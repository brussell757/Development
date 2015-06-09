<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$emp_id = $_POST['emp_id'];
$emp_id = substr($emp_id,1);

if(isset($id) && isset($emp_id)) {
	$mysqli->query("DELETE FROM `group_members` WHERE `group_id` = '$id' AND `emp_id` = '$emp_id'");
}
?>