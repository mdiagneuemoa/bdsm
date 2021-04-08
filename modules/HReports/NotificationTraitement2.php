<?php


function getRapportMailInfo($return_id,$mode,$currentModule,$currentstatus)
	{
	require_once('include/utils/CommonUtils.php');
	require_once('include/utils/utils.php');
	$mail_data = Array();
	global $adb,$app_strings;
	$emails = getEmailRecepteurByDemande($return_id);
	//print_r($emails);
	$mail_data = getInfosByDemande($return_id);
	$mail_data['statut'] = $currentstatus;
	$mail_data['mailto_directeur'] = 'mdiagne@uemoa.int';
	$mail_data['mailto_respumv'] = 'mdiagne@uemoa.int';
	$mail_data['mailto_charge'] = 'mdiagne@uemoa.int';
	$mail_data['mailto_initiateur'] = 'mdiagne@uemoa.int';
	$mail_data['mailto_dcpc'] = 'mdiagne@uemoa.int';
		
	return $mail_data;
	
	}

function getRapportNotification($desc,$currentModule)
	{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	
	
	$modulename=$mod_strings['LBL_MODULE'];
	
	$subject .=' ';
	
		
	$statut=$desc['statut'];
	
	if ($statut == 'submitted') {
		$subject = $app_strings["SUBMIT_MAIL_OBJECT"]." ".$desc['nom']."  ".$app_strings["SUBMIT_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_directeur'];
		$to_email_cc = $desc['mailto_charge'].";".$desc['mailto_initiateur'];
	}
	if ($statut == 'com_accepted') {
		$subject = $app_strings["SIGN_MAIL_OBJECT"]." ".$desc['nom']."  ".$app_strings["SIGN_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_respumv'];
		$to_email_cc = $desc['mailto_charge'].";".$desc['mailto_initiateur'];
	}
	if ($statut == 'dir_accepted') {
		$subject = $app_strings["SIGN_MAIL_OBJECT"]." ".$desc['nom']."  ".$app_strings["SIGN_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_charge'];
		$to_email_cc = $desc['mailto_initiateur'];
	}
	if ($statut == 'umv_accepted') {
		$subject = $app_strings["VISEUMV_MAIL_OBJECT"]." ".$desc['nom']."  ".$app_strings["VISEUMV_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_dcpc'];
		$to_email_cc = $desc['mailto_charge'].";".$desc['mailto_initiateur'];
	}
		if ($statut == 'authorized') {
		$subject = $app_strings["AUTHORIZE_MAIL_OBJECT"]." ".$desc['nom']."  ".$app_strings["AUTHORIZE_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_respumv'];
		$to_email_cc = $desc['mailto_charge'].";".$desc['mailto_initiateur'];
	}
	if ($statut == 'ag_cancelled' || $statut == 'dir_cancelled' || $statut == 'ch_cancelled') {
		$subject = $app_strings["CANCEL_MAIL_OBJECT"]." ".$desc['numom']."  ".$app_strings["CANCEL_MAIL_OBJECT_SUITE"]." ".$desc['nom']."  ".$app_strings["CANCEL_MAIL_OBJECT_FIN"];
		$to_email =$desc['mailto_initiateur'];
		$to_email_cc = $desc['mailto_charge'].";".$desc['mailto_respumv'];
	}
	if ($statut == 'omgenered') {
		$subject = $app_strings["OMGENERE_MAIL_OBJECT"]." ".$desc['numom']."  ".$app_strings["OMGENERE_MAIL_OBJECT_SUITE"];
		$to_email =$desc['mailto_charge'];
		$to_email_cc = $desc['mailto_initiateur'];
	}
	
	$from = $app_strings['LBL_FROM_NOMADE'];
	$description = getRapportDetails($desc,$desc['user_id'],$currentModule);
	
	$to_email_cc_cache ="";

	if ($to_email != '' && $to_email != ',,')
		send_mail('HReports',$to_email,$from,$from,decode_html($subject),$description,$to_email_cc,$to_email_cc_cache);	
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
				<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" valign="top" >
								<div style="margin-bottom: 2px;"><br>';
								
													$list .= '<ul>';
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT1"].' : </b>'.$description['nom'];
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT2"].' : </b>'.$description['ticket'];
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT3"].' : </b>'.$description['lieu'];
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT4"].' : </b>'.$description['datedebut'];
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT5"].' : </b>'.$description['datefin'];
														$list .= '<li><b>'.$app_strings["ALL_MAIL_TEXT6"].' : </b>'.$description['objet'];
													$list .= '</ul></di>';
													$list .= '<br><b>'.$app_strings["ALL_MAIL_TEXT7"].' : </b>'.decode_html($app_strings[$description['statut']]);
													if ($description['statut'] == 'ag_cancelled' ||  $description['statut'] == 'dir_cancelled' || $description['statut'] == 'ch_cancelled')
													{
														$list .= '<br><b>'.$app_strings["CORRECTION_MAIL_TEXT"].' : </b>'.$description['motif'];
													}	
													
													if ($description['statut'] == 'com_accepted')
													{
														$list .= '<br><ul>';
														$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget'];
														$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin'];
														$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget'];
														$list .= '</ul>';
														
														if($description['budget2']!='' && $description['sourcefin2']!='' && $description['codebudget2']!='')
														{
															$list .= '<br><ul>';
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget2'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin2'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget2'];
															$list .= '</ul>';
														}
														if($description['budget3']!='' && $description['sourcefin3']!='' && $description['codebudget3']!='')
														{
															$list .= '<br><ul>';
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget3'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin3'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget3'];
															$list .= '</ul>';
														}
														if($description['budget4']!='' && $description['sourcefin4']!='' && $description['codebudget4']!='')
														{
															$list .= '<br><ul>';
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget4'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin4'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget4'];
															$list .= '</ul>';
														}
														if($description['budget5']!='' && $description['sourcefin5']!='' && $description['codebudget5']!='')
														{
															$list .= '<br><ul>';
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget5'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin5'];
															$list .= '<li><b>'.$app_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget5'];
															$list .= '</ul>';
														}
													}	
												
													$list .= '<br><a href="'.$app_strings["ALL_MAIL_TEXT_LIEN_URL"].'">'.$app_strings["ALL_MAIL_TEXT_LIEN"].'</a>';

													$list .= '<br><b>'.$app_strings["ALL_MAIL_TEXT_SIGNATURE"];
													$list .= '<br><b>'.$app_strings["ALL_MAIL_TEXT_MSG"];

												$list .= '</td>
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