<?php

	if (isset($_POST['delete-submit'])) {
		
		require '../require/dbh.req.php';

		$id = $_POST['id'];
		
		$query = "DELETE FROM `checklist-task` WHERE checklist_id=$id";
		$conn->query($query);
		$sql = "DELETE FROM `checklist` WHERE id=$id;";
		
		if ($conn->query($sql) === true) {
			header("Location: ../../checklists.php?delete=success");
		}
		else {
			echo "Error deleting record: " . $conn->error;
		}
	}
