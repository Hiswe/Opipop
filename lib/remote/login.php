<?php

$login = new Block_Login($tpl);
$login->setIsAjax(true);
$login->configure();

echo $login->render();

