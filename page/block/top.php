<?php

// If a user is connected
if (isOk($_SESSION['user']))
{
    // List them
    $tpl->assignLoopVar('userLogged', array
    (
        'login' => $_SESSION['user']['login'],
        'id'    => $_SESSION['user']['id'],
    ));
}
else
{
	$tpl->assignSection('login');
}

$rs_category = $db->select('SELECT `id`, `label`, `guid` FROM `category` WHERE `status`="1" ORDER BY `position` ASC');

foreach ($rs_category['data'] as $category)
{
	$tpl->assignLoopVar('category', array
	(
		'id' => $category['id'],
		'label' => $category['label'],
		'guid' => $category['guid'],
	));
}

// If a feedback should be displayed
if (isOk($_SESSION['feedback']))
{
    $tpl->assignSection('feedback');
    $tpl->assignVar('feedback', $_SESSION['feedback']);
    unset($_SESSION['feedback']);
}

