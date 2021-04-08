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

$demandeid=$record;
//$numeroom = getNumeroOM($demandeid);
$infosOM = getInfosOM($demandeid);
$numeroom = $infosOM['numom'];

$date1 = new DateTime($infosOM['datecreation']);
$dateom = $date1->format('d-m-Y');

//echo 'demandeid=',$record, '  -  ','numeroom=',$numeroom;

/************************* GESTION DES ENGAGEMENTS *********************************/
 $demandeinfos = getInfosByDemande($demandeid);
 $initiateurdem = getInitiateurDemandeInfos($demandeid);
 $totaldecomptes = getTotalDecomptes($demandeid);
 $nomfamille = $demandeinfos['nomfamille'];
$infosengagement['matcharge'] = $demandeinfos['matricule'];
$infosengagement['nomcharge'] = 'OM : '.$numeroom.' du '.$dateom.' / '.$nomfamille;
$infosengagement['dateom'] = $infosOM['datecreation'];
$infosengagement['numom'] = $numeroom;
$infosengagement['societecharge'] = getSocieteSap($initiateurdem['user_direction']);
$infosengagement['objetmission'] = $page = str_replace("'", " ",$demandeinfos['objet']);
$infosengagement['objetmission'] = $page = str_replace('"', ' ',$demandeinfos['objet']);
$infosengagement['objetmission'] = preg_replace("#\n|\t|\r#"," ",$infosengagement['objetmission']);

$infosengagement['curentuserloginsap'] = $current_user->user_login;
$mntengagement = 0;
for($i=0; $i<count($totaldecomptes); $i++) 
{
	$decompte = $totaldecomptes[$i];
	$infosengagement['decomptes'][$i]['MontantDecpte'] = $decompte['totaldecompte'];
	$infosengagement['decomptes'][$i]['ProgBenef'] = $decompte['codebudget'];
	$infosengagement['decomptes'][$i]['CpteNat'] = $decompte['comptenat'];
	$mntengagement += $decompte['totaldecompte'];
	
}
//print_r($infosengagement);
//echo $infosengagement['nomcharge'];
$infosengagement['MontEng'] = $mntengagement;
$tabresultat = $focus->createEngagementMission($infosengagement);
$numegagement = str_replace(' ','',$tabresultat['NumEngagement']);
print_r($tabresultat);
//$numegagement = createEngagementMission($infosengagement);
//$numegagement = str_replace(' ','',$numegagement);
/*
if ($numegagement=='1-')
{
	$msg = $tabresultat['msgErreurPheb'];
	echo "Erreur création de l'engagement :",$msg;
	//echo "Engagement déja créé pour cet ordre de mission";
}
elseif(stripos($numegagement, '9EN') == 0)
{
	//$focus->addEngagementToOM($numegagement,$demandeid);
	echo "Engagement créé sous le N°:".$numegagement;
}
else
{
	//echo "Erreur création de l'engagement";
	$msg = $tabresultat['msgErreurPheb'];
	echo "Erreur création de l'engagement :",$msg;
}
*/
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