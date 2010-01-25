<?php

// If some user are connected
if (isOk($_SESSION['user']))
{
    // List them
    foreach($_SESSION['user'] as $id => $data)
    {
        $tpl->assignLoopVar('userLogged', array
        (
            'login' => $data['login'],
            'guid'  => makeGuid($data['login']),
            'id'    => $id,
        ));
    }
}

$rs_category = $db->select('SELECT `id`, `label` FROM `category` WHERE `status`="1" ORDER BY `position` ASC');

foreach ($rs_category['data'] as $category)
{
	$tpl->assignLoopVar('category', array
	(
		'id' => $category['id'],
		'label' => $category['label'],
		'guid' => makeGuid($category['label']),
	));
}

