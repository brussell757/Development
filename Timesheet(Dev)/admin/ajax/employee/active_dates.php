<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

if(isset($id) && isset($start_date) && isset($end_date)) {
	// SETS START/END DATES TO WHAT USER INSERTS
	if($start_date < $end_date)
	{
		$mysqli->query("UPDATE `employee_jobs` SET `start_date` = '$start_date' , `end_date` = '$end_date' WHERE `id` = '$id' LIMIT 1");
	} else {
		echo "true";	
	}
}
?>