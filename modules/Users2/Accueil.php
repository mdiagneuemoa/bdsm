<html>
<head>
<title>:: Bienvenue sur PORTAIL BOURSE ON LINE UEMOA | Ecran de connexion :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #333;
}
-->
</style>
<!--Added to display the footer in the login page by Dina-->
<link rel="stylesheet" type="text/css" media="all" href="themes/woodspice/login.css">

<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
<script type="text/javascript" language="JavaScript">

function set_password(form) {

	var regex = /^[0-9a-zA-Z\s]+$/;
	/*if (form.is_admin.value == 1 && trim(form.old_password.value) == "") {
		alert("<?php echo $current_module_strings['ERR_ENTER_OLD_PASSWORD']; ?>");
		return false;
	}*/
	if (trim(form.user_new_password.value) == "") {
		alert("<?php echo $current_module_strings['ERR_ENTER_NEW_PASSWORD']; ?>");
		form.user_new_password.focus();
		return false;
	}
	
	if(!regex.test(form.user_new_password.value) || form.user_new_password.value.length<8)
	{
		alert("<?php echo $current_module_strings['ERR_EXREG_PASSWORD']; ?>");
		form.user_new_password.focus();
		return false;
	}
	if (trim(form.user_confirm_password.value) == "") {
		alert("<?php echo $current_module_strings['ERR_ENTER_CONFIRMATION_PASSWORD']; ?>");
		form.user_confirm_password.focus();
		return false;
	}
	
	if (trim(form.user_new_password.value) == trim(form.user_confirm_password.value)) 
	{
		document.DetailView.user_new_password.value = form.user_new_password.value;
		document.DetailView.changepassword.value = 'true';
		document.DetailView.submit();
		return true;
						
	}
	else {
		alert("<?php echo $mod_strings['ERR_REENTER_PASSWORDS']; ?>");
		form.user_new_password.focus();
		return false;
	}
}

function backToLogin(form) {
	
		document.DetailView.module.value = 'Users';
		document.DetailView.action.value = 'Logout';
		document.DetailView.return_module.value = 'Users';
		//document.DetailView.return_action.value = 'Login';
		document.DetailView.submit();
		return true;
	}
function trim(str)
{
	var s = str.replace(/\s+$/,'');
	s = s.replace(/^\s+/,'');
	return s;
}	
</script>
</head>

  <header class="page-header">
             <div style=" background-color :#27AE60;">
               	<table width="80%" align=center>
					
							<tr><td width="10%">&nbsp;</td>
					          <td width="30%" valign=top><img src="themes/images-login/logo_uemoa.png" height=50 border=0></td>
							<td align="left" valign=middle><span style="font-size: 22px;text-decoration:none;color:white;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
								<span style="font-size: 25px;text-decoration:none;color:#154360;">Portail Gestion des déplacements UEMOA</span></td>
							</tr>
							
				</table>
            </div>
        </header>


<?php

$theme_path="themes/".$theme."/";
$image_path="include/images/";

global $app_language;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'Users');

 define("IN_LOGIN", true);

include_once('vtlib/Vtiger/Language.php');
/*
$username=shell_exec("echo %username%" );
$userlogin = substr($username, 4, -1);
echo "userlogin=",$userlogin;
if($userlogin=='MDIAGNE$')

header("Location: index.php?action=DetailView&module=Tiers&record=1994&parenttab=");
*/

// Retrieve username and password from the session if possible.
if(isset($_SESSION["login_user_name"]))
{
	if (isset($_REQUEST['default_user_name']))
		$login_user_name = $_REQUEST['default_user_name'];
	else
		$login_user_name = $_SESSION['login_user_name'];
}
else
{
	if (isset($_REQUEST['default_user_name']))
	{
		$login_user_name = $_REQUEST['default_user_name'];
	}
	elseif (isset($_REQUEST['ck_login_id_vtiger'])) {
		$login_user_name = get_assigned_user_name($_REQUEST['ck_login_id_vtiger']);
	}
	else
	{
		$login_user_name = $default_user_name;
	}
	$_session['login_user_name'] = $login_user_name;
}

$current_module_strings['VLD_ERROR'] = base64_decode('UGxlYXNlIHJlcGxhY2UgdGhlIFN1Z2FyQ1JNIGxvZ29zLg==');

// Retrieve username and password from the session if possible.
if(isset($_SESSION["login_password"]))
{
	$login_password = $_SESSION['login_password'];
}
else
{
	$login_password = $default_password;
	$_session['login_password'] = $login_password;
}

if(isset($_SESSION["login_error"]))
{
	$login_error = $_SESSION['login_error'];
	//session_unregister('login_error');
	unset($_SESSION['login_error']);
}

if(isset($_SESSION["user_blocked"]))
{
	$user_blocked = $_SESSION['user_blocked'];
	session_unregister('user_blocked');
}

?>
<br><BR><br>	
<!--table border=1 align=center>
<tr>
<td width=20%>&nbsp;</td><td width=50% valign=middle>

<ul>
<li><div class="rubrique">Gestion des demandes de Mat&eacute;riels Informatiques</div></li>
<li><div class="rubrique">Gestion des Tiers Fournnisseurs</div></li>
<li><div class="rubrique">Gestion des demandes de Bourses d'Excellence</div></li>
</ul>
</td>
<td align=right-->
			
<div class="container">
	<div id="content">
		
<h1 style="color:#5EB6DD">Bienvenue dans le logiciel <i>nomade</i><i> - UEMOA &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<img src="/images/logouemoasmall.png" alt="ballpop" /></i></h1>
<h3 style="color:#5EB6DD">Gestion des missions et voyages   </h3>

<div id="logo"><p align="center"><img src="themes/images-login/terre.23121.gif" alt="ballpop" /></p></div>

<p>Pour toute précision sur les procédures, référez vous à  
<a href="http://intranet/Pages/Default.aspx">l'intranet</a>.
</p>	</div><!-- content -->
</div>

</div><!-- page -->
</body>
</html>