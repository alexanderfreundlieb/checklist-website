<?php

	session_start();
	if (isset($_POST['add-submit'])) {
		
		require '../require/dbh.req.php';

		$text = $_POST['text'];
		$list = $_POST['list'];
		//Format: YYYY-MM-DD
		$date = $_POST['date'];
		$checked = 0;
		$userId = $_SESSION['id'];
		
		$sql = "INSERT INTO `checklist-task` (content, checked, `date`, `checklist_id`) VALUES
		( '$text', $checked, '$date', (SELECT id FROM checklist WHERE title='$list' AND user_id='$userId'));";
		
		if ($conn->query($sql) === true) {
			header("Location: ../../index.php?add=success");
		}
		else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
