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

	$tpl->assignVar('user_id', $userId);

	if (is_array($_SESSION['user']) && isset($_SESSION['user'][$userId]))
	{
		$tpl->assignSection('private');
	}

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

		// Compute user's feelings
		$rs_user_feeling = $db->select('
			SELECT f.id, COUNT(f.id) AS total
			FROM `user_result` AS `r`
			JOIN `question_answer_feeling` AS `j` ON j.question_id=r.question_id AND j.answer_id=r.answer_id
			JOIN `feeling` AS `f` ON f.id=j.feeling_id
			WHERE r.user_id="' . $userId . '" AND f.id!="1"
			GROUP BY f.id
		');

		// Init values
		$feelings = array('personality', 'surroundings', 'knowledge', 'experience', 'thoughts');
		$user_feelings = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0);

		// Count user feelings
		$totalPoint = 0;
		$max = 0;
		$values = array();
		foreach ($rs_user_feeling['data'] as $item)
		{
			$user_feelings[$item['id']] = $item['total'];
			$max = ($max < $item['total']) ? $item['total'] : $max;
			$totalPoint ++;
		}
		foreach ($feelings as $id => $label)
		{
			$tpl->assignLoopVar('feeling', array
			(
				'label'   => $label,
				'percent' => round(($user_feelings[$id + 1] / $max) * 100),
			));
			$values[] = number_format(($user_feelings[$id + 1] / $max) * 5 + 1, 2);
		}

		include 'inc/pChart.1.27d/pChart/pData.class';
		include 'inc/pChart.1.27d/pChart/pChart.class';
		include 'inc/pChart.1.27d/pChart/pCache.class';

		error_reporting(0);

		// Dataset definition
		$DataSet = new pData;
		$DataSet->AddPoint($feelings, 'Label');
		$DataSet->AddPoint($values, 'Serie1');
		$DataSet->AddSerie('Serie1');
		$DataSet->SetAbsciseLabelSerie('Label');
		$DataSet->SetSerieName('Personality', 'Serie1');

		// Init cahce
		$Cache = new pCache(ROOT_DIR . 'media/chart/');
		if (!$Cache->isInCache('personality', $DataSet->GetData()))
		{
			// Initialise the graph
			$Chart = new pChart(400, 400);
			$Chart->setFontProperties('inc/pChart.1.27d/Fonts/tahoma.ttf',10);
			$Chart->setGraphArea(50, 50, 350, 350);
			$Chart->setColorPalette(0, 120, 120, 230);

			// Draw the radar graph
			$Chart->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
			$Chart->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);

			// Cache the graph
			$Cache->WriteToCache('personality', $DataSet->GetData(), $Chart);
		}
		$tpl->assignVar('personality_chart', $Cache->GetFromCache('personality', $DataSet->GetData(), true));

		error_reporting(E_ALL);
	}
	else
	{
		$tpl->assignVar(array
		(
			'user_totalVote'           => 0,
			'user_totalPredictionWon'  => 0,
			'user_totalPredictionLost' => 0,
			'user_predictionAccuracy'  => 0,
			'user_distance'            => 0,
		));
	}
}
else
{
	// TODO : error, user does not exists
}

