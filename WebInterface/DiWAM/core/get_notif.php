<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

if(isset($_GET['admin_id'])) {

	$column_name = $_GET['admin_id'];

	$sql = "select n.notif_id, n.kit_id, s.source, s.state, n.ph, n.ec, n.tds, n.orp, n.turbidity, n.temperature from notifications n, sources s where n.kit_id = s.kit_id AND $column_name = 0";

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