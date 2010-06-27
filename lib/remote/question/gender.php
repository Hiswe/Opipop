<?php

$gender = new Block_Question_Gender($tpl);
$gender->setQuestion(new Model_Question($_GET['questionId']));
$gender->setIsAjax(true);
$gender->configure();

echo $gender->render();

