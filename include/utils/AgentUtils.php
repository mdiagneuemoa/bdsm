<?php

	session_start();
	$agent=new Agentuemoa();
	$organeid = $_REQUEST['organeid'];	
	$requete = $_REQUEST['requete'];	
	
	if  ($requete == "getdepartementsOrgane")
	{
		$departements = $agent->getdepartementsOrgane($organeid);		

	//$detaildossier = $dossier["organeid"].'��'.$dossier["organe"].'��'.$dossier["politiqueid"].'��'.$dossier["politique"].'��'.$dossier["programmeid"].'��'.$dossier["programme"];
	echo $departements;
	}
	
?>