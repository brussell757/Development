<?php 
require '../../../php_scripts/session.php';
$id = $_GET['id'];
?>
<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=10">
		<title>Cape Henry Timesheet - Administrator - Edit Groups</title>
        <link href="../../../images/cha.ico" rel="shortcut icon">
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
      	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
		<script src="../../../javascript/jquery-1.2.6.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script type="text/javascript" src="../../../javascript/group_functions.js"></script>
	</head>

	<body onload="member_content_update('<?=$id;?>')">
    	<div id="page_container">
        
        	<div class="head">
    		<img src="../../../images/header.png" alt="CHA Header">
            <p class="admin_greet_user">Welcome <?php echo $user_info['first_name']; ?>!</p>
            <ul id="options">
            	<li><button type="submit" onclick="location.href='../../employee.php'">Employees</button></li>
                <li><button class="selected" type="submit" onclick="location.href='../../groups.php'">Groups</button></li>
                <li><button type="submit" onclick="location.href='../../jobs.php'">Jobs</button></li>
                <li><button type="submit" onclick="location.href='../../holidays.php'">Holidays</button></li>
				<li><button type="submit" onclick="location.href='../../delivery_orders.php'">Delivery Orders</button></li>
                <li><button type="submit" onclick="location.href='reports.php'">Reports</button></li>
            </ul>
            
            <ul id="links">
            	<li><a href="../../../dashboard.php">My Dashboard</a>&nbsp; |</li>
            	<li><a href="../../../php_scripts/logout.php">Logout</a></li>
            </ul>
			</div>
            
            <div id="content">
            
            	<div id="groups">
                	<div id="modify_group" class="groups">
                    <input title='Save Group' type='button' class='save_icon' alt='Update Group' onclick="validate_modify_form('<?=$id;?>')">
<?php // SECTION DISPLAYS GROUPS
$query = "SELECT * FROM `groups` WHERE `id` = '$id'";
$results = $mysqli->query($query);
$row = $results->fetch_array(MYSQLI_BOTH);
?> 
					<table>
 				    <tr>             
      					<td><b>Group Name:</b> <br /><input type='text' id='mod_group_name' autocomplete='off' value="<?=$row['group_name'];?>"><br /></td>
                    </tr>
                    </table>
                    
                    <div id="employees"></div>
                    </div>
                </div>

            </div>
        	<img class="footer" src="../../../images/footer.png" alt="CHA Footer">
            <p class="footer_text">Copyright &copy; Cape Henry Associates 2014</p>
            
        </div>
	</body>
</html>