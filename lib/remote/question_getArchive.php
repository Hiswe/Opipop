<?php

$archive = new Block_Question_Archive($tpl);
$archive->setPage($_POST['page']);
$archive->setIsAjax(true);
$archive->configure();

$tpl->assignTemplate('lib/view/question_archive_list.tpl');
$tpl->display();

