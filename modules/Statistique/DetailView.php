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

$data_graf=$focus->getInfoDay();
$_SESSION['data_graf0']=$data_graf[0];
$_SESSION['data_graf1']=$data_graf[1];

$data_graf1=$focus->getInfoNbEvalAdp();
$_SESSION['data_graf2']=$data_graf1[0];
$_SESSION['data_graf3']=$data_graf1[1];
$_SESSION['data_graf4']=$data_graf1[2];

$data_graf2 = $focus->getInfoNoteMoyenneCC();
$_SESSION['data_graf5'] = $data_graf2[0];
$_SESSION['data_graf6'] = $data_graf2[1];

//print_r($data_graf2);

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


// Graph adds end

$filtre= $_REQUEST['filter'];
if ($filtre == '')
	$filtre= 'none' ;

$smarty->assign("FILTER",$filtre );
$smarty->display('StatisticsGraphiques.tpl');

?>