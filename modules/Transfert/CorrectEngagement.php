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
require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];

$demandeid=$record;
$nextTicket=getNextTickectOM();

$infosOM = getInfosOM($demandeid);
$numeroom = $infosOM['numom'];



/************************* GESTION DES ENGAGEMENTS *********************************/
correctEngagementToOM($nextTicket,$demandeid); 

	echo "Veillez recr\351er l'engagement ";

/*********************************** FIN GESTION DES ENGAGEMENTS *******************************/

?>