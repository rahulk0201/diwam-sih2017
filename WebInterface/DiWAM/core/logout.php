<?php
	
	//establish connection
	include 'config.php';
	$db = mysqli_connect($localhost,$username,$password,$dbname);
	if(mysqli_connect_error()) {
		die("connection failed".mysqli_connect_error());
	}
	
	session_start();
	
	unset($_SESSION['adminlogin']);
	unset($_SESSION['installer']);
	header ("Location: ../index.php");
?>