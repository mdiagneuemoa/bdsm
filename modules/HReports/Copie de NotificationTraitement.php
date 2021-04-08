<?php


function getRapportMailInfo($return_id,$mode,$currentModule)
	{
	require_once('include/utils/CommonUtils.php');
	$mail_data = Array();
	global $adb;
	$mailto='';
	if($currentModule == 'TraitementDemandes') {
		$qry  = "select siprod_traitement_demandes.*,siprod_demande.typedemande,";
		$qry .= " vtiger_crmentity.createdtime,siprod_demande.ticket,vtiger_crmentity.smcreatorid from siprod_traitement_demandes ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_demandes.traitementdemandeid";
		$qry .= " LEFT JOIN siprod_demande ON siprod_demande.ticket = siprod_traitement_demandes.ticket";
		$qry .= " where traitementdemandeid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$typedemande = $adb->query_result($ary_res,0,'typedemande');
		$statut = $adb->query_result($ary_res,0,'statut');
		$statut = $adb->query_result($ary_res,0,'smcreatorid');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		
		$mail_data['statut'] = $statut ;
		$mail_data['typedemande'] = getTypeDemandeName($typedemande);
		
		// Recuperation de l'email du posteur
		$query_posteur = "select distinct U.user_Email as posteur
						from     siprod_demande D, users U, vtiger_crmentity
						where    U.user_id = smcreatorid
						and      vtiger_crmentity.crmid = D.demandeid
						and      D.ticket= '$ticket' ";
		$result = $adb->pquery($query_posteur, array());
		$num_rows = $adb->num_rows($result);
		
		for($i=0; $i<$num_rows; $i++) {
			$posteur = $adb->query_result($result, $i, "posteur");
			if ($posteur != '')
				$mailto .= $posteur.',';
		}
		
		// Recuperation des emails destinataires
		$qry_dest= "select   distinct U.user_Email as owner ,S.user_Email as sup
			from     siprod_demande D,  siprod_type_demandes T,vtiger_groups G,
			vtiger_users2group UG,users U,siprod_groupsupcoord I, users S 
			where    D.typedemande=T.typedemandeid
			and      T.groupid=G.groupid 
			and      G.groupid = I.groupid
			and      G.groupid= UG.groupid
			and      (UG.userid =U.user_id and I.supid =S.user_id)
			and      D.ticket= '$ticket' ";
				
	}
	else {
		$qry  = "select siprod_traitement_incidents.*,siprod_incident.typeincident,";
		$qry .= " vtiger_crmentity.createdtime,siprod_incident.ticket from siprod_traitement_incidents ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_incidents.traitementincidentid";
		$qry .= " LEFT JOIN siprod_incident ON siprod_incident.ticket = siprod_traitement_incidents.ticket";
		$qry .= " where traitementincidentid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$typeincident = $adb->query_result($ary_res,0,'typeincident');
		$statut = $adb->query_result($ary_res,0,'statut');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		$mail_data['statut'] = $statut ;
		$mail_data['typeincident'] = getTypeincidentName($typeincident);
		
		// Recuperation de l'email du posteur
		$query_posteur = "select distinct U.user_Email as posteur
						from     siprod_incident D, users U, vtiger_crmentity
						where    U.user_id = smcreatorid
						and      vtiger_crmentity.crmid = D.incidentid
						and      D.ticket= '$ticket' ";
		$result = $adb->pquery($query_posteur, array());
		$num_rows = $adb->num_rows($result);
		
		for($i=0; $i<$num_rows; $i++) {
			$posteur = $adb->query_result($result, $i, "posteur");
			if ($posteur != '')
				$mailto .= $posteur.',';
		}
		
		// Recuperation des emails destinataires
		$qry_dest=" select   distinct U.user_Email as owner ,S.user_Email as sup
              from     siprod_incident D,  siprod_type_incidents T,vtiger_groups G,vtiger_users2group UG,users U,siprod_groupsupcoord I, users S
              where    D.typeincident=T.typeincidentid
              and      instr(concat(' ', T.groupid, ' '), concat(' ', G.groupid, ' ')) > 0 
              and      G.groupid = I.groupid
              and      G.groupid= UG.groupid
              and      (UG.userid =U.user_id and I.supid =S.user_id) 
              and      D.ticket= '$ticket'";

	}
		
	$req = $adb->pquery($qry_dest, array());
	$res=$adb->num_rows($req);	
	$i=0;
	
	$mailto_sup=''; 
	if($res>0) {
		while($i!=$res) { 
			$mailto_i = $adb->query_result($req, $i, "owner");
			if ($mailto_i != '')
				$mailto .= $mailto_i.',';
				
			$mailto_sup_i = $adb->query_result($req, $i, "sup");
			if( ! ereg("$mailto_sup_i", "$mailto_sup") )
				$mailto_sup .= $mailto_sup_i.',';
		
			$i++;
		} 
		
	}	
	$createdtime = $adb->query_result($ary_res,0,'createdtime');
	$tabcreatedtime = split(' ',$createdtime);
	$createdtime = getDisplayDate($tabcreatedtime[0])." ".$tabcreatedtime[1];

	// Début Récupération des mails du groupe modérateur
	
	$query_moderateur = "SELECT DISTINCT U.User_Email as group_moderateur 
		FROM vtiger_users2group UG, users U
		WHERE UG.userid = U.user_id 
		AND UG.groupid = 64
				UNION
		SELECT DISTINCT U.user_Email as group_moderateur 
		FROM siprod_groupsupcoord I, users U
		WHERE I.supid = U.user_id 
		AND I.groupid = 64 ";
	$result = $adb->pquery($query_moderateur, array());
	$num_rows = $adb->num_rows($result);
	
	for($i=0; $i<$num_rows; $i++) {
		$moderateur = $adb->query_result($result, $i, "group_moderateur");
		if ($moderateur != '')
			$mailto_sup .= $moderateur.',';
	}
	
	// Fin Récupération des mails du groupe modérateur
	
	$mail_data['title'] = "Mail de notification";
	$mail_data['ticket'] = $ticket;
	$mail_data['createdtime'] = $createdtime;
	$mail_data['mailto'] = $mailto ;
	$mail_data['mailto_sup'] = $mailto_sup ;
	
	return $mail_data;
	
	}

function getRapportNotification($desc,$currentModule)
	{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	
	// gestion des objet de message en fonction des statuts et des états
	
	$modulename=$mod_strings['LBL_MODULE'];
	
	$subject = $modulename;
	$subject .=' '.$desc['ticket'];
	
	if($modulename=='TraitementDemandes' || $modulename=='Demande')
		$typeName=$desc['typedemande'];
	else
		$typeName=$desc['typeincident'];
	
//	$statut=$desc['statut'];
//	$subject .=' ('.$typeName.') '.decode_html($app_strings[$statut]);
	
	
	$statut=$desc['statut'];
	
	if ($statut == 'open') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'pending') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'transfered') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'traited') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'reopen') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
//	elseif ($statut == 'relancer') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typeName." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
//	}


	// Recuperation des destinataires
	$to_email =$desc['mailto'];
	// Recuperation du N+1
	$to_email_sup =$desc['mailto_sup'];
	$from = $app_strings['LBL_FROM_GID'];
	
	$description = getRapportDetails($desc,$desc['user_id'],$currentModule);

	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from,$from,$subject,$description,$to_email_sup);
}

function getRapportDetails($description,$user_id,$currentModule,$from='')
	{
	global $log,$current_user,$currentModule;
	global $adb,$mod_strings;
	$log->debug("Entering getRapportDetails(".$description.") method ...");
	
	$reply = $mod_strings['LBL_CREATED'].' '.getDisplayDate($description['modifiedtime']);
	$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
	$current_username = getUserName($current_user->id);
	$list = $mod_strings['LBL_SALUTATION'].',<br><br>';
	$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING'].' '.$description['ticket'];
	
	$statut=$description['statut'];
	
	if($statut == 'closed'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_CLOSED'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_CLOSED'];
	}
	elseif($statut == 'open'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_OPEN'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_OPEN'];
	}
	elseif($statut == 'reopen'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_REOPEN'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_REOPEN'];
	}
	elseif($statut == 'pending'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_PENDING'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_PENDING'];
	}
	elseif($statut == 'transfered'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_TRANSFERED'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_TRANSFERED'];
	}
	elseif($statut == 'traited'){ 
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_TRAITED'].' '.$reply;
		$list .= '<br>'.$mod_strings['LBL_LIEN_TRAITED'];
	}
	$list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
	$list .= '<br>'.$current_username.'.'; 
	
	$log->debug("Exiting getActivityDetails method ...");
	return $list;
	}

?>