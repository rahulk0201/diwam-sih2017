<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//query
$sql = "select DISTINCT s.state, sa.safe_sources, uns.unsafe_sources from calculation s LEFT OUTER JOIN (SELECT state, COUNT(Distinct(kit_id)) as safe_sources from calculation WHERE status LIKE 'safe' GROUP BY state) sa ON s.state = sa.state LEFT OUTER JOIN (SELECT state, COUNT(Distinct(kit_id)) as unsafe_sources from calculation WHERE status LIKE 'Unsafe' GROUP BY state) uns ON s.state = uns.state";

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