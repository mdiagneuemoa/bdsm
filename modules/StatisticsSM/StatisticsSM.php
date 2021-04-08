<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('data/CRMEntity.php');
require_once('data/Tracker.php');

class StatisticsSM extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = 'nomade_reunion';
	var $table_index= 'reunionid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	//var $customFieldTable = Array('nomade_reunioncf', 'reunionid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'nomade_reunion', 'nomade_reunioncf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */

	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'nomade_reunion'   => 'reunionid',
	    'nomade_reunioncf' => 'reunionid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'Reunionid'=> Array('nomade_reunion', 'reunionid'),
		'Ticket'=> Array('nomade_reunion', 'ticket'),
		'Statut'=> Array('nomade_reunion', 'statut'),
		'Departement'=> Array('nomade_reunion', 'departement'),
		'Responssuivi'=> Array('nomade_reunion', 'responssuivi'),
		'Contact'=> Array('nomade_reunion', 'contact'),
		'Objet'=> Array('nomade_reunion', 'objet'),
		'Planning'=> Array('nomade_reunion', 'planning'),
		'Lieu'=> Array('nomade_reunion', 'lieu'),
		'Budget'=> Array('nomade_reunion', 'budget'),
		'Sourcefin'=> Array('nomade_reunion', 'sourcefin'),
		'Codebudget'=> Array('nomade_reunion', 'codebudget'),
		'Codefinre'=> Array('nomade_reunion', 'codefinre'),
		'Nbpartsetats'=> Array('nomade_reunion', 'nbpartsetats'),
		'Descpartsetats'=> Array('nomade_reunion', 'descpartsetats'),
		'Nbpartsautres'=> Array('nomade_reunion', 'nbpartsautres'),
		'Descpartsautres'=> Array('nomade_reunion', 'descpartsautres'),
		'Nbpartsuemoa'=> Array('nomade_reunion', 'nbpartsuemoa'),
		'Descpartuemoa'=> Array('nomade_reunion', 'descpartuemoa'),
		'Comptenat1'=> Array('nomade_reunion', 'comptenat1'),
		'Datedebut'=> Array('nomade_reunion', 'datedebut'),
		'Datefin'=> Array('nomade_reunion', 'datefin'),
		'Createdtime'=> Array('vtiger_crmentity', 'createdtime'),
		'Modifiedtime'=> Array('vtiger_crmentity', 'modifiedtime'),
		'Filename'=> Array('nomade_reunion', 'filename'),
		'Numdecision'=> Array('nomade_reunion', 'numdecision'),
		'Numengagement'=> Array('nomade_reunion', 'numengagement'),
		'Regisseur'=> Array('nomade_reunion', 'regisseur'),
		'Timbredc'=> Array('nomade_reunion', 'timbredc'),
		'Signatairedc'=> Array('nomade_reunion', 'signatairedc'),
		'Timbrecom'=> Array('nomade_reunion', 'timbrecom'),
		'Signatairecom'=> Array('nomade_reunion', 'signatairecom'),
		'Ticketparent'=> Array('nomade_reunion', 'ticketparent'),



		
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket',
		'Statut'=> 'statut',
		'Departement'=> 'departement',
		'Responssuivi'=> 'responssuivi',
		'Contact'=> 'contact',
		'Objet'=> 'objet',
		'Planning'=> 'planning',
		'Lieu'=> 'lieu',
		'Budget'=> 'budget',
		'Sourcefin'=> 'sourcefin',
		'Codebudget'=> 'codebudget',
		'Codefinre'=> 'codefinre',
		'Nbpartsetats'=> 'nbpartsetats',
		'Descpartsetats'=> 'descpartsetats',
		'Nbpartsautres'=> 'nbpartsautres',
		'Descpartsautres'=> 'descpartsautres',
		'Nbpartsuemoa'=> 'nbpartsuemoa',
		'Descpartuemoa'=> 'descpartuemoa',
		'Comptenat1'=> 'comptenat1',
		'Datedebut'=> 'datedebut',
		'Datefin'=> 'datefin',
		'Createdtime'=> 'createdtime',
		'Modifiedtime'=> 'modifiedtime',
		'Filename'=> 'filename',
		'Numdecision'=> 'numdecision',
		'Numengagement'=> 'numengagement',
		'Regisseur'=> 'regisseur',
		'Timbredc'=> 'timbredc',
		'Signatairedc'=> 'signatairedc',
		'Timbrecom'=> 'timbrecom',
		'Signatairecom'=> 'signatairecom',
		'Ticketparent'=> 'ticketparent',

		);
	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'ticket';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'Ticket'=> Array('nomade_reunion', 'ticket')
	);
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket'
	);

	// For Popup window record selection
	var $popup_fields = Array('ticket');

	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();

	// For Alphabetical search
	var $def_basicsearch_col = 'ticket';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'ticket';

	// Required Information for enabling Import feature
	var $required_fields = Array('ticket'=>1);

	// Callback function list during Importing
	var $special_functions = Array('set_import_assigned_user');

	var $default_order_by = 'ticket';
	var $default_sort_order='DESC';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'ticket');
	function __construct() {
		global $log, $currentModule;
		$this->column_fields = getColumnFields($currentModule);
		$this->db = new PearDatabase();
		$this->log = $log;
	}

	function getSortOrder() {
		global $currentModule;

		$sortorder = $this->default_sort_order;
		if($_REQUEST['sorder']) $sortorder = $_REQUEST['sorder'];
		else if($_SESSION[$currentModule.'_Sort_Order']) 
			$sortorder = $_SESSION[$currentModule.'_Sort_Order'];

		return $sortorder;
	}

	function getOrderBy() {
		$orderby = $this->default_order_by;
		if($_REQUEST['order_by']) $orderby = $_REQUEST['order_by'];
		else if($_SESSION[$currentModule.'_Order_By'])
			$orderby = $_SESSION[$currentModule.'_Order_By'];
		return $orderby;
	}
	
function getNextTicketReunion()
{
	global $log;
	$log->debug("Entering getNextTicketReunion method ...");
	$log->info("in getNextTicketReunion");
	global $adb ; 
	$num=0;
	$sql = "SELECT MAX(SUBSTRING(ticket,5))+1 AS numero FROM nomade_reunion";
	$result = $adb->query($sql);
	$num = $adb->query_result($result,0,"numero");	
	$nbrows = $adb->num_rows($result);
	$log->debug("Exiting getNextTicketReunion method ...");
	if ($nbrows==0) $num=1;
	//$num++ ;
	$l=strlen($num);
	$d2=date('y');
	$d=$d2;
	
	for( $i=0 ; $i< 4 - $l ; $i++ ){
		$prefix= $prefix."0" ;
	}
	$ticket='R'.$d ."-". $prefix . $num;
	
    return  $ticket;
}
function getNextTicketReunionBC($ticket)
{
	global $log;
	$log->debug("Entering getNextTicketReunionBC method ...");
	$log->info("in getNextTicketReunionBC");
	global $adb ; 
	
	$sql = "SELECT count(ticket) nbfils FROM nomade_reunion where ticketparent=? ";
	$result = $adb->pquery($sql, array($ticket));
	$nbfils = $adb->query_result($result,0,"nbfils");	
	
	$numbc = $nbfils+1;;
	$ticketbc=$ticket.'-BC0'.$numbc;
	
    return  $ticketbc;
}
function getNomPrenomDC($depart)
{
	global $log;
	$log->debug("Entering getNomPrenomDC() method ...");
       global $adb;
	
	$sql = "SELECT DISTINCT CONCAT(user_name,' ',user_firstname) AS nom
			FROM users,nomade_hierarchie 
			WHERE nomade_hierarchie.matdircab =users.user_matricule and nomade_hierarchie.direction like '".$depart."%'";
			
	$result = $adb->pquery($sql, array());
	
	$nomcomplet = $adb->query_result($result,0,"nom");
	return $nomcomplet;

}
function getNomPrenomCOM($depart)
{
	global $log;
	$log->debug("Entering getNomPrenomCOM() method ...");
       global $adb;
	
	$sql = "SELECT DISTINCT CONCAT(user_name,' ',user_firstname) AS nom
			FROM users,nomade_hierarchie 
			WHERE nomade_hierarchie.matcom =users.user_matricule and nomade_hierarchie.direction like '".$depart."%'";
			
	$result = $adb->pquery($sql, array($depart));
	
	$nomcomplet = $adb->query_result($result,0,"nom");
	return $nomcomplet;

}
function is_engageReunion($reunionid)
{
	global $log, $singlepane_view,$adb;
		$log->debug("Entering is_engageReunion(".$reunionid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(*) AS nbrow FROM nomade_reunion
				WHERE reunionid=?
				AND numengagement LIKE '050%' " ;
		$result = $adb->pquery($query, array($reunionid));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
}
function is_InitiateurReunion($matricule,$reunionid)
{	
	global $log, $singlepane_view,$adb;
	$log->debug("Entering is_InitiateurReunion(".$matricule.") method ...");
	global $app_strings, $mod_strings;
	
	$query = "SELECT count(user_id) nbrow
			FROM users,vtiger_crmentity WHERE vtiger_crmentity.smcreatorid=users.user_id
			AND setype='Reunion' AND vtiger_crmentity.crmid=? AND users.User_Matricule=? " ;
	$result = $adb->pquery($query, array($reunionid,$matricule));
	$row1 = $adb->fetchByAssoc($result);
	return $row1['nbrow'];
	
}
function check_isdemandevalide($naturedepenses,$dispbudget)
{
	//$bool = true;
	foreach($naturedepenses as $comptenat=>$depense)
	{
		$totaldepense = $depense['totaldepense'];
		$mntdispo = $dispbudget[$comptenat]['mntdispo'];
		if ($mntdispo=='') $mntdispo=0;
		
		if ($mntdispo<$totaldepense)
		{
			//echo "comptenat=",$comptenat;
			return 0;
		}
		//$tab[$comptenat]=array('totaldepense'=>$totaldepense,'mntdispo'=>$mntdispo);
	}  
	//print_r($naturedepenses);
	//echo "<br>*************<br>";
	//print_r($dispbudget);
	return 1;
}
function is_AgentDB($matricule)
{	
	global $log, $singlepane_view,$adb;
	$log->debug("Entering is_AgentDB(".$matricule.") method ...");
	global $app_strings, $mod_strings;
	
	$query = "SELECT count(*) as nbrow FROM users
				WHERE  User_Direction='01-02-136'
				AND users.User_Matricule=?" ;
	$result = $adb->pquery($query, array($matricule));
	$row1 = $adb->fetchByAssoc($result);
	return $row1['nbrow'];
}
function getInfosFiche($sfiche)
{	
	global $log, $singlepane_view,$adb;
	$log->debug("Entering getInfosFiche(".$sfiche.") method ...");
	global $app_strings, $mod_strings;
	
	$query = "SELECT dsm_sousfiche.codesfiche,dsm_sousfiche.libelle libsfiche,dsm_sousfiche.designation dessfiche,dsm_fiche.libelle libfiche,
				dsm_fiche.designation desfiche,categorie
				FROM dsm_fiche,dsm_sousfiche
				WHERE dsm_sousfiche.codefiche=dsm_fiche.codefiche
				AND dsm_sousfiche.codesfiche=?" ;
	$result = $adb->pquery($query, array($sfiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$INFOSFICHE['categorie'] = $row['categorie'];
			$INFOSFICHE['libfiche'] = $row['libfiche'];
			$INFOSFICHE['desfiche'] = $row['desfiche'];
			$INFOSFICHE['sfiches'][$row['codesfiche']] = array('libelle'=>$row['libsfiche'],'designation'=>$row['dessfiche']);
		}
	return $INFOSFICHE;
}
function getInfosLexique()
{	
	global $log, $singlepane_view,$adb;
	$log->debug("Entering getInfosLexique() method ...");
	global $app_strings, $mod_strings;
	
	$query = "SELECT secteur,codelexique,liblexique FROM dsm_lexique ORDER BY 1,2" ;
	$result = $adb->pquery($query, array());
		while ($row = $adb->fetchByAssoc($result))
		{
			$INFOSLEXIQUE[$row['secteur']][$row['codelexique']] = $row['liblexique'];
		}
	return $INFOSLEXIQUE;
}
function getInfosFaq()
{	
	global $log, $singlepane_view,$adb;
	$log->debug("Entering getInfosFaq() method ...");
	global $app_strings, $mod_strings;
	
	$query = "SELECT idfaq,question,reponse FROM dsm_faq ORDER BY 1" ;
	$result = $adb->pquery($query, array());
		while ($row = $adb->fetchByAssoc($result))
		{
			$INFOSFAQ[$i]['idfaq'] = $row['idfaq'];
			$INFOSFAQ[$i]['question'] = $row['question'];
			$INFOSFAQ[$i]['reponse'] = $row['reponse'];
			$i++;
		}
	return $INFOSFAQ;
}
function getInitiateurReunionInfos($reunionid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getInitiateurReunionInfos(".$reunionid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT user_id,CONCAT(user_firstname,' ',user_name) as nomcomplet,user_login,User_Direction,SUBSTRING(User_Direction,1,5) User_Departement,User_Matricule,user_Email
					FROM nomade_reunion,users,vtiger_crmentity 
					WHERE vtiger_crmentity.crmid=nomade_reunion.reunionid
					AND vtiger_crmentity.smcreatorid=users.user_id
					AND nomade_reunion.reunionid=?" ;
		$result = $adb->pquery($query, array($reunionid));
		$row1 = $adb->fetchByAssoc($result);
		
			return $row1;
	}
function getAllRegisseurs()
{
	global $log;
	$log->debug("Entering getAllRegisseurs() method ...");
	$log->info("in getAllRegisseurs ");

        global $adb;
       
              /*  $sql = "SELECT User_Matricule AS matricule,CONCAT(user_name,' ',user_firstname) AS nomcomplet
						FROM users where user_direction='01-02-136' ORDER BY user_name ";*/
		  $sql = "SELECT User_Matricule AS matricule,CONCAT(user_name,' ',user_firstname) AS nomcomplet
						FROM users  ORDER BY user_name ";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTAGENTS[]=$row;
	}
	 $AGENTSOPT[''] = 'Choisir le r&eacute;gisseur de la r&eacute;union...';
	 
	foreach($LISTAGENTS as $entry_key=>$agent)
	{
		$AGENTSOPT[$agent['matricule']] = $agent['nomcomplet'];
	}  
	$log->debug("Exiting getAllRegisseurs method ...");
        return $AGENTSOPT;
}	
function getSourcesFinancement()
{
	global $log;
	$log->debug("Entering getSourcesFinancement() method ...");
	$log->info("in getSourcesFinancement ");

        global $adb;
       
                $sql = "SELECT sourcefincode,sourcefinlib  FROM nomade_sourcesfinancement_reunion  ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTSOURCEFIN[]=$row;
	}
	 $SOURCEFINOPT[''] = 'Choisir la source de financement...';
	 
	foreach($LISTSOURCEFIN as $entry_key=>$sourcefin)
	{
		$SOURCEFINOPT[$sourcefin['sourcefincode']] = $sourcefin['sourcefinlib'];
	}  
	$log->debug("Exiting getSourcesFinancement method ...");
        return $SOURCEFINOPT;
}

function getTypeBudget()
{
	global $log;
	$log->debug("Entering getTypeBudget() method ...");
	$log->info("in getTypeBudget ");

        global $adb;
       
                $sql = "SELECT typebudgetid,typebudgetlib  FROM nomade_typebudget_reunion  ORDER BY 1";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTSOURCEFIN[]=$row;
	}
	 $SOURCEFINOPT[''] = 'Choisir la source de financement...';
	 
	foreach($LISTSOURCEFIN as $entry_key=>$sourcefin)
	{
		$SOURCEFINOPT[$sourcefin['typebudgetid']] = $sourcefin['typebudgetlib'];
	}  
	$log->debug("Exiting getSourcesFinancement method ...");
        return $SOURCEFINOPT;
}
function getDepartementAgent($matricule)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDepartementAgent(".$matricule.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT SUBSTRING(users.User_Direction,1,5) as depart FROM users WHERE User_Matricule=? " ;
		$result = $adb->pquery($query, array($matricule));
		$row1 = $adb->fetchByAssoc($result);
		$depart =$row1['depart'];
		
		return  $depart;
			
}

function getLibelleSfiche($sfiche)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getLibelleSfiche(".$sfiche.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT libelle FROM dsm_sousfiche WHERE codesfiche=? " ;
		$result = $adb->pquery($query, array($sfiche));
		$row1 = $adb->fetchByAssoc($result);
		$libelle =$row1['libelle'];
		
		return  $libelle;
			
}

function getInfosSfiche($sfiche)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getInfosSfiche(".$sfiche.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT * FROM dsm_sousfiche WHERE codesfiche=? " ;
		$result = $adb->pquery($query, array($sfiche));
		$row1 = $adb->fetchByAssoc($result);
		//$libelle =$row1['libelle'];
		
		return  $row1;
			
}

function getAllCategoriesFiches()
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getAllCategoriesFiches() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT DISTINCT categorie FROM dsm_fiche " ;
		$result = $adb->pquery($query, array());
		$CFICHES[]='Choisir une categorie....';
		while ($row = $adb->fetchByAssoc($result))
		{
			$CFICHES[$row['categorie']]=$row['categorie'];
		}
		return  $CFICHES;
			
}
function getAllFiches()
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getAllFiches() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT codefiche,designation,categorie FROM dsm_fiche ORDER BY categorie " ;
		$result = $adb->pquery($query, array());
		$FICHES[]='Choisir une fiche....';
		while ($row = $adb->fetchByAssoc($result))
		{
			$FICHES[$row['categorie']][$row['codefiche']]=$row['designation'];
		}
		return  $FICHES;
			
}
function getFichesByCat($cfiche)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getFichesByCat() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT codefiche,designation FROM dsm_fiche WHERE categorie=? " ;
		$result = $adb->pquery($query, array($cfiche));
		//$FICHES[]='Choisir une fiche....';
		while ($row = $adb->fetchByAssoc($result))
		{
			$FICHES[]=$row['codefiche'].':'.$row['designation'];
		}
		return  $FICHES;
			
}
function getLibelleFicheById($ficheid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getLibelleFicheById() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT UPPER(dsm_fiche.libelle) flibelle,dsm_sousfiche.designation fslibelle,systeme,source,dsm_sousfiche.unite 
					FROM dsm_sousfiche,dsm_fiche 
					WHERE dsm_fiche.codefiche=dsm_sousfiche.codefiche AND codesfiche=? " ;
		$result = $adb->pquery($query, array($ficheid));
		$row1 = $adb->fetchByAssoc($result);
			
		return  $row1;
			
}
function getAllSousFiches()
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getAllSousFiches() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT dsm_fiche.designation fdesignation,codesfiche,dsm_sousfiche.designation sfdesignation
					FROM dsm_sousfiche,dsm_fiche
					WHERE dsm_sousfiche.codefiche=dsm_fiche.codefiche
					ORDER BY dsm_fiche.designation,dsm_sousfiche.designation " ;
		$result = $adb->pquery($query, array());
		$SFICHES[]='Choisir une sous fiche....';
		while ($row = $adb->fetchByAssoc($result))
		{
			$SFICHES[$row['fdesignation']][$row['codesfiche']]=$row['sfdesignation'];
		}
		return  $SFICHES;
			
}
function getSousFichesByCodeFiche($codefiche)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getSousFichesByCodeFiche() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT codesfiche,dsm_sousfiche.designation sfdesignation
					FROM dsm_sousfiche
					WHERE  dsm_sousfiche.codefiche=?
					ORDER BY dsm_sousfiche.designation " ;
		$result = $adb->pquery($query, array($codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$SFICHES[]=$row['codesfiche'].':'.$row['sfdesignation'];
		}
		return  $SFICHES;
			
}
function IsLastLever($codeflux)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering IsLastLever() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(codeflux) nbrow FROM dsm_flux WHERE codeparent=? AND codeflux!=codeparent" ;
		$result = $adb->pquery($query, array($codeflux));
		$row = $adb->fetchByAssoc($result);
		
		return  $row['nbrow'];
			
}

function getDonneesIndicateursAnnuels($codefiche,$codepays,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateursAnnuels(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		
		$query1 = "SELECT DISTINCT dsm_indannee.annee
			FROM dsm_indannee,  dsm_flux
			WHERE dsm_indannee.codeflux=dsm_flux.codeflux AND dsm_indannee.codepays=? AND (dsm_indannee.annee>=? AND dsm_indannee.annee<=?)
			AND  dsm_flux.codesfiche=? 	AND dsm_indannee.annee!='' " ;
		$result1 = $adb->pquery($query1, array($codepays,$anneedeb,$anneefin,$codefiche));
		
		while ($row1 = $adb->fetchByAssoc($result1))
		{
			$INDICAN[$row1['annee']]=$row1['annee'];
			//print_r($DINDICATEURS[$row['codeflux']]);
		}	
//print_r($INDICAN);		
			$query = "SELECT dsm_flux.codeparent,dsm_flux.codeflux,dsm_flux.niveau,dsm_flux.intitule,dsm_flux.header
						,COALESCE(ROUND(dsm_indannee.quantite,1),0) quantite,dsm_indannee.codepays,dsm_indannee.annee,dsm_indannee.etat,dsm_indannee.statut
						FROM dsm_flux
						LEFT JOIN dsm_indannee  ON  dsm_indannee.codeflux=dsm_flux.codeflux AND dsm_indannee.codepays=?  AND (dsm_indannee.annee>=? AND dsm_indannee.annee<=?)
						WHERE  dsm_flux.codesfiche=? AND    dsm_flux.published=1
						ORDER BY  dsm_flux.codeflux" ;
					
		$result = $adb->pquery($query, array($codepays,$anneedeb,$anneefin,$codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			$DINDICATEURS[$row['codeflux']]['header']=$row['header'];
			
			$DINDICATEURS[$row['codeflux']]['data'][$row['annee']]=$row['quantite'];
			
			$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
			$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
			if ($row['annee']!='')
			$INDICATEURSAN[$row['annee']]=array('annee'=>$row['annee'],'etat'=>$row['etat'],'statut'=>$row['statut']);
			$INDICATEURS['pays']=$codepays;
			
		}
		/*foreach ($INDICAN as $kan => $an)
		{
			foreach ($DINDICATEURS as $an => $flux)
			{
				if ($an!=$row['annee'])
				{
					$DINDICATEURS[$row['codeflux']]['data'][$an]=0;
				}
			}
		}	*/
		//print_r($DINDICATEURS);
		if (count($INDICATEURSAN)!=0 && count($DINDICATEURS)!=0)
		{
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
			$INDICATEURS['params']='A'.'||'.$codefiche.'||'.$codepays.'||'.''.'||'.$anneedeb.'||'.''.'||'.$anneefin;
			
		}
		return  $INDICATEURS;
			
}

function getDonneesIndicateursCoherence1($codefiche,$codepays,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateursCoherence1(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		$j=intval($anneedeb);
		$k=$j+(intval($anneefin)-intval($anneedeb))+1;
		//echo $j.' - '.$k;
		for($i=$j; $i<$k; $i++)
		{
			$INDICATEURSAN[$i]=array('annee'=>$i,'etat'=>'&nbsp;');
			$INDICATEURSANID[$i]=$i;
		}
		//print_r($INDICATEURSAN);
		$query = "SELECT dsm_indannee.codeflux,COALESCE(ROUND(dsm_indannee.quantite,1),0) quantite,dsm_indannee.annee
			FROM dsm_indannee  WHERE  dsm_indannee.codepays=?  
			AND (dsm_indannee.annee>=? AND dsm_indannee.annee<=?)
			AND dsm_indannee.`codeflux` IN ('UR.11.03.00.02.01','FP.31.02.01','UR.11.09.02','FP.31.02.01','UR.11.10.01.02','FP.32.01',
			'BP.41.01.09.01','FP.31.01.03.01.01','FP.31.01.03.02.01','BP.41.01.12.01.02','FP.31.01.03.01.02','FP.31.01.03.02.02',
			'FP.32.02.01','SM.61.07.01','FP.32.03.02','FP.32.02.02','P.41.01.18.01','FP.35.03.02','BP.46.01.24','FP.32.03.01',
			'FP.32.02.01','FP.35.03.01')  " ;
					
		$result = $adb->pquery($query, array($codepays,$anneedeb-1,$anneefin));
		while ($row = $adb->fetchByAssoc($result))
		{
			if (stristr($row['codeflux'],'UR.') && $codepays=='SN')
				$DINDICATEUR[$row['codeflux']][$row['annee']]=$row['quantite']/1000;
			else
				$DINDICATEUR[$row['codeflux']][$row['annee']]=$row['quantite'];
			//$INDICATEURSAN[$row['annee']]=$row['annee'];
			
		}
		foreach ($INDICATEURSANID as $kan => $an)
		{
			$DINDICATEURS['COH01.01']['intitule']='I. TOFE / Comptes &eacute;conomiques';
			$DINDICATEURS['COH01.01']['data'][$an]='';
			$DINDICATEURS['COH01.01']['niveau']=0;
			$DINDICATEURS['COH01.01']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.01']['intitule']='Valeur Ajout&eacute;e des administrations publiques CE (1)';
			$DINDICATEURS['COH01.01.01']['data'][$an]=$DINDICATEUR['UR.11.03.00.02.01'][$an];
			$DINDICATEURS['COH01.01.01']['niveau']=1;
			$DINDICATEURS['COH01.01.01']['codeparent']='COH01.01';
			$DINDICATEURS['COH01.01.02']['intitule']='R&eacute;mun&eacute;ration des Salari&eacute;s (2)';
			$DINDICATEURS['COH01.01.02']['data'][$an]=$DINDICATEUR['FP.31.02.01'][$an];
			$DINDICATEURS['COH01.01.02']['niveau']=1;
			$DINDICATEURS['COH01.01.02']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.03']['intitule']='Ratio (2)/(1) (en %)';
			$DINDICATEURS['COH01.01.03']['data'][$an]=($DINDICATEURS['COH01.01.02']['data'][$an]/$DINDICATEURS['COH01.01.01']['data'][$an])*100;
			$DINDICATEURS['COH01.01.03']['niveau']=1;
			$DINDICATEURS['COH01.01.03']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.04']['intitule']='Consommation Finale Publique CE (1)';
			$DINDICATEURS['COH01.01.04']['data'][$an]=$DINDICATEUR['UR.11.09.02'][$an];
			$DINDICATEURS['COH01.01.04']['niveau']=1;
			$DINDICATEURS['COH01.01.04']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.05']['intitule']='R&eacute;mun&eacute;ration des Salari&eacute;s (2)';
			$DINDICATEURS['COH01.01.05']['data'][$an]=$DINDICATEUR['FP.31.02.01'][$an];
			$DINDICATEURS['COH01.01.05']['niveau']=1;
			$DINDICATEURS['COH01.01.05']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.06']['intitule']='Ratio (2)/(1) (en %)';
			$DINDICATEURS['COH01.01.06']['data'][$an]=($DINDICATEURS['COH01.01.05']['data'][$an]/$DINDICATEURS['COH01.01.04']['data'][$an])*100;
			$DINDICATEURS['COH01.01.06']['niveau']=1;
			$DINDICATEURS['COH01.01.06']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.07']['intitule']=' FBCF publique CE (1)';
			$DINDICATEURS['COH01.01.07']['data'][$an]=$DINDICATEUR['UR.11.10.01.02'][$an];
			$DINDICATEURS['COH01.01.07']['niveau']=1;
			$DINDICATEURS['COH01.01.07']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.08']['intitule']='Acquisitions nettes d\'actifs non financiers (2)';
			$DINDICATEURS['COH01.01.08']['data'][$an]=$DINDICATEUR['FP.32.01'][$an];
			$DINDICATEURS['COH01.01.08']['niveau']=1;
			$DINDICATEURS['COH01.01.08']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.01.09']['intitule']='Ratio (2)/(1) (en %)';
			$DINDICATEURS['COH01.01.09']['data'][$an]=($DINDICATEURS['COH01.01.07']['data'][$an]/$DINDICATEURS['COH01.01.08']['data'][$an])*100;
			$DINDICATEURS['COH01.01.09']['niveau']=1;
			$DINDICATEURS['COH01.01.09']['codeparent']='COH01.01';
			
			$DINDICATEURS['COH01.02']['intitule']='II TOFE/Balance paiements';
			$DINDICATEURS['COH01.02']['data'][$an]='';
			$DINDICATEURS['COH01.02']['niveau']=0;
			$DINDICATEURS['COH01.02']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.01']['intitule']='Revenus secondaires des Adminsitrations Publiques BDP (1) ';
			$DINDICATEURS['COH01.02.01']['data'][$an]=$DINDICATEUR['BP.41.01.09.01'][$an];
			$DINDICATEURS['COH01.02.01']['niveau']=1;
			$DINDICATEURS['COH01.02.01']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.02']['intitule']='Dons courants re&ccedil;us (d\'APu &eacute;trang&egrave;res et d\'Organisations Internationales) TOFE (2) ';
			$DINDICATEURS['COH01.02.02']['data'][$an]=$DINDICATEUR['FP.31.01.03.01.01'][$an]+$DINDICATEUR['FP.31.01.03.02.01'][$an];
			$DINDICATEURS['COH01.02.02']['niveau']=1;
			$DINDICATEURS['COH01.02.02']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.03']['intitule']=' Ecart (1)-(2) ';
			$DINDICATEURS['COH01.02.03']['data'][$an]=$DINDICATEURS['COH01.02.01']['data'][$an]-$DINDICATEURS['COH01.02.02']['data'][$an];
			$DINDICATEURS['COH01.02.03']['niveau']=1;
			$DINDICATEURS['COH01.02.03']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.04']['intitule']=' Dons projets / Transferts de capital des administrations publiques - BDP (1)';
			$DINDICATEURS['COH01.02.04']['data'][$an]=$DINDICATEUR['BP.41.01.12.01.02'][$an];
			$DINDICATEURS['COH01.02.04']['niveau']=1;
			$DINDICATEURS['COH01.02.04']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.05']['intitule']=' Dons en capital (re&ccedil;us d\'APu &eacute;trang&egrave;res et d\'Organisations Internationales) TOFE (2)';
			$DINDICATEURS['COH01.02.05']['data'][$an]=$DINDICATEUR['FP.31.01.03.01.02'][$an]+$DINDICATEUR['FP.31.01.03.02.02'][$an];
			$DINDICATEURS['COH01.02.05']['niveau']=1;
			$DINDICATEURS['COH01.02.05']['codeparent']='COH01.02';
			
			$DINDICATEURS['COH01.02.06']['intitule']=' Ecart (1)-(2) ';
			$DINDICATEURS['COH01.02.06']['data'][$an]=$DINDICATEURS['COH01.02.04']['data'][$an]-$DINDICATEURS['COH01.02.05']['data'][$an];
			$DINDICATEURS['COH01.02.06']['niveau']=1;
			$DINDICATEURS['COH01.02.06']['codeparent']='COH01.02';
			
				
			$DINDICATEURS['COH01.03']['intitule']='III TOFE /SMI';
			$DINDICATEURS['COH01.03']['data'][$an]='';
			$DINDICATEURS['COH01.03']['niveau']=0;
			$DINDICATEURS['COH01.03']['codeparent']='COH01.03';
			
			$DINDICATEURS['COH01.03.01']['intitule']='Financement int&eacute;rieur bancaire TOFE (1)';
			$DINDICATEURS['COH01.03.01']['data'][$an]=$DINDICATEUR['FP.32.02.01'][$an];
			$DINDICATEURS['COH01.03.01']['niveau']=1;
			$DINDICATEURS['COH01.03.01']['codeparent']='COH01.03';
			
			$DINDICATEURS['COH01.03.02']['intitule']=' Variation des Cr&eacute;ances nettes sur l\'Administration centrale SMI (2)';
			$an2=intval($an)-1;
			$DINDICATEURS['COH01.03.02']['data'][$an]=$DINDICATEUR['SM.61.07.01'][$an]-$DINDICATEUR['SM.61.07.01'][$an2];
			$DINDICATEURS['COH01.03.02']['niveau']=1;
			$DINDICATEURS['COH01.03.02']['codeparent']='COH01.03';
			
			$DINDICATEURS['COH01.03.03']['intitule']=' Ecart (1)-(2) ';
			$DINDICATEURS['COH01.03.03']['data'][$an]=$DINDICATEURS['COH01.03.01']['data'][$an]-$DINDICATEURS['COH01.03.02']['data'][$an];
			$DINDICATEURS['COH01.03.03']['niveau']=1;
			$DINDICATEURS['COH01.03.03']['codeparent']='COH01.03';
			
			$DINDICATEURS['COH01.04']['intitule']='IV. TOFE / Dette publique ext&eacute;rieure & balance de paiements';
			$DINDICATEURS['COH01.04']['data'][$an]='';
			$DINDICATEURS['COH01.04']['niveau']=0;
			$DINDICATEURS['COH01.04']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.01']['intitule']='Financement ext&eacute;rieur net';
			$DINDICATEURS['COH01.04.01']['data'][$an]='';
			$DINDICATEURS['COH01.04.01']['niveau']=1;
			$DINDICATEURS['COH01.04.01']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.01.01']['intitule']='- Finances publiques (a)';
			$DINDICATEURS['COH01.04.01.01']['data'][$an]=$DINDICATEUR['FP.32.03.02'][$an]-$DINDICATEUR['FP.32.02.02'][$an];
			$DINDICATEURS['COH01.04.01.01']['niveau']=2;
			$DINDICATEURS['COH01.04.01.01']['codeparent']='COH01.04.01';
			
			$DINDICATEURS['COH01.04.01.02']['intitule']='- Balance des paiements (b)';
			$DINDICATEURS['COH01.04.01.02']['data'][$an]=$DINDICATEUR['BP.41.01.18.01'][$an];
			$DINDICATEURS['COH01.04.01.02']['niveau']=2;
			$DINDICATEURS['COH01.04.01.02']['codeparent']='COH01.04.01';
			
			$DINDICATEURS['COH01.04.01.03']['intitule']='- Dette ext&eacute;rieure (c)';
			$DINDICATEURS['COH01.04.01.03']['data'][$an]=$DINDICATEUR['FP.35.03.02 '][$an]-$DINDICATEUR['FP.35.03.02 '][intval($an)-1];
			$DINDICATEURS['COH01.04.01.03']['niveau']=2;
			$DINDICATEURS['COH01.04.01.03']['codeparent']='COH01.04.01';
			
			$DINDICATEURS['COH01.04.02']['intitule']=' Ecart (a)-(b)';
			$DINDICATEURS['COH01.04.02']['data'][$an]=$DINDICATEURS['COH01.04.01.01']['data'][$an]-$DINDICATEURS['COH01.04.01.02']['data'][$an];
			$DINDICATEURS['COH01.04.02']['niveau']=1;
			$DINDICATEURS['COH01.04.02']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.03']['intitule']='Ecart (a)-(c)';
			$DINDICATEURS['COH01.04.03']['data'][$an]=$DINDICATEURS['COH01.04.01.01']['data'][$an]-$DINDICATEURS['COH01.04.01.03']['data'][$an];
			$DINDICATEURS['COH01.04.03']['niveau']=1;
			$DINDICATEURS['COH01.04.03']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.04']['intitule']='Ecart (b)-(c)';
			$DINDICATEURS['COH01.04.04']['data'][$an]=$DINDICATEURS['COH01.04.01.02']['data'][$an]-$DINDICATEURS['COH01.04.01.03']['data'][$an];
			$DINDICATEURS['COH01.04.04']['niveau']=1;
			$DINDICATEURS['COH01.04.04']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.05']['intitule']='Variation des avoirs ext&eacute;rieurs nets';
			$DINDICATEURS['COH01.04.05']['data'][$an]='';
			$DINDICATEURS['COH01.04.05']['niveau']=1;
			$DINDICATEURS['COH01.04.05']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.04.05.01']['intitule']='- Balance des Paiments (a)';
			$DINDICATEURS['COH01.04.05.01']['data'][$an]=$DINDICATEUR['BP.46.01.24'][$an];
			$DINDICATEURS['COH01.04.05.01']['niveau']=2;
			$DINDICATEURS['COH01.04.05.01']['codeparent']='COH01.04.05';
			
			$DINDICATEURS['COH01.04.05.02']['intitule']='- Situation mon&eacute;taire Int&eacute;gr&eacute;e (b)';
			$DINDICATEURS['COH01.04.05.02']['data'][$an]=$DINDICATEUR['SM.61.06'][$an]-$DINDICATEUR['SM.61.06'][intval($an)-1];
			$DINDICATEURS['COH01.04.05.02']['niveau']=2;
			$DINDICATEURS['COH01.04.05.02']['codeparent']='COH01.04.05';
			
			$DINDICATEURS['COH01.04.06']['intitule']='Ecart (a)-(b)';
			$DINDICATEURS['COH01.04.06']['data'][$an]=$DINDICATEURS['COH01.04.05.01']['data'][$an]-$DINDICATEURS['COH01.04.05.02']['data'][$an];
			$DINDICATEURS['COH01.04.06']['niveau']=1;
			$DINDICATEURS['COH01.04.06']['codeparent']='COH01.04';
			
			$DINDICATEURS['COH01.05']['intitule']='V. TOFE /  Dette publique int&eacute;rieure';
			$DINDICATEURS['COH01.05']['data'][$an]='';
			$DINDICATEURS['COH01.05']['niveau']=0;
			$DINDICATEURS['COH01.05']['codeparent']='COH01.05';
			
			$DINDICATEURS['COH01.05.01']['intitule']='Variation nette';
			$DINDICATEURS['COH01.05.01']['data'][$an]='';
			$DINDICATEURS['COH01.05.01']['niveau']=1;
			$DINDICATEURS['COH01.05.01']['codeparent']='COH01.05';
			
			$DINDICATEURS['COH01.05.01.01']['intitule']='- Finances publiques (1)';
			$DINDICATEURS['COH01.05.01.01']['data'][$an]=$DINDICATEUR['FP.32.03.01'][$an]-$DINDICATEUR['FP.32.02.01'][$an];
			$DINDICATEURS['COH01.05.01.01']['niveau']=2;
			$DINDICATEURS['COH01.05.01.01']['codeparent']='COH01.05.01';
			
			$DINDICATEURS['COH01.05.01.02']['intitule']='- Dette publique (2)';
			$DINDICATEURS['COH01.05.01.02']['data'][$an]=$DINDICATEUR['FP.35.03.01'][$an]-$DINDICATEUR['FP.35.03.01'][intval($an)-1];
			$DINDICATEURS['COH01.05.01.02']['niveau']=2;
			$DINDICATEURS['COH01.05.01.02']['codeparent']='COH01.05.01';
			
			$DINDICATEURS['COH01.05.02']['intitule']='Ecart (1)-(2)';
			$DINDICATEURS['COH01.05.02']['data'][$an]=$DINDICATEURS['COH01.05.01.01']['data'][$an]-$DINDICATEURS['COH01.05.01.02']['data'][$an];
			$DINDICATEURS['COH01.05.02']['niveau']=1;
			$DINDICATEURS['COH01.05.02']['codeparent']='COH01.05';
			
		}	
		//print_r($DINDICATEURS);
		if (count($INDICATEURSAN)!=0 && count($DINDICATEURS)!=0)
		{
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
		}
		return  $INDICATEURS;
			
}
function showStatisticsAnnuelles($statistics)
{
	if (count($statistics)==0 || count($statistics['annee'])==0 )
		{
			$tab .= '<br><table border=0 cellspacing=1 cellpadding=3  width="100%">';
			
				$tab .= '<tr><td class="info" align=center>Aucune donn&eacute;e trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
				$tab .= '</table>';
			
		}
		else
		{
			//$tab .= '<div id="container" style="style="float: left; width: 310px;margin-right: 10px;padding-right:0px;padding-left:0px;">';
			
			$statistics['params'].='||'.'DOWNLOADDATAS';
			$tab .= '<div id="table_gauche">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small"> ';
			/*$tab .= '<tr><td  nowrap align="left" colspan=2>
				<input name="export" type="button" class="crmbutton small create" onClick="ExportExcell(\''.$statistics['params'].'\');" value=" Export XSL">
								
				</td>	
			</tr>';*/
			$tab .= '<tr><td class="lvtCol" nowrap align="left">
					<input name="export" type="button" class="crmbutton small create" onClick="ExportExcell(\''.$statistics['params'].'\');" value=" Export XSL">
									
					</td>
					<td class="lvtCol" height=20>
			<table width=95%><tr><td nowrap>Devise/Unit&eacute; : '.$statistics['fiche']['unite'].'</td></tr></table></td>';
			
			
			$tab .= '<tr><td class="lvtCol">CODE <br>&nbsp;</td><td class="lvtCol">INTITULE<br>&nbsp;</td>';
						
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
								
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				$tab .= '<td nowrap class="datastat" >'.$codeflux.'</td><td class="datastat"  nowrap >'.$decal.' '.$data['intitule'].'</td>';
				
				
			}
			$tab .= '</table>';
			$tab .= '</div>';    
			$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			/*$tab .= '<tr><td  nowrap align="left" colspan=20>
					<input name="prepare" type="button" class="crmbutton small create" onClick="callPrepare();" disabled value=" Remetrre en pr&eacute;paration">&nbsp;
					<input name="modifier" type="button" class="crmbutton small create" onClick="callSubmit();" disabled value=" Soumettre (Sectoriel) ">&nbsp;
					<input name="valider" type="button" class="crmbutton small create" onClick="callValidate();" disabled value=" Valider (CNPE) ">&nbsp;
					<input name="publier" type="button" class="crmbutton small create" onClick="callPublish();" disabled value="  Viser (Commission) ">&nbsp;
					<input name="publier" type="button" class="crmbutton small create" onClick="callPublish();" disabled value="  Publier ">&nbsp;
					
					</td>	
			</tr>';*/
			$tab .= '<tr><td class="lvtCol" colspan=20 align=left height=20 nowrap><img src="themes/images/'.$statistics['pays'].'.JPG" height=10 width=20 border=0>&nbsp;'.$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'].'</td></tr>';
			
			$tab .= '<tr>';
			
			$AnneArrayObject = new ArrayObject($statistics['annee']);
			$AnneArrayObject->asort();
		
			foreach ($AnneArrayObject as $annee => $data)
			{
				$tab .= '<td align=center class="lvtCol" width=50><b>'.$data['annee'].'</b> <br>'.$data['etat'].'</td>';
			}
			$tab .= '</tr>';
			$decal='';
			
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				
				if ($data['header']==1)
				{
					$tab .= '<tr bgcolor=white class="'.$niveaustyle.'">';
					$tab .= '<td align=center class="datastat" colspan='.count($statistics['annee']).'>&nbsp;</td>';

				}
				else
				{
					$tab .= '<tr bgcolor=white >';
					foreach ($statistics['annee'] as $an => $dataan)
					{
						if ($data['data'][$dataan['annee']]!='' && $data['data'][$dataan['annee']]!=0)
							$tab .= '<td align=center class="datastat"  nowrap>'.number_format($data['data'][$dataan['annee']], 1, '.', ' ').'</td>';
						else
							$tab .= '<td align=center class="datastat" >-</td>';
						
					}
				}
			}
			$tab .= '</table>';
			$tab .= '</div>';    
			$tab .= '<tr><td  colspan=25><table width=90%><tr><td><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">Source :</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['systeme'].'</span></td>';
			$tab .= '<td  ><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">M&eacute;thodologie / Syst&egrave;me:</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['source'].'</span></td></tr></table></td></tr>';
			
			/*$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			$tab .= '<tr>';
			foreach ($statistics['annee'] as $annee => $data)
			{
				$tab .= '<td align=center class="lvtCol" width=50><b>'.$data['annee'].'</b> <br>'.$data['etat'].'</td>';
			}
			$tab .= '</tr>';
			
			foreach ($statistics['datas'] as $annee => $dataflux)
			{
				
				$tab .= '<tr bgcolor=white>';
				foreach ($dataflux['data'] as $an => $dataan)
				{
					if ($dataan!='' && $dataan!=0)
						$tab .= '<td align=center style="height:10px">'.$dataan.'</td>';
					else
						$tab .= '<td align=center style="height:10px">-</td>';
					
				}
				$tab .= '</tr>';
			}
			
			$tab .= '</table>';
			$tab .= '</div>';*/
		}		
		return $tab;
			
}

function getFormIndicateursAnnuels($codefiche,$codepays,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getFormIndicateursAnnuels() method ...");
		global $app_strings, $mod_strings;
		
		$query1 = "SELECT DISTINCT dsm_indannee.annee
			FROM dsm_indannee,  dsm_flux
			WHERE dsm_indannee.codeflux=dsm_flux.codeflux AND dsm_indannee.codepays=? AND (dsm_indannee.annee>=? AND dsm_indannee.annee<=?)
			AND  dsm_flux.codesfiche=? 	AND dsm_indannee.annee!='' " ;
		$result1 = $adb->pquery($query1, array($codepays,$anneedeb,$anneefin,$codefiche));
		
		while ($row1 = $adb->fetchByAssoc($result1))
		{
			$INDICAN[$row1['annee']]=$row1['annee'];
			//print_r($DINDICATEURS[$row['codeflux']]);
		}	
//print_r($INDICAN);		
			$query = "SELECT dsm_flux.codeparent,dsm_flux.codeflux,dsm_flux.niveau,dsm_flux.intitule
						,COALESCE(ROUND(dsm_indannee.quantite,1),0) quantite,dsm_indannee.codepays,dsm_indannee.annee,dsm_indannee.etat,dsm_indannee.statut
						FROM dsm_flux
						LEFT JOIN dsm_indannee  ON  dsm_indannee.codeflux=dsm_flux.codeflux AND dsm_indannee.codepays=?  AND (dsm_indannee.annee>=? AND dsm_indannee.annee<=?)
						WHERE  dsm_flux.codesfiche=?    
						ORDER BY  dsm_flux.codeflux" ;
					
		$result = $adb->pquery($query, array($codepays,$anneedeb,$anneefin,$codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			
			$DINDICATEURS[$row['codeflux']]['data'][$row['annee']]=$row['quantite'];
			
			$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
			$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
			if ($row['annee']!='')
			$INDICATEURSAN[$row['annee']]=array('annee'=>$row['annee'],'etat'=>$row['etat'],'statut'=>$row['statut']);
			
		}
		/*foreach ($INDICAN as $kan => $an)
		{
			foreach ($DINDICATEURS as $an => $flux)
			{
				if ($an!=$row['annee'])
				{
					$DINDICATEURS[$row['codeflux']]['data'][$an]=0;
				}
			}
		}	*/
		//print_r($DINDICATEURS);
		//if (count($INDICATEURSAN)!=0 && count($DINDICATEURS)!=0)
		//{
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
			$INDICATEURS['params']='A'.'||'.$codefiche.'||'.$codepays.'||'.''.'||'.$anneedeb.'||'.''.'||'.$anneefin;
		//}
		return  $INDICATEURS;
			
}
function showFormAnnuelles($statistics,$codepays,$anneedeb,$anneefin)
{
	if (count($statistics)==0)
	{
		$tab .= '<br><table align="center" border=0 cellspacing=1 cellpadding=3  width="100%">';
		
			$tab .= '<tr><td class="info" align=center>Aucune fiche trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
			$tab .= '</table>';
		
	}
	else
	{	//echo "codepays=",$codepays;
		$j=intval($anneedeb);
		$k=$j+(intval($anneefin)-intval($anneedeb))+1;
		//echo $j.' - '.$k;
		for($i=$j; $i<$k; $i++)
		{
			$INDICATEURSAN[$i]=$i;
		}

		$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small"> ';
		$tab .= '<tr><td class="lvtCol" align=center colspan=25>SAISIE '.$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'].'</td>';
		$tab .= '<tr><td class="lvtCol" colspan=25><table cellspacing=1 cellpadding=1 width=90%><tr><td><img src="themes/images/'.$codepays.'.JPG" height=20 width=20 border=0></td><td align=center>Ann&eacute;e de base : ';
		$tab .= '<select name="anneebase" id="anneebase" class="txtBox" style="width:100px">';
		for($i=1980;$i<=2020;$i++)
		{
			$tab .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$tab .= '</select></td>';
		$tab .= '<td  >Syst&egrave;me : &nbsp;&nbsp;<input type="text" name="systeme" id="systeme" size="20"></td></tr></table></td></tr>';
		$tab .= '<tr><td class="lvtCol">CODE <br>&nbsp;</td><td class="lvtCol">INTITULE<br>&nbsp;</td>';
		$AnneArrayObject = new ArrayObject($INDICATEURSAN);
		$AnneArrayObject->asort();
		foreach ($AnneArrayObject as $annee => $data2)
		{
			$tab .= '<td align=center class="lvtCol" width=50><b>'.$data2.'</b> <br>';
			$tab .= '<select name="etat_'.$data2.'" id="etat_'.$data2.'" class="txtBox" style="width:80px">';
			$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
			$tab .= '</select></td>';
		}	
		$tab .= '</tr>';
		$f=1;
		$flux ='';
		foreach($statistics['datas'] as $codeflux => $data)
		{
			
			if (substr($data['intitule'],1,4)== 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='fichedont';
			}
			if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='';
				$niveaustyle='fichen1';
			}
			elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='fichen2';
			}
			elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='fichen3';
			}
			elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='';
			}
			elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='';
			}
			elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
			{
				$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				$niveaustyle='';
			}
							
			$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
			$tab .= '<td nowrap class="datastat" >'.$codeflux.'</td><td class="datastat"  nowrap >'.$decal.' '.$data['intitule'].'</td>';
			
			foreach ($AnneArrayObject as $annee => $data2)
			{
				$flux .= 'ind_'.$codeflux.'_'.$annee.'||';
				if ($this->IsLastLever($codeflux)==0 && $data['niveau']!=0) $showinput=""; else $showinput="disabled";
				
				if ($data['data'][$annee]!='' && $data['data'][$annee]!=0)
					$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$annee.'" value="'.$data['data'][$annee].'"id="ind_'.$codeflux.'_'.$annee.'" size="4"></td>';
				else
					$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$annee.'" id="ind_'.$codeflux.'_'.$annee.'" size="4"></td>';
				
			}
			
			$tab .= '</tr>';
		}
			$tab .= '<tr><td class="small" nowrap align="center" colspan=10>
					<input name="submit" type="button" class="crmbutton small create" onClick="PasteDatasFromExcel(\''.$flux.'\');"  value=" PasteDatasFromExcel ">&nbsp;
				</td>	
			</tr>';		
		$tab .= '<tr><td class="small" nowrap align="center" colspan=10>
					<input name="submit" type="button" class="crmbutton small create" onClick="callSaisie();" disabled value=" Enregistrer la saisie ">&nbsp;
				</td>	
			</tr>';
		$tab .= '</table>';
		$tab .= '</div>';    
	
	}		
		return $tab;
			
}

function showFormUpload($statistics,$codepays,$anneedeb,$anneefin)
{
	if (count($statistics)==0)
	{
		$tab .= '<br><table align="center" border=0 cellspacing=1 cellpadding=3  width="100%">';
		
			$tab .= '<tr><td class="info" align=center>Aucune fiche trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
			$tab .= '</table>';
		
	}
	else
	{	//echo "codepays=",$codepays;
		$j=intval($anneedeb);
		$k=$j+(intval($anneefin)-intval($anneedeb))+1;
		//echo $j.' - '.$k;
		for($i=$j; $i<$k; $i++)
		{
			$INDICATEURSAN[$i]=array('annee'=>$i);
		}
		$statistics['params'].='||'.'DOWNLOADTEMPLATE';
		//$statistics['annee']=$INDICATEURSAN;
		//$statistics['datas']['data']=array();
		$filename = str_replace(" ","_",$statistics['fiche']['flibelle']).'-'.$codepays.'_'.$anneedeb.'-'.$anneefin.'.xls';
		$tab .= '<table border=0 cellspacing=3 cellpadding=3 width=70% class="lvt small" align=center> ';
		$tab .= '<tr><td class="lvtCol" align=center colspan=4>CHARGEMENT '.$statistics['fiche']['fslibelle'].'</td>';
		$tab .= '<tr><td class="lvtCol" >Ann&eacute;e de base : ';
		$tab .= '<select name="anneebase" id="anneebase" class="txtBox" style="width:100px">';
		for($i=1980;$i<=2020;$i++)
		{
			$tab .= '<option value="'.$i.'">'.$i.'</option>';
		}
		$tab .= '</select></td>';
		$tab .= '<td  class="lvtCol" >Syst&egrave;me : &nbsp;&nbsp;<input type="text" name="systeme" id="systeme" size="20"></td></tr>';
		
		$tab .= '<tr><td class="lvtCol">T&eacute;l&eacute;charger la maquette Excel &agrave  compl&eacute;ter : </td>';
		$tab .= '<td align=center class="lvtCol"><a href = "#" onClick="ExportExcell(\''.$statistics['params'].'\');">'.$filename.'</a><br>';
		$tab .= '</td>';
		$tab .= '</tr>';
		
		$tab .= '<tr><td class="lvtCol">Joindre le fichier Excel &agrave  charger : </td>';
		$tab .= '<td align=center class="lvtCol"><input type="file" accept=".xls"></td>';
		$tab .= '</tr>';
			
		$tab .= '<tr><td class="small" nowrap align="center" class="lvtCol" colspan=4>
					<input name="submit" type="button" class="crmbutton small create" onClick="callUploadFile();" disabled value=" Lancer le chargement ">&nbsp;
				</td>	
			</tr>';
		$tab .= '</table>';
		$tab .= '</div>';    
	
	}		
	return $tab;
			
}
function downloadDonneesAnnuelles($statistics,$paramstats)
{
	
global $tmp_dir, $root_directory,$CODEPAYSUEMOA;

$fname = tempnam($root_directory.$tmp_dir, "merge2.xls");
$workbook = &new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet();


# Set the column width for columns 1, 2, 3 and 4
$worksheet->set_column(0, 0,20);
$worksheet->set_column(1, 1,50);
# Create a format for the column headings
$header =& $workbook->addformat();
$header->set_bold();
$header->set_size(10);
$header->set_align('left');
$header->set_color('blue');
$header->set_border(0);

$libelle =& $workbook->addformat();
$libelle->set_bold();
$libelle->set_size(10);
$libelle->set_align('left');
$libelle->set_border(1);

$intitule =& $workbook->addformat();
$intitule->set_bold();
$intitule->set_size(10);
$intitule->set_align('left');
$intitule->set_border(1);

$libelle2 =& $workbook->addformat();
$libelle2->set_bold();
$libelle2->set_size(10);
$libelle2->set_align('center');
$libelle2->set_border(1);

$info =& $workbook->addformat();
$info->set_size(10);
$info->set_align('left');
$info->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(10);
$total->set_align('center');
$total->set_border(1);

$info2 =& $workbook->addformat();
$info2->set_size(10);
$info2->set_align('left');
$info2->set_border(0);

$info3 =& $workbook->addformat();
$info3->set_size(10);
$info3->set_align('center');
$info3->set_border(1);

$infoh =& $workbook->addformat();
$infoh->set_size(10);
$infoh->set_align('left');
$infoh->set_border(0);
$infoh->set_bold();

$merged_cells = &$workbook->addformat();
$merged_cells->set_bold();
$merged_cells->set_color('blue');
//$merged_cells->set_fg_color('51');
$merged_cells->set_align('center');
$merged_cells->set_size('2');
$merged_cells->set_align('vcenter');
$merged_cells->set_border(1);
// indique qu'une cellule de ce format servira � la fusion
$merged_cells->set_merge();

$merged_cells2 = &$workbook->addformat();
$merged_cells2->set_bold();
$merged_cells2->set_color('white');
$merged_cells2->set_fg_color('green');
$merged_cells2->set_align('center');
$merged_cells2->set_size('14');
$merged_cells2->set_align('vcenter');
$merged_cells2->set_border(0);
// indique qu'une cellule de ce format servira � la fusion
$merged_cells2->set_merge();

$merged_cells3 = &$workbook->addformat();
$merged_cells3->set_bold();
$merged_cells3->set_color('blue');
$merged_cells3->set_fg_color('green');
$merged_cells3->set_align('center');
$merged_cells3->set_size('14');
$merged_cells3->set_align('vcenter');
$merged_cells3->set_border(0);
// indique qu'une cellule de ce format servira � la fusion
$merged_cells3->set_merge();

$intitule =& $workbook->addformat();
$intitule->set_bold();
$intitule->set_size(10);
$intitule->set_align('left');
$intitule->set_border(1);

$worksheet->write(1,0,'Union Economique et Mon�taire Ouest Africaine',$merged_cells2);
$worksheet->write_blank(1,1, $merged_cells2);
$worksheet->write_blank(1,2, $merged_cells2);
$worksheet->write_blank(1,3, $merged_cells2);
$worksheet->write_blank(1,4, $merged_cells2);
$worksheet->write_blank(1,5, $merged_cells2);

$worksheet->write(2,0, 'Statistiques Surveillance Multimat�rale',$merged_cells3);
$worksheet->write_blank(2,1, $merged_cells3);
$worksheet->write_blank(2,2, $merged_cells3);
$worksheet->write_blank(2,3, $merged_cells3);
$worksheet->write_blank(2,4, $merged_cells3);
$worksheet->write_blank(2,5, $merged_cells3);

$worksheet->write(4,0, 'Etat Membre',$infoh);
$worksheet->write(4,1,$CODEPAYSUEMOA[$pays],$header);

$worksheet->write(5,0,'Fiche',$infoh);
$worksheet->write(5,1,$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'],$header);

$worksheet->write(6,0,'S�rie',$infoh);
$worksheet->write(6,1,$serie,$header);

if ($statistics['fiche']['unite']!='')
{
	$worksheet->write(7,0,'Devise/Unit�',$infoh);
	$worksheet->write(7,1,$statistics['fiche']['unite'],$header);
}

$worksheet->write_blank(10,0, $header);

$worksheet->write(10,0,'CODE',$libelle);
$worksheet->write(10,1,'INTITULE',$libelle);

	$frequence = $paramstats[0];
	$pays = $paramstats[2];
	$sficheid = $paramstats[1];
	$moisdeb = $paramstats[3]; $anneedeb = $paramstats[4];
	$moisfin = $paramstats[5]; $anneefin = $paramstats[6];
	$mode = $paramstats[7];
	
	$ln=11;$ln2=11;
	$cl=2;$cl2=2;
	
if ($mode=='DOWNLOADDATAS')
{
	$filename = str_replace(" ","_",$statistics['fiche']['flibelle']).'_'.$serie.'-'.$pays.'_'.$anneedeb.'-'.$anneefin;
	$AnneArrayObject = new ArrayObject($statistics['annee']);
	$AnneArrayObject->asort();
	foreach ($AnneArrayObject as $annee => $data)
	{
		$worksheet->write(10,$cl++,$data['annee'],$libelle2);
	}
	
}
else
{
	$filename = 'TEMPLATE_'.str_replace(" ","_",$statistics['fiche']['flibelle']).'_'.$serie.'-'.$pays.'_'.$anneedeb.'-'.$anneefin;
	$j=intval($anneedeb);
	$k=$j+(intval($anneefin)-intval($anneedeb))+1;
	for($i=$j; $i<$k; $i++)
	{
		$INDICATEURSAN[$i]=$i;
	}
	$AnneArrayObject = new ArrayObject($INDICATEURSAN);
	$AnneArrayObject->asort();
	foreach ($AnneArrayObject as $annee => $data)
	{
		$worksheet->write(10,$cl++,$data,$libelle2);
	}
}

$infocodeflux =& $workbook->addformat();
$infocodeflux->set_align('left');
$infocodeflux->set_border(1);

foreach($statistics['datas'] as $codeflux => $data)
{
	$dataflux=$decal.htmlspecialchars(html_entity_decode($data['intitule']));
	$worksheet->write($ln,0,$codeflux,$infocodeflux);
	$worksheet->write($ln,1,$dataflux,$infocodeflux);
	$cp=2;
	if ($mode=='DOWNLOADDATAS')
	{
		foreach ($AnneArrayObject as $annee => $data2)
		{
			if ($data['data'][$annee]!='' && $data['data'][$annee]!=0)
					$worksheet->write($ln,$cp,$data['data'][$annee],$info3);
			else
					$worksheet->write($ln,$cp,'-',$info3);

			$cp++;
		}
	}	
	$ln++;
}


$workbook->close();

if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
{
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
header("Content-Type: application/x-msexcel");
header("Content-Length: ".@filesize($fname));
//header("Content-disposition: attachment; filename=".$timesheet['timesheetname'.".xls");
header("Content-disposition: attachment; filename=$filename.xls");
$fh=fopen($fname, "rb");
fpassthru($fh);

}
function getDonneesIndicateursMensuels($codefiche,$codepays,$moisdeb,$moisfin,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateurs(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		/*$query = "SELECT sf.designation,f.codeparent,f.codeflux,f.niveau,f.intitule,ROUND(i.quantite,2) quantite,i.codepays,i.mois,i.annee 
					FROM dsm_flux f,dsm_indmois i,dsm_sousfiche sf 
					WHERE sf.codesfiche=f.codesfiche
					AND f.codeflux=i.codeflux
					AND sf.codesfiche=? AND i.codepays=?    
					AND (i.mois>=? AND i.mois<=?) AND (i.annee>=? AND i.annee<=?) " ;*/
		
		$query = "SELECT f.codeparent,f.codeflux,f.niveau,f.intitule,COALESCE(ROUND(i.quantite,2),0) quantite,i.codepays,i.mois,i.annee 
					FROM dsm_flux f
					LEFT JOIN  dsm_indmois i ON f.codeflux=i.codeflux AND i.codepays=?   AND (i.mois>=? AND i.mois<=?) AND (i.annee>=? AND i.annee<=?)  
					WHERE  f.codesfiche=?  AND f.published=1  
					ORDER BY  f.codeflux " ;
					
		$result = $adb->pquery($query, array($codepays,$moisdeb,$moisfin,$anneedeb,$anneefin,$codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			$DINDICATEURS[$row['codeflux']]['data'][$row['annee']][$row['mois']]=$row['quantite'];
			$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
			$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
			$INDICATEURSAN[$row['annee']]=$row['annee'];
			$INDICATEURSMOIS[$row['annee']][$row['mois']]=$row['mois'];
		//	print_r($row);
		}
		//echo $codefiche,' - ',$codepays,' - ',$moisdeb,' - ',$moisfin,' - ',$anneedeb,' - '; 
		//print_r($row);
		if (count($INDICATEURSAN)!=0 && count($INDICATEURSMOIS)!=0 && count($DINDICATEURS)!=0)
		{
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['mois']=$INDICATEURSMOIS;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
		}
		return  $INDICATEURS;
			
}
function showStatisticsMensuelles($statistics)
{
	global $MOISSTATS;
	
		if (count($statistics)==0)
		{
			$tab .= '<br><table border=0 cellspacing=1 cellpadding=3  width="100%">';
			
				$tab .= '<tr><td class="info" align=center>Aucune donn&eacute;e trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
				$tab .= '</table>';
			
		}
		else
		{
			$tab .= '<div id="table_gauche">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small">';
			if (count($statistics['datas'])!= 0)
			{
				$tab .= '<tr><td class="lvtCol" height=30>CODE <br>&nbsp;</td><td class="lvtCol" height=30>INTITULE<br>&nbsp;</td>';
				//$tab .= '<tr bgcolor=white ><td>&nbsp;</td><td>&nbsp;</td></tr>';
				
			}
			//print_r($statistics);
			foreach ($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
								
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				$tab .= '<td class="datastat" >'.$codeflux.'</td><td class="datastat" nowrap>'.$decal.' '.$data['intitule'].'</td>';
			}
			$tab .= '</table>';
			$tab .= '</div>';    
			$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			$tab .= '<tr>';
			foreach ($statistics['mois'] as $annee => $data)
			{
				$tab .= '<td align=center class="datastat"  colspan="'.count($data).'"><b>'.$annee.'</b></td>';
			}
			$tab .= '</tr>';
			$tab .= '<tr>';
			foreach ($statistics['mois'] as $annee => $datas)
			{
				foreach ($datas as $mois => $data)
				{
					if ($mois!='0')
					{
						$tab .= '<td align=center class="datastat" nowrap><b>'.$MOISSTATS[$mois].'</b></td>';
					}
				}
			}
			$tab .= '</tr>';
			/*$tab .= '<tr bgcolor=white >';
			foreach ($statistics['mois'] as $annee => $datas)
			{
				foreach($datas as $mois => $data)
				{
					if ($mois!='0')
					{
						$tab .= '<td align=center class="datastat" >&nbsp;</td>';
					}
				}
			}
			$tab .= '</tr>';*/
												
			foreach ($statistics['datas'] as $annee => $dataflux)
			{
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				foreach ($dataflux as $an => $dataan)
				{
					foreach ($dataan as $mois => $datamois)
					{
						foreach($datamois as $mois => $dataf)
						{
							
							if ($dataf!='' && $dataf!=0)
								$tab .= '<td align=center class="datastat" nowrap>'.number_format($dataf, 1, '.', ' ').'</td>';
							else
								$tab .= '<td align=center class="datastat" >-</td>';
						}
					}
				}
					$tab .= '</tr>';
			}
				$tab .= '</table><br>';
				$tab .= '</div>';
		}
		return $tab;
			
}



function getFormIndicateursMensuels($codefiche,$codepays,$moisdeb,$moisfin,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateurs(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT f.codeparent,f.codeflux,f.niveau,f.intitule,COALESCE(ROUND(i.quantite,2),0) quantite,i.codepays,i.mois,i.annee 
					FROM dsm_flux f
					LEFT JOIN  dsm_indmois i ON f.codeflux=i.codeflux AND i.codepays=?   AND (i.mois>=? AND i.mois<=?) AND (i.annee>=? AND i.annee<=?)  
					WHERE  f.codesfiche=?    
					ORDER BY  f.codeflux " ;
					
		$result = $adb->pquery($query, array($codepays,$moisdeb,$moisfin,$anneedeb,$anneefin,$codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			$DINDICATEURS[$row['codeflux']]['data'][$row['annee']][$row['mois']]=$row['quantite'];
			$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
			$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
			$INDICATEURSAN[$row['annee']]=$row['annee'];
			$INDICATEURSMOIS[$row['annee']][$row['mois']]=$row['mois'];
		//	print_r($row);
		}
		
		
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['mois']=$INDICATEURSMOIS;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
		
		return  $INDICATEURS;
			
}
function showFormMensuelles($statistics,$codepays,$moisdeb,$moisfin,$anneedeb,$anneefin)
{
	if (count($statistics)==0)
		{
			$tab .= '<br><table align="center" border=0 cellspacing=1 cellpadding=3  width="100%">';
			
				$tab .= '<tr><td class="info" align=center>Aucune fiche trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
				$tab .= '</table>';
			
		}
		else
		{	//echo "codepays=",$codepays;
			$j=intval($anneedeb);
			$k=$j+(intval($anneefin)-intval($anneedeb))+1;
			//echo $j.' - '.$k;
			for($i=$j; $i<$k; $i++)
			{
				$INDICATEURSAN[$i]=$i;
			}
			
			$jm=intval($moisdeb);
			$km=$jm+(intval($moisfin)-intval($moisdeb))+1;
			//echo $j.' - '.$k;
			for($im=$jm; $im<$km; $im++)
			{
				$INDICATEURSMOIS[$im]=$im;
			}
			$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small"> ';
			$tab .= '<tr><td class="lvtCol" align=center><img src="themes/images/'.$codepays.'.JPG" height=20 width=20 border=0></td><td class="lvtCol" align=center colspan=25>SAISIE '.$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'].'</td>';
			/*$tab .= '<tr><td class="lvtCol" colspan=25><table cellspacing=1 cellpadding=1 width=90%><tr><td><img src="themes/images/'.$codepays.'.JPG" height=20 width=20 border=0></td><td align=center>Ann&eacute;e de base : ';
			$tab .= '<select name="anneebase" id="anneebase" class="txtBox" style="width:100px">';
			for($i=1980;$i<=2020;$i++)
			{
				$tab .= '<option value="'.$i.'">'.$i.'</option>';
			}
			$tab .= '</select></td>';
			$tab .= '<td  >Syst&egrave;me : &nbsp;&nbsp;<input type="text" name="systeme" id="systeme" size="20"></td></tr></table></td></tr>';*/
			$tab .= '<tr><td class="lvtCol" rowspan=2>CODE</td><td class="lvtCol" rowspan=2>INTITULE</td>';
			$AnneArrayObject = new ArrayObject($INDICATEURSAN);
			$AnneArrayObject->asort();
			foreach ($AnneArrayObject as $annee => $data2)
			{
				$tab .= '<td align=center class="lvtCol" width=50 colspan=12><b>'.$data2.'</b>';
			}	
			$tab .= '</tr>';
			
			$tab .= '<tr>';
			$moisArrayObject = new ArrayObject($INDICATEURSMOIS);
			
			foreach ($AnneArrayObject as $annee => $data2)
			{
				foreach ($moisArrayObject as $mois => $data3)
				{
						$tab .= '<td align=center  class="lvtCol" nowrap><b>M'.$data3.'</b> <br>';
						$tab .= '<select name="etat_'.$annee.'_M'.$data3.'" id="etat_'.$annee.'_M'.$data3.'" class="txtBox" style="width:80px">';
						$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
						$tab .= '</select></td>';
					
					
				}
			}
			$tab .= '</tr>';
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				
				if ($this->IsLastLever($codeflux)==0 && $data['niveau']!=0) $showinput=""; else $showinput="disabled";
				
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				$tab .= '<td nowrap class="datastat" >'.$codeflux.'</td><td class="datastat"  nowrap >'.$decal.' '.$data['intitule'].'</td>';
				foreach ($data['data'] as $annee => $dataflux)
				{
					//$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
					foreach ($moisArrayObject as $mois => $data3)
					{
					
						if ($dataflux[$data3]!='' && $dataflux[$data3]!=0)
								$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$an.'_'.$data3.'" value="'.$dataflux[$data3].'" id="ind_'.$codeflux.'_'.$an.'_'.$data3.'" size="4"></td>';
							else
								$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$an.'_'.$data3.'" id="ind_'.$codeflux.'_'.$an.'_'.$data3.'" size="4"></td>';
						
					}
					
				}
								
				$tab .= '</tr>';
			}
					
			$tab .= '<tr><td class="small" nowrap align="center" colspan=10>
						<input name="submit" type="button" class="crmbutton small create" onClick="callSaisie();" disabled value=" Enregistrer la saisie ">&nbsp;
					</td>	
				</tr>';
			$tab .= '</table>';
			$tab .= '</div>';    
		
		}		
		return $tab;
			
}
function getDonneesIndicateursTrimestriels($codefiche,$codepays,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateursTrimestriels(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT sf.designation,f.codeparent,f.codeflux,f.niveau,f.intitule,COALESCE(ROUND(i.quantite,2),'') quantite,
				COALESCE(i.codepays,'') codepays,COALESCE(i.trimestre,'') trimestre,COALESCE(i.annee,'') annee
				FROM dsm_flux f
				INNER JOIN dsm_sousfiche sf ON sf.codesfiche=f.codesfiche 
				LEFT JOIN dsm_indtrimestre i ON i.codeflux=f.codeflux AND i.codepays=? AND (i.annee>=? AND i.annee<=?)
				WHERE f.codesfiche=?  AND f.published=1
				ORDER BY f.codeflux" ;
					
		$result = $adb->pquery($query, array($codefiche,$codepays,$anneedeb,$anneefin));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			if ($row['annee']!='' && $row['trimestre']!='')
			{
				$DINDICATEURS[$row['codeflux']]['data'][$row['annee']][$row['trimestre']]=$row['quantite'];
				$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
				//$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
				$INDICATEURSAN[$row['annee']]=$row['annee'];
				$INDICATEURSTRIM[$row['annee']][$row['trimestre']]=array('trimestre'=>$row['trimestre'],'etat'=>$row['etat'],'statut'=>$row['statut']);
				
			}
		}
		//print_r($DINDICATEURS);
		if (count($INDICATEURSAN)!=0 && count($INDICATEURSTRIM)!=0 && count($DINDICATEURS)!=0)
		{
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['trimestre']=$INDICATEURSTRIM;
			$INDICATEURS['datas']=$DINDICATEURS;
		}
		return  $INDICATEURS;
			
}


function showStatisticsTrimestrielles($statistics)
{
	if (count($statistics)==0)
		{
			$tab .= '<br><table border=0 cellspacing=1 cellpadding=3  width="100%">';
			
				$tab .= '<tr><td class="info" align=center>Aucune donn&eacute;e trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
				$tab .= '</table>';
			
		}
		else
		{
			//$tab .= '<div id="container" style="style="float: left; width: 310px;margin-right: 10px;padding-right:0px;padding-left:0px;">';
			$tab .= '<div id="table_gauche">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small">';
			$tab .= '<tr><td class="lvtCol" height=30>CODE <br>&nbsp;</td><td class="lvtCol" height=30>INTITULE<br>&nbsp;</td>';
			
			
			
			$decal='';
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
								
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				$tab .= '<td nowrap class="datastat">'.$codeflux.'</td><td class="datastat" nowrap >'.$decal.' '.$data['intitule'].'</td>';
			}	
			$tab .= '</table>';
			$tab .= '</div>';    
			$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			
			$tab .= '<tr>';
			$AnneArrayObject = new ArrayObject($statistics['annee']);
			$AnneArrayObject->asort();
			foreach ($AnneArrayObject as $annee => $data)
			{
				$tab .= '<td align=center   class="datastat"   colspan=4><b>'.$data.'</b></td>';
			}
			$tab .= '</tr>';
			$tab .= '<tr >';
			foreach ($statistics['trimestre'] as $annee => $data2)
			{					
				$tab .= '<td align=center class="datastat"  ><b>T1</b></td><td align=center class="datastat"><b>T2</b></td><td align=center class="datastat"><b>T3</b></td><td align=center class="datastat"><b>T4</b></td>';

			}

			$tab .= '</tr>';

			foreach($statistics['datas'] as $codeflux => $data)
			{
				$tab .= '<tr bgcolor=white >';
				foreach ($statistics['annee'] as $an => $dataan)
				{
					for($i=1;$i<=4;$i++)
					{
						if ($data['data'][$dataan][$i]!='' && $data['data'][$dataan][$i]!=0)
							$tab .= '<td align=center class="datastat"  nowrap>'.number_format($data['data'][$dataan][$i], 1, '.', ' ').'</td>';
						else
							$tab .= '<td align=center class="datastat" >-</td>';
					}
				}
			}
				/*foreach ($data['data'] as $an => $dataan)
				{
					
					for($i=1;$i<=4;$i++)
					{
						if ($dataan[$i]!='' && $dataan[$i]!=0)
							$tab .= '<td align=center class="datastat" nowrap>'.number_format($dataan[$i], 1, '.', ' ').'</td>';
						else
							$tab .= '<td align=center style="height:10px">-</td>';
					}
				}*/
			
			$tab .= '</table>';
			$tab .= '</div>';    
			/*$tab .= '<tr><td  colspan=25><table width=90%><tr><td><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">Source :</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['systeme'].'</span></td>';
			$tab .= '<td  ><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">M&eacute;thodologie / Syst&egrave;me:</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['source'].'</span></td></tr></table></td></tr>';
			 */
			/*$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			$tab .= '<tr>';
			foreach ($statistics['annee'] as $annee => $data)
			{
				$tab .= '<td align=center class="lvtCol" width=50><b>'.$data['annee'].'</b> <br>'.$data['etat'].'</td>';
			}
			$tab .= '</tr>';
			
			foreach ($statistics['datas'] as $annee => $dataflux)
			{
				
				$tab .= '<tr bgcolor=white>';
				foreach ($dataflux['data'] as $an => $dataan)
				{
					if ($dataan!='' && $dataan!=0)
						$tab .= '<td align=center style="height:10px">'.$dataan.'</td>';
					else
						$tab .= '<td align=center style="height:10px">-</td>';
					
				}
				$tab .= '</tr>';
			}
			
			$tab .= '</table>';
			$tab .= '</div>';*/
		}		
		return $tab;
			
}
function getFormIndicateursTrimestriels($codefiche,$codepays,$anneedeb,$anneefin)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getDonneesIndicateursTrimestriels(".$codepays.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT f.codeparent,f.codeflux,f.niveau,f.intitule,COALESCE(ROUND(i.quantite,2),'') quantite,
				COALESCE(i.codepays,'') codepays,COALESCE(i.trimestre,'') trimestre,COALESCE(i.annee,'') annee
				FROM dsm_flux f
				LEFT JOIN dsm_indtrimestre i ON i.codeflux=f.codeflux AND i.codepays=? AND (i.annee>=? AND i.annee<=?)
				WHERE  f.codesfiche=? 
				ORDER BY f.codeflux" ;
					
		$result = $adb->pquery($query, array($codepays,$anneedeb,$anneefin,$codefiche));
		while ($row = $adb->fetchByAssoc($result))
		{
			$DINDICATEURS[$row['codeflux']]['intitule']=$row['intitule'];
			//if ($row['annee']!='' && $row['trimestre']!='')
			//{
				$DINDICATEURS[$row['codeflux']]['data'][$row['annee']][$row['trimestre']]=$row['quantite'];
				$DINDICATEURS[$row['codeflux']]['niveau']=$row['niveau'];
				//$DINDICATEURS[$row['codeflux']]['codeparent']=$row['codeparent'];
				$INDICATEURSAN[$row['annee']]=$row['annee'];
				$INDICATEURSTRIM[$row['annee']][$row['trimestre']]=array('trimestre'=>$row['trimestre'],'etat'=>$row['etat'],'statut'=>$row['statut']);
				//echo 'niveau=',$row['niveau'],'<br>';
			//}
		}
		//print_r($DINDICATEURS);
		
			$INDICATEURS['annee']=$INDICATEURSAN;
			$INDICATEURS['trimestre']=$INDICATEURSTRIM;
			$INDICATEURS['datas']=$DINDICATEURS;
			$INDICATEURS['fiche']=$this->getLibelleFicheById($codefiche);
		
		return  $INDICATEURS;
			
}

function showFormTrimestrielles($statistics,$codepays,$moisdeb,$moisfin,$anneedeb,$anneefin)
{
	if (count($statistics)==0)
		{
			$tab .= '<br><table border=0 cellspacing=1 cellpadding=3  width="100%">';
			
				$tab .= '<tr><td class="info" align=center>Aucune donn&eacute;e trouv&eacute;e pour ces param&eacute;tres saisis!!!</td></tr>';
				$tab .= '</table>';
			
		}
		else
		{
		
			$j=intval($anneedeb);
			$k=$j+(intval($anneefin)-intval($anneedeb))+1;
			//echo $j.' - '.$k;
			for($i=$j; $i<$k; $i++)
			{
				$INDICATEURSAN[$i]=$i;
			}
		
		
			//$tab .= '<div id="container" style="style="float: left; width: 310px;margin-right: 10px;padding-right:0px;padding-left:0px;">';
			//$tab .= '<div id="table_gauche">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3  class="lvt small">';
			$tab .= '<tr><td class="lvtCol" align=center><img src="themes/images/'.$codepays.'.JPG" height=20 width=20 border=0></td><td class="lvtCol" align=center colspan=25>SAISIE '.$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'].'</td>';
			$tab .= '<tr><td class="lvtCol" height=30 rowspan=2>CODE <br>&nbsp;</td><td class="lvtCol" rowspan=2 height=30>INTITULE<br>&nbsp;</td>';
			
			//$tab .= '<tr>';
			$AnneArrayObject = new ArrayObject($INDICATEURSAN);
			$AnneArrayObject->asort();
			foreach ($AnneArrayObject as $annee => $data1)
			{
				$tab .= '<td align=center   class="lvtCol"  colspan=4><b>'.$annee.'</b></td>';
			}
			$tab .= '</tr>';
			$tab .= '<tr >';
			foreach ($INDICATEURSAN as $annee => $data2)
			{					
				$tab .= '<td align=center class="lvtCol" ><b>T1</b><br>';
				$tab .= '<select name="etat_'.$annee.'_T'.$data2.'" id="etat_'.$annee.'_T1" class="txtBox" style="width:80px">';
				$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
				$tab .= '</select></td>';
				$tab .= '<td align=center class="lvtCol"><b>T2</b><br>';
				$tab .= '<select name="etat_'.$annee.'_T'.$data2.'" id="etat_'.$annee.'_T2" class="txtBox" style="width:80px">';
				$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
				$tab .= '</select></td>';
				$tab .= '<td align=center class="lvtCol"><b>T3</b><br>';
				$tab .= '<select name="etat_'.$annee.'_T'.$data2.'" id="etat_'.$annee.'_T3" class="txtBox" style="width:80px">';
				$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
				$tab .= '</select></td>';
				$tab .= '<td align=center class="lvtCol"><b>T4</b><br>';
				$tab .= '<select name="etat_'.$annee.'_T'.$data2.'" id="etat_'.$annee.'_T4" class="txtBox" style="width:80px">';
				$tab .= '<option value="DEF">d&eacute;finitif</option><option value="PROV">provisoire</option><option value="EST">estimation</option><option value="PREV">pr&eacute;vision</option>';
				$tab .= '</select></td>';

			}

			$tab .= '</tr>';

			
			$decal='';
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if (substr($data['intitule'],1,4)== 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichedont';
				}
				if ($data['niveau']==0 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='';
					$niveaustyle='fichen1';
				}
				elseif ($data['niveau']==1 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen2';
				}
				elseif ($data['niveau']==2 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='fichen3';
				}
				elseif ($data['niveau']==3 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==4 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				elseif ($data['niveau']==5 && substr($data['intitule'],1,4)!= 'Dont')
				{
					$decal='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					$niveaustyle='';
				}
				//echo 	"niveaustyle=",$data['niveau'],' - ',$niveaustyle,'<br>';			
				$tab .= '<tr bgcolor=white class="'.$niveaustyle.'" >';
				$tab .= '<td nowrap class="datastat">'.$codeflux.'</td><td class="datastat" nowrap >'.$decal.' '.$data['intitule'].'</td>';
				
				if ($this->IsLastLever($codeflux)==0 && $data['niveau']!=0) $showinput=""; else $showinput="disabled";

				//$tab .= '<tr bgcolor=white >';
				foreach ($INDICATEURSAN as $an => $dataan)
				{
					for($i=1;$i<=4;$i++)
					{
						if ($data['data'][$dataan][$i]!='' && $data['data'][$dataan][$i]!=0)
							$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" value="'.$data['data'][$dataan][$i].'" id="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" size="4"></td>';

						else
							$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" id="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" size="4"></td>';
					}
				}
				
			}	
			$tab .= '</table>';
			$tab .= '</div>';    
			/*$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			
			
			foreach($statistics['datas'] as $codeflux => $data)
			{
				if ($this->IsLastLever($codeflux)==0 && $data['niveau']!=0) $showinput=""; else $showinput="disabled";

				$tab .= '<tr bgcolor=white >';
				foreach ($INDICATEURSAN as $an => $dataan)
				{
					for($i=1;$i<=4;$i++)
					{
						if ($data['data'][$dataan][$i]!='' && $data['data'][$dataan][$i]!=0)
							$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" value="'.$data['data'][$dataan][$i].'" id="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" size="4"></td>';

						else
							$tab .= '<td align=center class="datastat" ><input type="text" '.$showinput.' class="inputstat" name="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" id="ind_'.$codeflux.'_'.$dataan.'_'.$i.'" size="4"></td>';
					}
				}
			}*/
				/*foreach ($data['data'] as $an => $dataan)
				{
					
					for($i=1;$i<=4;$i++)
					{
						if ($dataan[$i]!='' && $dataan[$i]!=0)
							$tab .= '<td align=center class="datastat" nowrap>'.number_format($dataan[$i], 1, '.', ' ').'</td>';
						else
							$tab .= '<td align=center style="height:10px">-</td>';
					}
				}*/
			
			$tab .= '</table>';
			$tab .= '</div>';    
			/*$tab .= '<tr><td  colspan=25><table width=90%><tr><td><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">Source :</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['systeme'].'</span></td>';
			$tab .= '<td  ><span style="font-size:13px;font-family: Arial, Helvetica, sans-serif;">M&eacute;thodologie / Syst&egrave;me:</span> &nbsp;&nbsp;<span style="color:green;font-size:13px;font-family: Arial, Helvetica, sans-serif;">'.$statistics['fiche']['source'].'</span></td></tr></table></td></tr>';
			 */
			/*$tab .= '<div id="table_droite">';
			$tab .= '<table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>';
			$tab .= '<tr>';
			foreach ($statistics['annee'] as $annee => $data)
			{
				$tab .= '<td align=center class="lvtCol" width=50><b>'.$data['annee'].'</b> <br>'.$data['etat'].'</td>';
			}
			$tab .= '</tr>';
			
			foreach ($statistics['datas'] as $annee => $dataflux)
			{
				
				$tab .= '<tr bgcolor=white>';
				foreach ($dataflux['data'] as $an => $dataan)
				{
					if ($dataan!='' && $dataan!=0)
						$tab .= '<td align=center style="height:10px">'.$dataan.'</td>';
					else
						$tab .= '<td align=center style="height:10px">-</td>';
					
				}
				$tab .= '</tr>';
			}
			
			$tab .= '</table>';
			$tab .= '</div>';*/
		}		
		return $tab;
			
}

	function save_module($module) 
	{
		global $log,$adb;
		$insertion_mode = $this->mode;
		if(isset($this->parentid) && $this->parentid != '')
			$relid =  $this->parentid;		

		/*if(isset($relid) && $relid != '')
		{
			$this->insertintofiledemvrel($relid,$this->id);
		}*/
		//echo "id =",$this->id;break;
		$this->insertIntoReunionFiles($this->id,'Reunion');
		
	
	}
	function insertIntoReunionFiles($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoReunionFiles($id,$module) method.");
		
		$file_saved = false;
		//print_r($_FILES);break;
		foreach($_FILES as $fileindex => $files)
		{
			for($i=0; $i<count($files); $i++)
			{
				 
				$currentfile = array('name'=>$files['name'][$i],'size'=>$files['size'][$i],'type'=>$files['type'][$i],'tmp_name'=>$files['tmp_name'][$i],'error'=>$files['error'][$i]);
				if($currentfile['name'] != '' && $currentfile['size'] > 0)
				{
					$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
					//echo $id,' - ',$module,' - ',$currentfile;break;
					$file_saved = $this->uploadAndSaveFile($id,$module,$currentfile);
				}
			}
		}
//break;
		$log->debug("Exiting from insertIntorapport($id,$module) method.");
	}
	function saveNatureDepenses($reunionid,$numreunion,$natdeptab)
	{
		global $adb;
		foreach($natdeptab as $ndindex => $natdep)
		{
			$linenum=1;
			foreach($natdep as $lndindex => $lignenatdep)
			{
				$dbQuery = "insert into nomade_reunion_natdepenses(ticket,reunionid,comptenat,linenum,libdepense,qtedepense,nbredepense,pudepense,totaldepense)
				    values (?,?,?,?,?,?,?,?,?)";
				$dbresult = $adb->pquery($dbQuery,array($numreunion,$reunionid,$ndindex,$linenum,$lignenatdep['lib'],$lignenatdep['qte'],$lignenatdep['nb'],$lignenatdep['pu'],$lignenatdep['pt']));	
				$linenum++;
			}
		}
	}
	function deleteNatureDepenses($reunionid)
	{
		global $adb;
		$dbQuery = "delete from nomade_reunion_natdepenses where reunionid=?";
		$dbresult = $adb->pquery($dbQuery,array($reunionid));	
			
	}
	function getLignesDepenses($reunionid)
	{
		global $adb;
	
		$query = "SELECT * FROM nomade_reunion_natdepenses WHERE  reunionid=?  ";
		$result = $adb->pquery($query, array($reunionid)); 
		while ( $row = $adb->fetchByAssoc($result))
		{
			$lignesdepenses[]=$row;
		}
		return $lignesdepenses;
	}
	/*
	function getInfosDisponibiliteFonds($infosbudget,$comptesnat)
	{	
		global $log, $singlepane_view,$adb,$WSSAP;
		$log->debug("Entering getInfosDisponibiliteFonds(".$infosbudget.") method ...");
		global $app_strings, $mod_strings;
		$message ='';
		header('Content-Type: text/html; charset=utf-8');

		$SOAP_AUTH = array( 'login'=> $WSSAP['SOAP_AUTH']['user'],'password' => $WSSAP['SOAP_AUTH']['password']);
				
		$WSDL = $WSSAP['URL_CONTRDISPOFOND'];
		//print_r($infosbudget);
		//print_r($comptesnat);
	   #Create Client Object, download and parse WSDL
	    try
		{
			$client = new SoapClient($WSDL,$SOAP_AUTH);
			
		}
		catch (SoapFault $exception)
		{
		  //  print "***Caught Exception***\n";
			//print_r($exception);
			$message = "Les informations sur le budget (cr&eacute;dits disponibles) sont temporairement indisponibles";
		 //   print "***END Exception***\n";
			//die();
		//	continue;
		}
		if ($message =='')
		{
			foreach($comptesnat as $comptenat => $comptenatlib)
			{
					$budget->AFISCAL=$WSSAP['AFISCAL'];  // Ann&eacute;e budg&eacute;taire
					$budget->CODE_BUDGETAIRE=$infosbudget['codebudget']; // Code budg&eacute;taire
					$budget->CPTE_BUDGETAIRE=$comptenat; // Compte nature
					$budget->FOND=$infosbudget['sourcefin']; // Source de Finanacement
					
					$societe = substr($infosbudget['codebudget'], 0, 2);
					$budget->PF=$WSSAP['PERIMETREFIN'][$societe]; // P&eacute;rim&eacute;tre Financier
											
					$resultat='';
					try
					{
					  $infosdisp = $client->ZGET_AVAIBILITY($budget); 
					  $dispbudgetobj= $infosdisp->IT_RESULT->item;
					  $mtndispo = $dispbudgetobj->MNTNT_DISPO;
					  $dispbudget[$infosbudget['codebudget']][$comptenat]=array('codebudget'=>$infosbudget['codebudget'],
																				'sourcefin'=>$infosbudget['sourcefin'],
																				'comptenat'=>$comptenat,
																				'comptenatlib'=>$comptenatlib,
																				'fonddisp'=>$dispbudgetobj->MNTANT_FD_ENGAGE,
																				'fondengage'=>$dispbudgetobj->FOND_ENGAGE,
																				'mntdispo'=>$dispbudgetobj->MNTNT_DISPO
																			);
					}
					catch (SoapFault $exception)
					{
			$message = "Les informations sur le budget (cr&eacute;dits disponibles) sont temporairement indisponibles";
					  //  print "***Caught Exception***\n";
						print_r($exception);
					 //   print "***END Exception***\n";
						//die();
					//	continue;
					}
				
			}
		}
		else
			$dispbudget['msgErreurSap'] = $message;
			
		return $dispbudget;
			
	}
	*/
	
	function getBudgetPheb($connect,$codebudget,$comptenat)
	{
		
		$sql = "select UEMOA_NOMADE_BUDGET.CodeBudgetaire,UEMOA_NOMADE_BUDGET.CompteNature,MontantBudget
			from  UEMOA_NOMADE_BUDGET
			where UEMOA_NOMADE_BUDGET.CodeBudgetaire='".$codebudget."'
			and UEMOA_NOMADE_BUDGET.CompteNature='".$comptenat."'";
			
		$result = sqlsrv_query($connect, $sql);
		
		$infosbudget = sqlsrv_fetch_array($result);
		$budget=array('codebudget'=>$infosbudget['CodeBudgetaire'],'comptenat'=>$infosbudget['CompteNature'],'MontantBudget'=>$infosbudget['MontantBudget']);
		
		return $budget;
		
	}
	function getEngagementPheb($connect,$codebudget,$comptenat)
	{
		
		$sql = "select CodeBudgetaire,CompteNature,SUM(MontantEngage) as mtengage 
				from  dbo.UEMOA_NOMADE_ENG
				where CodeBudgetaire='".$codebudget."'
				and CompteNature='".$comptenat."'
				 group by CodeBudgetaire,CompteNature ";
			
		$result = sqlsrv_query($connect, $sql);
		
		$infosengagement = sqlsrv_fetch_array($result);
		$engagement=array('codebudget'=>$infosengagement['CodeBudgetaire'],'comptenat'=>$infosengagement['CompteNature'],'MontantEngage'=>$infosengagement['mtengage']);

		return $engagement;
		
	}

	function getInfosDispoBudgCmtNat($connect,$codebudget,$comptenat)
	{	
		$budget = $this->getBudgetPheb($connect,$codebudget,$comptenat);
		$engagement = $this->getEngagementPheb($connect,$codebudget,$comptenat);
		$dispbudget = array('comptenat'=>$comptenat,'fonddisp'=>$budget['MontantBudget'],'fondengage'=>$engagement['MontantEngage'],
										 'mntdispo'=>$budget['MontantBudget']-$engagement['MontantEngage']);
		return $dispbudget;
	}


	function getInfosDisponibiliteFonds($infosbudget,$comptesnat)
	{	
		global $log, $singlepane_view,$adb,$DBPHEB;
		$log->debug("Entering getInfosDisponibiliteFonds(".$infosbudget.") method ...");
		global $app_strings, $mod_strings;
		$message ='';
		header('Content-Type: text/html; charset=utf-8');

		$DBPHEB['MSSQL_AUTH'] = array('user'=>'sa','pwd'=>'sa','db'=>'UEMOA_SOCIETE_09','servername'=>'OUAVPHEBBD01'); 
		$connectionInfo = array("UID" => $DBPHEB['MSSQL_AUTH']['user'], "PWD" => $DBPHEB['MSSQL_AUTH']['pwd'], "Database"=>$DBPHEB['MSSQL_AUTH']['db']);
		
		$connect = sqlsrv_connect($DBPHEB['MSSQL_AUTH']['servername'], $connectionInfo);
		if( $connect === false ) {
			die( print_r( sqlsrv_errors(), true));
		}
			

		foreach($comptesnat as $comptenat => $comptenatlib)
		{
			$codebudget = $infosbudget['codebudget'];
			$dispoBudgCmtNat = $this->getInfosDispoBudgCmtNat($connect,$codebudget,$comptenat);
			$dispbudget[$codebudget][$comptenat]=array('codebudget'=>$codebudget,
														'sourcefin'=>$infosbudget['sourcefin'],
														'comptenat'=>$comptenat,
														'comptenatlib'=>$comptenatlib,
														'fonddisp'=>$dispoBudgCmtNat['fonddisp'],
														'fondengage'=>$dispoBudgCmtNat['fondengage'],
														'mntdispo'=>$dispoBudgCmtNat['mntdispo']
														);
			
			//print_r($dispbudget);
		}

		sqlsrv_close($connect);
		$dispbudget['msgErreurSap'] = $message;
			
		return $dispbudget;
			
	}
	function getNatureDepenses($reunionid,$codebudg)
	{
		global $adb;
		/*$query = "SELECT DISTINCT nomade_reunion_natdepenses.comptenat comptenat,libconptenature libnatdepense
				FROM nomade_reunion_natdepenses,nomade_comptenature2budget 
				WHERE nomade_reunion_natdepenses.comptenat=nomade_comptenature2budget.comptenature COLLATE utf8_unicode_ci
				AND codebudget=?  ";
		$query = "SELECT DISTINCT nomade_comptenature2budget.comptenature comptenat,libconptenature libnatdepense
				FROM nomade_comptenature2budget 
				WHERE  codebudget=?  ";*/
				
		 $query = " SELECT DISTINCT `comptenature` comptenat,UPPER(`libconptenature`) libnatdepense FROM `nomade_comptenature2budget`
						ORDER BY 1";
						
		$result = $adb->pquery($query, array()); 
		while ( $row = $adb->fetchByAssoc($result))
		{
			$comptenats[$row['comptenat']]=$row['libnatdepense'];
		}
		$query1 = "SELECT comptenat,linenum,libdepense,qtedepense,nbredepense,pudepense,totaldepense,isdepensedb 
			   FROM nomade_reunion_natdepenses WHERE reunionid=? order by comptenat";
		$result1 = $adb->pquery($query1, array($reunionid)); 
		while ( $row1 = $adb->fetchByAssoc($result1))
		{
			$depenses[]=$row1;
		}
		//print_r($depenses);
		foreach($comptenats as $comptenat => $comptenatlib)
		{
			$totalnatdepense=0;
			$existdepnatdep = 0;
			$montantaengage = 0;
			//echo "comptenat=",$comptenat;
			foreach($depenses as $key => $depense)
			{
			   if($comptenat==$depense['comptenat'])
			   {
				if ($depense['isdepensedb']==0)
				{
					$styletr = 'background-color:white;';
					$checked = '';
					$disabled = '';
				}
				else
				{
					$styletr = 'background-color:#808080;';
					$checked = 'checked';
					$disabled = 'disabled';
				}	
				$natdepenses[$comptenat]['depenses'][]=array('linenum'=>$depense['linenum'],'libdepense'=>$depense['libdepense'],'qtedepense'=>$depense['qtedepense'],'nbredepense'=>$depense['nbredepense'],'pudepense'=>$depense['pudepense'],'totaldepense'=>$depense['totaldepense'],
										'style'=>$styletr,'checked'=>$checked,'disabled'=>$disabled);
				$totalnatdepense+=$depense['totaldepense'];
				$existdepnatdep = 1;
			    }
			}
			if($existdepnatdep==0)				// ajouter une ligne vide
			{
				$natdepenses[$comptenat]['depenses'][]=array('linenum'=>1,'libdepense'=>'','qtedepense'=>0,'nbredepense'=>0,'pudepense'=>0,'totaldepense'=>0,
										'style'=>'backgroundColor  = "white"','checked'=>'','disabled'=>'');
			}
			$natdepenses[$comptenat]['libnatdepense']=$comptenatlib;
			$natdepenses[$comptenat]['totaldepense']=$totalnatdepense;
			
		}
		
		return $natdepenses;
	}
	
	
	function getNatureDepensesAEngagees($reunionid)
	{
		global $adb;
		
		$query = "SELECT comptenat,libconptenature,SUM(totaldepense)  totaldepense
			       FROM nomade_reunion_natdepenses,nomade_comptenature2budget  
					WHERE nomade_comptenature2budget.comptenature =nomade_reunion_natdepenses.comptenat COLLATE utf8_unicode_ci
					AND reunionid=? AND isdepensedb='1' 
			   GROUP BY comptenat";
		$result = $adb->pquery($query, array($reunionid)); 
		while ( $row = $adb->fetchByAssoc($result))
		{
			$natdepenses[$row['comptenat']]['totaldepense'] = $row['totaldepense'];
			$natdepenses[$row['comptenat']]['libconmptenature'] = $row['libconptenature'];
			
		}
		
		
		return $natdepenses;
	}
	function getComptesNat($codebudg)
	{
		global $adb;
		/*$query = "SELECT DISTINCT nomade_reunion_natdepenses.comptenat comptenat,libconptenature libnatdepense
				FROM nomade_reunion_natdepenses,nomade_comptenature2budget 
				WHERE nomade_reunion_natdepenses.comptenat=nomade_comptenature2budget.comptenature COLLATE utf8_unicode_ci
				AND codebudget=?  ";
		$query = "SELECT DISTINCT nomade_comptenature2budget.comptenature comptenat,libconptenature libnatdepense
				FROM nomade_comptenature2budget 
				WHERE  codebudget=?  ";*/
				
		 $query = " SELECT DISTINCT comptenature comptenat,UPPER(libconptenature) libnatdepense FROM nomade_comptenature2budget
						ORDER BY 1";
						
		$result = $adb->pquery($query, array()); 
		while ( $row = $adb->fetchByAssoc($result))
		{
			$comptenats[$row['comptenat']]=$row['libnatdepense'];
		}
				
		return $comptenats;
	}
	
	function getInfosByReunion($ticket)
{
	global $log;
	$log->debug("Entering getInfosByReunion(".$ticket.") method ...");
	$log->info("in getInfosByReunion ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT r.ticket,CONCAT(ag.user_name,' ',ag.user_firstname) AS nom,r.statut,r.datedebut,r.datefin,
						ag.user_Email AS mailtocharge,r.objet,r.lieu,r.budget,r.sourcefin,r.codebudget,r.responssuivi
						FROM nomade_reunion r
						INNER JOIN users ag ON ag.User_Matricule=r.responssuivi
						WHERE r.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				//$demande['sourcefin'] = getSourceFinById($demande['sourcefin']);
				
				
        }
	$log->debug("Exiting getInfosByReunion method ...");
        return $demande;
}

function getInfosByReunionById($reunionid)
{
	global $log;
	$log->debug("Entering getInfosByReunionById(".$reunionid.") method ...");
	//$log->info("in getInfosByReunionById ".$reunionid.");
	$DEPARTEMENTS = array('01-01'=>'PCOM','01-02'=>'DSAF','01-03'=>'DATC','01-04'=>'DEMEN','01-05'=>'DAREN','01-06'=>'DDH','01-07'=>'DMRC','01-08'=>'DPE','02-00'=>'CJ','03-00'=>'CC','04-00'=>'CIP','05-00'=>'CCR');
        global $adb;
        if($reunionid != '')
        {
                $sql = "SELECT r.ticket,r.departement,CONCAT(ag.user_name,' ',ag.user_firstname) AS nom,r.statut,DATE_FORMAT(r.datedebut,'%d-%m-%Y') datedebut,DATE_FORMAT(r.datefin,'%d-%m-%Y') datefin ,DATE_FORMAT(vc.modifiedtime,'%d-%m-%Y') datecreation,
						ag.user_Email AS mailtocharge,r.objet,r.lieu,r.budget,r.sourcefin,r.codebudget,r.responssuivi,r.regisseur
						FROM nomade_reunion r
						INNER JOIN users ag ON ag.User_Matricule=r.responssuivi
						INNER JOIN vtiger_crmentity vc ON vc.crmid=r.reunionid
						WHERE r.reunionid=?";
                $result = $adb->pquery($sql, array($reunionid));
		$reunion = $adb->fetchByAssoc($result);
				//$demande['sourcefin'] = getSourceFinById($demande['sourcefin']);
				
	$reunion['departementsigle'] = $DEPARTEMENTS[$reunion['departement']];	
	$reunion['codefournregisseur'] = '420'.$reunion['regisseur'];	

	
        }
	$log->debug("Exiting getInfosByReunionById method ...");
        return $reunion;
}

function createEngagementReunion($infosengagement)
{	
	global $log, $singlepane_view,$adb,$WSSAP;
	$log->debug("Entering createEngagementReunion(".$infosengagement.") method ...");
	global $app_strings, $mod_strings;
	
	header('Content-Type: text/html; charset=utf-8');

	$SOAP_AUTH = array( 'login'=> $WSSAP['SOAP_AUTH']['user'],'password' => $WSSAP['SOAP_AUTH']['password']);
			
	$WSDL = $WSSAP['URL_ENGAGEMENTREUNION'];

   #Create Client Object, download and parse WSDL
   
   $client = new SoapClient($WSDL,$SOAP_AUTH);
   
	$mission->BENEF=$infosengagement['beneficiaire'];  // Departement b&eacute;n&eacute;ficiaire
	//$mission->MISSION=$infosengagement['numreunion']; // Num&eacute;ro de la R&eacute;union
	$mission->MISSION='R18-006'; // Num&eacute;ro de la R&eacute;union
	
	$mission->SOCIETE=$infosengagement['societedepart']; // Socit&eacute; de la Commission ou cour des comptes
	$mission->TEXTEH=$infosengagement['objetreunion']; // Objet de la Mission
	//$mission->USER=$infosengagement['curentuserloginsap']; // Personne de la DB creant l'engagement
	$mission->USER='AZOURE';
	$depenses = $infosengagement['depenses'];$i=0;
	foreach($depenses as $comptenat => $depense)
	{
					
		//$mission->IT_POST->item[$i]->MONTANT=$depense['totaldepense']; // total fiche de decompte
		$mission->IT_POST->item[$i]->MONTANT=4000; // total fiche de decompte
		$mission->IT_POST->item[$i]->TEXTE='Reunion'; // 
		$mission->IT_POST->item[$i]->COMPTE=$comptenat; // compte nature
		$mission->IT_POST->item[$i]->FONDS=$depense['sourcefin']; //  Source de Finanacement
		$mission->IT_POST->item[$i]->FOURN='0000'.$infosengagement['codefournregisseur']; // Code fournisseur du Regisseur
		$mission->IT_POST->item[$i]->CODE_BUDGT=$depense['codebudget']; // Code Budg&eacute;taire
		$i++;
				
	}
	
	print_r($mission);break;
	//echo "<br>*************************</br>";
	//print_r($WSSAP);
	
    $resultat='';
   try
    {
     // $result = $client->ZBR_LOAD_COMMITMENT($mission); 
    }
    catch (SoapFault $exception)
    {
        print "***Caught Exception***\n";
        print_r($exception);
        print "***END Exception***\n";
        die();
    }
    
    //print_r($result);
    //$resultat = $result->Belnr;
    $resultat = $result;
	
    return $resultat;
		
}
function addEngagementToReunion($numengagement,$reunionid)
{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering addEngagementToReunion(".$reunionid.") method ...");
		global $app_strings, $mod_strings;
		
		$reqUpdate= "UPDATE nomade_reunion SET numengagement=? WHERE reunionid=?  " ;
		$adb->pquery($reqUpdate, array($numengagement,$reunionid));
}
function getSocieteSapDepart($depart)
{
	global $log;
	$log->debug("Entering getSocieteSapDepart(".$depart.") method ...");
	$log->info("in getSocieteSapDepart ".$depart);

        global $adb;
        if($depart != '')
        {
		$idsociete = substr($depart,0,2);
                $sql = "SELECT codeidentsap FROM nomade_societe WHERE codeidentuemoa=?";
                $result = $adb->pquery($sql, array($idsociete));
                $codeidentsap = $adb->query_result($result,0,"codeidentsap");
        }
	$log->debug("Exiting getSocieteSapDepart method ...");
        return $codeidentsap;
}
	function getTicketReunion($reunionid)
	{
	global $log;
	$log->debug("Entering getTicketReunion(".$reunionid.") method ...");
	$log->info("in getTicketReunion ".$reunionid);

	global $adb;
	if($reunionid != '')
	{
		$sql = "select ticket from nomade_reunion where reunionid=?";
        	$result = $adb->pquery($sql, array($reunionid));
		$ticket = $adb->query_result($result,0,"ticket");
	}
	$log->debug("Exiting getTicketDemande method ...");
	return $ticket;
	}
	function getReunionIdByTicket($ticket)
	{
		global $log;
		$log->debug("Entering getReunionIdByTicket(".$ticket.") method ...");
		$log->info("in getReunionIdByTicket ".$ticket);

	        global $adb;
	        if($ticket != '')
	        {
	                $sql = "select reunionid from nomade_reunion where ticket=?";
	                $result = $adb->pquery($sql, array($ticket));
	                $reunionid = $adb->query_result($result,0,"reunionid");
	        }
		$log->debug("Exiting getReunionIdByTicket method ...");
	        return $reunionid;
	}
	function getMotifRejetById($motifid)
	{
		global $log;
		$log->debug("Entering getMotifRejetById(".$motifid.") method ...");
		$log->info("in getMotifRejetById ".$motifid);

	        global $adb;
	        if($motifid != '')
	        {
	                $sql = "select motiflib from nomade_reunion_motifrejet where motifid=?";
	                $result = $adb->pquery($sql, array($motifid));
	                $motiflib = $adb->query_result($result,0,"motiflib");
	        }
		$log->debug("Exiting getMotifRejetById method ...");
	        return $motiflib;
	}
	function insertintofiledemrel($relid,$id)
	{
		global $adb;
		$dbQuery = "insert into nomade_sedemandefilerel values ( ?, ? )";
		$dbresult = $adb->pquery($dbQuery,array($relid,$id));
	}
	
	function insertIntoDemandeFiles($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoConventionFiles($id,$module) method.");
		
		$file_saved = false;
		//print_r($_FILES);
		foreach($_FILES as $fileindex => $files)
		{
			for($i=0; $i<count($files); $i++)
			{
				 
				$currentfile = array('name'=>$files['name'][$i],'size'=>$files['size'][$i],'type'=>$files['type'][$i],'tmp_name'=>$files['tmp_name'][$i],'error'=>$files['error'][$i]);
				if($currentfile['name'] != '' && $currentfile['size'] > 0)
				{
					$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
					$file_saved = $this->uploadAndSaveFile($id,$module,$currentfile);
				}
			}
		}
//break;
		$log->debug("Exiting from insertIntorapport($id,$module) method.");
	}
	function getTimbresDC()
	{
		global $log;
		$log->debug("Entering getTimbres() method ...");
		$log->info("in getTimbres ");

	        global $adb;
	       
	                $sql = "SELECT id, CONCAT(timbre1,timbre2,timbre3) AS timbre FROM nomade_timbre where id IN (101,102,103,104) ORDER BY 2";
	                $result = $adb->pquery($sql, array());
	                      
		   	while ($row = $adb->fetchByAssoc($result))
		{
			$LISTTIMBRE[]=$row;
		}
		 $TIMBREOPT[''] = 'Choisir le timbre...';
		 
		foreach($LISTTIMBRE as $entry_key=>$comptenat)
		{
			$TIMBREOPT[$comptenat['id']] = $comptenat['timbre'];
		}  
		$log->debug("Exiting getTimbres method ...");
	        return $TIMBREOPT;
	}
	function getTimbresCOM()
	{
		global $log;
		$log->debug("Entering getTimbres() method ...");
		$log->info("in getTimbres ");

	        global $adb;
	       
	                $sql = "SELECT id, CONCAT(timbre1,timbre2,timbre3) AS timbre FROM nomade_timbre ORDER BY 2";
	                $result = $adb->pquery($sql, array());
	                      
		   	while ($row = $adb->fetchByAssoc($result))
		{
			$LISTTIMBRE[]=$row;
		}
		 $TIMBREOPT[''] = 'Choisir le timbre...';
		 
		foreach($LISTTIMBRE as $entry_key=>$comptenat)
		{
			$TIMBREOPT[$comptenat['id']] = $comptenat['timbre'];
		}  
		$log->debug("Exiting getTimbres method ...");
	        return $TIMBREOPT;
	}
	function getSignataires()
	{
		global $log;
		$log->debug("Entering getSignataires() method ...");
		$log->info("in getSignataires ");

	        global $adb;
	       
	                $sql = "SELECT distinct signataire FROM nomade_signataire ORDER BY 1";
	                $result = $adb->pquery($sql, array());
	                      
		   	while ($row = $adb->fetchByAssoc($result))
		{
			$LISTSIGNATAIRE[]=$row;
		}
		 $SIGNATAIREOPT[''] = 'Choisir le signataire...';
		 
		foreach($LISTSIGNATAIRE as $entry_key=>$comptenat)
		{
			$SIGNATAIREOPT[$comptenat['signataire']] = $comptenat['signataire'];
		}  
		$log->debug("Exiting getSignataires method ...");
	        return $SIGNATAIREOPT;
	}
	function savemodifsignataires($reunionid,$infossignataires)
	{
		global $adb;
		//echo "reunionid=",$reunionid,"<br>";
		//echo "timbredc=",$infossignataires->timbredc,"<br>";
		$dbQuery = "update nomade_reunion set timbredc='".$infossignataires->timbredc."',signatairedc='".$infossignataires->signatairedc."',timbrecom='".$infossignataires->timbrecom."',signatairecom='".$infossignataires->signatairecom."' where reunionid=? ";
		$dbresult = $adb->pquery($dbQuery,array($reunionid)); 
		
	}
	function saveDecision($reunionid,$regisseur)
	{
		global $adb;
		
		$dbQuery = "update nomade_reunion set regisseur='".$regisseur."' where reunionid=? ";
		$dbresult = $adb->pquery($dbQuery,array($reunionid)); 
		
	}
	
function getEmailInitiateur($ticket)
{
	global $log;
	$log->debug("Entering getEmailInitiateur(".$ticket.") method ...");
	$log->info("in getEmailInitiateur ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT aginit.user_Email AS mailto_initiateur,SUBSTRING(aginit.User_Direction,1,5) AS initiateur_depart
			FROM nomade_reunion d,users aginit,vtiger_crmentity vt
			WHERE vt.crmid=d.reunionid
			AND aginit.user_id=vt.smcreatorid
			AND d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getEmailInitiateur method ...");
        return $demande;
}
function getEmailResponssuivi($ticket)
{
	global $log;
	$log->debug("Entering getEmailResponssuivi(".$ticket.") method ...");
	$log->info("in getEmailResponssuivi ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT d.responssuivi AS matagent,agcharge.user_Email AS mailto_charge,SUBSTRING(agcharge.User_Direction,1,5) as charge_depart
			FROM nomade_reunion d,users agcharge
			WHERE agcharge.User_Matricule = d.responssuivi 
			AND d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getEmailResponssuivi method ...");
        return $demande;
}
function getEmailSUPSInitiateur($ticket)
{
	global $log;
	$log->debug("Entering getEmailSUPSInitiateur(".$ticket.") method ...");
	$log->info("in getEmailSUPSInitiateur ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT nh.emaildirecteur AS mailto_directeur,nh.emaildircab AS mailto_dircab,nh.emailcom AS mailto_com,
			nh.emailresponsumv AS mailto_respumv,nh.emaildircabpcom AS mailto_dcpc
			FROM nomade_reunion d,vtiger_crmentity vt,nomade_hierarchie nh,users aginit
			WHERE vt.crmid=d.reunionid
			AND aginit.user_id=vt.smcreatorid
			AND nh.direction=aginit.User_Direction
			AND d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getEmailSUPSInitiateur method ...");
        return $demande;
}
function getEmailSUPSResponssuivi($ticket)
{
	global $log;
	$log->debug("Entering getEmailSUPSResponssuivi(".$ticket.") method ...");
	$log->info("in getEmailSUPSResponssuivi ".$ticket);

        global $adb;
        if($ticket != '')
        {
                $sql = "SELECT d.responssuivi AS matagent,agcharge.user_Email AS mailto_charge,
			nh.emaildirecteur AS mailto_directeur,
			nh.emaildircab AS mailto_dircab,
			nh.emailcom AS mailto_com
			FROM nomade_reunion d,users agcharge,
			vtiger_crmentity vt,nomade_hierarchie nh
			WHERE vt.crmid=d.reunionid
			AND agcharge.User_Matricule = d.responssuivi 
			AND nh.direction=agcharge.User_Direction
			AND d.ticket=?";
                $result = $adb->pquery($sql, array($ticket));
				$demande = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getEmailSUPSResponssuivi method ...");
        return $demande;
}
function getAllAgentDB()
{
	global $log;
	$log->debug("Entering getAllAgentDB() method ...");
	$log->info("in getAllAgentDB ");

        global $adb;
       
                $sql = "SELECT User_Email AS email FROM users where user_direction='01-02-136' ORDER BY user_name ";
		
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
		{
			$emailagentsDB.=$row['email'].',';
		}
		
	$log->debug("Exiting getAllAgentDB method ...");
        return $emailagentsDB;
}
function getRapportMailInfo($ticket,$currentstatus)
	{
	$mail_data = Array();
	global $adb,$mod_strings;
	$mail_data = $this->getInfosByReunion($ticket);
	$mailsupcharge = $this->getEmailSUPSResponssuivi($ticket);
	$mailsupinitiateur = $this->getEmailSUPSInitiateur($ticket);
	$mailinitiateur = $this->getEmailInitiateur($ticket);
	$mailcharge = $this->getEmailResponssuivi($ticket);
	$mail_data['statut'] = $currentstatus;
	$mail_data['emailsinitiateur'] = array('initiateur'=>$mailinitiateur['mailto_initiateur'],'initiateurdepart'=>$mailinitiateur['initiateur_depart'],
						'directeur'=>$mailsupinitiateur['mailto_directeur'],'dircab'=>$mailsupinitiateur['mailto_dircab'],
						'com'=>$mailsupinitiateur['mailto_com'],
						'respumv'=>$mailsupinitiateur['mailto_respumv'],'dcpc'=>$mailsupinitiateur['mailto_dcpc']);
						
	$mail_data['emailsresponssuivi'] = array('charge'=>$mailcharge['mailto_charge'],'chargedepart'=>$mailcharge['charge_depart'],
						'directeur'=>$mailsupcharge['mailto_directeur'],
						'dircab'=>$mailsupcharge['mailto_dircab'],'com'=>$mailsupcharge['mailto_com']);
		
	return $mail_data;
	
	}

function sendNotificationReunion($desc,$currentModule)
{
	global $current_user,$adb,$mod_strings,$app_strings;
	require_once("modules/Emails/mail.php");
	
	
	$modulename=$mod_strings['LBL_MODULE'];
	
	$subject =' ';
	$to_email='';
	$to_email_cc='';	
	$statut=$desc['statut'];

	$subject = 'R&eacute;union N&deg;: '.$desc['ticket']."  ".decode_html($mod_strings[$desc['statut']]);

		
	if ($statut == 'open') {
		$to_email =$desc['emailsinitiateur']['initiateur'];
		$to_email_cc = $desc['emailsresponssuivi']['charge'].",".$desc['emailsresponssuivi']['directeur'].",".$desc['emailsinitiateur']['directeur'].",".$desc['emailsinitiateur']['dircab'].",".$desc['emailsinitiateur']['com'];
		//$to_email_cc = "";
	}
	
	if ($statut == 'dc_submitted') {
		$to_email =$desc['emailsinitiateur']['dircab'];
		$to_email_cc = $desc['emailsinitiateur']['initiateur'].",".$desc['emailsresponssuivi']['charge'];
		//$to_email =$desc['emailsinitiateur']['initiateur'];

	}
	
	
	if ($statut == 'dc_authorized') {
		//$to_email = $this->getAllAgentDB();
		$to_email = 'mlkone@uemoa.int';
		$to_email_cc =  $desc['emailsinitiateur']['initiateur'].','.$desc['emailsresponssuivi']['charge'].','.'adavid@uemoa.int'.','.'kkarimoune@uemoa.int'.','.'azoure@uemoa.int';
		//$to_email_cc =  $desc['emailsinitiateur']['initiateur'].",".$desc['emailsresponssuivi']['charge'];
	}
	
	if ($statut == 'dc_denied') {
		$to_email =$desc['emailsinitiateur']['initiateur'];
		$to_email_cc = $desc['emailsresponssuivi']['charge'];
	   // $to_email =$desc['emailsinitiateur']['initiateur'];

	}
	
	if ($statut == 'db_accepted' || $statut == 'db_denied') {
		$to_email =$desc['emailsinitiateur']['initiateur'];
		$to_email_cc = $desc['emailsinitiateur']['dircab'].",".$desc['emailsresponssuivi']['charge'];
	}
	
		
	if ($statut == 'mt_cancelled') {
		$to_email =$desc['emailsinitiateur']['initiateur'];
		$to_email_cc = $desc['emailsinitiateur']['dircab'].",".$desc['emailsresponssuivi']['charge'];
	}
	
		
	$from = $app_strings['LBL_FROM_NOMADE'];
	$description = $this->getRapportDetails($desc,$currentModule);
	
	
	$to_email_cc_cache ="";
	echo "Objet :",decode_html($subject),"<br>";
	echo "from :",$from,"<br>";
	echo "to :",$to_email,"<br>";
	echo "cc :",$to_email_cc,"<br>";
	//print_r($description);break;
	
	if ($to_email != '' && $to_email != ',,')
		 send_mail('HReports',$to_email,$from,$from,decode_html($subject),$description,$to_email_cc,$to_email_cc_cache);	
}

function getRapportDetails($description,$currentModule,$from='')
{
	        global $log,$current_user,$currentModule;
	        global $adb,$mod_strings,$app_strings;
	        $log->debug("Entering getRapportDetails(".$description.") method ...");

		
		$list='
				<table width="100%">
						<tbody>
							<tr>
								<td align="left" width="100%" valign="top" >
								<div style="margin-bottom: 2px;"><br>';
								
														$list .= '<b>Bonjour, </b><br>';
														$list .= 'Ci-apr&egrave;s, l\'&eacute;volution du projet de r&eacute;union en objet.</br>';
								
														$list .= '<ul>';
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT2"].' : </b>'.$description['ticket'];
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT3"].' : </b>'.$description['lieu'];
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT4"].' : </b>'.$description['datedebut'];
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT5"].' : </b>'.$description['datefin'];
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT6"].' : </b>'.$description['objet'];
														$list .= '<li><b>'.$mod_strings["ALL_MAIL_TEXT7"].' : </b>'.decode_html($mod_strings[$description['statut']]);
														$list .= '</ul>';
												if ($description['statut'] == 'dc_denied' || $description['statut'] == 'db_denied' ||  $description['statut'] == 'mt_cancelled')
													{
														$list .= '<br><b>'.$mod_strings["MOTIFREJET_MAIL_TEXT"].' : </b>'.$description['motif'];
														if ($description['autremotif']!='')
															$list .= '<br><b>'.$mod_strings["AUTREMOTIFREJET_MAIL_TEXT"].' : </b>'.$description['autremotif'];
														if ($description['commentaire']!='')
														$list .= '<br><b>'.$mod_strings["COMMENTAIREREJET_MAIL_TEXT"].' : </b>'.$description['commentaire'];
													}	
													$list .= '<br>';
													if ($description['statut'] == 'db_accepted')
													{
														$list .= '<br><ul>';
														$list .= '<li><b>'.$mod_strings["SIGN_MAIL_TEXT_BUDGET"].' : </b>'.$description['budget'];
														$list .= '<li><b>'.$mod_strings["SIGN_MAIL_TEXT_FIN"].' : </b>'.$description['sourcefin'];
														$list .= '<li><b>'.$mod_strings["SIGN_MAIL_TEXT_IMP"].' : </b>'.$description['codebudget'];
														$list .= '</ul>';
																												
													}	
												
													$list .= '<br><a href="'.$mod_strings["ALL_MAIL_TEXT_LIEN_URL"].'">'.decode_html($mod_strings["ALL_MAIL_TEXT_LIEN"]).'</a>';

													$list .= '<br><b>'.$mod_strings["ALL_MAIL_TEXT_SIGNATURE"];
													$list .= '<br><b>'.$mod_strings["ALL_MAIL_TEXT_MSG"];

												$list .= '</td>
											</tr>
										</tbody>
									</table> ';
																			
				
							
        $log->debug("Exiting getActivityDetails method ...");
        return $this->correctImg($list);
}

/**
 *  Cette fonction complete l url des images et 
 * 	reduit la taill des images
 */
function correctImg($imgbalise)
{
	$imgbalise = html_entity_decode($imgbalise);
	$pattern = "|<img(.*)src=\"|U";
	preg_match( $pattern , $imgbalise  , $imgs);
	$replacement = '<img height="600" width="800" src="http://10.11.2.198';
	if($imgs != null){
		$corectHtlm = str_replace($imgs[0] , $replacement, $imgbalise);
		return $corectHtlm ;
	}
	else
		return $imgbalise;
}

	
	
	
	function getFileTypeFieldName(){
		global $adb,$log;
		$query = 'SELECT fieldname from vtiger_field where tabid = ? and uitype = ?';
		$tabid = getTabid('Demandes');
		//$res = $adb->pquery($query,array($tabid,27));
		$res = $adb->pquery($query,array($tabid,61));
		$fieldname = $adb->query_result($res,0,'fieldname');
		return $fieldname;
		
	} 
	/**
	 * Return query to use based on given modulename, fieldname
	 * Useful to handle specific case handling for Popup
	 */
	function getQueryByModuleField($module, $fieldname, $srcrecord) {
		// $srcrecord could be empty
	}

	/**
	 * Get list view query (send more WHERE clause condition if required)
	 */
	function getListQuery($module, $where='') {
//		$query = "SELECT vtiger_crmentity.*, $this->table_name.* ,siprod_type_demandes.*,operations.*";
//
//		// Select Custom Field Table Columns if present
//		if(!empty($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";
//
//		$query .= " FROM $this->table_name";
//
//		$query .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";
//		
//		//$query .= "	INNER JOIN operations ON operations.Op_Id=".$this->table_name.".campagne"; 
//		$query .= "	INNER JOIN siprod_type_demandes ON siprod_type_demandes.typereunionid=".$this->table_name.".typedemande"; 
//
//		// Consider custom table join as well.
//		if(!empty($this->customFieldTable)) {
//			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
//				      " = $this->table_name.$this->table_index"; 
//		}
//		$query .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid";
//		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
//
//		$query .= "	WHERE vtiger_crmentity.deleted = 0 ".$where;
//		$query .= $this->getListViewSecurityParameter($module);
//		
		$query="SELECT DISTINCT 
				nomade_demande.reunionid,
				nomade_demande.ticket,
				nomade_demande.statut,
				nomade_demande.natmission,
				nomade_demande.modetransport,
				nomade_demande.objet,
				nomade_demande.filename,
				nomade_demande.filename2,
				nomade_demande.filename3,
				nomade_demande.filename4,
				nomade_demande.filename5,
				nomade_demande.datedebut,
				nomade_demande.datefin,
				nomade_demande.duree,
				nomade_demande.lieu,
				nomade_demande.budget,
				nomade_demande.sourcefin,
				nomade_demande.codebudget,
				nomade_demande.comptenat,
				nomade_demande.budget2,
				nomade_demande.sourcefin2,
				nomade_demande.codebudget2,
				nomade_demande.comptenat2,
				nomade_demande.budget3,
				nomade_demande.sourcefin3,
				nomade_demande.codebudget3,
				nomade_demande.comptenat3,
				nomade_demande.budget4,
				nomade_demande.sourcefin4,
				nomade_demande.codebudget4,
				nomade_demande.comptenat4,
				nomade_demande.budget5,
				nomade_demande.sourcefin5,
				nomade_demande.codebudget5,
				nomade_demande.comptenat5,
				nomade_demande.service,
				nomade_demande.matricule,
				nomade_demande.fonction,
				vtiger_crmentity.createdtime,
				vtiger_crmentity.crmid ,
				vtiger_groups.groupname,
				vtiger_groups.groupid,
				siprod_users.userid,
				siprod_users.userid
				FROM 
				nomade_demande 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = nomade_demande.reunionid 
				INNER JOIN vtiger_groups ON vtiger_groups.groupid = siprod_type_demandes.groupid 
				INNER JOIN vtiger_users2group ON vtiger_users2group.groupid = vtiger_groups.groupid 
				INNER JOIN siprod_users ON siprod_users.userid = vtiger_users2group.userid  
				INNER JOIN users ON users.user_id = siprod_users.userid  
				WHERE vtiger_crmentity.deleted = 0" ;
		
		return $query;
	}

	/**
	 * Apply security restriction (sharing privilege) query part for List view.
	 */
	function getListViewSecurityParameter($module) {
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		//require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

		$sec_query = '';
		$tabid = getTabid($module);

		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 
			&& $defaultOrgSharingPermission[$tabid] == 3) {

				$sec_query .= " AND (vtiger_crmentity.smownerid in($current_user->id) OR vtiger_crmentity.smownerid IN 
					(
						SELECT vtiger_user2role.userid FROM vtiger_user2role 
						INNER JOIN vtiger_users ON vtiger_users.id=vtiger_user2role.userid 
						INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid 
						WHERE vtiger_role.parentrole LIKE '".$current_user_parent_role_seq."::%'
					) 
					OR vtiger_crmentity.smownerid IN 
					(
						SELECT shareduserid FROM vtiger_tmp_read_user_sharing_per 
						WHERE userid=".$current_user->id." AND tabid=".$tabid."
					) 
					OR 
						(";
		
					// Build the query based on the group association of current user.
					if(sizeof($current_user_groups) > 0) {
						$sec_query .= " vtiger_groups.groupid IN (". implode(",", $current_user_groups) .") OR ";
					}
					$sec_query .= " vtiger_groups.groupid IN 
						(
							SELECT vtiger_tmp_read_group_sharing_per.sharedgroupid 
							FROM vtiger_tmp_read_group_sharing_per
							WHERE userid=".$current_user->id." and tabid=".$tabid."
						)";
				$sec_query .= ")
				)";
		}
		return $sec_query;
	}

	/**
	 * Create query to export the records.
	 */
	function create_export_query($where)
	{
		global $current_user;
		$thismodule = $_REQUEST['module'];
		
		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery($thismodule, "detail_view");
		
		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list, vtiger_groups.groupname as 'Assigned To Group', vtiger_users.user_name AS user_name 
					FROM vtiger_crmentity INNER JOIN $this->table_name ON vtiger_crmentity.crmid=$this->table_name.$this->table_index";

		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index"; 
		}

		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
		$query .= " LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id and vtiger_users.status='Active'";

		$where_auto = " vtiger_crmentity.deleted=0";

		if($where != '') $query .= " WHERE ($where) AND $where_auto";
		else $query .= " WHERE $where_auto";

		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		//require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

		// Security Check for Field Access
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[7] == 3)
		{
			//Added security check to get the permitted records only
			$query = $query." ".getListViewSecurityParameter($thismodule);
		}
		return $query;
	}

	/**
	 * Initialize this instance for importing.
	 */
	function initImport($module) {
		$this->db = new PearDatabase();
		$this->initImportableFields($module);
	}

	/**
	 * Create list query to be shown at the last step of the import.
	 * Called From: modules/Import/UserLastImport.php
	 */
	function create_import_query($module) {
		global $current_user;
		$query = "SELECT vtiger_crmentity.crmid, vtiger_users.user_name, $this->table_name.* FROM $this->table_name
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index
			LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=vtiger_crmentity.crmid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			WHERE vtiger_users_last_import.assigned_user_id='$current_user->id'
			AND vtiger_users_last_import.bean_type='$module'
			AND vtiger_users_last_import.deleted=0
			AND vtiger_users.status = 'Active'";
		return $query;
	}

	/**
	 * Delete the last imported records.
	 */
	function undo_import($module, $user_id) {
		global $adb;
		$count = 0;
		$query1 = "select bean_id from vtiger_users_last_import where assigned_user_id=? AND bean_type='$module' AND deleted=0";
		$result1 = $adb->pquery($query1, array($user_id)) or die("Error getting last import for undo: ".mysql_error()); 
		while ( $row1 = $adb->fetchByAssoc($result1))
		{
			$query2 = "update vtiger_crmentity set deleted=1 where crmid=?";
			$result2 = $adb->pquery($query2, array($row1['bean_id'])) or die("Error undoing last import: ".mysql_error()); 
			$count++;			
		}
		return $count;
	}

	/**
	 * Function which will set the assigned user id for import record.
	 */
	function set_import_assigned_user()
	{
		global $current_user, $adb;
		$record_user = $this->column_fields["assigned_user_id"];
		
		if($record_user != $current_user->id){
			$sqlresult = $adb->pquery("select id from vtiger_users where id = ?", array($record_user));
			if($this->db->num_rows($sqlresult)!= 1) {
				$this->column_fields["assigned_user_id"] = $current_user->id;
			} else {			
				$row = $adb->fetchByAssoc($sqlresult, -1, false);
				if (isset($row['id']) && $row['id'] != -1) {
					$this->column_fields["assigned_user_id"] = $row['id'];
				} else {
					$this->column_fields["assigned_user_id"] = $current_user->id;
				}
			}
		}
	}
	
	/** 
	 * Function which will give the basic query to find duplicates
	 */
	function getDuplicatesQuery($module,$table_cols,$field_values,$ui_type_arr,$select_cols='') {
		$select_clause = "SELECT ". $this->table_name .".".$this->table_index ." AS recordid, vtiger_users_last_import.deleted,".$table_cols;

		// Select Custom Field Table Columns if present
		if(isset($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";

		$from_clause = " FROM $this->table_name";

		$from_clause .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";

		// Consider custom table join as well.
		if(isset($this->customFieldTable)) {
			$from_clause .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index"; 
		}
		$from_clause .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
						LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
		
		$where_clause = "	WHERE vtiger_crmentity.deleted = 0";
		$where_clause .= $this->getListViewSecurityParameter($module);
					
		if (isset($select_cols) && trim($select_cols) != '') {
			$sub_query = "SELECT $select_cols FROM  $this->table_name AS t " .
				" INNER JOIN vtiger_crmentity AS crm ON crm.crmid = t.".$this->table_index.
					" GROUP BY $select_cols HAVING COUNT(*)>1";	
		} else {
			$sub_query = "SELECT $table_cols $from_clause $where_clause GROUP BY $table_cols HAVING COUNT(*)>1";
		}	
		
		
		$query = $select_clause . $from_clause .
					" LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=" . $this->table_name .".".$this->table_index .
					" INNER JOIN (" . $sub_query . ") AS temp ON ".get_on_clause($field_values,$ui_type_arr,$module) .
					$where_clause .
					" ORDER BY $table_cols,". $this->table_name .".".$this->table_index ." ASC";
					
		return $query;		
	}
	
	
	/** Returns a list of the associated traitement
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_traitements($ticket)
	{	
		
		global $log, $singlepane_view,$adb ;
//		global $app_strings, $default_language, $log, $translation_string_prefix;
		$log->debug("Entering get_traitements(".$ticket.") method ...");
		global $app_strings, $mod_strings;

		$button = '';
	
		
		$query =" SELECT vtiger_crmentity.smcreatorid, nomade_traitement_demandes.statut, vtiger_crmentity.createdtime AS datemodification,nomade_motifrejet.motiflib as motif,
					CONCAT( users.user_firstname, ' ', users.user_name ) AS nom
					FROM nomade_traitement_demandes
					INNER JOIN vtiger_crmentity ON nomade_traitement_demandes.traitementdemandeid = vtiger_crmentity.crmid
					INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
					LEFT JOIN nomade_motifrejet ON nomade_motifrejet.motifid = nomade_traitement_demandes.motif COLLATE utf8_unicode_ci
					WHERE nomade_traitement_demandes.ticket =?
					AND vtiger_crmentity.deleted =0	
					ORDER BY datemodification" ;
		
		$log->debug("Exiting get_traitements method ...");	

		$category = getParentTab($currentModule);
		
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["description"] = decode_html($row1["description"]);
			//$row1["statut"] = $app_strings[$row1["statut"]];
			$row1["datemodification"] = getDisplayDate($row1["datemodification"]);
			$row1["nom"] = decode_html($row1["nom"]);
			$row1["groupname"] = decode_html(getGroupTraiteurInfo($category, $row1["smcreatorid"]));
			$row1["groupe"] = decode_html($row1["groupe"]);
			$traitement[]=$row1;			
		}
		return $traitement;
	}
	
		/**
	 * Verifie l'existence du ticket pour gerer son unicit&eacute;
	 */
	function existTicket($ticket)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existTicket(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select count(*) as nb from nomade_reunion where ticket = ? " ;
		$result = $adb->pquery($query, array($ticket));
		$nbrows = $adb->query_result($result, 0 , "nb");
		
		if($nbrows < 1)
			return 1;
		else
			return 0;
	}
	
	function existlignebudget2($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existlignebudget2(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT budget2,sourcefin2,codebudget2 FROM nomade_demande WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['budget2'])!='' && trim($row1['sourcefin2'])!='') && trim($row1['codebudget2'])!='')
			return 1;
		else
			return 0;
	}
	
	function existlignebudget3($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande3(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT budget3,sourcefin3,codebudget3 FROM nomade_demande WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['budget3'])!='' && trim($row1['sourcefin3'])!='') && trim($row1['codebudget3'])!='')
			return 1;
		else
			return 0;
	}
	
	function existlignebudget4($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande4(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT budget4,sourcefin4,codebudget4 FROM nomade_demande WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['budget4'])!='' && trim($row1['sourcefin4'])!='') && trim($row1['codebudget4'])!='')
			return 1;
		else
			return 0;
	}
	
	function existlignebudget5($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande5(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT budget5,sourcefin5,codebudget5 FROM nomade_demande WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['budget5'])!='' && trim($row1['sourcefin5'])!='') && trim($row1['codebudget5'])!='')
			return 1;
		else
			return 0;
	}
	function existjustif2($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existjustif2(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT filename3,filename4 FROM nomade_demande WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['filename3'])!='' && trim($row1['filename4'])!=''))
			return 1;
		else
			return 0;
	}
	
	function saveLivraisonArticle($article)
	{
		global $adb;
		//$dt = new DateTime($prodfinvalues['datelivraison']);
		//$datelivraison = $dt->format("Y-m-d");
		
		$dbQuery = "INSERT INTO siprod_livraison_demande(demandeid,ticket,statut,numarticle,descarticle,numseriearticle,datelivraison,quantite,commentaire) VALUES(?,?,?,?,?,?,?,?,?)";
		$dbresult = $adb->pquery($dbQuery,array($article['demandeid'],$article['ticket'],$article['statut'],$article['numarticle'],$article['descarticle'],$article['numseriearticle'],$article['datelivraison'],$article['quantite'],$article['commentaire'])) or die("Error getting last import for undo: ".mysql_error()); 
		/*if (mysql_insert_id()!=0)
			return false;
		else
			return true;*/
			
	}
	
	function isarticlelivre($demandeid,$numarticle)
	{	
		global $log, $adb;
		$log->debug("Entering isarticlelivre() method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT demandeid,numarticle,descarticle,statut,numseriearticle,datelivraison,commentaire FROM siprod_livraison_demande WHERE demandeid=? AND statut=1 AND numarticle=? " ;
		$result = $adb->pquery($query, array($demandeid,$numarticle));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['demandeid'])!='' && trim($row1['numarticle'])!='' && trim($row1['descarticle'])!=''))
			return $row1;
		else
			return array();
	}
	
	
	function traiterdemande($demandeid)
	{
		global $adb;
		//$dt = new DateTime($prodfinvalues['datelivraison']);
		//$datelivraison = $dt->format("Y-m-d");
		
		$dbQuery = "UPDATE nomade_demande SET statut='traited',datelivraison=NOW() WHERE demandeid=? ";
		$dbresult = $adb->pquery($dbQuery,array($demandeid)) or die("Error getting last import for undo: ".mysql_error()); 
		/*if (mysql_insert_id()!=0)
			return false;
		else
			return true;*/
			
	}
	/** 
	 * Handle saving related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	// function save_related_module($module, $crmid, $with_module, $with_crmid) { }
	
	/**
	 * Handle deleting related module information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function delete_related_module($module, $crmid, $with_module, $with_crmid) { }

	/**
	 * Handle getting related list information.
	 * NOTE: This function has been added to CRMEntity (base class).
	 * You can override the behavior by re-defining it here.
	 */
	//function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }
}
?>