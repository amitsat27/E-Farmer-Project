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
<link rel="stylesheet" type="text/css" href="ask.css">
</head>
<body bgcolor="white">

<div id="tagline">
	<img src="logo.png" id="logo">	
	<p id="brand"> E-Farm </p>
	<a id="login" href="login.php?login=<?php echo $login ?>&page=main" name="login"> <?php echo $login ?> </a> 
	<p id="loginTag"> <?php echo $name ?> </p>
</div>

<div id="navigation">
	<a href="main.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Home</a>
	<a href="product.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Agro Products</a>
	<a href="sell.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Sell Crops</a>
	<a href="cropsposted.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Buy Crops</a>
	<a href="askquery.php?user=<?php echo $user ?>&name=<?php echo $name ?>" id="tabs">Ask Expert</a>
</div>

<div id="division" align="center">
<p id="header">Ask Question</p>

<html>
<body>

<form method="POST" action="getquery.php?user=<?php echo $user ?>">
<input type="text" name="topic" class="textbox" placeholder="Topic" required><br><br><br>
<textarea rows="4" cols="50" name="query" class="textbox" placeholder="Detailed Description" required>
</textarea> <br><br>
<input type="submit" name="<?php echo $user?>" value="Send Query" class="signbtn"> 
	
</form>
</div>

</body>
</html>



<?php


?>



</body>
</html>
