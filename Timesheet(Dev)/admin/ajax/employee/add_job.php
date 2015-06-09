<?php
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];
$job_id = $_POST['job_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

if(isset($emp_id) && isset($job_id) && isset($start_date) && isset($end_date)) {
	// SELECTS JOBS THAT HAVE SAME ID AS ID PASSED
	$query = "SELECT * FROM `jobs` WHERE `id` = '$job_id' LIMIT 1";
	$results = $mysqli->query($query);
	
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		// INSERTS JOBS INTO EMPLOYEE_JOBS TABLE
		$insert = "INSERT INTO `employee_jobs` (`id`, `emp_id`, `job_id`, `start_date`, `end_date`) 
		VALUES (NULL, '$emp_id', '$job_id', '$start_date', '$end_date')";
		$mysqli->query($insert);
	}
}
?>