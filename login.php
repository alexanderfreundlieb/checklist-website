<?php
	session_start();
	require "php/require/dbh.req.php";
?>

<!doctype html>
<html lang="en">
	
	<head>

		<title>Checkliste - Login</title>

		<?php
			include "php/head.html";
		?>
	
	</head>
	
	<body>
		<header>
			
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'wronglogin') {
						echo '<div class="error-box show" id="wrong">Falsches Passwort oder falscher Benutzer!</div>
						<script>
						  setTimeout(function(){
							document.getElementById("wrong").classList.remove("show")
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
				<h2>Anmelden</h2>
				<h6>Noch keinen Account? <a href="signup.php" class="link">Jetzt registrieren</a></h6>
				<form action="php/include/login.inc.php" method="post">
					<label for="uidMail">Benutzername</label>
					<input type="text" name="uidMail" placeholder="Benutzername hier eingeben" required>
					<label for="password">Passwort</label>
					<input type="password" name="password" placeholder="Passwort hier eingeben" required>
					<button type="submit" name="signin-submit" class="submit-btn">Anmelden</button>
				</form>
			</div>
		</main>
	</body>
</html>