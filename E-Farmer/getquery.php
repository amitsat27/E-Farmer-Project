<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'vendor/autoload.php';

	$topic = $_POST['topic'];
	$query = $_POST['query'];
	$user = $_GET['user'];

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
    	$mail->addAddress('efarmerportal@gmail.com');
    	$mail->isHTML(true);                                 
    	$mail->Subject = 'New Query';
    	$mail->Body    = '<br> <b> User : </b>' . $user . '<br> <b> Topic : </b>' . $topic . '<br> <b> Query : </b>' . $query;
	$mail->send();	
	header("Location:askquery.php");
?>
