<?php

session_start();
if(isset($_GET["deconnect"]) && $_GET["deconnect"]){
	unset($_SESSION["connect"]);
} 
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if (empty($connect)){
	header("Location: ./connexion.php");	
}

if (isset($_SESSION["mail"])) {
	$username = $_SESSION["username"];
}else{
	$username = "";
}