<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {
	// DELETES JOB FROM DATABASE
	$query = "SELECT * FROM `employee_jobs` WHERE `job_id` = '$id'";
	$results = $mysqli->query($query);
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		if($results->num_rows != 0) {
			$mysqli->query("UPDATE `jobs` SET `end_date` = CURDATE() - 1 WHERE `id`='$id'");
			$mysqli->query("UPDATE `employee_jobs` SET `end_date` = CURDATE() - 1 WHERE `job_id`='$id'");
		} 
	}
	if($results->num_rows === 0)
	{
		$mysqli->query("DELETE FROM `jobs` WHERE `id`='$id'");
	}
}
?>