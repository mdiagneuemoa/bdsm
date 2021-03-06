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
 * $Header: /cvs/repository/siprodPCCI/modules/Calendar/EditView.php,v 1.1 2010/01/15 18:43:49 isene Exp $
 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once('data/Tracker.php');
require_once('modules/Calendar/Activity.php');
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
require_once('include/FormValidationUtil.php');
require_once('modules/Calendar/calendarLayout.php'); 
require_once("modules/Emails/mail.php");
include_once 'modules/Calendar/header.php';
global $app_strings;
global $mod_strings,$current_user;
// Unimplemented until jscalendar language vtiger_files are fixed
$focus = new Activity();
$smarty =  new vtigerCRM_Smarty();
//added to fix the issue4600
$searchurl = getBasic_Advance_SearchURL();
$smarty->assign("SEARCH", $searchurl);
//4600 ends

$activity_mode = $_REQUEST['activity_mode'];
if($activity_mode == 'Task')
{
	$tab_type = 'Calendar';
	$taskcheck = true;	
	$smarty->assign("SINGLE_MOD",$mod_strings['LBL_TODO']);
}
elseif($activity_mode == 'Events')
{
	$tab_type = 'Events';
	$taskcheck = false;
	$smarty->assign("SINGLE_MOD",$mod_strings['LBL_EVENT']);
}

if(isset($_REQUEST['record']) && $_REQUEST['record']!='') {
    $focus->id = $_REQUEST['record'];
    $focus->mode = 'edit';
    $focus->retrieve_entity_info($_REQUEST['record'],$tab_type);		
    $focus->name=$focus->column_fields['subject'];
    $sql = 'select vtiger_users.user_name,vtiger_invitees.* from vtiger_invitees left join vtiger_users on vtiger_invitees.inviteeid=vtiger_users.id where activityid=?';
    $result = $adb->pquery($sql, array($focus->id));
    $num_rows=$adb->num_rows($result);
    $invited_users=Array();
    for($i=0;$i<$num_rows;$i++)
    {
	    $userid=$adb->query_result($result,$i,'inviteeid');
	    $username=$adb->query_result($result,$i,'user_name');
	    $invited_users[$userid]=getUserNomPrenom($username);
    }
    $smarty->assign("INVITEDUSERS",$invited_users);
    $smarty->assign("UPDATEINFO",updateInfo($focus->id));
    $related_array = getRelatedLists("Calendar", $focus);
    $cntlist = $related_array['Contacts']['entries'];
	$is_fname_permitted = getFieldVisibilityPermission("Contacts", $current_user->id, 'firstname');
    $cnt_idlist = '';
    $cnt_namelist = '';
    if($cntlist != '')
    {
	    $i = 0;
	    foreach($cntlist as $key=>$cntvalue)
	    {
		    if($i != 0)
		    {
			    $cnt_idlist .= ';';
			    $cnt_namelist .= "\n";
		    }
		    $cnt_idlist .= $key;
		    $contName = eregi_replace("(<a[^>]*>)(.*)(</a>)", "\\2", $cntvalue[0]);
			if ($is_fname_permitted == '0') $contName .= ' '.eregi_replace("(<a[^>]*>)(.*)(</a>)", "\\2", $cntvalue[1]);
		    $cnt_namelist .= '<option value="'.$key.'">'.$contName.'</option>';
		    $i++;
	    }
    }
    $smarty->assign("CONTACTSID",$cnt_idlist);
    $smarty->assign("CONTACTSNAME",$cnt_namelist);
    $query = 'select vtiger_recurringevents.recurringfreq,vtiger_recurringevents.recurringinfo from vtiger_recurringevents where vtiger_recurringevents.activityid = ?';
    $res = $adb->pquery($query, array($focus->id));
    $rows = $adb->num_rows($res);
    if($rows != 0)
    {
	    $value['recurringcheck'] = 'Yes';
	    $value['repeat_frequency'] = $adb->query_result($res,0,'recurringfreq');
	    $recurringinfo =  explode("::",$adb->query_result($res,0,'recurringinfo'));
	    $value['eventrecurringtype'] = $recurringinfo[0];
	    if($recurringinfo[0] == 'Weekly')
	    {
		   for($i=0;$i<6;$i++)
		   {
			   $label = 'week'.$recurringinfo[$i+1];
			   $value[$label] = 'checked';
		   }
	    }
	    elseif($recurringinfo[0] == 'Monthly')
	    {
		    $value['repeatMonth'] = $recurringinfo[1];
		    if($recurringinfo[1] == 'date')
		    {
			    $value['repeatMonth_date'] = $recurringinfo[2];
		    }
		    else
		    {
			    $value['repeatMonth_daytype'] = $recurringinfo[2];
			    $value['repeatMonth_day'] = $recurringinfo[3];
		    }
	    }
    }
    else
    {
	    $value['recurringcheck'] = 'No';
    }

}else
{
	if(isset($_REQUEST['contact_id']) && $_REQUEST['contact_id']!=''){
		$smarty->assign("CONTACTSID",$_REQUEST['contact_id']);
		$contact_name = "<option value=".$_REQUEST['contact_id'].">".getContactName($_REQUEST['contact_id'])."</option>";
		$smarty->assign("CONTACTSNAME",$contact_name);
		$account_id = $_REQUEST['account_id'];
                $account_name = getAccountName($account_id);
	}	
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
    	$focus->mode = ''; 	
}
$userDetails=getOtherUserName($current_user->id);
$to_email = getUserEmailId('id',$current_user->id);
$smarty->assign("CURRENTUSERID",$current_user->id);

$disp_view = getView($focus->mode);
if($disp_view == 'edit_view')
{
	$act_data = getBlocks($tab_type,$disp_view,$mode,$focus->column_fields);
}
else	
{
	$act_data = getBlocks($tab_type,$disp_view,$mode,$focus->column_fields,'BAS');
}
$smarty->assign("BLOCKS",$act_data);
foreach($act_data as $header=>$blockitem)
{
	foreach($blockitem as $row=>$data)
	{
		foreach($data as $key=>$maindata)
		{
			$uitype[$maindata[2][0]] = $maindata[0][0];
			
			$fldlabel[$maindata[2][0]] = $maindata[1][0];
			$fldlabel_sel[$maindata[2][0]] = $maindata[1][1];
			$fldlabel_combo[$maindata[2][0]] = $maindata[1][2];
			$value[$maindata[2][0]] = $maindata[3][0];
			$secondvalue[$maindata[2][0]] = $maindata[3][1];
			$thirdvalue[$maindata[2][0]] = $maindata[3][2];
			
		}
	}
}
//print_r($value['assigned_user_id']);

//$select_users = array();
/*
foreach($value['assigned_user_id'] as $key_one=>$arr)
{
	foreach($arr as $sel_value=>$user)
	{
		$value['assigned_user_id'][$key_one]=getUserNomPrenom($sel_value);
	}
}	*/

// jread.topik. patch account_id for create contact
if (strlen($account_name) > 0)
{
	$fldlabel_sel['parent_id'][1]='selected';
	$secondvalue['parent_id'] = $account_id;
	$value['parent_id'] = $account_name;
}

//$format = ($current_user->hour_format == '')?'am/pm':$current_user->hour_format;
$format = ($current_user->hour_format == '')?'24':$current_user->hour_format;
//echo $format;
$stdate = key($value['date_start']);
$enddate = key($value['due_date']);
$sttime = $value['date_start'][$stdate];
$endtime = $value['due_date'][$enddate];
$time_arr = getaddEventPopupTime($sttime,$endtime,$format);
$value['starthr'] = $time_arr['starthour'];
$value['startmin'] = $time_arr['startmin'];
$value['startfmt'] = $time_arr['startfmt'];
$value['endhr'] = $time_arr['endhour'];
$value['endmin'] = $time_arr['endmin'];
$value['endfmt'] = $time_arr['endfmt'];
$smarty->assign("STARTHOUR",getTimeCombo($format,'start',$time_arr['starthour'],$time_arr['startmin'],$time_arr['startfmt'],$taskcheck));
$smarty->assign("ENDHOUR",getTimeCombo($format,'end',$time_arr['endhour'],$time_arr['endmin'],$time_arr['endfmt']));
$smarty->assign("FOLLOWUP",getTimeCombo($format,'followup_start',$time_arr['endhour'],$time_arr['endmin'],$time_arr['endfmt']));
$smarty->assign("ACTIVITYDATA",$value);
$smarty->assign("LABEL",$fldlabel);
$smarty->assign("secondvalue",$secondvalue);
$smarty->assign("thirdvalue",$thirdvalue);
$smarty->assign("fldlabel_combo",$fldlabel_combo);
$smarty->assign("fldlabel_sel",$fldlabel_sel);
$smarty->assign("OP_MODE",$disp_view);
$smarty->assign("ACTIVITY_MODE",$activity_mode);
$smarty->assign("HOURFORMAT",$format);
$smarty->assign("USERSLIST",$userDetails);
$smarty->assign("USEREMAILID",$to_email);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("DATEFORMAT",parse_calendardate($app_strings['NTC_DATE_FORMAT']));

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$log->info("Activity edit view");

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

if (isset($focus->name))
$smarty->assign("NAME", $focus->name);
else
$smarty->assign("NAME", "");

if($focus->mode == 'edit')
{
        $smarty->assign("MODE", $focus->mode);
}

$category = getParentTab();
$smarty->assign("CATEGORY",$category);

// Unimplemented until jscalendar language vtiger_files are fixed
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("CALENDAR_DATEFORMAT", parse_calendardate($app_strings['NTC_DATE_FORMAT']));

if (isset($_REQUEST['return_module']))
	$smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if (isset($_REQUEST['return_action']))
	$smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if (isset($_REQUEST['return_id']))
	$smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if (isset($_REQUEST['ticket_id']))
	$smarty->assign("TICKETID", $_REQUEST['ticket_id']);
if (isset($_REQUEST['product_id']))
	$smarty->assign("PRODUCTID", $_REQUEST['product_id']);
if (isset($_REQUEST['return_viewname']))
	$smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
if(isset($_REQUEST['view']) && $_REQUEST['view']!='')
	$smarty->assign("view",$_REQUEST['view']);
if(isset($_REQUEST['hour']) && $_REQUEST['hour']!='')
	$smarty->assign("hour",$_REQUEST['hour']);
if(isset($_REQUEST['day']) && $_REQUEST['day']!='')
	$smarty->assign("day",$_REQUEST['day']);
if(isset($_REQUEST['month']) && $_REQUEST['month']!='')
	$smarty->assign("month",$_REQUEST['month']);
if(isset($_REQUEST['year']) && $_REQUEST['year']!='')
	$smarty->assign("year",$_REQUEST['year']);
if(isset($_REQUEST['viewOption']) && $_REQUEST['viewOption']!='')
	$smarty->assign("viewOption",$_REQUEST['viewOption']);
if(isset($_REQUEST['subtab']) && $_REQUEST['subtab']!='')
	$smarty->assign("subtab",$_REQUEST['subtab']);
if(isset($_REQUEST['maintab']) && $_REQUEST['maintab']!='')
	$smarty->assign("maintab",$_REQUEST['maintab']);
	
	
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("ID", $focus->id);

 $tabid = getTabid($tab_type);
 $validationData = getDBValidationData($focus->tab_name,$tabid);
 $data = split_validationdataArray($validationData);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("DUPLICATE", $_REQUEST['isDuplicate']);

if ($activity_mode == 'Task') {
	$custom_fields_data = getCalendarCustomFields(getTabid('Calendar'),'edit',$focus->column_fields);
} else {
	$custom_fields_data = getCalendarCustomFields(getTabid('Events'),'edit',$focus->column_fields);
}
$smarty->assign("CUSTOM_FIELDS_DATA", $custom_fields_data);

$smarty->display("ActivityEditView.tpl");

?>
