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

    function __autoload($className)
    {
        include 'com/' . str_replace('_', '/', $className) . '.php';
    }

    // REMOTES
    if (isset($_GET['remote']))
    {
        include 'com/remote/' . $_GET['remote'] . '.php';
        exit();
    }

    // PAGES
    if (isset($_GET['page']))
    {
        $tpl = new Template();
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
                $page = new Page_Homepage($tpl);
                break;

            case 'login':
                $page = new Page_Login($tpl);
                break;

            case 'logout':
                $page = new Page_Logout($tpl);
                break;

            case 'question':
                $page = new Page_Question($tpl);
                break;

            case 'question_list':
                $page = new Page_Question_List($tpl);
                break;

            case 'user':
                $page = new Page_User($tpl);
                break;

            case 'user_edit':
                $page = new Page_User_Edit($tpl);
                break;

            case 'user_list':
                $page = new Page_User_List($tpl);
                break;

            default :
                $page = new Page($tpl);
        }
        $page->configureData();
        $page->configureView();

        $tpl->display();
    }

