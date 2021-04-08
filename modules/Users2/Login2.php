<html>
<head>
<title>:: Bienvenue sur SI GESTION DES CONVENTIONS | Ecran de connexion :::</title>
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



<?php

$theme_path="themes/".$theme."/";
$image_path="include/images/";

global $app_language;
//we don't want the parent module's string file, but rather the string file specifc to this subpanel
global $current_language;
$current_module_strings = return_module_language($current_language, 'Users');

 define("IN_LOGIN", true);

include_once('vtlib/Vtiger/Language.php');

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
	session_unregister('login_error');
}

if(isset($_SESSION["user_blocked"]))
{
	$user_blocked = $_SESSION['user_blocked'];
	session_unregister('user_blocked');
}

?>


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
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table id="Table_01" width="801" height="438" border="0" cellpadding="0" cellspacing="0" align="center" <?php echo $idlogin; ?>>
	
	<tr>
		<td rowspan="2">
			<img src="themes/images-login/logo_uemoa.png" alt=""></td>
		<td rowspan="3">
			<img src="themes/images-login/login_02.jpg" width="15" height="298" alt=""></td>
		<td colspan="2" width="290" height="110" alt=""></td>
		<td rowspan="3" background="themes/images-login/login_04.jpg" width="21" height="298" alt=""></td>
		<td width="206" height="110" alt=""></td>
		<td>
			<img src="themes/images-login/spacer.gif" width="1" height="110" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="2" background="themes/images-login/login_06.jpg" width="290" height="188"  ><table width="95%" border="0">
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
				
		  <tr>
		    <td width="60%" nowrap><?php echo $current_module_strings['LBL_USER_NAME'] ?></td>
		    <td width="40%">
		      <label>
		        <input type="text" name="user_name" id="textfield">
	          </label>
	        </td>
	      </tr>
		  <tr>
		    <td nowrap><?php echo $current_module_strings['LBL_PASSWORD'] ?> </td>
		    <td>
		      <label>
		        <input type="password" name="user_password" id="textfield2" type="password">
	          </label>
	       </td>
	      </tr>
		   <tr>
				<td nowrap>Pays : </td>
				<td><select class="small" name='pays' style="width:70%" tabindex="3">
					<?php echo get_select_options_with_id($PAYS,"") ?>
				</select>
				</td>
			</tr>
		  <tr>
		    <td colspan="2" align="right">
		    <p>
		    	<input title="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_TITLE'] ?>" alt="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_TITLE'] ?>" accesskey="<?php echo $current_module_strings['LBL_LOGIN_BUTTON_TITLE'] ?>" src="themes/images-login/connexion.jpg" width="143" height="28" type="image" name="Login" value="  <?php echo $current_module_strings['LBL_LOGIN_BUTTON_LABEL'] ?>">
		    </p>
	        <p>&nbsp;</p></td>
	      </tr>
		  
  </table>
  <!-- change password on first connexion -->
					<!--  
					<table border="0" cellpadding="0" cellspacing="0" width="80%" <?php // echo $idchangepw; ?>
					<tr>
						<td class="signinHdr"><?php // echo $mod_strings['LBL_FIRSTCON_CHANGE_PASSWORD']; ?></td>
					</tr>
					<tr>
						<td class="small" align="center"> -->
						<!-- form elements -->
						
						<!--  
							<br>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
									<tr>
										<td class="small" align="right" nowrap><?php // echo $current_module_strings['LBL_NEW_PASSWORD'] ?></td>
										<td class="small" align="left"><input class="small" type="password" name="user_new_password" tabindex="1"></td>
									</tr>
									<tr>
										<td class="small" align="right" nowrap><?php // echo $current_module_strings['LBL_CONFIRM_PASSWORD'] ?></td>
										<td class="small" align="left"><input class="small" type="password" size='20' name="user_confirm_password" tabindex="2">
										<br><font size=1><em><?php // echo $current_module_strings['LBL_PW_LENGTH']?></em></font></td>
									</tr>
									
						 -->
									
						<!-- 	
								
							<?php
							//if( isset($_SESSION['validation'])){
							?>
							<tr>
								<td colspan="2"><font color="Red"> <?php // echo $current_module_strings['VLD_ERROR']; ?> </font></td>
							</tr>
							<?php
							/*}
							else if(isset($login_error) && $login_error != "")
							{*/
							?>
							<tr>
								<td colspan="2"><b class="small"><font color="Brown">
							<?php // echo $login_error ?>
								</font></b></td>
							</tr>
							<?php
							//}
							?>
							<tr>
								<td class="small" align='right'><input title='<?php //echo $app_strings['LBL_SAVE_BUTTON_TITLE']; ?>' accessKey='<?php // echo $app_strings['LBL_SAVE_BUTTON_KEY']; ?>' class='crmbutton small save' LANGUAGE=javascript onclick='set_password(this.form);' type='button' name='button' value='  <?php // echo $app_strings['LBL_SAVE_BUTTON_LABEL']; ?>  '></td>
								<td align='left'><input title='<?php //echo $app_strings['LBL_CANCEL_BUTTON_TITLE']; ?>' accessyKey='<?php // echo $app_strings['LBL_CANCEL_BUTTON_KEY']; ?>' class='crmbutton small cancel' LANGUAGE=javascript onclick='backToLogin(this.form)' type='button' name='button' value='  <?php // echo $app_strings['LBL_CANCEL_BUTTON_LABEL']; ?>  '></td>
							</tr>
							</table>
							<br><br>
						</td>
					</tr>
					</table>
					
				-->
					
</form>					
					<!-- end change password -->
  </td>
  
		<td rowspan="2" background="themes/images-login/login_07.jpg" width="206" height="188" alt=""></td>
		
		<td>
			<img src="themes/images-login/spacer.gif" width="1" height="50" alt=""></td>
			
	</tr>
	<tr>
		<td background="themes/images-login/login_08.jpg" width="268" height="138" alt=""></td>
		<td>
			<img src="themes/images-login/spacer.gif" width="1" height="138" alt=""></td>
	</tr>
	<tr>
		<td colspan="3"  width="413" height="139" alt=""></td>
		<td colspan="3" nowrap>
			
		</td>
		<td>
		
			<img src="themes/images-login/spacer.gif" width="1" height="139" alt=""></td>
	</tr>
	
</table>
</body>
</html>