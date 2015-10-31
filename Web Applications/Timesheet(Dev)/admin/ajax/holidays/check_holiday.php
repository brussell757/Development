<?php
require '../../../php_scripts/session.php';

$date = $_POST['date'];

$query = "SELECT * FROM `holidays` ORDER BY `date` DESC";
$results = $mysqli->query($query);
while($row = $results->fetch_array(MYSQLI_BOTH)) {
	if($row['date'] == $date) {
		echo "true";	
	}
}
?>