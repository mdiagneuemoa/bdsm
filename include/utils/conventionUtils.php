
<?php


	require_once('include/DatabaseUtil.php');
	require_once('include/database/PearDatabase.php');
	
	function saveProduiFinancier($jsonData)
	{
		global $adb;
		$prodfinvalues = json_decode($jsonData, true);
		$dt = new DateTime($prodfinvalues['dateprodfin']);
		$dateprodfin = $dt->format("Y-m-d");
		$dt2 = new DateTime($prodfinvalues['dateeffetprodfin']);
		$dateeffetprodfin = $dt2->format("Y-m-d");
		$dbQuery = "INSERT INTO sigc_produitfinancier(libelle,montant,dateprodfin,dateeffetprodfin,ticket) VALUES (?,?,?,?,?)";
		$dbresult = $adb->pquery($dbQuery,array($prodfinvalues['libelleprodfin'],$prodfinvalues['montantprodfin'],$dateprodfin,$dateeffetprodfin,$prodfinvalues['numconvention']));
		if (mysql_insert_id()!=0)
			echo "Produit Financier enregistre avec succes!!!";
		else
			echo "Echec enregistrement Produit Financier!!!";
			
	}
	
	function deleteProduiFinancier($idprodfin)
	{
		global $adb;

		$dbQuery = "DELETE FROM sigc_produitfinancier WHERE idprodfin=? ";
		$dbresult = $adb->pquery($dbQuery,array($idprodfin));
			
	}
	
	function deleteCRExecution($idexecution)
	{
		global $adb;

		$dbQuery = "DELETE FROM sigc_execution_conventions WHERE idexecution=? ";
		$dbresult = $adb->pquery($dbQuery,array($idexecution));
	
	}
	
	/*
	function  getinfosproject($projectid) {

		// TO DO
		global $log, $app_strings, $nb_appels_distribues, $nb_appels_recus,$adb;
		$log->debug("Entering getinfosproject() method ...");

		
		$querydossier=" SELECT o.organecode AS organeid,o.organelibelle AS organe,o.organesigle AS organesigle,d3.dossiercode AS projetid ,d2.dossiercode AS politiqueid ,
						d2.dossierlibelle AS politique,d1.dossiercode AS programmeid,d1.dossierlibelle AS programme 
						FROM sigc_organes o,sigc_dossiers d1,sigc_dossiers d2,sigc_dossiers d3
						WHERE  o.organecode=d3.organecode 
						AND d3.dossiercode = ?
						AND d2.depth=1 AND  d2.dossierparent=CONCAT(d1.dossiercode,':',d2.dossiercode)
						AND d3.depth=2 AND d3.dossierparent = CONCAT(d1.dossiercode,':',d2.dossiercode,':',d3.dossiercode)  " ;
		$resultdossier= $adb->pquery($querydossier, array($projectid));	
		$organe = $adb->query_result($resultdossier, 0, 'organe');
		$organeid = $adb->query_result($resultdossier, 0, 'organeid');
		$politique = $adb->query_result($resultdossier, 0, 'politique');
		$politiqueid = $adb->query_result($resultdossier, 0, 'politiqueid');
		$programme = $adb->query_result($resultdossier, 0, 'programme');
		$programmeid = $adb->query_result($resultdossier, 0, 'programmeid');
		
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$dossier = array();

		
		$dossier["organeid"] = $organeid;
		$dossier["organe"] = $organe;
		$dossier["politiqueid"] = $politiqueid;
		$dossier["politique"] = $politique;
		$dossier["programmeid"] = $programmeid;
		$dossier["programme"] = $programme;
		
		$log->debug("Exiting getinfosproject method ...");
		
		return $dossier;						
	}

	*/
 
	function  infoCallReportsDB($queue = 'tigo_sn_1677') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue('$queue', @vCompleted, @vHoldtime, @vServicelevelPerf, @vCalls, @vAbandoned, @vServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
//		$queryQueue = " select (Calls + Abandoned + Completed)  as total_calls_entered, Calls  as total_calls_attente, (Completed + Abandoned)  as total_calls_distributed, Completed  as total_calls_answered, Abandoned  as total_calls_abandoned, Holdtime  as time_attente_estime, ServiceLevel as sevice_level, ServicelevelPerf as sevice_level_performance from stat_realtime_tigo_sn.queuestatus where Queue = '$queue'; " ;
		$queryQueue = " SELECT (@vCalls + @vAbandoned + @vCompleted)  as total_calls_entered, @vCalls  as total_calls_attente, (@vAbandoned + @vCompleted)  as total_calls_distributed, @vCompleted  as total_calls_answered, @vAbandoned  as total_calls_abandoned, @vHoldtime  as time_attente_estime, @vServicelevel as sevice_level, @vServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}


	function  infoCallReportsDB_Dep($queue = 'Orange_SN_dep') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB_dep() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue_dep('$queue', @vCompleted, @vHoldtime, @vServicelevelPerf, @vCalls, @vAbandoned, @vServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
//		$queryQueue = " select (Calls + Abandoned + Completed)  as total_calls_entered, Calls  as total_calls_attente, (Completed + Abandoned)  as total_calls_distributed, Completed  as total_calls_answered, Abandoned  as total_calls_abandoned, Holdtime  as time_attente_estime, ServiceLevel as sevice_level, ServicelevelPerf as sevice_level_performance from stat_realtime_tigo_sn.queuestatus where Queue = '$queue'; " ;
		$queryQueue = " SELECT (@vCalls + @vAbandoned + @vCompleted)  as total_calls_entered, @vCalls  as total_calls_attente, (@vAbandoned + @vCompleted)  as total_calls_distributed, @vCompleted  as total_calls_answered, @vAbandoned  as total_calls_abandoned, @vHoldtime  as time_attente_estime, @vServicelevel as sevice_level, @vServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom +$nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}


	function  infoCallReportsDB_111($queue = 'tigo_sn_111') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB_dep() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue_111('$queue', @vCompleted, @vHoldtime, @vServicelevelPerf, @vCalls, @vAbandoned, @vServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
		$queryQueue = " SELECT (@vCalls + @vAbandoned + @vCompleted)  as total_calls_entered, @vCalls  as total_calls_attente, (@vAbandoned + @vCompleted)  as total_calls_distributed, @vCompleted  as total_calls_answered, @vAbandoned  as total_calls_abandoned, @vHoldtime  as time_attente_estime, @vServicelevel as sevice_level, @vServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom +$nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}


	function  infoCallReportsDB_112($queue = 'tigo_sn_112') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB_dep() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue_112('$queue', @vCompleted, @vHoldtime, @vServicelevelPerf, @vCalls, @vAbandoned, @vServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
		$queryQueue = " SELECT (@vCalls + @vAbandoned + @vCompleted)  as total_calls_entered, @vCalls  as total_calls_attente, (@vAbandoned + @vCompleted)  as total_calls_distributed, @vCompleted  as total_calls_answered, @vAbandoned  as total_calls_abandoned, @vHoldtime  as time_attente_estime, @vServicelevel as sevice_level, @vServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom +$nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}


	function  infoCallReportsDB_113($queue = 'tigo_sn_113') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB_dep() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue_113('$queue', @nbCompleted, @nbHoldtime, @nbServicelevelPerf, @nbCalls, @nbAbandoned, @nbServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
		$queryQueue = " SELECT (@nbCalls + @nbAbandoned + @nbCompleted)  as total_calls_entered, @nbCalls  as total_calls_attente, (@nbAbandoned + @nbCompleted)  as total_calls_distributed, @nbCompleted  as total_calls_answered, @nbAbandoned  as total_calls_abandoned, @nbHoldtime  as time_attente_estime, @nbServicelevel as sevice_level, @nbServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom +$nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}

	function  infoCallReportsDB_1212($queue = 'Orange_SN_1212') {

		// TO DO
		global $log, $adb_statelop, $app_strings, $nb_appels_distribues, $nb_appels_recus;
		$log->debug("Entering infoCallReportsDB_dep() method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		$query ="CALL $database_tserver.Queues_Status('$queue', @nbdissuades,  @tpsmoyendist,  @tpsmoyenabandon, @tpsattentemax);";
		$adb_statelop->pquery($query, array());
		
		$query2 =" Select  @nbdissuades as total_calls_dissuaded,  @tpsmoyendist as temps_moyen_distributed, @tpsmoyenabandon as temps_moyen_abandoned, @tpsattentemax as max_time_attente; " ;
		$result = $adb_statelop->pquery($query2, array());
		$num_rows=$adb_statelop->num_rows($result);

		
		$queryQueueIni = " CALL $database_realtime.stat_queue_1212('$queue', @nbCompleted, @nbHoldtime, @nbServicelevelPerf, @nbCalls, @nbAbandoned, @nbServicelevel) "; 
		$adb_statelop->pquery($queryQueueIni, array());
		
		$queryQueue = " SELECT (@nbCalls + @nbAbandoned + @nbCompleted)  as total_calls_entered, @nbCalls  as total_calls_attente, (@nbAbandoned + @nbCompleted)  as total_calls_distributed, @nbCompleted  as total_calls_answered, @nbAbandoned  as total_calls_abandoned, @nbHoldtime  as time_attente_estime, @nbServicelevel as sevice_level, @nbServicelevelPerf as sevice_level_performance; "; 
		$resultQueue = $adb_statelop->pquery($queryQueue, array());
		$num_rowsQueue=$adb_statelop->num_rows($resultQueue);


		// Debut - Augmenter le nombre d'agents en com dans les appels recus
		
		$queryEnCom ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$adb_statelop->pquery($queryEnCom, array());
		
		$queryEnCom =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$resultEnCom = $adb_statelop->pquery($queryEnCom, array());	
		$nb_agent_encom = $adb_statelop->query_result($resultEnCom, 0, 'agent_encom');
		$nb_agent_hold = $adb_statelop->query_result($resultEnCom, 0, 'agent_hold');
		
		// Fin - Augmenter le nombre d'agents en com dans les appels recus



		$etatQueue = array();

		$total_calls_entered = 0;
		$total_calls_attente = 0;
		$total_calls_distributed = 0;
		$total_calls_answered = 0;
		$total_calls_abandoned = 0;
		$time_attente_estime = 0;
		$sevice_level = 0;
		$sevice_level_performance = 0;
		
		$total_calls_dissuaded = 0;
		$temps_moyen_distributed = 0;
		$temps_moyen_abandoned = 0;
		$max_time_attente = 0;

		$pourc_calls_distributed = 0;
		$pourc_calls_abandoned = 0;
		$pourc_calls_dissuaded = 0;
		$pourc_calls_answered = 0;

		for($i=0;$i<$num_rowsQueue;$i++) {
			$total_calls_entered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_entered');
			$total_calls_attente = $adb_statelop->query_result($resultQueue, $i, 'total_calls_attente');
			$total_calls_distributed = $adb_statelop->query_result($resultQueue, $i, 'total_calls_distributed');
			$total_calls_answered = $adb_statelop->query_result($resultQueue, $i, 'total_calls_answered');
			$total_calls_abandoned = $adb_statelop->query_result($resultQueue, $i, 'total_calls_abandoned');
			$time_attente_estime = $adb_statelop->query_result($resultQueue, $i, 'time_attente_estime');
			$sevice_level = $adb_statelop->query_result($resultQueue, $i, 'sevice_level');
			$sevice_level_performance = $adb_statelop->query_result($resultQueue, $i, 'sevice_level_performance');
		}

		for($i=0;$i<$num_rows;$i++) {
			$total_calls_dissuaded = $adb_statelop->query_result($result, $i, 'total_calls_dissuaded');
			$temps_moyen_distributed = $adb_statelop->query_result($result, $i, 'temps_moyen_distributed');
			$temps_moyen_abandoned = $adb_statelop->query_result($result, $i, 'temps_moyen_abandoned');
			$max_time_attente = $adb_statelop->query_result($result, $i, 'max_time_attente');
		}
		
		
		if(isset($total_calls_entered) && $total_calls_entered != '' && $total_calls_entered != 0) {
			$pourc_calls_distributed = round((($total_calls_distributed) / $total_calls_entered) * 100, 2);
			$pourc_calls_abandoned = round((($total_calls_abandoned) / $total_calls_entered) * 100, 2);
			$pourc_calls_dissuaded = round(($total_calls_dissuaded / $total_calls_entered) * 100, 2);
			$pourc_calls_answered = round(($total_calls_answered / $total_calls_entered) * 100, 2);
		}

		$etatQueue["total_calls_entered"] = $total_calls_entered + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_attente"] = $total_calls_attente;
		$etatQueue["total_calls_distributed"] = $total_calls_distributed + $nb_agent_encom + $nb_agent_hold;
		$etatQueue["total_calls_answered"] = $total_calls_answered + $nb_agent_encom +$nb_agent_hold;
		$etatQueue["total_calls_abandoned"] = $total_calls_abandoned;
		$etatQueue["time_attente_estime"] = $time_attente_estime;
		$etatQueue["sevice_level"] = $sevice_level;
		$etatQueue["sevice_level_performance"] = $sevice_level_performance;

		$etatQueue["total_calls_dissuaded"] = $total_calls_dissuaded;
		$etatQueue["temps_moyen_distributed"] = $temps_moyen_distributed;
		$etatQueue["temps_moyen_abandoned"] = $temps_moyen_abandoned;
		$etatQueue["max_time_attente"] = $max_time_attente;
			
		$etatQueue["pourc_calls_dissuaded"] = $pourc_calls_dissuaded;
		$etatQueue["pourc_calls_distributed"] = $pourc_calls_distributed;
		$etatQueue["pourc_calls_abandoned"] = $pourc_calls_abandoned;
		$etatQueue["pourc_calls_answered"] = $pourc_calls_answered;

		
		$log->debug("Exiting infoCallReportsDB method ...");
		
		return $etatQueue;						
	}


	function getInfoGraphDB($queue = 'Orange_CI') {
              
		// TO DO
		global $log, $adb_statelop, $app_strings;
		$log->debug("Entering getInfoGraphDB($queue) method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		//$query ="CALL stat_realtime_tigo_sn.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw);";
		$query ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$result = $adb_statelop->pquery($query, array());
		
		//$query =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw; " ;
		$query =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw, @hold as agent_hold; " ;
		$result = $adb_statelop->pquery($query, array());	
		$num_rows=$adb_statelop->num_rows($result);
		
		$etatGraph = array();
		$agents = "";
		$couleurs = "";

		$tabAgent = array();
		$tabCouleur = array();
		
		$compteur = 0;
		
		for($i=0;$i<$num_rows;$i++)
		{
			$agent_encom = $adb_statelop->query_result($result, $i, 'agent_encom');
			$agent_dispo = $adb_statelop->query_result($result, $i, 'agent_dispo');
			$agent_indispo = $adb_statelop->query_result($result, $i, 'agent_indispo');
			$agent_acw = $adb_statelop->query_result($result, $i, 'agent_acw');
			$agent_hold = $adb_statelop->query_result($result, $i, 'agent_hold');

	//		if($agent_encom != 0) {
				$agents .= $agent_encom.",";
				$couleur .= "'".$app_strings['COULEUR_ENCOM']."',";
				$compteur += 1;
				
				$tabAgent ["AGENT_ENCOM"] = $agent_encom;
				$tabCouleur [] = $app_strings['COULEUR_ENCOM'];		
	//		}
	//		if($agent_dispo != 0) {
				$agents .= $agent_dispo.",";
				$couleur .= "'".$app_strings['COULEUR_DISPO']."',";
				$compteur += 1;
				
				$tabAgent ["AGENT_DISPO"] = $agent_dispo;
				$tabCouleur [] = $app_strings['COULEUR_DISPO'];
	//		}
	//		if($agent_indispo != 0) {
				$agents .= $agent_indispo.",";
				$couleur .= "'".$app_strings['COULEUR_INDISPO']."',";
				$compteur += 1;
				
				$tabAgent ["AGENT_INDISPO"] = $agent_indispo;
				$tabCouleur [] = $app_strings['COULEUR_INDISPO'];
	//		}
	//		if($agent_acw != 0) {
				$agents .= $agent_acw.",";
				$couleur .= "'".$app_strings['COULEUR_ACW']."',";
				$compteur += 1;
				
				$agents .= $agent_hold.",";
				$couleur .= "'".$app_strings['COULEUR_HOLD']."',";
				$compteur += 1;
				
				$tabAgent ["AGENT_ACW"] = $agent_acw;
				$tabCouleur [] = $app_strings['COULEUR_ACW'];
	//		}
		}
/*
		if($compteur == 1) {
			$agents .= $agents;
			$couleur .= "'".substr($couleur, 1, strlen($couleur) - 1);;
		}
*/		
//		echo "Agents : $agents <br/> Couleur : $couleur";
		
		$etatGraph["agent"] = substr($agents, 0, strlen($agents) - 1);
		$etatGraph["couleur"] = substr($couleur, 0, strlen($couleur) - 1);
		
//		$etatGraph["agent"] = $tabAgent;
//		$etatGraph["couleur"] = $tabCouleur;


		$log->debug("Exiting getInfoGraphDB method ...");
		
		return $etatGraph;
	}	
	

	function getInfoGraphDBPM($queue = 'tigo_sn_1677') {
              
		// TO DO
		global $log, $adb_statelop, $app_strings;
		$log->debug("Entering getInfoGraphDB($queue) method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		
		//$query ="CALL stat_realtime_tigo_sn.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw);";
		$query ="CALL $database_realtime.info_graphe( '$queue', @encom,  @dispo,  @indispo, @acw, @hold);";
		$result = $adb_statelop->pquery($query, array());
		
		//$query =" Select  @encom as agent_encom,  @dispo as agent_dispo, @indispo as agent_indispo, @acw as agent_acw; " ;
		$query ="  Select  IFNULL(ROUND(((@encom * 100) / (@encom + @dispo + @indispo + @acw + @hold)), 0), 0) as agent_encom,  
					IFNULL(ROUND(((@dispo * 100) / (@encom + @dispo + @indispo + @acw + @hold)), 0), 0) as agent_dispo, 
					IFNULL(ROUND(((@indispo * 100) / (@encom + @dispo + @indispo + @acw + @hold)), 0), 0) as agent_indispo, 
					IFNULL(ROUND(((@acw * 100) / (@encom + @dispo + @indispo + @acw + @hold)), 0), 0) as agent_acw, 
					IFNULL(ROUND(((@hold * 100) / (@encom + @dispo + @indispo + @acw + @hold)), 0), 0) as agent_hold, 
					(@encom + @dispo + @indispo + @acw + @hold) as nbccx,
					@encom as nbencom,@dispo as nbdispo,@indispo as nbindispo,@acw as nbacw,@hold as nbhold; " ;
		$result = $adb_statelop->pquery($query, array());	
		
		$etatGraph = array();
		$agents = "";
		$tabNbAgent="";
		$couleurs = "";

				
		$agent_encom = $adb_statelop->query_result($result, 0, 'agent_encom');
		$agent_dispo = $adb_statelop->query_result($result, 0, 'agent_dispo');
		$agent_indispo = $adb_statelop->query_result($result, 0, 'agent_indispo');
		$agent_acw = $adb_statelop->query_result($result, 0, 'agent_acw');
		$agent_hold = $adb_statelop->query_result($result, 0, 'agent_hold');
		
		$nbencom = $adb_statelop->query_result($result, 0, 'nbencom');
		$nbdispo = $adb_statelop->query_result($result, 0, 'nbdispo');
		$nbindispo = $adb_statelop->query_result($result, 0, 'nbindispo');
		$nbacw = $adb_statelop->query_result($result, 0, 'nbacw');
		$nbhold = $adb_statelop->query_result($result, 0, 'nbhold');
		
		$nbccx = $adb_statelop->query_result($result, 0, 'nbccx');
		

		$agents .= $agent_encom.",";
		$couleur .= $app_strings['COULEUR_ENCOM'].",";
		$tabNbAgent .=$nbencom.",";
		
		$agents .= $agent_dispo.",";
		$couleur .= $app_strings['COULEUR_DISPO'].",";
		$tabNbAgent .=$nbdispo.",";
		
		$agents .= $agent_indispo.",";
		$couleur .= $app_strings['COULEUR_INDISPO'].",";
		$tabNbAgent .=$nbindispo.",";
		
		$agents .= $agent_acw.",";
		$couleur .= $app_strings['COULEUR_ACW'].",";
		$tabNbAgent .=$nbacw.",";
		
		$agents .= $agent_hold.",";
		$couleur .= $app_strings['COULEUR_HOLD'].",";
		$tabNbAgent .=$nbhold.",";
		
		$etatGraph["agent"] = substr($agents, 0, strlen($agents) - 1);
		$etatGraph["couleur"] = substr($couleur, 0, strlen($couleur) - 1);
		$etatGraph["nbagent"] = substr($tabNbAgent, 0, strlen($tabNbAgent) - 1);
		$etatGraph["nbccx"] = $nbccx;
		
		$log->debug("Exiting getInfoGraphDBPM method ...");
		
		return $etatGraph;
	}	
		
	function  infoCallReportsAST() {
/*					  
		// string nbenattente = "";
		//string tpsmoyendist ="";
		//string tpsmoyenabandon = "";
		//string tpsattentemax = "";
		ParamCampagne.Value = "Orange_CI";
		CmdQueue = new MySqlCommand("Queues_Status", cx);              
*/								
	}

	function statEtatAgentDB($logUser) {
				  
		// temps logue = "";
		//temps de com ="";
		//temps indispo = "";
		//temps post traitement = "";
              
		// TO DO
		global $log, $adb_statelop, $app_strings;
		$log->debug("Entering statEtatAgentDB($logUser) method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		
		$query ="CALL $database_tserver.Agents_Status( '$logUser', @AppelEntrant ,  @MemberName,  @TempsMoyenParle , @TempsLoggue , @TempsPause , @TempsParle , @TempsACW,  @TempsHold, @StatutEncours, @TempsEncours,@HeureFirstCon);";
		$result = $adb_statelop->pquery($query, array());
		
		$query =" Select  @AppelEntrant as total_calls_entered,  @MemberName as member_name,  @TempsMoyenParle as temps_moyen_answer, @TempsLoggue as total_time_login, @TempsPause as total_time_not_ready, @TempsParle as total_time_in_bound_talk, @TempsACW as total_time_work_acw, @TempsHold as total_time_on_hold, @StatutEncours as current_status, @TempsEncours as time_current_status; " ;
		$result = $adb_statelop->pquery($query, array());
		$num_rows=$adb_statelop->num_rows($result);

		$member_name = '';
		$total_time_login = '';
		$total_time_in_bound_talk = '';
		$total_time_not_ready = '';
		$total_time_work_acw = '';
		
		$tabAgent=array();
		
		for($i=0;$i<$num_rows;$i++)
		{
			$etatAgent = array();
			
			$total_time_login = $adb_statelop->query_result($result, $i, 'total_time_login');
			
	//		if(isset($total_time_login) && $total_time_login != '00:00:00' && $total_time_login != null) {
				$member_name = $adb_statelop->query_result($result, $i, 'member_name');
				
				//$total_calls_entered = $adb_statelop->query_result($result, $i, 'total_calls_entered');
				$total_time_login = $adb_statelop->query_result($result, $i, 'total_time_login');
				$total_time_in_bound_talk = $adb_statelop->query_result($result, $i, 'total_time_in_bound_talk');
				$total_time_not_ready = $adb_statelop->query_result($result, $i, 'total_time_not_ready');
				$total_time_work_acw = $adb_statelop->query_result($result, $i, 'total_time_work_acw');
				$total_time_on_hold = $adb_statelop->query_result($result, $i, 'total_time_on_hold');
				$current_status = $adb_statelop->query_result($result, $i, 'current_status');
				$time_current_status = $adb_statelop->query_result($result, $i, 'time_current_status');

				//if($member_name!='')
				//	$member_name .=" : "."[".$time_current_status ."]";
		}	
				//$etatAgent[$app_strings['LBL_'.$current_status]."::$current_status".";"."[".$time_current_status ."]"] = array();
				$etatAgent[$app_strings['LBL_DISPO']."::DISPO".";"."[".$total_time_login ."]"] = array();
				$etatAgent[$app_strings['LBL_ENCOM']."::COM".";"."[".$total_time_in_bound_talk ."]"] = array();
				$etatAgent[$app_strings['LBL_INDISPO']."::INDISPO".";"."[".$total_time_not_ready ."]"] = array();
				$etatAgent[$app_strings['LBL_ACW']."::ACW".";"."[".$total_time_work_acw ."]"] = array();
				$etatAgent[$app_strings['LBL_HOLD']."::HOLD".";"."[".$total_time_on_hold ."]"] = array();
				
				$tabAgent[((isset($member_name) && $member_name != '') ? $member_name:"Agent")."::".$current_status.";".$time_current_status] = $etatAgent;
//			$tabAgent[((isset($member_name) && $member_name != '') ? $member_name:"Agent")."::".$app_strings['ICONE_CAMPAGNE'].";"." "] = $etatAgent;
			
			
	
		$log->debug("Exiting statEtatAgentDB method ...");
		
		return $tabAgent;
	}

	function detailAgentDB($logUser) {
				  
		 //TempsLoggue
		 //AppelEntrant
		 //NameAgent
		 //TempsMoyenParle
		 //TempsIndispo
		 //TempsParle
		 //TempsPost
		 
		//CmdAgent = new MySqlCommand("Agents_Status", cx);           


              
		// TO DO
		global $log, $adb_statelop, $app_strings;
		$log->debug("Entering detailAgentDB($logUser) method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_tserver = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database_tserver'];	
		
		$query ="CALL $database_tserver.Agents_Status( '$logUser', @AppelEntrant ,  @MemberName,  @TempsMoyenParle , @TempsLoggue , @TempsPause , @TempsParle , @TempsACW,  @TempsHold, @StatutEncours, @TempsEncours,@HeureFirstCon);";
		$result = $adb_statelop->pquery($query, array());
		
		$query =" Select  @AppelEntrant as total_calls_entered,  @MemberName as member_name,  @TempsMoyenParle as temps_moyen_answer, @TempsLoggue as total_time_login, @TempsPause as total_time_not_ready, @TempsParle as total_time_in_bound_talk, @TempsACW as total_time_work_acw, @TempsHold as total_time_on_hold, @StatutEncours as current_status, @TempsEncours as time_current_status, @HeureFirstCon as heurefirstcon" ;
		$result = $adb_statelop->pquery($query, array());
		$num_rows=$adb_statelop->num_rows($result);
		
		
		$detailAgent = array();
		
		for($i=0;$i<$num_rows;$i++)
		{
			$member_name = $adb_statelop->query_result($result, $i, 'member_name');
			$total_calls_entered = $adb_statelop->query_result($result, $i, 'total_calls_entered');
			$total_time_login = $adb_statelop->query_result($result, $i, 'total_time_login');
			$total_time_in_bound_talk = $adb_statelop->query_result($result, $i, 'total_time_in_bound_talk');
			$total_time_not_ready = $adb_statelop->query_result($result, $i, 'total_time_not_ready');
			$total_time_work_acw = $adb_statelop->query_result($result, $i, 'total_time_work_acw');
			$temps_moyen_answer = $adb_statelop->query_result($result, $i, 'temps_moyen_answer');
			$hour_first_con = $adb_statelop->query_result($result, $i, 'heurefirstcon');

			$detailAgent["member_name"] = $member_name;
			$detailAgent["total_calls_entered"] = $total_calls_entered;
			$detailAgent["total_time_login"] = $total_time_login;
			$detailAgent["total_time_in_bound_talk"] = $total_time_in_bound_talk;
			$detailAgent["total_time_not_ready"] = $total_time_not_ready;
			$detailAgent["total_time_work_acw"] = $total_time_work_acw;
			$detailAgent["temps_moyen_answer"] = $temps_moyen_answer;
			$detailAgent["heure_first_con"] = $hour_first_con;

		}
		
		$log->debug("Exiting detailAgentDB method ...");

		return $detailAgent;
	}

	function  getEtatAgents($campagne = 'Orange_CI') {
		// TO DO
		global $log, $adb, $app_strings;
		$log->debug("Entering getEtatAgents($campagne) method ...");

		global $CAMPAGNES_STATSREALTIME, $adb_statelop;
		$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
		$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
		global $CAMPAGNES_DATABASES; 
		$database_portal = $CAMPAGNES_DATABASES[$CURRENT_CAMPAGNE]['portaldb'];
		
		$query =" select login, GROUP_CONCAT(first_name, ' ' , SUBSTRING(last_name,1,1), '.') as agent_name, statut, vtiger_groups.groupname as groupname, vtiger_groups.groupid from $database_portal.vtiger_users, $database_portal.vtiger_groups, $database_portal.vtiger_users2group, $database_realtime.agentvent
			where profil_id = 22
			and queue LIKE '%$campagne%'
			and log = concat('Agent/',login)
			and vtiger_users2group.userid = id
			and vtiger_users2group.groupid = vtiger_groups.groupid
			group by login
			order by vtiger_groups.groupid, login; " ;
			
		$result = $adb->pquery($query, array());
		$num_rows=$adb->num_rows($result);
		
		
		$tabAgent=array();
		$currentGroup = 0;
		
		for($i=0;$i<$num_rows;$i++)
		{
			$tab = array();
			$login = $adb->query_result($result, $i, 'login');
			$agent_name = $adb->query_result($result, $i, 'agent_name');
			$statut = $adb->query_result($result, $i, 'statut');
			$groupname = $adb->query_result($result, $i, 'groupname');
			$groupid = $adb->query_result($result, $i, 'groupid');
			$queue = $adb->query_result($result, $i, 'queue');
			
			if($currentGroup != $groupid) {
				if($currentGroup != 0) {
					$tabAgent[$grp] = $tabGroup;
				}
				$tabGroup = array();
				$currentGroup = $groupid;
			}
			
			//$tab["login"] = $login;
			$tab["agent_name"] = $login." - ".$agent_name;
			$tab["statut"] = $statut;
		//	$tab["groupid"] = $groupid;
		//	$tab["groupname"] = $groupname;
		//	$tab["campagne_id"] = $campagne_id;
			//$tabGroup[$login] = $tab;
			//$tabGroup[$login] = array();
			$tabGroup[$login." - ".$agent_name.":".$statut] = array();
			//$tabGroup[$login.":".$statut] = array();
			$grp = $adb->query_result($result, $i-1, 'groupname');
		}
		
		$tabAgent[$grp != '' ? $grp : $groupname] = $tabGroup;
	//	$tabAgent[$grp] = $tabGroup;
		
		$tabCampagne [$campagne] = $tabAgent;
		//$tabAgent[] = $tabGroup;
		$log->debug("Exiting getEtatAgents method ...");

		return $tabCampagne;						
	}	
	


function maxHoldTime($waitEnCour)
{
	$maxholdtime = 0;
	if (count($waitEnCour) > 1)
	{
		for ($j = 1; $j < count($waitEnCour); $j++)
		{
			if ($waitEnCour[$j] > $waitEnCour[$j - 1])
			{
				$maxholdtime = $waitEnCour[$j];
			}
			else $maxholdtime = $waitEnCour[$j - 1];

		}

		return $maxholdtime;

	}
	else if (count($waitEnCour) == 1)
	{

		$maxholdtime = $waitEnCour[0];
		return $maxholdtime;
	}
	else return 0;

}

function moyDistribution($TempscallerDistribuer)
{
	$moyDistribution = 0;
	if (count($TempscallerDistribuer) > 1)
	{
		for ($j = 0; $j < count($TempscallerDistribuer); $j++)
		{
			$moyDistribution += $TempscallerDistribuer[$j];
								
		}
		return $moyDistribution /count($TempscallerDistribuer);

	}
	else if (count($TempscallerDistribuer) == 1)
	{
		return $TempscallerDistribuer[0];
	}
	else return 0.00;

}

function moyAbandon($TempscallerAbandonner)
{
	$moyAbandon = 0;
	if (count($TempscallerAbandonner) > 1)
	{
		for ($j = 0; $j < count($TempscallerAbandonner); $j++)
		{
			$moyAbandon += $TempscallerAbandonner[$j];
								
		}

		return $moyAbandon / count($TempscallerAbandonner);

	}
	else if (count($TempscallerAbandonner) == 1)
	{
		return $TempscallerAbandonner[0];
	}
	else return 0.00;

}

function treeAgents($pere, $videok)
 {
 $nombre = 0;
 global $etatAgents;
 global $hierar;
 global $vide;
 $hierar++;
 global $texte;
 global $i;
global $app_strings;


 
	 foreach($pere as $key=>$fils)
	 {
			 $etatval = explode(":",$key);
			/* switch($etatval[1])
			 {
				case 'encom' : 'encom.png';
				case 'indispo' : 'enpause1.png';
				case 'enposttrait' : 'enposttraitement1.png';
				case 'delogue' : 'delogue.png';
			 }*/
			 $nombre++;
			 $nombrefolder = count($pere);
			 $nombresusfolder = count($fils);
			 if($nombrefolder == $nombre) $vide[$hierar] = 1;
			 else $vide[$hierar] = 0;
			 $i++;

			$texte .="<tr >";
			 
			 if($hierar > '1')
			 {
				 for($nb=1; $nb < $hierar; $nb++)
				 if($videok[$nb] == '1')
				 $texte .= '<td nowrap width=10 align=right><img src="' . vtiger_imageurl("vide.png", $theme) . '" alt="" /></td>';
				 else
				 $texte .= '<td nowrap width=10 align=right><img src="' . vtiger_imageurl("verti.png", $theme) . '" alt="" /></td>';
			 }
			 if($nombresusfolder == '0')
			 {
				 if($nombrefolder == $nombre)
				 $texte .= '<td nowrap width=10 align=right><img src="' . vtiger_imageurl("simplepetit.png", $theme) . '" /></td>';
				 else
				 $texte .= '<td nowrap width=10 align=right><img src="' . vtiger_imageurl("simple.png", $theme) . '" /></td>';
			 }
			 else
				 {
				 $texte .= '<td nowrap width=10 align=right><img class="lien"';
				
				 if($nombrefolder == $nombre)
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moinspetit.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("pluspetit.png", $theme) . '" /></td>';
				 }
				 else
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moins.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("plus.png", $theme) . '" alt="[-]" /></td>';
				 }
			 }
			
			 //AFFICHAGE DE LA LIGNE
			$etatAgentImg = "";
			switch($etatval[1]) {
				case 'LOGON' :
					$etatAgentImg = $app_strings['ICONE_LOGON'];
					break;
				case 'LOGOFF' :
					$etatAgentImg = $app_strings['ICONE_LOGOFF'];
					break;
				case 'UNKNOWN' :
					$etatAgentImg = $app_strings['ICONE_UNKNOWN'];
					break;
				case 'COM' :
					$etatAgentImg = $app_strings['ICONE_COM'];
					break;
				case 'ACW' :
					$etatAgentImg = $app_strings['ICONE_ACW'];
					break;
				case 'INDISPO' :
					$etatAgentImg = $app_strings['ICONE_INDISPO'];
					break;
				case 'DISPO' :
					$etatAgentImg = $app_strings['ICONE_DISPO'];
					break;
				case 'HOLD' :
					$etatAgentImg = $app_strings['ICONE_HOLD'];
					break;	
				default :
					if($hierar == 1) {
						$etatAgentImg = $app_strings['ICONE_CAMPAGNE'];
					}
					else {
						$etatAgentImg = $app_strings['ICONE_GROUPE'];
					}
					break;					
			}
			
			$etage = $hierar+4;

			$login = explode(" - ", $etatval[0]);
			// $texte .= ' <img src="' . vtiger_imageurl($etatAgentImg, $theme) . '" /> <a href="./tree.php?path='.$key.'">'.$etatval[0].'</a><br />';
			 $texte .= '<td nowrap colspan="'.$etage.'" align=left ><img src="' . vtiger_imageurl($etatAgentImg, $theme) . '"/> <a href="#" class="realtime" onClick="javascript:setAgentInSession(\'Agent/'.$login[0].'\')">'.$etatval[0].'</a></td>';
			 
			 $texte .="</tr>";
			 
			 //FIN AFFICHAGE DE LA LIGNE
			 $texte .= '<div id="dossier'.$i.'"';
			 if($etatAgents[$hierar] != $fils)  $texte .= ' style="display: block;"';
			 else  $texte .= ' alt="[+]" ';
			 $texte .= ' />';
			
			 treeAgents($fils, $vide);
			
			 $texte .= '</div>';

	 
	}

 $hierar--;
 return $texte;
 }

 
 
 function treeEtatAgents($pere, $videok)
 {
 $nombre = 0;
 global $etatAgents;
 global $hierar;
 global $vide;
 $hierar++;
 global $texte;
 global $i;
global $app_strings;

 
	 foreach($pere as $key=>$fils)
	 {
			 $etatval = explode("::",$key);
			/* switch($etatval[1])
			 {
				case 'encom' : 'encom.png';
				case 'indispo' : 'enpause1.png';
				case 'enposttrait' : 'enposttraitement1.png';
				case 'delogue' : 'delogue.png';
			 }*/
			 $nombre++;
			 $nombrefolder = count($pere);
			 $nombresusfolder = count($fils);
			 if($nombrefolder == $nombre) $vide[$hierar] = 1;
			 else $vide[$hierar] = 0;
			 $i++;
			 
			$texte .="<tr >";

			if($hierar > '1')
			 {
				 for($nb=1; $nb < $hierar; $nb++)
				 if($videok[$nb] == '1')
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("vide.png", $theme) . '" alt="" /></td>';
				 else
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("verti.png", $theme) . '" alt="" /></td>';
			 }
			 if($nombresusfolder == '0')
			 {
				 if($nombrefolder == $nombre)
				 $texte .= '<td nowrap align=right><img src="' . vtiger_imageurl("simplepetit.png", $theme) . '" /></td>';
				 else
				 $texte .= '<td nowrap align=right><img src="' . vtiger_imageurl("simple.png", $theme) . '" /></td>';
			 }
			 else
				 {
				 $texte .= '<td nowrap width=1% align=right><img class="lien" onclick="javascript:toggle(\'dossier'.$i.'\', this, '.$vide[$hierar].');"';
				
				 if($nombrefolder == $nombre)
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moinspetit.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("pluspetit.png", $theme) . '" /></td>';
				 }
				 else
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moins.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("plus.png", $theme) . '" alt="[-]" /></td>';
				 }
			 }
			 
			
			
			 //AFFICHAGE DE LA LIGNE
			
			$etatValue = explode(";", $etatval[1]);
			
			$etatAgentImg = "";
			switch($etatValue[0]) {
				case 'LOGON' :
					$etatAgentImg = $app_strings['ICONE_LOGON'];
					break;
				case 'LOGOFF' :
					$etatAgentImg = $app_strings['ICONE_LOGOFF'];
					break;
				case 'UNKNOWN' :
					$etatAgentImg = $app_strings['ICONE_UNKNOWN'];
					break;
				case 'COM' :
					$etatAgentImg = $app_strings['ICONE_COM'];
					break;
				case 'ACW' :
					$etatAgentImg = $app_strings['ICONE_ACW'];
					break;
				case 'INDISPO' :
					$etatAgentImg = $app_strings['ICONE_INDISPO'];
					break;
				case 'DISPO' :
					$etatAgentImg = $app_strings['ICONE_DISPO'];
					break;
				case 'HOLD' :
					$etatAgentImg = $app_strings['ICONE_HOLD'];
					break;	
				default :
					if($hierar == 1) {
						$etatAgentImg = $app_strings['ICONE_CAMPAGNE'];
					}
					else {
						$etatAgentImg = $app_strings['ICONE_GROUPE'];
					}
					break;					
			}
			
			if($hierar ==1) {
				$etage = $hierar+4;
			}

			 $texte .= '<td nowrap colspan="'.$etage.'" align=left ><img src="' . vtiger_imageurl($etatAgentImg, $theme) . '" border=0/> <a href="#" class="realtime" onClick="javascript:setEtatInSession(\''.$etatValue[0].'\')">'.$etatval[0].' : '.$etatValue[1].'</a></td>';
			 $texte .="</tr>";

			 //FIN AFFICHAGE DE LA LIGNE
			 $texte .= '<div id="dossier'.$i.'"';
			 if($etatAgents[$hierar] != $fils)  $texte .= ' style="display: block;"';
			 else  $texte .= ' alt="[+]" ';
			 $texte .= ' />';
			
			 treeEtatAgents($fils, $vide);
			
			 $texte .= '</div>';

	 
	}

 $hierar--;
 return $texte;
 }

function treeAgentsFilter($pere, $videok)
 {
 $nombre = 0;
 global $etatAgents;
 global $hierar;
 global $vide;
 $hierar++;
 global $texte;
 global $i;
global $app_strings, $current_user;


 
	 foreach($pere as $key=>$fils)
	 {
			 $etatval = explode(":",$key);
			/* switch($etatval[1])
			 {
				case 'encom' : 'encom.png';
				case 'indispo' : 'enpause1.png';
				case 'enposttrait' : 'enposttraitement1.png';
				case 'delogue' : 'delogue.png';
			 }*/
			 $nombre++;
			 $nombrefolder = count($pere);
			 $nombresusfolder = count($fils);
			 if($nombrefolder == $nombre) $vide[$hierar] = 1;
			 else $vide[$hierar] = 0;
			 $i++;
			 
			$texte .="<tr >";
			 
			 if($hierar > '1')
			 {
				 for($nb=1; $nb < $hierar; $nb++)
				 if($videok[$nb] == '1')
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("vide.png", $theme) . '" alt="" /></td>';
				 else
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("verti.png", $theme) . '" alt="" /></td>';
			 }
			 if($nombresusfolder == '0')
			 {
				 if($nombrefolder == $nombre)
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("simplepetit.png", $theme) . '" /></td>';
				 else
				 $texte .= '<td nowrap width=1% align=right><img src="' . vtiger_imageurl("simple.png", $theme) . '" /></td>';
			 }
			 else
				 {
				 $texte .= '<td nowrap width=1% align=right><img class="lien" onclick="javascript:toggle(\'dossier'.$i.'\', this, '.$vide[$hierar].');"';
				
				 if($nombrefolder == $nombre)
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moinspetit.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("pluspetit.png", $theme) . '" /></td>';
				 }
				 else
				 {
					 if($etatAgents[$hierar] != $fils)
					 $texte .= ' src="' . vtiger_imageurl("moins.png", $theme) . '" alt="[+]" /></td>';
					 else
					 $texte .= ' src="' . vtiger_imageurl("plus.png", $theme) . '" alt="[-]" /></td>';
				 }
			 }
			
			 //AFFICHAGE DE LA LIGNE
			$etatAgentImg = "";
			switch($etatval[1]) {
				case 'LOGON' :
					$etatAgentImg = $app_strings['ICONE_LOGON'];
					break;
				case 'LOGOFF' :
					$etatAgentImg = $app_strings['ICONE_LOGOFF'];
					break;
				case 'UNKNOWN' :
					$etatAgentImg = $app_strings['ICONE_UNKNOWN'];
					break;
				case 'COM' :
					$etatAgentImg = $app_strings['ICONE_COM'];
					break;
				case 'ACW' :
					$etatAgentImg = $app_strings['ICONE_ACW'];
					break;
				case 'INDISPO' :
					$etatAgentImg = $app_strings['ICONE_INDISPO'];
					break;
				case 'DISPO' :
					$etatAgentImg = $app_strings['ICONE_DISPO'];
					break;
				case 'HOLD' :
					$etatAgentImg = $app_strings['ICONE_HOLD'];
					break;	
				default :
					if($hierar == 1) {
						$etatAgentImg = $app_strings['ICONE_CAMPAGNE'];
					}
					else {
						$etatAgentImg = $app_strings['ICONE_GROUPE'];
					}
					break;					
			}

			 //AFFICHAGE DE LA LIGNE

			if($hierar ==1) {
				$etage = $hierar+4;
			}
			
			// $texte .= ' <img src="' . vtiger_imageurl($etatAgentImg, $theme) . '" /> <a href="./tree.php?path='.$key.'">'.$etatval[0].'</a><br />';
			$texte .= ' <td nowrap colspan="'.$etage.'" align=left width=99%>&nbsp;';
			if (isset($_SESSION['extension']) && $_SESSION['extension']!='')
			{
				$extensionEcoute = $_SESSION['extension'];
			}
			else
				$extensionEcoute='';
			if($etatval[1] == 'COM') {
				$texte .= ' <a href="#" class="realtime" onClick="javascript:ecouterAgent(\''.$etatval[0].'\',\''.$extensionEcoute.'\')"><img src="' . vtiger_imageurl($app_strings['ICONE_ECOUTER'], $theme) . '" border=0 title="Cliquer pour &eacute;couter cet agent"/></a>';
				/*if($current_user->profil_id != 23) 
				{
				 $texte .= ' <a href="#" onClick="javascript:entrerEnTiers(\''.$etatval[0].'\',\''.$extensionEcoute.'\')"><img src="' . vtiger_imageurl($app_strings['ICONE_ENTRER_EN_TIERS'], $theme) . '" border=0 title="Cliquer pour une entr&eacute;e en tiers"/></a> ';
				} */
			}	
			$texte .= '&nbsp;<img src="' . vtiger_imageurl($etatAgentImg, $theme) . '"/> <a href="#"  class="realtime" onClick="javascript:setAgentInSession(\'Agent/'.$etatval[0].'\')">'.$etatval[0].'</a> ';

			$texte .="</td></tr>";
		
			//FIN AFFICHAGE DE LA LIGNE
			 $texte .= '<div id="dossier'.$i.'"';
			 if($etatAgents[$hierar] != $fils)  $texte .= ' style="display: block;"';
			 else  $texte .= ' alt="[+]" ';
			 $texte .= ' />';
			
			 treeAgentsFilter($fils, $vide);
			
			 $texte .= '</div>';

	 
	}

 $hierar--;
 return $texte;
 }
 

function getAgentsByEtat($campagne = 'Orange_CI', $etat)
{
	global $log, $adb_statelop, $app_strings;
	$log->debug("Entering getAgentsByEtat($etat) method ...");

	global $CAMPAGNES_STATSREALTIME, $adb_statelop;
	$CURRENT_CAMPAGNE = $_SESSION['campagne']; 
	$database_realtime = $CAMPAGNES_STATSREALTIME [$CURRENT_CAMPAGNE]['database'];	
	
	//$query =" select distinct SUBSTRING_INDEX(log, '/', -1) as login, Nom as agent_name, statut from $database_realtime.agentvent where queue = '$campagne' and statut = '$etat'; " ;
	$query =" select distinct SUBSTRING_INDEX(log, '/', -1) as login, Nom as agent_name, statut from $database_realtime.agentvent where vqueue = '$campagne' and statut = '$etat'; " ;
		
	$result = $adb_statelop->pquery($query, array());
	$num_rows=$adb_statelop->num_rows($result);
		
	
	$libelleEtat = '';
	switch($etat) {
		case 'LOGON' :
			$libelleEtat = $app_strings['LBL_LOGON'];
			break;
		case 'COM' :
			$libelleEtat = $app_strings['LBL_ENCOM'];
			break;
		case 'ACW' :
			$libelleEtat = $app_strings['LBL_ACW'];
			break;
		case 'INDISPO' :
			$libelleEtat = $app_strings['LBL_INDISPO'];
			break;
		case 'DISPO' :
			$libelleEtat = $app_strings['LBL_DISPO'];
			break;
		case 'HOLD' :
			$libelleEtat = $app_strings['LBL_HOLD'];
			break;	
		default :
			break;					
	}
	

/*
	$folderout .= "<ul style='display:block;list-style-type:none;'>";
	$folderout .= "<li ><img src='". vtiger_imageurl($app_strings['ICONE_CAMPAGNE'], $theme) . "' border=0>[$num_rows] $libelleEtat </li>";
	$folderout .=  "<li><ul>";

	
	for($i=0;$i<$num_rows;$i++)
	{
		$tab = array();
		$login = $adb_statelop->query_result($result, $i, 'login');
		$agent_name = $adb_statelop->query_result($result, $i, 'agent_name');
		$statut = $adb_statelop->query_result($result, $i, 'statut');
		
		$etatAgentImg = $app_strings[$statut];
		$folderout .=  "<li><img src='". vtiger_imageurl($etatAgentImg, $theme) . "' border=0>$login - $agent_name</li>";		
	}
	
	$folderout .=  "</ul></li></ul>";
		
*/



	$tabEtatAgentFilter = array();
	$tab = array();

	for($i=0;$i<$num_rows;$i++)
	{
		$login = $adb_statelop->query_result($result, $i, 'login');
		$agent_name = $adb_statelop->query_result($result, $i, 'agent_name');
		$statut = $adb_statelop->query_result($result, $i, 'statut');
		
		$tab[$login." - ".$agent_name.":".$statut] = array();
	}
	$tabEtatAgentFilter["[$num_rows]".$libelleEtat.":"] = $tab;

				
	$log->debug("Exiting getAgentsByEtat method ...");

//	return $folderout;
//	return treeAgentsFilter($tabEtatAgentFilter, $vide);	
	return $tabEtatAgentFilter;
}		







?>

