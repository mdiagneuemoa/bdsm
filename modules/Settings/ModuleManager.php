<?php

include_once('vtlib/Vtiger/Utils.php');

if($_REQUEST['module_settings'] == 'true') {
	$targetmodule = $_REQUEST['formodule'];

	$targetSettingPage = "modules/$targetmodule/Settings.php";
	if(file_exists($targetSettingPage)) {
		Vtiger_Utils::checkFileAccess($targetSettingPage);
		require_once($targetSettingPage);
		exit;
	}
}

$modulemanager_uploaddir = 'test/vtlib';

if($_REQUEST['module_import'] != '') {
	require_once('modules/Settings/ModuleManager/Import.php');
	exit;
} else if($_REQUEST['module_update'] != '') {
	require_once('modules/Settings/ModuleManager/Update.php');
	exit;
} else if($_REQUEST['module_import_cancel'] == 'true') {
	$uploadfile = $_REQUEST['module_import_file'];
	$uploadfilename = "$modulemanager_uploaddir/$uploadfile";
	if(file_exists($uploadfilename)) unlink($uploadfilename);
}

require_once('Smarty_setup.php');

global $mod_strings,$app_strings,$theme;
$smarty = new vtigerCRM_Smarty;
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", "themes/$theme/images/");

$module_disable = $_REQUEST['module_disable'];
$module_name = $_REQUEST['module_name'];
$module_enable = $_REQUEST['module_enable'];
$module_type = $_REQUEST['module_type'];

if($module_name != '') {
	if($module_type == 'language') {
		if($module_enable == 'true') vtlib_toggleLanguageAccess($module_name, true);
		if($module_disable== 'true') vtlib_toggleLanguageAccess($module_name, false);
	} else {
		if($module_enable == 'true') vtlib_toggleModuleAccess($module_name, true);
		if($module_disable== 'true') vtlib_toggleModuleAccess($module_name, false);
	}
}

// Check write permissions on the required directories
$dir_notwritable = Array();
if(!vtlib_isDirWriteable('test/vtlib')) $dir_notwritable[] = 'test/vtlib';
if(!vtlib_isDirWriteable('cron/modules')) $dir_notwritable[] = 'cron/modules';
if(!vtlib_isDirWriteable('modules')) $dir_notwritable[] = 'modules';
if(!vtlib_isDirWriteable('Smarty/templates/modules')) $dir_notwritable[] = 'Smarty/templates/modules';

$smarty->assign("DIR_NOTWRITABLE_LIST", $dir_notwritable);
// END

$smarty->assign("TOGGLE_MODINFO", vtlib_getToggleModuleInfo());
$smarty->assign("TOGGLE_LANGINFO", vtlib_getToggleLanguageInfo());

if($_REQUEST['mode'] !='') $mode = $_REQUEST['mode'];
$smarty->assign("MODE", $mode);

if($_REQUEST['ajax'] != 'true')	$smarty->display('Settings/ModuleManager/ModuleManager.tpl');	
else $smarty->display('Settings/ModuleManager/ModuleManagerAjax.tpl');

?>
