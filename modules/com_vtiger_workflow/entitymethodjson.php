<?php
require_once("include/Zend/Json.php");
require_once('modules/com_vtiger_workflow/VTEntityMethodManager.inc');

function vtEntityMethodJson($adb, $request){
	$moduleName = $request['module_name'];
	$emm = new VTEntityMethodManager($adb);
	$methodNames = $emm->methodsForModule($moduleName);
	echo Zend_Json::encode($methodNames);
}

vtEntityMethodJson($adb, $_REQUEST);
?>