<?php

    if (!Tool::isOk($_SESSION['user']))
    {
        $_SESSION['warning'] = 'You need to be logged to vote';
        echo 'register';
        exit();
    }

    $question = new Model_Question($_POST['question_id']);
    if ($question->getEndDate() < time())
    {
        exit();
    }

    $user = new Model_User($_SESSION['user']['id']);

    $guess = $user->getGuess($question);
    if ($guess == false && Tool::isOk($_POST['answer_id']))
    {
        $user->guess($question->getId(), $_POST['answer_id']);
    }

    $guess = new Block_Question_Active_Wait();
    $guess->setQuestion($question);
    $guess->configure();

    echo $guess->render();

