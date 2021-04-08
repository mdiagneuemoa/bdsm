<?php
class Parametres {
	var $numeroclient;
	var $consigneaccueil;
	var $consignereponse;
	var $autreconsigne;
	var $planacces;
	var $doccommercial;
	var $autredoc;
	var $dureeminrv;
	var $rappelrv;
	var $copiemail;

	
	function __construct($nom,$prenom,$poste,$mobile)
	{
		//$this->id = $id;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->poste = $poste;
		$this->mobile = $mobile;
	}
	
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
	
} // fin class 