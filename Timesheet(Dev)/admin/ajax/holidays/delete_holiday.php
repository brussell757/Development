<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {
	// DELETES JOB FROM DATABASE
	$mysqli->query("DELETE FROM `holidays` WHERE `id`='$id'");
}
?>