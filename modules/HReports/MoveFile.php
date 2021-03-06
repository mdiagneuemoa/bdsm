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

require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $current_user;
if($current_user->is_admin != 'on')
{
	echo 'NOT_PERMITTED';
	die;	
}
else
{
	$new_folderid = $_REQUEST['folderid'];
	
	if(isset($_REQUEST['idlist']) && $_REQUEST['idlist']!= '')
	{
		$id_array = Array();
		$id_array = explode(';',$_REQUEST['idlist']);
		for($i = 0;$i < count($id_array)-1;$i++)
		{
			ChangeFolder($id_array[$i],$new_folderid);	
		}
		header("Location: index.php?action=HReportsAjax&file=ListView&mode=ajax&module=HReports");
	}
}

/** To Change the HReports to another folder
  * @param $recordid -- The file id
  * @param $new_folderid -- The folderid to which the file to be moved
  * @returns nothing 
 */
function ChangeFolder($recordid,$new_folderid)
{
	global $adb;
	$sql="update vtiger_hreports set folderid=".$new_folderid." where hreportsid in (".$recordid.")";
	$res=$adb->pquery($sql,array());
}
?>
