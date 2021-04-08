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
		
	$mail_data['title']       = " ";
	$mail_data['mode']        = $mode;
	$mail_data['ticket']      = $ticket;
	$mail_data['statut']      = $statut;
	$mail_data['extension']   = $extension;
	$mail_data['campagne']    = getCampagneName($campagne);
	$mail_data['popimpactee'] = $popimpactee;
	$mail_data['filename']    = $filename;
	$mail_data['createdtime'] = $createdtime;
	$mail_data['modifiedtime']= $modifiedtime;
	$mail_data['description'] = $description;
	
	return $mail_data;

}

function getRapportNotification($desc,$currentModule,$email_i)
{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mailbis.php");
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
	
	$subject = "D&eacute;passement du d&eacute;lai de traitement | ";

	$subject .= $desc['campagne']." : ".$typ." (du ".$desc['modifiedtime'].")";
	
	$from = $app_strings['LBL_FROM_GID'];
	
	$description = getRapportDetailsBis($desc,$desc['user_id'],$currentModule);
	
	if ($email_i != '' && $email_i != ',,'){
		send_mail('HReports',$email_i,$from ,$from,decode_html($subject),$description,"asarre@pcci.sn,bmbacke@pcci.sn","smgning@pcci.sn");
		//send_mail('HReports',"mndiouf@pcci.sn",$from ,$from,decode_html($subject),$description,"","");
	}
	//echo $description;
}

function getRapportDetailsBis($description,$user_id,$currentModule,$from='')
{
	        global $log,$current_user;
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
								<div style="margin-bottom: 5px; margin: 5pt; color: rgb(59, 89, 152);">';
								$list .= 'Bonjour,<br><br>';
							    if($currentModule == 'Incidents' || $currentModule == 'SuiviIncidents'){
							   		$list .= '<span style="color: #4169E1; font-weight: bold;">'.decode_html('L&acute;incident N&ordm; '.$description['ticket'].' du '.$reply.' assign&eacute; &agrave; votre groupe n&acute;est toujours pas trait&eacute;</span><br> ');
							    }
							   	else{
									$list .= decode_html('LBL_DETAILS_DEMANDE_STRING').' '.$reply.'.<br> ';
							   	}
								$list .=' 
								</div>
								<div style="margin: 5pt;">
									
									<table cellpadding="0" style="margin-top: 1px;">
										<tbody>
											<tr valign="top">
												<td width="100%" style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 5px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">'; 

													$list .= '<ul>';
													 $list .= '<li><b>Ticket : </b>'.$description['ticket'];
													$list .= '<li><b>'.decode_html('Statut : </b>'.$app_strings[$description['statut']]);
													
													if($currentModule == 'Incidents'){
														$list .= '<li><b>'.decode_html('Typeincident : </b>'.$description['type']);
														$list .= '<li><b>'.decode_html('ModeFonctionnement : </b>'.$description['modeFonctionnement']);
														if($description['popimpactee']== "1000" )
														  $list .= '<li><b>'.decode_html('Population impactee :</b> Tous');
														else
														  $list .= '<li><b>'.decode_html('Population impactee : </b>'.$description['popimpactee']);
														$list .= '<li><b>'.decode_html('Delais : </b>'.$description['delais']);
													}
													else{
														$list .= '<li><b>'.decode_html('Typedemande : </b>'.$description['type']);
														$list .= '<li><b>'.decode_html('Delais  : </b>'.$description['delais']);														
														if($description['datelivraison'] != "")
															$list .= '<li><b>'.decode_html('Date Livraison Souhaitee : </b>'.$description['datelivraison']);									
													}
													$list .= '</ul>
												</td>
											</tr>
										</tbody>
									</table>
									<div style="border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">&nbsp;</div>';
									
									if ($description['description'] != ""){
									$list .= '
									
									<div style="margin: 0pt; border-bottom: 1px solid rgb(204, 204, 204); line-height: 5px;">
										<table cellpadding="0" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%"
													style="font-size: 12px; color: rgb(153, 153, 153); padding: 0px 0px 5px;">
													<span style="font-size: 12px; color: rgb(59, 89, 152);">
													<b>Description:</b><br>'.$description['description'].'</span>
												</td>
											</tr>
										</tbody>
									</table>
									</div>
									';
									}		
								$list .= '</div>
								<div style="margin: 5pt; font-size: 12px; color: rgb(59, 89, 152); padding: 0px 0px 5px;">';
									
									$list .= decode_html('<b>Contact du d&eacute;clarant').' : </b>
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