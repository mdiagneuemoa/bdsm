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


$list_query = " SELECT conventionid,ticket,statut,CONCAT(sigc_domaines.domainelibelle,'(',sigc_type_activites.typeactivitelib,')') as domaine,typeactivite,montant,libellecourt libelle,datedemarrage,organe,bailleurs,agenceexecution
						FROM sigc_convention
						INNER JOIN sigc_domaines  ON sigc_convention.domaine=sigc_domaines.domainecode 
						INNER JOIN sigc_type_activites ON sigc_convention.typeactivite=sigc_type_activites.typeactiviteid ";
						
$date_start_val = $_REQUEST['date_start'];
$date_end_val = $_REQUEST['date_end'];

$d = new DateTime($date_start_val);
$date_start = $d->format("Y-m-d");

$d = new DateTime($date_end_val);
$date_end = $d->format("Y-m-d");
		
$d = new DateTime();
$current_date = $d->format("d-m-Y");

if(($date_start == $date_end && $current_date == $date_end) || $_REQUEST['ajax'] == '') {

	//$list_query .= " AND YEAR(DATE_FORMAT(datesignature,'%Y-%m-%d')) = YEAR(DATE_FORMAT(now(),'%Y-%m-%d'))";
	$list_query .= " AND datesignature <= DATE('".$date_end."')";

}
else
{	
	$agence = $_REQUEST['filter_agence_field'];
	$domaine = $_REQUEST['filter_domaine_field'];
	$organe = $_REQUEST['filter_organe_field'];
	$localite = $_REQUEST['filter_localite_field'];
	$programme = $_REQUEST['filter_programme_field'];
	$politique = $_REQUEST['filter_politique_field'];
	
	if($organe!='' && $organe!='000')
	{
		$list_query .= " INNER JOIN sigc_dossiers ON sigc_dossiers.dossiercode=sigc_convention.projetid AND = sigc_dossiers.organecode='".$organe."'";
 
	}
	
	if($programme!='' && $programme!='000')
	{
		$list_query .= " INNER JOIN sigc_dossiers ON sigc_dossiers.dossiercode=sigc_convention.projetid 
						AND sigc_dossiers.dossierparent LIKE CONCAT('%:','".$programme."',':',sigc_dossiers.dossiercode) ";

	}
	 
	if($politique!='' && $politique!='000')
	{
		$list_query .= " INNER JOIN sigc_dossiers ON sigc_dossiers.dossiercode=sigc_convention.projetid 
						AND sigc_dossiers.dossierparent LIKE CONCAT('".$politique."',':%:',sigc_dossiers.dossiercode) ";

	}
	
	if($agence!='' && $agence!='000')
	{
		$list_query .= "  AND sigc_convention.agenceexecution = '".$agence."'";

	}
	
	if($domaine!='' && $domaine!='000')
	{
		$list_query .= "  AND sigc_convention.domaine = '".$domaine."'";

	}
	if($localite!='' && $localite!='000')
	{
		$list_query .= " AND SUBSTR(sigc_convention.localite,1,2) = '".$localite."'";

	}
	
    $list_query .= " AND (datesignature BETWEEN DATE('".$date_start."') AND DATE('".$date_end."'))";
}						

/*
if($where != '') {
	$list_query = "$list_query AND $where";
}
if($_REQUEST['ajax'] != '' && $_REQUEST['domaine_field'] != '') {
	$list_query = " $list_query  and sigc_convention.domaine='".$_REQUEST['domaine_field']."'";
}
*/

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

$recordCount= $adb->num_rows($adb->query($list_query));

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
	$list_result = $adb->query( $list_query );
	$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $recordCount" . $app_strings['LBL_LIST_OF'] ." ".$recordCount;

/*}
else
{
	$list_result = $adb->query( $list_query . " LIMIT $limit_start_rec, $list_max_entries_per_page" );
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
$listview_entries = getListViewEntriesReportingConventions($focus,$currentModule,$list_result,$navigation_array,'','','EditView','Delete',$customView);
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

// JOKCALL : Critères de filtre sur le tableau - Début

	$smarty->assign("PROJECTS", getAllProjectsByOrgane("1-5"));
	$smarty->assign("AGENCESEXECUTION", getAllAgencesExecution());
	$smarty->assign("DOMAINES", getAllDomaines());
	$smarty->assign("TYPESACTIVITE", getAllTypesActivite());
	$smarty->assign("ORGANES", getAllOrganes());
	$smarty->assign("LOCALITESPAYS", getAllLocalitesPays());
	$smarty->assign("PROGRAMMES", getAllProgrammes());
	$smarty->assign("POLITIQUES", getAllPolitiques());
	
	// Tranche : Début
	
	
$smarty->assign("TRANCHE", array(
                                /*1 => $app_strings['LBL_JOKCALL_TRANCHE_QUATER'],*/
                                2 =>  $app_strings['LBL_JOKCALL_TRANCHE_HORAIRE'],
                                3 =>  $app_strings['LBL_JOKCALL_TRANCHE_DAY']));
$smarty->assign("DEFAULT_SELECTED", 3);
                                
	// Tranche : Fin

$smarty->assign("FILTERHEURES", $FILTERHEURES);
//$smarty->assign("FILTERMINUTES", getAllMinutes());

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("DATEDEBUT",date('d-m-Y', strtotime('-4 year')));

$smarty->assign('NB_RECORDS', $recordCount);

$smarty->assign("LIST_QUERY",$list_query);
$smarty->assign("CAMPAGNE", $CURRENT_CAMPAGNE);

// JOKCALL : Critères de filtre sur le tableau - Fin

$_SESSION[$currentModule.'_listquery'] = $list_query;

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntriesReportingConventions.tpl");
else 
	$smarty->display('ListViewReportingConventions.tpl');

?>
