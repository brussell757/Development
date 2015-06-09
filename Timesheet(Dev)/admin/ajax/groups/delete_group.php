<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {	
	// DELETES GROUP FROM DATABASE
	$mysqli->query("DELETE FROM `group_members` WHERE `group_id` = '$id'");
	$mysqli->query("DELETE FROM `groups` WHERE `id` = '$id'");
}
?>