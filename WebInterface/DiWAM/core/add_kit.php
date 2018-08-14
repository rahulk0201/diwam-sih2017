<?php

include 'config.php';
$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//declaring variables
$source = $state = $kit_id = $pht_min_min = $pht_min_max = $ect_min = $ect_max = $tdst_min = $tdst_max = $orpt_min = $orpt_max = $turbt_min = $turbt_max = $tempt_min = $tempt_max = "";
$Err = "";

//Login
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$source = $_POST['source'];
	$source = mysqli_real_escape_string($db,$source);
	$kit_id = $_POST['kit_id'];
	$kit_id = mysqli_real_escape_string($db,$kit_id);
	$pht_min = $_POST['pht_min'];
	$pht_min = mysqli_real_escape_string($db,$pht_min);
	$pht_max = $_POST['pht_max'];
	$pht_max = mysqli_real_escape_string($db,$pht_max);
	$ect_min = $_POST['ect_min'];
	$ect_min = mysqli_real_escape_string($db,$ect_min);
	$ect_max = $_POST['ect_max'];
	$ect_max = mysqli_real_escape_string($db,$ect_max);
	$tdst_min = $_POST['tdst_min'];
	$tdst_min = mysqli_real_escape_string($db,$tdst_min);
	$tdst_max = $_POST['tdst_max'];
	$tdst_max = mysqli_real_escape_string($db,$tdst_max);
	$orpt_min = $_POST['orpt_min'];
	$orpt_min = mysqli_real_escape_string($db,$orpt_min);
	$orpt_max = $_POST['orpt_max'];
	$orpt_max = mysqli_real_escape_string($db,$orpt_max);
	$turbt_min = $_POST['turbt_min'];
	$turbt_min = mysqli_real_escape_string($db,$turbt_min);
	$turbt_max = $_POST['turbt_max'];
	$turbt_max = mysqli_real_escape_string($db,$turbt_max);
	$tempt_min = $_POST['tempt_min'];
	$tempt_min = mysqli_real_escape_string($db,$tempt_min);
	$tempt_max = $_POST['tempt_max'];
	$tempt_max = mysqli_real_escape_string($db,$tempt_max);
	$date = date("d-m-Y");

	$sql="INSERT INTO `kits` (`kit_id`, `source`, `ph_thres_min`, `ph_thres_max`, `ec_thres_min`, `ec_thres_max`, `tds_thres_min`, `tds_thres_max`, `orp_thres_min`, `orp_thres_max`, `turb_thres_min`, `turb_thres_max`, `temp_thres_min`, `temp_thres_max`, `date_of_deployment`, `kit_status`) VALUES ('$kit_id', '$source', '$pht_min', '$pht_max', '$ect_min', '$ect_max', '$tdst_min', '$tdst_max', '$orpt_min', '$orpt_max', '$turbt_min', '$turbt_max', '$tempt_min', '$tempt_max', '$date', 'WORKING');";

	if ($db->query($sql) === TRUE) {
		header("Location: ../kits.php");
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	}

}

?>