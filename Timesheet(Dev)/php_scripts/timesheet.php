<?php  // PULLS DATA FROM PAY_PERIOD TABLE
require 'session.php';

$pay_period_id = $_POST['pay_period_id'];

if($pay_period_id == 00) {
	exit;	
}

if(isset($pay_period_id)) {
$query = "SELECT * FROM `pay_periods` WHERE `id` = '$pay_period_id'";
$results = $mysqli->query($query);

while($pay_period_row = $results->fetch_array(MYSQLI_BOTH)) {
	$start_date = $pay_period_row['start_date'];
	$start_date = date('m/d/Y', strtotime($start_date));
	$end_date = date('m/d/Y', strtotime($start_date. ' + 13 days'));
}
?>
<script type='text/javascript'>
/*********************************************************************************START SCRIPTS ************************************************************************************/
// NAVITGATE TABLE USING ARROW KEYS
$(document).ready(function() {
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
});

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
	  totalHours = "&nbsp;";
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

/*********************************************************************************END SCRIPTS ************************************************************************************/
</script>

<table width="1030px" cellpadding="1" cellspacing="0" border="1px" class="table" align="center">
  <tr>
      <td class="description"><b>Employee #: </b><?=$user_info['emp_num'];?></td>
      <td class="description"><b>Employee Name: </b><?=$user_info['last_name'] . ", " . $user_info['first_name'];?></td>
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

$query = "SELECT * FROM `employee_jobs` WHERE `emp_id` = '$user_info[id]' AND (`start_date` <= '$ed' AND `end_date` >= '$sd')";

$tresult = $mysqli->query($query);
while ($emp_job = $tresult->fetch_array(MYSQLI_BOTH)){
	$job_id = $emp_job['id'];
?>
    <script>
	$(document).ready(function() {
		// Updates the hour totals for the job id
		updateHourTotals(<?=$emp_job['id'];?>);
<?php
$cDate = new DateTime($start_date);
?>	
		// Updates the daily hour totals on load
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
		
		//Updates the pay period hours
		updatePeriodHours();
	});
	</script>
<?php
$query = "SELECT * FROM `jobs` WHERE `id` = '$emp_job[job_id]' LIMIT 1"; 
$job = $mysqli->query($query)->fetch_array(MYSQLI_BOTH);	

$query = "SELECT * FROM `hours` WHERE `emp_id` = '$user_info[id]' AND `job_id` = '$emp_job[id]'";
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
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='hours_<?=$job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>' value='<?=$hours[$cDate->format('Y-m-d')];?>' onchange="update_hours('<?=$user_info['id'];?>', '<?=$job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>')">
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
	  // Updates the hour totals for the job id
  	  updateHourTotalsFixed(<?=$fixed_jobs['id'];?>);
<?php
$cDate = new DateTime($start_date);
?>
	  // Updates the daily hours once document is ready. This is for holiday hours that are preloaded into the timesheet
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
	  
	  // Updates the pay period hours
	  updatePeriodHours();
  });
  </script>
<?php
$query = "SELECT * FROM `fixed_hours` WHERE (`emp_id` = '$user_info[id]' OR `emp_id` IS NULL) AND `job_id` = '$fixed_job_id'";
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
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 1 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 2 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 3 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 4 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 5 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 6 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 7 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 8 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 9 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 10 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td>
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 11 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 12 day'));?>')">
      </td><?php $cDate->modify('+1 day'); ?>
      
      <td class="weekend">
      	<input type="text" class="<?=$cDate->format('Y-m-d');?>_daily_hours period_hours" id='fixed_hours_<?=$fixed_job_id;?>_<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>' value='<?=$fixed_hours[$cDate->format('Y-m-d')];?>' onchange="update_fixed_hours('<?=$user_info['id'];?>', '<?=$fixed_job_id;?>', '<?=date('Y-m-d', strtotime($start_date. ' + 13 day'));?>')">
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
    <li><a href="../dashboard.php">Save &nbsp;</a>|</li>
    <li><a href="reports/timesheet/timesheet_pdf.php?a=<?=$user_info['id'];?>&b=<?=$pay_period_id;?>">Print &nbsp;</a>|</li>
    <!--<li><a href="">Send as Email &nbsp;</a>|</li>-->
    <li><a href="reports/timesheet/timesheet_pdf.php?a=<?=$user_info['id'];?>&b=<?=$pay_period_id;?>&c=1">Download PDF</a></li>
</ul>
<?php
}
?>