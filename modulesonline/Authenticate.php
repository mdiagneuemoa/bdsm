<?php

require_once('beans/Abonne.php');
//require_once('include/logging.php');

$focus = new Abonne();

// Add in defensive code here.
$user_password = htmlspecialchars($_REQUEST['password'],ENT_QUOTES,$default_charset); //BUGFIX  " Cross-Site-Scripting "
$usr_name = $_REQUEST['username'];

$focus->load_abonne($usr_name, $user_password);
if($focus->is_authenticated())
{


	// Recording the login info
     $usip=$_SERVER['REMOTE_ADDR'];
	 $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
     $intime=date("Y/m/d H:i:s");
     require_once('inc/LoginHistory.php');
     $loghistory=new LoginHistory();
     $Signin = $loghistory->user_login($focus->username,$usip,$intime);

	unset($_SESSION['login_password']);
	unset($_SESSION['login_user_name']);
	unset($_SESSION['numeroclient']);
	$_SESSION['numeroclient'] = $focus->numeroclient;
	$_SESSION['login_user_name'] = $focus->username;
	$_SESSION['login_password'] = $focus->password;
	$_SESSION['nom'] = $focus->nom;
	$_SESSION['prenom'] = $focus->prenom;
	header("Location: accueil.php");
}
else
{
	
	header("Location: index.html");
}

?>
