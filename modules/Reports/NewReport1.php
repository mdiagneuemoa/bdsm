<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once("data/Tracker.php");
require_once('include/logging.php');
require_once('include/utils/utils.php');
require_once('modules/Reports/Reports.php');
require_once('Smarty_setup.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
$current_module_strings = return_module_language($current_language, 'Reports');
global $list_max_entries_per_page, $default_charset;
global $urlPrefix;
$log = LoggerManager::getLogger('report_list');
global $currentModule;
global $image_path;
global $theme;
global $ogReport;
// focus_list is the means of passing data to a ListView.
global $focus_list;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$list_report_form = new vtigerCRM_Smarty;
$list_report_form->assign("MOD", $mod_strings);
$list_report_form->assign("APP", $app_strings);
if(isset($_REQUEST["record"]) && $_REQUEST["record"]!='')
{
	$reportid = $_REQUEST["record"];
	$list_report_form->assign('REPORT_ID',$reportid);
	$oReport = new Reports($reportid);
	$primarymodule = $oReport->primodule;
	
	$secondarymodule = '';
	$secondarymodules =Array();
	foreach($oReport->related_modules[$primarymodule] as $key=>$value){
		if(isset($_REQUEST["secondarymodule_".$value]))$secondarymodules []= $_REQUEST["secondarymodule_".$value];
		$oReport->getSecModuleColumnsList($_REQUEST["secondarymodule_".$value]);
		if(!isPermitted($_REQUEST["secondarymodule_".$value],'index')== "yes" && !isset($_REQUEST["secondarymodule_".$value]))
		{
			$permission = false;
		}
	}
	$secondarymodule = implode(":",$secondarymodules);

	$reporttype = $oReport->reporttype;
	$reportname  = $oReport->reportname;
	$reportdescription  = $oReport->reportdescription;
	$folderid  = $oReport->folderid;	
	$ogReport = new Reports();
    $ogReport->getPriModuleColumnsList($oReport->primodule);
	if($secondarymodule==''){
		if($oReport->secmodule!=''){
			$sec_module = split(":",$oReport->secmodule);
			$secondarymodules =Array();
			foreach($sec_module as $smod){
				if(vtlib_isModuleActive($smod)){
					$secondarymodules[] = $smod; 
				}
			}
			$secondarymodule = implode(":",$secondarymodules);
		}
        $ogReport->getSecModuleColumnsList($oReport->secmodule);
	} else {
        $ogReport->getSecModuleColumnsList($secondarymodule);
	}
}else
{
	$reportname = $_REQUEST["reportname"];
	$reportdescription = $_REQUEST["reportdes"];
	$folderid = $_REQUEST["reportfolder"];
	$ogReport = new Reports();
	$primarymodule = $_REQUEST["primarymodule"];
	$secondarymodule = '';
	$secondarymodules =Array();
	foreach($ogReport->related_modules[$primarymodule] as $key=>$value){
		if(isset($_REQUEST["secondarymodule_".$value]))$secondarymodules []= $_REQUEST["secondarymodule_".$value];
		$ogReport->getSecModuleColumnsList($_REQUEST["secondarymodule_".$value]);
		if(!isPermitted($_REQUEST["secondarymodule_".$value],'index')== "yes" && !isset($_REQUEST["secondarymodule_".$value]))
		{
			$permission = false;
		}
	}
	$secondarymodule = implode(":",$secondarymodules);
	$ogReport->getPriModuleColumnsList($primarymodule);
	
	//$ogReport->getSecModuleColumnsList($secondarymodule);
	$list_report_form->assign('BACK_WALK','true');
}

$date_format='<script> var userDateFormat = \''.$current_user->date_format.'\' </script>';
$list_report_form->assign('DATE_FORMAT',$date_format);

$list_report_form->assign('PRI_MODULE',$primarymodule);
$list_report_form->assign('SEC_MODULE',$secondarymodule);
$reportname = htmlspecialchars($reportname, ENT_COMPAT, $default_charset);
$list_report_form->assign('REPORT_NAME',$reportname);
$reportdescription = htmlspecialchars($reportdescription, ENT_COMPAT, $default_charset);
$list_report_form->assign('REPORT_DESC',$reportdescription);
$list_report_form->assign('FOLDERID',$folderid);
$list_report_form->assign("IMAGE_PATH", $image_path);
$list_report_form->assign("THEME_PATH", $theme_path);
if(isPermitted($primarymodule,'index') == "yes" && $permission==false)
{
	$list_report_form->display("ReportsStep1.tpl");
}
else
{
	echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 80%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme) ."' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);'  width='70%'><span class='genHeaderSmall'>".$mod_strings['LBL_NO_PERMISSION']." ".$primarymodule." ".$secondarymodule."</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>                                                                                </td>
		</tr>
		</tbody></table>
		</div>";
	echo "</td></tr></table>";
}
?>
