<?php

$archive = new Block_Question_Archive($tpl);
$archive->setPage($_POST['page']);
$archive->setIsAjax(true);
$archive->configure();

echo $archive->render();

