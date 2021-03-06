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
if($mode) $focus->mode = $mode;
if($record)$focus->id  = $record;

$currencyid=fetchCurrency($current_user->id);
$rate_symbol = getCurrencySymbolandCRate($currencyid);
$rate = $rate_symbol['rate'];

if($_REQUEST['imagelist'] != '')
{
	$del_images = array();
	$del_images = explode('###',$_REQUEST['imagelist']);
	$del_image_array = array_slice($del_images,0,count($del_images)-1);
}

//Checking If image is given or not 
$image_lists=array();
$count=0;

$saveimage = "true";
$image_error = "false";
//end of code to retain the pictures from db

if($image_error=="true") //If there is any error in the file upload then moving all the data to EditView.
{
	//re diverting the page and reassigning the same values as image error occurs	
	if($_REQUEST['activity_mode'] != '')$activity_mode=$_REQUEST['activity_mode'];
	if($_REQUEST['return_module'] != '')$return_module=$_REQUEST['return_module'];
	if($_REQUEST['return_action'] != '')$return_action=$_REQUEST['return_action'];
	if($_REQUEST['return_id'] != '')$return_id=$_REQUEST['return_id'];

	 $log->debug("There is an error during the upload of product image.");
	$field_values_passed.="";
	foreach($focus->column_fields as $fieldname => $val)
	{
		if(isset($_REQUEST[$fieldname]))
		{
			 $log->debug("Assigning the previous values given for the product to respective vtiger_fields ");
			$field_values_passed.="&";
			$value = $_REQUEST[$fieldname];
			$focus->column_fields[$fieldname] = $value;
			$field_values_passed.=$fieldname."=".$value;

		}
	}
	$values_pass=$field_values_passed;
	$encode_field_values=base64_encode($values_pass);

	$error_module = "Products";
	$error_action = "EditView";

	if(isset($_request['return_id']) && $_request['return_id'] != "")
		$return_id = $_request['return_id'];
	if(isset($_request['activity_mode']))
		$return_action .= '&activity_mode='.$_request['activity_mode'];

	if($mode=="edit")
	{
		$return_id=$_REQUEST['record'];
	}
	header("location: index.php?action=$error_action&module=$error_module&record=$return_id&return_id=$return_id&return_action=$return_action&return_module=$return_module&activity_mode=$activity_mode&return_viewname=$return_viewname&saveimage=$saveimage&error_msg=$errormessage&image_error=$image_error&encode_val=$encode_field_values.$search");
}
if($saveimage=="true")
{
	$image_lists_db=implode("###",$image_lists);
	$focus->column_fields['imagename']=$image_lists_db;
	$log->debug("Assign the Image name to the vtiger_field name ");
}

if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != '' && $_REQUEST['return_id'] != $focus->id)
	$focus->parentid = $_REQUEST['return_id'];
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module']!='')
	$focus->return_module = $_REQUEST['return_module'];
if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

$focus->save($currentModule);
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

//Checking and Sending Mail from reorder level
global $current_user;
$productname = $focus->column_fields['productname'];
$qty_stk = $focus->column_fields['qtyinstock'];
$reord = $focus->column_fields['reorderlevel'];
$handler = $focus->column_fields['assigned_user_id'];
if($qty_stk != '' && $reord != '') {
	if($qty_stk < $reord) {
		$handler_name = getUserName($handler);
		$sender_name = getUserName($current_user->id);
		$to_address= getUserEmail($handler);
		$subject =  $productname.' '.$mod_strings['MSG_STOCK_LEVEL'];
		$body = $mod_strings['MSG_DEAR'].' '.$handler_name.',<br><br>'.

		$mod_strings['MSG_CURRENT_STOCK'].' '.$productname.' '.$mod_strings['MSG_IN_OUR_WAREHOUSE'].' '.$qty_stk.'. '.$mod_strings['MSG_PROCURE_REQUIRED_NUMBER'].' '.$reord.'.<br> '.

		$mod_strings['MSG_SEVERITY'].'<br><br> '.
		$mod_strings['MSG_THANKS'].'<br> '.
		$sender_name;

		include("modules/Emails/mail.php");
		$mail_status = send_mail("Products",$to_address,$current_user->user_name,$current_user->email1,$subject,$body);
	}
}

if(isset($_REQUEST['activity_mode'])) $return_action .= '&activity_mode='.$_REQUEST['activity_mode'];

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&start=".$_REQUEST['pagenumber'].$search);

?>