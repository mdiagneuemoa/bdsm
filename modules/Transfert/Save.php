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

$numtransfert = $_REQUEST['ticket'];
//echo "typereamenagement =",$focus->column_fields['typereamenagement'];
//echo " -- numtransfert =",$numtransfert;
$typebudget = $_REQUEST['debit_typebudget_0'];
$sourcefin = $_REQUEST['debit_sourcefin_0'];
//echo " -- typebudget =",$typebudget,'<br>';
//echo " -- sourcefin =",$sourcefin;break;

for ($k=0;$k<=20;$k++)
{
	$codebudgetdeb = $_REQUEST['debit_codebudget_'.$k];
	$codebudgetcred = $_REQUEST['credit_codebudget_'.$k];

	//echo "codebudgetdeb =",$codebudgetdeb, "   - codebudgetcred =",$codebudgetcred;
	if($codebudgetdeb!='' && $_REQUEST['debit_comptenat_'.$k]!='' && $_REQUEST['debit_montant_'.$k]!='' && $_REQUEST['debit_montant_'.$k]!=0)
	{
		$debcredtab[]=array('typebudget'=>$typebudget,'codebudget'=>$codebudgetdeb,'comptenat'=>$_REQUEST['debit_comptenat_'.$k],
									 'sourcefin'=>$sourcefin,'montant'=>$_REQUEST['debit_montant_'.$k],'sens'=>'D');
		
	}	
	if($codebudgetcred!='' && $_REQUEST['credit_comptenat_'.$k]!='' && $_REQUEST['credit_montant_'.$k]!='' && $_REQUEST['credit_montant_'.$k]!=0)
	{
		$debcredtab[]=array('typebudget'=>$typebudget,'codebudget'=>$codebudgetcred,'comptenat'=>$_REQUEST['credit_comptenat_'.$k],
									 'sourcefin'=>$sourcefin,'montant'=>$_REQUEST['credit_montant_'.$k],'sens'=>'C');
		
	}	
}

//echo $_REQUEST['record'],' - ',$_REQUEST['ticket'],"<br>";
//print_r($_REQUEST);
echo "<br>********** DEBIT *****************<br>";
//print_r($debcredtab['Debit']);
echo "<br>************* CREDIT ***************<br>";
//print_r($debcredtab['Credit']);
//break;

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}


$ticket = $_REQUEST['ticket'];
if($focus->existTicket($ticket) == 1  || ($focus->existTicket($ticket) == 0  && $mode == 'edit')) {
	if($mode != 'edit'){
		$RealTicket = $focus->getNextTicketTransfert();
		$focus->column_fields['ticket'] = $RealTicket ;
		
	}
	//print_r($natdeptab);break;
	$focus->deleteDebitsCredits($record);
	
	$focus->save($currentModule);
	$return_id = $focus->id;
	
	$focus->saveDebitsCredits($focus->id,$numtransfert,$debcredtab);
	//$mail_data = $focus->getRapportMailInfo($focus->column_fields['ticket'],$focus->column_fields['statut']);
	//$focus->sendNotificationTransfert($mail_data,$currentModule);
	
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