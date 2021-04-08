<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $app_strings, $mod_strings, $current_language, $currentModule, $theme;
global $list_max_entries_per_page;
global $current_user;

require_once('Smarty_setup.php');
require_once('include/ListView/ListView.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

$currentModule = 'OrdresMission';

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$category = getParentTab();
$url_string = '';

$tool_buttons = Button_Check($currentModule);
$list_buttons = Array();


$focus = new $currentModule();

$smarty = new vtigerCRM_Smarty();

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', true);

$smarty->assign('MOD', $mod_strings);
$smarty->assign('APP', $app_strings);
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', getTranslatedString('SINGLE_'.$currentModule));
$smarty->assign('CATEGORY', $category);
$smarty->assign('BUTTONS', $list_buttons);
$smarty->assign('CHECK', $tool_buttons);
$smarty->assign("THEME", $theme);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
/*
$query="SELECT DISTINCT SUBSTRING(users.user_direction,1,5) codedepart,dep.libdepartement
	FROM nomade_ordremission,nomade_demande,users,nomade_services dep
	WHERE  nomade_demande.demandeid = nomade_ordremission.omid  
	AND users.User_Matricule = nomade_demande.matricule
	AND nomade_ordremission.datedepart<=CURRENT_DATE() AND nomade_ordremission.datearrivee>=CURRENT_DATE()	
	AND dep.codedepartement=SUBSTRING(users.user_direction,1,5)";

$result = $adb->query($query);
$listdepart = $adb->fetchByAssoc($result);
*/
if(  $module == 'OrdresMission' )
{

	$list_query="SELECT DISTINCT nomade_ordremission.numom,SUBSTRING(users.user_direction,1,5) codedepart,dep.libdepartement,
	CONCAT(users.user_name,'  ',users.user_firstname) AS matricule,
	nomade_demande.objet,nomade_demande.lieu,
	date_format(nomade_ordremission.datedepart, '%d-%m-%Y') as datedepart,date_format(nomade_ordremission.datearrivee, '%d-%m-%Y')as datearrivee
	FROM nomade_ordremission,nomade_demande,users,vtiger_crmentity,nomade_services dep
	WHERE  nomade_demande.demandeid = nomade_ordremission.omid  
	AND vtiger_crmentity.crmid = nomade_ordremission.omid  
	AND users.User_Matricule = nomade_demande.matricule
	AND nomade_ordremission.datedepart<=CURRENT_DATE() AND nomade_ordremission.datearrivee>=CURRENT_DATE() 
	AND dep.codedepartement=SUBSTRING(users.user_direction,1,5) 
	AND nomade_ordremission.numom NOT IN ('18-1081','18-1080') ";
}
	
$list_query .=" ORDER BY codedepart,numom ";


//echo 'list_query = ',$list_query, '<br>' ;

$list_result = $adb->query($list_query);
while($row = $adb->fetchByAssoc($list_result))
{
	//$depart = $row['codedepart'];
	$listmissions[] = $row;
}
$i=0;$k=0;
while ($i<count($listmissions))
{
	$depart = $listmissions[$i]['codedepart'];
	$missions[$depart]['libdepart']=$listmissions[$i]['libdepartement'];
	$missions[$depart]['missions'][$k++] = array ('numom'=>$listmissions[$i]['numom'],'matricule'=>$listmissions[$i]['matricule'],'objet'=>$listmissions[$i]['objet'],
								   'lieu'=>$listmissions[$i]['lieu'],'datedepart'=>$listmissions[$i]['datedepart'],'datearrivee'=>$listmissions[$i]['datearrivee']);
	for ($j=$i+1;$j<count($listmissions);$j++)
	{
		if ($listmissions[$j]['codedepart']==$depart)
			$missions[$depart]['missions'][$k++] = array ('numom'=>$listmissions[$j]['numom'],'matricule'=>$listmissions[$j]['matricule'],'objet'=>$listmissions[$j]['objet'],
								   'lieu'=>$listmissions[$j]['lieu'],'datedepart'=>$listmissions[$j]['datedepart'],'datearrivee'=>$listmissions[$j]['datearrivee']);
		else
			break;
	}
	$i=$j;
}
$smarty->assign('LISTENTITY', $missions);
//print_r($missions);break;
$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $end_rec " . $app_strings['LBL_LIST_OF'] ." ".$recordCount;

$smarty->assign('RECORD_COUNTS', $record_string);
$smarty->assign('DATEJOUR', date('d-m-Y'));

$smarty->display('ListViewCurrentMission.tpl');

?>
