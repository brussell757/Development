<?php
require '../../../php_scripts/session.php';

$job_code = $_POST['job_code'];
$job_code = $mysqli->real_escape_string($job_code);

if(isset($job_code)) {
	$query = "SELECT `job_id` FROM `jobs` WHERE `job_id` = '$job_code'";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['job_id'] === $job_code) {
		echo "true";
	} else if ($row['job_id'] != $job_code) {
		echo "false";
	}
}
?>