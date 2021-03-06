<?php

class Page_User extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/top.tpl');
        Globals::$tpl->assignTemplate('lib/view/user.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top();
        $top->configure();

        $profile = new Model_User($_GET['login']);

        Globals::$tpl->assignVar(array
        (
            'profile_id'     => $profile->getId(),
            'profile_login'  => $profile->getLogin(),
            'profile_sex'    => $profile->getGender(false),
            'profile_avatar' => $profile->getAvatarURL('large'),
            'profile_region' => $profile->getZipName(),
            'profile_gender' => $profile->getGender(),
        ));

        // Get stats on friends
        $profileFriendsStats = $profile->getGuessFriendsStats();

        // If a user is logged
        if ($user = Model_User::getLoggedUser())
        {
            // If I'm on my profile
            if ($user->getId() == $profile->getId())
            {
                Globals::$tpl->assignSection('private');

                // Get pending friend requests
                $pendingFriends = $user->getPendingFriends();

                // Assign friends infos
                foreach ($pendingFriends as $friend)
                {
                    Globals::$tpl->assignLoopVar('request', array
                    (
                        'id'     => $friend->getId(),
                        'login'  => $friend->getLogin(),
                        'avatar' => $friend->getAvatarURL('medium'),
                    ));
                }
            }
        }

        $profileTotalVotes = $profile->getTotalVotes();

        Globals::$tpl->assignVar(array
        (
            'profile_totalVote'           => $profileTotalVotes,
            'profile_totalPredictionWon'  => 0,
            'profile_totalPredictionLost' => 0,
            'profile_predictionAccuracy'  => 0,
            'profile_global_distance'     => 0,
            'profile_friend_distance'     => 0,
        ));

        // Get stats on profil's user guesses according to global votes
        $profileGGS = $profile->getGuessGlobalStats();
        if ($profileGGS['guesses'] != 0)
        {
            Globals::$tpl->assignVar(array
            (
                'profile_totalPredictionWon'  => $profileGGS['goodGuesses'],
                'profile_totalPredictionLost' => $profileGGS['badGuesses'],
                'profile_predictionAccuracy'  => round(($profileGGS['goodGuesses'] / $profileGGS['guesses']) * 100),
            ));
        }

        // List all friends
        $friends = $profile->getFriends();
        foreach ($friends as $friend)
        {
            Globals::$tpl->assignLoopVar('friend', array
            (
                'id'            => $friend->getId(),
                'login'         => $friend->getLogin(),
                'avatar_medium' => $friend->getAvatarURL('medium'),
                'avatar_small'  => $friend->getAvatarURL('small'),
            ));

            foreach ($profileFriendsStats as $stat)
            {
                // Get stats on profil's user gusses
                if ($friend->getId() == $stat['user']->getId())
                {
                    Globals::$tpl->assignLoopVar('friend.stat', array
                    (
                        'predictionAccuracy_his' => round(($stat['his_guesses'] == 0) ? 0 : ($stat['his_goodGuesses'] / $stat['his_guesses']) * 100),
                        'predictionAccuracy_my'  => round(($stat['my_guesses'] == 0) ? 0 : ($stat['my_goodGuesses'] / $stat['my_guesses']) * 100),
                    ));
                }
            }
        }

        // If profile's user already voted
        if ($profileTotalVotes != 0)
        {
            $totalQuestions = Model_Question::getTotalQuestions();

            // Get stats on profil's user votes according to global votes
            $profileAGS = $profile->getAnswerGlobalStats();
            if ($profileAGS['votes'] != 0)
            {
                Globals::$tpl->assignVar(array
                (
                    'profile_global_distance' => round((($profileAGS['votes'] - $profileAGS['goodVotes']) / $profileAGS['votes']) * $totalQuestions),
                ));
            }

            // Get stats on profil's user votes according to his friends votes
            $profileAFS = $profile->getAnswerFriendStats();
            if ($profileAFS['votes'] != 0)
            {
                Globals::$tpl->assignVar(array
                (
                    'profile_friend_distance' => round((($profileAFS['votes'] - $profileAFS['goodVotes']) / $profileAFS['votes']) * $totalQuestions),
                ));
            }
        }

        // Compute user's feelings
        $profileFeelings = $profile->getFeelings();
        $maxFeelingScore = 0;
        foreach ($profileFeelings as $total)
        {
            $maxFeelingScore = ($maxFeelingScore < $total) ? $total : $maxFeelingScore;
        }
        $feelings = array('Personalité', 'Environement', 'Savoir', 'Experience', 'Réflexion', 'Sensibilité');
        $colors   = Conf::get('GRAPH_COLORS');
        $data     = array();
        foreach ($feelings as $id => $label)
        {
            Globals::$tpl->assignLoopVar('feeling', array
            (
                'label'   => $label,
                'percent' => round(($maxFeelingScore == 0) ? 0 : ($profileFeelings[$id + 1] / $maxFeelingScore) * 100),
            ));
            $data[] = array
            (
                'value' => (($maxFeelingScore ? (1 - $profileFeelings[$id + 1] / $maxFeelingScore) : 0) * 0.95) + 0.05,
                'label' => $label,
                'color' => $colors[$id],
            );
        }
        Globals::$tpl->assignVar('feeling_data', json_encode($data));

        // No friends ?
        if (count($friends) == 0 && (!isset($pendingFriends) || count($pendingFriends) == 0))
        {
            Globals::$tpl->assignSection('noFriends');
        }
    }
}

