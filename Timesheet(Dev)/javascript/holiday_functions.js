$(document).ready(function() {
	var url = "ajax/holidays/holidays_list.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#holidays').html(data);
	  }
  	);
});

// FUNCTION DISPLAYING THE CREATE HOLIDAYS SECTION
function new_holiday() {
	var url = "ajax/holidays/new_holiday.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#holidays').html(data);
	  }
  	);
}

// FUNCTION THAT VALIDATES IF FORM IS FILLED IN
function validate_form() {
	var holiday_name = $('#holiday_name').val().length;
  	var holiday_date = $('#holiday_date').val().length;
	
	if(holiday_name == 0 || holiday_date == 0) {
		alert("All fields must be filled in!");	
		return false;
	} else {
		check_holiday();
	}
}

// FUNCTION THAT CHECKS IF HOLIDAY EXSISTS
function check_holiday() {
	var date = document.getElementById('holiday_date').value;
	var url = "ajax/holidays/check_holiday.php";
	$.post( url , { date:date },
		function(data) {
			if(data === "true") {
				alert("This holiday already exists!");
			} else {
				insert_holiday();	
			}
		}
	);
}

// FUNCTION THAT INSERTS JOB INTO DATABASE
function insert_holiday() {
  	var holiday_name = document.getElementById('holiday_name').value;
  	var holiday_date = document.getElementById('holiday_date').value;
  	var url = "ajax/holidays/insert_holiday.php";
	var create = "yes";
	
	$.post( url, { holiday_name:holiday_name, holiday_date:holiday_date, create:create },
		function(data) {
			if(data === "true") {
				alert("Holiday successfully created!");
				location.reload();
			} else {
				alert("There was an error inserting the holiday!");	
				return false;
			}
		}
	);	
}

// FUNCTION THAT CANCELS THE PROCESS OF CREATING A HOLIDAY 
function cancel_create_holiday() {
	$('#create_holiday').find('input').val('');
	$('#create_holiday').hide();	
}

// FUNCTION THAT DELETES HOLIDAY FROM DATABASE
function delete_holiday(id) {
	var url = "ajax/holidays/delete_holiday.php";
	var msg = confirm("Are you sure you want to delete this holiday from the database?");
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

