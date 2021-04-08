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
//$numeroom = getNumeroOM($demandeid);
$infosOM = getInfosOM($demandeid);
$numeroom = $infosOM['numom'];

$date1 = new DateTime($infosOM['datecreation']);
$dateom = $date1->format('d-m-Y');

//echo 'demandeid=',$record, '  -  ','numeroom=',$numeroom;

/************************* GESTION DES ENGAGEMENTS *********************************/
 $demandeinfos = getInfosByDemande($demandeid);
 $totaldecomptes = getTotalDecomptes($demandeid);
 $nomfamille = $demandeinfos['nomfamille'];
$infosengagement['matcharge'] = $demandeinfos['matricule'];
$infosengagement['nomcharge'] = 'OM : '.$numeroom.' du '.$dateom.' / '.$nomfamille;

$infosengagement['numom'] = $numeroom;
$infosengagement['societecharge'] = getSocieteSap($demandeinfos['user_direction']);
$infosengagement['objetmission'] = $page = str_replace("'", " ",$demandeinfos['objet']);
$infosengagement['objetmission'] = $page = str_replace('"', ' ',$demandeinfos['objet']);
$infosengagement['curentuserloginsap'] = $current_user->user_login;

for($i=0; $i<count($totaldecomptes); $i++) 
{
	$decompte = $totaldecomptes[$i];
	$infosengagement['decomptes'][$i]['totaldecompte'] = $decompte['totaldecompte'];
	$infosengagement['decomptes'][$i]['codebudget'] = $decompte['codebudget'];
	$infosengagement['decomptes'][$i]['sourcefin'] = $decompte['sourcefin'];
	$infosengagement['decomptes'][$i]['comptenat'] = $decompte['comptenat'];

	
}
//print_r($infosengagement);
//echo $infosengagement['nomcharge'];

$numegagement = createEngagementMission($infosengagement);
$numegagement = str_replace(' ','',$numegagement);

if ($numegagement=='1-')
{
	echo "Engagement déja créé pour cet ordre de mission";
}
elseif(stripos($numegagement, '05000') == 0)
{
	addEngagementToOM($numegagement,$demandeid);
	echo "Engagement créé sous le N°:".$numegagement;
}
else
	echo "Erreur création de l'engagement";

/*********************************** FIN GESTION DES ENGAGEMENTS *******************************/

//$search=$_REQUEST['search_url'];
/*
if($_REQUEST['parenttab'] != '')     $parenttab = $_REQUEST['parenttab'];
if($_REQUEST['return_module'] != '') {
	$return_module = $_REQUEST['return_module'];
} else {
	$return_module = $currentModule;
}*/

//header("Location: index.php?action=DetailView&module=OrdresMission&record=$demandeid&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);

?>