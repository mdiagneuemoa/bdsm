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
require_once('modules/HReports/NotificationTraitement.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
//$statut = $_REQUEST['statut'];
//echo "Mode : $mode, Statut : $statut"; break;

if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;


if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

//SIPROD ADD
if($_REQUEST['statut']!='') $focus->column_fields['statut'] = $_REQUEST['statut'];
//SIPROD ADD END

$datepaiement = $_REQUEST['datepaiement'];
$dt = new DateTime($datepaiement);
$date = $dt->format("Y-m-d");
$focus->column_fields['datepaiement'] = $date;
//$focus->save($currentModule);

$search=$_REQUEST['search_url'];

if($_REQUEST['parenttab'] != '')     $parenttab = $_REQUEST['parenttab'];
if($_REQUEST['return_module'] != '') {
	$return_module = $_REQUEST['return_module'];
} else {
	$return_module = $currentModule;
}


	$return_id = $record;

	header("Location: index.php?action=CallRelatedList&module=Conventions&record=$return_id&parenttab=Conventions");
	//header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);

?>