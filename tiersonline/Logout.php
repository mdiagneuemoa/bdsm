<?php
require_once('inc/LoginHistory.php');

global $adb, $enable_backup,$current_user;

	$usip=$_SERVER['REMOTE_ADDR'];
        $outtime=date("Y/m/d H:i:s");
        $loghistory=new LoginHistory();
       $loghistory->user_logout($_SESSION['login_user_name'],$usip,$outtime);
       	unset($_SESSION['numeroclient']);

session_destroy();
header("Location: index.php");
?>
