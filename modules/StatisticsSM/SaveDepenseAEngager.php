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

//echo "reunionid=$reunionid";

foreach ($_REQUEST as $varname => $requestval)
{
	if (stripos($varname, 'cknaturesdepense') == 0 && $requestval == 'on')
	{
		$depenseinfos = explode('_',$varname);
		$comptnat = $depenseinfos[1];
		$linedep = $depenseinfos[2];
		$comptenats[$comptnat][$linedep]=1;
	}
}
$lignedepenses = $focus->getLignesDepenses($reunionid);
//print_r($lignedepenses);

for($i=0; $i<count($lignedepenses); $i++)
{
	$linedep = $lignedepenses[$i];
	if ($comptenats[$linedep['comptenat']][$linedep['linenum']]==1)
	{
		$params = array($reunionid,$linedep['comptenat'],$linedep['linenum']);
		$adb->pquery("update nomade_reunion_natdepenses set isdepensedb='1'  where reunionid=? and comptenat=? and linenum=?", $params);
		//echo $linedep['comptenat'],' - ',$linedep['linenum'],' -> ','isdepensedb=1','<br>';
	}
	else
	{
		$params = array($reunionid,$linedep['comptenat'],$linedep['linenum']);
		$adb->pquery("update nomade_reunion_natdepenses set isdepensedb='0'  where reunionid=? and comptenat=? and linenum=?", $params);
		//echo $linedep['comptenat'],' - ',$linedep['linenum'],' -> ','isdepensedb=0','<br>';

	}
}
//print_r($comptenats);
//break;

header("Location: index.php?action=Engagement&module=Reunion&record=$reunionid&parenttab=$parenttab");

?>