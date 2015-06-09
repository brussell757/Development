<?php
require 'db_connect.php';	

if(isset($_COOKIE['UID']) && isset($_COOKIE['HASH']) && isset($_COOKIE['REMEMBERME'])){
	
	$c_uid = $_COOKIE['UID'];
	$c_hash = $_COOKIE['HASH'];
	$c_remember = $_COOKIE['REMEMBERME'];
	
	$query = "SELECT * FROM `sessions` WHERE `emp_id` = '$c_uid' AND `hash` = '$c_hash' LIMIT 1";
	$result = $mysqli->query($query);
	$num_rows = $result->num_rows;
	
	if($num_rows != 1) {
		header("Location: /index.php");
		exit;
	} else {
		$query = "SELECT * FROM `employees` WHERE `id` = '$c_uid' LIMIT 1";
		$result = $mysqli->query($query);
		$user_info = $result->fetch_array(MYSQLI_BOTH);
		
		if($c_remember == 1) {
			setcookie("UID", $c_uid, time()+3600*24*30, "/");
			setcookie("HASH", $c_hash, time()+3600*24*30, "/");
			setcookie("REMEMBERME", $c_remember, time()+3600*24*30, "/");
			
			$expire = date("Y-m-d H:i:s", time()+3600*24*30);
			$mysqli->query("UPDATE `sessions` SET `expire_date` = '$expire' WHERE `emp_id` = '$c_uid' AND `hash` = '$c_hash'");
		} else if($c_remember == 0) {
			setcookie("UID", $c_uid, time()+3600, "/");
			setcookie("HASH", $c_hash, time()+3600, "/");
			setcookie("REMEMBERME", $c_remember, time()+3600, "/");
			
			$expire = date("Y-m-d H:i:s", time()+3600);
			$mysqli->query("UPDATE `sessions` SET `expire_date` = '$expire' WHERE `emp_id` = '$c_uid' AND `hash` = '$c_hash'");
		}
		
		if(strtolower($_SERVER['PHP_SELF']) == "/index.php") {
			header("Location: /dashboard.php");
		}
	}	
} else {
	if(strtolower($_SERVER['PHP_SELF']) == "/index.php") {
		
	} else {
		header("Location: /index.php");
		exit;
	}
}

if(strtolower($_SERVER['PHP_SELF']) == "/php_scripts/logout.php") {
	unset($_COOKIE['UID']);
	unset($_COOKIE['HASH']);
	unset($_COOKIE['REMEMBERME']);
	
	setcookie("UID", NULL, -1, "/");
	setcookie("HASH", NULL, -1, "/");
	setcookie('REMEMBERME', NULL, -1, "/");
	
	header("Location: /index.php");
}
?>