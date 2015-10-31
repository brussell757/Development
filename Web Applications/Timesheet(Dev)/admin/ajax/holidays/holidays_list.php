<?php // SECTION DISPLAYS JOBS
require '../../../php_scripts/session.php';

$query = "SELECT * FROM `holidays` ORDER BY `date` DESC";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
?>
   <div class="holidays" id="holiday_<?=$row['id'];?>">
      <span class="label" title="<?=$row['name'];?>"><?=$row['name'];?></span>
      <input title="Delete Holiday" type="image" class="icon"  src="../../images/delete.png" alt="Delete Holiday" onclick="delete_holiday('<?=$row['id'];?>')">
      <div class="dates">
        <span title="Date"><?=$row['date'];?></span>
      </div>
  </div> 
<?php
}
?> 