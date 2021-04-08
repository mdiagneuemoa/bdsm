<?php
function getRapportMailInfo()
{
	$mail_data = Array();
	
	$mail_data['nom'] = "Rama OUEDRAOGO";
	$mail_data['email'] = "rama.ouedraogo@gmail.com";
	$mail_data['password'] = "utRfrarI";
	$mail_data['mailto'] = "mdiagne@uemoa.int";
		
	return $mail_data;

}

function getRapportNotification($desc)
{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("mail.php");
	$subject="";
	
	
	$subject ="Votre inscription à la Bourse de Soutien UEMOA";
	$to_email =$desc['mailto'];
	
	$to_email_cc ="";
	$from = "bourseonline@uemoa.int";
	$to_email_cc_cache ="";
	
	$description = getMessageInscription($desc);
	// Empecher la copie cachée 
	$to_email_cc_cache="";
	$result = send_mail('Candidat',$to_email,$from ,$from,$subject,$description,$to_email_cc,$to_email_cc_cache);
	return $result;
}

function sendNotificationInscription($mail,$canditat)
{
	
	// Objet
	$mail->Subject = 'Votre inscription à la Bourse de Soutien UEMOA';

	// Destinataire
	$mail->AddAddress($canditat['email'], $canditat['nom']);	

	$msg = getMessageInscription($canditat);
	$mail->MsgHTML($msg);
	 
	// Envoi du mail avec gestion des erreurs
	if(!$mail->Send()) {
	  echo 'Erreur : ' . $mail->ErrorInfo;
	} else {
	  echo 'Message envoyé !';
	} 
}

function sendNotificationCandidature($mail,$canditat)
{
	
	// Objet
	$mail->Subject = 'Votre candidature à la Bourse de Soutien UEMOA';

	// Destinataire
	$mail->AddAddress($canditat['email'], $canditat['nom']);	

	$msg = getMessageCandidature($canditat);
	$mail->MsgHTML($msg);
	 
	// Envoi du mail avec gestion des erreurs
	if(!$mail->Send()) {
	  echo 'Erreur : ' . $mail->ErrorInfo;
	} else {
	  echo 'Message envoyé !';
	} 
}

function getMessageInscription($candidat)
{
	
		$list='
		<table cellspacing="5" cellpadding="5" border="0" width="620" style="padding: 2px;">
			<tbody>
				
				<tr>
					<td valign="top"
						style="background-color: rgb(255, 255, 255); border-bottom: 1px solid rgb(59, 89, 152); border-left: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 15px;">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" height="100" valign="top" style="font-size: 14px;">
								<div style="margin-bottom: 15px; color: rgb(59, 89, 152);"><br>';
								$list .= 'Bonjour '.$candidat['nom'].',<br><br>';
							   	$list .='Votre inscription à la Bourse de Soutien à la recherche et à la formation de la Commission de l\'UEMOA  a été enregistrée avec succès.
									Vous devez vous connecter au portail Bourse de Soutien UEMOA via ce lien <a href="http://ouavlibre01/portailweb/bourseonline.php">ici</a> afin de compléter et valider votre candidature. <br>
									Voici vos paramètres de connexion au portail : <br>
										
								</div>
								<div style="margin-bottom: 15px;">
									
									<table cellpadding="5" style="margin-top: 5px;">
										<tbody>
											<tr valign="top">
												<td width="100%" style="font-size: 14px; color: rgb(153, 153, 153); padding: 0px 0px 10px;">
													<span style="font-size: 14px; color: rgb(59, 89, 152);">'; 

													$list .= '<ul>';
													
													
														$list .= '<li><b> Votre identifiant : </b>'.$candidat['email'];
														$list .= '<li><b>Votre mot de passe : </b>'.$candidat['password'];														
														
													$list .= '</ul>
												</td>
											</tr>
										</tbody>
									</table>
									
								<div style="margin: 0pt; font-size: 14px; color: rgb(59, 89, 152); padding: 0px 0px 10px;"';
																	
									
									$list .= '<br>Cordialement.
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

        return correctImg($list);
}

function getMessageCandidature($candidat)
{
	
		$list='
		<table cellspacing="5" cellpadding="5" border="0" width="620" style="padding: 2px;">
			<tbody>
				
				<tr>
					<td valign="top"
						style="background-color: rgb(255, 255, 255); border-bottom: 1px solid rgb(59, 89, 152); border-left: 1px solid rgb(204, 204, 204); border-right: 1px solid rgb(204, 204, 204); font-family: "lucida grande", tahoma, verdana, arial, sans-serif; padding: 15px;">
					<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" height="100" valign="top" style="font-size: 14px;">
								<div style="margin-bottom: 15px; color: rgb(59, 89, 152);"><br>';
								$list .= 'Bonjour '.$candidat['nom'].',<br><br>';
							   	$list .='Votre candidature à la Bourse de Soutien à la recherche et à la formation de la Commission de l\'UEMOA  a été enregistrée avec succès.
									Une fois la selection effectuée, la liste des candidats retenus par pays sera publiée sur le site officiel de la Commission de l\'UEMOA (www.uemoa.int), rubrique : <br>
										
								</div>
			
									
								<div style="margin: 0pt; font-size: 14px; color: rgb(59, 89, 152); padding: 0px 0px 10px;"';
																	
									
									$list .= '<br>Cordialement.
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

        return correctImg($list);
}

function correctImg($imgbalise)
{
	$imgbalise = html_entity_decode($imgbalise);
	$pattern = "|<img(.*)src=\"|U";
	preg_match( $pattern , $imgbalise  , $imgs);
	$replacement = '<img height="600" width="800" src="http://localhost';
	if($imgs != null){
		$corectHtlm = str_replace($imgs[0] , $replacement, $imgbalise);
		return $corectHtlm ;
	}
	else
		return $imgbalise;
}

?>