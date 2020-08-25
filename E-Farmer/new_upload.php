<?php
	$conn = new mysqli("localhost", "root", "", "efarmer");

	$news = $_POST['news'];
	$news = $news . ' (' . date("d/m/Y") . ') ';

	$sql = "insert into news (news) values ('$news')";	
	if($conn->query($sql)) {
		header('Location:news.php');			
	} else {
		echo $conn->error;			
	}
?>
