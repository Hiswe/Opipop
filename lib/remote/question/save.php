<?php

    header("Cache-Control: no-cache");

    if (!($user = Model_User::getLoggedUser()))
    {
        $_SESSION['warning'] = 'You need to be logged to vote';
        echo 'register';
        exit();
    }

    if (Tool::isOk($_POST['question']))
    {
        $question = new Model_Question($_POST['question']);

        if (isset($_POST['answer']))
        {
            if ($_POST['answer'] == 0)
            {
                if (Tool::isOk($_POST['vote']) && $_POST['vote'] == $user->getId())
                {
                    // vote
                    $user->removeVote($question);
                }
                else if (Tool::isOk($_POST['guess']) && $_POST['guess'] == $user->getId())
                {
                    // guess
                    $user->removeGuess($question);
                }
                else if (Tool::isOk($_POST['user']) && Tool::isOk($_POST['friend']) && $_POST['user'] == $user->getId())
                {
                    // guess for friend
                    $user->removeGuessAboutFriend($question, $friend);
                }
            }
            else
            {
                $answer = new Model_Answer($_POST['answer']);

                if (Tool::isOk($_POST['vote']) && $_POST['vote'] == $user->getId())
                {
                    // vote
                    $userAnswer = $user->getAnswer($question);
                    if (!$userAnswer)
                    {
                        $user->vote($question, $answer);
                    }
                    else if ($userAnswer->getId() != $answer->getId())
                    {
                        $user->updateVote($question, $answer);
                    }
                }
                else if (Tool::isOk($_POST['guess']) && $_POST['guess'] == $user->getId())
                {
                    // guess
                    $userGuess = $user->getGuess($question);
                    if (!$userGuess)
                    {
                        $user->guess($question, $answer);
                    }
                    else if ($userGuess->getAnswer()->getId() != $answer->getId())
                    {
                        $user->updateGuess($question, $answer);
                    }
                }
                else if (Tool::isOk($_POST['user']) && Tool::isOk($_POST['friend']) && $_POST['user'] == $user->getId())
                {
                    // guess for friend
                    $friend     = new Model_User($_POST['friend']);
                    $userGuesse = $user->getGuessAboutFriend($question);
                    if (!$userGuess)
                    {
                        $user->guessAboutFriend($question, $friend, $answer);
                    }
                    else if ($userGuess->getAnswer()->getId() != $answer->getId())
                    {
                        $user->updateGuessAboutFriend($question, $friend, $answer);
                    }
                }
            }
        }
    }


