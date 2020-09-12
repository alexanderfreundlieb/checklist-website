<?php

	session_start();
	if (isset($_POST['add-submit'])) {
		
		require '../require/dbh.req.php';

		$title = $_POST['title'];
		$favorite = 0;
		$userId = $_SESSION['id'];
		
		$sqlTest = "SELECT COUNT(*) AS num FROM checklist WHERE title='$title' AND user_id=$userId";
		$result = mysqli_query($conn, $sqlTest);
		$row = mysqli_fetch_array($result);
		
		if ($row['num'] != 0) {
			header("Location: ../../checklists.php?error=notunique");
		}
		else {
			$sql = "INSERT INTO `checklist` (title, favorite, `user_id`) VALUES
			( '$title', $favorite, $userId )";

			if ($conn->query($sql) === true) {
				header("Location: ../../checklists.php?add=success");
			}
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			
			}
		}
	} 