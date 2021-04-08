<?php
	require_once('include/utils/utils.php');
	require_once('modules/Transfert/Transfert.php');

	session_start();

	$matricule = $_REQUEST['matricule'];	
	$requete = $_REQUEST['requete'];	
	$focus = new Transfert();
	if  ($requete == "savemodifSignataire")
	{
		$transfertid = $_REQUEST['transfertid'];		
		$infossignataires = json_decode($_REQUEST['jsoninfossignataires']);
		$focus->savemodifsignataires($transfertid,$infossignataires);
		//print_r($jsoninfossignataires);
		//echo $transfertid;
	}
	if  ($requete == "saveDecision")
	{
		$transfertid = $_REQUEST['transfertid'];		
		$regisseur = $_REQUEST['regisseur'];		
		$focus->saveDecision($transfertid,$regisseur);
		//print_r($jsoninfossignataires);
		//echo $transfertid;
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
		$comptnats = getCompteNatByBudget($codebudget,$sourcefin);	
		echo json_encode($comptnats);
		//echo "XXXXXX";
	}
	if  ($requete == "getDispoByCompteNat")
	{
		$codebudget = $_REQUEST['codebudget'];	
		$comptenat = $_REQUEST['comptenat'];
		$linedebcred = array('codebudget'=>$codebudget,'comptenat'=>$comptenat);	
		$lignedisp = $focus->getInfosDisponibiliteFonds($linedebcred);
		//echo json_encode($comptnats);
		echo number_format($lignedisp['mntdispo'], 3, ' ', ' ');
		//echo "XXXXXX";
	}
	
	

function getCompteNatByBudget($codebudget)
{
	global $log;
	$log->debug("Entering getCompteNatByBudget(".$codebudget.") method ...");
	$log->info("in getCompteNatByBudget ".$codebudget);

        global $adb;
        if($codebudget != '')
        {
                //$sql = "SELECT comptenature,UPPER(libconptenature) libconptenature FROM nomade_comptenature2budget WHERE codebudget=? ";
				//$result = $adb->pquery($sql, array($codebudget));
			   $sql = " SELECT DISTINCT comptenature,libcomptenat FROM nomade_comptenat2budget WHERE codebudget=? ORDER BY 1";
               $result = $adb->pquery($sql, array($codebudget));
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