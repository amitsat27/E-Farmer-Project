<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$quantity = $_POST['showquan'];
	$seller = $_POST['buybutton'];
	$name = $_GET['name'];
	$user = $_GET['user'];
	$crop = $_POST['crop'];
	$date = date("Y/m/d");
	$conn = new mysqli("localhost", "root", "", "efarmer");
	$phone = "";
	$sellername = "";
	$address = "";
	$login = $_POST['signdetails'];

	if ($login == "Sign In") {
		header("Location:login.php?login=$login&page=cropsposted");	
		return;
	}

	$sql = "select phone, address from users where email='".$user."'";
	$res = $conn->query($sql);
	if ($res->num_rows > 0) {
	    	while($row = $res->fetch_assoc()) {
			$phone = $row['phone'];
			$address = $row['address'];
		}
	}

	$sql = "select first, last from users where email='".$seller."'";
	$res = $conn->query($sql);
	if ($res->num_rows > 0) {
	    	while($row = $res->fetch_assoc()) {
			$sellername = $row['first'] . " " . $row['last'];
		}
	}

	if (isset($_POST['submit'])) {

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
	$mail->addAddress($seller);

	$mail->isHTML(true);                                 
	$mail->Subject = "New Order"; 
	$mail->Body = '<html>
<body>
	<div style="height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> New Order </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Crop                         : ' . $crop . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : ' . $quantity . '</a></p> <sp>
		<hr>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Buyer Detailes </a></p> <sp>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Name                       : ' . substr($name,4) . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Contact Number      : ' . $phone . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Email                       : ' . $user . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Address                   : ' . $address . '</a></p>

		</div>
		<br><br><a href="localhost/main.php" type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;"  class="radio">Visit Website</a></p>
	</div>
</body>
</html>' ; 

	$mail->send();

	$mail->addAddress($user);

	$mail->isHTML(true);                                 
	$mail->Subject = "Order Receipt"; 
	$mail->Body = '<html>
<body>
	<div style="height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> Order Receipt </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Farmer Name           : ' . $sellername . ' </a></p>
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Crop                         : ' . $crop . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : ' . $quantity . '</a></p> <sp>
		<hr>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Buyer Detailes </a></p> <sp>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Name                       : ' . substr($name, 4) . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Contact Number      : ' . $phone . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Email                       : ' . $user . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Address                   : ' . $address . '</a></p>
		</div>
		<br><br><a href="localhost/main.php" type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;"  class="radio">Visit Website</a></p>
	</div>
</body>
</html>' ; 

	$mail->send();
	header("Location:cropsposted.php?user=$user&name=$name");
	}
?>

<html>
<body>
	<div style="margin-left:25%; margin-top:5%; height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> Confirm Order </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Farmer Name           : <?php echo $sellername ?> </a></p>
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Crop                         : <?php echo $crop ?> </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : <?php echo $quantity ?></a></p> <sp>
		<hr>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Buyer Details </a></p> <sp>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Name                       : <?php echo substr($name, 4) ?></a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Contact Number      : <?php echo $phone ?> </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Email                       : <?php echo $user ?> </a></p>
		<p style="width:100%;overflow-x:scroll;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Address                    : <?php echo $address ?></a></p>
		<form method="post" action="buycrop.php?name=<?php echo $name ?>.&user=<?php echo $user ?>"> 
		<input type="text" style="display:none;" name="showquan" value="<?php echo $quantity ?>">
		<input type="text" style="display:none;" name="buybutton" value="<?php echo $seller ?>">
		<input type="text" style="display:none;" name="crop" value="<?php echo $crop ?>">
		<input type="text" style="display:none;" name="signdetails" value="<?php echo $login ?>">
		</div>
		<br><br><button type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;" name="submit" class="radio">Place Order</button></form></p>
	</div>
</body>
</html>	
