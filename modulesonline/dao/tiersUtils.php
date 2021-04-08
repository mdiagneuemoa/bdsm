
 <?php
 
require_once ("C:/wamp/www/portailuemoa/config/config_inc.php");
//require_once (PATH_BEANS."/tiers.php");
require_once (PATH_DAO_IMPL."/tiersDaoImpl.php");
$tiersdao = new TiersDao();


if ($_REQUEST["action"]==getTiersByMatricule)
{
	 $matricule = $_REQUEST['matricule'];
	 $nbmat = $tiersdao->verifExistMatricule($matricule);
	 
	 if($nbmat==1)
	 {
		$tiers = $tiersdao->selectTiersByMatricule($matricule);
		$tiers['matvalide']=1;

	 }	
	else
	   $tiers['matvalide']=0;
	   
	echo json_encode($tiers);
	//echo $nbmat;
}
if ($_REQUEST["action"]==getTiersByMatricule2)
{
	 $nummatricule = $_REQUEST['nummatricule'];
	 $nbmat = $tiersdao->verifExistMatricule($nummatricule);
	 
	 if($nbmat==1)
	 {
		$tiers = $tiersdao->selectTiersByMatricule($nummatricule);
		$tiers['matvalide']=1;

	 }	
	else
	   $tiers['matvalide']=0;
	   
	echo json_encode($tiers);
	//echo $nbmat;
}
if ($_REQUEST["action"]==getTiersByIdentFiscale)
{
	 $identificationfiscale = $_REQUEST['identificationfiscale'];
	 $nbmat = $tiersdao->verifExistIdentFiscale($identificationfiscale);
	 
	 if($nbmat==1)
	 {
		$tiers = $tiersdao->selectTiersByIdentFiscale($identificationfiscale);
		$tiers['matvalide']=1;

	 }	
	else
	   $tiers['matvalide']=0;
	   
	echo json_encode($tiers);
	//echo $nbmat;
}
if ($_REQUEST["action"]==getTiersByRaisonSociale)
{
	 $raisonsociale = $_REQUEST['raisonsociale'];
	 $nbmat = $tiersdao->verifExistRaisonSociale($raisonsociale);
	 
	 if($nbmat==1)
	 {
		$tiers = $tiersdao->selectTiersByRaisonSociale($raisonsociale);
		$tiers['matvalide']=1;

	 }	
	else
	   $tiers['matvalide']=0;
	   
	echo json_encode($tiers);
	//echo $nbmat;
}

if ($_REQUEST["action"]==saveTiers)
{
	 $matricule = $_REQUEST['matricule'];
	 $nbmat = $tiersdao->verifExistMatricule($matricule);
	 
	 if($nbmat==1)
	 {
		
		$tiers['matvalide']=1;

	 }	
	else
	   $tiers['matvalide']=0;
	   
	
	echo $nbmat;
}
if ($_REQUEST["action"]==getNextIdentifiant)
{
	 $nextidentifiant = $tiersdao->getNextIdentifiant();
	
	echo $nextidentifiant;
}

//print_r($messages);
?> 		
