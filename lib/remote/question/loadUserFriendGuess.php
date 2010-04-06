<?php

    if (!Tool::isOk($_SESSION['user']))
    {
        $_SESSION['warning'] = 'You need to be logged to vote and have friendes';
        echo 'register';
        exit();
    }

    $question = new Model_Question($_POST['question_id']);
    if ($question->getEndDate() < time())
    {
        exit();
    }

    $user = new Model_User($_SESSION['user']['id']);

    $guesses = $user->getGuessesAboutFriends($question);

    // Select all user's friends
    $friends = $user->getFriends();
    $output = array();

    // Assign friends infos
    foreach ($friends as $friend)
    {
        $guessId = 0;
        foreach ($guesses as $guess)
        {
            if ($guess->getUser()->getId() == $friend->getId())
            {
                $guessId = $guess->getId();
                break;
            }
        }

        $output[] = array
        (
            'id'     => $friend->getId(),
            'login'  => $friend->getLogin(),
            'avatar' => $friend->getAvatarUri('small'),
            'guess'  => $guessId,
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($output);


