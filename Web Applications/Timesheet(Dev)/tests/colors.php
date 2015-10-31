<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="font-family: 'Courier New', Courier, monospace;">


<?php
$values = array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
//$values = array("0","1","F");

foreach ($values as $v) {
	$a = $v;
	echo "<br />";
	foreach ($values as $v) {
		$b = $v;
		echo "<br />";
		foreach ($values as $v) {
			$color = $a.$b.$v.$a.$b.$v;
			//$bgcolor = $v.$b.$a;
			//$color = $v.$e.$d.$c.$b.$a;
			?>
            <div style="float: left; background: #<?=$color;?>;">&nbsp;</div>
            <?php
			
		}	
	}	
}

?>




</body>
</html>