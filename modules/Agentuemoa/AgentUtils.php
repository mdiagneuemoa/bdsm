<?php

	session_start();
	$organeid = $_REQUEST['organeid'];	
	$requete = $_REQUEST['requete'];	
	
	if  ($requete == "getdepartementsOrgane")
	{
		$departements = json_encode(getdepartementsOrgane($organeid));		
		
		//$detaildossier = $dossier["organeid"].'��'.$dossier["organe"].'��'.$dossier["politiqueid"].'��'.$dossier["politique"].'��'.$dossier["programmeid"].'��'.$dossier["programme"];
		echo $departements;
	}
	
?>