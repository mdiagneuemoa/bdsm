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


require_once('include/utils/UserInfoUtil.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

global $mod_strings;
global $app_strings;
global $app_list_strings;



global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


//Retreiving the hierarchy
$hquery = "select * from vtiger_rapportsfolder order by parentfolder asc";
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
//Constructing the folderdetails array
$folder_det = getAllFolderDetails();
$query = "select * from vtiger_rapportsfolder";
$result = $adb->pquery($query, array());
$num_rows=$adb->num_rows($result);

$folderout ='';
$folderout .= indent($hrarray,$folderout,$folder_det);

/** recursive function to construct the folder tree ui 
  * @param $hrarray -- Hierarchial folder tree array with only the folderid:: Type array
  * @param $folderout -- html string ouput of the constucted folder tree ui:: Type varchar 
  * @param $folder_det -- folderdetails array got from calling getAllfolderDetails():: Type array 
  * @returns $folder_out -- html string ouput of the constucted folder tree ui:: Type string
  *
 */

function indent($hrarray,$folderout,$folder_det)
{
	global $theme,$mod_strings,$app_strings;
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
			$folderout .= '<img src="' . vtiger_imageurl('minus.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle" onClick="showhide(\''.$folderid_arr.'\',\'img_'.$folderid.'\')" style="cursor:pointer;">';
		}
		else if($folderdepth != 0){
			$folderout .= '<img src="' . vtiger_imageurl('vtigerDevDocs.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle">';	
		}
		else{
			$folderout .= '<img src="' . vtiger_imageurl('menu_root.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_ROOT'].'" title="'.$app_strings['LBL_ROOT'].'" align="absmiddle">';
		}	
		if($folderdepth == 0 ){
			$folderout .= '&nbsp;<b class="genHeaderGray">'.$foldername.'</b></td>';
			$folderout .= '<td nowrap><div id="layer_'.$folderid.'" class="drag_Element"><a href="index.php?module=Settings&action=createfolder&parenttab=Settings&parent='.$folderid.'"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) . '" align="absmiddle" border="0" alt="'.$mod_strings['LBL_ADD_ROLE'].'" title="'.$mod_strings['LBL_ADD_ROLE'].'"></a></div></td></tr></table>';
		}
		else{
			$folderout .= '&nbsp;<a href="javascript:put_child_ID(\'user_'.$folderid.'\');" class="x" id="user_'.$folderid.'">'.$foldername.'</a></td>';

			$folderout.='<td nowrap><div id="layer_'.$folderid.'" class="drag_Element">
													<a href="index.php?module=Settings&action=createfolder&parenttab=Settings&parent='.$folderid.'"><img src="' . vtiger_imageurl('Rolesadd.gif', $theme) .'" align="absmiddle" border="0" alt="'.$mod_strings['LBL_ADD_ROLE'].'" title="'.$mod_strings['LBL_ADD_ROLE'].'"></a>
													<a href="index.php?module=Settings&action=createfolder&folderid='.$folderid.'&parenttab=Settings&mode=edit"><img src="' . vtiger_imageurl('RolesEdit.gif', $theme) . '" align="absmiddle" border="0" alt="'.$mod_strings['LBL_EDIT_ROLE'].'" title="'.$mod_strings['LBL_EDIT_ROLE'].'"></a>';

			if($folderid != 'R1')
			{
							
				$folderout .=	'<a href="index.php?module=Settings&action=RoleDeleteStep1&folderid='.$folderid.'&parenttab=Settings"><img src="' . vtiger_imageurl('RolesDelete.gif', $theme) . '" align="absmiddle" border="0" alt="'.$mod_strings['LBL_DELETE_ROLE'].'" title="'.$mod_strings['LBL_DELETE_ROLE'].'"></a>';
			}		
													
		        $folderout .='<a href="javascript:;" class="small" onClick="get_parent_ID(this,\'user_'.$folderid.'\')"><img src="' . vtiger_imageurl('RolesMove.gif', $theme) . '" align="absmiddle" border="0" alt="'.$mod_strings['LBL_MOVE_ROLE'].'" title="'.$mod_strings['LBL_MOVE_ROLE'].'"></a>
												</div></td></tr></table>';
//			$folderout .=	'&nbsp;<a href="index.php?module=Users&action=createfolder&parenttab=Settings&parent='.$folderid.'">Add</a> | <a href="index.php?module=Users&action=createfolder&folderid='.$folderid.'&parenttab=Settings&mode=edit">Edit</a> | <a href="index.php?module=Users&action=RoleDeleteStep1&folderid='.$folderid.'&parenttab=Settings">Delete</a> | <a href="index.php?module=Users&action=RoleDetailView&parenttab=Settings&folderid='.$folderid.'">View</a>';		


		}
 		$folderout .=  '</li>';
		if(sizeof($value) > 0 )
		{
			$folderout = indent($value,$folderout,$folder_det);
		}

		$folderout .=  '</ul>';

	}

	return $folderout;
}
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("FOLDERTREE", $folderout);
/*
if($_REQUEST['ajax'] == 'true')
{
	$smarty->display("FolderTree.tpl");
}
else
{
	$smarty->display("ListFolders.tpl");
}*/
?>
