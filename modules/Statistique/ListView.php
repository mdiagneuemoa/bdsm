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

// Graph Info
$dataType		=	$focus->getDataParType();
$dataCampagne	=	$focus->getDataParCampagne();

$_SESSION['data_campagne']	=	$dataCampagne;
$_SESSION['data_type']		=	$dataType;

if( $dataCampagne == null || count($dataCampagne)<=0 || count($dataCampagne[0])<=0 ) 
	$smarty->assign("SHOW_CAMPAGNE_T", "ko");
if( $dataCampagne == null || count($dataCampagne)<=0 || count($dataCampagne[1])<=0 ) 
	$smarty->assign("SHOW_CAMPAGNE_S", "ko");
		
if( $dataType == null || count($dataType)<=0 || count($dataType[0])<=0 ) 
	$smarty->assign("SHOW_TYPE_T", "ko");
if( $dataType == null || count($dataType)<=0 || count($dataType[1])<=0 ) 
	$smarty->assign("SHOW_TYPE_S", "ko");
		
$smarty->assign("MYSELECTED_BAREME", $_REQUEST['bareme_field'] );
$smarty->assign("FILTERCAMPAGNE",	 getAllCampagne());
$smarty->assign("MYSELECTED_CAMP", 	 $_REQUEST['campagne_field'] );
$smarty->assign("DATEFORMAT",		 " jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", 	 "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", 	 $app_strings['LBL_JSCALENDAR_LANG']);
$smarty->assign("MYSELECTED_DS", 	 $_REQUEST['date_start'] );
$smarty->assign("MYSELECTED_DE", 	 $_REQUEST['date_end'] );

$filtre= $_REQUEST['filter'];
if ($filtre == '')
	$filtre = 'none' ;

$smarty->assign("FILTER",$filtre );
$smarty->display('Statistique.tpl');

?>