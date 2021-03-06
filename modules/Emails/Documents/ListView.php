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
require_once('modules/Documents/Documents.php');
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/database/Postgres8.php');
require_once('include/DatabaseUtil.php');

global $app_strings,$mod_strings,$list_max_entries_per_page;

$log = LoggerManager::getLogger('note_list');

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
$oCustomView = new CustomView("Documents");
$viewid = $oCustomView->getViewId($currentModule);
$customviewcombo_html = $oCustomView->getCustomViewCombo($viewid);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);
//<<<<<customview>>>>>
if (!isset($where)) $where = "";
$url_string = ''; // assigning http url string

$focus = new Documents();
// Initialize sort by fields 
$focus->initSortbyField('Documents'); 
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


if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
	// we have a query
	$url_string .="&query=true".$ustring;
	$log->info("Here is the where clause for the list view: $where");
	$smarty->assign("SEARCH_URL",$url_string);

}
if(isPermitted('Documents','Delete','') == 'yes')
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
$smarty->assign("SINGLE_MOD",'Document');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);

//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
if($viewid != "0")
{
	$listquery = getListQuery("Documents");
	$query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,"Documents");
}else
{
	$query = getListQuery("Documents");
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

$listview_header = getListViewHeader($focus,"Documents",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("LISTHEADER", $listview_header);
$listview_header_search = getSearchListHeaderValues($focus,"Documents",$url_string,$sorder,$order_by,"",$oCustomView);
$smarty->assign("SEARCHLISTHEADER",$listview_header_search);

$smarty->assign("SELECT_SCRIPT", $view_script);

$start = Array();
$request_folderid = '';
   	
if($_REQUEST['action'] == 'DocumentsAjax' && isset($_REQUEST['folderid']))
{
	$request_folderid = $_REQUEST['folderid'];
	$start[$request_folderid] = $_REQUEST['start'];
}
$focus->del_create_def_folder($focus->query);
 
$dbQuery = "select * from vtiger_attachmentsfolder";
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
		$query .= " and vtiger_notes.folderid = $folder_id";
		if($folder_id != $request_folderid)
		{
			$start[$folder_id] = 1;
		}
		
		
		if(isset($order_by) && $order_by != '')
		{
			$tablename = getTableNameForField('Documents',$order_by);
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
		$max_entries_per_page = 5; 
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
		$folder_details['foldername']=$adb->query_result($result,$i,"foldername");
		$foldername = $folder_details['foldername'];
		$folder_details['description']=$adb->query_result($result,$i,"description");
		$folder_files = getListViewEntries($focus,"Documents",$list_result,$navigation_array,"","","EditView","Delete",$oCustomView);
		$folder_details['entries']= $folder_files;
		$folder_details['navigation'] = getTableHeaderNavigation($navigation_array, $url_string,"Documents",$folder_id,$viewid);
		if ($displayFolder == true || $folderid == 1) {
			$folders[$foldername] = $folder_details;
		} else{
			$emptyfolders[$foldername] = $folder_details;
		}
	}
}
else
{
	$smarty->assign("NO_FOLDERS","yes");
}

$smarty->assign("NO_OF_FOLDERS",$foldercount);
$smarty->assign("FOLDERS", $folders);
$smarty->assign("EMPTY_FOLDERS", $emptyfolders);
$smarty->assign("ALL_FOLDERS", array_merge($folders, $emptyfolders));

//Added to select Multiple records in multiple pages
$smarty->assign("SELECTEDIDS", $_REQUEST['selobjs']);
$smarty->assign("ALLSELECTEDIDS", $_REQUEST['allselobjs']);

$alphabetical = AlphabeticalSearch($currentModule,'index','notes_title','true','basic',"","","","",$viewid);
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
	$smarty->display("DocumentsListViewEntries.tpl");
else	
	$smarty->display("DocumentsListView.tpl");
?>
