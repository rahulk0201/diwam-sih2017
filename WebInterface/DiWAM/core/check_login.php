<?php 
session_start();

if(!isset($_SESSION['adminlogin'])) {
header ("Location: access_denied.php");;
}
?>