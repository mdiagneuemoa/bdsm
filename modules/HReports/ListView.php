<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once("data/Tracker.php");
require_once('modules/HReports/HReports.php');
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/database/Postgres8.php');
require_once('include/DatabaseUtil.php');

require_once('include/utils/UserInfoUtil.php');
$smarty = new vtigerCRM_Smarty;

global $app_list_strings;



global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

global $app_strings,$mod_strings,$list_max_entries_per_page;

$log = LoggerManager::getLogger('hreport_list');

global $currentModule,$image_path,$theme;
if($_REQUEST['parenttab'] != '')
{
	$category = $_REQUEST['parenttab'];
}
else
{
	$category = getParentTab();	
}	
if(!$_SESSION['lvs'][$currentModule])
{
	unset($_SESSION['lvs']);
	$modObj = new ListViewSession();
	$modObj->sorder = $sorder;
	$modObj->sortby = $order_by;
	$_SESSION['lvs'][$currentModule] = get_object_vars($modObj);
}

//<<<<cutomview>>>>>>>
$oCustomView = new CustomView("HReports");
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);
//<<<<<customview>>>>>
if (!isset($where)) $where = "";
$url_string = ''; // assigning http url string

$focus = new HReports();
// Initialize sort by fields 
$focus->initSortbyField('HReports'); 
// END
$smarty = new vtigerCRM_Smarty;
$other_text = Array();

if($_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR","The User does not have permission to delete ".$errormsg." ".$currentModule);
}else
{
        $smarty->assign("ERROR","");
}
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION['NOTES_ORDER_BY'] = $order_by;
$_SESSION['NOTES_SORT_ORDER'] = $sorder;
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

//<<<<<<<<<<<<<<<<<<< BACKUP DOCUMENT >>>>>>>>>>>>>>>>>>>>
if(isset($_REQUEST['idToBackup']))
{
	BackupRapport('Archive',$_REQUEST['idToBackup']);
}

//<<<<<<<<<<<<<<<<<<< END BACKUP DOCUMENT >>>>>>>>>>>>>>>>>>>>

if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
	// we have a query
	$url_string .="&query=true".$ustring;
	$log->info("Here is the where clause for the list view: $where");
	$smarty->assign("SEARCH_URL",$url_string);

}
if(isPermitted('HReports','Delete','') == 'yes')
{
	$smarty->assign("MASS_DELETE","yes");
	$other_text['del'] = $app_strings['LBL_MASS_DELETE'];
}

if($viewnamedesc['viewname'] == 'All')
{
	$smarty->assign("ALL", 'All');
}

//Added to handle approving or denying status-public by the admin in CustomView
$statusdetails = $oCustomView->isPermittedChangeStatus($viewnamedesc['status']);
$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);

//To check if a user is able to edit/delete a customview
$edit_permit = $oCustomView->isPermittedCustomView($viewid,'EditView',$currentModule);
$delete_permit = $oCustomView->isPermittedCustomView($viewid,'Delete',$currentModule);
$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
$smarty->assign("CV_DELETE_PERMIT",$delete_permit);

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'HReport');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
if($viewid != "0")
{
	$listquery = getListQuery("HReports");
	$query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"HReports");
}else
{
	$query = getListQuery("HReports");
}
//<<<<<<<<customview>>>>>>>>>

$hide_empty_folders = 'no';

if(isset($where) && $where != '')
{
        $query .= ' and '.$where;
        $_SESSION['export_where'] = $where;
}
else
   unset($_SESSION['export_where']);
   
$focus->query = $query;

if($viewid ==0)
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme)."' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span clas
		s='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
	echo "</td></tr></table>";
	exit;
}

$record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings[LBL_LIST_OF] ." ".$noofrows;


//Retreive the List View Table Header
if($viewid !='')
$url_string .="&viewname=".$viewid;

$listview_header = getListViewHeader($focus,"HReports",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);
$listview_header_search = getSearchListHeaderValues($focus,"HReports",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER",$listview_header_search);

$smarty->assign("SELECT_SCRIPT", $view_script);

$start = Array();
$request_folderid = "";
   	
if($_REQUEST['action'] == 'HReportsAjax' && isset($_REQUEST['folderid']))
{
	$request_folderid = $_REQUEST['folderid'];
	$start[$request_folderid] = $_REQUEST['start'];
}
$focus->del_create_def_folder($focus->query);
$condition = "";
if(isset($_REQUEST['folderid']))
{
	$condition = " where folderid ='".$_REQUEST['folderid']."'";
}
else
{
	$condition = " where folderid ='R1'";
}
$dbQuery = "select * from vtiger_rapportsfolder ".$condition;

$result = $adb->pquery($dbQuery,array());
$foldercount = $adb->num_rows($result);
$folders = Array();
$emptyfolders = Array();
if($foldercount > 0 )
{
	for($i=0;$i<$foldercount;$i++)
	{
		$query = '';
		$displayFolder='';
		$query = $focus->query;
		$list_query = '';
		$list_query = $focus->query;
		$folder_id = $adb->query_result($result,$i,"folderid");
		$query .= " and vtiger_hreports.folderid ='".$folder_id."'";
		
		if($folder_id != $request_folderid)
		{
			$start[$folder_id] = 1;
		}
		
		
		if(isset($order_by) && $order_by != '')
		{
			$tablename = getTableNameForField('HReports',$order_by);
			$tablename = (($tablename != '')?($tablename."."):'');

			if( $adb->dbType == "pgsql")
			{
 	    		$query .= ' GROUP BY '.$tablename.$order_by;
 	    		$list_query .= ' GROUP BY '.$tablename.$order_by;
 	    		$focus->additional_query .= ' GROUP BY '.$tablename.$order_by;
			}

        	$query .= ' ORDER BY '.$tablename.$order_by.' '.$sorder;
        	$list_query .= ' ORDER BY '.$tablename.$order_by.' '.$sorder;
        	$focus->additional_query .= ' ORDER BY '.$tablename.$order_by.' '.$sorder;
		}
		
		//Retreiving the no of rows
		$count_result = $adb->query( mkCountQuery( $query));
		$num_records = $adb->query_result($count_result,0,"count");
		if($num_records > 0){
			$displayFolder=true;
		}
		//navigation start
		$max_entries_per_page = 20; 
		//Storing Listview session object
		if($_SESSION['lvs'][$currentModule])
		{
			setSessionVar($_SESSION['lvs'][$currentModule],$num_records,$max_entries_per_page);
		}
		
		//added for 4600                                                                                                                            
		if($num_records <= $max_entries_per_page)
        	$_SESSION['lvs'][$currentModule]['start'] = 1;
		//ends

		//Retreive the Navigation array
		$navigation_array = getNavigationValues($start[$folder_id], $num_records, $max_entries_per_page);
		//Postgres 8 fixes
		if( $adb->dbType == "pgsql")
     		$query = fixPostgresQuery( $query, $log, 0);

		// Setting the record count string
		//modified by rdhital
		$start_rec = $navigation_array['start'];
		$end_rec = $navigation_array['end_val']; 
		
		$_SESSION['nav_start']=$start_rec;
		$_SESSION['nav_end']=$end_rec;

		//limiting the query
		if ($start_rec ==0) 
			$limit_start_rec = 0;
		else
			$limit_start_rec = $start_rec -1;
	
 		if( $adb->dbType == "pgsql")
     		$list_result = $adb->pquery($query. " OFFSET $limit_start_rec LIMIT $max_entries_per_page",array());
 		else
     		$list_result = $adb->pquery($query. " LIMIT $limit_start_rec, $max_entries_per_page",array());
     		
		//navigation end
		
		$folder_details=Array();
		$folderid = $adb->query_result($result,$i,"folderid");
		$folder_details['folderid']=$folderid;
		$smarty->assign("FOLDERID", $folderid);
		$folder_details['foldername']=$adb->query_result($result,$i,"foldername");
		$foldername = $folder_details['foldername'];
		$folder_details['description']=$adb->query_result($result,$i,"description");
		$folder_files = getListViewEntries($focus,"HReports",$list_result,$navigation_array,"","","EditView","Delete",$oCustomView);
		$folder_details['entries']= $folder_files;
		$folder_details['navigation'] = getTableHeaderNavigation($navigation_array, $url_string,"HReports",$folder_id,$viewid);
		//if ($displayFolder == true) {
			$folders[$foldername] = $folder_details;
		//} else{
		//	$emptyfolders[$foldername] = $folder_details;
		//}
	}
}
else
{
	$smarty->assign("NO_FOLDERS","yes");
}


/* ***********************DISPLAY FOLDER CREATED*********************/



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
//Constructing the Roledetails array
$folder_det = getAllRapportsFolderDetails();
/*$query = "select * from vtiger_rapportsfolder";
$result = $adb->pquery($query, array());
$num_rows=$adb->num_rows($result);
*/
$folderout ='';
$folderout .= indent($hrarray,$folderout,$folder_det);

$smarty->assign("FOLDERTREE", $folderout);
/*******************END DISPLAY FOLDER CREATED*************************/


$smarty->assign("NO_OF_FOLDERS",$foldercount);
$smarty->assign("FOLDERS", $folders);
$smarty->assign("EMPTY_FOLDERS", $emptyfolders);
$smarty->assign("ALL_FOLDERS", array_merge($folders, $emptyfolders));

//Added to select Multiple records in multiple pages
$smarty->assign("SELECTEDIDS", $_REQUEST['selobjs']);
$smarty->assign("ALLSELECTEDIDS", $_REQUEST['allselobjs']);

$alphabetical = AlphabeticalSearch($currentModule,'index','hreports_title','true','basic',"","","","",$viewid);
$fieldnames = getAdvSearchfields($module);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
if($current_user->id == 1)
	$smarty->assign("IS_ADMIN","on");
$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$_SESSION['documents_listquery'] = $list_query;


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '' || $_REQUEST['mode'] == 'ajax')
	$smarty->display("HReportsListViewEntries.tpl");
else	
	$smarty->display("HReportsListView.tpl");
	
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
		$folderout .= '<ul id="'.$folderid.'" style="display:block;list-style-type:none;">';
		$folderout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_'.$folderid.'\')" onMouseOut="fnInVisible(\'layer_'.$folderid.'\')">';
		$folderout.= '<tr><td nowrap>';
		if(sizeof($value) >0 && $folderdepth != 0)
		{	
			//$folderout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
			$folderout .= '<img src="' . vtiger_imageurl('minus.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" title="'.$app_strings['LBL_EXPAND_COLLAPSE'].'" align="absmiddle" onClick="showhide2(\''.$folderid_arr.'\',\'img_'.$folderid.'\',\'dossier_'.$folderid.'\')" style="cursor:pointer;">';
							
		}
		
		if($folderdepth == 0){
			$folderout .= '<img src="' . vtiger_imageurl('menu_root.gif', $theme) . '" id="img_'.$folderid.'" border="0"  alt="'.$app_strings['LBL_ROOT'].'" title="'.$app_strings['LBL_ROOT'].'" align="absmiddle">';
			$folderout .= '&nbsp;<b class="smallf"><a class="smallf" href="index.php?action=ListView&module=HReports&parenttab=Espace Rapportage&folderid='.$folderid.'">'.$foldername.'</a></b></td>';
			$folderout .= '</tr></table>';
		}
		else{
			
			$folderout .= '&nbsp;<a class="smallf" href="index.php?action=ListView&module=HReports&parenttab=Espace Rapportage&folderid='.$folderid.'">';
			$folderout .= '<img src="' . vtiger_imageurl('dossier-ferme.gif', $theme) . '" id="dossier_'.$folderid.'" border="0"  align="absmiddle" style="cursor:pointer;">&nbsp;'.$foldername.'</a></td>';
			$folderout .='</div></td></tr></table>';

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
?>
