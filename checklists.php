<?php
	session_start();
	require 'php/require/dbh.req.php';

	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
	}

	$sqlUser = "SELECT username, email FROM user WHERE id='" . $_SESSION['id'] . "';";
	$resultUser = mysqli_query($conn, $sqlUser);
	$rowUser = mysqli_fetch_array($resultUser);

	$sql = mysqli_query($conn, "SELECT c.title, c.id, COUNT(ct.id) AS count FROM checklist AS c JOIN `checklist-task` AS ct ON c.id = ct.checklist_id WHERE user_id='" . $_SESSION['id'] . "' GROUP BY c.id;");
	$sql2 = mysqli_query($conn, "SELECT title, id FROM checklist WHERE user_id='" . $_SESSION['id'] . "';");
?>

<!doctype html>
<html lang="en">
	<head>
	
		<title>Checkliste - Meine Listen</title>
		
		<?php
			require 'php/head.html';
		?>
	
	</head>

	<body>
		
		<header>
			
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 'notunique') {
						echo '<div class="error-box show" id="notunique">Diese Checkliste existiert bereits!</div>
						<script>
						  setTimeout(function(){
							document.getElementById("notunique").classList.remove("show")
						  }, 3000);
						</script>';
					}
				}
			?>
			
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
								<li class="sidebar-link"><a href="checklists.php"><i class="far fa-check-square sidebar-icon active"></i>Checklisten</a></li>
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
			</div>
		</header>
		
		<main>
			<div class="main-container checklists-container">
				<h2 class="title checklists-title">Meine Listen</h2>
				<button class="edit-button">Bearbeiten</button>
				<button class="done-button invis-done">Fertig</button>
				<div class="plus"></div>
				<div class="form-popup" id="myForm">
					<form action="php/include/addlist.inc.php" class="form-container" method="post">
						<h3>Liste erstellen</h3>

						<label for="title">Titel</label>
						<input type="text" placeholder="Titel eingeben" name="title" required>

						<button type="submit" name="add-submit" class="btn">Erstellen</button>
						<button type="button" class="btn cancel">Schliessen</button>
					</form>
				</div>
				
				<?php
					if (mysqli_num_rows($sql) == 0) {
						if (mysqli_num_fields($sql2) == 0) {
							echo '<h3 style="font-weight:400">Keine vorhandenen Listen</h3>';
						}
						else {
							while ($row = mysqli_fetch_array($sql2)) {
								echo '<div class="list-box">
									<p class="list-title">' . $row['title'] . '</p>';
									echo '<p class="list-count">0 Tasks</p>';
									echo '<form action="php/include/deletelist.inc.php" method="post">
										<input name="id" style="display:none" value="' . $row['id'] . '">
										<button type="submit" name="delete-submit" class="minus invis-done"></button>
									</form>
								</div>';
							}
						}
					}
					else {
						while ($row = mysqli_fetch_array($sql)) {
							echo '<div class="list-box">
								<p class="list-title">' . $row['title'] . '</p>';
								if ($row['count'] == 1) {
									echo '<p class="list-count">' . $row['count'] . ' Task</p>';
								}
								else {
									echo '<p class="list-count">' . $row['count'] . ' Tasks</p>';
								}
								echo '<form action="php/include/deletelist.inc.php" method="post">
									<input name="id" style="display:none" value="' . $row['id'] . '">
									<button type="submit" name="delete-submit" class="minus invis-done"></button>
								</form>
							</div>';
						}
					}
				?>
				
			</div>
		</main>
		
	</body>
</html>