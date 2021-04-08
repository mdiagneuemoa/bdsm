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
require_once('bourseonline/phpmailer/MailCommon.php');

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


$datedem = $_REQUEST['datenaissance'];
$dt = new DateTime($datedem);
$date = $dt->format("Y-m-d");
$focus->column_fields['datenaissance'] = $date;

if ($_REQUEST['etab1formdatedeb']!='')
{
	$datedem1 = $_REQUEST['etab1formdatedeb'];
	$dt1 = new DateTime($datedem1);
	$date1 = $dt1->format("Y-m-d");
	$focus->column_fields['etab1formdatedeb'] = $date1;
}
if ($_REQUEST['etab1formdatefin']!='')
{
	$datedem2 = $_REQUEST['etab1formdatefin'];
	$dt2 = new DateTime($datedem2);
	$date2 = $dt2->format("Y-m-d");
	$focus->column_fields['etab1formdatefin'] = $date2;
}

if ($_REQUEST['etab2formdatedeb']!='')
{
	$datedem3 = $_REQUEST['etab2formdatedeb'];
	$dt3 = new DateTime($datedem3);
	$date3 = $dt3->format("Y-m-d");
	$focus->column_fields['etab2formdatedeb'] = $date3;
}
if ($_REQUEST['etab2formdatefin']!='')
{
	$datedem4 = $_REQUEST['etab2formdatefin'];
	$dt4 = new DateTime($datedem4);
	$date4 = $dt4->format("Y-m-d");
	$focus->column_fields['etab2formdatefin'] = $date4;
}

if ($_REQUEST['etab3formdatedeb']!='')
{
	$datedem5 = $_REQUEST['etab3formdatedeb'];
	$dt5 = new DateTime($datedem5);
	$date5 = $dt5->format("Y-m-d");
	$focus->column_fields['etab3formdatedeb'] = $date5;
}
if ($_REQUEST['etab3formdatefin']!='')
{
	$datedem6 = $_REQUEST['etab3formdatefin'];
	$dt6 = new DateTime($datedem6);
	$date6 = $dt6->format("Y-m-d");
	$focus->column_fields['etab3formdatefin'] = $date6;
}


$focus->column_fields['etab1formmontant'] = trim($focus->column_fields['etab1formmontant']);

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
	$candidat['nom'] = $_REQUEST['prenom'].' '.$_REQUEST['nom'];
	$candidat['email'] = $_REQUEST['email'];
	$result = sendNotificationCandidature($candidat);
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