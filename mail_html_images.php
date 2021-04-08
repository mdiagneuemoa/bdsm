<html>
<body>
<?php
require_once('config.inc.php');
require('cron/send_mail.php');
require_once('config.php');
require_once('include/utils/utils.php');
require_once('include/language/fr_fr.lang.php');

global $app_strings;
// Email Setup
$emailresult 	= $adb->pquery("SELECT email1 from vtiger_users", array());
$emailid 		= $adb->fetch_array($emailresult);
$emailaddress 	= $emailid[0];

$mailserveresult = $adb->pquery("SELECT server,server_username,server_password,smtp_auth FROM vtiger_systems where server_type = ?", array('email'));
$mailrow 		 = $adb->fetch_array($mailserveresult);
$mailserver 	 = $mailrow[0];
$mailuname 	 	 = $mailrow[1];
$mailpwd 		 = $mailrow[2];
$smtp_auth 		 = $mailrow[3];

//----------------------------------
// Construction de l'entête
//----------------------------------
$delimiteur = "-----=".md5(uniqid(rand()));

$entete = "MIME-Version: 1.0\r\n";
$entete .= "Content-Type: multipart/related; boundary=\"$delimiteur\"\r\n";
$entete .= "\r\n";

//--------------------------------------------------
// Construction du message proprement dit
//--------------------------------------------------

$msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";

//---------------------------------
// 1ère partie du message
// Le code HTML
//---------------------------------
$msg .= "--$delimiteur\r\n";
$msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
$msg .= "Content-Transfer-Encoding:8bit\r\n";
$msg .= "\r\n";
$msg .= "<html><body><h1>Email HTML avec 2 images</h1>";
$msg .= "Image 1:<img src=\"cid:image1\"><br />";
$msg .= "Image 2:<img src=\"cid:image2\"><br /></body></html>\r\n";
$msg .= "\r\n";

//---------------------------------
// 2nde partie du message
// Le 1er fichier (inline)
//---------------------------------
$fichier = "Athlete.jpg";
$fp      = fopen($fichier, "rb");
$fichierattache = fread($fp, filesize($fichier));
fclose($fp);
$fichierattache = chunk_split(base64_encode($fichierattache));

$msg .= "--$delimiteur\r\n";
$msg .= "Content-Type: application/octet-stream; name=\"$fichier\"\r\n";
$msg .= "Content-Transfer-Encoding: base64\r\n";
$msg .= "Content-ID: <image1>\r\n";
$msg .= "\r\n";
$msg .= $fichierattache . "\r\n";
$msg .= "\r\n\r\n";

//---------------------------------------------------------------------------
// 3ème partie du message
// Le 2ème fichier (attachment)
//---------------------------------------------------------------------------
$fichier1 = "Athlete.jpg";
$fp1      = fopen($fichier1, "rb");
$fichierattache1 = fread($fp1, filesize($fichier1));
fclose($fp1);
$fichierattache1 = chunk_split(base64_encode($fichierattache1));

$msg .= "--$delimiteur\r\n";
$msg .= "Content-Type: application/octet-stream; name=\"$fichier1\"\r\n";
$msg .= "Content-Transfer-Encoding: base64\r\n";
$msg .= "Content-ID: <image2>\r\n";
$msg .= "\r\n";
$msg .= $fichierattache1 . "\r\n";
$msg .= "\r\n\r\n";

$msg .= "--$delimiteur\r\n";

$destinataire = "mndiouf@pcci.sn";
$expediteur   = "mndiouf@pcci.sn";
$reponse      = $expediteur;
echo "Ce script envoie un mail au format HTML avec 2 images à $destinataire";
mail($destinataire,
     "Email HTML avec 2 images",
     $msg,
     "Reply-to: $reponse\r\nFrom: $expediteur\r\n".$entete);

$add	=array("mndiouf@pcci.sn");
$addCC =array("mndiouf@pcci.sn","mndiouf@pcci.sn");
sendmail($add,'reportgidpcci@pcci.sn',$subject,$msg,$mailserver,$mailuname,$mailpwd,"",$smtp_auth,$addCC,"Reply-to: $reponse\r\nFrom: $expediteur\r\n".$entete);

?>
</body>
</html> 
