<?php
session_start();
include 'config.php';
$db = mysqli_connect($localhost,$username,$password,$dbname);
if(mysqli_connect_error()) {
	 die("connection failed: ".mysqli_connect_error());
}

//declaring variables
$pass = $email = "";
$Err = "";

//Login
if($_SERVER["REQUEST_METHOD"] == "POST") {

$email = $_POST['email'];
$email = mysqli_real_escape_string($db,$email);
$pass = $_POST['password'];
$pass = mysqli_real_escape_string($db,$pass);
$pass = md5($pass);

//if main admin logs in
$type = mysqli_query($db,"select * from admin where email = '$email'");
$type1 = mysqli_fetch_array($type);

if(!empty($type1['email'])) {

$sql = mysqli_query($db,"select * from admin where email = '$email' and password = '$pass'");
$sql_res = mysqli_fetch_array($sql);
$sql_rows = mysqli_num_rows($sql);


if ($sql) {
			if ($sql_rows > 0) {
				$_SESSION['adminlogin'] = 1;
				$_SESSION['admin_id'] = $sql_res["admin_id"];
				$_SESSION['user'] = $sql_res["fname"];
				$_SESSION['full_name'] = $sql_res["fname"].' '.$sql_res["lname"];
				$_SESSION['timeout'] = time();
				header ("Location: live_dashboard.php");
			}
			else {
				$Err = "Invalid Email or Password!";
			}
		}
		else {
			$Err = "Error logging on";
		}
}
}


?>
