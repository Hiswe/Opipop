<?php

    if (!Tool::isOk($_SESSION['user']))
    {
        $_SESSION['warning'] = 'You need to be logged to participate';
        echo 'register';
        exit();
    }

    $question = new Model_Question($_POST['question_id']);
    if ($question->getEndDate() < time())
    {
        exit();
    }

    $user    = new Model_User($_SESSION['user']['id']);
    $guesses = $user->getGuessesAboutFriends($question);

    if (isset($_POST['guess']))
    {
        foreach($_POST['guess'] as $friendId => $answerId)
        {
            // If user did not already guess for this friend
            foreach ($guesses as $guess)
            {
                if ($guess->getUser()->getId() == $friendId)
                {
                    break;
                    continue;
                }
            }
            $user->guessAboutFriend($_POST['question_id'], $friendId, $answerId);
        }
    }

    $block = new Block_Question_Active_Friends();
    $block->setQuestion($question);
    $block->configure();

    echo $block->render();


