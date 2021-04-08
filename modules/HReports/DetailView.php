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
 * $Header: /cvs/repository/siprodPCCI/modules/HReports/DetailView.php,v 1.1 2010/01/15 18:44:44 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('data/Tracker.php');
require_once('Smarty_setup.php');
require_once('modules/HReports/HReports.php');
require_once('include/upload_file.php');
require_once('include/utils/utils.php');
global $app_strings;
global $mod_strings;
global $currentModule;

$focus = new HReports();

if(isset($_REQUEST['record'])) {
   $focus->retrieve_entity_info($_REQUEST['record'],"HReports");
   $focus->id = $_REQUEST['record'];
   $focus->name=$focus->column_fields['hreports_title'];
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

//needed when creating a new hreport with default values passed in
if (isset($_REQUEST['contact_name']) && is_null($focus->contact_name)) {
	$focus->contact_name = $_REQUEST['contact_name'];
}
if (isset($_REQUEST['contact_id']) && is_null($focus->contact_id)) {
	$focus->contact_id = $_REQUEST['contact_id'];
}
if (isset($_REQUEST['opportunity_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['opportunity_name'];
}
if (isset($_REQUEST['opportunity_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['opportunity_id'];
}
if (isset($_REQUEST['account_name']) && is_null($focus->parent_name)) {
	$focus->parent_name = $_REQUEST['account_name'];
}
if (isset($_REQUEST['account_id']) && is_null($focus->parent_id)) {
	$focus->parent_id = $_REQUEST['account_id'];
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$log->info("HReport detail view");

$smarty = new vtigerCRM_Smarty;
$dbQuery="select filename,folderid,filelocationtype,filestatus,rapportstatus from vtiger_hreports where hreportsid = ?";
$result=$adb->pquery($dbQuery,array($focus->id));
$filename=$adb->query_result($result,0,'filename');
$folderid=$adb->query_result($result,0,'folderid');
$filestatus=$adb->query_result($result,0,'filestatus');
$filelocationtype=$adb->query_result($result,0,'filelocationtype');
$rapportstatus=$adb->query_result($result,0,'rapportstatus');

$folder = "select foldername from vtiger_rapportsfolder where folderid = ?";
$res = $adb->pquery($folder,array($folderid));
$foldername = $adb->query_result($res,0,'foldername');

$fileattach = "select attachmentsid from vtiger_seattachmentsrel where crmid = ?";
$res = $adb->pquery($fileattach,array($focus->id));
$fileid = $adb->query_result($res,0,'attachmentsid');

//test pour afficher bouton de validation 
/*if($rapportstatus=="Provisoire" || $rapportstatus=="En cours de validation")
{
	$smarty->assign("ISVALIDABLE","true");
}*/
//echo $current_user->user_name;
//echo $focus->id,$current_user->user_name;
if($focus->isValidable($focus->id,$current_user->user_name))
{
	$smarty->assign("ISVALIDABLE","true");
}

//if($filelocationtype == 'I'){
	$pathQuery = $adb->pquery("select path from vtiger_attachments where attachmentsid = ?",array($fileid));
	$filepath = $adb->query_result($pathQuery,0,'path');
/*}
else{
	$filepath = $filename;
}
*/		

$smarty->assign("FILEID",$fileid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$allblocks = getBlocks($currentModule,"detail_view",'',$focus->column_fields);
$smarty->assign("BLOCKS", $allblocks);
$flag = 0;
foreach($allblocks as $blocks)
{
	foreach($blocks as $block_entries)
	{
		if($block_entries['File Name']['value'] != '' || isset($block_entries['File Name']['value']))
			$flag = 1;
	}
}
//echo "id=",$filename," - flag=",$filestatus,"<br>";
if($flag == 1)
	$smarty->assign("FILE_EXIST","yes");
elseif($flag == 0)
	$smarty->assign("FILE_EXIST","no");
	
$smarty->assign("UPDATEINFO",updateInfo($focus->id));

if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");

$smarty->assign("FILENAME", $filename);

if (isset($_REQUEST['return_module'])) $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action'])) $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id'])) $smarty->assign("RETURN_ID", $_REQUEST['return_id']);

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("ID", $focus->id);

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$category = getParentTab();
$smarty->assign("CATEGORY",$category);

$smarty->assign("SINGLE_MOD", 'HReport');

if(isPermitted("HReports","EditView",$_REQUEST['record']) == 'yes' && $rapportstatus!='Archive')
	$smarty->assign("EDIT_DUPLICATE","permitted");

if(isPermitted("HReports","Delete",$_REQUEST['record']) == 'yes' && $rapportstatus!='Archive')
	$smarty->assign("DELETE","permitted");

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$smarty->assign("IS_REL_LIST",isPresentRelatedLists($currentModule));


$tabid = getTabid("HReports");
 $validationData = getDBValidationData($focus->tab_name,$tabid);
 $data = split_validationdataArray($validationData);

 $smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
 $smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
 $smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
 if($current_user->id == 1)
{
 	$smarty->assign("CHECK_INTEGRITY_PERMISSION","yes");
    $smarty->assign("ADMIN","yes");
}
$smarty->assign("FILE_STATUS",$filestatus); 	
 $smarty->assign("DLD_TYPE",$filelocationtype);
 $smarty->assign("NOTESID",$focus->id);
 $smarty->assign("FOLDERID",$folderid);
 $smarty->assign("FOLDERNAME",$foldername);
 $smarty->assign("DLD_PATH",$filepath);

$smarty->assign("MODULE",$currentModule);
$smarty->assign("EDIT_PERMISSION",isPermitted($currentModule,'EditView',$_REQUEST[record]));

if(isset($_SESSION['hreports_listquery'])){
	$arrayTotlist = array();
	$aNamesToList = array(); 
	$forAllCRMIDlist_query=$_SESSION['hreports_listquery'];
	$resultAllCRMIDlist_query=$adb->pquery($forAllCRMIDlist_query,array());
	while($forAllCRMID = $adb->fetch_array($resultAllCRMIDlist_query))
	{
		$arrayTotlist[]=$forAllCRMID['crmid'];
	}
	$_SESSION['listEntyKeymod_'.$focus->id] = $module.":".implode(",",$arrayTotlist);
	if(isset($_SESSION['listEntyKeymod_'.$focus->id]))
	{
		$split_temp=explode(":",$_SESSION['listEntyKeymod_'.$focus->id]);
		if($split_temp[0] == $module)
		{	
			$smarty->assign("SESMODULE",$split_temp[0]);
			$ar_allist=explode(",",$split_temp[1]);
			
			for($listi=0;$listi<count($ar_allist);$listi++)
			{
				if($ar_allist[$listi]==$_REQUEST[record])
				{
					if($listi-1>=0)
					{
						$privrecord=$ar_allist[$listi-1];
						$smarty->assign("privrecord",$privrecord);
					}else {unset($privrecord);}
					if($listi+1<count($ar_allist))
					{
						$nextrecord=$ar_allist[$listi+1];
						$smarty->assign("nextrecord",$nextrecord);
					}else {unset($nextrecord);}
					break;
				}
				
			}
		}
	}
}

// Record Change Notification
$focus->markAsViewed($current_user->id);
// END

$smarty->display("DetailView.tpl");

?>
