<?php

    include 'inc/conf.default.php';
    include 'inc/conf.local.php';

	foreach($conf as $key => $value)
	{
		DEFINE($key, $value);
	}

	ini_set('session.use_trans_sid', '0');	// remove PHPSSID
	ini_set('url_rewriter.tags', ''); 		// remove PHPSSID

    session_start();

    date_default_timezone_set('Europe/Paris');

