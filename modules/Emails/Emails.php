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
 * $Header: /cvs/repository/siprodPCCI/modules/Emails/Emails.php,v 1.1 2010/01/15 18:44:04 isene Exp $
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
require_once('modules/Contacts/Contacts.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/Potentials/Potentials.php');
require_once('modules/Users/Users.php');

// Email is used to store customer information.
class Emails extends CRMEntity {
	var $log;
	var $db;
	var $table_name = "vtiger_activity";
	var $table_index= 'activityid';
	// Stored vtiger_fields
  	// added to check email save from plugin or not
	var $plugin_save = false;

var $rel_users_table = "vtiger_salesmanactivityrel";
var $rel_contacts_table = "vtiger_cntactivityrel";
var $rel_serel_table = "vtiger_seactivityrel";



	var $tab_name = Array('vtiger_crmentity','vtiger_activity');
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_activity'=>'activityid',
		'vtiger_seactivityrel'=>'activityid','vtiger_cntactivityrel'=>'activityid','vtiger_email_track'=>'mailid');

	// This is the list of vtiger_fields that are in the lists.
        var $list_fields = Array(
				       'Subject'=>Array('activity'=>'subject'),
				       'Related to'=>Array('seactivityrel'=>'parent_id'),
				       'Date Sent'=>Array('activity'=>'date_start'),
						'Assigned To'=>Array('crmentity','smownerid'),
						'Access Count'=>Array('vantage_email_track','count')
			        );

       var $list_fields_name = Array(
				       'Subject'=>'subject',
				       'Related to'=>'parent_id',
				       'Date Sent'=>'date_start',
						'Assigned To'=>'assigned_user_id',
       					'Access Count'=>'count'
				    );

       var $list_link_field= 'subject';

	var $column_fields = Array();

	var $sortby_fields = Array('subject','date_start','smownerid');

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'date_start';
	var $default_sort_order = 'ASC';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('subject','assigned_user_id');
	
	/** This function will set the columnfields for Email module 
	*/

	function Emails() {
		$this->log = LoggerManager::getLogger('email');
		$this->log->debug("Entering Emails() method ...");
		$this->log = LoggerManager::getLogger('email');
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('Emails');
		$this->log->debug("Exiting Email method ...");
	}


	function save_module($module)
	{
		global $adb;
		//Inserting into seactivityrel
		
		  //modified by Richie as raju's implementation broke the feature for addition of webmail to vtiger_crmentity.need to be more careful in future while integrating code
	   	  if($_REQUEST['module']=="Emails" && $_REQUEST['smodule']!='webmails' && (!$this->plugin_save))
		  {
				if($_REQUEST['currentid']!='')
				{
					$actid=$_REQUEST['currentid'];
				}
				else 
				{
					$actid=$_REQUEST['record'];
				}
				$parentid=$_REQUEST['parent_id'];
				if($_REQUEST['module'] != 'Emails' && $_REQUEST['module'] != 'Webmails')
				{
					if(!$parentid) {
						$parentid = $adb->getUniqueID('vtiger_seactivityrel');
					}
					$mysql='insert into vtiger_seactivityrel values(?,?)';
					$adb->pquery($mysql, array($parentid, $actid));
				}
				else
				{	  
					$myids=explode("|",$parentid);  //2@71|
					for ($i=0;$i<(count($myids)-1);$i++)
					{
						$realid=explode("@",$myids[$i]);
						$mycrmid=$realid[0];
						//added to handle the relationship of emails with vtiger_users
						if($realid[1] == -1)
						{
							$del_q = 'delete from vtiger_salesmanactivityrel where smid=? and activityid=?';
                                                        $adb->pquery($del_q,array($mycrmid, $actid));
							$mysql='insert into vtiger_salesmanactivityrel values(?,?)';
						}
						else
						{
							$del_q = 'delete from vtiger_seactivityrel where crmid=? and activityid=?';
							$adb->pquery($del_q,array($mycrmid, $actid));
							$mysql='insert into vtiger_seactivityrel values(?,?)';
						}	
						$params = array($mycrmid, $actid);
						$adb->pquery($mysql, $params);
					}
				}
			}
			else
			{
				if(isset($this->column_fields['parent_id']) && $this->column_fields['parent_id'] != '')
				{
					$this->insertIntoEntityTable('vtiger_seactivityrel', $module);
				}
				elseif($this->column_fields['parent_id']=='' && $insertion_mode=="edit")
				{
					$this->deleteRelation('vtiger_seactivityrel');
				}
			}


			//Insert into cntactivity rel		

			if(isset($this->column_fields['contact_id']) && $this->column_fields['contact_id'] != '')
			{
				$this->insertIntoEntityTable('vtiger_cntactivityrel', $module);
			}
			elseif($this->column_fields['contact_id'] =='' && $insertion_mode=="edit")
			{
				$this->deleteRelation('vtiger_cntactivityrel');
			}
			
			//Inserting into attachment
			
			$this->insertIntoAttachment($this->id,$module);			
		
	}


	function insertIntoAttachment($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");
		
		$file_saved = false;
		
		//Added to send generated Invoice PDF with mail
		$pdfAttached = $_REQUEST['pdf_attachment'];
		//created Invoice pdf is attached with the mail
			if(isset($_REQUEST['pdf_attachment']) && $_REQUEST['pdf_attachment'] !='')
			{
				$file_saved = pdfAttach($this,$module,$pdfAttached,$id);
			}

		//This is to added to store the existing attachment id of the contact where we should delete this when we give new image
		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}
		if($module == 'Emails' && isset($_REQUEST['att_id_list']) && $_REQUEST['att_id_list'] != '')
		{
			$att_lists = explode(";",$_REQUEST['att_id_list'],-1);
			$id_cnt = count($att_lists);
			if($id_cnt != 0)
			{
				for($i=0;$i<$id_cnt;$i++)
				{
					$sql_rel='insert into vtiger_seattachmentsrel values(?,?)';
		                        $adb->pquery($sql_rel, array($id, $att_lists[$i]));
				}
			}			
		}
		if($_REQUEST['att_module'] == 'Webmails')
		{
			require_once("modules/Webmails/Webmails.php");
		        require_once("modules/Webmails/MailParse.php");
		        require_once('modules/Webmails/MailBox.php');
		        //$mailInfo = getMailServerInfo($current_user);
			//$temprow = $adb->fetch_array($mailInfo);

		        $MailBox = new MailBox($_REQUEST["mailbox"]);
		        $mbox = $MailBox->mbox;
		        $webmail = new Webmails($mbox,$_REQUEST['mailid']);
		        $array_tab = Array();
		        $webmail->loadMail($array_tab);
			if(isset($webmail->att_details)){
			foreach($webmail->att_details as $fileindex => $files)
			{
				if($files['name'] != '' && $files['size'] > 0)
				{
					//print_r($files);
					$file_saved = $this->saveForwardAttachments($id,$module,$files);
				}
			}
			}
		}
		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}	
	
	function saveForwardAttachments($id,$module,$file_details)
	{
		global $log;
                $log->debug("Entering into saveForwardAttachments($id,$module,$file_details) method.");
                global $adb, $current_user;
		global $upload_badext;
		require_once('modules/Webmails/MailBox.php');
                $mailbox=$_REQUEST["mailbox"];
		$MailBox = new MailBox($mailbox);
		$mail = $MailBox->mbox;
		$binFile = preg_replace('/\s+/', '_', $file_details['name']);//replace space with _ in filename
                $ext_pos = strrpos($binFile, ".");
                $ext = substr($binFile, $ext_pos + 1);
                if (in_array(strtolower($ext), $upload_badext))
                {
                    $binFile .= ".txt";
                }
		//$filename = basename($binFile);
		$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters 
		$filetype= $file_details['type'];
		$filesize = $file_details['size'];
		$filepart = $file_details['part'];
		$transfer = $file_details['transfer'];
		$file = imap_fetchbody($mail,$_REQUEST['mailid'],$filepart);
		if ($transfer == 'BASE64')
			    $file = imap_base64($file);
		elseif($transfer == 'QUOTED-PRINTABLE')
			    $file = imap_qprint($file);
		$current_id = $adb->getUniqueID("vtiger_crmentity");
		$date_var = date('Y-m-d H:i:s');
		//to get the owner id
		$ownerid = $this->column_fields['assigned_user_id'];
		if(!isset($ownerid) || $ownerid=='')
			$ownerid = $current_user->id;
		$upload_file_path = decideFilePath();
		file_put_contents ($upload_file_path.$current_id."_".$filename,$file);
		
                        $sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?,?,?,?,?,?,?)";
                        $params1 = array($current_id, $current_user->id, $ownerid, $module." Attachment", $this->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
						$adb->pquery($sql1, $params1);
						
                        $sql2="insert into vtiger_attachments(attachmentsid, name, description, type, path) values(?,?,?,?,?)";
                        $params2 = array($current_id, $filename, $this->column_fields['description'], $filetype, $upload_file_path);
						$result=$adb->pquery($sql2, $params2);
						
                        if($_REQUEST['mode'] == 'edit')
                        {
                        	if($id != '' && $_REQUEST['fileid'] != '')
                            {
                                $delquery = 'delete from vtiger_seattachmentsrel where crmid = ? and attachmentsid = ?';
		                        $adb->pquery($delquery, array($id, $_REQUEST['fileid']));
			        		}
						}
                        $sql3='insert into vtiger_seattachmentsrel values(?,?)';
                        $adb->pquery($sql3, array($id, $current_id));
                        return true;
		$log->debug("exiting from  saveforwardattachment function.");
	}
	/** Returns a list of the associated contacts
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_contacts($id)
	{
		global $log,$adb;
		$log->debug("Entering get_contacts(".$id.") method ...");
		global $mod_strings;
		global $app_strings;

		$focus = new Contacts();

		$button = '';
		$returnset = '&return_module=Emails&return_action=CallRelatedList&return_id='.$id;

		$query = 'select vtiger_contactdetails.accountid, vtiger_contactdetails.contactid, vtiger_contactdetails.firstname,vtiger_contactdetails.lastname, vtiger_contactdetails.department, vtiger_contactdetails.title, vtiger_contactdetails.email, vtiger_contactdetails.phone, vtiger_contactdetails.emailoptout, vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.modifiedtime from vtiger_contactdetails inner join vtiger_cntactivityrel on vtiger_cntactivityrel.contactid=vtiger_contactdetails.contactid inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid where vtiger_cntactivityrel.activityid='.$adb->quote($id).' and vtiger_crmentity.deleted=0';
		$log->info("Contact Related List for Email is Displayed");
		$log->debug("Exiting get_contacts method ...");
		return GetRelatedList('Emails','Contacts',$focus,$query,$button,$returnset);
	}
	
	/** Returns the column name that needs to be sorted
	 * Portions created by vtigerCRM are Copyright (C) vtigerCRM.
	 * All Rights Reserved..
	 * Contributor(s): Mike Crowe
	*/

	function getSortOrder()
	{	
		global $log;
		$log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder'])) 
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['EMAILS_SORT_ORDER'] != '')?($_SESSION['EMAILS_SORT_ORDER']):($this->default_sort_order));

		$log->debug("Exiting getSortOrder method ...");
		return $sorder;
	}

	/** Returns the order in which the records need to be sorted
	 * Portions created by vtigerCRM are Copyright (C) vtigerCRM.
	 * All Rights Reserved..
	 * Contributor(s): Mike Crowe
	*/

	function getOrderBy()
	{
		global $log;
		$log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['EMAILS_ORDER_BY'] != '')?($_SESSION['EMAILS_ORDER_BY']):($this->default_order_by));

		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}	
	// Mike Crowe Mod --------------------------------------------------------

	/** Returns a list of the associated vtiger_users
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_users($id)
	{
		global $log;
		$log->debug("Entering get_users(".$id.") method ...");
		global $adb;
		global $mod_strings;
		global $app_strings;

		$id = $_REQUEST['record'];

		$query = 'SELECT vtiger_users.id, vtiger_users.first_name,vtiger_users.last_name, vtiger_users.user_name, vtiger_users.email1, vtiger_users.email2, vtiger_users.yahoo_id, vtiger_users.phone_home, vtiger_users.phone_work, vtiger_users.phone_mobile, vtiger_users.phone_other, vtiger_users.phone_fax from vtiger_users inner join vtiger_salesmanactivityrel on vtiger_salesmanactivityrel.smid=vtiger_users.id and vtiger_salesmanactivityrel.activityid=?';
		$result=$adb->pquery($query, array($id));   

		$noofrows = $adb->num_rows($result);
		$header [] = $app_strings['LBL_LIST_NAME'];

		$header []= $app_strings['LBL_LIST_USER_NAME'];

		$header []= $app_strings['LBL_EMAIL'];

		$header []= $app_strings['LBL_PHONE'];
		while($row = $adb->fetch_array($result))
		{

			global $current_user;

			$entries = Array();

			if(is_admin($current_user))
			{
				$entries[] = $row['last_name'].' '.$row['first_name'];
			}
			else
			{
				$entries[] = $row['last_name'].' '.$row['first_name'];
			}		

			$entries[] = $row['user_name'];
			$entries[] = $row['email1'];
			if($email == '')        $email = $row['email2'];
			if($email == '')        $email = $row['yahoo_id'];

			$entries[] = $row['phone_home'];
			if($phone == '')        $phone = $row['phone_work'];
			if($phone == '')        $phone = $row['phone_mobile'];
			if($phone == '')        $phone = $row['phone_other'];
			if($phone == '')        $phone = $row['phone_fax'];

			//Adding Security Check for User

			$entries_list[] = $entries;
		}

		if($entries_list != '')
			$return_data = array("header"=>$header, "entries"=>$entries);
		$log->debug("Exiting get_users method ...");
		return $return_data;
	}

	
        /**
          * Returns a list of the Emails to be exported
          */
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		global $current_user;
		$log->debug("Entering create_export_query(".$order_by.",".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Emails", "detail_view");
		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list FROM vtiger_activity 
			INNER JOIN vtiger_crmentity 
				ON vtiger_crmentity.crmid=vtiger_activity.activityid 
			LEFT JOIN vtiger_users
				ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_seactivityrel
				ON vtiger_seactivityrel.activityid = vtiger_activity.activityid
			LEFT JOIN vtiger_contactdetails
				ON vtiger_contactdetails.contactid = vtiger_seactivityrel.crmid
			LEFT JOIN vtiger_cntactivityrel
				ON vtiger_cntactivityrel.activityid = vtiger_activity.activityid
				AND vtiger_cntactivityrel.contactid = vtiger_cntactivityrel.contactid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_salesmanactivityrel
				ON vtiger_salesmanactivityrel.activityid = vtiger_activity.activityid
			LEFT JOIN vtiger_emaildetails
				ON vtiger_emaildetails.emailid = vtiger_activity.activityid
			LEFT JOIN vtiger_seattachmentsrel 
				ON vtiger_activity.activityid=vtiger_seattachmentsrel.crmid 
			LEFT JOIN vtiger_attachments 
				ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid 
			WHERE vtiger_activity.activitytype='Emails' AND vtiger_crmentity.deleted=0 ";

		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		//we should add security check when the user has Private Access

		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1)
		{
			$sec_parameter=getListViewSecurityParameter("Emails");
			$query .= $sec_parameter;	
		}

		$log->debug("Exiting create_export_query method ...");
                return $query;
        }
        
	/**
	* Used to releate email and contacts -- Outlook Plugin
	*/  
	function set_emails_contact_invitee_relationship($email_id, $contact_id)
	{
		global $log;
		$log->debug("Entering set_emails_contact_invitee_relationship(".$email_id.",". $contact_id.") method ...");
		$query = "insert into $this->rel_contacts_table (contactid,activityid) values(?,?)";
		$this->db->pquery($query, array($contact_id, $email_id), true,"Error setting email to contact relationship: "."<BR>$query");
		$log->debug("Exiting set_emails_contact_invitee_relationship method ...");
	}
     
	/**
	* Used to releate email and salesentity -- Outlook Plugin
	*/
	function set_emails_se_invitee_relationship($email_id, $contact_id)
	{
		global $log;
		$log->debug("Entering set_emails_se_invitee_relationship(".$email_id.",". $contact_id.") method ...");
		$query = "insert into $this->rel_serel_table (crmid,activityid) values(?,?)";
		$this->db->pquery($query, array($contact_id, $email_id), true,"Error setting email to contact relationship: "."<BR>$query");
		$log->debug("Exiting set_emails_se_invitee_relationship method ...");
	}
     
	/**
	* Used to releate email and Users -- Outlook Plugin
	*/    
	function set_emails_user_invitee_relationship($email_id, $user_id)
	{
		global $log;
		$log->debug("Entering set_emails_user_invitee_relationship(".$email_id.",". $user_id.") method ...");
		$query = "insert into $this->rel_users_table (smid,activityid) values (?,?)";
		$this->db->pquery($query, array($user_id, $email_id), true,"Error setting email to user relationship: "."<BR>$query");
		$log->debug("Exiting set_emails_user_invitee_relationship method ...");
	}
	
	// Function to unlink an entity with given Id from another entity
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		
		$sql='DELETE FROM vtiger_seactivityrel WHERE activityid=?';
		$this->db->pquery($sql, array($id));
			
		$sql = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
		$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
		$this->db->pquery($sql, $params);
	}
}
/** Function to get the emailids for the given ids form the request parameters 
 *  It returns an array which contains the mailids and the parentidlists
*/

function get_to_emailids($module)
{
	global $adb;
	if(isset($_REQUEST["field_lists"]) && $_REQUEST["field_lists"] != "")
	{
		$field_lists = $_REQUEST["field_lists"];
		if (is_string($field_lists)) $field_lists = explode(":", $field_lists);
		$query = 'select columnname,fieldid from vtiger_field where fieldid in ('. generateQuestionMarks($field_lists) .') and vtiger_field.presence in (0,2)';
		$result = $adb->pquery($query, array($field_lists));
		$columns = Array();
		$idlists = '';
		$mailids = '';
		while($row = $adb->fetch_array($result))
    		{
			$columns[]=$row['columnname'];
			$fieldid[]=$row['fieldid'];
		}
		$columnlists = implode(',',$columns);
		$idstring = $_REQUEST["idlist"];
                $single_record = false;
		if(!strpos($idstring,':'))
		{
			$single_record = true;
		}
		$crmids = ereg_replace(':',',',$idstring);
		$crmids = explode(",", $crmids);
		switch($module)
		{
			case 'Leads':
				$query = 'select crmid,concat(lastname," ",firstname) as entityname,'.$columnlists.' from vtiger_leaddetails inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_leaddetails.leadid left join vtiger_leadscf on vtiger_leadscf.leadid = vtiger_leaddetails.leadid where vtiger_crmentity.deleted=0 and ((ltrim(vtiger_leaddetails.email) != \'\') or (ltrim(vtiger_leaddetails.yahooid) != \'\')) and vtiger_crmentity.crmid in ('. generateQuestionMarks($crmids) .')';
				break;
			case 'Contacts':
				//email opt out funtionality works only when we do mass mailing.
				if(!$single_record)
				$concat_qry = '(((ltrim(vtiger_contactdetails.email) != \'\')  or (ltrim(vtiger_contactdetails.yahooid) != \'\')) and (vtiger_contactdetails.emailoptout != 1)) and ';
				else
				$concat_qry = '((ltrim(vtiger_contactdetails.email) != \'\')  or (ltrim(vtiger_contactdetails.yahooid) != \'\')) and ';
				$query = 'select crmid,concat(lastname," ",firstname) as entityname,'.$columnlists.' from vtiger_contactdetails inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_contactdetails.contactid left join vtiger_contactscf on vtiger_contactscf.contactid = vtiger_contactdetails.contactid where vtiger_crmentity.deleted=0 and '.$concat_qry.'  vtiger_crmentity.crmid in ('. generateQuestionMarks($crmids) .')';
				break;
			case 'Accounts':
				//added to work out email opt out functionality.
				if(!$single_record)
					$concat_qry = '(((ltrim(vtiger_account.email1) != \'\') or (ltrim(vtiger_account.email2) != \'\')) and (vtiger_account.emailoptout != 1)) and ';
				else
					$concat_qry = '((ltrim(vtiger_account.email1) != \'\') or (ltrim(vtiger_account.email2) != \'\')) and ';
					
				$query = 'select crmid,accountname as entityname,'.$columnlists.' from vtiger_account inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_account.accountid left join vtiger_accountscf on vtiger_accountscf.accountid = vtiger_account.accountid where vtiger_crmentity.deleted=0 and '.$concat_qry.' vtiger_crmentity.crmid in ('. generateQuestionMarks($crmids) .')';
				break;
		}
		$result = $adb->pquery($query, array($crmids));
		while($row = $adb->fetch_array($result))
		{
			$name = $row['entityname'];
			for($i=0;$i<count($columns);$i++)
			{
				if($row[$columns[$i]] != NULL && $row[$columns[$i]] !='')
				{
					$idlists .= $row['crmid'].'@'.$fieldid[$i].'|'; 
					$mailids .= $name.'<'.$row[$columns[$i]].'>,';	
				}
			}
		}

		$return_data = Array('idlists'=>$idlists,'mailds'=>$mailids);
	}else
	{
		$return_data = Array('idlists'=>"",'mailds'=>"");
	}	
	return $return_data;
		
}

//added for attach the generated pdf with email
function pdfAttach($obj,$module,$file_name,$id)
{
	global $log;
	$log->debug("Entering into pdfAttach() method.");

	global $adb, $current_user;
	global $upload_badext;
	$date_var = date('Y-m-d H:i:s');

	$ownerid = $obj->column_fields['assigned_user_id'];
	if(!isset($ownerid) || $ownerid=='')
		$ownerid = $current_user->id;

	$current_id = $adb->getUniqueID("vtiger_crmentity");

	$upload_file_path = decideFilePath();

	//Copy the file from temporary directory into storage directory for upload
	$status = copy("storage/".$file_name,$upload_file_path.$current_id."_".$file_name);
	//Check wheather the copy process is completed successfully or not. if failed no need to put entry in attachment table
	if($status)
	{
		$query1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?,?,?,?,?,?,?)";
		$params1 = array($current_id, $current_user->id, $ownerid, $module." Attachment", $obj->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
		$adb->pquery($query1, $params1);

		$query2="insert into vtiger_attachments(attachmentsid, name, description, type, path) values(?,?,?,?,?)";
		$params2 = array($current_id, $file_name, $obj->column_fields['description'], 'pdf', $upload_file_path);
		$result=$adb->pquery($query2, $params2);

		$query3='insert into vtiger_seattachmentsrel values(?,?)';
		$adb->pquery($query3, array($id, $current_id));

		return true;
	}
	else
	{
		$log->debug("pdf not attached");
		return false;
	}
}


?>
