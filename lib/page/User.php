<?php

class Page_User extends Page
{
    public function configureView()
    {
        $this->tpl->assignTemplate('lib/view/header.tpl');
        $this->tpl->assignTemplate('lib/view/top.tpl');
        $this->tpl->assignTemplate('lib/view/user/header.tpl');
        $this->tpl->assignTemplate('lib/view/user/menu.tpl');
        $this->tpl->assignTemplate('lib/view/user.tpl');
        $this->tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top($this->tpl);
        $top->configure();

        $profile = new Model_User($_GET['login']);

        $this->tpl->assignVar(array
        (
            'profile_id'     => $profile->getId(),
            'profile_login'  => $profile->getLogin(),
            'profile_avatar' => $profile->getAvatarUri('large'),
        ));

        // If a user is logged
        if (Tool::isOk($_SESSION['user']))
        {
            $user = new Model_User($_SESSION['user']['id']);

            // If I'm on my profile
            if ($user->getId() == $profile->getId())
            {
                $this->tpl->assignSection('private');
                $this->tpl->assignSection('friendPendingRequest');

                // Get pending friend requests
                $pendingFriends = $profile->getPendingFriends();

                // Assign friends infos
                foreach ($pendingFriends as $friend)
                {
                    $this->tpl->assignLoopVar('request', array
                    (
                        'id'     => $friend->getId(),
                        'login'  => $friend->getLogin(),
                        'avatar' => $friend->getAvatarUri(),
                    ));
                }
            }
            else
            {
                $this->tpl->assignSection('friendRequest');

                // Look if I'm friend with this profile's user
                switch ($profile->getFriendStatus($user))
                {
                    case Model_User::FRIEND_STATUS_NONE :
                        $friendMessage = 'Add to friends';
                        $friendAction  = 'add';
                        break;
                    case Model_User::FRIEND_STATUS_PENDING :
                        $friendMessage = 'Cancel friend request';
                        $friendAction  = 'cancel';
                        break;
                    case Model_User::FRIEND_STATUS_VALIDED :
                        $friendMessage = 'Remove from friends';
                        $friendAction  = 'remove';
                        break;
                }
                $this->tpl->assignVar(array
                (
                    'friendRequest_message' => $friendMessage,
                    'friendRequest_action'  => $friendAction,
                ));
            }
        }

        $friends = $profile->getFriends();

        foreach ($friends as $friend)
        {
            $this->tpl->assignLoopVar('friend', array
            (
                'id'     => $friend->getId(),
                'login'  => $friend->getLogin(),
                'avatar' => $friend->getAvatarUri('small'),
            ));
        }

        $profileTotalVotes = $profile->getTotalVotes();

        $this->tpl->assignVar(array
        (
            'profile_totalVote'           => $profileTotalVotes,
            'profile_totalPredictionWon'  => 0,
            'profile_totalPredictionLost' => 0,
            'profile_predictionAccuracy'  => 0,
            'profile_global_distance'     => 0,
            'profile_firend_distance'     => 0,
        ));

        // If profile's user already voted
        if ($profileTotalVotes != 0)
        {
            $totalQuestions = Model_Question::getTotalQuestions();

            // Get stats on profil's user votes according to global votes
            $profileAGS = $profile->getAnswerGlobalStats();
            if ($profileAGS['votes'] != 0)
            {
                $this->tpl->assignVar(array
                (
                    'profile_global_distance' => round((($profileAGS['votes'] - $profileAGS['popularVotes']) / $profileAGS['votes']) * $totalQuestions),
                ));
            }

            // Get stats on profil's user votes according to his friends votes
            $profileAFS = $profile->getAnswerFriendStats();
            if ($profileAFS['votes'] != 0)
            {
                $this->tpl->assignVar(array
                (
                    'profile_friend_distance' => round((($profileAFS['votes'] - $profileAFS['popularVotes']) / $profileAFS['votes']) * $totalQuestions),
                ));
            }

            // Get stats on profil's user guesses according to global votes
            $profileGGS = $profile->getGuessGlobalStats();
            if ($profileGGS['guesses'] != 0)
            {
                $this->tpl->assignVar(array
                (
                    'profile_totalPredictionWon'  => $profileGGS['popularGuesses'],
                    'profile_totalPredictionLost' => $profileGGS['unpopularGuesses'],
                    'profile_predictionAccuracy'  => round(($profileGGS['popularGuesses'] / $profileGGS['guesses']) * 100),
                ));
            }

            // Get stats on profil's user gusses for each of his friends
            $profileGFS = $profile->getGuessFriendsStats();
            foreach ($profileGFS as $friend)
            {
                $this->tpl->assignLoopVar('friendPredictionAccuracy', array
                (
                    'id'      => $friend['user']->getId(),
                    'login'   => $friend['user']->getLogin(),
                    'percent' => round(($friend['guesses'] == 0) ? 0 : ($friend['popularGuesses'] / $friend['guesses']) * 100),
                ));
            }

            // Compute user's feelings
            $profileFeelings = $profile->getFeelings();
            $maxFeelingScore = 0;
            foreach ($profileFeelings as $total)
            {
                $maxFeelingScore = ($maxFeelingScore < $total) ? $total : $maxFeelingScore;
            }
            $feelings = array('personality', 'surroundings', 'knowledge', 'experience', 'thoughts');
            $values   = array();
            foreach ($feelings as $id => $label)
            {
                $this->tpl->assignLoopVar('feeling', array
                (
                    'label'   => $label,
                    'percent' => round(($maxFeelingScore == 0) ? 0 : ($profileFeelings[$id + 1] / $maxFeelingScore) * 100),
                ));
                $values[] = number_format(($profileFeelings[$id + 1] / $maxFeelingScore) * 5 + 1, 2);
            }

            include 'inc/pChart.1.27d/pChart/pData.class';
            include 'inc/pChart.1.27d/pChart/pChart.class';
            include 'inc/pChart.1.27d/pChart/pCache.class';

            error_reporting(0);

            // Dataset definition
            $DataSet = new pData;
            $DataSet->AddPoint($feelings, 'Label');
            $DataSet->AddPoint($values, 'Serie1');
            $DataSet->AddSerie('Serie1');
            $DataSet->SetAbsciseLabelSerie('Label');
            $DataSet->SetSerieName('Personality', 'Serie1');

            // Init cahce
            $Cache = new pCache(ROOT_DIR . 'media/chart/');
            if (!$Cache->isInCache('personality', $DataSet->GetData()))
            {
                // Initialise the graph
                $Chart = new pChart(400, 400);
                $Chart->setFontProperties('inc/pChart.1.27d/Fonts/tahoma.ttf',10);
                $Chart->setGraphArea(50, 50, 350, 350);
                $Chart->setColorPalette(0, 120, 120, 230);

                // Draw the radar graph
                $Chart->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
                $Chart->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);

                // Cache the graph
                $Cache->WriteToCache('personality', $DataSet->GetData(), $Chart);
            }
            $this->tpl->assignVar('personality_chart', $Cache->GetFromCache('personality', $DataSet->GetData(), true));

            error_reporting(E_ALL);
        }
    }
}

