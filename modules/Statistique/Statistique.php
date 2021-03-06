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

class Statistique extends CRMEntity {
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
	
	
	
	//******************* DEBUT GID PCCI	****************************//

	function  getDataParType() {
		
		global $log, $adb;

		$log->debug("Entering select getDataParType() method.");
		
		$date_start_val 	= $_REQUEST['date_start'];
		$date_end_val		= $_REQUEST['date_end'];
		
	    $query = "  select date_postage,typeincidents,SUM(nb_incidents_declares) as nb_incidents_declares,
					SUM(nb_incidents_en_souffrance) as nb_incidents_en_souffrance
					from siprod_rapport_quotidien_type where 1=1 ";
		
		$query_distinct = "select distinct typeincidents from siprod_rapport_quotidien_type where 1=1 ";
					
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query     .= " and date_postage >= ".$adb->quote($date_start);
		}
		else{
			$query     .= " and date_postage >= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
		}				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query   .= " and date_postage  <= ".$adb->quote($date_end);
		}
		else{
			$query     .= " and date_postage <= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
		}		
		
		$query .= " group by  date_postage,typeincidents order by typeincidents asc";
		$query_distinct .= " order by typeincidents asc";
		
		$list_result 	      = $adb->query($query);
		$list_result_distinct = $adb->query($query_distinct);
		$data_type		= array();
		$data_incident 	= array();
		$data_souffrant = array();
		$data_type_s	= array();
		$data_type_t	= array();
		
		for($c=0 ; $c < $adb->num_rows($list_result_distinct) ;++$c){
			$type_c        		= $adb->query_result($list_result_distinct, $c, 'typeincidents');
			$nb_incident_i  	= 0;
			$data_souffrant_i 	= 0;
			for($i=0 ; $i < $adb->num_rows($list_result) ;++$i){
				$type_i    = $adb->query_result($list_result, $i, 'typeincidents');
				if($type_i == $type_c){
					$nb_incident_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_declares');	
					$data_souffrant_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_en_souffrance');
				}
			}
			if($nb_incident_i != 0){
				$data_type_t[]		= decode_html($type_c);
				$data_incident[]    = $nb_incident_i;
			}
			if( $data_souffrant_i != 0 ){
				$data_type_s[]		= decode_html($type_c);
				$data_souffrant[]   = $data_souffrant_i;
			}
		}
		$data_type[0] = $data_type_t;
		$data_type[1] = $data_type_s;
		
		$data = array(0=>$data_type,1=>$data_incident,2=>$data_souffrant);
		
		return $data;
	}


	function getDataParCampagne() {
		
		global $log, $adb;

		$log->debug("Entering select getDataParCampagne() method.");
		
		$date_start_val 	= $_REQUEST['date_start'];
		$date_end_val		= $_REQUEST['date_end'];
		
	    $query = "select date_postage,campagne,op_lib,SUM(nb_incidents_declares) as nb_incidents_declares,
	    		  SUM(nb_incidents_en_souffrance) as nb_incidents_en_souffrance
				  from  siprod_rapport_quotidien_campagne where 1=1 ";
		
		$query_distinct = "select distinct campagne,op_lib	from siprod_rapport_quotidien_campagne where 1=1 ";			
		
		if(isset($date_start_val) && $date_start_val != '') {
			$d = new DateTime($date_start_val);
			$date_start = $d->format("Y-m-d");
			$query     .= " and date_postage >= ".$adb->quote($date_start);
		}
		else{
			$query     .= " and date_postage >= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
		}				
		if(isset($date_end_val) && $date_end_val != '') {
			$d = new DateTime($date_end_val);
			$date_end = $d->format("Y-m-d");
			$query   .= " and date_postage  <= ".$adb->quote($date_end);
		}
		else{
			$query     .= " and date_postage <= DATE_FORMAT(ADDDATE(now(), -1), '%Y-%m-%d') ";
		}		
		
		$query .= " group by  date_postage,campagne order by campagne asc";
		$query_distinct .= " order by campagne asc";
		
		$list_result 		  = $adb->query($query);
		$list_result_distinct = $adb->query($query_distinct);
		$data_campagne	 = array();
		$data_incident 	 = array();
		$data_souffrant  = array();
		$data_campagne_s = array();
		$data_campagne_t = array();
		for($c=0 ; $c < $adb->num_rows($list_result_distinct) ;++$c){
			$campagne_c     	= $adb->query_result($list_result_distinct, $c, 'campagne');
			$campagne_lib_c     = $adb->query_result($list_result_distinct, $c, 'op_lib');
			$nb_incident_i  	= 0;
			$data_souffrant_i 	= 0;
			for($i=0 ; $i < $adb->num_rows($list_result) ;++$i){
				$campagne_i    = $adb->query_result($list_result, $i, 'campagne');
				if($campagne_i == $campagne_c){
					$nb_incident_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_declares');	
					$data_souffrant_i  	+= $adb->query_result($list_result, $i, 'nb_incidents_en_souffrance');
				}
			}
			if( $nb_incident_i != 0 ){
				$data_campagne_t[]	= decode_html($campagne_lib_c);
				$data_incident[]    = $nb_incident_i;
			}
			if( $data_souffrant_i != 0 ){
				$data_campagne_s[]	= decode_html($campagne_lib_c);
				$data_souffrant[]   = $data_souffrant_i;
			}
		}
		$data_campagne[0] = $data_campagne_t;
		$data_campagne[1] = $data_campagne_s;
		$data = array(0=>$data_campagne,1=>$data_incident,2=>$data_souffrant);
		
		return $data;
	}

}
?>