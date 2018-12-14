<!-- Public page -->

<!DOCTYPE html>

<html>
	<head>
		<title>Lisgar Announcements</title>

		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="media-query.css">
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

		<script src="jquery-3.3.1.js"></script>
		<script src="app.js"></script>
	</body>
</html>