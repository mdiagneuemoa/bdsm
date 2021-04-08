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
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
global $app_strings, $default_charset;
global $currentModule, $current_user;
global $theme;
$url_string = '';
$smarty = new vtigerCRM_Smarty;
if (!isset($where)) $where = "";


$url = '';
$popuptype = '';
$popuptype = $_REQUEST["popuptype"];


$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("THEME_PATH",$theme_path);
$smarty->assign("MODULE",$currentModule);

$form = $_REQUEST['form'];

require_once("modules/$currentModule/Users.php");
$focus = new Users();

$smarty->assign("RETURN_ACTION",$_REQUEST['return_action']);

$query = getListQuery($currentModule,$where_relquery);

	$listview_header_search=getSearchListHeaderValues($focus,"$currentModule",$url_string,$sorder,$order_by);
	$smarty->assign("SEARCHLISTHEADER", $listview_header_search);
	$smarty->assign("ALPHABETICAL", $alphabetical);
			
if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
	$url_string .="&query=true".$ustring;
}

if(isset($where) && $where != '')
{
        $query .= ' and '.$where;
}
//Added to fix the issue #2307 

$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : $focus->default_order_by;
$sorder = (isset($_REQUEST['sorder']) && $_REQUEST['sorder'] != '') ? $_REQUEST['sorder'] : $focus->default_sort_order;

if(isset($order_by) && $order_by != '')
{
        $query .= ' ORDER BY '.$order_by.' '.$sorder;
}


$count_result = $adb->query(mkCountQuery($query));
$noofrows = $adb->query_result($count_result, 0, 'count');
//echo 'nb=',$noofrows;
//Retreiving the start value from request
if(isset($_REQUEST['start']) && $_REQUEST['start'] != '')
{
	$start = $_REQUEST['start'];
}
else
{
	$start = 1;
}
$limstart=($start-1)*$list_max_entries_per_page;
$query.=" LIMIT $limstart,$list_max_entries_per_page";
$list_result = $adb->query($query);

//Retreive the Navigation array
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
// Setting the record count string
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val']; 
if($navigation_array['start'] != 0)
	$record_string= $app_strings[LBL_SHOWING]." " .$start_rec." - ".$end_rec." " .$app_strings[LBL_LIST_OF] ." ".$noofrows;

//Retreive the List View Table Header
$focus->initSortbyField($currentModule);
$focus->list_mode="search";
$focus->popup_type=$popuptype;
$url_string .='&popuptype='.$popuptype;
if(isset($_REQUEST['select']) && $_REQUEST['select'] == 'enable')
	$url_string .='&select=enable';
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != '')
	$url_string .='&return_module='.$_REQUEST['return_module'];



$listview_header = getSearchListViewHeader($focus,"$currentModule",$url_string,$sorder,$order_by);
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("HEADERCOUNT",count($listview_header)+1);

$listview_entries = getSearchListViewEntries($focus,"$currentModule",$list_result,$navigation_array,$form); 
$smarty->assign("LISTENTITY", $listview_entries[0]);

require_once('include/Zend/Json.php');
$smarty->assign("LISTENTITYACTION", Zend_Json::encode($listview_entries[1]));

$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,$currentModule,"Popup");
$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("POPUPTYPE", $popuptype);
$smarty->assign("PARENT_MODULE", $_REQUEST['parent_module']);


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("PopupContents.tpl");
else
	$smarty->display("Popup.tpl");

?>

