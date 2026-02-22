<?php
	session_start();
	include("../settings/connect_datebase.php");
	
	$NowDate = date("Y-m-d H:i:s");
	$sql = "SELECT * FROM `access_ip` where `ip` = '$user_ip';";
	$QueryAccess = $mysqli->query($sql);
	if ($QueryAccess->num_rows>0) {
		$ReadAccess = $QueryAccess->fetch_assoc();
		$EndDate = $ReadAccess['endDate'];
		$StartDate = $ReadAccess['startDate'];
		if ($StartDate == $EndDate) {
			echo "Пользователь заблочен";
			exit;
		} else {
			$sql = "UPDATE `access_ip` SET `startDate` = '$EndDate', `endDate` = '$NowDate' WHERE `ip` = '$user_ip'";
			$mysqli->query($sql);
		}
	} else {
		$sql = "INSERT INTO `access_ip`(`ip`, `startDate`, `endDate`) values ('$user_ip',null, '$NowDate')";
		$mysqli->query($sql);
	}





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
		echo md5(md5(-1));
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