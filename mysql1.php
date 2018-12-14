<?php
echo "DB connection test<br/>";

$con = new mysqli("127.0.0.1", "root", "root", "announcements");
if ($con->connect_error) {
die("DB Connection failed : " . $con->connect_error);
}

$result = $con->query("SELECT ann.id as Id, ann.Title as title, cat.Name as category, top.Name as topic, ann.Location as location, ann.Content as content, date(ann.Datetime) as date, day(ann.Datetime) as day, month(ann.Datetime) as month, date_format(ann.Datetime, '%l:%i %p') as time from Announcements as ann, Category as cat, Topic as top where ann.category_id=cat.id and ann.topic_id=top.id order by month, day, title");

if ( $result->num_rows > 0 ){
echo "<table border='1'>";
echo "<tr><th>Id</th><th>Title</th><th>Category</th><th>Topic</th><th>Month</th><th>Date</th></tr>";

while($row = $result->fetch_assoc()){
echo "<tr>";
echo "<td>" . $row["Id"] . "</td><td>" . $row["title"] . "</td><td>" . $row["category"] . "</td><td>" . $row["topic"] . "</td><td>" . $row["month"] . "</td><td>" . $row["date"] . "</td>";
echo "</tr>";
}
echo "</table>";
} else {
echo "No result found!";
}


//$data = "INSERT INTO announcements (title, category_id, topic_id, location, content, datetime) VALUES ('Test input', 1, 1, 'This is test location','This is a test input', now())";
//if($con->query($data) === true)
//	echo "ADDEDDDDDD";

$con->close();
?>