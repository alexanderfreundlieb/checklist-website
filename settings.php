<?php
	session_start();
	require 'php/require/dbh.req.php';

	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
	}

	$sqlUser = "SELECT username, email FROM user WHERE id='" . $_SESSION['id'] . "';";
	$resultUser = mysqli_query($conn, $sqlUser);
	$rowUser = mysqli_fetch_array($resultUser);
?>

<!doctype html>
<html lang="en">
	<head>
	
		<title>Checkliste - Einstellungen</title>
		
		<?php
			require 'php/head.html';
		?>
	
	</head>

	<body>
		
		<header>
			<div class="nav-box">
				<div class="nav-container">
					<span class="toggle-button">
						<span class="menu-bar menu-bar-top"></span>
						<span class="menu-bar menu-bar-middle"></span>
						<span class="menu-bar menu-bar-bottom"></span>
					</span>
					<div class="menu-wrap">
						<div class="menu-sidebar">
							<div class="user-container">
								<div class="profile-img-container">
									<i class="fas fa-user profile-img"></i>
								</div>
								<div class="profile-text">
									<h3>
										
										<?php
											echo ucfirst(mb_strimwidth($rowUser['username'], 0, 11));
										?>
										
									</h3>
									<h6>
										
										<?php
											echo mb_strimwidth($rowUser['email'], 0, 20, "...");
										?>
										
									</h6>
								</div>
							</div>
							<ul class="menu">
								<li class="sidebar-link"><a href="index.php"><i class="fas fa-home sidebar-icon"></i>Home</a></li>
								<li class="sidebar-link"><a href="checklists.php"><i class="far fa-check-square sidebar-icon"></i>Checklisten</a></li>
							</ul>
							<a href="php/include/logout.inc.php"><button class="sidebar-button">Abmelden</button></a>
						</div>
					</div>
					<div class="vis-link">
						<a href="index.php" class="navbar-brand nav-item">Checkliste</a>
						<a href="settings.php" class="fas fa-cog nav-item"></a>
					</div>
				</div>
			</div>
		</header>
		
		<main>
			<div class="main-container">
                <h2 class="title">Einstellungen</h2>
                <h4 class="settings-sub-heading">Farben</h4>
                <div class="colors">
                    <span class="color red"></span>
                    <span class="color orange"></span>
                    <span class="color yellow"></span>
                    <span class="color green"></span>
                    <span class="color blue active-color"></span>
                    <span class="color purple"></span>
                    <span class="color brown"></span>
                </div>
				<br>
				<br>
				<h3 style="text-align: center">Noch nicht funktionsfähig - Comming soon!</h3>
            </div>
		</main>
		
	</body>
</html>