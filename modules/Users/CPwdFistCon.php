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
 * $Header: /cvs/repository/siprodPCCI/modules/Users/CPwdFistCon.php,v 1.1 2010/01/15 18:42:25 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
// This file is used for all popups on this module
// The popup_picker.html file is used for generating a list from which to find and choose one instance.

require_once('modules/Users/Users.php');

$user = new User();
$userid = $_REQUEST['record'];
$new_password = $_REQUEST['user_new_password'];
//echo $userid,"-",$new_password;
//echo "test";
if (isset($new_password)) 
{
		$new_pass = $new_password;
		$new_passwd = $new_password;
		$new_pass = md5($new_pass);
		if (!change_password($new_password,$userid,$user)) 
		{
			header("Location: index.php?action=Error&module=Users&error_string=".urlencode($focus->error_string));
		}
		else
		{
			header("Location: index.php?action=Authenticate2&module=Users&user_name=$userid");
		}
}

function change_password($new_password,$userid,$user)
{
	$user_hash = strtolower(md5($new_password));
	//set new password
	$crypt_type = $user->DEFAULT_PASSWORD_CRYPT_TYPE;
	$encrypted_new_password = $user->encrypt_password($new_password, $crypt_type);

	$query = "UPDATE vtiger_users SET user_password=?, user_hash=?, crypt_type=? where id=?";
	$user->db->pquery($query, array($encrypted_new_password, $user_hash, $crypt_type, $userid), true, "Error setting new password for userid=$userid: ") or die;	
	return true;
}	

?>
