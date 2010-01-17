<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    set_time_limit(20);
    ini_set("memory_limit",'16M');

	$rs_question = $db->select('SELECT `id`, `category_id`, `date`, `label` FROM `question` WHERE `id`="' . $_POST['id'] . '"');
    $data = $rs_question['data'][0];

	$rs_answer = $db->select('
		SELECT a.label
		FROM `question_answer` AS `q`
		JOIN `answer` AS `a` ON a.id=q.answer_id
		WHERE q.question_id="' . $_POST['id'] . '"
	');
    $n = 1;
    foreach ($rs_answer['data'] as $item)
    {
        $data['answer' . $n] = $item['label'];
        $n ++;
    }

	echo json_encode($data);

