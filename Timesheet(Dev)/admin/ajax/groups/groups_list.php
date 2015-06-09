<?php // SECTION DISPLAYS GROUPS
require '../../../php_scripts/session.php';

$query = "SELECT * FROM `groups` ORDER BY `group_name`";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
?>
<div class="groups" id="groups_<?=$row['id'];?>">
  <span class="label" title="<?=$row['group_name'];?>"><?=$row['group_name'];?></span>
  <input title="Delete Group" type="image" class="icon"  src="../../images/delete.png" alt="Delete Group" onclick="delete_group('<?=$row['id'];?>')">      
  <a href="ajax/groups/edit_group.php?id=<?=$row['id'];?>"></a>
</div> 
<?php
}
?> 