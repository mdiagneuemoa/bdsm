<?php

require_once ("config/config_inc.php");
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");

class Tiers {
	var $tiersid;
	var $identifiant;
	var $nom;
	var $prenom;
	var $raisonsociale;
	var $initiales;
	var $identificationfiscale;
	var $datenaissance;
	var $matricule;
	var $adresse text;
	var $ville;
	var $boitepostale;
	var $pays;
	var $telephonefixe;
	var $fax;
	var $portable;
	var $email;
	var $email2;
	var $siteinternet;
	var $repnom;
	var $repportable;
	var $ replignedirect;
	var $personnalitejuridique;
	var $formejuridique;
	var $typeactivite1;
	var $typeactivite2;
	var $typeactivite3;
	var $nombanque1;
	var $paysbanque1;
	var $codebanque1;
	var $nomagence1;
	var $codeguichet1;
	var $libellecompte1;
	var $numerocompte1;
	var $clerib1;
	var $devisecompte1;
	var $codeswift1;
	var $ ribfile;
	var $nombanque2;
	var $paysbanque2;
	var $codebanque2;
	var $nomagence2;
	var $codeguichet2;
	var $libellecompte2;
	var $numerocompte2;
	var $clerib2;
	var $devisecompte2;
	var $codeswift2;
	var $ribfile2;
	var $matriculefile;
	var $attestationfiscalefile;
	var $statut;
	private $db;	
	
	function __construct($nom,$prenom,$poste,$mobile)
	{
		//$this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->poste = $poste;
		$this->mobile = $mobile;
	}
	/*
	function Abonne()
	{
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
	}
	*/
	function SetId($id) {
		$this->id = $id;
	}
	function GetId() {
		return $this->id;
	}
	function SetNom($nom) {
		$this->nom = $nom;
	}
	function GetNom() {
		return $this->nom;
	}
	function SetPrenom($prenom) {
		$this->prenom = $prenom;
	}
	function GetPrenom() {
		return $this->prenom;
	}
	function SetPoste($poste) {
		$this->poste = $poste;
	}
	function GetPoste() {
		return $this->poste;
	}
	function SetMobile($mobile) {
		$this->mobile = $mobile;
	}
	function GetMobile() {
		return $this->mobile;
	}
	
	
	function is_authenticated()
	{
		return $this->authenticated;
	}

	function load_tiers($usr_name, $user_password)
	{
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		
		$validation = 0;
		
		if(!isset($user_password) || $user_password == "")
			return null;
		
		$query .= "SELECT util_id,util_numeroclient as numeroclient, util_login, util_passwd AS user_password, util_nom AS nom,util_prenom AS prenom, util_statut AS statut ";
		$query .= "FROM interf_utilisateur ";
		$query .= "WHERE util_login='".$usr_name."' AND util_passwd='".$user_password."'";
		//echo  
		$result = $db->Query($query);

		if (!$result) {

			$trace->Trace_Err("requete = [$sql], message =[" . $db->Errno . "] ,code = [" . $db->Error . "]");
			return null;
		}
		$abonne = $db->FetchAllArrays($result);

		if(count($abonne) <= 0)
		{
			return null;
		}
		$this->numeroclient = $client['numeroclient'] ;	
		$this->authenticated = true;
		$this->username = $usr_name;
		$this->nom = $client['nom'] ;	
		$this->prenom = $client['prenom'] ;	

		return $this;
	}
	
	
} // fin class 