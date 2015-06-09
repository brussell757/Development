<?php
require 'ldap_connect.php';
require 'db_connect.php';

if(!empty($_POST['username']) && !empty($_POST['password'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $ldapbind = ldap_bind($ldapconn, "capehenry\\".$username, $password);

  if($ldapbind) {
	  
	  $filter = 'samAccountName=' . $_POST['username'];
	  $search = array('givenName');
	  
	  $ldapresults = ldap_search($ldapconn, $baseDN, $filter, $search, 0, 1, 5);
	  if (!$ldapresults) {
		  die('No results found');
	  }
	  else {
		  $results = ldap_get_entries($ldapconn, $ldapresults);
		  $name = ($results['0']['givenname']['0']);
		  
		  $query = "SELECT * FROM `employees` WHERE `user_name` = '$username' AND `active` = '1' LIMIT 1";
		  $results = $mysqli->query($query);
		  $row = $results->fetch_array(MYSQLI_BOTH);
		  $emp_id = $row['id'];
		  $md5_hash = md5(rand().$emp_id);
		  
		  if($results->num_rows == 0) {
			  echo "Access Denied: User not found!";
		  } else if($results->num_rows == 1) {
			  
			  $query = "SELECT * FROM `sessions` WHERE `emp_id` = '$emp_id'";
			  $results = $mysqli->query($query);
			  $row = $results->fetch_array(MYSQLI_BOTH);
			  
			  $c_uid = $row['emp_id'];
			  $c_hash = $row['hash'];
			  $num_rows = $results->num_rows;
			 
			  if($num_rows == 1) {
				
				  if(isset($_POST['remember'])) {
					  setcookie("UID", $c_uid, time()+3600*24*30, "/");
					  setcookie("HASH", $c_hash, time()+3600*24*30, "/");
					  setcookie('REMEMBERME', '1', time()+3600*24*30, "/");
					  header("Location: /dashboard.php");
				  } else if(!isset($_POST['remember'])) {
					  setcookie("UID", $c_uid, time()+3600, "/");
					  setcookie("HASH", $c_hash, time()+3600, "/");
					  setcookie('REMEMBERME', '0', time()+3600, "/");
					  header("Location: /dashboard.php");
				  }
				  
			  } else if($num_rows == 0) {
				  
				  if(isset($_POST['remember'])) {	
					  setcookie("UID", $emp_id, time()+3600*24*30, "/");
					  setcookie("HASH", $md5_hash, time()+3600*24*30, "/");
					  setcookie('REMEMBERME', '1', time()+3600*24*30, "/");
					  
					  $set_date = date("Y-m-d H:i:s", time());
					  $expire_date = date("Y-m-d H:i:s", time()+3600*24*30);
					  $mysqli->query("INSERT INTO `sessions` (`id`, `emp_id`, `hash`, `set_date`, `expire_date`) VALUES (NULL, '$emp_id', '$md5_hash', '$set_date', '$expire_date')");
					  header("Location: /dashboard.php");
				  } else if(!isset($_POST['remember'])) {
					  setcookie("UID", $emp_id, time()+3600, "/");
					  setcookie("HASH", $md5_hash, time()+3600, "/");
					  setcookie('REMEMBERME', '0', time()+3600, "/");
					  
					  $set_date = date("Y-m-d H:i:s", time());
					  $expire_date = date("Y-m-d H:i:s", time()+3600);
					  $mysqli->query("INSERT INTO `sessions` (`id`, `emp_id`, `hash`, `set_date`, `expire_date`) VALUES (NULL, '$emp_id', '$md5_hash', '$set_date', '$expire_date')");
					  header("Location: /dashboard.php");
				  }	
				  
			  } else {
					  echo "Database Error!";
					  exit; 
			  }
		  }
	  }
  } 
  else {
	  echo "Access Denied";	
  }
} 
else {
	  echo "Username/Password must be filled out";
}
