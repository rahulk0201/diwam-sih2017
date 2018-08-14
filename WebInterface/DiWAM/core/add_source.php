<?php

include 'config.php';
$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//declaring variables
$source = $state = $lat = $long = $pincode = "";
$Err = "";

//Login
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$source = $_POST['source'];
	$source = mysqli_real_escape_string($db,$source);
	$state = $_POST['state'];
	$state = mysqli_real_escape_string($db,$state);
	$pincode = $_POST['pincode'];
	$pincode = mysqli_real_escape_string($db,$pincode);
	$lat = $_POST['latitude'];
	$lat = mysqli_real_escape_string($db,$lat);
	$long = $_POST['longitude'];
	$long = mysqli_real_escape_string($db,$long);

	$sql="INSERT INTO `sources`( `source`, `pincode`, `state` , `latitude`, `longitude` ) VALUES ( '$source' , '$pincode', '$state' , '$lat', '$long' )";

	if ($db->query($sql) === TRUE) {
		header("Location: ../sources.php");
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	}

}

?>