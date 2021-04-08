<?php

function getExchangeMailerParam()
{
	$mail = array();
	$mail['Host'] = 'mail.uemoa.int';
	$mail['SMTPAuth']   = true;
	$mail['Port'] = 25; // Par défaut
	$mail['Mailer'] = 'smtp';
	$mail['SMTPDebug'] = 2;
	// Authentification
	$mail['Username'] = "bourseonline@uemoa.int";
	$mail['Password'] = "bourse@online";
	return $mail;
}

function getGmailMailerParam()
{
	$mail = array();
	$mail['Host'] = 'ssl://smtp.gmail.com';
	$mail['SMTPAuth']   = true;
	$mail['Port'] = 465; // Par défaut
	 $mail['Mailer'] = 'smtp';
	 $mail['SMTPDebug'] = 2;
	// Authentification
	$mail['Username'] = "meissa.diagne@gmail.com";
	$mail['Password'] = "meiz77";
	return $mail;
}

function send_mail($to_mail,$to_name,$subject,$msg)
{
	require_once('modulemail/class.phpmailer.php'); 
	require_once('modulemail/class.smtp.php'); 
	$mail = new PHPMailer();

	$param = getExchangeMailerParam();
	//$param = getGmailMailerParam();
	
	$mail->Host = $param['Host'];
	$mail->SMTPAuth   = $param['SMTPAuth'];
	$mail->Port = $param['Port'];; // Par défaut
	$mail->Mailer = $param['Mailer'];
	$mail->SMTPDebug = $param['SMTPDebug'];
	// Authentification
	$mail->Username = $param['Username'];
	$mail->Password = $param['Password'];
	// Objet
	$mail->Subject = $subject;
	$mail->AddAddress($to_mail, $to_name);	
	$mail->MsgHTML($msg);
	 
	// Envoi du mail avec gestion des erreurs
	if(!$mail->Send()) {
	  $result = 'Erreur : ' . $mail->ErrorInfo.'  '.date('d-m-Y H:i:s');
	} else {
	  $result = 'Message envoyé le '.date('d-m-Y H:i:s');
	} 
	return $result;
}

function sendNotificationInscription($canditat)
{
	$subject = 'Votre inscription à la Bourse de Soutien UEMOA le '.date('d-m-Y H:i:s');
	$to_mail = $canditat['email'];
	$to_name = $canditat['nom'];
	$msg = getMessageInscription($canditat);
	$result = send_mail($to_mail,$to_name,$subject,$msg);
	echo $result;
}

function sendNotificationCandidature($mail,$canditat)
{
	
	// Objet
	$subject = 'Votre candidature à la Bourse de Soutien UEMOA le '.date('d-m-Y H:i:s');
	$to_mail = $canditat['email'];
	$to_name = $canditat['nom'];
	$msg = getMessageCandidature($canditat);
	send_mail($to_mail,$to_name,$subject,$msg);
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