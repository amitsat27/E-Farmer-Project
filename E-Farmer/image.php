<?php
	$conn = new mysqli("localhost", "root", "", "efarmer");

	if (isset($_POST['upload_data'])) {
		if ($_FILES['image']['error'] == 0) {
			if (getimagesize($_FILES['image']['tmp_name']) != FALSE) {
					$productname = $_POST['productname'];
					$mrp = $_POST['mrp'];
					$price = $_POST['price'];
					$prodesc = $_POST['prodesc'];
					$category = $_POST['category'];

					$image = addslashes($_FILES['image']['tmp_name']);
					$image = file_get_contents($image);
					$image = base64_encode($image);
					$sql = "insert into agroproducts (name, type, mrp, price, prodesc, image) values ('$productname', '$category','$mrp','$price','$prodesc','$image')";	
					$conn->query($sql);
					echo '<script type="text/javascript">';
					echo ' alert("New product added.")';
					echo '</script>';
			}	
		}
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
			<br>
			<form method="post" enctype='multipart/form-data'>
<input type="text" name="productname" class="textbox" placeholder="Product Name" required/><br>
<input type="text" name="category" class="textbox" placeholder="Category" required/><br>
<input type="text" name="mrp" class="textbox" placeholder="MRP" required/><br>
<input type="text" name="price" class="textbox" placeholder="Price" required/><br>
<input type="text" name="prodesc" class="textbox" placeholder="Product Descrption" required/><br>
<p align="center"> <a class="tags"> Image </a> </p><input type="file" name="image" class="textbox" required/><br>
<input type='submit' value='Upload' name='upload_data' class="signbtn" ">

		</form>
	</div>
</div>

</body>
</html>
