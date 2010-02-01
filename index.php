<?php

    // CONF
    include 'inc/conf.default.php';
    include 'inc/conf.local.php';
	foreach($conf as $key => $value)
	{
		DEFINE($key, $value);
	}

    // PHP
	ini_set('session.use_trans_sid', '0');	// remove PHPSSID
	ini_set('url_rewriter.tags', ''); 		// remove PHPSSID
    date_default_timezone_set('Europe/Paris');
    session_start();

    // REMOTES
    if (isset($_GET['remote']))
    {
        include 'com/DB.php';
        include 'com/Tool.php';
        include 'com/remote/' . $_GET['remote'] . '.php';
        exit();
    }

    // PAGES
    if (isset($_GET['page']))
    {
        include 'com/DB.php';
        include 'com/Tool.php';
        include 'com/Page.php';
        include 'com/Block.php';
        include 'com/Template.php';

        $tpl = new templateEngine();
        $tpl->cacheTimeCoef = CACHE_TIMECOEF;
        $tpl->assignVar (array(
            'PAGE_TITLE'       => PAGE_TITLE,
            'PAGE_DESCRIPTION' => PAGE_DESCRIPTION,
            'PAGE_KEYWORDS'    => PAGE_KEYWORDS,
            'ROOT_PATH'        => ROOT_PATH,
            'VERSION'          => VERSION
        ));

        switch ($_GET['page'])
        {
            case 'homepage':
                include 'com/page/Homepage.php';
                $page = new Page_Homepage($tpl);
                break;

            case 'login':
                include 'com/page/Login.php';
                $page = new Page_Login($tpl);
                break;

            case 'logout':
                include 'com/page/Logout.php';
                $page = new Page_Logout($tpl);
                break;

            default :
                $page = new Page($tpl);
        }
        $page->configureData();
        $page->configureView();

        $tpl->display();
    }

