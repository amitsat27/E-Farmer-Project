<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	if ($login = $_GET['login'] == 'Sign Out') {
		header('Location:' . $_GET['page'] . '.php');
	}

	$conn = new mysqli("localhost", "root", "", "efarmer");
	if(array_key_exists('signinbtn', $_POST)) {	
    		$email = $_POST["user"];
		$pass = $_POST["pass"];
		$sql = "SELECT first, last, email, pass FROM users";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
	  		while($row = $result->fetch_assoc()) {
				if ($row['email'] == $email && $row['pass'] == $pass) {
					$user = $row['email'];
					$name = "Hi, " . $row['first'] . " " . $row['last'];
					header('Location:' . $_GET['page'] . '.php?user='.$user.'&name='.$name);
					exit;
				}
	    		} 
		}
		echo '<script type="text/javascript">';
		echo 'alert("Invalid credentials.")';
		echo '</script>';	
	}

	if(array_key_exists('signupbtn', $_POST)) {
		$first = $_POST["first"];
		$last = $_POST["last"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$address = $_POST["address"];
		$pass1 = $_POST["pass1"];
		$pass2 = $_POST["pass2"];
		$type = $_POST["type"];	
		$bool = true;
	
		$sql = "select email from users";
		$res = $conn->query($sql);
		if ($res->num_rows > 0) {
		    	while($row = $res->fetch_assoc()) {
				if ($email == $row['email']) {
					$bool = false;	
					break;
				}
			}
		}
			
            	$sql = "INSERT INTO users (first, last, email, phone, address, pass, type) VALUES ('$first','$last','$email','$phone','$address','$pass1','$type')";
		
		if ($bool) {
			if ($pass1 == $pass2 && $bool) {
				if ($conn -> query($sql) == TRUE) {
					echo '<script type="text/javascript">';
					echo ' alert("Registration Successful.")';
					echo '</script>';
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
				    	$mail->addAddress($email);

				    	$mail->isHTML(true);                                 
				    	$mail->Subject = 'Registration Successful';
				    	$mail->Body    = '<html>
	<body>
		<div style="height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
			<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;">E-Farm</p>
			<p width=50% style="margin-left:12.5%;font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;">Hi, ' . $first . ' ' . $last . ' <br><br> Welcome to <u><b> E-Farm </u></b> community. You have successfully registered for E-Farm Portal. It is our pleasure to serve you. Do enjoy our services.</p>
			<br><a href="localhost/main.php" type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;"  class="radio">Visit Website </a></p>
		</div>
	</body>
	</html>';

			    		$mail->send();	
				}
			} else {
				echo '<script type="text/javascript">';
				echo ' alert("Password does not match.")';
				echo '</script>';
			}
		} else {
			echo '<script type="text/javascript">';
			echo ' alert("Email already registered.")';
			echo '</script>';
		}
        } 
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="loginstyle.css">
</head>
<body>

<p align="center" id="tagline">E-Farm</p>
<div id="container">
	<input type="button" id="signinreplace" value="Sign In" class="sign" onclick="change('signin','signup','signinreplace','signupreplace')">
	<input type="button" id="signupreplace" value="Sign Up" class="sign" onclick="change('signup','signin','signupreplace','signinreplace')">
	<div id="signreplace">
		<div id="signin" class="toreplace">
			<form method="post">
			<p class="tags" align="center"> Username </p> <input type="text" name="user" class="textbox" placeholder="Username" required> 
			<p class="tags" align="center"> Password </p> <input type="password" name="pass" class="textbox" placeholder="Password" required><br><br>
			<input type="submit" name="signinbtn" class="signbtn" value="Sign In">
			</form>
			<div style="text-align:center; padding-top:5%;">
			<a href="forgot.php?page=<?php echo $_GET['page'] ?>" id="forgot"> Forgot password? </a>
			</div>
		</div>

		<div id="signup" class="toreplace">
			<form method="post">
			<p class="tags" align="center"> First Name </p> <input type="text" name="first" class="textbox" required> 
			<p class="tags" align="center"> Last Name </p> <input type="text" name="last" class="textbox" required>
			<p class="tags" align="center"> Email </p> <input type="email" name="email" class="textbox" required> 
			<p class="tags" align="center"> Phone </p> <input type="number" name="phone" class="textbox" required>
			<p class="tags" align="center"> Address </p> <input type="text" name="address" class="textbox" required>
			<p class="tags" align="center"> Password </p> <input type="password" name="pass1" class="textbox" required>
			<p class="tags" align="center"> Confirm Password </p> <input type="password" name="pass2" class="textbox" required> <br>
			<p><a class="radio"> Farmer <input type="radio" name="type" value="Farmer" required> </a>
			<a class="radio"> Supplier <input type="radio" name="type" value="Supplier" required> </a> <br><br>
			<input type="submit" name="signupbtn" class="signbtn" value="Sign Up" class="radio"></p>
			</form>
		</div>
	</div>
</div>
<img src="logo.png" id="photo"><br>

<script>
	change('signin', 'signup', 'signinreplace','signupreplace');
	function change(param1, param2, param3, param4) {
		document.getElementById(param1).style.display = "block";
		document.getElementById(param2).style.display = "none";
		document.getElementById(param3).style.background = "white";
		document.getElementById(param3).style.color = "#004b00";
		document.getElementById(param4).style.background = "#004b00";
		document.getElementById(param4).style.color = "white";
	}
</script>

</body>
</html>
