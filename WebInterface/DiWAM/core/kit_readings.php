<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//query
$sql = "";

$data = $_GET['data'];

if(strcmp($data,"count") == 0) {
	$safe = 0;
	$unsafe = 0;
	$kits = 0;

	$sql = "Select count(*) as safe from calculation where status like 'Safe'";
	$result = mysqli_query($db, $sql);

	$rows = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $safe = $row["safe"];
	    }
	} 

	$sql = "Select count(*) as unsafe from calculation where status like 'Unsafe'";
	$result = mysqli_query($db, $sql);

	$rows = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $unsafe = $row["unsafe"];
	    }
	}

	$sql = "Select count(*) as kits from kits";
	$result = mysqli_query($db, $sql);

	$rows = array();
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $kits = $row["kits"];
	    }
	} 

	$total = $safe + $unsafe;

	echo '[{"safe":'.$safe.',"unsafe":'.$unsafe.',"total":'.$total.',"kits":'.$kits.'}]';
}

else if(strcmp($data,"state_summary") == 0) {

	$sql = "select DISTINCT s.state, sa.safe_sources, uns.unsafe_sources from calculation s, (SELECT state, COUNT(*) as safe_sources from calculation WHERE status LIKE 'safe' GROUP BY state) sa, (SELECT state, COUNT(*) as unsafe_sources from calculation WHERE status LIKE 'Unsafe' GROUP BY state) uns WHERE s.state = sa.state and sa.state = uns.state";

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

else if(strcmp($data, "unsafe_sources") == 0) {
	$sql = "select k.kit_id, k.source, s.state, k.ph, k.ec, k.do, k.bod, k.temperature, c.status, ca.ph_anomaly, ca.ec_anomaly, ca.do_anomaly, ca.bod_anomaly, ca.temperature_anomaly from kit_readings k,kits c, calculation ca, state_mapping s where k.kit_id = c.kit_id AND c.kit_id = ca.kit_id AND ca.kit_id = s.kit_id AND ca.status like 'Unsafe'";

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

else if(strcmp($data, "all") == 0) {

	$sql = "select k.kit_id, k.source, s.state, k.ph, k.ec, k.do, k.bod, k.temperature, c.status, ca.ph_anomaly, ca.ec_anomaly, ca.do_anomaly, ca.bod_anomaly, ca.temperature_anomaly from kit_readings k,kits c, calculation ca, state_mapping s where k.kit_id = c.kit_id AND c.kit_id = ca.kit_id AND ca.kit_id = s.kit_id";

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