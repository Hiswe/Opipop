<?php

    // CONF
    include 'conf/default.php';
    include 'conf/local.php';
    include 'lib/Conf.php';
    Conf::register($conf);

    // PHP
    ini_set('session.use_trans_sid', '0');    // remove PHPSSID
    ini_set('url_rewriter.tags', '');         // remove PHPSSID
    date_default_timezone_set('Europe/Paris');
    session_start();

    // AUTOLOADER
    function __autoload($className)
    {
        include Conf::get('ROOT_DIR') . 'lib/' . str_replace('_', '/', $className) . '.php';
    }

    // TEMPLATE ENGINE
    $tpl = new Template();
    $tpl->cacheTimeCoef = Conf::get('CACHE_TIMECOEF');
    $tpl->assignVar (array(
        'PAGE_TITLE'       => Conf::get('PAGE_TITLE'),
        'PAGE_DESCRIPTION' => Conf::get('PAGE_DESCRIPTION'),
        'PAGE_KEYWORDS'    => Conf::get('PAGE_KEYWORDS'),
        'ROOT_PATH'        => Conf::get('ROOT_PATH'),
        'VERSION'          => Conf::get('VERSION')
    ));

    // DECTECT IF AJAX
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        $ajax = true;
        $tpl->assignSection('AJAX');
    }
    else
    {
        $ajax = false;
        $tpl->assignSection('NOT_AJAX');
    }

    // REMOTES
    if (isset($_GET['remote']))
    {
        if ($ajax)
        {
            include 'lib/remote/' . $_GET['remote'] . '.php';
            exit();
        }
        else
        {
            $page = new Page($tpl);
            $tpl->assignTemplate('lib/view/header.tpl');
            $tpl->assignTemplate('lib/view/top.tpl');
            $tpl->display();
            $tpl->clearLayout();
            echo '<div id="remote">';
            include 'lib/remote/' . $_GET['remote'] . '.php';
            echo '</div>';
            $tpl->clearLayout();
            $tpl->assignTemplate('lib/view/footer.tpl');
            $tpl->display();
            exit();
        }
    }

    // PAGES
    if (isset($_GET['page']))
    {
        switch ($_GET['page'])
        {
            case 'homepage':
                $page = new Page_Homepage($tpl);
                break;

            case 'register':
                $page = new Page_Register($tpl);
                break;

            case 'logout':
                $page = new Page_Logout($tpl);
                break;

            case 'question':
                $page = new Page_Question($tpl);
                break;

            case 'user':
                $page = new Page_User($tpl);
                break;

            case 'user_edit':
                $page = new Page_User_Edit($tpl);
                break;

            case 'user_confirm':
                $page = new Page_User_Confirm($tpl);
                break;

            case 'submit':
                $page = new Page_Submit($tpl);
                break;

            default :
                $page = new Page($tpl);
        }
        $page->configureData();
        $page->configureView();

        $tpl->display();
    }

