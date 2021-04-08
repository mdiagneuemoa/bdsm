<?php
/***********************************************************************************
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
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

$datedebutStr = $_REQUEST['datedepart'];
if(isset($datedebutStr) && $datedebutStr != '') {
	$datedebutIns = new DateTime($datedebutStr);
	$datedepart = $datedebutIns->format("Y-m-d");
			
	$focus->column_fields['datedepart'] = $datedepart;
} 

$datefinStr = $_REQUEST['datearrivee'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$datearrivee = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['datearrivee'] = $datearrivee;
} 

$datefinStr = $_REQUEST['trajet1date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet1date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet1date'] = $trajet1date;
} 
$datefinStr = $_REQUEST['trajet2date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet2date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet2date'] = $trajet2date;
} 

$datefinStr = $_REQUEST['trajet3date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet3date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet3date'] = $trajet3date;
} 

$datefinStr = $_REQUEST['trajet4date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet4date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet4date'] = $trajet4date;
} 

$datefinStr = $_REQUEST['trajet5date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet5date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet5date'] = $trajet5date;
} 

$datefinStr = $_REQUEST['trajet6date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet6date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet6date'] = $trajet6date;
} 

$datefinStr = $_REQUEST['trajet7date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet7date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet7date'] = $trajet7date;
} 

$datefinStr = $_REQUEST['trajet8date'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$trajet8date = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['trajet8date'] = $trajet8date;
} 

$datecreat = new DateTime(date());
$datecreation = $datecreat->format("Y-m-d");
$focus->column_fields['datecreation'] = $datecreation;

$ticket = $_REQUEST['ticket'];
if($focus->existTicket($ticket) == 1  || ($focus->existTicket($ticket) == 0  && $mode == 'edit')) {
	if($mode != 'edit'){
		$RealTicket = getNextTickectOM();
		$focus->column_fields['ticket'] = $RealTicket ;
	}
	$focus->save($currentModule);
	$return_id = $focus->id;
		
	$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule,$focus->column_fields['campagne']);
	getRapportNotification($mail_data,$currentModule);
	
	$reqUpdate= "update nomade_demande set statut ='omgenered' where demandeid= '".$return_id."' " ;
	$adb->pquery($reqUpdate, array());
	
}
$omid = $focus->id;
$decomptes = getDecompteBydemande2($omid);
saveDecompte($decomptes,$omid);


$search=$_REQUEST['search_url'];
/*
if($_REQUEST['parenttab'] != '')     $parenttab = $_REQUEST['parenttab'];
if($_REQUEST['return_module'] != '') {
	$return_module = $_REQUEST['return_module'];
} else {
	$return_module = $currentModule;
}*/
$return_module = $currentModule;

if($_REQUEST['return_action'] != '') {
	$return_action = $_REQUEST['return_action'];
} else {
	$return_action = "DetailView";
}

if($_REQUEST['return_id'] != '') {
	$return_id = $_REQUEST['return_id'];
}
header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
?>