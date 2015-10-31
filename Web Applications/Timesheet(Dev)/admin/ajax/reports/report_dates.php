<?php
require '../../../php_scripts/session.php';

$period_id = $_POST['period_id'];

if(isset($period_id)) {
  $result = $mysqli->query("SELECT *  FROM `pay_periods` WHERE `id` = '$period_id' LIMIT 1");
  $row = $result->fetch_array(MYSQLI_BOTH);
  
  $period_sd = $row['start_date'];
  $period_sd = date('m/d/Y', strtotime($period_sd));
  $period_ed = date('m/d/Y', strtotime($period_sd. ' + 13 days'));
  
  echo $period_sd . "," . $period_ed;
}
?>