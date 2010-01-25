<?php

include 'page/block/top.php';

$tpl->assignVar('user_login', $_GET['login']);

// Retrieve user's id
$rs_user = $db->select('
	SELECT `id`
	FROM `user`
	WHERE `login`="' . $_GET['login'] . '"
');

if ($rs_user['total'] != 0)
{
	$userId = $rs_user['data'][0]['id'];

	// Count user's total votes
	$rs_result_total = $db->select('
		SELECT COUNT(user_id) AS `total`
		FROM `user_result`
		WHERE `user_id`="' . $userId . '"
		GROUP BY `user_id`
	');

	// If user already voted
	if ($rs_result_total['total'] != 0)
	{
		$user_totalVote = $rs_result_total['data'][0]['total'];
		$tpl->assignVar(array
		(
			'user_totalVote' => $rs_result_total['data'][0]['total'],
		));

		// Select all user's results for past questions
		$rs_user_result = $db->select('
			SELECT r.question_id AS `question_id`, r.answer_id AS `answer_id`
			FROM `user_result` AS `r`
			JOIN `question` AS `q` ON q.id=r.question_id
			WHERE r.user_id="' . $userId . '" AND q.date < ' . (time() - POLL_DURATION - 3600) . '
		');

		// Count results for each question's answers
		$rs_result = $db->select('
			SELECT `question_id`, `answer_id`, COUNT(answer_id) AS `total`
			FROM `user_result`
			GROUP BY `question_id`, `answer_id`
		');

		// Build a table containing question's id associated
		// with the most voted answer's id (0 if egality)
		$results = array();
		foreach ($rs_result['data'] as $item)
		{
			if (in_array($item['question_id'], $results))
			{
				if ($results[$item['question_id']]['total'] == $item['total'])
				{
					$results[$item['question_id']]['answer_id'] = 0;
				}
				else if ($results[$item['question_id']]['total'] < $item['total'])
				{
					continue;
				}
			}
			$results[$item['question_id']] = array
			(
				'answer_id' => $item['answer_id'],
				'total'     => $item['total'],
			);
		}
		$totalQuestion = count($results);

		// Count user's popular votes
		$totalPopularVote = 0;
		foreach ($rs_user_result['data'] as $item)
		{
			if ($results[$item['question_id']]['answer_id'] == 0 || $results[$item['question_id']]['answer_id'] == $item['answer_id'])
			{
				$totalPopularVote ++;
			}
		}
		$tpl->assignVar(array
		(
			'user_distance' => round((($user_totalVote - $totalPopularVote) / $user_totalVote) * $totalQuestion),
		));

		// Select all user's prognostics for past questions
		$rs_user_prognostic = $db->select('
			SELECT p.question_id AS `question_id`, p.answer_id AS `answer_id`
			FROM `user_prognostic` AS `p`
			JOIN `question` AS `q` ON q.id=p.question_id
			WHERE p.user_id="' . $userId . '" AND q.date < ' . (time() - POLL_DURATION - 3600) . '
		');

		// Count prognostic for each question's answers
		$rs_prognostic = $db->select('
			SELECT `question_id`, `answer_id`, COUNT(answer_id) AS `total`
			FROM `user_prognostic`
			GROUP BY `question_id`, `answer_id`
		');

		// Build a table containing question's id associated
		// with the most guessed answer's id (0 if egality)
		$prognostics = array();
		foreach ($rs_prognostic['data'] as $item)
		{
			if (in_array($item['question_id'], $prognostics))
			{
				if ($prognostics[$item['question_id']]['total'] == $item['total'])
				{
					$prognostics[$item['question_id']]['answer_id'] = 0;
				}
				else if ($prognostics[$item['question_id']]['total'] < $item['total'])
				{
					continue;
				}
			}
			$prognostics[$item['question_id']] = array
			(
				'answer_id' => $item['answer_id'],
				'total'     => $item['total'],
			);
		}

		// Count user's good and bad prognostics
		$totalPredictionLost = 0;
		$totalPredictionWon = 0;
		foreach ($rs_user_prognostic['data'] as $item)
		{
			if ($prognostics[$item['question_id']]['answer_id'] != 0 && $prognostics[$item['question_id']]['answer_id'] != $item['answer_id'])
			{
				$totalPredictionLost ++;
			}
			else
			{
				$totalPredictionWon ++;
			}
		}
		$tpl->assignVar(array
		(
			'user_totalPredictionWon' => $totalPredictionWon,
			'user_totalPredictionLost' => $totalPredictionLost,
			'user_predictionAccuracy' => round(($totalPredictionWon / $rs_user_prognostic['total']) * 100),
		));
	}
	else
	{
		$tpl->assignVar(array
		(
			'user_totalVote' => 0,
			'user_totalPredictionWon' => 0,
			'user_totalPredictionLost' => 0,
			'user_distance' => 0,
		));
	}
}
else
{
	// TODO : error, user does not exists
}

