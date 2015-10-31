<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
if(isset($id)) {
	// SETS END DATE TO DAY BEFORE CURRENT DATE AND REMOVES JOB FROM ACTIVE JOBS
	$mysqli->query("UPDATE `employee_jobs` SET `end_date` = CURDATE() -1 WHERE `id` = '$id' LIMIT 1");
}
?>