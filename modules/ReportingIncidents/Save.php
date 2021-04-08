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

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
$profilId=$_REQUEST['profilId'];
$raison=$_REQUEST['raison'];

if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}


if ($mode == 'add') {
	$allselectedboxes = $_REQUEST['allselectedboxes'];
	$allProfileSelectedBoxes = $_REQUEST['allProfileSelectedBoxes'];
	
	$tabAllselectedboxes = explode(';',$allselectedboxes);
	$tabAllProfileSelectedBoxes = explode(';',$allProfileSelectedBoxes);
	$focus->addUsersGID($tabAllselectedboxes, $tabAllProfileSelectedBoxes);
	$focus->insertIntoCrmEntity($currentModule);
}
elseif ($mode == 'edit') {
	$tabUsersGID = array("user_id"=>$record,"profilid"=>$profilId,"statut"=>1,"raison"=>'');
	$focus->updateUsersGID($tabUsersGID);
	$focus->insertIntoCrmEntity($currentModule);
}
else {
	$statut = 0;
	if ($mode == 'enable')
		$statut = 1;
	$tabUsersGID = array("user_id"=>$record,"profilid"=>$profilId,"statut"=>$statut,"raison"=>$raison);
	$focus->updateUsersGID($tabUsersGID);
	$focus->insertIntoCrmEntity($currentModule);
}

//$focus->save($currentModule);
$return_id = $focus->id;

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
	$return_action = "ListView";
}

if($_REQUEST['return_id'] != '') {
	$return_id = $_REQUEST['return_id'];
}

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);

?>