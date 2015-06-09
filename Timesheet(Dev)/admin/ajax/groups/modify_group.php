<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

$group_name = $_POST['group_name'];
$group_name = $mysqli->real_escape_string($group_name);

$create = $_POST['create'];

if($create) {
	$mysqli->query("UPDATE `groups` SET `group_name` = '$group_name' WHERE `id` = '$id'");
	echo "true";
}
?>