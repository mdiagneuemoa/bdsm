<html>
<head>
<title>:: Bienvenue sur PORTAIL TIERS ON LINE UEMOA | Ecran de connexion :::</title>
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
               	<table width="80%" height=50 align=center>
					
							<tr>
					          <td width="40%" valign=middle><img src="themes/images-login/logo_uemoa.png" height=50 border=0></td>
							<td align="left" valign=middle nowrap><span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
								<span style="font-size: 25px;text-decoration:none;color:#154360;vertical-align:middle;">Portail Tiers & Fournisseurs de la Commission de l???UEMOA </span></td>
							</tr>
							<tr><td colspan=2><marquee direction="left" color="red"><font color="red">Inscrivez vous afin de devenir fournisseur ou prestataire de la Commission  de l'UEMOA.</font></MARQUEE>
							</td>
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

<table border=1	><tr><td width=70%>
<div class="rubrique">Tr??s important</div>
<div class="detail"> Tous les fournisseurs de la Commission de l'UEMOA doivent respecter le Code de conduite des fournisseurs et les Conditions g??n??rales applicables aux contrats de la Commission de l'UEMOA, qui contiennent des dispositions sp??ciales contre les mines terrestres, le travail des enfants et l'exploitation sexuelle, et en faveur des droits fondamentaux des travailleurs.<br>

La Commission de l'UEMOA ne travaille qu'avec des fournisseurs qui partagent son respect pour les droits fondamentaux de l'homme, la justice sociale, la dignit?? humaine et l'??galit?? hommes-femmes, valeurs consacr??es dans la Charte des Nations Unies.
</div>
<div class="rubrique">S'inscrire pour devenir fournisseur de la Commission de l'UEMOA</div>
<div class="detail">


Ce portail centralise les achats de nombreux organes de l'UEMOA, et les fournisseurs peuvent s'y inscrire afin d'avoir acc??s aux march??s. <br>Tous les fournisseurs de la Commission de l'UEMOA doivent ??tre inscrits sur ce portail. Pour toute question concernant l'inscription sur le portail ou le service d'alerte aux appels d'offres, veuillez ??crire ?? registry@ungm.org.

la Commission de l'UEMOA cherche ?? diversifier sa base de fournisseurs et ?? trouver des fournisseurs de biens et services de qualit?? ?? des prix concurrentiels, en particulier issus de pays de l'Union (UEMOA).

<br><br>Les besoins actuels de la Commission de l'UEMOA en mati??re d'achats sont disponibles en temps r??el dans la section ?? Les Opportunit??s d'affaires ?? du site de la Commission de l'UEMOA.

Ses besoins ?? court et ?? moyen terme sont indiqu??s dans ses projets d'achats trimestriels.

<br><br>Afin de favoriser une concurrence efficace et d'am??liorer la transparence, la Commission de l'UEMOA publie les besoins de ses projets en mati??re d'achats. En informant la communaut?? des fournisseurs de ses besoins ?? venir en mati??re d'achats, la Commission de l'UEMOA cherche ?? augmenter la probabilit?? de recevoir des offres r??pondant ?? ses crit??res, ?? favoriser la concurrence et ?? am??liorer la transparence.

<br><br>La Commission de l'UEMOA propose un service d'alerte aux appels d'offres, qui permet aux fournisseurs enregistr??s de recevoir des alertes automatiques pour chaque appel d'offre correspondant aux biens ou services qu'il propose. Inscrivez-vous  et choisissez ce service pour ??tre automatiquement inform?? des derni??res possibilit??s d'affaires avec la Commission de l'UEMOA.

 </div>


</td>
			<td align=right	>
  <div class="container">
	<section id="content">
		<form action="index.php" method="post" name="DetailView" id="form">
			<input type="hidden" name="module" value="Users">
			<input type="hidden" name="action" value="Authenticate">
			<input type="hidden" name="return_module" value="Users">
			<input type="hidden" name="return_action" value="Login">
			<input type="hidden" name="changepassword" value="false">
	<?php
		if(isset($_GET['firstconnexion']) && $_GET['firstconnexion']=="yes")
		{
			$idlogin ="style={display:none}";
			$idchangepw = "style={display:block}";
			//echo '<script>document.form.user_new_password.focus();</script>';
			echo '<input type="hidden" name="record" value="'.$_GET['userid'].'">';
			
		}
		else
		{
			$idlogin ="style={display:block}";
			$idchangepw = "style={display:none}";
			
		}
	?>
			<div style="font-size: 9px;text-decoration:none;color:#27AE60;font-weight:bold;vertical-align:middle;">ACC&Eacute;DER &Agrave; VOTRE DOSSIER</div>
			<!--table><tr><td style="font-size: 9px;text-decoration:none;color:#27AE60;font-weight:bold;vertical-align:middle;">ACC&Eacute;DER &Agrave; VOTRE DOSSIER</td>
			<td width=15%> <img src="themes/images-login/logo_uemoa.png"  /></td>
			</tr></table-->																								
			<br>
			 <div>
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
				</div>
			<div>
				<input type="text" placeholder="Username" required="" name="user_name" id="username"  />
			</div>
			<div>
				<input type="password" placeholder="Password" name="user_password" required="" id="password" type="password"  />
			</div>
			
		
			<div>
				<input type="submit" name="Login" value="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_LABEL'] ?>" />

			</div>
			<div align=center><a href="/portailweb/tiersonline/inscriptiontiers.php"><img src="themes/images-login/sinscrire.jpg"/></a>
			</div>
			</tr></table>	
		</form>
		<!-- button -->
	</section><!-- content -->
</div>
				

</body>
</html>