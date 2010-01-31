<?php

include 'page/block/top.php';

// If some user are connected
if (isOk($_SESSION['user']))
{
	$tpl->assignSection('noLogin');
}
else
{
	$tpl->assignSection('login');
}

