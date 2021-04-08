<?php
	require_once('include/utils/utils.php');
	require_once('modules/StatisticsSM/StatisticsSM.php');

	session_start();

	$requete = $_REQUEST['requete'];	
	$focus = new StatisticsSM();
	
	if  ($requete == "getStatistiques")
	{
		$paramstats = $_REQUEST['paramstats'];	
		$vparamstats = json_decode($paramstats);
		$frequence = $vparamstats->frequence;
		$pays = $vparamstats->pays;
		$sficheid = $vparamstats->sficheid;
		$moisdeb = $vparamstats->moisdeb; $anneedeb = $vparamstats->anneedeb;
		$moisfin = $vparamstats->moisfin; $anneefin = $vparamstats->anneefin;
		
		if ($frequence=='A')
		{
			if ($sficheid=='SFCO71-01')
				$statistics = $focus->getDonneesIndicateursCoherence1($sficheid,$pays,$anneedeb,$anneefin);
			else	
				$statistics = $focus->getDonneesIndicateursAnnuels($sficheid,$pays,$anneedeb,$anneefin);
			$showstatistics = $focus->showStatisticsAnnuelles($statistics);
		}
		elseif ($frequence=='M')
		{
			
			//$sficheid='SFPR22-01';
			//echo $sficheid,' - ',$frequence,' - ',$pays,' - ',$moisdeb,' - ',$moisfin,' - ',$anneedeb,' - ',$anneefin; 
			$statistics = $focus->getDonneesIndicateursMensuels($sficheid,$pays,$moisdeb,$moisfin,$anneedeb,$anneefin);
			
			$showstatistics = $focus->showStatisticsMensuelles($statistics);
		}
		elseif ($frequence=='T')
		{
			$statistics = $focus->getDonneesIndicateursTrimestriels($sficheid,$pays,$anneedeb,$anneefin);
			$showstatistics = $focus->showStatisticsTrimestrielles($statistics);
			//$showstatistics = $focus->showStatistics($statistics);
		}
		/*elseif ($frequence=='S')
		{
			$statistics = $focus->getDonneesIndicateursSemestriels($sficheid,$pays,$anneedeb,$anneefin);
			$showstatistics = $focus->showStatistics($statistics);
		}*/
		//print_r($depensesmissions);
		//echo json_encode($resultats);
		echo $showstatistics;
	}
	
	if  ($requete == "getFormSaisie")
	{
		$paramstats = $_REQUEST['paramstats'];	
		$vparamstats = json_decode($paramstats);
		$frequence = $vparamstats->frequence;
		$pays = $vparamstats->pays;
		$typesaisie = $vparamstats->typesaisie;
		$sficheid = $vparamstats->sficheid;
		$moisdeb = $vparamstats->moisdeb; $anneedeb = $vparamstats->anneedeb;
		$moisfin = $vparamstats->moisfin; $anneefin = $vparamstats->anneefin;
		
		if ($typesaisie=='FORM')
		{
		
			if ($frequence=='A')
			{
				//$statistics = $focus->getFormIndicateursAnnuels($sficheid,$pays,$anneedeb,$anneefin);
				$statistics = $focus->getFormIndicateursAnnuels($sficheid,$pays,$anneedeb,$anneefin);
				$showstatistics = $focus->showFormAnnuelles($statistics,$pays,$anneedeb,$anneefin);
			}
			elseif ($frequence=='M')
			{
				
				//$sficheid='SFPR22-01';
				//echo $sficheid,' - ',$frequence,' - ',$pays,' - ',$moisdeb,' - ',$moisfin,' - ',$anneedeb,' - ',$anneefin; 
				$statistics = $focus->getFormIndicateursMensuels($sficheid,$pays,$moisdeb,$moisfin,$anneedeb,$anneefin);
				
				$showstatistics = $focus->showFormMensuelles($statistics,$pays,$moisdeb,$moisfin,$anneedeb,$anneefin);
			}
			elseif ($frequence=='T')
			{
				$statistics = $focus->getFormIndicateursTrimestriels($sficheid,$pays,$anneedeb,$anneefin);
				$showstatistics = $focus->showFormTrimestrielles($statistics,$pays,$moisdeb,$moisfin,$anneedeb,$anneefin);
				//$showstatistics = $focus->showStatistics($statistics);
			}
			/*elseif ($frequence=='S')
			{
				$statistics = $focus->getDonneesIndicateursSemestriels($sficheid,$pays,$anneedeb,$anneefin);
				$showstatistics = $focus->showStatistics($statistics);
			}*/
			//print_r($depensesmissions);
			//echo json_encode($resultats);
		}
		else
		{
			$statistics = $focus->getFormIndicateursAnnuels($sficheid,$pays,$anneedeb,$anneefin);
			$showstatistics = $focus->showFormUpload($statistics,$pays,$anneedeb,$anneefin);

		}
		echo $showstatistics;
	}
	if  ($requete == "getFichesByCat")
	{
		$cfiche = $_REQUEST['cfiche'];	
		$fiches = $focus->getFichesByCat($cfiche);	
		//print_r($actions);
		echo json_encode($fiches);
	}
	if  ($requete == "getSousFichesByFiche")
	{
		$fiche = $_REQUEST['fiche'];	
		$sfiches = $focus->getSousFichesByCodeFiche($fiche);	
		//print_r($actions);
		echo json_encode($sfiches);
	}
?>