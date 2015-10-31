<?php
require '../../../php_scripts/session.php';

$id = $_POST['id'];

if(isset($id)) {
	$query = "SELECT `delivery_order` FROM `jobs` WHERE `delivery_order` = '$id'";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	if($id === $row['delivery_order']) {
		echo "true";	
	} else {
		$mysqli->query("DELETE FROM `delivery_orders` WHERE `id`='$id'");
	}
}
?>