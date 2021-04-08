<?php

	session_start();
	$agent=new Agentuemoa();
	$organeid = $_REQUEST['organeid'];	
	$requete = $_REQUEST['requete'];	
	
	if  ($requete == "getdepartementsOrgane")
	{
		$departements = $agent->getdepartementsOrgane($organeid);		

	//$detaildossier = $dossier["organeid"].'งง'.$dossier["organe"].'งง'.$dossier["politiqueid"].'งง'.$dossier["politique"].'งง'.$dossier["programmeid"].'งง'.$dossier["programme"];
	echo $departements;
	}
	
?>