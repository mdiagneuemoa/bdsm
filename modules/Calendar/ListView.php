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
 * $Header: /cvs/repository/siprodPCCI/modules/Calendar/ListView.php,v 1.1 2010/01/15 18:43:50 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once("data/Tracker.php");
require_once('modules/Calendar/Activity.php');
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('modules/Calendar/CalendarCommon.php');
require_once('include/database/PearDatabase.php');

global $app_strings;
global $list_max_entries_per_page;

$log = LoggerManager::getLogger('task_list');

global $currentModule,$image_path,$theme,$adb;

if (isset($_REQUEST['current_user_only'])) $current_user_only = $_REQUEST['current_user_only'];

$focus = new Activity();
// Initialize sort by fields
$focus->initSortbyField('Calendar');
// END
$smarty = new vtigerCRM_Smarty;
$other_text = Array();

if(!$_SESSION['lvs'][$currentModule])
{
	unset($_SESSION['lvs']);
	$modObj = new ListViewSession();
	$modObj->sorder = $sorder;
	$modObj->sortby = $order_by;
	$_SESSION['lvs'][$currentModule] = get_object_vars($modObj);
}

if($_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR",$mod_strings["SHARED_EVENT_DEL_MSG"]);
}else
{
        $smarty->assign("ERROR","");
}
//<<<<<<< sort ordering >>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION['ACTIVITIES_ORDER_BY'] = $order_by;
$_SESSION['ACTIVITIES_SORT_ORDER'] = $sorder;
//<<<<<<< sort ordering >>>>>>>>>>>>>


//<<<<cutomview>>>>>>>
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
//echo "viewid=",$viewid,"<br>";
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);

//Added to handle approving or denying status-public by the admin in CustomView
$statusdetails = $oCustomView->isPermittedChangeStatus($viewnamedesc['status']);
$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);

//To check if a user is able to edit/delete a customview
$edit_permit = $oCustomView->isPermittedCustomView($viewid,'EditView',$currentModule);
$delete_permit = $oCustomView->isPermittedCustomView($viewid,'Delete',$currentModule);
$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
$smarty->assign("CV_DELETE_PERMIT",$delete_permit);

//<<<<<customview>>>>>
if($viewid == 0 )
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('close.gif', $theme) ?>'></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
	echo "</td></tr></table>";
	exit;
}

$changeOwner = getAssignedTo(16);
$userList = $changeOwner[0];
$groupList = $changeOwner[1];

$smarty->assign("CHANGE_USER",$userList);
$smarty->assign("CHANGE_GROUP",$groupList);
$smarty->assign("CHANGE_OWNER",getUserslist());
$smarty->assign("CHANGE_GROUP_OWNER",getGroupslist());
$where = "";

$url_string = ''; // assigning http url string

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{

	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
	// we have a query
	$url_string .="&query=true".$ustring;
	$log->info("Here is the where clause for the list view: $where");
	$smarty->assign("SEARCH_URL",$url_string);
}


if($viewnamedesc['viewname'] == 'All')
{
	$smarty->assign("ALL", 'All');
}

if(isPermitted("Calendar","Delete",$_REQUEST['record']) == 'yes')
{
	$other_text['del'] = $app_strings[LBL_MASS_DELETE];
}
if(isPermitted('Calendar','EditView','') == 'yes')
{
        $other_text['c_owner'] = $app_strings[LBL_CHANGE_OWNER];
}
global  $task_title;
$title_display = $current_module_strings['LBL_LIST_FORM_TITLE'];
if ($task_title) $title_display= $task_title;

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
if($viewid != "0")
{
	$listquery = getListQuery("Calendar");
	$list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"Calendar");
}else
{
	$list_query = getListQuery("Calendar");
}
//<<<<<<<<customview>>>>>>>>>

if(isset($where) && $where != '')
{
	if(isset($_REQUEST['from_homepagedb']) && $_REQUEST['from_homepagedb'] == 'true')
		$list_query .= " and ((vtiger_activity.status!='Completed' and vtiger_activity.status!='Deferred') or vtiger_activity.status is null) and ((vtiger_activity.eventstatus!='Held' and vtiger_activity.eventstatus!='Not Held') or vtiger_activity.eventstatus is null) AND ".$where;
	else
		$list_query .= " AND " .$where;
}
if (isset($_REQUEST['from_homepage'])) {
	$today = date("Y-m-d", time());
	if ($_REQUEST['from_homepage'] == 'upcoming_activities')
		$list_query .= " AND (vtiger_activity.status is NULL OR vtiger_activity.status not in ('Completed','Deferred')) and (vtiger_activity.eventstatus is NULL OR  vtiger_activity.eventstatus not in ('Held','Not Held')) AND (date_start >= '$today' OR vtiger_recurringevents.recurringdate >= '$today')";
	elseif ($_REQUEST['from_homepage'] == 'pending_activities') 
		$list_query .= " AND (vtiger_activity.status is NULL OR vtiger_activity.status not in ('Completed','Deferred')) and (vtiger_activity.eventstatus is NULL OR  vtiger_activity.eventstatus not in ('Held','Not Held')) AND (due_date <= '$today' OR vtiger_recurringevents.recurringdate <= '$today')";
}

$list_query .= ' group by vtiger_activity.activityid having vtiger_activity.activitytype != "Emails"';

if(isset($order_by) && $order_by != '')
{
	if($order_by == 'smownerid')
        {
                $list_query .= ' ORDER BY user_name '.$sorder;
        }
        else
        {
		$tablename = getTableNameForField('Calendar',$order_by);
		$tablename = (($tablename != '')?($tablename."."):'');
		if($order_by == 'lastname')
         		$list_query .= ' ORDER BY vtiger_contactdetails.lastname '.$sorder;
	        else
			$list_query .= ' ORDER BY '.$tablename.$order_by.' '.$sorder; 
	}
}

//Constructing the list view
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Activity');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("NEW_EVENT",$app_strings['LNK_NEW_EVENT']);
$smarty->assign("NEW_TASK",$app_strings['LNK_NEW_TASK']);

//Retreiving the no of rows
$count_result = $adb->query("select count(*) count,vtiger_activity.activitytype ".substr($list_query, strpos($list_query,'FROM'),strlen($list_query))); 
$noofrows = $adb->num_rows($count_result); 

//Storing Listview session object
if($_SESSION['lvs'][$currentModule])
{
	setSessionVar($_SESSION['lvs'][$currentModule],$noofrows,$list_max_entries_per_page);
}

//added for 4600
                                                                                                                             
if($noofrows <= $list_max_entries_per_page)
        $_SESSION['lvs'][$currentModule]['start'] = 1;
//ends
$start = $_SESSION['lvs'][$currentModule]['start'];

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);

// Setting the record count string
//modified by rdhital
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val']; 
//By raju Ends

//limiting the query
if ($start_rec ==0) 
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;
	
$list_result = $adb->query($list_query. " limit ".$limit_start_rec.",".$list_max_entries_per_page);

$record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;

//Retreive the List View Table Header
if($viewid !='')
$url_string .="&viewname=".$viewid;

//Cambiado code to add close button in custom vtiger_field
/*
if (($viewid!=0)&&($viewid!="")){
  if (!isset($oCustomView->list_fields['Close'])) $oCustomView->list_fields['Close']=array ( 'vtiger_activity' => 'eventstatus' );
  if (!isset($oCustomView->list_fields_name['Close'])) $oCustomView->list_fields_name['Close']='eventstatus';
}*/
$listview_header = getListViewHeader($focus,"Calendar",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);

$listview_header_search=getSearchListHeaderValues($focus,"Calendar",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER", $listview_header_search);

$listview_entries = getListViewEntries($focus,"Calendar",$list_result,$navigation_array,"","","EditView","Delete",$oCustomView);
$smarty->assign("LISTENTITY", $listview_entries);
$smarty->assign("SELECT_SCRIPT", $view_script);

//Added to select Multiple records in multiple pages
$smarty->assign("SELECTEDIDS", $_REQUEST['selobjs']);
$smarty->assign("ALLSELECTEDIDS", $_REQUEST['allselobjs']);
$smarty->assign("CURRENT_PAGE_BOXES", implode(array_keys($listview_entries),";"));

$navigationOutput = getTableHeaderNavigation($navigation_array,$url_string,"Calendar","ListView",$viewid);
$alphabetical = AlphabeticalSearch($currentModule,'ListView','subject','true','basic',"","","","",$viewid);
$fieldnames = getAdvSearchfields($module);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$_SESSION['activity_listquery'] = $list_query;

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else	
	$smarty->display("ActivityListView.tpl");
?>
