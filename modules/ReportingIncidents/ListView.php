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

// Enabling Module Search
$url_string = '';
if($_REQUEST['query'] == 'true') {
	list($where, $ustring) = split('#@@#', getWhereCondition($currentModule));
	$url_string .= "&query=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

// Custom View
$customView = new CustomView($currentModule);
$viewid = $customView->getViewId($currentModule);
$customview_html = $customView->getCustomViewCombo($viewid);
$viewinfo = $customView->getCustomViewByCvid($viewid);

if($_REQUEST['filter'] == 'true') {
	$smarty->assign('INFILTER', "in filter");
	list($where, $ustring) = split('#@@#', basicFilterReportingIncident());
	$url_string .= "&filter=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

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

/*$list_query = "select siprod_reporting_incidents.semaine_postage,
					siprod_reporting_incidents.campagne,siprod_reporting_incidents.nb_incidents_all,
					siprod_reporting_incidents.nb_incidents_traited,
					siprod_reporting_incidents.duree_traitement,siprod_reporting_incidents.nb_incidents_pending,
					siprod_reporting_incidents.nb_incidents_transfered,siprod_reporting_incidents.nb_incidents_open 
					from siprod_reporting_incidents ";
*/
$list_query = "
				SELECT  date_postage as date_postage,campagne ,
				SUM(nb_incidents_all) as nb_incidents_all,
				SUM(nb_incidents_traited) as nb_incidents_traited,
				SUM(duree_traitement) as duree_traitement,
				SUM(nb_incidents_pending)as   nb_incidents_pending,
				SUM(nb_incidents_transfered) as nb_incidents_transfered ,
				SUM(nb_Incidents_open)   as   nb_Incidents_open,
				SUM(nb_incidents_dclosed) as   nb_incidents_dclosed
				FROM
				(
									SELECT DATE(createdtime) as date_postage,
									op_lib  as Campagne,
									count(*) as nb_incidents_all,
									0 as nb_incidents_traited,
									0 as duree_traitement,
									0 as nb_incidents_pending,
									0 as  nb_Incidents_open,
									0 as  nb_incidents_transfered ,
									0 as  nb_incidents_dclosed
									from  siprod_incident I, vtiger_crmentity C ,operations
									where crmid = incidentid 
									and   deleted = 0
									and   op_id = campagne
									group by campagne,date_postage
									UNION 
									SELECT DATE(REQ2.createdtime) as date_postage,REQ2.op_lib as Campagne,0 as nb_incidents_all,count(*) as nb_incidents_traited,SUM(dureetraitement)as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
									FROM
									(
									Select REQ.createdtime,REQ.campagne,REQ.op_lib,REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement,REQ.typeincidentid,REQ.groupid,
									TIMESTAMPDIFF(SECOND,REQ.datecreation, REQ.datetraitement)as dureetraitement
									FROM
									(
									SELECT C.createdtime,I.campagne,op_lib, I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,TI.typeincidentid,TI.groupid
									FROM siprod_incident I,siprod_type_incidents TI,siprod_traitement_incidents T1, vtiger_crmentity C1, vtiger_crmentity C,operations
									WHERE (T1.statut = 'traited')
									AND C.crmid = I.incidentid
									AND C1.crmid = T1.traitementincidentid
									and Op_Id=  I.campagne 
									and C.deleted = 0
									and C1.deleted = 0
									AND I.ticket = T1.ticket
									AND I.typeincident= TI.typeincidentid
									GROUP BY I.ticket
									UNION
									SELECT C.createdtime,I.campagne,op_lib,T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,TI.typeincidentid,TI.groupid
									FROM siprod_traitement_incidents T, siprod_incident I,siprod_type_incidents TI,siprod_traitement_incidents T1, vtiger_crmentity C1, vtiger_crmentity C,operations
									WHERE (T1.statut = 'traited')
									AND C.crmid = T.traitementincidentid
									AND C1.crmid = T1.traitementincidentid
									and Op_Id=  I.campagne
									and C.deleted = 0
									and C1.deleted = 0
									AND T.ticket = T1.ticket
									and T.ticket not in (
										select SI.ticket
										from siprod_incident SI ,vtiger_crmentity CR 
										where CR.deleted = 0 and   CR.crmid = SI.incidentid 
										)
									AND T.statut = 'reopen'
									AND I.typeincident= TI.typeincidentid
									GROUP BY T.ticket
									) 
									REQ
									)
									REQ2
									group by campagne,date_postage
									
									UNION 
									SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,count(*) as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
									from  siprod_incident I, vtiger_crmentity C ,operations
									where crmid = incidentid 
									and   deleted = 0
									and statut='pending'
									and   op_id = campagne
									group by campagne,date_postage
									UNION
									SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,count(*) as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
									from  siprod_incident I, vtiger_crmentity C ,operations
									where crmid = incidentid 
									and   deleted = 0
									and ((statut='open') or (statut='reopen'))
									and   op_id = campagne
									group by campagne,date_postage
									UNION
									
									SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,count(*) as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
									from  siprod_incident I, vtiger_crmentity C ,operations
									where crmid = incidentid 
									and   deleted = 0
									and (statut='transfered')
									and   op_id = campagne
									group by campagne,date_postage
									
									UNION
									
									SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,count(*) as  nb_incidents_dclosed
									from  siprod_incident I, vtiger_crmentity C ,operations
									where crmid = incidentid 
									and   deleted = 0
									and statut='closed' 
									and I.ticket not in (select ticket from  siprod_traitement_incidents where statut='traited' )
									and   op_id = campagne
									group by campagne,date_postage
				) siprod_reporting_incidents
				
				";
$list_query = "SELECT  date_postage as date_postage,campagne ,

               SUM(nb_incidents_all) as nb_incidents_all,

               SUM(nb_incidents_traited) as nb_incidents_traited,

               SUM(duree_traitement) as duree_traitement,

               SUM(nb_incidents_pending)as   nb_incidents_pending,

               SUM(nb_incidents_transfered) as nb_incidents_transfered ,

               SUM(nb_Incidents_open)   as   nb_Incidents_open,

               SUM(nb_incidents_dclosed) as   nb_incidents_dclosed

               FROM

               (

                    SELECT DATE(createdtime) as date_postage,

                   	  op_lib  as Campagne,
	
	                  count(*) as nb_incidents_all,
	
	                  0 as nb_incidents_traited,
	
	                  0 as duree_traitement,
	
	                  0 as nb_incidents_pending,
	
	                  0 as  nb_Incidents_open,
	
	                  0 as  nb_incidents_transfered ,
	
	                  0 as  nb_incidents_dclosed
	
	                  from  vue_incident I, vue_crm C ,operations
	
	                  where crmid = incidentid 
	
	                  and   deleted = 0
	
	                  and   op_id = campagne
	
	                  group by campagne,date_postage
	
	                  UNION 
	
	                  SELECT DATE(REQ2.createdtime) as date_postage,REQ2.op_lib as Campagne,0 as nb_incidents_all,count(*) as nb_incidents_traited,SUM(dureetraitement)as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
	
	                  FROM
	
	                  (
	
	                  Select REQ.createdtime,REQ.campagne,REQ.op_lib,REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement,REQ.typeincidentid,REQ.groupid,
	
	                  TIMESTAMPDIFF(SECOND,REQ.datecreation, REQ.datetraitement)as dureetraitement
	
	                  FROM
	
	                  (
	
	                  SELECT C.createdtime,I.campagne,op_lib, I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,TI.typeincidentid,TI.groupid
	
	                  FROM vue_incident I,siprod_type_incidents TI,vue_tr_incindent T1, vue_crm C1, vue_crm C,operations
	
	                  WHERE (T1.statut = 'traited')
	
	                  AND C.crmid = I.incidentid
	
	                  AND C1.crmid = T1.traitementincidentid
	
	                  and Op_Id=  I.campagne 
	
	                  and C.deleted = 0
	
	                  and C1.deleted = 0
	
	                  AND I.ticket = T1.ticket
	
	                  AND I.typeincident= TI.typeincidentid
	
	                  GROUP BY I.ticket
	
	                  UNION
	
	                  SELECT C.createdtime,I.campagne,op_lib,T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,TI.typeincidentid,TI.groupid
	
	                  FROM vue_tr_incindent T, vue_incident I,siprod_type_incidents TI,vue_tr_incindent T1, vue_crm C1, vue_crm C,operations
	
	                  WHERE (T1.statut = 'traited')
	
	                  AND C.crmid = T.traitementincidentid
	
	                  AND C1.crmid = T1.traitementincidentid
	
	                  and Op_Id=  I.campagne
	
	                  and C.deleted = 0
	
	                  and C1.deleted = 0
	
	                  AND T.ticket = T1.ticket
	
	                  and T.ticket not in (
	
	                              select SI.ticket
	
	                              from vue_incident SI ,vue_crm CR 
	
	                              where CR.deleted = 0 and   CR.crmid = SI.incidentid 
	
	                              )
	
	                  AND T.statut = 'reopen'
	
	                  AND I.typeincident= TI.typeincidentid
	
	                  GROUP BY T.ticket
	
	                  ) 
	
	                  REQ
	
	                  )
	
	                  REQ2
	
	                  group by campagne,date_postage
	
	                  
	
	                  UNION 
	
	                  SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,count(*) as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
	                  from  vue_incident I, vue_crm C ,operations
	                  where crmid = incidentid 
	                  and   deleted = 0
	                  and statut='pending'
	                  and   op_id = campagne
	                  group by campagne,date_postage
	                 
	                  UNION
	
	                  SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,count(*) as  nb_Incidents_open,0 as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
	
	                  from  vue_incident I, vue_crm C ,operations
	
	                  where crmid = incidentid 
	
	                  and   deleted = 0
	
	                  and ((statut='open') or (statut='reopen'))
	
	                  and   op_id = campagne
	
	                  group by campagne,date_postage
	
	                  UNION
	
	                  
	
	                  SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,count(*) as  nb_incidents_transfered ,0 as  nb_incidents_dclosed
	                  from  vue_incident I, vue_crm C ,operations
	                  where crmid = incidentid 
	                  and   deleted = 0
	                  and (statut='transfered')
	                  and   op_id = campagne
	                  group by campagne,date_postage
	
	                  UNION
	
	                  SELECT DATE(createdtime) as date_postage,op_lib as Campagne,0 as nb_incidents_all,0 as nb_incidents_traited,0 as duree_traitement,0 as nb_incidents_pending,0 as  nb_Incidents_open,0 as  nb_incidents_transfered ,count(*) as  nb_incidents_dclosed
	                  from  vue_incident I, vue_crm C ,operations
	                  where crmid = incidentid 
	                  and   deleted = 0
	                  and statut='closed' 
	                  and I.ticket not in (select ticket from  vue_tr_incindent where statut='traited' )
	                  and   op_id = campagne
	                  group by campagne,date_postage

               ) siprod_reporting_incidents ";
					
if($where != '') {
	$list_query 		= " $list_query WHERE $where";
}
else
	$list_query 		= "$list_query where date_postage = DATE(now())";

$list_query = "$list_query Group by campagne,date_postage";

// Sorting
if($order_by) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY user_name '.$sorder;
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
		$list_query .= ' ORDER BY ' . $tablename . $order_by . ' ' . $sorder;
		
	}
}


//$countQuery = $adb->query( mkCountQuery($list_query) );
//$countQuery = $adb->query( $list_query_count );
//$recordCount= $adb->query_result($countQuery,0,'count');
$result = $adb->query($list_query);
$recordCount= $adb->num_rows($result);
//echo $list_query;
//$smarty->assign('LIST_QUERY', $list_query);
// Set paging start value.
$start = 1;
//if(isset($_REQUEST['start'])) { 
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

$list_result = $adb->query( $list_query . " LIMIT $limit_start_rec, $list_max_entries_per_page" );

$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $end_rec " . $app_strings['LBL_LIST_OF'] ." ".$recordCount;

$smarty->assign('RECORD_COUNTS', $record_string);
$smarty->assign("CUSTOMVIEW_OPTION",$customview_html);

// Navigation
$start = $_SESSION['lvs'][$currentModule]['start'];
$navigation_array = getNavigationValues($start, $recordCount, $list_max_entries_per_page);
$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string, $currentModule, 'index', $viewid);
$smarty->assign("NAVIGATION", $navigationOutput);

$listview_header = getListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);
$listview_entries = getListViewEntries($focus,$currentModule,$list_result,$navigation_array,'','','ListView','Delete',$customView);
$listview_header_search = getSearchListHeaderValues($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);

$smarty->assign('LISTHEADER', $listview_header);
$smarty->assign('LISTENTITY', $listview_entries);
$smarty->assign('SEARCHLISTHEADER',$listview_header_search);

// Module Search
//$alphabetical = AlphabeticalSearch($currentModule,'index',$focus->def_basicsearch_col,'true','basic','','','','',$viewid);
	
$fieldnames = getAdvSearchfields($currentModule);
$criteria = getcriteria_options();
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("CRITERIA", $criteria);

$smarty->assign("AVALABLE_FIELDS", getMergeFields($currentModule,"available_fields"));
$smarty->assign("FIELDS_TO_MERGE", getMergeFields($currentModule,"fileds_to_merge"));

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

$_SESSION[$currentModule.'_listquery'] = $list_query;

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else 
	$smarty->display('ListViewRI.tpl');

?>
