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


if( $currentModule == 'TraitementDemandes' || $currentModule == 'SuiviDemandes' )
	$currentModule = 'Demandes';

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$category = getParentTab();
$url_string = '';

$tool_buttons = Button_Check($currentModule);
$list_buttons = Array();

if(isPermitted($currentModule,'Delete','') == 'yes') $list_buttons['del'] = $app_strings[LBL_MASS_DELETE];
if(isPermitted($currentModule,'Edit','') == 'yes') {
	$list_buttons['mass_edit'] = $app_strings[LBL_MASS_EDIT];
	// Mass Edit could be used to change the owner as well!
	//$list_buttons['c_owner'] = $app_strings[LBL_CHANGE_OWNER];	
}

$focus = new $currentModule();
$focus->initSortbyField($currentModule);
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION[$currentModule."_Order_by"] = $order_by;
$_SESSION[$currentModule."_Sort_Order"]=$sorder;

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

$smarty->assign('CHANGE_OWNER', getUserslist());
$smarty->assign('CHANGE_GROUP_OWNER', getGroupslist());

// Enabling Module Search
$url_string = '';
if($_REQUEST['query'] == 'true') {
	list($where, $ustring) = split('#@@#', getWhereCondition($currentModule));
	$url_string .= "&query=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

// Enabling Module Filter
if($_REQUEST['filter'] == 'true') {
	list($where, $ustring) = split('#@@#', basicFilter('Demandes'));
	$url_string .= "&filter=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
	list($stat_field,$stat_val) = explode('=',$ustring);
	$smarty->assign('SEARCH_FIELD_VAL', $stat_val);
}

// Custom View

$customView = new CustomView($currentModule);
$viewid = $customView->getViewId($currentModule);
$customview_html = $customView->getCustomViewCombo($viewid);
$viewinfo = $customView->getCustomViewByCvid($viewid);

// Feature available from 5.1
if(method_exists($customView, 'isPermittedChangeStatus')) {
	// Approving or Denying status-public by the admin in CustomView
	$statusdetails = $customView->isPermittedChangeStatus($viewinfo['status']);
	
	// To check if a user is able to edit/delete a CustomView
	$edit_permit = $customView->isPermittedCustomView($viewid,'EditView',$currentModule);
	$delete_permit = $customView->isPermittedCustomView($viewid,'Delete',$currentModule);

	$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);
	$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
	$smarty->assign("CV_DELETE_PERMIT",$delete_permit);
}
// END

$smarty->assign("VIEWID", $viewid);

if($viewinfo['viewname'] == 'All') $smarty->assign('ALL', 'All');

if($viewid ==0)
{
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme) ."' ></td>
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

$listquery = $focus->getListQuery($currentModule);
$list_query= $customView->getModifiedCvListQuery($viewid, $listquery, $currentModule);

//$_SESSION['fromListAll'] = 'YES';
//if( $current_user->isPosteurDemande($current_user->id) > 0  && $_SESSION['DemandesAtraiter'] != 'true' && $module == 'TraitementDemandes' ){

$curentusermat = $current_user->user_matricule;
//$curentusermat ='274';
 $curentuserprofil = $current_user->profilid;
 
 //echo 'mat=',$curentusermat, ' -','profil:',$curentuserprofil ;
  $curentuserid = $current_user->user_id;
  $currentuserdirection = getDirectionAgent($curentusermat);
  $currentuserdepartement = getDepartementAgent($curentusermat);
  $currentuser_isdircabpcom = is_DirecteurCabinetPCOM($curentusermat);
	$currentuser_ispcom = is_PresidentCOM($curentusermat);
	$currentuser_ispcominterim = is_PCOMInterim($curentusermat);
$smarty->assign("IS_DIRCABPCOM",is_DirecteurCabinetPCOM($curentusermat));
//$smarty->assign("IS_DIRCABPCOM",'1');
 $smarty->assign("CURRENT_USER_PROFIL",$curentuserprofil);
$currentuser_isdirinterim = is_directeurInterim($curentusermat,$currentuserdirection);
$directionsinterim = getTabToList(getdirectionsInterim($curentusermat));
$currentuser_isdircabinterim = is_dircabInterim($curentusermat);
$wherecabinetsinterim = getTabToCond(getcabinetsInterim($curentusermat));
$currentuser_iscominterim = is_CommissaireInterim($curentusermat);
$currentuser_isdircabpcominterim = is_dircabpcomInterim($curentusermat);
$currentuser_isrumvinterim = is_RUMVInterim($curentusermat);
//echo "currentuser_isrumvinterim=",$curentusermat," - ",$currentuser_isrumvinterim;
//echo "wherecabinetsinterim=",$wherecabinetsinterim;
//break;
//echo "currentuser_isdircabpcom =",$currentuser_isdircabpcom ;
//print_r(getdirectionsInterim($curentusermat));

if(  $module == 'Demandes' ){

$list_query = "SELECT DEMANDE.matricule,DEMANDE.ticket,DEMANDE.objet,(CASE WHEN DEMANDE.codebudget='' THEN 'SANS FRAIS' ELSE DEMANDE.codebudget END) AS codebudget,
				(CASE WHEN DEMANDE.sourcefin='00-00-00-00' THEN 'Ressource Propre' 
					  WHEN DEMANDE.sourcefin='00-00-00-01' THEN 'SANS FRAIS' 
					  ELSE 'Ressource Exterieure' END) sourcefin,
				DEMANDE.lieu, DEMANDE.datedebut,DEMANDE.datefin,DEMANDE.statut, DEMANDE.crmid 
				FROM
				( ";

if($curentusermat == '771')   // MEissa DIAGNE
{
	$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND nomade_demande.statut NOT IN('omgenered','ag_cancelled','ch_cancelled','om_cancelled') 
					AND vtiger_crmentity.deleted =0";
}				
elseif($currentuserdirection == '04-00-289'  || $currentuserdirection == '04-00-289')   // Demande de la cour des comptes
{
	$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction IN ('04-00-289')
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
}

elseif($currentuserdirection == '02-00-100'  || $currentuserdirection == '02-00-184')   // Demande de la cour de justice
{
	$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction IN ('02-00-100','02-00-184')
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
}
else
{
				
	if ($curentuserprofil=='20') /********** SUPER UTILISATEUR ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.deleted =0";
	}
	elseif ($currentuser_isdircabpcominterim=='1')  /******** C'est l'interim de DIRCAB PCOM ****/
	{
		//echo "InterimDCPC=true";
			$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users,users u2
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.`smcreatorid`=u2.user_id
					AND u2.User_Direction like '".$currentuserdepartement."%'
					AND nomade_demande.statut IN ('dc_submitted') 
					AND vtiger_crmentity.deleted =0";
					
			$list_query .= " UNION 
					SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users,`siprod_users` su
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND users.user_id=su.userid AND su.profilid=25
					AND nomade_demande.statut IN ('umv_accepted') 
					AND vtiger_crmentity.deleted =0 ";
			
			$list_query .= " UNION 
					SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users,users u2
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.`smcreatorid`=u2.user_id
					AND u2.User_Direction IN ('04-00-289')
					AND nomade_demande.statut IN ('umv_accepted','dcpc_submitted') 
					AND vtiger_crmentity.deleted =0 ";
	}
	elseif ($curentuserprofil=='21' && $currentuser_isrumvinterim =='0') /********** DIRECTEUR ************/
	{	
	
		if ($currentuserdirection=='01-02-124')
		{
			$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND nomade_demande.statut NOT IN('omgenered') 
					AND vtiger_crmentity.deleted =0";
		}
		else
		{
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction='".$currentuserdirection."'
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
		}
	}
	
	elseif ($curentuserprofil=='22' || $curentuserprofil=='25' || $curentuserprofil=='36') /********** DIR CAB ou COMMISSAIRE ou AAF************/
	{	
	
		if ($currentuser_ispcom=='1' || $currentuser_ispcominterim=='1')  /******** C'est le PCOM ****/
		{
			
			
			$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users,users u2
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.`smcreatorid`=u2.user_id
					AND u2.User_Direction like '".$currentuserdepartement."%'
					AND nomade_demande.statut IN ('dcpc_submitted') 
					AND vtiger_crmentity.deleted =0  ";
					
			$list_query .= "UNION  SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND nomade_demande.statut IN('umv_accepted','pcom_authorized') 
					AND vtiger_crmentity.deleted =0";
		}
		elseif ($currentuser_isdircabpcom=='1' || $currentuser_isdircabpcominterim=='1')  /******** C'est le DIRCAB PCOM ****/
		{
			
			
			$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users,users u2
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.`smcreatorid`=u2.user_id
					AND u2.User_Direction like '".$currentuserdepartement."%'
					AND nomade_demande.statut IN ('dcpc_submitted','umv_accepted') 
					AND vtiger_crmentity.deleted =0  ";
					
			$list_query .= "UNION  SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND users.User_Direction NOT IN ('03-00-100','03-00-187')
					AND nomade_demande.statut IN('umv_accepted') 
					AND vtiger_crmentity.deleted =0";
					
		}
		else
		{
			$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction like '".$currentuserdepartement."%'
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
			
			if ($currentuserdepartement == '01-04')
			{
				$list_query .= " UNION SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction='05-00-290'
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
			}
					
		}
	}
	elseif ($curentuserprofil=='26' || $currentuser_isrumvinterim =='1') /********** RESP UMV ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.deleted =0";
	}
	elseif ($curentuserprofil=='27') /********** AGENT UMV / AGENT DFC ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.deleted =0";
	}
	elseif ($curentuserprofil=='29') /********** AGENT DFC ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND vtiger_crmentity.deleted =0";
	}
	elseif ($curentuserprofil=='28') /********** AGENT IMPLANT ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND nomade_demande.statut IN ('authorized','rumv_accepted','pcom_authorized') 
					AND vtiger_crmentity.deleted =0";
	}
	
	else /********** AGENT SIMPLE ************/
	{	
		$list_query .= "SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule  
					AND  users.User_Matricule='".$curentusermat."' 
					AND nomade_demande.statut NOT IN('omgenered') 
					AND vtiger_crmentity.deleted =0";
	}				
	$list_query .= " UNION 
					SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
					nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
					FROM nomade_demande,vtiger_crmentity,users
					WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
					AND users.User_Matricule = nomade_demande.matricule 
					AND nomade_demande.statut NOT IN('omgenered') 
					AND vtiger_crmentity.smcreatorid='".$curentuserid."' AND setype='Demandes'  
					AND vtiger_crmentity.deleted =0";
	
	if($currentuser_isdirinterim == '1')
	{
		$list_query .= "  UNION 
						SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction IN (".$directionsinterim.")
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0 ";
	}
	if($currentuser_isdircabinterim == '1' || $currentuser_iscominterim == '1')
	{
		//echo "YESSSSSSS";
		$list_query .= "  UNION 
						SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id "
						.$wherecabinetsinterim.
						" AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
						
		if ($currentuserdepartement == '01-04')
			{
				$list_query .= " UNION SELECT DISTINCT CONCAT(users.user_name,' ',users.user_firstname) AS matricule,nomade_demande.ticket,nomade_demande.objet,nomade_demande.codebudget,nomade_demande.sourcefin,
						nomade_demande.lieu, nomade_demande.datedebut,nomade_demande.datefin,nomade_demande.statut, vtiger_crmentity.crmid 
						FROM nomade_demande,vtiger_crmentity,users,users u2
						WHERE vtiger_crmentity.crmid = nomade_demande.demandeid 
						AND users.User_Matricule = nomade_demande.matricule 
						AND vtiger_crmentity.`smcreatorid`=u2.user_id
						AND u2.User_Direction='05-00-290'
						AND nomade_demande.statut NOT IN('omgenered') 
						AND vtiger_crmentity.deleted =0";
			}
	}

}	
	$list_query .=" )DEMANDE ";
	
	
	//$list_query .="	AND vtiger_crmentity.deleted =0 ";
		/* INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid AND users.user_id=".$current_user->id;*/
}
//echo "currentuserdirection=",$currentuserdirection,"<br>";
//echo "curentuserprofil=",$curentuserprofil,"<br>";


if($where != '') {
	$list_query = "$list_query WHERE $where";
}
$list_query .=" ORDER BY DEMANDE.ticket DESC ";

if($_REQUEST['filter'] == 'true') 
{
	$_SESSION['currentquery'] = $list_query;
}

if (isset($_SESSION['currentquery']) && $_SESSION['currentquery']!="" && !isset($_REQUEST['query']))
{
	$list_query = $_SESSION['currentquery'];
}
// Sorting
/*
if($order_by) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY ticket '.$sorder;
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
//		$list_query .= ' ORDER BY ' . $tablename . $order_by . ' DESC ' ;//. $sorder;
		$list_query .= ' ORDER BY ' . $tablename . $order_by . ' '.$sorder; //. $sorder;
	}
}
*/
//echo '<br><br>list_query = ',$list_query, '<br>' ;
$smarty->assign('LIST_QUERY', $list_query);

$countQuery = $adb->query( mkCountQuery($list_query) );

$recordCount= $adb->query_result($countQuery,0,'count');

// Set paging start value.
$start = 1;

//if(isset($_REQUEST['start'])) { $start = $_REQUEST['start']; } 
//else { $start = $_SESSION['lvs'][$currentModule]['start']; }


if(isset($_REQUEST['start']) && $_REQUEST['start'] != '') { 
	$start = $_REQUEST['start']; 
} 
elseif(isset($_SESSION['lvs'][$currentModule]['start']) && $_SESSION['lvs'][$currentModule]['start'] != '') { 
	$start = $_SESSION['lvs'][$currentModule]['start']; 
}

// Total records is less than a page now.
if($recordCount <= $list_max_entries_per_page) $start = 1;
// Save in session
$_SESSION['lvs'][$currentModule]['start'] = $start;

$navigation_array = getNavigationValues($start, $recordCount, $list_max_entries_per_page);

$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];

$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;

if ($start_rec ==0) $limit_start_rec = 0;
else $limit_start_rec = $start_rec -1;

$list_result = $adb->query( $list_query . " LIMIT $limit_start_rec, $list_max_entries_per_page" );

$record_string= $app_strings['LBL_SHOWING']." $start_rec  -  $end_rec " . $app_strings['LBL_LIST_OF'] ." ".$recordCount;

$smarty->assign('RECORD_COUNTS', $record_string);
$smarty->assign("CUSTOMVIEW_OPTION",$customview_html);

// Navigation
$start = $_SESSION['lvs'][$currentModule]['start'];
$navigation_array = getNavigationValues($start, $recordCount, $list_max_entries_per_page);
$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string, $currentModule, 'index', $viewid);
$smarty->assign("NAVIGATION", $navigationOutput);
$listview_header = getListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);

$listview_entries = getListViewEntries($focus,$currentModule,$list_result,$navigation_array,'','','EditView','Delete',$customView);

$listview_header_search = getSearchListHeaderValues($focus,$currentModule,$url_string,$sorder,$order_by,'',$customView);

$smarty->assign('LISTHEADER', $listview_header);
$smarty->assign('LISTENTITY', $listview_entries);
$smarty->assign('SEARCHLISTHEADER',$listview_header_search);

// Module Search
$alphabetical = AlphabeticalSearch($currentModule,'index',$focus->def_basicsearch_col,'true','basic','','','','',$viewid);
$fieldnames = getAdvSearchfields($currentModule);
$criteria = getcriteria_options();
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("CRITERIA", $criteria);

$smarty->assign("AVALABLE_FIELDS", getMergeFields($currentModule,"available_fields"));
$smarty->assign("FIELDS_TO_MERGE", getMergeFields($currentModule,"fileds_to_merge"));


$smarty->assign("FILTERGROUPNAME", getAllGroupeTraiement());
$smarty->assign("FILTERSTATUT", getAllStatut());
$smarty->assign("FILTERTYPOLOGIE", getAllTypeDemande());
$smarty->assign("FILTERCAMPAGNE", getAllCampagne());
$smarty->assign("STATUTS",getAllStatuts());
//$smarty->assign("STATUTS",$DEMSTATUTS);


$smarty->assign("DATEFORMAT"," jj-mm-aaaa ");
$smarty->assign("JS_DATEFORMAT", "%d-%m-%Y");
$smarty->assign("CALENDAR_LANG", $app_strings['LBL_JSCALENDAR_LANG']);



$_SESSION[$currentModule.'_listquery'] = $list_query;

// Add for url
if($_SESSION['DemandesAtraiter'] == 'true')
	$smarty->assign('RIGHT_LABEL', 'TraitementDemandes');
elseif($_SESSION['DemandesASuivre'] == 'true')
	$smarty->assign('RIGHT_LABEL', 'SuiviDemandes');
//end
if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else 
	$smarty->display('ListView.tpl');

?>
