<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('Smarty_setup.php');
require_once('user_privileges/default_module_view.php');
//require_once('modules/Statistics/Diagramme.php');

global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$tool_buttons = Button_Check($currentModule);

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];
$tabid = getTabid($currentModule);
$category = getParentTab($currentModule);

if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
if($isduplicate == 'true') $focus->id = '';

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', getTranslatedString($currentModule)); 
$smarty->assign('CATEGORY', $category);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);

$recordName = array_values(getEntityName($currentModule, $focus->id));
$recordName = $recordName[0];
$smarty->assign('NAME', $recordName);
$smarty->assign('UPDATEINFO',updateInfo($focus->id));

$nbDemandesDeclares = $focus->getNbDemandesDeclares();
$nbDemandesTraitesDansDelai = $focus->getNbDemandesTraitesDansDelai();
$nbDemandesTraitesAuDelaDelai = $focus->getNbDemandesTraitesAuDelaDelai();
$nbDemandesEnSouffrance = $focus->getNbDemandesEnSouffrance();

if($nbDemandesDeclares > 0){
	$demandesTauxTraitement = ($nbDemandesDeclares != 0) ? ($nbDemandesTraitesDansDelai + $nbDemandesTraitesAuDelaDelai) * 100 / $nbDemandesDeclares : 0;
	$demandesTauxTraitement = number_format($demandesTauxTraitement, 2, '.', '');
}
$demandesDureeMoyenneTraitement = $focus->getDemandesDureeMoyenneTraitement();
$demandesDureeMoyenneTraitement = number_format($demandesDureeMoyenneTraitement, 2, '.', '');

$demandesOrigineInterne = $focus->getDemandesOrigineInterne();
$demandesOrigineExterne = $focus->getDemandesOrigineExterne();

$valuesStatut = $focus->getNbDemandeStatut();

$smarty->assign('DEMANDES_NB_DECLARES', $nbDemandesDeclares);
$smarty->assign('DEMANDES_NB_TRAITES_DANS_DELAIS', $nbDemandesTraitesDansDelai);
$smarty->assign('DEMANDES_NB_TRAITES_AU_DELA_DELAIS', $nbDemandesTraitesAuDelaDelai);
$smarty->assign('DEMANDES_NB_EN_SOUFFRANCE', $nbDemandesEnSouffrance); 
$smarty->assign('DEMANDES_TAUX_TRAITEMENT', $demandesTauxTraitement."%");
$smarty->assign('DEMANDES_DUREE_MOYENNE_TRAITEMENT', $demandesDureeMoyenneTraitement." min");
$smarty->assign('DEMANDES_NB_ORIGINE_INTERNE', $demandesOrigineInterne);
$smarty->assign('DEMANDES_NB_ORIGINE_EXTERNE', $demandesOrigineExterne);

//$nbIncidentsDeclares = $focus->getNbIncidentsDeclares();
//$smarty->assign('INCIDENTS_NB_DECLARES', $nbIncidentsDeclares);
//
//$nbIncidentsDemandesDeclares = $nbIncidentsDeclares + $nbDemandesDeclares;
//$smarty->assign('NB_INCIDENTS_DEMANDES_DECLARES', $nbIncidentsDemandesDeclares);

$smarty->assign("FILTERGROUPNAME", getAllGroupeTraiement());
$smarty->assign("MYSELECTED_GT", $_REQUEST['groupname_field'] );

$smarty->assign("FILTERTYPOLOGIE", getAllTypeDemande());
$smarty->assign("MYSELECTED_TYPE", $_REQUEST['typologie_field'] );

$smarty->assign("FILTERCAMPAGNE", getAllCampagne());
$smarty->assign("MYSELECTED_CAMP", $_REQUEST['campagne_field'] );

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("MYSELECTED_DS", $_REQUEST['date_start'] );
$smarty->assign("MYSELECTED_DE", $_REQUEST['date_end'] );


// Graph adds
$nbatraiter = $nbDemandesDeclares -  ($nbDemandesTraitesDansDelai + $nbDemandesTraitesAuDelaDelai + $nbDemandesEnSouffrance);
$Nonsouffrant = $nbatraiter + $valuesStatut[1] - $valuesStatut[2] - $valuesStatut[3] ;
if ($Nonsouffrant<0) $Nonsouffrant=0;
$valuesTraitement= array(
	"Non souffrant"  				=> $Nonsouffrant  ,
	"Souffrance"     			    => $nbDemandesEnSouffrance,
	"Traitées dans les delais"      => $nbDemandesTraitesDansDelai,
	"Traitées hors delais"        	=> $nbDemandesTraitesAuDelaDelai
);

$_SESSION['valuesTraitementDemande'] = $valuesTraitement ;

$valuesOrigine= array( $demandesOrigineInterne, $demandesOrigineExterne );
$_SESSION['valuesOrigine'] = $valuesOrigine ;

$smarty->assign('VALUES_STATUS', $valuesStatut);
$smarty->assign('TYPOLOGY', $_REQUEST['typologie_field']);
$smarty->assign('DEMANDES_NON_TRAITE', $Nonsouffrant);

// Graph adds end

$filtre= $_REQUEST['filter'];
if ($filtre == '')
	$filtre= 'none' ;

$smarty->assign("FILTER",$filtre );
$smarty->display('StatisticsDemandes.tpl');

?>