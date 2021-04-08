<?php


function getServiceAgent($userdirection)
{
	$db = mysql_connect('localhost', 'root', ''); 
	mysql_select_db('nomade',$db); 
	
	$sql = "SELECT dep1.organesigle,dep1.organeparent,dep2.organesigle,CONCAT(dep1.organesigle,'(',dep2.organesigle,')') as service
				  FROM nomade_departements dep1 
				  LEFT JOIN nomade_departements dep2 ON CONCAT(dep2.organeparent,':',dep1.organecode)=dep1.organeparent WHERE dep1.organecode ='".$userdirection."'";
	
	$result = mysql_query($sql);
	$dep = mysql_fetch_assoc($result);
				
	return $dep['service'];
		
       
}

function getInfosByDemande($iddemande)
{
		$db = mysql_connect('localhost', 'root', ''); 
		mysql_select_db('nomade',$db); 
		
        if($iddemande != '')
        {
                $sql = "SELECT d.ticket,CONCAT(ag.civilite,' ',ag.nom,' ',ag.prenoms) AS nom,d.fonction,
							ag.affectdirection,d.datedebut,d.datefin,
							 cat.titrecat,localitenom AS lieu,d.objet,
							 trans.libmodetransp AS modetransp,
							 d.budget,d.sourcefin,d.codebudget,d.comptenat,
							 d.budget2,d.sourcefin2,d.codebudget2,d.comptenat2,
							 d.budget3,d.sourcefin3,d.codebudget3,d.comptenat3,
							 d.budget4,d.sourcefin4,d.codebudget4,d.comptenat4,
							 d.budget5,d.sourcefin5,d.codebudget5,d.comptenat5,
							 d.matricule
						FROM nomade_demande d
						INNER JOIN param_localites loc ON loc.localiteid=d.lieu
						INNER JOIN nomade_agentsuemoa ag ON ag.matricule=d.matricule
						INNER JOIN nomade_categorie cat ON cat.codecat=ag.categmis
						INNER JOIN nomade_modetransport trans ON trans.idmodetransp=d.modetransport COLLATE utf8_unicode_ci 
						WHERE d.demandeid='".$iddemande."'";
						
                 $result = mysql_query($sql);
				$demande = mysql_fetch_assoc($result);
				$demande['service'] = getServiceAgent($demande['affectdirection']);
				 
        }
	$log->debug("Exiting getInfosByDemande method ...");
        return $demande;
}


function getInfosByOM($iddemande)
{
	
	$db = mysql_connect('localhost', 'root', ''); 
	mysql_select_db('nomade',$db); 
	
        if($iddemande != '')
        {
                $sql = "SELECT d.numom,d.datedepart,d.datearrivee,
							 d.trajet1date,d.trajet1depart,d.trajet1arrivee,
							 d.trajet2date,d.trajet2depart,d.trajet2arrivee,
							 d.trajet3date,d.trajet3depart,d.trajet3arrivee,
							 d.trajet4date,d.trajet4depart,d.trajet4arrivee,
							 d.trajet5date,d.trajet5depart,d.trajet5arrivee,
							 d.trajet6date,d.trajet6depart,d.trajet6arrivee,
							 d.trajet7date,d.trajet7depart,d.trajet7arrivee,
							 d.trajet8date,d.trajet8depart,d.trajet8arrivee,
							 t.timbre1,t.timbre2,t.timbre3,d.signataire,
							 d.matricule
						FROM nomade_ordremission d
						INNER JOIN nomade_timbre t ON t.id=d.timbre
						WHERE d.demandeid='".$iddemande."'";
						
                 $result = mysql_query($sql);
				$demande = mysql_fetch_assoc($result);
			
        }
	$log->debug("Exiting getInfosByOM method ...");
        return $demande;
}

?>