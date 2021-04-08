<?php
require_once (PATH_DAO_INTERF."/IAbonneDao.php");  
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class AbonneDao implements IAbonneDao 
 {   
 	  private $db;	
 	  public function __construct() {
 	  	
 	  // the following code will make it so that the class directory is in your include_path // this allows the __autoload function to work.
	/*	$cur = ini_get("include_path");
		$cur .= PATH_SEPARATOR.dirname(__FILE__).'\\dao\\';;
		ini_set("include_path", $cur);*/
		// this will load any classes that are not found and are located in the // /include/class/ folder.
		//$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		//$db->Open();
		    }
 	/*
	function __autoload($class) {
			include($class . '.php');
			// Check to see it the include defined the class 
			if ( !class_exists($class, false) ) {
				trigger_error("Unable to load class $class", E_USER_ERROR);  
			}
	}*/

	
		
	
    public function selectAbonneById($numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT categorie,civilite,nom,prenom,adresse,mobile,numerortc,email,consignes,reponses,autresconsignes
				FROM paof_clients WHERE numeroclient='".$numeroclient."' ";
		$result = $db->Query($sql);
		//echo $sql;
		if (!$result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$abonne = $db->FetchAllArrays($result);
		return $abonne[0];
	} 
	
    
 }
?>
