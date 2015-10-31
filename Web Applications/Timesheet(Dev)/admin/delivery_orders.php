<?php 
require '../php_scripts/session.php';
?>
<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=10">
		<title>Cape Henry Timesheet - Administrator - Delivery Orders</title>
        <link href="../images/cha.ico" rel="shortcut icon">
        <link href="../css/style.css" rel="stylesheet" type="text/css" />
      	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="../javascript/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script type="text/javascript" src="../javascript/delivery_functions.js"></script>
	</head>

	<body>
    	<div id="page_container">
        	
    		<img src="../images/header.png" alt="CHA Header">
            <p class="admin_greet_user">Welcome <?php echo $user_info['first_name']; ?>!</p>
            <ul id="options">
            	<li><button type="submit" onclick="location.href='employee.php'">Employees</button></li>
                <li><button type="submit" onclick="location.href='groups.php'">Groups</button></li>
                <li><button type="submit" onclick="location.href='jobs.php'">Jobs</button></li>
                <li><button type="submit" onclick="location.href='holidays.php'">Holidays</button></li>
				<li><button class="selected" type="submit" onclick="location.href='delivery_orders.php'">Delivery Orders</button></li>
                <li><button type="submit" onclick="location.href='reports.php'">Reports</button></li>
            </ul>
            
            <ul id="links">
            	<li><a href="../dashboard.php">My Dashboard</a>&nbsp; |</li>
            	<li><a href="../php_scripts/logout.php">Logout</a></li>
            </ul>
            
            <div id="content">
				<button id="new_order" type="submit" onclick="new_order()">+ Add</button>
				<div id="delivery_orders"></div>
            </div>
        	<img class="footer" src="../images/footer.png" alt="CHA Footer">
            <p class="footer_text">Copyright &copy; Cape Henry Associates 2014</p>
        </div>
	</body>
</html>