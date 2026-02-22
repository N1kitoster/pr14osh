<?php
	session_start();
	include("../settings/connect_datebase.php");
	
	$login = $_POST['login'];
	$password = $_POST['password'];
	$CountAttempt = 0;
	$sql = "SELECT `attempt` from `users` where `login` = '$login'";
	$QueryAttempt = $mysqli->query($sql);
	if($QueryAttempt->num_rows>0) {
		$ReadAttempt = $QueryAttempt->fetch_assoc();
		$CountAttempt = $ReadAttempt['attempt'];
	}
	if ($CountAttempt >=5) {
		echo md5(md5($id));
		exit;
	}
	// ищем пользователя
	$query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."' AND `password`= '".$password."';");
	
	$id = -1;
	while($user_read = $query_user->fetch_row()) {
		$id = $user_read[0];
	}
	
	if($id != -1) {
		$_SESSION['user'] = $id;
		$CountAttempt = 0;
	} else {
		$CountAttempt+=1;
	}
	$sql = "UPDATE `users` SET `attempt`='$CountAttempt' WHERE `login` = '$login' ";
	$mysqli->query($sql);
	echo md5(md5($id));
?>