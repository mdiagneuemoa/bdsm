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

//checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once("modules/TraitementIncidents/TraitementIncidents.php");

$tool_buttons = Button_Check($currentModule);

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];
$tabid = getTabid($currentModule);
$category = getParentTab($currentModule);
//echo "email = ",$current_user->email;
if ($record == '') 
{
   $record = $focus->getCandidatsid($current_user->user_numerologin);	
   //$record = $focus->getCandidatsid('maty.diagne@gmail.com');	
}  

 if($record != '') {
	$focus->id = $record;
	$focus->retrieve_entity_info($record, $currentModule);
	$smarty->assign("ALL_POPULATION_CHECKED", $focus->column_fields["all_ccx_affected"]=='1' ? (" - ".$app_strings['ALL_POPULATION']) : "");
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

if(isset($_SESSION[$currentModule.'_listquery'])){
	$arrayTotlist = array();
	$aNamesToList = array();
	$forAllCRMIDlist_query=$_SESSION[$currentModule.'_listquery'];
	$resultAllCRMIDlist_query=$adb->pquery($forAllCRMIDlist_query,array());
	while($forAllCRMID = $adb->fetch_array($resultAllCRMIDlist_query))
	{
		$arrayTotlist[]=$forAllCRMID['crmid'];
	}
	$_SESSION['listEntyKeymod_'.$focus->id] = $module.":".implode(",",$arrayTotlist);

	if(isset($_SESSION['listEntyKeymod_'.$focus->id]))
	{
		$split_temp=explode(":",$_SESSION['listEntyKeymod_'.$focus->id]);
		if($split_temp[0] == $module)
		{
			$smarty->assign("SESMODULE",$split_temp[0]);
			$ar_allist=explode(",",$split_temp[1]);
				
			for($listi=0;$listi<count($ar_allist);$listi++)
			{
				if($ar_allist[$listi]==$_REQUEST[record])
				{
					if($listi-1>=0)
					{
						$privrecord=$ar_allist[$listi-1];
						$smarty->assign("privrecord",$privrecord);
					}else {unset($privrecord);}
					if($listi+1<count($ar_allist))
					{
						$nextrecord=$ar_allist[$listi+1];
						$smarty->assign("nextrecord",$nextrecord);
					}else {unset($nextrecord);}
					break;
				}

			}
		}
	}
}

$smarty->assign('IS_REL_LIST', isPresentRelatedLists($currentModule));
$smarty->assign('SinglePane_View', $singlepane_view);
/*
 if($singlepane_view == 'true') {
 $related_array = getRelatedLists($currentModule,$focus);
 $smarty->assign("RELATEDLISTS", $related_array);
 }
 */
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

$ticket=getTicketConvention($focus->id);
$traitements=$focus->get_traitements($ticket);
$smarty->assign('TICKET',$ticket);
$traitements=$focus->get_traitements($ticket);
$statut= $focus->column_fields['statut'] ;
$smarty->assign('STATUT',$statut);
$smarty->assign('LISTTRAITEMENT',$traitements);
$smarty->assign('NBTRAITEMENT', count($traitements)-1);

 $smarty->assign("CURRENT_USER_IS_POSTEUR_DEMANDE", $current_user->isPosteurDemande($current_user->id));	// Is posteur demande if function return a value > 0
 $smarty->assign("CURRENT_USER_IS_POSTEUR_INCIDENT", $current_user->isPosteurIncident($current_user->id));	// Is posteur incident if function return a value > 0
 $smarty->assign("CURRENT_USER_IS_TRAITEUR_DEMANDE", $current_user->isTraiteurDemande($current_user->id));	// Is traieur demande if function return a value > 0
 $smarty->assign("CURRENT_USER_IS_TRAITEUR_INCIDENT", $current_user->isTraiteurIncident($current_user->id));	// Is traieur incident if function return a value > 0
 $smarty->assign("CURRENT_USER_IS_SUPERIEUR", $current_user->isSuperieur($current_user->id)); // Is n+1 if function return a value > 0
 $smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
 $smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);	// Is Super Utilisateur if profileid = 20
	
$smarty->assign("CURRENT_USER_NOMPRENOM",$current_user->user_firstname." ".$current_user->user_name);

if(isTraiteurPermittedAction($currentModule, '', $record)=='yes')
	$smarty->assign("CURRENT_USER_DO_ACTION_TRAITEUR", 'YES');
else
	$smarty->assign("CURRENT_USER_DO_ACTION_TRAITEUR", 'NO');
	
	
if(isPosteurPermittedAction($currentModule, '', $record)=='yes')
	$smarty->assign("CURRENT_USER_DO_ACTION_POSTEUR", 'YES');
else
	$smarty->assign("CURRENT_USER_DO_ACTION_POSTEUR", 'NO');

$smarty->assign("POSTEUR_INFO", getPosteurInfo($record));
//$smarty->assign("TRAITEUR_INFO", getTraiteurIncidentInfo($record));
//$smarty->assign("IS_EN_SOUFFRANCE", isEnSouffrance($category, $record, $ticket));


$display_etablissement2="display:none;";
$display_etablissement3="display:none;";
if ($focus->existcoordetab2($record)==1) 	$display_etablissement2="display:;";
if ($focus->existcoordetab3($record)==1) 	$display_etablissement3="display:;";
$smarty->assign("DISPLAY_ETABLISSEMENT2",$display_etablissement2);
$smarty->assign("DISPLAY_ETABLISSEMENT3",$display_etablissement3);	

$entity_relanced = $focus->column_fields['relanced'];
if($entity_relanced == '0000-00-00 00:00:00' || $entity_relanced == '00-00-0000 00:00:00' || $entity_relanced == '') {
	$display_val = '';	
}
else {
	$display_val = getDisplayDate($entity_relanced);
}
$smarty->assign("DATE_DERRIRE_RELANCE", $display_val);
$smarty->assign("DELAICANDIDATURE", $DELAICANDIDATURE);
$smarty->assign("BOURSEEDITION", $BOURSEEDITION);

$smarty->display('DetailView.tpl');

?>