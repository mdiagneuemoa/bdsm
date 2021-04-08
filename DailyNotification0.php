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
$query = "select * from siprod_rapport_quotidien_campagne where date_postage = DATE_FORMAT(adddate(now(), -1), '%Y-%m-%d')";
$result = $adb->pquery($query, array());
// tableau data par type
$query_type = "select * from siprod_rapport_quotidien_type where date_postage = DATE_FORMAT(adddate(now(), -1), '%Y-%m-%d') ";
$result_type = $adb->pquery($query_type, array());
// tableau data par groupe

// tableau data par groupe
$query_groupe = "select * from siprod_rapport_quotidien_groupe where date_postage = DATE_FORMAT(adddate(now(), -1), '%Y-%m-%d')";
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
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #cac9cd;width:200px;' rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_CAMPAGNE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  colspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;' colspan='2'>  Incidents non traités </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  rowspan='2'>  Clôturés avant traitement</td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;' colspan='2'>  Origine incident </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";
	
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  En attente de clôture </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  Clôturés </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;
$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

while ($myrow = $adb->fetch_array($result)) 
{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px;'> ".$myrow["op_lib"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center;'> ".$myrow["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_closed"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_nonsouffrants"]." </td>";
	
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_dclosed"]."</td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$myrow["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$myrow["incidents_externes"]." </td>";
	
	$duree = $myrow["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";																				

	$total_nb_incidents_declares 		+= $myrow["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $myrow["nb_incidents_traites"];
	$total_incidents_closed 			+= $myrow["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $myrow["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $myrow["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $myrow["incidents_dclosed"];
	$total_incidents_internes 			+= $myrow["incidents_internes"];
	$total_incidents_externes 			+= $myrow["incidents_externes"] ; 
	$dureeTotal 						+= $myrow["duree_t_traitement"] ;
	
	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}else{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px; font-weight:bold;'> Totaux </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center; font-weight:bold;'> ".$total_nb_incidents_declares." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_traites." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_closed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_en_souffrance." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_nonsouffrants." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_dclosed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_internes." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_externes." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;font-weight:bold;'> ".sec_To_Time($dureeTotal)." </td>";
	$body_content.="</tr>";																				
	
}

$body_content.="</table>";

// tableau data par type start
$body_content.="</br><span style='font-family:Verdana;font-size:13px;'> Par type incident</span>";

$body_content.="<table style='border: 1px #6495ed; width:98%;background-color: #6495ed;'>";
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #cac9cd;width:200px;' rowspan='2'>  Type incident </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  colspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;' colspan='2'>  Incidents non traités </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  rowspan='2'>  Clôturés avant traitement</td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;' colspan='2'>  Origine incident </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";
	
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  En attente de clôture </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  Clôturés </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;
	
$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

while ($myrow = $adb->fetch_array($result_type)) // nb_incidents_en_souffrance   incidents_nonsouffrants  nb_incidents_dslesdelais
{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px;'> ".$myrow["typeincidents"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center;'> ".$myrow["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_closed"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_nonsouffrants"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$myrow["incidents_dclosed"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$myrow["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$myrow["incidents_externes"]." </td>";
	
	$duree = $myrow["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";																				

	$total_nb_incidents_declares 		+= $myrow["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $myrow["nb_incidents_traites"];
	$total_incidents_closed 			+= $myrow["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $myrow["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $myrow["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $myrow["incidents_dclosed"];
	$total_incidents_internes 			+= $myrow["incidents_internes"];
	$total_incidents_externes 			+= $myrow["incidents_externes"] ; 
	$dureeTotal 						+= $myrow["duree_t_traitement"] ;

	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}else{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px; font-weight:bold;'> Totaux </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center; font-weight:bold;'> ".$total_nb_incidents_declares." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_traites." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_closed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_en_souffrance." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_nonsouffrants." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_dclosed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_internes." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_externes." </td>";
	

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;font-weight:bold;'> ".sec_To_Time($dureeTotal)." </td>";
	$body_content.="</tr>";																				
	
}

$body_content.="</table>";

// tableau data par type end

//tableau data par groupe start
$body_content.="</br><span style='font-family:Verdana;font-size:13px;'>Par groupe de traitement</span>";

$body_content.="<table style='border: 1px #6495ed; width:98%;background-color: #6495ed;'>";
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #cac9cd;width:200px;' rowspan='2'>  Groupes </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  colspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;' colspan='2'>  Incidents non traités </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'  rowspan='2'>  Clôturés avant traitement</td>";	
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;' colspan='2'>  Origine incident </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;'  rowspan='2'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]." </td>";
	$body_content.="</tr>";
	
	$body_content.="<tr style='text-align: center;'>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  En attente de clôture </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  Clôturés </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_INTERNES"]." </td>";
	$body_content.="    <td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;'>  ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_EXTERNES"]." </td>";
	$body_content.="</tr>";

$isContainStatistic = false;
$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

for($i=0; $i < count($result_groupe_c); $i++ ){
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px;'> ".str_replace("Team ","", $result_groupe_c[$i]["groupeincidents"])." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_declares"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_traites"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$result_groupe_c[$i]["incidents_closed"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$result_groupe_c[$i]["nb_incidents_en_souffrance"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$result_groupe_c[$i]["incidents_nonsouffrants"]." </td>";	
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center;'> ".$result_groupe_c[$i]["incidents_dclosed"]."</td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$result_groupe_c[$i]["incidents_internes"]." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center;'> ".$result_groupe_c[$i]["incidents_externes"]." </td>";
	
	$duree = $result_groupe_c[$i]["duree_t_traitement"] ;

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;'> ".sec_To_Time($duree)." </td>";
	$body_content.="</tr>";		
	
	
	$total_nb_incidents_declares 		+= $result_groupe_c[$i]["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $result_groupe_c[$i]["nb_incidents_traites"];
	$total_incidents_closed 			+= $result_groupe_c[$i]["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $result_groupe_c[$i]["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $result_groupe_c[$i]["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $result_groupe_c[$i]["incidents_dclosed"];
	$total_incidents_internes 			+= $result_groupe_c[$i]["incidents_internes"];
	$total_incidents_externes 			+= $result_groupe_c[$i]["incidents_externes"] ; 
	$dureeTotal							+= $result_groupe_c[$i]["duree_t_traitement"] ;																		

	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$body_content.="<tr>";
	$body_content.="	<td colspan=11 style='border: thin  #6495ed; font-size:11px; font-family:Verdana; background-color: #fff; margin: 4px; text-align:center;'> ".$app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]." </td>";
	$body_content.="</tr>";																				
}else{
	$body_content.="<tr>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #fff;margin: 4px;width:200px; font-weight:bold;'> Totaux </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #79b6e5;text-align:center; font-weight:bold;'> ".$total_nb_incidents_declares." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_traites." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_closed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_nb_incidents_en_souffrance." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_nonsouffrants." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #D0E3FA;text-align:center; font-weight:bold;'> ".$total_incidents_dclosed." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_internes." </td>";
	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #caf2e3;text-align:center; font-weight:bold;'> ".$total_incidents_externes." </td>";
	

	$body_content.="	<td style='border: thin  #6495ed;font-size:11px; font-family:Verdana; background-color: #e3d8f6;text-align:center;font-weight:bold;'> ".sec_To_Time($dureeTotal)." </td>";
	$body_content.="</tr>";																				
	
}

$body_content.="</table>";


// tableau data par groupe end



$body_content.="</br><span style='font-family:Verdana;font-size:11px;'>Cordialement.</span><br>"; 
$subject=" Rapport des incidents du " .date('d.m.Y'); 

// Getting Adresses and sending mails
/*
$sqlEmails = "SELECT DISTINCT U.User_Email as group_moderateur 
	FROM vtiger_users2group UG, users U
	WHERE UG.userid = U.user_id 
	AND UG.groupid = 53
	UNION
	SELECT DISTINCT U.user_Email as group_moderateur 
	FROM siprod_groupsupcoord I, users U
	WHERE I.supid = U.user_id 
	AND I.groupid = 53 ";
	
$resultEmails = $adb->pquery($sqlEmails, array());


while ($myrow = $adb->fetch_array($resultEmails))
{
	$add = $myrow['group_moderateur'];
	sendmail($add,'reportgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
}
*/

	$add = 'sdiongue@pcci.sn';
	sendmail($add,'reportgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
	$add = 'mndiouf@pcci.sn';
	sendmail($add,'reportgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);
	$add = 'mediagne@pcci.sn';
	sendmail($add,'reportgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth);

//echo $body_content;
?>


