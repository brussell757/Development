<?php
require '../../../php_scripts/session.php';

$group_name = $_POST['group_name'];
$group_name = $mysqli->real_escape_string($group_name);

$create = $_POST['create'];

if($create) {
	$mysqli->query("INSERT INTO `groups` (`id`, `group_name`)
				    VALUES ( NULL, '$group_name')");
	echo "true";
}
?>