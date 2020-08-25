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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="mainstyle.css">
</head>
<body>

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

<div>
	<div id="slideshow">
		<div class="division">
			<img src="image1.jpg" style="width:100%;height:100%;">
		</div>

		<div class="division">
			<img src="image2.jpg" style="width:100%;height:100%;">
		</div>

		<div class="division">
			<img src="image3.jpg" style="width:100%;height:100%;">
		</div>

		<div class="division">
			<img src="image4.jpg" style="width:100%;height:100%;">
		</div>

		<div class="division">
			<img src="image5.jpg" style="width:100%;height:100%;">
		</div>
	</div>
</div>

	<p align="center" id="abouttag"> <img src="crop.jpg" height=50 width=100> About Us <img src="crop.jpg" height=50 width=100> </p>
	<div id="aboutdiv"> <p id="about"> Our Site provides the farmer with the same idea so that farmer should be able to sell crops as per there harvesting seasons. Farmers are able to sell their crops they are also able to get relevant information about crops and Agro products pesticides , other chemicals which are needed for the crops and which are suitable for the crops . This site will give farmer a correct guide to manage their farming related activities. <br> </p> </div>

	<p align="center" id="abouttag"> <img src="crop.jpg" height=50 width=100> News <img src="crop.jpg" height=50 width=100> </p>
	<div id="aboutdiv"> <div id="about" align="center"> <marquee direction=up scrollamount=3 id="marquee"> 

	<?php
		$array_result = null;

		$conn = new mysqli("localhost", "root", "", "efarmer");

		$sql = "select * from news";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    	while($row = $result->fetch_assoc()) {
				$array_result[] = $row['news'];
		    	}
		}
		foreach(array_reverse($array_result) as $news) {
			echo '<p id="news">' . $news . '</p>';		
		}
	?>

 	</marquee> </div> </div>

	<p align="center" id="abouttag"> <img src="crop.jpg" height=50 width=100> Services <img src="crop.jpg" height=50 width=100> </p>
	<div id="aboutdiv"> <div id="about" align="center"> 
	<div id="desc"> <p id="about"> Agro Products <br><br> We helps farmers in optimizing their production. We do so by developing, registering and internationally marketing a wide range of generic and innovative plant protection products <br><br><br> <a class="sell" href="product.php"> Buy Now </a> </p> </div> 

	<div id="desc"> <p id="about"> Advertising Harvest <br><br>  We helps farmers to sell their produce at right price benefiting both famrers and consumers <br><br><br><br><br><br> <a class="sell" href="cropsposted.php"> Check Portal </a> </p> </div>

	<br> <div id="desc"> <p id="about">  Expert Advice <br><br>  Our expert gives advise to farmer so that they can grew their harvest without any loss <br><br><br> <a class="sell" href="askquery.php"> Take Advise </a> </p> </div>	
	</div> </div> <br><br><br><br>

<script type="text/JavaScript">
	var news = document.getElementById("news");
	var slideIndex = 0;

	showSlides();

	function showSlides() {
		var i;
		var slides = document.getElementsByClassName("division");
	  	for (i = 0; i < slides.length; i++) {
	    		slides[i].style.display = "none";  
	  	}
	  	slideIndex++;
	  	if (slideIndex > slides.length) {
			slideIndex = 1;
		}  
	  	slides[slideIndex-1].style.display = "block"; 
		setTimeout(showSlides, 2000);
	}
</script>
</body>
</html>
