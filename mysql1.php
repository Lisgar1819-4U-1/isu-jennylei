<?php
echo "DB connection test<br/>";

$con = new mysqli("127.0.0.1", "root", "root", "announcements");
if ($con->connect_error) {
die("DB Connection failed : " . $con->connect_error);
}

$result = $con->query("select ans.Title as title, cat.Name as category, top.Name as topic, ans.Location as location, ans.Content as content, date(ans.Datetime) as date from Announcements as ans, Category as cat, Topic as top where ans.category_id='1' and ans.category_id=cat.id and ans.topic_id=top.id order by ans.Datetime");

if ( $result->num_rows > 0 ){
echo "<table border='1'>";
echo "<tr><th>Title</th><th>Category</th><th>Topic</th></tr>";

while($row = $result->fetch_assoc()){
echo "<tr>";
echo "<td>" . $row["title"] . "</td><td>" . $row["category"] . "</td><td>" . $row["topic"] . "</td>";
echo "</tr>";
}
echo "</table>";
} else {
echo "No result found!";
}


$data = "INSERT INTO announcements (title, category_id, topic_id, location, content, datetime) VALUES ('Test input', 1, 1, 'This is test location','This is a test input', now())";
if($con->query($data) === true)
	echo "ADDEDDDDDD";

$con->close();
?>