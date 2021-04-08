<?php

function getRapportMailInfo($return_id,$mode,$currentModule)
	{
	require_once('include/utils/CommonUtils.php');
	$mail_data = Array();
	global $adb,$app_strings;
	$mailto='';
	if($currentModule == 'TraitementDemandes') {
		
		$qry  = "select siprod_traitement_demandes.*,siprod_demande.*,";
		$qry .= "(select vt.createdtime from siprod_demande sd INNER JOIN vtiger_crmentity vt ON vt.crmid = sd.demandeid
				where sd.ticket = siprod_traitement_demandes.ticket) as datecreation," ;
		$qry .= " vtiger_crmentity.createdtime,vtiger_crmentity.smcreatorid from siprod_traitement_demandes ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_demandes.traitementdemandeid";
		$qry .= " LEFT JOIN siprod_demande ON siprod_demande.ticket = siprod_traitement_demandes.ticket";
		$qry .= " where traitementdemandeid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$demandeid = $adb->query_result($ary_res,0,'demandeid');
		$typedemande = $adb->query_result($ary_res,0,'typedemande');
		$statut = $adb->query_result($ary_res,0,'statut');
		$creator_id = $adb->query_result($ary_res,0,'smcreatorid');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		$campagneid = $adb->query_result($ary_res,0,'campagne');
		$destination = $adb->query_result($ary_res,0,'destination');
		
		$typeDemandeInfo = getTypeDemandeInfo($typedemande);
		$typedemandeName = $typeDemandeInfo["nom"];
		$mail_data['type'] = $typedemandeName;
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Demandes&record=$demandeid"  ;
	    $mail_data['lien'] = " Pour plus d'information <a href='".$link."'>cliquer ici</a> ";
		$mail_data['statut'] = $statut ;
		$mail_data['typedemande'] = getTypeDemandeName($typedemande);
		$typedemandeDelais = $typeDemandeInfo["delais"];
		$mail_data['delais'] = $typedemandeDelais;
		
		// Recuperation de l'email du posteur
		$query_posteur = "select distinct U.user_Email as posteur,
						CONCAT(user_firstname,' ', user_name) as demandeur
						from     siprod_demande D, users U, vtiger_crmentity
						where    U.user_id = smcreatorid
						and      vtiger_crmentity.crmid = D.demandeid
						and      D.ticket= '$ticket' ";
		$result = $adb->pquery($query_posteur, array());
		$num_rows = $adb->num_rows($result);
		
		for($i=0; $i<$num_rows; $i++) {
			$posteur = $adb->query_result($result, $i, "posteur");
			$demandeur = $adb->query_result($result, 0 , "demandeur");
			if ($posteur != '')
				$mailto .= $posteur.',';
		}
		
		// Recuperation des emails destinataires
		if($statut == 'transfered' && $destination !="" )
			$qry_dest = " select distinct U.user_Email as owner ,S.user_Email as sup
                    from     siprod_demande D,  siprod_type_demandes T,vtiger_groups G,vtiger_users2group UG,users U,siprod_groupsupcoord I, users S
                    where    D.typedemande=T.typedemandeid
                    and      T.groupid = G.groupid
                    and      G.groupid = I.groupid
                    and      G.groupid= UG.groupid
                    and      (UG.userid =U.user_id and I.supid =S.user_id) 
                    and      G.groupid = '$destination' ";
		else
			$qry_dest= "select   distinct U.user_Email as owner ,S.user_Email as sup
				from     siprod_demande D,  siprod_type_demandes T,vtiger_groups G,
				vtiger_users2group UG,users U,siprod_groupsupcoord I, users S 
				where    D.typedemande=T.typedemandeid
				and      T.groupid=G.groupid 
				and      G.groupid = I.groupid
				and      G.groupid= UG.groupid
				and      (UG.userid =U.user_id and I.supid =S.user_id)
				and      D.ticket= '$ticket' ";
		
		$reqDelais="select  createdtime, TIMESTAMPDIFF(MINUTE,createdtime, now()) as delais_previsionnel
		from    vtiger_crmentity,siprod_demande where demandeid = crmid and   ticket=?" ;
				
	}
	else {
		$qry  = "select siprod_traitement_incidents.*,siprod_incident.*,";
		$qry .= "(select vt.createdtime from siprod_incident sd INNER JOIN vtiger_crmentity vt ON vt.crmid = sd.incidentid
				where sd.ticket = siprod_traitement_incidents.ticket) as datecreation," ;
		$qry .= " vtiger_crmentity.createdtime from siprod_traitement_incidents ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_incidents.traitementincidentid";
		$qry .= " LEFT JOIN siprod_incident ON siprod_incident.ticket = siprod_traitement_incidents.ticket";
		$qry .= " where traitementincidentid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$typeincident = $adb->query_result($ary_res,0,'typeincident');
		$statut = $adb->query_result($ary_res,0,'statut');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		$campagneid = $adb->query_result($ary_res,0,'campagne');
		$destination = $adb->query_result($ary_res,0,'destination');
		
		$incidentid = $adb->query_result($ary_res,0,'incidentid');
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Incidents&record=$incidentid"  ;
	    $mail_data['lien'] = " Pour plus d'information <a href='".$link."'>cliquer ici</a> ";
	    
		$mail_data['statut'] = $statut ;
		$mail_data['typeincident'] = getTypeincidentName($typeincident);
		
		$typeIncidentInfo = getTypeIncidentInfo($typeincident);
		$typeincidentName = $typeIncidentInfo["nom"];
		$typeincidentDelais = $typeIncidentInfo["delais"];
		$modeFonctionnement = $adb->query_result($ary_res,0,'modefonctionnement');
		$popimpactee = $adb->query_result($ary_res,0,'popimpactee');
		$floor = $adb->query_result($ary_res,0,'floor');
		$mail_data['floor'] = $floor;
		$mail_data['type'] = $typeincidentName;
		$mail_data['delais'] = $typeincidentDelais;
		$mail_data['popimpactee'] = $popimpactee;
		
		$mail_data['modeFonctionnement'] = $modeFonctionnement;
		
		// Recuperation de l'email du posteur
		$query_posteur = "select distinct U.user_Email as posteur,
			CONCAT(user_firstname,' ', user_name) as demandeur
			from     siprod_incident D, users U, vtiger_crmentity
			where    U.user_id = smcreatorid
			and      vtiger_crmentity.crmid = D.incidentid
			and      D.ticket= '$ticket' ";
						
		$result = $adb->pquery($query_posteur, array());
		$num_rows = $adb->num_rows($result);
		
		for($i=0; $i<$num_rows; $i++) {
			$posteur = $adb->query_result($result, 0 , "posteur");
			$demandeur = $adb->query_result($result, 0 , "demandeur");
			if ($posteur != '')
				$mailto .= $posteur.',';
		}
		
		// Recuperation des emails destinataires
		if($statut == 'transfered' && $destination !="" )
			$qry_dest = "select  distinct U.user_Email as owner ,S.user_Email as sup
	              from     siprod_incident D,  siprod_type_incidents T,vtiger_groups G,vtiger_users2group UG,users U,siprod_groupsupcoord I, users S
	              where    D.typeincident=T.typeincidentid
	              and      instr(concat(' ', T.groupid, ' '), concat(' ', G.groupid, ' ')) > 0 
	              and      G.groupid = I.groupid
	              and      G.groupid= UG.groupid
	              and      (UG.userid =U.user_id and I.supid =S.user_id) 
	              and      G.groupid = '$destination' ";
		else
			$qry_dest=" select   distinct U.user_Email as owner ,S.user_Email as sup
	              from     siprod_incident D,  siprod_type_incidents T,vtiger_groups G,vtiger_users2group UG,users U,siprod_groupsupcoord I, users S
	              where    D.typeincident=T.typeincidentid
	              and      instr(concat(' ', T.groupid, ' '), concat(' ', G.groupid, ' ')) > 0 
	              and      G.groupid = I.groupid
	              and      G.groupid= UG.groupid
	              and      (UG.userid =U.user_id and I.supid =S.user_id) 
	              and      D.ticket= '$ticket'";
	              
		$reqDelais="select  createdtime, TIMESTAMPDIFF(MINUTE,createdtime, now()) as delais_previsionnel
		from    vtiger_crmentity,siprod_incident where   incidentid = crmid and   ticket=?" ;
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
		
	$query_rp = "SELECT DISTINCT u.User_Email as rp_email
		FROM  users u
		INNER JOIN siprod_campagnerp crp ON u.user_id = crp.rpid
		INNER JOIN operations op ON   crp.campagneid = op.Op_Id
		WHERE op.Op_Id  = ?
		UNION
		SELECT DISTINCT u.User_Email as rp_email
		FROM  users u
		INNER JOIN siprod_campagnerp crp ON u.user_id = crp.rpbackupid
		INNER JOIN operations op  ON   crp.campagneid = op.Op_Id
		WHERE op.Op_Id  = ? ";

	$query_moderateur = " SELECT DISTINCT U.User_Email as group_moderateur 
		FROM vtiger_users2group UG, users U
		WHERE UG.userid = U.user_id 
		AND UG.groupid = 64                   
		UNION
		SELECT DISTINCT U.user_Email as group_moderateur 
		FROM siprod_groupsupcoord I, users U
		WHERE I.supid = U.user_id 
		AND I.groupid = 64 ";
	
	//Modif PNAP groupe moderateur PNAP 71
	if( $campagneid == "1000891" )
		$query_moderateur = " SELECT DISTINCT U.User_Email as group_moderateur 
			FROM vtiger_users2group UG, users U
			WHERE UG.userid = U.user_id 
			AND UG.groupid = 71                     
			UNION
			SELECT DISTINCT U.user_Email as group_moderateur 
			FROM siprod_groupsupcoord I, users U
			WHERE I.supid = U.user_id 
			AND I.groupid = 71 ";
	// End modif pnap
	
	$result = $adb->pquery($query_moderateur, array());
	$num_rows = $adb->num_rows($result);
	
	$result_rp = $adb->pquery($query_rp, array($campagneid,$campagneid));
	$num_rows_rp = $adb->num_rows($result_rp);
	
	for($i=0; $i<$num_rows; $i++) {
		$moderateur = $adb->query_result($result, $i, "group_moderateur");
		if ($moderateur != '')
			$mailto_sup .= $moderateur.',';
	}
	
	// If no PNAP
	if( $campagneid != "1000891" ){
		for($j=0; $j < $num_rows_rp; $j++) {
			$rp = $adb->query_result($result_rp, $j, "rp_email");
			if ($rp != '')
				$mailto_sup .= $rp.',';
		}
	}
	$description= $adb->query_result($ary_res,0,7);
	$extension = $adb->query_result($ary_res,0,'extension');
	$campagne = $adb->query_result($ary_res,0,'campagne');
	$mail_data['extension'] = $extension;
	$resultdelai = $adb->pquery($reqDelais, array($ticket));
	$delais_previsionnel = $adb->query_result($resultdelai,0,'delais_previsionnel');
	$mail_data['delais_previsionnel'] = $delais_previsionnel;
	
	$mail_data['title'] = "Mail de notification";
	$mail_data['ticket'] = $ticket;
	$mail_data['createdtime'] = $createdtime;
	
	$mail_data['mailto'] = $mailto ;
	$mail_data['mailto_sup'] = $mailto_sup ;
	$mail_data['creator_id'] = $creator_id;
	$mail_data['description'] = $description;
	$mail_data['demandeur'] = $demandeur ;
	$datecreation = $adb->query_result($ary_res,0,'datecreation');
	
	$tabdatecreation = split(' ',$datecreation);
	$datecreation = getDisplayDate($tabdatecreation[0])." ".$tabdatecreation[1];
	$mail_data['datecreation'] = $datecreation;
	
	$mail_data['campagne'] = getCampagneName($campagne);
	
	// Recuperation des emails en copie caché
	$query_top = "SELECT DISTINCT U.User_Email as top_email 
		FROM vtiger_users2group UG, users U
		WHERE UG.userid = U.user_id 
		AND UG.groupid = 68";
		
	$result_top = $adb->pquery($query_top, array() );
	$num_rows_top = $adb->num_rows($result_top);
	
	for($k=0; $k < $num_rows_top; $k++) {
		$top = $adb->query_result($result_top, $k, "top_email");
		if ($top != '')
			$mailto_top .= $top.',';
	}
	$mail_data['mailto_top'] = $mailto_top ;
	// Fin Recuperation des emails en copie caché
	
	return $mail_data;
	
	}

function getRapportNotification($desc,$currentModule)
	{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	
	
	$modulename=$mod_strings['LBL_MODULE'];
	
	$subject = $modulename;
	$subject .=' '.$desc['ticket'];
	
	if($modulename=='TraitementDemandes' || $modulename=='Demande')
		$typeName=$desc['typedemande'];
	else
		$typeName=$desc['typeincident'];

	
	$statut=$desc['statut'];
	
	if ($statut == 'open') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce".$desc['createdtime'].")";
	}
	elseif ($statut == 'pending') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}
	elseif ($statut == 'transfered') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}
	elseif ($statut == 'traited') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}
	elseif ($statut == 'reopen' || $statut == 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}
	elseif ($statut == 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}
	elseif ($statut == 'closed') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_CLOSED"]." ".$desc['campagne'].": ".$typeName." (du ".$desc['datecreation'].") - ".decode_html($app_strings['action_'.$statut])." (ce ".$desc['createdtime'].")";
	}

	$to_email =$desc['mailto'];
	$to_email_sup =$desc['mailto_sup'];
	$from = $app_strings['LBL_FROM_GID'];
	$description = getRapportDetails($desc,$desc['user_id'],$currentModule);
	
	$to_email_cc_cache =$desc['mailto_top'];
	
	// Enlever les copies cahée - 
	$to_email_cc_cache ="";

	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from,$from,decode_html($subject),$description,$to_email_sup,$to_email_cc_cache);	
}

function getRapportDetails($description,$user_id,$currentModule,$from='')
{
	        global $log,$current_user,$currentModule;
	        global $adb,$mod_strings,$app_strings;
	        $log->debug("Entering getRapportDetails(".$description.") method ...");

		if ($description['mode'] == 'edit')	 
		{
				$reply = $mod_strings['LBL_LAST_MODIFIED'].' '.$description['createdtime'];
		}
		else	 
		{
			$reply = $mod_strings['LBL_CREATED'].' '.$description['createdtime'];
		}
						
		$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
		
	    $current_username = getNomPrenomUserEdited($current_user->id);
		
		$list='
		<table cellspacing="0" cellpadding="0" border="0" width="620" style="padding: 10px;">
			<tbody>
				<tr>
					<td style="background: none repeat scroll 0% 0% rgb(59, 89, 152); color: rgb(255, 255, 255); font-weight: bold; font-family: "arial", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: left;">
						<table width="100%">
							<tbody>
								<tr>
									<td align="left" width="" valign="top"
										style="color: rgb(255, 255, 255); font-weight: bold; font-family: "arial", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: left;">
										GIDPCCI 
									</td> 
									<td align="right" width="" valign="top"
										style="color: rgb(255, 255, 255); font-weight: bold; font-family: "arial", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: right;">
										  N° Ticket : '.$description['ticket'].' 
									</td>
								</tr>
							</tbody>
						</table>                                                      
					</td>
				</tr>
				<tr>
					<td valign="top"
						style="background-color: rgb(255, 255, 255); border-bottom: 1px solid rgb(59, 89, 152); border-left: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); font-family: "arial", tahoma, verdana, arial, sans-serif; padding: 15px;">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" valign="top" style="font-size: 12px;">
								<div style="margin-bottom: 15px; color: rgb(59, 89, 152);"><br>';
								$list .= $mod_strings['LBL_SALUTATION'].',<br>';
							    if($currentModule == 'Incidents' || $currentModule == 'SuiviIncidents' || $currentModule == 'TraitementIncidents' ){
							   		$list .= decode_html($mod_strings['LBL_DETAILS_INCIDENT_NOTIFICATION']).'<br> ';
							    	$rappel = decode_html('<br>Rappel sur l&acute;incident ');	
							    }
							   	else{
									$list .= decode_html($mod_strings['LBL_DETAILS_DEMANDE_NOTIFICATION']).'<br> ';
							   		$rappel = decode_html('<br>Rappel sur la demande ');
							   	}
							   	$statut = $description['statut'];
							   	$list .= decode_html('<br><b>Action effectu&eacute;e : </b>'.decode_html($app_strings['action_'.$statut]).'  <b>Ce </b>'.$description['createdtime']);
    							$list .= decode_html('<br><b>Temps &eacute;coul&eacute; (en Min) : </b>'.$description['delais_previsionnel']);													   										
								$list .=' 
								</div>
								<div style="margin-bottom: 10px;"><span style="font-size: 12px; color: rgb(59, 89, 152);"><b>';
								$list .= $rappel;
								$list .='</b></span><div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">&nbsp;</div>
								<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%" style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">'; 
													$list .= '<ul>';
													$list .= '<li><b>'.$mod_strings["ticket"].' : </b>'.$description['ticket'];
																										
													if($currentModule == 'Incidents' || $currentModule == 'TraitementIncidents'){
														$list .= '<li><b>'.decode_html($mod_strings["Typeincident"].' : </b>'.$description['typeincident']);
														$list .= '<li><b>'.decode_html($mod_strings["ModeFonctionnement"].' : </b>'.$description['modeFonctionnement']);
														if($description['popimpactee']== "1000" )
														  $list .= '<li><b>'.decode_html($mod_strings["Population impactee"].' :</b> Tous');
														else
														  $list .= '<li><b>'.decode_html($mod_strings["Population impactee"].' : </b>'.$description['popimpactee']);
														$list .= '<li><b>'.decode_html($mod_strings["Delais"].' : </b>'.$description['delais']);
													}
													else{
														$list .= '<li><b>'.decode_html($mod_strings["Typedemande"].' : </b>'.$description['typedemande']);
														$list .= '<li><b>'.decode_html($mod_strings["Delais"].' : </b>'.$description['delais']);
													}
													$list .= '</ul>';
													
													$list .= '<br><b>Contact du demandeur : </b> 
													<br>'.decode_html($description['demandeur']) ;
													if ($description['floor'] != "") $list .= '<br>'.decode_html($description['floor']);
													if ($description['extension'] != "") $list .= '<br><b>Extension : </b>'.$description['extension'];
													$list .= '<br><br>'.$description['lien'].'
													
												</td>
											</tr>
										</tbody>
									</table> ';
									
									if ($description['description'] != ""){
									$list .= '<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">&nbsp;</div>
									
									<div style="line-height: 5px;">
										<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%"
													style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">
													<b>Description:</b><br>'.$description['description'].'
												</td>
											</tr>
										</tbody>
									</table>
									</div>';
									}		
				
								$list .= '</div>
								</td>
							</tr>
						</tbody>
					</table>
					<img style="border: 0pt none; min-height: 1px; width: 1px;" alt="">
					</td>
				</tr>
				</tbody>
		</table> ';

        $log->debug("Exiting getActivityDetails method ...");
        return correctImg($list);
}

/**
 *  Cette fonction complete l url des images et 
 * 	reduit la taill des images
 */
function correctImg($imgbalise)
{
	$imgbalise = html_entity_decode($imgbalise);
	$pattern = "|<img(.*)src=\"|U";
	preg_match( $pattern , $imgbalise  , $imgs);
	$replacement = '<img height="600" width="800" src="http://10.11.2.198';
	if($imgs != null){
		$corectHtlm = str_replace($imgs[0] , $replacement, $imgbalise);
		return $corectHtlm ;
	}
	else
		return $imgbalise;
}

?>