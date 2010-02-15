<?php

	DB::update('UPDATE `question`
		SET
			`label` = "' . $_POST['label'] . '",
			`didyouknow` = "' . $_POST['didyouknow'] . '"
		WHERE `id` = "' . $_POST['id'] . '"');

	DB::delete('
		DELETE FROM `question_answer_feeling`
		WHERE `question_id`="' . $_POST['id'] . '"
	');

	foreach ($_POST['answer'] as $key => $answer)
	{
		$rs_answer = DB::select('
			SELECT `id`
			FROM `answer`
			WHERE `label`="' . $answer . '"
		');

		if ($rs_answer['total'] == 0)
		{
			$answer_id = DB::insert('INSERT INTO `answer` (`label`) VALUES
			(
				"' . $answer . '"
			)');
		}
		else
		{
			$answer_id =  $rs_answer['data'][0]['id'];
		}

		DB::insert('INSERT INTO `question_answer_feeling` (`question_id`, `answer_id`, `feeling_id`) VALUES
		(
			"' . $_POST['id'] . '",
			"' . $answer_id . '",
			"' . $_POST['feeling'][$key] . '"
		)');
	}

