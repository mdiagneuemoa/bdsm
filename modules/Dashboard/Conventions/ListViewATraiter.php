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
 * $Header: /cvs/repository/siprodPCCI/modules/Conventions/ListViewATraiter.php,v 1.11 2010/06/03 12:53:04 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**Function to get the top 5 Accounts order by Amount in Descending Order
 *return array $values - array with the title, header and entries like  Array('Title'=>$title,'Header'=>$listview_header,'Entries'=>$listview_entries) where as listview_header and listview_entries are arrays of header and entity values which are returned from function getListViewHeader and getListViewEntries
*/
function getConventionsATraites($maxval,$calCnt)
{
	$log = LoggerManager::getLogger('Conventions à traiter');
	$log->debug("Entering getDemandesATraites() method ...");
	require_once("data/Tracker.php");
	require_once('modules/Potentials/Potentials.php');
	require_once('include/logging.php');
	require_once('include/ListView/ListView.php');
	global $app_strings;
	global $adb;
	global $current_language;
	global $current_user;
	$current_module_strings = return_module_language($current_language, "Conventions");
	$list_query_bis = "";
	
	$where = " AND sigc_convention.statut not in ('closed','running') ";
	$limitResult = " limit 10 ";
	
	if($current_user->isTraiteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
		$where = " AND sigc_convention.statut='initiate' not in ('closed','running') ";
		
		$list_query = "	SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,sigc_convention.conventionid,sigc_convention.ticket,sigc_convention.libelle,sigc_convention.statut,sigc_convention.montant,
				sigc_convention.datedemarrage,sigc_convention.organe,sigc_convention.bailleurs,
				sigc_convention.maitriseouvrage,sigc_convention.agenceexecution,sigc_convention.beneficiaire,
				sigc_conventioncf.* 
				
				FROM sigc_convention 
				
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = sigc_convention.conventionid 
				INNER JOIN sigc_conventioncf ON sigc_convention.conventionid = sigc_conventioncf.conventionid  ";
	
	    if( $current_user->is_admin != 'on' && $current_user->profilid != 20 ){
	    	$list_query = $list_query." 
	    	    INNER JOIN vtiger_groups g ON instr(concat(' ', sigc_type_conventions.groupid, ' '), concat(' ', g.groupid, ' ')) > 0 
				INNER JOIN sigc_traitement_conventions ON sigc_traitement_conventions.ticket = sigc_convention.ticket 
						
				WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
				or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id)) 
				And vtiger_crmentity.deleted =0 				
				AND (sigc_convention.statut <>'closed') 
				AND (sigc_convention.statut <>'traited') 
				or   ( sigc_traitement_conventions.statut = 'transfered'and sigc_convention.statut='transfered'
				and  (sigc_traitement_conventions.destination in (select groupid from vtiger_users2group where userid = $current_user->id) 
				      or sigc_traitement_conventions.destination in (select groupid from siprod_groupsupcoord where supid = $current_user->id)))
				";
	    }
	    else	
		    $list_query = $list_query." WHERE vtiger_crmentity.deleted =0 ";	
		
		$list_query = $list_query.$where." order by createdtime desc ";
		
		$list_query_bis = $list_query;
		$list_query = $list_query.$limitResult;
	}
	elseif($current_user->isPosteurIncident($current_user->id) > 0 ||  $current_user->is_admin == 'on' || $current_user->profilid == 20 ) {
		
		//$where = " AND (sigc_convention.statut <> 'closed') ";
		
		$list_query = "	SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
				sigc_convention.conventionid,sigc_convention.ticket,sigc_convention.libelle,sigc_convention.statut,sigc_convention.montant,
				sigc_convention.datedemarrage,sigc_convention.organe,sigc_convention.bailleurs,
				sigc_convention.maitriseouvrage,sigc_convention.agenceexecution,sigc_convention.beneficiaire,
			sigc_conventioncf.*
			FROM sigc_convention
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = sigc_convention.conventionid
			INNER JOIN sigc_conventioncf
				ON sigc_convention.conventionid = sigc_conventioncf.conventionid ";
		
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
	
	$conventions_a_traiter_view_all_check = $_SESSION["Conventions_a_traiter_view_all_check"];
	
	if (isset($conventions_a_traiter_view_all_check) && ($conventions_a_traiter_view_all_check == 'Conventions_a_traiter_view_all_check' || $conventions_a_traiter_view_all_check == 'on')) {
		
		$where = " AND sigc_convention.statut not in ('closed','running') ";
		
		$list_query = " SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
				sigc_convention.conventionid,sigc_convention.ticket,sigc_convention.libelle,sigc_convention.statut,sigc_convention.montant,
				sigc_convention.datedemarrage,sigc_convention.organe,sigc_convention.bailleurs,
				sigc_convention.maitriseouvrage,sigc_convention.agenceexecution,sigc_convention.beneficiaire,
				sigc_conventioncf.*
				FROM sigc_convention
				INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = sigc_convention.conventionid
				
				INNER JOIN sigc_conventioncf
					ON sigc_convention.conventionid = sigc_conventioncf.conventionid
							
				WHERE vtiger_crmentity.deleted = 0 order by createdtime desc ";
				
//			$list_query = "SELECT distinct vtiger_crmentity.crmid, vtiger_crmentity.createdtime,sigc_convention.statut,
//				sigc_convention.ticket,sigc_convention.conventionid,operations.Op_Lib as campagne,
//				sigc_type_conventions.nom as lbtypeconvention,sigc_convention.popimpactee,
//				sigc_conventioncf.* 
//				
//				FROM sigc_convention 
//				
//				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = sigc_convention.conventionid 
//				INNER JOIN sigc_type_conventions ON sigc_type_conventions.typeconventionid = sigc_convention.typeconvention 
//				INNER JOIN operations ON operations.Op_Id = sigc_convention.campagne 
//				INNER JOIN sigc_conventioncf ON sigc_convention.conventionid = sigc_conventioncf.conventionid 
//				INNER JOIN vtiger_groups g ON instr(concat(' ', sigc_type_conventions.groupid, ' '), concat(' ', g.groupid, ' ')) > 0 
//				INNER JOIN sigc_traitement_conventions ON sigc_traitement_conventions.ticket = sigc_convention.ticket 
//						
//				WHERE (g.groupid in (select groupid from vtiger_users2group where userid = $current_user->id) 
//				or g.groupid in (select groupid from siprod_groupsupcoord where supid = $current_user->id)) 
//				And vtiger_crmentity.deleted =0 				
//				AND (sigc_convention.statut <>'closed') 
//				
//				or   ( sigc_traitement_conventions.statut = 'transfered'and sigc_convention.statut='transfered'
//				and  (sigc_traitement_conventions.destination in (select groupid from vtiger_users2group where userid = $current_user->id) 
//				      or sigc_traitement_conventions.destination in (select groupid from siprod_groupsupcoord where supid = $current_user->id)))
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
					'conventionid'=> $adb->query_result($res,$i,'conventionid'),
					'ticket'=> $adb->query_result($res,$i,'ticket'),
					'libelle'=> $adb->query_result($res,$i,'libelle'),
					'statut'=> $adb->query_result($res,$i,'statut'),
					'montant'=> $adb->query_result($res,$i,'montant'),
					'datedemarrage'=> $adb->query_result($res,$i,'datedemarrage'),
					 'organe'=> $adb->query_result($res,$i,'organe'),
					'bailleurs'=> $adb->query_result($res,$i,'bailleurs'),
					'maitriseouvrage'=> $adb->query_result($res,$i,'maitriseouvrage'),
					'agenceexecution'=> $adb->query_result($res,$i,'agenceexecution'),
					'beneficiaire'=> $adb->query_result($res,$i,'beneficiaire')

									);
		}
	}

	$req = $adb->pquery($list_query_bis, array());
	$recordCount = $adb->num_rows($req);
	
	$_SESSION["recordCountConvention"] = $noofrecords;
	$_SESSION["totalRecordCountConvention"] = $recordCount;
			
	unset($_SESSION['Conventions_a_traiter_view_all_check']);
	session_unregister('Conventions_a_traiter_view_all_check');
	
	$values = getConventionEntries($open_indicent_list);
	return $values;

}

function getConventionEntries($open_indicent_list){
	global $current_language, $app_strings;
	$current_module_strings = return_module_language($current_language, 'Conventions');
	
	$header=array();
	$header[] ='N&deg; Immatriculation';
	$header[] ='Libell&eacute; Convention';
	$header[] ='Statut';
	$header[] ='Montant';
	$header[] ='Date D&eacute;marrage';
	$header[] = 'Organe';
	$header[] ='Bailleur(s)';
	$header[] ='Maitrise d\'Ouvrage';
	$header[] ='Agence d\'Ex&eacute;cution';
	$header[] ='Bénéficiaire';
		
	if(!empty($open_indicent_list)){
		$entries = array();
		foreach($open_indicent_list as $indicent){
			
			$entity_statut = decode_html($indicent["statut"]);
			$img='';
			$value = ($current_module_strings[$entity_statut] != '') ? $current_module_strings[$entity_statut] : (($app_strings[$entity_statut] != '') ? ($app_strings[$entity_statut]) : $entity_statut);
			switch($entity_statut)
			{
				Case "initiate": {$img = '<img src="'. vtiger_imageurl('statut-atraiter.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "denied": {$img =  '<img src="'. vtiger_imageurl('statut-retraiter.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "pending": {$img = '<img src="'. vtiger_imageurl('statut-en_cours.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "certifiedDAJ": {$img = '<img src="'. vtiger_imageurl('statut-en_cours.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "certifiedDFB": {$img = '<img src="'. vtiger_imageurl('statut-traite.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "approve": {$img = '<img src="'. vtiger_imageurl('statut-transfere.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "validate": {$img = '<img src="'. vtiger_imageurl('statut-transfere.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "running": {$img = '<img src="'. vtiger_imageurl('statut-transfere.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
				Case "closed": {$img = '<img src="'. vtiger_imageurl('okvert.jpg', $theme) . '" border="0" align="absmiddle">'; break;}
			}
			
			$entries[$indicent['ticket']] = array(
					'0' => '<a href="index.php?action=DetailView&module=Conventions&record='.$indicent["conventionid"].'" ;">'.$indicent["ticket"].'',
					'1'=> $indicent["libelle"],
					'2'=> $indicent["statut"],
					'3'=> $indicent["montant"],
					'4'=> $indicent["datedemarrage"],
					'5'=> $indicent["organe"],
					'6'=> $indicent["bailleurs"],
					'7'=> $indicent["maitriseouvrage"],
					'8'=> $indicent["agenceexecution"],
					'9'=> $indicent["beneficiaire"],

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
