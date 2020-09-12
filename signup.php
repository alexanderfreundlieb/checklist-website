<?php
	session_start();
	require "php/require/dbh.req.php";
?>

<!doctype html>
<html lang="en">
	
	<head>
		
		<title>Checkliste - Regsitrieren</title>

		<?php
			include "php/head.html";
		?>

	</head>

	<body>
		<header>
			
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'usertaken') {
						echo '<div class="error-box show" id="user">Benutzer existiert bereits!</div>
						<script>
						  setTimeout(function(){
							document.getElementById("user").classList.remove("show")
						  }, 3000);
						</script>';
					}
					else if ($_GET['error'] == 'emailtaken') {
						echo '<div class="error-box show" id="mail">Email existiert bereits!</div>
						<script>
						  setTimeout(function(){
							document.getElementById("mail").classList.remove("show")
						  }, 3000);
						</script>';
					}
					else if ($_GET['error'] == 'mismatchpassword') {
						echo '<div class="error-box show" id="password">Wiederholtes Passwort ist nicht das gleiche!</div>
						<script>
						  setTimeout(function(){
							document.getElementById("password").classList.remove("show")
						  }, 3000);
						</script>';
					}
				}
			?>
			
			<div class="nav-box">
				<div class="nav-container">
					<div class="vis-link">
						<a href="index.php" class="navbar-brand nav-item login-nav">Checkliste</a>
					</div>
				</div>
			</div>
		</header>
		
		<main>
			<div class="main-container login-page">
				<h2>Registrieren</h2>
				<h6>Bereits registriert? <a href="login.php" class="link">Jetzt anmelden</a></h6>
				<form action="php/include/signup.inc.php" method="post">
					<label for="mail">Email</label>
					<input type="email" name="mail" placeholder="Mail hier eingeben" required>
					<label for="username">Benutzername</label>
					<input type="text" name="username" placeholder="Benutzername hier eingeben" required>
					<label for="pwd">Passwort</label>
					<input type="password" name="pwd" placeholder="Passwort hier eingeben" required>
					<label for="repeatPwd">Passwort wiederholen</label>
					<input type="password" name="repeatPwd" placeholder="Passwort hier wiederholen" required>
					<button type="submit" name="signup-submit" class="submit-btn">Registrieren</button>
				</form>
			</div>
		</main>
	</body>
</html>