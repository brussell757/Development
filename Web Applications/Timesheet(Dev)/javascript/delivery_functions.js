$(document).ready(function() {
	var url = "ajax/delivery_orders/orders_list.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#delivery_orders').html(data);
	  }
  	);
});


// FUNCTION DISPLAYING THE CREATE ORDERS SECTION
function new_order() {
	var url = "ajax/delivery_orders/new_order.php";
  	$.post( url, {},
	  	function(data) {
		  	$('#delivery_orders').html(data);
	  }
  	);
}

// FUNCTION THAT VALIDATES IF FORM IS FILLED IN
function validate_form() {
	var order_name = $('#order_name').val().length;
	
	if(order_name == 0) {
		alert("All fields must be filled in!");	
		return false;
	} else {
		check_order();
	}
	
}

// FUNCTION THAT CHECKS IF ORDER EXISTS IN DATABASE
function check_order() {
	var order_name = document.getElementById('order_name').value;
	var url = "ajax/delivery_orders/check_order.php";
	$.post( url, { order_name:order_name },
		function(data) {
			if(data === "true") {
				confirm("This delivery order already exsists");
				return false;
			} else if (data === "false"){
				insert_order();
			}
		}
	);
}

// FUNCTION THAT INSERTS ORDER INTO DATABASE
function insert_order() {
  	var order_name = document.getElementById('order_name').value;
  	var url = "ajax/delivery_orders/insert_order.php";
	var create = "yes";
	
	$.post( url, { order_name:order_name, create:create },
		function(data) {
			if(data === "true") {
				alert("Delivery order successfully created!");
				location.reload();
			} else {
				alert("There was an error inserting the delivery order!");	
				return false;
			}
		}
	);	
}

// FUNCTION THAT CANCELS THE PROCESS OF CREATING AN ORDER
function cancel_create_order() {
	$('#create_order').find('input').val('');
	$('#create_order').hide();
}

// FUNCTION THAT DELETES ORDER FROM DATABASE
function delete_order(id) {
	var url = "ajax/delivery_orders/delete_order.php";
	var msg = confirm("Are you sure you want to delete this delivery order from the database?");
	if(msg === true) {
  		$.post( url, { id:id },
	  		function(data) {
				if(data === "true") {
					alert("This delivery order cannot be deleted. It is being used in a job!");
					return false;
				} else {
					location.reload();
				}
	  		}
  		);
	} else {
		return false;	
	}
}


