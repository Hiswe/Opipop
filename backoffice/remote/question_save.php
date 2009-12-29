<?php

	require_once '../../inc/conf.default.php';
	require_once '../../inc/conf.local.php';
    require_once '../../inc/setup.php';

	$db->update('UPDATE `question`
		SET `label` = "' . $_POST['label'] . '"
		WHERE `id` = "' . $_POST['id'] . '"');

	$db->delete('DELETE FROM `question_answer` WHERE `question_id`="' . $_POST['id'] . '"');

	$db->insert('INSERT INTO `question_answer` (`question_id`, `answer_id`) VALUES
	(
		"' . $_POST['answer1'] . '",
		"' . $_POST['answer2'] . '"
	)');

