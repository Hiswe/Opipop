<?php

include 'page/block/top.php';

$rs_question = $db->select
('
    SELECT `id`, `date`, `label`
    FROM `question`
    WHERE `date` < ' . (time() - (86400 * 7)) . '
    ORDER BY `date` DESC
', (($_GET['p'] > 0) ? $_GET['p'] - 1 : $_GET['p']) * POLLS_PER_PAGE, POLLS_PER_PAGE);

if ($rs_question['total'] != 0)
{
    $idList = array();
    foreach ($rs_question['data'] as $item)
    {
        $idList[] = $item['id'];
    }

    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer` AS j ON j.answer_id = a.id
        WHERE j.question_id IN (' . implode(',', $idList) . ')
    ', 0, 8);

    foreach ($rs_question['data'] as $question)
    {
        $tpl->assignLoopVar('question', array
        (
            'date'  => date('d-m-Y', $question['date']),
            'label' => $question['label'],
            'id'    => $question['id'],
        ));

        foreach ($rs_answer['data'] as $answer)
        {
            if ($answer['question_id'] == $question['id'])
            {
                $tpl->assignLoopVar('question.answer', array
                (
                    'label' => $answer['label'],
                ));
            }
        }
    }

    $totalPage = ceil($rs_question['total'] / POLLS_PER_PAGE);
    $n = 1;

    if ($_GET['p'] > 0)
    {
        $_GET['p'] --;
    }

    for ($p = 0; $p < $totalPage; $p ++)
    {
        if ($p > 2 && $p < $_GET['p'] - 4)
        {
            $p = $_GET['p'] - 4;
            $tpl->assignSection('pagination_space' . $n);
            $n ++;
        }
        if ($p < $totalPage - 3 && $p > $_GET['p'] + 4)
        {
            $p = $totalPage - 3;
            $tpl->assignSection('pagination_space' . $n);
            $n ++;
        }

        $tpl->assignLoopVar('pagination_' . $n, array
        (
            'n'      => $p + 1,
            'link'   => 'archives/' . (($p == 0) ? '' : $p + 1),
            'class'  => ($p == $_GET['p']) ? 'on' : 'off'
        ));
    }

    if ($totalPage > 1)
    {
        $tpl->assignSection('pagination');
        $tpl->assignVar(array
        (
            'pagination_next' => 'archives/' . ($_GET['p'] + 2),
            'pagination_prev' => 'archives/' . (($_GET['p'] == 1) ? '' : $_GET['p'])
        ));

        if ($_GET['p'] > 0)
        {
            $tpl->assignSection('pagination_prev');
        }
        if ($_GET['p'] < $totalPage - 1)
        {
            $tpl->assignSection('pagination_next');
        }
    }
}

