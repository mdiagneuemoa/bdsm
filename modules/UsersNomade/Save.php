<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $current_user, $currentModule;

checkFileAccess("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$focus = new $currentModule();
setObjectValuesFromRequest($focus);

$mode = $_REQUEST['mode'];
$record=$_REQUEST['record'];
//echo "record=",$record," - ",$mode;
//break;
if($mode) $focus->mode = $mode;

//$focus->save($currentModule);
if ($record && $mode=='edit')
{
	//print_r($focus->column_fields);break;
	$focus->id  = $record;
	$email = $focus->column_fields['user_email'];
	$emailtab = explode("@",$email);
	$focus->column_fields['user_login']=$emailtab[0];
	$focus->column_fields['user_numerologin']=$emailtab[0];
	
	$query = "UPDATE users SET user_name='".$focus->column_fields['user_name']."',user_firstname='".$focus->column_fields['user_firstname']."',
		user_login='".$focus->column_fields['user_login']."',user_direction='".$focus->column_fields['user_direction']."',
		user_numerologin='".$focus->column_fields['user_numerologin']."',user_fonction='".mysql_real_escape_string($focus->column_fields['user_fonction'])."',
		user_email='".$focus->column_fields['user_email']."',user_categmis='".$focus->column_fields['user_categmis']."'  
		 WHERE  user_id=?";
		// echo $query;break;
		 $adb->pquery($query,array($record));	

	$queryprofil = "UPDATE siprod_users SET profilid='".$focus->column_fields['user_profil']."' WHERE userid=?";
 	$adb->pquery($queryprofil,array($record));	

}
else
{
	$focus->column_fields['user_id']=$focus->getNextUserId();
	$focus->id = $focus->column_fields['user_id'];	

	$focus->column_fields['user_matricule']=$focus->getNextMatricule();
	
	$email = $focus->column_fields['user_email'];
	$emailtab = explode("@",$email);
	$focus->column_fields['user_login']=$emailtab[0];
	$focus->column_fields['user_numerologin']=$emailtab[0];
	
	$passwordtab= $focus->randomPassword(8,1,"lower_case,numbers");
	$focus->column_fields['user_pwd']= $passwordtab[0];
	
 	$adb->pquery($queryprofil,array($focus->column_fields['user_profil'],$focus->column_fields['user_id']));
	$query = "INSERT INTO  users(user_id,user_name,user_firstname,user_login,user_pwd,user_direction,user_matricule,user_numerologin,user_fonction,user_email,user_categmis) 
		 values(?,?,?,?,?,?,?,?,?,?,?) ";
		 $adb->pquery($query,array($focus->column_fields['user_id'],$focus->column_fields['user_name'],$focus->column_fields['user_firstname'],
		 $focus->column_fields['user_login'],$focus->column_fields['user_pwd'],$focus->column_fields['user_direction'],$focus->column_fields['user_matricule'],
		 $focus->column_fields['user_numerologin'],$focus->column_fields['user_fonction'],$focus->column_fields['user_email'],$focus->column_fields['user_categmis']));	

	$queryprofil = "INSERT INTO  siprod_users(userid,profilid,statut) values(?,?,?)";
	$adb->pquery($queryprofil,array($focus->column_fields['user_id'],$focus->column_fields['user_profil'],1));	
}
	 
$return_id = $focus->id;

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