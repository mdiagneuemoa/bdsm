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

$lignesdebcred = $focus->getLignesDebitsCreditsBrut($record);
$smarty->assign("LIGNESDEBIT",$lignesdebcred['Debit']);
$smarty->assign("LIGNESCREDIT",$lignesdebcred['Credit']);

  $IS_DEMANDEVALIDE = $focus->check_isdemandevalide($lignesdebcred);
  //echo "IS_DEMANDEVALIDE=",$IS_DEMANDEVALIDE;
/* if($IS_DEMANDEVALIDE==true) 
	echo "demandevalide";
else 
	echo "demande de transfert nécessaire sur les lignes en rouge!!!";
*/	
//print_r($dispbudget);
 $smarty->assign("IS_DEMANDEVALIDE",$IS_DEMANDEVALIDE);

$initiateurdemandeinfos = $focus->getInitiateurTransfertInfos($record);

//print_r($dispbudget);
 $curentusermat = $current_user->user_matricule;
 //$directioncode =$userinfos['direction'];
 $directioncode = $initiateurdemandeinfos['User_Direction'];
 $curentuserprofil = $current_user->profilid;

 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$smarty->assign("IS_INTERIMDIRCAB",is_dircabInterim($curentusermat));
$smarty->assign("IS_INTERIMCOMMISSAIRE",is_CommissaireInterim($curentusermat));
//echo "isposteur=",$focus->is_InitiateurTransfert($curentusermat,$record);
$smarty->assign("IS_DIRCAB",is_DirecteurCabinet($curentusermat,$directioncode));
$smarty->assign("IS_COMMISSAIRE",is_Commissaire($curentusermat,$directioncode));
$smarty->assign("IS_POSTEURDEMANDE",$focus->is_InitiateurTransfert($curentusermat,$record));
$smarty->assign("POSTEURDEMANDE",$initiateurdemandeinfos['nomcomplet']);

//echo "statut=",getCategorieAgent($record);
$smarty->assign("STATUT",$focus->column_fields['statut']);
if($isduplicate == 'true') $focus->id = '';
$isengaged = $focus->is_engageTransfert($record);
$smarty->assign("IS_REUNIONENGAGE",$isengaged);
$isagentdb = $focus->is_AgentDB($curentusermat); 
$smarty->assign("IS_AGENTDB",$isagentdb);

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
$ticket=$focus->getTicketTransfert($focus->id);
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

$smarty->display('TransfertDetailView.tpl');

?>