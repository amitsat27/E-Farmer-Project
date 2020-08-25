<?php
	session_start();
	$user = null;

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
					$_SESSION['login'] = "Hi, " . $row['first'] . " " . $row['last'];
					header('Location:main.php');
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
		$pass = $_POST["password"];
		$type = $_POST["radio"];
            	$sql = "INSERT INTO users (first, last, email, phone, address, pass, type) VALUES 				('$first','$last','$email','$phone','$address','$pass','$type')";
		if ($conn -> query($sql) == TRUE) {
			echo '<script type="text/javascript">';
			echo ' alert("Registration Successful.")';
			echo '</script>';		
		} else {
			echo '<script type="text/javascript">';
			echo ' alert("Registration Unsuccessful")'; 
			echo '</script>';
		}
        } 
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="myModal" class="modal">
	<div class="modal-content">
		<button type="button" id="signin" class="sign" onclick="show('signindiv', 'signin', 'signup')"> Sign In </button>
		<button type="button" id="signup" class="sign" onclick="show('signupdiv', 'signup', 'signin')"> Sign Up </button>
	<div id="div">
	</div>
	</div>
</div>

<div id="signindiv" style="display:none">
	<form method="post">
		<p class="label"> Username </p> <input type="email" name="user" 				class="text" required><br>
		<p class="label"> Password </p> <input type="password" name="pass" 				class="text" required><br>
		<button type="submit" name="signinbtn" class="submit"> Sign In </button>
	</form>
</div>

<div id="signupdiv" style="display:none">
	<form method="post">
		<p class="label"> First Name </p> <input type="text" name="first" class="text" required><br>
		<p class="label"> Last Name </p> <input type="text" name="last" class="text" required><br>
		<p class="label"> Email </p> <input type="email" name="email" class="text" required><br>
		<p class="label"> Phone </p> <input type="number" name="phone" class="text" required><br>
		<p class="label"> Address </p> <input type="text" name="address" class="text" required><br>
		<p class="label"> Password </p> <input type="password" name="password" class="text" required><br>
		<label class="radioText"><input type="radio" class="radio" name="radio" value="farmer" required>Farmer</label>
		<label class="radioText"><input type="radio" class="radio" name="radio" value="supplier" required>Supplier</label>
		<button type="submit" name="signupbtn" class="submit">Sign Up</button>
	</form>
</div> 
<script type="text/JavaScript">
	show('signindiv', 'signin', 'signup');

	function show(param1, param2, param3) {
		document.getElementById('div').innerHTML = 							document.getElementById(param1).innerHTML;
		document.getElementById(param2).style.backgroundColor = "white";
		document.getElementById(param2).style.color = "green";
		document.getElementById(param3).style.backgroundColor = "green";
		document.getElementById(param3).style.color = "white";
	}
</script>
</body>
</html>
