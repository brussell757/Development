<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {
	$query = "SELECT * FROM `group_members` WHERE `group_id` = '$id'";
	$results = $mysqli->query($query);
	$count_rows = $results->num_rows;
	
	echo $count_rows;
}
?>