<?php 
require 'php_scripts/session.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=10">
    <title>Cape Henry Timesheet - Dashboard</title>
    <link href="images/cha.ico" rel="shortcut icon">
    <link href='http://fonts.googleapis.com/css?family=Pacifico|Play' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script src="javascript/jquery-1.2.6.min.js" type="text/javascript"></script>
    <script src="javascript/dashboard_functions.js" type="text/javascript"></script>
</head>

<body>
    <div id="page_container">
    
        <div class="head">
        <img src="../images/header.png" alt="CHA Header">
        <p class="greet_user">Welcome <?php echo $user_info['first_name'] ?>!</p>
        <ul id="dashboard_links">
<?php
	if($user_info['admin'] == 1) { // if statement to see if user had admin privileges
?>
 		<li><a href="../admin/employee.php">Administrator</a>&nbsp; |</li> <!-- displayed if user has admin privligies -->
        <li><a href="php_scripts/logout.php">Logout</a></li> <!-- displayed if user has admin privligies -->
<?php
	} else if($user_info['admin'] == 0) { // if user doesnt have admin priviliges
?>
        <li><a href="php_scripts/logout.php">Logout</a></li> <!-- displayed if user doesn't have admin priviliges -->
<?php
	}
?>
      </ul>
      </div>
                 
        <div id="content">
            <form>
                <label class="pay_period_label">Pay Period :</label>
                <select id="pay_period" onChange="timesheet_content_update()">
                
                    <?php //Populate drop down list w/ pay periods from database
                            $query = "SELECT * FROM `pay_periods` ORDER BY `start_date` DESC LIMIT 5";
                            $result = $mysqli->query($query);

                            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                $period_id = $row['id'];
                                $start_date = $row['start_date'];
                                $start_date = date('m/d/Y', strtotime($start_date));
                                $end_date = date('m/d/Y', strtotime($start_date. ' + 13 days'));
                                $options = "<option value=" . $period_id .">" . $start_date . ' - ' . $end_date .  "</option>";
                                echo $options; //displays the last 5 pay periods in database
                            }
                     ?>
                      
                </select>
            </form>
            <div id="timesheet"></div> <!-- displays timesheet div from timesheet.php -->
        </div>
        
        <img class="footer" src="../images/footer.png" alt="CHA Footer">
        <p class="footer_text">Copyright &copy; Cape Henry Associates 2014</p>
      </div>
</body>
</html>

