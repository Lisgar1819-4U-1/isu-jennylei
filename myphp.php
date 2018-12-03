
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
				<p class="header-btn log-in" id="log-in">Log in</p>
			</div>
		</div>

		<div class="main-container">
			<?php include 'sidebar.php'?>

			<?php include 'main-content.php'?>
		</div>

		<div class="overlay" id="overlay"></div>
		<div class="expandable no-padding" id="expandable"></div>

		<div class="log-in-container" id="log-in-container">
			<div class="float-left half flex">
				<h1>LOG IN</h1>
			</div>
			<div class="float-left half flex">
				<form class="signIn-form" method="post">
					<fieldset>
						<legend>Sign in</legend>
						<input type="email" name="email" placeholder="Email" required/><br>
						<input type="password" name="password" placeholder="Password" required/><br>
						<input type="submit" value="Log In"/><br>
						<input type="button" value="Cancel" id="cancel-log-in" />
					</fieldset>
				</form>
			</div>
		</div>

		<?php
			$email = 'a@b.c';
			$password = 'abc';
			$match = false;

			if ($_POST["email"] == "" || $_POST["password"] == "") {
			} if ($_POST["email"] == $email && $_POST["password"] == $password) {
				echo "<script> window.location.assign('admin.php'); </script>";
			}
		?>

		<script src="jquery-3.3.1.js"></script>
		<script src="app.js"></script>
	</body>
</html>