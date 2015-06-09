<?php 
require '../php_scripts/session.php';
?>
<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=10">
		<title>Cape Henry Timesheet - Administrator - Employees</title>
        <link href="../images/cha.ico" rel="shortcut icon">
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
      	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="../javascript/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script src="../javascript/emp_functions.js" type="text/javascript"></script>
	</head>

	<body>
    	<div id="page_container">
        
        	<img src="../images/header.png" alt="CHA Header">
            <p class="admin_greet_user">Welcome <?php echo $user_info['first_name']; ?>!</p>
            <ul id="options">
            	<li><button class="selected" type="submit" onclick="location.href='employee.php'">Employees</button></li>
                <li><button type="submit" onclick="location.href='groups.php'">Groups</button></li>
                <li><button type="submit" onclick="location.href='jobs.php'">Jobs</button></li>
                <li><button type="submit" onclick="location.href='holidays.php'">Holidays</button></li>
				<li><button type="submit" onclick="location.href='delivery_orders.php'">Delivery Orders</button></li>
                <li><button type="submit" onclick="location.href='reports.php'">Reports</button></li>
            </ul>
            
            <ul id="links">
            	<li><a href="../dashboard.php">My Dashboard</a>&nbsp; |</li>
            	<li><a href="../php_scripts/logout.php">Logout</a></li>
            </ul>
            
            <div id="content">
            
            	<div id="select_emp"> <!-- div for dropdown menu of employees -->
					<form>
                    	<select id="emp_list" onchange="emp_content_update()">
                			<option value="00" selected>Select Employee</option>
                            
                            <?php //Populate drop down list w/ employee names from active directory
								$query = "SELECT `id`,`last_name`, `first_name` FROM `employees` WHERE `active` = '1' ORDER BY `last_name`, `first_name`";
								$result = $mysqli->query($query);

								while($row = $result->fetch_array(MYSQLI_ASSOC)) {
									$id = $row['id'];
									$last_name = $row['last_name'];
									$first_name = $row['first_name'];
									$options = "<option value=" . $id .">" . $last_name . ", " . $first_name . "</option>";
									echo $options; // displays all active employees in employees table
								}
							?>
                            
                		</select>
            		</form>
                </div> <!-- end select_emp div -->
                
                <label for="view_disabled_employees" class="disabled_employees_text">Include Disabled</label>
                <input id="view_disabled_employees" type="checkbox" onchange="include_disabled_employees()">
               
                <hr> 
                
                <div id="emp_content"></div> <!-- displays employee content from the emp_content.php page -->
                
            </div>
            <img class="footer" src="../images/footer.png" alt="CHA Footer">
            <p class="footer_text">Copyright &copy; Cape Henry Associates 2014</p>
        </div>
	</body>
</html>