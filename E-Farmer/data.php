<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$conn = new mysqli("localhost", "root", "", "efarmer");

	if (isset($_POST['update'])) {
		$orderid = $_POST['orderid'];
		$status = $_POST['status'];
		$user = "";
		$productname = "";
		$quantity = "";
		$price = "";

		$sql = "select * from boughtproducts where orderid='".$orderid."'";
		$res = $conn->query($sql);
		if ($res->num_rows > 0) {
		    	while($row = $res->fetch_assoc()) {
				$user = $row['user'];
				$productname = $row['productname'];
				$quantity = $row['quantity'];
				$price = $row['price'];
			}
		}

		$sql = "update boughtproducts set status='".$status."' where orderid=".$orderid;	
		$conn->query($sql);

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
		$mail->addAddress($user);


		$mail->isHTML(true);                                 
		$mail->Subject = 'Order Status';
		$mail->Body    = '<html>
		<body>
		<div style="height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> Order Status </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Product                     : ' . $productname . ' </a> 			</p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : ' . $quantity . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Total Amount           : ' . $price . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Status                      : ' . $status . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Payment Mode        : Cash </a></p>

		</div>
		<br><br><a href="localhost/main.php" type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;"  class="radio">Visit Website</a></p>
	</div>
</body>
</html>' ;

	$mail->send();
	echo '<script type="text/javascript">';
	echo ' alert("Order status updated.")';
	echo '</script>';
	}
?>

<html>
<head>
	<link rel="stylesheet" href="company.css">
</head>
<body>

<p align="center" id="tagline">E-Farm</p>
<div id="container">
	<div id="signreplace">
		<form method="post">
			<br>
			 <input type="number" name="orderid" placeholder="Order Id" class="textbox" required/><br>
			 <input type="text" name="status"  placeholder="Status" class="textbox" required/><br>
			<input type="submit" value="Update" name="update" class="signbtn"">

		</form>
	</div>
</div>

</body>
</html>
