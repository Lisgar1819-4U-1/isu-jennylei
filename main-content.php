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