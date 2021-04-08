<?php
	require_once('include/utils/conventionUtils.php');

	session_start();

	$projectid = $_REQUEST['projectid'];	
	$requete = $_REQUEST['requete'];	
	
	if  ($requete == "getinfosprojet")
	{
		$dossier = getinfosproject($projectid);		

	//$detaildossier = $dossier["organeid"].'งง'.$dossier["organe"].'งง'.$dossier["politiqueid"].'งง'.$dossier["politique"].'งง'.$dossier["programmeid"].'งง'.$dossier["programme"];
	echo json_encode($dossier);
	}
	
	if  ($requete == "saveprodfin")
	{
		$prodfinvalues = $_REQUEST['prodfinvalues'];		

		saveProduiFinancier($prodfinvalues);
	}
	
	if  ($requete == "delprodfin")
	{
		$idprodfin = $_REQUEST['idprodfin'];		

		deleteProduiFinancier($idprodfin);
	}
	
	if  ($requete == "delcrexecution")
	{
		$idexecution = $_REQUEST['idexecution'];		

		deleteCRExecution($idexecution);
	}
	
?>