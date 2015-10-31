<?php
require '../../../php_scripts/session.php';

$group_id = $_POST['group_id'];
$emp_id = $_POST['emp_id'];

if(isset($group_id) && isset($emp_id)) {
	$query = "SELECT * FROM `group_members` WHERE `group_id` = '$group_id'";
	$results = $mysqli->query($query);
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		$member_exists = $row['emp_id'];	
	}
	
	if($emp_id == $member_exists || $group_id == 00) {
		exit();	
	} else {
		$mysqli->query("INSERT INTO `group_members` (`id`, `emp_id`, `group_id`)
						VALUES (NULL, '$emp_id', '$group_id')");
	}	
}
?>