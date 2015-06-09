// FUNCTION THAT LOADS GROUPS
$(document).ready(function() {
	var url = "ajax/groups/groups_list.php";
	$.post( url, {},
		function(data) {
			$('#groups').html(data);
	  }
	);
});

// FUNCTION LOADS MEMEMBER CONTENT
function member_content_update(id){
	var url = "member_content_update.php";
  	$.post( url, { id:id },
	  	function(data) {
		  	$('#employees').html(data)
	  }
  	);
}

// FUNCTION DISPLAYING THE CREATE GROUP
function new_group() {
	var url = "ajax/groups/new_group.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#groups').html(data);
	  }
  	);
}

// FUNCTION THAT VALIDATES IF FORM IS FILLED IN
function validate_form() {
	var group_name = $('#group_name').val().length;
	
	if(group_name == 0) {
		alert("A group name must be present!");	
		return false;
	} else {
		check_group();
	}
	
}

// FUNCTION THAT CHECKS IF GROUP EXSISTS IN DATABASE
function check_group() {
	var group_name = document.getElementById('group_name').value;
	
	var url = "ajax/groups/check_group.php";
	$.post( url, { group_name:group_name },
		function(data) {
			if(data === "true") {
				confirm("This group already exsists");
				return false;
			} else if (data === "false"){
				insert_group();
			}
		}
	);
}

// FUNCTION THAT INSERTS GROUP INTO DATABASE
function insert_group() {
  	var group_name = document.getElementById('group_name').value;
  	var url = "ajax/groups/insert_group.php";
	var create = "yes";
	
	$.post( url, { group_name:group_name, create:create },
		function(data) {
			if(data === "true") {
				location.reload();
			} else {
				alert("There was an error inserting the group!");	
				return false;
			}
		}
	);	
}

// FUNCTION THAT CANCELS THE PROCESS OF CREATING A GROUP 
function cancel_create_group() {
	$('#create_group').find('input').val('');
	$('#create_group').hide();
	$('#new_group').fadeIn('slow');	
}

//*****************************************************************************************************************************************************************
//  SEPERATE CREATE GROUP FUNCTIONS FROM MODIFY GROUP FUNCTIONS
//*****************************************************************************************************************************************************************

// FUNCTION THAT VALIDATES THE MODIFIED GROUP FORM
function validate_modify_form(id) {
	var group_name = $('#mod_group_name').val().length;
	
	if(group_name == 0) {
		alert("A group name must be present!");	
		return false;
	} else {
		check_modify_group(id);
	}		
}

// FUNCTION THAT CHECKS IF MODIFIED GROUP EXISTS IN DATABASE
function check_modify_group(id) {
	var group_name = document.getElementById('mod_group_name').value;
	var url = "check_mod_group.php";
	$.post( url, { id:id, group_name:group_name },
		function(data) {
			if(data === "true") {
				confirm("This group already exists");
				return false;
			} else if (data === "false"){
				modify_group(id);
			}
		}
	);
}

// FUNCTION THAT UPDATES GROUP IN DATABASE
function modify_group(id) {
  	var group_name = document.getElementById('mod_group_name').value;
  	var url = "modify_group.php";
	var create = "yes"
	
	$.post( url, { id:id, group_name:group_name, create:create },
		function(data) {
			if(data === "true") {
				window.location.href="../../groups.php";
			} else {
				alert("There was an error updating the group.");	
			}
		}
	);	
}

//*****************************************************************************************************************************************************************
//  SEPERATE MODIFY GROUP FUNCTIONS FROM MISC FUNCTIONS
//*****************************************************************************************************************************************************************

// FUNCTION THAT DELETES HOLIDAY FROM DATABASE/ALERTS HOW MANY USERS IN GROUP
function delete_group(id) {
	var url = "ajax/groups/count_members.php";
  	$.post( url, { id:id },
		function(data) {
			if(data == 0) {
				var url = "ajax/groups/delete_group.php";
				$.post( url, { id:id },
					function(data) {
						location.reload();
					}
				);		
			} else if (data == 1) {
				var msg = confirm("There is '" + data + "' member in this group. \n Are you sure you want to delete it?");
					if(msg === true) {
						var url = "ajax/groups/delete_group.php";
						$.post( url, { id:id },
							function(data) {
								location.reload();
							}	
						);
					} else {
						return false;	
					}
			} else {
				var msg = confirm("There are '" + data + "' members in this group. \n Are you sure you want to delete it?");
					if(msg === true) {
						var url = "ajax/groups/delete_group.php";
						$.post( url, { id:id },
							function(data) {
								location.reload();
							}	
						);	
					} else {
						return false;
					}
			}
		}
	);
}

// FUNCTION THAT INSERTS EMPLOYEES INTO GROUP
function insert_members(id, emp_id) {
	 var create = "yes"; 
	 var url = "add_members.php";
     $.post( url, { id:id, emp_id:emp_id, create:create },
	 	function(data) {
			member_content_update(id);
		}
	 );
}

// FUNCTION THAT REMOVES EMPLOYEES FROM GROUP
function remove_members(id, emp_id) {
	 var create = "yes"; 
	 var url = "remove_members.php";
     $.post( url, { id:id, emp_id:emp_id, create:create },
	 	function(data) {
			member_content_update(id);
		}
	);
}