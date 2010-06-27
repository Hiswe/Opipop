<?php

$map = new Block_Question_Map($tpl);
$map->setIsAjax(true);
$map->configure();

echo $map->render();

