<!DOCTYPE html>

<html>
	<head>
		<title>Create Announcements</title>

		<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="stylesheet" type="text/css" href="../media-query.css">
	</head>

	<body>
		<div class="color-strip"></div>

		<?php
			include '../setup.php';

			// Gets announcement id for editing
			$id = $_GET['id'];
			if (strlen($id) == 0) $id = $_REQUEST['id'];

			$action = $_REQUEST['action'];
			$title = "";
			$date = "";
			$time = "";
			$location = "";
			$category_id = "";
			$topic_id = "";
			$description = "";

			// If editing, set default variables
			if (strlen($id) > 0 && strlen($action) == 0){
				$sql = "SELECT title, DATE_FORMAT(dateTime, '%Y-%m-%d') as date, DATE_FORMAT(dateTime, '%H:%m') as time, location, content, category_id, topic_id FROM Announcements WHERE id=" . $id;

				$result = $con->query($sql);
				
				if ($result->num_rows > 0) {
					// Find the current announcement
					$row = $result->fetch_assoc();
					$title = $row["title"];
					$date = $row["date"];
					$time = $row["time"];
					$location = $row["location"];
					$category_id = $row["category_id"];
					$topic_id = $row["topic_id"];
					$description = $row["content"];
				} else {
					$id = "";
				}
			}
		?>

		<div class="create-container" id="create-container">
			<div class="half flex">
				<h2>CREATE ANNOUNCEMENT</h2>
			</div>
			<div class="half flex">
				<form name="create" class="create-form" id="create-form" method="post" onsubmit="return validateCreate()">
					<fieldset>
						<legend>Create Announcement</legend>
						
						<?php if (strlen($id) > 0){	?>
						
						<input type="hidden" name="id" value="<?=$id?> " required/>
						<input type="hidden" name="action" value="modify" required/>
						
						<?php } else {	?>
						
						<input type="hidden" name="action" value="create" required/>
				
						<?php }	?>

						<input type="text" name="title" <?php if (strlen($title) > 0){?>value="<?=$title?>"<?php } else { ?>placeholder="Title"<?php } ?> required/>

						<br>

						<input type="date" name="date" <?php if (strlen($date) > 0){?>value="<?=$date?>"<?php }?> class="half-width" required/>
						<input type="time" name="time" <?php if (strlen($time) > 0){?>value="<?=$time?>:00"<?php }?> class="half-width float-right"/>

						<br>

						<input type="text" name="location" <?php if (strlen($location) > 0){?>value="<?=$location?>"<?php } else { ?>placeholder="Location"<?php } ?>/>

						<select class="form-select" id="category-select" name="category" onChange="checkOption('category-select');" required>
							<option autofocus>Select Category</option>
							<?php
								$result = $con->query("SELECT id, name FROM Category");

								if ($result->num_rows > 0) {
									// create option for each category type
									while($row = $result->fetch_assoc()) {
										echo '<option value = "' . $row["id"] . '"';
										if ( $row["id"] == $category_id)
											echo " selected";
										echo '>' . $row["name"] . "</option>";
									}
								}
							?>
							<option>Create New Category</option>
						</select>
						<br>

						<select class="form-select" id="organization-select" name="organization" onChange="checkOption('organization-select');" required>
							<option autofocus>Select Organization, Team or Group</option>
							<?php
								$result = $con->query("SELECT id, name FROM Topic");

								if ($result->num_rows > 0) {
									// create option for each organization type
									while($row = $result->fetch_assoc()) {
										echo '<option value = "' . $row["id"] . '"';
										if ( $row["id"] == $topic_id)
											echo " selected";
										echo '>' . $row["name"] . "</option>";
									}
								}
							?>
							<option>Create New organization, team or group</option>
						</select>

						<textarea type="text" maxlength="512" rows="7" name="description" <?php if (strlen($description) > 0){?>value="<?=$description?>"<?php } else { ?>placeholder="Description"<?php } ?>> </textarea>

						<input type="submit" name="submit" id="submit-create-form" value="<?php if (strlen($id) > 0){?>Modify<?php } else { ?>Create<?php } ?>">
						<?php if (strlen($id) > 0){?> <input type="submit" name="delete" value="Delete"> <?php } 
							// Deletes announcement
							if (isset($_POST['delete'])) {
								$sql = "DELETE from announcements where announcements.id = " . $id;

								$con->query($sql);
							}
						?>
						<input type="button" value="Cancel" onclick="returnToAdmin()">
					</fieldset>
				</form>
			</div>
		</div>

		<div class="error-msg" id="errorId">
			
		</div>

		<?php
			// Save changes
			if (strlen($action) > 0 && isset($_POST['submit'])) {
				$title = $con->real_escape_string($_REQUEST['title']);
				$date = $con->real_escape_string($_REQUEST['date']);
				$time = $con->real_escape_string($_REQUEST['time']);
				$location = $con->real_escape_string($_REQUEST['location']);
				$category = $con->real_escape_string($_REQUEST['category']);
				$organization = $con->real_escape_string($_REQUEST['organization']);
				$content = $con->real_escape_string($_REQUEST['description']);

				$timestamp = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));

				// Update db
				if (strlen($id) > 0 && $action == "modify")
					$sql = "UPDATE Announcements set title='" . $title . "', dateTime='" . $timestamp . "', location='" . $location . "', content='". $content . "', category_id='" . $category . "', topic_id='" . $organization. "' WHERE id=" . $id;
				else
					$sql = "INSERT INTO Announcements (title, dateTime, location, content, category_id, topic_id) VALUES ('$title', '$timestamp', '$location', '$content', $category, $organization)";
					
				// echo "sql = " . $sql;

				$con->query($sql);

				// echo "<meta http-equiv='refresh' content='0'>";
				echo "<script> window.location.assign('admin.php'); </script>";
			}
		?>

		<div class="overlay" id="overlay"></div>
		<div class="expandable no-padding" id="expandable"></div>

		<?php
			// Adding new groups / organizations
			$action = $_REQUEST['group'];
			$name = $con->real_escape_string($_REQUEST['groupName']);

			// If submit clicked
			if (isset($_POST['createGroup'])) {
				if ($action == "category")
					$sql = "INSERT into Category (name) VALUES ('$name')";
				else if ($action == "organization")
					$sql = "INSERT into Topic (name) VALUES ('$name')";

				echo $sql;

				$con->query($sql);

				echo "<meta http-equiv='refresh' content='0'>";
			}
		?>

		<script src="../form-validation.js"></script>
		<script type="text/javascript">
			function returnToAdmin() {
				window.location = 'admin.php';
			}

			let expandable = document.getElementById('expandable');
			let overlay = document.getElementById('overlay');

			function openOverlay() {
				expandable.classList.add('half-screen');
				expandable.classList.remove('no-padding');
				overlay.classList.add('full-screen');
			}

			function closeOverlay() {
					console.log('close goddammit');
				expandable.classList.remove('half-screen');
				expandable.classList.add('no-padding');
				overlay.classList.remove('full-screen');
			}

			function checkOption(id) {
				console.log(id);
				let selectBox = document.getElementById(id);
				let selectedIndex = selectBox.selectedIndex;

				if (selectedIndex == selectBox.options.length - 1) {
					console.log(selectBox.name);
					
					openOverlay();

					expandable.innerHTML = `
						<form method='post' name='new-group' onsubmit='return validateNewGroup();'>
							<fieldset>
								<div class="close-overlay" id="close-overlay" onclick="closeOverlay()">&#10005;</div>

								<legend>New ${selectBox.name}</legend>

								<input type='hidden' name='group' value='${selectBox.name}'/>

								<input type='text' name='groupName'/>
								<input type='submit' value='Add' name='createGroup'/>
							</fieldset>
						</form>
					`;
				}

			}

			overlay.onclick = function() {
				console.log('help');
				closeOverlay();
			}
		</script>
	</body>
</html>