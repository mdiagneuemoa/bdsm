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
 * $Header: /cvs/repository/siprodPCCI/modules/Calendar/Save.php,v 1.1 2010/01/15 18:43:49 isene Exp $
 * Description:  Saves an Account record and then redirects the browser to the 
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Calendar/Activity.php');
require_once('include/logging.php');
require_once("config.php");
require_once('include/database/PearDatabase.php');
require_once('modules/Calendar/CalendarCommon.php');
global $adb,$theme,$mod_strings;
$local_log =& LoggerManager::getLogger('index');
$focus = new Activity();
$activity_mode = $_REQUEST['activity_mode'];
$tab_type = 'Calendar';
//added to fix 4600
$search=$_REQUEST['search_url'];


if(isset($_REQUEST['taskstatus']))
{
	$focus->column_fields["activitytype"] = 'Task';
}
elseif(isset($_REQUEST['eventstatus']))
{
	$focus->column_fields["activitytype"] = 'Events';	
}

if(isset($_REQUEST['record']))
{
	$focus->id = $_REQUEST['record'];
	$local_log->debug("id is ".$id);
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
}

if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['taskstatus']!='' || $_REQUEST['eventstatus']!=''))
{
	$status ='';
	$activity_type='';
	$return_id = $focus->id;
	if(isset($_REQUEST['taskstatus']))
	{
		$status = $_REQUEST['taskstatus'];	
		$activity_type = "Task";	
	}
	elseif(isset($_REQUEST['eventstatus']))
	{
		$status = $_REQUEST['eventstatus'];	
		$activity_type = "Events";	
	}
	if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
	{
		ChangeStatus($status,$return_id,$activity_type);
	}
	else
	{
		echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";	
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
		echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

			<table border='0' cellpadding='5' cellspacing='0' width='98%'>
			<tbody><tr>
			<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
			</tr>
			<tr>
			<td class='small' align='right' nowrap='nowrap'>			   	
			<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
			</tr>
			</tbody></table> 
		</div>";
		echo "</td></tr></table>";die;
	}
	$mail_data = getActivityMailInfo($return_id,$status,$activity_type);
	
	//if($mail_data['sendnotification'] == 1)
	//{
		//echo "--------mail notification envoy?";
		getEventNotification($activity_type,$mail_data['subject'],$mail_data);
	//}
	$invitee_qry = "select * from vtiger_invitees where activityid=?";
	$invitee_res = $adb->pquery($invitee_qry, array($return_id));
	$count = $adb->num_rows($invitee_res);
	if($count != 0)
	{
		for($j = 0; $j < $count; $j++)
		{
			$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

		}
		$invitees_ids_string = implode(';',$invitees_ids);
		sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
	}


}
else
{
	foreach($focus->column_fields as $fieldname => $val)
	{
		if(isset($_REQUEST[$fieldname]))
		{
			if(is_array($_REQUEST[$fieldname]))
				$value = $_REQUEST[$fieldname];
			else
				$value = trim($_REQUEST[$fieldname]);
			$focus->column_fields[$fieldname] = $value;
			if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
			{	
				$focus->column_fields['time_start'] = '';
				$focus->column_fields['duration_hours'] = '';
				$focus->column_fields['duration_minutes'] = '';
			}	
			if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
				$focus->column_fields['recurringtype'] = '--None--';
		}
	}
	if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
	        $focus->column_fields['visibility'] = $_REQUEST['visibility'];
	else
	        $focus->column_fields['visibility'] = 'Private';
	
	if($_REQUEST['assigntype'] == 'U' || $_REQUEST['task_assigntype'] == 'U') {
		$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
	} elseif($_REQUEST['assigntype'] == 'T' || $_REQUEST['task_assigntype'] == 'T') {
		$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
	}
	$focus->save($tab_type);
	/* For Followup START -- by Minnie */
	if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
	{
		$heldevent_id = $focus->id;
		$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
		$focus->column_fields['date_start'] = $_REQUEST['followup_date'];
		$focus->column_fields['due_date'] = $_REQUEST['followup_due_date'];
		$focus->column_fields['time_start'] = $_REQUEST['followup_time_start'];
		$focus->column_fields['time_end'] = $_REQUEST['followup_time_end'];
		$focus->column_fields['eventstatus'] = $mod_strings['Planned'];
		$focus->mode = 'create';
		$focus->save($tab_type);
	}
	/* For Followup END -- by Minnie */
	$return_id = $focus->id;
}

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") 
	$return_module = $_REQUEST['return_module'];
else 
	$return_module = "Calendar";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") 
	$return_action = $_REQUEST['return_action'];
else 
	$return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") 
	$return_id = $_REQUEST['return_id'];

$activemode = "";
if($activity_mode != '') 
	$activemode = "&activity_mode=".$activity_mode;

function getRequestData()
{
	$mail_data = Array();
	$mail_data['user_id'] = $_REQUEST['assigned_user_id'];
	$mail_data['subject'] = $_REQUEST['subject'];
	$mail_data['status'] = (($_REQUEST['activity_mode']=='Task')?($_REQUEST['taskstatus']):($_REQUEST['eventstatus']));
	$mail_data['activity_mode'] = $_REQUEST['activity_mode'];
	$mail_data['taskpriority'] = $_REQUEST['taskpriority'];
	$mail_data['relatedto'] = $_REQUEST['parent_name'];
	$mail_data['contact_name'] = $_REQUEST['contact_name'];
	$mail_data['description'] = $_REQUEST['description'];
	if(isset($_REQUEST['assigntype']) && $_REQUEST['assigntype']!="") 
		$mail_data['assingn_type'] = $_REQUEST['assigntype'];
	else
	if(isset($_REQUEST['task_assigntype']) && $_REQUEST['task_assigntype']!="") 	
		$mail_data['assingn_type'] = $_REQUEST['task_assigntype'];
	$groupeInfo = getGroupName($_REQUEST['assigned_group_id']);
	$mail_data['group_name'] = $groupeInfo[0];
	$mail_data['mode'] = $_REQUEST['mode'];
	$value = getaddEventPopupTime($_REQUEST['time_start'],$_REQUEST['time_end'],'24');
	$start_hour = $value['starthour'].':'.$value['startmin'].''.$value['startfmt'];
	if($_REQUEST['activity_mode']!='Task')
		$end_hour = $value['endhour'] .':'.$value['endmin'].''.$value['endfmt'];
	$mail_data['st_date_time'] = getDisplayDate($_REQUEST['date_start'])." ".$start_hour;
	$mail_data['end_date_time']=getDisplayDate($_REQUEST['due_date'])." ".$end_hour;
	$mail_data['location']=$_REQUEST['location'];

	$mail_data['chefequipe']=$_REQUEST["chefequipe"];
	$mail_data['coordonnateur']=$_REQUEST["coordonnateur"];
	$mail_data['consultant1']=$_REQUEST["consultant1"];
	$mail_data['consultant2']=$_REQUEST["consultant2"];
	$mail_data['assistant1']=$_REQUEST["assistant1"];
	$mail_data['assistant2']=$_REQUEST["assistant2"];

	
	
	return $mail_data;
}
//Added code to send mail to the assigned to user about the details of the vtiger_activity if sendnotification = on and assigned to user
//if($_REQUEST['sendnotification'] == 'on')
//{
	$mail_contents = getRequestData();
	getEventNotification($_REQUEST['activity_mode'],$_REQUEST['subject'],$mail_contents);
//}

//code added to send mail to the vtiger_invitees
if(isset($_REQUEST['inviteesid']) && $_REQUEST['inviteesid']!='')
{
	$mail_contents = getRequestData();
        sendInvitation($_REQUEST['inviteesid'],$_REQUEST['activity_mode'],$_REQUEST['subject'],$mail_contents);
}

if(isset($_REQUEST['contactidlist']) && $_REQUEST['contactidlist'] != '')
{
	//split the string and store in an array
	$storearray = explode (";",$_REQUEST['contactidlist']);
	$del_sql = "delete from vtiger_cntactivityrel where activityid=?";
	$adb->pquery($del_sql, array($record));
	foreach($storearray as $id)
	{
		if($id != '')
		{
			$record = $focus->id;
			$sql = "insert into vtiger_cntactivityrel values (?,?)";
			$adb->pquery($sql, array($id, $record));
			if(!empty($heldevent_id)) {
				$sql = "insert into vtiger_cntactivityrel values (?,?)";
				$adb->pquery($sql, array($id, $heldevent_id));
			}
		}
	}
}

//to delete contact account relation while editing event
if(isset($_REQUEST['deletecntlist']) && $_REQUEST['deletecntlist'] != '' && $_REQUEST['mode'] == 'edit')
{
	//split the string and store it in an array
	$storearray = explode (";",$_REQUEST['deletecntlist']);
	foreach($storearray as $id)
	{
		if($id != '')
		{
			$record = $focus->id;
			$sql = "delete from vtiger_cntactivityrel where contactid=? and activityid=?";
			$adb->pquery($sql, array($id, $record));
		}
	}

}

//to delete activity and its parent table relation
if(isset($_REQUEST['del_actparent_rel']) && $_REQUEST['del_actparent_rel'] != '' && $_REQUEST['mode'] == 'edit')
{
	$parnt_id = $_REQUEST['del_actparent_rel'];
	$sql= 'delete from vtiger_seactivityrel where crmid=? and activityid=?';
	$adb->pquery($sql, array($parnt_id, $record));
}

if(isset($_REQUEST['view']) && $_REQUEST['view']!='')
	$view=$_REQUEST['view'];
if(isset($_REQUEST['hour']) && $_REQUEST['hour']!='')
	$hour=$_REQUEST['hour'];
if(isset($_REQUEST['day']) && $_REQUEST['day']!='')
	$day=$_REQUEST['day'];
if(isset($_REQUEST['month']) && $_REQUEST['month']!='')
	$month=$_REQUEST['month'];
if(isset($_REQUEST['year']) && $_REQUEST['year']!='') 
	$year=$_REQUEST['year'];
if(isset($_REQUEST['viewOption']) && $_REQUEST['viewOption']!='') 
	$viewOption=$_REQUEST['viewOption'];
if(isset($_REQUEST['subtab']) && $_REQUEST['subtab']!='') 
	$subtab=$_REQUEST['subtab'];

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') 
	$return_viewname='0';
if($_REQUEST['return_viewname'] != '')
	$return_viewname=$_REQUEST['return_viewname'];
if($_REQUEST['parenttab'] != '')
	$parenttab=$_REQUEST['parenttab'];
if($_REQUEST['start'] !='')
	$page='&start='.$_REQUEST['start'];
if($_REQUEST['maintab'] == 'Calendar')
	header("Location: index.php?action=".$return_action."&module=".$return_module."&view=".$view."&hour=".$hour."&day=".$day."&month=".$month."&year=".$year."&record=".$return_id."&viewOption=".$viewOption."&subtab=".$subtab."&parenttab=$parenttab");
else
	header("Location: index.php?action=$return_action&module=$return_module$view$hour$day$month$year&record=$return_id$activemode&viewname=$return_viewname$page&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
?>
