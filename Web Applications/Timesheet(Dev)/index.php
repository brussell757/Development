<?php  
require 'php_scripts/session.php';
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=10">
		<title>Cape Henry Timesheet</title>
        <link href="images/cha.ico" rel="shortcut icon">
        <link href='http://fonts.googleapis.com/css?family=Play' rel='stylesheet' type='text/css'>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
    	<div id="page_container">
    		<img src="images/header.png" alt="CHA Header">
            <div id="content">
					<div id="login">
                        <h2>Employee Login</h2>
                		<img src="images/lock.png" alt="Lock Icon">
                		<form action="php_scripts/user_validation.php" method="post" name="login">
                			<input class="credintials" type="text" name="username" placeholder="Username" autocomplete="off"><br />
                			<input class="credintials" type="password" name="password" placeholder="Password"><br />
                    		<input type="checkbox" name="remember"><h4>Remember Me</h4><br />
          					<button type="submit" name="submit">Log In</button><br />
                		</form>
            		</div>
            </div>
        	<img class="footer" src="images/footer.png" alt="CHA Footer">
            <p class="footer_text">Copyright &copy; Cape Henry Associates 2014</p>
        </div>
	</body>
</html>
