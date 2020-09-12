<?php
	session_start();
	require 'php/require/dbh.req.php';

	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
	}

	$sql1 = "SELECT c.title, ct.id, ct.content, ct.checked, ct.date FROM `checklist-task` AS ct JOIN checklist AS c ON ct.checklist_id = c.id WHERE c.user_id='" . $_SESSION['id'] . "';";
	$result1 = mysqli_query($conn, $sql1);

	$sql2 = "SELECT c.title, ct.id, ct.content, ct.checked, ct.date FROM `checklist-task` AS ct JOIN checklist AS c ON ct.checklist_id = c.id WHERE c.user_id='" . $_SESSION['id'] . "';";
	$result2 = mysqli_query($conn, $sql2);

	$sql3 = "SELECT c.title, ct.id, ct.content, ct.checked, ct.date FROM `checklist-task` AS ct JOIN checklist AS c ON ct.checklist_id = c.id WHERE c.user_id='" . $_SESSION['id'] . "';";
	$result3 = mysqli_query($conn, $sql3);

	$tomorrow = new DateTime('tomorrow');
	$afterTomorrow = new DateTime('tomorrow + 1day');

	$sqlDropdown = "SELECT title FROM checklist WHERE user_id='" . $_SESSION['id'] . "';";
	$resultDropdown = mysqli_query($conn, $sqlDropdown);

	$sqlUser = "SELECT username, email FROM user WHERE id='" . $_SESSION['id'] . "';";
	$resultUser = mysqli_query($conn, $sqlUser);
	$rowUser = mysqli_fetch_array($resultUser);

?>

<!doctype html>
<html lang="en">
	<head>
	
		<title>Checkliste - Home</title>
		
		<?php
			require 'php/head.html';
		?>
	
	</head>

	<body>
		
		<header>
			
			<?php
				if (isset($_GET['signin'])) {
					echo '<div class="success-box show" id="login">Erfolgreich angemeldet!</div>
					<script>
					  setTimeout(function(){
						document.getElementById("login").classList.remove("show")
					  }, 3000);
					</script>';
				}
				else if (isset($_GET['signup'])) {
					echo '<div class="success-box show" id="register">Erfolgreich registriert und angemeldet!</div>
					<script>
					  setTimeout(function(){
						document.getElementById("register").classList.remove("show")
					  }, 3000);
					</script>';
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
								<li class="sidebar-link"><a href="index.php"><i class="fas fa-home sidebar-icon active"></i>Home</a></li>
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
				<h2 class="title">Alles</h2>
				<button class="edit-button">Bearbeiten</button>
				<button class="done-button invis-done">Fertig</button>
				<div class="plus"></div>
				<div class="form-popup" id="myForm">
					<form action="php/include/addtask.inc.php" class="form-container" method="post">
						<h3>Task hinzufügen</h3>

						<label for="text">Text</label>
						<input type="text" placeholder="Text eingeben" name="text" required>

						<label for="list">Liste</label>
						<select name="list" required>
							
							<?php 
								while ($rowDropdown = mysqli_fetch_array($resultDropdown)) {
									echo '<option value="' . $rowDropdown['title'] . '">' . $rowDropdown['title'] . '</option>';
								}
							?>
							
						</select>

						<label for="date">Deadline</label>
						<input type="date" name="date" required>

						<button type="submit" name="add-submit" class="btn">Hinzufügen</button>
						<button type="button" class="btn cancel">Schliessen</button>
					</form>
				</div>
				
				<?php
				
					if (mysqli_num_rows($result1) == 0) {
						echo '<h3 style="font-weight:400; padding-top:15px">Nichts geplant</h3>';
					}
					else {
						echo '<h4>Heute</h4><br>';

						while ($row1 = mysqli_fetch_array($result1)) {
							if (date("Y-m-d") == $row1['date']) {
								echo '<div class="task-box">
									<label class="checkbox-label">
										<input type="checkbox"';
										if ($row1['checked'] == 1) {
											echo 'checked>';
										}
										else {
											echo '>';
										}
										echo '<span class="checkbox-custom">
									</label>
									<form action="php/include/deletetask.inc.php" method="post">
										<input name="id" style="display:none" value="' . $row1['id'] . '">
										<button type="submit" name="delete-submit" class="minus invis-done"></button>
									</form>
									<p class="task-title">';
										echo $row1['title'];
									echo '</p>
									<p class="task-content">';
										echo $row1['content'];
									echo '</p>
								</div>';
							}
						}

						echo '<h4>Morgen</h4><br>';

						if (mysqli_num_rows($result2) == 0) {
							echo '<h3 style="font-weight:400">Nichts geplant</h3>';
						}
						while ($row2 = mysqli_fetch_array($result2)) {
							if ($tomorrow->format("Y-m-d") == $row2['date']) {
								echo '<div class="task-box">
									<label class="checkbox-label">
										<input type="checkbox"';
										if ($row2['checked'] == 1) {
											echo 'checked>';
										}
										else {
											echo '>';
										}
										echo '<span class="checkbox-custom">
									</label>
									<form action="php/include/deletetask.inc.php" method="post">
										<input name="id" style="display:none" value="' . $row2['id'] . '">
										<button type="submit" name="delete-submit" class="minus invis-done"></button>
									</form>
									<p class="task-title">';
										echo $row2['title'];
									echo '</p>
									<p class="task-content">';
										echo $row2['content'];
									echo '</p>
								</div>';
							}
						}

						echo '<h4>' . $afterTomorrow->format("d.m.Y") . '</h4>';

						if (mysqli_num_rows($result3) == 0) {
							echo '<h3 style="font-weight:400">Nichts geplant</h3>';
						}
						while ($row3 = mysqli_fetch_array($result3)) {
							if ($afterTomorrow->format("Y-m-d") == $row3['date']) {
								echo '<div class="task-box">
									<label class="checkbox-label">
										<input type="checkbox"';
										if ($row3['checked'] == 1) {
											echo 'checked>';
										}
										else {
											echo '>';
										}
										echo '<span class="checkbox-custom">
									</label>
									<form action="php/include/deletetask.inc.php" method="post">
										<input name="id" style="display:none" value="' . $row3['id'] . '">
										<button type="submit" name="delete-submit" class="minus invis-done"></button>
									</form>
									<p class="task-title">';
										echo $row3['title'];
									echo '</p>
									<p class="task-content">';
										echo $row3['content'];
									echo '</p>
								</div>';
							}
						}
					}
				
				?>
			
			</div>
		</main>
		
	</body>
</html>