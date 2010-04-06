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

    $answer = $user->getAnswer($question);
    if ($answer == false && Tool::isOk($_POST['answer_id']))
    {
        //$user->vote($question->getId(), $_POST['answer_id']);
    }

    $guess = new Block_Question_Active_Guess($tpl);
    $guess->setQuestion($question);
    $guess->configure();

    echo $guess->render();

