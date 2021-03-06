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

class Conventions extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity
	
	var $table_name = 'sigc_convention';
	var $table_index= 'conventionid';
	var $column_fields = Array();
	
	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;
	
	/**
	 * Mandatory table for supporting custom fields.
	 */
	//var $customFieldTable = Array('sigc_conventioncf', 'conventionid');
	
	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'sigc_convention', 'sigc_conventioncf');
	
	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'sigc_convention'   => 'conventionid',
		'sigc_conventioncf' => 'conventionid');
	
	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		
		'Ticket'=> Array('sigc_convention','ticket'),
		'Libelle'=> Array('sigc_convention','libelle'),
		'Libellecourt'=> Array('sigc_convention','libellecourt'),
		'Description'=> Array('sigc_convention','description'),
		'typeconvention'=> Array('sigc_convention','typeconvention'),
		'Statut'=> Array('sigc_convention','statut'),
		'Montant'=> Array('sigc_convention','montant'),
		'Datedemarrage'=> Array('sigc_convention','datedemarrage'),
		'Delai'=> Array('sigc_convention','delai'),
		'Datesignature'=> Array('sigc_convention','datesignature'),
		'Datecloture'=> Array('sigc_convention','datecloture'),
		'Datepremierdecaissement'=> Array('sigc_convention','datepremierdecaissement'),
		'File Name'=> Array('sigc_convention','filename'),
		'Projet'=> Array('sigc_convention','projetid'),
		'Organe'=> Array('sigc_convention','organe'),
		'Politique'=> Array('sigc_convention','politique'),
		'Programme'=> Array('sigc_convention','programme'),
		'Bailleurs'=> Array('sigc_convention','bailleurs'),
		'BailleursRate'=> Array('sigc_convention','bailleursrate'),
		'Maitriseouvrage'=> Array('sigc_convention','maitriseouvrage'),
		'Agenceexecution'=> Array('sigc_convention','agenceexecution'),
		'Beneficiaire'=> Array('sigc_convention','beneficiaire'),
		'Domaine'=> Array('sigc_convention','domaine'),
		'Typeactivite'=> Array('sigc_convention','typeactivite'),
		'Localite'=> Array('sigc_convention','localite')
		//'Satut' => Array('sigc_convention','statut'),
		//'Assigned To' => Array('crmentity','smownerid')
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=>'ticket',
		'Libelle'=>'libelle',
		'Libellecourt'=>'libellecourt',
		'Description'=>'description',
		'typeconvention'=>'typeconvention',
		'Statut'=>'statut',
		'Montant'=>'montant',
		'Datedemarrage'=>'datedemarrage',
		'Delai'=>'delai',
		'Datesignature'=>'datesignature',
		'Datecloture'=>'datecloture',
		'Datepremierdecaissement'=>'datepremierdecaissement',
		'File Name'=>'filename',
		'Projet'=>'projetid',
		'Organe'=> 'organe',
		'Politique'=> 'politique',
		'Programme'=> 'programme',
		'Bailleurs'=>'bailleurs',
		'BailleursRate'=> 'bailleursrate',
		'Maitriseouvrage'=>'maitriseouvrage',
		'Agenceexecution'=> 'agenceexecution',
		'Numengagement'=>'numengagement',
		'Beneficiaire'=>'beneficiaire',
		'Domaine'=>'domaine',
		'Typeactivite'=>'typeactivite',
		'Localite'=>'localite',
		//'Assigned To' => 'assigned_user_id'
	);
	
	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'ticket';
	
	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		
		'Ticket'=> Array('sigc_convention', 'ticket'),
		'Libelle'=> Array('sigc_convention', 'libelle')

	);
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket',
		'Libelle'=> 'libelle'

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
	
	function save_module($module)
	{
		global $log,$adb;
		$insertion_mode = $this->mode;
		if(isset($this->parentid) && $this->parentid != '')
			$relid =  $this->parentid;		
		//inserting into vtiger_sehreportsrel
		//echo "relid =$relid" ;break;
		if(isset($relid) && $relid != '')
		{
			$this->sigc_seconventionfilerel($relid,$this->id);
		}
		
		$this->insertIntoConventionFiles($this->id,'Conventions');
		
		/*		
		$fieldname = $this->getFileTypeFieldName();
		//echo $_FILES[$fieldname]['name'],' - ',$_FILES[$fieldname]['error'];break;
		if($_FILES[$fieldname]['name'] != '')
		{
			$errCode=$_FILES[$fieldname]['error'];
				if($errCode == 0){
					foreach($_FILES as $fileindex => $files)
					{
						if($files['name'] != '' && $files['size'] > 0){
							$filename = $_FILES[$fieldname]['name'];
							$filename = from_html(preg_replace('/\s+/', '_', $filename));
							$filetype = $_FILES[$fieldname]['type'];
							$filesize = $_FILES[$fieldname]['size'];
							$filelocationtype = 'I';
						}
					}
			
				}
			$this->insertIntoConventionFiles($this->id,'Conventions');
				$filestatus=1;
				//$query = "Update vtiger_hreports set filename = ? ,filesize = ?, filetype = ? , filelocationtype = ? , filestatus = ?, filedownloadcount = ? where hreportsid = ?";
				//$re=$adb->pquery($query,array($filename,$filesize,$filetype,$filelocationtype,$filestatus,$filedownloadcount,$this->id));
		}
		*/
		
	}
	
	function insertintofileconvrel($relid,$id)
	{
		global $adb;
		$dbQuery = "insert into sigc_seconventionfilerel values ( ?, ? )";
		$dbresult = $adb->pquery($dbQuery,array($relid,$id));
	}
	
	function insertIntoConventionFiles($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoConventionFiles($id,$module) method.");
		
		$file_saved = false;
		//print_r($_FILES);break;
		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}

		$log->debug("Exiting from insertIntorapport($id,$module) method.");
	}
	
	function getFileTypeFieldName(){
		global $adb,$log;
		$query = 'SELECT fieldname from vtiger_field where tabid = ? and uitype = ?';
		$tabid = getTabid('Conventions');
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
		global $current_user;
		
		$query="SELECT DISTINCT 
			sigc_convention.ticket,
			sigc_convention.libelle,
			sigc_convention.statut,
			sigc_convention.montant,
			c.createdtime,
			sigc_convention.datedemarrage ,
			sigc_convention.delai ,
			sigc_convention.bailleurs ,			
			c.crmid 
			FROM sigc_convention 
			INNER JOIN vtiger_crmentity  ON crmid = sigc_convention.conventionid
			";
			
		if ($current_user->profilid == 24)
		{
			/*$join_clause = " INNER JOIN sigc_domaines ON sigc_domaines.domainecode=sigc_convention.domaine
						 INNER JOIN users ON users.User_Direction=sigc_domaines.organecode ";*/
						 
			$query.=$join_clause."	WHERE deleted =0  AND sigc_convention.statut NOT IN('validate','running','complete','close') ";
		
		}
		if ($current_user->profilid == 23)
		{
			/*$join_clause = " INNER JOIN sigc_domaines ON sigc_domaines.domainecode=sigc_convention.domaine
						 INNER JOIN users ON users.User_Direction=sigc_domaines.organecode ";*/
						 
			$query.=$join_clause."	WHERE deleted =0  AND sigc_convention.statut IN('validate','running') ";
		
		}
		return $query;
	}
	
	/**
	 * Apply security restriction (sharing privilege) query part for List view.
	 */
	function getListViewSecurityParameter($module) {
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		
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
		////require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		
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
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_traitements(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query ="select TRAIT.crmid,TRAIT.statut,TRAIT.datemodification,TRAIT.nom,TRAIT.organelib,TRAIT.organesigle,TRAIT.organecode,TRAIT.description
				FROM   
				(SELECT vtiger_crmentity.crmid, sigc_convention.statut, vtiger_crmentity.createdtime AS datemodification, 
				CONCAT( users.user_firstname, ' ', users.user_name ) AS nom,sigc_organes.organelibelle AS organelib,sigc_organes.organesigle AS organesigle,sigc_organes.organecode AS organecode, '' AS description
				FROM sigc_convention
				INNER JOIN vtiger_crmentity ON sigc_convention.conventionid = vtiger_crmentity.crmid
				INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
				INNER JOIN sigc_organes ON users.User_Direction = sigc_organes.organecode
				WHERE sigc_convention.ticket =?  AND vtiger_crmentity.deleted = 0 
				UNION  
				SELECT vtiger_crmentity.crmid, sigc_traitement_conventions.statut, vtiger_crmentity.createdtime AS datemodification, 
				concat( users.user_firstname, ' ', users.user_name ) AS nom,sigc_organes.organelibelle AS organelib,sigc_organes.organesigle AS organesigle,sigc_organes.organecode AS organecode, sigc_traitement_conventions.description
				FROM sigc_traitement_conventions
				INNER JOIN vtiger_crmentity ON sigc_traitement_conventions.traitementconventionid = vtiger_crmentity.crmid
				INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
				INNER JOIN sigc_organes ON users.User_Direction = sigc_organes.organecode
				WHERE sigc_traitement_conventions.ticket =?  AND vtiger_crmentity.deleted = 0
				)TRAIT
				ORDER BY TRAIT.datemodification asc" ;
		

		$log->debug("Exiting get_traitements method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket,$ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["traitementid"] = $row1["crmid"];
			$row1["statut"] = $app_strings[$row1["statut"]];
			$row1["datemodification"] = getDisplayDate($row1["datemodification"]);
			$row1["nom"] = decode_html($row1["nom"]);
			$row1["organe"] = $row1["organelib"].'('.$this->getOrganeHier($row1["organecode"],$row1["organesigle"]).')';
			$row1["description"] = decode_html($row1["description"]);
			$traitement[]=$row1;			
		}
		return $traitement;
	}
	function getOrganeHier($organe)
	{
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getOrganesLibelle(".$organe.") method ...");
		global $app_strings, $mod_strings;
		
		$query ="SELECT CONCAT(o2.organesigle,'/',o3.organesigle) AS organehier,o3.depth,o3.organesigle sigle
				FROM sigc_organes o2,sigc_organes o3 
				WHERE o3.organeparent LIKE CONCAT('%',':',o2.organecode,':',o3.organecode) 
				AND o3.organecode=?" ;
		

		$log->debug("Exiting getOrganesLibelle method ...");
		$result = $adb->pquery($query, array($organe));
		$row1 = $adb->fetchByAssoc($result);
			if ($row1["depth"]>0)
				$organehier = $row1["organehier"];
			else
				$organehier = $row1["organesigle"];
		
		return $organehier;
	}
	
	function get_decaissements($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_decaissements(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT numengagement,dateengagement,montantengage,montantliquide,montantordonnance,
					dateordonnancement,montantpaye,datepaiement
				FROM sigc_decaissements
				WHERE numconvention=? " ;
		
		$log->debug("Exiting get_executions method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["numengagement"] = $row1["numengagement"];
			$row1["dateengagement"] = getDisplayDate($row1["dateengagement"]);
			$row1["montantengage"] = number_format($row1["montantengage"], 0, ',', ' ');
			$row1["montantliquide"] = number_format($row1["montantliquide"], 0, ',', ' ');
			$row1["montantordonnance"] = number_format($row1["montantordonnance"], 0, ',', ' ');
			$row1["dateordonnancement"] = getDisplayDate($row1["dateordonnancement"]);
			$row1["montantpaye"] = number_format($row1["montantpaye"], 0, ',', ' ');
			$row1["datepaiement"] = decode_html($row1["datepaiement"]);
			$decaissement[]=$row1;			
		}
		return $decaissement;
	}
	function get_crexecutions($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_executions(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT vtiger_crmentity.smcreatorid,sigc_execution_conventions.idexecution,sigc_execution_conventions.reffournisseur,sigc_execution_conventions.refpaiement,
					sigc_modepaiement.modepaiementlib modepaiement,sigc_execution_conventions.montant,sigc_execution_conventions.datepaiement,
					sigc_execution_conventions.description,vtiger_crmentity.modifiedtime datesaisie
					FROM sigc_execution_conventions
					INNER JOIN vtiger_crmentity ON sigc_execution_conventions.idexecution = vtiger_crmentity.crmid
					INNER JOIN sigc_modepaiement ON sigc_execution_conventions.modepaiement = sigc_modepaiement.modepaiementcode
					WHERE sigc_execution_conventions.ticket =?  
					AND vtiger_crmentity.deleted = 0
					ORDER BY vtiger_crmentity.modifiedtime desc" ;
		

		$log->debug("Exiting get_executions method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["idexecution"] = $row1["idexecution"];
			$row1["reffournisseur"] = $row1["reffournisseur"];
			$row1["refpaiement"] = $row1["refpaiement"];
			$row1["modepaiement"] = decode_html($row1["modepaiement"]);
			$row1["montant"] = number_format($row1["montant"], 0, ',', ' ');
			$row1["datepaiement"] = getDisplayDate($row1["datepaiement"]);
			$row1["localitenom"] = decode_html($row1["localitenom"]);
			$row1["datesaisie"] = getDisplayDate($row1["datesaisie"]);
			$row1["description"] = decode_html($row1["description"]);
			
			$pjustifs = $this->get_crexecutions_pjustif($row1["idexecution"]);

			$row1["pjustifid"] = $pjustifs["pjustifid"];
			$row1["filename"] = $pjustifs["filename"];
			
			$crexecution[]=$row1;			
		}
		return $crexecution;
	}
	
	function get_crexecutions_pjustif($idconventionfile)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_crexecutions_pjustif(".$idconventionfile.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT secv.conventionfileid pjustifid,cf.name filename FROM sigc_seconventionfilerel secv,sigc_conventionfiles cf 
					WHERE secv.crmid = cf.conventionfileid AND cf.conventionfileid AND cf.conventionfileid=?" ;
		
		$log->debug("Exiting get_crexecutions_pjustif method ...");
		$result = $adb->pquery($query, array($idconventionfile));
		$pjustifs = $adb->fetchByAssoc($result); 
			
		return $pjustifs;
	}
	
	function get_produitsfinanciers($ticket)
	{	
		// TO DO
		global $log, $singlepane_view,$adb;
		$log->debug("Entering get_produitsfinanciers(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$button = '';
		
		
		$query =" SELECT sigc_produitfinancier.idprodfin,sigc_produitfinancier.libelle,sigc_produitfinancier.montant,sigc_produitfinancier.dateprodfin datesaisie,sigc_produitfinancier.dateeffetprodfin dateeffet
					FROM sigc_produitfinancier
					WHERE sigc_produitfinancier.ticket =?  
					ORDER BY datesaisie DESC" ;
		

		$log->debug("Exiting get_produitsfinanciers method ...");
		$category = getParentTab($currentModule);
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["idprodfin"] = $row1["idprodfin"];
			$row1["libelle"] = $row1["libelle"];
			$row1["montant"] = number_format($row1["montant"], 0, ',', ' ');
			$row1["dateeffet"] = getDisplayDate($row1["dateeffet"]);
			$row1["datesaisie"] = getDisplayDate($row1["datesaisie"]);
			
			
			$produitsfinanciers[]=$row1;			
		}
		return $produitsfinanciers;
	}
	
	/**
	 * Verifie l'existence du ticket pour gerer son unicit?
	 */
	function existTicket($ticket)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existTicket(".$ticket.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select count(*) NBR from sigc_convention where ticket = ? " ;
		$result = $adb->pquery($query, array($ticket));
		$nbrows = $adb->query_result($result, 0 , "NBR");
		
		if($nbrows < 1)
			return 1;
		else
			return 0;
	}
	function getBailleursRates($conventionid)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering getBailleursRates(".$conventionid.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "select bailleurs,bailleursrate from sigc_convention where conventionid = ? " ;
		$result = $adb->pquery($query, array($conventionid));
		$row1 = $adb->fetchByAssoc($result);
		$bailleurs = explode('|',$row1["bailleurs"]);
		$bailleursrate = explode('|',$row1["bailleursrate"]);

		return array('bailleurs1'=>$bailleurs[0],'bailleurs1rate'=>$bailleursrate[0],'bailleurs2'=>$bailleurs[1],'bailleurs2rate'=>$bailleursrate[1]);
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