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

$display_lignebudget2="display:none;";
$display_lignebudget3="display:none;";
$display_lignebudget4="display:none;";
$display_lignebudget5="display:none;";
$display_justifs2="display:none;";


if ($focus->existlignebudget2($record)==1) 	$display_lignebudget2="display:;";
if ($focus->existlignebudget3($record)==1) 	$display_lignebudget3="display:;";
if ($focus->existlignebudget4($record)==1) 	$display_lignebudget4="display:;";
if ($focus->existlignebudget5($record)==1) 	$display_lignebudget5="display:;";
if ($focus->existjustif2($record)==1) 	$display_justifs2="display:;";
	
 $smarty->assign("DISPLAY_LIGNEBUDGET2",$display_lignebudget2);
 $smarty->assign("DISPLAY_LIGNEBUDGET3",$display_lignebudget3);
 $smarty->assign("DISPLAY_LIGNEBUDGET4",$display_lignebudget4);
 $smarty->assign("DISPLAY_LIGNEBUDGET5",$display_lignebudget5);
 $smarty->assign("DISPLAY_JUSTIFS2",$display_justifs2);	 

 $smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);
if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
$matricule = $focus->column_fields['matricule'];
$datefin = $focus->column_fields['datefin'];
$datedeb = $focus->column_fields['datedebut'];

//$date = new DateTime($focus->column_fields["modifiedtime"], new DateTimeZone('Europe/Paris')); 
//$datemodif =  date("Y-m-d H:i:s", $date->format('U'));
//$row1["modifiedtime"] = getDisplayDate($datemodif);


$userinfos = getinfosagent($matricule,$datedeb);
$nbjourconsomme = $focus->getNbJourConsommeAgent($matricule,$record);
$initiateurdemandeinfos = getInitiateurDemandeInfos($record);
 $directioncodeinitiateur = $initiateurdemandeinfos['user_direction'];
 $smarty->assign("AGENTNOM",$userinfos['nom']);
 $smarty->assign("AGENTMATRICULE",$userinfos['matricule']);
 $smarty->assign("AGENTPRENOM",$userinfos['prenom']);
 $smarty->assign("AGENTSERVICE",$userinfos['service']);
 $smarty->assign("DATEDERNMISSION",$userinfos['datedernmission']);
 $smarty->assign("INTERVALMISSION",$userinfos['intervalmission']);
// $smarty->assign("NBJOURCONSOMME",$userinfos['nbjourconsomme']);
 $smarty->assign("NBJOURCONSOMME",$nbjourconsomme);
  
  if ($focus->column_fields['codebudget']!='' && $focus->column_fields['sourcefin']!='')
  {
	$infosbudget['codebudget'] = $focus->column_fields['codebudget'];
	$infosbudget['sourcefin'] = $focus->column_fields['sourcefin'];
	if ($focus->column_fields['comptenat']=='638400')
	{
		$comptesnat = array ('638400'=>'638400','618100'=>'618100') ;
	}
	if ($focus->column_fields['comptenat']=='638410')
	{
		$comptesnat = array ('638410'=>'638410','618110'=>'618110') ;
	}
	
	//$comptesnat = array ('638400'=>'638400','618100'=>'618100') ;
	//$dispbudget = getInfosDisponibiliteFonds($infosbudget,$comptesnat);
 	$dispbudget = $focus->getInfosDisponibiliteFonds($infosbudget,$comptesnat);
 }
  
  //print_r($dispbudget);
 $smarty->assign("BUDGETDISP",$dispbudget);
 $smarty->assign("BUDGETBILLETDISP",$dispbudgetb);
  $smarty->assign("NBLINEBUDGETDISP",count($dispbudget));
 // echo "nbdispbudget = ",count($dispbudget);
 //print_r($userinfos);
 $curentusermat = $current_user->user_matricule;
 //$directioncode =$userinfos['direction'];
 $directioncode = $initiateurdemandeinfos['User_Direction'];
 $curentuserprofil = $current_user->profilid;
 //echo  "curentuserprofil=", $curentuserprofil;
 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$smarty->assign("IS_DIRECTEUR",is_directeur($curentusermat,$directioncode));
$smarty->assign("IS_INTERIMDIRECTEUR",is_directeurInterim($curentusermat,$directioncodeinitiateur));
//echo "directioncodeinitiateur =", is_directeurInterim($curentusermat,$directioncodeinitiateur);
$smarty->assign("IS_INTERIMDIRCAB",is_dircabInterim($curentusermat));
$smarty->assign("IS_INTERIMRUMV",is_RUMVInterim($curentusermat));
$smarty->assign("IS_INTERIMDIRCABPCOM",is_dircabpcomInterim($curentusermat));
$smarty->assign("IS_INTERIMCOMMISSAIRE",is_CommissaireInterim($curentusermat));
$smarty->assign("IS_DIRCAB",is_DirecteurCabinet($curentusermat,$directioncode));
$smarty->assign("IS_COMMISSAIRE",is_Commissaire($curentusermat,$directioncode));
$smarty->assign("IS_DIRCABPCOM",is_DirecteurCabinetPCOM($curentusermat));
$smarty->assign("IS_PRESIDENTCOM",is_PresidentCOM($curentusermat));
$smarty->assign("IS_INTERIMPCOM",is_PCOMInterim($curentusermat));

$smarty->assign("IS_RESPUMV",is_ResponsableUMV($curentusermat,$directioncode));
$smarty->assign("IS_AGENTUMV",is_AgentUMV($curentusermat,$directioncode));
$smarty->assign("IS_POSTEURDEMANDE",is_InitiateurDemande($curentusermat,$record));
$smarty->assign("POSTEURDEMANDE",$initiateurdemandeinfos['nomcomplet']);
$smarty->assign("IS_CHARGEMISSIONDEMANDE",is_ChargeMissionDemande($curentusermat,$record));
$smarty->assign("IS_DEMANDEPCOM",is_DemandePresidence($record));
$smarty->assign("IS_DEMANDECCR",is_DemandeCCR($record));
$smarty->assign("IS_DEMANDECIP",is_DemandeCIP($record));
$smarty->assign("IS_DEMANDECJ",is_DemandeCourJustice($record));
$smarty->assign("CATEROGIEAGENT",getCategorieAgentInitiateur($record));
$smarty->assign("IS_SGCC",is_SecretaireGeneralCC($curentusermat,$directioncode));
 $is_demandeMembreOrgane = $focus->is_demandeMembreOrgane($record);

$smarty->assign("ISDEMREJETPOURHORSDELAI",is_rejetHorsDelaiDemande($record));
$smarty->assign("ISDEMREJETPOURHORSBUDGET",is_rejetHorsBudgetDemande($record));




//echo "statut=",getCategorieAgent($record);
$smarty->assign("STATUT",$focus->column_fields['statut']);
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
//echo $curentuserprofil;break;
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

$traitements=$focus->get_traitements($ticket);
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
	$smarty->assign("IS_INTERIMPRESIDENTCC",is_PresidentCCInterim($curentusermat));
	
	//echo "is_PresidentCC =", is_PresidentCC('507');
	
	$smarty->display('CCDetailView.tpl');
}

elseif($directioncodeinitiateur == '02-00-100'  || $directioncodeinitiateur == '02-00-184')   // Demande de la cour de justice
{
	$smarty->display('CJDetailView.tpl');
}
elseif($directioncodeinitiateur == '04-00-289')   // Demande de CIP
{
	$smarty->display('CIPDetailView.tpl');
}
else
{
	if($is_demandeMembreOrgane == 1) 
		$smarty->display('MODetailView.tpl');
	else
		$smarty->display('AgentDetailView.tpl');
}

?>