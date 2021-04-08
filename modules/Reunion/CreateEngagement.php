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
//require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];

$reunionid=$record;
//echo "reunionid=",$reunionid;break;

$infosReunion = $focus->getInfosByReunionById($reunionid);
$numreunion = $infosReunion['ticket'];
$codebudget=$infosReunion['codebudget'];
$sourcefin = $infosReunion['sourcefin'];
$depart = $infosReunion['departement'];

$infosengagement['mataaf'] = $infosReunion['responssuivi'];
$infosengagement['beneficiaire'] = 'REUNION '.$infosReunion['departementsigle'].' N°:'.$numreunion.' du '.$infosReunion['datecreation'];
//print_r($infosengagement);break;

$infosengagement['numreunion'] = $numreunion;
$infosengagement['societedepart'] = $focus->getSocieteSapDepart($depart);
$infosengagement['objetreunion'] = $page = str_replace("'", " ",$infosReunion['objet']);
$infosengagement['objetreunion'] = $page = str_replace('"', ' ',$infosReunion['objet']);
$infosengagement['objetreunion'] = preg_replace("#\n|\t|\r#"," ",$infosengagement['objetreunion']);
$infosengagement['codefournregisseur'] = $infosReunion['codefournregisseur'];

$infosengagement['curentuserloginsap'] = $current_user->user_login;
$natdepensesaengager = $focus->getNatureDepensesAEngagees($reunionid);

foreach($natdepensesaengager as $comptenat => $natdepenses)
{
	if ($natdepenses['totaldepense']>0)
	{
		$infosengagement['depenses'][$comptenat]['totaldepense'] = $natdepenses['totaldepense'];
		$infosengagement['depenses'][$comptenat]['codebudget'] = $codebudget;
		$infosengagement['depenses'][$comptenat]['sourcefin'] = $sourcefin;
		$infosengagement['depenses'][$comptenat]['comptenat'] = $comptenat;
		$infosengagement['depenses'][$comptenat]['libconmptenature'] = $natdepenses['libconmptenature'];
		
	}

}


$resultat = $focus->createEngagementReunion($infosengagement);
//print_r($numegagement);
//print_r($infosengagement);
//break;
//echo $infosengagement['nomcharge'];


$numegagement = str_replace(' ','',$resultat->BELNR);

if ($numegagement=='1-')
{
	echo "Erreur création de l'engagement : ", $resultat->IT_IO;
}
elseif(stripos($numegagement, '045000') == 0)
{
	$focus->addEngagementToReunion($numegagement,$reunionid);
	echo "Engagement créé sous le N°: ".$numegagement;
}
else
	echo "Erreur création de l'engagement";

/*********************************** FIN GESTION DES ENGAGEMENTS *******************************/

?>