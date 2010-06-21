<?php

$register = new Block_Register($tpl);
$register->setIsAjax(true);
$register->configure();

echo $register->render();

