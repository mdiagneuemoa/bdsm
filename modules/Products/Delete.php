<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $currentModule;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$focus = new $currentModule();

$record = $_REQUEST['record'];
$module = $_REQUEST['module'];
$return_module = $_REQUEST['return_module'];
$return_action = $_REQUEST['return_action'];
$parenttab = $_REQUEST['parenttab'];
$return_id = $_REQUEST['return_id'];

//Added to fix 4600
$url = getBasic_Advance_SearchURL();

if(!isset($record))
	die(getTranslatedString('ERR_DELETE_RECORD'));
if($return_module!="Products" || ($return_module=="Products" && empty($return_id)))
	DeleteEntity($currentModule, $return_module, $focus, $record, $return_id);
else
	$focus->deleteProduct2ProductRelation($record, $return_id, $_REQUEST['is_parent']);

if($_REQUEST['parenttab']) $parenttab = $_REQUEST['parenttab'];

if(isset($_REQUEST['activity_mode']))
	$url .= '&activity_mode='.$_REQUEST['activity_mode'];

header("Location: index.php?module=$return_module&action=$return_action&record=$return_id&parenttab=$parenttab&relmodule=$module".$url);

?>