<?php
require '../../../php_scripts/session.php';

$group_name = $_POST['group_name'];

if(isset($group_name)) {	
	$query = "SELECT `group_name` FROM `groups` WHERE `group_name` = '$group_name'";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['group_name'] === $group_name) {
		echo "true";
	} else if ($row['group_name'] != $group_name) {
		echo "false";
	}
}
?>