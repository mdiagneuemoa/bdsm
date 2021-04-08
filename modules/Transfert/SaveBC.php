<?php
/***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule, $adb;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

//$nbnatdepenses = $_REQUEST['nbnatdepense'];
$numreunion = $_REQUEST['ticket'];
//echo $nbnatdepenses;

$codebudget = $focus->column_fields['codebudget'];
$comptesnat = $focus->getComptesNat($codebudget);

 foreach($comptesnat as $comptenat => $comptenatlib)
{

	//$natdep = $_REQUEST['natdepense_'.$i*2];
	$natdep = $comptenat;
	for ($k=1;$k<=100;$k++)
	{
		$lignedep = $_REQUEST['naturesdepense_'.$natdep.'_lib_'.$k];
		//echo "lignedep =",$lignedep ;
		if($lignedep!='')
		{
			$natdeptab[$natdep][$k]['lib']=$lignedep;
			$natdeptab[$natdep][$k]['qte']=$_REQUEST['naturesdepense_'.$natdep.'_qte_'.$k];
			$natdeptab[$natdep][$k]['nb']=$_REQUEST['naturesdepense_'.$natdep.'_nb_'.$k];
			$natdeptab[$natdep][$k]['pu']=$_REQUEST['naturesdepense_'.$natdep.'_pu_'.$k];
			$natdeptab[$natdep][$k]['pt']=$_REQUEST['naturesdepense_'.$natdep.'_pt_'.$k];
		}	
	}
}
//echo $focus->column_fields['ticketparent'],' - ',$_REQUEST['ticket'],"<br>";
//print_r($_REQUEST);
echo "<br>";
//print_r($natdeptab);
//break;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

$datedebutStr = $_REQUEST['datedebut'];
if(isset($datedebutStr) && $datedebutStr != '') {
	$datedebutIns = new DateTime($datedebutStr);
	$datedebut = $datedebutIns->format("Y-m-d");
			
	$focus->column_fields['datedebut'] = $datedebut;
} 

$datefinStr = $_REQUEST['datefin'];
if(isset($datefinStr) && $datefinStr != '') {
	$datefinIns = new DateTime($datefinStr);
	$datefin = $datefinIns->format("Y-m-d");
			
	$focus->column_fields['datefin'] = $datefin;
} 

$ticket = $_REQUEST['ticket'];
$ticketparent = $focus->column_fields['ticketparent'];
if($focus->existTicket($ticket) == 1  || ($focus->existTicket($ticket) == 0  && $mode == 'edit')) {
	if($mode != 'edit'){
		$RealTicket = $focus->getNextTicketReunionBC($ticketparent);
		$focus->column_fields['ticket'] = $RealTicket ;
		$focus->column_fields['timbredc'] = '104' ;
		$focus->column_fields['signatairedc'] = $focus->getNomPrenomDC($focus->column_fields['departement']) ;
		if ($focus->column_fields['departement']=='01-01')
		{
			$focus->column_fields['timbrecom'] = '7';
			$focus->column_fields['signatairecom'] = $focus->column_fields['signatairedc']; 
		}
		else
		{
			$focus->column_fields['timbrecom'] = '100' ;
			$focus->column_fields['signatairecom'] = $focus->getNomPrenomCOM($focus->column_fields['departement']) ;
		}
	}
	$focus->deleteNatureDepenses($record);
	
	$focus->save($currentModule);
	$return_id = $focus->id;
	$focus->saveNatureDepenses($focus->id,$numreunion,$natdeptab);
	//$mail_data = $focus->getRapportMailInfo($focus->column_fields['ticket'],$focus->column_fields['statut']);
	//$focus->sendNotificationReunion($mail_data,$currentModule);
	
}

$search=$_REQUEST['search_url'];

if($_REQUEST['parenttab'] != '')     $parenttab = $_REQUEST['parenttab'];
if($_REQUEST['return_module'] != '') {
	$return_module = $_REQUEST['return_module'];
} else {
	$return_module = $currentModule;
}

if($_REQUEST['return_action'] != '') {
	$return_action = $_REQUEST['return_action'];
} else {
	$return_action = "DetailView";
}

if($_REQUEST['return_id'] != '') {
	$return_id = $_REQUEST['return_id'];
}
header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
?>