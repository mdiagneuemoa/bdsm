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
// Construction de l'ent�te
//----------------------------------
// On choisi g�n�ralement de construire une fronti�re g�n�r�e aleatoirement
// comme suit. (le document pourra ainsi etre attache dans un autre mail
// dans le cas d'un transfert par exemple)
$boundary = "-----=".md5(uniqid(rand()));

// Ici, on construit un ent�te contenant les informations
// minimales requises.
//	Version du format MIME utilis�
$header = "MIME-Version: 1.0\r\n";
//	Type de contenu. Ici plusieurs parties de type different "multipart/mixed"
//	Avec un fronti�re d�finie par $boundary
$header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
$header .= "\r\n";

//--------------------------------------------------
// Construction du message proprement dit
//--------------------------------------------------

// Pour le cas, o� le logiciel de mail du destinataire
// n'est pas capable de lire le format MIME de cette version
// Il est de bon ton de l'en informer
// REM: Ce message n'appara�t pas pour les logiciels sachant lire ce format
$msg = "Je vous informe que ceci est un message au format MIME 1.0 multipart/mixed.\r\n";

//---------------------------------
// 1�re partie du message
// Le texte
//---------------------------------
// Chaque partie du message est s�par� par une fronti�re
$msg .= "--$boundary\r\n";

// Et pour chaque partie on en indique le type
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
// Et comment il sera cod�
$msg .= "Content-Transfer-Encoding:8bit\r\n";
// Il est indispensable d'introduire une ligne vide entre l'ent�te et le texte
$msg .= "\r\n";
// Enfin, on peut �crire le texte de la 1�re partie
$msg .= "Ceci est un mail avec un fichier joint\r\n";
$msg .= "\r\n";

//---------------------------------
// 2nde partie du message
// Le fichier
//---------------------------------
// Tout d'abord lire le contenu du fichier
$file = "C:\Athlete.jpg";
$fp = fopen($file, "rb");   // b c'est pour les windowsiens
$attachment = fread($fp, filesize($file));
fclose($fp);

// puis convertir le contenu du fichier en une cha�ne de caract�re
// certe totalement illisible mais sans caract�res exotiques
// et avec des retours � la ligne tout les 76 caract�res
// pour �tre conforme au format RFC 2045
$attachment = chunk_split(base64_encode($attachment));

// Ne pas oublier que chaque partie du message est s�par� par une fronti�re
$msg .= "--$boundary\r\n";
// Et pour chaque partie on en indique le type
$msg .= "Content-Type: image/jpg; name=\"$file\"\r\n";
// Et comment il sera cod�
$msg .= "Content-Transfer-Encoding: base64\r\n";
// Petit plus pour les fichiers joints
// Il est possible de demander � ce que le fichier
// soit si possible affich� dans le corps du mail
$msg .= "Content-Disposition: inline; filename=\"$file\"\r\n";
// Il est indispensable d'introduire une ligne vide entre l'ent�te et le texte
$msg .= "\r\n";
// C'est ici que l'on ins�re le code du fichier lu
$msg .= $attachment . "\r\n";
$msg .= "\r\n\r\n";

// voil�, on indique la fin par une nouvelle fronti�re
$msg .= "--$boundary--\r\n";

$destinataire = "mndiouf@pcci.sn";
$expediteur   = "mndiouf@pcci.sn";
$reponse      = $expediteur;
echo "Ce script envoie un mail avec fichier attach� � $expediteur";
mail($destinataire, "test avec fichier attach�", $msg,
     "Reply-to: $reponse\r\nFrom: $expediteur\r\n".$header);
     

?>
</body>
</html>
