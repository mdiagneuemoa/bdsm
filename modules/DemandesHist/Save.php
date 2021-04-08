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
//require_once('modules/HReports/HReportsCommon.php');
require_once('modules/HReports/NotificationTraitementNomade_delegation.php');

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

$datedebutStr = $_REQUEST['datedebut'];
if(isset($datedebutStr) && $datedebutStr != '') {
	$datedebutIns = new DateTime($datedebutStr);
	$datedebut = $datedebutIns->format("Y-m-d");
			
	$focus->column_fields['datedebut'] = $datedebut;
} 

$datefinStr = $_REQUEST['datefin'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$datefin = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['datefin'] = $datefin;
} 

$ticket = $_REQUEST['ticket'];
if($focus->existTicket($ticket) == 1  || ($focus->existTicket($ticket) == 0  && $mode == 'edit')) {
	if($mode != 'edit'){
		$RealTicket = getNextTickectDemande();
		$focus->column_fields['ticket'] = $RealTicket ;
	}
	$focus->save($currentModule);
	$return_id = $focus->id;
	
	//$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule,$focus->column_fields['campagne']);
	//getRapportNotification($mail_data,$currentModule);
	
	if($mode != 'edit')
	{
		 $is_demandeMembreOrgane = $focus->is_demandeMembreOrgane($return_id);
		$mail_data = getRapportMailInfo($focus->column_fields['ticket'],$focus->mode,$currentModule,$focus->column_fields['statut']);
		//print_r($mail_data);break;
		$iniateurdepart = $mail_data['emailsinitiateur']['initiateur_depart'];
		if ($iniateurdepart=='03-00')
			sendNotificationCC($mail_data,$currentModule);
		elseif ($iniateurdepart=='02-00')
			sendNotificationCJ($mail_data,$currentModule);
		elseif ($iniateurdepart=='04-00')
			sendNotificationCIP($mail_data,$currentModule);	
		else
		{
			if($is_demandeMembreOrgane == 1) 
				sendNotificationMO($mail_data,$currentModule);
			else
				sendNotificationAgentDepart($mail_data,$currentModule);
		}
	}
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
header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
?>