<!DOCTYPE html>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="color-strip"></div>

	<?php
		include 'setup.php';

		$id = $_GET['id'];
		if (strlen($id) == 0) $id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		// echo "id = " . $id;
		// echo "action = " . $action;
		$title = "";
		$date = "";
		$time = "";
		$location = "";
		$category_id = "";
		$topic_id = "";
		$description = "";
		if (strlen($id) > 0 && strlen($action) == 0){
			$sql = "SELECT title, DATE_FORMAT(dateTime, '%Y-%m-%d') as date, DATE_FORMAT(dateTime, '%H:%m') as time, location, content, category_id, topic_id FROM Announcements WHERE id=" . $id;
			// echo "sql = " . $sql;
			$result = $con->query($sql);
			
			if ($result->num_rows > 0) {
				// found the current item
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

	<div class="create-container form-container" id="create-container">
		<div class="half flex">
			<h1>CREATE ANNOUNCEMENT</h1>
		</div>
		<div class="half flex">
			<form class="create-form" method="post">
				<fieldset>
					<legend>Create Announcement</legend>
					
					<?php if (strlen($id) > 0){	?>
					
					<input type="hidden" name="id" value="<?=$id?> " required/>
					<input type="hidden" name="action" value="modify" required/>
					
					<?php } else {	?>
					
					<input type="hidden" name="action" value="create" required/>
			
					<?php }	?>

					<input type="text" name="title" <?php if (strlen($title) > 0){?>value="<?=$title?>"<?php } else { ?>placeholder="Title"<?php } ?> required/><br>

					<input type="date" name="date" <?php if (strlen($date) > 0){?>value="<?=$date?>"<?php }?> class="half-width" required/>
					<input type="time" name="time" <?php if (strlen($time) > 0){?>value="<?=$time?>:00"<?php }?> class="half-width float-right"/><br>

					<input type="text" name="location" <?php if (strlen($location) > 0){?>value="<?=$location?>"<?php } else { ?>placeholder="Location"<?php } ?>/>

					<select name="category">
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
									echo '<option value = "' . $row["id"] . '"';
									if ( $row["id"] == $topic_id)
										echo " selected";
									echo '>' . $row["name"] . "</option>";
								}
							}
						?>
						<option onclick="createNewGroup()">Create New Category</option>
					</select>

					<input type="text" name="description" <?php if (strlen($description) > 0){?>value="<?=$description?>"<?php } else { ?>placeholder="Description"<?php } ?>/>

					<input type="submit" value="<?php if (strlen($id) > 0){?>Modify<?php } else { ?>Create<?php } ?>">
					<input type="button" value="Cancel" onclick="closeCreate()">
				</fieldset>
			</form>
		</div>
	</div>

	<?php
	if (strlen($action) > 0) {
			$title = $con->real_escape_string($_REQUEST['title']);
			$date = $con->real_escape_string($_REQUEST['date']);
			$time = $con->real_escape_string($_REQUEST['time']);
			$location = $con->real_escape_string($_REQUEST['location']);
			$category = $con->real_escape_string($_REQUEST['category']);
			$organization = $con->real_escape_string($_REQUEST['organization']);
			$content = $con->real_escape_string($_REQUEST['description']);

			$timestamp = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));

			if (strlen($id) > 0 && $action == "modify")
				$sql = "UPDATE Announcements set title='" . $title . "', dateTime='" . $timestamp . "', location='" . $location . "', content='". $content . "', category_id='" . $category . "', topic_id='" . $organization. "' WHERE id=" . $id;
			else
				$sql = "INSERT INTO Announcements (title, dateTime, location, content, category_id, topic_id) VALUES ('$title', '$timestamp', '$location', '$content', $category, $organization)";
				
			echo "sql = " . $sql;

			$con->query($sql);

			echo "<meta http-equiv='refresh' content='0'>";
		}
	?>
</body>
</html>