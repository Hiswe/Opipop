<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

	$db->update('UPDATE `question`
		SET `label` = "' . $_POST['label'] . '"
		WHERE `id` = "' . $_POST['id'] . '"');

	$db->delete('DELETE FROM `question_answer_feeling` WHERE `question_id`="' . $_POST['id'] . '"');

	foreach ($_POST['answer'] as $key => $answer)
	{
		$rs_answer = $db->select('
			SELECT `id`
			FROM `answer`
			WHERE `label`="' . $answer . '"
		');

		if ($rs_answer['total'] == 0)
		{
			$answer_id = $db->insert('INSERT INTO `answer` (`label`) VALUES ("' . $answer . '")');
		}
		else
		{
			$answer_id =  $rs_answer['data'][0]['id'];
		}

		$db->insert('INSERT INTO `question_answer_feeling` (`question_id`, `answer_id`, `feeling_id`) VALUES
		(
			"' . $_POST['id'] . '",
			"' . $answer_id . '",
			"' . $_POST['feeling'][$key] . '"
		)');
	}

