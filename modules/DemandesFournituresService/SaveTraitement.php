<?php
	require_once('modules/Demandes/Demandes.php');

	session_start();
	$demande = new Demandes();
	$record = $_REQUEST['demandeid'];
	
	if ($_REQUEST['statutdemande']==1)
	{
		$article1['demandeid'] = $_REQUEST['demandeid'];	
		$article1['ticket']= $_REQUEST['demandeticket'];	
		$article1['statut'] = $_REQUEST['statutdemande'];	
		$article1['numarticle'] = 1;	
		$article1['descarticle'] = $_REQUEST['descarticle1'];	
		$article1['datelivraison'] = date("d-m-Y H:i:s");
		$article1['quantite'] =1;
		$article1['numseriearticle']= $_REQUEST['numserie1'];	
		$article1['commentaire'] = $_REQUEST['comment1'];	
		
		$demande->saveLivraisonArticle($article1);
	}
	if ($_REQUEST['statutdemande2']==1)
	{
		$article2['demandeid'] = $_REQUEST['demandeid'];	
		$article2['ticket']= $_REQUEST['demandeticket'];	
		$article2['statut'] = $_REQUEST['statutdemande2'];	
		$article2['numarticle'] = 2;	
		$article2['descarticle'] = $_REQUEST['descarticle1'];	
		$article2['datelivraison'] = date("d-m-Y H:i:s");
		$article2['quantite'] =1;
		$article2['numseriearticle']= $_REQUEST['numserie2'];	
		$article2['commentaire'] = $_REQUEST['comment2'];	
		
		$demande->saveLivraisonArticle($article2);
	}

	
	if ($_REQUEST['statutdemande3']==1)
	{
		$article3['demandeid'] = $_REQUEST['demandeid'];	
		$article3['ticket']= $_REQUEST['demandeticket'];	
		$article3['statut'] = $_REQUEST['statutdemande3'];	
		$article3['numarticle'] = 3;	
		$article3['descarticle'] = $_REQUEST['descarticle3'];	
		$article3['datelivraison'] = date("d-m-Y H:i:s");
		$article3['quantite'] =1;
		$article3['numseriearticle']= $_REQUEST['numserie3'];	
		$article3['commentaire'] = $_REQUEST['comment3'];	
		
		$demande->saveLivraisonArticle($article3);
	}	

	if ($_REQUEST['statutdemande4']==1)
	{
		$article4['demandeid'] = $_REQUEST['demandeid'];	
		$article4['ticket']= $_REQUEST['demandeticket'];	
		$article4['statut'] = $_REQUEST['statutdemande4'];	
		$article4['numarticle'] = 4;	
		$article4['descarticle'] = $_REQUEST['descarticle4'];	
		$article4['datelivraison'] = date("d-m-Y H:i:s");
		$article4['quantite'] =1;
		$article4['numseriearticle']= $_REQUEST['numserie4'];	
		$article4['commentaire'] = $_REQUEST['comment4'];	
		
		$demande->saveLivraisonArticle($article4);
	}

	
	if ($_REQUEST['statutdemande5']==1)
	{
		$article5['demandeid'] = $_REQUEST['demandeid'];	
		$article5['ticket']= $_REQUEST['demandeticket'];	
		$article5['statut'] = $_REQUEST['statutdemande5'];	
		$article5['numarticle'] = 5;	
		$article5['descarticle'] = $_REQUEST['descarticle5'];	
		$article5['datelivraison'] = date("d-m-Y H:i:s");
		$article5['quantite'] =1;
		$article5['numseriearticle']= $_REQUEST['numserie5'];	
		$article5['commentaire'] = $_REQUEST['comment5'];	
		
		$demande->saveLivraisonArticle($article5);
	}
	if ($_REQUEST['statutdemande']==1 || $_REQUEST['statutdemande2']==1 || $_REQUEST['statutdemande3']==1 || $_REQUEST['statutdemande4']==1 || $_REQUEST['statutdemande5']==1)
	{
		$demande->traiterdemande($record);
	}
	//break;	
	/*echo "demandeid=$demandeid"," - ","demandeticket=$demandeticket","<br>";
	echo "statutdemande=$statutdemande"," - ","statutdemande2=$statutdemande2"," - ","statutdemande3=$statutdemande3","statutdemande4=$statutdemande4","statutdemande5=$statutdemande5","<br>";
	
	echo "descarticle1=$descarticle1"," - ","numserie1=$numserie1"," - ","comment1=$comment1","<br>";
	echo "descarticle2=$descarticle2"," - ","numserie2=$numserie2"," - ","comment2=$comment2","<br>";
	echo "descarticle3=$descarticle3"," - ","numserie3=$numserie3"," - ","comment3=$comment3","<br>";
	echo "descarticle4=$descarticle4"," - ","numserie3=$numserie4"," - ","comment3=$comment4","<br>";
	echo "descarticle5=$descarticle5"," - ","numserie5=$numserie5"," - ","comment5=$comment5","<br>";
	
	break;
	if  ($requete == "getinfosprojet")
	{
		$dossier = getinfosproject($projectid);		

	//$detaildossier = $dossier["organeid"].'§§'.$dossier["organe"].'§§'.$dossier["politiqueid"].'§§'.$dossier["politique"].'§§'.$dossier["programmeid"].'§§'.$dossier["programme"];
	echo json_encode($dossier);
	}
	*/
	header("Location:index.php?action=DetailView&module=Demandes&record=$record&parenttab=Demandes");
?>