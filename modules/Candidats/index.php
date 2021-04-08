<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $currentModule, $current_user;

if ($current_user->profilid==50) 
{
	checkFileAccess("modules/$currentModule/DetailView.php");
	include_once("modules/$currentModule/DetailView.php");
}
else
{
	checkFileAccess("modules/$currentModule/ListView.php");
	include_once("modules/$currentModule/ListView.php");
}

?>