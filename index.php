<?php

    include 'inc/setup.php';

	include 'com/Page.php';
	include 'com/Block.php';
	include 'com/Template.php';
	include 'com/DB.php';
	include 'com/util/Tool.php';

    // DEBUG INFOS
	$start_time = microtime();
	$sql_time = 0;

	$tpl = new templateEngine();
	$tpl->cacheTimeCoef = CACHE_TIMECOEF;
	$tpl->assignVar (array(
		'PAGE_TITLE'       => PAGE_TITLE,
		'PAGE_DESCRIPTION' => PAGE_DESCRIPTION,
		'PAGE_KEYWORDS'    => PAGE_KEYWORDS,
		'ROOT_PATH'        => ROOT_PATH,
		'VERSION'          => VERSION
	));

	$page = (isOk($_GET['page'])) ? $_GET['page'] : 'homepage';
    switch ($page)
    {
        case 'homepage':
            require_once 'com/page/Homepage.php';
            $page = new Page_Homepage($tpl);
            break;

        default :
            $page = new Page($tpl);
    }
    $page->configureData();
    $page->configureView();

    $tpl->display();

    // DEBUG INFOS
    echo '<br/><hr/>';
    echo 'SQL : ' . number_format(DB::getTotalQueryTime(), 3, ',', ' ') . ' sec | ';
    echo 'PHP : ' . number_format(microtime() - $start_time - DB::getTotalQueryTime(), 3, ',', ' ') . ' sec | ';
    echo 'TOTAL : ' . number_format (microtime() - $start_time, 3, ',', ' ') . ' sec';

