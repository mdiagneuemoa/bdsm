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
require_once("modules/Reunion/Reunion.php");

require_once('include/DatabaseUtil.php');

$focus = new $currentModule();
$reunion_focus = new Reunion();

setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;



//SIPROD ADD
if($_REQUEST['statut']!='') 
	$focus->column_fields['statut'] = $_REQUEST['statut'];
//SIPROD ADD END

	
	
$ticket = $_REQUEST['ticket'];
$reunionid = $reunion_focus->getReunionIdByTicket($_REQUEST['ticket']);

$motif = $_REQUEST['motif'];
$autremotif = $_REQUEST['autremotif'];
$commentaire = $_REQUEST['commentaire'];
//$reunionid = $_REQUEST['record'];
//echo "ticket=",$ticket,"  -- statut=",$_REQUEST['statut'],"  -- record=",$_REQUEST['record'];
//print_r($focus->column_fields);break;
	$focus->save($currentModule);
	$return_id = $focus->id;
		
	$reqUpdate= "update nomade_reunion set statut ='".$_REQUEST['statut']."' where ticket= '".$_REQUEST['ticket']."' " ;
	$adb->pquery($reqUpdate, array());

	//$mail_data = $reunion_focus->getRapportMailInfo($_REQUEST['ticket'],$_REQUEST['statut']);
	//$mail_data['motif'] = $reunion_focus->getMotifRejetById($motif);
	//$mail_data['autremotif'] = $autremotif;
	//$mail_data['commentaire'] = $commentaire;
	//$reunion_focus->sendNotificationReunion($mail_data,$currentModule);
	
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
	
header("Location: index.php?action=DetailView&module=Reunion&record=$reunionid&parenttab=$parenttab#pos");

?>