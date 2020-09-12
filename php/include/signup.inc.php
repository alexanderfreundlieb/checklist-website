<?php

	//Es wird geprüft ob der Benutzer mit dem Anmelde Knopf hier hin gekommen ist
	if (isset($_POST['signup-submit'])) {
		
		//Verbindung zu der Datenbank
		require '../require/dbh.req.php';

		//Im Form eingegeben Daten werden in variablen gespeichert
		$username = $_POST['username'];
		$email = $_POST['mail'];
		$password = $_POST['pwd'];
		$repeatPassword = $_POST['repeatPwd'];
		//Zusätzlich wire jedem Benutzer vorerst die Farbe blau zugewiesen
		//Die color Variable bezieht sich auf die Spalte color_id in 
		//unserer Datenbank. Dementsprechend ist 1 die id der Tabelle
		//color, welche zu blau gehört. 2 währe rot, 3 orange usw.
		$color = 1;

		//Überprüft ob irgendwelche Felder lehr sind
		if (empty($username) || empty($email) || empty($password) || empty($repeatPassword)) {
			header("Location: ../../signup.php?error=emptyfields");
			exit();
		}
		//Überprüft ob die eingegeben EMail legitim ist
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			header("Location: ../../signup.php?error=invalidmail");
			exit();
		}
		//Überprüft ob die Passwörter übereinstimmen
		else if ($password !== $repeatPassword) {
			header("Location: ../../signup.php?error=mismatchpassword");
			exit();
		}
		else {
			//SQL Statement wird vorbereitet um zu überprüfen ob die EMail 
			//bereits in der Datenbank vorhanden ist
			$sql = "SELECT email FROM user WHERE email=?;";
			$stmt = mysqli_stmt_init($conn);
			//Prüft ob irgendwelche Fehler im Statement sind
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../../signup.php?error=sqlerror");
				exit();
			}
			else {
				//Nur "s" da wir nur 1 String mitgeben
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				//Anzahl Zeilen mit der gleichen Mail werden in eine
				//neue Variable gespeichert.
				$resultCountEmail = mysqli_stmt_num_rows($stmt);
				mysqli_stmt_close($stmt);
				
				//Wie bei der EMail wird auch beim Benutzernamen überprüft,
				//ob er bereits vergeben ist.
				$sql = "SELECT username FROM user WHERE username=?;";
				$stmt = mysqli_stmt_init($conn);
				if (!mysqli_stmt_prepare($stmt, $sql)) {
					header("Location: ../../signup.php?error=sqlerror");
					exit();
				}
				else {
					mysqli_stmt_bind_param($stmt, "s", $username);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					$resultCountUsername = mysqli_stmt_num_rows($stmt);
					mysqli_stmt_close($stmt);
				
					//Wenn die EMail oder der Benutzername bereits existiert, beträgt die
					//nummer der Variable resultCountEmail, respektive resultCountUsername, 1
					if ($resultCountEmail > 0) {
						header("Location: ../../signup.php?error=emailtaken");
						exit();
					}
					else if ($resultCountUsername > 0) {
						header("Location: ../../signup.php?error=usertaken");
						exit();
					}
					else {
						//SQL Statement wird vorbereitet um die eingegebenen Daten in die Datenbank zu speichern
						$sql = "INSERT INTO user (email, username, password, color_id) VALUES (?, ?, ?, ?);";
						$stmt = mysqli_stmt_init($conn);
						if (!mysqli_stmt_prepare($stmt, $sql)) {
							header("Location: ../../signup.php?error=sqlerror");
						}
						else {
							//Das eingegebene Passwort wird gehashed damit es nicht offen in der Datenbank steht
							$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
							//Hier "sssi" da wir 3 strings und 1 integer mitgeben
							mysqli_stmt_bind_param($stmt, "sssi", $email, $username, $hashedPwd, $color);
							mysqli_stmt_execute($stmt);

							header("Location: ../../index.php?signup=success");
							exit();
						}
					}
				}
			}
		}
		//Das Statement und die Verbindung wird geschlossen
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	//Der Benutzer wird zurück geschickt wenn er auf anderem Weg als über den Anmelde Knopf hier hin gekommen ist
	else {
		header("Location: ../../signup.php");
		exit();
	}