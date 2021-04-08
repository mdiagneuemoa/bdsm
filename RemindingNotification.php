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
require_once('notificationUtil.php');
global $app_strings; 
// Email Setup
$emailresult 	= $adb->pquery("SELECT email1 from vtiger_users", array());
$emailid 		= $adb->fetch_array($emailresult);
$emailaddress 	= $emailid[0];

$resalert 			= $adb->pquery("SELECT ticket from siprod_alert", array());
$num_rows_alerted 	= $adb->num_rows($resalert);
$ticketalerted = "";
for($t=0; $t<$num_rows_alerted; $t++) {
	$ticketalerted_t      = $adb->query_result($resalert, $t, "ticket");
	if($ticketalerted == "")
		$ticketalerted  = ''.$ticketalerted_t;
	else
		$ticketalerted  = $ticketalerted.','.$ticketalerted_t;
}

$mailserveresult = $adb->pquery("SELECT server,server_username,server_password,smtp_auth FROM vtiger_systems where server_type = ?", array('email'));
$mailrow 	= $adb->fetch_array($mailserveresult);
$mailserver = $mailrow[0];
$mailuname 	= $mailrow[1];
$mailpwd 	= $mailrow[2];
$smtp_auth 	= $mailrow[3];


$query = " SELECT REQ2.incidentid,REQ2.ticket, REQ2.campagne,REQ2.typeincidentid,REQ2.groupid from 
	(
	SELECT REQ.incidentid,REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation,TIMESTAMPDIFF(MINUTE,
	REQ.datecreation, now())as dureetraitement, REQ.delais,REQ.campagne,REQ.typeincidentid,REQ.groupid
		FROM
		(
			select I.incidentid,I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TI.delais,I.campagne,TI.typeincidentid,TI.groupid
			from siprod_incident I
			inner join siprod_type_incidents TI on I.typeincident= TI.typeincidentid
			left join siprod_traitement_incidents T1 on I.ticket = T1.ticket
			inner join vtiger_crmentity C  on I.incidentid= C.crmid
			where I.ticket not in (select distinct ticket from siprod_traitement_incidents where ifnull(statut,'') = 'traited' OR ifnull(statut,'') = 'closed' OR ifnull(statut,'') = 'reopen')
			AND C.deleted = 0
			group by I.ticket
			UNION
			SELECT I.incidentid,T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TI.delais,I.campagne,TI.typeincidentid,TI.groupid
			FROM siprod_traitement_incidents T, siprod_incident I,siprod_type_incidents TI,siprod_traitement_incidents T1, vtiger_crmentity C1, vtiger_crmentity C
			WHERE T.ticket not in ( select ticket from  siprod_traitement_incidents  where statut= 'traited' OR statut= 'closed')
			AND C.crmid = T.traitementincidentid
			AND C.deleted = 0
			AND C1.crmid = T1.traitementincidentid
			AND T.ticket = T1.ticket
			AND I.ticket = T1.ticket
			AND T.statut = 'reopen'
			AND I.typeincident= TI.typeincidentid
			GROUP BY T.ticket
		) 
	REQ
	where TIMESTAMPDIFF(MINUTE,REQ.datecreation, now()) > (REQ.delais +((20*REQ.delais)/100))
	) REQ2 where DATE(REQ2.datecreation)= DATE(now()) AND REQ2.typeincidentid not in (5290, 5289) " ;
	if($ticketalerted != "")
		$query .= " AND REQ2.ticket not in ( ".$ticketalerted." ) ";

$result 	= $adb->pquery($query, array());
$num_rows 	= $adb->num_rows($result);

for($i=0; $i<$num_rows; $i++) {
	$ticket          = $adb->query_result($result, $i, "ticket");
	if($email_k == "")
		$alertedTickets  = ''.$ticket;
	else
		$alertedTickets  = $alertedTickets.','.$ticket;
	
	$da     = new DateTime();
	$date_a = $da->format("Y-m-d H:i:s");	

	$adb->pquery("insert into siprod_alert (ticket,date_alert) values(?,?)", array($ticket,$date_a));
	
	$return_id       = $adb->query_result($result, $i, "incidentid");
	$idCampagne      = $adb->query_result($result, $i, "campagne");
	$typeincidentid  = $adb->query_result($result, $i, "typeincidentid");
	$groupid    	 = $adb->query_result($result, $i, "groupid");
	
	$groupstr       =  str_replace("|##|",",",$groupid) ;
	
	$queryMail = "select vtiger_groups.*, trim(users.user_email) as supgroup from vtiger_groups 
					join siprod_groupsupcoord on siprod_groupsupcoord.groupid = vtiger_groups.groupid 
					join users on users.user_id= siprod_groupsupcoord.coordid
					where vtiger_groups.groupid in (".$groupstr.")";
					
	$resultk 	= $adb->pquery($queryMail, array());
	$num_rowsk 	= $adb->num_rows($resultk);
	$email_k = "";
	for($k=0; $k<$num_rowsk; $k++) {
		if($email_k == "")
			$email_k         = $adb->query_result($resultk, $k, "supgroup");
		else
			$email_k         = $email_k.",".$adb->query_result($resultk, $k, "supgroup");
	}
	$infoTab = getRapportMailInfo($return_id,'relance','Incidents',$idCampagne);
	
	getRapportNotification($infoTab,'Incidents',$email_k);
	
}

?>


