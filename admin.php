<!DOCTYPE html>

<html>
	<head>
		<title>Lisgar Announcements</title>

		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php
			//echo "DB connection test<br/>";

			$con = new mysqli("127.0.0.1", "root", "root", "announcements");
			if ($con->connect_error) {
			die("DB Connection failed : " . $con->connect_error);
			}

			date_default_timezone_set('US/Eastern');
		?>

		<div class="color-strip"></div>

		<div class="header" id="header">
			<h1>Lisgar Announcements</h1>

			<div class="float-right">
				<p class="header-btn create" id="create" onclick="openCreate()">Create</p>
				<p class="header-btn settings" id="settings" onclick="openSettings()">Settings</p>
				<p class="header-btn log-out" id="log-out" onclick="location.href='myphp.php'">Log out</p>
			</div>
		</div>

		<div class="main-container">
			<div class="side-bar" id="side-bar">
				<ul>
					<li class="selected month-btn">September</li>
					<li class="month-btn">October</li>
					<li class="month-btn">November</li>
					<li class="month-btn">December</li>
					<li class="month-btn">January</li>
					<li class="month-btn">February</li>
					<li class="month-btn">March</li>
					<li class="month-btn">April</li>
					<li class="month-btn">May</li>
					<li class="month-btn">June</li>
					<li class="month-btn">July</li>
					<li class="month-btn">August</li>
				</ul>

				<div class="float-bottom">
					Return to <a href="https://lisgarci.ocdsb.ca/">Lisgar CI</a>
				</div>
			</div>

			<div class="main-content" id="main-content">
				<h3>September</h3>

				<div class="card-container" id="card-container">
					<?php
						$result = $con->query("SELECT ans.Title as title, cat.Name as category, top.Name as topic, ans.Location as location, ans.Content as content, date(ans.Datetime) as date, day(ans.Datetime) as day, date_format(ans.Datetime, '%l:%i %p') as time from Announcements as ans, Category as cat, Topic as top where ans.category_id=cat.id and ans.topic_id=top.id order by day");

						if ( $result->num_rows > 0 ){
							// echo "<table border='1'>";
							// echo "<tr><th>Title</th><th>Category</th><th>Topic</th></tr>";

							$index = 1;
							$ended = false;
							while($row = $result->fetch_assoc()){
								$title = $row["title"];
								$category = $row["category"];
								$topic = $row["topic"];
								$location = $row["location"];
								$time = $row["time"];
								$day = $row["day"];

								if ( $index <= $day ){
									if ( $ended ){
										echo '</div>';
										$ended = false;
									}

									echo '
										<div class="dates">
											<h4 class="date">' . $day . '</h4>';
									$index++;
									
									$ended = true;
								}

								echo '
									<div class="card">
										<p class="card-info card-category border">' . $category . '</p>
										<p class="card-info">' . $topic . '</p>
										<p class="card-title">' . $title . '</p>
										<p class="card-info card-setting">' . $time . '</p>
										<p class="card-info card-setting">' . $location . '</p>
									</div>';

								// echo "<tr>";
								// echo "<td>" . $row["title"] . "</td><td>" . $row["category"] . "</td><td>" . $row["topic"] . "</td>";
								// echo "</tr>";
							}
	
							if ( $ended ){
								echo '</div>';
								$ended = false;

								$index++;
							}

							// echo "</table>";
						}
					?>
				</div>
			</div>
		</div>

		<div class="overlay" id="overlay">
			<div class="expandable no-padding" id="expandable">
			</div>
		</div>

		<div class="create-container form-container" id="create-container">
			<div class="float-left half flex">
				<h1>CREATE ANNOUNCEMENT</h1>
			</div>
			<div class="float-left half flex">
				<form method="post">
					<fieldset>
						<legend>Create Announcement</legend>
						<input type="hidden" name="action" value="create" required/><br>

						<input type="text" name="title" placeholder="Title" required/><br>

						<input type="date" name="date" class="half-width" required/>
						<input type="time" name="time" class="half-width float-right"/><br>
						<input type="text" name="location" placeholder="Location"/>

						<select name="category">
							<option autofocus>Select Category</option>
							<?php
								$result = $con->query("SELECT id, name FROM Category");

								if ($result->num_rows > 0) {
									// create option for each category type
									while($row = $result->fetch_assoc()) {
										echo '<option value = "' . $row["id"] . '">' . $row["name"] . "</option>";
									}
								}
							?>
							<option onclick="createNewGroup()">Create New Category</option>
						</select>
						<br>

						<select name="organization">
							<option autofocus>Organization, Team or Group </option>
							<?php
								$result = $con->query("SELECT id, name FROM Topic");

								if ($result->num_rows > 0) {
									// create option for each category type
									while($row = $result->fetch_assoc()) {
										echo '<option value = "' . $row["id"] . '">' . $row["name"] . "</option>";
									}
								}
							?>
							<option onclick="createNewGroup()">Create New Category</option>
						</select>

						<input type="text" name="description" placeholder="Description"/>

						<input type="submit" value="Create">
						<input type="button" value="Cancel" onclick="closeCreate()">
					</fieldset>
				</form>
			</div>
		</div>
		<?php
			$action = $con->real_escape_string($_REQUEST['action']);
			if ($action == "create") {
				$title = $con->real_escape_string($_REQUEST['title']);
				$date = $con->real_escape_string($_REQUEST['date']);
				$time = $con->real_escape_string($_REQUEST['time']);
				$location = $con->real_escape_string($_REQUEST['location']);
				$category = $con->real_escape_string($_REQUEST['category']);
				$organization = $con->real_escape_string($_REQUEST['organization']);
				$content = $con->real_escape_string($_REQUEST['description']);

				$timestamp = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));

				$sql = "INSERT INTO Announcements (title, dateTime, location, content, category_id, topic_id) VALUES ('$title', '$timestamp', '$location', '$content', $category, $organization)";

				echo "sql = " . $sql;

				$con->query($sql);

				echo "<meta http-equiv='refresh' content='0'>";
			}
		?>

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
			//function addAnnouncement(title, date, month, category, topic, location, time) {
			//	createAnnouncement(title, date, month, category, topic, location, time);
			//}

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

			function createNewGroup() {
				document.getElementById('main-content').innerHTML += {
				}
			}
		</script>
	</body>
</html>