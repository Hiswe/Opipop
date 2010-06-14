<?php

    header('Content-Type: application/json; charset=utf-8');
    header("Cache-Control: no-cache");

    set_time_limit(20);
    ini_set("memory_limit",'16M');

    $rs = DB::select('
        SELECT `id`, CONCAT(`question`, " - [", `response1`, " / ", `response2`, "]") AS `label`
        FROM `submition`
        ORDER BY `id` DESC
    ');

    echo json_encode($rs['data']);

