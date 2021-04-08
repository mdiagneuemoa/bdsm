<?php

/*********************************************
* Variables globales de l'application        *
*********************************************/

	define("PATH_PROJET","C:/wamp/www/mon-assistant-en-ligne");
	

	define('PATH_PHP',PATH_PROJET.'/www');
	define('PATH_TEMPLATE',PATH_PROJET.'/templates');
	define('PATH_INC',PATH_PROJET.'/inc');
	define('PATH_TRACE',PATH_PROJET.'/erreur');
	define('PATH_BEANS',PATH_PROJET.'/beans');
	define('PATH_CONFIG',PATH_PROJET.'/config');
	define('PATH_DAO_INTERF',PATH_PROJET.'/dao/interfaces');
	define('PATH_DAO',PATH_PROJET.'/dao');
	define('PATH_DAO_IMPL',PATH_PROJET.'/dao/impl');
	define('SMARTY_DIR','C:/wamp/www/Smarty-2.6.19/libs/');
	

/*********************************************
* Constantes			             *
*********************************************/

	define('TRACE',true);

	//BS - Format de date 11/09/2006
	define('FORMAT_DATE_EXPORT',"d/m/Y");

/*********************************************
* Variables de la Base de Données            *
*********************************************/

	 define('DB_HOST','localhost');
	// define('DB_HOST','10.3.4.12');
	define('DB_DATABASE','paccueil');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	


	// Timeout pour 5 min d'inactivite
	global $session_timeout;
	$session_timeout=600;
	
?>
