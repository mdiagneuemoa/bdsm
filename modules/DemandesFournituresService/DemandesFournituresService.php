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

class DemandesFournituresService extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = 'siprod_dfs';
	var $table_index= 'demandeid';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	//var $customFieldTable = Array('siprod_dfscf', 'demandeid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'siprod_dfs', 'siprod_dfscf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'siprod_dfs'   => 'demandeid',
	    'siprod_dfscf' => 'demandeid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'Ticket'=> Array('siprod_dfs', 'ticket'),
		'Statut'=> Array('siprod_dfs', 'statut'),
		'Date Creation' => Array('crmentity','createdtime'),
		//'TypeDemande' => Array('siprod_dfs','typedemande'),
		'NatureDemande' => Array('siprod_dfs','naturedemande'),
		//'TypeDemande3' => Array('siprod_dfs','typedemande3'),
		//'TypeDemande4' => Array('siprod_dfs','typedemande4'),
		//'TypeDemande5' => Array('siprod_dfs','typedemande5'),
		//'Campagne' => Array('siprod_dfs','campagne'),
		'Priorite' => Array('siprod_dfs','priorite'),
		//'Quantite2' => Array('siprod_dfs','quantite2'),
		//'Quantite3' => Array('siprod_dfs','quantite3'),
		//'Quantite4' => Array('siprod_dfs','quantite4'),
		//'Quantite5' => Array('siprod_dfs','quantite5'),
		'Justifdemande' => Array('siprod_dfs','justifdemande'),
		//'Justifdemande2' => Array('siprod_dfs','justifdemande2'),
		//'Justifdemande3' => Array('siprod_dfs','justifdemande3'),
		//'Justifdemande4' => Array('siprod_dfs','justifdemande4'),
		//'Justifdemande5' => Array('siprod_dfs','justifdemande5'),
		'Desc1' => Array('siprod_dfs','desc1'),
		//'Desc2' => Array('siprod_dfs','desc2'),
		//'Desc3' => Array('siprod_dfs','desc3'),
		//'Desc4' => Array('siprod_dfs','desc4'),
		//'Desc5' => Array('siprod_dfs','desc5'),
		'Service' => Array('siprod_dfs','service'),
		'Nom' => Array('siprod_dfs','nom'),
		/*'Anneebudgetaire' => Array('siprod_dfs','anneebudgetaire'),
		'Anneebudgetaire2' => Array('siprod_dfs','anneebudgetaire2'),
		'Anneebudgetaire3' => Array('siprod_dfs','anneebudgetaire3'),
		'Anneebudgetaire4' => Array('siprod_dfs','anneebudgetaire4'),
		'Anneebudgetaire5' => Array('siprod_dfs','anneebudgetaire5'),*/

		
	);
	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
		'Ticket'=> 'ticket',
		'Statut'=> 'statut',
		'Date Creation' => 'createdtime',
		//'TypeDemande' => 'typedemande',
		'NatureDemande' => 'naturedemande',
		//'TypeDemande3' => 'typedemande3',
		//'TypeDemande4' => 'typedemande4',
		//'TypeDemande5' => 'typedemande5',
		//'Quantite2' => 'quantite2',
		//'Quantite3' => 'quantite3',
		//'Quantite4' => 'quantite4',
		//'Quantite5' => 'quantite5',		
		//'Campagne' => 'campagne',
		'Priorite' => 'priorite',
		'Justifdemande' => 'justifdemande',
		//'Justifdemande2' => 'justifdemande2',
		//'Justifdemande3' => 'justifdemande3',
		//'Justifdemande4' => 'justifdemande4',
		//'Justifdemande5' => 'justifdemande5',
		'Desc1' => 'desc1',
		//'Desc2' => 'desc2',
		//'Desc3' => 'desc3',
		//'Desc4' => 'desc4',
		//'Desc5' => 'desc5',
		'Service' => 'service',
		'Nom' => 'nom',
		'Prenom' => 'prenom',
		/*'Anneebudgetaire' => 'anneebudgetaire',
		'Anneebudgetaire2' => 'anneebudgetaire2',
		'Anneebudgetaire3' => 'anneebudgetaire3',
		'Anneebudgetaire4' => 'anneebudgetaire4',
		'Anneebudgetaire5' => 'anneebudgetaire5',*/
		);

	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'ticket';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'

		'Ticket'=> Array('siprod_dfs', 'ticket')
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
				siprod_dfs.ticket,
				siprod_dfs.typedemande,
				siprod_dfs.statut,
				vtiger_crmentity.createdtime,
				siprod_dfs.campagne ,
				vtiger_crmentity.crmid ,
				vtiger_groups.groupname,
				vtiger_groups.groupid,
				siprod_users.userid,
				siprod_users.userid
				FROM 
				siprod_dfs 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = siprod_dfs.demandeid 
				INNER JOIN siprod_type_demandes ON siprod_type_demandes.typedemandeid=siprod_dfs.typedemande 
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
	
//		$query = "select siprod_traitement_demandes.statut,
//					siprod_traitement_demandes.datemodification,
//					siprod_traitement_demandes.cause,
//					siprod_traitement_demandes.origine,vtiger_groups.groupname as groupe,
//					concat(users.user_firstname,'  ',users.user_name) as nom,		
//					siprod_traitement_demandes.description
//					FROM siprod_traitement_demandes,vtiger_groups,users 
//					where vtiger_groups.groupid = siprod_traitement_demandes.destination 
//					and users.user_id = siprod_traitement_demandes.user		
//				    and siprod_traitement_demandes.ticket= ?" ;
//		
		
		$query =" SELECT vtiger_crmentity.smcreatorid, siprod_traitement_demandes.statut, vtiger_crmentity.createdtime AS datemodification, siprod_traitement_demandes.cause, siprod_traitement_demandes.origine, concat( users.user_firstname, ' ', users.user_name ) AS nom, vtiger_groups.groupname, vtiger_groups.groupname AS groupe, siprod_traitement_demandes.description
					FROM siprod_traitement_demandes
					INNER JOIN vtiger_crmentity ON siprod_traitement_demandes.traitementdemandeid = vtiger_crmentity.crmid
					LEFT JOIN vtiger_groups ON vtiger_groups.groupid = siprod_traitement_demandes.destination
					INNER JOIN users ON users.user_id = vtiger_crmentity.smcreatorid
					WHERE siprod_traitement_demandes.ticket =? 
					AND vtiger_crmentity.deleted =0	
					order by datemodification" ;
		
		$log->debug("Exiting get_traitements method ...");	

		$category = getParentTab($currentModule);
		
		$result = $adb->pquery($query, array($ticket));
		while ( $row1 = $adb->fetchByAssoc($result) )
		{
			$row1["description"] = decode_html($row1["description"]);
			$row1["statut"] = $app_strings[$row1["statut"]];
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
		
		$query = "select count(*) as nb from siprod_dfs where ticket = ? " ;
		$result = $adb->pquery($query, array($ticket));
		$nbrows = $adb->query_result($result, 0 , "nb");
		
		if($nbrows < 1)
			return 1;
		else
			return 0;
	}
	
	function existdemande2($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande2(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT typedemande2,quantite2 FROM siprod_dfs WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['typedemande2'])!='' && trim($row1['quantite2'])!=''))
			return 1;
		else
			return 0;
	}
	
	function existdemande3($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande3(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT typedemande3,quantite3 FROM siprod_dfs WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['typedemande3'])!='' && trim($row1['quantite3'])!=''))
			return 1;
		else
			return 0;
	}
	
	function existdemande4($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande4(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT typedemande4,quantite4 FROM siprod_dfs WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['typedemande4'])!='' && trim($row1['quantite4'])!=''))
			return 1;
		else
			return 0;
	}
	
	function existdemande5($record)
	{	
		global $log, $singlepane_view,$adb;
		$log->debug("Entering existdemande5(".$record.") method ...");
		global $app_strings, $mod_strings;
		
		$query = "SELECT typedemande5,quantite5 FROM siprod_dfs WHERE demandeid=? " ;
		$result = $adb->pquery($query, array($record));
		$row1 = $adb->fetchByAssoc($result);
		if((trim($row1['typedemande5'])!='' && trim($row1['quantite5'])!=''))
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
		
		$dbQuery = "UPDATE siprod_dfs SET statut='traited',datelivraison=NOW() WHERE demandeid=? ";
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