<?php
/***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule;
global $adb;
checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;
if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}
if($_REQUEST['bailleurs2'] != '') {
	$focus->column_fields['bailleurs'] = $_REQUEST['bailleurs'].'|'.$_REQUEST['bailleurs2'];
	$focus->column_fields['bailleursrate'] = $_REQUEST['bailleursrate'].'|'.$_REQUEST['bailleursrate2'];
}

$datedem = $_REQUEST['datedemarrage'];
$dt = new DateTime($datedem);
$date = $dt->format("Y-m-d");
$focus->column_fields['datedemarrage'] = $date;

$focus->column_fields['montant'] = trim($focus->column_fields['montant']);

//print_r($focus->column_fields['filename']);break;

if($_REQUEST['statut']!='') 
	$focus->column_fields['statut'] = $_REQUEST['statut'];

$ticket = $_REQUEST['ticket'];

if($focus->existTicket($ticket) == 1 || ($focus->existTicket($ticket) == 0  && $mode == 'edit')){
	if($mode != 'edit'){
		$RealTicket = getNextMatriculeConvention();
		$focus->column_fields['ticket'] = $RealTicket ;
	}
}	
	$focus->save($currentModule);
	$return_id = $focus->id;
	//$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule,$focus->column_fields['campagne']);
	//getRapportNotification($mail_data,$currentModule);


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

if($mode == "traiter") {
	header("Location: index.php?module=TraitementConventions&action=index&parenttab=Conventions");
}
else {
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
}
?>