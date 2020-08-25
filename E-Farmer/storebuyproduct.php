<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$quantity = $_POST['showquan'];
	$id = $_POST['buybutton'];
	$name = substr($id,strpos($id,"*")+1,strpos($id,"#"));
	$user = substr($id,0,strpos($id,"*"));
	$id = substr($id,strpos($id,"#")+1);
	$date = date("Y/m/d");
	$address = "";
	$productimage;
	$actualprice = "";
	$price = "";

	if ($user == "#") {
		$login = "Sign In";
		header("Location:login.php?login=SignIn&page=product");
		return;
	} 

	$conn = new mysqli("localhost", "root", "", "efarmer");

	$sql = "select address from users where email='".$user."'";
	$res = $conn->query($sql);
	if ($res->num_rows > 0) {
	    	while($row = $res->fetch_assoc()) {
			$address = $row['address'];
		}
	}

	$sql = "select image from agroproducts where id='".$id."'";
	$res = $conn->query($sql);
	if ($res->num_rows > 0) {
	    	while($row = $res->fetch_assoc()) {
			$productimage = $row['image'];
		}
	}

	$sql = "select * from agroproducts where id='". $id ."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    	while ($row = $result->fetch_assoc()) {
			if ($row['id'] == $id) {
				$actualprice = $row['price'];
				$price = ($row['price'] * $quantity);
				$productname = $row['name'];
			}
		}
	}

	if(isset($_POST['submit'])) {
				$sql = "insert into boughtproducts (dt, user, productname, quantity, status, price) values ('$date','$user','$productname','$quantity','Pending','$price')";
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
			    	$mail->Subject = 'Order Confirmation';
			    	$mail->Body    = '<html>
<body>
	<div style="height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> Order Confirmation </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Product                     : ' . $productname . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : ' . $quantity . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Price                         : ' . $actualprice . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Total Amount           : ' . $price . '</a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Delivery Address     : ' . $address . ' </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Payment Mode        : Cash </a></p>

		</div>
		<br><br><a href="localhost/main.php" type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;"  class="radio">Visit Website</a></p>
	</div>
</body>
</html>' ;

	$mail->send();
	header("Location:product.php?user=$user&name=$name");
	}
?>

<html>
<body>
	<div style="margin-left:25%; margin-top:5%; height:auto; width:50%; border:2px black solid; padding-bottom:2%;">
		<p align="center" style="margin-top:0%;font-size:400%;color:white;background-color:green;border-bottom:2px white solid;"> <a> E-Farm </a> </p>
		<p align="center" style="margin-top:-7%;font-size:200%;color:white;background-color:brown;"> <a> Order Confirmation </a> </p>
		<div style="height:auto; margin-left:12.5%; width:75%; border:2px black solid; padding:2%;">
		<p style="width:100%;"><a width=50% style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Product                     : <?php echo $productname ?> </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Quantity                   : <?php echo $quantity ?></a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Price                         : <?php echo $actualprice ?> </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Total Amount           : <?php echo $price ?></a></p>
		<p style="width:100%;overflow-x:scroll;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Delivery Address     : <?php echo $address ?> </a></p>
		<p style="width:100%;"><a style="font-size:125%;color:#004b00;text-decoration:none;padding-right:12.5%;white-space:pre;"> Payment Mode        : Cash </a></p>
		<form method="post" action="storebuyproduct.php"> 
		<input type="text" style="display:none;" name="showquan" value="<?php echo $_POST['showquan'] ?>">
		<input type="text" style="display:none;" name="buybutton" value="<?php echo $_POST['buybutton'] ?>">
		</div>
		<br><br><button type="submit" style="margin-left:37.5%;padding:1% 5%;background-color:#004b00;color:white;font-size:125%;border:2px solid white;border-radius:10% / 50%;text-decoration:none;" name="submit" class="radio">Confirm Order</button></form></div></p>
	</div>
</body>
</html>
