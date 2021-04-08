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
 * $Header: /cvs/repository/siprodPCCI/include/utils/utils.php,v 1.2 2010/04/06 15:41:10 isene Exp $
 * Description:  Includes generic helper functions used throughout the application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/



/** This function returns the name of the person.
  * It currently returns "first last".  It should not put the space if either name is not available.
  * It should not return errors if either name is not available.
  * If no names are present, it will return ""
  * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
  * All Rights Reserved.
  * Contributor(s): ______________________________________..
  */

  require_once('include/database/PearDatabase.php');
  require_once('include/ComboUtil.php'); //new
  require_once('include/utils/ListViewUtils.php');	
  require_once('include/utils/EditViewUtils.php');
  require_once('include/utils/DetailViewUtils.php');
  require_once('include/utils/CommonUtils.php');
  require_once('include/utils/InventoryUtils.php');
  require_once('include/utils/SearchUtils.php');
  require_once('include/FormValidationUtil.php');
  require_once('include/DatabaseUtil.php');
require_once("include/events/SqlResultIterator.inc");
 
// Constants to be defined here

// For Migration status.
define("MIG_CHARSET_PHP_UTF8_DB_UTF8", 1);
define("MIG_CHARSET_PHP_NONUTF8_DB_NONUTF8", 2);
define("MIG_CHARSET_PHP_NONUTF8_DB_UTF8", 3);
define("MIG_CHARSET_PHP_UTF8_DB_NONUTF8", 4);

// For Customview status.
define("CV_STATUS_DEFAULT", 0);				
define("CV_STATUS_PRIVATE", 1);
define("CV_STATUS_PENDING", 2);
define("CV_STATUS_PUBLIC", 3);

// For Restoration.
define("RB_RECORD_DELETED", 'delete');
define("RB_RECORD_INSERTED", 'insert');
define("RB_RECORD_UPDATED", 'update');

/** Function to return a full name
  * @param $row -- row:: Type integer
  * @param $first_column -- first column:: Type string
  * @param $last_column -- last column:: Type string
  * @returns $fullname -- fullname:: Type string 
  *
*/
function return_name(&$row, $first_column, $last_column)
{
	global $log;
	$log->debug("Entering return_name(".$row.",".$first_column.",".$last_column.") method ...");
	$first_name = "";
	$last_name = "";
	$full_name = "";

	if(isset($row[$first_column]))
	{
		$first_name = stripslashes($row[$first_column]);
	}

	if(isset($row[$last_column]))
	{
		$last_name = stripslashes($row[$last_column]);
	}

	$full_name = $first_name;

	// If we have a first name and we have a last name
	if($full_name != "" && $last_name != "")
	{
		// append a space, then the last name
		$full_name .= " ".$last_name;
	}
	// If we have no first name, but we have a last name
	else if($last_name != "")
	{
		// append the last name without the space.
		$full_name .= $last_name;
	}

	$log->debug("Exiting return_name method ...");
	return $full_name;
}

/** Function to return language 
  * @returns $languages -- languages:: Type string 
  *
*/

function get_languages()
{
	global $log;
	$log->debug("Entering get_languages() method ...");
	global $languages;
	$log->debug("Exiting get_languages method ...");
	return $languages;
}

/** Function to return language 
  * @param $key -- key:: Type string
  * @returns $languages -- languages:: Type string 
  *
*/

//seems not used
function get_language_display($key)
{
	global $log;
	$log->debug("Entering get_language_display(".$key.") method ...");
	global $languages;
	$log->debug("Exiting get_language_display method ...");
	return $languages[$key];
}

/** Function returns the user array 
  * @param $assigned_user_id -- assigned_user_id:: Type string
  * @returns $user_list -- user list:: Type array 
  *
*/

function get_assigned_user_name(&$assigned_user_id)
{
	global $log;
	$log->debug("Entering get_assigned_user_name(".$assigned_user_id.") method ...");
	$user_list = &get_user_array(false,"");
	if(isset($user_list[$assigned_user_id]))
	{
		$log->debug("Exiting get_assigned_user_name method ...");
		return $user_list[$assigned_user_id];
	}

	$log->debug("Exiting get_assigned_user_name method ...");
	return "";
}

/** Function returns the user key in user array 
  * @param $add_blank -- boolean:: Type boolean
  * @param $status -- user status:: Type string
  * @param $assigned_user -- user id:: Type string
  * @param $private -- sharing type:: Type string
  * @returns $user_array -- user array:: Type array 
  *
*/

//used in module file
function get_user_array($add_blank=true, $status="Active", $assigned_user="",$private="")
{
	global $log;
	$log->debug("Entering get_user_array(".$add_blank.",". $status.",".$assigned_user.",".$private.") method ...");
	global $current_user;
	if(isset($current_user) && $current_user->id != '')
	{
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
	}
	static $user_array = null;
	$module=$_REQUEST['module'];

	if($user_array == null)
	{
		require_once('include/database/PearDatabase.php');
		$db = new PearDatabase();
		$temp_result = Array();
		// Including deleted vtiger_users for now.
		if (empty($status)) {
				$query = "SELECT id, user_name from vtiger_users";
				$params = array();
		}
		else {
				if($private == 'private')
				{
					$log->debug("Sharing is Private. Only the current user should be listed");
					$query = "select id as id,user_name as user_name from vtiger_users where id=? and status='Active' union select vtiger_user2role.userid as id,vtiger_users.user_name as user_name from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like ? and status='Active' union select shareduserid as id,vtiger_users.user_name as user_name from vtiger_tmp_write_user_sharing_per inner join vtiger_users on vtiger_users.id=vtiger_tmp_write_user_sharing_per.shareduserid where status='Active' and vtiger_tmp_write_user_sharing_per.userid=? and vtiger_tmp_write_user_sharing_per.tabid=?";	
					$params = array($current_user->id, $current_user_parent_role_seq."::%", $current_user->id, getTabid($module));	
				}
				else
				{
					$log->debug("Sharing is Public. All vtiger_users should be listed");
					$query = "SELECT id, user_name from vtiger_users WHERE status=?";
					$params = array($status);
				}
		}
		if (!empty($assigned_user)) {
			 $query .= " OR id=?";
			 array_push($params, $assigned_user);
		}

		$query .= " order by user_name ASC";

		$result = $db->pquery($query, $params, true, "Error filling in user array: ");

		if ($add_blank==true){
			// Add in a blank row
			$temp_result[''] = '';
		}

		// Get the id and the name.
		while($row = $db->fetchByAssoc($result))
		{
			$temp_result[$row['id']] = $row['user_name'];
		}

		$user_array = &$temp_result;
	}

	$log->debug("Exiting get_user_array method ...");
	
	return $user_array;
}

function get_user_array_UsersGID($add_blank=true, $status="Active", $assigned_user="",$private="")
{
	global $log;
	$log->debug("Entering get_user_array(".$add_blank.",". $status.",".$assigned_user.",".$private.") method ...");
	global $current_user;
	if(isset($current_user) && $current_user->id != '')
	{
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
	}
	static $user_array = null;
	$module=$_REQUEST['module'];

	if($user_array == null)
	{
		require_once('include/database/PearDatabase.php');
		$db = new PearDatabase();
		$temp_result = Array();
		// Including deleted vtiger_users for now.
/*		if (empty($status)) {
				$query = "SELECT user_id, user_name from users";
				$params = array();
		}
		else {
				if($private == 'private')
				{
	*/				$log->debug("Sharing is Private. Only the current user should be listed");
					$query = "select user_id as id,user_name as user_name from users where user_id=?";	
					$params = array($current_user->id);	
/*				}
				else
				{
					$log->debug("Sharing is Public. All vtiger_users should be listed");
					$query = "SELECT user_id, user_name from users WHERE status=?";
					$params = array($status);
				}
		}
		if (!empty($assigned_user)) {
			 $query .= " OR id=?";
			 array_push($params, $assigned_user);
		}
*/
		$query .= " order by user_name ASC";

		$result = $db->pquery($query, $params, true, "Error filling in user array: ");

		if ($add_blank==true){
			// Add in a blank row
			$temp_result[''] = '';
		}

		// Get the id and the name.
		while($row = $db->fetchByAssoc($result))
		{
			$temp_result[$row['id']] = $row['user_name'];
		}

		$user_array = &$temp_result;
	}

	$log->debug("Exiting get_user_array method ...");
	
	return $user_array;
}

function get_group_array($add_blank=true, $status="Active", $assigned_user="",$private="")
{
	global $log;
	$log->debug("Entering get_user_array(".$add_blank.",". $status.",".$assigned_user.",".$private.") method ...");
	global $current_user;
	if(isset($current_user) && $current_user->id != '')
	{
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
	}
	static $group_array = null;
	$module=$_REQUEST['module'];

	if($group_array == null)
	{
		require_once('include/database/PearDatabase.php');
		$db = new PearDatabase();
		$temp_result = Array();
		// Including deleted vtiger_users for now.
		$log->debug("Sharing is Public. All vtiger_users should be listed");
		$query = "SELECT groupid, groupname from vtiger_groups";
		$params = array();		
		
		if($private == 'private'){
			//To get users list
				
			$user_query = "select id as id,user_name as user_name from vtiger_users where id=? and status='Active' union select vtiger_user2role.userid as id,vtiger_users.user_name as user_name from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like ? and status='Active' union select shareduserid as id,vtiger_users.user_name as user_name from vtiger_tmp_write_user_sharing_per inner join vtiger_users on vtiger_users.id=vtiger_tmp_write_user_sharing_per.shareduserid where status='Active' and vtiger_tmp_write_user_sharing_per.userid=? and vtiger_tmp_write_user_sharing_per.tabid=?";	
			$user_params = array($current_user->id, $current_user_parent_role_seq."::%", $current_user->id, getTabid($module));	
					
			if (!empty($assigned_user)) {
				$user_query .= " OR id=?";
				array_push($user_params, $assigned_user);
			}
			$user_result = $db->pquery($user_query, $user_params, true, "Error filling in user array: ");
			while($row = $db->fetchByAssoc($user_result)) {
				$user_array[$row['id']] = $row['id'];
			}
				
			$group_ids = array();
			$usr_res = $db->pquery("select distinct groupid from vtiger_users2group where userid in(".generateQuestionMarks($user_array).")",array($user_array));
			$num_grps = $db->num_rows($usr_res);
					
			$query .= " WHERE groupid=?";			
			$params = array( $current_user->id);
			if ($num_grps > 0) {
				for($i=0; $i<$num_grps; $i++) {
					$group_ids[] = $db->query_result($usr_res, $i, 'groupid');
				}
				$query .= " OR groupid in (".generateQuestionMarks($group_ids).")";
				array_push($params, $group_ids);
			}
		
			$log->debug("Sharing is Private. Only the current user should be listed");
			$query .= " union select vtiger_group2role.groupid as groupid,vtiger_groups.groupname as groupname from vtiger_group2role inner join vtiger_groups on vtiger_groups.groupid=vtiger_group2role.groupid inner join vtiger_role on vtiger_role.roleid=vtiger_group2role.roleid where vtiger_role.parentrole like ?";
			array_push($params, $current_user_parent_role_seq."::%");
					
			$query .= " union select sharedgroupid as groupid,vtiger_groups.groupname as groupname from vtiger_tmp_write_group_sharing_per inner join vtiger_groups on vtiger_groups.groupid=vtiger_tmp_write_group_sharing_per.sharedgroupid where vtiger_tmp_write_group_sharing_per.sharedgroupid=?";
			array_push($params, $current_user->id);

			$query .= " and vtiger_tmp_write_group_sharing_per.tabid=?";
			array_push($params,  getTabid($module));
		}		
		$query .= " order by groupname ASC";

		$result = $db->pquery($query, $params, true, "Error filling in user array: ");

		if ($add_blank==true){
			// Add in a blank row
			$temp_result[''] = '';
		}

		// Get the id and the name.
		while($row = $db->fetchByAssoc($result))
		{
			$temp_result[$row['groupid']] = $row['groupname'];
		}

		$group_array = &$temp_result;
	}

	$log->debug("Exiting get_user_array method ...");
	return $group_array;
}
/** Function skips executing arbitary commands given in a string
  * @param $string -- string:: Type string
  * @param $maxlength -- maximun length:: Type integer
  * @returns $string -- escaped string:: Type string 
  *
*/

function clean($string, $maxLength)
{
	global $log;
	$log->debug("Entering clean(".$string.",". $maxLength.") method ...");
	$string = substr($string, 0, $maxLength);
	$log->debug("Exiting clean method ...");
	return escapeshellcmd($string);
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map($request_var, & $focus, $always_copy = false)
{
	global $log;
	$log->debug("Entering safe_map(".$request_var.",".get_class($focus).",".$always_copy.") method ...");
	safe_map_named($request_var, $focus, $request_var, $always_copy);
	$log->debug("Exiting safe_map method ...");
}

/**
 * Copy the specified request variable to the member variable of the specified object.
 * Do no copy if the member variable is already set.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function safe_map_named($request_var, & $focus, $member_var, $always_copy)
{
	global $log;
	$log->debug("Entering safe_map_named(".$request_var.",".get_class($focus).",".$member_var.",".$always_copy.") method ...");
	if (isset($_REQUEST[$request_var]) && ($always_copy || is_null($focus->$member_var))) {
		$log->debug("safe map named called assigning '{$_REQUEST[$request_var]}' to $member_var");
		$focus->$member_var = $_REQUEST[$request_var];
	}
	$log->debug("Exiting safe_map_named method ...");
}

/** This function retrieves an application language file and returns the array of strings included in the $app_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */

function return_app_list_strings_language($language)
{
	global $log;
	$log->debug("Entering return_app_list_strings_language(".$language.") method ...");
	global $app_list_strings, $default_language, $log, $translation_string_prefix;
	$temp_app_list_strings = $app_list_strings;
	$language_used = $language;

	@include("include/language/$language.lang.php");
	if(!isset($app_list_strings))
	{
		$log->warn("Unable to find the application language file for language: ".$language);
		require("include/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($app_list_strings))
	{
		$log->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_app_list_strings_language method ...");
		return null;
	}


	$return_value = $app_list_strings;
	$app_list_strings = $temp_app_list_strings;

	$log->debug("Exiting return_app_list_strings_language method ...");
	return $return_value;
}

/** This function retrieves an application language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_application_language($language)
{
	global $log;
	$log->debug("Entering return_application_language(".$language.") method ...");
	global $app_strings, $default_language, $log, $translation_string_prefix;
	$temp_app_strings = $app_strings;
	$language_used = $language;

	@include("include/language/$language.lang.php");
	if(!isset($app_strings))
	{
		$log->warn("Unable to find the application language file for language: ".$language);
		require("include/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($app_strings))
	{
		$log->fatal("Unable to load the application language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_application_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($app_strings as $entry_key=>$entry_value)
		{
			$app_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$return_value = $app_strings;
	$app_strings = $temp_app_strings;

	$log->debug("Exiting return_application_language method ...");
	return $return_value;
}

/** This function retrieves a module's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are in the current module, do not call this function unless you are loading it for the first time */
function return_module_language($language, $module)
{
	global $log;
	$log->debug("Entering return_module_language(".$language.",". $module.") method ...");
	global $mod_strings, $default_language, $log, $currentModule, $translation_string_prefix;

	if($currentModule == $module && isset($mod_strings) && $mod_strings != null)
	{
		// We should have already loaded the array.  return the current one.
		$log->debug("Exiting return_module_language method ...");
		return $mod_strings;
	}

	$temp_mod_strings = $mod_strings;
	$language_used = $language;

	@include("modules/$module/language/$language.lang.php");
	if(!isset($mod_strings))
	{
		$log->warn("Unable to find the module language file for language: ".$language." and module: ".$module);
		require("modules/$module/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($mod_strings))
	{
		$log->fatal("Unable to load the module($module) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_module_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($mod_strings as $entry_key=>$entry_value)
		{
			$mod_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$return_value = $mod_strings;
	$mod_strings = $temp_mod_strings;

	$log->debug("Exiting return_module_language method ...");
	return $return_value;
}

/*This function returns the mod_strings for the current language and the specified module
*/

function return_specified_module_language($language, $module)
{
	global $log;
	global $default_language, $translation_string_prefix;

	@include("modules/$module/language/$language.lang.php");
	if(!isset($mod_strings))
	{
		$log->warn("Unable to find the module language file for language: ".$language." and module: ".$module);
		require("modules/$module/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($mod_strings))
	{
		$log->fatal("Unable to load the module($module) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_module_language method ...");
		return null;
	}

	$return_value = $mod_strings;

	$log->debug("Exiting return_module_language method ...");
	return $return_value;
}

/** This function retrieves an application language file and returns the array of strings included in the $mod_list_strings var.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * If you are using the current language, do not call this function unless you are loading it for the first time */
function return_mod_list_strings_language($language,$module)
{
	global $log;
	$log->debug("Entering return_mod_list_strings_language(".$language.",".$module.") method ...");
	global $mod_list_strings, $default_language, $log, $currentModule,$translation_string_prefix;

	$language_used = $language;
	$temp_mod_list_strings = $mod_list_strings;

	if($currentModule == $module && isset($mod_list_strings) && $mod_list_strings != null)
	{
		$log->debug("Exiting return_mod_list_strings_language method ...");
		return $mod_list_strings;
	}

	@include("modules/$module/language/$language.lang.php");

	if(!isset($mod_list_strings))
	{
		$log->fatal("Unable to load the application list language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_mod_list_strings_language method ...");
		return null;
	}

	$return_value = $mod_list_strings;
	$mod_list_strings = $temp_mod_list_strings;

	$log->debug("Exiting return_mod_list_strings_language method ...");
	return $return_value;
}

/** This function retrieves a theme's language file and returns the array of strings included.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function return_theme_language($language, $theme)
{
	global $log;
	$log->debug("Entering return_theme_language(".$language.",". $theme.") method ...");
	global $mod_strings, $default_language, $log, $currentModule, $translation_string_prefix;

	$language_used = $language;

	@include("themes/$theme/language/$current_language.lang.php");
	if(!isset($theme_strings))
	{
		$log->warn("Unable to find the theme file for language: ".$language." and theme: ".$theme);
		require("themes/$theme/language/$default_language.lang.php");
		$language_used = $default_language;
	}

	if(!isset($theme_strings))
	{
		$log->fatal("Unable to load the theme($theme) language file for the selected language($language) or the default language($default_language)");
		$log->debug("Exiting return_theme_language method ...");
		return null;
	}

	// If we are in debug mode for translating, turn on the prefix now!
	if($translation_string_prefix)
	{
		foreach($theme_strings as $entry_key=>$entry_value)
		{
			$theme_strings[$entry_key] = $language_used.' '.$entry_value;
		}
	}

	$log->debug("Exiting return_theme_language method ...");
	return $theme_strings;
}



/** If the session variable is defined and is not equal to "" then return it.  Otherwise, return the default value.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
*/
function return_session_value_or_default($varname, $default)
{
	global $log;
	$log->debug("Entering return_session_value_or_default(".$varname.",". $default.") method ...");
	if(isset($_SESSION[$varname]) && $_SESSION[$varname] != "")
	{
		$log->debug("Exiting return_session_value_or_default method ...");
		return $_SESSION[$varname];
	}

	$log->debug("Exiting return_session_value_or_default method ...");
	return $default;
}

/**
  * Creates an array of where restrictions.  These are used to construct a where SQL statement on the query
  * It looks for the variable in the $_REQUEST array.  If it is set and is not "" it will create a where clause out of it.
  * @param &$where_clauses - The array to append the clause to
  * @param $variable_name - The name of the variable to look for an add to the where clause if found
  * @param $SQL_name - [Optional] If specified, this is the SQL column name that is used.  If not specified, the $variable_name is used as the SQL_name.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
  */
function append_where_clause(&$where_clauses, $variable_name, $SQL_name = null)
{
	global $log;
	$log->debug("Entering append_where_clause(".$where_clauses.",".$variable_name.",".$SQL_name.") method ...");
	if($SQL_name == null)
	{
		$SQL_name = $variable_name;
	}

	if(isset($_REQUEST[$variable_name]) && $_REQUEST[$variable_name] != "")
	{
		array_push($where_clauses, "$SQL_name like '$_REQUEST[$variable_name]%'");
	}
	$log->debug("Exiting append_where_clause method ...");
}

/**
  * Generate the appropriate SQL based on the where clauses.
  * @param $where_clauses - An Array of individual where clauses stored as strings
  * @returns string where_clause - The final SQL where clause to be executed.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
  */
function generate_where_statement($where_clauses)
{
	global $log;
	$log->debug("Entering generate_where_statement(".$where_clauses.") method ...");
	$where = "";
	foreach($where_clauses as $clause)
	{
		if($where != "")
		$where .= " and ";
		$where .= $clause;
	}

	$log->info("Here is the where clause for the list view: $where");
	$log->debug("Exiting generate_where_statement method ...");
	return $where;
}

/**
 * A temporary method of generating GUIDs of the correct format for our DB.
 * @return String contianing a GUID in the format: aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
 *
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
*/
function create_guid()
{
	global $log;
	$log->debug("Entering create_guid() method ...");
        $microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec* 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	$log->debug("Exiting create_guid method ...");
	return $guid;

}

/** Function to create guid section for a given character
  * @param $characters -- characters:: Type string
  * @returns $return -- integer:: Type integer``
  */
function create_guid_section($characters)
{
	global $log;
	$log->debug("Entering create_guid_section(".$characters.") method ...");
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= sprintf("%x", rand(0,15));
	}
	$log->debug("Exiting create_guid_section method ...");
	return $return;
}

/** Function to ensure length
  * @param $string -- string:: Type string
  * @param $length -- length:: Type string
  */

function ensure_length(&$string, $length)
{
	global $log;
	$log->debug("Entering ensure_length(".$string.",". $length.") method ...");
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
	$log->debug("Exiting ensure_length method ...");
}
/*
function microtime_diff($a, $b) {
	global $log;
	$log->debug("Entering microtime_diff(".$a.",". $b.") method ...");
	list($a_dec, $a_sec) = explode(" ", $a);
	list($b_dec, $b_sec) = explode(" ", $b);
	$log->debug("Exiting microtime_diff method ...");
	return $b_sec - $a_sec + $b_dec - $a_dec;
}
 */

/**
 * Return the display name for a theme if it exists.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_theme_display($theme) {
	global $log;
	$log->debug("Entering get_theme_display(".$theme.") method ...");
	global $theme_name, $theme_description;
	$temp_theme_name = $theme_name;
	$temp_theme_description = $theme_description;

	if (is_file("./themes/$theme/config.php")) {
		@include("./themes/$theme/config.php");
		$return_theme_value = $theme_name;
	}
	else {
		$return_theme_value = $theme;
	}
	$theme_name = $temp_theme_name;
	$theme_description = $temp_theme_description;

	$log->debug("Exiting get_theme_display method ...");
	return $return_theme_value;
}

/**
 * Return an array of directory names.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_themes() {
	global $log;
	$log->debug("Entering get_themes() method ...");
   if ($dir = @opendir("./themes")) {
		while (($file = readdir($dir)) !== false) {
           if ($file != ".." && $file != "." && $file != "CVS" && $file != "Attic" && $file != "akodarkgem" && $file != "bushtree" && $file != "coolblue" && $file != "Amazon" && $file != "busthree" && $file != "Aqua" && $file != "nature" && $file != "orange" && $file != "blue") {
			   if(is_dir("./themes/".$file)) {
				   if(!($file[0] == '.')) {
				   	// set the initial theme name to the filename
				   	$name = $file; 

				   	// if there is a configuration class, load that.
				   	if(is_file("./themes/$file/config.php"))
				   	{
				   		require_once("./themes/$file/config.php");
				   		$name = $theme_name;
				   	}

				   	if(is_file("./themes/$file/header.php"))
					{
						$filelist[$file] = $name;
					}
				   }
			   }
		   }
	   }
	   closedir($dir);
   }

   ksort($filelist);
   $log->debug("Exiting get_themes method ...");
   return $filelist;
}



/**
 * Create javascript to clear values of all elements in a form.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_clear_form_js () {
global $log;
$log->debug("Entering get_clear_form_js () method ...");
$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function clear_form(form) {
	for (j = 0; j < form.elements.length; j++) {
		if (form.elements[j].type == 'text' || form.elements[j].type == 'select-one') {
			form.elements[j].value = '';
		}
	}
}
//  End -->
</script>
EOQ;

$log->debug("Exiting get_clear_form_js  method ...");
return $the_script;
}

/**
 * Create javascript to set the cursor focus to specific vtiger_field in a form
 * when the screen is rendered.  The vtiger_field name is currently hardcoded into the
 * the function.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_set_focus_js () {
global $log;
$log->debug("Entering set_focus() method ...");
//TODO Clint 5/20 - Make this function more generic so that it can take in the target form and vtiger_field names as variables
$the_script = <<<EOQ
<script type="text/javascript" language="JavaScript">
<!-- Begin
function set_focus() {
	if (document.forms.length > 0) {
		for (i = 0; i < document.forms.length; i++) {
			for (j = 0; j < document.forms[i].elements.length; j++) {
				var vtiger_field = document.forms[i].elements[j];
				if ((vtiger_field.type == "text" || vtiger_field.type == "textarea" || vtiger_field.type == "password") &&
						!field.disabled && (vtiger_field.name == "first_name" || vtiger_field.name == "name")) {
				vtiger_field.focus();
                    if (vtiger_field.type == "text") {
                        vtiger_field.select();
                    }
					break;
	    		}
			}
      	}
   	}
}
//  End -->
</script>
EOQ;

$log->debug("Exiting get_set_focus_js  method ...");
return $the_script;
}

/**
 * Very cool algorithm for sorting multi-dimensional arrays.  Found at http://us2.php.net/manual/en/function.array-multisort.php
 * Syntax: $new_array = array_csort($array [, 'col1' [, SORT_FLAG [, SORT_FLAG]]]...);
 * Explanation: $array is the array you want to sort, 'col1' is the name of the column
 * you want to sort, SORT_FLAGS are : SORT_ASC, SORT_DESC, SORT_REGULAR, SORT_NUMERIC, SORT_STRING
 * you can repeat the 'col',FLAG,FLAG, as often you want, the highest prioritiy is given to
 * the first - so the array is sorted by the last given column first, then the one before ...
 * Example: $array = array_csort($array,'town','age',SORT_DESC,'name');
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function array_csort() {
   global $log;
   $log->debug("Entering array_csort() method ...");
   $args = func_get_args();
   $marray = array_shift($args);
   $i = 0;

   $msortline = "return(array_multisort(";
   foreach ($args as $arg) {
	   $i++;
	   if (is_string($arg)) {
		   foreach ($marray as $row) {
			   $sortarr[$i][] = $row[$arg];
		   }
	   } else {
		   $sortarr[$i] = $arg;
	   }
	   $msortline .= "\$sortarr[".$i."],";
   }
   $msortline .= "\$marray));";

   eval($msortline);
   $log->debug("Exiting array_csort method ...");
   return $marray;
}

/** Function to set default varibles on to the global variable
  * @param $defaults -- default values:: Type array
       */
function set_default_config(&$defaults)
{
	global $log;
	$log->debug("Entering set_default_config(".$defaults.") method ...");

	foreach ($defaults as $name=>$value)
	{
		if ( ! isset($GLOBALS[$name]) )
		{
			$GLOBALS[$name] = $value;
		}
	}
	$log->debug("Exiting set_default_config method ...");
}

$toHtml = array(
        '"' => '&quot;',
        '<' => '&lt;',
        '>' => '&gt;',
        '& ' => '&amp; ',
        "'" =>  '&#039;',
	'' => '\r',
        '\r\n'=>'\n',

);

/** Function to convert the given string to html
  * @param $string -- string:: Type string
  * @param $ecnode -- boolean:: Type boolean
    * @returns $string -- string:: Type string 
      *
       */
function to_html($string, $encode=true)
{
	global $log,$default_charset;
	//$log->debug("Entering to_html(".$string.",".$encode.") method ...");
	global $toHtml;
	$action = $_REQUEST['action'];
	$search = $_REQUEST['search'];

	$doconvert = false;

	if($_REQUEST['module'] != 'Settings' && $_REQUEST['file'] != 'ListView' && $_REQUEST['module'] != 'Portal' && $_REQUEST['module'] != "Reports")// && $_REQUEST['module'] != 'Emails')
		$ajax_action = $_REQUEST['module'].'Ajax';

	if(is_string($string))
	{
		if($action != 'CustomView' && $action != 'Export' && $action != $ajax_action && $action != 'LeadConvertToEntities' && $action != 'CreatePDF' && $action != 'ConvertAsFAQ' && $_REQUEST['module'] != 'Dashboard' && $action != 'CreateSOPDF' && $action != 'SendPDFMail' && (!isset($_REQUEST['submode'])) )
		{
			$doconvert = true;
		}
		else if($search == true)
		{
			// Fix for tickets #4647, #4648. Conversion required in case of search results also.
			$doconvert = true;
		}
		if ($doconvert == true)
		{
			if(strtolower($default_charset) == 'utf-8') 
				$string = htmlentities($string, ENT_QUOTES, $default_charset);
			else
				$string = preg_replace(array('/</', '/>/', '/"/'), array('&lt;', '&gt;', '&quot;'), $string);
		}
	}

	//$log->debug("Exiting to_html method ...");
	return $string;
}

/** Function to get the tabname for a given id
  * @param $tabid -- tab id:: Type integer
    * @returns $string -- string:: Type string 
      *
       */

function getTabname($tabid)
{
	global $log;
	$log->debug("Entering getTabname(".$tabid.") method ...");
        $log->info("tab id is ".$tabid);
        global $adb;
	$sql = "select tablabel from vtiger_tab where tabid=?";
	$result = $adb->pquery($sql, array($tabid));
	$tabname=  $adb->query_result($result,0,"tablabel");
	$log->debug("Exiting getTabname method ...");
	return $tabname;

}

/** Function to get the tab module name for a given id
  * @param $tabid -- tab id:: Type integer
    * @returns $string -- string:: Type string 
      *
       */

function getTabModuleName($tabid)
{
	global $log;
	$log->debug("Entering getTabModuleName(".$tabid.") method ...");
	if (file_exists('tabdata.php') && (filesize('tabdata.php') != 0))
        {
                include('tabdata.php');
		$tabname = array_search($tabid,$tab_info_array);
        }
        else
        {
	global $log;
        $log->info("tab id is ".$tabid);
        global $adb;
        $sql = "select name from vtiger_tab where tabid=?";
        $result = $adb->pquery($sql, array($tabid));
        $tabname=  $adb->query_result($result,0,"name");
	}
	$log->debug("Exiting getTabModuleName method ...");
        return $tabname;
}

/** Function to get column fields for a given module
  * @param $module -- module:: Type string
    * @returns $column_fld -- column field :: Type array 
      *
       */

function getColumnFields($module)
{
	global $log;
	$log->debug("Entering getColumnFields(".$module.") method ...");
	$log->info("in getColumnFields ".$module);
	global $adb;
	$column_fld = Array();
    $tabid = getTabid($module);
	if ($module == 'Calendar') {
    	$tabid = array('9','16');
    }
	$sql = "select * from vtiger_field where tabid in (" . generateQuestionMarks($tabid) . ") and vtiger_field.presence in (0,2)";
        $result = $adb->pquery($sql, array($tabid));
        $noofrows = $adb->num_rows($result);
		
	
	for($i=0; $i<$noofrows; $i++)
	{
		$fieldname = $adb->query_result($result,$i,"fieldname");
		$column_fld[$fieldname] = ''; 
	}
	$log->debug("Exiting getColumnFields method ...");
	return $column_fld;	
}

/** Function to get a users's mail id
  * @param $userid -- userid :: Type integer
    * @returns $email -- email :: Type string 
      *
       */

function getUserEmail($userid)
{
	global $log;
	$log->debug("Entering getUserEmail(".$userid.") method ...");
	$log->info("in getUserEmail ".$userid);

        global $adb;
        if($userid != '')
        {
                $sql = "select email1 from vtiger_users where id=?";
                $result = $adb->pquery($sql, array($userid));
                $email = $adb->query_result($result,0,"email1");
        }
	$log->debug("Exiting getUserEmail method ...");
        return $email;
}	

function getmatricule($userid)
{
	global $log;
	$log->debug("Entering getmatricule(".$userid.") method ...");
	$log->info("in getmatricule ".$userid);

        global $adb;
        if($userid != '')
        {
                $sql = "select matricule from demande where demandeid=?";
                $result = $adb->pquery($sql, array($userid));
                $matricule = $adb->query_result($result,0,"matricule");
        }
	$log->debug("Exiting getmatricule method ...");
        return $matricule;
}

function getNumeroOM($demandeid)
{
	global $log;
	$log->debug("Entering getNumeroOM(".$demandeid.") method ...");
	$log->info("in getNumeroOM ".$demandeid);

        global $adb;
        if($demandeid != '')
        {
                $sql = "SELECT numom FROM ordremission WHERE omid=?";
                $result = $adb->pquery($sql, array($demandeid));
                $numom = $adb->query_result($result,0,"numom");
        }
	$log->debug("Exiting getNumeroOM method ...");
        return $numom;
}

function getInfosOM($demandeid)
{
	global $log;
	$log->debug("Entering getInfosOM(".$demandeid.") method ...");
	$log->info("in getNumeroOM ".$demandeid);

        global $adb;
        if($demandeid != '')
        {
                $sql = "SELECT numom,datecreation FROM ordremission WHERE omid=?";
                $result = $adb->pquery($sql, array($demandeid));
				$row1 = $adb->fetchByAssoc($result);
        }
	$log->debug("Exiting getInfosOM method ...");
        return $row1;
}

function getServiceAgent($userdirection)
{
	global $adb;
	$sql = "SELECT dep1.organesigle,dep1.organeparent,dep2.organesigle,CONCAT(dep1.organesigle,'(',dep2.organesigle,')') as service
				  FROM departements dep1 
				  LEFT JOIN departements dep2 ON CONCAT(dep2.organeparent,':',dep1.organecode)=dep1.organeparent WHERE dep1.organecode =? ";
	
	
				$resultat = $adb->pquery($sql, array($userdirection));
				$direction = $adb->query_result($resultat,0,"service");
				
	       return $direction;
		
       
}

function is_PosteurDemande($iddemande,$matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_PosteurDemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT User_Matricule FROM users,vtiger_crmentity 
				WHERE vtiger_crmentity.smcreatorid= users.user_id
				AND vtiger_crmentity.crmid=?
				AND  users.User_Matricule=?  " ;
		$result = $adb->pquery($query, array($iddemande,$matricule));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['matricule'])!='' ))
			return 1;
		else
			return 0;
}

function is_ChargeMissionDemande($matricule,$iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_ChargeMissionDemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matricule) nbrow FROM demande WHERE  demande.matricule=? AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($matricule,$iddemande));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function is_DemandeCIP($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_DemandeCIP(".$iddemande.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(u2.user_id) AS nbrow
				FROM demande,vtiger_crmentity,users u2
				WHERE vtiger_crmentity.crmid = demande.demandeid 
				AND vtiger_crmentity.`smcreatorid`=u2.user_id
				AND u2.User_Direction LIKE '04-00%'
				AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}
function is_DemandeCourJustice($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_DemandeCourJustice(".$iddemande.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(u2.user_id) AS nbrow
				FROM demande,vtiger_crmentity,users u2
				WHERE vtiger_crmentity.crmid = demande.demandeid 
				AND vtiger_crmentity.`smcreatorid`=u2.user_id
				AND u2.User_Direction LIKE '02-00%'
				AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function is_DemandePresidence($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_ChargeMissionDemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(u2.user_id) AS nbrow
				FROM demande,vtiger_crmentity,users u2
				WHERE vtiger_crmentity.crmid = demande.demandeid 
				AND vtiger_crmentity.`smcreatorid`=u2.user_id
				AND u2.User_Direction LIKE '01-01%'
				AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function is_DemandeCCR($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_DemandeCCR(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(u2.user_id) AS nbrow
				FROM demande,vtiger_crmentity,users u2
				WHERE vtiger_crmentity.crmid = demande.demandeid 
				AND vtiger_crmentity.`smcreatorid`=u2.user_id
				AND u2.User_Direction ='05-00-290'
				AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function getCategorieAgent($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getCategorieAgent(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT profilid
					FROM demande,users,siprod_users
					WHERE demande.matricule=users.User_Matricule
					AND users.user_id=siprod_users.userid
					AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		$categorie =$row1['profilid'];
		return  $categorie;
			
}
function getCategorieAgentInitiateur($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getCategorieAgentInitiateur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT profilid
				FROM demande,vtiger_crmentity,users,siprod_users
				WHERE vtiger_crmentity.crmid = demande.demandeid 
				AND users.user_id=siprod_users.userid
				AND vtiger_crmentity.smcreatorid=users.user_id
				AND demande.demandeid=? " ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		$categorie =$row1['profilid'];
		return  $categorie;
			
}
function getDirectionAgent($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDirectionAgent(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT User_Direction as direction FROM users WHERE User_Matricule=? " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		$direction =$row1['direction'];
		
		return  $direction;
			
}
function getDepartementAgent($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDepartementAgent(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT SUBSTRING(users.User_Direction,1,5) as depart FROM users WHERE User_Matricule=? " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		$depart =$row1['depart'];
		
		return  $depart;
			
}

/*
function getCategorieAgent($iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getCategorieAgent(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT SUM(TT.isdir) AS isdirect ,SUM(TT.isdc) AS iddirectc,SUM(TT.iscom)  AS iscommis
					FROM 
					(
					SELECT COUNT(*) AS isdir,0 AS isdc,0 AS iscom
					FROM demande,hierarchie
					WHERE demande.matricule=hierarchie.matdirecteur COLLATE utf8_unicode_ci
					AND demande.demandeid=?
					UNION
					SELECT 0 AS isdir,COUNT(*) AS isdc,0 AS iscom
					FROM demande,hierarchie
					WHERE demande.matricule=hierarchie.matdircab COLLATE utf8_unicode_ci
					AND demande.demandeid=?
					UNION
					SELECT 0 AS isdir,0 AS isdc,COUNT(*) AS iscom
					FROM demande,hierarchie
					WHERE demande.matricule=hierarchie.matcom COLLATE utf8_unicode_ci
					AND demande.demandeid=?
					) TT " ;
		$result = $adb->pquery($query, array($iddemande,$iddemande,$iddemande));
		$row1 = $adb->fetchByAssoc($result);
		$categorie ='';
		if($row1['iscommis']>0)
			$categorie='Commissaire';
		elseif ($row1['iddirectc']>0)
			$categorie='DirecteurCabinet';
		elseif ($row1['isdir']>0)	
			$categorie='Directeur';
		else
			$categorie='AgentSimple';
			
			return  $categorie;
			
}
*/

function is_rejetHorsDelaiDemande($demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_rejetHorsDelaiDemande(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(*) as nbrow FROM demande d,traitement_demandes td
					WHERE d.ticket=td.ticket
					AND d.demandeid=?
					AND d.statut='umv_denied'
					AND td.motif IN ('02','24') " ;
		$result = $adb->pquery($query, array($demandeid));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function is_rejetHorsBudgetDemande($demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_rejetHorsBudgetDemande(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(*) as nbrow FROM demande d,traitement_demandes td
					WHERE d.ticket=td.ticket
					AND d.demandeid=?
					AND d.statut='umv_denied'
					AND td.motif IN ('01','03','04','05') " ;
		$result = $adb->pquery($query, array($demandeid));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}

function is_directeur($matricule,$direction)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matdirecteur) nbrow FROM hierarchie WHERE hierarchie.matdirecteur =? and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}
function is_directeurInterim($matricule,$direction)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeurinterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.codedirection =? 
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($direction,$matricule));
		$row1 = $adb->fetchByAssoc($result);
		//if ($row1['nbrow']>=1) $row1['nbrow']=1;
		return $row1['nbrow'];
}

function is_dircabInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_dircabInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.codedirection LIKE'%-100'
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;

		return $row1['nbrow'];
}

function is_RUMVInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_RUMVInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.matdirecteur='109'
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;

		return $row1['nbrow'];
}

function is_dircabpcomInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_dircabpcomInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.codedirection ='01-01-100'
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;

		return $row1['nbrow'];
}

function is_CommissaireInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_CommissaireInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
			WHERE ni.codedirection LIKE '%-100'
			AND iscommissaire=1
			AND ni.matinterimaire=?
			AND ni.active=1
			AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;
		return $row1['nbrow'];
}

function getdirectionsInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getdirectionInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT `codedirection` FROM interims ni
					WHERE  ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin  " ;
		$result = $adb->pquery($query, array($matricule));
		$i=0;
		while ($row1 = $adb->fetchByAssoc($result))
		{
			$LISTDIRECTION[$i++]=$row1['codedirection'];
		}
	 
		return $LISTDIRECTION;
}

function getcabinetsInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getdirectionInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT codedirection FROM interims ni
						WHERE  ni.matinterimaire=?
						AND ni.codedirection LIKE'%-100'
						AND ni.active=1
						AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$i=0;
		while ($row1 = $adb->fetchByAssoc($result))
		{
			$LISTDIRECTION[$i++]=$row1['codedirection'];
		}
	 
		return $LISTDIRECTION;
}


function getTabToList($tab)
{
	$list="";
	foreach($tab as $key=>$element)
	{
		$list.= "'".$element."',";
	}  
	$list = substr($list,0,-1);
	return $list;
}

function getTabToCond($tab)
{
	$list=" AND (";
	foreach($tab as $key=>$element)
	{
		$list.= " u2.User_Direction like '".substr($element,0,5)."%' OR ";

	}  
	$list = substr($list,0,-3).' )  ';
	return $list;
}

	function is_DirecteurCabinet($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matdircab) nbrow FROM hierarchie WHERE hierarchie.matdircab =? and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
function is_SecretaireGeneralCC($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_SecretaireGeneralCC(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matdircab) nbrow FROM hierarchie WHERE hierarchie.matdircab =? and hierarchie.direction like '03-%' and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
function is_DirecteurCabinetInterim($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM hierarchie nh,interims ni
				  WHERE SUBSTRING(nh.direction,1,5)=SUBSTRING(?,1,5) 
					AND nh.matdircab=ni.matdirecteur
					AND nh.direction=ni.codedirection
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() BETWEEN ni.datedebut AND ni.datefin " ;
		$result = $adb->pquery($query, array($direction,$matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}	
	
	function is_Commissaire($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matcom) nbrow FROM hierarchie WHERE hierarchie.matcom =? and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	/*
	function is_DirecteurCabinetPCOM($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matdircabpcom) nbrow FROM hierarchie WHERE hierarchie.matdircabpcom =? and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}*/
	function is_DirecteurCabinetPCOM($matricule)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(*) as nbrow FROM users,siprod_users
					WHERE siprod_users.userid= users.user_id
					AND siprod_users.profilid='22'
					AND User_Direction LIKE '01-01%'
					AND users.User_Matricule=?" ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	function is_PresidentCOM($matricule)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_PresidentCOM(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(*) as nbrow FROM users,siprod_users
					WHERE siprod_users.userid= users.user_id
					AND siprod_users.profilid='25'
					AND User_Direction LIKE '01-01%'
					AND users.User_Matricule=?" ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	
	function is_PCOMInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_PCOMInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.codedirection ='01-01-100' 
					AND iscommissaire=1
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;

		return $row1['nbrow'];
}
	function is_PresidentCC($matricule)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_PresidentCC(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(*) as nbrow FROM users,siprod_users
					WHERE siprod_users.userid= users.user_id
					AND siprod_users.profilid='25'
					AND User_Direction LIKE '03-00%'
					AND users.User_Matricule=?" ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	
	function is_PresidentCCInterim($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_PresidentCCInterim(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(interimid) nbrow FROM interims ni
					WHERE ni.codedirection LIKE '03-00%'
					AND iscommissaire=1
					AND ni.matinterimaire=?
					AND ni.active=1
					AND CURDATE() >= ni.datedebut AND CURDATE() <= ni.datefin " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		if ($row1['nbrow']>=1) $row1['nbrow']=1;

		return $row1['nbrow'];
}
	function is_ResponsableUMV($matricule,$direction)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matresponsumv) nbrow FROM hierarchie WHERE hierarchie.matresponsumv =? and hierarchie.direction=? " ;
		$result = $adb->pquery($query, array($matricule,$direction));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	
	function is_AgentUMV($matricule)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_directeur(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(matagentumv) nbrow FROM hierarchie WHERE hierarchie.matagentumv =?" ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
	}
	
	function is_InitiateurDemande($matricule,$iddemande)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_InitiateurDemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT count(user_id) nbrow
				FROM users,vtiger_crmentity WHERE vtiger_crmentity.smcreatorid=users.user_id
				AND setype='Demandes' AND vtiger_crmentity.crmid=? AND users.User_Matricule=? " ;
		$result = $adb->pquery($query, array($iddemande,$matricule));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
		
	}
	function getInitiateurDemande($iddemande)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getInitiateurDemande(".$iddemande.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT user_id,User_Matricule,user_name,user_firstname 
					FROM demande,users,vtiger_crmentity 
					WHERE vtiger_crmentity.crmid=demande.demandeid
					AND vtiger_crmentity.smcreatorid=users.user_id
					AND demande.demandeid=?" ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		
			return $row1['user_firstname'].' '.$row1['user_name'];
	}
	
	function getInitiateurDemandeInfos($iddemande)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getInitiateurDemandeInfos(".$iddemande.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT user_id,CONCAT(user_firstname,' ',user_name) as nomcomplet,user_login,User_Direction,SUBSTRING(User_Direction,1,5) User_Departement,User_Matricule,user_Email
					FROM demande,users,vtiger_crmentity 
					WHERE vtiger_crmentity.crmid=demande.demandeid
					AND vtiger_crmentity.smcreatorid=users.user_id
					AND demande.demandeid=?" ;
		$result = $adb->pquery($query, array($iddemande));
		$row1 = $adb->fetchByAssoc($result);
		
			return $row1;
	}
	
function getListDivision($matricule)
{
	global $adb;
        
	
	$sql = "  SELECT affectdirection FROM tiers_agentsuemoa WHERE matricule =?";
			
	$result = $adb->pquery($sql, array($matricule));
	$direction = $adb->query_result($result,0,"affectdirection");
	return $direction;
		
       
}
function getListService()
{
	global $adb;
        
	
	$sql = "  SELECT affectdirection FROM tiers_agentsuemoa WHERE matricule =?";
			
	$result = $adb->pquery($sql, array($matricule));
	$direction = $adb->query_result($result,0,"affectdirection");
	return $direction;
		
       
}

function getListDirecteur()
{
	global $adb;
    global $log;
	
	$log->debug("Entering getListDirecteur() method ...");
	$log->info("in getListDirecteur ");    
	
	$sql = "  SELECT user_id,CONCAT(user_name,' ',user_firstname,' (',user_Fonction,')') AS nomdirecteur,User_Matricule as matricule,User_Direction as codedirection
				FROM users,siprod_users,vtiger_profile
				WHERE users.user_id=siprod_users.userid
				AND vtiger_profile.profileid=siprod_users.profilid
				AND ( profilid IN (21,22,25,26) OR User_Matricule IN ('109'))
				ORDER BY user_name asc";
			
	$result = $adb->pquery($sql, array());
	$LISTDIRECTEURS =array();
	$i=0;
	while ($row1 = $adb->fetchByAssoc($result))
	{
		$LISTDIRECTEURS[$i++]=$row1;
	}
	 $LISTDIROPT[''] = 'Choisir le responsable...';
	 
	foreach($LISTDIRECTEURS as $key=>$directeur)
	{
		$LISTDIROPT[$directeur['matricule']] = $directeur['nomdirecteur'];
	}  
	$log->debug("Exiting getListDirecteur method ...");
	
        return $LISTDIROPT;
		
       
}

function getListInterimaire()
{
	global $log;
	$log->debug("Entering getListInterimaire() method ...");
	$log->info("in getListInterimaire ");

        global $adb;
       
                $sql = "SELECT user_id,CONCAT(user_name,' ',user_firstname,' (',user_Fonction,')') AS nomcomplet,User_Matricule as matricule
						FROM users ORDER BY user_name ASC";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTAGENTS[]=$row;
	}
	 $AGENTSOPT[''] = 'Choisir l\'Int&eacute;rimaire...';
	 
	foreach($LISTAGENTS as $entry_key=>$agent)
	{
		$AGENTSOPT[$agent['matricule']] = $agent['nomcomplet'];
	}  
	$log->debug("Exiting getListInterimaire method ...");
        return $AGENTSOPT;
}


function getUserInfos($userlogin)
{
	global $log;
	$log->debug("Entering getUserInfos(".$userlogin.") method ...");
	$log->info("in getUserInfos ".$userlogin);

        global $adb;
        if($userlogin != '')
        {
                $sql = "select user_matricule, user_name, user_firstname,user_direction,user_fonction from users where user_login=?";
                $result = $adb->pquery($sql, array($userlogin));
                $user['matricule'] = $adb->query_result($result,0,"user_matricule");
                $user['nom'] = $adb->query_result($result,0,"user_name");
                $user['prenom'] = $adb->query_result($result,0,"user_firstname");
                $user_direction = $adb->query_result($result,0,"user_direction");
                $user['service'] = getServiceAgent($user_direction);

                $user['fonction'] = $adb->query_result($result,0,"user_fonction");		
        }
	$log->debug("Exiting getUserInfos method ...");
        return $user;
}	
function getSourceFinById($sourcefinid)
{
	global $log;
	$log->debug("Entering getSourceFinById(".$sourcefinid.") method ...");
	$log->info("in getSourceFinById ".$sourcefinid);

        global $adb;
        if($sourcefinid != '')
        {
                $sql = "SELECT sourcefinlib as sourcefin FROM sourcesfinancement WHERE sourcefincode=?";
                $result = $adb->pquery($sql, array($sourcefinid));
                $sourcefin = $adb->query_result($result,0,"sourcefin");
        }
	$log->debug("Exiting getSourceFinById method ...");
        return $sourcefin;
}

function getActiviteByCodeBudget($codebudget)
{
	global $log;
	$log->debug("Entering getActiviteByCodeBudget(".$codebudget.") method ...");
	$log->info("in getActiviteByCodeBudget ".$codebudget);

        global $adb;
        if($codebudget != '')
        {
                $sql = "SELECT CONCAT(libactivite,'(',centrefinancier,'-',domainefinancier,')') libactivite FROM codebudgetaire 
						WHERE CONCAT(centrefinancier,'-',domainefinancier)=? ";
                $result = $adb->pquery($sql, array($codebudget));
                $libactivite = $adb->query_result($result,0,"libactivite");
        }
	$log->debug("Exiting getActiviteByCodeBudget method ...");
        return $libactivite;
}

function getActiviteByCodeBudgetReunion($codebudget)
{
	global $log;
	$log->debug("Entering getActiviteByCodeBudgetReunion(".$codebudget.") method ...");
	$log->info("in getActiviteByCodeBudgetReunion ".$codebudget);

        global $adb;
        if($codebudget != '')
        {
                $sql = "SELECT CONCAT(centrefinancier,'-',domainefinancier,' : ',libactivite) libactivite FROM codebudgetaire 
						WHERE CONCAT(centrefinancier,'-',domainefinancier)=? ";
                $result = $adb->pquery($sql, array($codebudget));
                $libactivite = $adb->query_result($result,0,"libactivite");
        }
	$log->debug("Exiting getActiviteByCodeBudgetReunion method ...");
        return $libactivite;
}

function getInfosByDemande($iddemande)
{
	global $log;
	$log->debug("Entering getInfosByDemande(".$iddemande.") method ...");
	$log->info("in getInfosByDemande ".$iddemande);

        global $adb;
        if($iddemande != '')
        {
                $sql = "SELECT d.ticket,CONCAT(ag.user_name,' ',ag.user_firstname) AS nom,ag.user_name as nomfamille,d.fonction,d.statut,
						ag.user_Fonction AS affectdirection,d.datedebut,d.datefin,ag.User_Direction,
						cat.titrecat,lieu AS lieu,d.objet,d.commentbillet,
						trans.libmodetransp AS modetransp,ag.user_Email AS mailtocharge,
						d.budget,d.sourcefin,d.codebudget,d.comptenat,
						d.budget2,d.sourcefin2,d.codebudget2,d.comptenat2,
						d.budget3,d.sourcefin3,d.codebudget3,d.comptenat3,
						d.budget4,d.sourcefin4,d.codebudget4,d.comptenat4,
						d.budget5,d.sourcefin5,d.codebudget5,d.comptenat5,
						d.matricule
						FROM demande d
						INNER JOIN users ag ON ag.User_Matricule=d.matricule
						INNER JOIN categorie cat ON cat.codecatuemoa=ag.user_categmis 
						INNER JOIN modetransport trans ON trans.idmodetransp=d.modetransport COLLATE utf8_unicode_ci 
						WHERE d.demandeid=?";
                $result = $adb->pquery($sql, array($iddemande));
				$demande = $adb->fetchByAssoc($result);
				//$demande['service'] = getServiceAgent($demande['affectdirection']);
				$demande['sourcefinanc'] = $demande['sourcefin'];
				$demande['sourcefin'] = getSourceFinById($demande['sourcefin']);

				$demande['sourcefin2'] = getSourceFinById($demande['sourcefin2']);
				$demande['sourcefin3'] = getSourceFinById($demande['sourcefin3']);
				$demande['sourcefin4'] = getSourceFinById($demande['sourcefin4']);
				$demande['sourcefin5'] = getSourceFinById($demande['sourcefin5']);
				
        }
	$log->debug("Exiting getInfosByDemande method ...");
        return $demande;
}

function getInfosByDemandeBis($ticket)
{
	global $log;
	$log->debug("Entering getInfosByDemandeBis(".$ticket.") method ...");
	$log->info("in getInfosByDemandeBis ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT d.ticket,CONCAT(ag.user_name,' ',ag.user_firstname) AS nom,d.fonction,d.statut,
						ag.user_Fonction AS affectdirection,d.datedebut,d.datefin,
						cat.titrecat,lieu AS lieu,d.objet,d.commentbillet,
						trans.libmodetransp AS modetransp,ag.user_Email AS mailtocharge,
						d.budget,d.sourcefin,d.codebudget,d.comptenat,
						d.budget2,d.sourcefin2,d.codebudget2,d.comptenat2,
						d.budget3,d.sourcefin3,d.codebudget3,d.comptenat3,
						d.budget4,d.sourcefin4,d.codebudget4,d.comptenat4,
						d.budget5,d.sourcefin5,d.codebudget5,d.comptenat5,
						d.matricule
						FROM demande d
						INNER JOIN users ag ON ag.User_Matricule=d.matricule
						INNER JOIN categorie cat ON cat.codecatuemoa=ag.user_categmis 
						INNER JOIN modetransport trans ON trans.idmodetransp=d.modetransport COLLATE utf8_unicode_ci
						WHERE d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				$demande['service'] = getServiceAgent($demande['affectdirection']);
				$demande['sourcefin'] = getSourceFinById($demande['sourcefin']);
				$demande['sourcefin2'] = getSourceFinById($demande['sourcefin2']);
				$demande['sourcefin3'] = getSourceFinById($demande['sourcefin3']);
				$demande['sourcefin4'] = getSourceFinById($demande['sourcefin4']);
				$demande['sourcefin5'] = getSourceFinById($demande['sourcefin5']);
				
        }
	$log->debug("Exiting getInfosByDemande method ...");
        return $demande;
}
function getEmailRecepteurByDemande($ticket)
{
	global $log;
	$log->debug("Entering getInfosByDemande(".$ticket.") method ...");
	$log->info("in getInfosByDemande ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT d.matricule AS matagent,agcharge.user_Email AS mailto_charge,
						aginit.user_Email AS mailto_initiateur,
						nh.`emaildirecteur` AS mailto_directeur,
						nh.`emaildircab` AS mailto_dircab,
						nh.`emailcom` AS mailto_com
						FROM demande d,users aginit,users agcharge,
						vtiger_crmentity vt,`hierarchie` nh
						WHERE vt.crmid=d.demandeid
						AND agcharge.User_Matricule = d.matricule 
						AND aginit.user_id=vt.smcreatorid
						AND nh.`direction`=aginit.User_Direction
						AND d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getInfosByDemande method ...");
        return $demande;
}
function getStatutReunionById($idstatut)
{
	global $log;
	$log->debug("Entering getStatutReunionById() method ...");
       global $adb;
	
	$sql = "SELECT libstatus statut FROM reunionstatus WHERE status=?";
			
	$result = $adb->pquery($sql, array($idstatut));
	
	$statut = $adb->query_result($result,0,"statut");
	return $statut;

}
function getStatutTransfertById($idstatut)
{
	global $log;
	$log->debug("Entering getStatutTransfertById() method ...");
       global $adb;
	
	$sql = "SELECT libstatus statut FROM transfertstatus WHERE status=?";
			
	$result = $adb->pquery($sql, array($idstatut));
	
	$statut = $adb->query_result($result,0,"statut");
	return $statut;

}
function getInfosByOM($iddemande)
{
	global $log;
	$log->debug("Entering getInfosByOM(".$iddemande.") method ...");
	$log->info("in getInfosByOM ".$iddemande);

        global $adb;
        if($iddemande != '')
        {
                $sql = "SELECT d.numom,d.datedepart,d.datearrivee,DATE_ADD(d.datearrivee, INTERVAL 7 DAY) as delairegularisation, 
							 d.trajet1date,d.trajet1depart,d.trajet1arrivee,
							 d.trajet2date,d.trajet2depart,d.trajet2arrivee,
							 d.trajet3date,d.trajet3depart,d.trajet3arrivee,
							 d.trajet4date,d.trajet4depart,d.trajet4arrivee,
							 d.trajet5date,d.trajet5depart,d.trajet5arrivee,
							 d.trajet6date,d.trajet6depart,d.trajet6arrivee,
							 d.trajet7date,d.trajet7depart,d.trajet7arrivee,
							 d.trajet8date,d.trajet8depart,d.trajet8arrivee,
							 t.timbre1,t.timbre2,t.timbre3,d.signataire,
							 d.matricule
						FROM ordremission d
						INNER JOIN timbre t ON t.id=d.timbre
						WHERE d.omid=?";
						
                 $result = $adb->pquery($sql, array($iddemande));
				$demande = $adb->fetchByAssoc($result);
			
        }
	$log->debug("Exiting getInfosByOM method ...");
        return $demande;
}
function getDernMissionAgent($matricule)
{
	global $log;
	$log->debug("Entering getDernMissionAgent(".$matricule.") method ...");
	$log->info("in getDernMissionAgent ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT MAX(`datearrivee`) AS maxdate FROM ordremission 
						WHERE `ordremission`.matricule=? AND ordremission.deleted=0";
                $result = $adb->pquery($sql, array($matricule));
               $row = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getDernMissionAgent method ...");
        return $row['maxdate'];
}

function getNbJourConsommeAgent($matricule)
{
	global $log;
	$log->debug("Entering getNbJourAnneeAgent(".$matricule.") method ...");
	$log->info("in getNbJourAnneeAgent ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT COALESCE( SUM(COALESCE(DATEDIFF(datearrivee,datedepart),0)+1),0) AS nbjour 
						FROM ordremission
						INNER JOIN demande ON demande.demandeid=omid AND demande.lieu!='OUAGADOUGOU'
						WHERE ordremission.matricule=? AND ordremission.deleted=0";
                $result = $adb->pquery($sql, array($matricule));
               $row = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getNbJourAnneeAgent method ...");
        return $row['nbjour'];
}

function getmatriculeByTicket($ticket)
{
	global $log;
	$log->debug("Entering getmatriculeByDemandeId(".$ticket.") method ...");
	$log->info("in getmatriculeByDemandeId ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "select matricule from demande where ticket=?";
                $result = $adb->pquery($sql, array($ticket));
                $matricule = $adb->query_result($result,0,"matricule");
        }
	$log->debug("Exiting getmatriculeByDemandeId method ...");
        return $matricule;
}
function getDemandeIdByTicket($ticket)
{
	global $log;
	$log->debug("Entering getDemandeIdByTicket(".$ticket.") method ...");
	$log->info("in getDemandeIdByTicket ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "select demandeid from demande where ticket=?";
                $result = $adb->pquery($sql, array($ticket));
                $demandeid = $adb->query_result($result,0,"demandeid");
        }
	$log->debug("Exiting getDemandeIdByTicket method ...");
        return $demandeid;
}
function getTicketByDemandeId($demandeid)
{
	global $log;
	$log->debug("Entering getTicketByDemandeId(".$demandeid.") method ...");
	$log->info("in getTicketByDemandeId ".$demandeid);

        global $adb;
        if($demandeid != '')
        {
                $sql = "select ticket from demande where demandeid=?";
                $result = $adb->pquery($sql, array($demandeid));
                $ticket = $adb->query_result($result,0,"ticket");
        }
	$log->debug("Exiting getTicketByDemandeId method ...");
        return $ticket;
}

function SaveTraitementEnMasse($module,$record,$ticket,$statut) 
	{
		global $log, $singlepane_view,$adb,$current_user;	
		$log->debug("Entering SaveTraitementEnMasse method ($module,$record)");
			
		$current_id = $adb->getUniqueID("vtiger_crmentity");
		if($current_user->id == '')
			$current_user->id = 0;

		$sql = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,createdtime,modifiedtime) values(?,?,?,?,?,?)";
		$params = array($current_id, $current_user->id, $current_user->id, $module,date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
		$adb->pquery($sql, $params);
		
		$sql2 = "insert into traitement_demandes (traitementdemandeid,ticket,statut,datemodification) values(?,?,?,?)";
		$params2 = array($current_id,$ticket,$statut,date('Y-m-d H:i:s'));
		$adb->pquery($sql2, $params2);
		
		
		$reqUpdate= "update demande set statut ='".$statut."' where ticket= '".$ticket."' " ;
		$adb->pquery($reqUpdate, array());


		$mail_data = getRapportMailInfo($ticket,'',$module,$statut);
		//print_r($mail_data); break;
		getRapportNotification($mail_data,$module);
		// End envoi de notification 
		
		$log->debug("Exiting SaveTraitementEnMasse method ...");
	}
	
function getFonctionByMatricule($matricule)
{
	global $log;
	$log->debug("Entering getFonctionByMatricule(".$matricule.") method ...");
	$log->info("in getFonctionByMatricule ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT user_Fonction AS fonction FROM users WHERE User_Matricule=?";
                $result = $adb->pquery($sql, array($matricule));
                $fonction = $adb->query_result($result,0,"fonction");
        }
	$log->debug("Exiting getFonctionByMatricule method ...");
        return $fonction;
}

function getDirectionResp($matricule)
{
	global $log;
	$log->debug("Entering getDirectionResp(".$matricule.") method ...");
	$log->info("in getDirectionResp ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT codeservice,libservice,codedepartement,libdepartement,profilid 
						FROM services,users,siprod_users
						WHERE User_Direction=codeservice
						AND siprod_users.userid=users.user_id
						AND User_Matricule=?";
                $result = $adb->pquery($sql, array($matricule));
               $row = $adb->fetchByAssoc($result);
			   $profilid = $row['profilid'];
			   $codedirection = "";
			   $libdirection = "";

			  if ($profilid == '25')
			   {
					$libdirection = $row['libdepartement'];
				}
				else		
					$libdirection = $row['libservice'];
				
        }
	$log->debug("Exiting getDirectionResp method ...");
        return $libdirection;
}
function getDirectionInterim($matricule)
{
	global $log;
	$log->debug("Entering getDirectionInterim(".$matricule.") method ...");
	$log->info("in getDirectionInterim ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT codeservice,libservice,codedepartement,libdepartement,profilid 
						FROM services,users,siprod_users
						WHERE User_Direction=codeservice
						AND siprod_users.userid=users.user_id
						AND User_Matricule=?";
                $result = $adb->pquery($sql, array($matricule));
               $row = $adb->fetchByAssoc($result);
			   $profilid = $row['profilid'];
			   $codedirection = "";
			   $libdirection = "";

			  if ($profilid == '25')
			   {
					$direction = $row['codeservice'].'##'.$row['libdepartement'];
				}
				else		
					$direction = $row['codeservice'].'##'.$row['libservice'];
				
        }
	$log->debug("Exiting getDirectionInterim method ...");
        return $direction;
}

function getAllStatuts()
{
	global $log;
	$log->debug("Entering getAllStatuts() method ...");
	$log->info("in getAllStatuts ");

        global $adb;
       
                $sql = "SELECT STATUS,libstatus FROM demsetatus ORDER BY libstatus";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTSTATUTS[]=$row;
	}
	 $LISTSTATUTSSOPT[''] = 'Tous';
	 
	foreach($LISTSTATUTS as $entry_key=>$statut)
	{
		$LISTSTATUTSSOPT[$statut['status']] = $statut['libstatus'];
	}  
	$log->debug("Exiting getAllStatuts method ...");
        return $LISTSTATUTSSOPT;
}

function getAllDepartements()
{
	global $log;
	$log->debug("Entering getAllDepartements() method ...");
	$log->info("in getAllDepartements ");

        global $adb;
       
                $sql = "SELECT codedepartement,libdepartement FROM services order by 2 desc";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTDEPARTS[]=$row;
	}
	 $LISTDEPARTSOPT[''] = 'Tous';
	 
	foreach($LISTDEPARTS as $entry_key=>$depart)
	{
		$LISTDEPARTSOPT[$depart['codedepartement']] = $depart['libdepartement'];
	}  
	$log->debug("Exiting getAllDepartements method ...");
        return $LISTDEPARTSOPT;
}

function deleteDecompte($iddemande)
{	
		global $log,$adb;
		$log->debug("Entering deleteDecompte(".$iddemande.") method ...");
		
		$sql_decompte ='DELETE FROM decompte WHERE iddemande = ? ';
		$adb->pquery($sql_decompte, array($iddemande));
	
}
function saveDecompte($decomptes,$iddemande)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDecompteBydemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
        global $adb;
		 for($i=0; $i<count($decomptes); $i++)
        {
				// $params = array($iddemande,$decomptes[$i]['zone'], $decomptes[$i]['nbjindemn'], $decomptes[$i]['indemnite'], $decomptes[$i]['nbjheberg'], $decomptes[$i]['herbergement'],$decomptes[$i]['nbjtransp'],$decomptes[$i]['transport']);
				 $params = array($iddemande,$decomptes[$i]['ville'],$decomptes[$i]['sourcefin'],$decomptes[$i]['codebudget'],$decomptes[$i]['comptenat'], $decomptes[$i]['nbjindemn'], $decomptes[$i]['indemnite'], $decomptes[$i]['nbjheberg'], $decomptes[$i]['herbergement'],$decomptes[$i]['nbjtransp'],$decomptes[$i]['transport']);
                $adb->pquery("insert into decompte(iddemande,lieu,sourcefin,codebudget,comptenat,nbjindemn,tauxindemn,nbjheberg,tauxheberg,nbjtransp,tauxtransp) values (?,?,?,?,?,?,?,?,?,?,?)", $params);
			//print_r($decomptes[$i]);echo"<br>";
		}
	
		
}

function getDecompteBydemande2($demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDecompteBydemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT TRAJETS.zone,
					GROUP_CONCAT(DISTINCT TRAJETS.ville SEPARATOR '/') ville,
					TRAJETS.sourcefin,TRAJETS.codebudget,TRAJETS.comptenat,
					SUM(TRAJETS.nbjindemn) nbjindemn,TRAJETS.indemnite,
					SUM(TRAJETS.nbjheberg) nbjheberg,TRAJETS.herbergement,
					SUM(TRAJETS.nbjtransp) nbjtransp,TRAJETS.transport,
					SUM(TRAJETS.mnttotal) mnttotal
					FROM 
					(
					SELECT trajet1zone AS zone,trajet1arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet2date,trajet1date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet2date,trajet1date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet2date,trajet1date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet2date,trajet1date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet2date,trajet1date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet2date,trajet1date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet1zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet1zone  
					WHERE ordremission.omid=?


					UNION

					SELECT trajet2zone AS zone,trajet2arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet3date,trajet2date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet3date,trajet2date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet3date,trajet2date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet3date,trajet2date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet3date,trajet2date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet3date,trajet2date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet2zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet2zone  
					WHERE ordremission.omid=?
					AND trajet2arrivee<>trajet1depart
					AND trajet2date<>trajet3date

					UNION

					SELECT trajet3zone AS zone,trajet3arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet4date,trajet3date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet4date,trajet3date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet4date,trajet3date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet4date,trajet3date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet4date,trajet3date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet4date,trajet3date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet3zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet3zone  
					WHERE ordremission.omid=?
					AND trajet3arrivee<>trajet1depart
					AND trajet3date<>trajet4date

					UNION

					SELECT trajet4zone AS zone,trajet4arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet5date,trajet4date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet5date,trajet4date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet5date,trajet4date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet5date,trajet4date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet5date,trajet4date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet5date,trajet4date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet4zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet4zone  
					WHERE ordremission.omid=?
					AND trajet4arrivee<>trajet1depart
					AND trajet4date<>trajet5date

					UNION

					SELECT trajet5zone AS zone,trajet5arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet6date,trajet5date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet6date,trajet5date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet6date,trajet5date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet6date,trajet5date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet6date,trajet5date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet6date,trajet5date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet5zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet5zone  
					WHERE ordremission.omid=?
					AND trajet5arrivee<>trajet1depart
					AND trajet5date<>trajet6date

					UNION

					SELECT trajet6zone AS zone,trajet6arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet7date,trajet6date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet7date,trajet6date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet7date,trajet6date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet7date,trajet6date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet7date,trajet6date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet7date,trajet6date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet6zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet6zone  
					WHERE ordremission.omid=?
					AND trajet6arrivee<>trajet1depart
					AND trajet6date<>trajet7date

					UNION

					SELECT trajet7zone AS zone,trajet7arrivee AS ville,
					demande.sourcefin,demande.codebudget,demande.comptenat,
					COALESCE(DATEDIFF(trajet8date,trajet7date),0) AS nbjindemn,bareme.indemnite,
					COALESCE(DATEDIFF(trajet8date,trajet7date),0) AS nbjheberg,bareme.herbergement,
					COALESCE(DATEDIFF(trajet8date,trajet7date),0) AS nbjtransp,bareme.transport,
					(	( (COALESCE(DATEDIFF(trajet8date,trajet7date),0))*bareme.indemnite )+
						( (COALESCE(DATEDIFF(trajet8date,trajet7date),0))*bareme.herbergement )
						+
						( (COALESCE(DATEDIFF(trajet8date,trajet7date),0))*bareme.transport)
					) AS mnttotal
					FROM ordremission
					INNER JOIN demande ON demande.demandeid = ordremission.omid 
					INNER JOIN users ON users.user_matricule = ordremission.matricule 
					INNER JOIN categorie ON categorie.codecatuemoa = users.user_categmis
					INNER JOIN bareme ON bareme.zone = ordremission.trajet7zone 
					AND bareme.catperd = categorie.codeperdcat
					INNER JOIN zone ON zone.idzone = ordremission.trajet7zone  
					WHERE ordremission.omid=?
					AND trajet7arrivee<>trajet1depart
					AND trajet7date<>trajet8date

					)TRAJETS
					GROUP BY TRAJETS.zone
					ORDER BY 1";
		
		$result = $adb->pquery($query, array($demandeid,$demandeid,$demandeid,$demandeid,$demandeid,$demandeid,$demandeid,));
		$LISTDECOMPTES = array();
		$totaldecompte=0;
		$cpt=0;
		while ($row = $adb->fetchByAssoc($result))
		{
			$LISTDECOMPTES[]=$row;
			$cpt++;
		}
		$rowend = $LISTDECOMPTES[$cpt-1];
		$rowend['nbjindemn']+=1;
		$rowend['nbjtransp']+=1;
		$rowend['mnttotal']=($rowend['nbjindemn']*$rowend['indemnite'])+($rowend['indemnite']*$rowend['nbjheberg'])+($rowend['herbergement']*$rowend['transport']);
		$LISTDECOMPTES[$cpt-1]=$rowend;
		return $LISTDECOMPTES;
}

/**************************** NOMAGE GESTION DES ENGAGEMENT **************************************/

function getSocieteSap($direction)
{
	global $log;
	$log->debug("Entering getSocieteSap(".$direction.") method ...");
	$log->info("in getSocieteSap ".$direction);

        global $adb;
        if($direction != '')
        {
		$idsociete = substr($direction,0,2);
                $sql = "SELECT codeidentsap FROM societe WHERE codeidentuemoa=?";
                $result = $adb->pquery($sql, array($idsociete));
                $codeidentsap = $adb->query_result($result,0,"codeidentsap");
        }
	$log->debug("Exiting getSocieteSap method ...");
        return $codeidentsap;
}

function getTotalDecomptes($iddemande)
{
	global $log;
	$log->debug("Entering getTotalDecompte(".$iddemande.") method ...");
	$log->info("in getTotalDecompte ".$iddemande);

        global $adb;
        if($iddemande != '')
        {
                $sql = "SELECT DECOMPT.iddemande,DECOMPT.codebudget,DECOMPT.sourcefin,DECOMPT.comptenat,DECOMPT.mnttotal AS totaldecompte
			FROM
			(SELECT decompte.iddemande,decompte.codebudget,decompte.sourcefin,decompte.comptenat,decompte.lieu AS zone,
			nbjindemn AS nbjindemn,tauxindemn AS indemnite,
			nbjheberg AS nbjheberg,tauxheberg AS herbergement,
			nbjtransp AS nbjtransp,tauxtransp AS transport,
			(	( (COALESCE(nbjindemn,0))*tauxindemn )+
				( (COALESCE(nbjheberg,0))*tauxheberg )
				+
				( (COALESCE(nbjtransp,0))*tauxtransp)
			) AS mnttotal
			FROM decompte
			INNER JOIN demande ON demande.demandeid = decompte.iddemande 
			WHERE decompte.iddemande=?
			)DECOMPT ";
			// GROUP BY DECOMPT.codebudget";
			
                $result = $adb->pquery($sql, array($iddemande));
		$i=0;
		while ($row = $adb->fetchByAssoc($result))
		{
			$LISTDECOMPTES[$i++]=array('codebudget'=>$row['codebudget'],'sourcefin'=>$row['sourcefin'],'comptenat'=>$row['comptenat'],'totaldecompte'=>$row['totaldecompte']);
		}
		return $LISTDECOMPTES;
				
        }
	$log->debug("Exiting getTotalDecompte method ...");
        return $LISTDECOMPTES;
}
function is_engageOM($demandeid)
{
	global $log, $singlepane_view,$adb;
		$log->debug("Entering is_engageOM(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(*) AS nbrow FROM ordremission
				WHERE omid=?
				AND numengagement LIKE '050%' " ;
		$result = $adb->pquery($query, array($demandeid));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}
function createEngagementMission($infosengagement)
{	
	global $log, $singlepane_view,$adb,$WSSAP;
	$log->debug("Entering createEngagementMission(".$infosengagement.") method ...");
	global $app_strings, $mod_strings;
	
	header('Content-Type: text/html; charset=utf-8');

	$SOAP_AUTH = array( 'login'=> $WSSAP['SOAP_AUTH']['user'],'password' => $WSSAP['SOAP_AUTH']['password']);
			
	$WSDL = $WSSAP['URL_ENGAGEMENTMISSION'];

   #Create Client Object, download and parse WSDL
    $client = new SoapClient($WSDL,$SOAP_AUTH);
   
	$mission->Benef=$infosengagement['nomcharge'];  // Matricule du Chargé de Mission
	$mission->Mission=$infosengagement['numom']; // Numéro de l'OM
	$mission->Societe=$infosengagement['societecharge']; // Socité de la Commission ou cour des comptes
	$mission->Texteh=$infosengagement['objetmission']; // Objet de la Mission
	$mission->User=$infosengagement['curentuserloginsap']; // Personne gérérant l'OM
		
	$decomptes = $infosengagement['decomptes'];
	for($i=0; $i<count($decomptes); $i++) 
	{
					
		$mission->ItPost->item[$i]->Montant=$decomptes[$i]['totaldecompte']; // total fiche de decompte
		$mission->ItPost->item[$i]->Texte=$infosengagement['matcharge']; // 
		$mission->ItPost->item[$i]->Compte=$decomptes[$i]['comptenat']; // compte nature
		$mission->ItPost->item[$i]->Fonds=$decomptes[$i]['sourcefin']; //  Source de Finanacement
//		$mission->ItPost->item[$i]->Fourn='0000'.$WSSAP['CODEFOURNISSEUR']; // Code fournisseur de Syntyche
		$mission->ItPost->item[$i]->Fourn=$WSSAP['CODEFOURNISSEUR']; // Code fournisseur de Syntyche
		$mission->ItPost->item[$i]->CodeBudgt=$decomptes[$i]['codebudget']; // Code Budgétaire
				
	}
	
	//print_r($mission);
	//echo "<br>*************************</br>";
	//print_r($WSSAP);
	
    $resultat='';
   try
    {
      $result = $client->ZLoadCommitment($mission); 
    }
    catch (SoapFault $exception)
    {
        print "***Caught Exception***\n";
        print_r($exception);
        print "***END Exception***\n";
        die();
    }
    
    //print_r($result);
   // $resultat = $result->Belnr;
    $resultat['code'] = $result->Belnr;
    $resultat['msg'] = $result->ItIo;
	
	
    return $resultat;
		
}

/*
function getInfosDisponibiliteFonds($infosbudget)
{	
	global $log, $singlepane_view,$adb,$WSSAP;
	$log->debug("Entering getInfosDisponibiliteFonds(".$infosbudget.") method ...");
	global $app_strings, $mod_strings;
	
	header('Content-Type: text/html; charset=utf-8');

	$SOAP_AUTH = array( 'login'=> $WSSAP['SOAP_AUTH']['user'],'password' => $WSSAP['SOAP_AUTH']['password']);
			
	$WSDL = $WSSAP['URL_CONTRDISPOFOND'];

   #Create Client Object, download and parse WSDL
    try{
		$client = new SoapClient($WSDL,$SOAP_AUTH);
	}
	catch ( SoapFault $e )
	{
	    echo 'Le système SAP est momentatément indispensable pour afficher les informations de disponibilité des crédits 1';
	}
   //print_r($infosbudget);
	$budget->AFISCAL=$WSSAP['AFISCAL'];  // Année budgétaire
	$budget->CODE_BUDGETAIRE=$infosbudget['codebudget']; // Code budgétaire
	$budget->CPTE_BUDGETAIRE=$infosbudget['comptenat']; // Compte nature
	$budget->FOND=$infosbudget['sourcefin']; // Source de Finanacement
	
	$societe = substr($infosbudget['codebudget'], 0, 2);
	$budget->PF=$WSSAP['PERIMETREFIN'][$societe]; // Périmétre Financier
	
			
    $resultat='';
	
   try
    {
      $result = $client->ZGET_AVAIBILITY($budget); 
    }
    catch (SoapFault $exception)
    {
      //  print "***Caught Exception***\n";
       // print_r($exception);
     //   print "***END Exception***\n";
        //die();
		echo " Le système SAP est momentatément indispensable pour afficher les informations de disponibilité des crédits";
    }
    
    //print_r($result);
   	
    return $result;
		
}
*/

	function getInfosDisponibiliteFonds($infosbudget,$comptesnat)
	{	
		global $log, $singlepane_view,$adb,$WSSAP;
		$log->debug("Entering getInfosDisponibiliteFonds(".$infosbudget.") method ...");
		global $app_strings, $mod_strings;
		$message ='';
		header('Content-Type: text/html; charset=utf-8');

		$SOAP_AUTH = array( 'login'=> $WSSAP['SOAP_AUTH']['user'],'password' => $WSSAP['SOAP_AUTH']['password']);
				
		$WSDL = $WSSAP['URL_CONTRDISPOFOND'];
		//print_r($infosbudget);
		//print_r($comptesnat);
	   #Create Client Object, download and parse WSDL
	    try
		{
			$client = new SoapClient($WSDL,$SOAP_AUTH);
			
		}
		catch (SoapFault $exception)
		{
		  //  print "***Caught Exception***\n";
			//print_r($exception);
			$message = "Les informations sur le budget (cr&eacute;dits disponibles) sont temporairement indisponibles";
		 //   print "***END Exception***\n";
			//die();
		//	continue;
		}
		if ($message =='')
		{
			foreach($comptesnat as $comptenat => $comptenatlib)
			{
					$budget->AFISCAL=$WSSAP['AFISCAL'];  // Année budgétaire
					$budget->CODE_BUDGETAIRE=$infosbudget['codebudget']; // Code budgétaire
					$budget->CPTE_BUDGETAIRE=$comptenat; // Compte nature
					$budget->FOND=$infosbudget['sourcefin']; // Source de Finanacement
					
					$societe = substr($infosbudget['codebudget'], 0, 2);
					$budget->PF=$WSSAP['PERIMETREFIN'][$societe]; // Périmétre Financier
											
					$resultat='';
					try
					{
					  $infosdisp = $client->ZGET_AVAIBILITY($budget); 
					  $dispbudgetobj= $infosdisp->IT_RESULT->item;
					  $mtndispo = $dispbudgetobj->MNTNT_DISPO;
					  $dispbudget[$infosbudget['codebudget']][$comptenat]=array('codebudget'=>$infosbudget['codebudget'],
																				'sourcefin'=>$infosbudget['sourcefin'],
																				'comptenat'=>$comptenat,
																				'comptenatlib'=>$comptenatlib,
																				'fonddisp'=>$dispbudgetobj->MNTANT_FD_ENGAGE,
																				'fondengage'=>$dispbudgetobj->FOND_ENGAGE,
																				'mntdispo'=>$dispbudgetobj->MNTNT_DISPO
																			);
					}
					catch (SoapFault $exception)
					{
						$message = "Les informations sur le budget (cr&eacute;dits disponibles) sont temporairement indisponibles";
					  //  print "***Caught Exception***\n";
						//print_r($exception);
					 //   print "***END Exception***\n";
						//die();
					//	continue;
					}
				
			}
		}
		$dispbudget['msgErreurSap'] = $message;
			
		return $dispbudget;
			
	}
	

function addEngagementToOM($numengagement,$demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering addEngagementToOM(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$reqUpdate= "UPDATE ordremission SET numengagement=? WHERE omid=?  " ;
		$adb->pquery($reqUpdate, array($numengagement,$demandeid));
}
function correctEngagementToOM($nextTicket,$demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering correctEngagementToOM(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$reqUpdate= "UPDATE ordremission SET numengagement='',numom=?  WHERE omid=?  " ;
		$adb->pquery($reqUpdate, array($nextTicket,$demandeid));
}
/**************************** NOMAGE GESTION DES ENGAGEMENT FIN**************************************/

function getDecompteBydemande($demandeid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDecompteBydemande(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT decompte.lieu AS zone,
						nbjindemn AS nbjindemn,tauxindemn AS indemnite,
						nbjheberg AS nbjheberg,tauxheberg AS herbergement,
						nbjtransp AS nbjtransp,tauxtransp AS transport,
						(	( (COALESCE(nbjindemn,0))*tauxindemn )+
							( (COALESCE(nbjheberg,0))*tauxheberg )
							+
							( (COALESCE(nbjtransp,0))*tauxtransp)
						) AS mnttotal
						FROM decompte
						INNER JOIN demande ON demande.demandeid = decompte.iddemande 
						WHERE decompte.iddemande=? " ;
		$result = $adb->pquery($query, array($demandeid));
		$LISTDECOMPTES = array();
		$totaldecompte=0;
		while ($row = $adb->fetchByAssoc($result))
		{
			$LISTDECOMPTES[]=$row;
		}
		return $LISTDECOMPTES;
}

function getinfosagent($matricule,$datedeb)
{
	global $log;
	$log->debug("Entering getinfosagent(".$matricule.") method ...");
	$log->info("in getinfosagent ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT User_Matricule AS matricule,user_name AS nom,user_firstname AS prenoms,User_Direction AS affectdirection
						FROM users WHERE User_Matricule=?";
                $result = $adb->pquery($sql, array($matricule));
                $user['matricule'] = $adb->query_result($result,0,"matricule");
                $user['nom'] = $adb->query_result($result,0,"nom");
                $user['prenom'] = $adb->query_result($result,0,"prenoms");
                $affectdirection = $adb->query_result($result,0,"affectdirection");
                //$user['service'] = getServiceAgent($affectdirection);
               $user['direction'] = $affectdirection;
               $user['fonction'] = $adb->query_result($result,0,"affectfonction");		
				
				$datedernmissionagent = getDernMissionAgent($matricule);
				if($datedernmissionagent!='')
				{
					$date1 = new DateTime($datedernmissionagent); 
					$user['datedernmission']=$date1->format('d-m-Y');
					$date2   = new DateTime($datedeb); 
					$dDiff = $date2->diff($date1);
					$interval = $dDiff->days; 
					$user['intervalmission'] = $interval;
				}
				else
				{
					$user['datedernmission']="";
					$user['intervalmission']=0;
				}
				//$user['nbjourconsomme'] = getNbJourConsommeAgent($matricule);
				
				//$user['datedernmission']="2018-01-08";
				//$user['intervalmission']=8;
				//$user['nbjourconsomme']=20;
        }
	$log->debug("Exiting getinfosagent method ...");
        return $user;
}	

function getListAgent()
{
	global $log;
	$log->debug("Entering getListAgent() method ...");
	$log->info("in getListAgent ");

        global $adb;
       
                $sql = "SELECT User_Matricule AS matricule,CONCAT(user_name,' ',user_firstname) AS nomcomplet
						FROM users ORDER BY user_name ";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTAGENTS[]=$row;
	}
	 $AGENTSOPT[''] = 'Choisir le charg&eacute; de mission...';
	 
	foreach($LISTAGENTS as $entry_key=>$agent)
	{
		$AGENTSOPT[$agent['matricule']] = $agent['nomcomplet'];
	}  
	$log->debug("Exiting getListAgent method ...");
        return $AGENTSOPT;
}
/*
function getListAgent()
{
	global $log;
	$log->debug("Entering getListAgent() method ...");
	$log->info("in getListAgent ");

        global $adb;
       
                $sql = "SELECT matricule,CONCAT(nom,' ',prenoms) AS nomcomplet FROM agentsuemoa
						ORDER BY nom";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTAGENTS[]=$row;
	}
	 $AGENTSOPT[''] = 'Choisir le charg&eacute; de mission...';
	 
	foreach($LISTAGENTS as $entry_key=>$agent)
	{
		$AGENTSOPT[$agent['matricule']] = $agent['nomcomplet'];
	}  
	$log->debug("Exiting getListAgent method ...");
        return $AGENTSOPT;
}*/

function getListMotifsRejet()
{
	global $log;
	$log->debug("Entering getListMotifsRejet() method ...");
	$log->info("in getListMotifsRejet ");

        global $adb;
       
                $sql = "SELECT motifid,motiflib
						FROM motifrejet 
						ORDER BY 2";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTAGENTS[]=$row;
	}
	 $AGENTSOPT[''] = 'Choisir le motif du rejet...';
	 
	foreach($LISTAGENTS as $entry_key=>$agent)
	{
		$AGENTSOPT[$agent['motifid']] = $agent['motiflib'];
	}  
	$log->debug("Exiting getListMotifsRejet method ...");
        return $AGENTSOPT;
}

function getSourcesFinancement()
{
	global $log;
	$log->debug("Entering getSourcesFinancement() method ...");
	$log->info("in getSourcesFinancement ");

        global $adb;
       
                $sql = "SELECT sourcefincode,sourcefinlib  FROM sourcesfinancement  ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTSOURCEFIN[]=$row;
	}
	 $SOURCEFINOPT[''] = 'Choisir la source de financement...';
	 
	foreach($LISTSOURCEFIN as $entry_key=>$sourcefin)
	{
		$SOURCEFINOPT[$sourcefin['sourcefincode']] = $sourcefin['sourcefinlib'];
	}  
	$log->debug("Exiting getSourcesFinancement method ...");
        return $SOURCEFINOPT;
}

function getCodesBudgetaires()
{
	global $log;
	$log->debug("Entering getCodesBudgetaires() method ...");
	$log->info("in getCodesBudgetaires ");

        global $adb;
       
                $sql = "SELECT centrefinancier,domainefinancier FROM codebudgetaire  ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	  	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTCODEBUDGET[]=$row;
	}
	 $CODEBUDGETOPT[''] = 'Choisir le code budgetaire...';
	 
	foreach($LISTCODEBUDGET as $entry_key=>$codebudget)
	{
		$CODEBUDGETOPT[$codebudget['centrefinancier'].'-'.$codebudget['domainefinancier']] = $codebudget['centrefinancier'].'-'.$codebudget['domainefinancier'];
	}  
	$log->debug("Exiting getSourcesFinancement method ...");
        return $CODEBUDGETOPT;
}

function getComptesNature()
{
	global $log;
	$log->debug("Entering getComptesNature() method ...");
	$log->info("in getComptesNature ");

        global $adb;
       
                $sql = "SELECT comptenature FROM comptenature  ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTCOMPTENAT[]=$row;
	}
	 //$COMPTENATOPT[''] = 'Choisir le compte nature...';
	 
	foreach($LISTCOMPTENAT as $entry_key=>$comptenat)
	{
		$COMPTENATOPT[$comptenat['comptenature']] = $comptenat['comptenature'];
	}  
	$log->debug("Exiting getComptesNature method ...");
        return $COMPTENATOPT;
}

function getTimbres()
{
	global $log;
	$log->debug("Entering getTimbres() method ...");
	$log->info("in getTimbres ");

        global $adb;
       
                $sql = "SELECT id, CONCAT(timbre1,timbre2,timbre3) AS timbre FROM timbre ORDER BY 2";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTTIMBRE[]=$row;
	}
	 $TIMBREOPT[''] = 'Choisir le timbre...';
	 
	foreach($LISTTIMBRE as $entry_key=>$comptenat)
	{
		$TIMBREOPT[$comptenat['id']] = $comptenat['timbre'];
	}  
	$log->debug("Exiting getTimbres method ...");
        return $TIMBREOPT;
}

function getSignataires()
{
	global $log;
	$log->debug("Entering getSignataires() method ...");
	$log->info("in getSignataires ");

        global $adb;
       
                $sql = "SELECT distinct signataire FROM signataire ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTSIGNATAIRE[]=$row;
	}
	 $SIGNATAIREOPT[''] = 'Choisir le signataire...';
	 
	foreach($LISTSIGNATAIRE as $entry_key=>$comptenat)
	{
		$SIGNATAIREOPT[$comptenat['signataire']] = $comptenat['signataire'];
	}  
	$log->debug("Exiting getSignataires method ...");
        return $SIGNATAIREOPT;
}

/** Function to get a users's mail id
  * @param $username -- username :: Type integer
    * @returns $email -- email :: Type string 
      *
       */

	   
function getBudgetsByAgentDepart($matricule)
{
	global $log;
	$log->debug("Entering getBudgetsByAgentDepart(".$matricule.") method ...");
	$log->info("in getBudgetsByAgentDepart ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT CONCAT(centrefinancier,'-',domainefinancier) codebudget 
			FROM codebudgetaire , users u
			WHERE u.user_matricule=?
			AND SUBSTRING(u.user_direction,1,5)=SUBSTRING(centrefinancier,1,5) ";
               $result = $adb->pquery($sql, array($matricule));
		$i=0;
		while ($row1 = $adb->fetchByAssoc($result))
		{
			$CODEBUDGETS[$i++]=$row1['codebudget'];
		}
	 
		
        }
	$log->debug("Exiting getBudgetsByAgentDepart method ...");
        return $CODEBUDGETS;
}

function getCodeBudgetsByAgentDepart($matricule)
{
	global $log;
	$log->debug("Entering getCodeBudgetsByAgentDepart(".$matricule.") method ...");
	$log->info("in getCodeBudgetsByAgentDepart ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT CONCAT(centrefinancier,'-',domainefinancier) codebudg ,libactivite
			FROM codebudgetaire , users u
			WHERE u.user_matricule=?
			AND SUBSTRING(u.user_direction,1,5)=SUBSTRING(centrefinancier,1,5) ";
               $result = $adb->pquery($sql, array($matricule));
	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTCODEBUDGET[]=$row;
	}
	 $CODEBUDGETOPT[''] = 'Choisir le code budgetaire...';
	 
	foreach($LISTCODEBUDGET as $entry_key=>$codebudget)
	{
		$CODEBUDGETOPT[$codebudget['codebudg']] = $codebudget['codebudg'].' ('.$codebudget['libactivite'].')';
	}  
	 
		
        }
	$log->debug("Exiting getCodeBudgetsByAgentDepart method ...");
        return $CODEBUDGETOPT;
}

function getUserEmailByUsername($username)
{
	global $log;
	$log->debug("Entering getUserEmailByUsername(".$username.") method ...");
	$log->info("in getUserEmailByUsername ".$username);

        global $adb;
        if($username != '')
        {
                $sql = "select email1 from vtiger_users where user_name=?";
                $result = $adb->pquery($sql, array($username));
                $email = $adb->query_result($result,0,"email1");
        }
	$log->debug("Exiting getUserEmailByUsername method ...");
        return $email;
}		

/** Function to get a userid for outlook
  * @param $username -- username :: Type string
    * @returns $user_id -- user id :: Type integer 
       */

	   
	   
	   
//outlook security
function getUserId_Ol($username)
{
	global $log;
	$log->debug("Entering getUserId_Ol(".$username.") method ...");
	$log->info("in getUserId_Ol ".$username);

	global $adb;
	$sql = "select id from vtiger_users where user_name=?";
	$result = $adb->pquery($sql, array($username));
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0)
	{
		$user_id = $adb->query_result($result,0,"id");
    	}
	else
	{
		$user_id = 0;
	}
	$log->debug("Exiting getUserId_Ol method ...");
	return $user_id;
}	


/** Function to get a action id for a given action name
  * @param $action -- action name :: Type string
    * @returns $actionid -- action id :: Type integer 
       */

//outlook security

function getActionid($action)
{
	global $log;
	$log->debug("Entering getActionid(".$action.") method ...");
	global $adb;
	$log->info("get Actionid ".$action);
	$actionid = '';
	if(file_exists('tabdata.php') && (filesize('tabdata.php') != 0)) 
	{
		include('tabdata.php');
		$actionid= $action_id_array[$action];
	}
	else
	{
		$query="select * from vtiger_actionmapping where actionname=?";
        	$result =$adb->pquery($query, array($action));
        	$actionid=$adb->query_result($result,0,'actionid');
		
	}
	$log->info("action id selected is ".$actionid );
	$log->debug("Exiting getActionid method ...");	
	return $actionid;
}

/** Function to get a action for a given action id
  * @param $action id -- action id :: Type integer
    * @returns $actionname-- action name :: Type string 
       */


function getActionname($actionid)
{
	global $log;
	$log->debug("Entering getActionname(".$actionid.") method ...");
	global $adb;

	$actionname='';
	
	if (file_exists('tabdata.php') && (filesize('tabdata.php') != 0)) 
	{
		include('tabdata.php');
		$actionname= $action_name_array[$actionid];
	}
	else
	{
	
		$query="select * from vtiger_actionmapping where actionid=? and securitycheck=0";
		$result =$adb->pquery($query, array($actionid));
		$actionname=$adb->query_result($result,0,"actionname");
	}	
	$log->debug("Exiting getActionname method ...");
	return $actionname;
}

/** Function to get a assigned user id for a given entity
  * @param $record -- entity id :: Type integer
    * @returns $user_id -- user id :: Type integer 
       */

function getUserId($record)
{
	global $log;
	$log->debug("Entering getUserId(".$record.") method ...");
        $log->info("in getUserId ".$record);

	global $adb;
        $user_id=$adb->query_result($adb->pquery("select * from vtiger_crmentity where crmid = ?", array($record)),0,'smownerid');
	$log->debug("Exiting getUserId method ...");
	return $user_id;	
}

/** Function to get a user id or group id for a given entity
  * @param $record -- entity id :: Type integer
    * @returns $ownerArr -- owner id :: Type array 
       */

function getRecordOwnerId($record)
{
	global $log;
	$log->debug("Entering getRecordOwnerId(".$record.") method ...");
	global $adb;
	$ownerArr=Array();
	$query="select smownerid from vtiger_crmentity where crmid = ?";
	$result=$adb->pquery($query, array($record));
	if($adb->num_rows($result) > 0)
	{
		$ownerId=$adb->query_result($result,0,'smownerid');
		$sql_result = $adb->pquery("select count(*) as count from users where user_id = ?",array($ownerId));
		if($adb->query_result($sql_result,0,'count') > 0)
			$ownerArr['Users'] = $ownerId;
		else
			$ownerArr['Groups'] = $ownerId;
	}	
	$log->debug("Exiting getRecordOwnerId method ...");
	return $ownerArr;

}

/** Function to insert value to profile2field table
  * @param $profileid -- profileid :: Type integer
       */


function insertProfile2field($profileid)
{
	global $log;
	$log->debug("Entering insertProfile2field(".$profileid.") method ...");
        $log->info("in insertProfile2field ".$profileid);

	global $adb;
	$adb->database->SetFetchMode(ADODB_FETCH_ASSOC); 
	$fld_result = $adb->pquery("select * from vtiger_field where generatedtype=1 and displaytype in (1,2,3) and vtiger_field.presence in (0,2) and tabid != 29", array());
        $num_rows = $adb->num_rows($fld_result);
        for($i=0; $i<$num_rows; $i++)
        {
                 $tab_id = $adb->query_result($fld_result,$i,'tabid');
                 $field_id = $adb->query_result($fld_result,$i,'fieldid');
				 $params = array($profileid, $tab_id, $field_id, 0, 1);
                 $adb->pquery("insert into vtiger_profile2field values (?,?,?,?,?)", $params);
	}
	$log->debug("Exiting insertProfile2field method ...");
}

/** Function to insert into default org field
       */

function insert_def_org_field()
{
	global $log;
	$log->debug("Entering insert_def_org_field() method ...");
	global $adb;
	$adb->database->SetFetchMode(ADODB_FETCH_ASSOC); 
	$fld_result = $adb->pquery("select * from vtiger_field where generatedtype=1 and displaytype in (1,2,3) and vtiger_field.presence in (0,2) and tabid != 29", array());
        $num_rows = $adb->num_rows($fld_result);
        for($i=0; $i<$num_rows; $i++)
        {
                 $tab_id = $adb->query_result($fld_result,$i,'tabid');
                 $field_id = $adb->query_result($fld_result,$i,'fieldid');
				 $params = array($tab_id, $field_id, 0, 1);
                 $adb->pquery("insert into vtiger_def_org_field values (?,?,?,?)", $params);
	}
	$log->debug("Exiting insert_def_org_field() method ...");
}

/** Function to insert value to profile2field table
  * @param $fld_module -- field module :: Type string
  * @param $profileid -- profileid :: Type integer
  * @returns $result -- result :: Type string
  */
	 
function getProfile2FieldList($fld_module, $profileid)
{
	global $log;
	$log->debug("Entering getProfile2FieldList(".$fld_module.",". $profileid.") method ...");
        $log->info("in getProfile2FieldList ".$fld_module. ' vtiger_profile id is  '.$profileid);

	global $adb;
	$tabid = getTabid($fld_module);
	
	$query = "select vtiger_profile2field.visible,vtiger_field.* from vtiger_profile2field inner join vtiger_field on vtiger_field.fieldid=vtiger_profile2field.fieldid where vtiger_profile2field.profileid=? and vtiger_profile2field.tabid=? and vtiger_field.presence in (0,2)";
	$result = $adb->pquery($query, array($profileid, $tabid));
	$log->debug("Exiting getProfile2FieldList method ...");
	return $result;
}

/** Function to insert value to profile2fieldPermissions table
  * @param $fld_module -- field module :: Type string
  * @param $profileid -- profileid :: Type integer
  * @returns $return_data -- return_data :: Type string
  */

//added by jeri

function getProfile2FieldPermissionList($fld_module, $profileid)
{
	global $log;
	$log->debug("Entering getProfile2FieldPermissionList(".$fld_module.",". $profileid.") method ...");
        $log->info("in getProfile2FieldList ".$fld_module. ' vtiger_profile id is  '.$profileid);

	global $adb;
	$tabid = getTabid($fld_module);
	
	$query = "select vtiger_profile2field.visible,vtiger_field.* from vtiger_profile2field inner join vtiger_field on vtiger_field.fieldid=vtiger_profile2field.fieldid where vtiger_profile2field.profileid=? and vtiger_profile2field.tabid=? and vtiger_field.presence in (0,2)";
	$qparams = array($profileid, $tabid);
	$result = $adb->pquery($query, $qparams);
	$return_data=array();
    for($i=0; $i<$adb->num_rows($result); $i++)
    {
		$return_data[]=array($adb->query_result($result,$i,"fieldlabel"),$adb->query_result($result,$i,"visible"),$adb->query_result($result,$i,"uitype"),$adb->query_result($result,$i,"visible"),$adb->query_result($result,$i,"fieldid"),$adb->query_result($result,$i,"displaytype"),$adb->query_result($result,$i,"typeofdata"));
	}	
	$log->debug("Exiting getProfile2FieldPermissionList method ...");
	return $return_data;
}

/** Function to getProfile2allfieldsListinsert value to profile2fieldPermissions table
  * @param $mod_array -- mod_array :: Type string
  * @param $profileid -- profileid :: Type integer
  * @returns $profilelist -- profilelist :: Type string
  */

function getProfile2AllFieldList($mod_array,$profileid)
{
	global $log;
     $log->debug("Entering getProfile2AllFieldList(".$mod_array.",".$profileid.") method ...");
     $log->info("in getProfile2AllFieldList vtiger_profile id is " .$profileid);

	global $adb;
	$profilelist=array();
	for($i=0;$i<count($mod_array);$i++)
	{
		$profilelist[key($mod_array)]=getProfile2FieldPermissionList(key($mod_array), $profileid);
		next($mod_array);
	}
	$log->debug("Exiting getProfile2AllFieldList method ...");
	return $profilelist;	
}

/** Function to getdefaultfield organisation list for a given module
  * @param $fld_module -- module name :: Type string
  * @returns $result -- string :: Type object
  */

//end of fn added by jeri

function getDefOrgFieldList($fld_module)
{
	global $log;
	$log->debug("Entering getDefOrgFieldList(".$fld_module.") method ...");
        $log->info("in getDefOrgFieldList ".$fld_module);

	global $adb;
	$tabid = getTabid($fld_module);
	
	$query = "select vtiger_def_org_field.visible,vtiger_field.* from vtiger_def_org_field inner join vtiger_field on vtiger_field.fieldid=vtiger_def_org_field.fieldid where vtiger_def_org_field.tabid=? and vtiger_field.presence in (0,2)";
	$qparams = array($tabid);
	$result = $adb->pquery($query, $qparams);
	$log->debug("Exiting getDefOrgFieldList method ...");
	return $result;
}

/** Function to getQuickCreate for a given tabid
  * @param $tabid -- tab id :: Type string
  * @param $actionid -- action id :: Type integer
  * @returns $QuickCreateForm -- QuickCreateForm :: Type boolean
  */

function getQuickCreate($tabid,$actionid)
{
	global $log;
	$log->debug("Entering getQuickCreate(".$tabid.",".$actionid.") method ...");
	$module=getTabModuleName($tabid);
	$actionname=getActionname($actionid);
        $QuickCreateForm= 'true';

	$perr=isPermitted($module,$actionname);
	if($perr = 'no')
	{
                $QuickCreateForm= 'false';
	}	
	$log->debug("Exiting getQuickCreate method ...");
	return $QuickCreateForm;

}

/** Function to getQuickCreate for a given tabid
  * @param $tabid -- tab id :: Type string
  * @param $actionid -- action id :: Type integer
  * @returns $QuickCreateForm -- QuickCreateForm :: Type boolean
  */

function ChangeStatus($status,$activityid,$activity_mode='')
 {
	global $log;
	$log->debug("Entering ChangeStatus(".$status.",".$activityid.",".$activity_mode."='') method ...");
        $log->info("in ChangeStatus ".$status. ' vtiger_activityid is  '.$activityid);

        global $adb;
        if ($activity_mode == 'Task')
        {
                $query = "Update vtiger_activity set status=? where activityid = ?";
        }
        elseif ($activity_mode == 'Events')
        {
                $query = "Update vtiger_activity set eventstatus=? where activityid = ?";
        }
		if($query) {
        	$adb->pquery($query, array($status, $activityid));
		}
	$log->debug("Exiting ChangeStatus method ...");
 }

 function BackupRapport($status,$rapportid)
 {
	global $log;
	$log->debug("Entering BackupRapport(".$status.",".$rapportid."='') method ...");
        $log->info("in BackupRapport ".$status. ' vtiger_hreportsid is  '.$rapportid);

        global $adb;
        $query = "Update vtiger_hreports set rapportstatus=? where hreportsid = ?";
       	if($query) {
        	$adb->pquery($query, array($status, $rapportid));
		}
	$log->debug("Exiting BackupRapport method ...");
 }
 
 function BackupDocument($status,$documentid)
 {
	global $log;
	$log->debug("Entering BackupDocument(".$status.",".$documentid."='') method ...");
        $log->info("in BackupDocument ".$status. ' vtiger_notesid is  '.$documentid);

        global $adb;
        $query = "Update vtiger_notes set docstatus=? where notesid = ?";
       	if($query) {
        	$adb->pquery($query, array($status, $documentid))or die;
		}
	$log->debug("Exiting BackupDocument method ...");
 }
 
/** Function to set date values compatible to database (YY_MM_DD)
  * @param $value -- value :: Type string
  * @returns $insert_date -- insert_date :: Type string
  */

function getDBInsertDateValue($value)
{
	global $log;
	$log->debug("Entering getDBInsertDateValue(".$value.") method ...");
	global $current_user;
	$dat_fmt = $current_user->date_format;
	if($dat_fmt == '') {
		$dat_fmt = 'dd-mm-yyyy';
	}
	$insert_date='';
	if($dat_fmt == 'dd-mm-yyyy')
	{
		list($d,$m,$y) = split('-',$value);
	}
	elseif($dat_fmt == 'mm-dd-yyyy')
	{
		list($m,$d,$y) = split('-',$value);
	}
	elseif($dat_fmt == 'yyyy-mm-dd')
	{
		list($y,$m,$d) = split('-',$value);
	}

	if(!$y && !$m && !$d) {
		$insert_date = '';
	} else {
		$insert_date=$y.'-'.$m.'-'.$d;
	}
	$log->debug("Exiting getDBInsertDateValue method ...");
	return $insert_date;
}

/** Function to get unitprice for a given product id
  * @param $productid -- product id :: Type integer
  * @returns $up -- up :: Type string
  */

function getUnitPrice($productid, $module='Products')
{
	global $log, $adb;
	$log->debug("Entering getUnitPrice($productid,$module) method ...");
	
	if($module == 'Services') {
    	$query = "select unit_price from vtiger_service where serviceid=?";
	} else {
    	$query = "select unit_price from vtiger_products where productid=?";		
	}
    $result = $adb->pquery($query, array($productid));
    $unitpice = $adb->query_result($result,0,'unit_price');
	$log->debug("Exiting getUnitPrice method ...");
	return $unitpice;
}

/** Function to upload product image file 
  * @param $mode -- mode :: Type string
  * @param $id -- id :: Type integer
  * @returns $ret_array -- return array:: Type array
  */

function upload_product_image_file($mode,$id)
{
	global $log;
	$log->debug("Entering upload_product_image_file(".$mode.",".$id.") method ...");
	global $root_directory;
        $log->debug("Inside upload_product_image_file. The id is ".$id);
	$uploaddir = $root_directory ."/test/product/";

	$file_path_name = $_FILES['imagename']['name'];
	if (isset($_REQUEST['imagename_hidden'])) {
		$file_name = $_REQUEST['imagename_hidden'];
	} else {
		//allowed file pathname like UTF-8 Character 
		$file_name = ltrim(basename(" ".$file_path_name)); // basename($file_path_name);
	}
	$file_name = $id.'_'.$file_name;
	$filetype= $_FILES['imagename']['type'];
	$filesize = $_FILES['imagename']['size'];

	$ret_array = Array();

	if($filesize > 0)
	{

		if(move_uploaded_file($_FILES["imagename"]["tmp_name"],$uploaddir.$file_name))
		{

			$upload_status = "yes";
			$ret_array["status"] = $upload_status;
			$ret_array["file_name"] = $file_name;
			

		}
		else
		{
			$errorCode =  $_FILES['imagename']['error'];
			$upload_status = "no";
			$ret_array["status"] = $upload_status;
			$ret_array["errorcode"] = $errorCode;
			
			
		}

	}
	else
	{
		$upload_status = "no";
                $ret_array["status"] = $upload_status;
	}
	$log->debug("Exiting upload_product_image_file method ...");
	return $ret_array;		

}

/** Function to upload product image file 
  * @param $id -- id :: Type integer
  * @param $deleted_array -- images to be deleted :: Type array
  * @returns $imagename -- imagelist:: Type array
  */

function getProductImageName($id,$deleted_array='')
{
	global $log;
	$log->debug("Entering getProductImageName(".$id.",".$deleted_array."='') method ...");
	global $adb;
	$image_array=array();	
	$query = "select imagename from vtiger_products where productid=?";
	$result = $adb->pquery($query, array($id));
	$image_name = $adb->query_result($result,0,"imagename");
	$image_array=explode("###",$image_name);
	$log->debug("Inside getProductImageName. The image_name is ".$image_name);
	if($deleted_array!='')
	{
		$resultant_image = array();
		$resultant_image=array_merge(array_diff($image_array,$deleted_array));
		$imagelists=implode('###',$resultant_image);	
		$log->debug("Exiting getProductImageName method ...");
		return	$imagelists;
	}
	else
	{
		$log->debug("Exiting getProductImageName method ...");
		return $image_name;	
	}
}

/** Function to get Contact images 
  * @param $id -- id :: Type integer
  * @returns $imagename -- imagename:: Type string
  */

function getContactImageName($id)
{
	global $log;
	$log->debug("Entering getContactImageName(".$id.") method ...");
        global $adb;
        $query = "select imagename from vtiger_contactdetails where contactid=?";
        $result = $adb->pquery($query, array($id));
        $image_name = $adb->query_result($result,0,"imagename");
        $log->debug("Inside getContactImageName. The image_name is ".$image_name);
	$log->debug("Exiting getContactImageName method ...");
        return $image_name;

}

/** Function to update sub total in inventory 
  * @param $module -- module name :: Type string
  * @param $tablename -- tablename :: Type string
  * @param $colname -- colname :: Type string
  * @param $colname1 -- coluname1 :: Type string
  * @param $entid_fld -- entity field :: Type string
  * @param $entid -- entid :: Type integer
  * @param $prod_total -- totalproduct :: Type integer
  */

function updateSubTotal($module,$tablename,$colname,$colname1,$entid_fld,$entid,$prod_total)
{
	global $log;
	$log->debug("Entering updateSubTotal(".$module.",".$tablename.",".$colname.",".$colname1.",".$entid_fld.",".$entid.",".$prod_total.") method ...");
        global $adb;
        //getting the subtotal
        $query = "select ".$colname.",".$colname1." from ".$tablename." where ".$entid_fld."=?";
        $result1 = $adb->pquery($query, array($entid));
        $subtot = $adb->query_result($result1,0,$colname);
        $subtot_upd = $subtot - $prod_total;

        $gdtot = $adb->query_result($result1,0,$colname1);
        $gdtot_upd = $gdtot - $prod_total;

        //updating the subtotal
        $sub_query = "update $tablename set $colname=?, $colname1=? where $entid_fld=?";
        $adb->pquery($sub_query, array($subtot_upd, $gdtot_upd, $entid));
	$log->debug("Exiting updateSubTotal method ...");
}

/** Function to get Inventory Total 
  * @param $return_module -- return module :: Type string
  * @param $id -- entity id :: Type integer
  * @returns $total -- total:: Type integer
  */

function getInventoryTotal($return_module,$id)
{
	global $log;
	$log->debug("Entering getInventoryTotal(".$return_module.",".$id.") method ...");
	global $adb;
	if($return_module == "Potentials")
	{
		$query ="select vtiger_products.productname,vtiger_products.unit_price,vtiger_products.qtyinstock,vtiger_seproductsrel.* from vtiger_products inner join vtiger_seproductsrel on vtiger_seproductsrel.productid=vtiger_products.productid where crmid=?";
	}
	elseif($return_module == "Products")
	{
		$query="select vtiger_products.productid,vtiger_products.productname,vtiger_products.unit_price,vtiger_products.qtyinstock,vtiger_crmentity.* from vtiger_products inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_products.productid where vtiger_crmentity.deleted=0 and productid=?";
	}
	$result = $adb->pquery($query, array($id));
	$num_rows=$adb->num_rows($result);
	$total=0;
	for($i=1;$i<=$num_rows;$i++)
	{
		$unitprice=$adb->query_result($result,$i-1,'unit_price');
		$qty=$adb->query_result($result,$i-1,'quantity');
		$listprice=$adb->query_result($result,$i-1,'listprice');
		if($listprice == '')
		$listprice = $unitprice;
		if($qty =='')
		$qty = 1;
		$total = $total+($qty*$listprice);
	}
	$log->debug("Exiting getInventoryTotal method ...");
	return $total;
}

/** Function to update product quantity 
  * @param $product_id -- product id :: Type integer
  * @param $upd_qty -- quantity :: Type integer
  */

function updateProductQty($product_id, $upd_qty)
{
	global $log;
	$log->debug("Entering updateProductQty(".$product_id.",". $upd_qty.") method ...");
	global $adb;
	$query= "update vtiger_products set qtyinstock=? where productid=?";
    $adb->pquery($query, array($upd_qty, $product_id));
	$log->debug("Exiting updateProductQty method ...");

}

/** Function to get account information 
  * @param $parent_id -- parent id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function get_account_info($parent_id)
{
	global $log;
	$log->debug("Entering get_account_info(".$parent_id.") method ...");
        global $adb;
        $query = "select accountid from vtiger_potential where potentialid=?";
        $result = $adb->pquery($query, array($parent_id));
        $accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting get_account_info method ...");
        return $accountid;
}

/** Function to get quick create form fields 
  * @param $fieldlabel -- field label :: Type string
  * @param $uitype -- uitype :: Type integer
  * @param $fieldname -- field name :: Type string
  * @param $tabid -- tabid :: Type integer
  * @returns $return_field -- return field:: Type string
  */

//for Quickcreate-Form

function get_quickcreate_form($fieldlabel,$uitype,$fieldname,$tabid)
{
	global $log;
	$log->debug("Entering get_quickcreate_form(".$fieldlabel.",".$uitype.",".$fieldname.",".$tabid.") method ...");
	$return_field ='';
	switch($uitype)	
	{
		case 1: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 2: $return_field .=get_textmanField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 6: $return_field .=get_textdateField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 11: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 13: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;	
			break;
		case 15: $return_field .=get_textcomboField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;	
			break;
		case 16: $return_field .=get_textcomboField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;	
			break;
		case 17: $return_field .=get_textwebField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 19: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;	
			break;
		case 22: $return_field .=get_textmanField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 23: $return_field .=get_textdateField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 50: $return_field .=get_textaccField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 51: $return_field .=get_textaccField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 55: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 63: $return_field .=get_textdurationField($fieldlabel,$fieldname,$tabid);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
		case 71: $return_field .=get_textField($fieldlabel,$fieldname);
			$log->debug("Exiting get_quickcreate_form method ...");
			return $return_field;
			break;
	}
}	

/** Function to get quick create form fields 
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @param $tid -- tabid :: Type integer
  * @returns $form_field -- return field:: Type string
  */

function get_textmanField($label,$name,$tid)
{
	global $log;
	$log->debug("Entering get_textmanField(".$label.",".$name.",".$tid.") method ...");
	$form_field='';
	if($tid == 9)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_T_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
		$log->debug("Exiting get_textmanField method ...");
		return $form_field;	
	}
	if($tid == 16)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_E_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
		$log->debug("Exiting get_textmanField method ...");
		return $form_field;	
	}
	else
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
		$log->debug("Exiting get_textmanField method ...");
		return $form_field;	
	}	
	
}	

/** Function to get textfield for website field  
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @returns $form_field -- return field:: Type string
  */

function get_textwebField($label,$name)
{
	global $log;
	$log->debug("Entering get_textwebField(".$label.",".$name.") method ...");

	$form_field='';
	$form_field .='<td>';
	$form_field .= $label.':<br>http://<br>';
	$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
	$log->debug("Exiting get_textwebField method ...");
	return $form_field;
	
}

/** Function to get textfield   
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @returns $form_field -- return field:: Type string
  */

function get_textField($label,$name)
{
	global $log;
	$log->debug("Entering get_textField(".$label.",".$name.") method ...");	
	$form_field='';
	if($name == "amount")
	{
		$form_field .='<td>';
		$form_field .= $label.':(U.S Dollar:$)<br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
		$log->debug("Exiting get_textField method ...");
		return $form_field;
	}
	else
	{
		
		$form_field .='<td>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="20" maxlength="" value=""></td>';
		$log->debug("Exiting get_textField method ...");
		return $form_field;
	}
	
}

/** Function to get account textfield   
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @param $tid -- tabid :: Type integer
  * @returns $form_field -- return field:: Type string
  */

function get_textaccField($label,$name,$tid)
{
	global $log;
	$log->debug("Entering get_textaccField(".$label.",".$name.",".$tid.") method ...");
	
	global $app_strings;

	$form_field='';
	if($tid == 2)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="account_name" type="text" size="20" maxlength="" id="account_name" value="" readonly><br>';
		$form_field .='<input name="account_id" id="QCK_'.$name.'" type="hidden" value="">&nbsp;<input title="'.$app_strings[LBL_CHANGE_BUTTON_TITLE].'" accessKey="'.$app_strings[LBL_CHANGE_BUTTON_KEY].'" type="button" tabindex="3" class="button" value="'.$app_strings[LBL_CHANGE_BUTTON_LABEL].'" name="btn1" LANGUAGE=javascript onclick=\'return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=EditView&form_submit=false","test","width=600,height=400,resizable=1,scrollbars=1");\'></td>';
		$log->debug("Exiting get_textaccField method ...");
		return $form_field;
	}
	else
	{	
		$form_field .='<td>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="account_name" type="text" size="20" maxlength="" value="" readonly><br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="hidden" value="">&nbsp;<input title="'.$app_strings[LBL_CHANGE_BUTTON_TITLE].'" accessKey="'.$app_strings[LBL_CHANGE_BUTTON_KEY].'" type="button" tabindex="3" class="button" value="'.$app_strings[LBL_CHANGE_BUTTON_LABEL].'" name="btn1" LANGUAGE=javascript onclick=\'return window.open("index.php?module=Accounts&action=Popup&popuptype=specific&form=EditView&form_submit=false","test","width=600,height=400,resizable=1,scrollbars=1");\'></td>';
		$log->debug("Exiting get_textaccField method ...");
		return $form_field;
	}	
		
}

/** Function to get combo field values   
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @returns $form_field -- return field:: Type string
  */

function get_textcomboField($label,$name)
{
	global $log;
	$log->debug("Entering get_textcomboField(".$label.",".$name.") method ...");
	$form_field='';
	if($name == "sales_stage")
	{
		$comboFieldNames = Array('leadsource'=>'leadsource_dom'
                      ,'opportunity_type'=>'opportunity_type_dom'
                      ,'sales_stage'=>'sales_stage_dom');
		$comboFieldArray = getComboArray($comboFieldNames);
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<select name="'.$name.'">';
		$form_field .=get_select_options_with_id($comboFieldArray['sales_stage_dom'], "");
		$form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
		return $form_field;
		
	}
	if($name == "productcategory")
	{
		$comboFieldNames = Array('productcategory'=>'productcategory_dom');
		$comboFieldArray = getComboArray($comboFieldNames);
		$form_field .='<td>';
		$form_field .= $label.':<br>';
		$form_field .='<select name="'.$name.'">';
		$form_field .=get_select_options_with_id($comboFieldArray['productcategory_dom'], "");
		$form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
		return $form_field;	
		
	}
	if($name == "ticketpriorities")
	{
		$comboFieldNames = Array('ticketpriorities'=>'ticketpriorities_dom');
		$comboFieldArray = getComboArray($comboFieldNames);	
		$form_field .='<td>';
		$form_field .= $label.':<br>';
		$form_field .='<select name="'.$name.'">';
		$form_field .=get_select_options_with_id($comboFieldArray['ticketpriorities_dom'], "");
		$form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
		return $form_field;
	}
	if($name == "activitytype")
	{
		$comboFieldNames = Array('activitytype'=>'activitytype_dom',
			 'duration_minutes'=>'duration_minutes_dom');
		$comboFieldArray = getComboArray($comboFieldNames);
		$form_field .='<td>';
		$form_field .= $label.'<br>';
		$form_field .='<select name="'.$name.'">';
		$form_field .=get_select_options_with_id($comboFieldArray['activitytype_dom'], "");
		$form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
		return $form_field;
		
		
	}
        if($name == "eventstatus")
        {
                $comboFieldNames = Array('eventstatus'=>'eventstatus_dom');
                $comboFieldArray = getComboArray($comboFieldNames);
                $form_field .='<td>';
                $form_field .= $label.'<br>';
                $form_field .='<select name="'.$name.'">';
                $form_field .=get_select_options_with_id($comboFieldArray['eventstatus_dom'], "");
                $form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
                return $form_field;


        }
        if($name == "taskstatus")
        {
                $comboFieldNames = Array('taskstatus'=>'taskstatus_dom');
                $comboFieldArray = getComboArray($comboFieldNames);
                $form_field .='<td>';
                $form_field .= $label.'<br>';
                $form_field .='<select name="'.$name.'">';
                $form_field .=get_select_options_with_id($comboFieldArray['taskstatus_dom'], "");
                $form_field .='</select></td>';
		$log->debug("Exiting get_textcomboField method ...");
                return $form_field;
        }


	
}

/** Function to get date field    
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @param $tid -- tabid :: Type integer
  * @returns $form_field -- return field:: Type string
  */


function get_textdateField($label,$name,$tid)
{
	global $log;
	$log->debug("Entering get_textdateField(".$label.",".$name.",".$tid.") method ...");
	global $theme;
	global $app_strings;
	global $current_user;

	$ntc_date_format = $app_strings['NTC_DATE_FORMAT'];
	$ntc_time_format = $app_strings['NTC_TIME_FORMAT'];
	
	$form_field='';
	$default_date_start = date('Y-m-d');
	$default_time_start = date('H:i');
	$dis_value=getNewDisplayDate();
	
	if($tid == 2)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<font size="1"><em old="ntc_date_format">('.$current_user->date_format.')</em></font><br>';
		$form_field .='<input name="'.$name.'"  size="12" maxlength="10" id="QCK_'.$name.'" type="text" value="">&nbsp';
	       	$form_field .='<img src="themes/'.$theme.'/images/btnL3Calendar.gif" id="jscal_trigger"></td>';
		$log->debug("Exiting get_textdateField method ...");
		return $form_field;
			
	}
	if($tid == 9)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_T_'.$name.'" tabindex="2" type="text" size="10" maxlength="10" value="'.$default_date_start.'">&nbsp';
		$form_field.= '<img src="themes/'.$theme.'/images/btnL3Calendar.gif" id="jscal_trigger_date_start">&nbsp';
		$form_field.='<input name="time_start" id="task_time_start" tabindex="1" type="text" size="5" maxlength="5" type="text" value="'.$default_time_start.'"><br><font size="1"><em old="ntc_date_format">('.$current_user->date_format.')</em></font>&nbsp<font size="1"><em>'.$ntc_time_format.'</em></font></td>';
		$log->debug("Exiting get_textdateField method ...");
		return $form_field;	
	}
	if($tid == 16)
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_E_'.$name.'" tabindex="2" type="text" size="10" maxlength="10" value="'.$default_date_start.'">&nbsp';
		$form_field.= '<img src="themes/'.$theme.'/images/btnL3Calendar.gif" id="jscal_trigger_event_date_start">&nbsp';
		$form_field.='<input name="time_start" id="event_time_start" tabindex="1" type="text" size="5" maxlength="5" type="text" value="'.$default_time_start.'"><br><font size="1"><em old="ntc_date_format">('.$current_user->date_format.')</em></font>&nbsp<font size="1"><em>'.$ntc_time_format.'</em></font></td>';
		$log->debug("Exiting get_textdateField method ...");
		return $form_field;	
	}
	
	else
	{
		$form_field .='<td>';
		$form_field .= '<font color="red">*</font>';
		$form_field .= $label.':<br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="10" maxlength="10" value="'.$default_date_start.'">&nbsp';
		$form_field.= '<img src="themes/'.$theme.'/images/btnL3Calendar.gif" id="jscal_trigger">&nbsp';
		$form_field.='<input name="time_start" type="text" size="5" maxlength="5" type="text" value="'.$default_time_start.'"><br><font size="1"><em old="ntc_date_format">('.$current_user->date_format.')</em></font>&nbsp<font size="1"><em>'.$ntc_time_format.'</em></font></td>';
		$log->debug("Exiting get_textdateField method ...");
		return $form_field;	
	}
	
}

/** Function to get duration text field in activity  
  * @param $label -- field label :: Type string
  * @param $name -- field name :: Type string
  * @param $tid -- tabid :: Type integer
  * @returns $form_field -- return field:: Type string
  */

function get_textdurationField($label,$name,$tid)
{
	global $log;
	$log->debug("Entering get_textdurationField(".$label.",".$name.",".$tid.") method ...");
	$form_field='';
	if($tid == 16)
	{
		
		$comboFieldNames = Array('activitytype'=>'activitytype_dom',
			 'duration_minutes'=>'duration_minutes_dom');
		$comboFieldArray = getComboArray($comboFieldNames);
	
		$form_field .='<td>';
		$form_field .= $label.'<br>';
		$form_field .='<input name="'.$name.'" id="QCK_'.$name.'" type="text" size="2" value="1">&nbsp;';
		$form_field .='<select name="duration_minutes">';
		$form_field .=get_select_options_with_id($comboFieldArray['duration_minutes_dom'], "");
		$form_field .='</select><br>(hours/minutes)<br></td>';
		$log->debug("Exiting get_textdurationField method ...");
		return $form_field;
	}	
}

/** Function to get email text field  
  * @param $module -- module name :: Type name
  * @param $id -- entity id :: Type integer
  * @returns $hidden -- hidden:: Type string
  */

//Added to get the parents list as hidden for Emails -- 09-11-2005
function getEmailParentsList($module,$id)
{
	global $log;
	$log->debug("Entering getEmailParentsList(".$module.",".$id.") method ...");
        global $adb;
	if($module == 'Contacts')
		$focus = new Contacts();
	if($module == 'Leads')
		$focus = new Leads();
        
	$focus->retrieve_entity_info($id,$module);
        $fieldid = 0;
        $fieldname = 'email';
        if($focus->column_fields['email'] == '' && $focus->column_fields['yahooid'] != '')
                $fieldname = 'yahooid';

        $res = $adb->pquery("select * from vtiger_field where tabid = ? and fieldname= ? and vtiger_field.presence in (0,2)", array(getTabid($module), $fieldname));
        $fieldid = $adb->query_result($res,0,'fieldid');

        $hidden .= '<input type="hidden" name="emailids" value="'.$id.'@'.$fieldid.'|">';
        $hidden .= '<input type="hidden" name="pmodule" value="'.$module.'">';

	$log->debug("Exiting getEmailParentsList method ...");
	return $hidden;
}

/** This Function returns the current status of the specified Purchase Order.
  * The following is the input parameter for the function
  *  $po_id --> Purchase Order Id, Type:Integer
  */
function getPoStatus($po_id)
{
	global $log;
	$log->debug("Entering getPoStatus(".$po_id.") method ...");

	global $log;
        $log->info("in getPoName ".$po_id);

        global $adb;
        $sql = "select postatus from vtiger_purchaseorder where purchaseorderid=?";
        $result = $adb->pquery($sql, array($po_id));
        $po_status = $adb->query_result($result,0,"postatus");
	$log->debug("Exiting getPoStatus method ...");
        return $po_status;
}

/** This Function adds the specified product quantity to the Product Quantity in Stock in the Warehouse 
  * The following is the input parameter for the function:
  *  $productId --> ProductId, Type:Integer
  *  $qty --> Quantity to be added, Type:Integer
  */
function addToProductStock($productId,$qty)
{
	global $log;
	$log->debug("Entering addToProductStock(".$productId.",".$qty.") method ...");
	global $adb;
	$qtyInStck=getProductQtyInStock($productId);
	$updQty=$qtyInStck + $qty;
	$sql = "UPDATE vtiger_products set qtyinstock=? where productid=?";
	$adb->pquery($sql, array($updQty, $productId));
	$log->debug("Exiting addToProductStock method ...");
	
}

/**	This Function adds the specified product quantity to the Product Quantity in Demand in the Warehouse 
  *	@param int $productId - ProductId
  *	@param int $qty - Quantity to be added
  */
function addToProductDemand($productId,$qty)
{
	global $log;
	$log->debug("Entering addToProductDemand(".$productId.",".$qty.") method ...");
	global $adb;
	$qtyInStck=getProductQtyInDemand($productId);
	$updQty=$qtyInStck + $qty;
	$sql = "UPDATE vtiger_products set qtyindemand=? where productid=?";
	$adb->pquery($sql, array($updQty, $productId));
	$log->debug("Exiting addToProductDemand method ...");
	
}

/**	This Function subtract the specified product quantity to the Product Quantity in Stock in the Warehouse 
  *	@param int $productId - ProductId
  *	@param int $qty - Quantity to be subtracted
  */
function deductFromProductStock($productId,$qty)
{
	global $log;
	$log->debug("Entering deductFromProductStock(".$productId.",".$qty.") method ...");
	global $adb;
	$qtyInStck=getProductQtyInStock($productId);
	$updQty=$qtyInStck - $qty;
	$sql = "UPDATE vtiger_products set qtyinstock=? where productid=?";
	$adb->pquery($sql, array($updQty, $productId));
	$log->debug("Exiting deductFromProductStock method ...");
	
}

/**	This Function subtract the specified product quantity to the Product Quantity in Demand in the Warehouse 
  *	@param int $productId - ProductId
  *	@param int $qty - Quantity to be subtract
  */
function deductFromProductDemand($productId,$qty)
{
	global $log;
	$log->debug("Entering deductFromProductDemand(".$productId.",".$qty.") method ...");
	global $adb;
	$qtyInStck=getProductQtyInDemand($productId);
	$updQty=$qtyInStck - $qty;
	$sql = "UPDATE vtiger_products set qtyindemand=? where productid=?";
	$adb->pquery($sql, array($updQty, $productId));
	$log->debug("Exiting deductFromProductDemand method ...");
	
}


/** This Function returns the current product quantity in stock.
  * The following is the input parameter for the function:
  *  $product_id --> ProductId, Type:Integer
  */
function getProductQtyInStock($product_id)
{
	global $log;
	$log->debug("Entering getProductQtyInStock(".$product_id.") method ...");
        global $adb;
        $query1 = "select qtyinstock from vtiger_products where productid=?";
        $result=$adb->pquery($query1, array($product_id));
        $qtyinstck= $adb->query_result($result,0,"qtyinstock");
	$log->debug("Exiting getProductQtyInStock method ...");
        return $qtyinstck;


}

/**	This Function returns the current product quantity in demand.
  *	@param int $product_id - ProductId
  *	@return int $qtyInDemand - Quantity in Demand of a product
  */
function getProductQtyInDemand($product_id)
{
	global $log;
	$log->debug("Entering getProductQtyInDemand(".$product_id.") method ...");
        global $adb;
        $query1 = "select qtyindemand from vtiger_products where productid=?";
        $result = $adb->pquery($query1, array($product_id));
        $qtyInDemand = $adb->query_result($result,0,"qtyindemand");
	$log->debug("Exiting getProductQtyInDemand method ...");
        return $qtyInDemand;
}

/** Function to seperate the Date and Time
  * This function accepts a sting with date and time and
  * returns an array of two elements.The first element
  * contains the date and the second one contains the time
  */
function getDateFromDateAndtime($date_time)
{
	global $log;
	$log->debug("Entering getDateFromDateAndtime(".$date_time.") method ...");
	$result = explode(" ",$date_time);
	$log->debug("Exiting getDateFromDateAndtime method ...");
	return $result;
}


/** Function to get header for block in edit/create and detailview  
  * @param $header_label -- header label :: Type string
  * @returns $output -- output:: Type string
  */

function getBlockTableHeader($header_label)
{
	global $log;
	$log->debug("Entering getBlockTableHeader(".$header_label.") method ...");
	global $mod_strings;
	$label = $mod_strings[$header_label];
	$output = $label;
	$log->debug("Exiting getBlockTableHeader method ...");
	return $output;

}



/**     Function to get the vtiger_table name from 'field' vtiger_table for the input vtiger_field based on the module
 *      @param  : string $module - current module value
 *      @param  : string $fieldname - vtiger_fieldname to which we want the vtiger_tablename
 *      @return : string $tablename - vtiger_tablename in which $fieldname is a column, which is retrieved from 'field' vtiger_table per $module basis
 */
function getTableNameForField($module,$fieldname)
{
	global $log;
	$log->debug("Entering getTableNameForField(".$module.",".$fieldname.") method ...");
	global $adb;
	$tabid = getTabid($module);
	//Asha
	if($module == 'Calendar') {
		$tabid = array('9','16');
	}
	$sql = "select tablename from vtiger_field where tabid in (". generateQuestionMarks($tabid) .") and vtiger_field.presence in (0,2) and columnname like ?";
	$res = $adb->pquery($sql, array($tabid, '%'.$fieldname.'%'));

	$tablename = '';
	if($adb->num_rows($res) > 0)
	{
		$tablename = $adb->query_result($res,0,'tablename');
	}

	$log->debug("Exiting getTableNameForField method ...");
	return $tablename;
}

/** Function to get parent record owner  
  * @param $tabid -- tabid :: Type integer
  * @param $parModId -- parent module id :: Type integer
  * @param $record_id -- record id :: Type integer
  * @returns $parentRecOwner -- parentRecOwner:: Type integer
  */

function getParentRecordOwner($tabid,$parModId,$record_id)
{
	global $log;
	$log->debug("Entering getParentRecordOwner(".$tabid.",".$parModId.",".$record_id.") method ...");
	$parentRecOwner=Array();
	$parentTabName=getTabname($parModId);
	$relTabName=getTabname($tabid);
	$fn_name="get".$relTabName."Related".$parentTabName;
	$ent_id=$fn_name($record_id);
	if($ent_id != '')
	{
		$parentRecOwner=getRecordOwnerId($ent_id);	
	}
	$log->debug("Exiting getParentRecordOwner method ...");
	return $parentRecOwner;
}

/** Function to get potential related accounts   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getPotentialsRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getPotentialsRelatedAccounts(".$record_id.") method ...");
	global $adb;
	$query="select accountid from vtiger_potential where potentialid=?";
	$result=$adb->pquery($query, array($record_id));
	$accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting getPotentialsRelatedAccounts method ...");
	return $accountid;
}

/** Function to get email related accounts   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */
function getEmailsRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getEmailsRelatedAccounts(".$record_id.") method ...");
	global $adb;
	$query = "select vtiger_seactivityrel.crmid from vtiger_seactivityrel inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_seactivityrel.crmid where vtiger_crmentity.setype='Accounts' and activityid=?";
	$result = $adb->pquery($query, array($record_id));
	$accountid=$adb->query_result($result,0,'crmid');
	$log->debug("Exiting getEmailsRelatedAccounts method ...");
	return $accountid;
}
/** Function to get email related Leads   
  * @param $record_id -- record id :: Type integer
  * @returns $leadid -- leadid:: Type integer
  */
  
 
function getEmailsRelatedLeads($record_id)
{
	global $log;
	$log->debug("Entering getEmailsRelatedLeads(".$record_id.") method ...");
	global $adb;
	$query = "select vtiger_seactivityrel.crmid from vtiger_seactivityrel inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_seactivityrel.crmid where vtiger_crmentity.setype='Leads' and activityid=?";
	$result = $adb->pquery($query, array($record_id));
	$leadid=$adb->query_result($result,0,'crmid');
	$log->debug("Exiting getEmailsRelatedLeads method ...");
	return $leadid;
}

function getAllLocalitesByCountry($contry)
{
	global $log;
	$log->debug("Entering getAllLocalitesByCountry() method ...");
       global $adb;
	$LOCALITES = array();
	$LOCALITESOPT = array();

	$sql = "SELECT * FROM sigc_localites ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$LOCALITES[]=$row;
	}
	$LOCALITESOPT[''] = 'Choisir...';
	foreach($LOCALITES as $entry_key=>$localite)
	{
		if($localite['localitedepth']==0 && $localite['localitenom']==$contry)
			//$LOCALITESOPT[$localite['localiteid']] = $localite['localitenom'];
			foreach($LOCALITES as $entry_key2=>$localite2)
			{
				if($localite2['localitedepth']==1 && strstr($localite2['localiteparent'],$localite['localiteid']) )
					//$LOCALITESOPT['SENEGAL'][$localite2['localiteid']] = $localite2['localitenom'];
					foreach($LOCALITES as $entry_key3=>$localite3)
					{
						if($localite3['localitedepth']==2 && strstr($localite3['localiteparent'],$localite['localiteid'].':'.$localite2['localiteid']))
							$LOCALITESOPT[$localite['localitenom']][$localite2['localitenom']][$localite3['localiteid']] = $localite3['localitenom'];
					}
			}
		
		
	}

	return $LOCALITESOPT;

}

function getAllLocalites()
{
	global $log;
	$log->debug("Entering getAllLocalites() method ...");
       global $adb;
	$LOCALITES = array();
	$LOCALITESOPT = array();

	$sql = "SELECT * FROM sigc_localites order by localitenom";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$LOCALITES[]=$row;
	}
	$LOCALITESOPT[''] = 'Choisir...';
	foreach($LOCALITES as $entry_key=>$localite)
	{
		if($localite['localitedepth']==0)
			//$LOCALITESOPT[$localite['localiteid']] = $localite['localitenom'];
			foreach($LOCALITES as $entry_key2=>$localite2)
			{
				if($localite2['localitedepth']==1 && $localite2['localiteparent']==$localite['localiteid'].":".$localite2['localiteid'] )
					//$LOCALITESOPT['SENEGAL'][$localite2['localiteid']] = $localite2['localitenom'];
					foreach($LOCALITES as $entry_key3=>$localite3)
					{
						if($localite3['localitedepth']==2 && $localite3['localiteparent']==$localite['localiteid'].':'.$localite2['localiteid'].':'.$localite3['localiteid'])
							$LOCALITESOPT[$localite['localitenom']][$localite2['localitenom']][$localite3['localiteid']] = $localite3['localitenom'];
					}
			}
		
		
	}

	return $LOCALITESOPT;

}

function getAllVilles()
{
	global $log;
	$log->debug("Entering getAllVilles() method ...");
       global $adb;
	$LOCALITES = array();
	$LOCALITESOPT = array();

	$sql = "SELECT * FROM param_localites order by localitenom";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$LOCALITES[]=$row;
	}
	$LOCALITESOPT[''] = 'Choisir...';
	foreach($LOCALITES as $entry_key=>$localite)
	{
		if($localite['localitedepth']==0)
			//$LOCALITESOPT[$localite['localiteid']] = $localite['localitenom'];
			foreach($LOCALITES as $entry_key2=>$localite2)
			{
				if($localite2['localitedepth']==1 && $localite2['localiteparent']==$localite['localiteid'].":".$localite2['localiteid'] )
					$LOCALITESOPT[$localite['localitenom']][$localite2['localiteid']] = $localite2['localitenom'];
					
			}
		
		
	}

	return $LOCALITESOPT;

}

function getAllProjects()
{
	global $log;
	$log->debug("Entering getAllProjects() method ...");
       global $adb;
	$PROEJECTS = array();
	$PROEJECTSOPT = array();

	$sql = "SELECT * FROM sigc_dossiers ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$PROEJECTS[]=$row;
	}
	$PROEJECTSOPT[''] = 'Choisir un Projet...';
	foreach($PROEJECTS as $entry_key=>$project)
	{
		if($project['depth']==0)
			//$PROEJECTSOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			foreach($PROEJECTS as $entry_key2=>$project2)
			{
				if($project2['depth']==1 && strstr($project2['dossierparent'],$project['dossiercode']) )
					//$LOCALITESOPT['SENEGAL'][$localite2['localiteid']] = $localite2['localitenom'];
					foreach($PROEJECTS as $entry_key3=>$project3)
					{
						if($project3['depth']==2 && strstr($project3['dossierparent'],$project['dossiercode'].':'.$project2['dossiercode']))
							$PROEJECTSOPT[$project['dossierlibelle']][$project2['dossierlibelle']][$project3['dossiercode']] = $project3['dossiersigle'].' : '.$project3['dossierlibelle'];
					}
			}
		
		
	}

	return $PROEJECTSOPT;

}

function getAllProjectsByOrgane($organe)
{
	global $log;
	$log->debug("Entering getAllProjectsByOrgane() method ...");
       global $adb;
	$PROEJECTS = array();
	$PROEJECTSOPT = array();

	$sql = "SELECT * FROM sigc_dossiers ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$PROEJECTS[]=$row;
	}
	$PROEJECTSOPT[''] = 'Choisir un Projet...';
	foreach($PROEJECTS as $entry_key=>$project)
	{
		if($project['depth']==0 && $project['organecode']==$organe)
			//$PROEJECTSOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			foreach($PROEJECTS as $entry_key2=>$project2)
			{
				if($project2['depth']==1 && strstr($project2['dossierparent'],$project['dossiercode']) )
					//$LOCALITESOPT['SENEGAL'][$localite2['localiteid']] = $localite2['localitenom'];
					foreach($PROEJECTS as $entry_key3=>$project3)
					{
						if($project3['depth']==2 && strstr($project3['dossierparent'],$project['dossiercode'].':'.$project2['dossiercode']))
							$PROEJECTSOPT[$project['dossierlibelle']][$project2['dossierlibelle']][$project3['dossiercode']] = $project3['dossiersigle'].' : '.$project3['dossierlibelle'];
					}
			}
		
		
	}

	return $PROEJECTSOPT;

}

function  getinfosproject($projectid) {

		// TO DO
		global $log, $app_strings, $nb_appels_distribues, $nb_appels_recus,$adb;
		$log->debug("Entering getinfosproject() method ...");

		
		$querydossier=" SELECT o.organecode AS organeid,o.organelibelle AS organe,o.organesigle AS organesigle,d3.dossiercode AS projetid ,d1.dossiercode AS politiqueid ,
						d1.dossierlibelle AS politique,d2.dossiercode AS programmeid,d2.dossierlibelle AS programme 
						FROM sigc_organes o,sigc_dossiers d1,sigc_dossiers d2,sigc_dossiers d3
						WHERE  o.organecode=d3.organecode 
						AND d3.dossiercode = ?
						AND d2.depth=1 AND  d2.dossierparent=CONCAT(d1.dossiercode,':',d2.dossiercode)
						AND d3.depth=2 AND d3.dossierparent = CONCAT(d1.dossiercode,':',d2.dossiercode,':',d3.dossiercode)  " ;
		$resultdossier= $adb->pquery($querydossier, array($projectid));	
		$organe = $adb->query_result($resultdossier, 0, 'organe');
		$organeid = $adb->query_result($resultdossier, 0, 'organeid');
		$organesigle = $adb->query_result($resultdossier, 0, 'organesigle');
		$politique = $adb->query_result($resultdossier, 0, 'politique');
		$politiqueid = $adb->query_result($resultdossier, 0, 'politiqueid');
		$programme = $adb->query_result($resultdossier, 0, 'programme');
		$programmeid = $adb->query_result($resultdossier, 0, 'programmeid');
		
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$dossier = array();

		
		$dossier["organeid"] = $organeid;
		$dossier["organe"] = $organesigle.' : '.$organe;
		$dossier["politiqueid"] = $politiqueid;
		$dossier["politique"] = $politique;
		$dossier["programmeid"] = $programmeid;
		$dossier["programme"] = $programme;
		
		$log->debug("Exiting getinfosproject method ...");
		
		return $dossier;						
	}
	
function getAllDomainesByOrgane($organe)
{
	global $log;
	$log->debug("Entering getAllDomainesByOrgane() method ...");
       global $adb;
	$DOMAINES = array();
	$DOMAINESOPT = array();

	$sql = "SELECT * FROM sigc_domaines ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$DOMAINES[]=$row;
	}
	$DOMAINESOPT[''] = 'Choisir un domaine...';
	foreach($DOMAINES as $entry_key=>$domaine)
	{
		if($domaine['domainedepth']==0 && $domaine['organecode']==$organe)
			//$DOMAINESOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			foreach($DOMAINES as $entry_key2=>$domaine2)
			{
				if($domaine2['domainedepth']==1 && strstr($domaine2['domaineparent'],$domaine['domainecode']) )
					$DOMAINESOPT[$domaine['domainelibelle']][$domaine2['domainecode']] = $domaine2['domainelibelle'];
					
			}
		
		
	}

	return $DOMAINESOPT;

}


function getAllOrganes()
{
	global $log;
	$log->debug("Entering getAllOrgane() method ...");
       global $adb;
	$ORGANES = array();
	$ORGANESOPT = array();

	$sql = "SELECT * FROM sigc_organes ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$ORGANES[]=$row;
	}
	$ORGANESOPT['000'] = 'Tous';
	foreach($ORGANES as $entry_key=>$organe)
	{
		if($organe['organedepth']==0)
			//$ORGANESOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			
			foreach($ORGANES as $entry_key2=>$organe2)
			{
				if($organe2['depth']==1 && strstr($organe2['organeparent'],$organe['organecode']) )
					//$LOCALITESOPT['SENEGAL'][$organe2['localiteid']] = $lorgane2['localitenom'];
					foreach($ORGANES as $entry_key3=>$organe3)
					{
						if($organe3['depth']==2 && strstr($organe3['organeparent'],$organe['organecode'].':'.$organe2['organecode']))
							$ORGANESOPT[$organe['organelibelle']][$organe2['organelibelle']][$organe3['organecode']] =$organe3['organesigle'].' : '.$organe3['organelibelle'];
					}
			}
		
	}
	
	return $ORGANESOPT;

}

function getAllDomaines()
{
	global $log;
	$log->debug("Entering getAllDomaines() method ...");
       global $adb;
	$DOMAINES = array();
	$DOMAINESOPT = array();

	$sql = "SELECT * FROM sigc_domaines order by domainelibelle ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$DOMAINES[]=$row;
	}
	$DOMAINESOPT['000'] = 'Tous';
	foreach($DOMAINES as $entry_key=>$domaine)
	{
		if($domaine['domainedepth']==0)
			//$DOMAINESOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			foreach($DOMAINES as $entry_key2=>$domaine2)
			{
				if($domaine2['domainedepth']==1 && $domaine2['domaineparent']==$domaine['domainecode'].":".$domaine2['domainecode'] )
					$DOMAINESOPT[$domaine['domainelibelle']][$domaine2['domainecode']] = $domaine2['domainelibelle'];
					
			}
		
		
	}

	return $DOMAINESOPT;

}

function getDelaiConvention($ticket)
{
	global $log;
	global $adb;

	$log->debug("Entering getDelaiConvention() method ...");
	
	$sql = "SELECT  delai FROM sigc_convention WHERE ticket=? ";
	$result = $adb->pquery($sql, array($ticket));
	
	$delai = $adb->query_result($result,0,"delai");
	return $delai;

}

function getDomaineById($domaineid)
{
	global $log;
	$log->debug("Entering getDomaineById() method ...");
       global $adb;
	
	$sql = "SELECT  domainelibelle domaine FROM sigc_domaines WHERE domainecode=? ";
	$result = $adb->pquery($sql, array($domaineid));
	
	$domaine = $adb->query_result($result,0,"domaine");
	return $domaine;

}
function getTypeActiviteById($typeactiviteid)
{
	global $log;
	$log->debug("Entering getTypeActiviteById() method ...");
       global $adb;
	
	$sql = "SELECT  typeactivitelib AS typeactivite FROM sigc_type_activites WHERE typeactiviteid=? ";
	$result = $adb->pquery($sql, array($typeactiviteid));
	
	$typeactivite = $adb->query_result($result,0,"typeactivite");
	return $typeactivite;

}
function getTypeActiviteTiersById($typeactiviteid)
{
	global $log;
	$log->debug("Entering getTypeActiviteTiersById() method ...");
       global $adb;
	
	$sql = "SELECT  activitelibelle AS typeactivite FROM tiers_activites WHERE activitecode=? ";
	$result = $adb->pquery($sql, array($typeactiviteid));
	
	$typeactivite = $adb->query_result($result,0,"typeactivite");
	return $typeactivite;

}
function getSecteursActivitesById($secteursid)
{
	global $log;
	$log->debug("Entering getSecteursActivitesById() method ...");
       global $adb;
	
	$listsecteurs=explode('|##|',$secteursid);
	foreach($listsecteurs as $loc)
	{
		$loc=trim($loc);
		$secteur = getTypeActiviteTiersById($loc);
		$secteurs.=$secteur."<br>";
	}
	return $secteurs;

}

function getProjectById($projectid)
{
	global $log;
	$log->debug("Entering getProjectById() method ...");
       global $adb;
	
	$sql = "SELECT  CONCAT(dossierlibelle,' (',dossiersigle,')') AS project FROM sigc_dossiers WHERE dossiercode=? ";
	$result = $adb->pquery($sql, array($projectid));
	
	$project = $adb->query_result($result,0,"project");
	return $project;

}
/*
function getDepartById($organeid)
{
	global $log;
	$log->debug("Entering getDepartById() method ...");
       global $adb;
	
	$sql = "SELECT  CONCAT(organelibelle,' (',organesigle,')') AS organe FROM tiers_departements WHERE organecode=? ";
	$result = $adb->pquery($sql, array($organeid));
	
	$organe = $adb->query_result($result,0,"organe");
	return $organe;

}
*/
function getDepartById($organeid)
{
	global $log;
	$log->debug("Entering getDepartById() method ...");
       global $adb;
	
	$sql = "SELECT libdepartement FROM services WHERE codedepartement=? ";
	$result = $adb->pquery($sql, array($organeid));
	
	$libdepartement = $adb->query_result($result,0,"libdepartement");
	return $libdepartement;

}
function getAllVillesPays()
{
	global $log;
	$log->debug("Entering getAllVillesPays() method ...");
       global $adb;
	$LOCALITES = array();
	$LOCALITESOPT = array();

	$sql = "SELECT * FROM param_localites_villes  order by localitenom";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$LOCALITES[]=$row;
	}
	$LOCALITESOPT[''] = 'Choisir le lieu de la réunion...';
	foreach($LOCALITES as $entry_key=>$localite)
	{
		foreach($LOCALITES as $entry_key2=>$localite2)
		{
			if($localite2['localitedepth']==1 && $localite2['localiteparent']==$localite['localiteid'].":".$localite2['localiteid'] )
			$LOCALITESOPT[$localite['localitenom']][$localite2['localitenom']] = $localite2['localitenom'];
		}
		
	}
	return $LOCALITESOPT;

}
function getBudgetsReunionByAgentDepart($matricule)
{
	global $log;
	$log->debug("Entering getBudgetsReunionByAgentDepart(".$matricule.") method ...");
	$log->info("in getBudgetsReunionByAgentDepart ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT CONCAT(centrefinancier,'-',domainefinancier) codebudg ,libactivite
			FROM codebudgetaire , users u
			WHERE u.user_matricule=?
			AND SUBSTRING(u.user_direction,1,5)=SUBSTRING(centrefinancier,1,5) 
			AND iscodebudgetreunion=1";
               $result = $adb->pquery($sql, array($matricule));
	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTCODEBUDGET[]=$row;
	}
	 $CODEBUDGETOPT[''] = 'Choisir le code budgetaire...';
	 
	foreach($LISTCODEBUDGET as $entry_key=>$codebudget)
	{
		$CODEBUDGETOPT[$codebudget['codebudg']] = $codebudget['codebudg'].' ('.$codebudget['libactivite'].')';
	}  
	 
		
        }
	$log->debug("Exiting getBudgetsReunionByAgentDepart method ...");
        return $CODEBUDGETOPT;
}
function getLocaliteById($localite)
{
	global $log;
	$log->debug("Entering getLocaliteById() method ...");
       global $adb;
	
	$sql = "SELECT CONCAT(l1.localitenom,'/',l2.localitenom,'/',l3.localitenom) AS localite
			FROM sigc_localites l1,sigc_localites l2,sigc_localites l3
			WHERE  l1.localiteid=?
			AND l2.localitedepth=1 AND  l2.localiteparent =CONCAT(l3.localiteid,':',l2.localiteid)
			AND l1.localitedepth=2 AND l1.localiteparent =CONCAT(l3.localiteid,':',l2.localiteid,':',l1.localiteid) ";
			
	$result = $adb->pquery($sql, array($localite));
	
	$localite = $adb->query_result($result,0,"localite");
	return $localite;

}

function getLieuById($localite)
{
	global $log;
	$log->debug("Entering getLieuById() method ...");
       global $adb;
	
	$sql = "SELECT CONCAT(l1.localitenom,' (',l2.localitenom,')') AS lieu
			FROM param_localites l1,param_localites l2
			WHERE  l1.localiteid=?
			AND l1.localitedepth=1 AND  l1.localiteparent =CONCAT(l2.localiteid,':',l1.localiteid) ";
			
	$result = $adb->pquery($sql, array($localite));
	
	$lieu = $adb->query_result($result,0,"lieu");
	return $lieu;

}

function getTimbreById($timbreid)
{
	global $log;
	$log->debug("Entering getTimbreById() method ...");
       global $adb;
	
	$sql = "SELECT CONCAT(timbre1,timbre2,timbre3) AS timbre FROM timbre WHERE id=? ";
			
	$result = $adb->pquery($sql, array($timbreid));
	
	$timbre = $adb->query_result($result,0,"timbre");
	return $timbre;

}

function getStatutById($idstatut)
{
	global $log;
	$log->debug("Entering getStatutById() method ...");
       global $adb;
	
	$sql = "SELECT libstatus statut FROM demsetatus WHERE STATUS=?";
			
	$result = $adb->pquery($sql, array($idstatut));
	
	$statut = $adb->query_result($result,0,"statut");
	return $statut;

}
function getZoneById($zoneid)
{
	global $log;
	$log->debug("Entering getZoneById() method ...");
       global $adb;
	
	$sql = "SELECT libellezone FROM zone WHERE idzone=?";
			
	$result = $adb->pquery($sql, array($zoneid));
	
	$zone = $adb->query_result($result,0,"libellezone");
	return $zone;

}
function getNomPrenom($maticule)
{
	global $log;
	$log->debug("Entering getNomPrenom() method ...");
       global $adb;
	
	$sql = "SELECT CONCAT(user_name,' ',user_firstname) AS nom
			FROM users 
			WHERE  User_Matricule=?";
			
	$result = $adb->pquery($sql, array($maticule));
	
	$nomcomplet = $adb->query_result($result,0,"nom");
	return $nomcomplet;

}

function getDirectionById($directionid)
{
	global $log;
	$log->debug("Entering getDirectionById() method ...");
       global $adb;
	
	$sql = "SELECT libservice FROM services WHERE codeservice=? ";
	$result = $adb->pquery($sql, array($directionid));
	
	$libservice = $adb->query_result($result,0,"libservice");
	return $libservice;

}

function getCategerieById($catid)
{
	global $log;
	$log->debug("Entering getCategerieById() method ...");
       global $adb;
	
	$sql = "SELECT titrecat FROM categorie WHERE codecatuemoa=? ";
	$result = $adb->pquery($sql, array($catid));
	
	$titrecat = $adb->query_result($result,0,"titrecat");
	return $titrecat;

}

function getProfilById($profilid)
{
	global $log;
	$log->debug("Entering getProfilById() method ...");
       global $adb;
	
	$sql = "SELECT profilename FROM vtiger_profile WHERE profileid=? ";
	$result = $adb->pquery($sql, array($profilid));
	
	$profilename = $adb->query_result($result,0,"profilename");
	return $profilename;

}
function getAllProgrammes()
{
	global $log;
	$log->debug("Entering getAllProgrammes() method ...");
       global $adb;
	$PROGRAMMES = array();
	$PROGRAMMESOPT = array();

	$sql = "SELECT * FROM sigc_dossiers order by dossiersigle  ";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$PROGRAMMES[]=$row;
	}
	$PROGRAMMESOPT['000'] = 'Tous';
	foreach($PROGRAMMES as $entry_key=>$programme)
	{
		//$PROGRAMMESOPT[$programme['dossiercode']] = $programme['dossiersigle'].' : '.$programme['dossierlibelle'];
		
		if($programme['depth']==0)
			//$DOMAINESOPT[$dossierparent] = 'D&eacute;partement de la S&eacute;curit&eacute; Alimentaire, de l Agriculture, des Mines et de l Environnement (DSAME)';
			foreach($PROGRAMMES as $entry_key2=>$programme2)
			{
				if($programme2['depth']==1 && $programme2['dossierparent']==$programme['dossiercode'].":".$programme2['dossiercode'] )
					$PROGRAMMESOPT[$programme['dossiersigle'].':'.$programme['dossierlibelle']][$programme2['dossiercode']] = $programme2['dossiersigle'].':'.$programme2['dossierlibelle'];
					
			}
					
	}
	
	return $PROGRAMMESOPT;

}

function getAllPolitiques()
{
	global $log;
	$log->debug("Entering getAllPolitiques() method ...");
       global $adb;
	$POLITIQUES = array();
	$POLITIQUESOPT = array();

	$sql = "SELECT * FROM sigc_dossiers where depth=0 order by dossiersigle";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$POLITIQUES[]=$row;
	}
	$POLITIQUESOPT['000'] = 'Tous';
	foreach($POLITIQUES as $entry_key=>$politique)
	{
			$POLITIQUESOPT[$politique['dossiercode']] = $politique['dossierlibelle'].' ('.$politique['dossiersigle'].')';
	}

	return $POLITIQUESOPT;

}

function getAllTypesActivite()
{
	global $log;
	$log->debug("Entering getAllTypesActivite() method ...");
       global $adb;
	$TYPEACTIVITES = array();
	$TYPEACTIVITESOPT = array();

	$sql = "SELECT * FROM tiers_activites order by 1";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$TYPEACTIVITES[]=$row;
	}
	$TYPEACTIVITESOPT[''] = 'Choisir un Type d\'activit&eacute;...';
	foreach($TYPEACTIVITES as $entry_key=>$typeact)
	{
		$TYPEACTIVITESOPT[$typeact['activitecode']] = $typeact['activitelibelle'];
					
	}

	return $TYPEACTIVITESOPT;

}

function getdepartementsOrgane($organe)
{
	global $log, $singlepane_view,$adb;
	$log->debug("Entering getdepartementsOrgane(".$organe.") method ...");
	global $app_strings, $mod_strings;
	
	$query ="SELECT organecode,organesigle,organelibelle
			FROM tiers_departements 
			WHERE organeparent = CONCAT('".$organe."',':',organecode) 
			AND depth=2" ;
	

	$log->debug("Exiting getOrganesLibelle method ...");
	$result = $adb->pquery($query, array());
	$optionslist="";
	while ( $row1 = $adb->fetchByAssoc($result) )
	{
		//$optionslist="<option value=".$row1["organecode"].">".$row1["organelibelle"]."(".$row1["organesigle"].")"."</option>";
		$optionslist[]=$row1["organecode"].":".$row1["organelibelle"]."(".$row1["organesigle"].")";
			
	}
	
	return $optionslist;
}

function getAllAgencesExecution()
{
	global $log;
	$log->debug("Entering getAllAgencesExecution() method ...");
       global $adb;
	$MAITRISEOUVRAGES = array();
	$MAITRISEOUVRAGESOPT = array();

	$sql = "SELECT * FROM sigc_maitriseouvrages order by pays";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$MAITRISEOUVRAGES[]=$row;
	}
	$MAITRISEOUVRAGESOPT['000'] = 'Choisir une Agence d\'execution...';
	foreach($MAITRISEOUVRAGES as $entry_key=>$maitriseouvrages)
	{
			foreach($MAITRISEOUVRAGES as $entry_key2=>$maitriseouvrages2)
			{
				if($maitriseouvrages2['pays']==$maitriseouvrages['pays'] )
							$MAITRISEOUVRAGESOPT[$maitriseouvrages['pays']][$maitriseouvrages2['sigle']] = $maitriseouvrages2['libelle'];
			}
		
	}

	return $MAITRISEOUVRAGESOPT;

}

function getAllLocalitesPays()
{
	global $log;
	$log->debug("Entering getAllLocalitesPays() method ...");
       global $adb;
	$LOCALITES = array();
	$LOCALITESOPT = array();

	$sql = "SELECT * FROM sigc_localites where localitedepth=0 order by localitenom";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$LOCALITES[]=$row;
	}
	$LOCALITESOPT['000'] = 'Toutes';
	foreach($LOCALITES as $entry_key=>$localite)
	{
		$LOCALITESOPT[$localite['localiteid']] = $localite['localitenom'];
	}
	return $LOCALITESOPT;

}

function getfonctionsentreprise()
{	
		// TO DO
		global $log, $singlepane_view,$adb,$dbconfig;
		$log->debug("Entering getfonctionsentreprise() method ...");
		global $app_strings, $mod_strings;
		
		$connectionInfo = array( "Database" => "PAIE_UEMOA", "UID" => $dbconfig['db_usersql'], "PWD" => $dbconfig['db_pwdsql'], "CharacterSet" => "UTF-8");
		$con = sqlsrv_connect($dbconfig['db_serversql'], $connectionInfo);
		if( $con === false )
		{
		 die('Not working: ' . sqlsrv_errors());
		 // $fonctions['errorsql'] = sqlsrv_errors();
		}
		$sql = "select Code,UPPER(Intitule) as intitule from PAIE_UEMOA.dbo.T_FONCTIONENTREPRISE WHERE Code NOT IN ('CE') order by 2 ";
		$stmt = sqlsrv_query( $con, $sql );
		if( $stmt === false) {
		   die( print_r(sqlsrv_errors(), true) );
			//$fonctions['errorsql'] = sqlsrv_errors();
		}

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
			$fonctions[$row['Code']] = $row['intitule'];
			//print_r($row);
			
			}

	sqlsrv_free_stmt( $stmt);
		return $fonctions;
}

/*
function getAllMairiseOuvrages()
{
	global $log;
	$log->debug("Entering getAllMairiseOuvrages() method ...");
       global $adb;
	$MAITRISEOUVRAGES = array();
	$MAITRISEOUVRAGESOPT = array();

	$sql = "SELECT * FROM sigc_maitriseouvrages order by pays";
	$result = $adb->pquery($sql, array());
	
	while ($row = $adb->fetchByAssoc($result))
	{
		$MAITRISEOUVRAGES[]=$row;
	}
	$MAITRISEOUVRAGESOPT[''] = 'Choisir...';
	foreach($MAITRISEOUVRAGES as $entry_key=>$maitriseouvrages)
	{
			foreach($MAITRISEOUVRAGES as $entry_key2=>$maitriseouvrages2)
			{
				if($maitriseouvrages2['pays']==$maitriseouvrages['pays'] )
							$MAITRISEOUVRAGESOPT[$maitriseouvrages['pays']][$maitriseouvrages2['maitriseouvrageid']] = $maitriseouvrages2['libelle'];
			}
		
	}

	return $MAITRISEOUVRAGESOPT;

}*/
/** Function to get HelpDesk related Accounts   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getHelpDeskRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getHelpDeskRelatedAccounts(".$record_id.") method ...");
	global $adb;
        $query="select parent_id from vtiger_troubletickets inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_troubletickets.parent_id where ticketid=? and vtiger_crmentity.setype='Accounts'";
        $result=$adb->pquery($query, array($record_id));
        $accountid=$adb->query_result($result,0,'parent_id');
	$log->debug("Exiting getHelpDeskRelatedAccounts method ...");
        return $accountid;
}

/** Function to get Quotes related Accounts   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getQuotesRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getQuotesRelatedAccounts(".$record_id.") method ...");
	global $adb;
        $query="select accountid from vtiger_quotes where quoteid=?";
        $result=$adb->pquery($query, array($record_id));
        $accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting getQuotesRelatedAccounts method ...");
        return $accountid;
}

/** Function to get Quotes related Potentials   
  * @param $record_id -- record id :: Type integer
  * @returns $potid -- potid:: Type integer
  */

function getQuotesRelatedPotentials($record_id)
{
	global $log;
	$log->debug("Entering getQuotesRelatedPotentials(".$record_id.") method ...");
	global $adb;
        $query="select potentialid from vtiger_quotes where quoteid=?";
        $result=$adb->pquery($query, array($record_id));
        $potid=$adb->query_result($result,0,'potentialid');
	$log->debug("Exiting getQuotesRelatedPotentials method ...");
        return $potid;
}

/** Function to get Quotes related Potentials   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getSalesOrderRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getSalesOrderRelatedAccounts(".$record_id.") method ...");
	global $adb;
        $query="select accountid from vtiger_salesorder where salesorderid=?";
        $result=$adb->pquery($query, array($record_id));
        $accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting getSalesOrderRelatedAccounts method ...");
        return $accountid;
}

/** Function to get SalesOrder related Potentials   
  * @param $record_id -- record id :: Type integer
  * @returns $potid -- potid:: Type integer
  */

function getSalesOrderRelatedPotentials($record_id)
{
	global $log;
	$log->debug("Entering getSalesOrderRelatedPotentials(".$record_id.") method ...");
	global $adb;
        $query="select potentialid from vtiger_salesorder where salesorderid=?";
        $result=$adb->pquery($query, array($record_id));
        $potid=$adb->query_result($result,0,'potentialid');
	$log->debug("Exiting getSalesOrderRelatedPotentials method ...");
        return $potid;
}
/** Function to get SalesOrder related Quotes   
  * @param $record_id -- record id :: Type integer
  * @returns $qtid -- qtid:: Type integer
  */

function getSalesOrderRelatedQuotes($record_id)
{
	global $log;
	$log->debug("Entering getSalesOrderRelatedQuotes(".$record_id.") method ...");
	global $adb;
        $query="select quoteid from vtiger_salesorder where salesorderid=?";
        $result=$adb->pquery($query, array($record_id));
        $qtid=$adb->query_result($result,0,'quoteid');
	$log->debug("Exiting getSalesOrderRelatedQuotes method ...");
        return $qtid;
}

/** Function to get Invoice related Accounts   
  * @param $record_id -- record id :: Type integer
  * @returns $accountid -- accountid:: Type integer
  */

function getInvoiceRelatedAccounts($record_id)
{
	global $log;
	$log->debug("Entering getInvoiceRelatedAccounts(".$record_id.") method ...");
	global $adb;
        $query="select accountid from vtiger_invoice where invoiceid=?";
        $result=$adb->pquery($query, array($record_id));
        $accountid=$adb->query_result($result,0,'accountid');
	$log->debug("Exiting getInvoiceRelatedAccounts method ...");
        return $accountid;
}
/** Function to get Invoice related SalesOrder   
  * @param $record_id -- record id :: Type integer
  * @returns $soid -- soid:: Type integer
  */

function getInvoiceRelatedSalesOrder($record_id)
{
	global $log;
	$log->debug("Entering getInvoiceRelatedSalesOrder(".$record_id.") method ...");
	global $adb;
        $query="select salesorderid from vtiger_invoice where invoiceid=?";
        $result=$adb->pquery($query, array($record_id));
        $soid=$adb->query_result($result,0,'salesorderid');
	$log->debug("Exiting getInvoiceRelatedSalesOrder method ...");
        return $soid;
}


/** Function to get Days and Dates in between the dates specified
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function get_days_n_dates($st,$en)
{
	global $log;
	$log->debug("Entering get_days_n_dates(".$st.",".$en.") method ...");
        $stdate_arr=explode("-",$st);
        $endate_arr=explode("-",$en);

        $dateDiff = mktime(0,0,0,$endate_arr[1],$endate_arr[2],$endate_arr[0]) - mktime(0,0,0,$stdate_arr[1],$stdate_arr[2],$stdate_arr[0]);//to get  dates difference

        $days   =  floor($dateDiff/60/60/24)+1; //to calculate no of. days
        for($i=0;$i<$days;$i++)
        {
                $day_date[] = date("Y-m-d",mktime(0,0,0,date("$stdate_arr[1]"),(date("$stdate_arr[2]")+($i)),date("$stdate_arr[0]")));
        }
        if(!isset($day_date))
                $day_date=0;
        $nodays_dates=array($days,$day_date);
	$log->debug("Exiting get_days_n_dates method ...");
        return $nodays_dates; //passing no of days , days in between the days
}//function end


/** Function to get the start and End Dates based upon the period which we give
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function start_end_dates($period)
{
	global $log;
	$log->debug("Entering start_end_dates(".$period.") method ...");
        $st_thisweek= date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-date("w")),date("Y")));
        if($period=="tweek")
        {
                $st_date= date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-date("w")),date("Y")));
                $end_date = date("Y-m-d",mktime(0,0,0,date("n"),(date("j")-1),date("Y")));
                $st_week= date("w",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($st_week==0)
                {
                        $start_week=explode("-",$st_thisweek);
                        $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-7),date("$start_week[0]")));
                        $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-1),date("$start_week[0]")));
                }
                $period_type="week";
                $width="360";
        }
        else if($period=="lweek")
        {
                $start_week=explode("-",$st_thisweek);
                $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-7),date("$start_week[0]")));
                $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-1),date("$start_week[0]")));
                $st_week= date("w",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($st_week==0)
                {
                        $start_week=explode("-",$st_thisweek);
                        $st_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-14),date("$start_week[0]")));
                        $end_date = date("Y-m-d",mktime(0,0,0,date("$start_week[1]"),(date("$start_week[2]")-8),date("$start_week[0]")));
                }
                $period_type="week";
                $width="360";
        }
        else if($period=="tmon")
        {
		$period_type="month";
		$width="840";
		$st_date = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));	
		$end_date = date("Y-m-t");

        }
        else if($period=="lmon")
        {
                $st_date=date("Y-m-d",mktime(0,0,0,date("n")-1,date("1"),date("Y")));
                $end_date = date("Y-m-d",mktime(0, 0, 1, date("n"), 0,date("Y")));
                $period_type="month";
                $start_month=date("d",mktime(0,0,0,date("n"),date("j"),date("Y")));
                if($start_month==1)
                {
                        $st_date=date("Y-m-d",mktime(0,0,0,date("n")-2,date("1"),date("Y")));
                        $end_date = date("Y-m-d",mktime(0, 0, 1, date("n")-1, 0,date("Y")));
                }

                $width="840";
        }
        else
        {
                $curr_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
                $today_date=explode("-",$curr_date);
                $lastday_date=date("Y-m-d",mktime(0,0,0,date("$today_date[1]"),date("$today_date[2]")-1,date("$today_date[0]")));
                $st_date=$lastday_date;
                $end_date=$lastday_date;
                $period_type="yday";
		 $width="250";
        }
        if($period_type=="yday")
                $height="160";
        else
                $height="250";
        $datevalues=array($st_date,$end_date,$period_type,$width,$height);
	$log->debug("Exiting start_end_dates method ...");
        return $datevalues;
}//function ends


/**   Function to get the Graph and vtiger_table format for a particular date
        based upon the period
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Contributor(s): ______________________________________..
 */
function Graph_n_table_format($period_type,$date_value)
{
	global $log;
	$log->debug("Entering Graph_n_table_format(".$period_type.",".$date_value.") method ...");
        $date_val=explode("-",$date_value);
        if($period_type=="month")   //to get the vtiger_table format dates
        {
                $table_format=date("j",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=date("D",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
        }
        else if($period_type=="week")
        {
                $table_format=date("d/m",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=date("D",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
        }
        else if($period_type=="yday")
        {
                $table_format=date("j",mktime(0,0,0,date($date_val[1]),(date($date_val[2])),date($date_val[0])));
                $graph_format=$table_format;
        }
        $values=array($graph_format,$table_format);
	$log->debug("Exiting Graph_n_table_format method ...");
        return $values;
}

/** Function to get image count for a given product   
  * @param $id -- product id :: Type integer
  * @returns count -- count:: Type integer
  */

function getImageCount($id)
{
	global $log;
	$log->debug("Entering getImageCount(".$id.") method ...");
	global $adb;
	$image_lists=array();
	$query="select imagename from vtiger_products where productid=?";
	$result=$adb->pquery($query, array($id));
	$imagename=$adb->query_result($result,0,'imagename');
	$image_lists=explode("###",$imagename);
	$log->debug("Exiting getImageCount method ...");
	return count($image_lists);

}

/** Function to get user image for a given user   
  * @param $id -- user id :: Type integer
  * @returns $image_name -- image name:: Type string
  */

function getUserImageName($id)
{
	global $log;
	$log->debug("Entering getUserImageName(".$id.") method ...");
	global $adb;
	$query = "select imagename from vtiger_users where id=?";
	$result = $adb->pquery($query, array($id));
	$image_name = $adb->query_result($result,0,"imagename");
	$log->debug("Inside getUserImageName. The image_name is ".$image_name);
	$log->debug("Exiting getUserImageName method ...");
	return $image_name;

}

/** Function to get all user images for displaying it in listview   
  * @returns $image_name -- image name:: Type array
  */

function getUserImageNames()
{
	global $log;
	$log->debug("Entering getUserImageNames() method ...");
	global $adb;
	$query = "select imagename from vtiger_users where deleted=0";
	$result = $adb->pquery($query, array());
	$image_name=array();
	for($i=0;$i<$adb->num_rows($result);$i++)
	{
		if($adb->query_result($result,$i,"imagename")!='')
			$image_name[] = $adb->query_result($result,$i,"imagename");
	}
	$log->debug("Inside getUserImageNames.");
	if(count($image_name) > 0)
	{
		$log->debug("Exiting getUserImageNames method ...");
		return $image_name;
	}
}

/**   Function to remove the script tag in the contents
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function strip_selected_tags($text, $tags = array())
{
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
    foreach ($tags as $tag){
        if(preg_match_all('/<'.$tag.'[^>]*>(.*)<\/'.$tag.'>/iU', $text, $found)){
            $text = str_replace($found[0],$found[1],$text);
        }
    }

    return $text;
}

/** Function to check whether user has opted for internal mailer
  * @returns $int_mailer -- int mailer:: Type boolean
    */
function useInternalMailer() {
	global $current_user,$adb;
	return $adb->query_result($adb->pquery("select int_mailer from vtiger_mail_accounts where user_id=?", array($current_user->id)),0,"int_mailer");
}

/**
* the function is like unescape in javascript
* added by dingjianting on 2006-10-1 for picklist editor
*/
function utf8RawUrlDecode ($source) {
    global $default_charset;
    $decodedStr = "";
    $pos = 0;
    $len = strlen ($source);
    while ($pos < $len) {
        $charAt = substr ($source, $pos, 1);
        if ($charAt == '%') {
            $pos++;
            $charAt = substr ($source, $pos, 1);
            if ($charAt == 'u') {
                // we got a unicode character
                $pos++;
                $unicodeHexVal = substr ($source, $pos, 4);
                $unicode = hexdec ($unicodeHexVal);
                $entity = "&#". $unicode . ';';
                $decodedStr .= utf8_encode ($entity);
                $pos += 4;
            }
            else {
                // we have an escaped ascii character
                $hexVal = substr ($source, $pos, 2);
                $decodedStr .= chr (hexdec ($hexVal));
                $pos += 2;
            }
        } else {
            $decodedStr .= $charAt;
            $pos++;
        }
    }
    if(strtolower($default_charset) == 'utf-8')
	    return html_to_utf8($decodedStr);
    else
	    return $decodedStr;
    //return html_to_utf8($decodedStr);
}

/**
*simple HTML to UTF-8 conversion:
*/
function html_to_utf8 ($data)
{
	return preg_replace("/\\&\\#([0-9]{3,10})\\;/e", '_html_to_utf8("\\1")', $data);
}

function _html_to_utf8 ($data)
{
	if ($data > 127)
	{
		$i = 5;
		while (($i--) > 0)
		{
			if ($data != ($a = $data % ($p = pow(64, $i))))
			{
				$ret = chr(base_convert(str_pad(str_repeat(1, $i + 1), 8, "0"), 2, 10) + (($data - $a) / $p));
				for ($i; $i > 0; $i--)
					$ret .= chr(128 + ((($data % pow(64, $i)) - ($data % ($p = pow(64, $i - 1)))) / $p));
				break;
			}
		}
	}
	else
		$ret = "&#$data;";
	return $ret;
}

// Return Question mark
function _questionify($v){
	return "?";
}

/**
* Function to generate question marks for a given list of items
*/
function generateQuestionMarks($items_list) {
	// array_map will call the function specified in the first parameter for every element of the list in second parameter
	if (is_array($items_list)) {
		return implode(",", array_map("_questionify", $items_list));	
	} else {	
		return implode(",", array_map("_questionify", explode(",", $items_list)));
	}
}

/**
* Function to find the UI type of a field based on the uitype id
*/
function is_uitype($uitype, $reqtype) {
	$ui_type_arr = array(
		'_date_' => array(5, 6, 23, 70),
		'_picklist_' => array(15, 16, 52, 53, 54, 55, 59, 62, 63, 66, 68, 76, 77, 78, 80, 98, 101, 115, 357),
		'_users_list_' => array(52),
	);

	if ($ui_type_arr[$reqtype] != null) {
		if (in_array($uitype, $ui_type_arr[$reqtype])) {
			return true;
		}
	}
	return false;
}
/**
 * Function to escape quotes
 * @param $value - String in which single quotes have to be replaced.
 * @return Input string with single quotes escaped.
 */
function escape_single_quotes($value) {
	if (isset($value)) $value = str_replace("'", "\'", $value);	
	return $value;
}

/**
 * Function to format the input value for SQL like clause.
 * @param $str - Input string value to be formatted.
 * @param $flag - By default set to 0 (Will look for cases %string%). 
 *                If set to 1 - Will look for cases %string.
 *                If set to 2 - Will look for cases string%.
 * @return String formatted as per the SQL like clause requirement
 */
function formatForSqlLike($str, $flag=0,$is_field=false) {
	if (isset($str)) {
		if($is_field==false){
			$str = str_replace('%', '\%', $str);
			$str = str_replace('_', '\_', $str);
			if ($flag == 0) {
				$str = '%'. $str .'%';			
			} elseif ($flag == 1) {
				$str = '%'. $str;
			} elseif ($flag == 2) {
				$str = $str .'%';
			} 
		} else {
			if ($flag == 0) {
				$str = 'concat("%",'. $str .',"%")';			
			} elseif ($flag == 1) {
				$str = 'concat("%",'. $str .')';
			} elseif ($flag == 2) {
				$str = 'concat('. $str .',"%")';
			} 
		}
	}
	return mysql_real_escape_string($str);
}

/**
 * Get Current Module (global variable or from request)
 */
function getCurrentModule($perform_set=false) {
	global $currentModule;
	if(isset($currentModule)) return $currentModule;

	// Do some security check and return the module information
	if(isset($_REQUEST['module']))
	{
		$is_module = false;
		$module = $_REQUEST['module'];
		$dir = @scandir($root_directory."modules");
		$temp_arr = Array("CVS","Attic");
		$res_arr = @array_intersect($dir,$temp_arr);
		if(count($res_arr) == 0  && !ereg("[/.]",$module)) {
			if(@in_array($module,$dir))
				$is_module = true;
		}

		if($is_module) {
			if($perform_set) $currentModule = $module;
			return $module;
		}
	}
	return null;
}


/**
 * Set the language strings.
 */
function setCurrentLanguage($active_module=null) {
	global $current_language, $default_language, $app_strings, $app_list_strings, $mod_strings, $currentModule;

	if($active_module==null) {
		if (!isset($currentModule))
			$active_module = getCurrentModule();
		else
			$active_module = $currentModule;
	}

	if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
	{
		$current_language = $_SESSION['authenticated_user_language'];
	}
	else
	{
		$current_language = $default_language;
	}

	//set module and application string arrays based upon selected language
	if (!isset($app_strings))
		$app_strings = return_application_language($current_language);
	if (!isset($app_list_strings))
		$app_list_strings = return_app_list_strings_language($current_language);
	if (!isset($mod_strings) && isset($active_module))
		$mod_strings = return_module_language($current_language, $active_module);
}

/**	Function used to get all the picklists and their values for a module
	@param string $module - Module name to which the list of picklists and their values needed
	@return array $fieldlists - Array of picklists and their values
**/
function getAccessPickListValues($module)
{
	global $adb, $log;
	global $current_user;
	$log->debug("Entering into function getAccessPickListValues($module)");
	
	$id = getTabid($module);
	$query = "select fieldname,columnname,fieldid,fieldlabel,tabid,uitype from vtiger_field where tabid = ? and uitype in ('15','33','55') and vtiger_field.presence in (0,2)";
	$result = $adb->pquery($query, array($id));
	
	$roleid = $current_user->roleid;
	$subrole = getRoleSubordinates($roleid);
	
	if(count($subrole)> 0)
	{
		$roleids = $subrole;
		array_push($roleids, $roleid);
	}
	else
	{
		$roleids = $roleid;
	}

	$temp_status = Array();
	for($i=0;$i < $adb->num_rows($result);$i++)
	{
		$fieldname = $adb->query_result($result,$i,"fieldname");
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		$columnname = $adb->query_result($result,$i,"columnname");
		$tabid = $adb->query_result($result,$i,"tabid");
		$uitype = $adb->query_result($result,$i,"uitype");

		$keyvalue = $columnname;
		$fieldvalues = Array();
		if (count($roleids) > 1)
		{
			$mulsel="select distinct $fieldname from vtiger_$fieldname inner join vtiger_role2picklist on vtiger_role2picklist.picklistvalueid = vtiger_$fieldname.picklist_valueid where roleid in (\"". implode($roleids,"\",\"") ."\") and picklistid in (select picklistid from vtiger_$fieldname) order by sortid asc";
		}
		else
		{
			$mulsel="select distinct $fieldname from vtiger_$fieldname inner join vtiger_role2picklist on vtiger_role2picklist.picklistvalueid = vtiger_$fieldname.picklist_valueid where roleid ='".$roleid."' and picklistid in (select picklistid from vtiger_$fieldname) order by sortid asc";
		}
		if($fieldname != 'firstname')
			$mulselresult = $adb->query($mulsel);
		for($j=0;$j < $adb->num_rows($mulselresult);$j++)
		{
			$fieldvalues[] = $adb->query_result($mulselresult,$j,$fieldname);
		}
		$field_count = count($fieldvalues);
		if($uitype == 15 && $field_count > 0 && ($fieldname == 'taskstatus' || $fieldname == 'eventstatus'))
		{
			$temp_count =count($temp_status[$keyvalue]);
			if($temp_count > 0)
			{
				for($t=0;$t < $field_count;$t++)
				{
					$temp_status[$keyvalue][($temp_count+$t)] = $fieldvalues[$t];
				}
				$fieldvalues = $temp_status[$keyvalue];
			}
			else
				$temp_status[$keyvalue] = $fieldvalues;
		}
		if($uitype == 33)
			$fieldlists[1][$keyvalue] = $fieldvalues;
		else if($uitype == 55 && $fieldname == 'salutationtype')
			$fieldlists[$keyvalue] = $fieldvalues;
		else if($uitype == 15)
			$fieldlists[$keyvalue] = $fieldvalues;
	}
	$log->debug("Exit from function getAccessPickListValues($module)");

	return $fieldlists;
}

function get_config_status() {
	global $default_charset;
	if(strtolower($default_charset) == 'utf-8')	
		$config_status=1;
	else
		$config_status=0;
	return $config_status;
}

function getMigrationCharsetFlag() {
	global $adb;
	
	if(!$adb->isPostgres())
		$db_status=check_db_utf8_support($adb);
	$config_status=get_config_status();	
	
	if ($db_status == $config_status) {
		if ($db_status == 1) { // Both are UTF-8
			$db_migration_status = MIG_CHARSET_PHP_UTF8_DB_UTF8;
		} else { // Both are Non UTF-8
			$db_migration_status = MIG_CHARSET_PHP_NONUTF8_DB_NONUTF8;		
		}
		} else {
			if ($db_status == 1) { // Database charset is UTF-8 and CRM charset is Non UTF-8
				$db_migration_status = MIG_CHARSET_PHP_NONUTF8_DB_UTF8;
		} else { // Database charset is Non UTF-8 and CRM charset is UTF-8
			$db_migration_status = MIG_CHARSET_PHP_UTF8_DB_NONUTF8;		
		}	
	}
	return $db_migration_status;
}

/************ Function to convert a given time string to Minutes **************/
function ConvertToMinutes($time_string)
{
	$interval = split(' ', $time_string);
	$interval_minutes = intval($interval[0]);
	$interval_string = strtolower($interval[1]);
	if($interval_string == 'hour' || $interval_string == 'hours')
	{
		$interval_minutes = $interval_minutes * 60;
	}
	elseif($interval_string == 'day' || $interval_string == 'days')
	{
		$interval_minutes = $interval_minutes * 1440;
	}		
	return $interval_minutes;
}

//added to find duplicates
/** To get the converted record values which have to be display in duplicates merging tpl*/
function getRecordValues($id_array,$module)
{
	global $adb,$current_user;
	global $app_strings;
	$tabid=getTabid($module);	
	$query="select fieldname,fieldlabel from vtiger_field where tabid=".$tabid." and fieldname  not in ('createdtime','modifiedtime') and vtiger_field.presence in (0,2) and uitype not in('4')";
	$result=$adb->query($query);
	$no_rows=$adb->num_rows($result);

	for($i=0;$i<$no_rows;$i++)
		{
			$fld_name=$adb->query_result($result,$i,"fieldname");
			if(getFieldVisibilityPermission($module,$current_user->id,$fld_name) == '0')
				$fld_array []= $fld_name;
	
		}
	$js_arr = $fld_array;
	$focus = new $module();
	if(isset($id_array) && $id_array !='') 
	{      
		foreach($id_array as $value)
			{
				$focus->id=$value;
				$focus->retrieve_entity_info($value,$module);
				$field_values[]=$focus->column_fields;
			
			}
	}
	$tabid=getTabid($module);	
	$query="select fieldname,uitype,fieldlabel from vtiger_field where tabid=".$tabid." and fieldname not in ('createdtime','modifiedtime') and vtiger_field.presence in (0,2) and uitype not in('4')" ;

	$result=$adb->query($query);
	$no_rows=$adb->num_rows($result);
	$labl_array=array();
	$value_pair = array();
	$c = 0;
	for($i=0;$i<$no_rows;$i++)
	{
		$fld_name=$adb->query_result($result,$i,"fieldname");
		$fld_label=$adb->query_result($result,$i,"fieldlabel");
		$ui_type=$adb->query_result($result,$i,"uitype");
		
		if(getFieldVisibilityPermission($module,$current_user->id,$fld_name) == '0')
		{
			$record_values[$c][$fld_label] = Array();
			$ui_value[]=$ui_type;
			for($j=0;$j < count($field_values);$j++)
			{
				
				if($ui_type ==56)
				{
					if($field_values[$j][$fld_name] == 0)
						$value_pair['disp_value']=$app_strings['no'];
					else
						$value_pair['disp_value']=$app_strings['yes'];
					
				}
				elseif($ui_type == 51 || $ui_type == 50)
				{
					$entity_id=$field_values[$j][$fld_name];
					if($module !='Products')
						$entity_name=getAccountName($entity_id);
					else
						$entity_name=getProductName($entity_id);
					
					$value_pair['disp_value']=$entity_name;	
				}	
				elseif($ui_type == 53)
				{
					$owner_id=$field_values[$j][$fld_name];
					$ownername=getOwnerName($owner_id);
					$value_pair['disp_value']=$ownername;
				}				
				elseif($ui_type ==57)
				{
					$contact_id= $field_values[$j][$fld_name];		
					if($contact_id != '')
						{
							$contactname=getContactName($contact_id);
						}
						
					$value_pair['disp_value']=$contactname;
				}
				elseif($ui_type == 75 || $ui_type ==81)
				{
					$vendor_id=$field_values[$j][$fld_name];
					if($vendor_id != '')
						{
							$vendor_name=getVendorName($vendor_id);
						}	
					$value_pair['disp_value']=$vendor_name;
				}	
						
				elseif($ui_type == 52)
				{
					$user_id = $field_values[$j][$fld_name];
					$user_name=getUserName($user_id);
					$value_pair['disp_value']=$user_name;

				}
				elseif($ui_type ==68)
				{
					$parent_id = $field_values[$j][$fld_name];
					$value_pair['disp_value'] = getAccountName($parent_id);
					if($value_pair['disp_value'] == '' || $value_pair['disp_value'] == NULL)
						$value_pair['disp_value'] = getContactName($parent_id);
					
				}
				elseif($ui_type ==59)
				{
					$product_name=getProductName($field_values[$j][$fld_name]);
					if($product_name != '')
						$value_pair['disp_value']=$product_name;
					else $value_pair['disp_value']='';
				}
				elseif($ui_type==58)
				{
					$campaign_name=getCampaignName($field_values[$j][$fld_name]);
					if($campaign_name != '')
						$value_pair['disp_value']=$campaign_name;
					else $value_pair['disp_value']='';
				}
				else
					$value_pair['disp_value']=$field_values[$j][$fld_name];
				$value_pair['org_value'] = $field_values[$j][$fld_name];

				array_push($record_values[$c][$fld_label],$value_pair);
			}
			$c++;
		}

	}
	$parent_array[0]=$record_values;
	$parent_array[1]=$js_arr;
	$parent_array[2]=$fld_array;
	return $parent_array;
}

/** Function to check whether the relationship entries are exist or not on elationship tables */
function is_related($relation_table,$crm_field,$related_module_id,$crmid)
{
	global $adb;
	$check_res = $adb->query("select * from $relation_table where $crm_field=$related_module_id and crmid=$crmid");
	$count = $adb->num_rows($check_res);
	if($count > 0)
		return true;
	else
		return false;	
}

/** Function to get a to find duplicates in a particular module*/
function getDuplicateQuery($module,$field_values,$ui_type_arr)
{
	global $current_user;
	$tbl_col_fld = explode(",", $field_values);
	$i=0;
	foreach($tbl_col_fld as $val) {
		list($tbl[$i], $cols[$i], $fields[$i]) = explode(".", $val);
		$tbl_cols[$i] = $tbl[$i]. "." . $cols[$i];
		$i++;
	}
	$table_cols = implode(",",$tbl_cols);
	$sec_parameter = getSecParameterforMerge($module);
	if( stristr($_REQUEST['action'],'ImportStep') || ($_REQUEST['action'] == $_REQUEST['module'].'Ajax' && $_REQUEST['current_action'] == 'ImportSteplast'))
	{	
		if($module == 'Contacts')
		{
			$ret_arr = get_special_on_clause($table_cols);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			$nquery="select vtiger_contactdetails.contactid as recordid,
					vtiger_users_last_import.deleted,$table_cols FROM vtiger_contactdetails
					INNER JOIN vtiger_crmentity
						ON vtiger_crmentity.crmid=vtiger_contactdetails.contactid
					INNER JOIN vtiger_contactaddress
						ON vtiger_contactdetails.contactid = vtiger_contactaddress.contactaddressid
					INNER JOIN vtiger_contactsubdetails
						ON vtiger_contactaddress.contactaddressid = vtiger_contactsubdetails.contactsubscriptionid
					LEFT JOIN vtiger_users_last_import
						ON vtiger_users_last_import.bean_id=vtiger_contactdetails.contactid
					LEFT JOIN vtiger_account
						ON vtiger_account.accountid=vtiger_contactdetails.accountid
					LEFT JOIN vtiger_customerdetails
						ON vtiger_customerdetails.customerid=vtiger_contactdetails.contactid
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
					INNER JOIN (select $select_clause from vtiger_contactdetails t
							INNER JOIN vtiger_crmentity crm
								ON crm.crmid=t.contactid
							INNER JOIN vtiger_contactaddress addr
								ON t.contactid = addr.contactaddressid
							INNER JOIN vtiger_contactsubdetails subd
								ON addr.contactaddressid = subd.contactsubscriptionid
    						LEFT JOIN vtiger_account acc
		                        ON acc.accountid=t.accountid
							LEFT JOIN vtiger_customerdetails custd
						ON custd.customerid=t.contactid
							WHERE crm.deleted=0 group by $select_clause  HAVING COUNT(*)>1) as temp
						ON ".get_on_clause($field_values,$ui_type_arr,$module)."
					WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_contactdetails.contactid ASC";
			
		}

	else if($module == 'Accounts')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];	
			$nquery="SELECT vtiger_account.accountid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_account
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_account.accountid
				INNER JOIN vtiger_accountbillads
					ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid
				INNER JOIN vtiger_accountshipads
					ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid
				LEFT JOIN vtiger_users_last_import
                    ON vtiger_users_last_import.bean_id=vtiger_account.accountid
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_users.id = vtiger_crmentity.smownerid
				INNER JOIN (select $select_clause from vtiger_account t
							INNER JOIN vtiger_crmentity crm
								ON crm.crmid=t.accountid
							INNER JOIN vtiger_accountbillads badd
								ON t.accountid = badd.accountaddressid
							INNER JOIN vtiger_accountshipads sadd
								ON t.accountid = sadd.accountaddressid
							WHERE crm.deleted=0 group by $select_clause HAVING COUNT(*)>1) as temp 
					ON ".get_on_clause($field_values,$ui_type_arr,$module)."
				WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_account.accountid ASC";
				
		}
	else if($module == 'Leads')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			$nquery="select vtiger_leaddetails.leadid as recordid, 
					vtiger_users_last_import.deleted,$table_cols FROM vtiger_leaddetails 
					INNER JOIN vtiger_crmentity 
						ON vtiger_crmentity.crmid=vtiger_leaddetails.leadid 
					INNER JOIN vtiger_leadsubdetails 
						ON vtiger_leadsubdetails.leadsubscriptionid = vtiger_leaddetails.leadid 
					INNER JOIN vtiger_leadaddress 
						ON vtiger_leadaddress.leadaddressid = vtiger_leadsubdetails.leadsubscriptionid 
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users_last_import 
						ON vtiger_users_last_import.bean_id=vtiger_leaddetails.leadid 
					INNER JOIN (select $select_clause from vtiger_leaddetails t 
							INNER JOIN vtiger_crmentity crm 
								ON crm.crmid=t.leadid 
							INNER JOIN vtiger_leadsubdetails subd
								ON subd.leadsubscriptionid = t.leadid 
							INNER JOIN vtiger_leadaddress addr 
								ON addr.leadaddressid = subd.leadsubscriptionid 
							WHERE crm.deleted=0 and t.converted = 0 group by $select_clause HAVING COUNT(*)>1) as temp 
						ON ".get_on_clause($field_values,$ui_type_arr,$module)." 
				WHERE vtiger_crmentity.deleted=0 AND vtiger_leaddetails.converted = 0 $sec_parameter ORDER BY $table_cols,vtiger_leaddetails.leadid ASC";
				
		}	
	else if($module == 'Products')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			
			$nquery="SELECT vtiger_products.productid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_products
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_products.productid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_products.productid
				INNER JOIN (select $select_clause from vtiger_products t
						INNER JOIN vtiger_crmentity crm
						ON crm.crmid=t.productid
						WHERE crm.deleted=0 group by $select_clause HAVING COUNT(*)>1) as temp
					ON ".get_on_clause($field_values,$ui_type_arr,$module)."
				WHERE vtiger_crmentity.deleted=0 ORDER BY $table_cols,vtiger_products.productid ASC";
							
		}	
		else if($module == 'HelpDesk')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			$nquery="SELECT vtiger_troubletickets.ticketid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_troubletickets
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_troubletickets.ticketid
				LEFT JOIN vtiger_account 
					ON vtiger_account.accountid = vtiger_troubletickets.parent_id 
				LEFT JOIN vtiger_contactdetails 
					ON vtiger_contactdetails.contactid = vtiger_troubletickets.parent_id
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_crmentity.smownerid = vtiger_users.id
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_troubletickets.ticketid
				LEFT JOIN vtiger_attachments
					ON vtiger_attachments.attachmentsid=vtiger_crmentity.crmid
				LEFT JOIN vtiger_ticketcomments
					ON vtiger_ticketcomments.ticketid = vtiger_crmentity.crmid
				INNER JOIN (select $select_clause from vtiger_troubletickets t
						INNER JOIN vtiger_crmentity crm
						ON crm.crmid=t.ticketid
						LEFT JOIN vtiger_account acc
							ON acc.accountid = t.parent_id 
						LEFT JOIN vtiger_contactdetails contd
							ON contd.contactid = t.parent_id
						WHERE crm.deleted=0 group by $select_clause HAVING COUNT(*)>1) as temp
					ON ".get_on_clause($field_values,$ui_type_arr,$module)."
				WHERE vtiger_crmentity.deleted=0". $sec_parameter ." ORDER BY $table_cols,vtiger_troubletickets.ticketid ASC";
											
		}
		else if($module == 'Potentials')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			$nquery="SELECT vtiger_potential.potentialid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_potential
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_potential.potentialid
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_users.id = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_potential.potentialid
				INNER JOIN (select $select_clause from vtiger_potential t
						INNER JOIN vtiger_crmentity crm
						ON crm.crmid=t.potentialid
						WHERE crm.deleted=0 group by $select_clause HAVING COUNT(*)>1) as temp
					ON ".get_on_clause($field_values,$ui_type_arr,$module)."
				WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_potential.potentialid ASC";
							
		}	
		else if($module == 'Vendors')
		{
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			$nquery="SELECT vtiger_vendor.vendorid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_vendor
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_vendor.vendorid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_vendor.vendorid
				INNER JOIN (select $select_clause from vtiger_vendor t
						INNER JOIN vtiger_crmentity crm
						ON crm.crmid=t.vendorid
						WHERE crm.deleted=0 group by $select_clause HAVING COUNT(*)>1) as temp
					ON ".get_on_clause($field_values,$ui_type_arr,$module)."
				WHERE vtiger_crmentity.deleted=0 ORDER BY $table_cols,vtiger_vendor.vendorid ASC";
							
		} else {
			$ret_arr = get_special_on_clause($field_values);
			$select_clause = $ret_arr['sel_clause'];
			$on_clause = $ret_arr['on_clause'];
			checkFileAccess("modules/$module/$module.php");
			require_once("modules/$module/$module.php");
			$modObj = new $module();
			if ($modObj != null && method_exists($modObj, 'getDuplicatesQuery')) {
				$nquery = $modObj->getDuplicatesQuery($module,$table_cols,$field_values,$ui_type_arr,$select_clause);
			}
		}		
	}
	else
	{
		
		if($module == 'Contacts')
		{			
			$nquery = "SELECT vtiger_contactdetails.contactid AS recordid,
					vtiger_users_last_import.deleted,".$table_cols."
					FROM vtiger_contactdetails
					INNER JOIN vtiger_crmentity
						ON vtiger_crmentity.crmid=vtiger_contactdetails.contactid
					INNER JOIN vtiger_contactaddress
						ON vtiger_contactdetails.contactid = vtiger_contactaddress.contactaddressid
					INNER JOIN vtiger_contactsubdetails
						ON vtiger_contactaddress.contactaddressid = vtiger_contactsubdetails.contactsubscriptionid
					LEFT JOIN vtiger_users_last_import
						ON vtiger_users_last_import.bean_id=vtiger_contactdetails.contactid
					LEFT JOIN vtiger_account
						ON vtiger_account.accountid=vtiger_contactdetails.accountid
					LEFT JOIN vtiger_customerdetails
						ON vtiger_customerdetails.customerid=vtiger_contactdetails.contactid
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
					INNER JOIN (SELECT $table_cols
							FROM vtiger_contactdetails
							INNER JOIN vtiger_crmentity
								ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
							INNER JOIN vtiger_contactaddress
								ON vtiger_contactdetails.contactid = vtiger_contactaddress.contactaddressid
							INNER JOIN vtiger_contactsubdetails
								ON vtiger_contactaddress.contactaddressid = vtiger_contactsubdetails.contactsubscriptionid
							LEFT JOIN vtiger_account
								ON vtiger_account.accountid=vtiger_contactdetails.accountid
							LEFT JOIN vtiger_customerdetails
								ON vtiger_customerdetails.customerid=vtiger_contactdetails.contactid
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
							WHERE vtiger_crmentity.deleted=0 $sec_parameter
							GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
						ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
	                                WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_contactdetails.contactid ASC";
				
		}
		else if($module == 'Accounts')
		{
			$nquery="SELECT vtiger_account.accountid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_account
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_account.accountid
				INNER JOIN vtiger_accountbillads
					ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid
				INNER JOIN vtiger_accountshipads
					ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_account.accountid
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_users.id = vtiger_crmentity.smownerid
				INNER JOIN (SELECT $table_cols
					FROM vtiger_account
					INNER JOIN vtiger_crmentity
						ON vtiger_crmentity.crmid = vtiger_account.accountid
					INNER JOIN vtiger_accountbillads
					ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid
					INNER JOIN vtiger_accountshipads
						ON vtiger_account.accountid = vtiger_accountshipads.accountaddressid 
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
					WHERE vtiger_crmentity.deleted=0 $sec_parameter
					GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
				ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
                                WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_account.accountid ASC";			
		}
		else if($module == 'Leads')
		{
			$nquery = "SELECT vtiger_leaddetails.leadid AS recordid, vtiger_users_last_import.deleted,
					$table_cols FROM vtiger_leaddetails 
					INNER JOIN vtiger_crmentity 
						ON vtiger_crmentity.crmid=vtiger_leaddetails.leadid 
					INNER JOIN vtiger_leadsubdetails 
						ON vtiger_leadsubdetails.leadsubscriptionid = vtiger_leaddetails.leadid 
					INNER JOIN vtiger_leadaddress 
						ON vtiger_leadaddress.leadaddressid = vtiger_leadsubdetails.leadsubscriptionid 
					LEFT JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users
						ON vtiger_users.id = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users_last_import 
						ON vtiger_users_last_import.bean_id=vtiger_leaddetails.leadid 
					INNER JOIN (SELECT $table_cols 
							FROM vtiger_leaddetails 
							INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_leaddetails.leadid 
							INNER JOIN vtiger_leadsubdetails 
								ON vtiger_leadsubdetails.leadsubscriptionid = vtiger_leaddetails.leadid 
							INNER JOIN vtiger_leadaddress 
								ON vtiger_leadaddress.leadaddressid = vtiger_leadsubdetails.leadsubscriptionid 
							LEFT JOIN vtiger_groups
								ON vtiger_groups.groupid = vtiger_crmentity.smownerid
							LEFT JOIN vtiger_users
								ON vtiger_users.id = vtiger_crmentity.smownerid
							WHERE vtiger_crmentity.deleted=0 AND vtiger_leaddetails.converted = 0 $sec_parameter
							GROUP BY $table_cols HAVING COUNT(*)>1) as temp 
					ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
					WHERE vtiger_crmentity.deleted=0  AND vtiger_leaddetails.converted = 0 $sec_parameter ORDER BY $table_cols,vtiger_leaddetails.leadid ASC";		
						
		}	
		else if($module == 'Products')
		{
			$nquery = "SELECT vtiger_products.productid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_products
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_products.productid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_products.productid
					INNER JOIN (SELECT $table_cols
							FROM vtiger_products
							INNER JOIN vtiger_crmentity
								ON vtiger_crmentity.crmid = vtiger_products.productid WHERE vtiger_crmentity.deleted=0
							GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
				ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
                                WHERE vtiger_crmentity.deleted=0  ORDER BY $table_cols,vtiger_products.productid ASC";
		}	
		else if($module == "HelpDesk")
		{
			$nquery = "SELECT vtiger_troubletickets.ticketid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_troubletickets
				Inner JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_troubletickets.ticketid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_troubletickets.ticketid
				LEFT JOIN vtiger_attachments
					ON vtiger_attachments.attachmentsid=vtiger_crmentity.crmid
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_contactdetails 
					ON vtiger_contactdetails.contactid = vtiger_troubletickets.parent_id
				LEFT JOIN vtiger_ticketcomments
								ON vtiger_ticketcomments.ticketid = vtiger_crmentity.crmid
				INNER JOIN (SELECT $table_cols FROM vtiger_troubletickets
							INNER JOIN vtiger_crmentity
								ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid 
							LEFT JOIN vtiger_attachments
								ON vtiger_attachments.attachmentsid=vtiger_crmentity.crmid
							LEFT JOIN vtiger_contactdetails 
								ON vtiger_contactdetails.contactid = vtiger_troubletickets.parent_id
							LEFT JOIN vtiger_ticketcomments
								ON vtiger_ticketcomments.ticketid = vtiger_crmentity.crmid
							LEFT JOIN vtiger_groups
								ON vtiger_groups.groupid = vtiger_crmentity.smownerid
							LEFT JOIN vtiger_contactdetails contd
								ON contd.contactid = vtiger_troubletickets.parent_id
				WHERE vtiger_crmentity.deleted=0 $sec_parameter
							GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
				ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
                                WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_troubletickets.ticketid ASC";
		}
		else if($module == "Potentials")
		{
			$nquery = "SELECT vtiger_potential.potentialid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_potential
				Inner JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_potential.potentialid
				LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_potential.potentialid
				LEFT JOIN vtiger_groups
					ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_users.id = vtiger_crmentity.smownerid
					INNER JOIN (SELECT $table_cols
							FROM vtiger_potential
							INNER JOIN vtiger_crmentity
								ON vtiger_crmentity.crmid = vtiger_potential.potentialid 
							LEFT JOIN vtiger_groups
								ON vtiger_groups.groupid = vtiger_crmentity.smownerid
							LEFT JOIN vtiger_users
								ON vtiger_users.id = vtiger_crmentity.smownerid	
							WHERE vtiger_crmentity.deleted=0 $sec_parameter
							GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
				ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
                                WHERE vtiger_crmentity.deleted=0 $sec_parameter ORDER BY $table_cols,vtiger_potential.potentialid ASC";
		}
		else if($module == "Vendors")
		{
			$nquery = "SELECT vtiger_vendor.vendorid AS recordid,
				vtiger_users_last_import.deleted,".$table_cols."
				FROM vtiger_vendor
				Inner JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid=vtiger_vendor.vendorid
					LEFT JOIN vtiger_users_last_import
					ON vtiger_users_last_import.bean_id=vtiger_vendor.vendorid
					INNER JOIN (SELECT $table_cols
							FROM vtiger_vendor
							INNER JOIN vtiger_crmentity
								ON vtiger_crmentity.crmid = vtiger_vendor.vendorid WHERE vtiger_crmentity.deleted=0
							GROUP BY ".$table_cols." HAVING COUNT(*)>1) as temp
				ON ".get_on_clause($field_values,$ui_type_arr,$module) ."
                                WHERE vtiger_crmentity.deleted=0  ORDER BY $table_cols,vtiger_vendor.vendorid ASC";
		} else {
			checkFileAccess("modules/$module/$module.php");
			require_once("modules/$module/$module.php");
			$modObj = new $module();
			if ($modObj != null && method_exists($modObj, 'getDuplicatesQuery')) {
				$nquery = $modObj->getDuplicatesQuery($module,$table_cols,$field_values,$ui_type_arr);
			}
		}				
	}
	return $nquery;
}

/** Function to return the duplicate records data as a formatted array */
function getDuplicateRecordsArr($module)
{
	global $adb,$app_strings,$list_max_entries_per_page,$theme;
	$field_values_array=getFieldValues($module);
	$field_values=$field_values_array['fieldnames_list'];
	$fld_arr=$field_values_array['fieldnames_array'];
	$col_arr=$field_values_array['columnnames_array'];
	$fld_labl_arr=$field_values_array['fieldlabels_array'];
	$ui_type=$field_values_array['fieldname_uitype'];

	$dup_query = getDuplicateQuery($module,$field_values,$ui_type);
	// added for page navigation
	$dup_count_query = substr($dup_query, stripos($dup_query,'FROM'),strlen($dup_query));
	$dup_count_query = "SELECT count(*) as count ".$dup_count_query;
	$count_res = $adb->query($dup_count_query);
	$no_of_rows = $adb->query_result($count_res,0,"count");

	if($no_of_rows <= $list_max_entries_per_page)
		$_SESSION['dup_nav_start'.$module] = 1;
	else if(isset($_REQUEST["start"]) && $_REQUEST["start"] != "" && $_SESSION['dup_nav_start'.$module] != $_REQUEST["start"])
		$_SESSION['dup_nav_start'.$module] = $_REQUEST["start"];
	$start = ($_SESSION['dup_nav_start'.$module] != "")?$_SESSION['dup_nav_start'.$module]:1;
	$navigation_array = getNavigationValues($start, $no_of_rows, $list_max_entries_per_page);
	$start_rec = $navigation_array['start'];
	$end_rec = $navigation_array['end_val'];
	$navigationOutput = getTableHeaderNavigation($navigation_array, "",$module,"FindDuplicate","");
	if ($start_rec == 0)
		$limit_start_rec = 0;
	else
		$limit_start_rec = $start_rec -1;
	$dup_query .= " LIMIT $limit_start_rec, $list_max_entries_per_page";
	//ends
	
	$nresult=$adb->query($dup_query);
	$no_rows=$adb->num_rows($nresult);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	require_once($theme_path.'layout_utils.php');	
	if($no_rows == 0)
	{
		if ($_REQUEST['action'] == 'FindDuplicateRecords')
		{
			//echo "<br><br><center>".$app_strings['LBL_NO_DUPLICATE']." <a href='javascript:window.history.back()'>".$app_strings['LBL_GO_BACK'].".</a></center>";
			//die;
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";	
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>
		
				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='" . vtiger_imageurl('empty.jpg', $theme) . "' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_NO_DUPLICATE]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>			   	
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>     </td>
				</tr>
				</tbody></table> 
				</div>";
			echo "</td></tr></table>";
			exit();
		}
		else
		{
			echo "<br><br><table align='center' class='reportCreateBottom big' width='95%'><tr><td align='center'>".$app_strings['LBL_NO_DUPLICATE']."</td></tr></table>";
			die;
		}
	}	

	$rec_cnt = 0;
	$temp = Array();
	$sl_arr = Array();
	$grp = "group0";
	$gcnt = 0;
	$ii = 0; //ii'th record in group 
	while ( $rec_cnt < $no_rows )
	{			
		$result = $adb->fetchByAssoc($nresult);
		//echo '<pre>';print_r($result);echo '</pre>';	
		if($rec_cnt != 0)
		{
			$sl_arr = array_slice($result,2);
			array_walk($temp,'lower_array');
			array_walk($sl_arr,'lower_array');
			$arr_diff = array_diff($temp,$sl_arr);
			if(count($arr_diff) > 0)
			{
				$gcnt++;	
				$temp = $sl_arr;
				$ii = 0;
			}
			$grp = "group".$gcnt;
		}
		$fld_values[$grp][$ii]['recordid'] = $result['recordid'];	
		for($k=0;$k<count($col_arr);$k++)
		{
			if($rec_cnt == 0)
			{
				$temp[$fld_labl_arr[$k]] = $result[$col_arr[$k]];
			}
			if($ui_type[$fld_arr[$k]] == 56)
			{
				if($result[$col_arr[$k]] == 0)
				{
					$result[$col_arr[$k]]=$app_strings['no'];
				}
				else
					$result[$col_arr[$k]]=$app_strings['yes'];
			}
			if($ui_type[$fld_arr[$k]] ==75 || $ui_type[$fld_arr[$k]] ==81)
			{
				$vendor_id=$result[$col_arr[$k]];
				if($vendor_id != '')
					{
						$vendor_name=getVendorName($vendor_id);
					}	
				$result[$col_arr[$k]]=$vendor_name;	
			}
			if($ui_type[$fld_arr[$k]] ==57)
			{
				$contact_id= $result[$col_arr[$k]];
				if($contact_id != '')
				{
					$contactname=getContactName($contact_id);
				}
						
				$result[$col_arr[$k]]=$contactname;
			}	
			if($ui_type[$fld_arr[$k]] ==68)
			{
				$parent_id= $result[$col_arr[$k]];
				if($parent_id != '')
				{
					$parentname=getParentName($parent_id);
				}
						
				$result[$col_arr[$k]]=$parentname;
			}
			if($ui_type[$fld_arr[$k]] ==53 || $ui_type[$fld_arr[$k]] ==52)
			{
				if($result[$col_arr[$k]] != '')
				{
					$owner=getOwnerName($result[$col_arr[$k]]);
				}
				$result[$col_arr[$k]]=$owner;
			}	
			if($ui_type[$fld_arr[$k]] ==50 or $ui_type[$fld_arr[$k]] ==51)
			{
				if($module!='Products') {
					$entity_name=getAccountName($result[$col_arr[$k]]);
				} else {
					$entity_name=getProductName($result[$col_arr[$k]]);
				}
				if($entity_name != '') {
					$result[$col_arr[$k]]=$entity_name;
				} else {
					$result[$col_arr[$k]]='';
				}
			}
			if($ui_type[$fld_arr[$k]] ==58)
			{
				$campaign_name=getCampaignName($result[$col_arr[$k]]);
				if($campaign_name != '')
					$result[$col_arr[$k]]=$campaign_name;
				else $result[$col_arr[$k]]='';
			}
			if($ui_type[$fld_arr[$k]] == 59)
			{
				$product_name=getProductName($result[$col_arr[$k]]);
				if($product_name != '')
					$result[$col_arr[$k]]=$product_name;
				else $result[$col_arr[$k]]='';
			}
			$fld_values[$grp][$ii][$fld_labl_arr[$k]] = $result[$col_arr[$k]];
			
		}
		$fld_values[$grp][$ii]['Entity Type'] = $result['deleted'];
		$ii++;	
		$rec_cnt++;
	}

	$gro="group";
	for($i=0;$i<$no_rows;$i++)
	{
		$ii=0;
		$dis_group[]=$fld_values[$gro.$i][$ii];
		$count_group[$i]=count($fld_values[$gro.$i]);
		$ii++;
		$new_group[]=$dis_group[$i];
	}
	$fld_nam=$new_group[0];
	$ret_arr[0]=$fld_values;
	$ret_arr[1]=$fld_nam;
	$ret_arr[2]=$ui_type;
	$ret_arr["navigation"]=$navigationOutput;
	return $ret_arr;
}

/** Function to get on clause criteria for sub tables like address tables to construct duplicate check query */
function get_special_on_clause($field_list)
{
	$field_array = explode(",",$field_list);
	$ret_str = '';
	$sel_clause = '';
	$i=1;
	$cnt = count($field_array);
	$spl_chk = ($_REQUEST['modulename'] != '')?$_REQUEST['modulename']:$_REQUEST['module'];
	foreach($field_array as $fld)
	{
		$sub_arr = explode(".",$fld);
		$tbl_name = $sub_arr[0];
		$col_name = $sub_arr[1];
		$fld_name = $sub_arr[2];
		
		//need to handle aditional conditions with sub tables for further modules of duplicate check
		if($tbl_name == 'vtiger_leadsubdetails' || $tbl_name == 'vtiger_contactsubdetails')
			$tbl_alias = "subd";
		else if($tbl_name == 'vtiger_leadaddress' || $tbl_name == 'vtiger_contactaddress')
			$tbl_alias = "addr";
		else if($tbl_name == 'vtiger_account' && $spl_chk == 'Contacts')
			$tbl_alias = "acc";
		else if($tbl_name == 'vtiger_accountbillads')
			$tbl_alias = "badd";
		else if($tbl_name == 'vtiger_accountshipads')
			$tbl_alias = "sadd";
		else if($tbl_name == 'vtiger_crmentity')
			$tbl_alias = "crm";
		else if($tbl_name == 'vtiger_customerdetails')
			$tbl_alias = "custd";
		else if($tbl_name == 'vtiger_contactdetails' && spl_chk == 'HelpDesk')
			$tbl_alias = "contd";
		else 
			$tbl_alias = "t";
			
		$sel_clause .= $tbl_alias.".".$col_name.",";	
		$ret_str .= " $tbl_name.$col_name = $tbl_alias.$col_name";
		if ($cnt != $i) $ret_str .= " and ";
		$i++;
	}
	$ret_arr['on_clause'] = $ret_str;
	$ret_arr['sel_clause'] = trim($sel_clause,",");
	return $ret_arr;
}

/** Function to get on clause criteria for duplicate check queries */
function get_on_clause($field_list,$uitype_arr,$module)
{
	$field_array = explode(",",$field_list);
	$ret_str = '';
	$i=1;
	foreach($field_array as $fld)
	{
		$sub_arr = explode(".",$fld);
		$tbl_name = $sub_arr[0];
		$col_name = $sub_arr[1];
		$fld_name = $sub_arr[2];

		$ret_str .= " ifnull($tbl_name.$col_name,'null') = ifnull(temp.$col_name,'null')";
		
		if (count($field_array) != $i) $ret_str .= " and ";
		$i++;
	}
	return $ret_str;
}

/** call back function to change the array values in to lower case */
function lower_array(&$string){
	    $string = strtolower(trim($string));
}

/** Function to get recordids for subquery where condition */
// TODO - Need to check if this method is used anywhere? 
function get_subquery_recordids($sub_query)
{
	global $adb;
	//need to update this module whenever duplicate check tool added for new modules
	$module_id_array = Array("Accounts"=>"accountid","Contacts"=>"contactid","Leads"=>"leadid","Products"=>"productid","HelpDesk"=>"ticketid","Potentials"=>"potentialid","Vendors"=>"vendorid");
	$id = ($module_id_array[$_REQUEST['modulename']] != '')?$module_id_array[$_REQUEST['modulename']]:$module_id_array[$_REQUEST['module']]; 
	$sub_res = '';
	$sub_result = $adb->query($sub_query);
	$row_count = $adb->num_rows($sub_result);
	$sub_res = '';
	if($row_count > 0)
	{
		while($rows = $adb->fetchByAssoc($sub_result))
		{
			$sub_res .= $rows[$id].",";
		}
		$sub_res = trim($sub_res,",");
	}
	else
		$sub_res .= "''";
	return $sub_res;
}

/** Function to get tablename, columnname, fieldname, fieldlabel and uitypes of fields of merge criteria for a particular module*/
function getFieldValues($module)
{
	global $adb,$current_user;

	//In future if we want to change a id mapping to name or other string then we can add that elements in this array.
	//$fld_table_arr = Array("vtiger_contactdetails.account_id"=>"vtiger_account.accountname");
	//$special_fld_arr = Array("account_id"=>"accountname");
	$fld_table_arr = Array();
	$special_fld_arr = Array();
	$tabid=getTabid($module);
	$sql="select distinct(userid) from vtiger_user2mergefields where tabid=?";
	$sql_result=$adb->pquery($sql,array($tabid));
	$num_rows=$adb->num_rows($sql_result);
	for($i=0; $i<$num_rows;$i++)
	{
		if($adb->query_result($sql_result,$i,"userid") == $current_user->id)
		{
			$user_id=$current_user->id;
			break;
		}
		$user_id=0;
	}
	$query="select fieldid from vtiger_user2mergefields where tabid=? and userid=? and visible=?";
	$result= $adb->pquery($query,array($tabid,$user_id,1));
	$num_rows=$adb->num_rows($result);
	for($i=0; $i<$num_rows;$i++)
	{
		$field_id = $adb->query_result($result,$i,"fieldid");
		$res_val.=$field_id.",";
				
	}
	$res_val=rtrim($res_val,",");
	if($res_val != "")
	{
		$fieldname_query="select fieldname,fieldlabel,uitype,tablename,columnname from vtiger_field where fieldid in (".$res_val.") and vtiger_field.presence in (0,2)";
		$fieldname_result = $adb->query($fieldname_query);
		$field_num_rows = $adb->num_rows($fieldname_result);
	}
	$fld_arr = array();
	$col_arr = array();
	for($j=0;$j< $field_num_rows;$j ++)
	{
		$tablename = $adb->query_result($fieldname_result,$j,'tablename');
		$column_name = $adb->query_result($fieldname_result,$j,'columnname');
		$field_name = $adb->query_result($fieldname_result,$j,'fieldname');
		$field_lbl = $adb->query_result($fieldname_result,$j,'fieldlabel');
		$ui_type = $adb->query_result($fieldname_result,$j,'uitype');
		$table_col = $tablename.".".$column_name;
		if(getFieldVisibilityPermission($module,$current_user->id,$field_name) == 0)
		{
			$fld_name = ($special_fld_arr[$field_name] != '')?$special_fld_arr[$field_name]:$field_name;			 
			
			$fld_arr[] = $fld_name;
			$col_arr[] = $column_name;
			if($fld_table_arr[$table_col] != '')
				$table_col = $fld_table_arr[$table_col];
			
			$field_values_array['fieldnames_list'][] = $table_col . "." . $fld_name;
			$fld_labl_arr[]=$field_lbl;
			$uitype[$field_name]=$ui_type;
		}
	}
	$field_values_array['fieldnames_list']=implode(",",$field_values_array['fieldnames_list']);
	$field_values=implode(",",$fld_arr);
	$field_values_array['fieldnames']=$field_values;
	$field_values_array["fieldnames_array"]=$fld_arr;
	$field_values_array["columnnames_array"]=$col_arr;
	$field_values_array['fieldlabels_array']=$fld_labl_arr;
	$field_values_array['fieldname_uitype']=$uitype;

	//echo "<pre>";print_r($field_values_array);echo "</pre>";
	return $field_values_array;	
}

/** To get security parameter for a particular module -- By Pavani*/
function getSecParameterforMerge($module)
{
	global $current_user;
	$tab_id = getTabid($module);
	$sec_parameter="";
	require('user_privileges/user_privileges_'.$current_user->id.'.php');
	////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
	if($is_admin == false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[$tab_id] == 3)
	{
		if($module == "Products" || $module == "Vendors") {
			$sec_parameter = "";
		} else {
			$sec_parameter=getListViewSecurityParameter($module);
			if($module == "Accounts") {
				$sec_parameter .= " AND (vtiger_crmentity.smownerid IN (".$current_user->id.")
						OR vtiger_crmentity.smownerid IN (
					 	SELECT vtiger_user2role.userid
					 	FROM vtiger_user2role
					 	INNER JOIN vtiger_users
						ON vtiger_users.id = vtiger_user2role.userid
						INNER JOIN vtiger_role
						ON vtiger_role.roleid = vtiger_user2role.roleid
					 	WHERE vtiger_role.parentrole LIKE '".$current_user_parent_role_seq."::%')
						OR vtiger_crmentity.smownerid IN (
						SELECT shareduserid
						FROM vtiger_tmp_read_user_sharing_per
						WHERE userid=".$current_user->id."
						AND tabid=".$tab_id.")
						OR (vtiger_crmentity.smownerid in (0)
						AND (";

				if(sizeof($current_user_groups) > 0) {
					$sec_parameter .= " vtiger_groups.groupname IN (
									SELECT groupname
									FROM vtiger_groups
									WHERE groupid IN (". implode(",", getCurrentUserGroupList()) ."))
									OR ";
				}
				$sec_parameter .= " vtiger_groups.groupname IN (
				 	SELECT vtiger_groups.groupname
					FROM vtiger_tmp_read_group_sharing_per
					INNER JOIN vtiger_groups
						ON vtiger_groups.groupid = vtiger_tmp_read_group_sharing_per.sharedgroupid
					WHERE userid=".$current_user->id."
					AND tabid=".$tab_id.")))) ";
			}
		}
	}	
	return $sec_parameter;
}

// Update all the data refering to currency $old_cur to $new_cur
function transferCurrency($old_cur, $new_cur) {
		
	// Transfer User currency to new currency
	transferUserCurrency($old_cur, $new_cur);
	
	// Transfer Product Currency to new currency
	transferProductCurrency($old_cur, $new_cur);
	
	// Transfer PriceBook Currency to new currency
	transferPriceBookCurrency($old_cur, $new_cur);
}

// Function to transfer the users with currency $old_cur to $new_cur as currency
function transferUserCurrency($old_cur, $new_cur) {
	global $log, $adb, $current_user;
	$log->debug("Entering function transferUserCurrency...");
	
	$sql = "update vtiger_users set currency_id=? where currency_id=?";
	$adb->pquery($sql, array($new_cur, $old_cur));
	
	$current_user->retrieve_entity_info($current_user->id,"Users");
	$log->debug("Exiting function transferUserCurrency...");	
}

// Function to transfer the products with currency $old_cur to $new_cur as currency
function transferProductCurrency($old_cur, $new_cur) {
	global $log, $adb;
	$log->debug("Entering function updateProductCurrency...");
	$prod_res = $adb->pquery("select productid from vtiger_products where currency_id = ?", array($old_cur));
	$numRows = $adb->num_rows($prod_res);
	$prod_ids = array();
	for($i=0;$i<$numRows;$i++) {
		$prod_ids[] = $adb->query_result($prod_res,$i,'productid');
	}
	if(count($prod_ids) > 0) {
		$prod_price_list = getPricesForProducts($new_cur,$prod_ids);
	
		for($i=0;$i<count($prod_ids);$i++) {
			$product_id = $prod_ids[$i];
			$unit_price = $prod_price_list[$product_id];
			$query = "update vtiger_products set currency_id=?, unit_price=? where productid=?";
			$params = array($new_cur, $unit_price, $product_id);
			$adb->pquery($query, $params);
		}	
	}
	$log->debug("Exiting function updateProductCurrency...");
}

// Function to transfer the pricebooks with currency $old_cur to $new_cur as currency 
// and to update the associated products with list price in $new_cur currency
function transferPriceBookCurrency($old_cur, $new_cur) {
	global $log, $adb;
	$log->debug("Entering function updatePriceBookCurrency...");
	$pb_res = $adb->pquery("select pricebookid from vtiger_pricebook where currency_id = ?", array($old_cur));
	$numRows = $adb->num_rows($pb_res);
	$pb_ids = array();
	for($i=0;$i<$numRows;$i++) {
		$pb_ids[] = $adb->query_result($pb_res,$i,'pricebookid');
	}
	
	if(count($pb_ids) > 0) {	
		require_once('modules/PriceBooks/PriceBooks.php');
		
		for($i=0;$i<count($pb_ids);$i++) {
			$pb_id = $pb_ids[$i];
			$focus = new PriceBooks();
			$focus->id = $pb_id;
			$focus->mode = 'edit';
			$focus->retrieve_entity_info($pb_id, "PriceBooks");
			$focus->column_fields['currency_id'] = $new_cur;
			$focus->save("PriceBooks");
		}	
	}
	
	$log->debug("Exiting function updatePriceBookCurrency...");
}

//functions for asterisk integration start
/**
 * this function returns the caller name based on the phone number that is passed to it
 * @param $from - the number which is calling
 * returns caller information in name(type) format :: for e.g. Mary Smith (Contact)
 * if no information is present in database, it returns :: Unknown Caller (Unknown)
 */
function getCallerName($from) {
	global $adb;

	//information found
	$callerInfo = getCallerInfo(getStrippedNumber($from));

	if($callerInfo != false){
		$callerName = $callerInfo[name];
		$module = $callerInfo[module];
		$callerModule = " (<a href='index.php?module=$module&action=index'>$module</a>)";
		$callerID = $callerInfo[id];
		
		$caller = "<a href='index.php?module=$module&action=DetailView&record=$callerID'>$callerName</a>$callerModule";
	}else{
		$caller = $caller."<br>
						<a target='_blank' href='index.php?module=Leads&action=EditView&phone=$from'>Create Lead</a><br>
						<a target='_blank' href='index.php?module=Contacts&action=EditView&phone=$from'>Create Contact</a><br>
						<a target='_blank' href='index.php?module=Accounts&action=EditView&phone=$from'>Create Account</a>";
	}
	return $caller;
}

/**
 * this function searches for a given number in vtiger and returns the callerInfo in an array format
 * currently the search is made across only leads, accounts and contacts modules
 * 
 * @param $number - the number whose information you want
 * @return array in format array(name=>callername, module=>module, id=>id);
 */
function getCallerInfo($number){
	global $adb, $log;
	$caller = "Unknown Number (Unknown)"; //declare caller as unknown in beginning
	
	$name['Contacts'] = array('name'=>"concat(firstname,' ',lastname)", 'table'=>'vtiger_contactdetails', 'field'=>"phone,mobile,fax", 'id'=>'contactid');
	$name['Accounts'] = array('name'=>"accountname", 'table'=>"vtiger_account", 'field'=>"phone, otherphone, fax", 'id'=>'accountid');
	$name['Leads'] = array('name'=>"concat(firstname,' ',lastname)", 'table'=>"vtiger_leaddetails inner join vtiger_leadaddress on vtiger_leaddetails.leadid = vtiger_leadaddress.leadaddressid", 'field'=>"phone,mobile,fax", 'id'=>'leadid'); 
	
	foreach ($name as $module => $info) {
		$phones = explode(",",$info[field]);
		
		$sql = "select *,".$info[name]." as name from ".$info[table]." inner join vtiger_crmentity on ".$info['id']."=crmid where deleted=0";
		$result = $adb->query($sql);
		
		$id = searchPhoneNumber($number, $phones, $result, 1);

		if($id){
			$callerName = $adb->query_result($result, $id, "name");
			$callerID = $adb->query_result($result,$id,$info['id']);
			$data = array("name"=>$callerName, "module"=>$module, "id"=>$callerID);
			return $data;			
		}
	}
	return false;
}

/**
 * this function searches the given record in the result for the given fields
 * @param integer $record - the value to search
 * @param array $fields - the fields to search
 * @param object $result - the adodb result set in which to search
 * @param integer $flag - if on, it removes the non-integers from the fields before comparison - 1 to set
 */
function searchPhoneNumber($record, $fields, $result, $flag=0){
	global $adb;
	$count = $adb->num_rows($result);

	for($i=0;$i<$count;$i++){
		foreach($fields as $field){
			$number = $adb->query_result($result, $i, $field);
			if($flag == 1){
				$number = getStrippedNumber($number);
			}
			if($number == $record){
				return $i;			
			}
		}
	}
	return false;
}

/**
 * this function removes any pre-codes like SIP:, PSTN:, etc added to a number
 * it also removes any braces or spaces present in a number
 * @param string $number - the number to be processed
 */
function getStrippedNumber($number){
	$number = preg_replace("/[^\d]/i","",$number);
	return $number;
}

/**
 * this function returns the tablename and primarykeys for a given module in array format
 * @param object $adb - peardatabase type object
 * @param string $module - module name for  which you want the array
 * @return array(tablename1=>primarykey1,.....)
 */
function get_tab_name_index($adb, $module){
	$tabid = getTabid($module);
	$sql = "select * from vtiger_tab_name_index where tabid = ?";
	$result = $adb->pquery($sql, array($tabid));
	$count = $adb->num_rows($result);
	$data = array();
	
	for($i=0; $i<$count; $i++){
		$tablename = $adb->query_result($result, $i, "tablename");
		$primaryKey = $adb->query_result($result, $i, "primarykey");
		$data[$tablename] = $primaryKey;
	}
	return $data;
}

/**
 * this function returns the value of use_asterisk from the database for the current user
 * @param string $id - the id of the current user
 */
function get_use_asterisk($id){
	global $adb;
	if(!vtlib_isModuleActive('PBXManager')){
		return false;
	}
	$sql = "select * from vtiger_asteriskextensions where userid = ?";
	$result = $adb->pquery($sql, array($id));
	if($adb->num_rows($result)>0){
		$use_asterisk = $adb->query_result($result, 0, "use_asterisk");
		$asterisk_extension = $adb->query_result($result, 0, "asterisk_extension");
		if($use_asterisk == 0 || empty($asterisk_extension)){
			return 'false';
		}else{
			return 'true';
		}
	}else{
		return 'false';
	}
}

/**
 * this function adds a record to the callhistory module
 * 
 * @param string $userExtension - the extension of the current user
 * @param string $callfrom - the caller number
 * @param string $callto - the called number
 * @param string $status - the status of the call (outgoing/incoming/missed)
 * @param object $adb - the peardatabase object
 */
function addToCallHistory($userExtension, $callfrom, $callto, $status, $adb){
	$sql = "select * from vtiger_asteriskextensions where asterisk_extension=".$userExtension;
	$result = $adb->pquery($sql,array());
	$userID = $adb->query_result($result, 0, "userid");
	
	$crmID = $adb->getUniqueID('vtiger_crmentity');
	$timeOfCall = date('Y-m-d H:i:s');
	
	$sql = "insert into vtiger_crmentity values (?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$params = array($crmID, $userID, $userID, 0, "PBXManager", "", $timeOfCall, $timeOfCall, NULL, NULL, 0, 1, 0);
	$adb->pquery($sql, $params);
	
	if(empty($callfrom)){
		$callfrom = "Unknown";
	}
	if(empty($callto)){
		$callto = "Unknown";
	}
	
	if($status == 'outgoing'){
		//call is from user to record
		$sql = "select * from vtiger_asteriskextensions where asterisk_extension=$callfrom";
		$result = $adb->query($sql);
		if($adb->num_rows($result)>0){
			$userid = $adb->query_result($result, 0, "userid");
			$callerName = getUserFullName($userid);
		}
		
		$receiver = getCallerInfo($callto);
		if($receiver == false){
			$receiver = getCallerInfo(getStrippedNumber($callto));
		}
		if(empty($receiver)){
			$receiver = "Unknown";
		}else{
			$receiver = "<a href='index.php?module=".$receiver[module]."&action=DetailView&record=".$receiver[id]."'>".$receiver[name]."</a>";
		}
	}else{
		//call is from record to user
		$sql = "select * from vtiger_asteriskextensions where asterisk_extension=$callto";
		$result = $adb->query($sql);
		if($adb->num_rows($result)>0){
			$userid = $adb->query_result($result, 0, "userid");
			$receiver = getUserFullName($userid);
		}
		$callerName = getCallerInfo($callfrom);
		if($callerName == false){
			$callerName = getCallerInfo(getStrippedNumber($callfrom));
		}
		if(empty($callerName)){
			$callerName = "Unknown";
		}else{
			$callerName = "<a href='index.php?module=".$callerName[module]."&action=DetailView&record=".$callerName[id].">'".$callerName[name]."</a>";
		}
	}
	
	$sql = "insert into vtiger_pbxmanager values (?,?,?,?,?)";
	$params = array($crmID, $callerName, $receiver, $timeOfCall, $status);
	$adb->pquery($sql, $params);
}
//functions for asterisk integration end

//functions for settings page
/**
 * this function returns the blocks for the settings page
 */
function getSettingsBlocks(){
	global $adb;
	$sql = "select * from vtiger_settings_blocks where blockid!=3 order by sequence";
	$result = $adb->query($sql);
	$count = $adb->num_rows($result);
	$blocks = array();
	
	if($count>0){
		for($i=0;$i<$count;$i++){
			$blockid = $adb->query_result($result, $i, "blockid");
			$label = $adb->query_result($result, $i, "label");
			$blocks[$blockid] = $label;
		}
	}
	return $blocks;
}

/**
 * this function returns the fields for the settings page
 */
function getSettingsFields(){
	global $adb;
	$sql = "select * from vtiger_settings_field where blockid!=".getSettingsBlockId('LBL_MODULE_MANAGER')." and fieldid not in(5,6,8,9,18,27,28) order by blockid,sequence";
	$result = $adb->query($sql);
	$count = $adb->num_rows($result);
	$fields = array();
	
	if($count>0){
		for($i=0;$i<$count;$i++){
			$blockid = $adb->query_result($result, $i, "blockid");
			$iconpath = $adb->query_result($result, $i, "iconpath");
			$description = $adb->query_result($result, $i, "description");
			$linkto = $adb->query_result($result, $i, "linkto");
			$action = getPropertiesFromURL($linkto, "action");
			$module = getPropertiesFromURL($linkto, "module");
			$name = $adb->query_result($result, $i, "name");
	
			$fields[$blockid][] = array("icon"=>$iconpath, "description"=>$description, "link"=>$linkto, "name"=>$name, "action"=>$action, "module"=>$module);
		}
		
		//add blanks for 4-column layout
		foreach($fields as $blockid=>&$field){
			if(count($field)>0 && count($field)<4){
				for($i=count($field);$i<4;$i++){
					$field[$i] = array(); 
				}
			}
		}
	}
	return $fields;
}

/**
 * this function takes an url and returns the module name from it
 */
function getPropertiesFromURL($url, $action){
	$result = array();
	preg_match("/$action=([^&]+)/",$url,$result);
	return $result[1];
}

//functions for settings page end

/* Function to get the name of the Field which is used for Module Specific Sequence Numbering, if any 
 * @param module String - Module label
 * return Array - Field name and label are returned */
function getModuleSequenceField($module) {
	global $adb, $log;
	$log->debug("Entering function getModuleSequenceFieldName ($module)...");
	$field = null;
	
	if (!empty($module)) {
		//uitype 4 points to Module Numbering Field
		$seqColRes = $adb->pquery("SELECT fieldname, fieldlabel, columnname FROM vtiger_field WHERE uitype=? AND tabid=? and vtiger_field.presence in (0,2)", array('4', getTabid($module)));
		if($adb->num_rows($seqColRes) > 0) {
			$fieldname = $adb->query_result($seqColRes,0,'fieldname');
			$columnname = $adb->query_result($seqColRes,0,'columnname');
			$fieldlabel = $adb->query_result($seqColRes,0,'fieldlabel');
			$field['name'] = $fieldname;
			$field['column'] = $columnname;
			$field['label'] = $fieldlabel;
		}
	}
	
	$log->debug("Exiting getModuleSequenceFieldName...");
	return $field;
}

/* Function to get the Result of all the field ids allowed for Duplicates merging for specified tab/module (tabid) */
function getFieldsResultForMerge($tabid) {
	global $log, $adb;
	$log->debug("Entering getFieldsResultForMerge(".$tabid.") method ...");
	
	$nonmergable_tabids = array(29);
	
	if (in_array($tabid, $nonmergable_tabids)) {
		return null;
	}
	
	// List of Fields not allowed for Duplicates Merging based on the module (tabid) [tabid to fields mapping]
	$nonmergable_field_tab = Array(
		4 => array('portal','imagename'),
		13 => array('update_log','filename','comments'),
	);
	
	$nonmergable_displaytypes = Array(4);
	$nonmergable_uitypes = Array('70','69','4');
	
	$sql = "SELECT fieldid,typeofdata FROM vtiger_field WHERE tabid = ? and vtiger_field.presence in (0,2)";
	$params = array($tabid);

	$where = '';
	
	if (isset($nonmergable_field_tab[$tabid]) && count($nonmergable_field_tab[$tabid]) > 0) {
		$where .= " AND fieldname NOT IN (". generateQuestionMarks($nonmergable_field_tab[$tabid]) .")";
		array_push($params, $nonmergable_field_tab[$tabid]);
	}
	
	if (count($nonmergable_displaytypes) > 0) {
		$where .= " AND displaytype NOT IN (". generateQuestionMarks($nonmergable_displaytypes) .")";
		array_push($params, $nonmergable_displaytypes);
	}
	if (count($nonmergable_uitypes) > 0) {
		$where .= " AND uitype NOT IN ( ". generateQuestionMarks($nonmergable_uitypes) .")" ;
		array_push($params, $nonmergable_uitypes);
	}
	
	if (trim($where) != '') {
		$sql .= $where;
	}
	  
	$res = $adb->pquery($sql, $params);
	$log->debug("Exiting getFieldsResultForMerge method ...");
	return $res;
}

/* Function to get the related tables data  
 * @param - $module - Primary module name
 * @param - $secmodule - Secondary module name
 * return Array $rel_array tables and fields to be compared are sent
 * */
function getRelationTables($module,$secmodule){
	require_once("modules/$module/$module.php");
	$primary_obj = new $module();
	
	require_once("modules/$secmodule/$secmodule.php");
	$secondary_obj = new $secmodule();
	
	if(method_exists($primary_obj,setRelationTables)){
		$reltables = $primary_obj->setRelationTables($secmodule);	
	} else {
		$reltables = '';
	}
	if(is_array($reltables) && !empty($reltables)){
		$rel_array = $reltables;
	} else {
		$rel_array = array("vtiger_crmentityrel"=>array("crmid","relcrmid"),"".$primary_obj->table_name."" => "".$primary_obj->table_index."");
	}
	return $rel_array;
}

/**
 * This function returns no value but handles the delete functionality of each entity.
 * Input Parameter are $module - module name, $return_module - return module name, $focus - module object, $record - entity id, $return_id - return entity id. 
 */
function DeleteEntity($module,$return_module,$focus,$record,$return_id) {
	global $log;	
	$log->debug("Entering DeleteEntity method ($module, $return_module, $record, $return_id)");
	
	if ($module != $return_module && !empty($return_module) && !empty($return_id)) {
		$focus->unlinkRelationship($record, $return_module, $return_id);
	} else {
		$focus->trash($module, $record);
	}
	$log->debug("Exiting DeleteEntity method ...");
}

/* Function to install Vtlib Compliant 
 * @param - $packagename - Name of the module
 * @param - $packagepath - Complete path to the zip file of the Module
 */
function installVtlibModule($packagename, $packagepath, $customized=false) {
	global $log, $adb;
	require_once('vtlib/Vtiger/Package.php');
	require_once('vtlib/Vtiger/Module.php');
	$Vtiger_Utils_Log = true;
	$package = new Vtiger_Package();
	
	$module = $package->getModuleNameFromZip($packagepath);
	$module_exists = false;
	$module_dir_exists = false;
	if($module == null) {
		$log->fatal("$packagename Module zipfile is not valid!");
	} else if(Vtiger_Module::getInstance($module)) {
		$log->fatal("$module already exists!");
		$module_exists = true;
	} 
	if($module_exists == false) {
		$log->debug("$module - Installation starts here");
		$package->import($packagepath, true);
		$moduleInstance = Vtiger_Module::getInstance($module);
		if (empty($moduleInstance)) {
			$log->fatal("$module module installation failed!");
		} else {
			if(file_exists("modules/$packagename/Setup.php")) {
				require_once("modules/$packagename/Setup.php");			
				$setupClass = $module.'Setup';
				if (class_exists($setupClass)) {
					$setupObj = new $setupClass();
					if(method_exists($setupObj, 'postInstall')) {
						$log->debug("SETUP CLASS exists for $module - Method exists postInstall");
						$setupObj->postInstall();
					}
				}
			}
			if (!$customized) {
				$adb->pquery('UPDATE vtiger_tab SET customized=0 WHERE name=?', array($module));
			}
		}
	}	
}

// Function to install Vtlib Compliant - Optional Modules
function installOptionalModules($selected_modules){

	$selected_modules = split(":",$selected_modules);
	if ($handle = opendir('packages/5.1.0/optional')) {	    
	    
	    while (false !== ($file = readdir($handle))) {
	        $filename_arr = explode(".", $file);
	        $packagename = $filename_arr[0];
	        if (!empty($packagename) && in_array($packagename,$selected_modules)) {
	        	$packagepath = "packages/5.1.0/optional/$file";
	        	installVtlibModule($packagename, $packagepath);
	        }
	    }
	    closedir($handle);
	}
}

/**
 * this function checks if a given column exists in a given table or not
 * @param string $columnName - the columnname
 * @param string $tableName - the tablename
 * @return boolean $status - true if column exists; false otherwise
 */
function columnExists($columnName, $tableName){
	global $adb;
	$columnNames = array();
	$columnNames = $adb->getColumnNames($tableName);
	
	if(in_array($columnName, $columnNames)){
		return true;
	}else{
		return false;
	}
}

/* To get modules list for which work flow and field formulas is permitted*/
function com_vtGetModules($adb) {
	$sql="select distinct vtiger_field.tabid, name 
		from vtiger_field 
		inner join vtiger_tab 
			on vtiger_field.tabid=vtiger_tab.tabid 
		where vtiger_field.tabid not in(9,10,16,15,8,29) and vtiger_tab.presence = 0 and vtiger_tab.isentitytype=1";
	$it = new SqlResultIterator($adb, $adb->query($sql));
	$modules = array();
	foreach($it as $row) {
		if(isPermitted($row->name,'index') == "yes") {
			$modules[$row->name] = getTranslatedString($row->name);
		}
	}
	return $modules;
}
/*
function sec_To_Time($seconde)
            {
            if ($seconde<0) 
                       $secondep = (-1)*$seconde;
            else
                       $secondep = $seconde;
            $temp = $secondep % 3600;
            $heures = floor(( $secondep - $temp ) / 3600) ;
            $secondes = floor($temp % 60) ;
            $minutes = floor(( $temp - $heures ) / 60);
            if ($seconde<0)
                       return "-".($heures<10?'0'.$heures:$heures).":".($minutes<10?'0'.$minutes:$minutes).":".($secondes<10?'0'.$secondes:$secondes);
            else
                       return ($heures<10?'0'.$heures:$heures).":".($minutes<10?'0'.$minutes:$minutes).":".($secondes<10?'0'.$secondes:$secondes);
            }
			*/
?>