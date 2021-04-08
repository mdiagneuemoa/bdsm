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

class TraitementDemandes extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = 'nomade_traitement_demandes';
	var $table_index= 'traitementdemandeid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('nomade_traitement_demandescf', 'traitementdemandeid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'nomade_traitement_demandes', 'nomade_traitement_demandescf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'nomade_traitement_demandes'   => 'traitementdemandeid',
	    'nomade_traitement_demandescf' => 'traitementdemandeid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Ticket'=> Array('nomade_traitement_demandes', 'ticket'),
		'Motif'=> Array('nomade_traitement_demandes', 'motif'),
		'Autremotif'=> Array('nomade_traitement_demandes', 'autremotif'),
		'Description' => Array('nomade_traitement_demandes','description'),
		'Statut' => Array('nomade_traitement_demandes','statut'),
		'Date' => Array('nomade_traitement_demandes','datemodification'),
		'User' => Array('nomade_traitement_demandes','user'),
		'Matricule' => Array('nomade_traitement_demandes','matricule'),		
		'Service' => Array('nomade_traitement_demandes','service'),		
		'Fonction' => Array('nomade_traitement_demandes','fonction'),	
		);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket',
		'Motif'=>  'motif',
		'Autremotif'=>  'autremotif',
		'Description' => 'description',
		'Statut' =>  'statut',
		'Date' => 'datemodification',
		'User' => 'user',
		'Matricule' => 'matricule',		
		'Service' => 'service',		
		'Fonction' => 'fonction',	
		);		


	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'ticket';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Ticket'=> Array('nomade_traitement_demandes', 'ticket')
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
	var $default_sort_order='ASC';
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
	function save_module($module) {
	}
	function getinfosagent($matricule)
	{
	global $log;
	$log->debug("Entering getinfosagent(".$matricule.") method ...");
	$log->info("in getinfosagent ".$matricule);

        global $adb;
        if($matricule != '')
        {
                $sql = "SELECT User_Matricule AS matricule,user_name AS nom,user_firstname AS prenoms,User_Direction AS affectdirection
						FROM users WHERE User_Matricule=?";
                $result = $adb->pquery($sql, array($matricule));
                $user['matricule'] = $adb->query_result($result,0,"matricule");
                $user['nom'] = $adb->query_result($result,0,"nom");
                $user['prenom'] = $adb->query_result($result,0,"prenoms");
                $affectdirection = $adb->query_result($result,0,"affectdirection");
                //$user['service'] = getServiceAgent($affectdirection);
               $user['direction'] = $affectdirection;
               $user['fonction'] = $adb->query_result($result,0,"affectfonction");		
								
        }
		$log->debug("Exiting getinfosagent method ...");
        return $user;
	}
	
		
	function cancelMission($nummission)
	{
		global $log, $singlepane_view,$adb,$WSSAP;
		$log->debug("Entering cancelMission(".$nummission.") method ...");
		$log->info("in cancelMission ".$nummission);

			$reqUpdate1= "update nomade_ordremission set deleted ='1',datedeleted=now() where omid=? " ;
			$adb->pquery($reqUpdate1, array($nummission));
			
			/***************** Annulation Engagement ****************************/ 
			
			$sql = "SELECT numengagement FROM nomade_ordremission WHERE deleted ='1' and omid=?";
			$result = $adb->pquery($sql, array($nummission));
			$numengagement = $adb->query_result($result,0,"numengagement");
					
			if($numengagement!='')
			{
				$initiateurdem = getInitiateurDemandeInfos($nummission);
				$engagement['societe'] = getSocieteSap($initiateurdem['user_direction']);
				$engagement['numengagement'] = $numengagement;
				$this->cancelEngagementMission($engagement);
			}
			
			
			$log->debug("Exiting cancelMission method ...");
			
	}
	
	function cancelEngagementMission($infosengagement)
	{	
		global $log, $singlepane_view,$adb,$WSSAP;
		$log->debug("Entering cancelEngagementMission(".$infosengagement.") method ...");
		global $app_strings, $mod_strings;
		
		header('Content-Type: text/html; charset=utf-8');
		
		$SOAP_AUTH = array( 'login'    => $WSSAP['SOAP_AUTH']['user'],
                        'password' => $WSSAP['SOAP_AUTH']['password']);
			
		$WSDL = $WSSAP['URL_ANNULERENGAGEMENT'];
		   #Create Client Object, download and parse WSDL
		    try
			{
				$client = new SoapClient($WSDL,$SOAP_AUTH);
			}
			catch (SoapFault $exception)
			{
				$message = "Impossible d'annuler l'engagement SAP est temporairement indisponible!!!";
			 
			}
			$mission->BELNR=$infosengagement['numengagement'];  // Numéro de l'engagement
			$mission->SOCIETE=$infosengagement['societe']; // Société	 
			
			try
			{
			  $result = $client->ZWSFI07_CANCELDOCUMENT($mission); 
			}
			catch (SoapFault $exception)
			{
				$message = "Impossible d'annuler l'engagement SAP est temporairement indisponible!!!";

			}
			$result['msgErreurSap'] = $message;
			#Out the results
		//	echo "<br><br>";
		//	print_r($result);
		
		
		return $result;
			
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
		$query = "SELECT vtiger_crmentity.*, $this->table_name.*";

		// Select Custom Field Table Columns if present
		if(!empty($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";

		$query .= " FROM $this->table_name";

		$query .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";

		// Consider custom table join as well.
		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index"; 
		}
		$query .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid";
		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";

		$query .= "	WHERE vtiger_crmentity.deleted = 0 ".$where;
		$query .= $this->getListViewSecurityParameter($module);
		return $query;
	}

	/**
	 * Apply security restriction (sharing privilege) query part for List view.
	 */
	function getListViewSecurityParameter($module) {
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

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
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

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
	
		/**
	 * Verifie l'existence du statut pour gerer l'unicité 
	 * des actions
	 *   return select ticket_incident('201007061215','traited')
	 */
	function existStatut($ticket,$statut)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existTicket(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select count(*) from nomade_demande where ticket = ? and statut= ?" ;
		$result = $adb->pquery($query, array($ticket,$statut));
		$nbrows = $adb->query_result($result, 0 , "statut");
		
		if($nbrows < 1)
			return 1;
		else
			return 0;
	}
function getMotifRejetById($motifid)
	{
		global $log;
		$log->debug("Entering getMotifRejetById(".$motifid.") method ...");
		$log->info("in getMotifRejetById ".$motifid);

	        global $adb;
	        if($motifid != '')
	        {
	                $sql = "select motiflib from nomade_motifrejet where motifid=?";
	                $result = $adb->pquery($sql, array($motifid));
	                $motiflib = $adb->query_result($result,0,"motiflib");
	        }
		$log->debug("Exiting getMotifRejetById method ...");
	        return $motiflib;
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