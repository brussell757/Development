<?php
require '../../../php_scripts/session.php';
?>

<div id="create_group">
    <div class="buttons">
        <input title="Create Group" type="button" class="add_icon" alt="Create"  onclick="validate_form()">
        <input title="Cancel" type="button" class="cancel_icon" alt="Cancel" onclick="cancel_create_group()">
    </div>
    <table>
    <tr>  
        <td>Group Name: <br /><input type="text" id="group_name" autocomplete="off"><br /></td>
    </tr>
    </table>
</div>

<?php // SECTION DISPLAYS JOBS
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