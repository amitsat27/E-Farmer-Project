<?php
	$id = $_POST['cancelbutton'];
	$name = substr($id,strpos($id,"*")+1,strpos($id,"#"));
	$user = substr($id,0,strpos($id,"*"));
	$orderid = substr($id,strpos($id,"#")+1);	

	$conn = new mysqli("localhost", "root", "", "efarmer");

	$sql = "delete from boughtproducts where orderid='". $orderid ."'";
	$conn->query($sql);
	header("Location:product.php?user=$user&name=$name");	
?>
