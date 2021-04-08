<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once('modules/HReports/NotificationTraitementNomade.php');

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

$focus->column_fields['codedirection']=getDirectionAgent($focus->column_fields['matdirecteur']);
$iscommissaire = is_Commissaire($focus->column_fields['matdirecteur'],$focus->column_fields['codedirection']);
if ($iscommissaire =='1')
	$focus->column_fields['iscommissaire'] = 1;
else 
	$focus->column_fields['iscommissaire'] = 0;

$focus->column_fields['active']=1;
//print_r($focus->column_fields);break;
$focus->save($currentModule);
$return_id = $focus->id;


//$mail_data = getRapportMailInfo($_REQUEST['ticket'],$focus->mode,$currentModule,$_REQUEST['statut']);
		//print_r($mail_data); break;
//getRapportNotification($mail_data,$currentModule);
		// End envoi de notification 
	

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