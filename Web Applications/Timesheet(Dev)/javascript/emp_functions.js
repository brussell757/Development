// RUNS ISNUMBER FUNCION WHEN KEY PRESSED
$(document).ready(function() {
    $("#emp_num").keypress(function(event) { return isNumber(event) });
});

// FUNCTION DISPLAYING THE ADD JOB SECTION
function display_add_job() {
	$('#emp_jobs').find('#job_list').fadeIn('slow');
}

// FUNCTION THAT INCLUDES DISABLED EMPLOYEES IN EMPLOYEE LIST
function include_disabled_employees() {
	var checked = document.getElementById('view_disabled_employees').checked;
	
	if(checked === true) { // if statement to see if view_disabled_employees box is checked
	  var url = "ajax/employee/include_disabled_emps.php";
	  $.post( url , { },
		  function(data) { // function that loads the employee list with disabled employees
			  $('#select_emp').load("ajax/employee/include_disabled_emps.php #emp_list");
			  $('#emp_list').val('00'); // sets the value of the emp_list to 00
			  emp_content_update(); // call to emp_content_update() function
		  } // end function
	  ); // end post
	} else if(checked === false) { // runs if the view_disabled_employees box is not checked
	  var url = "ajax/employee/emp_list.php";
	  $.post( url , {},
		  function(data) { // function that loads the employee list with active employees
			  $('#select_emp').load("ajax/employee/emp_list.php #emp_list");
			  $('#emp_list').val('00'); // sets the value of the emp_list to 00
			  emp_content_update(); // call to emp_content_update() function
		  } // end function
	  ); // end post
	}
}

// FUNCTION THAT LOADS EMPLOYEE DATA
function emp_content_update(){
	var emp_id = document.getElementById('emp_list').value;
	var url = "ajax/employee/emp_content.php";
  	$.post( url, { emp_id:emp_id },
	  	function(data) { // function that checks if employee is disabled or if admin access
			var url = "ajax/employee/check_emp_disabled.php"
			$.post( url , { emp_id:emp_id },
				function(data) {
					if(data === 'true') { // if statement that sets the disable_box to checked if employee is disabled
						document.getElementById('disable_box').checked = true;
					}
				} // end function
			); // end post
			
			var admin_url = "ajax/employee/check_admin_access.php"
			$.post( admin_url , { emp_id:emp_id },
				function(data) {
					if(data === 'true') { // if statement that sets the admin_box to checked if employee has admin access
						document.getElementById('admin_box').checked = true;	
					}
				} // end function
			); // end post
			
		  	$('#emp_content').html(data); // updates emp_content with data from emp_content.php
	  	} // end function
		
  	); // end post
}

// FUNCTION DISPLAYING START AND END DATES OF JOBS
function job_dates() {
	var job_id = document.getElementById('avaliable_jobs').value;
	var url = "ajax/employee/job_dates.php";
	$.post( url, { job_id:job_id },
	  	function(data) {
			var dates = data.split(",");
			document.getElementById('start_date').value = dates['0'];
			document.getElementById('end_date').value = dates['1'];
	  }
  	);
}

// FUNCTION THAT DISPLAYS REQUESTED TIMESHEET
function view_emp_timesheet(emp_id) {
	var period_id = document.getElementById('timesheet_periods').value;
	var url = "view_emp_timesheet.php";
	$.post( url, { emp_id:emp_id, period_id:period_id },
		function(data) {
			$('#emp_content').html(data)
		}
	);
}

// FUNCTION THAT UPDATES EMPLOYEE NUM
function update_emp_num() {
	var msg = confirm ("Are you sure you want to update the employee number?");
	var emp_id = document.getElementById('emp_list').value;	
	var emp_num = document.getElementById('emp_num').value;	
	var url = "ajax/employee/update_emp_num.php";
	
	if(msg === true) {
		$.post( url, { emp_id:emp_id, emp_num:emp_num},
	  		function(data) {
				if(data === "true") { // if statement to see if emp_number exists
					alert("This employee number already exists in the system.");
					emp_content_update();
					return false; 
				} else{
					emp_content_update();	
				}
			} // end function
		); // end post
	} else {
		emp_content_update();
		return false;
	}	
}

// FUNCTION THAT ADDS '$' AT BEGINNING OF LOAD RATE
function add_curr()
{
	var load_rate = document.getElementById('load_rate').value;
	
	if(load_rate.indexOf("$") != 0){ 
		document.getElementById('load_rate').value = "\$" + load_rate;	
	}
}

// FUNCTION THAT UPDATES LOAD RATE
function update_load_rate(id) {
	var emp_id = document.getElementById('emp_list').value;	
	var load_rate = document.getElementById('load_rate').value;	
	var url = "ajax/employee/update_load_rate.php";
	
	load_rate = load_rate.replace('$', '');
	
	$.post( url, { id:id, emp_id:emp_id, load_rate:load_rate },
	  	function(data) {
			emp_content_update();	
		}
	);	
}

// FUNCTION THAT CHANGES THE STATUS OF EMPLOYEE TO DISABLED/ACTIVE
function change_emp_status(emp_id) {
	var checked = document.getElementById('disable_box').checked;
	
	if(checked === true) {
	  	var url = "ajax/employee/disable_emp.php";
		$.post( url, { emp_id:emp_id }, 
			function(data) { // function that updates employee list when an employee is disabled
				$('#emp_list').change(function() {
					update_emp_list();
				});
			}
		);
	} else {
		var url = "ajax/employee/activate_emp.php";
		$.post( url, { emp_id:emp_id });
	}	
}

// FUNCTION THAT CHANGES THE STATUS OF EMPLOYEE TO ADMIN
function change_admin_status(emp_id) {
	var checked = document.getElementById('admin_box').checked;
	
	if(checked === true) {
	  	var url = "ajax/employee/admin_access.php";
		$.post( url, { emp_id:emp_id });
	} else {
		var url = "ajax/employee/no_admin_access.php";
		$.post( url, { emp_id:emp_id });
	}	
}

//FUNCTION THAT UPDATES THE EMPLOYEE LIST
function update_emp_list() {
	var emp_id = document.getElementById('emp_list').value;
	var url = "ajax/employee/emp_list.php";
	$.post( url, {emp_id:emp_id}, 
		function(data) {
			document.getElementById('emp_list').innerHTML = data;
		}
	);
}

// FUNCTION THAT ADDS JOB TO ACTIVE JOBS
function add_job() {
	var emp_id = document.getElementById('emp_list').value;
	var job_id = document.getElementById('avaliable_jobs').value;
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;	
	var url = "ajax/employee/add_job.php";
	if(start_date > end_date) {
		alert("START DATE must come before END DATE");
		return false;	
	} else {
  		$.post( url, { emp_id:emp_id, job_id:job_id, start_date:start_date, end_date:end_date },
	  		function(data) {
				emp_content_update();
	  		}
  		);
	}
}

// FUNCTION THAT DISPLAYS UPDATE BUTTON
function update_dates(id) {
	$('#remove_' + id).hide();
	$('#update_' + id).show();
}

// FUNCTION THAT CHANGES ACTIVE DATES OF JOB
function active_dates(id) {
	var start_date = document.getElementById('active_start_date_' + id).value;
	var end_date = document.getElementById('active_end_date_' + id).value;	
	var url = "ajax/employee/active_dates.php";
	
	$.post( url, { id:id, start_date:start_date, end_date:end_date },
		function(data) {	
			if(data === "true"){
				alert("START DATE must come before END DATE");
				return false;
			} else {	
				emp_content_update();
			}
		}
	);	
}

// FUNCTION THAT REMOVES JOBS FROM ACTIVE JOBS
function remove_job(id) {
	var url = "ajax/employee/remove_job.php";
	
	var msg = confirm("Are you sure you want to remove this job from the \n'Active Jobs' list?");
	
	if(msg === true) {
  		$.post( url, { id:id },
	  		function(data) {
				emp_content_update();
	  	}
  		);
	} else {
		return false;	
	}
}

// FUNCTION THAT DISPLAYS ARCHIVES
function view_archives() {
	var emp_id = document.getElementById('emp_list').value;	
	var url = "ajax/employee/emp_archives.php";
  	$.post( url, { emp_id:emp_id },
	  	function(data) {
			$('#inactive_jobs').html(data)
	  	}
  	);	
}

// FUNCTION THAT HIDES ARCHIVES
function hide_archives() {
	$('#inactive_jobs').html("<a id=\"archives_link\" href=\"#archives\" onclick=\"view_archives()\">View Inactive Jobs</a>")
	$('#archives_link').html("Show Inactive Jobs")
}

// FUNCTION DISPLAYING THE ADD GROUP SECTION
function display_add_group() {
	$('#group_list').fadeIn('slow');
}

// FUNCTION THAT ADDS GROUP TO ACTIVE JOBS
function add_group() {
	var emp_id = document.getElementById('emp_list').value;
	var group_id = document.getElementById('avaliable_groups').value;
	var url = "ajax/employee/emp_add_member.php";
	$.post( url, { emp_id:emp_id, group_id:group_id },
		function(data) {
			emp_content_update();
		}
	);
}

// FUNCTION THAT REMOVES EMPLOYEES FROM GROUP
function remove_members(id, emp_id) {
	 var create = "yes"; 
	 var url = "ajax/employee/emp_remove_member.php";
     $.post( url, { id:id, emp_id:emp_id, create:create },
	 	function(data) {
			emp_content_update();
		}
	);
}

// UPDATE HOURS IN DATABASE
function update_hours(emp_id,job_id,date) {
	var hours = document.getElementById('hours_' + job_id + '_' + date).value;
	var url = "../php_scripts/hours/insert_hours.php";	
	$.post( url, { emp_id:emp_id, job_id:job_id, date:date, hours:hours });
	updateHourTotals(job_id);
	updateDailyTotalHours(date);
	updatePeriodHours();
}

// UPDATE FIXED HOURS IN DATABASE
function update_fixed_hours(emp_id,fixed_job_id,date) {
	var hours = document.getElementById('fixed_hours_' + fixed_job_id + '_' + date).value;
	var url = "../php_scripts/hours/insert_fixed_hours.php";	
	$.post( url, { emp_id:emp_id, fixed_job_id:fixed_job_id, date:date, hours:hours });
	updateHourTotalsFixed(fixed_job_id);
	updateDailyTotalHours(date);
	updatePeriodHours();
}