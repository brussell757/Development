<?php
require '../../../php_scripts/session.php';

$order_name = $_POST['order_name'];
$order_name = $mysqli->real_escape_string($order_name);

if(isset($order_name)) {
	$query = "SELECT `name` FROM `delivery_orders` WHERE `name` = '$order_name'";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($row['name'] === $order_name) { 
		echo "true";
	} else if ($row['name'] != $order_name) {
		echo "false";
	}
}
?>