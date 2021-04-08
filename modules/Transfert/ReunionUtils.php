<?php
	require_once('include/utils/utils.php');
	require_once('modules/Reunion/Reunion.php');

	session_start();

	$matricule = $_REQUEST['matricule'];	
	$requete = $_REQUEST['requete'];	
	$focus = new Reunion();
	if  ($requete == "savemodifSignataire")
	{
		$reunionid = $_REQUEST['reunionid'];		
		$infossignataires = json_decode($_REQUEST['jsoninfossignataires']);
		$focus->savemodifsignataires($reunionid,$infossignataires);
		//print_r($jsoninfossignataires);
		//echo $reunionid;
	}
	if  ($requete == "saveDecision")
	{
		$reunionid = $_REQUEST['reunionid'];		
		$regisseur = $_REQUEST['regisseur'];		
		$focus->saveDecision($reunionid,$regisseur);
		//print_r($jsoninfossignataires);
		//echo $reunionid;
	}
	if  ($requete == "getfonctionagent")
	{
		$fonction = getFonctionByMatricule($matricule);		

		echo $fonction;
	}
	
	if  ($requete == "getfoncinterim")
	{
		$direction = getDirectionResp($matricule);		

		echo $direction;
	}
	
	if  ($requete == "getCompteNatByBudget")
	{
		$codebudget = $_REQUEST['codebudget'];	
		$sourcefin = $_REQUEST['sourcefin'];	
		$comptnats = getCompteNatByBudget($codebudget,$sourcefin);	
		echo json_encode($comptnats);
		//echo "XXXXXX";
	}
	
	

function getCompteNatByBudget($codebudget,$sourcefin)
{
	global $log;
	$log->debug("Entering getCompteNatByBudget(".$codebudget.") method ...");
	$log->info("in getCompteNatByBudget ".$codebudget);

        global $adb;
        if($codebudget != '')
        {
                //$sql = "SELECT comptenature,UPPER(libconptenature) libconptenature FROM nomade_comptenature2budget WHERE codebudget=? ";
				//$result = $adb->pquery($sql, array($codebudget));
			   $sql = " SELECT DISTINCT `comptenature`,UPPER(`libconptenature`) libcomptenat FROM `nomade_comptenature2budget`
						ORDER BY 1";
               $result = $adb->pquery($sql, array());
		$i=0;
		while ($row1 = $adb->fetchByAssoc($result))
		{
			//$budget = getDispBudgetByCompteNat($codebudget,$sourcefin,$row1['comptenature']);
			if ($budget['mntdispo']!='')
				$mntdispo = number_format($budget['mntdispo'], 0, ',', ' ');
			else
				$mntdispo ='0';
			$CODEBUDGETS[$i++]=$row1['libcomptenat'].'::'.$row1['comptenature'].'::'.$mntdispo;
		}
	 
		
        }
	$log->debug("Exiting getCompteNatByBudget method ...");
        return $CODEBUDGETS;
}

function getDispBudgetByCompteNat($codebudget,$sourfin,$comptenat)
{
	$infosbudget['codebudget'] = $codebudget;
	$infosbudget['sourcefin'] = $sourfin;
	  
	$infosbudget['comptenat'] = $comptenat;
	$infosdisp = getInfosDisponibiliteFonds($infosbudget);
	$dispbudgetobj= $infosdisp->IT_RESULT->item;
	//print_r($dispbudgetobj);
	$dispbudget=array(	'comptenat'=>$comptenat,
					'comptenatlib'=>$comptenatlib,
					'fonddisp'=>$dispbudgetobj->MNTANT_FD_ENGAGE,
					'fondengage'=>$dispbudgetobj->FOND_ENGAGE,
					'mntdispo'=>$dispbudgetobj->MNTNT_DISPO
				      );
	 return  $dispbudget;								
}
?>