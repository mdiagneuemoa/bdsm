<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModuleglobal,$adb ;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
//require_once('modules/HReports/NotificationTraitement2.php');
//require_once('modules/HReports/NotificationTraitementNomade.php');
require_once('modules/HReports/NotificationTraitementNomade_delegation.php');

require_once('include/DatabaseUtil.php');

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

//SIPROD ADD
if($_REQUEST['statut']!='') 
	$focus->column_fields['statut'] = $_REQUEST['statut'];
//SIPROD ADD END

	
	
$ticket = $_REQUEST['ticket'];
$iddemande = getDemandeIdByTicket($_REQUEST['ticket']);

//echo "ticket=",$ticket,"  -- statut=",$_REQUEST['statut'];break;

//if($focus->existStatut($ticket , $_REQUEST['statut']) == 1 || ($focus->existStatut($ticket , $_REQUEST['statut']) == 0  && $mode == 'edit')){
	$focus->save($currentModule);
	$return_id = $focus->id;
	
	if ($_REQUEST['statut'] == 'om_cancelled')
	{
		$reqUpdate1= "update nomade_ordremission set deleted ='1',datedeleted=now() where omid= '".$iddemande."' " ;
		$adb->pquery($reqUpdate1, array());

	}
	$reqUpdate= "update nomade_demande set statut ='".$_REQUEST['statut']."' where ticket= '".$_REQUEST['ticket']."' " ;
	$adb->pquery($reqUpdate, array());


		//$mail_data = getRapportMailInfo($_REQUEST['ticket'],$focus->mode,$currentModule,$_REQUEST['statut']);
		//print_r($mail_data); break;
		//getRapportNotification($mail_data,$currentModule);
		// End envoi de notification 
		
	 $is_demandeMembreOrgane = $focus->is_demandeMembreOrgane($iddemande);
	 $mail_data = getRapportMailInfo($_REQUEST['ticket'],$focus->mode,$currentModule,$_REQUEST['statut']);
	$iniateurdepart = $mail_data['emailsinitiateur']['initiateur_depart'];
	if ($iniateurdepart=='03-00')
		sendNotificationCC($mail_data,$currentModule);
	elseif ($iniateurdepart=='02-00')
		sendNotificationCJ($mail_data,$currentModule);
	else
	{
		if($is_demandeMembreOrgane == 1) 
			sendNotificationMO($mail_data,$currentModule);
		else
			sendNotificationAgentDepart($mail_data,$currentModule);
	}
	
//}
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

// SIPROD ADD
if( isset($_REQUEST['dmd']) && $_REQUEST['dmd']!=''){
	$return_id = $_REQUEST['dmd'];
	$_REQUEST['dmd']='';
}
//$iddemande = getDemandeIdByTicket($_REQUEST['ticket']);
if ($_REQUEST['statut'] == 'om_cancelled')
{
	header("Location: index.php?action=DetailView&module=OrdresMission&record=$iddemande&parenttab=$parenttab#pos");

}
else{
	header("Location: index.php?action=DetailView&module=Demandes&record=$iddemande&parenttab=$parenttab#pos");
}
?>