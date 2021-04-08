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
 * $Header: /cvs/repository/siprodPCCI/modules/Demandes/ListViewATraiter.php,v 1.10 2010/06/03 12:53:03 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

function getDemandeEntries($open_indicent_list){
	global $current_language, $app_strings;
	$current_module_strings = return_module_language($current_language, 'Demandes');
	
	$header=array();
	$header[] =$current_module_strings['ticket'];
	$header[] =$current_module_strings['TypeDemande'];
	//$header[] =$current_module_strings['Popimpactee'];
	$header[] =$current_module_strings['Campagne'];
	$header[] =$current_module_strings['LBL_DATE_CREATION'];

		
	if(!empty($open_indicent_list)){
		$entries = array();
		foreach($open_indicent_list as $indicent){
			
			$entries[$indicent['ticket']] = array(
					'0' => '<a href="index.php?action=DetailView&module=Demandes&record='.$indicent["demandeid"].'" ;">'.$indicent["ticket"].'</a>',
					'1'=> $indicent["typedemande"],
					//'2'=> $indicent["popimpactee"],
					'2'=> $indicent["campagne"],
					'3'=> $indicent["date_creation"],
					
					);
		}
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$entries);
	}else{
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$current_module_strings['LBL_NO_DATA']);
	}
	//print_f($values);
	return $values;
}

/**Function to get the top 5 Accounts order by Amount in Descending Order
 *return array $values - array with the title, header and entries like  Array('Title'=>$title,'Header'=>$listview_header,'Entries'=>$listview_entries) where as listview_header and listview_entries are arrays of header and entity values which are returned from function getListViewHeader and getListViewEntries
*/
function getDemandesATraites($maxval,$calCnt)
{
	$log = LoggerManager::getLogger('Demandes à traiter');
	$log->debug("Entering getDemandesATraites() method ...");
	require_once("data/Tracker.php");
	require_once('modules/Potentials/Potentials.php');
	require_once('include/logging.php');
	require_once('include/ListView/ListView.php');
	global $app_strings;
	global $adb;
	global $current_language;
	global $current_user;
	$current_module_strings = return_module_language($current_language, "Demandes");
	
	$list_query_bis = "";
	
	$where = " AND (siprod_demande.statut='pending' or siprod_demande.statut='open' or siprod_demande.statut='transfered') ";
	$limitResult = " limit 10 ";
		
	if($current_user->isTraiteurDemande($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
//		$where = " AND (siprod_demande.statut='pending' or siprod_demande.statut='open' or siprod_demande.statut='transfered') ";
		
		$list_query = "SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
			siprod_demande.ticket,siprod_demande.demandeid,operations.Op_Lib as campagne,siprod_type_demandes.nom as lbtypedemande,
			siprod_demandecf.*
			FROM siprod_demande
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = siprod_demande.demandeid
			INNER JOIN siprod_type_demandes
				ON siprod_type_demandes.typedemandeid = siprod_demande.typedemande
			INNER JOIN operations
				ON operations.Op_Id = siprod_demande.campagne
					INNER JOIN siprod_demandecf
				ON siprod_demande.demandeid = siprod_demandecf.demandeid ";
		
			// restriction au user connecté
	
	    if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	    	$list_query = $list_query." INNER JOIN vtiger_groups g ON g.groupid = siprod_type_demandes.groupid
			 WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
					or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id))
				    And vtiger_crmentity.deleted =0 ";
	    }
	    else {	
		    $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";
	    }
	    
		$list_query = $list_query.$where." order by createdtime desc ";
		$list_query_bis = $list_query;
		$list_query = $list_query.$limitResult;
	}
	elseif($current_user->isPosteurDemande($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
//		$where = " AND (siprod_demande.statut <> 'closed') ";
		
		$list_query = "SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
			siprod_demande.ticket,siprod_demande.demandeid,operations.Op_Lib as campagne,siprod_type_demandes.nom as lbtypedemande,
			siprod_demandecf.*
			FROM siprod_demande
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = siprod_demande.demandeid
			INNER JOIN siprod_type_demandes
				ON siprod_type_demandes.typedemandeid = siprod_demande.typedemande
			INNER JOIN operations
				ON operations.Op_Id = siprod_demande.campagne
					INNER JOIN siprod_demandecf
				ON siprod_demande.demandeid = siprod_demandecf.demandeid ";
		
			// restriction au user connecté
	
		   if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
		   		$list_query = $list_query." INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid ";
			    $list_query = $list_query." WHERE vtiger_crmentity.deleted =0  and users.user_id=".$current_user->id;
	        } 
	        else{
			   $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";
	        }   		
		$list_query = $list_query.$where ." order by createdtime desc ";
		
		$list_query_bis = $list_query;
		$list_query = $list_query.$limitResult;
		
	}

	$demandes_a_traiter_view_all_check = $_SESSION["Demandes_a_traiter_view_all_check"];
	
	if (isset($demandes_a_traiter_view_all_check) && ($demandes_a_traiter_view_all_check == 'Demandes_a_traiter_view_all_check' || $demandes_a_traiter_view_all_check == 'on')) {
		
//		$where = " AND (siprod_demande.statut='pending' or siprod_demande.statut='open') ";
		
		$list_query = " SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
			siprod_demande.ticket,siprod_demande.demandeid,operations.Op_Lib as campagne,siprod_type_demandes.nom as lbtypedemande,
			siprod_demandecf.*
			FROM siprod_demande
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = siprod_demande.demandeid
			INNER JOIN siprod_type_demandes
				ON siprod_type_demandes.typedemandeid = siprod_demande.typedemande
			INNER JOIN operations
				ON operations.Op_Id = siprod_demande.campagne
					INNER JOIN siprod_demandecf
				ON siprod_demande.demandeid = siprod_demandecf.demandeid
							
				WHERE vtiger_crmentity.deleted = 0 order by createdtime desc ";
	}
			
//	echo "List_query : $list_query <br/>List_query_bis : $list_query_bis <br/>";
	$list_result=$adb->query($list_query);
	$res = $adb->query($list_query);

	$open_indicent_list = array();
	$noofrecords = $adb->num_rows($res);
	
	if($calCnt == 'calculateCnt'){
		return $noofrecords;
	}
	if ($noofrecords>0){
		for($i=0;$i<$noofrecords;$i++){
			$open_indicent_list[] = array('ticket' => $adb->query_result($res,$i,'ticket'),
										'demandeid' => $adb->query_result($res,$i,'demandeid'),
										'typedemande' => $adb->query_result($res,$i,'lbtypedemande'),
										'campagne' => $adb->query_result($res,$i,'campagne'),
										//'popimpactee' => $adb->query_result($res,$i,'popimpactee'),
										'date_creation' => getDisplayDate($adb->query_result($res,$i,'createdtime')),
										
									);
		}
	}

	
	$req = $adb->pquery($list_query_bis, array());
	$recordCount = $adb->num_rows($req);
	
	$title=array();
	$title[]='myTopAccounts.gif';
	$title[]=$current_module_strings['Demandes_a_traiter'];
	$title[]='home_myaccount';
	
	$header=array();
	$header[]=$current_module_strings['Demandes_a_traiter'];
	
//	session_start();
	$_SESSION["recordCountDemande"] = $noofrecords;
	$_SESSION["totalRecordCountDemande"] = $recordCount;
	
	unset($_SESSION['Demandes_a_traiter_view_all_check']);
	session_unregister('Demandes_a_traiter_view_all_check');
	
	$values = getDemandeEntries($open_indicent_list);
	return $values;

}

?>
