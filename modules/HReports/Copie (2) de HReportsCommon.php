<?php
function getRapportMailInfo($return_id,$mode,$currentModule,$idCampagne)
{
	 require_once('include/utils/CommonUtils.php');
	$mail_data = Array();
	global $adb,$app_strings;
	
	if($currentModule == 'Demandes' || $currentModule == 'SuiviDemandes' ){
		$qry  = "select * from siprod_demande ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_demande.demandeid";
		$qry .= " where demandeid=?";
		$ary_res = $adb->pquery($qry, array($return_id));
		$typedemande = $adb->query_result($ary_res,0,'typedemande');
		
		$typeDemandeInfo = getTypeDemandeInfo($typedemande);
		$typedemandeName = $typeDemandeInfo["nom"];
		$typedemandeDelais = $typeDemandeInfo["delais"];
		
		$mail_data['type'] = $typedemandeName;
		$mail_data['delais'] = $typedemandeDelais;	
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Demandes&record=$return_id"  ;
		$mail_data['lien'] = " Pour traiter cette demande cliquer <a href='".$link."'>ici</a> ";
		
		$datelivraison = $adb->query_result($ary_res,0,'datelivraison');
		$mail_data['datelivraison'] = getDisplayDate($datelivraison); 
		
		$reqString ="
			SELECT DISTINCT U.user_Email as mgroup , S.user_Email as sup
			FROM siprod_demande D, siprod_type_demandes T, vtiger_groups G, vtiger_users2group UG, users U, siprod_groupsupcoord I, users S
			WHERE D.typedemande = T.typedemandeid
			AND T.groupid = G.groupid
			AND G.groupid = I.groupid
			AND G.groupid = UG.groupid
			AND UG.userid = U.user_id 
			AND I.supid = S.user_id
			and D.demandeid= '". $return_id ."'";
		
		
		$req = $adb->pquery($reqString, array());
		$res=$adb->num_rows($req);
		$i=0;
		
		$mailto='';
		$mailto_sup ='' ;
		if($res>0)
		{
			while($i!=$res) { 
				$mailto.=$adb->query_result($req,$i,"mgroup").',';
				$mailto_sup=$adb->query_result($req,$i,"sup").',';
				$i++;
			} 
		}
		
	
	}
	else {
		$qry  = "select * from siprod_incident ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid";
		$qry .= " where incidentid=?";
		$ary_res = $adb->pquery($qry, array($return_id));
		$modeFonctionnement = $adb->query_result($ary_res,0,'modefonctionnement');
		$typeincident = $adb->query_result($ary_res,0,'typeincident');
		
		$typeIncidentInfo = getTypeIncidentInfo($typeincident);
		$typeincidentName = $typeIncidentInfo["nom"];
		$typeincidentDelais = $typeIncidentInfo["delais"];
		$floor = $adb->query_result($ary_res,0,'floor');
		$mail_data['floor'] = $floor;
		$mail_data['type'] = $typeincidentName;
		$mail_data['delais'] = $typeincidentDelais;
		
		$mail_data['modeFonctionnement'] = $modeFonctionnement;
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Incidents&record=$return_id"  ;
		$mail_data['lien'] = " Pour traiter cet incident <a href='".$link."'>cliquer ici</a> ";
		
	
		$reqString="	
			SELECT DISTINCT U.user_Email as mgroup , S.user_Email as sup
                  from     siprod_incident D, siprod_type_incidents T, vtiger_groups G, vtiger_users2group UG, users U,siprod_groupsupcoord I, users S
                  where    D.typeincident=T.typeincidentid
                  and      instr(concat(' ', T.groupid, ' '), concat(' ', G.groupid, ' ')) > 0 
                  AND      G.groupid = I.groupid
                  and      G.groupid= UG.groupid
                  and      UG.userid =U.user_id
                  AND      I.supid = S.user_id
				  and      D.incidentid= ". $return_id ; 
	

		$req1 = $adb->pquery($reqString, array());
		$res=$adb->num_rows($req1);		
		$i=0;
		$mailto='';
		$mailto_sup ='' ;
				
		if($res>0)
		{
			while($i!=$res) { 
				$mailto_i =$adb->query_result($req1,$i,"mgroup");
				if ($mailto_i != '')
					$mailto .= $mailto_i.',';
				
				$mailto_sup_i=$adb->query_result($req1,$i,"sup");
				if ($mailto_sup_i != '' && ! ereg("$mailto_sup_i","$mailto_sup") )
					$mailto_sup .= $mailto_sup_i.',';
					
				$i++;
			}
		}
		
	}
		
	$ticket = $adb->query_result($ary_res,0,'ticket');
	$statut = $adb->query_result($ary_res,0,'statut');
	$extension = $adb->query_result($ary_res,0,'extension');
	$campagne = $adb->query_result($ary_res,0,'campagne');
	$popimpactee = $adb->query_result($ary_res,0,'popimpactee');
	$filename = $adb->query_result($ary_res,0,'filename');
	$createdtime = $adb->query_result($ary_res,0,'createdtime');
	$tabcreatedtime = split(' ',$createdtime);
	$createdtime = getDisplayDate($tabcreatedtime[0])." ".$tabcreatedtime[1];
	$description = $adb->query_result($ary_res,0,'description');
	$modifiedtime = $adb->query_result($ary_res,0,'modifiedtime');
	$tabmodifiedtime = split(' ',$modifiedtime);
	$modifiedtime = getDisplayDate($tabmodifiedtime[0])." ".$tabmodifiedtime[1];

	
	$query_rp = "SELECT DISTINCT u.User_Email as rp_email
		FROM  users u
		INNER JOIN siprod_campagnerp crp ON U.user_id = crp.rpid
		INNER JOIN operations op ON   crp.campagneid = op.Op_Id
		WHERE op.Op_Id  = ?
		UNION
		SELECT DISTINCT u.User_Email as rp_email
		FROM  users u
		INNER JOIN siprod_campagnerp crp ON U.user_id = crp.rpbackupid
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
	
	$result = $adb->pquery($query_moderateur, array());
	$num_rows = $adb->num_rows($result);
	
	$result_rp = $adb->pquery($query_rp, array($idCampagne,$idCampagne));
	$num_rows_rp = $adb->num_rows($result_rp);
	
	for($i=0; $i<$num_rows; $i++) {
		$moderateur = $adb->query_result($result, $i, "group_moderateur");
		if ($moderateur != '')
			$mailto_sup .= $moderateur.',';
	}
	
	for($j=0; $j < $num_rows_rp; $j++) {
		$rp = $adb->query_result($result_rp, $j, "rp_email");
		if ($rp != '')
			$mailto_sup .= $rp.',';
	}
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
	
	$mail_data['title'] = " ";
	$mail_data['mode'] = $mode;
	$mail_data['ticket'] = $ticket;
	$mail_data['statut'] = $statut;
	$mail_data['extension'] = $extension;
	$mail_data['campagne'] = getCampagneName($campagne);
	$mail_data['popimpactee'] = $popimpactee;
	$mail_data['filename'] = $filename;
	$mail_data['createdtime'] = $createdtime;
	$mail_data['modifiedtime'] = $modifiedtime;
	$mail_data['description'] = $description;
	$mail_data['mailto'] = $mailto ;
	
	$mail_data['mailto_sup'] = $mailto_sup ;
	$mail_data['mailto'] = $mailto; 
	
	return $mail_data;

}

function getRapportNotification($desc,$currentModule)
{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	$subject="";
	
	if ($desc['mode'] == 'edit')
	{
		$subject = $mod_strings['LBL_MODIFICATION'];
	}
	else	 
	{
		$subject = $mod_strings['LBL_CREATION'];
	}

	$typ = $desc['type'];
	$statut = $desc['statut'];
	$mode = $desc['mode'];
	if ($statut == 'open' && $mode != 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'pending' && $mode != 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'transfered' && $mode != 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'traited' && $mode != 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'reopen' && $mode != 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings[$statut]);
	}
	elseif ($mode == 'relance') {
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_RELANCER"]." ".$desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].") - ".decode_html($app_strings['relance']);
	}

	
	$to_email =$desc['mailto'];
	
	$to_email_cc =$desc['mailto_sup'];
	$from = $app_strings['LBL_FROM_GID'];
	$to_email_cc_cache =$desc['mailto_top'];
	
	$description = getRapportDetailsBis($desc,$desc['user_id'],$currentModule);
	// Empecher la copie cachée 
	$to_email_cc_cache="";
	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from ,$from,decode_html($subject),$description,$to_email_cc,$to_email_cc_cache);
	
}

function getRapportDetailsBis($description,$user_id,$currentModule,$from='')
{
	        global $log,$current_user,$currentModule;
	        global $adb,$mod_strings,$app_strings;
	        $log->debug("Entering getRapportDetails(".$description.") method ...");

		if ($description['mode'] == 'edit')	 
		{
				$reply = $mod_strings['LBL_LAST_MODIFIED'].' '.$description['modifiedtime'];
		}
		else	 
		{
			$reply = $mod_strings['LBL_CREATED'].' '.$description['modifiedtime'];
		}
						
		$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
		
	    $current_username = getNomPrenomUserEdited($current_user->id);
		
		$list='
		<table cellspacing="0" cellpadding="0" border="0" width="620" style="padding: 10px;">
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
								<div style="margin-bottom: 15px; color: rgb(59, 89, 152);"><br>';
								$list .= $mod_strings['LBL_SALUTATION'].',<br>';
							    if($currentModule == 'Incidents' || $currentModule == 'SuiviIncidents'){
							   		$list .= decode_html($mod_strings['LBL_DETAILS_ICIDENT_STRING']).' '.$reply.'.<br> ';
							    }
							   	else{
									$list .= decode_html($mod_strings['LBL_DETAILS_DEMANDE_STRING']).' '.$reply.'.<br> ';
							   	}
								$list .=' 
								</div>
								<div style="margin-bottom: 15px;">
									
									<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%" style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">'; 

													$list .= '<ul>';
													 $list .= '<li><b>'.$mod_strings["ticket"].' : </b>'.$description['ticket'];
													$list .= '<li><b>'.decode_html($mod_strings["Statut"].' : </b>'.$app_strings[$description['statut']]);
													
													if($currentModule == 'Incidents'){
														$list .= '<li><b>'.decode_html($mod_strings["Typeincident"].' : </b>'.$description['type']);
														$list .= '<li><b>'.decode_html($mod_strings["ModeFonctionnement"].' : </b>'.$description['modeFonctionnement']);
														if($description['popimpactee']== "1000" )
														  $list .= '<li><b>'.decode_html($mod_strings["Population impactee"].' :</b> Tous');
														else
														  $list .= '<li><b>'.decode_html($mod_strings["Population impactee"].' : </b>'.$description['popimpactee']);
														$list .= '<li><b>'.decode_html($mod_strings["Delais"].' : </b>'.$description['delais']);
													}
													else{
														$list .= '<li><b>'.decode_html($mod_strings["Typedemande"].' : </b>'.$description['type']);
														$list .= '<li><b>'.decode_html($mod_strings["Delais"].' : </b>'.$description['delais']);														
														if($description['datelivraison'] != "")
															$list .= '<li><b>'.decode_html($mod_strings["Date Livraison Souhaitee"].' : </b>'.$description['datelivraison']);									
													}
													$list .= '</ul>
												</td>
											</tr>
										</tbody>
									</table>
									<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">&nbsp;</div>';
									
									if ($description['description'] != ""){
									$list .= '<br>
									
									<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">
										<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%"
													style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 10px;"><span
													style="font-size: 12px; color: rgb(59, 89, 152);">
													<b>Description:</b><br>'.$description['description'].'
												</td>
											</tr>
										</tbody>
									</table>
									</div>
									<br>';
									}		
								$list .= '</div>
								<div style="margin: 0pt; font-size: 12px; color: rgb(59, 89, 152); padding: 0px 0px 10px;"';
									
									$list .= '<br><b>Contact du demandeur : </b><br> 
									<br>'.decode_html($current_username) ;
									if ($description['floor'] != "")
									 $list .= '<br>'.decode_html($description['floor']);
									if ($description['extension'] != "") 
										$list .= '<br>Extension : '.$description['extension'];
									$list .= '<br>'.$description['lien'].'
								</div>
								</td>
							</tr>
						</tbody>
					</table>
					<img style="border: 0pt none; min-height: 1px; width: 1px;" alt="">
					</td>
				</tr>
				</tbody>
		</table>
		';

        $log->debug("Exiting getActivityDetails method ...");
        return correctImg($list);
}


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