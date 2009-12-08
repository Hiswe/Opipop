<?php

if (isOk($_SESSION['user']))
{
	$tpl->assignSection('confirm_ok');
}
else if (isOk($_GET['u']) && isOk($_GET['k']))
{
	$result = $db->select('SELECT `key`, `valided` FROM `user` WHERE `id`="' . $_GET['u'] . '"');

	if ($result['total'] != 0 && $result['data'][0]['key'] == $_GET['k'])
	{
		if ($result['data'][0]['valided'] == 0)
		{
			$db->update('UPDATE `user` SET `valided`=1 WHERE `id`="' . $_GET['u'] . '"');
		}

		$_SESSION['user'] = $_GET['u'];

		$tpl->assignSection('confirm_ok');
	}
	else
	{
		$tpl->assignSection('confirm_error');
	}
}
else
{
	$tpl->assignSection('confirm_wait');
}

