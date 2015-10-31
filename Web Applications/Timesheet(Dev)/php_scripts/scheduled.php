<?php //DISPLAYS LIST OF EMPLOYEES IN ACTIVE DIRECTORY
require 'ldap_connect.php';
require 'db_connect.php';

$ldapbind = ldap_bind($ldapconn, 'timesheet_logon', 'Default123');

if($ldapbind) {
	
	$filter = 'samAccountName=*';
	$searches = array('mail','sn','givenName');
	
	$ldap_results = ldap_search($ldapconn, $baseDN, $filter, $searches, 0, 0, 10);
	if (! $ldap_results) {
		die('No results found');
	}
	
	
	$results = ldap_get_entries($ldapconn, $ldap_results);

	$i = 0;
	foreach ($results as $name) {
		if (isset($name['mail']['0']) && isset($name['givenname']['0']) && isset($name['sn']['0'])) {
				
				$emp_mail[$i] = $name['mail']['0'];
				
				$emp_sn[$i] = $name['sn']['0'];
				$emp_gn[$i] = $name['givenname']['0'];
				$i++;
			}
	}
}else {
	echo "Access Denied";	
}

?>

<?php //INSERTS USER INTO EMPLOYEES TABLE IF NOT ALREADY IN IT
$query = "SELECT * FROM `employees`";
$result = $mysqli->query($query);

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$db_email[] = $row['email'];	
}

$cha_emp = array_map('strtolower', $emp_mail);
$db_email = array_map('strtolower', $db_email);
$diff = array_diff($cha_emp, $db_email);

foreach ($diff as $key => $new_emp){
	$insert = "INSERT INTO `employees` (`id`, `emp_num`, `first_name`, `last_name`, `email`, `user_name`, `active`, `admin`) 
	VALUES (NULL, NULL, '$emp_gn[$key]', '$emp_sn[$key]', LOWER('$emp_mail[$key]'), LOWER('$emp_gn[$key].$emp_sn[$key]'), '1', '0')";
	$mysqli->query($insert);
}
?>

<?php //INSERTS NEW TIMESHEET
$query = "SELECT `start_date` FROM `pay_periods` ORDER BY `start_date` DESC LIMIT 1";
$results = $mysqli->query($query);
$row = $results->fetch_array(MYSQLI_BOTH);
$date = date("Y-m-d", strtotime($row['start_date']. ' + 13 days'));

while (strtotime($date) <= strtotime(date("Y-m-d"))) {
	
	//ADDS HOLIDAY HOURS TO TIMESHEET IF NEEDED
	$query = "SELECT `start_date` FROM `pay_periods` ORDER BY `start_date` DESC LIMIT 1";
	$results = $mysqli->query($query);
	$row = $results->fetch_array(MYSQLI_BOTH);
	
	$start_date = $row['start_date'];
	$end_date = date("Y-m-d", strtotime("+13 days", strtotime($start_date)));
	
	$query = "SELECT `date` FROM `holidays` ORDER BY `date` DESC";
	$result = $mysqli->query($query);
	
	unset($holidays);
	while($holiday_row = $result->fetch_array(MYSQLI_BOTH)) {
		$holidays[] = $holiday_row['date'];
	}
	
	foreach($holidays as $holiday) {
		if($holiday <= $end_date && $holiday >= $start_date) {
  		    $mysqli->query("INSERT INTO `fixed_hours` (`id`, `emp_id`, `job_id`, `date`, `hours`)
  					      VALUES (NULL, NULL, 3, '$holiday', '8')");	
		}
	}
	//ENDS ADD HOLIDAY HOURS TO TIMESHEET SECTION
	
	$new_date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
	$insert_period = "INSERT INTO `pay_periods` (`id`, `start_date`)
	VALUES (NULL, '$new_date')";
	$mysqli->query($insert_period);
	$date = date("Y-m-d", strtotime("+14 day", strtotime($date)));
	
	//ADDS HOLIDAY HOURS TO TABLE FOR LAST PAY PERIOD
	if(strtotime($date) > strtotime(date("Y-m-d"))) {
		
		$query = "SELECT `date` FROM `holidays` ORDER BY `date` DESC";
		$result = $mysqli->query($query);
		
		$start_date = $new_date;
		$end_date = $date;
		
		unset($holidays);
		while($holiday_row = $result->fetch_array(MYSQLI_BOTH)) {
			$holidays[] = $holiday_row['date'];
		}
		
		foreach($holidays as $holiday) {
			if($holiday <= $end_date && $holiday >= $start_date) {	
			    $mysqli->query("INSERT INTO `fixed_hours` (`id`, `emp_id`, `job_id`, `date`, `hours`)
	  					        VALUES (NULL, NULL, 3, '$holiday', '8')");	
			}
		}
	}
	//ENDS IF STATEMENT
}
?>