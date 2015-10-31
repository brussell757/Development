<?php
require '../../../php_scripts/session.php';

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
	$mysqli->query("INSERT INTO `jobs` (`id`, `job_id`, `job_title`, `company`, `start_date`, `end_date`, `funding`, `profit`, `delivery_order`)
				    VALUES ( NULL, '$job_code', '$job_title', '$company', '$start', '$end', '$fund', '$profit', '$order')");
	echo "true";
}
?>