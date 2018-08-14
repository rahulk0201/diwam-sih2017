<?php

session_start();

include 'config.php';
$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//declaring variables
$source = $state = $kit_id = $pht = $ect = $tdst = $orpt = $turbt = $tempt = "";
$Err = "";
$admin_id = $_SESSION["admin_id"];

if(!empty($_POST['check_list'])){
// Loop to store and display values of individual checked checkbox.
	foreach($_POST['check_list'] as $selected){

		$sql="UPDATE notifications SET $admin_id = 1 WHERE notif_id = $selected";

		if ($db->query($sql) === TRUE) {
			header("Location: ../kits.php");
		    
		} else {
		    $Err = "Error: " . $sql . "<br>" . $db->error;
		}
	}
}

?>