<?php
require '../../../php_scripts/session.php';

$emp_id = $_POST['emp_id'];
if(isset($emp_id)) {
$mysqli->query("UPDATE `employees` SET `admin` = 0 WHERE `id` = $emp_id");
}
?>