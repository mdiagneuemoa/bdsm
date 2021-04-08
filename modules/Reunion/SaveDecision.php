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

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$reunionid = $_REQUEST['reunionid'];

	$params2 = array($reunionid);
        $adb->pquery("update nomade_reunion set regisseur='".$_REQUEST['regisseur']."',numdecision='".$_REQUEST['numdecision']."' where reunionid=? ", $params2);


header("Location: index.php?action=DetailView&module=Reunion&record=$reunionid&parenttab=$parenttab");
?>