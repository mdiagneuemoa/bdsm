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

//print_r($focus->column_fields);

/*
$date3 = new DateTime($focus->column_fields['datedepart']);
$datedebr = $date3->format('d-m-Y');

$date4 = new DateTime($focus->column_fields['datearrivee']);
$datearrivr = $date4->format('d-m-Y');
*/

 $smarty->assign("DATEDEPR",$focus->column_fields['datedepart']);
 $smarty->assign("DATEARRIVR",$focus->column_fields['datearrivee']);


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
$smarty->assign("STATUTOM",$demandeinfos['statut']);
$smarty->assign("TICKET",$demandeinfos['ticket']);

 $curentusermat = $current_user->user_matricule;
  $curentuserprofil = $current_user->profilid;
 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$smarty->assign("IS_AGENTUMV",is_AgentUMV($curentusermat));

$initiateurdemandeinfos = getInitiateurDemandeInfos($record);
 $directioncodeinitiateur = $initiateurdemandeinfos['user_direction'];

$decomptes = getDecompteBydemande($record);
 $smarty->assign("DECOMPTES",$decomptes);
  
 $totaldecomptes = getTotalDecomptes($record);
 
$decompte = $totaldecomptes[0];
 if ($decompte['codebudget']!='' && $decompte['sourcefin']!='')
  {
	$infosbudget['codebudget'] = $decompte['codebudget'];
	$infosbudget['sourcefin'] = $decompte['sourcefin'];
	if ($decompte['comptenat']=='638400')
	{
		$comptesnat = array ('638400'=>'638400','618100'=>'618100') ;
	}
	if ($decompte['comptenat']=='638410')
	{
		$comptesnat = array ('638410'=>'638410','618110'=>'618110') ;
	}
	//$comptesnat = array ('638400'=>'638400','618100'=>'618100') ;
	$dispbudget = $focus->getInfosDisponibiliteFonds($infosbudget,$comptesnat);
  }

 $smarty->assign("BUDGETDISP",$dispbudget);
 
 $isengaged = $focus->is_engageOM($record);
 $smarty->assign("IS_MISSIONENGAGE",$isengaged);	

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

if($entity_relanced == '0000-00-00 00:00:00' || $entity_relanced == '00-00-0000 00:00:00' || $entity_relanced == '') {
	$display_val = '';	
}
else {
	$display_val = getDisplayDate($entity_relanced);
}
$smarty->assign("DATE_DERRIRE_RELANCE", $display_val);


if($directioncodeinitiateur == '03-00-100'  || $directioncodeinitiateur == '03-00-187')   // Demande de la cour des comptes
{
	$smarty->assign("IS_PRESIDENTCC",is_PresidentCC($curentusermat));
	//echo "is_PresidentCC =", is_PresidentCC('507');
	
	$smarty->display('CCDetailView.tpl');
}

else
{
	$smarty->display('DetailView.tpl');
}
?>