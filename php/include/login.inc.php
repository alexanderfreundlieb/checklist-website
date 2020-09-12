<?php

	//Es wird geprüft ob der Benutzer mit dem Anmelde Knopf hier hin gekommen ist
	if (isset($_POST['signin-submit'])) {
		
		//Verbindung zu der Datenbank
		require '../require/dbh.req.php';
		
		//Im Form eingegeben Daten werden in variablen gespeichert
		$uidMail = $_POST['uidMail'];
		$pwd = $_POST['password'];
		
		//Überprüft ob irgendwelche Felder lehr sind
		if (empty($uidMail) || empty($pwd)) {
			header("Location: ../../login.php?error=emptyfields");
			exit();
		}
		else {
			//SQL Statement wird vorbereitet um zu überprüfen ob der Benutzername 
			//oder die EMail in der Datenbank vorhanden ist
			$sql = "SELECT * FROM user WHERE username=? OR email=?;";
			$stmt = mysqli_stmt_init($conn);
			//Prüft ob irgendwelche Fehler im Statement sind
			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: ../../login.php?error=sqlerror");
				exit();
			}
			else {
				//"ss" da wir 2 strings mitgeben
				mysqli_stmt_bind_param($stmt, "ss", $uidMail, $uidMail);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				//Prüft ob der Benutzername oder die EMail in der Datenbank vorhanden ist
				if ($row = mysqli_fetch_assoc($result)) {
					//Hier wird das eingegeben Passwort überprüft
					//Es muss mit password_verify überprüft werden, da das Passwort gehashed ist
					$pwdCheck = password_verify($pwd, $row['password']);
					if ($pwdCheck == false) {
						header("Location: ../../login.php?error=wronglogin");
						exit();
					}
					else if ($pwdCheck == true) {
						//Wenn das Passwort richtig eingegeben wurde, wird eine Session gestartet
						//Der Benutzer ist jetzt eingeloggt
						session_start();
						$_SESSION['id'] = $row['id'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['username'] = $row['username'];
						
						header("Location: ../../index.php?signin=success");
						exit();
					}
				}
				else {
					header("Location: ../../login.php?error=wronglogin");
					exit();
				}
			}
		}
		//Das Statement und die Verbindung wird geschlossen
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
	//Der Benutzer wird zurück geschickt wenn er auf anderem Weg als über den Anmelde Knopf hier hin gekommen ist
	else {
		header("Location: ../../login.php");
		exit();
	}