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

//checkFileAccess("modules/$currentModule/ListView.php");

if($_REQUEST["parenttab"]=="Demandes" && $_REQUEST["module"]=="TraitementDemandes")
{
	$_SESSION['DemandesAtraiter'] = 'true';
	include_once("modules/Demandes/ListView.php");

}	
else
	include_once("modules/$currentModule/ListView.php");
	
session_unregister('DemandesAtraiter');	
?>
