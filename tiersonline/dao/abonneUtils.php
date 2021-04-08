
 <?php
 
require_once ("C:/wamp/www/mon-assistant-en-ligne1/config/config_inc.php");
require_once (PATH_BEANS."/Abonne.php");
require_once (PATH_DAO_IMPL."/abonneDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$abonnedao = new AbonneDao();

if ($_REQUEST["action"]==getCategories)
{
	$abonne = $abonnedao->selectAbonneById($numeroclient);
	
	echo $abonne;
}

//print_r($messages);
?> 		
