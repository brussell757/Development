<?php
$mysqli = new mysqli("localhost", "********", "*******", "timesheet"); // (Username/Password removed for security purposes)
if(!$mysqli) {
	die ("Could not connect to database");	
}
?>