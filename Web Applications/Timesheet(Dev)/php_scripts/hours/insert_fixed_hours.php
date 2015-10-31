<?php
require '../db_connect.php';

$emp_id = $_POST['emp_id'];
$fixed_job_id = $_POST['fixed_job_id'];
$date = $_POST['date'];
$hours = $_POST['hours'];

if(isset($emp_id) && isset($fixed_job_id) && isset($date) && isset($hours)) {
	$query = "SELECT `hours` FROM `fixed_hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$fixed_job_id' AND `date` = '$date'";
	$results = $mysqli->query($query);
	while($row = $results->fetch_array(MYSQLI_BOTH)){
		$hours_exist = $row['hours'];	
	}
	
	if($hours_exist)
	{	
		if($hours == 0) {
			$mysqli->query("DELETE FROM `fixed_hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$fixed_job_id' AND `date` = '$date'");
		} else {
			$mysqli->query("UPDATE `fixed_hours` SET `hours` = '$hours' WHERE `emp_id` = '$emp_id' AND `job_id` = '$fixed_job_id' AND `date` = '$date'");
		}
	} else if (!$hours_exists) {
		if($hours == 0) {
			$mysqli->query("DELETE FROM `fixed_hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$fixed_job_id' AND `date` = '$date'");
		} 
		else {
			$mysqli->query("INSERT INTO `fixed_hours` (`id`, `emp_id`, `job_id`, `date`, `hours`)
						   VALUES ( NULL, '$emp_id', '$fixed_job_id', '$date', '$hours')");
		}
	}
} else {
	echo "Access Denied!";
	die();	
}
?>