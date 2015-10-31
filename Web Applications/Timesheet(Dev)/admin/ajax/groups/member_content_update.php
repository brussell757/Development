<?php
require '../../../php_scripts/session.php';
?>

<div id="current_employees">
<b>Remove Members:</b>

<?php
$group_id = $_POST['id'];

$query = "SELECT * FROM `group_members` WHERE `group_id` = '$group_id'";
$group_results = $mysqli->query($query);

while($group_row = $group_results->fetch_array(MYSQLI_BOTH)) {
  $member_id = $group_row['emp_id'];	
  $member_array[] = $group_row['emp_id'];
  
  $query = "SELECT * FROM `employees` WHERE `id` = '$member_id'";
  $member_results = $mysqli->query($query);
  
  while($member_row = $member_results->fetch_array(MYSQLI_BOTH)) {
      $first_name['A'.$member_id] = $member_row['first_name'];		  
      $last_name['A'.$member_id] = $member_row['last_name'];
      
  }
}
array_multisort ($last_name, $first_name);

foreach($last_name as $key => $value) {	
?>

  <ul>
      <li onclick="remove_members('<?=$group_id;?>','<?=$key;?>')"><?=$value . ", " . $first_name[$key];?></li>
  </ul>
  
<?php
}
?>

</div>

<div id="add_employees">
<b>Add Members:</b>

<?php
if(count($member_array) >= 0) {
  $last = array_pop($member_array);
  foreach($member_array as $curr_member_id) {
      if($curr_member_id != $last) {
          $exclude_list .= "'".$curr_member_id."', ";	
      }
  }
  $exclude_list .= "'".$last."'";
}

$query = "SELECT * FROM `employees` WHERE `id` NOT IN ({$exclude_list}) AND `active` = '1' ORDER BY `last_name`, `first_name`";
$add_results = $mysqli->query($query);

while($add_row = $add_results->fetch_array(MYSQLI_BOTH)) {	
    $add_first_name = $add_row['first_name'];
    $add_last_name = $add_row['last_name'];
?>

  <ul>
      <li onclick="insert_members('<?=$group_id;?>','<?=$add_row['id'];?>')"><?=$add_last_name . ", " . $add_first_name;?></li>
  </ul>
  
<?php
}
?>	
			
</div>