<?php

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    set_time_limit(20);
    ini_set("memory_limit",'16M');

    $rs_question = DB::select('
        SELECT `id`, `category_id`, `date`, `label`, `didyouknow`
        FROM `question`
        WHERE `id`="' . $_POST['id'] . '"
    ');
    $data = $rs_question['data'][0];

    $rs_answer = DB::select('
        SELECT a.label AS `answer`, f.id `feeling`
        FROM `question_answer_feeling` AS `q`
        JOIN `answer`  AS `a` ON a.id=q.answer_id
        JOIN `feeling` AS `f` ON f.id=q.feeling_id
        WHERE q.question_id="' . $_POST['id'] . '"
    ');
    $n = 1;
    foreach ($rs_answer['data'] as $item)
    {
        $data['answer' . $n] = $item['answer'];
        $data['feeling' . $n] = $item['feeling'];
        $n ++;
    }

    echo json_encode($data);

