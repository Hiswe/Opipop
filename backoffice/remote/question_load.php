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

	$rs_answer = $db->select('SELECT `answer_id` FROM `question_answer` WHERE `question_id`="' . $_POST['id'] . '"');
    $n = 1;
    foreach ($rs_answer['data'] as $item)
    {
        $data['answer' . $n] = $item['answer_id'];
        $n ++;
    }

	$rs_answers = $db->select('SELECT `id`, `label` FROM `answer` ORDER BY `label` ASC');
    $data['answers'] = array();
    foreach ($rs_answers['data'] as $item)
    {
        $data['answers'][] = array(
            'value' => $item['id'],
            'label' => $item['label'],
        );
    }

	echo json_encode($data);

