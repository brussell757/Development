<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$group_name = $_POST['group_name'];
$group_name = $mysqli->real_escape_string($group_name);

if(isset($id) && isset($group_name)) {	
	$query = "SELECT `group_name` FROM `groups` WHERE `group_name` = '$group_name' AND `id` != '$id'";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['group_name'] === $group_name) {
		echo "true";
	} else if ($row['group_name'] != $group_name) {
		echo "false";
	}
}
?>