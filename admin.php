<!DOCTYPE html>

<html>
	<head>
		<title>Lisgar Announcements</title>

		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php include 'setup.php'?>

		<div class="color-strip"></div>

		<div class="header" id="header">
			<h1>Lisgar Announcements</h1>

			<div class="float-right">
				<p class="header-btn create" id="create" onclick="location.href='create.php'">Create</p>
				<p class="header-btn settings" id="settings" onclick="openSettings()">Settings</p>
				<p class="header-btn log-out" id="log-out" onclick="location.href='myphp.php'">Log out</p>
			</div>
		</div>

		<div class="main-container">
			<?php include 'sidebar.php'?>

			<?php include 'main-content.php'?>
		</div>

		<div class="overlay" id="overlay">
			<div class="expandable no-padding" id="expandable">
			</div>
		</div>

		<div class="settings-container form-container" id="settings-container">
			<div class="float-left half flex">
				<h1>SETTINGS</h1>
			</div>
			<div class="float-left half flex">
				<fieldset>
					<legend>Settings</legend>

				</fieldset>
			</div>
		</div>

		<?php
			$email = 'a@b.c';
			$password = 'abc';
			$match = false;

			if ($_POST["email"] == "" || $_POST["password"] == "") {
			} if ($_POST["email"] == $email && $_POST["password"] == $password) {
				echo "<script> window.location.assign('lisgarci.ocdsb.ca'); </script>";
			}
		?>

		<script src="jquery-3.3.1.js"></script>
		<script src="app.js"></script>
		<script type="text/javascript">
			function openCreate() {
				document.getElementById('create-container').style.display = "block";
			}

			function closeCreate() {
				document.getElementById('create-container').style.display = "none";
			}

			function openSettings() {
				document.getElementById('settings-container').style.display = "block";
			}

			function closeSettings() {
				document.getElementById('settings-container').style.display = "none";
			}
		</script>
	</body>
</html>