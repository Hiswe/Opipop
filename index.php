<?php

	require_once 'inc/conf.default.php';
	require_once 'inc/conf.local.php';
    require_once 'inc/setup.php';

    require_once 'page/' . $page . '.php';

	$tpl->assignTemplate ('template/block/header.tpl');
	$tpl->assignTemplate ('template/'.$page.'.tpl');
	$tpl->assignTemplate ('template/block/footer.tpl');

	$tpl->display ();

echo 'SQL : ' . number_format($sql_time, 3, ',', ' ') . ' sec | ';
echo 'PHP : ' . number_format(microtime() - $start_time - $sql_time, 3, ',', ' ') . ' sec | ';
echo 'TOTAL : ' . number_format (microtime() - $start_time, 3, ',', ' ') . ' sec';

