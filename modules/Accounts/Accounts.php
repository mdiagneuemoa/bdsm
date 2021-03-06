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
 * $Header: /cvs/repository/siprodPCCI/modules/Accounts/Accounts.php,v 1.1 2010/01/15 18:42:49 isene Exp $
 * Description:  Defines the Account SugarBean Account entity with the necessary
 * methods and variables.
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
require_once('modules/Potentials/Potentials.php');
require_once('modules/Calendar/Activity.php');
require_once('modules/Documents/Documents.php');
require_once('modules/Emails/Emails.php');
require_once('include/utils/utils.php');
require_once('user_privileges/default_module_view.php');

// Account is used to store vtiger_account information.
class Accounts extends CRMEntity {
	var $log;
	var $db;
	var $table_name = "vtiger_account";
	var $table_index= 'accountid';
	var $tab_name = Array('vtiger_crmentity','vtiger_account','vtiger_accountbillads','vtiger_accountshipads','vtiger_accountscf');
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_account'=>'accountid','vtiger_accountbillads'=>'accountaddressid','vtiger_accountshipads'=>'accountaddressid','vtiger_accountscf'=>'accountid');
	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_accountscf', 'accountid');
	var $entity_table = "vtiger_crmentity";

	var $column_fields = Array();

	var $sortby_fields = Array('accountname','bill_city','website','phone','smownerid');		

	//var $groupTable = Array('vtiger_accountgrouprelation','accountid');
	
	// This is the list of vtiger_fields that are in the lists.
	var $list_fields = Array(
			'Account Name'=>Array('vtiger_account'=>'accountname'),
			'Billing City'=>Array('vtiger_accountbillads'=>'bill_city'), 
			'Website'=>Array('vtiger_account'=>'website'),
			'Phone'=>Array('vtiger_account'=> 'phone'),
			'Assigned To'=>Array('vtiger_crmentity'=>'smownerid')
			);

	var $list_fields_name = Array(
			'Account Name'=>'accountname',
			'Billing City'=>'bill_city',
			'Website'=>'website',
			'Phone'=>'phone',
			'Assigned To'=>'assigned_user_id'
			);
	var $list_link_field= 'accountname';

	var $search_fields = Array(
			'Account Name'=>Array('vtiger_account'=>'accountname'),
			'Billing City'=>Array('vtiger_accountbillads'=>'bill_city'), 
			);

	var $search_fields_name = Array(
			'Account Name'=>'accountname',
			'Billing City'=>'bill_city',
			);
	// This is the list of vtiger_fields that are required
	var $required_fields =  array();
	
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('assigned_user_id', 'createdtime', 'modifiedtime', 'accountname');
	
	//Default Fields for Email Templates -- Pavani
	var $emailTemplate_defaultFields = array('accountname','account_type','industry','annualrevenue','phone','email1','rating','website','fax');
	
	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'accountname';
	var $default_sort_order = 'ASC';
	
	function Accounts() {
		$this->log =LoggerManager::getLogger('account');
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('Accounts');
		$this->initRequiredFields("Accounts");
	}

	/** Function to handle module specific operations when saving a entity 
	*/
	function save_module($module) {
		
	}


	// Mike Crowe Mod --------------------------------------------------------Default ordering for us
	/**
	 * Function to get sort order
 	 * return string  $sorder    - sortorder string either 'ASC' or 'DESC'
	 */
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");	
		if(isset($_REQUEST['sorder'])) 
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['ACCOUNTS_SORT_ORDER'] != '')?($_SESSION['ACCOUNTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}
	/**
	 * Function to get order by
	 * return string  $order_by    - fieldname(eg: 'accountname')
 	 */
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['ACCOUNTS_ORDER_BY'] != '')?($_SESSION['ACCOUNTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}	
	// Mike Crowe Mod --------------------------------------------------------


	/** Returns a list of the associated contacts
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_contacts($id)
	{	
		global $log, $singlepane_view;
                $log->debug("Entering get_contacts(".$id.") method ...");
		global $mod_strings;

		$focus = new Contacts();

		$button = '';
		if(isPermitted("Contacts",1,"") == 'yes')
		{
			$button .= '<input title="New Contact" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Contacts\'" type="submit" name="button" value="'.$mod_strings['LBL_NEW_CONTACT'].'">&nbsp;</td>';
		}

		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		//SQL
		$query = "SELECT vtiger_contactdetails.*,vtiger_contactscf.*,
			vtiger_crmentity.crmid,
                        vtiger_crmentity.smownerid,
			vtiger_account.accountname,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name
			FROM vtiger_contactdetails
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
			INNER JOIN vtiger_contactscf
				ON vtiger_contactscf.contactid = vtiger_contactdetails.contactid
			LEFT JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_contactdetails.accountid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_contactdetails.accountid = ".$id;
		$log->debug("Exiting get_contacts method ...");
		return GetRelatedList('Accounts','Contacts',$focus,$query,$button,$returnset);
	}

	/** Returns a list of the associated opportunities
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_opportunities($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_opportunities(".$id.") method ...");
		global $mod_strings;

		$focus = new Potentials();
		$button = '';

		if(isPermitted("Potentials",1,"") == 'yes')
		{
			$button .= '<input title="New Potential" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Potentials\'" type="submit" name="button" value="'.$mod_strings['LBL_NEW_POTENTIAL'].'">';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_potential.potentialid, vtiger_potential.accountid,
			vtiger_potential.potentialname, vtiger_potential.sales_stage,
			vtiger_potential.potentialtype, vtiger_potential.amount,
			vtiger_potential.closingdate, vtiger_potential.potentialtype, vtiger_account.accountname,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,vtiger_crmentity.crmid, vtiger_crmentity.smownerid,
			vtiger_potentialscf.*
			FROM vtiger_potential
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_potential.potentialid
			INNER JOIN vtiger_potentialscf
				ON vtiger_potentialscf.potentialid = vtiger_potential.potentialid
			LEFT JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_potential.accountid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_potential.accountid = ".$id;
		$log->debug("Exiting get_opportunities method ...");

		return GetRelatedList('Accounts','Potentials',$focus,$query,$button,$returnset);
	}

	/** Returns a list of the associated tasks
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_activities($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_activities(".$id.") method ...");
		global $mod_strings;

		$focus = new Activity();
		$button = '';
		if(isPermitted("Calendar",1,"") == 'yes')
		{

			$button .= '<input title="New Task" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.return_action.value=\'DetailView\';this.form.module.value=\'Calendar\';this.form.return_module.value=\'Accounts\';this.form.activity_mode.value=\'Task\'" type="submit" name="button" value="'.$mod_strings['LBL_NEW_TASK'].'">&nbsp;';
			$button .= '<input title="New Event" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.return_action.value=\'DetailView\';this.form.module.value=\'Calendar\';this.form.return_module.value=\'Accounts\';this.form.activity_mode.value=\'Events\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_EVENT'].'">&nbsp;</td>';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_activity.*, vtiger_cntactivityrel.*,
			vtiger_seactivityrel.*, vtiger_contactdetails.lastname,
			vtiger_contactdetails.firstname,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid,
			vtiger_crmentity.modifiedtime,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
			vtiger_recurringevents.recurringtype
			FROM vtiger_activity
			INNER JOIN vtiger_seactivityrel
				ON vtiger_seactivityrel.activityid = vtiger_activity.activityid
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_activity.activityid
			LEFT JOIN vtiger_cntactivityrel
				ON vtiger_cntactivityrel.activityid = vtiger_activity.activityid
			LEFT JOIN vtiger_contactdetails
		       		ON vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid
			LEFT JOIN vtiger_users
				ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT OUTER JOIN vtiger_recurringevents
				ON vtiger_recurringevents.activityid = vtiger_activity.activityid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_seactivityrel.crmid = ".$id."
			AND vtiger_crmentity.deleted = 0
			AND ((vtiger_activity.activitytype='Task' and vtiger_activity.status not in ('Completed','Deferred')) 
			OR (vtiger_activity.activitytype not in ('Emails','Task') and  vtiger_activity.eventstatus not in ('','Held'))) ";
		$log->debug("Exiting get_activities method ...");
		return GetRelatedList('Accounts','Calendar',$focus,$query,$button,$returnset);

	}
	/**
	 * Function to get Account related Task & Event which have activity type Held, Completed or Deferred.
 	 * @param  integer   $id      - accountid
 	 * returns related Task or Event record in array format
 	 */
	function get_history($id)
	{
		global $log;
                $log->debug("Entering get_history(".$id.") method ...");
		$query = "SELECT vtiger_activity.activityid, vtiger_activity.subject,
			vtiger_activity.status, vtiger_activity.eventstatus,
			vtiger_activity.activitytype, vtiger_activity.date_start, vtiger_activity.due_date,
			vtiger_activity.time_start, vtiger_activity.time_end,
			vtiger_crmentity.modifiedtime, vtiger_crmentity.createdtime,
			vtiger_crmentity.description,case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name
			FROM vtiger_activity
			INNER JOIN vtiger_seactivityrel
				ON vtiger_seactivityrel.activityid = vtiger_activity.activityid
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_activity.activityid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_users.id=vtiger_crmentity.smownerid
			WHERE (vtiger_activity.activitytype = 'Meeting'
				OR vtiger_activity.activitytype = 'Call'
				OR vtiger_activity.activitytype = 'Task')
			AND (vtiger_activity.status = 'Completed'
				OR vtiger_activity.status = 'Deferred'
				OR (vtiger_activity.eventstatus = 'Held'
					AND vtiger_activity.eventstatus != ''))
			AND vtiger_seactivityrel.crmid = ".$id."
			AND vtiger_crmentity.deleted = 0";
		//Don't add order by, because, for security, one more condition will be added with this query in include/RelatedListView.php
		$log->debug("Exiting get_history method ...");
		return getHistory('Accounts',$query,$id);
	}

	/** Returns a list of the associated emails
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	*/
	function get_emails($id)
	{
		global $log, $singlepane_view;
		$log->debug("Entering get_emails(".$id.") method ...");
		global $mod_strings;

		$focus = new Emails();

		$button = '';

		if(isPermitted("Emails",1,"") == 'yes')
		{
						$button .= '<input title="New Email" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Emails\';this.form.email_directing_module.value=\'accounts\';this.form.record.value='.$id.';this.form.return_action.value=\'DetailView\'" type="submit" name="button" value="'.$mod_strings['LBL_NEW_EMAIL'].'">';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$log->info("Email Related List for Account Displayed");
		$query = "SELECT case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
			vtiger_activity.activityid, vtiger_activity.subject,
			vtiger_activity.activitytype, vtiger_crmentity.modifiedtime,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_activity.date_start, vtiger_seactivityrel.crmid as parent_id 
			FROM vtiger_activity, vtiger_seactivityrel, vtiger_account, vtiger_users, vtiger_crmentity
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid=vtiger_crmentity.smownerid
			WHERE vtiger_seactivityrel.activityid = vtiger_activity.activityid
				AND vtiger_account.accountid = vtiger_seactivityrel.crmid
				AND vtiger_users.id=vtiger_crmentity.smownerid
				AND vtiger_crmentity.crmid = vtiger_activity.activityid
				AND vtiger_account.accountid = ".$id."
				AND vtiger_activity.activitytype='Emails'
				AND vtiger_crmentity.deleted = 0";
		$log->debug("Exiting get_emails method ...");
		return GetRelatedList('Accounts','Emails',$focus,$query,$button,$returnset);
	}	

	
	/**
	* Function to get Account related Quotes
	* @param  integer   $id      - accountid
	* returns related Quotes record in array format
	*/
	function get_quotes($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_quotes(".$id.") method ...");
		global $app_strings;
		require_once('modules/Quotes/Quotes.php');

		$focus = new Quotes();

		$button = '';
		if(isPermitted("Quotes",1,"") == 'yes')
		{
			$button .= '<input title="'.$app_strings['LBL_NEW_QUOTE_BUTTON_TITLE'].'" accessyKey="'.$app_strings['LBL_NEW_QUOTE_BUTTON_KEY'].'" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Quotes\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_QUOTE_BUTTON'].'">&nbsp;</td>';
		}

		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
			vtiger_crmentity.*,
			vtiger_quotes.*,
			vtiger_potential.potentialname,
			vtiger_account.accountname
			FROM vtiger_quotes
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_quotes.quoteid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_quotes.accountid
			LEFT OUTER JOIN vtiger_potential
				ON vtiger_potential.potentialid = vtiger_quotes.potentialid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_account.accountid = ".$id;
		$log->debug("Exiting get_quotes method ...");
		return GetRelatedList('Accounts','Quotes',$focus,$query,$button,$returnset);
	}
	/**
	* Function to get Account related Invoices 
	* @param  integer   $id      - accountid
	* returns related Invoices record in array format
	*/
	function get_invoices($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_invoices(".$id.") method ...");
		global $app_strings;
		require_once('modules/Invoice/Invoice.php');

		$focus = new Invoice();

		$button = '';
		if(isPermitted("Invoice",1,"") == 'yes')
		{
			$button .= '<input title="'.$app_strings['LBL_NEW_INVOICE_BUTTON_TITLE'].'" accessyKey="'.$app_strings['LBL_NEW_INVOICE_BUTTON_KEY'].'" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Invoice\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_INVOICE_BUTTON'].'">&nbsp;</td>';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
			vtiger_crmentity.*,
			vtiger_invoice.*,
			vtiger_account.accountname,
			vtiger_salesorder.subject AS salessubject
			FROM vtiger_invoice
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_invoice.invoiceid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_invoice.accountid
			LEFT OUTER JOIN vtiger_salesorder
				ON vtiger_salesorder.salesorderid = vtiger_invoice.salesorderid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_account.accountid = ".$id;
		$log->debug("Exiting get_invoices method ...");
		return GetRelatedList('Accounts','Invoice',$focus,$query,$button,$returnset);
	}

	/**
	* Function to get Account related SalesOrder 
	* @param  integer   $id      - accountid
	* returns related SalesOrder record in array format
	*/
	function get_salesorder($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_salesorder(".$id.") method ...");
		require_once('modules/SalesOrder/SalesOrder.php');
		global $app_strings;

		$focus = new SalesOrder();

		$button = '';
		if(isPermitted("SalesOrder",1,"") == 'yes')
		{
			$button .= '<input title="'.$app_strings['LBL_NEW_SORDER_BUTTON_TITLE'].'" accessyKey="'.$app_strings['LBL_NEW_SORDER_BUTTON_KEY'].'" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'SalesOrder\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_SORDER_BUTTON'].'">&nbsp;</td>';
		}

		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_crmentity.*,
			vtiger_salesorder.*,
			vtiger_quotes.subject AS quotename,
			vtiger_account.accountname,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name
			FROM vtiger_salesorder
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_salesorder.salesorderid
			LEFT OUTER JOIN vtiger_quotes
				ON vtiger_quotes.quoteid = vtiger_salesorder.quoteid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_salesorder.accountid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_salesorder.accountid = ".$id;
		$log->debug("Exiting get_salesorder method ...");		
		return GetRelatedList('Accounts','SalesOrder',$focus,$query,$button,$returnset);
	}
	/**
	* Function to get Account related Tickets
	* @param  integer   $id      - accountid
	* returns related Ticket record in array format
	*/
	function get_tickets($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_tickets(".$id.") method ...");
		global $app_strings;

		$focus = new HelpDesk();
		$button = '';

		if(isPermitted('HelpDesk',1, '') == 'yes')
			$button .= '<input title="'.getTranslatedString('LBL_ADD_NEW').' '.getTranslatedString('Ticket').'" accessyKey="F" class="crmbutton small create"
				 onclick="this.form.action.value=\'EditView\';this.form.module.value=\'HelpDesk\'" type="submit" name="button" value="'.getTranslatedString('LBL_ADD_NEW').' '.getTranslatedString('Ticket').'"></td>';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_users.id,
			vtiger_troubletickets.title, vtiger_troubletickets.ticketid AS crmid,
			vtiger_troubletickets.status, vtiger_troubletickets.priority,
			vtiger_troubletickets.parent_id, vtiger_troubletickets.ticket_no,
			vtiger_crmentity.smownerid, vtiger_crmentity.modifiedtime
			FROM vtiger_troubletickets
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid
			LEFT JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_troubletickets.parent_id
			LEFT JOIN vtiger_contactdetails
			        ON vtiger_contactdetails.contactid=vtiger_troubletickets.parent_id
			LEFT JOIN vtiger_users
				ON vtiger_users.id=vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE  vtiger_crmentity.deleted = 0 and ( vtiger_troubletickets.parent_id=".$id." or " ;

		$query .= " vtiger_troubletickets.parent_id in(SELECT vtiger_contactdetails.contactid
			FROM vtiger_contactdetails
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_crmentity.smownerid = vtiger_users.id
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_contactdetails.accountid = ".$id;

			
		//Appending the security parameter
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		$tab_id=getTabid('Contacts');
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[$tab_id] == 3)
		{
			$sec_parameter=getListViewSecurityParameter('Contacts');
			$query .= ' '.$sec_parameter;

		}

		$query .= ") )";
		
		$log->debug("Exiting get_tickets method ...");
		$return_value = GetRelatedList('Accounts','HelpDesk',$focus,$query,$button,$returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		
		return $return_value;
	}
	/**
	* Function to get Account related Products 
	* @param  integer   $id      - accountid
	* returns related Products record in array format
	*/
	function get_products($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_products(".$id.") method ...");
		require_once('modules/Products/Products.php');
		global $app_strings;

		$focus = new Products();

		$button = '';

		if(isPermitted("Products",1,"") == 'yes')
		{


			$button .= '<input title="New Product" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Products\';this.form.return_module.value=\'Accounts\';this.form.return_action.value=\'DetailView\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_PRODUCT'].'">&nbsp;';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_products.productid, vtiger_products.productname,
			vtiger_products.productcode, vtiger_products.commissionrate,
			vtiger_products.qty_per_unit, vtiger_products.unit_price,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid
			FROM vtiger_products
			INNER JOIN vtiger_seproductsrel ON vtiger_products.productid = vtiger_seproductsrel.productid and vtiger_seproductsrel.setype='Accounts'
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid
			INNER JOIN vtiger_account ON vtiger_account.accountid = vtiger_seproductsrel.crmid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_account.accountid = $id";

		$log->debug("Exiting get_products method ...");
		return GetRelatedList('Accounts','Products',$focus,$query,$button,$returnset);
	}

	/** Function to export the account records in CSV Format
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export Accounts Query.
	*/
	function create_export_query($where)
	{
		global $log;
		global $current_user;
                $log->debug("Entering create_export_query(".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Accounts", "detail_view");
		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list, vtiger_groups.groupname as 'Assigned To Group',case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name 
	       			FROM ".$this->entity_table."
				INNER JOIN vtiger_account
					ON vtiger_account.accountid = vtiger_crmentity.crmid
				LEFT JOIN vtiger_accountbillads
					ON vtiger_accountbillads.accountaddressid = vtiger_account.accountid
				LEFT JOIN vtiger_accountshipads
					ON vtiger_accountshipads.accountaddressid = vtiger_account.accountid
				LEFT JOIN vtiger_accountscf
					ON vtiger_accountscf.accountid = vtiger_account.accountid
	                        LEFT JOIN vtiger_groups
                        	        ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users
					ON vtiger_users.id = vtiger_crmentity.smownerid and vtiger_users.status = 'Active'
				LEFT JOIN vtiger_account vtiger_account2 
					ON vtiger_account2.accountid = vtiger_account.parentid
				";//vtiger_account2 is added to get the Member of account


		$where_auto = " vtiger_crmentity.deleted = 0 ";

		if($where != "")
			$query .= " WHERE ($where) AND ".$where_auto;
		else
			$query .= " WHERE ".$where_auto;

		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
		//we should add security check when the user has Private Access
		if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[6] == 3)
		{
			//Added security check to get the permitted records only
			$query = $query." ".getListViewSecurityParameter("Accounts");
		}

		$log->debug("Exiting create_export_query method ...");
		return $query;
	}

	/** Function to get the Columnnames of the Account Record
	* Used By vtigerCRM Word Plugin
	* Returns the Merge Fields for Word Plugin
	*/
	function getColumnNames_Acnt()
	{
		global $log,$current_user;
		$log->debug("Entering getColumnNames_Acnt() method ...");
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0)
		{
			$sql1 = "SELECT fieldlabel FROM vtiger_field WHERE tabid = 6 and vtiger_field.presence in (0,2)";
			$params1 = array();
		}else
		{
			$profileList = getCurrentUserProfileList();
			$sql1 = "select vtiger_field.fieldid,fieldlabel from vtiger_field INNER JOIN vtiger_profile2field on vtiger_profile2field.fieldid=vtiger_field.fieldid inner join vtiger_def_org_field on vtiger_def_org_field.fieldid=vtiger_field.fieldid where vtiger_field.tabid=6 and vtiger_field.displaytype in (1,2,4) and vtiger_profile2field.visible=0 and vtiger_def_org_field.visible=0 and vtiger_field.presence in (0,2)";
			$params1 = array();
			if (count($profileList) > 0) {
				$sql1 .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")  group by fieldid";
			    array_push($params1,  $profileList);
			}
		} 
		$result = $this->db->pquery($sql1, $params1);
		$numRows = $this->db->num_rows($result);
		for($i=0; $i < $numRows;$i++)
		{
			$custom_fields[$i] = $this->db->query_result($result,$i,"fieldlabel");
			$custom_fields[$i] = ereg_replace(" ","",$custom_fields[$i]);
			$custom_fields[$i] = strtoupper($custom_fields[$i]);
		}
		$mergeflds = $custom_fields;
		$log->debug("Exiting getColumnNames_Acnt method ...");
		return $mergeflds;
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
		
		$rel_table_arr = Array("Contacts"=>"vtiger_contactdetails","Potentials"=>"vtiger_potential","Quotes"=>"vtiger_quotes",
					"SalesOrder"=>"vtiger_salesorder","Invoice"=>"vtiger_invoice","Activities"=>"vtiger_seactivityrel",
					"Documents"=>"vtiger_senotesrel","Attachments"=>"vtiger_seattachmentsrel","HelpDesk"=>"vtiger_troubletickets",
					"Products"=>"vtiger_seproductsrel");
		
		$tbl_field_arr = Array("vtiger_contactdetails"=>"contactid","vtiger_potential"=>"potentialid","vtiger_quotes"=>"quoteid",
					"vtiger_salesorder"=>"salesorderid","vtiger_invoice"=>"invoiceid","vtiger_seactivityrel"=>"activityid",
					"vtiger_senotesrel"=>"notesid","vtiger_seattachmentsrel"=>"attachmentsid","vtiger_troubletickets"=>"ticketid",
					"vtiger_seproductsrel"=>"productid");	
		
		$entity_tbl_field_arr = Array("vtiger_contactdetails"=>"accountid","vtiger_potential"=>"accountid","vtiger_quotes"=>"accountid",
					"vtiger_salesorder"=>"accountid","vtiger_invoice"=>"accountid","vtiger_seactivityrel"=>"crmid",
					"vtiger_senotesrel"=>"crmid","vtiger_seattachmentsrel"=>"crmid","vtiger_troubletickets"=>"parent_id",
					"vtiger_seproductsrel"=>"crmid");	
		
		foreach($transferEntityIds as $transferId) {
			foreach($rel_table_arr as $rel_module=>$rel_table) {
				$id_field = $tbl_field_arr[$rel_table];
				$entity_id_field = $entity_tbl_field_arr[$rel_table];
				// IN clause to avoid duplicate entries
				$sel_result =  $adb->pquery("select $id_field from $rel_table where $entity_id_field=? " .
						" and $id_field not in (select $id_field from $rel_table where $entity_id_field=?)",
						array($transferId,$entityId));
				$res_cnt = $adb->num_rows($sel_result);
				if($res_cnt > 0) {
					for($i=0;$i<$res_cnt;$i++) {
						$id_field_value = $adb->query_result($sel_result,$i,$id_field);
						$adb->pquery("update $rel_table set $entity_id_field=? where $entity_id_field=? and $id_field=?", 
							array($entityId,$transferId,$id_field_value));	
					}
				}				
			}
		}
		$log->debug("Exiting transferRelatedRecords...");
	}
	
	/*
	 * Function to get the relation tables for related modules 
	 * @param - $secmodule secondary module name
	 * returns the array with table names and fieldnames storing relations between module and this module
	 */
	function setRelationTables($secmodule){
		$rel_tables =  array (
			"Contacts" => array("vtiger_contactdetails"=>array("accountid","contactid"),"vtiger_account"=>"accountid"),
			"Potentials" => array("vtiger_potential"=>array("accountid","potentialid"),"vtiger_account"=>"accountid"),
			"Quotes" => array("vtiger_quotes"=>array("accountid","quoteid"),"vtiger_account"=>"accountid"),
			"SalesOrder" => array("vtiger_salesorder"=>array("accountid","salesorderid"),"vtiger_account"=>"accountid"),
			"Invoice" => array("vtiger_invoice"=>array("accountid","invoiceid"),"vtiger_account"=>"accountid"),
			"Calendar" => array("vtiger_seactivityrel"=>array("crmid","activityid"),"vtiger_account"=>"accountid"),
			"HelpDesk" => array("vtiger_troubletickets"=>array("parent_id","ticketid"),"vtiger_account"=>"accountid"),
			"Products" => array("vtiger_seproductsrel"=>array("crmid","productid"),"vtiger_account"=>"accountid"),
			"Documents" => array("vtiger_senotesrel"=>array("crmid","notesid"),"vtiger_account"=>"accountid"),
		);
		return $rel_tables[$secmodule];
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
		
		$query = " left join $tabname as $tmpname on $tmpname.$prifieldname = $condvalue and $tmpname.$secfieldname IN (SELECT accountid from vtiger_account)";
			$query .= " left join vtiger_account as vtiger_accountAccount on vtiger_accountAccount.accountid=$tmpname.$secfieldname 
			left join vtiger_crmentity as vtiger_crmentityAccounts on vtiger_crmentityAccounts.crmid=vtiger_accountAccount.accountid and vtiger_crmentityAccounts.deleted=0
			left join vtiger_account on vtiger_account.accountid = vtiger_crmentityAccounts.crmid
			left join vtiger_accountbillads on vtiger_account.accountid=vtiger_accountbillads.accountaddressid
			left join vtiger_accountshipads on vtiger_account.accountid=vtiger_accountshipads.accountaddressid
			left join vtiger_accountscf on vtiger_account.accountid = vtiger_accountscf.accountid
			left join vtiger_account as vtiger_accountAccounts on vtiger_accountAccounts.accountid = vtiger_account.parentid
			left join vtiger_groups as vtiger_groupsAccounts on vtiger_groupsAccounts.groupid = vtiger_crmentityAccounts.smownerid
			left join vtiger_users as vtiger_usersAccounts on vtiger_usersAccounts.id = vtiger_crmentityAccounts.smownerid ";

		return $query;
	}

	/**
	* Function to get Account hierarchy of the given Account
	* @param  integer   $id      - accountid
	* returns Account hierarchy in array format
	*/
	function getAccountHierarchy($id) {
		global $log, $adb, $current_user;
        $log->debug("Entering getAccountHierarchy(".$id.") method ...");
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
							
		$tabname = getParentTab();		
		$listview_header = Array();
		$listview_entries = array();

		foreach ($this->list_fields_name as $fieldname=>$colname) {			
			if(getFieldVisibilityPermission('Accounts', $current_user->id, $colname) == '0') {
				$listview_header[] = getTranslatedString($fieldname);
			}
		}
		
		$accounts_list = Array();
		
		// Get the accounts hierarchy from the top most account in the hierarch of the current account, including the current account	
		$encountered_accounts = array($id);
		$accounts_list = $this->__getParentAccounts($id, $accounts_list, $encountered_accounts);
		
		// Get the accounts hierarchy (list of child accounts) based on the current account	
		$accounts_list = $this->__getChildAccounts($id, $accounts_list, $accounts_list[$id]['depth']);
		
		// Create array of all the accounts in the hierarchy
		foreach($accounts_list as $account_id => $account_info) {
			$account_info_data = array();
			foreach ($this->list_fields_name as $fieldname=>$colname) {			
				if(getFieldVisibilityPermission('Accounts', $current_user->id, $colname) == '0') {
					$data = $account_info[$colname];
					if ($colname == 'accountname') {
						if ($account_id != $id) {
							$data = '<a href="index.php?module=Accounts&action=DetailView&record='.$account_id.'&parenttab='.$tabname.'">'.$data.'</a>';
						} else {
							$data = '<b>'.$data.'</b>';
						}
						// - to show the hierarchy of the Accounts
						$account_depth = str_repeat(" .. ", $account_info['depth'] * 2);
						$data = $account_depth . $data;							
					}
					if ($colname == 'website') {
						$data = '<a href="http://'. $data .'" target="_blank">'.$data.'</a>';
					}
					$account_info_data[] = $data;
				}	
			}									
			$listview_entries[$account_id] = $account_info_data;	
		}
		
		$account_hierarchy = array('header'=>$listview_header,'entries'=>$listview_entries);
        $log->debug("Exiting getAccountHierarchy method ...");
		return $account_hierarchy;
	}	
	
	/**
	* Function to Recursively get all the upper accounts of a given Account 
	* @param  integer   $id      		- accountid
	* @param  array   $parent_accounts   - Array of all the parent accounts
	* returns All the parent accounts of the given accountid in array format
	*/
	function __getParentAccounts($id, &$parent_accounts, &$encountered_accounts) {
		global $log, $adb;
        $log->debug("Entering __getParentAccounts(".$id.",".$parent_accounts.") method ...");
		
		$query = "SELECT parentid FROM vtiger_account " .
				" INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid" .
				" WHERE vtiger_crmentity.deleted = 0 and vtiger_account.accountid = ?";
		$params = array($id);
		
		$res = $adb->pquery($query, $params);

		if ($adb->num_rows($res) > 0 &&
			$adb->query_result($res, 0, 'parentid') != '' && $adb->query_result($res, 0, 'parentid') != 0 &&
			!in_array($adb->query_result($res, 0, 'parentid'),$encountered_accounts)) {
				
			$parentid = $adb->query_result($res, 0, 'parentid');	
			$encountered_accounts[] = $parentid;	
			$this->__getParentAccounts($parentid,$parent_accounts,$encountered_accounts);
		}
		
		$query = "SELECT vtiger_account.*, vtiger_accountbillads.*," .
				" CASE when (vtiger_users.user_name not like '') THEN vtiger_users.user_name ELSE vtiger_groups.groupname END as user_name " .
				" FROM vtiger_account" .
				" INNER JOIN vtiger_crmentity " .
				" ON vtiger_crmentity.crmid = vtiger_account.accountid" .
				" INNER JOIN vtiger_accountbillads" .
				" ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid " .
				" LEFT JOIN vtiger_groups" .
				" ON vtiger_groups.groupid = vtiger_crmentity.smownerid" .
				" LEFT JOIN vtiger_users" .
				" ON vtiger_users.id = vtiger_crmentity.smownerid" .
				" WHERE vtiger_crmentity.deleted = 0 and vtiger_account.accountid = ?";
		$params = array($id);
		$res = $adb->pquery($query, $params);
		
		$parent_account_info = array();
		$depth = 0;
		$immediate_parentid = $adb->query_result($res, 0, 'parentid');
		if (isset($parent_accounts[$immediate_parentid])) {
			$depth = $parent_accounts[$immediate_parentid]['depth'] + 1;
		}
		$parent_account_info['depth'] = $depth;
		foreach($this->list_fields_name as $fieldname=>$columnname) {
			if ($columnname == 'assigned_user_id') {
				$parent_account_info[$columnname] = $adb->query_result($res, 0, 'user_name');				
			} else {
				$parent_account_info[$columnname] = $adb->query_result($res, 0, $columnname);
			}
		}
		$parent_accounts[$id] = $parent_account_info;
        $log->debug("Exiting __getParentAccounts method ...");
		return $parent_accounts;
	}
	
	/**
	* Function to Recursively get all the child accounts of a given Account 
	* @param  integer   $id      		- accountid
	* @param  array   $child_accounts   - Array of all the child accounts
	* @param  integer   $depth          - Depth at which the particular account has to be placed in the hierarchy
	* returns All the child accounts of the given accountid in array format
	*/
	function __getChildAccounts($id, &$child_accounts, $depth) {
		global $log, $adb;
        $log->debug("Entering __getChildAccounts(".$id.",".$child_accounts.",".$depth.") method ...");
		
		$query = "SELECT vtiger_account.*, vtiger_accountbillads.*," .
				" CASE when (vtiger_users.user_name not like '') THEN vtiger_users.user_name ELSE vtiger_groups.groupname END as user_name " .
				" FROM vtiger_account" .
				" INNER JOIN vtiger_crmentity " .
				" ON vtiger_crmentity.crmid = vtiger_account.accountid" .
				" INNER JOIN vtiger_accountbillads" .
				" ON vtiger_account.accountid = vtiger_accountbillads.accountaddressid " .
				" LEFT JOIN vtiger_groups" .
				" ON vtiger_groups.groupid = vtiger_crmentity.smownerid" .
				" LEFT JOIN vtiger_users" .
				" ON vtiger_users.id = vtiger_crmentity.smownerid" .
				" WHERE vtiger_crmentity.deleted = 0 and parentid = ?";
		$params = array($id);
		$res = $adb->pquery($query, $params);
	
		$num_rows = $adb->num_rows($res);
		
		if ($num_rows > 0) {
			$depth = $depth + 1;
			for($i=0;$i<$num_rows;$i++) {
				$child_acc_id = $adb->query_result($res, $i, 'accountid');
				if(array_key_exists($child_acc_id,$child_accounts)) {
					continue;
				}
				$child_account_info = array();
				$child_account_info['depth'] = $depth;
				foreach($this->list_fields_name as $fieldname=>$columnname) {
					if ($columnname == 'assigned_user_id') {
						$child_account_info[$columnname] = $adb->query_result($res, $i, 'user_name');
					} else {
						$child_account_info[$columnname] = $adb->query_result($res, $i, $columnname);
					}
				}
				$child_accounts[$child_acc_id] = $child_account_info;
				$this->__getChildAccounts($child_acc_id, $child_accounts, $depth);
			}
		}
        $log->debug("Exiting __getChildAccounts method ...");
		return $child_accounts;
	}
	
	// Function to unlink the dependent records of the given record by id
	function unlinkDependencies($module, $id) {
		global $log;
		
		//Deleting Account related Potentials.
		$pot_q = 'SELECT vtiger_crmentity.crmid FROM vtiger_crmentity 
			INNER JOIN vtiger_potential ON vtiger_crmentity.crmid=vtiger_potential.potentialid  
			INNER JOIN vtiger_account ON vtiger_account.accountid=vtiger_potential.accountid 
			WHERE vtiger_crmentity.deleted=0 AND vtiger_potential.accountid=?';		
		$pot_res = $this->db->pquery($pot_q, array($id));
		$pot_ids_list = array();
		for($k=0;$k < $this->db->num_rows($pot_res);$k++)
		{
			$pot_id = $this->db->query_result($pot_res,$k,"crmid");
			$pot_ids_list[] = $pot_id;
			$sql = 'UPDATE vtiger_crmentity SET deleted = 1 WHERE crmid = ?';
			$this->db->pquery($sql, array($pot_id));
		}
		//Backup deleted Account related Potentials.
		$params = array($id, RB_RECORD_UPDATED, 'vtiger_crmentity', 'deleted', 'crmid', implode(",", $pot_ids_list));
		$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES(?,?,?,?,?,?)', $params);
		
		//Deleting Account related Quotes.
		$quo_q = 'SELECT vtiger_crmentity.crmid FROM vtiger_crmentity 
			INNER JOIN vtiger_quotes ON vtiger_crmentity.crmid=vtiger_quotes.quoteid 
			INNER JOIN vtiger_account ON vtiger_account.accountid=vtiger_quotes.accountid 
			WHERE vtiger_crmentity.deleted=0 AND vtiger_quotes.accountid=?';
		$quo_res = $this->db->pquery($quo_q, array($id));
		$quo_ids_list = array();
		for($k=0;$k < $this->db->num_rows($quo_res);$k++)
		{
			$quo_id = $this->db->query_result($quo_res,$k,"crmid");
			$quo_ids_list[] = $quo_id;
			$sql = 'UPDATE vtiger_crmentity SET deleted = 1 WHERE crmid = ?';
			$this->db->pquery($sql, array($quo_id));
		}
		//Backup deleted Account related Quotes.
		$params = array($id, RB_RECORD_UPDATED, 'vtiger_crmentity', 'deleted', 'crmid', implode(",", $quo_ids_list));
		$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES(?,?,?,?,?,?)', $params);
		
		//Backup Contact-Account Relation
		$con_q = 'SELECT contactid FROM vtiger_contactdetails WHERE accountid = ?';
		$con_res = $this->db->pquery($con_q, array($id));
		if ($this->db->num_rows($con_res) > 0) {
			$con_ids_list = array();
			for($k=0;$k < $this->db->num_rows($con_res);$k++)
			{
				$con_ids_list[] = $this->db->query_result($con_res,$k,"contactid");
			}
			$params = array($id, RB_RECORD_UPDATED, 'vtiger_contactdetails', 'accountid', 'contactid', implode(",", $con_ids_list));
			$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES(?,?,?,?,?,?)', $params);
		}
		//Deleting Contact-Account Relation.
		$con_q = 'UPDATE vtiger_contactdetails SET accountid = 0 WHERE accountid = ?';
		$this->db->pquery($con_q, array($id));
	
		//Backup Trouble Tickets-Account Relation
		$tkt_q = 'SELECT ticketid FROM vtiger_troubletickets WHERE parent_id = ?';
		$tkt_res = $this->db->pquery($tkt_q, array($id));
		if ($this->db->num_rows($tkt_res) > 0) {
			$tkt_ids_list = array();
			for($k=0;$k < $this->db->num_rows($tkt_res);$k++)
			{
				$tkt_ids_list[] = $this->db->query_result($tkt_res,$k,"ticketid");
			}
			$params = array($id, RB_RECORD_UPDATED, 'vtiger_troubletickets', 'parent_id', 'ticketid', implode(",", $tkt_ids_list));
			$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES(?,?,?,?,?,?)', $params);
		}
		//Deleting Trouble Tickets-Account Relation.
		$tt_q = 'UPDATE vtiger_troubletickets SET parent_id = 0 WHERE parent_id = ?';
		$this->db->pquery($tt_q, array($id));
	    
		parent::unlinkDependencies($module, $id);
	}
	
	// Function to unlink an entity with given Id from another entity 
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		if(empty($return_module) || empty($return_id)) return;		
		
		if($return_module == 'Products') {
			$sql = 'DELETE FROM vtiger_seproductsrel WHERE crmid=? AND productid=?';
			$this->db->pquery($sql, array($id, $return_id));
		} else {
			$sql = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
			$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
			$this->db->pquery($sql, $params);
		}
	}

}

?>
