<?php
require '../../../php_scripts/session.php';
?>
  <script type="text/javascript">
  $(function() {
      $(".datepicker").datepicker({
          dateFormat: "yy-mm-dd",
          showAnim: "slide",
      });
  });
  </script>
  
  <div id="create_holiday">
      <div class="buttons">
          <input title="Create Holiday" type="button" class="add_icon" alt="Create"  onclick="validate_form()">
          <input title="Cancel" type="button" class="cancel_icon" alt="Cancel" onclick="cancel_create_holiday()">
      </div>
      <table>
      <tr>  
          <td>Holiday Name: <br /><input type="text" id="holiday_name" autocomplete="off"><br /></td>
          <td>Date: <br /><input class="holiday_date datepicker" type="text" id="holiday_date" autocomplete="off"><br /></td>
      </tr>
      </table>
  </div>
  
<?php // SECTION DISPLAYS JOBS
$query = "SELECT * FROM `holidays` ORDER BY `date` DESC";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
?>
      <div class="holidays" id="holiday_<?=$row['id'];?>">
        <span class="label" title="<?=$row['name'];?>"><?=$row['name'];?></span>
        <input title="Delete Holiday" type="image" class="icon"  src="../../images/delete.png" alt="Delete Job" onclick="delete_holiday('<?=$row['id'];?>')">
        <div class="dates">
          <span title="Date"><?=$row['date'];?></span>
        </div>
      </div>  
<?php
}
?> 