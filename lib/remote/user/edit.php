<?php

$edit = new Block_User_Edit($tpl);
$edit->setUser(new Model_User($_GET['userId']));
$edit->setIsAjax(true);
$edit->configure();

echo $edit->render();

