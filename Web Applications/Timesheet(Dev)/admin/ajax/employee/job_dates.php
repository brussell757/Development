<?php 
require '../../../php_scripts/session.php';

if($_POST['job_id'] == "00") { 
   echo ","; exit(); 
} 

$job_id = $_POST['job_id'];

if(isset($job_id)) {
  $result = $mysqli->query("SELECT `start_date`,`end_date` FROM `jobs` WHERE `id` = '$job_id' LIMIT 1");
  $row = $result->fetch_array(MYSQLI_BOTH);
  echo $row['start_date'] . "," . $row['end_date'];
}
?>