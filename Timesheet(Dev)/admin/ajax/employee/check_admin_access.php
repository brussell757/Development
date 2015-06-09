<?php
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];

if(isset($emp_id)) {
	$query = "SELECT `admin` FROM `employees` WHERE `id` = $emp_id";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['admin'] == 1) {
		echo "true";	
	} else if ($row['admin'] == 0) {
		echo "false";	
	}
}
?>