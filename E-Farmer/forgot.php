<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$page = $_GET['page'];

	if(array_key_exists('forgot', $_POST)) {
		$mail = new PHPMailer(true);
		$mail->SMTPDebug = false;                     
		$mail->isSMTP();                                           
		$mail->Host       = 'smtp.gmail.com';                    
		$mail->SMTPAuth   = true;                                
		$mail->Username   = 'efarmerportal@gmail.com';           
		$mail->Password   = 'efarmer@2411';                      
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      
		$mail->Port       = 587;                                 

		$mail->setFrom('no-reply@gmail.com', 'E-Farmer Portal');
		$mail->addAddress($_POST['user']);

		$mail->isHTML(true);                                 
		$mail->Subject = 'Registration Successful';
		$mail->Body    = '<b>Hi, Vedant Password </b> <br>     You are requested to reset password. Please click on link below to reset password <br> <a href="localhost/reset.php?user=vedantpadalkar@gmailcom">Click Here To Reset Password </a>';

		$mail->send();

		echo '<script type="text/javascript">';
		echo ' alert("We have sent you mail for reset.")';
		echo '</script>';

		header('Location:login.php?login=Sign In&page=' . $page);
	}
?>

<html>
<head>
	<link rel="stylesheet" href="loginstyle.css">
</head>
<body>

<p align="center" id="tagline">E-Farm</p>
<div id="container">
	<div id="signreplace">
		<form method="post">
			<p class="tags" align="center"> Forgot Password </p> 
			<input type="text" name="user" class="textbox" placeholder="Email" required> 
			<input type="submit" name="forgot" class="signbtn" value="Submit">
		</form>
	</div>
</div>
</body>
</html>
