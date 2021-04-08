<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/Users/Authenticate.php,v 1.3 2010/05/06 16:38:34 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Users/Users.php');
require_once('modules/Users/CreateUserPrivilegeFile.php');
require_once('include/logging.php');
require_once('user_privileges/audit_trail.php');

global $mod_strings, $default_charset;

$focus = new Users();

// Add in defensive code here.
$focus->column_fields["user_name"] = to_html($_REQUEST['user_name']);
$user_password = htmlspecialchars($_REQUEST['user_password'],ENT_QUOTES,$default_charset); //BUGFIX  " Cross-Site-Scripting "

$pays = $focus->getPays($user_password);
//echo $pays;break;
$_SESSION['pays'] = $pays;

if($_REQUEST['changepassword'] == 'true')
{
	$focus->retrieve_entity_info($_REQUEST['record'],'Users');
	$focus->id = $_REQUEST['record'];
	if (isset($_POST['user_new_password'])) 
	{
		$new_pass = $_POST['user_new_password'];
		$new_passwd = $_POST['user_new_password'];
		$new_pass = md5($new_pass);
		if (!$focus->change_passwordFC($_POST['user_new_password'],$focus->id)) 
		{
			header("Location: index.php?action=Error&module=Users&error_string=".urlencode($focus->error_string));
			exit;
		}
		else
			$user_password = $new_passwd;
	}
	
}

//$focus->load_user($user_password);
$usr_name = to_html($_REQUEST['user_name']);
$focus->load_userGID($usr_name, $user_password);
/*
if($focus->user_desabled())
{
	header("Location: index.php?compteBloque=yes");
}
else
	if($focus->is_firstconnexion($focus->column_fields["user_name"]) && (!isset($_REQUEST['changepassword']) || $_REQUEST['changepassword']=='false') )
	{
		header("Location:index.php?firstconnexion=yes&userid=".$focus->id);
	}	
		
else*/
if($focus->is_authenticated())
{

	//Inserting entries for audit trail during login
	
	if($audit_trail == 'true')
	{
		if($record == '')
			$auditrecord = '';						
		else
			$auditrecord = $record;	

		$date_var = $adb->formatDate(date('Y-m-d H:i:s'), true);
 	    $query = "insert into vtiger_audit_trial values(?,?,?,?,?,?)";
		$params = array($adb->getUniqueID('vtiger_audit_trial'), $focus->id, 'Users','Authenticate','',$date_var);				
		$adb->pquery($query, $params);
	}
	
	// Recording the login info
        $usip=$_SERVER['REMOTE_ADDR'];
        $intime=date("Y/m/d H:i:s");
        require_once('modules/Users/LoginHistory.php');
        $loghistory=new LoginHistory();
        $Signin = $loghistory->user_login($focus->column_fields["user_name"],$usip,$intime);

	//Security related entries start
	require_once('include/utils/UserInfoUtil.php');
	$_SESSION['pays'] = $pays;

//	createUserPrivilegesfile($focus->id);
	createUsersGIDPrivilegesfile($focus->id);
	
	//Security related entries end		unset($_SESSION['validation']);
		unset($_SESSION['login_password']);
		unset($_SESSION['login_error']);
		unset($_SESSION['login_user_name']);
		unset($_SESSION['loginattempts']);
		unset($_SESSION['userstatut']);
		unset($_SESSION['user_blocked']);

/*	session_unregister('login_password');
	session_unregister('login_error');
	session_unregister('login_user_name');
	session_unregister('loginattempts');
	session_unregister('userstatut');
	session_unregister('user_blocked');*/
	//session_unregister('firstconnexion');
	

	$_SESSION['authenticated_user_id'] = $focus->id;
	$_SESSION['app_unique_key'] = $application_unique_key;

	// store the user's theme in the session
	if (isset($_REQUEST['login_theme'])) {
		$authenticated_user_theme = $_REQUEST['login_theme'];
	}
	elseif (isset($_REQUEST['ck_login_theme']))  {
		$authenticated_user_theme = $_REQUEST['ck_login_theme'];
	}
	else {
		$authenticated_user_theme = $default_theme;
	}
	
	// store the user's language in the session
	if (isset($_REQUEST['login_language'])) {
		$authenticated_user_language = $_REQUEST['login_language'];
	}
	elseif (isset($_REQUEST['ck_login_language']))  {
		$authenticated_user_language = $_REQUEST['ck_login_language'];
	}
	else {
		$authenticated_user_language = $default_language;
	}

	// If this is the default user and the default user theme is set to reset, reset it to the default theme value on each login
	if($reset_theme_on_default_user && $focus->user_name == $default_user_name)
	{
		$authenticated_user_theme = $default_theme;
	}
	if(isset($reset_language_on_default_user) && $reset_language_on_default_user && $focus->user_name == $default_user_name)
	{
		$authenticated_user_language = $default_language;	
	}

	$_SESSION['vtiger_authenticated_user_theme'] = $authenticated_user_theme;
	$_SESSION['authenticated_user_language'] = $authenticated_user_language;
	
	$log->debug("authenticated_user_theme is $authenticated_user_theme");
	$log->debug("authenticated_user_language is $authenticated_user_language");
	$log->debug("authenticated_user_id is ". $focus->id);
        $log->debug("app_unique_key is $application_unique_key");

	
// Clear all uploaded import files for this user if it exists

	global $import_dir;

	$tmp_file_name = $import_dir. "IMPORT_".$focus->id;

	if (file_exists($tmp_file_name))
	{
		unlink($tmp_file_name);
	}
	$arr = $_SESSION['lastpage'];
	if(isset($_SESSION['lastpage']))
		header("Location: index.php?".$arr[0]);
	else
		header("Location: index.php");
}

/*else
if($_SESSION['loginattempts'] == 3)
{
			$focus->log->warn("SECURITY: " . $focus->column_fields["user_name"] . " has attempted to login ". 	$_SESSION['loginattempts'] . " times.");
			$focus->desable_user();
			header("Location: index.php");
}
*/
elseif(isset($_SESSION['userstatut']) && $_SESSION['userstatut'] == 0) {
	$_SESSION['login_user_name'] = $focus->column_fields["user_name"];
	$_SESSION['login_password'] = $user_password;
	$_SESSION['user_blocked'] = $mod_strings['ERR_USER_BLOCKED'];
	header("Location: index.php");
}
else
{
	$_SESSION['login_user_name'] = $focus->column_fields["user_name"];
	$_SESSION['login_password'] = $user_password;
	$_SESSION['login_error'] = $mod_strings['ERR_INVALID_PASSWORD'];
	
	// go back to the login screen.	
	// create an error message for the user.
	header("Location: index.php");
}

?>
