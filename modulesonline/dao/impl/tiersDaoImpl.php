<?php
require_once (PATH_DAO_INTERF."/ITiersDao.php");  
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");
/*
 * Created on 6 mai 08
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class TiersDao implements ITiersDao 
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
	 	
    public function updateChampTiers($id,$champ,$valeur)
    {
    	$sql = " UPDATE  `Collaborateur` SET ";
		$sql .= " `COLLAB_NOM`='" . $collab->nom . "' ,";
		$sql .= " `COLLAB_PRENOM`='" . $collab->prenom . "' ,";
		$sql .= " `COLLAB_POSTE`='" . $collab->poste . "' ,";
		$sql .= " `COLLAB_MOBILE`='" . $collab->mobile . "' ,";
		if (!$db->Query($sql)) {

			$trace->Trace_Err("requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
    }
    
    
    public function deleteTiers($ids)
    {
    	
    }
	
		
	
    public function selectTiersByAbonne($numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT contactid,CONCAT(prenom,' ',nom) AS nom,email,numerotel,adressedomicile adresse,cc.libelle catlib,c.categorie
				FROM paof_contacts c
				LEFT JOIN `paof_contactcategorie` cc ON cc.id=c.categorie
				where c.numeroclient='".$numeroclient."' ";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$contacts = $db->FetchAllArrays($result);
		return $contacts;
	} 
	
	
	 public function selectTiersByEmail($email)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT tiersid,identifiant,nom,prenom,raisonsociale,initiales,identificationfiscale,matricule,adresse,ville,boitepostale,pays,
			telephonefixe,fax,portable,email,email2,nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,
			clerib1,devisecompte1,codeswift1,ribfile,nombanque2,paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,
			clerib2,devisecompte2,codeswift2,ribfile2,matriculefile 
		        FROM tiers_informations WHERE email='".$email."' ";
		//echo $sql;
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$tiers = $db->FetchAllArrays($result);
		return $tiers[0];
	}
	
	public function getRibfile($field,$tierid)
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		switch($field)
		{
			case 'ribfile' : $path='RIB1';
			case 'ribfile2' : $path='RIB2';
			case 'ribfile3' : $path='RIB3';
			case 'matriculefile' : $path='MATRICULE';
			case 'attestationfiscalefile' : $path='ATTESTFISCALE';
			default : $path='';
		}
		$sql = "SELECT NAME as filename FROM tiers_files f,tiers_filerel fr WHERE f.fileid=fr.fileid   AND path LIKE '%$path%' AND fr.tiersid ='".$tierid."' ";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$nb = $db->FetchAllArrays($result);
		return $nb[0]['filename'];
	}
	 public function selectTiersByMatricule($matricule)
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT tiersid,identifiant,nom,prenom,raisonsociale,initiales,identificationfiscale,datenaissance,matricule,adresse,complementadresse,ville,boitepostale,pays,
			telephonefixe,fax,portable,email,email2,nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,
			clerib1,devisecompte1,codeswift1,nombanque2,paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,
			clerib2,devisecompte2,codeswift2,matriculefile 
		        FROM tiers_informations WHERE matricule='".$matricule."' ";
		//echo $sql;
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$row = $db->FetchAllArrays($result);
		$tiers = $row[0];
		if ($tiers['numerocompte1']!='') $tiers['ribfile']=$this->getRibfile('ribfile',$tiers['tiersid']);
		if ($tiers['numerocompte2']!='') $tiers['ribfile2']=$this->getRibfile('ribfile2',$tiers['tiersid']);
		if ($tiers['numerocompte3']!='') $tiers['ribfile3']=$this->getRibfile('ribfile3',$tiers['tiersid']);
		$tiers['matriculefile']=$this->getRibfile('matriculefile',$tiers['tiersid']);
		$tiers['attestationfiscalefile']=$this->getRibfile('attestationfiscalefile',$tiers['tiersid']);
		//echo "getRibfile=".$this->getRibfile('ribfile',$tiers['tiersid']);
		return $tiers;
	}
	
	
	public function selectTiersByIdentFiscale($identfiscale)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT tiersid,identifiant,nom,raisonsociale,initiales,identificationfiscale,datenaissance,matricule,adresse,complementadresse,ville,boitepostale,pays,
			telephonefixe,fax,portable,email,email2,siteinternet,repnom,reptitre,repportable,replignedirect,personnalitejuridique,formejuridique,typeactivite1,typeactivite2,typeactivite3,
			nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,
			clerib1,devisecompte1,codeswift1,ribfile,nombanque2,paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,
			clerib2,devisecompte2,codeswift2,ribfile2,nombanque3,paysbanque3,codebanque3,nomagence3,codeguichet3,libellecompte3,numerocompte3,
			clerib3,devisecompte3,codeswift3,ribfile3,matriculefile 
		        FROM tiers_informations WHERE identificationfiscale='".$identfiscale."' ";
		//echo $sql;
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$tiers = $db->FetchAllArrays($result);
		return $tiers[0];
	}
	public function verifExistMatricule($matricule)
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT count(*) nbmat FROM tiers_informations WHERE matricule='".$matricule."' ";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$nb = $db->FetchAllArrays($result);
		return $nb[0]['nbmat'];
	}
	
	public function verifExistIdentFiscale($identfiscale)
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT count(*) nbmat FROM tiers_informations WHERE REPLACE(identificationfiscale, ' ', '')=REPLACE('".$identfiscale."' , ' ', '')";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$nb = $db->FetchAllArrays($result);
		return $nb[0]['nbmat'];
	}
	
	public function verifExistRaisonSociale($raisonsociale)
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT count(*) nbmat FROM tiers_informations WHERE nom like '%".$raisonsociale."%' ";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$nb = $db->FetchAllArrays($result);
		return $nb[0]['nbmat'];
	}
	
	public function selectTiersByRaisonSociale($raisonsociale)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT tiersid,identifiant,nom,raisonsociale,initiales,identificationfiscale,datenaissance,matricule,adresse,complementadresse,ville,boitepostale,pays,
			telephonefixe,fax,portable,email,email2,siteinternet,repnom,reptitre,repportable,replignedirect,personnalitejuridique,formejuridique,typeactivite1,typeactivite2,typeactivite3,
			nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,
			clerib1,devisecompte1,codeswift1,ribfile,nombanque2,paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,
			clerib2,devisecompte2,codeswift2,ribfile2,nombanque3,paysbanque3,codebanque3,nomagence3,codeguichet3,libellecompte3,numerocompte3,
			clerib3,devisecompte3,codeswift3,ribfile3,matriculefile 
		        FROM tiers_informations WHERE nom like '%".$raisonsociale."%' ";
		//echo $sql;
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$tiers = $db->FetchAllArrays($result);
		return $tiers[0];
	}
	
	
	
	    public function saveTiers($tiers)
	   {
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//print_r($tiers);
		$tiers['identifiant']=$this->getNextIdentifiant();
		$nexttiersid=$this->getNextTiersId();
		
		$sql = " INSERT INTO tiers_informations(tiersid,identifiant,nom,prenom,identificationfiscale,datenaissance,matricule,adresse,complementadresse,ville,boitepostale,pays,telephonefixe,";
		$sql .="portable,email,email2,nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,clerib1,";
		$sql .="devisecompte1,codeswift1,ribfile,nombanque2,paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,";
		$sql .="clerib2,devisecompte2,codeswift2,ribfile2,attestationfiscalefile)";

		$sql .=" VALUES('".$nexttiersid."','".$tiers['identifiant']."','".$tiers['nom']."','".$tiers['prenom']."','".$tiers['identificationfiscale']."','".$tiers['datenaissance']."',";
		$sql .="'".$tiers['matricule']."','".$tiers['adresse']."','".$tiers['complementadresse']."','".$tiers['ville']."','".$tiers['boitepostale']."','".$tiers['pays']."','".$tiers['telephonefixe']."',";
		$sql .="'".$tiers['portable']."','".$tiers['email']."','".$tiers['email2']."',";
		$sql .="'".$tiers['nombanque1']."','".$tiers['paysbanque1']."','".$tiers['codebanque1']."','".$tiers['nomagence1']."','".$tiers['codeguichet1']."',";
		$sql .="'".$tiers['libellecompte1']."','".$tiers['numerocompte1']."','".$tiers['clerib1']."',";
		$sql .="'".$tiers['devisecompte1']."','".$tiers['codeswift1']."','".$tiers['ribfile']."','".$tiers['nombanque2']."','".$tiers['paysbanque2']."','".$tiers['codebanque2']."','".$tiers['nomagence2']."','".$tiers['codeguichet2']."',";
		$sql .="'".$tiers['libellecompte2']."','".$tiers['numerocompte2']."','".$tiers['clerib2']."','".$tiers['devisecompte2']."','".$tiers['codeswift2']."','".$tiers['ribfile2']."','".$tiers['attestationfiscalefile']."');";

		//echo $sql;
		if (!$db->Query($sql)) {

			//$trace->Trace_Err("requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			echo "requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]";
		}
		else
		{
			$tiersid = $nexttiersid;
			$query = "insert into vtiger_crmentity(crmid,setype,createdtime,modifiedtime) values('".$tiersid."','Tiers','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
			$db->Query($query);
			$upload1 = $this->uploadFile('ribfile','/uploads/RIB1/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,false);
			if($tiers['numerocompte2']!='')
				$upload2 = $this->uploadFile('ribfile2','/uploads/RIB2/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,false);
			$upload3 = $this->uploadFile('matriculefile','/uploads/MATRICULE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,false);
		}
		
		return $upload1;
	   }
	   
	    public function updateTiers($tiers)
	   {
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		$matricule=$tiers['matricule'];
		//print_r($tiers);
		$sql = " UPDATE  tiers_informations SET ";
		$sql .="  identifiant ='".$tiers['identifiant']."',nom ='".$tiers['nom']."',prenom ='".$tiers['prenom']."',identificationfiscale ='".$tiers['identificationfiscale']."',";
		$sql .="matricule ='".$tiers['matricule']."',adresse ='".$tiers['adresse']."', ville ='".$tiers['ville']."',boitepostale ='".$tiers['boitepostale']."',pays ='".$tiers['pays']."',telephonefixe ='".$tiers['telephonefixe']."',";
		$sql .="portable ='".$tiers['portable']."',email ='".$tiers['email']."',email2 ='".$tiers['email2']."',";
		$sql .="nombanque1 ='".$tiers['nombanque1']."',paysbanque1 ='".$tiers['paysbanque1']."',codebanque1 ='".$tiers['codebanque1']."',nomagence1 ='".$tiers['nomagence1']."',codeguichet1 ='".$tiers['codeguichet1']."',";
		$sql .="libellecompte1 ='".$tiers['libellecompte1']."',numerocompte1 ='".$tiers['numerocompte1']."',clerib1 ='".$tiers['clerib1']."',";
		$sql .="devisecompte1 ='".$tiers['devisecompte1']."',codeswift1 ='".$tiers['codeswift1']."',ribfile ='".$tiers['ribfile']."',nombanque2 ='".$tiers['nombanque2']."',paysbanque2 ='".$tiers['paysbanque2']."',codebanque2 ='".$tiers['codebanque2']."',nomagence2 ='".$tiers['nomagence2']."',codeguichet2 ='".$tiers['codeguichet2']."',";
		$sql .="libellecompte2 ='".$tiers['libellecompte2']."',numerocompte2 ='".$tiers['numerocompte2']."',clerib2 ='".$tiers['clerib2']."',devisecompte2 ='".$tiers['devisecompte2']."',codeswift2 ='".$tiers['codeswift2']."',ribfile2 ='".$tiers['ribfile2']."',attestationfiscalefile ='".$tiers['attestationfiscalefile']."'";
		$sql .=" where matricule='".$matricule."'";
		//echo $sql;
		if (!$db->Query($sql)) {

			//$trace->Trace_Err("requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			echo "requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]";
		}
		else
		{
			$isupdate=true;
			$tiersid = $tiers['tiersid'];
			$query = "update vtiger_crmentity set modifiedtime= '".date("Y-m-d H:i:s")."' where crmid= '".$tiersid."' ";
			$db->Query($query);
			$upload1 = $this->uploadFile('ribfile','/uploads/RIB1/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			if($tiers['numerocompte2']!='')
				$upload2 = $this->uploadFile('ribfile2','/uploads/RIB2/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			if($tiers['numerocompte3']!='')
				$upload3 = $this->uploadFile('ribfile3','/uploads/RIB3/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			$upload4 = $this->uploadFile('matriculefile','/uploads/MATRICULE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
		}
		
		return $upload1;
	   }
	   
	    public function updateFournisseurs($tiers)
	   {
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		$identificationfiscale=$tiers['identificationfiscale'];
		//print_r($tiers);
		//echo "UPDATE!!!!!";
		$sql = " UPDATE  tiers_informations SET ";
		$sql .="  identifiant ='".$tiers['identifiant']."',nom ='".$tiers['raisonsociale']."',initiales ='".$tiers['initiales']."',datenaissance ='".$tiers['datenaissance']."',identificationfiscale ='".$tiers['identificationfiscale']."',";
		$sql .="matricule ='".$tiers['nummatricule']."',adresse ='".$tiers['adresse']."',complementadresse ='".$tiers['complementadresse']."', ville ='".$tiers['ville']."',boitepostale ='".$tiers['boitepostale']."',pays ='".$tiers['pays']."',telephonefixe ='".$tiers['telephonefixe']."',";
		$sql .="formejuridique ='".$tiers['formejuridique']."',personnalitejuridique ='".$tiers['personnalitejuridique']."',repnom ='".$tiers['repnom']."',reptitre ='".$tiers['reptitre']."',repportable ='".$tiers['repportable']."',";
		$sql .="portable ='".$tiers['portable']."',email ='".$tiers['email']."',email2 ='".$tiers['email2']."',siteinternet ='".$tiers['siteinternet']."',";
		$sql .="nombanque1 ='".$tiers['nombanque1']."',paysbanque1 ='".$tiers['paysbanque1']."',codebanque1 ='".$tiers['codebanque1']."',nomagence1 ='".$tiers['nomagence1']."',codeguichet1 ='".$tiers['codeguichet1']."',";
		$sql .="libellecompte1 ='".$tiers['libellecompte1']."',numerocompte1 ='".$tiers['numerocompte1']."',clerib1 ='".$tiers['clerib1']."',";
		$sql .="devisecompte1 ='".$tiers['devisecompte1']."',codeswift1 ='".$tiers['codeswift1']."',ribfile ='".$tiers['ribfile']."',";
		$sql .="nombanque2 ='".$tiers['nombanque2']."',paysbanque2 ='".$tiers['paysbanque2']."',codebanque2 ='".$tiers['codebanque2']."',nomagence2 ='".$tiers['nomagence2']."',codeguichet2 ='".$tiers['codeguichet2']."',";
		$sql .="libellecompte2 ='".$tiers['libellecompte2']."',numerocompte2 ='".$tiers['numerocompte2']."',clerib2 ='".$tiers['clerib2']."',devisecompte2 ='".$tiers['devisecompte2']."',codeswift2 ='".$tiers['codeswift2']."',ribfile2 ='".$tiers['ribfile2']."',attestationfiscalefile ='".$tiers['attestationfiscalefile']."',";
		$sql .="nombanque3 ='".$tiers['nombanque3']."',paysbanque3 ='".$tiers['paysbanque3']."',codebanque3 ='".$tiers['codebanque3']."',nomagence3 ='".$tiers['nomagence3']."',codeguichet3 ='".$tiers['codeguichet3']."',";
		$sql .="libellecompte3 ='".$tiers['libellecompte3']."',numerocompte3 ='".$tiers['numerocompte3']."',clerib3 ='".$tiers['clerib3']."',devisecompte3 ='".$tiers['devisecompte3']."',codeswift3 ='".$tiers['codeswift3']."',ribfile3 ='".$tiers['ribfile3']."'";
		$sql .=" where identificationfiscale='".$identificationfiscale."'";
		//echo $sql;
		if (!$db->Query($sql)) {

			//$trace->Trace_Err("requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			echo "requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]";
		}
		else
		{
			$isupdate=true;
			$tiersid = $tiers['tiersid'];
			$query = "update vtiger_crmentity set modifiedtime= '".date("Y-m-d H:i:s")."' where crmid= '".$tiersid."' ";
			$db->Query($query);
			$upload1 = $this->uploadFile('ribfile','/uploads/RIB1/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			if($tiers['numerocompte2']!='')
				$upload2 = $this->uploadFile('ribfile2','/uploads/RIB2/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			if($tiers['numerocompte3']!='')
				$upload3 = $this->uploadFile('ribfile3','/uploads/RIB3/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			$upload4 = $this->uploadFile('matriculefile','/uploads/MATRICULE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			$upload5 = $this->uploadFile('attestationfiscalefile','/uploads/ATTESTFISCALE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
		}
		
		return $upload1;
	   }
	   
	   public function saveFournisseurs($tiers)
	   {
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//print_r($tiers);
		$tiers['identifiant']=$this->getNextIdentifiant();
		$nexttiersid=$this->getNextTiersId();
		$typeactivites = implode(" |##| ",$tiers['typeactivite']);
		$sql .= " INSERT INTO tiers_informations(tiersid,identificationfiscale,nom,identifiant,initiales,datenaissance,matricule,adresse,complementadresse,";
		$sql .= " ville,boitepostale,codepostal,pays,telephonefixe,portable,email,email2,siteinternet,formejuridique,personnalitejuridique,repnom,reptitre,repportable,";
		$sql .= " replignedirect,typeactivite1,nombanque1,paysbanque1,codebanque1,nomagence1,codeguichet1,libellecompte1,numerocompte1,clerib1,devisecompte1,codeswift1,nombanque2,";
		$sql .= " paysbanque2,codebanque2,nomagence2,codeguichet2,libellecompte2,numerocompte2,clerib2,devisecompte2,codeswift2,nombanque3,paysbanque3,codebanque3,nomagence3,";
		$sql .= " codeguichet3,libellecompte3,numerocompte3,clerib3,devisecompte3,codeswift3) ";

		$sql .=" VALUES('".$nexttiersid."','".$tiers['identificationfiscale']."','".$tiers['raisonsociale']."','".$tiers['identifiant']."','".$tiers['initiales']."','".$tiers['datenaissance']."',";
		$sql .="'".$tiers['nummatricule']."','".$tiers['adresse']."','".$tiers['complementadresse']."','".$tiers['ville']."','".$tiers['boitepostale']."',";
		$sql .="'".$tiers['codepostal']."','".$tiers['pays']."','".$tiers['telephonefixe']."','".$tiers['portable']."','".$tiers['email']."','".$tiers['email2']."',";
		$sql .="'".$tiers['siteinternet']."','".$tiers['formejuridique']."','".$tiers['personnalitejuridique']."','".$tiers['repnom']."','".$tiers['reptitre']."','".$tiers['repportable']."','".$tiers['replignedirect']."',";
		$sql .="'".$typeactivites."','".$tiers['nombanque1']."','".$tiers['paysbanque1']."','".$tiers['codebanque1']."','".$tiers['nomagence1']."','".$tiers['codeguichet1']."',";
		$sql .="'".$tiers['libellecompte1']."','".$tiers['numerocompte1']."','".$tiers['clerib1']."','".$tiers['devisecompte1']."','".$tiers['codeswift1']."',";
		$sql .="'".$tiers['nombanque2']."','".$tiers['paysbanque2']."','".$tiers['codebanque2']."','".$tiers['nomagence2']."','".$tiers['codeguichet2']."',";
		$sql .="'".$tiers['libellecompte2']."','".$tiers['numerocompte2']."','".$tiers['clerib2']."','".$tiers['devisecompte2']."','".$tiers['codeswift2']."',";
		$sql .="'".$tiers['nombanque3']."','".$tiers['paysbanque3']."','".$tiers['codebanque3']."','".$tiers['nomagence3']."','".$tiers['codeguichet3']."',";
		$sql .="'".$tiers['libellecompte3']."','".$tiers['numerocompte3']."','".$tiers['clerib3']."','".$tiers['devisecompte3']."','".$tiers['codeswift3']."');";
		//echo $sql;
		if (!$db->Query($sql)) {

			//$trace->Trace_Err("requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			echo "requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]";
		}
		else
		{
			$tiersid = $nexttiersid;
			$query = "insert into vtiger_crmentity(crmid,setype,createdtime,modifiedtime) values('".$tiersid."','Tiers Fournisseurs','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
			$db->Query($query);
			$upload1 = $this->uploadFile('ribfile','/uploads/RIB1/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,false);
			if($tiers['numerocompte2']!='')
				$upload2 = $this->uploadFile('ribfile2','/uploads/RIB2/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,false);
			if($tiers['numerocompte3']!='')
				$upload3 = $this->uploadFile('ribfile3','/uploads/RIB3/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			$upload4 = $this->uploadFile('matriculefile','/uploads/MATRICULE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
			$upload5 = $this->uploadFile('attestationfiscalefile','/uploads/ATTESTFISCALE/',3000000, array('doc','gif','jpg','jpeg','docx','pdf'),$tiersid,$isupdate);
		}
		
		return $upload1;
	   }
	   
	public function selectAllSecteursActivite()
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT activitecode,activitelibelle FROM tiers_activites WHERE activiteid!=29 ";
		//echo $sql;
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$activites = $db->FetchAllArrays($result);
		return $activites;
	}
	
	

	    
	public function uploadFile($index,$destinationpath,$maxsize=FALSE,$extensions=FALSE,$tiersid,$isupdate)
	{
	   global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
	   //Test1: fichier correctement uploadé
	   $erreur="";
	     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) $erreur = "Erreur lors du transfert";
	   //Test2: taille limite
	     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) $erreur.= "Le fichier est trop gros";
	   //Test3: extension
	     $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
	     if ($extensions !== FALSE AND !in_array($ext,$extensions)) $erreur.= " Extension non valide";
	   //Déplacement
	   
		$binFile = preg_replace('/\s+/', '_', $_FILES[$index]['name']);//replace space with _ in filename
		$filename = ltrim(basename(" ".$binFile));
		$destination = PATH_PROJET.$destinationpath.$tiersid."_".$binFile;
	      $resmove = move_uploaded_file($_FILES[$index]['tmp_name'],$destination);
	      if (!$resmove) {
		$erreur.= " Erreur!!!!!";
		}
	      else
	      {
		
		
		$req = " call saveTiersFile('".$binFile."','".$_FILES[$index]['type']."','".$destinationpath."','".$tiersid."')";

		if (!$db->Query($req)) 
		{

			echo "requete = [$sql], Tiers =[" . $db->Errno . "] ,code = [" . $db->Error . "]";
		}
	    }

	     return $erreur;
	     //EXEMPLES
	 /* $upload1 = upload('icone','uploads/monicone1',15360, array('png','gif','jpg','jpeg') );
	  $upload2 = upload('mon_fichier','uploads/file112',1048576, FALSE );
	 
	  if ($upload1) "Upload de l'icone réussi!<br />";
	  if ($upload2) "Upload du fichier réussi!<br />";*/
	}
 
	public function getNextIdentifiant()
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT max(tiersid)+2 nexttiersid FROM tiers_informations ";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$maxtid = $db->FetchAllArrays($result);
		$maxtiersid=$maxtid[0]['nexttiersid'];
		$nextidentifiant = 'TCUEMOA'.$maxtiersid;
		return $nextidentifiant;
	}

	public function getNextTiersId()
	{
		global $trace;
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT max(tiersid)+1 nexttiersid FROM tiers_informations ";
		//echo $sql;
		$result = $db->Query($sql);
		
		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$maxtid = $db->FetchAllArrays($result);
		$maxtiersid=$maxtid[0]['nexttiersid'];
		return $maxtiersid;
	}
	public function selectContactByCategorie($numeroclient,$catid)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT contactid,CONCAT(prenom,' ',nom) AS nom,email,numerotel,adressedomicile adresse,cc.libelle catlib,c.categorie
				FROM paof_contacts c
				LEFT JOIN `paof_contactcategorie` cc ON cc.id=c.categorie
				where c.numeroclient='".$numeroclient."' AND categorie='".$catid."'";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$contacts = $db->FetchAllArrays($result);
		return $contacts;
	} 
	
	 public function selectCategorieByAbonne($numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "SELECT COUNT(contactid) nb,cc.id,cc.libelle
				FROM paof_contactcategorie cc
				LEFT JOIN paof_contacts c ON c.categorie=cc.id
				WHERE cc.numeroclient='".$numeroclient."'
				GROUP BY cc.id ";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$categories = $db->FetchAllArrays($result);
		return $categories;
	} 
	/*
	public function deleteCategorie($categorie)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "select count(contactid) nb,c.categorie,cc.libelle
				from paof_contacts c,paof_contactcategorie cc
				where c.categorie=cc.id
				and cc.numeroclient='".$numeroclient."'
				group by categorie";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
		}
		$categories = $db->FetchAllArrays($result);
		return $categories;
	} 
	*/
	public function addCategorie($categorie,$numeroclient)
	{
		global $trace;
    	$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		//$db = initBase();
		$sql = "INSERT INTO paof_contactcategorie(description,libelle,numeroclient) VALUES('".$categorie."','".$categorie."','".$numeroclient."')";
		$result = $db->Query($sql);

		if (!result) {
			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			return false;
		}
		return $true;
	} 
	
    public function selectContactByForder($numeroclient,$folderid)
	{
	
	}	
    public function selectFolderByAbonne($numeroclient)
	{
	
	}	
    public function findContactById($id)
	{
	
	}
    public function findContact($criteria)
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
