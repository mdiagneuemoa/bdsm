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
 * Contributor(s): ______________________________________..
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/HReports/Save.php,v 1.1 2010/01/15 18:44:44 isene Exp $
 * Description:  Saves an Account record and then redirects the browser to the
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/HReports/HReports.php');
require_once('modules/HReports/HReportsCommon.php');
require_once('include/logging.php');
require_once('include/upload_file.php');
global $root_directory;
$local_log =& LoggerManager::getLogger('index');
global $currentModule;
$focus = new HReports();
//added to fix 4600
setObjectValuesFromRequest($focus);
$search=$_REQUEST['search_url'];


if(isset($_REQUEST['hreportcontent']) && $_REQUEST['hreportcontent'] != "")
	$_REQUEST['hreportcontent'] = fck_from_html($_REQUEST['hreportcontent']);

if (!isset($_REQUEST['date_due_flag'])) $focus->date_due_flag = 'off';

if(isset($_REQUEST['parentid']) && $_REQUEST['parentid'] != '')
	$focus->parentid = $_REQUEST['parentid'];
if($_REQUEST['assigntype'] == 'U')  {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}
//Save the HReport

$focus->save($currentModule);

$return_id = $focus->id;
$hreport_id = $return_id;


if(isset($_REQUEST['parenttab']) && $_REQUEST['parenttab'] != "") $parenttab = $_REQUEST['parenttab'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = $_REQUEST['return_module'];
else $return_module = "HReports";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = $_REQUEST['return_action'];
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = $_REQUEST['return_id'];

$folder = "select folderid from vtiger_hreports where hreportsid = ?";
$res = $adb->pquery($folder,array($return_id));
$folderid = $adb->query_result($res,0,'folderid');

$local_log->debug("Saved record with id of ".$return_id);

// envoi de notification 
$mail_data = getRapportMailInfo($return_id,$focus->mode);
getRapportNotification($mail_data);

//Redirect to EditView if the given file is not valid.
if($file_upload_error)
{
	$return_module = 'HReports';
	$return_action = 'EditView';
	$return_id = $hreport_id.'&upload_error=true&return_module='.$_REQUEST['return_module'].'&return_action='.$_REQUEST['return_action'].'&return_id='.$_REQUEST['return_id'];
}

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=$_REQUEST['return_viewname'];
header("Location: index.php?action=$return_action&module=$return_module&parenttab=$parenttab&record=$return_id&folderid=$folderid&viewname=$return_viewname&start=".$_REQUEST['pagenumber'].$search);
?>
