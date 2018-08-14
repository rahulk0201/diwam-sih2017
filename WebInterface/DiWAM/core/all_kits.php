<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

if(isset($_GET['kit_id'])) {
    // id index exists
    $id = $_GET['kit_id'];
    //query
	$sql = "select * from kits where kit_id = $id";
	//get results
	$result = mysqli_query($db, $sql);

	//echo json
	$rows = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $rows[]=$row;
	    }
	} 

	echo json_encode($rows);
}
else {
	//query
	$sql = "select * from kits";

	//get results
	$result = mysqli_query($db, $sql);

	//echo json
	$rows = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $rows[]=$row;
	    }
	} 

	echo json_encode($rows);
}

?>