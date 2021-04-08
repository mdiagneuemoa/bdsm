<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule, $adb;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
$ticket = $_REQUEST['ticket'];
$opt = $_REQUEST['opt'];

if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

if($opt == "relancer" ){
	$return_id = $record;
	// Envoi de notification 
	
	$mail_data = getRapportMailInfo($return_id, "relance", $currentModule);
	getRapportNotification($mail_data, $currentModule);
		
	$date_var = date('Y-m-d H:i:s');
	$reqUpdate= "update siprod_demande set relanced = ? where ticket = ? ";
	$adb->pquery($reqUpdate, array($adb->formatDate($date_var, true), $ticket));
	
	// End envoi de notification 
}
else {
	$focus->save($currentModule);
	$return_id = $focus->id;
}
$search=$_REQUEST['search_url'];

if($_REQUEST['parenttab'] != '')     $parenttab = $_REQUEST['parenttab'];
if($_REQUEST['return_module'] != '') {
	$return_module = $_REQUEST['return_module'];
} else {
	$return_module = $currentModule;
}

if($_REQUEST['return_action'] != '') {
	$return_action = $_REQUEST['return_action'];
} else {
	$return_action = "DetailView";
}

if($_REQUEST['return_id'] != '') {
	$return_id = $_REQUEST['return_id'];
}

if( $mode == "relancer" ) {
	header("Location: index.php?module=SuiviDemandes&action=index&parenttab=Demandes");
}
else {
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
}
?>