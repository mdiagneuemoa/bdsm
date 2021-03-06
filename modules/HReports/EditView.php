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
 * Contributor(s): ______________________________________..
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/HReports/EditView.php,v 1.1 2010/01/15 18:44:43 isene Exp $
 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once('data/Tracker.php');
require_once('modules/HReports/HReports.php');
require_once('include/utils/utils.php');

global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;

$module = $_REQUEST['module'];
$focus = new HReports();
$smarty = new vtigerCRM_Smarty();

//added to fix the issue4600
$searchurl = getBasic_Advance_SearchURL();
$smarty->assign("SEARCH", $searchurl);
//4600 ends

if($_REQUEST['upload_error'] == true)
{
	echo '<br><b><font color="red"> The selected file has no data or a invalid file.</font></b><br>';
}


if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($_REQUEST['record'],"HReports");
    $focus->name=$focus->column_fields['hreports_title'];
}

if($focus->mode != 'edit')
{
	if(isset($_REQUEST['parent_id']) && isset($_REQUEST['return_module']))
	{
		$owner = getRecordOwnerId($_REQUEST['parent_id']);
		if(isset($owner['Users']) && $owner['Users'] != '') {
			$permitted_users = get_user_array('true', 'Active',$current_user->id);
			if(!in_array($owner['Users'],$permitted_users)){
				$owner['Users'] = $current_user->id;
			}
			$focus->column_fields['assigntype'] = 'U';
			$focus->column_fields['assigned_user_id'] = $owner['Users'];
		} elseif(isset($owner['Groups']) && $owner['Groups'] != '') {
			$focus->column_fields['assigntype'] = 'T';
			$focus->column_fields['assigned_user_id'] = $owner['Groups'];
		} 
	}   
} 
			
if(isset($_REQUEST['parent_id']) && $focus->mode != 'edit')
{
        $focus->column_fields['parent_id'] = $_REQUEST['parent_id'];
        $smarty->assign("PARENTID",$_REQUEST['parent_id']);
}

$dbQuery="select filename,folderid from vtiger_hreports where hreportsid = ?";
$result=$adb->pquery($dbQuery,array($focus->id));
$filename=$adb->query_result($result,0,'filename');
$folderid=$adb->query_result($result,0,'folderid');

if(is_null($filename) || $filename == '')
{
	$smarty->assign("FILE_EXIST","no");
}
else 
{
	$smarty->assign("FILE_NAME",$filename);
	$smarty->assign("FILE_EXIST","yes");
}

// le rapport est plac? dans le dossier en param?tre hodar crm 19/08/09
if(isset($_REQUEST['folderid']) && $focus->mode != 'edit')
{
	$folderid=$_REQUEST['folderid'];
}

$folder = "select foldername from vtiger_rapportsfolder where folderid = ?";
$res = $adb->pquery($folder,array($folderid));
$foldername = $adb->query_result($res,0,'foldername');

$smarty->assign("FOLDERID", $folderid);
$smarty->assign("FOLDERNAME", $foldername);

//setting default flag value so due date and time not required
if (!isset($focus->id)) $focus->date_due_flag = 'on';

//needed when creating a new case with default values passed in
if (isset($_REQUEST['contact_name']) && is_null($focus->contact_name)) {
	$focus->contact_name = $_REQUEST['contact_name'];
}
if (isset($_REQUEST['contact_id']) /* && is_null($focus->contact_id) */ ) {
	$focus->contact_id = $_REQUEST['contact_id'];
}
if (isset($_REQUEST['parent_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['parent_name'];
}
if (isset($_REQUEST['parent_id']) /* && is_null($focus->parent_id) */ ) {
	$focus->parent_id = $_REQUEST['parent_id'];
}
if (isset($_REQUEST['parent_type'])) {
	$focus->parent_type = $_REQUEST['parent_type'];
}
elseif (!isset($focus->parent_type)) {
	$focus->parent_type = $app_list_strings['record_type_default_key'];
}

/*if (isset($_REQUEST['filename']) && $_REQUEST['isDuplicate'] != 'true') {
        $focus->filename = $_REQUEST['filename'];
}*/



$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$disp_view = getView($focus->mode);
if($disp_view == 'edit_view')
	$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$mode,$focus->column_fields));
else	
{
	$smarty->assign("BASBLOCKS",getBlocks($currentModule,$disp_view,$mode,$focus->column_fields,'BAS'));
}	
if (isset($_REQUEST['validation']) && $_REQUEST['validation']=='true')
{
	$smarty->assign("MSGVALIDATION", $mod_strings['LBL_VALIDATION']);
}
$smarty->assign("OP_MODE",$disp_view);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);


$log->info("HReport detail view");

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'HReport');
//Display the FCKEditor or not? -- configure $FCKEDITOR_DISPLAY in config.php
if(getFieldVisibilityPermission('HReports',$current_user->id,'hreportcontent') != '0')
        $FCKEDITOR_DISPLAY = false;
$smarty->assign("FCKEDITOR_DISPLAY",$FCKEDITOR_DISPLAY);
	
if (isset($focus->name))
$smarty->assign("NAME", $focus->name);
else
$smarty->assign("NAME", "");

if($focus->mode == 'edit')
{
	$smarty->assign("UPDATEINFO",updateInfo($focus->id));
    $smarty->assign("MODE", $focus->mode);
	// pour validation de rapport
	
}
else
{
	$smarty->assign("MODE",'create');
}

if (isset($_REQUEST['return_module']))
$smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
else
$smarty->assign("RETURN_MODULE","HReports");
if (isset($_REQUEST['return_action']))
$smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
else
$smarty->assign("RETURN_ACTION","index");
if (isset($_REQUEST['return_id']))
$smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if (isset($_REQUEST['email_id']))
$smarty->assign("EMAILID", $_REQUEST['email_id']);
if (isset($_REQUEST['ticket_id'])) $smarty->assign("TICKETID", $_REQUEST['ticket_id']);
if (isset($_REQUEST['fileid']))
$smarty->assign("FILEID", $_REQUEST['fileid']);
if (isset($_REQUEST['record']))
{
         $smarty->assign("CANCELACTION", "DetailView");
}
else
{
         $smarty->assign("CANCELACTION", "index");
}
if (isset($_REQUEST['return_viewname']))
$smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("ID", $focus->id);
$smarty->assign("OLD_ID", $old_id );

if ( empty($focus->filename))
{
        $smarty->assign("FILENAME_TEXT", "");
        $smarty->assign("FILENAME", "");
}
else
{
        $smarty->assign("FILENAME_TEXT", "(".$focus->filename.")");
        $smarty->assign("FILENAME", $focus->filename);
}

if (isset($focus->parent_type) && $focus->parent_type != "") {
        $change_parent_button = "<input title='".$app_strings['LBL_CHANGE_BUTTON_TITLE']."' accessKey='".$app_strings['LBL_CHANGE_BUTTON_KEY']."' vtiger_tabindex='3' type='button' class='button' value='".$app_strings['LBL_CHANGE_BUTTON_LABEL']."' name='button' LANGUAGE=javascript onclick='return window.open(\"index.php?module=\"+ document.EditView.parent_type.value + \"&action=Popup&html=Popup_picker&form=TasksEditView\",\"test\",\"width=600,height=400,resizable=1,scrollbars=1\");'>";
        $smarty->assign("CHANGE_PARENT_BUTTON", $change_parent_button);
}
if ($focus->parent_type == "Account") $smarty->assign("DEFAULT_SEARCH", "&query=true&account_id=$focus->parent_id&account_name=".urlencode($focus->parent_name));

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

$tabid = getTabid("HReports");
$validationData = getDBValidationData($focus->tab_name,$tabid);
$data = split_validationdataArray($validationData);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->assign("DUPLICATE", $_REQUEST['isDuplicate']);
 
global $adb;
// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if($focus->mode != 'edit' && $mod_seq_field != null) {
		$autostr = getTranslatedString('MSG_AUTO_GEN_ON_SAVE');
		$mod_seq_string = $adb->pquery("SELECT prefix, cur_id from vtiger_modentity_num where semodule = ? and active=1",array($currentModule));
        $mod_seq_prefix = $adb->query_result($mod_seq_string,0,'prefix');
        $mod_seq_no = $adb->query_result($mod_seq_string,0,'cur_id');
        if($adb->num_rows($mod_seq_string) == 0 || $focus->checkModuleSeqNumber($focus->table_name, $mod_seq_field['column'], $mod_seq_prefix.$mod_seq_no))
                echo '<br><font color="#FF0000"><b>'. getTranslatedString('LBL_DUPLICATE'). ' '. getTranslatedString($mod_seq_field['label'])
                	.' - '. getTranslatedString('LBL_CLICK') .' <a href="index.php?module=Settings&action=CustomModEntityNo&parenttab=Settings&selmodule='.$currentModule.'">'.getTranslatedString('LBL_HERE').'</a> '
                	. getTranslatedString('LBL_TO_CONFIGURE'). ' '. getTranslatedString($mod_seq_field['label']) .'</b></font>';
        else
                $smarty->assign("MOD_SEQ_ID",$autostr);
}
// END
 

if($focus->mode == 'edit')
	$smarty->display("salesEditView.tpl");
else
	$smarty->display("CreateView.tpl");
?>
