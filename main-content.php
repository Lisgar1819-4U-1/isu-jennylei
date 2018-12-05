<div class="main-content" id="main-content">
	<h3 id="month">September</h3>

	<div class="card-container" id="card-container">
		<?php
			$result = $con->query("SELECT ann.Title as title, cat.Name as category, top.Name as topic, ann.Location as location, ann.Content as content, date(ann.Datetime) as date, day(ann.Datetime) as day, month(ann.Datetime) as month, date_format(ann.Datetime, '%l:%i %p') as time from Announcements as ann, Category as cat, Topic as top where ann.category_id=cat.id and ann.topic_id=top.id order by month, day, title");

			if ( $result->num_rows > 0 ){
				// echo "<table border='1'>";
				// echo "<tr><th>Title</th><th>Category</th><th>Topic</th></tr>";

				$index = 1;
				$prevDate = 0;
				$prevMoth = 0;
				$ended = false;
				while($row = $result->fetch_assoc()){
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

							<p class="card-info" style="display: none;">' . $content . '</p>
						</div>';
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