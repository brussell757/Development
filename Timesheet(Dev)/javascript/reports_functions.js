//FUNCTION THAT WILL DISPLAY EMPLOYEE REPORT FORM
function view_emp_report_form() {
	var url = "ajax/reports/emp_report_form.php";
  	$.post( url, {},
	  	function(data) {
			$('#emp_report_form').html(data);
	  	}
  	);	
}

//FUNCTION THAT HIDES THE EMPLOYEE REPORT FORM
function hide_emp_report_form() {
	$('#emp_report_form').html("<a id=\"emp_report_link\" href=\"#emp_report_form\" onclick=\"view_emp_report_form()\"></a>")
	$('#emp_report_link').html("Employee Report Form")	
}

//FUNCTION THAT WILL DISPLAY JOB REPORT FORM
function view_job_report_form() {
	var url = "ajax/reports/job_report_form.php";
  	$.post( url, {},
	  	function(data) {
			$('#job_report_form').html(data);
	  	}
  	);	
}

//FUNCTION THAT HIDES THE JOB REPORT FORM
function hide_job_report_form() {
	$('#job_report_form').html("<a id=\"job_report_link\" href=\"#job_report_form\" onclick=\"view_job_report_form()\"></a>")
	$('#job_report_link').html("Job Report Form")	
}


//FUNCTION THAT WILL PRELOAD DATES IN INPUT FIELD IF A SPECIFIC TIMESHEET IS SELECTED
function selected_period() {
	var period_id = document.getElementById('ts_periods').value;
	var url = "ajax/reports/report_dates.php";
	
	if(period_id === '*') {
		document.getElementById('start_report').value = " "
		document.getElementById('end_report').value = " "
	} else if(period_id != 00 || period_id != '*') {
		$.post(url, {period_id:period_id},
			function(data) {
				var dates = data.split(",");
				document.getElementById('start_report').value = dates['0'];
				document.getElementById('end_report').value = dates['1'];
			}
		);
	} else{
		return false;	
	}
}