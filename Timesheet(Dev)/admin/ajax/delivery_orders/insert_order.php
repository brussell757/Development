<?php
require '../../../php_scripts/session.php';

$order_name = $_POST['order_name'];
$order_name = $mysqli->real_escape_string($order_name);
$create = $_POST['create'];

if($create) {
	$mysqli->query("INSERT INTO `delivery_orders` (`id`, `name`)
				    VALUES ( NULL, '$order_name')");
	echo "true";
}
?>