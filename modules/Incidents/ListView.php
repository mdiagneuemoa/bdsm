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
global $dbconfig;

require_once('Smarty_setup.php');
require_once('include/ListView/ListView.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

if( $currentModule == 'TraitementIncidents' || $currentModule == 'SuiviIncidents' )
	$currentModule = 'Incidents';

//checkFileAccess("modules/$currentModule/$currentModule.php");
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
	list($where, $ustring) = split('#@@#', basicFilter($category));
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
$list_query_count="";
$listquery = $focus->getListQuery($currentModule);
$list_query= $customView->getModifiedCvListQuery($viewid, $listquery, $currentModule);


$dateStart = (isset($_REQUEST['date_start']) && $_REQUEST['date_start'] != '') ? $_REQUEST['date_start'] : '';
$dateEnd = (isset($_REQUEST['date_end']) && $_REQUEST['date_end'] != '') ? $_REQUEST['date_end'] : '';


$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

$viewIncident = "";
$viewIncidentCrmentity = "";
$viewTraitementIncident = "";
$viewTrIncidentCrmentity = "";
	
if ($isQueryRangeAll) {
	$viewIncident = $dbconfig['gid_incident'];
//	$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
	$viewTraitementIncident = $dbconfig['gid_traitement_incident'];
//	$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];
}
$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];
	
$disp = "DateStart = $dateStart, DateEnd = $dateEnd,  ViewIncident = $viewIncident, ViewIncidentCrmentity = $viewIncidentCrmentity, ViewTraitementIncident = $viewTraitementIncident, ViewTrIncidentCrmentity = $viewTrIncidentCrmentity, IsQueryRangeAll = $isQueryRangeAll, State = $state <br/>";
$smarty->assign('FILTRE_QUERY', $disp);


//$_SESSION['fromListAll'] = 'YES';
if( ( $current_user->isTraiteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) &&  $module == 'TraitementIncidents'  ){
	$list_query = "SELECT DISTINCT siprod_incident.ticket, siprod_incident.typeincident, siprod_type_incidents.nom,
			siprod_incident.statut, vtiger_crmentity.createdtime, 
			siprod_incident.campagne, vtiger_crmentity.crmid,siprod_incident.popimpactee,
			siprod_incident.relanced, siprod_incident.modefonctionnement, siprod_incident.all_ccx_affected 
			FROM $viewIncident siprod_incident
			INNER JOIN $viewIncidentCrmentity vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid
			INNER JOIN siprod_type_incidents ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident 
			";
	
	    // restriction au user connect� � modofier pour tenir en compte des incidents du groupe
	    if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	    	$list_query = $list_query." 
	    	INNER JOIN $viewTraitementIncident siprod_traitement_incidents ON siprod_traitement_incidents.ticket = siprod_incident.ticket 
			INNER JOIN vtiger_groups g ON instr(concat(' ', siprod_type_incidents.groupid, ' '), concat(' ', g.groupid, ' ')) > 0
			WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
			or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id))
			And vtiger_crmentity.deleted =0 
			
			or ( 
				siprod_traitement_incidents.statut = 'transfered'and siprod_incident.statut='transfered'
				and  (siprod_traitement_incidents.destination in (select groupid from vtiger_users2group where userid = 6856260) 
      			or siprod_traitement_incidents.destination in (select groupid from siprod_groupsupcoord where supid = 6856260))
      		)			
			";		     
	    
	    	//$list_query_count = "SELECT count(*) as count FROM ( ".$list_query." ) as total";
	    	
	    }
	    else	
		    $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";	

}
elseif( ($current_user->isPosteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 )  && $module == 'SuiviIncidents'  ){
	$list_query = "SELECT DISTINCT siprod_incident.ticket, siprod_incident.typeincident, 
		siprod_incident.statut, vtiger_crmentity.createdtime, 
		siprod_incident.campagne, vtiger_crmentity.crmid,siprod_incident.popimpactee,
		siprod_incident.relanced, siprod_incident.modefonctionnement, siprod_incident.all_ccx_affected 
		FROM $viewIncident siprod_incident
		INNER JOIN $viewIncidentCrmentity vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid
		INNER JOIN siprod_type_incidents ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident
		";
	   // restriction au user connect�
	   if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	   		$list_query = $list_query." INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid ";
		    $list_query = $list_query."  WHERE vtiger_crmentity.deleted =0  and users.user_id=".$current_user->id;
        } 
        else{
		   $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";
        }   		
		

}

if(  $module == 'Incidents'   ){
	$list_query = "SELECT DISTINCT
		siprod_incident.ticket,
		siprod_incident.typeincident,
		siprod_incident.statut,
		vtiger_crmentity.createdtime,
		siprod_incident.campagne,
		siprod_incident.popimpactee,
		siprod_incident.modefonctionnement,
		siprod_incident.all_ccx_affected,
		siprod_incident.relanced, 
		vtiger_crmentity.crmid 
		FROM $viewIncident siprod_incident
		INNER JOIN $viewIncidentCrmentity vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid
		INNER JOIN siprod_type_incidents ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident
		WHERE vtiger_crmentity.deleted =0 ";
}

$smarty->assign('AJAXWHERE', $where);
$smarty->assign('AJAXURLSTRING', $url_string);

if($where != '') {
	$list_query = "$list_query AND $where";
}

// Sorting
if($order_by) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY user_name '.$sorder;
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
		$list_query .= ' ORDER BY ' .  $order_by . ' '.$sorder; //. $sorder;
	}
}

$countQuery = $adb->query( mkCountQuery($list_query) );
$recordCount= $adb->query_result($countQuery,0,'count');

$req = $adb->pquery($list_query, array());
$recordCount=$adb->num_rows($req);
	
// Set paging start value.
$start = 1;

//if(isset($_REQUEST['start'])) { $start = $_REQUEST['start']; } 
//else { $start = $_SESSION['lvs'][$currentModule]['start']; }


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
$listview_entries = getListViewEntries($focus,$currentModule,$list_result,$navigation_array,'','','EditView','Delete',$customView);
$listview_header_search = getSearchListHeaderValues($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);

$smarty->assign('LISTHEADER', $listview_header);
$smarty->assign('LISTENTITY', $listview_entries);
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

$smarty->assign("FILTERGROUPNAME", getAllGroupeTraiement());
$smarty->assign("FILTERSTATUT", getAllStatut());
$smarty->assign("FILTERTYPOLOGIE", getAllTypeIncident());
$smarty->assign("FILTERCAMPAGNE", getAllCampagne());

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

$_SESSION[$currentModule.'_listquery'] = $list_query;
$smarty->assign('LIST_QUERY', $list_query);

// Add for url
if($_SESSION['IncidentsAtraiter'] == 'true')
	$smarty->assign('RIGHT_LABEL', 'TraitementIncidents');
elseif($_SESSION['IncidentsASuivre'] == 'true')
	$smarty->assign('RIGHT_LABEL', 'SuiviIncidents');

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else 
	$smarty->display('ListView.tpl');

?>
