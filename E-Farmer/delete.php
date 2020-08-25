<?php

 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "efarmer";
$conn =new mysqli($servername,$username,$password,$dbname);


$id = $_GET['id'];

$sql = "delete from cropsell where id='$id'";

$data = mysqli_query($conn,$sql);
if($data)
{
  
  echo "<font-color='green'>Crop Deleted ";
  
  
  header('Location:sell.php');
}
else
{
  echo "<font-color='red'>Crop  Not Deleted ";
  header('Location:sell.php');
}

 mysqli_close($conn); 
?>
