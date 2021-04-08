<?php
/*********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
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
$emailresult 	= $adb->pquery("SELECT email1 from vtiger_users", array());
$emailid 		= $adb->fetch_array($emailresult);
$emailaddress 	= $emailid[0];

$mailserveresult = $adb->pquery("SELECT server,server_username,server_password,smtp_auth FROM vtiger_systems where server_type = ?", array('email'));
$mailrow 		 = $adb->fetch_array($mailserveresult);
$mailserver 	 = $mailrow[0];
$mailuname 	 	 = $mailrow[1];
$mailpwd 		 = $mailrow[2];
$smtp_auth 		 = $mailrow[3];

$dataType		=	getDataParType();
$dataCampagne	=	getDataParCampagne();

$_SESSION['data_campagne']	=	$dataCampagne;
$_SESSION['data_type']		=	$dataType;

print_r($_SESSION['data_campagne']);
print_r($_SESSION['data_type']);

//-----------Deleting files--------------------
$fichier="Graphics/GRAPH_IMG/STAT_C_1.png";
if (file_exists($fichier))
{
	umask(0000); 
	chmod($fichier,0777); 
	unlink ($fichier); 
}
$fichier="Graphics/GRAPH_IMG/STAT_C_2.png";
if (file_exists($fichier))
{
	umask(0000); 
	chmod($fichier,0777); 
	unlink ($fichier); 
}
$fichier="Graphics/GRAPH_IMG/STAT_T_1.png";
if (file_exists($fichier))
{
	umask(0000); 
	chmod($fichier,0777); 
	unlink ($fichier); 
}
$fichier="Graphics/GRAPH_IMG/STAT_T_2.png";
if (file_exists($fichier))
{
	umask(0000); 
	chmod($fichier,0777); 
	unlink ($fichier); 
}

//---------Creating IMG GRAphics-----------------------------------
$body_content="<table align='center'>";
$body_content.="  <tr>";
$body_content.="		<td align='center'>";
$body_content.="			<img src='Graphics/Diagramme_C_1_X.php' width='800' height='400'/>";
$body_content.="		</td>";
$body_content.="  </tr>";
$body_content.="  <tr>";
$body_content.="		<td align='center'>";
$body_content.="			<img src='Graphics/Diagramme_C_2_X.php' width='800' height='400'/>";
$body_content.="		</td>";
$body_content.="  </tr>";
$body_content.="  <tr>";
$body_content.="		<td align='center'>";
$body_content.="			<img src='Graphics/Diagramme_T_1_X.php' width='800' height='400'/>";
$body_content.="		</td>";
$body_content.="  </tr>";
$body_content.="  <tr>";
$body_content.="		<td align='center'>";
$body_content.="			<img src='Graphics/Diagramme_T_2_X.php' width='800' height='400'/>";
$body_content.="		</td>";
$body_content.="  </tr>";
$body_content.="</table>";
echo $body_content;

// clé aléatoire de limite
$boundary = md5(uniqid(microtime(), TRUE));

// Headers
$headers = 'From: GID PCCI <reportgidpcci@pcci.sn>'."\r\n";
$headers .= 'Mime-Version: 1.0'."\r\n";
$headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
$headers .= "\r\n";

// Message
$msg = 'This is a multipart/mixed message.'."\r\n\r\n";

// Texte
$msg .= '--'.$boundary."\r\n";
//$msg .= 'Content-type:text/plain;charset=utf-8'."\r\n";
$msg .= 'Content-transfer-encoding:8bit'."\r\n";
$msg .= 'Un message avec une pièce jointe.'."\r\n";

// Pièce jointe
$file_name = 'C:\Athlete.jpg';
if (file_exists($file_name))
{
	$file_type = filetype($file_name);
	$file_size = filesize($file_name);
	
	$handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
	$content = fread($handle, $file_size);
	$content = chunk_split(base64_encode($content));
	$f = fclose($handle);
	
	$msg .= '--'.$boundary."\r\n";
	$msg .= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
	$msg .= 'Content-transfer-encoding:base64'."\r\n";
	$msg .= $content."\r\n";
}
$msg .= "Content-Disposition: inline; filename=\"$file\"\r\n";
// Fin
$msg .= '--'.$boundary."\r\n";
// Function mail()
//mail("mndiouf@pcci.sn", $subject, $msg, $headers);

$body_content = $msg;

// Preparing data and mail body
 /*
  setlocale (LC_ALL, 'fr_FR','fr');
  $body_content ="<span style='font-family:Verdana;font-size:11px;'>Statistiques journaliers des incidents du ".decode_html(utf8_encode (strftime("%A %d %B %Y %T", mktime(0, 0, 0, date('m'), date('d')-1, date('y'))))).".</span></br>";
  $body_content.="</br>";
  $body_content.="<table align='center'>";
  $body_content.="  <tr>";
  $body_content.="		<td align='center'>";
  $body_content.="			<img src='".$PORTAL_URL."Graphics/GRAPH_IMG/STAT_C_1.png' width='800' height='400' alt='R&eacute;partition des incidents par campagne'/>";
  $body_content.="		</td>";
  $body_content.="  </tr>";
  $body_content.="  <tr>";
  $body_content.="		<td align='center'>";
  $body_content.="			<img src='".$PORTAL_URL."Graphics/GRAPH_IMG/STAT_C_2.png' width='800' height='400' alt='R&eacute;partition des incidents souffrants par campagne'/>";
  $body_content.="		</td>";
  $body_content.="  </tr>";
  $body_content.="  <tr>";
  $body_content.="		<td align='center'>";
  $body_content.="			<img src='".$PORTAL_URL."Graphics/GRAPH_IMG/STAT_T_1.png' width='800' height='400' alt='R&eacute;partition des incidents par type'/>";
  $body_content.="		</td>";
  $body_content.="  </tr>";
  $body_content.="  <tr>";
  $body_content.="		<td align='center'>";
  $body_content.="			<img src='".$PORTAL_URL."Graphics/GRAPH_IMG/STAT_T_2.png' width='800' height='400' alt='R&eacute;partition des incidents souffrants par type'/>";
  $body_content.="		</td>";
  $body_content.="  </tr>";
  $body_content.="</table>";
  */

$subject=" Statistiques journaliers des incidents du " .strftime("%d.%m.%Y", mktime(0, 0, 0, date('m'), date('d')-1, date('y')));//date('d.m.Y'); 

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
  
  $add=array();
  while ($myrow = $adb->fetch_array($resultEmails))
  {
  $add[] = $myrow['group_moderateur'];
  }
  // Getting Adresses copy mails
   $sqlEmailsCC = "SELECT DISTINCT U.User_Email as group_moderateur 
   FROM vtiger_users2group UG, users U
   WHERE UG.userid = U.user_id 
   AND UG.groupid = 69
   UNION
   SELECT DISTINCT U.user_Email as group_moderateur 
   FROM siprod_groupsupcoord I, users U
   WHERE I.supid = U.user_id 
   AND I.groupid = 69 ";
   
   $resultEmailsCC = $adb->pquery($sqlEmailsCC, array());
   
   $addCC=array();
   while ($myrowCC = $adb->fetch_array($resultEmailsCC))
   {
   $addCC[] = $myrowCC['group_moderateur'];
   }
   */
$add	=array("mndiouf@pcci.sn");
$addCC =array("mndiouf@pcci.sn","mndiouf@pcci.sn");
sendmail($add,'reportgidpcci@pcci.sn',$subject,$body_content,$mailserver,$mailuname,$mailpwd,"",$smtp_auth,$addCC,$headers);

//echo $subject,"<br>";
//echo $body_content;


function  getDataParType() {
	
	global $log, $adb;
	
	$log->debug("Entering select getDataParType() method.");
	
	$date_start_val 	= $_REQUEST['date_start'];
	$date_end_val		= $_REQUEST['date_end'];
	
	$query = "  select date_postage,typeincidents,SUM(nb_incidents_declares) as nb_incidents_declares,
		SUM(nb_incidents_en_souffrance) as nb_incidents_en_souffrance
		from siprod_rapport_quotidien_type where 1=1 
		and date_postage = DATE_FORMAT(ADDDATE(now(), -2), '%Y-%m-%d') ";
	
	$query_distinct = "select distinct typeincidents from siprod_rapport_quotidien_type where 1=1 ";
	
	//		if(isset($date_start_val) && $date_start_val != '') {
	//			$d = new DateTime($date_start_val);
	//			$date_start = $d->format("Y-m-d");
	//			$query     .= " and date_postage >= ".$adb->quote($date_start);
	//		}
	//		else{
	//			$query     .= " and date_postage >= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
	//		}				
	//		if(isset($date_end_val) && $date_end_val != '') {
	//			$d = new DateTime($date_end_val);
	//			$date_end = $d->format("Y-m-d");
	//			$query   .= " and date_postage  <= ".$adb->quote($date_end);
	//		}
	//		else{
	//			$query     .= " and date_postage <= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
	//		}		
	
	$query .= " group by  date_postage,typeincidents order by typeincidents asc";
	$query_distinct .= " order by typeincidents asc";
	
	$list_result 	      = $adb->query($query);
	$list_result_distinct = $adb->query($query_distinct);
	$data_type		= array();
	$data_incident 	= array();
	$data_souffrant = array();
	$data_type_s	= array();
	$data_type_t	= array();
	
	for($c=0 ; $c < $adb->num_rows($list_result_distinct) ;++$c){
		$type_c        		= $adb->query_result($list_result_distinct, $c, 'typeincidents');
		$nb_incident_i  	= 0;
		$data_souffrant_i 	= 0;
		for($i=0 ; $i < $adb->num_rows($list_result) ;++$i){
			$type_i    = $adb->query_result($list_result, $i, 'typeincidents');
			if($type_i == $type_c){
				$nb_incident_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_declares');	
				$data_souffrant_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_en_souffrance');
			}
		}
		if($nb_incident_i != 0){
			$data_type_t[]		= decode_html($type_c);
			$data_incident[]    = $nb_incident_i;
		}
		if( $data_souffrant_i != 0 ){
			$data_type_s[]		= decode_html($type_c);
			$data_souffrant[]   = $data_souffrant_i;
		}
	}
	$data_type[0] = $data_type_t;
	$data_type[1] = $data_type_s;
	
	$data = array(0=>$data_type,1=>$data_incident,2=>$data_souffrant);
	
	return $data;
}


function getDataParCampagne() {
	
	global $log, $adb;
	
	$log->debug("Entering select getDataParCampagne() method.");
	
	$date_start_val 	= $_REQUEST['date_start'];
	$date_end_val		= $_REQUEST['date_end'];
	
	$query = "select date_postage,campagne,op_lib,SUM(nb_incidents_declares) as nb_incidents_declares,
		SUM(nb_incidents_en_souffrance) as nb_incidents_en_souffrance
		from  siprod_rapport_quotidien_campagne where 1=1 
		and date_postage = DATE_FORMAT(ADDDATE(now(), -2), '%Y-%m-%d') ";
	
	$query_distinct = "select distinct campagne,op_lib	from siprod_rapport_quotidien_campagne where 1=1 ";			
	
	//		if(isset($date_start_val) && $date_start_val != '') {
	//			$d = new DateTime($date_start_val);
	//			$date_start = $d->format("Y-m-d");
	//			$query     .= " and date_postage >= ".$adb->quote($date_start);
	//		}
	//		else{
	//			$query     .= " and date_postage >= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
	//		}				
	//		if(isset($date_end_val) && $date_end_val != '') {
	//			$d = new DateTime($date_end_val);
	//			$date_end = $d->format("Y-m-d");
	//			$query   .= " and date_postage  <= ".$adb->quote($date_end);
	//		}
	//		else{
	//			$query     .= " and date_postage <= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
	//		}		
	
	$query .= " group by  date_postage,campagne order by campagne asc";
	$query_distinct .= " order by campagne asc";
	
	$list_result 		  = $adb->query($query);
	$list_result_distinct = $adb->query($query_distinct);
	$data_campagne	 = array();
	$data_incident 	 = array();
	$data_souffrant  = array();
	$data_campagne_s = array();
	$data_campagne_t = array();
	for($c=0 ; $c < $adb->num_rows($list_result_distinct) ;++$c){
		$campagne_c     	= $adb->query_result($list_result_distinct, $c, 'campagne');
		$campagne_lib_c     = $adb->query_result($list_result_distinct, $c, 'op_lib');
		$nb_incident_i  	= 0;
		$data_souffrant_i 	= 0;
		for($i=0 ; $i < $adb->num_rows($list_result) ;++$i){
			$campagne_i    = $adb->query_result($list_result, $i, 'campagne');
			if($campagne_i == $campagne_c){
				$nb_incident_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_declares');	
				$data_souffrant_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_en_souffrance');
			}
		}
		if( $nb_incident_i != 0 ){
			$data_campagne_t[]	= decode_html($campagne_lib_c);
			$data_incident[]    = $nb_incident_i;
		}
		if( $data_souffrant_i != 0 ){
			$data_campagne_s[]	= decode_html($campagne_lib_c);
			$data_souffrant[]   = $data_souffrant_i;
		}
	}
	$data_campagne[0] = $data_campagne_t;
	$data_campagne[1] = $data_campagne_s;
	$data = array(0=>$data_campagne,1=>$data_incident,2=>$data_souffrant);
	
	return $data;
}

?>


