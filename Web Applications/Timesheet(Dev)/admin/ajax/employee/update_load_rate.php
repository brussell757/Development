<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$emp_id = $_POST['emp_id'];
$load_rate = $_POST['load_rate'];

if(isset($id) && isset($emp_id) && isset($load_rate)) {
	$query = "SELECT * FROM `rates` WHERE `id` = '$id' AND `emp_id` = '$emp_id'";
	$results = $mysqli->query($query);
	
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		$rate_exists = $row['load_rate'];	
	}
	
	if(!isset($rate_exists))
	{
		$mysqli->query("INSERT INTO `rates` (`id`, `emp_id`, `load_rate`)
						VALUES (NULL, '$emp_id', '$load_rate')");
	} else if ($load_rate == 0 || $load_rate == '') {
		$mysqli->query("DELETE FROM `rates` WHERE `id` = '$id'");
	} else if($load_rate != NULL) {
		$mysqli->query("UPDATE `rates` SET `load_rate` = '$load_rate' WHERE `id` = '$id' AND `emp_id` = '$emp_id'");
	}
}
?>