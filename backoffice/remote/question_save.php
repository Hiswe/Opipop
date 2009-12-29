<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

	$db->update('UPDATE `question`
		SET `label` = "' . $_POST['label'] . '"
		WHERE `id` = "' . $_POST['id'] . '"');

	$db->delete('DELETE FROM `question_answer` WHERE `question_id`="' . $_POST['id'] . '"');

	if ($_POST['answer1'] != 0)
	{
		$db->insert('INSERT INTO `question_answer` (`question_id`, `answer_id`) VALUES
		(
			"' . $_POST['id'] . '",
			"' . $_POST['answer1'] . '"
		)');
	}

	if ($_POST['answer2'] != 0)
	{
		$db->insert('INSERT INTO `question_answer` (`question_id`, `answer_id`) VALUES
		(
			"' . $_POST['id'] . '",
			"' . $_POST['answer2'] . '"
		)');
	}

