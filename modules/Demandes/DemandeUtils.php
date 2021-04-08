<?php
	require_once('include/utils/utils.php');

	session_start();

	$matricule = $_REQUEST['matricule'];	
	$requete = $_REQUEST['requete'];	
	
	if  ($requete == "getfonctionagent")
	{
		$fonction = getFonctionByMatricule($matricule);		

		echo $fonction;
	}
	if  ($requete == "getBudgetsByAgentDepart")
	{
		$budgets = getBudgetsByAgentDepart($matricule);		
		echo json_encode($budgets);
		//echo "XXXXXX";
	}
	if  ($requete == "getfoncinterim")
	{
		$direction = getDirectionResp($matricule);		

		echo $direction;
	}
	
	if  ($requete == "getdirectionresp")
	{
		$direction = getDirectionResp($matricule);		
		echo $direction;
	}
	if  ($requete == "getdirectioninterim")
	{
		$direction = getDirectionInterim($matricule);		
		echo $direction;
	}
	
	if  ($requete == "getinfosagent")
	{
		$dossier = getinfosagent($matricule);		

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