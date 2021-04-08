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

/*
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

if($where != '') {
	$list_query = "$list_query AND $where";
}

// Sorting
if($order_by) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY user_name '.$sorder;
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
		$list_query .= ' ORDER BY ' . $tablename . $order_by . ' ' . $sorder;
	}
}

$countQuery = $adb->query( mkCountQuery($list_query) );
$recordCount= $adb->query_result($countQuery,0,'count');

// Set paging start value.
$start = 1;
if(isset($_REQUEST['start'])) { $start = $_REQUEST['start']; } 
else { $start = $_SESSION['lvs'][$currentModule]['start']; }
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

$_SESSION[$currentModule.'_listquery'] = $list_query;

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else 
	$smarty->display('ListView.tpl');
*/

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$tool_buttons = Button_Check($currentModule);

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];
$tabid = getTabid($currentModule);
$category = getParentTab($currentModule);

if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
if($isduplicate == 'true') $focus->id = '';

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', getTranslatedString($currentModule)); 
$smarty->assign('CATEGORY', $category);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);

$recordName = array_values(getEntityName($currentModule, $focus->id));
$recordName = $recordName[0];
$smarty->assign('NAME', $recordName);
$smarty->assign('UPDATEINFO',updateInfo($focus->id));


$nbIncidentsDeclares = $focus->getNbIncidentsDeclares();
$nbIncidentsTraitesDansDelai = $focus->getNbIncidentsTraitesDansDelai();
$nbIncidentsTraitesAuDelaDelai = $focus->getNbIncidentsTraitesAuDelaDelai();
$nbIncidentsEnSouffrance = $focus->getNbIncidentsEnSouffrance();

$incidentsTauxTraitement = ($nbIncidentsDeclares != 0) ? (($nbIncidentsTraitesDansDelai + $nbIncidentsTraitesAuDelaDelai) * 100 / $nbIncidentsDeclares) : 0;
$incidentsTauxTraitement = number_format($incidentsTauxTraitement, 2, '.', '');

$incidentsDureeMoyenneTraitement = $focus->getIncidentsDureeMoyenneTraitement();
$incidentsDureeMoyenneTraitement = number_format($incidentsDureeMoyenneTraitement, 2, '.', '');

$incidentsOrigineInterne = $focus->getIncidentsOrigineInterne();
$incidentsOrigineExterne = $focus->getIncidentsOrigineExterne();

$smarty->assign('INCIDENTS_NB_DECLARES', $nbIncidentsDeclares);
$smarty->assign('INCIDENTS_NB_TRAITES_DANS_DELAIS', $nbIncidentsTraitesDansDelai);
$smarty->assign('INCIDENTS_NB_TRAITES_AU_DELA_DELAIS', $nbIncidentsTraitesAuDelaDelai);
$smarty->assign('INCIDENTS_NB_EN_SOUFFRANCE', $nbIncidentsEnSouffrance);
$smarty->assign('INCIDENTS_TAUX_TRAITEMENT', $incidentsTauxTraitement."%");
$smarty->assign('INCIDENTS_DUREE_MOYENNE_TRAITEMENT', $incidentsDureeMoyenneTraitement." min");
$smarty->assign('INCIDENTS_NB_ORIGINE_INTERNE', $incidentsOrigineInterne);
$smarty->assign('INCIDENTS_NB_ORIGINE_EXTERNE', $incidentsOrigineExterne);



/*
$nbDemandesDeclares = $focus->getNbDemandesDeclares();
$nbDemandesTraitesDansDelai = $focus->getNbDemandesTraitesDansDelai();
$nbDemandesTraitesAuDelaDelai = $focus->getNbDemandesTraitesAuDelaDelai();
$nbDemandesEnSouffrance = $focus->getNbDemandesEnSouffrance();

$demandesTauxTraitement = ($nbDemandesDeclares != 0) ? ($nbDemandesTraitesDansDelai + $nbDemandesTraitesAuDelaDelai) * 100 / $nbDemandesDeclares : 0;
$demandesTauxTraitement = number_format($demandesTauxTraitement, 2, '.', '');

$demandesDureeMoyenneTraitement = $focus->getDemandesDureeMoyenneTraitement();
$demandesDureeMoyenneTraitement = number_format($demandesDureeMoyenneTraitement, 2, '.', '');

$demandesOrigineInterne = $focus->getDemandesOrigineInterne();
$demandesOrigineExterne = $focus->getDemandesOrigineExterne();

$smarty->assign('DEMANDES_NB_DECLARES', $nbDemandesDeclares);
$smarty->assign('DEMANDES_NB_TRAITES_DANS_DELAIS', $nbDemandesTraitesDansDelai);
$smarty->assign('DEMANDES_NB_TRAITES_AU_DELA_DELAIS', $nbDemandesTraitesAuDelaDelai);
$smarty->assign('DEMANDES_NB_EN_SOUFFRANCE', $nbDemandesEnSouffrance); 
$smarty->assign('DEMANDES_TAUX_TRAITEMENT', $demandesTauxTraitement."%");
$smarty->assign('DEMANDES_DUREE_MOYENNE_TRAITEMENT', $demandesDureeMoyenneTraitement." min");
$smarty->assign('DEMANDES_NB_ORIGINE_INTERNE', $demandesOrigineInterne);
$smarty->assign('DEMANDES_NB_ORIGINE_EXTERNE', $demandesOrigineExterne);

$nbIncidentsDemandesDeclares = $nbIncidentsDeclares + $nbDemandesDeclares;

$smarty->assign('NB_INCIDENTS_DEMANDES_DECLARES', $nbIncidentsDemandesDeclares);
*/

$smarty->assign("FILTERGROUPNAME", getAllGroupeTraiement());
$smarty->assign("FILTERSTATUT", getAllStatut());
$smarty->assign("FILTERTYPOLOGIE", getAllTypeIncident());
$smarty->assign("FILTERCAMPAGNE", getAllCampagne());

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
{
	$smarty->assign('INCIDENTS_NB_DECLARES', $nbIncidentsDeclares);
	$smarty->display('StatisticsIncidents.tpl');
}
$smarty->display('StatisticsIncidents.tpl');

?>
