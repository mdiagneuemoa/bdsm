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

class StatisticsDemandes extends CRMEntity {
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

		// <<======= DEMANDES =======>>
		
	
	function getNbDemandesDeclares() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandesDeclares() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "select count(*) as  nb_demande_declare
					from siprod_demande ,siprod_type_demandes , vtiger_crmentity
					where crmid = Demandeid
					and deleted= 0
					and typedemande=typedemandeid";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and  groupid = $groupname_val  ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .="  and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_demande_declare");
		
		return $noofrows;
	}
	
	function getNbDemandesTraitesDansDelai() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandesTraitesDansDelai() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "SELECT count(*) as nb_demande_traites_dans_delai from 
					(
					SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement, TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement, REQ.delais,REQ.campagne,REQ.typedemandeid,REQ.groupid
					FROM
					(
						SELECT D.ticket, D.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
						FROM siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
						WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
						AND C.crmid = D.demandeid
						AND C1.crmid = T1.traitementdemandeid
						and C.deleted = 0
						and C1.deleted = 0
						AND D.ticket = T1.ticket
						AND D.typedemande= TD.typedemandeid
						GROUP BY D.ticket
						
						UNION
						
						SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
						FROM siprod_traitement_demandes T, siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
						WHERE ( (T1.statut = 'traited') or (T1.statut = 'closed') )
						AND C.crmid = T.traitementdemandeid
						AND C1.crmid = T1.traitementdemandeid
						and C.deleted = 0
						and C1.deleted = 0
						AND T.ticket = T1.ticket
						AND T.statut = 'reopen'
						AND D.typedemande= TD.typedemandeid
						GROUP BY T.ticket
					
					) REQ
					
					where TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement) <= REQ.delais ";
	
		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and REQ.groupid = $groupname_val  ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .="  and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
 		$query .= " )REQ2";
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_demande_traites_dans_delai");
		
		return $noofrows;
	}
	
	function getNbDemandesTraitesAuDelaDelai() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "SELECT count(*) as nb_demande_traites_au_dela_delai from 
					(
					SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement, TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement, REQ.delais,REQ.campagne,REQ.typedemandeid,REQ.groupid
					FROM
					(
						SELECT D.ticket, D.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
						FROM siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
						WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
						AND C.crmid = D.demandeid
						AND C1.crmid = T1.traitementdemandeid
						and C.deleted = 0
						and C1.deleted = 0
						AND D.ticket = T1.ticket
						AND D.typedemande= TD.typedemandeid
						GROUP BY D.ticket
						
						UNION
						
						SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
						FROM siprod_traitement_demandes T, siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
						WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
						AND C.crmid = T.traitementdemandeid
						AND C1.crmid = T1.traitementdemandeid
						and C.deleted = 0
						and C1.deleted = 0
						AND T.ticket = T1.ticket
						AND T.statut = 'reopen'
						AND D.typedemande= TD.typedemandeid
						GROUP BY T.ticket
					
					) REQ
					
					where TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement) > REQ.delais ";
	
		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and REQ.groupid = $groupname_val  ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .="  and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
 		$query .= " )REQ2";
		
 		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_demande_traites_au_dela_delai");
		
		return $noofrows;
	}
	
	function getNbDemandesEnSouffrance() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "SELECT count(*)as nb_demandes_en_souffrance from 
					(
						SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation,TIMESTAMPDIFF(MINUTE,
						REQ.datecreation, now())as dureetraitement, REQ.delais,REQ.campagne,REQ.typedemandeid,REQ.groupid
						FROM
						(
							select D.ticket, D.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
							from siprod_demande D
							inner join siprod_type_demandes TD on D.typedemande= TD.typedemandeid
							left join siprod_traitement_demandes T1 on D.ticket = T1.ticket
							inner join vtiger_crmentity C  on D.demandeid= C.crmid
							where D.ticket not in (
									select distinct ticket from siprod_traitement_demandes where (  ifnull(statut,'') = 'traited' OR ifnull(statut,'') = 'closed' OR ifnull(statut,'') = 'reopen' )
									)
							and C.deleted = 0
							group by D.ticket
							
							UNION
							
							SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, TD.delais,D.campagne,TD.typedemandeid,TD.groupid
							FROM siprod_traitement_demandes T, siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
							WHERE T.ticket not in ( select ticket from  siprod_traitement_demandes  where (statut= 'traited' OR statut= 'closed') )
							AND C.crmid = T.traitementdemandeid
							AND C1.crmid = T1.traitementdemandeid
							and C.deleted = 0
							and C1.deleted = 0
							AND T.ticket = T1.ticket
							AND D.ticket = T1.ticket
							AND T.statut = 'reopen'
							AND D.typedemande= TD.typedemandeid
							GROUP BY T.ticket
						) REQ
						where TIMESTAMPDIFF(MINUTE,REQ.datecreation, now()) > REQ.delais ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and REQ.groupid = $groupname_val  ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .="  and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and REQ.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and datecreation >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and datecreation  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
		$query .= " ) REQ2";

		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "nb_demandes_en_souffrance");
		
		return $noofrows;
	}
		
	function getDemandesDureeMoyenneTraitement() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandesTraitesAuDelaDelai() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "SELECT AVG(dureetraitement)as moyenne_traitement from 
					(
						SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement,
						TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement
						FROM
						(
							SELECT D.ticket, D.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement
							FROM siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
							WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
							AND C.crmid = D.demandeid
							AND C1.crmid = T1.traitementdemandeid
							AND D.ticket = T1.ticket
							AND D.typedemande= TD.typedemandeid
							GROUP BY D.ticket
						 
							UNION
						
							SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement
							FROM siprod_traitement_demandes T, siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
							WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
							AND C.crmid = T.traitementdemandeid
							AND C1.crmid = T1.traitementdemandeid
							AND T.ticket = T1.ticket
							AND T.statut = 'reopen'
							AND D.typedemande= TD.typedemandeid
							GROUP BY T.ticket
						 ) REQ
					)REQ2
					GROUP BY REQ2.statuttraitement";
		
		$query = "SELECT AVG(dureetraitement)as moyenne_traitement from 
					(
						SELECT REQ.ticket, REQ.statutcreation, REQ.statuttraitement, REQ.datecreation, REQ.datetraitement,REQ.campagne,REQ.typedemandeid,REQ.groupid,
						TIMESTAMPDIFF(MINUTE,REQ.datecreation, REQ.datetraitement)as dureetraitement
						FROM
						(
							SELECT D.ticket, D.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MIN(C1.createdtime) as datetraitement,D.campagne,TD.typedemandeid,TD.groupid
							FROM siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
							WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
							AND C.crmid = D.demandeid
							AND C1.crmid = T1.traitementdemandeid
							and C.deleted = 0
							and C1.deleted = 0
							AND D.ticket = T1.ticket
							AND D.typedemande= TD.typedemandeid
							GROUP BY D.ticket
							
							UNION
							
							SELECT T.ticket, T.statut as statutcreation, T1.statut as statuttraitement, C.createdtime as datecreation, MAX(C1.createdtime )as datetraitement,D.campagne,TD.typedemandeid,TD.groupid
							FROM siprod_traitement_demandes T, siprod_demande D,siprod_type_demandes TD,siprod_traitement_demandes T1, vtiger_crmentity C1, vtiger_crmentity C
							WHERE ((T1.statut = 'traited') or (T1.statut = 'closed'))
							AND C.crmid = T.traitementdemandeid
							AND C1.crmid = T1.traitementdemandeid
							and C.deleted = 0
							and C1.deleted = 0
							AND T.ticket = T1.ticket
							AND T.statut = 'reopen'
							AND D.typedemande= TD.typedemandeid
							GROUP BY T.ticket
						) REQ ";
		/*
			#where REQ.groupid = 51
        	#and REQ.typedemandeid =515
			#and REQ.campagne = 1000597
			#and REQ.datecreation between '2010-04-18' and '2010-04-27'
		 */
		
		if(isset($typologie_val) && $typologie_val != '') {
			$query .=" where REQ.typedemandeid = $typologie_val ";
			
			if(isset($groupname_val) && $groupname_val != '') {
				$query .=" and REQ.groupid = $groupname_val ";
			}
				
			if(isset($campagne_val) && $campagne_val != '') {
				$query .= " and REQ.campagne = $campagne_val ";
			}
			
			if(isset($date_start_val) && $date_start_val != '') {
				$d = new DateTime($date_start_val);
				$date_start = $d->format("Y-m-d");
				$query .= " and REQ.datecreation >= ".$adb->quote($date_start." 00:00:00");
			}
					
			if(isset($date_end_val) && $date_end_val != '') {
				$d = new DateTime($date_end_val);
				$date_end = $d->format("Y-m-d");
				$query .= " and REQ.datecreation  <= ".$adb->quote($date_end." 23:59:59");
			}	
		}
		
		$query .= " )REQ2
					GROUP BY REQ2.statuttraitement";
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "moyenne_traitement");
		
		return $noofrows;
	}
	
	function getDemandesOrigineInterne() {
		global $log, $adb;

		$log->debug("Entering select getDemandesOrigineInterne() method.");
		
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "select count(distinct crmid) as origine_interne
					from  siprod_traitement_demandes TD,siprod_demande D ,siprod_type_demandes ,vtiger_crmentity
					where origine ='interne'
					and crmid = Demandeid
					and typedemande=typedemandeid
					and deleted= 0
					and TD.ticket = D.ticket";

		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and groupid = $groupname_val  ";
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .=" and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	

		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_interne");
		
		return $noofrows;
	}
	
	function getDemandesOrigineExterne() {
		global $log, $adb;

		$log->debug("Entering select getDemandesOrigineExterne() method.");
				
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "select count(distinct crmid) as origine_externe
					from  siprod_traitement_demandes TD,siprod_demande D ,siprod_type_demandes ,vtiger_crmentity
					where origine ='externe'
					and crmid = Demandeid
					and typedemande=typedemandeid
					and deleted= 0
					and TD.ticket = D.ticket";

		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and groupid = $groupname_val  ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .=" and typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_externe");
		
		return $noofrows;
	}
	
	function getTypologiesOptions() {
		global $log, $adb;

		$log->debug("Entering select getIncidentsOrigineInterne() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "SELECT typedemandeid, nom FROM siprod_type_demandes";
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_interne");
		
		return $noofrows;
	}
	
	function getGroupesOptions() {
		global $log, $adb;

		$log->debug("Entering select getIncidentsOrigineInterne() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "select count(*) as origine_interne from siprod_traitement_incidents where origine = 'interne'";
		$result = $adb->pquery($query, array());
		$noofrows = $adb->query_result($result, 0, "origine_interne");
		
		return $noofrows;
	}
	
	function getNbDemandeStatut() {
		global $log, $adb;

		$log->debug("Entering select getNbDemandeStatut() method.");
		
		$url_string = "";
	
		$groupname_val = $_REQUEST['groupname_field'];
		$typologie_val = $_REQUEST['typologie_field'];
		$campagne_val = $_REQUEST['campagne_field'];
		$date_start_val = $_REQUEST['date_start'];
		$date_end_val= $_REQUEST['date_end'];
		
		$query = "select S.statut,ifnull(D.nb_demande_open,0) as nb_demande_open
		  from 
			(select   statut,count(*) as nb_demande_open 
			            from siprod_demande , vtiger_crmentity 
			            where crmid = Demandeid
			            and deleted = 0
			            group by statut)D right join siprod_statuts S on S.statut=D.statut
			            group by statut ASC";
		
		$query = "select S.statut,ifnull(D.nb_demande,0) as nb_demande from 
					(select statut,count(*) as nb_demande 
					from siprod_demande ,siprod_type_demandes, vtiger_crmentity 
					where crmid = Demandeid
					and deleted = 0
					and typedemande=typedemandeid ";
		
		if(isset($groupname_val) && $groupname_val != '') {
			$query .=" and siprod_type_demandes.groupid = $groupname_val ";
			 
		}
			
		if(isset($typologie_val) && $typologie_val != '') {
			$query .=" and siprod_type_demandes.typedemandeid = $typologie_val ";
		}
		
		if(isset($campagne_val) && $campagne_val != '') {
			$query .= " and siprod_demande.campagne = $campagne_val ";
		}
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query .= " and createdtime >= ".$adb->quote($date_start." 00:00:00");
		}
				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query .= " and createdtime  <= ".$adb->quote($date_end." 23:59:59");
		}	
		
		$query .= " group by statut ) D
				right join siprod_statuts S on S.statut=D.statut
				group by statut ASC";
		
		$result = $adb->pquery($query, array());
		
		$nbDmeOpen = $adb->query_result($result, 1, "nb_demande");
		$nbDmeReopen = $adb->query_result($result, 3, "nb_demande"); 
		$nbDmeTransfered= $adb->query_result($result, 5, "nb_demande"); ;
		
		$nbDmeOuvert = $nbDmeOpen + $nbDmeReopen + $nbDmeTransfered ; 
		$listStatutTpl[0] = $nbDmeOuvert ;
		if ($nbDmeOuvert > 0){
			$listStatut["A traiter"] = $nbDmeOuvert;
		}
		 
		$nbDmePending = $adb->query_result($result, 2, "nb_demande"); 
		$listStatutTpl[1] = $nbDmePending ;
		if ($nbDmePending > 0){
			$listStatut["En cours de traitement"] = $nbDmePending;
		}
		
		$nbDmeTraited= $adb->query_result($result, 4, "nb_demande"); 
		$listStatutTpl[2] = $nbDmeTraited  ;
		if ($nbDmeTraited > 0){
		    $listStatut["En attente de cl?ture"] = $nbDmeTraited;
		}
		
		$nbDmeClose = $adb->query_result($result, 0, "nb_demande");
		$listStatutTpl[3] = $nbDmeClose ;
		if ($nbDmeClose > 0){
			$listStatut["Cl?tur?s"] = $nbDmeClose;
		}

		$_SESSION['valuesStatutDemande'] = $listStatut ;
		
		return $listStatutTpl;
	}
	
	//////////////// FIN GID PCCI	////////////////
}
?>