<div class="main-content" id="main-content">
	<div class="header-panel">
		<h3 id="month">September</h3>

		<div class="filter-panel" id="filter-panel">
			<div class="filter-container" id="filter-category">
				<div class="filter-button Category">
					<p class="filter-text">Category</p>
					<img src="edit.svg"/>
				</div>
				<div class="filter-content">
				<?php
					$result = $con->query("SELECT id, name FROM Category");

					if ($result->num_rows > 0) {
						// create option for each category type
						while($row = $result->fetch_assoc()) {
							echo '<div class = "filter-element ' . $row["id"] . '">' . $row["name"] . "</div>";
						}
					}
				?>
					<div class="filter-element">None</div>
				</div>
			</div>

			<div class="filter-container" id="filter-topic">
				<div class="filter-button Topic">
					<p class="filter-text">Topic</p>
					<img src="edit.svg"/>
				</div>
				<div class="filter-content">
				<?php
					$result = $con->query("SELECT id, name FROM topic");

					if ($result->num_rows > 0) {
						// create option for each category type
						while($row = $result->fetch_assoc()) {
							echo '<div class = "filter-element ' . $row["id"] . '">' . $row["name"] . "</div>";
						}
					}
				?>
					<div class="filter-element">None</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card-container" id="card-container">
		<?php
			$result = $con->query("SELECT ann.Id as id, ann.Title as title, cat.Name as category, top.Name as topic, ann.Location as location, ann.Content as content, date(ann.Datetime) as date, day(ann.Datetime) as day, month(ann.Datetime) as month, date_format(ann.Datetime, '%l:%i %p') as time from Announcements as ann, Category as cat, Topic as top where ann.category_id=cat.id and ann.topic_id=top.id order by month, day, title");

			if (basename($_SERVER["REQUEST_URI"], ".php") == 'admin') $isAdmin = true;

			if ( $result->num_rows > 0 ){
				// echo "<table border='1'>";
				// echo "<tr><th>Title</th><th>Category</th><th>Topic</th></tr>";

				$index = 1;
				$prevDate = 0;
				$prevMoth = 0;
				$ended = false;
				while($row = $result->fetch_assoc()){
					$id = $row["id"];
					$title = $row["title"];
					$category = $row["category"];
					$topic = $row["topic"];
					$location = $row["location"];
					$time = $row["time"];
					$day = $row["day"];
					$month = $row["month"];
					$content = $row["content"];
					// echo "is" . $day . " = " . $prevDate;
					if ( $day != $prevDate || $month != $prevMonth ){
						if ( $ended ){
							echo '</div>';
							$ended = false;
						}

						echo '
							<div class="dates month_' . $month . '">
								<h4 class="date">' . $day . '</h4>';

						$ended = true;
					}

					echo '
						<div class="card">
							<p class="card-info card-category border">' . $category . '</p>
							<p class="card-info card-topic" style="display:inline-block;">' . $topic . '</p>
							<p class="card-title">' . $title . '</p>
							<p class="card-info card-setting">' . $time . '</p>
							<p class="card-info card-setting">' . $location . '</p>

							<p class="card-info" style="display: none;">' . $content . '</p>';

					if ($isAdmin) {
						echo '
							<div class="edit-btn" onclick="location.href=&quot;create.php?id=' . $id . '&quot;">
								<svg class="edit-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="620.969px" height="620.969px" viewBox="169.106 196.105 620.969 620.969" enable-background="new 169.106 196.105 620.969 620.969" xml:space="preserve">
									<path d="M657.573,467.129c-1.93-1.931-3.936-3.937-5.867-5.868c-1.561-1.56-3.119-3.12-4.605-4.605c-28.596-28.596-57.191-57.192-85.787-85.788c-10.473-10.473-21.02-20.945-31.492-31.493c-3.566-3.565-7.131-7.13-10.621-10.696c-3.492-3.491-6.982-6.981-10.475-10.473c-12.922,12.924-25.92,25.922-38.844,38.846c-18.718,18.717-37.435,37.435-56.152,56.152c-21.391,21.392-42.708,42.708-64.025,64.025c-21.316,21.316-42.633,42.633-63.95,63.951l-55.558,55.557c-12.999,12.998-25.997,25.996-38.995,38.994c-3.565,3.564-7.13,7.131-10.695,10.695c-4.085,4.084-7.65,7.354-7.874,14.039c-0.743,19.311,0,38.771,0.075,58.082c0,25.254,0.074,50.432,0.074,75.686c0,1.486,0,3.047,0,4.531c0,8.021,6.759,14.855,14.855,14.855c19.237,0,38.474,0,57.712,0.074c25.327,0,50.581,0.074,75.909,0.074c2.303,0,4.457,0.074,6.685-0.225c3.714-0.518,6.759-2.375,9.359-4.9c2.451-2.451,4.902-4.902,7.353-7.354c11.291-11.289,22.505-22.506,33.795-33.795c17.455-17.455,34.909-34.91,52.364-52.365c20.871-20.869,41.743-41.74,62.688-62.686c21.613-21.615,43.152-43.156,64.768-64.77c19.533-19.533,39.143-39.143,58.678-58.676c14.779-14.781,29.561-29.562,44.34-44.344c2.303-2.301,4.682-4.679,7.057-6.98C664.63,474.185,661.14,470.694,657.573,467.129z"/>
									<path d="M774.185,310.854c-5.793-5.793-11.586-11.587-17.455-17.455c-20.498-20.5-40.924-40.926-61.424-61.425c-6.314-6.313-12.701-12.627-19.016-19.015c-3.787-3.788-8.02-7.205-12.922-9.433c-13.074-5.942-29.34-5.794-41.447,2.6c-6.609,4.604-12.105,10.844-17.826,16.489c-9.58,9.582-19.162,19.163-28.744,28.744c-11.734,11.736-23.545,23.397-35.279,35.132l138.598,138.597c3.49,3.491,6.98,6.981,10.471,10.473l10.473,10.473c4.979-4.976,10.027-10.027,15.004-15.003c16.268-16.267,32.533-32.532,48.799-48.798c3.641-3.64,7.205-7.205,10.844-10.844c0.15-0.148,0.371-0.372,0.521-0.52c0.223-0.223,0.371-0.372,0.594-0.594C791.194,353.339,790.601,327.343,774.185,310.854z"/>
								</svg>
								Edit
							</div>';
					}

					echo '</div>';

					// echo $day;
					$prevDate = $day;
					$prevMonth = $month;
					}
					// echo "<tr>";
					// echo "<td>" . $row["title"] . "</td><td>" . $row["category"] . "</td><td>" . $row["topic"] . "</td>";
					// echo "</tr>";

					if ( $ended ){
						echo '</div>';
						$ended = false;

						$index++;
					}
				// echo "</table>";
				// }
			}
		?>
	</div>
</div>