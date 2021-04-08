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

class Demandes extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = 'nomade_demande';
	var $table_index= 'demandeid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	//var $customFieldTable = Array('nomade_demandecf', 'demandeid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'nomade_demande', 'nomade_demandecf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */

	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'nomade_demande'   => 'demandeid',
	    'nomade_demandecf' => 'demandeid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'demandeid'=> Array('nomade_demande', 'demandeid'),
		'Ticket'=> Array('nomade_demande', 'ticket'),
		'Statut'=> Array('nomade_demande', 'statut'),
		'Natmission'=> Array('nomade_demande', 'natmission'),
		'Modetransport'=> Array('nomade_demande', 'modetransport'),
		'Objet'=> Array('nomade_demande', 'objet'),
		'Commentbillet'=> Array('nomade_demande', 'commentbillet'),
		'Filename'=> Array('nomade_demande', 'filename'),
		'Filename2'=> Array('nomade_demande', 'filename2'),
		'Filename3'=> Array('nomade_demande', 'filename3'),
		'Filename4'=> Array('nomade_demande', 'filename4'),
		'Filename5'=> Array('nomade_demande', 'filename5'),
		'Datedebut'=> Array('nomade_demande', 'datedebut'),
		'Datefin'=> Array('nomade_demande', 'datefin'),
		'Duree'=> Array('nomade_demande', 'duree'),
		'Lieu'=> Array('nomade_demande', 'lieu'),
		'Budget'=> Array('nomade_demande', 'budget'),
		'Sourcefin'=> Array('nomade_demande', 'sourcefin'),
		'Codebudget'=> Array('nomade_demande', 'codebudget'),
		'Comptenat'=> Array('nomade_demande', 'comptenat'),
		'Budget2'=> Array('nomade_demande', 'budget2'),
		'Sourcefin2'=> Array('nomade_demande', 'sourcefin2'),
		'Codebudget2'=> Array('nomade_demande', 'codebudget2'),
		'Comptenat2'=> Array('nomade_demande', 'comptenat2'),
		'Budget3'=> Array('nomade_demande', 'budget3'),
		'Sourcefin3'=> Array('nomade_demande', 'sourcefin3'),
		'Codebudget3'=> Array('nomade_demande', 'codebudget3'),
		'Comptenat3'=> Array('nomade_demande', 'comptenat3'),
		'Budget4'=> Array('nomade_demande', 'budget4'),
		'Sourcefin4'=> Array('nomade_demande', 'sourcefin4'),
		'Codebudget4'=> Array('nomade_demande', 'codebudget4'),
		'Comptenat4'=> Array('nomade_demande', 'comptenat4'),
		'Budget5'=> Array('nomade_demande', 'budget5'),
		'Sourcefin5'=> Array('nomade_demande', 'sourcefin5'),
		'Codebudget5'=> Array('nomade_demande', 'codebudget5'),
		'Comptenat5'=> Array('nomade_demande', 'comptenat5'),
		'Service'=> Array('nomade_demande', 'service'),
		'Matricule'=> Array('nomade_demande', 'matricule'),
		'Fonction'=> Array('nomade_demande', 'fonction')


		
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket',
		'Statut'=> 'statut',
		'Natmission'=> 'natmission',
		'Modetransport'=> 'modetransport',
		'Objet'=> 'objet',
		'Commentbillet'=> 'commentbillet',		
		'Filename'=> 'filename',
		'Filename2'=> 'filename2',
		'Filename3'=> 'filename3',
		'Filename4'=> 'filename4',
		'Filename5'=> 'filename5',
		'Datedebut'=> 'datedebut',
		'Datefin'=> 'datefin',
		'Duree'=> 'duree',
		'Lieu'=> 'lieu',
		'Budget'=> 'budget',
		'Sourcefin'=> 'sourcefin',
		'Codebudget'=> 'codebudget',
		'Comptenat'=> 'comptenat',
		'Budget2'=> 'budget2',
		'Sourcefin2'=> 'sourcefin2',
		'Codebudget2'=> 'codebudget2',
		'Comptenat2'=> 'comptenat2',
		'Budget3'=> 'budget3',
		'Sourcefin3'=> 'sourcefin3',
		'Codebudget3'=> 'codebudget3',
		'Comptenat3'=> 'comptenat3',
		'Budget4'=> 'budget4',
		'Sourcefin4'=> 'sourcefin4',
		'Codebudget4'=> 'codebudget4',
		'Comptenat4'=> 'comptenat4',
		'Budget5'=> 'budget5',
		'Sourcefin5'=> 'sourcefin5',
		'Codebudget5'=> 'codebudget5',
		'Comptenat5'=> 'comptenat5',
		'Service'=> 'service',
		'Matricule'=> 'matricule',
		'Fonction'=> 'fonction'

		);

	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'ticket';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'Ticket'=> Array('nomade_demande', 'ticket')
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
					$budget->AFISCAL=$WSSAP['AFISCAL'];  // Année budgétaire
					$budget->CODE_BUDGETAIRE=$infosbudget['codebudget']; // Code budgétaire
					$budget->CPTE_BUDGETAIRE=$comptenat; // Compte nature
					$budget->FOND=$infosbudget['sourcefin']; // Source de Finanacement
					
					$societe = substr($infosbudget['codebudget'], 0, 2);
					$budget->PF=$WSSAP['PERIMETREFIN'][$societe]; // Périmétre Financier
											
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
						//print_r($exception);
					 //   print "***END Exception***\n";
						//die();
					//	continue;
					}
				
			}
		}
		
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

	function is_demandeMembreOrgane($demandeid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering is_demandeMembreOrgane(".$demandeid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT COUNT(u2.user_id) AS nbrow
			FROM nomade_demande,users u2,siprod_users su
			WHERE nomade_demande.matricule=u2.User_Matricule
			AND u2.user_id=su.userid
			AND su.profilid=25
			AND nomade_demande.demandeid=? " ;
		$result = $adb->pquery($query, array($demandeid));
		$row1 = $adb->fetchByAssoc($result);
		return $row1['nbrow'];
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
		
		$this->insertIntoDemandeFiles($this->id,'Demandes');
		
	
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
//		$query .= "	INNER JOIN siprod_type_demandes ON siprod_type_demandes.typedemandeid=".$this->table_name.".typedemande"; 
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
				nomade_demande.demandeid,
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
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = nomade_demande.demandeid 
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
	 
	 function getNbJourConsommeAgent($matricule,$demandeid)
{
	global $log;
	$log->debug("Entering getNbJourAnneeAgent(".$matricule.") method ...");
	$log->info("in getNbJourAnneeAgent ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT SUM(nomade_ordremission.duree) AS nbjour 
						FROM nomade_ordremission
						INNER JOIN nomade_demande ON nomade_demande.demandeid=omid AND nomade_demande.lieu!='OUAGADOUGOU'
						WHERE nomade_ordremission.matricule=? AND nomade_ordremission.omid!=? and nomade_ordremission.deleted=0";
                $result = $adb->pquery($sql, array($matricule,$demandeid));
               $row = $adb->fetchByAssoc($result);
				
        }
	$log->debug("Exiting getNbJourAnneeAgent method ...");
        return $row['nbjour'];
}
	 
	function get_traitements($ticket)
	{	
		
		global $log, $singlepane_view,$adb ;
//		global $app_strings, $default_language, $log, $translation_string_prefix;
		$log->debug("Entering get_traitements(".$ticket.") method ...");
		global $app_strings, $mod_strings;

		$button = '';
	
		
		$query =" SELECT vtiger_crmentity.smcreatorid, nomade_traitement_demandes.statut, vtiger_crmentity.createdtime AS datemodification,
					nomade_motifrejet.motiflib as motif,nomade_traitement_demandes.autremotif, 
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
			//$date = new DateTime($row1["datemodification"], new DateTimeZone('Europe/Paris')); 
			//$datemodif =  date("Y-m-d H:i:s", $date->format('U'));
			//$row1["datemodification"] = getDisplayDate($datemodif);
			$row1["datemodification"] = getDisplayDate($row1["datemodification"]);
			$row1["nom"] = decode_html($row1["nom"]);
			$row1["groupname"] = decode_html(getGroupTraiteurInfo($category, $row1["smcreatorid"]));
			$row1["groupe"] = decode_html($row1["groupe"]);
			$traitement[]=$row1;			
		}
		return $traitement;
	}
	
		/**
	 * Verifie l'existence du ticket pour gerer son unicité
	 */
	function existTicket($ticket)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existTicket(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select count(*) as nb from nomade_demande where ticket = ? " ;
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