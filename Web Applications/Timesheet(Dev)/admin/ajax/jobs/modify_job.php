<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

$job_code = $_POST['job_code'];
$job_code = $mysqli->real_escape_string($job_code);

$job_title = $_POST['job_title'];
$job_title = $mysqli->real_escape_string($job_title);

$company = $_POST['company'];
$company = $mysqli->real_escape_string($company);

$start = $_POST['start'];
$end = $_POST['end'];
$fund = $_POST['fund'];
$profit = $_POST['profit'];
$order = $_POST['order'];
$create = $_POST['create'];

if($create) {
	$mysqli->query("UPDATE `jobs` SET `job_id` = '$job_code', `job_title` = '$job_title', `company` = '$company', `start_date` = '$start', `end_date` = '$end', 
				   `funding` = '$fund', `profit` = '$profit', `delivery_order` = '$order' WHERE `id` = '$id'");
	echo "true";
}
?>