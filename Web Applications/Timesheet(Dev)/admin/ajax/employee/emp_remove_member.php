<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];
$emp_id = $_POST['emp_id'];

if(isset($emp_id) && isset($id)) {
$mysqli->query("DELETE FROM `group_members` WHERE `group_id` = '$id' AND `emp_id` = '$emp_id'");
}
?>