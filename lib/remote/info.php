<?php

$info = new Block_Info($tpl);
$info->setInfo($_GET['info']);
$info->setIsAjax(true);
$info->configure();

echo $info->render();

