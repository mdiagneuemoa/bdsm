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
 * $Header: /cvs/repository/siprodPCCI/modules/Users/Authenticate2.php,v 1.1 2010/01/15 18:42:27 isene Exp $
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

//$focus->load_user($user_password);

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

	createUserPrivilegesfile($focus->id);
	
	//Security related entries end
	session_unregister('login_password');
	session_unregister('login_error');
	session_unregister('login_user_name');
	session_unregister('loginattempts');
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


?>
