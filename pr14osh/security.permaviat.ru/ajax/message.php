<?php
    session_start();
	include("../settings/connect_datebase.php");

	
	if (isset($_SESSION['user']) && $_SESSION['user'] != -1) {
		$IdUser = $_SESSION['user'];
		$Message = $_POST["Message"];
		$IdPost = $_POST["IdPost"];

		
		$Message = str_replace("'", "''", $Message);

		$mysqli->query("INSERT INTO `comments`(`IdUser`, `IdPost`, `Messages`) VALUES ({$IdUser}, {$IdPost}, '{$Message}');");
	}
?>