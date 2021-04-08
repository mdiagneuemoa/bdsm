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


$nbIncidentsDeclares = $focus->getNbIncidentsDeclares();
$nbIncidentsTraitesDansDelai = $focus->getNbIncidentsTraitesDansDelai();
$nbIncidentsTraitesAuDelaDelai = $focus->getNbIncidentsTraitesAuDelaDelai();
$nbIncidentsEnSouffrance = $focus->getNbIncidentsEnSouffrance();
$nbIncidentsNonSouffrance = $focus->getNbIncidentsNonSouffrance();

$incidentsTauxTraitement = ($nbIncidentsDeclares != 0) ? (($nbIncidentsTraitesDansDelai + $nbIncidentsTraitesAuDelaDelai) * 100 / $nbIncidentsDeclares) : 0;
$incidentsTauxTraitement = number_format($incidentsTauxTraitement, 2, '.', '');

$incidentsDureeMoyenneTraitement = $focus->getIncidentsDureeMoyenneTraitement();
$incidentsDureeMoyenneTraitement = number_format($incidentsDureeMoyenneTraitement, 2, '.', '');

$incidentsOrigineInterne = $focus->getIncidentsOrigineInterne();
$incidentsOrigineExterne = $focus->getIncidentsOrigineExterne();

$valuesStatut = $focus->getNbIncidentStatut();

$smarty->assign('INCIDENTS_NB_DECLARES', $nbIncidentsDeclares);
$smarty->assign('INCIDENTS_NB_TRAITES_DANS_DELAIS', $nbIncidentsTraitesDansDelai);
$smarty->assign('INCIDENTS_NB_TRAITES_AU_DELA_DELAIS', $nbIncidentsTraitesAuDelaDelai);
$smarty->assign('INCIDENTS_NB_EN_SOUFFRANCE', $nbIncidentsEnSouffrance);
$smarty->assign('INCIDENTS_TAUX_TRAITEMENT', $incidentsTauxTraitement."%");
$smarty->assign('INCIDENTS_DUREE_MOYENNE_TRAITEMENT', $incidentsDureeMoyenneTraitement." min");
$smarty->assign('INCIDENTS_NB_ORIGINE_INTERNE', $incidentsOrigineInterne);
$smarty->assign('INCIDENTS_NB_ORIGINE_EXTERNE', $incidentsOrigineExterne);

//$nbDemandesDeclares = $focus->getNbDemandesDeclares();
//$smarty->assign('DEMANDES_NB_DECLARES', $nbDemandesDeclares);

$nbIncidentsDemandesDeclares = $nbIncidentsDeclares + $nbDemandesDeclares;
$smarty->assign('NB_INCIDENTS_DEMANDES_DECLARES', $nbIncidentsDemandesDeclares);

$smarty->assign("FILTERGROUPNAME", getAllGroupeTraiement());
$smarty->assign("MYSELECTED_GT", $_REQUEST['groupname_field'] );

$smarty->assign("FILTERTYPOLOGIE", getAllTypeIncident());
$smarty->assign("MYSELECTED_TYPE", $_REQUEST['typologie_field'] );

$smarty->assign("FILTERCAMPAGNE", getAllCampagne());
$smarty->assign("MYSELECTED_CAMP", $_REQUEST['campagne_field'] );

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("MYSELECTED_DS", $_REQUEST['date_start'] );
$smarty->assign("MYSELECTED_DE", $_REQUEST['date_end'] );

// Graph adds
$nbatraiter = $nbIncidentsDeclares -  ($nbIncidentsTraitesDansDelai + $nbIncidentsTraitesAuDelaDelai + $nbIncidentsEnSouffrance);
//$nbatraiter = $nbIncidentsDeclares -  ($nbIncidentsTraitesDansDelai + $nbIncidentsTraitesAuDelaDelai );// Retrancher les incidents cloturé directement
$Nonsouffrant = $nbIncidentsNonSouffrance;//$nbatraiter + $valuesStatut[1] - $valuesStatut[2] - $valuesStatut[3] ;

if ($Nonsouffrant<0) $Nonsouffrant=0;

$valuesTraitement= array(
	"Non souffrant" 			=> $Nonsouffrant ,
	"Souffrance"    			=> $nbIncidentsEnSouffrance,
	"Traité dans les Delais"    => $nbIncidentsTraitesDansDelai,
	"Traité hors Delai"         => $nbIncidentsTraitesAuDelaDelai
);
$_SESSION['valuesTraitement'] = $valuesTraitement ;

$valuesOrigine= array( $incidentsOrigineInterne, $incidentsOrigineExterne );
$_SESSION['valuesOrigine'] = $valuesOrigine ;




$smarty->assign('VALUES_STATUS', $valuesStatut);
$smarty->assign('TYPOLOGY', $_REQUEST['typologie_field']);
$smarty->assign('INCIDENTS_NON_TRAITE', $Nonsouffrant);
// Graph adds end

$filtre= $_REQUEST['filter'];
if ($filtre == '')
	$filtre= 'none' ;

$smarty->assign("FILTER",$filtre );
$smarty->display('StatisticsIncidents.tpl');

?>