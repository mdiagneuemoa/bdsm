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
 * $Header: /cvs/repository/siprodPCCI/modules/Incidents/ListViewATraiter.php,v 1.11 2010/06/03 12:53:04 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**Function to get the top 5 Accounts order by Amount in Descending Order
 *return array $values - array with the title, header and entries like  Array('Title'=>$title,'Header'=>$listview_header,'Entries'=>$listview_entries) where as listview_header and listview_entries are arrays of header and entity values which are returned from function getListViewHeader and getListViewEntries
*/
function getIncidentsATraites($maxval,$calCnt)
{
	$log = LoggerManager::getLogger('Incidents à traiter');
	$log->debug("Entering getDemandesATraites() method ...");
	require_once("data/Tracker.php");
	require_once('modules/Potentials/Potentials.php');
	require_once('include/logging.php');
	require_once('include/ListView/ListView.php');
	global $app_strings;
	global $adb;
	global $current_language;
	global $current_user;
	$current_module_strings = return_module_language($current_language, "Incidents");
	
	$list_query_bis = "";
	
	$where = " AND (siprod_incident.statut='pending' or siprod_incident.statut='open' or siprod_incident.statut='transfered' or siprod_incident.statut='reopen') ";
	$limitResult = " limit 10 ";
	
	if($current_user->isTraiteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
		$where = " AND (siprod_incident.statut='pending' or siprod_incident.statut='reopen' or siprod_incident.statut='open' or siprod_incident.statut='transfered') ";
		
		$list_query = "	SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,siprod_incident.statut,
				siprod_incident.ticket,siprod_incident.incidentid,operations.Op_Lib as campagne,
				siprod_type_incidents.nom as lbtypeincident,siprod_incident.popimpactee,
				siprod_incidentcf.* 
				
				FROM siprod_incident 
				
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid 
				INNER JOIN siprod_type_incidents ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident 
				INNER JOIN operations ON operations.Op_Id = siprod_incident.campagne 
				INNER JOIN siprod_incidentcf ON siprod_incident.incidentid = siprod_incidentcf.incidentid  ";
	
	    if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	    	$list_query = $list_query." 
	    	    INNER JOIN vtiger_groups g ON instr(concat(' ', siprod_type_incidents.groupid, ' '), concat(' ', g.groupid, ' ')) > 0 
				INNER JOIN siprod_traitement_incidents ON siprod_traitement_incidents.ticket = siprod_incident.ticket 
						
				WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
				or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id)) 
				And vtiger_crmentity.deleted =0 				
				AND (siprod_incident.statut <>'closed') 
				AND (siprod_incident.statut <>'traited') 
				or   ( siprod_traitement_incidents.statut = 'transfered'and siprod_incident.statut='transfered'
				and  (siprod_traitement_incidents.destination in (select groupid from vtiger_users2group where userid = $current_user->id) 
				      or siprod_traitement_incidents.destination in (select groupid from siprod_groupsupcoord where supid = $current_user->id)))
				";
	    }
	    else	
		    $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";	
		
		$list_query = $list_query.$where." order by createdtime desc ";
		
		$list_query_bis = $list_query;
		$list_query = $list_query.$limitResult;
	}
	elseif($current_user->isPosteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
		//$where = " AND (siprod_incident.statut <> 'closed') ";
		
		$list_query = "	SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,siprod_incident.statut,
			siprod_incident.ticket,siprod_incident.incidentid,operations.Op_Lib as campagne,siprod_type_incidents.nom as lbtypeincident,siprod_incident.popimpactee,
			siprod_incidentcf.*
			FROM siprod_incident
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = siprod_incident.incidentid
			INNER JOIN siprod_type_incidents
				ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident
			INNER JOIN operations
				ON operations.Op_Id = siprod_incident.campagne
			INNER JOIN siprod_incidentcf
				ON siprod_incident.incidentid = siprod_incidentcf.incidentid ";
		
	   // restriction au user connecté
	   if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	   		$list_query = $list_query." INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid ";
		    $list_query = $list_query."  WHERE vtiger_crmentity.deleted =0  and users.user_id=".$current_user->id;
        } 
        else{
		   $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";
        }   		
		$list_query = $list_query.$where." order by createdtime desc ";
		
		$list_query_bis = $list_query;
		$list_query = $list_query.$limitResult;
	}
	
	$incidents_a_traiter_view_all_check = $_SESSION["Incidents_a_traiter_view_all_check"];
	
	if (isset($incidents_a_traiter_view_all_check) && ($incidents_a_traiter_view_all_check == 'Incidents_a_traiter_view_all_check' || $incidents_a_traiter_view_all_check == 'on')) {
		
		$where = " AND (siprod_incident.statut='pending' or siprod_incident.statut='open') ";
		
		$list_query = " SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,siprod_incident.statut,
				siprod_incident.ticket,siprod_incident.incidentid,operations.Op_Lib as campagne,siprod_type_incidents.nom as lbtypeincident,siprod_incident.popimpactee,
				siprod_incidentcf.*
				FROM siprod_incident
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = siprod_incident.incidentid
				INNER JOIN siprod_type_incidents
					ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident
				INNER JOIN operations
					ON operations.Op_Id = siprod_incident.campagne
				INNER JOIN siprod_incidentcf
					ON siprod_incident.incidentid = siprod_incidentcf.incidentid
							
				WHERE vtiger_crmentity.deleted = 0 order by createdtime desc ";
				
//			$list_query = "SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,siprod_incident.statut,
//				siprod_incident.ticket,siprod_incident.incidentid,operations.Op_Lib as campagne,
//				siprod_type_incidents.nom as lbtypeincident,siprod_incident.popimpactee,
//				siprod_incidentcf.* 
//				
//				FROM siprod_incident 
//				
//				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid 
//				INNER JOIN siprod_type_incidents ON siprod_type_incidents.typeincidentid = siprod_incident.typeincident 
//				INNER JOIN operations ON operations.Op_Id = siprod_incident.campagne 
//				INNER JOIN siprod_incidentcf ON siprod_incident.incidentid = siprod_incidentcf.incidentid 
//				INNER JOIN vtiger_groups g ON instr(concat(' ', siprod_type_incidents.groupid, ' '), concat(' ', g.groupid, ' ')) > 0 
//				INNER JOIN siprod_traitement_incidents ON siprod_traitement_incidents.ticket = siprod_incident.ticket 
//						
//				WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
//				or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id)) 
//				And vtiger_crmentity.deleted =0 				
//				AND (siprod_incident.statut <>'closed') 
//				
//				or   ( siprod_traitement_incidents.statut = 'transfered'and siprod_incident.statut='transfered'
//				and  (siprod_traitement_incidents.destination in (select groupid from vtiger_users2group where userid = $current_user->id) 
//				      or siprod_traitement_incidents.destination in (select groupid from siprod_groupsupcoord where supid = $current_user->id)))
//				
//				order by createdtime desc limit 10
//				";
	}
	
//	echo "List_query : $list_query <br/>List_query_bis : $list_query <br/>";
	$list_result=$adb->query($list_query);
	
	$res = $adb->query($list_query);
	$open_indicent_list = array();
	$noofrecords = $adb->num_rows($res);
	
	if($calCnt == 'calculateCnt'){
		return $noofrecords;
	}
	if ($noofrecords>0){
		for($i=0;$i<$noofrecords;$i++){
			$open_indicent_list[] = array(
										'numero' => '',
										'immatriculation' => '',
										'libelle' => '',
										'statut' => '',
										'montant' => '',
										'bailleurs' => '',
										'maitriseouvrages' => '',
										'localite' => '',

									);
		}
	}

	$req = $adb->pquery($list_query_bis, array());
	$recordCount = $adb->num_rows($req);
	
	$_SESSION["recordCountIncident"] = $noofrecords;
	$_SESSION["totalRecordCountIncident"] = $recordCount;
			
	unset($_SESSION['Incidents_a_traiter_view_all_check']);
	session_unregister('Incidents_a_traiter_view_all_check');
	
	$values = getIncidentEntries($open_indicent_list);
	return $values;

}

function getIncidentEntries($open_indicent_list){
	global $current_language, $app_strings;
	$current_module_strings = return_module_language($current_language, 'Incidents');
	
	$header=array();
	$header[] ='Numero';
	$header[] ='Immatriculation';
	$header[] ='Libelle';
	$header[] ='Statut';
	$header[] ='Montant';
	$header[] ='Bailleur(s)';
	$header[] ='Maitrise(s) d\'ouvrage';
	$header[] ='Localite';


		
	if(!empty($open_indicent_list)){
		$entries = array();
		foreach($open_indicent_list as $indicent){
			
			$entity_statut = decode_html($indicent["statut"]);
			$img='';
			$value = ($current_module_strings[$entity_statut] != '') ? $current_module_strings[$entity_statut] : (($app_strings[$entity_statut] != '') ? ($app_strings[$entity_statut]) : $entity_statut);
			switch($entity_statut)
			{
				Case "open": {$img = '<img src="'. vtiger_imageurl('statut-atraiter.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "reopen": {$img =  '<img src="'. vtiger_imageurl('statut-retraiter.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "pending": {$img = '<img src="'. vtiger_imageurl('statut-en_cours.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "traited": {$img = '<img src="'. vtiger_imageurl('statut-traite.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "transfered": {$img = '<img src="'. vtiger_imageurl('statut-transfere.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "closed": {$img = '<img src="'. vtiger_imageurl('okvert.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
			}
			
			$entries[$indicent['ticket']] = array(
					'0' => '<a href="index.php?action=DetailView&module=Incidents&record='.$indicent["incidentid"].'" ;">'.$indicent["numero"].'',
					'1'=> $indicent["immatriculation"],
					'2'=> $indicent["libelle"],
					'3'=> $indicent["statut"],
					'4'=> $indicent["montant"],
					'5'=> $indicent["bailleurs"],
					'6'=> $indicent["maitriseouvrages"],
					'7'=> $indicent["localite"],
					
					);
		}
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$entries);
	}else{
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$current_module_strings['LBL_NO_DATA']);
	}
	//print_r($values);
	return $values;
}
?>
