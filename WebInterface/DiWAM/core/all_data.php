<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//query
$sql = "select s.kit_id, s.state, s.source, t.ph, t.ec, t.tds, t.orp, t.turbidity, t.temperature, t.ph_anomaly, t.ec_anomaly, t.tds_anomaly, t.orp_anomaly, t.turb_anomaly, t.temp_anomaly, s.latitude, s.longitude, t.timestamp, t.status from sources s LEFT OUTER JOIN today t ON t.kit_id = s.kit_id";

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

?>