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

 $smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);
if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
}
$matricule = $focus->column_fields['matricule'];
$datefin = $focus->column_fields['datefin'];
$datedeb = $focus->column_fields['datedebut'];

$codebudget = $focus->column_fields['codebudget'];
$comptesnat = $focus->getComptesNat($codebudget);

$naturedepenses = $focus->getNatureDepenses($record,$codebudget);
$smarty->assign("NATDEPENSES",$naturedepenses);
$smarty->assign("CODEBUDGET",$codebudget);

if ($focus->column_fields['codebudget']!='' && $focus->column_fields['sourcefin']!='')
  {
	  $infosbudget['codebudget'] = $focus->column_fields['codebudget'];
	  $infosbudget['sourcefin'] = $focus->column_fields['sourcefin'];
	  /*
	  foreach($comptesnat as $comptenat => $comptenatlib)
	  {
		//echo  "comptenat=",$comptenat;
		  $infosbudget['comptenat'] = $comptenat;
		 // $infosdisp = getInfosDisponibiliteFonds($infosbudget);
		  $dispbudgetobj= $infosdisp->IT_RESULT->item;
		  //print_r($dispbudgetobj);
			$dispbudget[$infosbudget['codebudget']][$comptenat]=array(	'comptenat'=>$comptenat,
								'comptenatlib'=>$comptenatlib,
								'fonddisp'=>$dispbudgetobj->MNTANT_FD_ENGAGE,
								'fondengage'=>$dispbudgetobj->FOND_ENGAGE,
								'mntdispo'=>$dispbudgetobj->MNTNT_DISPO
							);
	  }													 
	  */
	  $dispbudget = $focus->getInfosDisponibiliteFonds($infosbudget,$comptesnat);
  }
// print_r($dispbudget[$codebudget]);
// echo "<br>NATURES DEPENSES<BR>";
//  print_r($naturedepenses);
  $IS_DEMANDEVALIDE = $focus->check_isdemandevalide($naturedepenses,$dispbudget[$codebudget]);
  //echo "IS_DEMANDEVALIDE=",$IS_DEMANDEVALIDE;
/* if($IS_DEMANDEVALIDE==true) 
	echo "demandevalide";
else 
	echo "demande de transfert nécessaire sur les lignes en rouge!!!";
*/	
//print_r($dispbudget);
 $smarty->assign("IS_DEMANDEVALIDE",$IS_DEMANDEVALIDE);
	
 $smarty->assign("BUDGETDISP",$dispbudget);
$initiateurdemandeinfos = $focus->getInitiateurReunionInfos($record);

//print_r($dispbudget);
 $curentusermat = $current_user->user_matricule;
 //$directioncode =$userinfos['direction'];
 $directioncode = $initiateurdemandeinfos['User_Direction'];
 $curentuserprofil = $current_user->profilid;
 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$smarty->assign("IS_INTERIMDIRCAB",is_dircabInterim($curentusermat));
$smarty->assign("IS_INTERIMCOMMISSAIRE",is_CommissaireInterim($curentusermat));
//echo "isposteur=",$focus->is_InitiateurReunion($curentusermat,$record);
$smarty->assign("IS_DIRCAB",is_DirecteurCabinet($curentusermat,$directioncode));
$smarty->assign("IS_COMMISSAIRE",is_Commissaire($curentusermat,$directioncode));
$smarty->assign("IS_POSTEURDEMANDE",$focus->is_InitiateurReunion($curentusermat,$record));
$smarty->assign("POSTEURDEMANDE",$initiateurdemandeinfos['nomcomplet']);
$smarty->assign("IS_CHARGEMISSIONDEMANDE",is_ChargeMissionDemande($curentusermat,$record));
$smarty->assign("CATEROGIEAGENT",getCategorieAgent($record));
//echo "statut=",getCategorieAgent($record);
$smarty->assign("STATUT",$focus->column_fields['statut']);
if($isduplicate == 'true') $focus->id = '';
$smarty->assign("LISTREGISSEURS", $focus->getAllRegisseurs());	  
$smarty->assign("REGISSEURVAL",$focus->column_fields['regisseur']);	  
$isengaged = $focus->is_engageReunion($record);
$smarty->assign("IS_REUNIONENGAGE",$isengaged);
$isagentdb = $focus->is_AgentDB($curentusermat); 
$smarty->assign("IS_AGENTDB",$isagentdb);
$smarty->assign("TIMBRESDC",$focus->getTimbresDC());
$smarty->assign("TIMBRESCOM",$focus->getTimbresCOM());
$smarty->assign("SIGNATAIRES",$focus->getSignataires());
$smarty->assign("TIMBRESDCSELECT",$focus->column_fields['timbredc']);
$smarty->assign("TIMBRESCOMSELECT",$focus->column_fields['timbrecom']);
$smarty->assign("SIGNATAIREDCSELECT",$focus->column_fields['signatairedc']);
$smarty->assign("SIGNATAIRECOMSELECT",$focus->column_fields['signatairecom']);
$smarty->assign("REGISSEURSELECT",$focus->column_fields['regisseur']);

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);$smarty->assign('APP', $app_strings);
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
$ticket=$focus->getTicketReunion($focus->id);
//echo "ticket=",$ticket;
$traitements=$focus->get_traitements($ticket);
$smarty->assign('TICKET',$ticket);
 //print_r($traitements); // break;
$statut= $focus->column_fields['statut'] ;
$smarty->assign('STATUT',$statut);
$smarty->assign('LISTTRAITEMENT',$traitements);
$smarty->assign('NBTRAITEMENT',count($traitements)-1);
 // print_r($userinfos); break;

$smarty->assign("DATE_DERRIRE_RELANCE", $display_val);

$smarty->display('DetailViewReunion.tpl');

?>