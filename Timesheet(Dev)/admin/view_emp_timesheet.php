<?php  // PULLS DATA FROM EMPLOYEES TABLE
require '../php_scripts/db_connect.php';

$emp_id = $_POST['emp_id']; // FROM JAVASCRIPT FUNCTION IN EMPLOYEE_FUNCTIONS

$query = "SELECT * FROM `employees` WHERE `id` = '$emp_id'";
$results = $mysqli->query($query);
$emp_row = $results->fetch_array(MYSQLI_BOTH);
?>

<?php // PULLS EMPLOYEE NUMBER AND LOAD RATE OF SELECTED EMPLOYEE
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

<script type='text/javascript'>
/*********************************************************************************START SCRIPTS ************************************************************************************/
// NAVITGATE TABLE USING ARROW KEYS
function nav_table() {
  $('.table input').keyup(function (e) {
 
    if (e.which == 39) { // right arrow
      $(this).closest('td').next().find('input').focus();
 
    } else if (e.which == 37) { // left arrow
      $(this).closest('td').prev().find('input').focus();
 
    } else if (e.which == 40) { // down arrow
      $(this).closest('tr').next().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();
 
    } else if (e.which == 38) { // up arrow
      $(this).closest('tr').prev().find('td:eq(' + $(this).closest('td').index() + ')').find('input').focus();
    }
 }); 
}

/*******************************************************************************************************************************/
// RUNS ISNUMBER FUNCION WHEN KEY PRESSED
$(document).ready(function() {
	$(".table input").keypress(function(event) { return isNumber(event) });
	
});

/*******************************************************************************************************************************/
// THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
function isNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)){
		 return false;
	}
	return true;
}

/*******************************************************************************************************************************/
// FUNCTION THAT UPDATES TOTAL HOURS FOR CONTRACTS
function updateHourTotals(job_id) {
	var dates = []; // SETS DATES AS AN ARRAY
<?php
$jsDate = new DateTime($start_date);
$i=0;
while ($i <= 13) { // LOOP THAT PUSHES A DATE TO THE DATES ARRAY 
?>

	dates.push('<?=$jsDate->format('Y-m-d');?>');
	
<?php
$i++;
$jsDate->modify('+1 day');
}
?>
	
	var totalHours = 0;
	
	for (i = 0; i < dates.length; i++) {
	  var elementId = 'hours_' + job_id + "_" + dates[i]; // SETS ID
	  
	  var hrs = document.getElementById(elementId).value; // GETS VALUE OF ELEMENT WITH ID LISTED ABOVE

	  if (hrs == parseInt(hrs)) { // IF HRS IS AN INT ADDS HRS TO TOTALHOURS
		  hrs = parseInt(hrs); // SETS HRS TO AN INT
		  totalHours = totalHours + hrs;
	  }	else if (hrs == parseFloat(hrs)) {
		  hrs = parseFloat(hrs);
		  totalHours = totalHours + hrs;
	  }
	}
	if (totalHours == 0) { // IF TOTALHOURS IS 0 SETS TOTALHOURS TO BLANK VALUE
	  totalHours = "";
	}
	document.getElementById('total_hours_' + job_id).innerHTML = totalHours;		
}

/*******************************************************************************************************************************/
// FUNCTION THAT UPDATES TOTAL HOURS FOR FIXED JOBS
function updateHourTotalsFixed(job_id) {
	var dates = []; // SETS DATES AS AN ARRAY
	
<?php
$jsDate = new DateTime($start_date);
$i=0;
while ($i <= 13) { // LOOP THAT PUSHES A DATE TO THE DATES ARRAY 
?>

	dates.push('<?=$jsDate->format('Y-m-d');?>');
	
<?php
$i++;
$jsDate->modify('+1 day');
}
?>
	var totalHours = 0;
	
	for (i = 0; i < dates.length; i++) {
	  var fixed_elementId = 'fixed_hours_' + job_id + "_" + dates[i]; // SETS ID
	  
	  var hrs = document.getElementById(fixed_elementId).value; // GETS VALUE OF ELEMENT WITH ID LISTED ABOVE
		
	  if (hrs == parseInt(hrs)) { // IF HRS IS AN INT ADDS HRS TO TOTALHOURS
		  hrs = parseInt(hrs); // SETS HRS TO AN INT
		  totalHours = totalHours + hrs;
	  }	else if (hrs == parseFloat(hrs)) {
		  hrs = parseFloat(hrs);
		  totalHours = totalHours + hrs;
	  }
	}
	if (totalHours == 0) { // IF TOTALHOURS IS 0 SETS TOTALHOURS TO BLANK VALUE
	  totalHours = "";
	}
	document.getElementById('fixed_total_hours_' + job_id).innerHTML = totalHours;		
}

/*******************************************************************************************************************************/
// FUNCTION THAT UPDATES DAILY TOTAL HOURS
function updateDailyTotalHours(date) {
	var totalHours = 0;
	var job_ids = $('.' + date + '_daily_hours').map(function() { return this.id; }).get();
	for (i=0; i < job_ids.length; i++) {
		
	  var hrs = document.getElementById(job_ids[i]).value; // GETS VALUE OF ELEMENT 
		
	  if (hrs == parseInt(hrs)) { // IF HRS IS AN INT ADDS HRS TO TOTALHOURS
		  hrs = parseInt(hrs); // SETS HRS TO AN INT
		  totalHours = totalHours + hrs;
	  }	else if (hrs == parseFloat(hrs)) {
		  hrs = parseFloat(hrs);
		  totalHours = totalHours + hrs;
	  }
	}
	if (totalHours == 0) { // IF TOTALHOURS IS 0 SETS TOTALHOURS TO BLANK VALUE
	  totalHours = "";
	}
	document.getElementById('daily_total_hours_' + date).innerHTML = totalHours;
}

/*******************************************************************************************************************************/
// FUNCTION THAT UPDATES BI-WEEKLY TOTAL HOURS
function updatePeriodHours() {
	var totalHours = 0;
	var period_hours = $('.period_hours').map(function() { return this.id; }).get();
	for (i=0; i < period_hours.length; i++) {
		
	  var hrs = document.getElementById(period_hours[i]).value; // GETS VALUE OF ELEMENT
	   
	  if (hrs == parseInt(hrs)) { // IF HRS IS AN INT ADDS HRS TO TOTALHOURS
		hrs = parseInt(hrs); // SETS HRS TO AN INT
		totalHours = totalHours + hrs;
	  }	else if (hrs == parseFloat(hrs)) {
		  hrs = parseFloat(hrs);
		  totalHours = totalHours + hrs;
	  }
	}
	if (totalHours == 0) { // IF TOTALHOURS IS 0 SETS TOTALHOURS TO BLANK VALUE
	  totalHours = "";
	}
	document.getElementById('pay_period_hours').innerHTML = totalHours;
}

/*********************************************************************************END SCRIPTS************************************************************************************/
</script>

<!--********************************************************SAME CODE FROM DAHSBOARD TIMESHEET TO DISPLAY USERS TIMESHEET******************************************************-->

<div id="emp_jobs_header">
  <label for="emp_timsheet" class="emp_timesheet_label">View Timesheet :</label>
  <form>
      <select id="timesheet_periods" class="emp_timesheet">
          <?php   // POPULATE DROPDOWN LIST WITH PAY PERIODS
                  $query = "SELECT * FROM `pay_periods` ORDER BY `start_date` DESC";
                  $result = $mysqli->query($query);
    
                  while($pay_row = $result->fetch_array(MYSQLI_ASSOC)) {
                      $period_id = $pay_row['id'];
                      $pay_start_date = $pay_row['start_date'];
                      $pay_start_date = date('m/d/Y', strtotime($pay_start_date));
                      $pay_end_date = date('m/d/Y', strtotime($pay_start_date. ' + 13 days'));
                      $options = "<option value=" . $period_id .">" . $pay_start_date . ' - ' . $pay_end_date .  "</option>";
                      echo $options; 
                  }
				  
				  // PULLS THE PAY PERIOD ID FROM JAVASCRIPT .POST METHOD
				  $pay_period_id = $_POST['period_id'];

				  $query = "SELECT * FROM `pay_periods` WHERE `id` = '$pay_period_id'";
				  $results = $mysqli->query($query);
				  
				  while($pay_period_row = $results->fetch_array(MYSQLI_BOTH)) {
					  $start_date = $pay_period_row['start_date'];
					  $start_date = date('m/d/Y', strtotime($start_date));
					  $end_date = date('m/d/Y', strtotime($start_date. ' + 13 days'));
				  }
		  ?>
      </select>
      <a onclick="view_emp_timesheet('<?=$emp_id;?>')">Go</a>
  </form>
   
  <label for="emp_num" class="emp_num_label">Employee # :</label>
  <input id="emp_num" class="valid_numbers emp_num" type="text" value="<?=$emp_num;?>" onchange="update_emp_num()" autocomplete="off">
  
  <label for="load_rate" class="load_rate_label">Loaded Rate :</label>
  <input id="load_rate" class="valid_numbers load_rate" type="text" value="<?='$'. $load_rate;?>" onchange="add_curr(); update_load_rate('<?=$id?>')" autocomplete="off">
  
  <a class="return_emp_info" onclick="emp_content_update()">Return</a>
</div>

<!--**************************************************************************ACTUAL TIMESHEET CODE********************************************************************-->

<div id="admin_timesheet">
<table width="1030px" cellpadding="1" cellspacing="0" border="1px" class="table" align="center">
  <tr>
      <td class="description"><b>Employee #: </b><?=$emp_row['emp_num'];?></td>
      <td class="description"><b>Employee Name: </b><?=$emp_row['last_name'] . ", " . $emp_row['first_name'];?></td>
      <td width=230 class="description"><b>Pay Period: </b><?=$start_date . " - " . $end_date;?></td>
  </tr>
</table>

<table width="1030px" cellpadding="1" cellspacing="0" border="1px" id="navigate" class="table" align="center">
  <colgroup>
      <col span="7" style="background-color:#fff">
      <col span="2" style="background-color:#ccc">
      <col span="5" style="background-color:#fff">
      <col span="2" style="background-color:#ccc">
      <col style="background-color:#fff">
  </colgroup>
  <tr>
      <th class="contract_num_td" align="center">Contract Number:</th>
      <th align="center">Contract Title:</th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 1 day'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 2 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 3 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 4 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 5 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 6 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 7 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 8 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 9 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 10 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 11 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 12 days'));?></th>
      <th class="date_td" align="center"><?=date('n/j', strtotime($start_date. ' + 13 days'));?></th>
      <th class="total_td" align="center">Totals:</th>
  </tr>
  
<?php
$sd = new DateTime($start_date);
$ed = new DateTime($end_date);
$sd = $sd->format('Y-m-d');
$ed = $ed->format('Y-m-d');

$query = "SELECT * FROM `employee_jobs` WHERE `emp_id` = '$emp_id' AND (`start_date` <= '$ed' AND `end_date` >= '$sd')";

$tresult = $mysqli->query($query);
while ($emp_job = $tresult->fetch_array(MYSQLI_BOTH)){
	$job_id = $emp_job['id'];
?>
    <script>
	$(document).ready(function() {
		nav_table();
		updateHourTotals(<?=$emp_job['id'];?>);
<?php
$cDate = new DateTime($start_date);
?>	
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');<?php $cDate->modify('+1 day'); ?>
		updateDailyTotalHours('<?=$cDate->format('Y-m-d');?>');
		
		updatePeriodHours();
	});
	</script>
<?php
$query = "SELECT * FROM `jobs` WHERE `id` = '$emp_job[job_id]' LIMIT 1"; 
$job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);	

$query = "SELECT * FROM `hours` WHERE `emp_id` = '$emp_id' AND `job_id` = '$emp_job[id]'";
$result = $mysqli->query($query);
$job_code = $job['job_id'];
$job_title = $job['job_title'];

$hours = NULL;
while ($row = $result->fetch_array(MYSQLI_BOTH)) {
	$hours[$row['date']] = $row['hours'] + 0;
}
$cDate = new DateTime($start_date);

?>
<!-- ID's ARE WHERE THE ROW/COLUMN INTERSECT (DATE/JOB_ID), PASSING EMP_ID, JOB_ID, DATE TO UPDATE_HOURS() FUNCTION -->
  <tr>
      <td class="description">
	  	<?php echo $job_code; ?>
      </td>
      
      <td class="description">
	  	<?php echo $job_title; ?>
      </td>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$emp_id;?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="totals" id="total_hours_<?=$job_id;?>"></td>
  
<?php
}
?>

<?php
$query = "SELECT * FROM `fixed_jobs`";
$fixed_results = $mysqli->query($query);
while($fixed_jobs = $fixed_results->fetch_array(MYSQLI_BOTH)) {
	$fixed_job_id = $fixed_jobs['id'];
	$fixed_title = $fixed_jobs['job_title'];
?>
  <script>
  $(document).ready(function() {
  	  updateHourTotalsFixed(<?=$fixed_jobs['id'];?>);
	  updatePeriodHours();
  });
  </script>
<?php
$query = "SELECT * FROM `fixed_hours` WHERE (`emp_id` = '$emp_id' OR `emp_id` IS NULL) AND `job_id` = '$fixed_job_id'"; // NEED TO FIGUER OUT WHY HOLIDAY HOURS ONLY DISPLAY WHEN PAGE REFRESHED
$result = $mysqli->query($query);

$fixed_hours = NULL;
while ($fixed_row = $result->fetch_array(MYSQLI_BOTH)) {
	$fixed_hours[$fixed_row['date']] = $fixed_row['hours'] + 0;
}

$cDate = new DateTime($start_date);
?>
  <tr>
      <td>&nbsp;</td>
      
      <td class="description">
	  	<?=$fixed_title;?>
      </td>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$emp_id;?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="totals" id="fixed_total_hours_<?=$fixed_job_id;?>"></td>

<?php
}
$cDate = new DateTime($start_date);
?>

  <tr>
      <td class="description" colspan="2"><b>Daily Totals:</b></td>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td><?php $cDate->modify('+1 day'); ?>
      <td class="totals" id="daily_total_hours_<?=$cDate->format('Y-m-d');?>">&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
</table>

<table width="1030px" cellpadding="1" cellspacing="0" border="1px" class="table" align="center">
	<tr>
		<td class="description"><b>Bi-Weekly Totals:</b></td>
		<td class="total_td" id="pay_period_hours"></td>
	</tr>
</table>

<ul id="dashboard_options">
    <li><a href="#" onclick="alert('Changes Successfully Saved!');">Save &nbsp;</a>|</li>
    <li><a href="../reports/timesheet/timesheet_pdf.php?a=<?=$emp_id;?>&b=<?=$pay_period_id;?>">Print &nbsp;</a>|</li>
    <li><a href="../reports/timesheet/timesheet_pdf.php?a=<?=$emp_id;?>&b=<?=$pay_period_id;?>">Send as Email &nbsp;</a>|</li>
    <li><a href="../reports/timesheet/timesheet_pdf.php?a=<?=$emp_id;?>&b=<?=$pay_period_id;?>&c=1">Download PDF</a></li>
</ul>

</div>