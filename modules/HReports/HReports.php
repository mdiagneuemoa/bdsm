<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/HReports/HReports.php,v 1.1 2010/01/15 18:44:43 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/SugarBean.php');
require_once('data/CRMEntity.php');
require_once('include/upload_file.php');

// hreport is used to store customer information.
class HReports extends CRMEntity {
	
	var $log;
	var $db;
	var $table_name = "vtiger_hreports";
	var $table_index= 'hreportsid';
	var $default_hreport_name_dom = array('Meeting vtiger_hreports', 'Reminder');

	var $tab_name = Array('vtiger_crmentity','vtiger_hreports');
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_hreports'=>'hreportsid','vtiger_sehreportsrel'=>'hreportsid');
	
	var $column_fields = Array();

   // var $sortby_fields = Array('title','modifiedtime','filename','createdtime','lastname','filedownloadcount','smownerid');		  
	var $sortby_fields = Array('title','modifiedtime','filename','createdtime','lastname','filedownloadcount','smownerid','publishedBy','rapportcategory','rapportstatus','potentialid');		  

	// This is used to retrieve related vtiger_fields from form posts.
	var $additional_column_fields = Array('', '', '', '');

	// This is the list of vtiger_fields that are in the lists.
	var $list_fields = Array(
				'Title'=>Array('hreports'=>'title'),
				'File Name'=>Array('hreports'=>'filename'),
				'Assigned To' => Array('crmentity'=>'smownerid'),
				//'Folder Name' => Array('rapportsfolder'=>'foldername'),
				// ajouter pour hodar CRM
				//'published By'=>Array('hreports'=>'publishedBy'),
				//'Rapport Category'=>Array('hreports'=>'rapportcategory'),
				'Rapport Status'=>Array('hreports'=>'rapportstatus'),
				//'Potential'=>Array('hreports'=>'potentialid')
				);
	var $list_fields_name = Array(
					'Title'=>'hreports_title',
					'File Name'=>'filename',
					'Assigned To'=>'assigned_user_id',
					//'Folder Name' => 'folderid',
					// ajouter pour hodar CRM
					//'published By'=>'publishedBy',
					//'Rapport Category'=>'rapportcategory',
					'Rapport Status'=>'rapportstatus',
					//'Potential'=>'potentialid'
				     );	
				     
	var $search_fields = Array(
					'Title' => Array('hreports'=>'hreports_title'),
					'File Name' => Array('hreports'=>'filename'),
					'Assigned To' => Array('crmentity'=>'smownerid'),
					'Folder Name' => Array('rapportsfolder'=>'foldername'),
					// ajouter pour hodar CRM
					'published By'=>Array('hreports'=>'publishedBy'),
					'Rapport Category'=>Array('hreports'=>'rapportcategory'),
					'Rapport Status'=>Array('hreports'=>'rapportstatus'),
					'Potential'=>Array('hreports'=>'potentialid')
		);
	
	var $search_fields_name = Array(
					'Title' => 'hreports_title',
					'File Name' => 'filename',
					'Assigned To' => 'assigned_user_id',
					'Folder Name' => 'folderid',
					// ajouter pour hodar CRM
					'published By'=>'publishedBy',
					'Rapport Category'=>'rapportcategory',
					'Rapport Status'=>'rapportstatus',
					'Potential'=>'potentialid'
	);				     
	var $list_link_field= 'hreports_title';
	var $old_filename = '';
	//var $groupTable = Array('vtiger_hreportgrouprelation','hreportsid');

	//var $mandatory_fields = Array('hreports_title','createdtime' ,'modifiedtime','filename','filesize','filetype','filedownloadcount');
	var $mandatory_fields = Array('hreports_title','createdtime' ,'modifiedtime','filename','filesize','filetype','filedownloadcount','rapporcategory','rapportstatus','potentialid');
	
	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'title';
	var $default_sort_order = 'ASC';
	function HReports() {
		$this->log = LoggerManager::getLogger('hreports');
		$this->log->debug("Entering HReports() method ...");
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('HReports');
		$this->log->debug("Exiting HReports method ...");
	}

	function save_module($module)
	{
		global $log,$adb;
		$insertion_mode = $this->mode;
		if(isset($this->parentid) && $this->parentid != '')
			$relid =  $this->parentid;		
		//inserting into vtiger_sehreportsrel
		if(isset($relid) && $relid != '')
		{
			$this->insertintohreportsrel($relid,$this->id);
		}
		$fieldname = $this->getFileTypeFieldName();
		//if($_REQUEST[$fieldname."_locationtype"] == 'I' ){
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
						$this->insertIntoRapport($this->id,'HReports');
						$filestatus=1;
						$query = "Update vtiger_hreports set filename = ? ,filesize = ?, filetype = ? , filelocationtype = ? , filestatus = ?, filedownloadcount = ? where hreportsid = ?";
						$re=$adb->pquery($query,array($filename,$filesize,$filetype,$filelocationtype,$filestatus,$filedownloadcount,$this->id));
				}
				elseif($this->mode == 'edit') 
				{
					$fileres = $adb->pquery("select vtiger_attachments.name from vtiger_attachments inner join vtiger_seattachmentsrel on vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid and vtiger_seattachmentsrel.crmid=?", array($this->id));
					if ($adb->num_rows($fileres) > 0) 
					{
						$filename = $adb->query_result($fileres, 0, 'name');
						$query = "Update vtiger_hreports set filename = ? where hreportsid = ?";
						$re=$adb->pquery($query,array($filename,$this->id));
					}
				}
			
		

		
	}


	/**
	 *      This function is used to add the vtiger_rapports. This will call the function uploadAndSaveFile which will upload the rapport into the server and save that rapport information in the database.
	 *      @param int $id  - entity id to which the vtiger_files to be uploaded
	 *      @param string $module  - the current module name
	*/
	function insertIntoRapport($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntorapport($id,$module) method.");
		
		$file_saved = false;

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

	/**    Function used to get the sort order for HReports listview
	*      @return string  $sorder - first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['NOTES_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	*/
	function getSortOrder()
	{
		global $log;
		$log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['HREPORTS_SORT_ORDER'] != '')?($_SESSION['HREPORTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**     Function used to get the order by value for HReports listview
	*       @return string  $order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['NOTES_ORDER_BY'] if this session value is empty then default order by will be returned.
	*/
	function getOrderBy()
	{
		global $log;
		$log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['HREPORTS_ORDER_BY'] != '')?($_SESSION['HREPORTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}


	/** Function to export the hreports in CSV Format
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export HReports Query.
	*/
	function create_export_query($where)
	{
		global $log,$current_user;
		$log->debug("Entering create_export_query(". $where.") method ...");

		include("include/utils/ExportUtils.php");
		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("HReports", "detail_view");
		$fields_list = getFieldsListFromQuery($sql);
		
		$query = "SELECT $fields_list, vtiger_groups.groupname as 'Assigned To Group',case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name" .
				" FROM vtiger_hreports
				inner join vtiger_crmentity 
					on vtiger_crmentity.crmid=vtiger_hreports.hreportsid 
				LEFT JOIN vtiger_rapportsfolder on vtiger_hreports.folderid=vtiger_rapportsfolder.folderid
				LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid=vtiger_users.id " .
				" LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid=vtiger_groups.groupid "
				;
	
				$where_auto=" vtiger_crmentity.deleted=0"; 
				
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		//we should add security check when the user has Private Access
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[2] == 3)
		{
			//Added security check to get the permitted records only
			$query = $query." ".getListViewSecurityParameter("HReports");
		}

		if($where != "")
			$query .= "  WHERE ($where) AND ".$where_auto;
		else
			$query .= "  WHERE ".$where_auto;
		$log->debug("Exiting create_export_query method ...");
		        return $query;
	}	
	
	function del_create_def_folder($query)
	{
		global $adb;
		$dbQuery = $query." and vtiger_rapportsfolder.folderid = 'R1'";
		$dbresult = $adb->pquery($dbQuery,array());
		$noofhreports = $adb->num_rows($dbresult);
		if($noofhreports > 0)
		{
            $folderQuery = "select folderid from vtiger_rapportsfolder";
            $folderresult = $adb->pquery($folderQuery,array());
            $noofdeffolders = $adb->num_rows($folderresult);
            if($noofdeffolders == 0)
            {
			   // $insertQuery = "insert into vtiger_rapportsfolder values (0,'Default','Contains all rapports for which a folder is not set',1,0)";
			    $insertQuery = "insert into vtiger_rapportsfolder values ('R1','Rapports','Les rapports de Hodar Conseil',0,0)";
			    $insertresult = $adb->pquery($insertQuery,array());
            }
		}
		
	}
	
	function insertintohreportsrel($relid,$id)
	{
		global $adb;
		$dbQuery = "insert into vtiger_sehreportsrel values ( ?, ? )";
		$dbresult = $adb->pquery($dbQuery,array($relid,$id));
	}
	
	/*function save_related_module($module, $crmid, $with_module, $with_crmid){
		global $log;
		$log->debug("indocument".$module.$crmid.$with_module.$with_crmid);
		if(isset($this->parentid) && $this->parentid != '')
			$relid =  $this->parentid;		
		//inserting into vtiger_sehreportsrel
		if(isset($relid) && $relid != '')
		{
			$this->insertintohreportsrel($relid,$this->id);
		}
	}*/

	
	/*
	 * Function to get the primary query part of a report
	 * @param - $module Primary module name
	 * returns the query string formed on fetching the related data for report for primary module
	 */
	function generateReportsQuery($module){
	 			$moduletable = $this->table_name;
	 			$moduleindex = $this->tab_name_index[$moduletable];
	 				$query = "from $moduletable 
			        inner join vtiger_crmentity on vtiger_crmentity.crmid=$moduletable.$moduleindex
			        inner join vtiger_rapportsfolder on vtiger_rapportsfolder.folderid=$moduletable.folderid
					left join vtiger_groups as vtiger_groups".$module." on vtiger_groups".$module.".groupid = vtiger_crmentity.smownerid
		            left join vtiger_users as vtiger_users".$module." on vtiger_users".$module.".id = vtiger_crmentity.smownerid
					left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid
		            left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid";
		            return $query;
		            
	}
	
	/*
	 * Function to get the secondary query part of a report 
	 * @param - $module primary module name
	 * @param - $secmodule secondary module name
	 * returns the query string formed on fetching the related data for report for secondary module
	 */
	function generateReportsSecQuery($module,$secmodule){
		$tab = getRelationTables($module,$secmodule);
		
		foreach($tab as $key=>$value){
			$tables[]=$key;
			$fields[] = $value;
		}
		$tabname = $tables[0];
		$prifieldname = $fields[0][0];
		$secfieldname = $fields[0][1];
		$tmpname = $tabname."tmp".$secmodule;
		$condvalue = $tables[1].".".$fields[1];
	
		$query = " left join $tabname as $tmpname on $tmpname.$prifieldname = $condvalue  and $tmpname.$secfieldname IN (SELECT hreportsid from vtiger_hreports)";
		$query .=" left join vtiger_hreports as vtiger_hreports on vtiger_hreports.hreportsid=$tmpname.$secfieldname  
				left join vtiger_crmentity as vtiger_crmentity on vtiger_crmentity.crmid=vtiger_hreports.hreportsid and vtiger_crmentity.deleted=0 
				left join vtiger_hreports on vtiger_hreports.hreportsid = vtiger_crmentity.crmid 
		        left join vtiger_rapportsfolder on vtiger_rapportsfolder.folderid=vtiger_hreports.folderid
				left join vtiger_groups as vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid
				left join vtiger_users as vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid"; 

		return $query;
	}

	/*
	 * Function to get the relation tables for related modules 
	 * @param - $secmodule secondary module name
	 * returns the array with table names and fieldnames storing relations between module and this module
	 */
	function setRelationTables($secmodule){
		$rel_tables = array();
		return $rel_tables[$secmodule];
	}
	
	// Function to unlink all the dependent entities of the given Entity by Id
	function unlinkDependencies($module, $id) {
		global $log;		
		/*//Backup HReports Related Records
		$se_q = 'SELECT crmid FROM vtiger_sehreportsrel WHERE hreportsid = ?';
		$se_res = $this->db->pquery($se_q, array($id));
		if ($this->db->num_rows($se_res) > 0) {
			for($k=0;$k < $this->db->num_rows($se_res);$k++)
			{
				$se_id = $this->db->query_result($se_res,$k,"crmid");
				$params = array($id, RB_RECORD_DELETED, 'vtiger_sehreportsrel', 'hreportsid', 'crmid', $se_id);
				$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES (?,?,?,?,?,?)', $params);
			}
		}
		$sql = 'DELETE FROM vtiger_sehreportsrel WHERE hreportsid = ?';
		$this->db->pquery($sql, array($id));*/
		
		parent::unlinkDependencies($module, $id);
	}
	
	// Function to unlink an entity with given Id from another entity
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		if(empty($return_module) || empty($return_id)) return;
		
		$sql = 'DELETE FROM vtiger_sehreportsrel WHERE hreportsid = ? AND crmid = ?';
		$this->db->pquery($sql, array($id, $return_id));
			
		$sql = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
		$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
		$this->db->pquery($sql, $params);
	}


// Function to get fieldname for uitype 27 assuming that documents have only one file type field

	function getFileTypeFieldName(){
		global $adb,$log;
		$query = 'SELECT fieldname from vtiger_field where tabid = ? and uitype = ?';
		$tabid = getTabid('HReports');
		//$res = $adb->pquery($query,array($tabid,27));
		$res = $adb->pquery($query,array($tabid,61));
		$fieldname = $adb->query_result($res,0,'fieldname');
		return $fieldname;
		
	} 

function isValidable($rapportid,$username)
{
		global $adb,$log;
		$dbQuery="select assignedto,rapportstatus from vtiger_hreports where hreportsid = ?";
		$result=$adb->pquery($dbQuery,array($rapportid));
		$assignedto = $adb->query_result($result,0,'assignedto');
		$rapportstatus = $adb->query_result($result,0,'rapportstatus');
		
		if($username==$assignedto && ($rapportstatus=="Provisoire" || $rapportstatus=="En cours de validation"))
			return true;
		else
			return false;
	
}

}	
?>
