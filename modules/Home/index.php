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
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/Home/index.php,v 1.6 2010/06/03 10:32:25 isene Exp $
 * Description:  Main file for the Home module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/home.php');
require_once('Smarty_setup.php');
require_once('modules/Home/HomeBlock.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');
require_once('include/freetag/freetag.class.php');
require_once 'modules/Home/HomeUtils.php';

global $app_strings, $app_list_strings, $mod_strings;
global $adb, $current_user;
global $theme;
global $current_language;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;
$homeObj=new Homestuff;

$query="select name,tabid from vtiger_tab where tabid in (select distinct(tabid) from vtiger_field where tabid <> 29 and tabid <> 16 and tabid <>10) order by name";
$result=$adb->query($query);

for($i=0;$i<$adb->num_rows($result);$i++){
	$modName=$adb->query_result($result,$i,'name');
	//Security check done by Don
	if(isPermitted($modName,'DetailView') == 'yes' && vtlib_isModuleActive($modName)){
		$modulenamearr[]=array($adb->query_result($result,$i,'tabid'),$modName);
	}	
}

//Security Check done for RSS and Dashboards

$homedetails = $homeObj->getHomePageFrame();
$maxdiv = sizeof($homedetails)-1;
$user_name = $current_user->column_fields['user_name'];
$buttoncheck['Calendar'] = isPermitted('Calendar','index');
$freetag = new freetag();
//$numberofcols = getNumberOfColumns();
// hodar crm affichage de pending et upcoming activities 2 frames
$numberofcols =1;

$smarty->assign("CHECK",$buttoncheck);
if(vtlib_isModuleActive('Calendar')){
	$smarty->assign("CALENDAR_ACTIVE","yes");
}
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",'Home');
$smarty->assign("CATEGORY",getParenttab('Home'));
$smarty->assign("CURRENTUSER",$user_name);
$smarty->assign("MAXLEN",$maxdiv);
$smarty->assign("HOMEFRAME",$homedetails);
$smarty->assign("MODULE_NAME",$modulenamearr);
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("LAYOUT", $numberofcols);

$smarty->assign("CURRENT_USER_IS_POSTEUR_DEMANDE", $current_user->isPosteurDemande($current_user->id));	// Is posteur demande if function return a value > 0
$smarty->assign("CURRENT_USER_IS_POSTEUR_INCIDENT", $current_user->isPosteurIncident($current_user->id));	// Is posteur incident if function return a value > 0
$smarty->assign("CURRENT_USER_IS_TRAITEUR_DEMANDE", $current_user->isTraiteurDemande($current_user->id));	// Is traieur demande if function return a value > 0
$smarty->assign("CURRENT_USER_IS_TRAITEUR_INCIDENT", $current_user->isTraiteurIncident($current_user->id));	// Is traieur incident if function return a value > 0
$smarty->assign("CURRENT_USER_IS_SUPERIEUR", $current_user->isSuperieur($current_user->id)); // Is n+1 if function return a value > 0
$smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);	// Is Super Utilisateur if profileid = 20

//$recordCountDemande = $_SESSION["recordCountDemande"];
//$totalRecordCountDemande = $_SESSION["totalRecordCountDemande"];
//$recordCountIncident = $_SESSION["recordCountIncident"];
//$totalRecordCountIncident = $_SESSION["totalRecordCountIncident"];
//
//$smarty->assign("RECORD_COUNT_DEMANDE", $recordCountDemande);
//$smarty->assign("TOTAL_RECORD_COUNT_DEMANDE", $totalRecordCountDemande);	
//$smarty->assign("RECORD_COUNT_INCIDENT", $recordCountIncident);
//$smarty->assign("TOTAL_RECORD_COUNT_INCIDENT", $totalRecordCountIncident);	

$demandes_a_traiter_view_all_check = $_REQUEST["Demandes_a_traiter_view_all_check"];
$incidents_a_traiter_view_all_check = $_REQUEST["Incidents_a_traiter_view_all_check"];

$smarty->assign("DEMANDES_VIEW_ALL_CHECKED", ($demandes_a_traiter_view_all_check != '') ? 'checked' : '');
$smarty->assign("INCIDENTS_VIEW_ALL_CHECKED", ($incidents_a_traiter_view_all_check!= '') ? 'checked' : '');

//echo "Demandes_a_traiter_view_all_check : $demandes_a_traiter_view_all_check, Incidents_a_traiter_view_all_check : $incidents_a_traiter_view_all_check <br/>";

//session_start();

$_SESSION["Demandes_a_traiter_view_all_check"] = $demandes_a_traiter_view_all_check;
$_SESSION["Incidents_a_traiter_view_all_check"] = $incidents_a_traiter_view_all_check;


//unset($_SESSION['recordCountDemande']);
//unset($_SESSION['totalRecordCountDemande']);
//unset($_SESSION['recordCountIncident']);
//unset($_SESSION['totalRecordCountIncident']);
//
//session_unregister('recordCountDemande');
//session_unregister('totalRecordCountDemande');
//session_unregister('recordCountIncident');
//session_unregister('totalRecordCountIncident');

$smarty->display("Home/Homestuff.tpl");

?>
