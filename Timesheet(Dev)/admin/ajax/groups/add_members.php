<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$emp_id = $_POST['emp_id'];

if(isset($id) && isset($emp_id)) {
	$query = "SELECT * FROM `group_members` WHERE `group_id` = '$id'";
	$results = $mysqli->query($query);
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		$member_exists = $row['emp_id'];	
	}
	
	if($emp_id == $member_exists) {
		exit();	
	} else {
		$mysqli->query("INSERT INTO `group_members` (`id`, `emp_id`, `group_id`)
						VALUES (NULL, '$emp_id', '$id')");
	}
}
?>