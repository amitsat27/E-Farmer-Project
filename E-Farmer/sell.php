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

<html>
<head>
	<link rel="stylesheet" type="text/css" href="sell.css">
</head>
<body>


<div id="tagline">
	<img src="logo.png" id="logo">	
	<p id="brand"> E-Farm </p>
	<a id="login" href="login.php?login=<?php echo $login ?>&page=sell" name="login"> <?php echo $login ?> </a> 
	<p id="loginTag"> <?php echo $name ?> </p>
</div>

<div id="navigation">
	<a href="main.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Home</a>
	<a href="product.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Agro Products</a>
	<a href="sell.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Sell Crops</a>
	<a href="cropsposted.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Crops</a>
	<a href="askquery.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Ask Expert</a>
</div>

<div id="sellprod">
	<button id="tab1" class="tab_1" onclick="change('infopost','postedcrops','tab1','tab2')"> Sell a Crop </button>
	<button id="tab2" class="tab_1" onclick="change('postedcrops', 'infopost', 'tab2', 'tab1')"> Crops Posted </button>
</div>

<div id="infopost" class="column" style="display:none" align="center">
  
<p id="tab"> Crops Information </p>

	<form method="post" enctype="multipart/form-data" action="store_sell.php?name=<?php echo $name ?>&user=<?php echo $user ?>" id="tab3" class="Uploadform">
	Crop Name <input type="text" name="productname" required/><br>
	Image <input style="background:white;"  type="file" name="image" required/><br>
	Quantity <input type="text" name="quantity" required/><br>
	Price (per Kg) <input type="text" name="price" required/><br>
	Crop Description <input type="text" name="desc" required/><br>
	<input type="text" name="signdetails" style="display:none;" value="<?php echo $login ?>">
	<input type='submit' value='Upload' name='upload_data'">
	</form>
</div>
</div>

<div id="postedcrops" style="display:none">
<br>
	<br>
<table id="t01" align="center" border="1px" style="width:1200px;line-height:40px;font-family:arial, sans-serif;font-size:20px;">

	<tr>
		<th>Crop Name</th>
		<th>Quantity(in Kgs)</th>
		<th>Amount(in Rs)</th>
		<th>Remove Crops</th>
	</tr>
	<?php
	$conn = new mysqli("localhost", "root", "", "efarmer");

	$count = 1;
	$sql = "select * from cropsell where user='" . $user . "'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    	while($row = $result->fetch_assoc()) {
			echo'<tr>
			<td align="center">' . $row["CropName"] . '</td>
			<td align="center">' . $row["Quantity"] . '</td>
			<td align="center">' . $row["amount"] . '</td>
			<td align="center"><a href="delete.php?id=' . $row['id'] . '" style="text-decoration:none; color:red"">DeleteCrop</a></td>
			</tr>';
	    	}
	} 
	?>
</table>
</div>
</div>  

   

<script type="text/javascript">

change("infopost","postedcrops","tab1","tab2");

function change(param1, param2, param3, param4) {
	document.getElementById(param1).style.display = "block";
	document.getElementById(param2).style.display = "none";
	document.getElementById(param3).style.backgroundColor = "black";
	document.getElementById(param4).style.backgroundColor = "green";
	
}
</script>




</body>
</html>
