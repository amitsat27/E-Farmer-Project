<?php
	$name = $_GET['name'];
	$actual = substr($name, 4);
	$user = $_GET['user'];
	$login = $_POST['signdetails'];
	$conn = new mysqli("localhost", "root", "", "efarmer");

	if ($login == "Sign In") {
		header("Location:login.php?login=$login&page=sell");	
		return;

	}

	if ($_FILES['image']['error'] == 0) {
		if (getimagesize($_FILES['image']['tmp_name']) != FALSE) {
			$productname = $_POST['productname'];
			$quantity = $_POST['quantity'];
			$amount = $_POST['price'];
			$desc = $_POST['desc'];

			$image = addslashes($_FILES['image']['tmp_name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
			$sql = "INSERT INTO cropsell (user,CropName,image,quantity,amount,name,description) VALUES ('$user','$productname', '$image', '$quantity','$amount','$actual', '$desc')";
			$conn->query($sql);
			header("Location:sell.php?user=$user&name=$name");
		}	
	}
?>

