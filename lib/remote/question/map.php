<?php

$map = new Block_Question_Map($tpl);
$map->setQuestion(new Model_Question($_GET['questionId']));
$map->setIsAjax(true);
$map->configure();

echo $map->render();

