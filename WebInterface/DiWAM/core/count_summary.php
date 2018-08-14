<?php

header("Access-Control-Allow-Origin: *");
include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);

if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//query
$safe = 0;
$unsafe = 0;
$kits = 0;

$sql = "Select count(distinct(kit_id)) as safe from today where status like 'Safe'";
$result = mysqli_query($db, $sql);

$rows = array();
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $safe = $row["safe"];
    }
} 

$sql = "Select count(distinct(kit_id)) as unsafe from today where status like 'Unsafe'";
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

?>