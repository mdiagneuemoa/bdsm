<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

require_once('include/database/PearDatabase.php');
require_once('Smarty_setup.php');
require_once('modules/HelpDesk/HelpDesk.php');
require_once('include/utils/utils.php');
require_once('user_privileges/default_module_view.php');

$focus = new HelpDesk();

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) 
{
    $focus->retrieve_entity_info($_REQUEST['record'],"HelpDesk");
    $focus->name=$focus->column_fields['ticket_title'];
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') 
{
        $focus->id = "";
}

//Added code for Error display in sending mail to assigned to user when ticket is created or updated.
if($_REQUEST['mail_error'] != '')
{
    require_once("modules/Emails/mail.php");
	$ticket_owner = getUserName($focus->column_fields['assigned_user_id']);
    $error_msg = strip_tags(parseEmailErrorString($_REQUEST['mail_error']));
	$error_msg = $app_strings['LBL_MAIL_NOT_SENT_TO_USER']. ' ' . $ticket_owner. '. ' .$app_strings['LBL_PLS_CHECK_EMAIL_N_SERVER'];
	echo $mod_strings['LBL_MAIL_SEND_STATUS'].' <b><font class="warning">'.$error_msg.'</font></b>';
}

global $app_strings;
global $mod_strings;
global $currentModule, $singlepane_view;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$focus->id = $_REQUEST['record'];
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");
$smarty->assign("BLOCKS", getBlocks($currentModule,"detail_view",'',$focus->column_fields));
$smarty->assign("TICKETID", $_REQUEST['record']);

$smarty->assign("CUSTOMFIELD", $cust_fld);
$smarty->assign("SINGLE_MOD", 'HelpDesk');
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("UPDATEINFO",updateInfo($_REQUEST['record']));

if(isPermitted("HelpDesk","EditView",$_REQUEST['record']) == 'yes')
	$smarty->assign("EDIT_DUPLICATE","permitted");

if(isPermitted("HelpDesk","Delete",$_REQUEST['record']) == 'yes')
	$smarty->assign("DELETE","permitted");

//Added button for Convert the ticket to FAQ
if(isPermitted("Faq","EditView",'') == 'yes')
	$smarty->assign("CONVERTASFAQ","permitted");
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$smarty->assign("ID", $_REQUEST['record']);
if(isPermitted("HelpDesk","Merge",'') == 'yes')
{
	global $current_user;
        require("user_privileges/user_privileges_".$current_user->id.".php");
        require_once('include/utils/UserInfoUtil.php');
        $wordTemplateResult = fetchWordTemplateList("HelpDesk");
        $tempCount = $adb->num_rows($wordTemplateResult);
        $tempVal = $adb->fetch_array($wordTemplateResult);
        for($templateCount=0;$templateCount<$tempCount;$templateCount++)
        {
                $optionString[$tempVal["templateid"]]=$tempVal["filename"];
                $tempVal = $adb->fetch_array($wordTemplateResult);
        }
	 if($is_admin)
                $smarty->assign("MERGEBUTTON","permitted");
	elseif($tempCount >0)
		$smarty->assign("MERGEBUTTON","permitted");
	 $smarty->assign("TEMPLATECOUNT",$tempCount);
	$smarty->assign("WORDTEMPLATEOPTIONS",$app_strings['LBL_SELECT_TEMPLATE_TO_MAIL_MERGE']);
        $smarty->assign("TOPTIONS",$optionString);
}

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$tabid = getTabid("HelpDesk");
$validationData = getDBValidationData($focus->tab_name,$tabid);
$data = split_validationdataArray($validationData);
$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);

//Added to display the ticket comments information
$smarty->assign("COMMENT_BLOCK",$focus->getCommentInformation($_REQUEST['record']));

$smarty->assign("MODULE",$currentModule);
$smarty->assign("EDIT_PERMISSION",isPermitted($currentModule,'EditView',$_REQUEST[record]));
$smarty->assign("IS_REL_LIST",isPresentRelatedLists($currentModule));
$smarty->assign("TODO_PERMISSION",CheckFieldPermission('parent_id','Calendar'));
$smarty->assign("EVENT_PERMISSION",CheckFieldPermission('parent_id','Events'));
if($singlepane_view == 'true')
{
	$related_array = getRelatedLists($currentModule,$focus);
	$smarty->assign("RELATEDLISTS", $related_array);
}

if(isset($_SESSION['helpdesk_listquery'])){
	$arrayTotlist = array();
	$aNamesToList = array(); 
	$forAllCRMIDlist_query=$_SESSION['helpdesk_listquery'];
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
$smarty->assign("SinglePane_View", $singlepane_view);

// Record Change Notification
$focus->markAsViewed($current_user->id);
// END

$smarty->display("DetailView.tpl");

?>
