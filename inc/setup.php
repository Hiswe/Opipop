<?php

	foreach($conf as $key => $value)
	{
		DEFINE($key, $value);
	}

	if (isset($_POST['q']))
	{
		header('Location: ' . ROOT_PATH . 'search/' . urlencode(preg_replace ('#[./]#isU', ' ', $_POST['q'])));
	}

	$start_time = microtime();
	$sql_time = 0;

	ini_set('session.use_trans_sid', '0');	// remove PHPSSID
	ini_set('url_rewriter.tags', ''); 		// remove PHPSSID

	require ROOT_DIR.'inc/function.php';
	include ROOT_DIR.'inc/class/templateEngine.php';
	include ROOT_DIR.'inc/class/mysqlDatabase.php';

    session_start();

	$page = (isOk($_GET['page'])) ? $_GET['page'] : 'homepage';

	$db = new mysqlDatabase();

	$tpl = new templateEngine();

	$tpl->cacheTimeCoef = CACHE_TIMECOEF;

	$tpl->assignVar (array(
		'PAGE_TITLE' => PAGE_TITLE,
		'PAGE_DESCRIPTION' => PAGE_DESCRIPTION,
		'PAGE_KEYWORDS' => PAGE_KEYWORDS,
		'ROOT_PATH' => ROOT_PATH,
		'VERSION' => VERSION
	));

