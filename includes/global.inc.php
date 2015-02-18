<?php require_once ('connection.php');
	// check if session isset
	session_start();
	if(!isset($_SESSION['logged_in'])){
		header('Location: ../index.php');
	}
?>