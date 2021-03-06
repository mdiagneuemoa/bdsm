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
require_once('modules/Calendar/Activity.php');
require_once('modules/Calendar/CalendarCommon.php');
require_once('include/logging.php');
require_once("config.php");
require_once('include/database/PearDatabase.php');

$local_log =& LoggerManager::getLogger('index');
$focus = new Activity();
$activity_mode = $_REQUEST['activity_mode'];
if($activity_mode == 'Task')
{
        $tab_type = 'Calendar';
        $focus->column_fields["activitytype"] = 'Task';
}

if(isset($_REQUEST['record']))
{
	        $focus->id = $_REQUEST['record'];
}
if(isset($_REQUEST['mode']))
{
        $focus->mode = $_REQUEST['mode'];
}
foreach($focus->column_fields as $fieldname => $val)
{
	if(isset($_REQUEST[$fieldname]))
	{
		if(is_array($_REQUEST[$fieldname]))
			$value = $_REQUEST[$fieldname];
		else
			$value = trim($_REQUEST[$fieldname]);
		$focus->column_fields[$fieldname] = $value;
	}
}
 $focus->column_fields["subject"] = $_REQUEST["task_subject"];
 $focus->column_fields["time_start"] = $_REQUEST["task_time_start"];
 $focus->column_fields["assigned_user_id"] =  $_REQUEST["task_assigned_user_id"];
 $_REQUEST["assigned_group_id"]  = $_REQUEST['task_assigned_group_id'];
 $_REQUEST['assigntype'] = $_REQUEST['task_assigntype'];
 $focus->column_fields["taskstatus"] =  $_REQUEST["taskstatus"];
 $focus->column_fields["date_start"] =  $_REQUEST["task_date_start"];
 $focus->column_fields["due_date"] =  $_REQUEST["task_due_date"];
 $focus->column_fields["taskpriority"] =  $_REQUEST["taskpriority"];
 $focus->column_fields["parent_id"] = $_REQUEST["task_parent_id"];
 $focus->column_fields["contact_id"] = $_REQUEST["task_contact_id"];
 $focus->column_fields["description"] =  $_REQUEST["task_description"];
 
 // hodar crm notion d'?quipe associ?e ? une t?che
 $focus->column_fields["chefequipe"] =  $_REQUEST["chefequipe"];
 $focus->column_fields["coordonnateur"] =  $_REQUEST["coordonnateur"];
 $focus->column_fields["consultant1"] =  $_REQUEST["consultant1"];
 $focus->column_fields["consultant2"] = $_REQUEST["consultant2"];
 $focus->column_fields["assistant1"] = $_REQUEST["assistant1"];
 $focus->column_fields["assistant2"] =  $_REQUEST["assistant2"];
 
 if(isset($_REQUEST['task_sendnotification']) && $_REQUEST['task_sendnotification'] != null)
 	$focus->column_fields["sendnotification"] =  $_REQUEST["task_sendnotification"];

 	$focus->save($tab_type);
	//if($_REQUEST["task_sendnotification"]=='on')
//{
		$mail_contents = getRequestedToData();
		getEventNotification($_REQUEST['activity_mode'],$_REQUEST['task_subject'],$mail_contents);

      //  }
function getRequestedToData()
{
	$mail_data = Array();
	$mail_data['user_id'] = $_REQUEST["task_assigned_user_id"];
	$mail_data['subject'] = $_REQUEST['task_subject'];
	$mail_data['status'] = (($_REQUEST['activity_mode']=='Task')?($_REQUEST['taskstatus']):($_REQUEST['eventstatus']));
	$mail_data['activity_mode'] = $_REQUEST['activity_mode'];
	$mail_data['taskpriority'] = $_REQUEST['taskpriority'];
	$mail_data['relatedto'] = $_REQUEST['task_parent_name'];
	$mail_data['contact_name'] = $_REQUEST['task_contact_name'];
	$mail_data['description'] = $_REQUEST['task_description'];
	$mail_data['assingn_type'] = $_REQUEST['task_assigntype'];
	$mail_data['group_name'] = getGroupName($_REQUEST['task_assigned_group_id']);
	$mail_data['mode'] = $_REQUEST['task_mode'];
	$value = getaddEventPopupTime($_REQUEST['task_time_start'],$_REQUEST['task_time_end'],'24');
	$start_hour = $value['starthour'].':'.$value['startmin'].''.$value['startfmt'];
	$mail_data['st_date_time'] = getDisplayDate($_REQUEST['task_date_start'])." ".$start_hour;
	$mail_data['end_date_time']=getDisplayDate($_REQUEST['task_due_date']);
	
	$mail_data['chefequipe']=$_REQUEST["chefequipe"];
	$mail_data['coordonnateur']=$_REQUEST["coordonnateur"];
	$mail_data['consultant1']=$_REQUEST["consultant1"];
	$mail_data['consultant2']=$_REQUEST["consultant2"];
	$mail_data['assistant1']=$_REQUEST["assistant1"];
	$mail_data['assistant2']=$_REQUEST["assistant2"];


	
	return $mail_data;
}


 header("Location: index.php?action=index&module=Calendar&view=".$_REQUEST['view']."&hour=".$_REQUEST['hour']."&day=".$_REQUEST['day']."&month=".$_REQUEST['month']."&year=".$_REQUEST['year']."&viewOption=".$_REQUEST['viewOption']."&subtab=todo&parenttab=".$_REQUEST['parenttab']);
?>
