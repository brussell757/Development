<?php
require '../../../php_scripts/session.php';

$holiday_name = $_POST['holiday_name'];
$holiday_name = $mysqli->real_escape_string($holiday_name);
$holiday_date = $_POST['holiday_date'];
$create = $_POST['create'];

if($create) {
	$mysqli->query("INSERT INTO `holidays` (`id`, `date`, `name`)
				    VALUES ( NULL, '$holiday_date', '$holiday_name')");
	echo "true";
}
?>