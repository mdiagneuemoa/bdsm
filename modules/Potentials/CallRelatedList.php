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


require_once('Smarty_setup.php');
require_once('modules/Potentials/Potentials.php');
require_once('modules/CustomView/CustomView.php');
//Redirecting Header for single page layout
require_once('user_privileges/default_module_view.php');
global $singlepane_view;
if($singlepane_view == 'true' && $_REQUEST['action'] == 'CallRelatedList' )
{
	header("Location:index.php?action=DetailView&module=".$_REQUEST['module']."&record=".$_REQUEST['record']."&parenttab=".$_REQUEST['parenttab']);
}
else
{
$focus = new Potentials();
$currentmodule = $_REQUEST['module'];
$RECORD = $_REQUEST['record'];

if(isset($_REQUEST['record']) && $_REQUEST['record']!='') {
    $focus->retrieve_entity_info($_REQUEST['record'],"Potentials");
    $focus->id = $_REQUEST['record'];
    $focus->name=$focus->column_fields['potentialname'];
$log->debug("id is ".$focus->id);
$log->debug("name is ".$focus->name);
}

global $mod_strings;
global $app_strings;
global $currentModule;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
        $focus->id = "";
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] != ' ') {
        $smarty->assign("OP_MODE",$_REQUEST['mode']);
}
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
$related_array = getRelatedLists($currentModule,$focus);

$category = getParentTab();


// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}

// END

/* ***********************DISPLAY FOLDER CREATED*********************/
require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

global $mod_strings,$edit_permit,$delete_permit;
global $app_strings;
global $app_list_strings;



global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
/*
$oCustomView = new CustomView("Potentials");
$viewid = $oCustomView->getViewId($currentModule);
$edit_permit = $oCustomView->isPermittedCustomView($viewid,'EditView',$currentModule);
$delete_permit = $oCustomView->isPermittedCustomView($viewid,'Delete',$currentModule);
*/

//Retreiving the hierarchy
$hquery = "select * from vtiger_rapportsfolder where potentialid IN ('".$focus->id."',0) order by parentfolder asc";
$hr_res = $adb->pquery($hquery, array());
$num_rows = $adb->num_rows($hr_res);
$hrarray= Array();

for($l=0; $l<$num_rows; $l++)
{
	$folderid = $adb->query_result($hr_res,$l,'folderid');
	$parent = $adb->query_result($hr_res,$l,'parentfolder');
	$temp_list = explode('::',$parent);
	$size = sizeof($temp_list);
	$i=0;
	$k= Array();
	$y=$hrarray;
	if(sizeof($hrarray) == 0)
	{
		$hrarray[$temp_list[0]]= Array();
	}
	else
	{
		while($i<$size-1)
		{
			$y=$y[$temp_list[$i]];
			$k[$temp_list[$i]] = $y;
			$i++;

		}
		$y[$folderid] = Array();
		$k[$folderid] = Array();

		//Reversing the Array
		$rev_temp_list=array_reverse($temp_list);
		$j=0;
		//Now adding this into the main array
		foreach($rev_temp_list as $value)
		{
			if($j == $size-1)
			{
				$hrarray[$value]=$k[$value];
			}
			else
			{
				$k[$rev_temp_list[$j+1]][$value]=$k[$value];
			}
			$j++;
		}
	}

}
//Constructing the Roledetails array
$folder_det = getAllRapportsFolderDetails();

$folderout ='';
$folderout .= indent($hrarray,$folderout,$folder_det,$focus->id);
$smarty->assign("FOLDERTREE", $folderout);
/*
$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
$smarty->assign("CV_DELETE_PERMIT",$delete_permit);
*/
/*******************END DISPLAY FOLDER CREATED*************************/
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
$smarty->assign("TODO_PERMISSION",CheckFieldPermission('parent_id','Calendar'));
$smarty->assign("EVENT_PERMISSION",CheckFieldPermission('parent_id','Events'));
$smarty->assign("CATEGORY",$category);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));
$smarty->assign("ID",$focus->id);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",$app_strings['Potential']);
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("ACCOUNTID",$focus->column_fields['account_id']);
$smarty->assign("RELATEDLISTS", $related_array);
$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->display("RelatedLists.tpl");
}

function indent($hrarray,$folderout,$folder_det,$potentialid)
{
	global $theme,$mod_strings,$app_strings,$edit_permit,$delete_permit;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	
	
	
	foreach($hrarray as $folderid => $value)
	{
	
		//retreiving the vtiger_folder details
		$folder_det_arr=$folder_det[$folderid];
		$folderid_arr=$folder_det_arr[2];
		$foldername = $folder_det_arr[0];
		$folderdepth = $folder_det_arr[1]; 
		$folderout .= '<ul class="uil" id="'.$folderid.'" style="display:block;list-style-type:none;">';
		$folderout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_'.$folderid.'\')" onMouseOut="fnInVisible(\'layer_'.$folderid.'\')">';
		$folderout.= '<tr><td nowrap>';
		if(sizeof($value) >0 && $folderdepth != 0)
		{	
			$folderout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
			$folderout .= '<img src="' . vtiger_imageurl('minus.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle" onClick="showhide2(\''.$folderid_arr.'\',\'img_'.$folderid.'\',\'dossier_'.$folderid.'\')" style="cursor:pointer;">';
							
		}
	
		if($folderdepth == 0){
			$folderout .= '<img src="' . vtiger_imageurl('menu_root.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_ROOT'].'" title="'.$app_strings['LBL_ROOT'].'" align="absmiddle">';
			$folderout .= '&nbsp;<b class="genHeaderGray">'.$foldername.'</b></td>';
			$folderout .= '<td nowrap><div id="layer_'.$folderid.'" class="drag_Element">';
			//if($edit_permit=='yes')
			//{
				//$folderout .= '<a onClick="createFolders(this,\'orgLay\',\''.$folderid.'\',\''.$foldername.'\',\''.$potentialid.'\',\'Rapport\');" href="#"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a>';
				$folderout .= '<a onClick="createFolderss(this,\'orgLay\',\''.$folderid.'\',\''.$foldername.'\',\''.$potentialid.'\',\'Rapport\');" href="#"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a>';
			//}
			$folderout .= '</div></td></tr></table>';
		}
		else{
			$folderout .= '<a href="javascript:put_child_ID(\'user_'.$folderid.'\');" class="x" id="user_'.$folderid.'">';
			$folderout .= '<img src="' . vtiger_imageurl('dossier-ferme.gif', $theme) . '" id="dossier_'.$folderid.'" border="0"  align="absmiddle" style="cursor:pointer;">&nbsp;'.$foldername.'</a></td>';

			$folderout.='<td nowrap><div id="layer_'.$folderid.'" class="drag_Element">';
			//if($edit_permit=='yes')
			//{
				$folderout.='<a href="#" onClick="createFolderss(this,\'orgLay\',\''.$folderid.'\',\''.$foldername.'\',\''.$potentialid.'\',\'Rapport\');"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) .'" align="absmiddle" border="0" alt="Ajouter un sous-dossier" title="Ajouter un sous-dossier"></a>';
			//}
			if($folderid != 'R1')
			{
				//if($delete_permit=='yes')
				//{
					$folderout .='<a href="#" onClick="DeleteFolderCheck(\''.$folderid.'\',\''.$foldername.'\',\'Rapport\');"><img src="' . vtiger_imageurl('RolesDelete.gif', $theme) . '" align="absmiddle" border="0" alt="Supprimer le dossier" title="Supprimer le dossier"></a>';
				//}		
			}										
		        $folderout .='</div></td></tr></table>';
//			$folderout .=	'&nbsp;<a href="index.php?module=Users&action=createfolder&parenttab=Settings&parent='.$folderid.'">Add</a> | <a href="index.php?module=Users&action=createfolder&folderid='.$folderid.'&parenttab=Settings&mode=edit">Edit</a> | <a href="index.php?module=Users&action=RoleDeleteStep1&folderid='.$folderid.'&parenttab=Settings">Delete</a> | <a href="index.php?module=Users&action=RoleDetailView&parenttab=Settings&folderid='.$folderid.'">View</a>';		


		}
 		$folderout .=  '</li>';
		if(sizeof($value) > 0 )
		{
			$folderout = indent($value,$folderout,$folder_det,$potentialid);
		}

		$folderout .=  '</ul>';

	}

	return $folderout;
}	
?>
