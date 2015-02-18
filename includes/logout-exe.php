<?php require_once ('global.inc.php');

		unset($_SESSION["user"]);
		unset($_SESSION["logged_in"]);
		unset($_SESSION["role"]);
		unset($_SESSION['domain']);
		session_destroy();
		header("Location: ../index.php");
?>