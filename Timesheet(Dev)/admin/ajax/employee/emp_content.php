<?php 
require '../../../php_scripts/session.php';

if ($_POST['emp_id'] == "00") {
	exit(); 
}
?>

<?php if(isset($_POST['emp_id'])) {?>
<script type="text/javascript">
$(function() {
    $(".datepicker").datepicker({
		dateFormat: "yy-mm-dd",
		showAnim: "slide"
	});
});
</script>

<script>
// RUNS ISNUMBER FUNCION WHEN KEY PRESSED
$(document).ready(function() {
    $(".valid_numbers").keypress(function(event) { return isNumber(event) });
});

// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)){
		 return false;
	}
 	return true;
}    
</script>

<?php // SECTION PULLS EMPLOYEE NUM 
	
	$emp_id = $_POST['emp_id'];
	$query = "SELECT * FROM `employees` WHERE `id` = '$emp_id' LIMIT 1";
	$results = $mysqli->query($query);
	while($row = $results->fetch_array(MYSQLI_BOTH)) {
		$emp_num = $row['emp_num'];
		
		$query = "SELECT * FROM `rates` WHERE `emp_id` = '$emp_id'";
		$res = $mysqli->query($query);
		while($row = $res->fetch_array(MYSQLI_BOTH)) {
			$load_rate = $row['load_rate'];	
			$id = $row['id'];
		}
	}
?>
<div id="emp_jobs_header">

  <label for="emp_timsheet" class="emp_timesheet_label">View Timesheet :</label>
  <form>
      <select id="timesheet_periods" class="emp_timesheet">
          <?php //Populate drop down list w/ employee names from active directory
                  $query = "SELECT * FROM `pay_periods` ORDER BY `start_date` DESC";
                  $result = $mysqli->query($query);
    
                  while($pay_row = $result->fetch_array(MYSQLI_ASSOC)) {
                      $period_id = $pay_row['id'];
                      $start_date = $pay_row['start_date'];
                      $start_date = date('m/d/Y', strtotime($start_date));
                      $end_date = date('m/d/Y', strtotime($start_date. ' + 13 days'));
                      $options = "<option value=" . $period_id .">" . $start_date . ' - ' . $end_date .  "</option>";
                      echo $options; 
                  }
           ?> 
      </select>
      <a onclick="view_emp_timesheet('<?=$emp_id;?>')">Go</a>
  </form>
   
  <label for="emp_num" class="emp_num_label">Employee # :</label>
  <input id="emp_num" class="valid_numbers emp_num" type="text" value="<?=$emp_num;?>" onchange="update_emp_num()" autocomplete="off">
  
  <label for="load_rate" class="load_rate_label">Loaded Rate :</label>
  <input id="load_rate" class="valid_numbers load_rate" type="text" value="<?='$'. $load_rate;?>" onchange="add_curr(); update_load_rate('<?=$id?>')" autocomplete="off">
  
  
  <label for="disable_emp" class="disable_emp">Disable :</label>
  <input type="checkbox" class="disable_emp_box" id="disable_box" onchange="change_emp_status('<?=$emp_id;?>')">
  

  <label for="admin_access" class="admin_access">Administrator :</label>
  <input type="checkbox" class="admin_access_box" id="admin_box" onchange="change_admin_status('<?=$emp_id;?>')">
  
  <h3>Active Jobs: <button type="submit" class="add_button" onclick="display_add_job()">+ Add</button></h3>
</div>
<div id="emp_jobs">

<?php // SECTION DISPLAYS EACH EMPLOYEES ACTIVE JOBS
	$query = "SELECT * FROM `employee_jobs` WHERE `emp_id` = '$emp_id' AND `start_date` <= CURDATE() AND `end_date` >= CURDATE() ORDER BY `end_date`";
	$results = $mysqli->query($query);
	while ($row = $results->fetch_array(MYSQLI_BOTH)) {
		$query = "SELECT * FROM `jobs` WHERE `id` = '$row[job_id]' LIMIT 1";
		$res = $mysqli->query($query);
		$array = $res->fetch_array(MYSQLI_BOTH);
?>
	
  <div class="job">
    <span class="label" title="<?=$array['job_id'];?> - <?=$array['job_title'];?>"><?=$array['job_id'];?> - <?=$array['job_title'];?></span>
      <input title="Remove Job" type="image" class="icon" id="remove_<?=$row['id'];?>" src="../../images/delete.png" alt="Remove Job" onclick="remove_job('<?=$row['id'];?>')">
      <input title="Update Dates" type="image" class="icon update" id="update_<?=$row['id'];?>" src="../../images/update.png" alt="Update Dates" onclick="active_dates('<?=$row['id'];?>')">
    <div class="dates">
      <input title="Start Date" class="editable_start datepicker" id="active_start_date_<?=$row['id'];?>" onchange="update_dates('<?=$row['id'];?>');" value="<?=$row['start_date'];?>" type="text">
      ---
      <input title="End Date" class="editable_end datepicker" id="active_end_date_<?=$row['id'];?>"  onchange="update_dates('<?=$row['id'];?>');" value="<?=$row['end_date'];?>" type="text">
    </div>
  </div>
  
<?php
}
?>
  
	<div id="job_list"><!-- END JOB_LIST DIV-->
   		<div class="job">
     		<select id="avaliable_jobs" onchange="job_dates()">
       			<option value="00">Select a Job Code/Title</option>
                    
<?php // SECTION LISTS AVALIABLE JOBS IN DROPDOWN MENU
	$query = "SELECT * FROM `jobs` WHERE `start_date` <= CURDATE() AND `end_date` >= CURDATE() ORDER BY `id` DESC";
	$results = $mysqli->query($query);

	while($row = $results->fetch_array(MYSQLI_ASSOC)) {
		$id = $row['id'];
		$job_code = $row['job_id'];
		$job_title = $row['job_title'];
		$options = "<option value=" . $id .">" . $job_code . " - " . $job_title . "</option>";
		echo $options; 
	}
?>               
     		</select>
            <input title="Add Job" type="image" class="icon" src="../images/add.png" alt="Add Job" onclick="add_job()">
  	 		<div class="dates">
                <input title="Start Date" class="editable_start datepicker" id="start_date"  type="text">
                ---
                <input title="End Date" class="editable_end datepicker" id="end_date" type="text">
     		</div>
  		</div>
	</div><!-- END JOB_LIST DIV-->
    
	<div id="inactive_jobs"><!-- START INACTIVE JOBS DIV-->
		<a id="archives_link" href="#archives" onclick="view_archives()">Show Inactive Jobs</a>
    </div><!-- END INACTIVE JOBS DIV-->
    
</div> <!-- END JOBS DIV-->


<div id="emp_groups_header">  
  <h3>Member Of: <button type="submit" onclick="display_add_group()">+ Add</button></h3>
</div>

<div id="emp_groups"><!-- START EMP_GROUPS DIV-->
<?php // SECTION DISPLAYS EACH EMPLOYEES ACTIVE JOBS
$query = "SELECT `group_id` FROM `group_members` WHERE `emp_id` = '$emp_id'";
$results = $mysqli->query($query);
while ($row = $results->fetch_array(MYSQLI_BOTH)) {
	$query = "SELECT * FROM `groups` WHERE `id` = '$row[group_id]' LIMIT 1";
	$res = $mysqli->query($query);
	$array = $res->fetch_array(MYSQLI_BOTH);
?>
 <div class="groups" id="groups_<?=$array['id'];?>"><!-- START GROUPS DIV-->
      <span class="label" title="<?=$array['group_name'];?>"><?=$array['group_name'];?></span>
      <input title="Remove From Group" type="image" class="icon"  src="../../images/delete.png" alt="Remove from group" onclick="remove_members('<?=$array['id'];?>','<?=$emp_id;?>')">      
 </div><!-- END GROUPS DIV-->
<?php
}
?>

<div id="group_list"><!-- START GROUP_LIST DIV-->
   	<div class="groups"><!-- START GROUP DIV-->
     	<select id="avaliable_groups" >
       		<option value="00">Select a Group</option>            
<?php // SECTION LISTS AVALIABLE JOBS IN DROPDOWN MENU
	$query = "SELECT * FROM `groups` WHERE `id` != '$array[id]' ORDER BY `id` DESC";
	$results = $mysqli->query($query);

	while($row = $results->fetch_array(MYSQLI_ASSOC)) {
		$id = $row['id'];
		$group_name = $row['group_name'];
		$options = "<option value=" . $id .">" . $group_name . "</option>";
		echo $options; 
	}
?>               
     	</select>
        <input title="Add Group" type="image" class="icon" src="../images/add.png" alt="Add Group" onclick="add_group()">
  	</div><!-- END GROUPS DIV-->
</div><!-- END GROUP_LIST DIV-->
</div><!-- END EMP_GROUPS DIV-->
<?php
}
?>