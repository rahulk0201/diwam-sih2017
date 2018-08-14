<?php

include 'config.php';
$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//declaring variables
$source = $kit_id = $pht = $ect = $tdst = $orpt = $turbt = $tempt = "";
$Err = "";

//Login
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$source = $_POST['source'];
	$source = mysqli_real_escape_string($db,$source);
	$kit_id = $_POST['kit_id'];
	$kit_id = mysqli_real_escape_string($db,$kit_id);
	$pht = $_POST['pht'];
	$pht = mysqli_real_escape_string($db,$pht);
	$ect = $_POST['ect'];
	$ect = mysqli_real_escape_string($db,$ect);
	$tdst = $_POST['tdst'];
	$tdst = mysqli_real_escape_string($db,$tdst);
	$orpt = $_POST['orpt'];
	$orpt = mysqli_real_escape_string($db,$orpt);
	$turbt = $_POST['turbt'];
	$turbt = mysqli_real_escape_string($db,$turbt);
	$tempt = $_POST['tempt'];
	$tempt = mysqli_real_escape_string($db,$tempt);

	$sql = "UPDATE `kits` SET `ph_threshold`=$pht,`ec_threshold`=$ect,`tds_threshold`=$tdst,`orp_threshold`=$orpt,`turb_threshold`=$turbt,`temp_threshold`=$tempt WHERE kit_id = $kit_id";

	if ($db->query($sql) === TRUE) {
		header("Location: ../kits.php");
	    
	} else {
	    $Err = "Error: " . $sql . "<br>" . $db->error;
	    echo $Err;
	}

}

?>