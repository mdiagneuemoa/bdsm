<?php

require_once ("config/config_inc.php");
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");

class Abonne {
	var $numeroclient;
	var $nom;
	var $prenom;
	var $numeroassistant;
	var $telephone;
	var $email;
	var $consignes;
	var $reponses;
	var $planacces;
	var $doccommercial;
	var $autredoc;
	var $authenticated = false;
	var $login;
	var $password;
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

	function load_abonne($usr_name, $user_password)
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