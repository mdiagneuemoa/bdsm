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
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/data/CRMEntity.php,v 1.2 2010/04/21 11:33:50 isene Exp $
 * Description:  Defines the base class for all data entities used throughout the 
 * application.  The base class including its methods and variables is designed to 
 * be overloaded with module-specific methods and variables particular to the 
 * module's base entity class. 
 ********************************************************************************/

include_once('config.php');
require_once('include/logging.php');
require_once('data/Tracker.php');
require_once('include/utils/utils.php');
require_once('include/utils/UserInfoUtil.php');

class CRMEntity
{
  	var $ownedby;
   
	static function getInstance($module) {
		$modName = $module;
		if ($module == 'Calendar') {
			$modName = 'Activity';
		}
		require_once("modules/$module/$modName.php");
		$focus = new $modName();
		return $focus;		
	}

	/**
   	* This method implements a generic insert and update logic for any SugarBean
   	* This method only works for subclasses that implement the same variable names.
   	* This method uses the presence of an id vtiger_field that is not null to signify and update.
   	* The id vtiger_field should not be set otherwise.
   	* todo - Add support for vtiger_field type validation and encoding of parameters.
   	* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
   	* All Rights Reserved.
   	* Contributor(s): ______________________________________..
   	*/	
	function saveentity($module,$fileid='')
	{
		global $current_user, $adb;//$adb added by raju for mass mailing
		$insertion_mode = $this->mode;
	
		$this->db->println("TRANS saveentity starts $module");
		$this->db->startTransaction();
		
	
		foreach($this->tab_name as $table_name)
		{
				
			if($table_name == "vtiger_crmentity")
			{
				$this->insertIntoCrmEntity($module,$fileid);
			}
			else
			{
				$this->insertIntoEntityTable($table_name, $module,$fileid);			
			}
		}
		
		//Calling the Module specific save code
		$this->save_module($module);
	
		$assigntype=$_REQUEST['assigntype'];
		if($module != "Calendar")
	          $this->whomToSendMail($module,$this ->mode,$assigntype);
		
		$this->db->completeTransaction();
		$this->db->println("TRANS saveentity ends");
	
		// vtlib customization: Hook provide to enable generic module relation.
		if($_REQUEST['return_action'] == 'CallRelatedList') {
			$for_module = $_REQUEST['return_module'];
			$for_crmid  = $_REQUEST['return_id'];
	
			require_once("modules/$for_module/$for_module.php");
			$on_focus = new $for_module();
			// Do conditional check && call only for Custom Module at present
			// TOOD: $on_focus->IsCustomModule is not required if save_related_module function
			// is used for core modules as well.
			if($on_focus->IsCustomModule && method_exists($on_focus, 'save_related_module')) {
				$with_module = $module;
				$with_crmid = $this->id;
				$on_focus->save_related_module(
					$for_module, $for_crmid, $with_module, $with_crmid);
			}
		}
	// END
	}
	
	function insertIntoAttachment1($id,$module,$filedata,$filename,$filesize,$filetype,$user_id)
	{
		$date_var = date('Y-m-d H:i:s');
		global $current_user;
		global $adb;
		//global $root_directory;
		global $log;

		$ownerid = $user_id;
		
		if($filesize != 0)
		{
			$data = base64_encode(fread(fopen($filedata, "r"), $filesize));
		}
		
		$current_id = $adb->getUniqueID("vtiger_crmentity");

		if($module=='Emails') 
		{ 
			$log->info("module is ".$module);
			$idname='emailid';      $tablename='emails';    $descname='description';
		}
		else     
		{ 
			$idname='notesid';      $tablename='notes';     $descname='notecontent';
		}

		$sql="update $tablename set filename=? where $idname=?";
		$params = array($filename, $id);
		$adb->pquery($sql, $params);

		$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
		$params1 = array($current_id, $current_user->id, $ownerid, $module." Attachment", '', $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
		$adb->pquery($sql1, $params1);

		$sql2="insert into vtiger_attachments(attachmentsid, name, description, type) values(?, ?, ?, ?)";
		$params2 = array($current_id, $filename, '', $filetype);
		$result=$adb->pquery($sql2, $params2);

		//TODO -- instead of put contents in db now we should store the file in harddisk

		$sql3='insert into vtiger_seattachmentsrel values(?, ?)';
		$params3 = array($id, $current_id);
		$adb->pquery($sql3, $params3);
	}
	


	/**
	 *      This function is used to upload the attachment in the server and save that attachment information in db.
	 *      @param int $id  - entity id to which the file to be uploaded
	 *      @param string $module  - the current module name
	 *      @param array $file_details  - array which contains the file information(name, type, size, tmp_name and error)
	 *      return void
	*/
	function uploadAndSaveFile($id,$module,$file_details)
	{
		global $log;
		$log->debug("Entering into uploadAndSaveFile($id,$module,$file_details) method.");

		global $adb, $current_user;
		global $upload_badext;

		$date_var = date('Y-m-d H:i:s');

		//to get the owner id
		$ownerid = $this->column_fields['assigned_user_id'];
		if(!isset($ownerid) || $ownerid=='')
			$ownerid = $current_user->id;

		if(isset($file_details['original_name']) && $file_details['original_name'] != null) {
			$file_name = $file_details['original_name'];
		} else {
			$file_name = $file_details['name'];
		}

		// Arbitrary File Upload Vulnerability fix - Philip
		$binFile = preg_replace('/\s+/', '_', $file_name);//replace space with _ in filename
		$ext_pos = strrpos($binFile, ".");

		$ext = substr($binFile, $ext_pos + 1);

		if (in_array(strtolower($ext), $upload_badext))
		{
			$binFile .= ".txt";
		}
		// Vulnerability fix ends

		//$current_id = $adb->getUniqueID("vtiger_crmentity");
		//$current_id = getNextCmrId();
		$current_id =getNextAttachId();
		$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters 
		$filetype= $file_details['type'];
		$filesize = $file_details['size'];
		$filetmp_name = $file_details['tmp_name'];

		//get the file path inwhich folder we want to upload the file
		$upload_file_path = decideFilePath();

		//upload the file in server
		$upload_status = move_uploaded_file($filetmp_name,$upload_file_path.$current_id."_".$binFile);
		
		//echo "upload_status=$upload_status";break;
		
		$save_file = 'true';		

		if($save_file == 'true' && $upload_status == 'true')
		{
			
			//$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
			//$params1 = array($current_id, $current_user->id, $ownerid, $module, $this->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));		
			//$adb->pquery($sql1, $params1);

			$sql2="insert into nomade_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
			$params2 = array($current_id, $filename, $this->column_fields['description'], $filetype, $upload_file_path);
			$result=$adb->pquery($sql2, $params2);

			/*if($_REQUEST['mode'] == 'edit')
			{
				if($id != '' && $_REQUEST['fileid'] != '')
				{
					$delquery = 'delete from nomade_sedemandefilerel where crmid = ? and demandefileid = ?';
					$delparams = array($id, $_REQUEST['fileid']);
					$adb->pquery($delquery, $delparams);
				}
			}*/
			
			$sql3='insert into nomade_sedemandefilerel values(?,?)';
			$adb->pquery($sql3, array($id, $current_id));
						
			return true;
		}
		else
		{
			$log->debug("Skip the save attachment process.");
			return false;
		}
	
	}

	function uploadAndSaveFile2($id,$module,$file_details)
	{
		global $log;
		$log->debug("Entering into uploadAndSaveFile($id,$module,$file_details) method.");

		global $adb, $current_user;
		global $upload_badext;

		$date_var = date('Y-m-d H:i:s');

		//to get the owner id
		$ownerid = $this->column_fields['assigned_user_id'];
		if(!isset($ownerid) || $ownerid=='')
			$ownerid = $current_user->id;

		if(isset($file_details['original_name']) && $file_details['original_name'] != null) {
			$file_name = $file_details['original_name'];
		} else {
			$file_name = $file_details['name'];
		}

		// Arbitrary File Upload Vulnerability fix - Philip
		$binFile = preg_replace('/\s+/', '_', $file_name);//replace space with _ in filename
		$ext_pos = strrpos($binFile, ".");

		$ext = substr($binFile, $ext_pos + 1);

		if (in_array(strtolower($ext), $upload_badext))
		{
			$binFile .= ".txt";
		}
		// Vulnerability fix ends

		//$current_id = $adb->getUniqueID("vtiger_crmentity");
		$current_id = getNextCmrId();
		$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters 
		$filetype= $file_details['type'];
		$filesize = $file_details['size'];
		$filetmp_name = $file_details['tmp_name'];

		//get the file path inwhich folder we want to upload the file
		$upload_file_path = decideFilePath();

		//upload the file in server
		$upload_status = move_uploaded_file($filetmp_name,$upload_file_path.$current_id."_".$binFile);
		
		//echo "upload_status=$upload_status";break;
		
		$save_file = 'true';		

		if($save_file == 'true' && $upload_status == 'true')
		{
			
			$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
			$params1 = array($current_id, $current_user->id, $ownerid, $module." Attachment", $this->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));		
			$adb->pquery($sql1, $params1);

			$sql2="insert into nomade_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
			$params2 = array($current_id, $filename, $this->column_fields['description'], $filetype, $upload_file_path);
			$result=$adb->pquery($sql2, $params2);

			if($_REQUEST['mode'] == 'edit')
			{
				if($id != '' && $_REQUEST['fileid'] != '')
				{
					$delquery = 'delete from nomade_sedemandefilerel where crmid = ? and demandefileid = ?';
					$delparams = array($id, $_REQUEST['fileid']);
					$adb->pquery($delquery, $delparams);
				}
			}
			
			
			$att_sql="select nomade_sedemandefilerel.demandefileid  from nomade_sedemandefilerel inner join vtiger_crmentity on vtiger_crmentity.crmid=nomade_sedemandefilerel.demandefileid where  nomade_sedemandefilerel.crmid=?";
			$res=$adb->pquery($att_sql, array($id));
			$attachmentsid= $adb->query_result($res,0,'demandefileid');
			if($attachmentsid !='' )
			{
				$delquery='delete from nomade_sedemandefilerel where crmid=? and demandefileid=?';
				$adb->pquery($delquery, array($id, $attachmentsid));
				$crm_delquery="delete from vtiger_crmentity where crmid=?";
				$adb->pquery($crm_delquery, array($attachmentsid));
				$sql5='insert into nomade_sedemandefilerel values(?,?)';
				$adb->pquery($sql5, array($id, $current_id));
			}
			else
			{
				$sql3='insert into nomade_sedemandefilerel values(?,?)';
				$adb->pquery($sql3, array($id, $current_id));
			}
			
			return true;
		}
		else
		{
			$log->debug("Skip the save attachment process.");
			return false;
		}
	}
	
	/** Function to insert values in the vtiger_crmentity for the specified module
  	  * @param $module -- module:: Type varchar
 	 */	

  function insertIntoCrmEntity($module,$fileid='')
  {
	global $adb;
	global $current_user;
	global $log;

	if($fileid != '')
	{
		$this->id = $fileid;
		$this->mode = 'edit';
	}
	
	$date_var = date('Y-m-d H:i:s');
	
	$ownerid = $this->column_fields['assigned_user_id'];
     
	$sql="select ownedby from vtiger_tab where name=?";
	$res=$adb->pquery($sql, array($module));
	$this->ownedby = $adb->query_result($res,0,'ownedby');
	
	if($this->ownedby == 1)
	{
		$log->info("module is =".$module);
		$ownerid = $current_user->id;
	}
	// Asha - Change ownerid from '' to null since its an integer field. 
	// It is empty for modules like Invoice/Quotes/SO/PO which do not have Assigned to field
	if($ownerid == '') $ownerid = 0;
	
	if($module == 'Events')
	{
		$module = 'Calendar';
	}
	if($this->mode == 'edit')
	{
		$description_val = from_html($this->column_fields['description'],($insertion_mode == 'edit')?true:false);

		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		$tabid = getTabid($module);
		
		if ($module!='OrdresMission')
		{
			$sql = "update vtiger_crmentity set smownerid=?,modifiedby=?,description=?, modifiedtime=? where crmid=?";
			$params = array($ownerid, $current_user->id, $description_val, $adb->formatDate($date_var, true), $this->id);	
		}
	

		$adb->pquery($sql, $params);
		$sql1 ="delete from vtiger_ownernotify where crmid=?";
		$params1 = array($this->id);
		$adb->pquery($sql1, $params1);
		if($ownerid != $current_user->id)
		{
			$sql1 = "insert into vtiger_ownernotify values(?,?,?)";
			$params1 = array($this->id, $ownerid, null);
			$adb->pquery($sql1, $params1);
		}		
	}
	else
	{
		//if this is the create mode and the group allocation is chosen, then do the following
		/********************** NOMADE 29-01-2018 ****************************/
		if ($module=='OrdresMission')
		{
			$current_id =  $this->id;
			$sql = "update vtiger_crmentity set modifiedtime=? where crmid=?";
			$params = array($adb->formatDate($date_var, true), $this->id);
		}	
		else
		{
				$current_id = $adb->getUniqueID("vtiger_crmentity");
				
			$_REQUEST['currentid']=$current_id;
			
			if($current_user->id == '')
				$current_user->id = 0;

			$description_val = from_html($this->column_fields['description'],($insertion_mode == 'edit')?true:false);
			$sql = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?,?,?,?,?,?,?)";
			$params = array($current_id, $current_user->id, $ownerid, $module, $description_val, $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
			$adb->pquery($sql, $params);
			$this->id = $current_id;
		}
	}

   }


	/** Function to insert values in the specifed table for the specified module
  	  * @param $table_name -- table name:: Type varchar
  	  * @param $module -- module:: Type varchar
 	 */
  function insertIntoEntityTable($table_name, $module, $fileid='')
  {
	  global $log;
  	  global $current_user,$app_strings;
	   $log->info("function insertIntoEntityTable ".$module.' vtiger_table name ' .$table_name);
	  global $adb;
	  $insertion_mode = $this->mode;

	  //Checkin whether an entry is already is present in the vtiger_table to update
	  if($insertion_mode == 'edit')
	  {
		  $check_query = "select * from $table_name where ". $this->tab_name_index[$table_name] ."=?";
		  $check_result=$adb->pquery($check_query, array($this->id));

		  $num_rows = $adb->num_rows($check_result);

		  if($num_rows <= 0)
		  {
			  $insertion_mode = '';
		  }	 
	  }

	$tabid= getTabid($module);
  	if($module == 'Calendar' && $this->column_fields["activitytype"] != null && $this->column_fields["activitytype"] != 'Task') {
    	$tabid = getTabid('Events');
  	}
	  if($insertion_mode == 'edit')
	  {
		  $update = array();
		  $update_params = array();
		  require('user_privileges/user_privileges_'.$current_user->id.'.php');
//		  if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] ==0)
//		  {
				$sql = "select * from vtiger_field where tabid in (". generateQuestionMarks($tabid) .") and tablename=? and displaytype in (1,3) and presence in (0,2) group by columnname"; 
				$params = array($tabid, $table_name);	
//		  }


	  }
	  else
	  {
		  $table_index_column = $this->tab_name_index[$table_name];
		  if($table_index_column == 'id' && $table_name == 'vtiger_users')
		  {
		 	$currentuser_id = $adb->getUniqueID("vtiger_users");
			$this->id = $currentuser_id;
		  }
		  $column = array($table_index_column);
		  $value = array($this->id);
		  $sql = "select * from vtiger_field where tabid=? and tablename=? and displaytype in (1,3,4) and vtiger_field.presence in (0,2)";  
		  $params = array($tabid, $table_name);
	  }

	  $result = $adb->pquery($sql, $params);
	  $noofrows = $adb->num_rows($result);
	  for($i=0; $i<$noofrows; $i++) {
		$fieldname=$adb->query_result($result,$i,"fieldname");
		$columname=$adb->query_result($result,$i,"columnname");
		$uitype=$adb->query_result($result,$i,"uitype");
		$typeofdata=$adb->query_result($result,$i,"typeofdata");
		$typeofdata_array = explode("~",$typeofdata);
		$datatype = $typeofdata_array[0];
		  if(isset($this->column_fields[$fieldname]))
		  {
			  if($uitype == 56)
			  {
				  if($this->column_fields[$fieldname] == 'on' || $this->column_fields[$fieldname] == 1)
				  {
					  $fldvalue = '1';
				  }
				  else
				  {
					  $fldvalue = '0';
				  }

			  }
			 // elseif($uitype == 300)
			  //{
				//$fldvalue=intval($this->column_fields[$fieldname]);
			  //}
			  elseif($uitype == 15 || $uitype == 16)
			  {

				  if($this->column_fields[$fieldname] == $app_strings['LBL_NOT_ACCESSIBLE'])
				  {
					 
					//If the value in the request is Not Accessible for a picklist, the existing value will be replaced instead of Not Accessible value.
					 $sql="select $columname from  $table_name where ".$this->tab_name_index[$table_name]."=?";
					 $res = $adb->pquery($sql,array($this->id));
					 $pick_val = $adb->query_result($res,0,$columname);
					 $fldvalue = $pick_val;
				  }
				  else
				  {
					  $fldvalue = $this->column_fields[$fieldname];
				   }
			  }
			  elseif($uitype == 33)
			  {
  				if(is_array($this->column_fields[$fieldname]))
  				{
  				  $field_list = implode(' |##| ',$this->column_fields[$fieldname]);
  				}else
  				{
  				  $field_list = $this->column_fields[$fieldname];
          		}
  				$fldvalue = $field_list;
			  }
			  elseif($uitype == 5 || $uitype == 6 || $uitype ==23)
			  {
				  if($_REQUEST['action'] == 'Import')
				  {
					  $fldvalue = $this->column_fields[$fieldname];
				  }
				  else
				  {
					  //Added to avoid function call getDBInsertDateValue in ajax save
					  if (isset($current_user->date_format) && $_REQUEST['ajxaction'] != 'DETAILVIEW') {
					    	$fldvalue = getDBInsertDateValue($this->column_fields[$fieldname]);
					  } else {
							$fldvalue = $this->column_fields[$fieldname];
					  }
				  }
			  }
			  elseif($uitype == 7)
			  {
				  //strip out the spaces and commas in numbers if given ie., in amounts there may be ,
				  $fldvalue = str_replace(",","",$this->column_fields[$fieldname]);//trim($this->column_fields[$fieldname],",");

			  }
			  elseif($uitype == 4 && $insertion_mode != 'edit') {
				$this->column_fields[$fieldname] = $this->setModuleSeqNumber("increment",$module);
				$fldvalue = $this->column_fields[$fieldname];
			  }
			  else
			  {
				  $fldvalue = $this->column_fields[$fieldname]; 
			  }
			  if($uitype != 33)
				  $fldvalue = from_html($fldvalue,($insertion_mode == 'edit')?true:false);
		  }
		  else
		  {
			  $fldvalue = '';
		  }
		  if($fldvalue == '') {
		  	$fldvalue = $this->get_column_value($columname, $fldvalue, $fieldname, $uitype, $datatype);
		  }
		  
		if($insertion_mode == 'edit') {
			if($table_name != 'vtiger_ticketcomments' && $uitype != 4) {
				array_push($update, $columname."=?");
				array_push($update_params, $fldvalue);
			}
		} else {
			array_push($column, $columname);
			array_push($value, $fldvalue);
		}

	  }

	  if($insertion_mode == 'edit')
	  {
		if($_REQUEST['module'] == 'Incidents' && $table_name != 'siprod_incidentcf') {	
			if($_REQUEST["tous"] == 'on' || $_REQUEST["tous"] == 1) {
				array_push($update, "all_ccx_affected=?");
				array_push($update_params, '1');
			  }
			  else {
					array_push($update, "all_ccx_affected=?");
					array_push($update_params, '0');
			  }
  		}
  		
		  if($_REQUEST['module'] == 'Potentials')
		  {
			  $dbquery = 'select sales_stage from vtiger_potential where potentialid = ?';
			  $sales_stage = $adb->query_result($adb->pquery($dbquery, array($this->id)),0,'sales_stage');
			  if($sales_stage != $_REQUEST['sales_stage'] && $_REQUEST['sales_stage'] != '')
			  {
				  $date_var = date('YmdHis');
				  $closingdate = ($_REQUEST['ajxaction'] == 'DETAILVIEW')? $this->column_fields['closingdate'] : getDBInsertDateValue($this->column_fields['closingdate']);
				  $sql = "insert into vtiger_potstagehistory values(?,?,?,?,?,?,?,?)";
				  $params = array('', $this->id, $this->column_fields['amount'], decode_html($sales_stage), $this->column_fields['probability'], 0, $adb->formatDate($closingdate, true), $adb->formatDate($date_var, true));
				  $adb->pquery($sql, $params);
			  }
		  }
		  elseif($_REQUEST['module'] == 'PurchaseOrder' || $_REQUEST['module'] == 'SalesOrder' || $_REQUEST['module'] == 'Quotes' || $_REQUEST['module'] == 'Invoice')
		  {
			  //added to update the history for PO, SO, Quotes and Invoice
			  $history_field_array = Array(
				  			"PurchaseOrder"=>"postatus",
							"SalesOrder"=>"sostatus",
							"Quotes"=>"quotestage",
							"Invoice"=>"invoicestatus"
						      );

			  $inventory_module = $_REQUEST['module'];

			  if($_REQUEST['ajxaction'] == 'DETAILVIEW')//if we use ajax edit
			  {
				  if($inventory_module == "PurchaseOrder")
					  $relatedname = getVendorName($this->column_fields['vendor_id']);
				  else
				  	$relatedname = getAccountName($this->column_fields['account_id']);

				  $total = $this->column_fields['hdnGrandTotal'];
			  }
			  else//using edit button and save
			  {
			  	if($inventory_module == "PurchaseOrder")
			  		$relatedname = $_REQUEST["vendor_name"];
			  	else
			  		$relatedname = $_REQUEST["account_name"];

				$total = $_REQUEST['total'];
			  }

				if($this->column_fields["$history_field_array[$inventory_module]"] == $app_strings['LBL_NOT_ACCESSIBLE'])
				  {
					 
					  //If the value in the request is Not Accessible for a picklist, the existing value will be replaced instead of Not Accessible value.
					  $his_col = $history_field_array[$inventory_module];
					  $his_sql="select $his_col from  $this->table_name where ".$this->table_index."=?";
					 $his_res = $adb->pquery($his_sql,array($this->id));
					  $status_value = $adb->query_result($his_res,0,$his_col);
					 $stat_value = $status_value;
				  }
				  else
				  {
					  $stat_value  = $this->column_fields["$history_field_array[$inventory_module]"];
				  }
			  $oldvalue = getSingleFieldValue($this->table_name,$history_field_array[$inventory_module],$this->table_index,$this->id);
			  if($this->column_fields["$history_field_array[$inventory_module]"]!= '' &&  $oldvalue != $stat_value )
			  {
				  addInventoryHistory($inventory_module, $this->id,$relatedname,$total,$stat_value);
			  }
		  }
		  //Check done by Don. If update is empty the the query fails
		  if(count($update) > 0) {
		  	$sql1 = "update $table_name set ". implode(",",$update) ." where ". $this->tab_name_index[$table_name] ."=?";
			array_push($update_params, $this->id);
			$adb->pquery($sql1, $update_params)or die("Error creating document: ".mysql_error()."  sql=".$sql1);
			}
		  
	  }
	  else
	  {
	  	if($_REQUEST['module'] == 'Incidents' && $table_name != 'siprod_incidentcf') {	
			if($_REQUEST["tous"] == 'on' || $_REQUEST["tous"] == 1) {
				array_push($column, "all_ccx_affected");
				array_push($value, '1');
			}
			else {
				array_push($column, "all_ccx_affected");
				array_push($value, '0');
			}
  		}
	  	
  		$sql1 = "insert into $table_name(". implode(",",$column) .") values(". generateQuestionMarks($value) .")";
		  $adb->pquery($sql1, $value)or die("Error creating document: ".mysql_error()."  sql=".$sql1);
	  }

  }

function whomToSendMail($module,$insertion_mode,$assigntype)
{
 	global $adb;
   	if($insertion_mode!="edit")
   	{
		if($assigntype=='U')
		{
			sendNotificationToOwner($module,$this);
		}
       	elseif($assigntype=='T')
       	{
			$groupid=$_REQUEST['assigned_group_id'];
			sendNotificationToGroups($groupid,$this->id,$module);
       	}
   	}
}


	/** Function to delete a record in the specifed table 
  	  * @param $table_name -- table name:: Type varchar
	  * The function will delete a record .The id is obtained from the class variable $this->id and the columnname got from $this->tab_name_index[$table_name]
 	 */
function deleteRelation($table_name)
{
         global $adb;
         $check_query = "select * from $table_name where ". $this->tab_name_index[$table_name] ."=?";
         $check_result=$adb->pquery($check_query, array($this->id));
         $num_rows = $adb->num_rows($check_result);

         if($num_rows == 1)
         {
                $del_query = "DELETE from $table_name where ". $this->tab_name_index[$table_name] ."=?";
                $adb->pquery($del_query, array($this->id));
         }

}
	/** Function to attachment filename of the given entity 
  	  * @param $notesid -- crmid:: Type Integer
	  * The function will get the attachmentsid for the given entityid from vtiger_seattachmentsrel table and get the attachmentsname from nomade_attachments table 
	  * returns the 'filename'
 	 */
function getOldFileName($notesid)
{
	   global $log;
$log->info("in getOldFileName  ".$notesid);
	global $adb;
	$query1 = "select * from vtiger_seattachmentsrel where crmid=?";
	$result = $adb->pquery($query1, array($notesid));
	$noofrows = $adb->num_rows($result);
	if($noofrows != 0)
		$attachmentid = $adb->query_result($result,0,'attachmentsid');
	if($attachmentid != '')
	{
		$query2 = "select * from nomade_attachments where attachmentsid=?";
		$filename = $adb->query_result($adb->pquery($query2, array($attachmentid)),0,'name');
	}
	return $filename;
}
	
	
	





// Code included by Jaguar - Ends 

	/** Function to retrive the information of the given recordid ,module 
  	  * @param $record -- Id:: Type Integer
  	  * @param $module -- module:: Type varchar
	  * This function retrives the information from the database and sets the value in the class columnfields array
 	 */
  function retrieve_entity_info($record, $module)
  {
    global $adb,$log,$app_strings;
    $result = Array();
    foreach($this->tab_name_index as $table_name=>$index)
    {
	    $result[$table_name] = $adb->pquery("select * from $table_name where $index=?", array($record));
		if($adb->query_result($result["vtiger_crmentity"],0,"deleted") == 1)
	    die("<br><br><center>".$app_strings['LBL_RECORD_DELETE']." <a href='javascript:window.history.back()'>".$app_strings['LBL_GO_BACK'].".</a></center>");
    }
	
    /* Prasad: Fix for ticket #4595 */
	if (isset($this->table_name)) {
    	$mod_index_col = $this->tab_name_index[$this->table_name];
    	if($adb->query_result($result[$this->table_name],0,$mod_index_col) == '')
    		die("<br><br><center>".$app_strings['LBL_RECORD_NOT_FOUND'].
				". <a href='javascript:window.history.back()'>".$app_strings['LBL_GO_BACK'].".</a></center>");
	}
    $tabid = getTabid($module);
    $sql1 =  "select * from vtiger_field where tabid=? and vtiger_field.presence in (0,2)"; 
    $result1 = $adb->pquery($sql1, array($tabid));
    $noofrows = $adb->num_rows($result1);
	
    for($i=0; $i<$noofrows; $i++)
    {
      $fieldcolname = $adb->query_result($result1,$i,"columnname");
      $tablename = $adb->query_result($result1,$i,"tablename");
      $fieldname = $adb->query_result($result1,$i,"fieldname");
	    //when we don't have entry in the $tablename then we have to avoid retrieve, otherwise adodb error will occur(ex. when we don't have attachment for troubletickets, $result[nomade_attachments] will not be set so here we should not retrieve)
      if(isset($result[$tablename]))
      {
	      $fld_value = $adb->query_result($result[$tablename],0,$fieldcolname);
      }
      else
      {
	      $adb->println("There is no entry for this entity $record ($module) in the table $tablename");
	      $fld_value = "";
      }

      $this->column_fields[$fieldname] = $fld_value;
      
				
    }
	if($module == 'Users')
	{
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldcolname = $adb->query_result($result1,$i,"columnname");
			$tablename = $adb->query_result($result1,$i,"tablename");
			$fieldname = $adb->query_result($result1,$i,"fieldname");
			$fld_value = $adb->query_result($result[$tablename],0,$fieldcolname);
			$this->$fieldname = $fld_value;

		}
	}
	
	if($module == 'Incidents')
	{
	    $all_ccx_affected = $adb->query_result($result["siprod_incident"],0,"all_ccx_affected");
    	$this->column_fields["all_ccx_affected"] = $all_ccx_affected;
	}
	
    $this->column_fields["record_id"] = $record;
    $this->column_fields["record_module"] = $module;
  }

	/** Function to saves the values in all the tables mentioned in the class variable $tab_name for the specified module
  	  * @param $module -- module:: Type varchar
 	 */
	function save($module_name,$fileid='') 
	{
		global $log;
		$log->debug("module name is ".$module_name);
	
		//Event triggering code
		require_once("include/events/include.inc");
		global $adb;
		$em = new VTEventsManager($adb);
		$entityData  = VTEntityData::fromCRMEntity($this);
		$em->triggerEvent("vtiger.entity.beforesave.modifiable", $entityData);
		$em->triggerEvent("vtiger.entity.beforesave", $entityData);
		$em->triggerEvent("vtiger.entity.beforesave.final", $entityData);
		//Event triggering code ends
	
		//GS Save entity being called with the modulename as parameter
		$this->saveentity($module_name,$fileid);
		
		//Event triggering code
		$em->triggerEvent("vtiger.entity.aftersave", $entityData);
		//Event triggering code ends
	}
  
	function process_list_query($query, $row_offset, $limit= -1, $max_per_page = -1)
	{
		global $list_max_entries_per_page;
		$this->log->debug("process_list_query: ".$query);
		if(!empty($limit) && $limit != -1){
			$result =& $this->db->limitQuery($query, $row_offset + 0, $limit,true,"Error retrieving $this->object_name list: ");
		}else{
			$result =& $this->db->query($query,true,"Error retrieving $this->object_name list: ");
		}

		$list = Array();
		if($max_per_page == -1){
			$max_per_page 	= $list_max_entries_per_page;
		}
		$rows_found =  $this->db->getRowCount($result);

		$this->log->debug("Found $rows_found ".$this->object_name."s");
                
		$previous_offset = $row_offset - $max_per_page;
		$next_offset = $row_offset + $max_per_page;

		if($rows_found != 0)
		{

			// We have some data.

			for($index = $row_offset , $row = $this->db->fetchByAssoc($result, $index); $row && ($index < $row_offset + $max_per_page || $max_per_page == -99) ;$index++, $row = $this->db->fetchByAssoc($result, $index)){

				
				foreach($this->list_fields as $entry)
				{

					foreach($entry as $key=>$field) // this will be cycled only once
					{						
						if (isset($row[$field])) {
							$this->column_fields[$this->list_fields_names[$key]] = $row[$field];
						
						
							$this->log->debug("$this->object_name({$row['id']}): ".$field." = ".$this->$field);
						}
						else 
						{
							$this->column_fields[$this->list_fields_names[$key]] = "";
						}
					}
				}


				//$this->db->println("here is the bug");
				

				$list[] = clone($this);//added by Richie to support PHP5
			}
		}

		$response = Array();
		$response['list'] = $list;
		$response['row_count'] = $rows_found;
		$response['next_offset'] = $next_offset;
		$response['previous_offset'] = $previous_offset;

		return $response;
	}

	function process_full_list_query($query)
	{
		$this->log->debug("CRMEntity:process_full_list_query");
		$result =& $this->db->query($query, false);
		//$this->log->debug("CRMEntity:process_full_list_query: result is ".$result);


		if($this->db->getRowCount($result) > 0){
		
		//	$this->db->println("process_full mid=".$this->table_index." mname=".$this->module_name);
			// We have some data.
			while ($row = $this->db->fetchByAssoc($result)) {				
				$rowid=$row[$this->table_index];

				if(isset($rowid))
			       		$this->retrieve_entity_info($rowid,$this->module_name);
				else
					$this->db->println("rowid not set unable to retrieve");
				 
				 
				
		//clone function added to resolvoe PHP5 compatibility issue in Dashboards
		//If we do not use clone, while using PHP5, the memory address remains fixed but the
	//data gets overridden hence all the rows that come in bear the same value. This in turn
//provides a wrong display of the Dashboard graphs. The data is erroneously shown for a specific month alone
//Added by Richie
				$list[] = clone($this);//added by Richie to support PHP5
			}
		}

		if (isset($list)) return $list;
		else return null;
	}
	
	/** This function should be overridden in each module.  It marks an item as deleted.
	* If it is not overridden, then marking this type of item is not allowed
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function mark_deleted($id) {
		$date_var = date('Y-m-d H:i:s');
		$query = "UPDATE vtiger_crmentity set deleted=1,modifiedtime=? where crmid=?";
		$this->db->pquery($query, array($this->db->formatDate($date_var, true),$id), true,"Error marking record deleted: ");
	}

	function retrieve_by_string_fields($fields_array, $encode=true) 
	{ 
		$where_clause = $this->get_where($fields_array);
		
		$query = "SELECT * FROM $this->table_name $where_clause";
		$this->log->debug("Retrieve $this->object_name: ".$query);
		$result =& $this->db->requireSingleResult($query, true, "Retrieving record $where_clause:");
		if( empty($result)) 
		{ 
		 	return null; 
		} 

		 $row = $this->db->fetchByAssoc($result,-1, $encode);

		foreach($this->column_fields as $field) 
		{ 
			if(isset($row[$field])) 
			{ 
				$this->$field = $row[$field];
			}
		} 
		return $this;
	}

	// this method is called during an import before inserting a bean
	// define an associative array called $special_fields
	// the keys are user defined, and don't directly map to the bean's vtiger_fields
	// the value is the method name within that bean that will do extra
	// processing for that vtiger_field. example: 'full_name'=>'get_names_from_full_name'

	function process_special_fields() 
	{ 
		foreach ($this->special_functions as $func_name) 
		{ 
			if ( method_exists($this,$func_name) ) 
			{ 
				$this->$func_name(); 
			} 
		} 
	}

	/**
         * Function to check if the custom vtiger_field vtiger_table exists
         * return true or false
         */
        function checkIfCustomTableExists($tablename)
        {
                $query = "select * from ". mysql_real_escape_string($tablename);
                $result = $this->db->pquery($query, array());
                $testrow = $this->db->num_fields($result);
                if($testrow > 1)
                {
                        $exists=true;
                }
                else
                {
                        $exists=false;
                }
                return $exists;
        }

	/**
	 * function to construct the query to fetch the custom vtiger_fields
	 * return the query to fetch the custom vtiger_fields
         */
        function constructCustomQueryAddendum($tablename,$module)
        {
                global $adb;
		$tabid=getTabid($module);		
                $sql1 = "select columnname,fieldlabel from vtiger_field where generatedtype=2 and tabid=? and vtiger_field.presence in (0,2)"; 
                $result = $adb->pquery($sql1, array($tabid));
                $numRows = $adb->num_rows($result);
                $sql3 = "select ";
                for($i=0; $i < $numRows;$i++)
                {
                        $columnName = $adb->query_result($result,$i,"columnname");
                        $fieldlabel = $adb->query_result($result,$i,"fieldlabel");
                        //construct query as below
                        if($i == 0)
                        {
                                $sql3 .= $tablename.".".$columnName. " '" .$fieldlabel."'";
                        }
                        else
                        {
                                $sql3 .= ", ".$tablename.".".$columnName. " '" .$fieldlabel."'";
                        }

                }
                if($numRows>0)
                {
                        $sql3=$sql3.',';
                }
                return $sql3;

        }


	/**
	 * This function returns a full (ie non-paged) list of the current object type.  
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_full_list($order_by = "", $where = "") {
		$this->log->debug("get_full_list:  order_by = '$order_by' and where = '$where'");
		$query = $this->create_list_query($order_by, $where);
		return $this->process_full_list_query($query);
	}

	/**
	 * Track the viewing of a detail record.  This leverages get_summary_text() which is object specific
	 * params $user_id - The user that is viewing the record.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function track_view($user_id, $current_module,$id='')
	{
		$this->log->debug("About to call tracker (user_id, module_name, item_id)($user_id, $current_module, $this->id)");

		$tracker = new Tracker();
		//$tracker->track_view($user_id, $current_module, $id, '');
	}

	/*function insertIntoGroupTable($module)
	{
		global $log;

		if($module == 'Events')
		{
			$module = 'Calendar';
		}
		if($this->mode=='edit')
		{
						
		  	//to disable the update of groupentity relation in ajax edit for the fields except assigned_user_id field
			if(($_REQUEST['ajxaction'] != 'DETAILVIEW' && $_REQUEST['action'] != 'MassEditSave') || ($_REQUEST['ajxaction'] == 'DETAILVIEW' && $_REQUEST['fldName'] == 'assigned_user_id') || ($_REQUEST['action'] == 'MassEditSave' && isset($_REQUEST['assigned_user_id_mass_edit_check'])))
		  	{	  
			  	if($_REQUEST['assigntype'] == 'T')
			  	{
					$groupname = $_REQUEST['assigned_group_id'];

					updateModuleGroupRelation($module,$this->id,$groupname);

			  	}
				else
				{
					updateModuleGroupRelation($module,$this->id,'');

				}

		  	}
      		}
		else
		{
			$groupname = $_REQUEST['assigned_group_id'];
		 	if($_REQUEST['assigntype'] == 'T')
		  	{
			  	insertIntoGroupRelation($module,$this->id,$groupname);
		  	}
		  
		}			

	}*/
	
	/**
	* Function to get the column value of a field when the field value is empty ''
	* @param $columnname -- Column name for the field
	* @param $fldvalue -- Input value for the field taken from the User
	* @param $fieldname -- Name of the Field
	* @param $uitype -- UI type of the field
	* @return Column value of the field.
	*/
	function get_column_value($columnname, $fldvalue, $fieldname, $uitype, $datatype='') {
		global $log;
		$log->debug("Entering function get_column_value ($columnname, $fldvalue, $fieldname, $uitype, $datatype='')");
		
		// Added for the fields of uitype '57' which has datatype mismatch in crmentity table and particular entity table
		if ($uitype == 57 && $fldvalue == '') {
			return 0;
		}
		if (is_uitype($uitype, "_date_") && $fldvalue == '') {
			return null;
		}
		if ($datatype == 'I' || $datatype == 'N' || $datatype == 'NN'){
			return 0;
		}
		$log->debug("Exiting function get_column_value");
		return $fldvalue;
	}
	
	/**
	* Function to make change to column fields, depending on the current user's accessibility for the fields
	*/
	function apply_field_security() {
		global $current_user, $currentModule;
		
		require_once('include/utils/UserInfoUtil.php');
		foreach($this->column_fields as $fieldname=>$fieldvalue) {
		$reset_value = false;
			if (getFieldVisibilityPermission($currentModule, $current_user->id, $fieldname) != '0') 
				$reset_value = true;
			
			if ($fieldname == "record_id" || $fieldname == "record_module") 
				$reset_value = false;

			/*
				if (isset($this->additional_column_fields) && in_array($fieldname, $this->additional_column_fields) == true)
					$reset_value = false;
			 */
			
			if ($reset_value == true)
				$this->column_fields[$fieldname] = "";
		}
	}
	
	/**
	* Function to initialize the importable fields array, based on the User's accessibility to the fields
	*/
	function initImportableFields($module) {		
		global $current_user, $adb;
		require_once('include/utils/UserInfoUtil.php');
		
		//$colf = getColumnFields($module);
		$colf = Array();
		$tabid = getTabid($module);
		$skip_uitypes = array('4'); // uitype 4 is for Mod numbers
		$sql = "select * from vtiger_field where tabid=? and uitype not in (". generateQuestionMarks($skip_uitypes) .") and vtiger_field.presence in (0,2)"; 
	        $result = $adb->pquery($sql, array($tabid, $skip_uitypes));
	        $noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$colf[$fieldname] = ''; 
		}
		foreach($colf as $key=>$value) {
			if (getFieldVisibilityPermission($module, $current_user->id, $key) == '0')
				$this->importable_fields[$key]=1;
		}
	}
	
	
	/** Function to initialize the required fields array for that particular module */
	function initRequiredFields($module) {
		global $adb;
		
		$tabid = getTabId($module);
		$sql = "select * from vtiger_field where tabid= ? and typeofdata like '%M%' and uitype not in ('53','70') and vtiger_field.presence in (0,2)";  
		$result = $adb->pquery($sql,array($tabid));
        $numRows = $adb->num_rows($result);
        for($i=0; $i < $numRows;$i++)
        {
        	$fieldName = $adb->query_result($result,$i,"fieldname");
			$this->required_fields[$fieldName] = 1;
		}
	}
	
	/** Function to delete an entity with given Id */
	function trash($module, $id) {
		global $log, $current_user;
		
		$this->mark_deleted($id);
		$this->unlinkDependencies($module, $id);
		/*
		require_once('include/freetag/freetag.class.php');
		$freetag=new freetag();
		$freetag->delete_all_object_tags_for_user($current_user->id,$id);
		*/
		$sql_recentviewed ='DELETE FROM tracker WHERE user_id = ? AND item_id = ?';
        $this->db->pquery($sql_recentviewed, array($current_user->id, $id));
	}
	
	
	/** Function to unlink all the dependent entities of the given Entity by Id */
	function unlinkDependencies($module, $id) {
		global $log;
		
		$fieldRes = $this->db->pquery('SELECT tabid, tablename, columnname FROM vtiger_field WHERE fieldid IN (
			SELECT fieldid FROM vtiger_fieldmodulerel WHERE relmodule=?)', array($module));
		$numOfFields = $this->db->num_rows($fieldRes);
		for ($i=0; $i<$numOfFields; $i++) {
			$tabId = $this->db->query_result($fieldRes, $i, 'tabid');
			$tableName = $this->db->query_result($fieldRes, $i, 'tablename');
			$columnName = $this->db->query_result($fieldRes, $i, 'columnname');
			
			$relatedModule = vtlib_getModuleNameById($tabId);
			checkFileAccess("modules/$relatedModule/$relatedModule.php");
			require_once("modules/$relatedModule/$relatedModule.php");
			$focusObj = new $relatedModule();
			
			//Backup Field Relations for the deleted entity
			$relQuery = "SELECT $focusObj->table_index FROM $tableName WHERE $columnName=?";
			$relResult = $this->db->pquery($relQuery, array($id));
			$numOfRelRecords = $this->db->num_rows($relResult);
			if ($numOfRelRecords > 0) {
				$recordIdsList = array();
				for($k=0;$k < $numOfRelRecords;$k++)
				{
					$recordIdsList[] = $this->db->query_result($relResult,$k,$focusObj->table_index);
				}
				$params = array($id, RB_RECORD_UPDATED, $tableName, $columnName, $focusObj->table_index, implode(",", $recordIdsList));
				$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES (?,?,?,?,?,?)', $params);
			}
			
			$query = "UPDATE $tableName SET $columnName=0 WHERE $columnName=?";
			$params = array($id);
			$this->db->pquery($query, $params);
		}
	}
	
	/** Function to unlink an entity with given Id from another entity */
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		
		$query = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
		$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
		$this->db->pquery($query, $params);
	}
	
	/** Function to restore a deleted record of specified module with given crmid
  	  * @param $module -- module name:: Type varchar
  	  * @param $entity_ids -- list of crmids :: Array
 	 */
	function restore($module, $id) {
		global $current_user;
	
		$this->db->println("TRANS restore starts $module");
		$this->db->startTransaction();		
	
		$this->db->pquery('UPDATE vtiger_crmentity SET deleted=0 WHERE crmid = ?', array($id));
		//Restore related entities/records
		$this->restoreRelatedRecords($module,$id);
		
		$this->db->completeTransaction();
	    $this->db->println("TRANS restore ends");
	}

	/** Function to restore all the related records of a given record by id */
	function restoreRelatedRecords($module,$record) {
		
		$result = $this->db->pquery('SELECT * FROM vtiger_relatedlists_rb WHERE entityid = ?', array($record));
		$numRows = $this->db->num_rows($result);
		for($i=0; $i < $numRows;$i++)
		{
			$action = $this->db->query_result($result,$i,"action");
			$rel_table = $this->db->query_result($result,$i,"rel_table");
			$rel_column = $this->db->query_result($result,$i,"rel_column");
			$ref_column = $this->db->query_result($result,$i,"ref_column");
			$related_crm_ids = $this->db->query_result($result,$i,"related_crm_ids");
			
			if(strtoupper($action) == RB_RECORD_UPDATED) {
				$related_ids = explode(",", $related_crm_ids);
				if($rel_table == 'vtiger_crmentity' && $rel_column == 'deleted') {
					$sql = "UPDATE $rel_table set $rel_column = 0 WHERE $ref_column IN (". generateQuestionMarks($related_ids) . ")";
					$this->db->pquery($sql, array($related_ids));
				} else {
					$sql = "UPDATE $rel_table set $rel_column = ? WHERE $rel_column = 0 AND $ref_column IN (". generateQuestionMarks($related_ids) . ")";
					$this->db->pquery($sql, array($record, $related_ids));			
				}
			} elseif (strtoupper($action) == RB_RECORD_DELETED) {
				if ($rel_table == 'vtiger_seproductrel') {
					$sql = "INSERT INTO $rel_table($rel_column, $ref_column, 'setype') VALUES (?,?,?)";
					$this->db->pquery($sql, array($record, $related_crm_ids, $module));
				} else {
					$sql = "INSERT INTO $rel_table($rel_column, $ref_column) VALUES (?,?)";
					$this->db->pquery($sql, array($record, $related_crm_ids));
				}
			}
		}		
		
		//Clean up the the backup data also after restoring
		$this->db->pquery('DELETE FROM vtiger_relatedlists_rb WHERE entityid = ?', array($record));		
	}

	/** 
	* Function to initialize the sortby fields array
	*/
	function initSortByField($module) {
		global $adb, $log;
		$log->debug("Entering function initSortByField ($module)");
		// Define the columnname's and uitype's which needs to be excluded
		$exclude_columns = Array ('parent_id','quoteid','vendorid');
		$exclude_uitypes = Array ();
		
		$tabid = getTabId($module);
		if($module == 'Calendar') {
			$tabid = array('9','16');
		}
		$sql = "SELECT columnname FROM vtiger_field ".
				" WHERE (fieldname not like '%\_id' OR fieldname in ('assigned_user_id'))".
				" AND tabid in (". generateQuestionMarks($tabid) .") and vtiger_field.presence in (0,2)";  
		$params = array($tabid);
		if (count($exclude_columns) > 0) {		
			$sql .= " AND columnname NOT IN (". generateQuestionMarks($exclude_columns) .")";
			array_push($params, $exclude_columns);
		}
		if (count($exclude_uitypes) > 0) {		
			$sql .= " AND uitype NOT IN (". generateQuestionMarks($exclude_uitypes) . ")";
			array_push($params, $exclude_uitypes);
		}
		$result = $adb->pquery($sql,$params);
		$num_rows = $adb->num_rows($result);
		for($i=0; $i<$num_rows; $i++) {
			$columnname = $adb->query_result($result,$i,'columnname');
			if(in_array($columnname, $this->sortby_fields)) continue;
			else $this->sortby_fields[] = $columnname;
		}
		if($tabid == 21 or $tabid == 22)
			$this->sortby_fields[] = 'crmid';
		$log->debug("Exiting initSortByField");
	}

	/* Function to set the Sequence string and sequence number starting value */
	function setModuleSeqNumber($mode, $module, $req_str='', $req_no='')
	{
		global $adb;
		//when we configure the invoice number in Settings this will be used
		if ($mode == "configure" && $req_no != '') {
			$check = $adb->pquery("select cur_id from vtiger_modentity_num where semodule=? and prefix = ?", array($module, $req_str));
			if($adb->num_rows($check)== 0) {
				$numid = $adb->getUniqueId("vtiger_modentity_num");
				$active = $adb->pquery("select num_id from vtiger_modentity_num where semodule=? and active=1", array($module));
				$adb->pquery("UPDATE vtiger_modentity_num SET active=0 where num_id=?", array($adb->query_result($active,0,'num_id')));
				
				$adb->pquery("INSERT into vtiger_modentity_num values(?,?,?,?,?,?)", array($numid,$module,$req_str,$req_no,$req_no,1));
				return true;
			}
			else if($adb->num_rows($check)!=0) {
				$num_check = $adb->query_result($check,0,'cur_id');
				if($req_no < $num_check) {
					return false;
				}
				else {
					$adb->pquery("UPDATE vtiger_modentity_num SET active=0 where active=1 and semodule=?", array($module));
					$adb->pquery("UPDATE vtiger_modentity_num SET cur_id=?, active = 1 where prefix=? and semodule=?", array($req_no,$req_str,$module));
					return true;
				}
			}
		}
		else if ($mode == "increment") {
			//when we save new invoice we will increment the invoice id and write
			$check = $adb->pquery("select cur_id,prefix from vtiger_modentity_num where semodule=? and active = 1", array($module));
			$prefix = $adb->query_result($check,0,'prefix');
			$curid = $adb->query_result($check,0,'cur_id');
			$prev_inv_no=$prefix.$curid;
			$strip=strlen($curid)-strlen($curid+1);
			if($strip<0)$strip=0;
			$temp = str_repeat("0",$strip);
			$req_no.= $temp.($curid+1);
			$adb->pquery("UPDATE vtiger_modentity_num SET cur_id=? where cur_id=? and active=1 AND semodule=?", array($req_no,$curid,$module));
			return decode_html($prev_inv_no);	
		}
	}
	// END
	
	/* Function to get the next module sequence number for a given module */
	function getModuleSeqInfo($module) {
		global $adb;
		$check = $adb->pquery("select cur_id,prefix from vtiger_modentity_num where semodule=? and active = 1", array($module));
		$prefix = $adb->query_result($check,0,'prefix');
		$curid = $adb->query_result($check,0,'cur_id');
		return array($prefix, $curid);
	}
	// END
	
	/* Function to check if the mod number already exits */	
	function checkModuleSeqNumber($table, $column, $no)
	{
		global $adb;
		$result=$adb->pquery("select ".mysql_real_escape_string($column). 
			" from ".mysql_real_escape_string($table). 
			" where ".mysql_real_escape_string($column)." = ?", array($no));
	
		$num_rows = $adb->num_rows($result);
	
		if($num_rows > 0)
			return true;
		else
			return false;
	}
	// END


	/* Generic function to get attachments in the related list of a given module */
	function get_attachments($id, $cur_tab_id, $rel_tab_id, $actions=false) {
	
		global $currentModule, $app_strings,$singlepane_view;
		$this_module = $currentModule;
		if(isset($_REQUEST)){ 
			$parenttab = $_REQUEST['parenttab'];
		}	
		$related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();
		  
		// Some standard module class doesn't have required variables
		// that are used in the query, they are defined in this generic API
		vtlib_setup_modulevars($related_module, $other);
		
		$singular_modname = vtlib_toSingular($related_module);
		$button = '';
		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_NEW'). " ". getTranslatedString($related_module) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}
		$button .= '</td>';
		
	 // To make the edit or del link actions to return back to same view.
		if($singlepane_view == 'true') $returnset = "&return_module=$this_module&return_action=DetailView&return_id=$id";
		else $returnset = "&return_module=$this_module&return_action=CallRelatedList&return_id=$id";
		
	 	$query = "select case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name," .
				"'Documents' ActivityType,vtiger_attachments.type  FileType,crm2.modifiedtime lastmodified,
				vtiger_seattachmentsrel.attachmentsid attachmentsid, vtiger_notes.notesid crmid,
				vtiger_notes.notecontent description,vtiger_notes.*
				from vtiger_notes
				inner join vtiger_senotesrel on vtiger_senotesrel.notesid= vtiger_notes.notesid
				inner join vtiger_crmentity on vtiger_crmentity.crmid= vtiger_notes.notesid and vtiger_crmentity.deleted=0
				inner join vtiger_crmentity crm2 on crm2.crmid=vtiger_senotesrel.crmid 
				LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid			
				left join vtiger_seattachmentsrel  on vtiger_seattachmentsrel.crmid =vtiger_notes.notesid
				left join vtiger_attachments on vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
				left join vtiger_users on vtiger_crmentity.smownerid= vtiger_users.id
				where crm2.crmid=".$id;
		
		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset); 
		
		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		return $return_value;
	}

	/**
	 * For Record View Notification
	 */
	function isViewed($crmid=false) {
		if(!$crmid) { $crmid = $this->id; }
		if($crmid) {
			global $adb;
			$result = $adb->pquery("SELECT viewedtime,modifiedtime,smcreatorid,smownerid,modifiedby FROM vtiger_crmentity WHERE crmid=?", Array($crmid));
			$resinfo = $adb->fetch_array($result);

			$lastviewed = $resinfo['viewedtime'];
			$modifiedon = $resinfo['modifiedtime'];
			$smownerid   = $resinfo['smownerid'];
			$smcreatorid = $resinfo['smcreatorid'];
			$modifiedby = $resinfo['modifiedby'];
		
			if($modifiedby == '0' && ($smownerid == $smcreatorid)) {
				/** When module record is created **/
				return true; 
			} else if($smownerid == $modifiedby) {
				/** Owner and Modifier as same. **/
				return true;
			} else if($lastviewed && $modifiedon) {
				/** Lastviewed and Modified time is available. */
				if($this->__timediff($modifiedon, $lastviewed) > 0) return true;
			} 
		}
		return false;
	}

	function __timediff($d1, $d2) {
		list($t1_1, $t1_2) = explode(' ', $d1);
		list($t1_y, $t1_m, $t1_d) = explode('-', $t1_1);
		list($t1_h, $t1_i, $t1_s) = explode(':', $t1_2);

		$t1 = mktime($t1_h, $t1_i, $t1_s, $t1_m, $t1_d, $t1_y);

		list($t2_1, $t2_2) = explode(' ', $d2);
		list($t2_y, $t2_m, $t2_d) = explode('-', $t2_1);
		list($t2_h, $t2_i, $t2_s) = explode(':', $t2_2);

		$t2 = mktime($t2_h, $t2_i, $t2_s, $t2_m, $t2_d, $t2_y);

		if( $t1 == $t2 ) return 0;
		return $t2 - $t1;
	}

	function markAsViewed($userid) {
		global $adb;
		$adb->pquery("UPDATE vtiger_crmentity set viewedtime=? WHERE crmid=? AND smownerid=?",
			Array( date('Y-m-d H:i:s', time()), $this->id, $userid));
	}
	
	/**
	 * Save the related module record information. Triggered from CRMEntity->saveentity method or updateRelations.php
	 * @param String This module name
	 * @param Integer This module record number
	 * @param String Related module name
	 * @param mixed Integer or Array of related module record number
	 */
	function save_related_module($module, $crmid, $with_module, $with_crmid) {
		global $adb;
		if(!is_array($with_crmid)) $with_crmid = Array($with_crmid);
		foreach($with_crmid as $relcrmid) {
			$checkpresence = $adb->pquery("SELECT crmid FROM vtiger_crmentityrel WHERE 
				crmid = ? AND module = ? AND relcrmid = ? AND relmodule = ?", Array($crmid, $module, $relcrmid, $with_module));
			// Relation already exists? No need to add again
			if($checkpresence && $adb->num_rows($checkpresence)) continue;

			$adb->pquery("INSERT INTO vtiger_crmentityrel(crmid, module, relcrmid, relmodule) VALUES(?,?,?,?)", 
				Array($crmid, $module, $relcrmid, $with_module));
		}
	}

	/**
	 * Delete the related module record information. Triggered from updateRelations.php
	 * @param String This module name
	 * @param Integer This module record number
	 * @param String Related module name
	 * @param mixed Integer or Array of related module record number
	 */
	function delete_related_module($module, $crmid, $with_module, $with_crmid) {
		global $adb;
		if(!is_array($with_crmid)) $with_crmid = Array($with_crmid);
		foreach($with_crmid as $relcrmid) {
			$adb->pquery("DELETE FROM vtiger_crmentityrel WHERE crmid=? AND module=? AND relcrmid=? AND relmodule=?",
				Array($crmid, $module, $relcrmid, $with_module));
		}
	}

	/**
	 * Default (generic) function to handle the related list for the module.
	 * NOTE: Vtiger_Module::setRelatedList sets reference to this function in vtiger_relatedlists table
	 * if function name is not explicitly specified.
	 */
	function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions=false) {

		global $currentModule, $app_strings;

		if(isset($_REQUEST)) $parenttab = $_REQUEST['parenttab'];

		$related_module = vtlib_getModuleNameById($rel_tab_id);

		checkFileAccess("modules/$related_module/$related_module.php");
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();
		
		// Some standard module class doesn't have required variables
		// that are used in the query, they are defined in this generic API
		vtlib_setup_modulevars($currentModule, $this);
		vtlib_setup_modulevars($related_module, $other);

		$singular_modname = vtlib_toSingular($related_module);

		$button = '';
		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' " .
						" type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\"" .
						" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_NEW'). " ". getTranslatedString($related_module) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}
		$button .= '</td>';

		// To make the edit or del link actions to return back to same view.
		if($singlepane_view == 'true') $returnset = "&return_module=$currentModule&return_action=DetailView&return_id=$id";
		else $returnset = "&return_module=$currentModule&return_action=CallRelatedList&return_id=$id";

		$query = "SELECT vtiger_crmentity.*, $other->table_name.*";

		$query .= ", CASE WHEN (vtiger_users.user_name NOT LIKE '') THEN vtiger_users.user_name ELSE vtiger_groups.groupname END AS user_name";
		
		$more_relation = '';
		if(!empty($other->related_tables)) {
			foreach($other->related_tables as $tname=>$relmap) {
				$query .= ", $tname.*";

				// Setup the default JOIN conditions if not specified
				if(empty($relmap[1])) $relmap[1] = $other->table_name;
				if(empty($relmap[2])) $relmap[2] = $relmap[0];
				$more_relation .= " LEFT JOIN $tname ON $tname.$relmap[0] = $relmap[1].$relmap[2]";
			}
		}

		$query .= " FROM $other->table_name";
		$query .= " INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $other->table_name.$other->table_index";
		$query .= " INNER JOIN vtiger_crmentityrel ON (vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid OR vtiger_crmentityrel.crmid = vtiger_crmentity.crmid)";
		$query .= " LEFT  JOIN $this->table_name   ON $this->table_name.$this->table_index = $other->table_name.$other->table_index";
		$query .= $more_relation;
		$query .= " LEFT  JOIN vtiger_users        ON vtiger_users.id = vtiger_crmentity.smownerid";
		$query .= " LEFT  JOIN vtiger_groups       ON vtiger_groups.groupid = $other->table_name.$other->table_index";

		$query .= " WHERE vtiger_crmentity.deleted = 0 AND (vtiger_crmentityrel.crmid = $id OR vtiger_crmentityrel.relcrmid = $id)";

		$return_value = GetRelatedList($currentModule, $related_module, $other, $query, $button, $returnset);	

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		
		return $return_value;
	}

	/**
	 * Move the related records of the specified list of id's to the given record.
	 * @param String This module name
	 * @param Array List of Entity Id's from which related records need to be transfered 
	 * @param Integer Id of the the Record to which the related records are to be moved
	 */
	function transferRelatedRecords($module, $transferEntityIds, $entityId) {
		global $adb,$log;
		$log->debug("Entering function transferRelatedRecords ($module, $transferEntityIds, $entityId)");
		foreach($transferEntityIds as $transferId){
			
			// Pick the records related to the entity to be transfered, but do not pick the once which are already related to the current entity.
			$relatedRecords =  $adb->pquery("SELECT relcrmid, relmodule FROM vtiger_crmentityrel WHERE crmid=? AND module=?" .
					" AND relcrmid NOT IN (SELECT relcrmid FROM vtiger_crmentityrel WHERE crmid=? AND module=?)",
					 array($transferId, $module, $entityId, $module));
			$numOfRecords = $adb->num_rows($relatedRecords);
			for($i=0;$i<$numOfRecords;$i++) {
				$relcrmid = $adb->query_result($relatedRecords,$i,'relcrmid');
				$relmodule = $adb->query_result($relatedRecords,$i,'relmodule');
				$adb->pquery("UPDATE vtiger_crmentityrel SET crmid=? WHERE relcrmid=? AND relmodule=? AND crmid=? AND module=?", 
								array($entityId, $relcrmid, $relmodule, $transferId, $module));
			}
			
			// Pick the records to which the entity to be transfered is related, but do not pick the once to which current entity is already related.
			$parentRecords =  $adb->pquery("SELECT crmid, module FROM vtiger_crmentityrel WHERE relcrmid=? AND relmodule=?" .
					" AND crmid NOT IN (SELECT crmid FROM vtiger_crmentityrel WHERE relcrmid=? AND relmodule=?)",
					 array($transferId, $module, $entityId, $module));
			$numOfRecords = $adb->num_rows($parentRecords);
			for($i=0;$i<$numOfRecords;$i++) {
				$parcrmid = $adb->query_result($parentRecords,$i,'crmid');
				$parmodule = $adb->query_result($parentRecords,$i,'module');
				$adb->pquery("UPDATE vtiger_crmentityrel SET relcrmid=? WHERE crmid=? AND module=? AND relcrmid=? AND relmodule=?", 
								array($entityId, $parcrmid, $parmodule, $transferId, $module));
			}
		}
		$log->debug("Exiting transferRelatedRecords...");
	}

	/*
	 * Function to get the primary query part of a report for which generateReportsQuery Doesnt exist in module 
	 * @param - $module Primary module name
	 * returns the query string formed on fetching the related data for report for primary module
	 */
	function generateReportsQuery($module){
		global $adb;
		checkFileAccess("modules/$module/$module.php");
		require_once("modules/$module/$module.php");
		$primary = new $module();

		vtlib_setup_modulevars($module, $primary);
		$moduletable = $primary->table_name;
		$moduleindex = $primary->table_index;
		$modulecftable = $primary->customFieldTable[0];
		$modulecfindex = $primary->customFieldTable[1];
		
		if(isset($modulecftable)){
			$cfquery = "inner join $modulecftable as $modulecftable on $modulecftable.$modulecfindex=$moduletable.$moduleindex";
		} else {
			$cfquery = '';
		}
		$query = "from $moduletable $cfquery
	        inner join vtiger_crmentity on vtiger_crmentity.crmid=$moduletable.$moduleindex
			left join vtiger_groups as vtiger_groups".$module." on vtiger_groups".$module.".groupid = vtiger_crmentity.smownerid
            left join vtiger_users as vtiger_users".$module." on vtiger_users".$module.".id = vtiger_crmentity.smownerid
			left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid
            left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid";
            
        $fields_query = $adb->pquery("SELECT vtiger_field.fieldname,vtiger_field.tablename,vtiger_field.fieldid from vtiger_field INNER JOIN vtiger_tab on vtiger_tab.name = ? WHERE vtiger_tab.tabid=vtiger_field.tabid AND vtiger_field.uitype IN (10) and vtiger_field.presence in (0,2)",array($module));
        
        if($adb->num_rows($fields_query)>0){
	        for($i=0;$i<$adb->num_rows($fields_query);$i++){
	        	$field_name = $adb->query_result($fields_query,$i,'fieldname');
	        	$field_id = $adb->query_result($fields_query,$i,'fieldid');
		        $tab_name = $adb->query_result($fields_query,$i,'tablename');
		        $ui10_modules_query = $adb->pquery("SELECT relmodule FROM vtiger_fieldmodulerel WHERE fieldid=?",array($field_id));
		        
		       if($adb->num_rows($ui10_modules_query)>0){
			        $query.= " left join vtiger_crmentity as vtiger_crmentityRel$module on vtiger_crmentityRel$module.crmid = $tab_name.$field_name and vtiger_crmentityRel$module.deleted=0";
			        for($j=0;$j<$adb->num_rows($ui10_modules_query);$j++){
			        	$rel_mod = $adb->query_result($ui10_modules_query,$j,'relmodule');
			        	require_once("modules/$rel_mod/$rel_mod.php");
			        	$rel_obj = new $rel_mod();
			        	vtlib_setup_modulevars($rel_mod, $rel_obj);
						
						$rel_tab_name = $rel_obj->table_name;
						$rel_tab_index = $rel_obj->table_index;
				        $query.= " left join $rel_tab_name as ".$rel_tab_name."Rel$module on ".$rel_tab_name."Rel$module.$rel_tab_index = vtiger_crmentityRel$module.crmid";
			        }
		       }
	        }
        }
 		return $query;
	 		            
	}
	
	/*
	 * Function to get the secondary query part of a report for which generateReportsSecQuery Doesnt exist in module 
	 * @param - $module primary module name
	 * @param - $secmodule secondary module name
	 * returns the query string formed on fetching the related data for report for secondary module
	 */
	function generateReportsSecQuery($module,$secmodule){
		global $adb;
		checkFileAccess("modules/$secmodule/$secmodule.php");
		require_once("modules/$secmodule/$secmodule.php");
		$secondary = new $secmodule();

		vtlib_setup_modulevars($secmodule, $secondary);
	 	
		$tablename = $secondary->table_name;
		$tableindex = $secondary->table_index;
		$modulecftable = $secondary->customFieldTable[0];
		$modulecfindex = $secondary->customFieldTable[1];
	 	$tab = getRelationTables($module,$secmodule);
		
		foreach($tab as $key=>$value){
			$tables[]=$key;
			$fields[] = $value;
		}
		$tabname = $tables[0];
		$prifieldname = $fields[0][0];
		$secfieldname = $fields[0][1];
		$tmpname = $tabname."tmp";
		$condvalue = $tables[1].".".$fields[1];
		if(isset($modulecftable)){
			$cfquery = " left join $modulecftable on $modulecftable.$modulecfindex=$tablename.$tableindex";
		} else {
			$cfquery = '';
		}
	
		$query = " left join $tabname as $tmpname on $tmpname.$prifieldname = $condvalue  and $tmpname.$secfieldname IN (SELECT notesid from vtiger_notes)";
		$query .=" 	left join $tablename as $tablename".$secmodule." on $tablename".$secmodule.".$tableindex = $tmpname.$secfieldname
					left join vtiger_crmentity as vtiger_crmentity$secmodule on vtiger_crmentity$secmodule.crmid = $tablename".$secmodule.".$tableindex AND vtiger_crmentity$secmodule.deleted=0   
					left join $tablename on $tablename.$tableindex=vtiger_crmentity$secmodule.crmid   
					$cfquery   
					left join vtiger_groups as vtiger_groups".$secmodule." on vtiger_groups".$secmodule.".groupid = vtiger_crmentity$secmodule.smownerid
		            left join vtiger_users as vtiger_users".$secmodule." on vtiger_users".$secmodule.".id = vtiger_crmentity$secmodule.smownerid"; 
   
       $fields_query = $adb->pquery("SELECT vtiger_field.fieldname,vtiger_field.tablename,vtiger_field.fieldid from vtiger_field INNER JOIN vtiger_tab on vtiger_tab.name = ? WHERE vtiger_tab.tabid=vtiger_field.tabid AND vtiger_field.uitype IN (10) and vtiger_field.presence in (0,2)",array($secmodule));
       
       if($adb->num_rows($fields_query)>0){
	        for($i=0;$i<$adb->num_rows($fields_query);$i++){
	        	$field_name = $adb->query_result($fields_query,$i,'fieldname');
	        	$field_id = $adb->query_result($fields_query,$i,'fieldid');
	        	$tab_name = $adb->query_result($fields_query,$i,'tablename');
		        $ui10_modules_query = $adb->pquery("SELECT relmodule FROM vtiger_fieldmodulerel WHERE fieldid=?",array($field_id));
		        
		       if($adb->num_rows($ui10_modules_query)>0){
			        $query.= " left join vtiger_crmentity as vtiger_crmentityRel$secmodule on vtiger_crmentityRel$secmodule.crmid = $tab_name.$field_name and vtiger_crmentityRel$secmodule.deleted=0";
			        for($j=0;$j<$adb->num_rows($ui10_modules_query);$j++){
			        	$rel_mod = $adb->query_result($ui10_modules_query,$j,'relmodule');
			        	require_once("modules/$rel_mod/$rel_mod.php");
			        	$rel_obj = new $rel_mod();
			        	vtlib_setup_modulevars($rel_mod, $rel_obj);
						
						$rel_tab_name = $rel_obj->table_name;
						$rel_tab_index = $rel_obj->table_index;
				        $query.= " left join $rel_tab_name as ".$rel_tab_name."Rel$secmodule on ".$rel_tab_name."Rel$secmodule.$rel_tab_index = vtiger_crmentityRel$secmodule.crmid";
			        }
		       }
	        }
        }

		return $query;
	}	

	/*
	 * Function to get the security query part of a report
	 * @param - $module primary module name
	 * returns the query string formed on fetching the related data for report for security of the module
	 */
	function getListViewSecurityParameter($module){
		$tabid=getTabid($module);
		global $current_user;
		if($current_user)
		{
	        	require('user_privileges/user_privileges_'.$current_user->id.'.php');
	        	require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		}
		$sec_query .= " and (vtiger_crmentity.smownerid in($current_user->id) or vtiger_crmentity.smownerid in(select vtiger_user2role.userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%') or vtiger_crmentity.smownerid in(select shareduserid from vtiger_tmp_read_user_sharing_per where userid=".$current_user->id." and tabid=".$tabid.") or (";

        if(sizeof($current_user_groups) > 0)
        {
              $sec_query .= " vtiger_groups.groupid in (". implode(",", $current_user_groups) .") or ";
        }
        $sec_query .= " vtiger_groups.groupid in(select vtiger_tmp_read_group_sharing_per.sharedgroupid from vtiger_tmp_read_group_sharing_per where userid=".$current_user->id." and tabid=".$tabid."))) ";	
	}
	
	/*
	 * Function to get the security query part of a report
	 * @param - $module primary module name
	 * returns the query string formed on fetching the related data for report for security of the module
	 */
	function getSecListViewSecurityParameter($module){
		$tabid=getTabid($module);
		global $current_user;
		if($current_user)
		{
	        	require('user_privileges/user_privileges_'.$current_user->id.'.php');
	        	require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		}
		$sec_query .= " and (vtiger_crmentity$module.smownerid in($current_user->id) or vtiger_crmentity$module.smownerid in(select vtiger_user2role.userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%') or vtiger_crmentity$module.smownerid in(select shareduserid from vtiger_tmp_read_user_sharing_per where userid=".$current_user->id." and tabid=".$tabid.") or (";

        if(sizeof($current_user_groups) > 0)
        {
              $sec_query .= " vtiger_groups$module.groupid in (". implode(",", $current_user_groups) .") or ";
        }
        $sec_query .= " vtiger_groups$module.groupid in(select vtiger_tmp_read_group_sharing_per.sharedgroupid from vtiger_tmp_read_group_sharing_per where userid=".$current_user->id." and tabid=".$tabid."))) ";	
	}
	/** END **/
}
?>
