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
 * $Header: /cvs/repository/siprodPCCI/modules/Users/Forms.php,v 1.1 2010/01/15 18:42:25 isene Exp $
 * Description:  Contains a variety of utility functions used to display UI
 * components such as form vtiger_headers and footers.  Intended to be modified on a per
 * theme basis.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**
 * this function checks if the asterisk server details are set in the database or not
 * returns string "true" on success :: "false" on failure
 */
function checkAsteriskDetails(){
	global $adb,$current_user;
	$sql = "select * from vtiger_asterisk";
	$result = $adb->query($sql);
	
	$count = $adb->num_rows($result);
	
	if($count > 0){
		return "true";
	}else{
		return "false";
	}
}

/**
 * this function gets the asterisk extensions assigned in vtiger
 */
function getAsteriskExtensions(){
	global $adb, $current_user;
	
	$sql = "select * from vtiger_asteriskextensions where userid != ".$current_user->id;
	$result = $adb->pquery($sql, array());
	$count = $adb->num_rows($result);
	$data = array();
	
	for($i=0;$i<$count;$i++){
		$user = $adb->query_result($result, $i, "userid");
		$extension = $adb->query_result($result, $i, "asterisk_extension");
		if(!empty($extension)){
			$data[$user] = $extension;
		}
	}
	return $data;
}

/**
 * Create javascript to validate the data entered into a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_validate_record_js () {
global $mod_strings;
global $app_strings;

$lbl_last_name = $mod_strings['LBL_LIST_LAST_NAME'];
$lbl_first_name = $mod_strings['LBL_LIST_FIRST_NAME'];
$lbl_user_name = $mod_strings['LBL_LIST_USER_NAME'];
$lbl_role_name = $mod_strings['LBL_ROLE_NAME'];
$lbl_new_password = $mod_strings['LBL_LIST_PASSWORD'];
$lbl_confirm_new_password = $mod_strings['LBL_LIST_CONFIRM_PASSWORD'];
$lbl_user_email1 = $mod_strings['LBL_LIST_EMAIL'];
$lbl_title = $mod_strings['LBL_TITLE'];
$lbl_phone_mobile = $mod_strings['LBL_MOBILE_PHONE'];
$lbl_phone_work = $mod_strings['LBL_OFFICE_PHONE'];
$err_missing_required_fields = $app_strings['ERR_MISSING_REQUIRED_FIELDS'];
$err_invalid_email_address = $app_strings['ERR_INVALID_EMAIL_ADDRESS'];
$err_invalid_yahoo_email_address = $app_strings['ERR_INVALID_YAHOO_EMAIL_ADDRESS'];
$lbl_user_image=$mod_strings['User Image'];
$the_emailid = $app_strings['THE_EMAILID'];
$email_field_is = $app_strings['EMAIL_FILED_IS'].$err_invalid_email_address;
$other_email_field_is = $app_strings['OTHER_EMAIL_FILED_IS'].$err_invalid_email_address;
$yahoo_email_field_is = $app_strings['YAHOO_EMAIL_FILED_IS'].$err_invalid_yahoo_email_address;
$lbl_asterisk_details_not_set = $app_strings['LBL_ASTERISK_SET_ERROR'];
$lbl_address_street = $mod_strings['LBL_ADDRESS'];
$lbl_address_postalcode = $mod_strings['LBL_POSTAL_CODE'];
$lbl_address_country = $mod_strings['LBL_COUNTRY'];
$lbl_address_city = $mod_strings['LBL_CITY'];
//check asteriskdetails start
$checkAsteriskDetails = checkAsteriskDetails();
$extensions_list = implode(",",getAsteriskExtensions());
//check asteriskdetails end

$the_script  = <<<EOQ

<script type="text/javascript" language="Javascript">
<!--  to hide script contents from old browsers
function set_fieldfocus(errorMessage,oMiss_field){
		alert("$err_missing_required_fields" + errorMessage);
		oMiss_field.focus();	
}
function verify_password(password)
{
	var regex = /^[0-9a-zA-Z\s]+$/;
	if(!regex.test(password))
	{
		alert("Votre mot de passe doit etre alphanumerique");
		return false;
	}
	if( password.length<8)
	{
		alert("Votre mot de passe doit avoir 8 caracteres au moins");
		return false;
	}
	
}
function verify_data(form) {
	var existing_extensions = new Array($extensions_list);
	var isError = false;
	var errorMessage = "";
	var expregTel = new RegExp(/^\(?(00|00 |\+|\+ )?([0-9]{2} [0-9]{1}\)? |[0-9]{3}\)? |[0-9]{3}\)?)[0-9]{7,9}/);
	
	
	//check if asterisk server details are set or not
	/*
	if(trim(form.asterisk_extension.value)!="" && "$checkAsteriskDetails" == "false"){
		errorMessage = "$lbl_asterisk_details_not_set";
		alert(errorMessage);
		return false;
	}

	for(var i=0; i<existing_extensions.length; i++){
		if(form.asterisk_extension.value == existing_extensions[i]){
			alert("This extension has already been configured for another user. Please use another extension.");
			return false;
		}
	}*/
	//asterisk check ends
	// verifier mon de passe // crm hodar 13/08/09
	
	
	if (trim(form.email1.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_user_email1";
		oField_miss = form.email1;
	}
	if (trim(form.role_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_role_name";
		oField_miss =form.role_name;
	}
	if (trim(form.last_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_last_name";
		oField_miss =form.last_name;
	}
	if (trim(form.first_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_first_name";
		oField_miss =form.first_name;
	}
	if (trim(form.title.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_title";
		oField_miss = form.title;
	}
	if (trim(form.phone_mobile.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_phone_mobile";
		oField_miss = form.phone_mobile;
	}
	if (trim(form.phone_work.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_phone_work";
		oField_miss = form.phone_work;
	}
	if (trim(form.address_street.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_address_street";
		oField_miss = form.address_street;
	}
	/*if (trim(form.address_postalcode.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_address_postalcode";
		oField_miss = form.address_postalcode;
	}*/
	if (trim(form.address_country.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_address_country";
		oField_miss = form.address_country;
	}
	if (trim(form.address_city.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_address_city";
		oField_miss = form.address_city;
	}
	
	if(form.mode.value !='edit')
	{
		if (trim(form.user_password.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_new_password";
			oField_miss =form.user_password;
		}
		if (trim(form.confirm_password.value) == "") {
			isError = true;
			errorMessage += "\\n$lbl_confirm_new_password";
			oField_miss =form.confirm_password;
		}
	}


	if (trim(form.user_name.value) == "") {
		isError = true;
		errorMessage += "\\n$lbl_user_name";
		oField_miss =form.user_name;
	}

	if (isError == true) {
		set_fieldfocus(errorMessage,oField_miss);
		return false;
	}
	form.email1.value = trim(form.email1.value);
	if (form.email1.value != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.email1.value)) {
		alert("$the_emailid"+form.email1.value+"$email_field_is");
		form.email1.focus();
		return false;
	}
	
	//form.phone_work.value = trim(form.phone_work.value);
	if (form.phone_work.value != "" && !expregTel.test(form.phone_work.value)) 
	{
		alert("Merci d'entrer correctement Telephone bureau");
		form.phone_work.focus();
		return false;
	}
	//form.phone_mobile.value = trim(form.phone_mobile.value);
	if (form.phone_mobile.value != "" && !expregTel.test(form.phone_mobile.value)) 
	{
		alert("Merci d'entrer correctement Mobile");
		form.phone_mobile.focus();
		return false;
	}
	if (form.phone_fax.value != "" && !expregTel.test(form.phone_fax.value)) 
	{
		alert("Merci d'entrer correctement Fax");
		form.phone_fax.focus();
		return false;
	}
	if (form.phone_home.value != "" && !expregTel.test(form.phone_home.value)) 
	{
		alert("Merci d'entrer correctement Telephone Domicile");
		form.phone_home.focus();
		return false;
	}
	//verify_password(form.user_password.value);
/*
	form.email2.value = trim(form.email2.value);
	if (form.email2.value != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.email2.value)) {
		alert("$the_emailid"+form.email2.value+"$other_email_field_is");
		form.email2.focus();
		return false;
	}
	form.yahoo_id.value = trim(form.yahoo_id.value);
	if (form.yahoo_id.value != "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(form.yahoo_id.value) || (trim(form.yahoo_id.value) != "" && !(form.yahoo_id.value.indexOf('yahoo') > -1))) {
		alert("$the_emailid"+form.yahoo_id.value+"$yahoo_email_field_is");
		form.yahoo_id.focus();
		return false;
	}



	if(! upload_filter("imagename", "jpg|gif|bmp|png|JPG|GIF|BMP|PNG") )
	{
		form.imagename.focus();
		return false;
	}
*/
	//verify_password(form.user_password.value);
	
	if(form.mode.value != 'edit')
	{
		
		verify_password(form.user_password.value)
		
			if(trim(form.user_password.value) != trim(form.confirm_password.value))
			{
				alert("Vous devez confirmer avec le meme mot de passe");
				return false;
			}
			check_duplicate();
			
	}else
	{
	//	$('user_status').disabled = false;
		form.submit();
	}
	
}

// end hiding contents from old browsers  -->
</script>

EOQ;

return $the_script;
}

?>
