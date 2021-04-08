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
$display_conjoint="display:none;";
$display_enfant1="display:none;";
$display_enfant2="display:none;";
$display_enfant3="display:none;";
$display_enfant4="display:none;";
$display_enfant5="display:none;";
$display_enfant6="display:none;";

$display_coordbank2="display:none;";
$display_coordbank3="display:none;";
$display_coordbank4="display:none;";
$display_coordbank5="display:none;";

if($record) {
	$focus->id = $record;
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($record, $currentModule);
	$smarty->assign("ALL_POPULATION_CHECKED", $focus->column_fields["all_ccx_affected"]=='1' ? "checked" : "");
	$bailleurs = $focus->getBailleursRates($record);
	$smarty->assign("TICKET",getTicketConvention($record));
	$smarty->assign("SELECTNONMODIF",$focus->selectnonmodifval($record));
	//print_r($focus->selectnonmodifval($record)); break;
	if ($focus->existinfosconjoint($record)==1)	$display_conjoint="display:;";
	if ($focus->existinfosenfant1($record)==1) 	$display_enfant1="display:;";
	if ($focus->existinfosenfant2($record)==1) 	$display_enfant2="display:;";
	if ($focus->existinfosenfant3($record)==1) 	$display_enfant3="display:;";
	if ($focus->existinfosenfant4($record)==1) 	$display_enfant4="display:;";
	if ($focus->existinfosenfant5($record)==1) 	$display_enfant5="display:;";
	if ($focus->existinfosenfant6($record)==1) 	$display_enfant6="display:;";
	if ($focus->existcoordbanque2($record)==1) 	$display_coordbank2="display:;";
	if ($focus->existcoordbanque3($record)==1) 	$display_coordbank3="display:;";
	if ($focus->existcoordbanque4($record)==1) 	$display_coordbank4="display:;";
	if ($focus->existcoordbanque5($record)==1) 	$display_coordbank5="display:;";
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

//	print_r(getBlocks($currentModule, $disp_view, $focus->mode, $focus->column_fields));
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

if(isset($_REQUEST['return_module']))    $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
if(isset($_REQUEST['return_action']))    $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
if(isset($_REQUEST['return_id']))        $smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if (isset($_REQUEST['return_viewname'])) $smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);

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

$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);

//Display the FCKEditor or not? -- configure $FCKEDITOR_DISPLAY in config.php
if(getFieldVisibilityPermission('Conventions',$current_user->id,'description') != '0')
        $FCKEDITOR_DISPLAY = false;
$FCKEDITOR_DISPLAY = true;
$smarty->assign("FCKEDITOR_DISPLAY",$FCKEDITOR_DISPLAY);
 $smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);


	//$smarty->assign("PROJECTS", getAllProjectsByOrgane("1-5"));
	$smarty->assign("PROJECTS", getAllProjects());
	$smarty->assign("AGENCESEXECUTION", getAllAgencesExecution());
	$smarty->assign("DOMAINES", getAllDomaines());
	$smarty->assign("TYPESACTIVITE", getAllTypesActivite());
	$smarty->assign("LOCALITES", getAllLocalites());
	$smarty->assign("PAYS", $PAYS);
	$smarty->assign("DEVISES",$DEVISES);
	$smarty->assign("NBENFANTS",$NBENFANTS);
	$smarty->assign("SEXE",$SEXE);
	$smarty->assign("CIVILITE",$CIVILITE);
	$smarty->assign("SITUATIONFAMILIALE",$SITUATIONFAMILIALE);
	$smarty->assign("SCOLOUAPPRENT",$SCOLOUAPPRENT);
	$smarty->assign("SALOUCOM",$SALOUCOM);
	$smarty->assign("NATUREACTENAIS",$NATUREACTENAIS);
	$smarty->assign("NATUREPIECEIDENT",$NATUREPIECEIDENT);
	$smarty->assign("TYPECONTRAT",$TYPECONTRAT);
	$smarty->assign("CATEGORIESALARIE",$CATEGORIESALARIE);
	$smarty->assign("STATUTSALARIE",$STATUTSALARIE);
	$smarty->assign("LANGUEFORMATION",$LANGUEFORMATION);
	$smarty->assign("MODEDEPAIEMENT",$MODEDEPAIEMENT);
	$smarty->assign("PERIODEESSAI",$PERIODEESSAI);
	$smarty->assign("DIPLOME",$DIPLOME);
	$smarty->assign("PERMISCONDUIRE",$PERMISCONDUIRE);
	$smarty->assign("NIVEAUSCOLAIRE",$NIVEAUSCOLAIRE);
	$smarty->assign("NATIONNALITE",$NATIONNALITE);
	$smarty->assign("MOTIFSDEPART",$MOTIFSDEPART);
	//$smarty->assign("FONCTIONSAGENT",getfonctionsentreprise());
	
	// Siprod add end
	 $smarty->assign("DISPLAY_CONJOINT",$display_conjoint);
	 $smarty->assign("DISPLAY_COORDBANK2",$display_coordbank2);
	 $smarty->assign("DISPLAY_COORDBANK3",$display_coordbank3);
	 $smarty->assign("DISPLAY_COORDBANK4",$display_coordbank4);
	 $smarty->assign("DISPLAY_COORDBANK5",$display_coordbank5);
	 $smarty->assign("DISPLAY_ENFANT1",$display_enfant1);
	 $smarty->assign("DISPLAY_ENFANT2",$display_enfant2);
	 $smarty->assign("DISPLAY_ENFANT3",$display_enfant3);
	 $smarty->assign("DISPLAY_ENFANT4",$display_enfant4);
	 $smarty->assign("DISPLAY_ENFANT5",$display_enfant5);
	 $smarty->assign("DISPLAY_ENFANT6",$display_enfant6);
if($focus->mode == 'edit') {
	$smarty->display('salesEditView.tpl');
} else {
	// Siprod add
	$nextidentifiant=getNextIdentifiantTiers();
	$smarty->assign('NEXTIDENTIFIANTTIERS', $nextidentifiant );
	$smarty->assign("MAITREOUVRAGE", 'COMMISSION UEMOA');
	 $smarty->assign("CURRENT_PAYS", $_SESSION['pays']);
	$smarty->display('CreateView.tpl');
}

	


?>