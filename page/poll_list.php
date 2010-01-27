<?php

include 'page/block/top.php';

if (!isOk($_GET['p']))
{
	$_GET['p'] = 0;
}

if (isOk($_GET['archive']))
{
	// Select all previous question accoring to this page'n number
	$rs_question = $db->select
	('
		SELECT q.id, q.date, q.label
		FROM `question` AS `q`
		JOIN `category` AS `c` ON c.id=q.category_id
		WHERE q.date < ' . (time() - POLL_DURATION - 3600) . '
		AND c.guid="' . $_GET['guid'] . '"
        AND q.status=1
        AND c.status=1
		ORDER BY q.date DESC
	', (($_GET['p'] > 0) ? $_GET['p'] - 1 : $_GET['p']) * POLL_PER_PAGE, POLL_PER_PAGE);
}
else
{
	// Select all current questions
	$rs_question = $db->select
	('
		SELECT q.id, q.date, q.label
		FROM `question` AS `q`
		JOIN `category` AS `c` ON c.id=q.category_id
		WHERE q.date > ' . (time() - POLL_DURATION) . '
		AND c.guid="' . $_GET['guid'] . '"
        AND q.status=1
        AND c.status=1
		ORDER BY q.date DESC
	');
}

// If there is some
if ($rs_question['total'] != 0)
{
    // List all questions ids
    $idList = array();
    foreach ($rs_question['data'] as $item)
    {
        $idList[] = $item['id'];
    }

    // Select all possible answer related to those questions
    $rs_answer = $db->select
    ('
        SELECT a.id, a.label, j.question_id
        FROM `answer` AS a
        JOIN `question_answer_feeling` AS j ON j.answer_id = a.id
        WHERE j.question_id IN (' . implode(',', $idList) . ')
    ');

    // Loop through all questions
    foreach ($rs_question['data'] as $question)
    {
        // Assign question infos
        $tpl->assignLoopVar('question', array
        (
            'date'  => date('d-m-Y', $question['date']),
			'time'  => isOk($_GET['archive']) ? 'ended ' . timeWarp(date($question['date'] + POLL_DURATION)) : 'ends ' . timeWarp($question['date'] + POLL_DURATION),
            'label' => $question['label'],
            'guid'  => makeGuid($question['label']),
            'id'    => $question['id'],
        ));

        // Assign answers infos
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

	if (isOk($_GET['archive']))
	{
		// Dress the pagination
		$totalPage = ceil($rs_question['total'] / POLL_PER_PAGE);
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
				'link'   => 'category/' . $_GET['guid'] . '/archives/' . (($p == 0) ? '' : $p + 1),
				'class'  => ($p == $_GET['p']) ? 'on' : 'off'
			));
		}
		if ($totalPage > 1)
		{
			if ($_GET['p'] > 0)
			{
				$tpl->assignSection('pagination_prev');
			}
			if ($_GET['p'] < $totalPage - 1)
			{
				$tpl->assignSection('pagination_next');
			}
			$tpl->assignSection('pagination');
			$tpl->assignVar(array
			(
				'pagination_next' => 'category/' . $_GET['guid'] . '/archives/' . ($_GET['p'] + 2),
				'pagination_prev' => 'category/' . $_GET['guid'] . '/archives' . (($_GET['p'] == 1) ? '' : '/' . $_GET['p'])
			));
		}
	}
}
else
{
    // Error !
}

