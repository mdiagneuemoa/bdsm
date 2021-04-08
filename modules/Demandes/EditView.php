<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $app_strings, $mod_strings, $current_language, $currentModule, $theme,$current_user;

require_once('Smarty_setup.php');

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$focus = new $currentModule();
$smarty = new vtigerCRM_Smarty();

$category = getParentTab($currentModule);
$record = $_REQUEST['record'];
$isduplicate = $_REQUEST['isDuplicate'];

//added to fix the issue4600
$searchurl = getBasic_Advance_SearchURL();
$smarty->assign("SEARCH", $searchurl);
//4600 ends


$display_lignebudget2="display:none;";
$display_lignebudget3="display:none;";
$display_lignebudget4="display:none;";
$display_lignebudget5="display:none;";
$display_justifs2="display:none;";

if($record) {
	$focus->id = $record;
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($record, $currentModule);
	if ($focus->existlignebudget2($record)==1) 	$display_lignebudget2="display:;";
	if ($focus->existlignebudget3($record)==1) 	$display_lignebudget3="display:;";
	if ($focus->existlignebudget4($record)==1) 	$display_lignebudget4="display:;";
	if ($focus->existlignebudget5($record)==1) 	$display_lignebudget5="display:;";
}
if($isduplicate == 'true') {
	$focus->id = '';
	$focus->mode = '';
}

$disp_view = getView($focus->mode);

if($disp_view == 'edit_view') 
	$smarty->assign('BLOCKS', getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields));
else
	$smarty->assign('BASBLOCKS', getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields, 'BAS'));

$smarty->assign('OP_MODE',$disp_view);
$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
// TODO: Update Single Module Instance name here.
$smarty->assign('SINGLE_MOD', getTranslatedString('SINGLE_'.$currentModule));
$smarty->assign('CATEGORY', $category);
$smarty->assign("THEME", $theme);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('ID', $focus->id);
$smarty->assign('MODE', $focus->mode);

$smarty->assign('CHECK', Button_Check($currentModule));
$smarty->assign('DUPLICATE', $isduplicate);

if($focus->mode == 'edit' || $isduplicate) {
	$recordName = array_values(getEntityName($currentModule, $record));
	$recordName = $recordName[0];
	$smarty->assign('NAME', $recordName);
	$smarty->assign('UPDATEINFO',updateInfo($record));
}
$smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);

if(isset($_REQUEST['return_module']))    $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if(isset($_REQUEST['return_action']))    $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if(isset($_REQUEST['return_id']))        $smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if(isset($_REQUEST['return_viewname']))  $smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);

// Field Validation Information 
$tabid = getTabid($currentModule);
$validationData = getDBValidationData($focus->tab_name,$tabid);
$validationArray = split_validationdataArray($validationData);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$validationArray['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$validationArray['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$validationArray['fieldlabel']);

// In case you have a date field
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

global $adb;
// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if($focus->mode != 'edit' && $mod_seq_field != null) {
		$autostr = getTranslatedString('MSG_AUTO_GEN_ON_SAVE');
		$mod_seq_string = $adb->pquery("SELECT prefix, cur_id from vtiger_modentity_num where semodule = ? and active=1",array($currentModule));
        $mod_seq_prefix = $adb->query_result($mod_seq_string,0,'prefix');
        $mod_seq_no = $adb->query_result($mod_seq_string,0,'cur_id');
        if($adb->num_rows($mod_seq_string) == 0 || $focus->checkModuleSeqNumber($focus->table_name, $mod_seq_field['column'], $mod_seq_prefix.$mod_seq_no))
                echo '<br><font color="#FF0000"><b>'. getTranslatedString('LBL_DUPLICATE'). ' '. getTranslatedString($mod_seq_field['label'])
                	.' - '. getTranslatedString('LBL_CLICK') .' <a href="index.php?module=Settings&action=CustomModEntityNo&parenttab=Settings&selmodule='.$currentModule.'">'.getTranslatedString('LBL_HERE').'</a> '
                	. getTranslatedString('LBL_TO_CONFIGURE'). ' '. getTranslatedString($mod_seq_field['label']) .'</b></font>';
        else
                $smarty->assign("MOD_SEQ_ID",$autostr);
}
// END

// Gather the help information associated with fields
$smarty->assign('FIELDHELPINFO', vtlib_getFieldHelpInfo($currentModule));
// END
//Display the FCKEditor or not? -- configure $FCKEDITOR_DISPLAY in config.php
/*f(getFieldVisibilityPermission('Demandes',$current_user->id,'description') != '0')
        $FCKEDITOR_DISPLAY = false;*/
$FCKEDITOR_DISPLAY = true;
$smarty->assign("FCKEDITOR_DISPLAY",$FCKEDITOR_DISPLAY);

 $smarty->assign("DISPLAY_LIGNEBUDGET2",$display_lignebudget2);
 $smarty->assign("DISPLAY_LIGNEBUDGET3",$display_lignebudget3);
 $smarty->assign("DISPLAY_LIGNEBUDGET4",$display_lignebudget4);
 $smarty->assign("DISPLAY_LIGNEBUDGET5",$display_lignebudget5);
 $smarty->assign("DISPLAY_JUSTIFS2",$display_justifs2);	 

 
  $smarty->assign("NATUREMISSION",$NATUREMISSION);
  $smarty->assign("MOYENTRANSPORT",$MOYENTRANSPORT);
   $smarty->assign("LISTAGENTS",getListAgent());
   	$smarty->assign("LOCALITES", getAllVilles());

  $smarty->assign("TYPESBUDGET",$TYPEBUDGET);	
  $smarty->assign("SOURCESFINACEMENT",getSourcesFinancement());	
  $curentuserprofil = $current_user->profilid;
  if ($curentuserprofil=='20' || $curentuserprofil=='26' || $curentuserprofil=='27')
	$smarty->assign("CODESBUDGETAIRES",getCodesBudgetaires());	
  else
	$smarty->assign("CODESBUDGETAIRES",getCodeBudgetsByAgentDepart($current_user->user_matricule));	

  $smarty->assign("COMPTESNATURE",getComptesNature());	  
   
if($focus->mode == 'edit') {
	$smarty->display('salesEditView.tpl');
} else {
	// Siprod add
	$nextTicket=getNextTickectDemande();
	$smarty->assign('NEXTTICKET', $nextTicket );
	// Siprod add end
	$smarty->display('CreateView.tpl');
}

?>