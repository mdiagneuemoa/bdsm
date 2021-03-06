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
 * $Header: /cvs/repository/siprodPCCI/modules/Import/lastImport.php,v 1.1 2010/01/15 18:43:30 isene Exp $
 * Description:  TODO: To be written.
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once('data/Tracker.php');
require_once('modules/Import/ImportContact.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/ImportOpportunity.php');
require_once('modules/Import/ImportLead.php');
//Pavani: Import this file to Support Imports for Trouble tickets and vendors
require_once('modules/Import/ImportTicket.php');
require_once('modules/Import/ImportVendors.php');
require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');
require_once('include/ListView/ListView.php');
require_once('modules/Contacts/Contacts.php');
require_once('include/utils/utils.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
$currentModule = "Import";

if (! isset( $_REQUEST['module']))
{
	$_REQUEST['module'] = 'Home';
}

if (! isset( $_REQUEST['return_id']))
{
	$_REQUEST['return_id'] = '';
}
if (! isset( $_REQUEST['return_module']))
{
	$_REQUEST['return_module'] = '';
}

if (! isset( $_REQUEST['return_action']))
{
	$_REQUEST['return_action'] = '';
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$log->info("Import Step last");

$parenttab = getParenttab();
//This Buttons_List1.tpl is is called to display the add, search, import and export buttons ie., second level tabs
$smarty = new vtigerCRM_Smarty;

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMP", $import_mod_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$smarty->assign("MODULE", $_REQUEST['req_mod']);
$smarty->assign("SINGLE_MOD", $_REQUEST['modulename']);
$smarty->assign("CATEGORY", $_SESSION['import_parenttab']);

//@session_unregister("import_parenttab");

//$smarty->display("Buttons_List1.tpl");

global $limit;
global $list_max_entries_per_page;

$implict_account = false;

$import_modules_array = Array(
				"Leads"=>"Leads",
				"Accounts"=>"Accounts",
				"Contacts"=>"Contacts",
				"Potentials"=>"Potentials",
				"Products"=>"Products",
				"HelpDesk"=>"ImportTicket",
                "Vendors"=>"ImportVendors" 
			     );

foreach($import_modules_array as $module_name => $object_name)
{

	$seedUsersLastImport = new UsersLastImport();
	$seedUsersLastImport->bean_type = $module_name;
	$list_query = $seedUsersLastImport->create_list_query($o,$w);
	$current_module_strings = return_module_language($current_language, $module_name);

	$object = new $object_name();
	$seedUsersLastImport->list_fields = $object->list_fields;

	$list_result = $adb->query($list_query);
	//Retreiving the no of rows
	$noofrows = $adb->num_rows($list_result);

	if($noofrows>=1) 
	{
		if($module_name != 'Accounts')
		{
			$implict_account=true;
		}

		if($module_name == 'Accounts' && $implict_account==true)
			$display_header_msg = "Newly created Accounts";
		else
			$display_header_msg = "".$mod_strings['LBL_LAST_IMPORTED']." ".$app_strings[$module_name]."";
		
		//Display the Header Message	
		echo "
			<table width='100%' border='0' cellpadding='5' cellspacing='0'>
			   <tr>
				<td class='dvtCellLabel' align='left'>
					<b>".$mod_strings['LBL_LAST_IMPORTED']." ".$app_strings[$module_name]." </b>
				</td>
			   </tr>
			</table>
		      ";

		$smarty = new vtigerCRM_Smarty;

		$smarty->assign("MOD", $mod_strings);
		$smarty->assign("APP", $app_strings);
		$smarty->assign("IMAGE_PATH",$image_path);
		$smarty->assign("MODULE",$module_name);
		$smarty->assign("SINGLE_MOD",$module_name);
		$smarty->assign("SHOW_MASS_SELECT",'false');

		//Retreiving the start value from request
		if($module_name == $_REQUEST['nav_module'] && isset($_REQUEST['start']) && $_REQUEST['start'] != '')
		{
			$start = $_REQUEST['start'];
		}
		else
		{
			$start = 1;
		}

		$info_message='&recordcount='.$_REQUEST['recordcount'].'&noofrows='.$_REQUEST['noofrows'].'&message='.$_REQUEST['message'].'&skipped_record_count='.$_REQUEST['skipped_record_count'];
		$url_string = '&modulename='.$_REQUEST['modulename'].'&nav_module='.$module_name.$info_message;
		$viewid = '';

		//Retreive the Navigation array
		$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
		$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,"Import","ImportSteplast",$viewid);

		//Retreive the List View Header and Entries
		$listview_header = getListViewHeader($object,$module_name);
		$listview_entries = getListViewEntries($object,$module_name,$list_result,$navigation_array,"","","EditView","Delete","");
		//commented to remove navigation buttons from import list view
		//$smarty->assign("NAVIGATION", $navigationOutput);
		$smarty->assign("HIDE_CUSTOM_LINKS", 1);//Added to hide the CustomView links in imported records ListView
		$smarty->assign("LISTHEADER", $listview_header);
		$smarty->assign("LISTENTITY", $listview_entries);
        
		// Include required scripts   
		echo '<link rel="stylesheet" type="text/css" href="'.$theme_path.'/style.css">';
		echo '<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>';
		echo '<script language="JavaScript" type="text/javascript" src="include/js/' . $_SESSION['authenticated_user_language'] . '.lang.js?' . $_SESSION['vtiger_version'] . '"></script>';
		echo '<script language="JavaScript" type="text/javascript" src="modules/'. $_REQUEST['req_mod'] . '/' . $_REQUEST['req_mod'] . '.js"></script>';
		echo '<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>';
		
		$smarty->display("ListViewEntries.tpl");
	}
}

?>
