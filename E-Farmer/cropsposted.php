<?php
	$name = '';
	$user = '#';
	$login = 'Sign In';
	if (isset($_GET['user']) && !empty($_GET['user'])) {
		$name = $_GET['name'];
		$user = $_GET['user'];
		$login = 'Sign Out';
	}
?>

﻿<html>
<head>
<link rel="stylesheet" type="text/css" href="postedstyle.css">
</head>
<body>
<div id="tagline">
	<img src="logo.png" id="logo">	
	<p id="brand"> E-Farm </p>
	<a id="login" href="login.php?login=<?php echo $login ?>&page=cropsposted"> <?php echo $login ?> </a> 
	<p id="loginTag"> <?php echo $name ?> </p>
</div>

<div id="navigation">
	<a href="main.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Home</a>
	<a href="product.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Agro Products</a>
	<a href="sell.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Sell Crops</a>
	<a href="cropsposted.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Crops</a>
	<a href="askquery.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Ask Expert</a>
</div>

<div id="filter">
	<form method="post">
		<p class="tag">Product Name</p>
		<select name="crop" id="search">
			<option value="" selected disabled hidden>None</option>
			<?php 
				$conn = new mysqli("localhost", "root", "", "efarmer");
				$sql = "select CropName from cropsell group by CropName order by CropName asc";
				$res = $conn->query($sql);
				if ($res->num_rows > 0) {
				    	while($row = $res->fetch_assoc()) {
						echo '<option value="'.$row['CropName'].'">'.$row['CropName'].'</option>';
					}
				}
			?>
		</select>
		<button type="submit" name="search" id="search">Search</button>
	</form>
</div>

<div id="displayProduct">
	<?php
	$conn = new mysqli("localhost", "root", "", "efarmer");
	if (isset($_POST['search'])) {
		$cropname = $_POST['crop'];
		$sql = "select * from cropsell where CropName='" . $cropname. "'";
		$result = $conn->query($sql);
		$count = 0;
		if ($result->num_rows > 0) {
		    	while($row = $result->fetch_assoc()) {
				$seller = $row['user'];
				echo '<div class="product"><form method="POST" action="buycrop.php?name=' . $name . '&user=' . $user . '">
				<p> <img src="data:image;base64,'.$row['image'].'" class="productimage" name="productimage">
				<a class="infotag">Farmer Name      : </a> <a class="productinfo">'.$row['name'].'</a><br>
				<br><a class="infotag">Product Name     : </a><a class="productinfo">'.$row['CropName'].'</a>
				<br><br><a class="infotag">Quantity              : </a><a class="productinfo">'.$row['Quantity'].'</a>
				<br><br><a class="infotag">Price per(Kg)      : </a> <a class="productinfo">'.$row['amount'].'</a><br>			
				<div class="productdesc"><a class="infotag"><br>Description<br><br></a><a class="productinfo">' . $row['description'] . '</a></div>
				<p align="center"> <input type="button" value="+"class="quantity" 					onclick="increase('. $count .')">
				<input type="text" class="quantity" name="showquan" id="showquan'. $count .'" value="1">
				<input type="button" value="-"class="quantity" onclick="decrease('. $count .')"> </p>	
				<input type="text" name="signdetails" style="display:none;" value="' . $login . '">
				<input type="text" name="crop" style="display:none;" value="' . $row['CropName'] . '">
				<p style="text-align:center;"><button type="submit" name="buybutton" class="buybutton" value="' . $seller . '">Buy</button></p><br><br>
				</p></form><br><br>
				</div>';
				$count += 1;
		    	}
		} 
	}
?>
</div>
<script>
	var number = 1;
	var modal = document.getElementById('showorder');

	function increase(param1) {
		number = parseInt(document.getElementById('showquan'+param1).value);
		number += 1;
		document.getElementById('showquan'+param1).value = number;
	}
	function decrease(param1) {
		number = parseInt(document.getElementById('showquan'+param1).value);
		number -= 1;
		document.getElementById('showquan'+param1).value = number;
	}
</script>
</body>
</html>
