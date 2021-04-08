<?php
/***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule;
global $adb;
checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");
require_once('modules/HReports/HReportsCommon.php');

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;
if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}
if($_REQUEST['bailleurs2'] != '') {
	$focus->column_fields['bailleurs'] = $_REQUEST['bailleurs'].'|'.$_REQUEST['bailleurs2'];
	$focus->column_fields['bailleursrate'] = $_REQUEST['bailleursrate'].'|'.$_REQUEST['bailleursrate2'];
}

//print_r($_REQUEST);break;
$focus->column_fields['civilite'] = $_REQUEST['civilite2'];
$focus->column_fields['sexe'] = $_REQUEST['sexe2'];
$focus->column_fields['paysnaissance'] = $_REQUEST['paysnaissance2'];
$focus->column_fields['nationalite'] = $_REQUEST['nationalite2'];
$focus->column_fields['situationfamiliale'] = $_REQUEST['situationfamiliale2'];
$focus->column_fields['nombreenfants'] = $_REQUEST['nombreenfants2'];
$focus->column_fields['affectorgane'] = $_REQUEST['affectorgane2'];
$focus->column_fields['affectdepartement'] = $_REQUEST['affectdepartement2'];
$focus->column_fields['affectdirection'] = $_REQUEST['affectdirection2'];
$focus->column_fields['affectfonction'] = $_REQUEST['affectfonction2'];
$focus->column_fields['conttypecontrat'] = $_REQUEST['conttypecontrat2'];
$focus->column_fields['contcategorie'] = $_REQUEST['contcategorie2'];
$focus->column_fields['contstatut'] = $_REQUEST['contstatut2'];

if($_REQUEST['datenaissance'] != '') {
$datenaissance = $_REQUEST['datenaissance'];
$dt = new DateTime($datenaissance);
$datenaissance = $dt->format("Y-m-d");
$focus->column_fields['datenaissance'] = $datenaissance;
}

if($_REQUEST['dateetablissementactenaissance'] != '') {
$dateetablissementactenaissance = $_REQUEST['dateetablissementactenaissance'];
$dt = new DateTime($dateetablissementactenaissance);
$dateetablissementactenaissance = $dt->format("Y-m-d");
$focus->column_fields['dateetablissementactenaissance'] = $dateetablissementactenaissance;
}

if($_REQUEST['dateetablissement'] != '') {
$dateetablissement = $_REQUEST['dateetablissement'];
$dt = new DateTime($dateetablissement);
$dateetablissement = $dt->format("Y-m-d");
$focus->column_fields['dateetablissement'] = $dateetablissement;
}

if($_REQUEST['contdatedebut'] != '') {
$contdatedebut = $_REQUEST['contdatedebut'];
$dt = new DateTime($contdatedebut);
$contdatedebut = $dt->format("Y-m-d");
$focus->column_fields['contdatedebut'] = $contdatedebut;
}

if($_REQUEST['contdatefin'] != '') {
$contdatefin = $_REQUEST['contdatefin'];
$dt = new DateTime($contdatefin);
$contdatefin = $dt->format("Y-m-d");
$focus->column_fields['contdatefin'] = $contdatefin;
}

if($_REQUEST['contdateembauche'] != '') {
$contdateembauche = $_REQUEST['contdateembauche'];
$dt = new DateTime($contdateembauche);
$contdateembauche = $dt->format("Y-m-d");
$focus->column_fields['contdateembauche'] = $contdateembauche;
}

if($_REQUEST['contdateanciennete'] != '') {
$contdateanciennete = $_REQUEST['contdateanciennete'];
$dt = new DateTime($contdateanciennete);
$contdateanciennete = $dt->format("Y-m-d");
$focus->column_fields['contdateanciennete'] = $contdateanciennete;
}

if($_REQUEST['contdatedepart'] != '') {
$contdatedepart = $_REQUEST['contdatedepart'];
$dt = new DateTime($contdatedepart);
$contdatedepart = $dt->format("Y-m-d");
$focus->column_fields['contdatedepart'] = $contdatedepart;
}

if($_REQUEST['peredatenaissance'] != '') {
$peredatenaissance = $_REQUEST['peredatenaissance'];
$dt = new DateTime($peredatenaissance);
$peredatenaissance = $dt->format("Y-m-d");
$focus->column_fields['peredatenaissance'] = $peredatenaissance;
}

if($_REQUEST['peredatedeces'] != '') {
$peredatedeces = $_REQUEST['peredatedeces'];
$dt = new DateTime($peredatedeces);
$peredatedeces = $dt->format("Y-m-d");
$focus->column_fields['peredatedeces'] = $peredatedeces;
}

if($_REQUEST['meredatenaissance'] != '') {
$meredatenaissance = $_REQUEST['meredatenaissance'];
$dt = new DateTime($meredatenaissance);
$meredatenaissance = $dt->format("Y-m-d");
$focus->column_fields['meredatenaissance'] = $meredatenaissance;
}

if($_REQUEST['meredatedeces'] != '') {
$meredatedeces = $_REQUEST['meredatedeces'];
$dt = new DateTime($meredatedeces);
$meredatedeces = $dt->format("Y-m-d");
$focus->column_fields['meredatedeces'] = $meredatedeces;
}

if($_REQUEST['enfant1datenaissance'] != '') {
$enfant1datenaissance = $_REQUEST['enfant1datenaissance'];
$dt = new DateTime($enfant1datenaissance);
$enfant1datenaissance = $dt->format("Y-m-d");
$focus->column_fields['enfant1datenaissance'] = $enfant1datenaissance;
}

if($_REQUEST['enfant1datedeces'] != '') {
$enfant1datedeces = $_REQUEST['enfant1datedeces'];
$dt = new DateTime($enfant1datedeces);
$enfant1datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant1datedeces'] = $enfant1datedeces;
}

if($_REQUEST['enfant2datenaissance'] != '') {
$enfant2datenaissance = $_REQUEST['enfant2datenaissance'];
$dt = new DateTime($enfant2datenaissance);
$enfant2datenaissance = $dt->format("Y-m-d");
$focus->column_fields['enfant2datenaissance'] = $enfant2datenaissance;
}

if($_REQUEST['enfant2datedeces'] != '') {
$enfant2datedeces = $_REQUEST['enfant2datedeces'];
$dt = new DateTime($enfant2datedeces);
$enfant2datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant2datedeces'] = $enfant2datedeces;
}

if($_REQUEST['enfant3datenaissance'] != '') {
$enfant3datenaissance = $_REQUEST['enfant3datenaissance'];
$dt = new DateTime($enfant3datenaissance);
$enfant3datenaissance = $dt->format("Y-m-d");
$focus->column_fields['datedemarrage'] = $enfant3datenaissance;
}

if($_REQUEST['enfant3datedeces'] != '') {
$enfant3datedeces = $_REQUEST['enfant3datedeces'];
$dt = new DateTime($enfant3datedeces);
$enfant3datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant3datedeces'] = $enfant3datedeces;
}

if($_REQUEST['enfant4datenaissance'] != '') {
$enfant4datenaissance = $_REQUEST['enfant4datenaissance'];
$dt = new DateTime($enfant4datenaissance);
$enfant4datenaissance = $dt->format("Y-m-d");
$focus->column_fields['enfant4datenaissance'] = $enfant4datenaissance;
}

if($_REQUEST['enfant4datedeces'] != '') {
$enfant4datedeces = $_REQUEST['enfant4datedeces'];
$dt = new DateTime($enfant4datedeces);
$enfant4datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant4datedeces'] = $enfant4datedeces;
}

if($_REQUEST['enfant5datenaissance'] != '') {
$enfant5datenaissance = $_REQUEST['enfant5datenaissance'];
$dt = new DateTime($enfant5datenaissance);
$enfant5datenaissance = $dt->format("Y-m-d");
$focus->column_fields['enfant5datenaissance'] = $enfant5datenaissance;
}

if($_REQUEST['enfant5datedeces'] != '') {
$enfant5datedeces = $_REQUEST['enfant5datedeces'];
$dt = new DateTime($enfant5datedeces);
$enfant5datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant5datedeces'] = $enfant5datedeces;
}

if($_REQUEST['enfant6datenaissance'] != '') {
$enfant6datenaissance = $_REQUEST['enfant6datenaissance'];
$dt = new DateTime($enfant6datenaissance);
$enfant6datenaissance = $dt->format("Y-m-d");
$focus->column_fields['enfant6datenaissance'] = $enfant6datenaissance;
}

if($_REQUEST['enfant6datedeces'] != '') {
$enfant6datedeces = $_REQUEST['enfant6datedeces'];
$dt = new DateTime($enfant6datedeces);
$enfant6datedeces = $dt->format("Y-m-d");
$focus->column_fields['enfant6datedeces'] = $enfant6datedeces;
}

if($_REQUEST['conjointdatenaissance'] != '') {
$conjointdatenaissance = $_REQUEST['conjointdatenaissance'];
$dt = new DateTime($conjointdatenaissance);
$conjointdatenaissance = $dt->format("Y-m-d");
$focus->column_fields['conjointdatenaissance'] = $conjointdatenaissance;
}

if($_REQUEST['conjointdatedeces'] != '') {
$conjointdatedeces = $_REQUEST['conjointdatedeces'];
$dt = new DateTime($conjointdatedeces);
$conjointdatedeces = $dt->format("Y-m-d");
$focus->column_fields['conjointdatedeces'] = $conjointdatedeces;
}
//$focus->column_fields['montant'] = trim($focus->column_fields['montant']);

//print_r($focus->column_fields['filename']);break;

if($_REQUEST['statut']!='') 
	$focus->column_fields['statut'] = $_REQUEST['statut'];

$ticket = $_REQUEST['ticket'];

if($focus->existTicket($ticket) == 1 || ($focus->existTicket($ticket) == 0  && $mode == 'edit')){
	if($mode != 'edit'){
		$RealTicket = getNextMatriculeConvention();
		$focus->column_fields['ticket'] = $RealTicket ;
	}
}	
	$focus->save($currentModule);
	$return_id = $focus->id;
	//$mail_data = getRapportMailInfo($return_id,$focus->mode,$currentModule,$focus->column_fields['campagne']);
	//getRapportNotification($mail_data,$currentModule);


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

if($mode == "traiter") {
	header("Location: index.php?module=TraitementConventions&action=index&parenttab=Conventions");
}
else {
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);
}
?>