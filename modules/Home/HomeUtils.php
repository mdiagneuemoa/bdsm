<?php
/*********************************************************************************
 ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
  * ("License"); You may not use this file except in compliance with the License
  * The Original Code is:  vtiger CRM Open Source
  * The Initial Developer of the Original Code is vtiger.
  * Portions created by vtiger are Copyright (C) vtiger.
  * All Rights Reserved.
 *******************************************************************************/

/**
 * this file will contain the utility functions for Home module
 */

function getIncidentEntries($open_indicent_list){
	global $current_language, $app_strings;
	$current_module_strings = return_module_language($current_language, 'Incidents');
	
	$header=array();
	$header[] =$current_module_strings['Ticket'];
	$header[] =$current_module_strings['TypeIncident'];
	$header[] =$current_module_strings['Popimpactee'];
	$header[] =$current_module_strings['LBL_DATE_CREATION'];
	//$header[] ='Immatriculation';

		
	if(!empty($open_indicent_list)){
		$entries = array();
		foreach($open_indicent_list as $indicent){
			
			$entries[$indicent['ticket']] = array(
					'0' => '<a href="index.php?action=DetailView&module='.$indicent["module"].'&record='.$indicent["ticket"].'" ;">'.$indicent["ticket"].'</a>',
					'1'=> $indicent["typedemande"],
					'2'=> $indicent["popimpactee"],
					'3'=> $indicent["date_creation"],
					//'4'=> $indicent["immatriculation"],
					);
		}
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$entries);
	}else{
		$values = array('noofactivities'=>count($open_indicent_list),'Header'=>$header,'Entries'=>$current_module_strings['LBL_NO_DATA']);
	}
	//print_f($values);
	return $values;
}

/**
 * function to get upcoming activities for today
 * @param integer $maxval - the maximum number of records to display
 * @param integer $calCnt - returns the count query if this is set
 * return array    $values   - activities record in array format
 */
function homepage_getIncidentsATraites($maxval,$calCnt){
	require_once("data/Tracker.php");
	require_once("include/utils/utils.php");
	require_once('include/utils/CommonUtils.php');
	
	global $adb;
	global $current_user;
	
	
	$today = date("Y-m-d", time());
	$upcoming_condition = " AND (date_start > '$today' OR vtiger_recurringevents.recurringdate > '$today')";
	$where = " AND (siprod_incident.statut='pending' or siprod_incident.statut='open') ";
	$list_query = "SELECT vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
			siprod_incident.ticket,operations.Op_Lib as campagne,siprod_type_incidents.nom as lbtypeincident,siprod_incident.popimpactee,
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
						
			WHERE vtiger_crmentity.deleted = 0 ".$where;
	
	
	$list_query.= " limit $maxval";
	
	$res = $adb->query($list_query);
	$noofrecords = $adb->num_rows($res);
	if($calCnt == 'calculateCnt'){
		return $noofrecords;
	}
	
	$open_indicent_list = array();
	if ($noofrecords>0){
		for($i=0;$i<$noofrecords;$i++){
			$open_indicent_list[] = array('ticket' => $adb->query_result($res,$i,'ticket'),
										'typedemande' => $adb->query_result($res,$i,'lbtypedemande'),
										'campagne' => $adb->query_result($res,$i,'campagne'),
										'popimpactee' => $adb->query_result($res,$i,'popimpactee'),
										'date_creation' => getDisplayDate($adb->query_result($res,$i,'createdtime')),
										//'immatriculation' => '',
									);
		}
	}
	$values = getIncidentEntries($open_indicent_list);
	return $values;
}

/**
 * this function returns the activity entries in array format
 * it takes in an array containing activity details as a parameter
 * @param array $open_activity_list - the array containing activity details
 * return array $values - activities record in array format
 */
function getDemandeEntries($open_indicent_list){
	global $current_language, $app_strings;
	$current_module_strings = return_module_language($current_language, 'Demandes');
	
	$header=array();
	$header[] =$current_module_strings['Ticket'];
	$header[] =$current_module_strings['TypeDemande'];
	$header[] =$current_module_strings['Popimpactee'];
	$header[] =$current_module_strings['LBL_DATE_CREATION'];

		
	if(!empty($open_indicent_list)){
		$entries = array();
		foreach($open_indicent_list as $indicent){
			
			$entries[$indicent['ticket']] = array(
					'0' => '<a href="index.php?action=DetailView&module='.$indicent["module"].'&record='.$indicent["ticket"].'" ;">'.$indicent["ticket"].'</a>',
					'1'=> $indicent["typedemande"],
					'2'=> $indicent["popimpactee"],
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



/*
$entries[0] = array(
					'0' => '-','1'=> '-','2'=>'-','3'=>'-',);
		$values = array('Header'=>$header,'Entries'=>$entries);
*/
/**
 * function to get pending activities for today
 * @param integer $maxval - the maximum number of records to display
 * @param integer $calCnt - returns the count query if this is set
 * return array    $values   - activities record in array format
 */
function homepage_getDemandesATraites($maxval,$calCnt){
	require_once("data/Tracker.php");
	require_once("include/utils/utils.php");
	require_once('include/utils/CommonUtils.php');
	
	global $adb;
	global $current_user;
	
	
	$today = date("Y-m-d", time());
	$upcoming_condition = " AND (date_start > '$today' OR vtiger_recurringevents.recurringdate > '$today')";
	$where = " AND (siprod_demande.statut='pending' or siprod_demande.statut='open') ";
	$list_query = "SELECT vtiger_crmentity.crmid, vtiger_crmentity.createdtime,
			siprod_demande.ticket,operations.Op_Lib as campagne,siprod_type_demandes.nom as lbtypedemande,siprod_demande.popimpactee,
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
						
			WHERE vtiger_crmentity.deleted = 0 ".$where;
	
	
	$list_query.= " limit $maxval";
	
	$res = $adb->query($list_query);
	$noofrecords = $adb->num_rows($res);
	if($calCnt == 'calculateCnt'){
		return $noofrecords;
	}
	
	$open_indicent_list = array();
	if ($noofrecords>0){
		for($i=0;$i<$noofrecords;$i++){
			$open_indicent_list[] = array('ticket' => $adb->query_result($res,$i,'ticket'),
										'typedemande' => $adb->query_result($res,$i,'lbtypedemande'),
										'campagne' => $adb->query_result($res,$i,'campagne'),
										'popimpactee' => $adb->query_result($res,$i,'popimpactee'),
										'date_creation' => getDisplayDate($adb->query_result($res,$i,'createdtime')),
										
									);
		}
	}
	$values = getDemandeEntries($open_indicent_list);
	return $values;
}


/**
 * this function returns the number of columns in the home page for the current user.
 * if nothing is found in the database it returns 4 by default
 * return integer $data - the number of columns
 */
function getNumberOfColumns(){
	global $current_user, $adb;
	
	$sql = "select * from vtiger_home_layout where userid=".$current_user->id;
	$result = $adb->query($sql);
	
	if($adb->num_rows($result)>0){
		$data = $adb->query_result($result,0,"layout");
	}else{
		//$data = 4;	//default is 4 column layout for now
		$data = 2;
	}
	return $data;
}
?>