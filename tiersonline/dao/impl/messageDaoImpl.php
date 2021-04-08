<?php
require_once (PATH_DAO_INTERF."/IMessageDao.php");  
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class MessageDao implements IMessageDao 
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
	 	
    public function updateChampMessage($id,$champ,$valeur)
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
    
    
    public function deleteMessage($ids)
    {
    	
    }
	
		
	public function selectMessageByAbonne($numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT id messageid, DATE_FORMAT(dateappel,'%d-%m-%Y %h:%i:%s') AS dateappel,
				CASE WHEN objet='MSG' THEN 'newmail.gif' WHEN objet = 'RV' THEN 'calendar.gif' ELSE '' END icone,urgent,
				concat(LEFT(message,80),'.......') message,
				CASE WHEN numeroappelant='221000000000' OR numeroappelant='Anonymous' THEN 'Inconnu' ELSE numeroappelant END numeroappelant,
				coalesce(CONCAT(c.prenom,' ',c.nom),'') nomcontact,
				statutmessage,folderid, numerotelappelant,numtelclient 
				FROM paccueil.interf_messages m
				LEFT JOIN paof_contacts c ON numerotel=numeroappelant and c.numeroclient= m.numeroclient
				where m.numeroclient ='".$numeroclient."'";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$messages = $db->FetchAllArrays($result);
		return $messages;
	
	}
    public function selectMessageDAyByAbonne($numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT id messageid, DATE_FORMAT(dateappel,'%d-%m-%Y %h:%i:%s') AS dateappel,
				CASE WHEN objet='MSG' THEN 'newmail.gif' WHEN objet = 'RV' THEN 'calendar.gif' ELSE '' END icone,urgent,
				LEFT(message,100) message,
				CASE WHEN numeroappelant='221000000000' OR numeroappelant='Anonymous' THEN 'Inconnu' ELSE numeroappelant END numeroappelant,
				coalesce(CONCAT(c.prenom,' ',c.nom),'') nomcontact,
				statutmessage,folderid, numerotelappelant,numtelclient 
				FROM paccueil.interf_messages m
				LEFT JOIN paof_contacts c ON numerotel=numeroappelant and c.numeroclient= m.numeroclient
				where m.numeroclient ='".$numeroclient."'";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$messages = $db->FetchAllArrays($result);
		return $messages;
	} 
    public function selectMessageByForder($numeroclient,$folderid)
	{
	
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT id messageid, DATE_FORMAT(dateappel,'%d-%m-%Y %h:%i:%s') AS dateappel,
				CASE WHEN objet='MSG' THEN 'newmail.gif' WHEN objet = 'RV' THEN 'calendar.gif' ELSE '' END icone,urgent,
				LEFT(message,100) message,
				CASE WHEN numeroappelant='221000000000' OR numeroappelant='Anonymous' THEN 'Inconnu' ELSE numeroappelant END numeroappelant,
				coalesce(CONCAT(c.prenom,' ',c.nom),'') nomcontact,
				statutmessage,folderid, numerotelappelant,numtelclient 
				FROM paccueil.interf_messages m
				LEFT JOIN paof_contacts c ON numerotel=numeroappelant and c.numeroclient= m.numeroclient
				where m.numeroclient ='".$numeroclient."'  
				and folderid='".$folderid."' ";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$messages = $db->FetchAllArrays($result);
		return $messages;
	
	}	
    public function selectFolderByAbonne($numeroclient,$messages)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "select fm.folderid,fm.foldername from interf_msgfolder fm
				where fm.numeroclient ='".$numeroclient."' OR folderid IN (1,2,3) order by folderid,foldername";
	/*		
		$sql = "SELECT COUNT(m.folderid) nb,mf.folderid,mf.`foldername`
		FROM `interf_msgfolder` mf
		LEFT JOIN interf_messages m ON m.folderid=mf.folderid
		WHERE mf.numeroclient='".$numeroclient."' OR mf.folderid IN (1,2,3)
		GROUP BY mf.folderid";	
*/		
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$folders = $db->FetchAllArrays($result);
		foreach ($folders as $key => $folder) 
		{
			$fold = array();
			$fold['foldername'] = $folder['foldername'];
			$fold['folderid'] = $folder['folderid'];
			$fold['nb']=0;
			foreach ($messages as $message) 
			{
				if ($folder['folderid']==$message['folderid']) 
				{	
					$fold['nb']++;
				}	
			}	
			$folders2[$key]=$fold;
		}
		return $folders2;
	}	
    public function findMessageById($idmessage)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT id messageid, DATE_FORMAT(dateappel,'%d-%m-%Y %h:%i:%s') AS dateappel,
				CASE WHEN objet='MSG' THEN 'newmail.gif' WHEN objet = 'RV' THEN 'calendar.gif' ELSE '' END icone,message,urgent,
				CASE WHEN numeroappelant='221000000000' OR numeroappelant='Anonymous' THEN 'Inconnu' ELSE numeroappelant END numeroappelant,
				coalesce(CONCAT(c.prenom,' ',c.nom),'') nomcontact,
				statutmessage,folderid, numerotelappelant,numtelclient 
				FROM paccueil.interf_messages m
				LEFT JOIN paof_contacts c ON numerotel=numeroappelant and c.numeroclient= m.numeroclient
				where m.id ='".$idmessage."'";
				
		//echo $sql;		
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$message = $db->FetchAllArrays($result);
		return $message;
	}
    public function findMessage($criteria)
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
