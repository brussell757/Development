<?php
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];
$emp_num = $_POST['emp_num'];

if(isset($emp_id) && isset($emp_num)) {
	$query = "SELECT `emp_num` FROM `employees`";
	$results = $mysqli->query($query);
	
	// TESTS IF EMPLOYEE NUMBER EXISTS
	while($row = $results->fetch_array(MYSQLI_BOTH))
	{	
		$emp_num_array[] = $row['emp_num'];
		$emp_num_array = array_values(array_filter($emp_num_array));
	}
	
	if(in_array($emp_num, $emp_num_array)){
		echo "true";
	} else if(empty($emp_num)) {
		$mysqli->query("UPDATE `employees` SET `emp_num` = NULL WHERE `id` = '$emp_id'");
	} else if($emp_num != $row['emp_num']){
		$mysqli->query("UPDATE `employees` SET `emp_num` = '$emp_num' WHERE `id` = '$emp_id'");
	}
}
?>