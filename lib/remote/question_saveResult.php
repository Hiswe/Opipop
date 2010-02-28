<?php

    if (!Tool::isOk($_SESSION['user']))
    {
        exit();
    }

    $question = new Model_Question($_POST['question_id']);

    if ($question->getEndDate() < time())
    {
        exit();
    }

    $user = new Model_User($_SESSION['user']['id']);

    foreach ($_POST['data'] as $type => $value)
    {
        if ($type == 'vote')
        {
            $answer = $user->getAnswer($question);

            if ($answer == false && $value != 0)
            {
                $user->vote($question->getId(), $value);
            }
        }
        else if ($type == 'guess')
        {
            $guess = $user->getGuess($question);

            if ($guess == false && $value != 0)
            {
                $user->guess($question->getId(), $value);
            }
        }
    }

    exit();

    // Dress friends id list
    $friendIds = array();
    foreach($_POST['friend'] as $friend_id => $data)
    {
        $friendIds[] = $friend_id;
    }

    // Look if there is prognostics for thoses friend from this user to this question
    $rs = DB::select('
        SELECT `friend_id` FROM `user_guess_friend`
        WHERE `question_id`="' . $_POST['question_id'] . '"
        AND `user_id`="' . $user_id .'"
        AND `friend_id` IN (' . implode(',', $friendIds) . ')
    ');

    // Establish the list of already guessed friends
    $freindRegistered = array();
    foreach ($rs as $item)
    {
        $freindRegistered[] = $item['friend_id'];
    }

    foreach($_POST['friend'] as $friend_id => $data)
    {
        foreach ($data as $type => $value)
        {
            switch ($type)
            {
                case 'guess':
                    $table = 'user_guess_friend';
                    $answer_id = $value;
                    break;
                default:
                    continue;
            }

            // If user did not already guess for this friend
            if (!in_array($friend_id, $freindRegistered))
            {
                // Remember his guess
                DB::insert('INSERT INTO `' . $table . '` (`question_id`, `answer_id`, `user_id`, `friend_id`, `date`) VALUES
                (
                    "' . $_POST['question_id'] . '",
                    "' . $answer_id . '",
                    "' . $user_id . '",
                    "' . $friend_id . '",
                    "' . time() . '"
                )');
            }
        }
    }

