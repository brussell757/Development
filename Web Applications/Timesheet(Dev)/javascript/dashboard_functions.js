// DISPLAYS MOST RECENT TIMESHEET ON PAGE LOAD
$(document).ready(function() {
	var pay_period_id = document.getElementById('pay_period').value;
	var url = "php_scripts/timesheet.php";
  	$.post( url, { pay_period_id:pay_period_id },
	  	function(data) {
		   $('#timesheet').html(data)
	  	}
  	);
});

// DISPLAYS TIMESHEET SELECTED FROM DROPDOWN MENU
function timesheet_content_update(){
	var pay_period_id = document.getElementById('pay_period').value;
	var url = "php_scripts/timesheet.php";
  	$.post( url, { pay_period_id:pay_period_id },
	  	function(data) {
		   $('#timesheet').html(data)
	  	}
  	);
}

// UPDATE HOURS IN DATABASE
function update_hours(emp_id,job_id,date) {
	var hours = document.getElementById('hours_' + job_id + '_' + date).value;
	var url = "php_scripts/hours/insert_hours.php";	
	$.post( url, { emp_id:emp_id, job_id:job_id, date:date, hours:hours});
	updateHourTotals(job_id);
	updateDailyTotalHours(date);
	updatePeriodHours();
}

// UPDATE FIXED HOURS IN DATABASE
function update_fixed_hours(emp_id,fixed_job_id,date) {
	var hours = document.getElementById('fixed_hours_' + fixed_job_id + '_' + date).value;
	var url = "php_scripts/hours/insert_fixed_hours.php";	
	$.post( url, { emp_id:emp_id, fixed_job_id:fixed_job_id, date:date, hours:hours });
	updateHourTotalsFixed(fixed_job_id);
	updateDailyTotalHours(date);
	updatePeriodHours();
}