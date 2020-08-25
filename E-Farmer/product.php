<?php
	$name = null;
	$user = null;
	$login = 'Sign In';
	if (isset($_GET['user']) && !empty($_GET['user'])) {
		$name = $_GET['name'];
		$user = $_GET['user'];
		$login = 'Sign Out';
	}
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="productstyle.css">
</head>
<body>

<div id="tagline">
	<img src="logo.png" id="logo">	
	<p id="brand"> E-Farm </p>
	<a id="login" href="login.php?login=<?php echo $login ?>&page=product" name="login"> <?php echo $login ?> </a> 
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
		<select name="product" id="search">
			<option value="" selected disabled hidden>None</option>
			<?php 
				$conn = new mysqli("localhost", "root", "", "efarmer");
				$sql = "select type from agroproducts group by type order by type asc";
				$res = $conn->query($sql);
				if ($res->num_rows > 0) {
				    	while($row = $res->fetch_assoc()) {
						echo '<option value="'.$row['type'].'">'.$row['type'].'</option>';
					}
				}
			?>
		</select>
		<button type="submit" name="search" id="search">Search</button>
		<input type="button" id="myorder" onclick="openorder()" value="My Orders">
	</form>
</div>

<div id="displayProduct">
	<?php
	$conn = new mysqli("localhost", "root", "", "efarmer");

	if (isset($_POST['search'])) {
	$count = 1;
	$sql = "select * from agroproducts where type='" . $_POST['product'] . "'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()) {
			$productid = $row['id'];
			echo '<div class="product"><form method="POST" action="storebuyproduct.php">
			<p> <img src="data:image;base64,'.$row['image'].'" class="productimage" name="image">
			<a class="infotag">Product Name :  </a><a class="productinfo">'.$row['name'].'</a>
			<br><br><a class="infotag">MRP                :  </a><a class="productinfo">'.$row['mrp'].'</a>
			<br><br><a class="infotag">Price                :  </a> <a class="productinfo">'.$row['price'].' (Includuing All Taxes.)</a>
			<br><br><a class="infotag">You Save         :  </a><a class="productinfo">'.(floatval($row['mrp']) - floatval($row['price'])).'</a><br>
			<br><div class="productdesc"><a class="infotag"><br>Product Description<br><br></a><a class="productinfo">'.$row['prodesc'].'</a></div>
			<p align="center"> <input type="button" value="+"class="quantity" 					onclick="increase('. $count .')">
			<input type="text" class="quantity" name="showquan" id="showquan'. $count .'" readonly value="1">
			<input type="button" value="-"class="quantity" onclick="decrease('. $count .')"> </p>
			<p style="text-align:center;"><button type="submit" name="buybutton" class="buybutton" value="' . $user . "*" . $name . '#' .$productid.'">Buy</Search></button></p>
			</p></form>
			</div>';
			$count++;
	    	}
	} }
?>
</div>

<div id="showorder">
	<div id="orders">
		<p id="tagname"> Your Orders </p>
		<div style="overflow-y:scroll;max-height:70%;border:2px solid green;">
		<table id="table">
			<tr>
			<th> Order Id </th>
			<th> Date </th>
			<th> Product Name </th>
			<th> Quantity</th>
			<th> Price </th>
			<th> Status </th>
			<th> Action </th>
			</tr>
			<?php
				$conn = new mysqli("localhost", "root", "", "efarmer");

				$sql = "select * from boughtproducts where user='".$user."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				    	while($row = $result->fetch_assoc()) {
						$orderid = $row['orderid'];
						$date = date("d/m/Y", strtotime($row['dt'])); 
						echo '	<tr> <form method="post" action="cancelorder.php">
							<td> '. $row['orderid'] .' </td>
							<td> '. $date .' </td>
							<td> '. $row['productname'] .' </td>
							<td> '. $row['quantity'] .' </td>
							<td> '. $row['price'] .'</td>
							<td> '. $row['status'] .'</td> ';
						if ($row['status'] == "Pending") {
							echo '<td align="center"> <button type="submit" value="' . $user . "*" . $name . '#' .$orderid.'" name="cancelbutton">Cancel</button> </td>';
						} else {
							echo '<td> </td>';						
						}
						echo '</form> </tr>';					
					}
		 		}
			?>
		</table>
		</div>
	</div>
</div>
<script>
	var number = 1;
	var modal = document.getElementById('showorder');

	function openorder() {
		modal.style.display = "block";	
	}
	function increase(param1) {
		number = parseInt(document.getElementById('showquan'+param1).value);
		number += 1;
		if (number > 5) {
			number = 5;		
		}
		document.getElementById('showquan'+param1).value = number;
	}
	function decrease(param1) {
		number = parseInt(document.getElementById('showquan'+param1).value);
		number -= 1;
		if (number < 0) {
			number = 0;		
		}
		document.getElementById('showquan'+param1).value = number;
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
</script>
</body>
</html>
