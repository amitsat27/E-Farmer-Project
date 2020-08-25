<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$conn = new mysqli("localhost", "root", "", "efarmer");
	if(array_key_exists('reset', $_POST)) {	
    		$email = "vedantpadalkar@gmail.com";
		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		$sql = "SELECT first, last, email, pass FROM users";
		$result = $conn->query($sql);

		if ($pass1 != $pass2) {
			echo '<script type="text/javascript">';
			echo 'alert("Password does not match.")';
			echo '</script>';				
		} else

		if ($result->num_rows > 0) {
	  		while($row = $result->fetch_assoc()) {
				if ($row['email'] == $email) {
					$sql = "update users set pass='" . $pass1 . "' where email='" . $email . "'";
					$conn -> query($sql);
					echo '<script type="text/javascript">';
					echo 'alert("Password reset successful.")';
					echo '</script>';
					header('Location:main.php');
					exit;
				}
	    		} 
		}	
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
			<p class="tags" align="center"> Reset Password </p> 
			<input type="password" name="pass1" class="textbox" placeholder="  Password" required> <br><br>
			<input type="password" name="pass2" class="textbox" placeholder="  Cofirm Password" required> 
			<input type="submit" name="reset" class="signbtn" value="Reset">
			</form>
	</div>
</div>
</body>
</html>
