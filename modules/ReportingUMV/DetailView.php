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
require_once("modules/TraitementDemandes/TraitementDemandes.php");

$tool_buttons = Button_Check($currentModule);

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];
$tabid = getTabid($currentModule);
$category = getParentTab($currentModule);

//$record=474;
//echo '======= ',$record;

$display_trajet2="display:none;";
$display_trajet3="display:none;";
$display_trajet4="display:none;";
$display_trajet5="display:none;";
$display_trajet6="display:none;";
$display_trajet7="display:none;";
$display_trajet8="display:none;";

if ($focus->existtrajet2($record)==1) 	$display_trajet2="display:;";
if ($focus->existtrajet3($record)==1) 	$display_trajet3="display:;";
if ($focus->existtrajet4($record)==1) 	$display_trajet4="display:;";
if ($focus->existtrajet5($record)==1) 	$display_trajet5="display:;";
if ($focus->existtrajet6($record)==1) 	$display_trajet6="display:;";
if ($focus->existtrajet7($record)==1) 	$display_trajet7="display:;";
if ($focus->existtrajet8($record)==1) 	$display_trajet8="display:;";
	
 $smarty->assign("DISPLAY_TRAJET2",$display_trajet2);
 $smarty->assign("DISPLAY_TRAJET3",$display_trajet3);
 $smarty->assign("DISPLAY_TRAJET4",$display_trajet4);
 $smarty->assign("DISPLAY_TRAJET5",$display_trajet5);
 $smarty->assign("DISPLAY_TRAJET6",$display_trajet6);	 
 $smarty->assign("DISPLAY_TRAJET7",$display_trajet7);	 
 $smarty->assign("DISPLAY_TRAJET8",$display_trajet8);	 

 $smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);
if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}

$matricule = $focus->column_fields['matricule'];
/*
$date3 = new DateTime($focus->column_fields['datedebut']);
$focus->column_fields['datedebut'] = $date3->format('d-m-Y');

$date4 = new DateTime($focus->column_fields['datearrivee']);
$focus->column_fields['datearrivee'] = $date4->format('d-m-Y');
*/
$demandeinfos = getInfosByDemande($record);
$date1 = new DateTime($demandeinfos['datedebut']);
$demandeinfos['datedebut'] = $date1->format('d-m-Y');

$date2 = new DateTime($demandeinfos['datefin']);
$demandeinfos['datefin'] = $date2->format('d-m-Y');

//print_r($demandeinfos);

 $smarty->assign("AGENTNOM",$demandeinfos['nom']);
 $smarty->assign("AGENTMATRICULE",$demandeinfos['matricule']);
 $smarty->assign("AGENTSERVICE",$demandeinfos['service']);
  $smarty->assign("AGENTFONCTION",$demandeinfos['fonction']);
  $smarty->assign("DEMANDELIEU",$demandeinfos['lieu']);
   $smarty->assign("DEMANDEOBJET",$demandeinfos['objet']);
   $smarty->assign("DEMANDECOMMENTBILLET",$demandeinfos['commentbillet']);
   $smarty->assign("DEMANDEDATEDEB",$demandeinfos['datedebut']);
   $smarty->assign("DEMANDEDATEFIN",$demandeinfos['datefin']);
$smarty->assign("POSTEURDEMANDE",getInitiateurDemande($record));
//$smarty->assign("STATUTOM",$demandeinfos['statut']);
$smarty->assign("TICKET",$demandeinfos['ticket']);

 $curentusermat = $current_user->user_matricule;
  $curentuserprofil = $current_user->profilid;
 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$smarty->assign("IS_AGENTUMV",is_AgentUMV($curentusermat));

$decomptes = getDecompteBydemande($record);
 $smarty->assign("DECOMPTES",$decomptes);
 

 /************************* GESTION DES ENGAGEMENTS *********************************/
 
 $totaldecomptes = getTotalDecomptes($record);
 
 /***************************** CONTROLE DISPONIBILITE ******************************/
 
 for($i=0; $i<count($totaldecomptes); $i++) 
{
	$decompte = $totaldecomptes[$i];
	$infosengagement['decomptes'][$i]['totaldecompte'] = $decompte['totaldecompte'];
	$infosengagement['decomptes'][$i]['codebudget'] = $decompte['codebudget'];
	$infosengagement['decomptes'][$i]['sourcefin'] = $decompte['sourcefin'];
	$infosengagement['decomptes'][$i]['comptenat'] = $decompte['comptenat'];
	$infosdisp = getInfosDisponibiliteFonds($decompte);
	
	 $dispbudgetobj= $infosdisp->IT_RESULT->item;
	  $dispbudget[$decompte['codebudget']]=array('codebudget'=>$decompte['codebudget'],
													  'sourcefin'=>$decompte['sourcefin'],
													 'comptenat'=>$dispbudgetobj->CPTE_BUDGETAIRE,
													 'fonddisp'=>$dispbudgetobj->MNTANT_FD_ENGAGE,
													 'fondengage'=>$dispbudgetobj->FOND_ENGAGE,
													 'mntdispo'=>$dispbudgetobj->MNTNT_DISPO
													 );
		
}
//print_r($dispbudget);
 /***************************** FIN CONTROLE DISPONIBILITE ******************************/
$isengaged = is_engageOM($record);

 $smarty->assign("IS_MISSIONENGAGE",$isengaged);	
 $smarty->assign("BUDGETDISP",$dispbudget);
 
 
 
//echo "User_Direction=",$demandeinfos['user_direction'];
$infosengagement['matcharge'] = $demandeinfos['matricule'];
$infosengagement['numom'] = $focus->column_fields['numom'];
$infosengagement['societecharge'] = getSocieteSap($demandeinfos['user_direction']);
$infosengagement['objetmission'] = $demandeinfos['objet'];
$infosengagement['curentuserloginsap'] = $current_user->user_login;

for($i=0; $i<count($decomptes); $i++) 
{
	$decompte = $totaldecomptes[$i];
	$infosengagement['decomptes'][$i]['totaldecompte'] = $decompte['totaldecompte'];
	$infosengagement['decomptes'][$i]['codebudget'] = $decompte['codebudget'];
	$infosengagement['decomptes'][$i]['sourcefin'] = $decompte['sourcefin'];
	$infosengagement['decomptes'][$i]['comptenat'] = $decompte['comptenat'];
	
	/*$infosengagement['decomptes'][$i]['totaldecompte'] = '1500';
	$infosengagement['decomptes'][$i]['codebudget'] = '01-01-100-00-00-00-A00001';
	$infosengagement['decomptes'][$i]['sourcefin'] = '0000-00-00';
	$infosengagement['decomptes'][$i]['comptenat'] = '618100';*/
	
}




//print_r($infosengagement);
//$numegagement = createEngagementMission($infosengagement);
//echo "numegagement =",$numegagement;

/*********************************** FIN GESTION DES ENGAGEMENTS *******************************/
 
 
 
 //print_r($decomptes);break;
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

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$smarty->assign('IS_REL_LIST',isPresentRelatedLists($currentModule));

$validationArray = split_validationdataArray(getDBValidationData($focus->tab_name, $tabid));
$smarty->assign('VALIDATION_DATA_FIELDNAME',$validationArray['fieldname']);
$smarty->assign('VALIDATION_DATA_FIELDDATATYPE',$validationArray['datatype']);
$smarty->assign('VALIDATION_DATA_FIELDLABEL',$validationArray['fieldlabel']);

$smarty->assign('EDIT_PERMISSION', isPermitted($currentModule, 'EditView', $record));
$smarty->assign('CHECK', $tool_buttons);

$smarty->assign('IS_REL_LIST', isPresentRelatedLists($currentModule));
$smarty->assign('SinglePane_View', $singlepane_view);
/*
 if($singlepane_view == 'true') {
 $related_array = getRelatedLists($currentModule,$focus);
 $smarty->assign("RELATEDLISTS", $related_array);
 }
 */

//$decomptes = getDecompteBydemande2($record);
//saveDecompte($decomptes,$record);
 
if(isPermitted($currentModule, 'EditView', $record) == 'yes')
	$smarty->assign('EDIT_DUPLICATE', 'permitted');
if(isPermitted($currentModule, 'Delete', $record) == 'yes')
	$smarty->assign('DELETE', 'permitted');

$smarty->assign('BLOCKS', getBlocks($currentModule,'detail_view','',$focus->column_fields));

// Gather the custom link information to display
include_once('vtlib/Vtiger/Link.php');
$customlink_params = Array('MODULE'=>$currentModule, 'RECORD'=>$focus->id, 'ACTION'=>$_REQUEST['action']);
$smarty->assign('CUSTOM_LINKS', Vtiger_Link::getAllByType($tabid, 'DETAILVIEW', $customlink_params));
// END

// Record Change Notification
$focus->markAsViewed($current_user->id);
// END
$ticket=getTicketDemande($focus->id);

//$traitements=$focus->get_traitements($ticket);
$smarty->assign('TICKET',$ticket);
$statut= $focus->column_fields['statut'] ;
$smarty->assign('STATUT',$statut);
$smarty->assign('LISTTRAITEMENT',$traitements);
$smarty->assign('NBTRAITEMENT',count($traitements)-1);
 // print_r($userinfos); break;
/*
$smarty->assign("CURRENT_USER_IS_POSTEUR_DEMANDE", $current_user->isPosteurDemande($current_user->id));	// Is posteur demande if function return a value > 0
$smarty->assign("CURRENT_USER_IS_POSTEUR_INCIDENT", $current_user->isPosteurIncident($current_user->id));	// Is posteur incident if function return a value > 0
$smarty->assign("CURRENT_USER_IS_TRAITEUR_DEMANDE", $current_user->isTraiteurDemande($current_user->id));	// Is traieur demande if function return a value > 0
$smarty->assign("CURRENT_USER_IS_TRAITEUR_INCIDENT", $current_user->isTraiteurIncident($current_user->id));	// Is traieur incident if function return a value > 0
$smarty->assign("CURRENT_USER_IS_SUPERIEUR", $current_user->isSuperieur($current_user->id)); // Is n+1 if function return a value > 0
$smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);	// Is Super Utilisateur if profileid = 20
$smarty->assign("CURRENT_USER_CAN_DO_ACTION", $current_user->profilid);	// Pour tester s'il peut faire d'action ou pas

	
if(isTraiteurPermittedAction($currentModule, '', $record)=='yes')
	$smarty->assign("CURRENT_USER_DO_ACTION_TRAITEUR", 'YES');
else
	$smarty->assign("CURRENT_USER_DO_ACTION_TRAITEUR", 'NO');
	
	
if(isPosteurPermittedAction($currentModule, '', $record)=='yes')
	$smarty->assign("CURRENT_USER_DO_ACTION_POSTEUR", 'YES');
else
	$smarty->assign("CURRENT_USER_DO_ACTION_POSTEUR", 'NO');

$smarty->assign("POSTEUR_INFO", getPosteurInfo($record));
$smarty->assign("IS_EN_SOUFFRANCE", isEnSouffrance($category, $record, $ticket));

$entity_relanced = $focus->column_fields['relanced'];*/
if($entity_relanced == '0000-00-00 00:00:00' || $entity_relanced == '00-00-0000 00:00:00' || $entity_relanced == '') {
	$display_val = '';	
}
else {
	$display_val = getDisplayDate($entity_relanced);
}
$smarty->assign("DATE_DERRIRE_RELANCE", $display_val);

$smarty->display('DetailView.tpl');

?>