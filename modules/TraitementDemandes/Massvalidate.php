<?php


/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

require_once('include/utils/utils.php');
require_once('modules/HReports/NotificationTraitementNomade.php');

$idlist = $_REQUEST['idlist'];
$returnmodule=$_REQUEST['return_module'];
$return_action = $_REQUEST['return_action'];
$statut = $_REQUEST['statut'];

$rstart='';
//Added to fix 4600
//$url = getBasic_Advance_SearchURL();

//split the string and store in an array
$storearray = explode(";",$idlist);
array_filter($storearray);
$ids_list = array();
$errormsg = '';
//print_r($storearray);
//break;
$cpt=0;
foreach($storearray as $id)
{
	if($id!='')
	{
		$ticket=getTicketByDemandeId($id);
		SaveTraitementEnMasse($returnmodule,$id,$ticket,$statut); 
		//echo $returnmodule,' - ',$id,' - ',$ticket,' - ',$statut;
		$cpt++;
	}
        
}
echo $cpt," demande(s) autorisee(s) par le DC-PC avec succes!!!!"
/*
if(isset($_REQUEST['smodule']) && ($_REQUEST['smodule']!=''))
{
	$smod = "&smodule=".$_REQUEST['smodule'];
}
if(isset($_REQUEST['start']) && ($_REQUEST['start']!=''))
{
	$rstart = "&start=".$_REQUEST['start'];
}

	header("Location: index.php?module=".$returnmodule."&action=".$returnmodule."Ajax&ajax=delete".$rstart."&file=ListView&errormsg=".$errormsg.$url);
*/
?>

