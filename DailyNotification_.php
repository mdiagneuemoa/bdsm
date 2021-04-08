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

require_once('config.inc.php');
require('cron/send_mail.php');
require_once('config.php');
require_once('include/utils/utils.php');
require_once('include/language/fr_fr.lang.php');
global $app_strings;
// Email Setup
$emailresult = $adb->pquery("SELECT email1 from vtiger_users", array());
$emailid = $adb->fetch_array($emailresult);
$emailaddress = $emailid[0];

$mailserveresult = $adb->pquery("SELECT server,server_username,server_password,smtp_auth FROM vtiger_systems where server_type = ?", array('email'));
$mailrow = $adb->fetch_array($mailserveresult);
$mailserver = $mailrow[0];
$mailuname = $mailrow[1];
$mailpwd = $mailrow[2];
$smtp_auth = $mailrow[3];
// End Email Setup

// tableau data par campagne
$query = "select * from siprod_rapport_quotidien_campagne where date_postage = Date(now()) ";
$result = $adb->pquery($query, array());
// tableau data par type
$query_type = "select * from siprod_rapport_quotidien_type where date_postage = Date(now()) ";
$result_type = $adb->pquery($query_type, array());
// tableau data par groupe

// tableau data par groupe
$query_groupe = "select * from siprod_rapport_quotidien_groupe where date_postage = Date(now())";
$result_groupe = $adb->pquery($query_groupe, array());

$j = 0;
$result_groupe_c = null;
while ($myrow = $adb->fetch_array($result_groupe))
{
	$id_g = $myrow["groupeincidents"] ;
	$tab_g = split('\|##\|',$id_g);
	$g_name = "";
	$g_id ="";
	for($i=0; $i < count($tab_g); $i++ ){
		$query_groupename  = "select groupname from vtiger_groups where groupid = $tab_g[$i]";
		$result_groupename = $adb->pquery($query_groupename, array());
		$grouprow = $adb->fetch_array($result_groupename);
		$g_name = $g_name.'- '.$grouprow[0].'<br> ';
		$g_id = $g_id.','.$tab_g[$i];
	}
	$myrow["groupeid"] = $g_id ;
	$myrow["groupeincidents"] = $g_name ;
	$result_groupe_c[$j] = $myrow ;
	$j++;
}
//-----

// Preparing data and mail body
setlocale (LC_ALL, 'fr_FR','fr');
$body_content .= "<span style='font-family:Verdana;font-size:11px;'>".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INFO_ONE"]." ".decode_html(utf8_encode (strftime("%A %d %B %Y %T"))).".</span></br>";

$body_content.="</br><span style='font-family:Verdana;font-size:13px;'>Par campagne</span>";
$body_content.="<table style='border: 1px #6495ed; width:98%;background-color: #6495ed;'>";
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_CAMPAGNE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_DANS_DELAIS"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_HORS_DELAIS"]." </td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;

while ($myrow = $adb->fetch_array($result))
{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;'> ".$myrow["op_lib"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_nonsouffrants"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incident_audela_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_externes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_closed"]." </td>";

	$duree = $myrow["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";																				

	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}

$body_content.="</table>";

// tableau data par type start
$body_content.="</br><span style='font-family:Verdana;font-size:13px;'> Par type incident</span>";
$body_content.="<table style='border: 1px #6495ed; width:98%;background-color: #6495ed;'>";
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_TYPE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_DANS_DELAIS"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_HORS_DELAIS"]." </td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;

while ($myrow = $adb->fetch_array($result_type))
{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;'> ".$myrow["typeincidents"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_nonsouffrants"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incidents_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["nb_incident_audela_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_externes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$myrow["incidents_closed"]." </td>";

	$duree = $myrow["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";																				

	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}

$body_content.="</table>";
// tableau data par type end

//tableau data par groupe start
$body_content.="</br><span style='font-family:Verdana;font-size:13px;'>Par groupe de traitement</span>";
$body_content.="</br>";
$body_content.="<table style='border: 1px #6495ed; width:98%;background-color: #6495ed;'>";
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;width:150px;'>  ".$app_strings["DAILY_NOTIFICATION_GROUPE"]." GROUPE(S) </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_DANS_DELAIS"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES_HORS_DELAIS"]." </td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;

for($i=0; $i < count($result_groupe_c); $i++ ){
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:150px;'> ".$result_groupe_c[$i]["groupeincidents"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["incidents_nonsouffrants"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["nb_incident_audela_dslesdelais"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["incidents_externes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".$result_groupe_c[$i]["incidents_closed"]." </td>";

	$duree = $result_groupe_c[$i]["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";																				

	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}

$body_content.="</table>";
// tableau data par groupe end



$body_content.="</br><span style='font-family:Verdana;font-size:11px;'>Cordialement.</span><br>"; 
$subject=" Rapport des incidents du " .date('d.m.Y'); 

// Getting Adresses and sending mails
$sqlEmails = "SELECT DISTINCT U.User_Email as group_moderateur 
	FROM vtiger_users2group UG, users U
	WHERE UG.userid = U.user_id 
	AND UG.groupid = 64
	UNION
	SELECT DISTINCT U.user_Email as group_moderateur 
	FROM siprod_groupsupcoord I, users U
	WHERE I.supid = U.user_id 
	AND I.groupid = 64 ";
	
$resultEmails = $adb->pquery($sqlEmails, array());

/*
while ($myrow = $adb->fetch_array($resultEmails))
{
	$add = $myrow['group_moderateur'];
	sendmail($add,'mailgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
}
*/

	$add = 'sdiongue@pcci.sn';
	sendmail($add,'mailgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
	$add = 'smgning@pcci.sn';
	sendmail($add,'mailgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
	$add = 'mndiouf@pcci.sn';
	sendmail($add,'mailgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
	$add = 'mediagne@pcci.sn';
	sendmail($add,'mailgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);

?>


