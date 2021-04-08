<?php
function getRapportMailInfo($return_id,$mode,$currentModule)
	{
	require_once('include/utils/CommonUtils.php');
	$mail_data = Array();
	global $adb,$app_strings;
	$mailto='';
	if($currentModule == 'TraitementDemandes') {
		$qry  = "select siprod_traitement_demandes.*,siprod_demande.typedemande,siprod_demande.campagne,siprod_demande.demandeid,";
		$qry .= " vtiger_crmentity.createdtime,siprod_demande.ticket,vtiger_crmentity.smcreatorid from siprod_traitement_demandes ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_demandes.traitementdemandeid";
		$qry .= " LEFT JOIN siprod_demande ON siprod_demande.ticket = siprod_traitement_demandes.ticket";
		$qry .= " where traitementdemandeid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$demandeid = $adb->query_result($ary_res,0,'demandeid');
		$typedemande = $adb->query_result($ary_res,0,'typedemande');
		$statut = $adb->query_result($ary_res,0,'statut');
		$creator_id = $adb->query_result($ary_res,0,'smcreatorid');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Demandes&record=$demandeid"  ;
	    $mail_data['lien'] = " Pour plus d'information cliquer <a href='".$link."'>ici</a> ";
	
		$mail_data['statut'] = $statut ;
		$mail_data['typedemande'] = getTypeDemandeName($typedemande);
		
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
		$qry  = "select siprod_traitement_incidents.*,siprod_incident.typeincident,siprod_incident.campagne,siprod_incident.incidentid,";
		$qry .= " vtiger_crmentity.createdtime,siprod_incident.ticket from siprod_traitement_incidents ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_traitement_incidents.traitementincidentid";
		$qry .= " LEFT JOIN siprod_incident ON siprod_incident.ticket = siprod_traitement_incidents.ticket";
		$qry .= " where traitementincidentid=?";
		
		$ary_res = $adb->pquery($qry, array($return_id));
		$typeincident = $adb->query_result($ary_res,0,'typeincident');
		$statut = $adb->query_result($ary_res,0,'statut');
		$ticket = $adb->query_result($ary_res,0,'ticket');
		$destination = $adb->query_result($ary_res,0,'destination');
		
		$incidentid = $adb->query_result($ary_res,0,'incidentid');
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Incidents&record=$incidentid"  ;
	    $mail_data['lien'] = " Pour plus d'information cliquer <a href='".$link."'>ici</a> ";
	    
		$mail_data['statut'] = $statut ;
		$mail_data['typeincident'] = getTypeincidentName($typeincident);
		
		$query_posteur = "select distinct U.user_Email as posteur
						from     siprod_incident D, users U, vtiger_crmentity
						where    U.user_id = smcreatorid
						and      vtiger_crmentity.crmid = D.incidentid
						and      D.ticket= '$ticket' ";
						
		$result = $adb->pquery($query_posteur, array());
		$num_rows = $adb->num_rows($result);
		
		for($i=0; $i<$num_rows; $i++) {
			$posteur = $adb->query_result($result, 0 , "posteur");
			if ($posteur != '')
				$mailto .= $posteur.',';
		}
		
		if($statut == 'transfered' && $destination !="" )
			$query_posteur = "select  distinct U.user_Email as owner ,S.user_Email as sup
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
	
	$description= $adb->query_result($ary_res,0,'description');
	$extension = $adb->query_result($ary_res,0,'extension');
	$campagne = $adb->query_result($ary_res,0,'campagne');
	
	$mail_data['title'] = "Mail de notification";
	$mail_data['ticket'] = $ticket;
	$mail_data['createdtime'] = $createdtime;
	$mail_data['mailto'] = $mailto ;
	$mail_data['mailto_sup'] = $mailto_sup ;
	$mail_data['creator_id'] = $creator_id;
	$mail_data['description'] = $description;
	
	$mail_data['campagne'] = getCampagneName($campagne);
	
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
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'pending') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'transfered') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'traited') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'reopen' || $statut == 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typeName." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}

	
	$to_email =$desc['mailto'];
	$to_email_sup =$desc['mailto_sup'];
	$from = $app_strings['LBL_FROM_GID'];
	
	$description = getRapportDetailsBis($desc,$desc['user_id'],$currentModule);
	
	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from,$from,decode_html($subject),$description,$to_email_sup);

	send_mail('HReports','mndiouf@pcci.sn',$from ,$from,decode_html($subject),$description,'mndiouf@pcci.sn');
}

function getRapportDetails($description,$user_id,$currentModule,$from='')
{
	
	global $log,$current_user,$currentModule,$app_strings;
	global $adb,$mod_strings;
	$log->debug("Entering getRapportDetails(".$description.") method ...");
	
	$reply = $mod_strings['LBL_CREATED'].' '.$description['createdtime'];
	$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
	$idU = $description['creator_id'];
	$current_username = getUserName($current_user->id);
	$list = $mod_strings['LBL_SALUTATION'].',<br><br>';
	if($currentModule=='TraitementDemandes')
		$typeNam='La demande';
	else
		$typeNam="L'incident";
		
	$list .= $typeNam.' '.$description['ticket'];
	
	$statut=$description['statut'];
	
	if($statut == 'closed'){
		$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_CLOSED'].' '.$reply;
	}
	elseif($statut == 'open'){
		$list .= $mod_strings['LBL_DETAILS_TRAITEMENT_STRING_OPEN'].' '.$reply;
	}
	elseif($statut == 'reopen'){
		$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_REOPEN'].' '.$reply;
	}
	elseif($statut == 'pending'){
		$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_PENDING'].' '.$reply;
	}
	elseif($statut == 'transfered'){
		$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_TRANSFERED'].' '.$reply;
	}
	elseif($statut == 'traited'){ 
		$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_TRAITED'].' '.$reply;
	}
	$list .= '<br>'.$description['lien'] ;
	$list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
	$list .= '<br>'.$current_username.'.'; 
	
	$log->debug("Exiting getActivityDetails method ...");
	return $list;
}
	
	
function getRapportDetailsBis($description,$user_id,$currentModule,$from='')
{
	        global $log,$current_user,$currentModule;
	        global $adb,$mod_strings,$app_strings;
	        $log->debug("Entering getRapportDetails(".$description.") method ...");
		
						
	    $current_username = getNomPrenomUserEdited($current_user->id);
		
		$list='
		<table cellspacing="0" cellpadding="0" border="0" width="550">
			<tbody>
				<tr>
					<td style="background: none repeat scroll 0% 0% rgb(59, 89, 152); color: rgb(255, 255, 255); font-weight: bold; font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: left;">
						<table width="100%">
							<tbody>
								<tr>
									<td align="left" width="" valign="top"
										style="color: rgb(255, 255, 255); font-weight: bold; font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: left;">
										GIDPCCI 
									</td> 
									<td align="right" width="" valign="top"
										style="color: rgb(255, 255, 255); font-weight: bold; font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 4px 8px; vertical-align: middle; font-size: 16px; letter-spacing: -0.03em; text-align: right;">
										 N° Ticket : '.$description['ticket'].' 
									</td>
								</tr>
							</tbody>
						</table>                                                      
					</td>
				</tr>
				<tr>
					<td valign="top"
						style="background-color: rgb(255, 255, 255); border-bottom: 1px solid rgb(59, 89, 152); border-left: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 15px;">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" valign="top" style="font-size: 12px;">
								<div style="margin-bottom: 15px; color: rgb(59, 89, 152);">';

							   	$reply = $mod_strings['LBL_CREATED'].' '.$description['createdtime'];
							   	
								$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
							   								   	
								$list .=' 
								</div>
								<div style="margin-bottom: 15px;">
									
									<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%" style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">'; 

													$list .= $mod_strings['LBL_SALUTATION'].',<br><br>';
													
													if($currentModule == 'TraitementDemandes')
														$typeNam = 'La demande';
													else
														$typeNam = "L'incident";
														
													$list .= $typeNam.' '.$description['ticket'];
													$statut=$description['statut'];
													$list .=" concernant la campagne ".$description['campagne'];
													if($statut == 'closed'){
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_CLOSED'].' '.$reply;
													}
													elseif($statut == 'open'){
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_OPEN'].' '.$reply;
													}
													elseif($statut == 'reopen'){
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_REOPEN'].' '.$reply;
													}
													elseif($statut == 'pending'){
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_PENDING'].' '.$reply;
													}
													elseif($statut == 'transfered'){
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_TRANSFERED'].' '.$reply;
													}
													elseif($statut == 'traited'){ 
														$list .= $app_strings['LBL_DETAILS_TRAITEMENT_STRING_TRAITED'].' '.$reply;
													}
																					
													$list .= '</span></td>
											</tr>
										</tbody>
									</table>
									<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">&nbsp;</div>
										
								</div>
								<div style="margin: 0pt; font-size: 12px; color: rgb(59, 89, 152); padding: 0px 0px 10px;"';
									if($description['description']!= ''){
										$list .= '
										<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">
											<table cellpadding="0" style="margin-top: 5px;">
											<tbody>
												<tr valign="top">
													<td width="100%"
														style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;"><span
														style="font-size: 12px; color: rgb(59, 89, 152);">
														Description:<br>'.$description['description'].'
													</td>
												</tr>
											</tbody>
										</table>
										</div>';
									}
									
									$list .= '<span style="font-size: 12px; color: rgb(59, 89, 152);">';
									$list .= '<br>'.$description['lien'] ;
									$list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
									$list .= '<br>'.$current_username. '<span>
								</div>
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
        return $list;
}
?>