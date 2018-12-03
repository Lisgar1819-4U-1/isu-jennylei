<?php
			//echo "DB connection test<br/>";

			$con = new mysqli("127.0.0.1", "root", "root", "announcements");
			if ($con->connect_error) {
			die("DB Connection failed : " . $con->connect_error);
			}

			date_default_timezone_set('US/Eastern');
		?>
