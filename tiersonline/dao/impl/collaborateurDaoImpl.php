<?php
require_once (PATH_DAO_INTERF."/ICollaborateurDao.php");  
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/fonctions_inc.php");
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class CollaborateurDao implements ICollaborateurDao 
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
	
 	public function ajouter($collab)
 	{
 		global $trace;
		//$db = initBase();
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		$sql = " INSERT INTO `Collaborateur` VALUES( '',";
		$sql .= "'" . $collab->nom . "' ,";
		$sql .= "'" . $collab->prenom . "' ,";
		$sql .= "'" . $collab->poste . "' ,";
		$sql .= "'" . $collab->mobile . "' )";
		
		if (!$db->Query($sql)) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}	
		$result = $db->Query($sql);
		$arr1 = $this->selectAll();
		return $arr1;
 	}  
    public function update($collab)
    {
    	$sql = " UPDATE  `Collaborateur` SET ";
		$sql .= " `COLLAB_NOM`='" . $collab->nom . "' ,";
		$sql .= " `COLLAB_PRENOM`='" . $collab->prenom . "' ,";
		$sql .= " `COLLAB_POSTE`='" . $collab->poste . "' ,";
		$sql .= " `COLLAB_MOBILE`='" . $collab->mobile . "' ,";
		if (!$db->Query($sql)) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
    }
    
    public function updateChamp($id,$champ,$valeur)
    {
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		    
    	$sql  = 'UPDATE Collaborateur';
        $sql .= ' SET ' . mysql_real_escape_string($champ) . '="';
        $sql .= mysql_real_escape_string($valeur) . '" WHERE id=' . intval($id);
		if (!$db->Query($sql)) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
    }
    public function delete($id)
    {
    	
    }
    public function selectAll()
    {
    	global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = " SELECT `COLLAB_ID` as id,`COLLAB_NOM` as nom,`COLLAB_PRENOM` as prenom,`COLLAB_POSTE` as poste,`COLLAB_MOBILE`as mobile FROM Collaborateur order  by COLLAB_NOM ";

		if (!$db->Query($sql)) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$result = $db->Query($sql);
		$arr1 = $db->FetchAllArrays($result);
		return $arr1;
    } 
    public function findCollabById($id)
    {
    	global $trace;
		//$db = initBase();
		$sql = " SELECT `COLLAB_NOM`,`COLLAB_PRENOM`,`COLLAB_POSTE`,`COLLAB_MOBILE` FROM `Collaborateur`  ";
		$sql .= " WHERE  `COLLAB_ID`  ='" . $id . "' ";
		if (!$db->query($sql)) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$session = '';
		$idCollab = '';
		if ($db->next_record()) {
			$idCollab = $db->f('COLLAB_ID');

		}
		//debug_tableau(unserialize($session));
		/*if ($session != '') {
			$tmp_session = unserialize($session);
			$_SESSION['CLIENT'] = $tmp_session['CLIENT'];
			$_SESSION['ADRESSE_FACTURATION'] = $tmp_session['ADRESSE_FACTURATION'];
			$_SESSION['PERSONNE_FACTURATION'] = $tmp_session['PERSONNE_FACTURATION'];
		}*/

		return $idCollab;
    }
    
    public function findCollab($criteria)
    {
    	global $trace;
    	//echo $criteria->nom,"-",$criteria->prenom,"-",$criteria->poste,"-",$criteria->mobile;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = " SELECT `COLLAB_NOM`,`COLLAB_PRENOM`,`COLLAB_POSTE`,`COLLAB_MOBILE` FROM Collaborateur  ";
		//$sql .= " WHERE  `CLIE_ID`  ='" . $id . "' ";
		if(!empty($criteria->nom))
		{
			$sql .= " AND  `COLLAB_NOM`  like '%" . $criteria->nom . "%' ";
		}
		if(!empty($criteria->prenom))
		{
			$sql .= " AND  `COLLAB_PRENOM`  like '%" . $criteria->prenom . "%' ";
		}
		if(!empty($criteria->poste))
		{
			$sql .= " AND  `COLLAB_POSTE`  like '%" . $criteria->poste . "%' ";
		}
		if(!empty($criteria->mobile))
		{
			$sql .= " AND  `COLLAB_MOBILE`  like '%" . $criteria->mobile . "%' ";
		}
		$sql = preg_replace('/AND/', 'WHERE', $sql, 1);
		
		if (!$db->query($sql)) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$result = $db->Query($sql);
		$arr1 = $db->FetchAllArrays($result);
		return $arr1;
		
    }
    
 }
?>
