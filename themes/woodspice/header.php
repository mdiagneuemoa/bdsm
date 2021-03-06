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
 * $Header: /cvs/repository/siprodPCCI/themes/softed/header.php,v 1.4 2010/04/09 11:24:31 isene Exp $
 * Description:  Contains a variety of utility functions used to display UI
 * components such as form headers and footers.  Intended to be modified on a per
 * theme basis.
 ********************************************************************************/

require_once('Smarty_setup.php');
require_once("data/Tracker.php");
require_once("include/utils/utils.php");
require_once("include/calculator/Calc.php");

global $currentModule,$default_charset;
global $app_strings;
global $app_list_strings;
global $moduleList;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;
$header_array = getHeaderArray();
$smarty->assign("HEADERS",$header_array);
$smarty->assign("THEME",$theme);
$smarty->assign("IMAGEPATH",$image_path);

$qc_modules = getQuickCreateModules();
$smarty->assign("QCMODULE", $qc_modules);
$smarty->assign("APP", $app_strings);

if ($current_user->profilid == 22)
	$cnt = count($qc_modules);	
else	
	$cnt=0;

	
$smarty->assign("CNT", $cnt);

$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("MODULE_NAME", $currentModule);
$smarty->assign("DATE", getDisplayDate(date("Y-m-d H:i")));

//$smarty->assign("CURRENT_USER", $current_user->user_name);
$smarty->assign("CURRENT_USER", $current_user->user_numerologin);


//$smarty->assign("CURRENT_USER_IS_POSTEUR_DEMANDE", $current_user->isPosteurDemande($current_user->id));	// Is posteur demande if function return a value > 0
//$smarty->assign("CURRENT_USER_IS_POSTEUR_INCIDENT", $current_user->isPosteurIncident($current_user->id));	// Is posteur incident if function return a value > 0
//$smarty->assign("CURRENT_USER_IS_TRAITEUR_DEMANDE", $current_user->isTraiteurDemande($current_user->id));	// Is traieur demande if function return a value > 0
//$smarty->assign("CURRENT_USER_IS_TRAITEUR_INCIDENT", $current_user->isTraiteurIncident($current_user->id));	// Is traieur incident if function return a value > 0
//$smarty->assign("CURRENT_USER_IS_SUPERIEUR", $current_user->isSuperieur($current_user->id)); // Is n+1 if function return a value > 0
$smarty->assign("CURRENT_USER_IS_ADMIN", $current_user->is_admin);
$smarty->assign("CURRENT_USER_PROFIL_ID", $current_user->profilid);	// Is Super Utilisateur if profileid = 20
//echo "current_userid=$current_user->id";
$smarty->assign("CURRENT_USER_ID", $current_user->id);
$smarty->assign("MODULELISTS",$app_list_strings['moduleList']);
$smarty->assign("CATEGORY",getParentTab());
$smarty->assign("CALC",get_calc($image_path));
$smarty->assign("QUICKACCESS",getAllParenttabmoduleslist());
$smarty->assign("ANNOUNCEMENT",get_announcements());
$smarty->assign("USE_ASTERISK", get_use_asterisk($current_user->id));

if (is_admin($current_user)) $smarty->assign("ADMIN_LINK", "<a href='index.php?module=Settings&action=index'>".$app_strings['LBL_SETTINGS']."</a>");

$module_path="modules/".$currentModule."/";

require_once('include/Menu.php');

//Assign the entered global search string to a variable and display it again
if($_REQUEST['query_string'] != '')
	$smarty->assign("QUERY_STRING",htmlspecialchars($_REQUEST['query_string'],ENT_QUOTES,$default_charset));//BUGIX " Cross-Site-Scripting " 
else
	$smarty->assign("QUERY_STRING","$app_strings[LBL_SEARCH_STRING]");

global $module_menu;

require_once('data/Tracker.php');
$tracFocus=new Tracker();
$list = $tracFocus->get_recently_viewed($current_user->id);
$smarty->assign("TRACINFO",$list);

// Gather the custom link information to display
include_once('vtlib/Vtiger/Link.php');
$hdrcustomlink_params = Array('MODULE'=>$currentModule);
$COMMONHDRLINKS = Vtiger_Link::getAllByType(Vtiger_Link::IGNORE_MODULE, Array('HEADERLINK','HEADERSCRIPT', 'HEADERCSS'), $hdrcustomlink_params);
$smarty->assign('HEADERLINKS', $COMMONHDRLINKS['HEADERLINK']);
$smarty->assign('HEADERSCRIPTS', $COMMONHDRLINKS['HEADERSCRIPT']);
$smarty->assign('HEADERCSS', $COMMONHDRLINKS['HEADERCSS']);
// END

$gmail_bookmarklet = '<a href=\'javascript:(function()%7Bvar%20doc=top.document;var%20bodyElement=document.body;'.
'doc.vtigerURL%20=%22'.$site_URL.'/%22;var%20scriptElement=document.createElement(%22script%22);'.
'scriptElement.type=%22text/javascript%22;scriptElement.src=doc.vtigerURL+%22modules/Emails/GmailBookmarkletTrigger.js%22;'.
'bodyElement.appendChild(scriptElement);%7D)();\'>'.
$app_strings['LBL_GMAIL'].' '.$app_strings['LBL_BOOKMARKLET'].'</a>';
$smarty->assign("GMAIL_BOOKMARKLET", $gmail_bookmarklet);
$smarty->display("Header.tpl");
?>
