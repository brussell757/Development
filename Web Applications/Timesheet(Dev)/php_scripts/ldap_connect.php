<?php
// Error Reporting
set_time_limit(30);
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

$ldaphost = "*******"; //LDAP Host (Data removed for security purposes)
$ldapport = 389; //LDAP Port Number                

$ldapconn = ldap_connect($ldaphost, $ldapport); //Connect to LDAP Host on LDAP Port Number

// Check LDAP connection
if(!$ldapconn) {
	die("Unsuccessful connection to " . $ldaphost . " on port " . $ldapport . "<br />");	
} else {
	ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); 
	$baseDN = "OU=*******, DC=*******, DC=*******"; //Path to directory	(Data removed for security purposes)
}
?>