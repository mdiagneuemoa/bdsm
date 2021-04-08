<?php

// GID change
function getRapportMailInfo($return_id,$mode,$currentModule)
{
	 require_once('include/utils/CommonUtils.php');
	$mail_data = Array();
	global $adb,$app_strings;
	
	if($currentModule == 'Demandes' || $currentModule == 'SuiviDemandes'){
		$qry  = "select * from siprod_demande ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_demande.demandeid";
		$qry .= " where demandeid=?";
		$ary_res = $adb->pquery($qry, array($return_id));
		$typedemande = $adb->query_result($ary_res,0,'typedemande');
		
//		$typedemandeName=getTypeDemandeName($typedemande);
		$typeDemandeInfo = getTypeDemandeInfo($typedemande);
		$typedemandeName = $typeDemandeInfo["nom"];
		$typedemandeDelais = $typeDemandeInfo["delais"];
		
		$mail_data['type'] = $typedemandeName;
		$mail_data['delais'] = $typedemandeDelais;
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Demandes&record=$return_id"  ;
		$mail_data['lien'] = " Pour traiter cette demande cliquer <a href='".$link."'>ici</a> ";
	
		// Recuperation des emails destinataires
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
		// End recuperation des emails destinataires
	
	}
	else {
		$qry  = "select * from siprod_incident ";
		$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_incident.incidentid";
		$qry .= " where incidentid=?";
		$ary_res = $adb->pquery($qry, array($return_id));
		$modeFonctionnement = $adb->query_result($ary_res,0,'modefonctionnement');
		$typeincident = $adb->query_result($ary_res,0,'typeincident');
		
//		$mail_data['type'] = getTypeIncidentName($typeincident);
		
		//		$typedemandeName=getTypeDemandeName($typedemande);
		$typeIncidentInfo = getTypeIncidentInfo($typeincident);
		$typeincidentName = $typeIncidentInfo["nom"];
		$typeincidentDelais = $typeIncidentInfo["delais"];

		$mail_data['type'] = $typeincidentName;
		$mail_data['delais'] = $typeincidentDelais;
		
		$mail_data['modeFonctionnement'] = $modeFonctionnement;
		$link= $app_strings['appli_url']."/index.php?action=DetailView&module=Incidents&record=$return_id"  ;
		$mail_data['lien'] = " Pour traiter cet incident <a href='".$link."'>cliquer ici</a> ";
		
		// Recuperation des emails destinataires
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
//					$mailto .= $adb->query_result($req1,$i,"mgroup").',';
					$mailto .= $mailto_i.',';
				
				$mailto_sup_i=$adb->query_result($req1,$i,"sup");
				if ($mailto_sup_i != '' && ! ereg("$mailto_sup_i","$mailto_sup") )
					$mailto_sup .= $mailto_sup_i.',';
					
				$i++;
			}
		}
		// End recuperation des emails destinataires
	}
		
	$ticket = $adb->query_result($ary_res,0,'ticket');
	$statut = $adb->query_result($ary_res,0,'statut');
	$extension = $adb->query_result($ary_res,0,'extension');
	$campagne = $adb->query_result($ary_res,0,'campagne');
	$popimpactee = $adb->query_result($ary_res,0,'popimpactee');
	$filename = $adb->query_result($ary_res,0,'filename');
	$createdtime = $adb->query_result($ary_res,0,'createdtime');
	$modifiedtime = $adb->query_result($ary_res,0,'modifiedtime');
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
	$mail_data['mailto'] = $mailto ;
	//Mail N+1
	$mail_data['mailto_sup'] = $mailto_sup ;
	$mail_data['mailto'] = $mailto; // Liste email des membres du groupe
	
	return $mail_data;

}

function getRapportNotification($desc,$currentModule)
{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	$subject="";
	// gestion des objet de message en fonction des statuts et des états
	if ($desc['mode'] == 'edit')
	{
		$subject = $mod_strings['LBL_MODIFICATION'];
	}
	else	 
	{
		$subject = $mod_strings['LBL_CREATION'];
	}/*
	$subject .= $desc['title'];
	$statut=$desc['statut'];
	$typ=$desc['type'];
	$subject .=' ('.$typ.') '.decode_html($app_strings[$statut]);
	*/	
	$typ = $desc['type'];
	$statut = $desc['statut'];
	$mode = $desc['mode'];
	
	if ($statut == 'open' && $mode != 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_OPEN"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'pending' && $mode != 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_PENDING"].$typ." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'transfered' && $mode != 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRANSFERED"].$typ." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'traited' && $mode != 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_TRAITED"].$typ." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($statut == 'reopen' && $mode != 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings[$statut]);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_REOPEN"].$typ." sur ".$desc['campagne']." : ".decode_html($app_strings[$statut]);
	}
	elseif ($mode == 'relance') {
//		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_RELANCER"].$typ." sur ".$desc['campagne']." (".decode_html($mod_strings["ticket"])." : ".$desc['ticket'].") : ".decode_html($app_strings['relance']);
		$subject = $app_strings["INITIAL_MAIL_OBJECT_STATUT_RELANCER"].$typ." sur ".$desc['campagne']." : ".decode_html($app_strings['relance']);
	}

	// Recuperation des destinataires
	$to_email =$desc['mailto'];
	// Recuperation du N+1
	$to_email_cc =$desc['mailto_sup'];
	$from = $app_strings['LBL_FROM_GID'];
	
	//echo $to_email_cc; break ;
	$description = getRapportDetails($desc,$desc['user_id'],$currentModule);

	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from ,$from,$subject,$description,$to_email_cc);

}

function getRapportDetails($description,$user_id,$currentModule,$from='')
{
	        global $log,$current_user,$currentModule;
	        global $adb,$mod_strings,$app_strings;
	        $log->debug("Entering getRapportDetails(".$description.") method ...");

		if ($description['mode'] == 'edit')	 
		{
				$reply = $mod_strings['LBL_LAST_MODIFIED'].' '.getDisplayDate($description['modifiedtime']);
		}
		else	 
		{
			$reply = $mod_strings['LBL_CREATED'].' '.getDisplayDate($description['modifiedtime']);
		}
						
		$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
		
//	    $current_username = getUserName($current_user->id);
	    $current_username = getNomPrenomUserEdited($current_user->id);
	    
//		$list = '<table border = 1> <tr><td style="{background-color:blue}">GIDPCCI</td><tr><td>';
	    $list = $mod_strings['LBL_SALUTATION'].',<br><br>';
	    if($currentModule == 'Incidents' || $currentModule == 'SuiviIncidents'){
	   		$list .= $mod_strings['LBL_DETAILS_ICIDENT_STRING'].' '.$reply.'.<br> ';
	    }
	   	else{
			$list .= $mod_strings['LBL_DETAILS_DEMANDE_STRING'].' '.$reply.'.<br> ';
	   	}
		$list .= '<ul>';
	    $list .= '<li>'.$mod_strings["ticket"].' : '.$description['ticket'];
		$list .= '<li>'.$mod_strings["Statut"].' : '.$app_strings[$description['statut']];
		$list .= '<li>'.$mod_strings["Extension"].' : '.$description['extension'];
		if($currentModule == 'Incidents'){
			$list .= '<li>'.$mod_strings["Typeincident"].' : '.$description['type'];
			$list .= '<li>'.$mod_strings["Delais"].' : '.$description['delais'];
			$list .= '<li>'.$mod_strings["ModeFonctionnement"].' : '.$description['modeFonctionnement'];
			$list .= '<li>'.$mod_strings["Campagne"].' : '.$description['campagne'];
			if($description['popimpactee']== "1000" )
			  $list .= '<li>'.$mod_strings["Population impactee"].' : Tous';
			else
				 $list .= '<li>'.$mod_strings["Population impactee"].' : '.$description['popimpactee'];
		}
		else{
			$list .= '<li>'.$mod_strings["Typedemande"].' : '.$description['type'];
			$list .= '<li>'.$mod_strings["Delais"].' : '.$description['delais'];
			$list .= '<li>'.$mod_strings["Campagne"].' : '.$description['campagne'];
		}
		
		
		//$list .= '<li>'.$mod_strings["Filename"].' : '.$description['filename'];
		$list .= '</ul>';
		$list .= '<br>'.$description['lien'];
	    $list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
	    $list .= '<br>'.$current_username.'.'; 

//	    $list .= '</td></tr></table>';
        $log->debug("Exiting getActivityDetails method ...");
        return $list;
	}
//GID change end


//
//function getRapportMailInfo($return_id,$mode)
//{
//	$mail_data = Array();
//	global $adb;
//	$qry = "select vtiger_hreports.*,vtiger_rapportsfolder.foldername,vtiger_potential.potentialname,vtiger_crmentity.createdtime, vtiger_crmentity.modifiedtime from vtiger_hreports";
//	$qry .= " LEFT JOIN vtiger_rapportsfolder ON vtiger_rapportsfolder.folderid = vtiger_hreports.folderid";
//	$qry .= " LEFT JOIN vtiger_potential ON vtiger_potential.potentialid = vtiger_hreports.potentialid";
//	$qry .= " LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_hreports.hreportsid";
//	$qry .="  where hreportsid=?";
//	$ary_res = $adb->pquery($qry, array($return_id));
//	
//	$title = $adb->query_result($ary_res,0,'title');
//	$filename = $adb->query_result($ary_res,0,'filename');
//	$folderid = $adb->query_result($ary_res,0,'folderid');
//	$hreportcontent = $adb->query_result($ary_res,0,'hreportcontent');
//	$publishedby = $adb->query_result($ary_res,0,'publishedby');
//	$rapportcategory = $adb->query_result($ary_res,0,'rapportcategory');
//	$potentialid = $adb->query_result($ary_res,0,'potentialid');
//	$fileversion = $adb->query_result($ary_res,0,'fileversion');
//	$rapportstatus = $adb->query_result($ary_res,0,'rapportstatus');
//	$assignedto = $adb->query_result($ary_res,0,'assignedto');
//	$foldername = $adb->query_result($ary_res,0,'foldername');
//	$potentialname = $adb->query_result($ary_res,0,'potentialname');
//	$createdtime = $adb->query_result($ary_res,0,'createdtime');
//	$tabcreatedtime = split(' ',$createdtime);
//	$createdtime = getDisplayDate($tabcreatedtime[0])." ".$tabcreatedtime[1];
//	$modifiedtime = $adb->query_result($ary_res,0,'modifiedtime');
//	$tabmodifiedtime = split(' ',$modifiedtime);
//	$modifiedtime = getDisplayDate($tabmodifiedtime[0])." ".$tabmodifiedtime[1];
//	
//	$mailuser=getUserEmailByUsername($assignedto);
//	/*$nomPrenom = explode(' ', $assignedto, 2);
//	$res = $adb->pquery("select email1 from vtiger_users where last_name =? and first_name=?",array($nomPrenom[0],$nomPrenom[1]));
//	$mailuser=$adb->query_result($res,0,'email1');*/
//	
//	$mail_data['mode'] = $mode;
//	$mail_data['user_id'] = $assignedto;
//	$mail_data['title'] = $title;
//	$mail_data['localisation'] = $foldername;
//	$mail_data['description'] = $hreportcontent;
//	$mail_data['publishedby'] = $publishedby;
//	$mail_data['rapportcategory'] = $rapportcategory;
//	$mail_data['fileversion'] = $fileversion;
//	$mail_data['rapportstatus'] = $rapportstatus;
//	$mail_data['potentialname'] = $potentialname;
//	$mail_data['createdtime'] = $createdtime;
//	$mail_data['modifiedtime'] = $modifiedtime;
//	$mail_data['mailto'] = $mailuser;
//	
//	return $mail_data;
//
//
//}
//
//function getRapportNotification($desc)
//{
//	global $current_user,$adb,$mod_strings;
//	require_once("modules/Emails/mail.php");
//	$subject="";
//	// gestion des objet de message en fonction des statuts et des états
//    
//	if ($desc['mode'] == 'edit')
//	{
//			//modification de rapport
//			$subject = $mod_strings['LBL_MODIFICATION'];
//	}
//	else	 
//	{
//		// creation de rapport
//		$subject = $mod_strings['LBL_CREATION'];
//	}
//	$subject .=' : '.$desc['title'];
//	$crmentity = new CRMEntity();
//	$to_email =$desc['mailto'];
//	//$to_email = "mediagne@pcci.sn";
//	$description = getRapportDetails($desc,$desc['user_id']);
//	send_mail('HReports',$to_email,$current_user->user_name,'',$subject,$description);
//	
//	
//}
//
//function getRapportDetails($description,$user_id,$from='')
//{
//	        global $log,$current_user;
//	        global $adb,$mod_strings;
//	        $log->debug("Entering getRapportDetails(".$description.") method ...");
//
//		
//		if ($description['mode'] == 'edit')	 
//		{
//			/*
//			if($description['rapportstatus']=='En cours de validation' || $description['rapportstatus']=='Final')
//			{
//				//validation de rapport
//				$reply = $mod_strings['LBL_VALIDATED'].' '.$description['modifiedtime'];
//			}else
//			{*/
//				//modification de rapport
//				$reply = $mod_strings['LBL_LAST_MODIFIED'].' '.$description['modifiedtime'];
//			//}		
//		}
//		else	 
//		{
//			// creation de rapport
//			$reply = $mod_strings['LBL_CREATED'].' '.$description['createdtime'];
//		}
//				
//		//$name = getUserName($user_id);
//		
//		$msg = getTranslatedString($mod_strings['LBL_RAPPORT_NOTIFICATION']);
//
//	        $current_username = getUserName($current_user->id);
//
//	    $list = $mod_strings['LBL_SALUTATION'].',';
//		$list .= '<br><br>'.$msg;
//		$list .= ' ,'.$reply.'.<br> ';
//		$list .= $mod_strings['LBL_DETAILS_STRING'].'<br>';
//	    $list .= '<ul><li>'.$mod_strings["Title"].' : '.$description['title'];
//		$list .= '<li>'.$mod_strings["fileversion"].' : '.$description['fileversion'];
//		$list .= '<li>'.$mod_strings["LBL_LOCALISATION"].' : '.$description['localisation'];
//		$list .= '<li>'.$mod_strings["LBL_DESCRIPTION"].' : '.$description['description'];
//		$list .= '<li>'.$mod_strings["published By"].' : '.$description['publishedby'];
//		$list .= '<li>'.$mod_strings["Rapport Category"].' : '.$description['rapportcategory'];
//		$list .= '<li>'.$mod_strings["status"].' : '.$description['rapportstatus'];
//	    $list .= '<li>'.$mod_strings["LBL_DOSSIER_CLIENT"].' : '.$description['potentialname'];
//		 $list .= '</ul>';
//	    $list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
//	    $list .= '<br>'.$current_username.'.';
//
//	        $log->debug("Exiting getActivityDetails method ...");
//	        return $list;
//	}

?>