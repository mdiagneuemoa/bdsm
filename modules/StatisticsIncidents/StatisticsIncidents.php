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

class StatisticsIncidents extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = 'vtiger_payslip';
	var $table_index= 'payslipid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_payslipcf', 'payslipid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'vtiger_payslip', 'vtiger_payslipcf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_payslip'   => 'payslipid',
	    'vtiger_payslipcf' => 'payslipid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Payslip Name'=> Array('payslip', 'payslipname'),
		'Assigned To' => Array('crmentity','smownerid')
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Payslip Name'=> 'payslipname',
		'Assigned To' => 'assigned_user_id'
	);

	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'payslipname';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Payslip Name'=> Array('payslip', 'payslipname')
	);
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Payslip Name'=> 'payslipname'
	);

	// For Popup window record selection
	var $popup_fields = Array('payslipname');

	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();

	// For Alphabetical search
	var $def_basicsearch_col = 'payslipname';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'payslipname';

	// Required Information for enabling Import feature
	var $required_fields = Array('payslipname'=>1);

	// Callback function list during Importing
	var $special_functions = Array('set_import_assigned_user');

	var $default_order_by = 'payslipname';
	var $default_sort_order='ASC';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'payslipname');
	
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

	function save_module($module) {
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
	
	
	
	//////////////// DEBUT GID PCCI	////////////////

		// << ======= INCIDENTS	======= >>
	
	function getNbIncidentsDeclares() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbIncidentsDeclares() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$statut_val = $_REQUEST['statut_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];

		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "select count(*) as nb_incident_declare
					from $viewIncident I, siprod_type_incidents, $viewIncidentCrmentity C 
					where C.crmid = I.incidentid 
					and C.deleted = 0
					and I.typeincident=typeincidentid ";

		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',groupid,' '),concat(' ', $groupname_val, ' ')) > 0";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and typeincidentid = $typologie_val";
		}
		
		if(isset($statut_val) && $statut_val != '') {
			$url_string .= "&statut_field=".$statut_val;
			$query .=" and I.statut = ".$adb->quote($statut_val);
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and I.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and C.createdtime >=".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and C.createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
				
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_incident_declare");
		
		return $noofrows;
	}
	
	function getNbIncidentsTraitesDansDelai() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbIncidentsTraitesDansDelai() method.");
				
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];
		$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/

		$query = "SELECT count(*) as nb_incident_traites_dans_delai from 
				    (
				     SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement, TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement, REQ.delais,REQ.campagne,REQ.typeincidentid,REQ.groupid
				     FROM
				     (
						SELECT C.createdtime,I.campagne,op_lib,I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,TI.typeincidentid,TI.groupid,TI.delais
						FROM $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewIncidentCrmentity C,operations
						WHERE ((T1.statut = 'traited') or (T1.statut= 'closed'))
						AND C.crmid = I.incidentid
						AND C1.crmid = T1.traitementincidentid
						and Op_Id=  I.campagne 
						and C.deleted = 0
						and C1.deleted = 0
						AND I.ticket = T1.ticket
						AND I.typeincident= TI.typeincidentid
						GROUP BY I.ticket
						UNION
						SELECT C.createdtime,I.campagne,op_lib,T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,TI.typeincidentid,TI.groupid,TI.delais
						FROM $viewTraitementIncident T, $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewTrIncidentCrmentity C,operations
						WHERE ((T1.statut = 'traited') or (T1.statut ='closed'))
						AND C.crmid = T.traitementincidentid
						AND C1.crmid = T1.traitementincidentid
						and Op_Id=  I.campagne
						and C.deleted = 0
						and C1.deleted = 0
						AND T.ticket = T1.ticket
						and T.ticket not in (
									select SI.ticket
									from $viewIncident SI ,$viewIncidentCrmentity CR 
									where CR.deleted = 0 and   CR.crmid = SI.incidentid 
									)
						AND T.statut = 'reopen'
						AND I.typeincident= TI.typeincidentid
						GROUP BY T.ticket
				      ) REQ
				      where TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement) <= REQ.delais ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',REQ.groupid,' '),concat(' ', $groupname_val, ' ')) > 0 ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and REQ.typeincidentid = $typologie_val";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >=".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
	    $query .= " )REQ2";
     //echo $query; break;
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_incident_traites_dans_delai");
		
		return $noofrows;
	}
	
	function getNbIncidentsTraitesAuDelaDelai() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbIncidentsTraitesAuDelaDelai() method.");
				
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];
		$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/

		$query = "SELECT count(*) as nb_incident_traites_au_dela_delai from 
                            (
                             SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement, TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement, REQ.delais,REQ.campagne,REQ.typeincidentid,REQ.groupid
                             FROM
                             (
                                                            SELECT C.createdtime,I.campagne,op_lib,I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,TI.typeincidentid,TI.groupid,TI.delais
                                                            FROM $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewIncidentCrmentity C,operations
                                                            WHERE ((T1.statut = 'traited') or (T1.statut= 'closed'))
                                                            AND C.crmid = I.incidentid
                                                            AND C1.crmid = T1.traitementincidentid
                                                            and Op_Id=  I.campagne 
                                                            and C.deleted = 0
                                                            and C1.deleted = 0
                                                            AND I.ticket = T1.ticket
                                                            AND I.typeincident= TI.typeincidentid
                                                            GROUP BY I.ticket
                                                            UNION
                                                            SELECT C.createdtime,I.campagne,op_lib,T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,TI.typeincidentid,TI.groupid,TI.delais
                                                            FROM $viewTraitementIncident T, $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewTrIncidentCrmentity C,operations
                                                            WHERE ((T1.statut = 'traited') or (T1.statut ='closed'))
                                                            AND C.crmid = T.traitementincidentid
                                                            AND C1.crmid = T1.traitementincidentid
                                                            and Op_Id=  I.campagne
                                                            and C.deleted = 0
                                                            and C1.deleted = 0
                                                            AND T.ticket = T1.ticket
                                                            and T.ticket not in (
                                                                        select SI.ticket
                                                                        from $viewIncident SI ,$viewIncidentCrmentity CR 
                                                                        where CR.deleted = 0 and   CR.crmid = SI.incidentid 
                                                                        )
                                                            AND T.statut = 'reopen'
                                                            AND I.typeincident= TI.typeincidentid
                                                            GROUP BY T.ticket
                                                            ) 
                                                            REQ
				      where TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement) > REQ.delais ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',REQ.groupid,' '),concat(' ', $groupname_val, ' ')) > 0 ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and REQ.typeincidentid = $typologie_val";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >=".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
	    $query .= " )REQ2";
	    
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_incident_traites_au_dela_delai");
		
		return $noofrows;
	}
	
		function getNbIncidentsNonSouffrance() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "SELECT count(*)as nb_incidents_non_souffrant from 
                       (
                        SELECT REQ.ticket, REQ.statutcreation, REQ.datecreation,TIMESTAMPDIFF(MINUTE,
                        REQ.datecreation, now())as dureetraitement, REQ.delais,REQ.campagne,REQ.typeincidentid,REQ.groupid
                        FROM
                        (
                          select I.ticket, I.statut as statutcreation, C.createdtime as datecreation, TI.delais,I.campagne,TI.typeincidentid,TI.groupid
                          from $viewIncident I
                          inner join siprod_type_incidents TI on I.typeincident= TI.typeincidentid
                          inner join $viewIncidentCrmentity C  on I.incidentid= C.crmid
                          where C.deleted = 0
                          and ((I.statut = 'open') or (I.statut = 'reopen') or (I.statut = 'transfered'))
                          and  DATE(C.createdtime) = DATE(NOW())
                          group by I.ticket
                       ) REQ
                       where ((TIMESTAMPDIFF(MINUTE,REQ.datecreation, now()) < REQ.delais)  or (TIMESTAMPDIFF(MINUTE,REQ.datecreation, now()) = REQ.delais)) ";

		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',REQ.groupid,' '),concat(' ',$groupname_val,' ')) > 0 ";
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and REQ.typeincidentid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
			
		$query .= ") REQ2";
     
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_incidents_non_souffrant");
		
		return $noofrows;
	}
	
	function getNbIncidentsEnSouffrance() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];
		$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "SELECT count(*)as nb_incidents_en_souffrance from 
			     (
			      SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation,TIMESTAMPDIFF(MINUTE,
			      REQ.datecreation, now())as dureetraitement, REQ.delais,REQ.campagne,REQ.typeincidentid,REQ.groupid
			      FROM
			      (
			       select I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TI.delais,I.campagne,TI.typeincidentid,TI.groupid
			        from $viewIncident I
			        inner join siprod_type_incidents TI on I.typeincident= TI.typeincidentid
			        left join $viewTraitementIncident T1 on I.ticket = T1.ticket
			        inner join $viewIncidentCrmentity C  on I.incidentid= C.crmid
			        where I.ticket not in (select distinct VT.ticket from $viewTraitementIncident VT where ifnull(VT.statut,'') = 'traited' OR ifnull(VT.statut,'') = 'closed' OR ifnull(VT.statut,'') = 'reopen')
			        AND C.deleted = 0
			        group by I.ticket
			
			       UNION
			
			       SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TI.delais,I.campagne,TI.typeincidentid,TI.groupid
			       FROM $viewTraitementIncident T, $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewTrIncidentCrmentity C
			       WHERE T.ticket not in ( select VT.ticket from  $viewTraitementIncident VT where VT.statut= 'traited' OR VT.statut= 'closed')
			       AND C.crmid = T.traitementincidentid
			       AND C.deleted = 0
			       AND C1.crmid = T1.traitementincidentid
			       AND T.ticket = T1.ticket
			       AND I.ticket = T1.ticket
			       AND T.statut = 'reopen'
			       AND I.typeincident= TI.typeincidentid
			       GROUP BY T.ticket
			       ) REQ
			
			       where TIMESTAMPDIFF(MINUTE,REQ.datecreation, now()) > REQ.delais";

		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',REQ.groupid,' '),concat(' ',$groupname_val,' ')) > 0 ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and REQ.typeincidentid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
			
		$query .= ") REQ2";
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_incidents_en_souffrance");
		
		return $noofrows;
	}
		
	function getIncidentsDureeMoyenneTraitement() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];
		$viewTrIncidentCrmentity = $dbconfig['gid_tr_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "SELECT AVG(dureetraitement)as moyenne_traitement from 
					(
						SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement,REQ.campagne,REQ.typeincidentid,REQ.groupid,
						TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement
						FROM
						(
							SELECT I.ticket, I.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,I.campagne,TI.typeincidentid,TI.groupid
							FROM $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewIncidentCrmentity C
							WHERE T1.statut = 'traited'
							AND C.crmid = I.incidentid
							AND C1.crmid = T1.traitementincidentid
							and C.deleted = 0
							and C1.deleted = 0
							AND I.ticket = T1.ticket
							AND I.typeincident= TI.typeincidentid
							GROUP BY I.ticket 
						
							UNION
						
							SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,I.campagne,TI.typeincidentid,TI.groupid
							FROM $viewTraitementIncident T, $viewIncident I,siprod_type_incidents TI,$viewTraitementIncident T1, $viewTrIncidentCrmentity C1, $viewTrIncidentCrmentity C
							WHERE T1.statut = 'traited'
							AND C.crmid = T.traitementincidentid
							AND C1.crmid = T1.traitementincidentid
							and C.deleted = 0
							and C1.deleted = 0
							AND T.ticket = T1.ticket
							AND T.statut = 'reopen'
							AND I.typeincident= TI.typeincidentid
							GROUP BY T.ticket
						) REQ ";
		/*
			# and instr(concat(' ',REQ.groupid,' '),concat(' ',51,' ')) > 0 
			# and REQ.typeincidentid =820
			# and REQ.campagne = 1000862
			# and  datecreation between '2010-04-18' and '2010-04-27'
		*/
		
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .= " where REQ.typeincidentid = $typologie_val ";
			
			if(isset($groupname_val) && $groupname_val != '') {
				$url_string .= "&groupname_field=".$groupname_val;
				$query .=" and instr(concat(' ',REQ.groupid,' '),concat(' ', $groupname_val, ' ')) > 0  ";
				 
			}
				
			if(isset($campagne_val) && $campagne_val != '') {
				$url_string .= "&campagne_field=".$campagne_val;
				$query .= " and REQ.campagne = $campagne_val ";
			}
			
			if(isset($date_start_val) && $date_start_val != '') {
				$url_string .= "&date_start=".$date_start_val; 
				$d = new DateTime($date_start_val);
				$date_start = $d->format("Y-m-d");
				$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
			}
					
			if(isset($date_end_val) && $date_end_val != '') {
				$url_string .= "&date_end=".$date_end_val;
				$d = new DateTime($date_end_val);
				$date_end = $d->format("Y-m-d");
				$query .= " and datecreation <= ".$adb->quote($date_end." 23:59:59");
			}	
		}
		$query .= " )REQ2
					GROUP BY REQ2.statuttraitement";
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "moyenne_traitement");
		
		return $noofrows;
	}
	
	function getIncidentsOrigineInterne() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getIncidentsOrigineInterne() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "select count(distinct crmid) as origine_interne
					from $viewTraitementIncident TI ,$viewIncident I,siprod_type_incidents ,$viewIncidentCrmentity C
					where origine = 'interne'
					and typeincident=typeincidentid 
					and C.crmid = incidentid
					and C.deleted= 0
					and TI.ticket= I.ticket ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',siprod_type_incidents.groupid,' '),concat(' ', $groupname_val, ' ')) > 0 ";
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and siprod_type_incidents.typeincidentid = $typologie_val";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and I.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and C.createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and C.createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	

		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_interne");
		
		return $noofrows;
	}
	
	function getIncidentsOrigineExterne() {
		global $log, $adb;
		global $dbconfig;

		$log->debug("Entering select getIncidentsOrigineExterne() method.");
				
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];
		$viewTraitementIncident = $dbconfig['gid_traitement_incident'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		if ($viewTraitementIncident == '') {
			$viewTraitementIncident = 'siprod_traitement_incidents';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "select count(distinct crmid) as origine_externe
					from $viewTraitementIncident TI ,$viewIncident I,siprod_type_incidents ,$viewIncidentCrmentity C
					where origine = 'externe'
					and typeincident=typeincidentid 
					and C.crmid = incidentid
					and C.deleted= 0
					and TI.ticket= I.ticket ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',siprod_type_incidents.groupid,' '),concat(' ', $groupname_val, ' ')) > 0 ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and siprod_type_incidents.typeincidentid = $typologie_val";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and I.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and C.createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and C.createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
				
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_externe");
		
		return $noofrows;
	}

	function getNbIncidentStatut() {
		global $log, $adb;
		global $dbconfig;
		
		$log->debug("Entering select getNbIncidentStatut() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		//*********** Debut prise en compte de l'historisation **************/
		$dateStart = (isset($date_start_val) && $date_start_val != '') ? $date_start_val : '';
		$dateEnd = (isset($date_end_val) && $date_end_val != '') ? $date_end_val : '';
		
		$isQueryRangeAll = isQueryRangeAll ($dateStart, $dateEnd);

		$viewIncident = $dbconfig['gid_incident'];
		$viewIncidentCrmentity = $dbconfig['gid_incient_crmentity'];

		if ($viewIncident == '') {
			$viewIncident = 'siprod_incident';
		}
		//*********** Fin prise en compte de l'historisation **************/
		
		$query = "select S.statut, ifnull(nb_incident,0) as nb_incident
					from 
						(select   statut,count(*) as nb_incident 
						from $viewIncident I , $viewIncidentCrmentity C,siprod_type_incidents
						where C.crmid = I.incidentid
						and C.deleted = 0
						and I.typeincident = typeincidentid ";
					
		if(isset($groupname_val) && $groupname_val != '') {
			$url_string .= "&groupname_field=".$groupname_val;
			$query .=" and instr(concat(' ',siprod_type_incidents.groupid,' '),concat(' ',$groupname_val,' ')) > 0";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$url_string .= "&typologie_field=".$typologie_val;
			$query .="  and siprod_type_incidents.typeincidentid = $typologie_val";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$url_string .= "&campagne_field=".$campagne_val;
			$query .= " and I.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$url_string .= "&date_start=".$date_start_val; 
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and C.createdtime >=".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$url_string .= "&date_end=".$date_end_val;
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and C.createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
		$query .= " group by statut) D 
					right join siprod_statuts S on S.statut=D.statut
					group by statut ASC";
		//echo $query; break;
		$result = $adb->pquery($query, array());
		
		$nbDmeOpen = $adb->query_result($result, 1, "nb_incident");
		$nbDmeReopen = $adb->query_result($result, 3, "nb_incident"); 
		$nbDmeTransfered= $adb->query_result($result, 5, "nb_incident"); 
		
		$nbDmeOuvert = $nbDmeOpen + $nbDmeReopen + $nbDmeTransfered ; 
		$listStatutTpl[0] = $nbDmeOuvert;
		if ($nbDmeOuvert > 0){
			$listStatut["A traiter"] = $nbDmeOuvert;
		}
		 
		$nbDmePending = $adb->query_result($result, 2, "nb_incident"); 
		$listStatutTpl[1] = $nbDmePending ;
		if ($nbDmePending > 0){
			$listStatut["En cours de traitement"] = $nbDmePending;
		}
		
		$nbDmeTraited= $adb->query_result($result, 4, "nb_incident"); 
		$listStatutTpl[2] = $nbDmeTraited ;
		if ($nbDmeTraited > 0){
		    $listStatut["En attente de clôture"] = $nbDmeTraited;
		}
		
		$nbDmeClose = $adb->query_result($result, 0, "nb_incident");
		$listStatutTpl[3] = $nbDmeClose ;
		if ($nbDmeClose > 0){
			$listStatut["Clôturés"] = $nbDmeClose;
		}

		$_SESSION['valuesStatut'] = $listStatut ; 
		
				
		return $listStatutTpl;
	}
		
	//////////////// FIN GID PCCI	////////////////
}
?>