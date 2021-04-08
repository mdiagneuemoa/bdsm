<html>
<head>
<title>:: Bienvenue sur PORTAIL ADMIN UEMOA | Ecran de connexion :::</title>
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
							<td align="left" valign=middle><span style="font-size: 22px;text-decoration:none;color:white;">PORTAIL STATISTIQUES UEMOA</span><br>
								</td>
					          <td align=right valign=top><img src="themes/images-login/logo_uemoa_25ans.png" height=50 border=0></td>
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

//header("Location: index.php?action=Accueil&module=Users");


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
<table border=1 align=center height=400>
<!--tr><td colspan=2><marquee direction="left" color="red"><font color="blue"><b>L'application NOMADE est disponible. Les délégations de pouvoir sont désormais opérationnelles dans le système.<b/></font></MARQUEE></td></tr-->

<tr>
<td width=10%>&nbsp;</td><td width=50% valign=middle>

<h2 style="color:#5EB6DD">Macroéconomie - Mine - Energie - Transport</h1>
<h3 style="color:#5EB6DD">Culture - Artisanat - Tourisme - Economie Numérique</h3>
<h4 style="font-size: 15px;text-decoration:none;color:#5EB6DD;vertical-align:middle;">
Agriculte - Sécurité Alimentaire - Nutrition - Démographie - Services Sociaux</h4>

<div id="logo"><p align="center"><img src="themes/images-login/terre.23121.gif" alt="ballpop" /></p></div>

</td><td width=10%>&nbsp;</td>
<td align=right>
  <div class="container">
	<section id="content">
		<form action="index.php" method="post" name="DetailView" id="form">
			<input type="hidden" name="module" value="Users">
			<input type="hidden" name="action" value="Authenticate">
			<input type="hidden" name="return_module" value="Users">
			<input type="hidden" name="return_action" value="Login">
			<input type="hidden" name="changepassword" value="false">
		
			<div style="font-size: 9px;text-decoration:none;color:#27AE60;font-weight:bold;vertical-align:middle;">ACC&Eacute;DER AU PORTAIL</div>
			<!--table><tr><td style="font-size: 9px;text-decoration:none;color:#27AE60;font-weight:bold;vertical-align:middle;">ACC&Eacute;DER &Agrave; VOTRE DOSSIER</td>
			<td width=15%> <img src="themes/images-login/logo_uemoa.png"  /></td>
			</tr></table-->																								
			<br>
			 <div><table>
			 <?php
				if( isset($_SESSION['validation'])){
				?>
				<tr>
					<td colspan="2" align="center"><font color="Red"> <?php echo $current_module_strings['VLD_ERROR']; ?> </font></td>
				</tr>
				
				<?php
				}
				else if(isset($login_error) && $login_error != "")
				{
				?>
				<tr>
					<td colspan="2" align="center"><b class="small"><font color="Brown">
				<?php echo $login_error ?>
					</font></b></td>
				</tr>
				
				<?php
				}
				else if(isset($user_blocked) && $user_blocked != "")
				{
				?>
				<tr>
					<td colspan="2" align="center"><b class="small"><font color="Brown">
				<?php echo $user_blocked ?>
					</font></b></td>
				</tr>
				<?php
				}
				?>	
				</table></div>
			<div>
				<input type="text" placeholder="Username" required="" name="user_name" id="username"  />
			</div>
			<div>
				<input type="password" placeholder="Password" name="user_password" required="" id="password" type="password"  />
			</div>
			
			<!--div>
				<select class="small" name='pays' style="width:70%" tabindex="3">
					<?php echo get_select_options_with_id($PAYS,"") ?>
				</select>			
			</div-->
			<div>
				<input type="submit" name="Login" value="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_LABEL'] ?>" />

			</div>
			
			</tr></table>	
		</form>
		<!-- button -->
	</section><!-- content -->
</div>
</td>
</tr>
<tr><td width=50><td align=center colspan=2><p>Pour toute précision sur les procédures, référez vous à  
<a href="http://intranet/Pages/Default.aspx">l'intranet</a>.
</p> 
</td></tr>
</div><!-- page -->
</body>
</html>