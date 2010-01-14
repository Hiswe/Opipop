<?php

	require_once '../inc/conf.default.php';
	require_once '../inc/conf.local.php';
    require_once '../inc/setup.php';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <title>Backoffice</title>

    <script language="javascript" type="text/javascript">var ROOT_PATH = '<?php echo ROOT_PATH; ?>';</script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>js/lib/prototype.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/main.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/class.List.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/class.Item.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/class.Category.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/class.Question.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/static.Form.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo ROOT_PATH; ?>backoffice/js/static.Job.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_PATH; ?>backoffice/css/main.css">
</head>
<body>

    <div id="working"></div>
    <div id="list_1" class="list"></div>
    <div id="list_2" class="list"></div>
    <div id="form"></div>

</body>
</html>

