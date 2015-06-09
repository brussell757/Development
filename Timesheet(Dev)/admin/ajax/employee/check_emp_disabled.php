<?php
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];

if(isset($emp_id)) {
	$query = "SELECT `active` FROM `employees` WHERE `id` = $emp_id";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['active'] == 0) {
		echo "true";	
	} else if ($row['active'] == 1) {
		echo "false";	
	}
}
?>