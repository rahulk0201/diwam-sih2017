<?php

//////////////////////////////////////////////////////////////////////////
// This script is called by the iot devices to feed data into the database
// This script contains the main logic for deciding whether a source is //
// safe or not. //////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

include 'config.php';

$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//get data from url
$kit_id = $_GET["kit_id"];
$ph = $_GET["ph"];
$ec = $_GET["ec"];
$tds = $_GET["tds"];
$turb = $_GET["turbidity"];
$orp = $_GET["orp"];
$temp = $_GET["temperature"];
$timestamp = date('Y-m-d G:i:s');

//params to be derived
$ph_anomaly = $ec_anomaly = $tds_anomaly = $orp_anomaly = $turb_anomaly = $temp_anomaly = 0;
$safe = true;
$status = 'Safe';
//get thresholds from kits table
$sql = "select * from kits where kit_id = $kit_id";

//get results
$result = mysqli_query($db, $sql);

$rows = array();

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $rows[]=$row;
    }

    //check for safe / unsafe
	if($ph > $rows[0]['ph_thres_max'] || $ph <$rows[0]['ph_thres_min']) {
		$ph_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}
	if($ec > $rows[0]['ec_thres_max'] || $ec <$rows[0]['ec_thres_min']) {
		$ec_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}
	if($tds > $rows[0]['tds_thres_max'] || $tds <$rows[0]['tds_thres_min']) {
		$tds_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}
	if($orp > $rows[0]['orp_thres_max'] || $orp <$rows[0]['orp_thres_min']) {
		$orp_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}
	if($turb > $rows[0]['turb_thres_max'] || $turb <$rows[0]['turb_thres_min']) {
		$turb_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}
	if($temp > $rows[0]['temp_thres_max'] || $temp <$rows[0]['temp_thres_min']) {
		$temp_anomaly = 1;
		$safe = false;
		$status = 'Unsafe';
	}

	//insert into kit_readings table, calculations table and today table
	$sql = "INSERT INTO `kit_readings` (`kit_id`, `ph`, `ec`, `tds`, `orp`, `turbidity`, `temperature`, `timestamp`) VALUES ('$kit_id', '$ph', '$ec', '$tds', '$orp', '$turb', '$temp', '$timestamp');";

	if ($db->query($sql) === TRUE) {
		
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	    echo $Err;
	}

	$sql = "INSERT INTO `calculation` (`kit_id`, `ph_anomaly`, `ec_anomaly`, `tds_anomaly`, `orp_anomaly`, `turb_anomaly`, `temp_anomaly`, `status`) VALUES ('$kit_id', '$ph_anomaly', '$ec_anomaly', '$tds_anomaly', '$orp_anomaly', '$turb_anomaly', '$temp_anomaly', '$status');";

	if ($db->query($sql) === TRUE) {
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	    echo $Err;
	}

	/*$sql = "INSERT INTO `today` (`kit_id`, `ph`, `ec`, `tds`, `orp`, `turbidity`, `temperature`, `ph_anomaly`, `ec_anomaly`, `tds_anomaly`, `orp_anomaly`, `turb_anomaly`, `temp_anomaly`, `status`) VALUES ('$kit_id', '$ph', '$ec', '$tds', '$orp', '$turb', '$temp', $ph_anomaly, $ec_anomaly, $tds_anomaly, $orp_anomaly, $turb_anomaly, $temp_anomaly '$status');";*/
	$sql = "INSERT INTO `today` (`kit_id`, `ph`, `ec`, `tds`, `orp`, `turbidity`, `temperature`, `ph_anomaly`, `ec_anomaly`, `tds_anomaly`, `orp_anomaly`, `turb_anomaly`, `temp_anomaly`, `status`) VALUES ($kit_id, $ph, $ec, $tds, $orp, $turb, $temp, $ph_anomaly, $ec_anomaly, $tds_anomaly, $orp_anomaly, $turb_anomaly, $temp_anomaly, '$status');";

	if ($db->query($sql) === TRUE) {
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	    echo $Err;
	}

	if(!$safe) {

		//get total admins
		$admins = 0;

		$sql = "select count(*) as admin_count from admin;";

		$result = mysqli_query($db, $sql);

		$rows = array();

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		        $rows[]=$row;
		    }

		    $admins = $rows[0]['admin_count'];
		}

		//insert into notifications table
		// $sql = "INSERT INTO `notifications` VALUES (NULL, $kit_id', $ph, $ec, $tds, $orp, $turb, $temp, $ph_anomaly, $ec_anomaly, $tds_anomaly, $orp_anomaly, $turb_anomaly, $temp_anomaly, '$timestamp'";
		$sql = "INSERT INTO `notifications` VALUES (NULL, '$kit_id', $ph, $ec, $tds, $orp, $turb, $temp, $ph_anomaly, $ec_anomaly, $tds_anomaly, $orp_anomaly, $turb_anomaly, $temp_anomaly, '$timestamp'";

		for($i=0;$i<$admins;$i++) {
			$sql.=", 0";
		}

		$sql.=");";

		if ($db->query($sql) === TRUE) {
		    
		} else {
		    $Err = "Error: " . $sql . "<br>" . $db->error;
		    echo $Err;
		}

	}
}

?>