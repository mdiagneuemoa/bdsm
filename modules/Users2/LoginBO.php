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
               	<table width="80%" height=50 align=center>
					
							<tr>
					          <td width="40%" valign=middle><img src="themes/images-login/logo_uemoa.png" height=50 border=0></td>
							<td align="left" valign=middle nowrap><span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
								<span style="font-size: 25px;text-decoration:none;color:#154360;vertical-align:middle;">Portail Soutien de l’UEMOA &agrave; la Formation et &agrave; la Recherche</span></td>
							</tr>
							<tr><td colspan=2><marquee direction="left" color="red"><font color="red">Dernier d&eacute;lai pour les inscriptions &agrave; l'&eacute;dition 2017-2018 le 18 Juin 2017.</font></MARQUEE>
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

<table border=1	cellspacing=5 cellpadding=5>
<tr>
<td width=70%>
<div class="rubrique">Soutien de l’UEMOA &agrave; la formation et &agrave; la recherche de l'excellence</div>
<div class="detail"> Dans le cadre des objectifs du Trait&eacute; de l'UEMOA en mati&egrave;re de d&eacute;veloppement des ressources humaines, la Commission a mis en place 
un programme de soutien &agrave; la formation et &agrave; la recherche de l'excellence. Le pr&eacute;sent appel &agrave; candidatures vise &agrave; pr&eacute;s&eacute;lectionner les b&eacute;n&eacute;ficiaires de ce soutien, qui est accord&eacute;
<b> pour une p&eacute;riode de douze mois non prolongeable, non renouvelable et non soumise &agrave; report.</b><br>
<br>
Peuvent répondre à cet appel, les ressortissants des Etats membres de l’UEMOA, qui remplissent les conditions suivantes : 
<ul style="margin-left: 25px;padding-bottom:10px;margin-top:10px; ">
<li>Etre âgé de 35 ans au maximum ;</li>
<li>Etre titulaire d’une maîtrise ancien régime ou être en Master I (avoir validé le M1, en joignant le relevé de notes de l’année), ou être en dernière année de thèse de doctorat ;</li> 
<li>Avoir au minimum une moyenne de 14/20 au M1 ou au diplôme présenté ;</li>
<li>Etre inscrit dans un établissement d’enseignement supérieur public (national ou communautaire) implanté sur le territoire de l’Union ;</li>
<li>Etudier prioritairement dans un des domaines suivants : Sciences de l’ingénieur, Expertise Comptable, Santé publique, Sciences de l’éducation, Technologies de l’Information et de la Communication (TIC).</li>
<li><b>Les formations en ligne ne sont pas acceptées.</b></li> 
<li><b>La dur&eacute;e de la formation doit pas exc&eacute;der douze (12) mois.</b></li> 
</ul>
</div>

<div class="rubrique">Dossier de candidature</div>
<div class="detail">Les candidats pr&eacute;s&eacute;lectionn&eacute;s seront invit&eacute;s &agrave; transmettre les pi&egrave;ces compl&eacute;mentaires suivantes :<br>
<ol style="list-style-type:arabic-numbers;margin-left: 25px;padding-bottom:10px;margin-top:10px; ">
<li>Curriculum vitae de deux pages au maximum;</li>
<li>Une copie l&eacute;galis&eacute;e du dernier dipl&ocirc;me obtenu;</li>
<li>Le relev&eacute; des notes obtenues &agrave; ce dipl&ocirc;me (il ne s'agit pas de note de soutenance);</li>
<li>Un certificat de nationalit&eacute;;</li>
<li>Le chronogramme de la th&egrave;se (uniquement pour les formations doctorales);</li>
<li>Une facture pro forma fournie par l'&eacute;tablissement d'accueil, indiquant les diff&eacute;rents frais : inscription, scolarit&eacute;, laboratoire,...(dans la limite des ressources budg&eacute;taires pr&eacute;vues au Programme);</li>	
<li>Une attestation d'inscription ou de r&eacute;ussite au concours d'entr&eacute;e dans l'&eacute;tablissement souhait&eacute;.</li>
</ol>
</div>
<div class="rubrique">TRES IMPORTANT</div>
<div class="detail"> 
<ol style="list-style-type:arabic-numbers;;margin-left: 25px;padding-bottom:10px;margin-top:10px; ">
<li>Les candidatures f&eacute;minines sont vivement encourag&eacute;es.</li>
<li>Les candidats n'ayant pas obtenu au minimum la moyenne de <b>14/20</b> au dernier dipl&ocirc;me, ne sont pas accept&eacute;s.</li>
<li>Peuvent faire acte de candidature ceux qui ont valid&eacute; le M1, en joignant le relev&eacute; de notes de l'année.</li>
<li>En dehors du pr&eacute;sent appel &agrave; candidatures, aucune suite ne sera donn&eacute;e &agrave; toute autre demande de soutien adress&eacute;e &agrave; la Commission de l'UEMOA.</li>
</ol>
</div>
</td>
			<td align=right	>
  <div class="container">
	<section id="content">
		<form action="index.php" method="post" name="DetailView" id="form">
			<input type="hidden" name="module" value="Users">
			<input type="hidden" name="action" value="AuthenticateBO">
			<input type="hidden" name="return_module" value="Users">
			<input type="hidden" name="return_action" value="LoginBO">
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
				<input type="text" placeholder="Votre email" required="" name="user_name" id="username"  />
			</div>
			<div>
				<input type="password" placeholder="Votre Password" name="user_password" required="" id="password" type="password"  />
			</div>
			
			<!--div>
				<select class="small" name='pays' style="width:70%" tabindex="3">
					<?php echo get_select_options_with_id($PAYS,"") ?>
				</select>			
			</div-->
			<div>
				<input type="submit" name="Login" value="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_LABEL'] ?>" />

			</div>
			<div align=center><a href="/portailweb/bourseonline/inscription.php"><img src="themes/images-login/sinscrire.jpg"/></a>
			</div>
			</tr></table>	
		</form>
		<!-- button -->
	</section><!-- content -->
</div>
				

</body>
</html>