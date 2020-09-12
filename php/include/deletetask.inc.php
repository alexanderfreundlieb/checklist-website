<?php

	if (isset($_POST['delete-submit'])) {
		
		require '../require/dbh.req.php';

		$id = $_POST['id'];
		
		$sql = "DELETE FROM `checklist-task` WHERE id=$id;";
		
		if ($conn->query($sql) === true) {
			header("Location: ../../index.php?delete=success");
		}
		else {
			echo "Error deleting record: " . $conn->error;
		}
	}
