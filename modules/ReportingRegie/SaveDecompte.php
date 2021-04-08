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

$iddemande = $_REQUEST['demandeid'];
$nbzonetrajet = $_REQUEST['nbzonetrajet'];

//$adb->pquery("delete from nomade_decompte where iddemande=?",$iddemande);

 for($k=0; $k<$nbzonetrajet; $k++)
 {
		$zone = 'zonetrajet_'.$k;
		$nbjindemn = 'nbjindemn_'.$k;
		$indemnite = 'indemnite_'.$k;
		$nbjheberg = 'nbjheberg_'.$k;
		$herbergement = 'herbergement_'.$k;
		$nbjtransp = 'nbjtransp_'.$k;
		$transport = 'transport_'.$k;
		$params2 = array($iddemande,$_REQUEST[$zone]);
        $adb->pquery("update nomade_decompte set nbjindemn='".$_REQUEST[$nbjindemn]."',tauxindemn='".$_REQUEST[$indemnite]."',nbjheberg='".$_REQUEST[$nbjheberg]."',tauxheberg='".$_REQUEST[$herbergement]."',nbjtransp='".$_REQUEST[$nbjtransp]."',tauxtransp='".$_REQUEST[$transport]."' where iddemande=? and lieu=?", $params2);
			
}


header("Location: index.php?action=DetailView&module=OrdresMission&record=$iddemande&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
?>