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
require_once('modules/HReports/NotificationTraitement.php');
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

/*
	$focus->save($currentModule);
	$return_id = $focus->id;
	$reqUpdate= "update siprod_demande set statut ='".$_REQUEST['statut']."' where ticket= '".$_REQUEST['ticket']."' " ;
	$adb->pquery($reqUpdate, array());

	// envoi de notification 
	if($focus->statut!= 'closed'){
		$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule);
		getRapportNotification($mail_data,$currentModule);
		// End envoi de notification 
	}
*/
$ticket = $_REQUEST['ticket'];
if($focus->existStatut($ticket , $_REQUEST['statut']) == 1 || ($focus->existStatut($ticket , $_REQUEST['statut']) == 0  && $mode == 'edit')){
	$focus->save($currentModule);
	$return_id = $focus->id;
	$reqUpdate= "update siprod_demande set statut ='".$_REQUEST['statut']."' where ticket= '".$_REQUEST['ticket']."' " ;
	$adb->pquery($reqUpdate, array());

	// envoi de notification 
	if($focus->statut!= 'closed'){
		$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule);
		getRapportNotification($mail_data,$currentModule);
		// End envoi de notification 
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
// SIPROD ADD
if( isset($_REQUEST['dmd']) && $_REQUEST['dmd']!=''){
	$return_id = $_REQUEST['dmd'];
	$_REQUEST['dmd']='';
}
// SIPROD ADD END
//header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);

if( $mode == "traiter" ) {
	header("Location: index.php?module=TraitementDemandesOM&action=index&parenttab=Demandes");
}
elseif( $mode == "cloturer" || $mode == "reopen" ) {
	header("Location: index.php?module=SuiviDemandes&action=index&parenttab=Demandes");
}
elseif($mode == "traited&transfered") {
	$ticket = $_REQUEST['ticket'];
	header("Location: index.php?module=TraitementDemandesOM&opt=trsnfrt&action=EditView&dmd=$return_id&statut=transfered&ticket=$ticket&return_module=TraitementDemandesOM&return_action=index&parenttab=Demandes&return_viewname=");
}
elseif($mode == "transfered") {
	header("Location: index.php?module=TraitementDemandesOM&action=index&parenttab=Demandes");
}
else {
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
}

?>