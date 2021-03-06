<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $app_strings, $mod_strings, $current_language, $currentModule, $theme;
global $list_max_entries_per_page;

require_once('Smarty_setup.php');
require_once('include/ListView/ListView.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$category = getParentTab();
$url_string = '';

$tool_buttons = Button_Check($currentModule);
$list_buttons = Array();

if(isPermitted($currentModule,'Delete','') == 'yes') $list_buttons['del'] = $app_strings[LBL_MASS_DELETE];
if(isPermitted($currentModule,'Edit','') == 'yes') {
	$list_buttons['mass_edit'] = $app_strings[LBL_MASS_EDIT];
	// Mass Edit could be used to change the owner as well!
	//$list_buttons['c_owner'] = $app_strings[LBL_CHANGE_OWNER];	
}

$focus = new $currentModule();
$focus->initSortbyField($currentModule);
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION[$currentModule."_Order_by"] = $order_by;
$_SESSION[$currentModule."_Sort_Order"]=$sorder;

$smarty = new vtigerCRM_Smarty();

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('MOD', $mod_strings);
$smarty->assign('APP', $app_strings);
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', getTranslatedString('SINGLE_'.$currentModule));
$smarty->assign('CATEGORY', $category);
$smarty->assign('BUTTONS', $list_buttons);
$smarty->assign('CHECK', $tool_buttons);
$smarty->assign("THEME", $theme);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");

$smarty->assign('CHANGE_OWNER', getUserslist());
$smarty->assign('CHANGE_GROUP_OWNER', getGroupslist());

// Enabling Module Search
$url_string = '';
if($_REQUEST['query'] == 'true') {
	list($where, $ustring) = split('#@@#', getWhereCondition($currentModule));
	$url_string .= "&query=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

// Enabling Module Filter
if($_REQUEST['filter'] == 'true') {
	list($where, $ustring) = split('#@@#', basicFilter($currentModule));
	$url_string .= "&filter=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

// Custom View
$customView = new CustomView($currentModule);
$viewid = $customView->getViewId($currentModule);
$customview_html = $customView->getCustomViewCombo($viewid);
$viewinfo = $customView->getCustomViewByCvid($viewid);

// Feature available from 5.1
if(method_exists($customView, 'isPermittedChangeStatus')) {
	// Approving or Denying status-public by the admin in CustomView
	$statusdetails = $customView->isPermittedChangeStatus($viewinfo['status']);
	
	// To check if a user is able to edit/delete a CustomView
	$edit_permit = $customView->isPermittedCustomView($viewid,'EditView',$currentModule);
	$delete_permit = $customView->isPermittedCustomView($viewid,'Delete',$currentModule);

	$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);
	$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
	$smarty->assign("CV_DELETE_PERMIT",$delete_permit);
}
// END

$smarty->assign("VIEWID", $viewid);

if($viewinfo['viewname'] == 'All') $smarty->assign('ALL', 'All');

if($viewid ==0)
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme) ."' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span clas
		s='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
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

$listquery = getListQuery($currentModule);
$list_query= $customView->getModifiedCvListQuery($viewid, $listquery, $currentModule);


$list_query = "select ag_id, ";


$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
$dbstatel = $CAMPAGNES_STATSTELECOM [$CURRENT_CAMPAGNE]['database'];	

$current_table_name = "$dbstatel.agent_day";
$current_view_name = "$dbstatel.agent_day_view";

if($_REQUEST['tranche_field'] == '' || !isset($_REQUEST['ajax']) || $_REQUEST['ajax'] == '') {
	$list_query = "$list_query DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') as ag_jour_prod, ag_heure, ";

	$current_table_name = "$dbstatel.agent_hour";
	$current_view_name = "$dbstatel.agent_hour_view";
}


$date_start_val = $_REQUEST['date_start'];
$date_end_val = $_REQUEST['date_end'];

$d = new DateTime($date_start_val);
$date_start = $d->format("d-m-Y");

$d = new DateTime($date_end_val);
$date_end = $d->format("d-m-Y");
		
if($date_start != $date_end) {
	$periode = "'Du ".$date_start." au ".$date_end."' as ";
}
else {
	$periode = "DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') as ";
}	
		
if($_REQUEST['tranche_field'] == 1) {
	$list_query = "$list_query  $periode ag_jour_prod, ag_heure, ag_tranche_h, ";

	$current_table_name = "$dbstatel.agent_quarter";
	   
	if ($order_by == $focus->default_order_by) {
		$order_by = 'ag_heure, ag_tranche_h';
	}	
}

if($_REQUEST['tranche_field'] == 2) {
	$list_query = "$list_query  $periode ag_jour_prod, ag_heure, ";

	$current_table_name = "$dbstatel.agent_hour";
	$current_view_name = "$dbstatel.agent_hour_view";
}

if($_REQUEST['tranche_field'] == 3) {
	$periode = "DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') as ";
	
	$list_query = "$list_query  $periode ag_jour_prod, ";

	$heure_debut_field_val = $_REQUEST['heure_debut_field'];
	$heure_fin_field_val = $_REQUEST['heure_fin_field'];
	$tranche_field_val = $_REQUEST['tranche_field'];

	if (($module == 'Agent' && $tranche_field_val == '3') && (($heure_debut_field_val != '' && $heure_debut_field_val != '00') ||  ($heure_fin_field_val != '' && $heure_fin_field_val != '24'))) {
		$current_table_name = "$dbstatel.agent_hour";	
	}
	else {
		$current_table_name = "$dbstatel.agent_day";
		$current_view_name = "$dbstatel.agent_day_view";	
	}
	
//	$current_table_name = "$dbstatel.agent_day";
//	$current_view_name = "$dbstatel.agent_day_view";
	   
	if ($order_by == $focus->default_order_by) {
		$order_by = 'ag_user_id, ag_jour_prod';
		$sorder = 'DESC';
	}
}

$list_query_entries = " $list_query ag_user_id,ag_date,ag_nom,ag_op_lib,
							SEC_TO_TIME(sum(ag_total_time_login)) as ag_total_time_login,SEC_TO_TIME(sum(ag_total_time_not_ready)) as ag_total_time_not_ready,
							SEC_TO_TIME(sum(ag_total_time_wait)) as ag_total_time_wait,SEC_TO_TIME(sum(ag_total_time_talk)) as ag_total_time_talk,
							SEC_TO_TIME(sum(ag_total_time_after_call_work)) as ag_total_time_after_call_work,
							SEC_TO_TIME(sum(ag_total_time_in_bound_talk)) as ag_total_time_in_bound_talk,
							SEC_TO_TIME(sum(ag_total_time_internal_talk)) as ag_total_time_internal_talk,
							sum(ag_total_calls) as ag_total_calls,  sum(ag_total_in_bound_calls) as ag_total_in_bound_calls,
							sum(ag_total_internal_calls) as ag_total_internal_calls,sum(ag_total_wait_number) as ag_total_wait_number,
							sum(ag_total_not_ready_number) as ag_total_not_ready_number,sum(ag_total_number_on_hold) as ag_total_number_on_hold
							from ";
							
$list_query = " $list_query_entries  $current_table_name ";

if($_REQUEST['tranche_field'] == '' || !isset($_REQUEST['ajax']) || $_REQUEST['ajax'] == '') {
//	$list_query = "$list_query  where DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') group by  ag_user_id, ag_heure ";
	$list_query = "$list_query  where DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') /*and ag_op_lib='Orange_SN_1212'*/ group by ag_user_id ";
	$list_query = "$list_query  ";//union ($list_query_entries $current_view_name where DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') ) ";
}




if($where != '') {
	$list_query = "$list_query WHERE $where";
}

if($_REQUEST['tranche_field'] == 2) {
	$list_query = " $list_query  ";
}
if($_REQUEST['tranche_field'] == 3) {
	// Debut Ajout
	$date_start_val = $_REQUEST['date_start'];
	$date_end_val = $_REQUEST['date_end'];

	$d = new DateTime($date_start_val);
	$date_start = $d->format("d-m-Y");

	$d = new DateTime($date_end_val);
	$date_end = $d->format("d-m-Y");

	$d = new DateTime();
	$current_date = $d->format("d-m-Y");

	if($date_start == $date_end && $current_date == $date_end) {
		$and_where = ($where != '') ? " $where " : "DATE_FORMAT(ag_jour_prod,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d')  group by ag_user_id ";
		$current_table_name = "$dbstatel.agent_hour";
		$list_query = " $list_query_entries  $current_table_name  WHERE $and_where /*and ag_op_lib='Orange_SN_1212' */";
//		$list_query = " $list_query_entries $current_view_name WHERE $where ";
	}
	else {
		$list_query = " $list_query ";
	}
	
}

// Sorting
if($order_by) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY user_name '.$sorder;
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
		//$list_query .= ' ORDER BY ' . $tablename . $order_by . ' ' . $sorder;
		$list_query .= ' ORDER BY ' . $order_by . ' ' . $sorder;
	}
}

$recordCount= $adb_statelop->num_rows($adb_statelop->query($list_query));

// Set paging start value.
$start = 1;

if(isset($_REQUEST['start']) && $_REQUEST['start'] != '') { 
	$start = $_REQUEST['start']; 
} 
elseif(isset($_SESSION['lvs'][$currentModule]['start']) && $_SESSION['lvs'][$currentModule]['start'] != '') { 
	$start = $_SESSION['lvs'][$currentModule]['start']; 
}

// Total records is less than a page now.
if($recordCount <= $list_max_entries_per_page) $start = 1;
// Save in session
$_SESSION['lvs'][$currentModule]['start'] = $start;

$navigation_array = getNavigationValues($start, $recordCount, $list_max_entries_per_page);

$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];
$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;

if ($start_rec ==0) $limit_start_rec = 0;
else $limit_start_rec = $start_rec -1;

//if($_REQUEST['tranche_field'] == 3) 
//{
	$list_result = $adb_statelop->query( $list_query );
	$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $recordCount" . $app_strings['LBL_LIST_OF'] ." ".$recordCount;

/*}
else
{
	$list_result = $adb_statelop->query( $list_query . " LIMIT $limit_start_rec, $list_max_entries_per_page" );
	$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $end_rec " . $app_strings['LBL_LIST_OF'] ." ".$recordCount;
}	
*/
$smarty->assign('RECORD_COUNTS', $record_string);
$smarty->assign("CUSTOMVIEW_OPTION",$customview_html);

// Navigation
$start = $_SESSION['lvs'][$currentModule]['start'];
//$navigation_array = getNavigationValues($start, $recordCount, $list_max_entries_per_page);
//$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string, $currentModule, 'index', $viewid);
//$smarty->assign("NAVIGATION", $navigationOutput);

$listview_header = getListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);
$listview_entries = getListViewEntriesAgents($focus,$currentModule,$list_result,$navigation_array,'','','EditView','Delete',$customView);
$listview_header_search = getSearchListHeaderValues($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);

$smarty->assign('LISTHEADER', $listview_header);
//$smarty->assign('LISTENTITY', $listview_entries);
$smarty->assign('LISTENTITY', $listview_entries['detail']);
$smarty->assign('LISTENTITYGLOBAL', $listview_entries['global']);
$smarty->assign('SEARCHLISTHEADER',$listview_header_search);

// Module Search
$alphabetical = AlphabeticalSearch($currentModule,'index',$focus->def_basicsearch_col,'true','basic','','','','',$viewid);
$fieldnames = getAdvSearchfields($currentModule);
$criteria = getcriteria_options();
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("CRITERIA", $criteria);

$smarty->assign("AVALABLE_FIELDS", getMergeFields($currentModule,"available_fields"));
$smarty->assign("FIELDS_TO_MERGE", getMergeFields($currentModule,"fileds_to_merge"));

// JOKCALL : Crit?res de filtre sur le tableau - D?but

$smarty->assign("ENTITY_MODULE", getAllAgent()); 

	// Tranche : D?but
	
	
$smarty->assign("TRANCHE", array(
                                /*1 => $app_strings['LBL_JOKCALL_TRANCHE_QUATER'],*/
                                2 =>  $app_strings['LBL_JOKCALL_TRANCHE_HORAIRE'],
                                3 =>  $app_strings['LBL_JOKCALL_TRANCHE_DAY']));
$smarty->assign("DEFAULT_SELECTED", 3);
                                
	// Tranche : Fin

$smarty->assign("FILTERHEURES", $HORAIRES_OUVERTURE_OCI);
//$smarty->assign("FILTERMINUTES", getAllMinutes());

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

$smarty->assign('NB_RECORDS', $recordCount);

$smarty->assign("LIST_QUERY",$list_query);
$smarty->assign("CAMPAGNE", $CURRENT_CAMPAGNE);

// JOKCALL : Crit?res de filtre sur le tableau - Fin

$_SESSION[$currentModule.'_listquery'] = $list_query;

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntriesAgent.tpl");
else 
	$smarty->display('ListViewAgent.tpl');

?>
