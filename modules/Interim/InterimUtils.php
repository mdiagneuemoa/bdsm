<?php
	require_once('include/utils/utils.php');

	session_start();

	$matricule = $_REQUEST['matricule'];	
	$requete = $_REQUEST['requete'];	
	
		
	if  ($requete == "getfoncinterim")
	{
		$direction = getDirectionResp($matricule);		

		echo $direction;
	}
		
	if  ($requete == "getdirectioninterim")
	{
		$direction = getDirectionInterim($matricule);	
		echo $direction;
	}
		
	

	
	
	
?>