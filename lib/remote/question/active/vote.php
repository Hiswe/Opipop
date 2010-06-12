<?php

    header("Cache-Control: no-cache");

    if (!($user = Model_User::getLoggedUser()))
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

    $answer = $user->getAnswer($question);
    if ($answer == false && Tool::isOk($_POST['answer_id']))
    {
		$user->vote($question->getId(), $_POST['answer_id']);
    }

    $block = new Block_Question_Active_Guess();
    $block->setQuestion($question);
    $block->configure();

    echo json_encode(array(
		'questionId' => $_POST['question_id'],
		'content'    => $block->render(),
	));


