<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
	
global $adb,$current_user;
require('user_privileges/user_privileges_'.$current_user->id.'.php');

$modval=trim($_REQUEST['modname']);
$dash=trim($_REQUEST['dash']);
if(!empty($modval)){
	$tabid = getTabId($modval);
	$ssql = "select vtiger_customview.*, vtiger_users.user_name from vtiger_customview inner join vtiger_tab on vtiger_tab.name = vtiger_customview.entitytype 
				left join vtiger_users on vtiger_customview.userid = vtiger_users.id ";
	$ssql .= " where vtiger_tab.tabid=?";
	$sparams = array($tabid);
	
	if($is_admin == false){
		$ssql .= " and (vtiger_customview.status=0 or vtiger_customview.userid = ? or vtiger_customview.status = 3 or vtiger_customview.userid in(select vtiger_user2role.userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%'))";
		array_push($sparams, $current_user->id);
	}
	$result = $adb->pquery($ssql, $sparams);
	
	if($adb->num_rows($result)==0){
	  echo "No Filters available";
	  die;
	}else{
		$html = '<select id=selFilterid name=selFiltername onchange=setPrimaryFld(this) class="detailedViewTextBox" onfocus="this.className=\'detailedViewTextBoxOn\'" onblur="this.className=\'detailedViewTextBox\'"  style="width:60%">';
		for($i=0;$i<$adb->num_rows($result);$i++){
			if($adb->query_result($result,$i,'userid')==$current_user->id || $adb->query_result($result,$i,"viewname")=='All'){
				$html .= "<option value='".$adb->query_result($result,$i,'cvid')."'>".$adb->query_result($result,$i,"viewname")."</option>";
			}else{
				$html .= "<option value='".$adb->query_result($result,$i,'cvid')."'>".$adb->query_result($result,$i,"viewname")."[".$adb->query_result($result,$i,'user_name')."]</option>";
			}
		}
		$html .= '</select>';
	}
	echo $html;
}

if(!empty($dash)){
	global $current_language;
	$dashbd_strings = return_module_language($current_language, "Dashboard");
	$graph_array = array("leadsource" => $dashbd_strings['leadsource'],
					      "leadstatus" => $dashbd_strings['leadstatus'],
					      "leadindustry" => $dashbd_strings['leadindustry'],
					      "salesbyleadsource" => $dashbd_strings['salesbyleadsource'],
					      "salesbyaccount" => $dashbd_strings['salesbyaccount'],
						  "salesbyuser" => $dashbd_strings['salesbyuser'],
						  "salesbyteam" => $dashbd_strings['salesbyteam'],
				          "accountindustry" => $dashbd_strings['accountindustry'],
				          "productcategory" => $dashbd_strings['productcategory'],
						  "productbyqtyinstock" => $dashbd_strings['productbyqtyinstock'],
						  "productbypo" => $dashbd_strings['productbypo'],
						  "productbyquotes" => $dashbd_strings['productbyquotes'],
						  "productbyinvoice" => $dashbd_strings['productbyinvoice'],
				          "sobyaccounts" => $dashbd_strings['sobyaccounts'],
				          "sobystatus" => $dashbd_strings['sobystatus'],
				          "pobystatus" => $dashbd_strings['pobystatus'],
				          "quotesbyaccounts" => $dashbd_strings['quotesbyaccounts'],
				          "quotesbystage" => $dashbd_strings['quotesbystage'],
				          "invoicebyacnts" => $dashbd_strings['invoicebyacnts'],
				          "invoicebystatus" => $dashbd_strings['invoicebystatus'],
				          "ticketsbystatus" => $dashbd_strings['ticketsbystatus'],
				          "ticketsbypriority" => $dashbd_strings['ticketsbypriority'],
						  "ticketsbycategory" => $dashbd_strings['ticketsbycategory'], 
						  "ticketsbyuser" => $dashbd_strings['ticketsbyuser'],
						  "ticketsbyteam" => $dashbd_strings['ticketsbyteam'],
						  "ticketsbyproduct"=> $dashbd_strings['ticketsbyproduct'],
						  "contactbycampaign"=> $dashbd_strings['contactbycampaign'],
						  "ticketsbyaccount"=> $dashbd_strings['ticketsbyaccount'],
						  "ticketsbycontact"=> $dashbd_strings['ticketsbycontact'],);

	$html='<select name=seldashbd id=seldashbd_id class="detailedViewTextBox" onfocus="this.className=\'detailedViewTextBoxOn\'" onblur="this.className=\'detailedViewTextBox\'" style="width:60%">';
	foreach($graph_array as $key=>$value){
		$html .='<option value="'.$key.'">'.$value.'</option>';	
	}
	$html .= '</select>';
	echo $html;
}

if(!empty($_REQUEST['primecvid'])){
	$cvid=$_REQUEST['primecvid'];
	$fieldmodule = $_REQUEST['fieldmodname'];
	$queryprime="select cvid,columnname from vtiger_cvcolumnlist where columnname not like '%::%' and cvid=".$cvid;
	$result=$adb->pquery($queryprime,array());
	global $current_language,$app_strings;
	$fieldmod_strings = return_module_language($current_language, $fieldmodule);
	if($adb->num_rows($result)==0){
	  echo "No Fields available";
	  die;
	}else{
		$html = '<select id=selPrimeFldid name=PrimeFld multiple class="detailedViewTextBox" onfocus="this.className=\'detailedViewTextBoxOn\'" onblur="this.className=\'detailedViewTextBox\'" style="width:60%">';
		for($i=0;$i<$adb->num_rows($result);$i++){
			$columnname=$adb->query_result($result,$i,"columnname");
			if($columnname != ''){
				$prifldarr=explode(":",$columnname);
				$fieldname = $prifldarr[2];
				$priarr=explode("_",$prifldarr[3],2); //getting field label
				$prifld = str_replace("_"," ",$priarr[1]);
				if($is_admin == false){
					$fld_permission = getFieldVisibilityPermission($fieldmodule,$current_user->id,$fieldname);
				}
				if($fld_permission == 0){
					$field_query = $adb->pquery("SELECT fieldlabel FROM vtiger_field WHERE fieldname = ? AND tablename = ? and vtiger_field.presence in (0,2)", array($fieldname,$prifldarr[0]));
					$field_label = $adb->query_result($field_query,0,'fieldlabel');
					if(trim($field_label) != '')
						$html .= "<option value='".$columnname."'>".$field_label."</option>";
				}
			}
		}
		$html .= '</select>';
	}
	echo $html;	
}

if(!empty($_REQUEST['showmaxval']) && !empty($_REQUEST['sid'])){
	$sid=$_REQUEST['sid'];
	$maxval=$_REQUEST['showmaxval'];
	global $adb;
	$query="select stufftype from vtiger_homestuff where stuffid=".$sid;
	$res=$adb->query($query);
	$stufftypename=$adb->query_result($res,0,"stufftype");
	if($stufftypename=="Module"){
		$qry="update vtiger_homemodule set maxentries=".$maxval." where stuffid=".$sid;
		$result=$adb->query($qry);
	}else if($stufftypename=="RSS"){
		$qry="update vtiger_homerss set maxentries=".$maxval." where stuffid=".$sid;
		$result=$adb->query($qry);
	}else if($stufftypename=="Default"){
		$qry="update vtiger_homedefault set maxentries=".$maxval." where stuffid=".$sid;
		$result=$adb->query($qry);
	}
	echo "loadStuff(".$sid.",'".$stufftypename."')";
}

if(!empty($_REQUEST['dashVal'])){
	$did=$_REQUEST['did'];
	global $adb;
	$qry="update vtiger_homedashbd set dashbdtype='".$_REQUEST['dashVal']."' where stuffid=".$did;	
	$res=$adb->query($qry);
	echo "loadStuff(".$did.",'DashBoard')";
}

if(!empty($_REQUEST['homestuffid'])){
	$sid=$_REQUEST['homestuffid'];
	global $adb;
	$query="delete from vtiger_homestuff where stuffid=".$sid;
	$result=$adb->query($query);
	echo "SUCCESS";
}

//Sequencing of blocks starts
if(!empty($_REQUEST['matrixsequence'])){
	global $adb;
	$sequence = explode('_',$_REQUEST['matrixsequence']);
	for($i=count($sequence)-1, $seq=0;$i>=0;$i--, $seq++){
		$query = 'update vtiger_homestuff set stuffsequence='.$seq.' where stuffid='.$sequence[$i];
		$result = $adb->query($query);
	}
	echo "<table cellpadding='10' cellspacing='0' border='0' width='100%' class='vtResultPop small'><tr><td align='center'>Layout Saved</td></tr></table>";
}
//Sequencing of blocks ends

if(isset($_REQUEST['act']) && $_REQUEST['act'] =="hide"){
	$stuffid=$_REQUEST['stuffid'];
	global $adb,$current_user;
	$qry="update vtiger_homestuff set visible=1 where stuffid=".$stuffid;
	$res=$adb->query($qry);
	echo "SUCCESS";
}

//saving layout here
if(!empty($_REQUEST['layout'])){
	global $adb, $current_user;
	
	$sql = "delete from vtiger_home_layout where userid=".$current_user->id;
	$result = $adb->query($sql);
	
	$sql = "insert into vtiger_home_layout values (?, ?)";
	$result = $adb->pquery($sql, array($current_user->id, $_REQUEST['layout']));
	if(!$result){
		echo "SUCCESS";
	}
}
//layout save ends here
?>