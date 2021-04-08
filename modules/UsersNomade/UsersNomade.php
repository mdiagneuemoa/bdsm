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

class UsersNomade extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity

	var $table_name = "users";
	var $table_index= 'user_id';
	var $column_fields = Array();

	/** Indicator if this is a custom module or standard module */
	var $IsCustomModule = true;

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('userscf', 'user_id');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	//var $tab_name = Array('vtiger_crmentity', 'users', 'userscf');
	var $tab_name = Array('users');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'users'   => 'user_id',
		//'siprod_users'   => 'profilid',
	    'userscf' => 'user_id');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array(
	'user_id' => Array('users','user_id'),
	'user_sexe' => Array('users','user_sexe'),
	'user_name' => Array('users','user_name'),
	'user_firstname' => Array('users','user_firstname'),
	'user_login' => Array('users','user_login'),
	'user_pwd' => Array('users','user_pwd'),
	'user_direction' => Array('users','user_direction'),
	'user_matricule' => Array('users','user_matricule'),
	'user_numerologin' => Array('users','user_numerologin'),
	'user_fonction' => Array('users','user_fonction'),
	'user_email' => Array('users','user_email'),
	'user_categmis' => Array('users','user_categmis'),
	'user_profil' => Array('siprod_users','profilid'),

	);
	

	var $list_fields_name = Array(
		/* Format: Field Label => fieldname */
	'user_id' => 'user_id',
	'usersexe' => 'user_sexe',
	'username' => 'user_name',
	'userfirstname' => 'user_firstname',
	'userlogin' => 'user_login',
	'userpwd' => 'user_pwd',
	'userdirection' => 'user_direction',
	'usermatricule' => 'user_matricule',
	'usernumerologin' => 'user_numerologin',
	'userfonction' => 'user_fonction',
	'useremail' => 'user_email',
	'usercategmis' => 'user_categmis',
	'userprofil' => 'user_profil',

	);

	// Make the field link to detail view from list view (Fieldname)
	var $list_link_field = 'user_name';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'user_name'=> Array('users', 'user_name'),
		'user_firstname'=> Array('users', 'user_firstname'),
		/*'Groupe'=> Array('siprod_type_demandes', 'groupid'),*/
	);
	var $search_fields_name = Array(
		/* Format: Field Label => fieldname */
		'user_name'=> 'user_name'
	);

	// For Popup window record selection
	var $popup_fields = Array('user_name');

	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();

	// For Alphabetical search
	var $def_basicsearch_col = 'user_name';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'user_name';

	// Required Information for enabling Import feature
	var $required_fields = Array('user_name'=>1);

	// Callback function list during Importing
	var $special_functions = Array('set_import_assigned_user');

	var $default_order_by = 'nom';
	var $default_sort_order='ASC';
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'user_name');
	
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
	 function randomPassword($length,$count, $characters) {
 
		// $length - the length of the generated password
		// $count - number of passwords to be generated
		// $characters - types of characters to be used in the password
		 
		// define variables used within the function    
		    $symbols = array();
		    $passwords = array();
		    $used_symbols = '';
		    $pass = '';
		 
		// an array of different character types    
		    $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
		    $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $symbols["numbers"] = '1234567890';
		    $symbols["special_symbols"] = '!?~@#-_+<>[]{}';
		 
		    $characters = split(",",$characters); // get characters types to be used for the passsword
		    foreach ($characters as $key=>$value) {
		        $used_symbols .= $symbols[$value]; // build a string with all characters
		    }
		    $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1
		     
		    for ($p = 0; $p < $count; $p++) {
		        $pass = '';
		        for ($i = 0; $i < $length; $i++) {
		            $n = rand(0, $symbols_length); // get a random character from the string with all characters
		            $pass .= $used_symbols[$n]; // add the character to the password string
		        }
		        $passwords[] = $pass;
		    }
		     
		    return $passwords; // return the generated password
	}
	function getNextUserId()
	{
		global $log;
		$log->debug("Entering getNextUserId method ...");
		$log->info("in getNextUserId");
		global $adb ; 
		$num=0;
		$sql = "SELECT MAX(user_id)+1 AS userid FROM users";
		$result = $adb->query($sql);
		$nextuserid = $adb->query_result($result,0,"userid");	
		$log->debug("Exiting getNextUserId method ...");
			
		return  $nextuserid;
	}
	function getNextMatricule()
	{
		global $log;
		$log->debug("Entering getNextMatricule method ...");
		$log->info("in getNextMatricule");
		global $adb ; 
		$num=0;
		$sql = "SELECT MAX(CONVERT(user_matricule,SIGNED INTEGER))+1 AS matricule FROM users";
		$result = $adb->query($sql);
		$nextmatricule = $adb->query_result($result,0,"matricule");	
		$log->debug("Exiting getNextMatricule method ...");
			
		return  $nextmatricule;
	}
	function getProfilNameUser($userid)
	{
		global $log;
		$log->debug("Entering getProfilNameUser method ...");
		$log->info("in getProfilNameUser");
		global $adb ; 
		$num=0;
		$sql = "select profilename from vtiger_profile,siprod_users 
				where userid=? and siprod_users.profilid= vtiger_profile.profileid";
		 $result = $adb->pquery($sql, array($userid));
		$profilename = $adb->query_result($result,0,"profilename");	
		$log->debug("Exiting getProfilNameUser method ...");
			
		return  $profilename;
	}
	function getProfilIDUser($userid)
	{
		global $log;
		$log->debug("Entering getProfilIDUser method ...");
		$log->info("in getProfilIDUser");
		global $adb ; 
		$num=0;
		$sql = "select profileid from vtiger_profile,siprod_users 
				where userid=? and siprod_users.profilid= vtiger_profile.profileid";
		 $result = $adb->pquery($sql, array($userid));
		$profilename = $adb->query_result($result,0,"profilename");	
		$log->debug("Exiting getProfilIDUser method ...");
			
		return  $profilename;
	}
	function getAllProfils()
	{
		global $log;
		$log->debug("Entering getAllProfils() method ...");
		$log->info("in getAllProfils ");

	        global $adb;
	       
	                $sql = "SELECT profileid,profilename FROM vtiger_profile WHERE profileid NOT IN(1,20) ORDER BY 2";
	                $result = $adb->pquery($sql, array());
	         
			//$LISTPROFILSOPT[''] = 'Choisir le profil...';
		 
		   	while ($row = $adb->fetchByAssoc($result))
		{
			$LISTPROFILS[]=$row;
		}
		 
		foreach($LISTPROFILS as $entry_key=>$profil)
		{
			$LISTPROFILSOPT[$profil['profileid']] = $profil['profilename'];
		}  
		$log->debug("Exiting getAllProfils method ...");
	        return $LISTPROFILSOPT;
	}
function getAllDirections()
{
	global $log;
	$log->debug("Entering getAllDirections() method ...");
	$log->info("in getAllDirections ");

        global $adb;
       
                $sql = "SELECT codeservice,libservice,codedepartement,libdepartement FROM nomade_services ORDER BY codeservice";
                $result = $adb->pquery($sql, array());
                      
	   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTDIRECTIONS[]=$row;
	}
	$LISTDIRECTIONSOPT[''] = 'Choisir la direction...';
 
	foreach($LISTDIRECTIONS as $entry_key=>$direction)
	{
		$LISTDIRECTIONSOPT[$direction['libdepartement']][$direction['codeservice']] = $direction['libservice'];
	}  
	$log->debug("Exiting getAllDirections method ...");
        return $LISTDIRECTIONSOPT;
}
function getAllCategories()
{
	global $log;
	$log->debug("Entering getAllCategories() method ...");
	$log->info("in getAllCategories ");

        global $adb;
       
                $sql = "SELECT DISTINCT codecatuemoa,titrecat FROM nomade_categorie WHERE codecatuemoa!='A000000008' ORDER BY 2";
                $result = $adb->pquery($sql, array());
         
		$LISTCATEGORIESOPT[''] = 'Choisir la Cat&eacute;gorie...';

   	while ($row = $adb->fetchByAssoc($result))
	{
		$LISTCATEGORIES[]=$row;
	}
	 
	foreach($LISTCATEGORIES as $entry_key=>$categorie)
	{
		$LISTCATEGORIESOPT[$categorie['codecatuemoa']] = $categorie['titrecat'];
	}  
	$log->debug("Exiting getAllCategories method ...");
        return $LISTCATEGORIESOPT;
}

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
		echo "query= ", $query;
		
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