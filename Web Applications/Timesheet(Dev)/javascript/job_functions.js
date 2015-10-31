// FUNCTION THAT DISPLAYS JOBS
$(document).ready(function() {
	var url = "ajax/jobs/jobs_list.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#jobs').html(data);
	  }
  	);
});

// FUNCTION THAT ADDS '%' AT END OF PROFIT
function add_perc()
{
	var profit = document.getElementById('profit').value;
	var lastChar = profit[profit.length-1];
	
	if(lastChar != '%') {
	document.getElementById('profit').value = profit + "%";	
	}
}

// FUNCTION THAT ADDS '$' AT BEGINNING OF FUND
function add_curr()
{
	var fund = document.getElementById('fund').value;
	
	if(fund.indexOf("$") != 0){ 
		document.getElementById('fund').value = "\$" + fund;	
	}
}

// FUNCTION DISPLAYING THE CREATE JOB SECTION
function new_job() {
	var url = "ajax/jobs/new_job.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#jobs').html(data);
			inputlimiter();
			numerical_data();
	  }
  	);
}

// FUNCTION THAT VALIDATES FORM IS FILLED OUT
function validate_form() {
	var job_code = $('#job_code').val().length;
  	var job_title = $('#job_title').val().length;
  	var company = $('#company').val().length;
 	var fund = $('#fund').val().length;
  	var profit = $('#profit').val().length;
	
	if(job_code == 0 || job_title == 0 || company == 0 || fund == 0 || profit == 0) {
		alert("All fields must be filled in!");	
		return false;
	} else {
		validate_length();
	}
}

// FUNCTION THAT VALIDATES LENGTH OF FIELDS
function validate_length() {
	var job_code = $('#job_code').val().length;
  	var job_title = $('#job_title').val().length;
  	var company = $('#company').val().length;
  	var fund = $('#fund').val().length;
  	var profit = $('#profit').val().length;
	var errors = [];
	
	if(job_code > 30) {
		errors.push("Job Code\n");	
	}
	if (job_title > 150) {
		errors.push("Job Title\n");
	}
	if (company > 50) {
		errors.push("Company Name\n");
	}
	if (fund > 11) {
		errors.push("Funding Amount\n");
	}
	if (profit > 5) {
		errors.push("Profit Amount\n");
	} 

	if(job_code <= 30 && job_title <= 150 && company <= 50 && fund <= 12 && profit <= 6) {
		validate_dates();
	} else {
		var errors = errors.join("\n");
		alert("The following fields exceed their capacity: \n\n" + errors);	
		return false;
	}
}

// FUNCTION THAT VALIDATES DATES
function validate_dates() {	
	var start = document.getElementById('start').value;
	var end = document.getElementById('end').value;
	
	if(start > end) {
		event.preventDefault();
		alert("START_DATE must come before END_DATE");	
	} else {
		check_job();	
	}
}

// FUNCTION THAT CHECKS IF JOB EXISTS IN DATABASE
function check_job() {
	var job_code = document.getElementById('job_code').value;
	var url = "ajax/jobs/check_job.php";
	$.post( url, { job_code:job_code },
	function(data) {
		if(data === "true") {
			var msg = confirm("This job code already exists. \n Would you like to continue creating a duplicate?");
			if(msg === true) {
				insert_job();
				$('#create_job')[0].reset();	
			} else if(msg === false) {
				document.getElementById("job_code").select();
				document.getElementById("job_code").focus();
				event.preventDefault();	
			}
		} else if (data === "false"){
			insert_job();
			$('#create_job')[0].reset();
		}
	}
);
}

// FUNCTION THAT INSERTS JOB INTO DATABASE
function insert_job() {
  	var job_code = document.getElementById('job_code').value;
  	var job_title = document.getElementById('job_title').value;
  	var company = document.getElementById('company').value;
	var start = document.getElementById('start').value;
	var end = document.getElementById('end').value;
  	var fund = document.getElementById('fund').value;
  	var profit = document.getElementById('profit').value;
  	var order = document.getElementById('order').value;
  	var url = "ajax/jobs/insert_job.php";
	var create = "yes";
	
  	fund = fund.replace('$', '');
  	profit = profit.replace('%', '');
	
	$.post( url, { job_code:job_code, job_title:job_title, company:company, start:start, end:end, fund:fund, profit:profit, order:order, create:create },
		function(data) {
			if(data === "true") {
				location.reload();
			} else {
				alert("There was an error inserting the job.");	
				return false;
			}
		}
	);	
}

// FUNCTION THAT CANCELS THE PROCESS OF CREATING A JOB 
function cancel_create_job() {
	$('#create_job').find('input').val('');
	
	var url = "ajax/jobs/jobs_list.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#jobs').html(data);
	  }
  	);
}

//*****************************************************************************************************************************************************************
//  SEPERATE CREATE JOB FUNCTIONS FROM MODIFY JOB FUNCTIONS
//*****************************************************************************************************************************************************************

// FUNCTION THAT DISPLAYS DATE PICKER
function change_mod_start() {
	var picker = new Pikaday({
		field: document.getElementById('mod_start'),
		format: 'YYYY-MM-DD'
		});
}

// FUNCTION THAT DISPLAYS DATE PICKER
function change_mod_end() {
	var picker = new Pikaday({
		field: document.getElementById('mod_end'),
		format: 'YYYY-MM-DD'
		});
}

// FUNCTION THAT ADDS '%' AT END OF PROFIT
function add_mod_perc() {
	var profit = document.getElementById('mod_profit').value;
	var lastChar = profit[profit.length-1];
	
	if(lastChar != '%') {
	document.getElementById('mod_profit').value = profit + "%";	
	}
}

// FUNCTION THAT ADDS '$' AT END OF FUND
function add_mod_curr() {
	var fund = document.getElementById('mod_fund').value;
	
	if(fund.indexOf("$") != 0){ 
		document.getElementById('mod_fund').value = "\$" + fund;	
	}
}

// FUNCTION DISPLAYING THE EDIT JOB SECTION
function modify_section(id) {
	var url = "ajax/jobs/update_job.php";
  	$.post( url, { id:id },
	  	function(data) {
		  	$('#job_' + id).html(data)
			mod_inputlimiter();
			numerical_data();
	  }
  	);
}

// FUNCTION THAT LIMITS AMOUNT OF CHARACTERS USER CAN ENTER (MODIFY)
function mod_inputlimiter() {
	$('#mod_job_code').inputlimiter({
		limit: 30,
		limitText: '',
		remText: ''
	});
	$('#mod_job_title').inputlimiter({
		limit: 150,
		limitText: '',
		remText: ''
	});
	$('#mod_company').inputlimiter({
		limit: 50,
		limitText: '',
		remText: ''
	});
	$('#mod_fund').inputlimiter({
		limit: 11,
		limitText: '',
		remText: ''
	});
	$('#mod_profit').inputlimiter({
		limit: 6,
		limitText: '',
		remText: ''
	});
}

// FUNCTION THAT VALIDATES FORM IS FILLED OUT
function validate_modify_form(id) {
		var job_code = $('#mod_job_code').val().length;
  		var job_title = $('#mod_job_title').val().length;
  		var company = $('#mod_company').val().length;
  		var fund = $('#mod_fund').val().length;
  		var profit = $('#mod_profit').val().length;		
		
		if(job_code == 0 || job_title == 0 || company == 0 || fund == 0 || profit == 0) {
			alert("All fields must be filled in!");	
			return false;
		} else {
			validate_modify_length(id);
		}		
}

// FUNCTION THAT VALIDATES LENGTH OF FIELDS
function validate_modify_length(id) {
	var job_code = $('#mod_job_code').val().length;
  	var job_title = $('#mod_job_title').val().length;
  	var company = $('#mod_company').val().length;
  	var fund = $('#mod_fund').val().length;
  	var profit = $('#mod_profit').val().length;
	var errors = [];
	
	if(job_code > 30) {
		errors.push("Job Code\n");	
	}
	if (job_title > 150) {
		errors.push("Job Title\n");
	}
	if (company > 50) {
		errors.push("Company Name\n");
	}
	if (fund > 11) {
		errors.push("Funding Amount\n");
	}
	if (profit > 6) {
		errors.push("Profit Amount\n");
	} 

	if(job_code <= 30 && job_title <= 150 && company <= 50 && fund <= 12 && profit <= 6) {
		validate_modify_dates(id);
	} else {
		var errors = errors.join("\n");
		alert("The following fields exceed their capacity: \n\n" + errors);	
		return false;
	}
}

// FUNCTION THAT VALIDATES DATES
function validate_modify_dates(id) {	
	var start = document.getElementById('mod_start').value;
	var end = document.getElementById('mod_end').value;
	
	if(start > end) {
		event.preventDefault();
		alert("START_DATE must come before END_DATE");	
	} else {
		check_modify_job(id);	
	}
}

// FUNCTION THAT CHECKS IF JOB EXISTS IN DATABASE
function check_modify_job(id) {
	var job_code = document.getElementById('mod_job_code').value;
	var url = "ajax/jobs/check_mod_job.php";
	$.post( url, { id:id, job_code:job_code },
	function(data) {
		if(data === "true") {
			var msg = confirm("This job code already exists. \n Would you like to continue creating a duplicate?");
			if(msg === true) {
				modify_job(id);	
			} else if(msg === false) {
				document.getElementById("mod_job_code").select();
				document.getElementById("mod_job_code").focus();
				event.preventDefault();	
			}
		} else if (data === "false"){
			modify_job(id);
		}
	}
);
}

// FUNCTION THAT UPDATES JOB IN DATABASE
function modify_job(id) {
  	var job_code = document.getElementById('mod_job_code').value;
  	var job_title = document.getElementById('mod_job_title').value;
  	var company = document.getElementById('mod_company').value;
	var start = document.getElementById('mod_start').value;
	var end = document.getElementById('mod_end').value;
  	var fund = document.getElementById('mod_fund').value;
  	var profit = document.getElementById('mod_profit').value;
  	var order = document.getElementById('mod_order').value;
  	var url = "ajax/jobs/modify_job.php";
	var create = "yes";
	
  	fund = fund.replace('$', '');
  	profit = profit.replace('%', '');
	
	$.post( url, { id:id, job_code:job_code, job_title:job_title, company:company, start:start, end:end, fund:fund, profit:profit, order:order, create:create },
		function(data) {
			if(data === "true") {
				location.reload();
			} else {
				alert("There was an error updating the job.");	
			}
		}
	);	
}
//*****************************************************************************************************************************************************************
//  SEPERATE MODIFY JOB FUNCTIONS FROM DELETE JOB FUNCTION
//*****************************************************************************************************************************************************************

// FUNCTION THAT DELETES JOB FROM DATABASE
function delete_job(id) {
	var url = "ajax/jobs/delete_job.php";
	var msg = confirm("Are you sure you want to delete this job from the database?");
	if(msg === true) {
  		$.post( url, { id:id },
	  		function(data) {
				location.reload();
	  		}
  		);
	} else {
		return false;	
	}
}

//*****************************************************************************************************************************************************************
//  SEPERATE DELETE JOB FUNCTIONS FROM INACTIVE JOBS FUNCTIONS
//*****************************************************************************************************************************************************************

// FUNCTION THAT DISPLAYS INACTIVE JOBS
function view_archives() {	
	var url = "ajax/jobs/view_archives.php";
  	$.post( url, {},
	  	function(data) {
			$('#inactive_jobs').html(data)
	  	}
  	);	
}

// FUNCTION THAT HIDES INACTIVE JOBS
function hide_archives() {
	$('#inactive_jobs').html("<a id=\"archives_link\" href=\"#archives\" onclick=\"view_archives()\">View Inactive Jobs</a>")
	$('#archives_link').html("Show Inactive Jobs")
}