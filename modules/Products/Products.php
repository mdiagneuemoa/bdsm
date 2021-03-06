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
require_once('data/SugarBean.php');
require_once('include/utils/utils.php');
require_once('include/RelatedListView.php');
require_once('user_privileges/default_module_view.php');

class Products extends CRMEntity {
	var $db, $log; // Used in class functions of CRMEntity
	
	var $table_name = 'vtiger_products';
	var $table_index= 'productid';
    var $column_fields = Array();

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_productcf','productid');
	
	var $tab_name = Array('vtiger_crmentity','vtiger_products','vtiger_productcf');
	
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_products'=>'productid','vtiger_productcf'=>'productid','vtiger_seproductsrel'=>'productid','vtiger_producttaxrel'=>'productid');



	// This is the list of vtiger_fields that are in the lists.
	var $list_fields = Array(
		'Product Name'=>Array('products'=>'productname'),
		'Part Number'=>Array('products'=>'productcode'),
		'Commission Rate'=>Array('products'=>'commissionrate'),
		'Qty/Unit'=>Array('products'=>'qty_per_unit'),
		'Unit Price'=>Array('products'=>'unit_price')
	);
	var $list_fields_name = Array(
		'Product Name'=>'productname',
		'Part Number'=>'productcode',
		'Commission Rate'=>'commissionrate',
		'Qty/Unit'=>'qty_per_unit',
		'Unit Price'=>'unit_price'
	);
	
	var $list_link_field= 'productname';

	var $search_fields = Array(
		'Product Name'=>Array('products'=>'productname'),
		'Part Number'=>Array('products'=>'productcode'),
		'Unit Price'=>Array('products'=>'unit_price')
	);
	var $search_fields_name = Array(
		'Product Name'=>'productname',
		'Part Number'=>'productcode',
		'Unit Price'=>'unit_price'
	);
	
    var $required_fields = Array(
            'productname'=>1
    );

	// Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
	var $sortby_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'productname';
	var $default_sort_order = 'ASC';
	
	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('createdtime', 'modifiedtime', 'productname','imagename');
	 // Josh added for importing and exporting -added in patch2
    var $unit_price;

	/**	Constructor which will set the column_fields in this object
	 */
	function Products() {
		$this->log =LoggerManager::getLogger('product');
		$this->log->debug("Entering Products() method ...");
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('Products');
		$this->log->debug("Exiting Product method ...");
	}
	
	/**	Function used to get the sort order for Product listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['PRODUCTS_SORT_ORDER'] if this session value is empty then default sort order will be returned. 
	 */
	function getSortOrder()
	{
		global $log;
		$log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['PRODUCTS_SORT_ORDER'] != '')?($_SESSION['PRODUCTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for Product listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['PRODUCTS_ORDER_BY'] if this session value is empty then default order by will be returned. 
	 */
	function getOrderBy()
	{
		global $log;
		$log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['PRODUCTS_ORDER_BY'] != '')?($_SESSION['PRODUCTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	function save_module($module)
	{
		//Inserting into product_taxrel table
		if($_REQUEST['ajxaction'] != 'DETAILVIEW')
		{
			$this->insertTaxInformation('vtiger_producttaxrel', 'Products');
			$this->insertPriceInformation('vtiger_productcurrencyrel', 'Products');
		}

		if(isset($this->parentid) &&  $this->parentid!=''){
			$this->insertIntoseProductsRel($this->id,$this->parentid,$this->return_module);
		}

		// Update unit price value in vtiger_productcurrencyrel
		$this->updateUnitPrice();
		//Inserting into attachments
		$this->insertIntoAttachment($this->id,'Products');	
		
	}	

	/**	function to save the product tax information in vtiger_producttaxrel table
	 *	@param string $tablename - vtiger_tablename to save the product tax relationship (producttaxrel)
	 *	@param string $module	 - current module name
	 *	$return void
	*/
	function insertTaxInformation($tablename, $module)
	{
		global $adb, $log;
		$log->debug("Entering into insertTaxInformation($tablename, $module) method ...");
		$tax_details = getAllTaxes();

		$tax_per = '';
		//Save the Product - tax relationship if corresponding tax check box is enabled
		//Delete the existing tax if any
		if($this->mode == 'edit')
		{
			for($i=0;$i<count($tax_details);$i++)
			{
				$taxid = getTaxId($tax_details[$i]['taxname']);
				$sql = "delete from vtiger_producttaxrel where productid=? and taxid=?";
				$adb->pquery($sql, array($this->id,$taxid));
			}
		}
		for($i=0;$i<count($tax_details);$i++)
		{
			$tax_name = $tax_details[$i]['taxname'];
			$tax_checkname = $tax_details[$i]['taxname']."_check";
			if($_REQUEST[$tax_checkname] == 'on' || $_REQUEST[$tax_checkname] == 1)
			{
				$taxid = getTaxId($tax_name);
				$tax_per = $_REQUEST[$tax_name];
				if($tax_per == '')
				{
					$log->debug("Tax selected but value not given so default value will be saved.");
					$tax_per = getTaxPercentage($tax_name);
				}
				
				$log->debug("Going to save the Product - $tax_name tax relationship");

				$query = "insert into vtiger_producttaxrel values(?,?,?)";
				$adb->pquery($query, array($this->id,$taxid,$tax_per));
			}
		}

		$log->debug("Exiting from insertTaxInformation($tablename, $module) method ...");
	}
	
	/**	function to save the product price information in vtiger_productcurrencyrel table
	 *	@param string $tablename - vtiger_tablename to save the product currency relationship (productcurrencyrel)
	 *	@param string $module	 - current module name
	 *	$return void
	*/
	function insertPriceInformation($tablename, $module)
	{
		global $adb, $log, $current_user;
		$log->debug("Entering into insertPriceInformation($tablename, $module) method ...");
		// Update the currency_id based on the logged in user's preference
		$currencyid=fetchCurrency($current_user->id);
		$adb->pquery("update vtiger_products set currency_id=? where productid=?", array($currencyid, $this->id));
		
		$currency_details = getAllCurrencies('all');
		
		//Delete the existing currency relationship if any
		if($this->mode == 'edit')
		{
			for($i=0;$i<count($currency_details);$i++)
			{
				$curid = $currency_details[$i]['curid'];
				$sql = "delete from vtiger_productcurrencyrel where productid=? and currencyid=?";
				$adb->pquery($sql, array($this->id,$curid));
			}
		}
		
		$product_base_conv_rate = getBaseConversionRateForProduct($this->id, $this->mode);
		
		//Save the Product - Currency relationship if corresponding currency check box is enabled
		for($i=0;$i<count($currency_details);$i++)
		{
			$curid = $currency_details[$i]['curid'];
			$curname = $currency_details[$i]['currencylabel'];
			$cur_checkname = 'cur_' . $curid . '_check';
			$cur_valuename = 'curname' . $curid;
			$base_currency_check = 'base_currency' . $curid;
			if($_REQUEST[$cur_checkname] == 'on' || $_REQUEST[$cur_checkname] == 1)
			{
				$conversion_rate = $currency_details[$i]['conversionrate'];
				$actual_conversion_rate = $product_base_conv_rate * $conversion_rate;
				$converted_price = $actual_conversion_rate * $_REQUEST['unit_price'];
				$actual_price = $_REQUEST[$cur_valuename];
				
				$log->debug("Going to save the Product - $curname currency relationship");

				$query = "insert into vtiger_productcurrencyrel values(?,?,?,?)";
				$adb->pquery($query, array($this->id,$curid,$converted_price,$actual_price));
				
				// Update the Product information with Base Currency choosen by the User.
				if ($_REQUEST['base_currency'] == $cur_valuename) {
					$adb->pquery("update vtiger_products set currency_id=?, unit_price=? where productid=?", array($curid, $actual_price, $this->id)); 
				}
			}
		}

		$log->debug("Exiting from insertPriceInformation($tablename, $module) method ...");
	}
	
	function updateUnitPrice() {
		$prod_res = $this->db->pquery("select unit_price, currency_id from vtiger_products where productid=?", array($this->id));
		$prod_unit_price = $this->db->query_result($prod_res, 0, 'unit_price');
		$prod_base_currency = $this->db->query_result($prod_res, 0, 'currency_id');	
		
		$query = "update vtiger_productcurrencyrel set actual_price=? where productid=? and currencyid=?";
		$params = array($prod_unit_price, $this->id, $prod_base_currency);	
		$this->db->pquery($query, $params);
	}
	
	function insertIntoAttachment($id,$module)
	{
		global $log, $adb;
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");
		
		$file_saved = false;

		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{       
			      if($_REQUEST[$fileindex.'_hidden'] != '')	
				      $files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
			      else
				      $files['original_name'] = stripslashes($files['name']);
			      $files['original_name'] = str_replace('"','',$files['original_name']);
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}

		//Remove the deleted vtiger_attachments from db - Products
		if($module == 'Products' && $_REQUEST['del_file_list'] != '')
		{
			$del_file_list = explode("###",trim($_REQUEST['del_file_list'],"###"));
			foreach($del_file_list as $del_file_name)
			{
				$attach_res = $adb->pquery("select vtiger_attachments.attachmentsid from vtiger_attachments inner join vtiger_seattachmentsrel on vtiger_attachments.attachmentsid=vtiger_seattachmentsrel.attachmentsid where crmid=? and name=?", array($id,$del_file_name));
				$attachments_id = $adb->query_result($attach_res,0,'attachmentsid');
				
				$del_res1 = $adb->pquery("delete from vtiger_attachments where attachmentsid=?", array($attachments_id));
				$del_res2 = $adb->pquery("delete from vtiger_seattachmentsrel where attachmentsid=?", array($attachments_id));
			}
		}

		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}



	/**	function used to get the list of leads which are related to the product
	 *	@param int $id - product id 
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_leads($id)
	{
		global $log, $singlepane_view, $mod_strings;
		$log->debug("Entering get_leads(".$id.") method ...");

		require_once('modules/Leads/Leads.php');
		$focus = new Leads();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_leaddetails.leadid, vtiger_crmentity.crmid, vtiger_leaddetails.firstname, vtiger_leaddetails.lastname, vtiger_leaddetails.company, vtiger_leadaddress.phone, vtiger_leadsubdetails.website, vtiger_leaddetails.email, case when (vtiger_users.user_name not like \"\") then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_crmentity.smownerid, vtiger_products.productname, vtiger_products.qty_per_unit, vtiger_products.unit_price, vtiger_products.expiry_date
			FROM vtiger_leaddetails
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leaddetails.leadid
			INNER JOIN vtiger_leadaddress ON vtiger_leadaddress.leadaddressid = vtiger_leaddetails.leadid
			INNER JOIN vtiger_leadsubdetails ON vtiger_leadsubdetails.leadsubscriptionid = vtiger_leaddetails.leadid
			INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.crmid=vtiger_leaddetails.leadid
			INNER JOIN vtiger_products ON vtiger_seproductsrel.productid = vtiger_products.productid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_products.productid = ".$id;

		$log->debug("Exiting get_leads($id) method ...");
		return GetRelatedList('Products','Leads',$focus,$query,$button,$returnset);
        }

	/**	function used to get the list of accounts which are related to the product
	 *	@param int $id - product id 
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_accounts($id)
	{
		global $log, $singlepane_view, $mod_strings;
		$log->debug("Entering get_accounts(".$id.") method ...");

		require_once('modules/Accounts/Accounts.php');
		$focus = new Accounts();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_account.accountid, vtiger_crmentity.crmid, vtiger_account.accountname, vtiger_accountbillads.bill_city, vtiger_account.website, vtiger_account.phone, case when (vtiger_users.user_name not like \"\") then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_crmentity.smownerid, vtiger_products.productname, vtiger_products.qty_per_unit, vtiger_products.unit_price, vtiger_products.expiry_date
			FROM vtiger_account
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid
			INNER JOIN vtiger_accountbillads ON vtiger_accountbillads.accountaddressid = vtiger_account.accountid
			INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.crmid=vtiger_account.accountid
			INNER JOIN vtiger_products ON vtiger_seproductsrel.productid = vtiger_products.productid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_products.productid = ".$id;

			
		$log->debug("Exiting get_accounts method ...");
		return GetRelatedList('Products','Accounts',$focus,$query,$button,$returnset);
        }

	/**	function used to get the list of contacts which are related to the product
	 *	@param int $id - product id 
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_contacts($id)
	{
		global $log, $singlepane_view, $mod_strings;
		$log->debug("Entering get_contacts(".$id.") method ...");

		require_once('modules/Contacts/Contacts.php');
		$focus = new Contacts();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_contactdetails.title, vtiger_contactdetails.accountid, vtiger_contactdetails.email, vtiger_contactdetails.phone, vtiger_crmentity.crmid, case when (vtiger_users.user_name not like \"\") then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_crmentity.smownerid, vtiger_products.productname, vtiger_products.qty_per_unit, vtiger_products.unit_price, vtiger_products.expiry_date,vtiger_account.accountname
			FROM vtiger_contactdetails
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
			INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.crmid=vtiger_contactdetails.contactid
			INNER JOIN vtiger_products ON vtiger_seproductsrel.productid = vtiger_products.productid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_account ON vtiger_account.accountid = vtiger_contactdetails.accountid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_products.productid = ".$id;

		$log->debug("Exiting get_contacts method ...");
		return GetRelatedList('Products','Contacts',$focus,$query,$button,$returnset);
        }


	/**	function used to get the list of potentials which are related to the product
	 *	@param int $id - product id 
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_opportunities($id)
	{
		global $log, $singlepane_view, $mod_strings;
		$log->debug("Entering get_opportunities(".$id.") method ...");

		require_once('modules/Potentials/Potentials.php');
		$focus = new Potentials();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_potential.potentialid, vtiger_crmentity.crmid, vtiger_potential.potentialname, vtiger_account.accountname, vtiger_potential.accountid, vtiger_potential.sales_stage, vtiger_potential.amount, vtiger_potential.closingdate, case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_crmentity.smownerid, vtiger_products.productname, vtiger_products.qty_per_unit, vtiger_products.unit_price, vtiger_products.expiry_date
			FROM vtiger_potential
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_potential.potentialid
			INNER JOIN vtiger_account ON vtiger_potential.accountid = vtiger_account.accountid
			INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.crmid = vtiger_potential.potentialid
			INNER JOIN vtiger_products ON vtiger_seproductsrel.productid = vtiger_products.productid
			LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_products.productid = ".$id;

		$log->debug("Exiting get_opportunities($id) method ...");
		return GetRelatedList('Products','Potentials',$focus,$query,$button,$returnset);
        }

	/**	function used to get the list of tickets which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_tickets($id)
	{
		global $log, $singlepane_view;
		$log->debug("Entering get_tickets(".$id.") method ...");
		global $mod_strings;
		require_once('modules/HelpDesk/HelpDesk.php');
		$focus = new HelpDesk();

		$button = '';		
		if(isPermitted('HelpDesk',1, '') == 'yes')
			$button .= '<input title="'.getTranslatedString('LBL_ADD_NEW').' '.getTranslatedString('Ticket').'" accessyKey="F" class="crmbutton small create"
				 onclick="this.form.action.value=\'EditView\';this.form.module.value=\'HelpDesk\'" type="submit" name="button" value="'.getTranslatedString('LBL_ADD_NEW').' '.getTranslatedString('Ticket').'"></td>';
		
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT  case when (vtiger_users.user_name not like \"\") then vtiger_users.user_name else vtiger_groups.groupname end as user_name, vtiger_users.id,
			vtiger_products.productid, vtiger_products.productname,
			vtiger_troubletickets.ticketid,
			vtiger_troubletickets.parent_id, vtiger_troubletickets.title,
			vtiger_troubletickets.status, vtiger_troubletickets.priority,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid,
			vtiger_crmentity.modifiedtime, vtiger_troubletickets.ticket_no
			FROM vtiger_troubletickets
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid
			LEFT JOIN vtiger_products
				ON vtiger_products.productid = vtiger_troubletickets.product_id
			LEFT JOIN vtiger_users
				ON vtiger_users.id = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_products.productid = ".$id;
	
		$log->debug("Exiting get_tickets method ...");

		$return_value = GetRelatedList('Products','HelpDesk',$focus,$query,$button,$returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		
		return $return_value;
	}

	/**	function used to get the list of activities which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_activities($id)
	{
		global $log, $singlepane_view;
		$log->debug("Entering get_activities(".$id.") method ...");
		global $app_strings;
	
		require_once('modules/Calendar/Activity.php');

        	//if($this->column_fields['contact_id']!=0 && $this->column_fields['contact_id']!='')
        	$focus = new Activity();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;


		$query = "SELECT vtiger_contactdetails.lastname,
			vtiger_contactdetails.firstname,
			vtiger_contactdetails.contactid,
			vtiger_activity.*,
			vtiger_seactivityrel.*,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid,
			vtiger_crmentity.modifiedtime,
			vtiger_users.user_name,
			vtiger_recurringevents.recurringtype
			FROM vtiger_activity
			INNER JOIN vtiger_seactivityrel
				ON vtiger_seactivityrel.activityid = vtiger_activity.activityid
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid=vtiger_activity.activityid
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
			WHERE vtiger_seactivityrel.crmid=".$id."
			AND (activitytype != 'Emails')";
		$log->debug("Exiting get_activities method ...");
		return GetRelatedList('Products','Calendar',$focus,$query,$button,$returnset);
	}

	/**	function used to get the list of quotes which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_quotes($id)
	{
		global $log, $singlepane_view;
		$log->debug("Entering get_quotes(".$id.") method ...");	
		global $app_strings;
		require_once('modules/Quotes/Quotes.php');	
		$focus = new Quotes();
	
		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;


		$query = "SELECT vtiger_crmentity.*,
			vtiger_quotes.*,
			vtiger_potential.potentialname,
			vtiger_account.accountname,
			vtiger_inventoryproductrel.productid,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name 
				else vtiger_groups.groupname end as user_name
			FROM vtiger_quotes
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_quotes.quoteid
			INNER JOIN vtiger_inventoryproductrel
				ON vtiger_inventoryproductrel.id = vtiger_quotes.quoteid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_quotes.accountid
			LEFT OUTER JOIN vtiger_potential
				ON vtiger_potential.potentialid = vtiger_quotes.potentialid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users 
				ON vtiger_users.id = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_inventoryproductrel.productid = ".$id;
		$log->debug("Exiting get_quotes method ...");
		return GetRelatedList('Products','Quotes',$focus,$query,$button,$returnset);
	}

	/**	function used to get the list of purchase orders which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_purchase_orders($id)
	{
		global $log,$singlepane_view;
		$log->debug("Entering get_purchase_orders(".$id.") method ...");
		global $app_strings;
		require_once('modules/PurchaseOrder/PurchaseOrder.php');
		$focus = new PurchaseOrder();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_crmentity.*,
			vtiger_purchaseorder.*,
			vtiger_products.productname,
			vtiger_inventoryproductrel.productid,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name 
				else vtiger_groups.groupname end as user_name
			FROM vtiger_purchaseorder
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_purchaseorder.purchaseorderid
			INNER JOIN vtiger_inventoryproductrel
				ON vtiger_inventoryproductrel.id = vtiger_purchaseorder.purchaseorderid
			INNER JOIN vtiger_products
				ON vtiger_products.productid = vtiger_inventoryproductrel.productid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON vtiger_users.id = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_products.productid = ".$id;
		$log->debug("Exiting get_purchase_orders method ...");
		return GetRelatedList('Products','PurchaseOrder',$focus,$query,$button,$returnset);
	}

	/**	function used to get the list of sales orders which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_salesorder($id)
	{
		global $log,$singlepane_view;
		$log->debug("Entering get_salesorder(".$id.") method ...");
		global $app_strings;
		require_once('modules/SalesOrder/SalesOrder.php');

	        $focus = new SalesOrder();
 
		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT vtiger_crmentity.*,
			vtiger_salesorder.*,
			vtiger_products.productname AS productname,
			vtiger_account.accountname,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name 
				else vtiger_groups.groupname end as user_name
			FROM vtiger_salesorder
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_salesorder.salesorderid
			INNER JOIN vtiger_inventoryproductrel
				ON vtiger_inventoryproductrel.id = vtiger_salesorder.salesorderid
			INNER JOIN vtiger_products
				ON vtiger_products.productid = vtiger_inventoryproductrel.productid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_salesorder.accountid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users 
				ON vtiger_users.id = vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_products.productid = ".$id;
		$log->debug("Exiting get_salesorder method ...");
		return GetRelatedList('Products','SalesOrder',$focus,$query,$button,$returnset);
	}

	/**	function used to get the list of invoices which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_invoices($id)
	{
		global $log,$singlepane_view;
		$log->debug("Entering get_invoices(".$id.") method ...");
		global $app_strings;
		require_once('modules/Invoice/Invoice.php');
		$focus = new Invoice();

		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;


		$query = "SELECT vtiger_crmentity.*,
			vtiger_invoice.*,
			vtiger_inventoryproductrel.quantity,
			vtiger_account.accountname,
			case when (vtiger_users.user_name not like '') then vtiger_users.user_name 
				else vtiger_groups.groupname end as user_name
			FROM vtiger_invoice
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_invoice.invoiceid
			LEFT OUTER JOIN vtiger_account
				ON vtiger_account.accountid = vtiger_invoice.accountid
			INNER JOIN vtiger_inventoryproductrel
				ON vtiger_inventoryproductrel.id = vtiger_invoice.invoiceid
			LEFT JOIN vtiger_groups
				ON vtiger_groups.groupid = vtiger_crmentity.smownerid
			LEFT JOIN vtiger_users
				ON  vtiger_users.id=vtiger_crmentity.smownerid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_inventoryproductrel.productid = ".$id;
		$log->debug("Exiting get_invoices method ...");
		return GetRelatedList('Products','Invoice',$focus,$query,$button,$returnset);
	}

	/**	function used to get the list of pricebooks which are related to the product
	 *	@param int $id - product id
	 *	@return array - array which will be returned from the function GetRelatedList
	 */
	function get_product_pricebooks($id, $cur_tab_id, $rel_tab_id, $actions=false)
	{     
		global $log,$singlepane_view,$currentModule;
		$log->debug("Entering get_product_pricebooks(".$id.") method ...");
		
		$related_module = vtlib_getModuleNameById($rel_tab_id);
		checkFileAccess("modules/$related_module/$related_module.php");
		require_once("modules/$related_module/$related_module.php");
		$focus = new $related_module();
		$singular_modname = vtlib_toSingular($related_module);
		
		$button = '';
		if(isPermitted($related_module,1, '') == 'yes') {
			$button .= "<input title='".getTranslatedString('LBL_ADD_TO'). " ". getTranslatedString($related_module) ."' class='crmbutton small create'" .
				" onclick='this.form.action.value=\"AddProductToPriceBooks\";this.form.module.value=\"$currentModule\"' type='submit' name='button'" .
				" value='". getTranslatedString('LBL_ADD_TO'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";			
		}
		
		$button .= '</td>';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&return_id='.$id;


		$query = "SELECT vtiger_crmentity.crmid,
			vtiger_pricebook.*,
			vtiger_pricebookproductrel.productid as prodid
			FROM vtiger_pricebook
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_pricebook.pricebookid
			INNER JOIN vtiger_pricebookproductrel
				ON vtiger_pricebookproductrel.pricebookid = vtiger_pricebook.pricebookid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_pricebookproductrel.productid = ".$id; 
		$log->debug("Exiting get_product_pricebooks method ...");
           
		$return_value = GetRelatedList($currentModule, $related_module, $focus, $query, $button, $returnset);	

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		
		return $return_value; 
	}

	/**	function used to get the number of vendors which are related to the product
	 *	@param int $id - product id
	 *	@return int number of rows - return the number of products which do not have relationship with vendor
	 */
	function product_novendor()
	{
		global $log;
		$log->debug("Entering product_novendor() method ...");
		$query = "SELECT vtiger_products.productname, vtiger_crmentity.deleted
			FROM vtiger_products
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_products.productid
			WHERE vtiger_crmentity.deleted = 0
			AND vtiger_products.vendor_id is NULL";
		$result=$this->db->pquery($query, array());
		$log->debug("Exiting product_novendor method ...");
		return $this->db->num_rows($result);
	}

	/**
	* Function to get Product's related Products 
	* @param  integer   $id      - productid
	* returns related Products record in array format
	*/
	function get_products($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_products(".$id.") method ...");
		
		global $app_strings;

		$focus = new Products();

		$button = '';

		if(isPermitted("Products",1,"") == 'yes')
		{


			$button .= '<input title="New Product" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Products\';this.form.return_module.value=\'Products\';this.form.return_action.value=\'DetailView\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_PRODUCT'].'">&nbsp;';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&is_parent=0&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&is_parent=0&return_id='.$id;

		$query = "SELECT vtiger_products.productid, vtiger_products.productname,
			vtiger_products.productcode, vtiger_products.commissionrate,
			vtiger_products.qty_per_unit, vtiger_products.unit_price,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid
			FROM vtiger_products
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid
			LEFT JOIN vtiger_seproductsrel ON vtiger_seproductsrel.crmid = vtiger_products.productid AND vtiger_seproductsrel.setype='Products'
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_seproductsrel.productid = $id ";

		$log->debug("Exiting get_products method ...");
		return GetRelatedList('Products','Products',$focus,$query,$button,$returnset);
	}

	/**
	* Function to get Product's related Products 
	* @param  integer   $id      - productid
	* returns related Products record in array format
	*/
	function get_parent_products($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_products(".$id.") method ...");
		
		global $app_strings;

		$focus = new Products();

		$button = '';

		if(isPermitted("Products",1,"") == 'yes')
		{
			$button .= '<input title="New Product" accessyKey="F" class="button" onclick="this.form.action.value=\'EditView\';this.form.module.value=\'Products\';this.form.return_module.value=\'Products\';this.form.return_action.value=\'DetailView\'" type="submit" name="button" value="'.$app_strings['LBL_NEW_PRODUCT'].'">&nbsp;';
		}
		if($singlepane_view == 'true')
			$returnset = '&return_module=Products&return_action=DetailView&is_parent=1&return_id='.$id;
		else
			$returnset = '&return_module=Products&return_action=CallRelatedList&is_parent=1&return_id='.$id;

		$query = "SELECT vtiger_products.productid, vtiger_products.productname,
			vtiger_products.productcode, vtiger_products.commissionrate,
			vtiger_products.qty_per_unit, vtiger_products.unit_price,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid
			FROM vtiger_products
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid
			INNER JOIN vtiger_seproductsrel ON vtiger_seproductsrel.productid = vtiger_products.productid AND vtiger_seproductsrel.setype='Products'
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_seproductsrel.crmid = $id ";

		$log->debug("Exiting get_products method ...");
		return GetRelatedList('Products','Products',$focus,$query,$button,$returnset);
	}
	
	/**	function used to get the export query for product
	 *	@param reference $where - reference of the where variable which will be added with the query
	 *	@return string $query - return the query which will give the list of products to export
	 */	
	function create_export_query($where)
	{
		global $log;
		$log->debug("Entering create_export_query(".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Products", "detail_view");
		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list FROM ".$this->table_name ."
			INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_products.productid 
			LEFT JOIN vtiger_productcf
				ON vtiger_products.productid = vtiger_productcf.productid
			INNER JOIN vtiger_users
				ON vtiger_users.id=vtiger_products.handler 

			LEFT JOIN vtiger_vendor
				ON vtiger_vendor.vendorid = vtiger_products.vendor_id
			WHERE vtiger_crmentity.deleted = 0 and vtiger_users.status = 'Active'";
	

		if($where != "")
                        $query .= " AND ($where) ";

		$log->debug("Exiting create_export_query method ...");
                return $query;

	}

	/** Function to check if the product is parent of any other product 
	*/
	function isparent_check(){
		global $adb;
		$isparent_query = $adb->pquery(getListQuery("Products")." AND (vtiger_products.productid IN (SELECT productid from vtiger_seproductsrel WHERE vtiger_seproductsrel.productid = ? AND vtiger_seproductsrel.setype='Products'))",array($this->id));
		$isparent = $adb->num_rows($isparent_query);
		return $isparent;
	}

	/** Function to check if the product is member of other product
	*/
	function ismember_check(){
		global $adb;
		$ismember_query = $adb->pquery(getListQuery("Products")." AND (vtiger_products.productid IN (SELECT crmid from vtiger_seproductsrel WHERE vtiger_seproductsrel.crmid = ? AND vtiger_seproductsrel.setype='Products'))",array($this->id));
		$ismember = $adb->num_rows($ismember_query);
		return $ismember;
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
		
		$rel_table_arr = Array("HelpDesk"=>"vtiger_troubletickets","Products"=>"vtiger_seproductsrel","Attachments"=>"vtiger_seattachmentsrel",
				"Quotes"=>"vtiger_inventoryproductrel","PurchaseOrder"=>"vtiger_inventoryproductrel","SalesOrder"=>"vtiger_inventoryproductrel",
				"Invoice"=>"vtiger_inventoryproductrel","PriceBooks"=>"vtiger_pricebookproductrel","Leads"=>"vtiger_seproductsrel",
				"Accounts"=>"vtiger_seproductsrel","Potentials"=>"vtiger_seproductsrel","Contacts"=>"vtiger_seproductsrel",
				"Documents"=>"vtiger_senotesrel","Products"=>"vtiger_products");
		
		$tbl_field_arr = Array("vtiger_troubletickets"=>"ticketid","vtiger_seproductsrel"=>"crmid","vtiger_seattachmentsrel"=>"attachmentsid",
				"vtiger_inventoryproductrel"=>"id","vtiger_pricebookproductrel"=>"pricebookid","vtiger_seproductsrel"=>"crmid",
				"vtiger_senotesrel"=>"notesid","vtiger_products"=>"productid");	
		
		$entity_tbl_field_arr = Array("vtiger_troubletickets"=>"product_id","vtiger_seproductsrel"=>"crmid","vtiger_seattachmentsrel"=>"crmid",
				"vtiger_inventoryproductrel"=>"productid","vtiger_pricebookproductrel"=>"productid","vtiger_seproductsrel"=>"productid",
				"vtiger_senotesrel"=>"crmid","vtiger_products"=>"parentid");
		
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
	 * Function to get the secondary query part of a report 
	 * @param - $module primary module name
	 * @param - $secmodule secondary module name
	 * returns the query string formed on fetching the related data for report for secondary module
	 */
	function generateReportsSecQuery($module,$secmodule){
		global $current_user;
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
	
		$query = " left join $tabname as $tmpname on $tmpname.$prifieldname = $condvalue  and $tmpname.$secfieldname IN (SELECT productid from vtiger_products)";
		$query .= " left join vtiger_products as vtiger_productsRelProducts  on vtiger_productsRelProducts.productid = $tmpname.$secfieldname
			LEFT JOIN (
				SELECT vtiger_products.productid, 
						(CASE WHEN (vtiger_products.currency_id = " . $current_user->currency_id . " ) THEN vtiger_products.unit_price
							WHEN (vtiger_productcurrencyrel.actual_price IS NOT NULL) THEN vtiger_productcurrencyrel.actual_price
							ELSE (vtiger_products.unit_price / vtiger_currency_info.conversion_rate) * ". $current_user->conv_rate . " END
						) AS actual_unit_price
				FROM vtiger_products
				LEFT JOIN vtiger_currency_info ON vtiger_products.currency_id = vtiger_currency_info.id
				LEFT JOIN vtiger_productcurrencyrel ON vtiger_products.productid = vtiger_productcurrencyrel.productid
				AND vtiger_productcurrencyrel.currencyid = ". $current_user->currency_id . "
			) AS innerProduct ON innerProduct.productid = vtiger_productsRelProducts.productid
			left join vtiger_crmentity as vtiger_crmentityProducts on vtiger_crmentityProducts.crmid=vtiger_productsRelProducts.productid and vtiger_crmentityProducts.deleted=0
			left join vtiger_products on vtiger_products.productid = vtiger_crmentityProducts.crmid
			left join vtiger_productcf on vtiger_products.productid = vtiger_productcf.productid
			left join vtiger_users as vtiger_usersProducts on vtiger_usersProducts.id = vtiger_products.handler
			left join vtiger_vendor as vtiger_vendorRelProducts on vtiger_vendorRelProducts.vendorid = vtiger_products.vendor_id
			left join vtiger_seproductsrel on vtiger_seproductsrel.productid = vtiger_products.productid
			left join vtiger_crmentity as vtiger_crmentityRelProducts on vtiger_crmentityRelProducts.crmid = vtiger_seproductsrel.crmid and vtiger_crmentityRelProducts.deleted=0
			left join vtiger_account as vtiger_accountRelProducts on vtiger_accountRelProducts.accountid=vtiger_seproductsrel.crmid
			left join vtiger_leaddetails as vtiger_leaddetailsRelProducts on vtiger_leaddetailsRelProducts.leadid = vtiger_seproductsrel.crmid
			left join vtiger_potential as vtiger_potentialRelProducts on vtiger_potentialRelProducts.potentialid = vtiger_seproductsrel.crmid ";
		return $query;
	}

	/*
	 * Function to get the relation tables for related modules 
	 * @param - $secmodule secondary module name
	 * returns the array with table names and fieldnames storing relations between module and this module
	 */
	function setRelationTables($secmodule){
		$rel_tables = array (
			"HelpDesk" => array("vtiger_troubletickets"=>array("product_id","ticketid"),"vtiger_products"=>"productid"),
			"Quotes" => array("vtiger_inventoryproductrel"=>array("productid","id"),"vtiger_products"=>"productid"),
			"PurchaseOrder" => array("vtiger_inventoryproductrel"=>array("productid","id"),"vtiger_products"=>"productid"),
			"SalesOrder" => array("vtiger_inventoryproductrel"=>array("productid","id"),"vtiger_products"=>"productid"),
			"Invoice" => array("vtiger_inventoryproductrel"=>array("productid","id"),"vtiger_products"=>"productid"),
			"Leads" => array("vtiger_seproductsrel"=>array("productid","crmid"),"vtiger_products"=>"productid"),
			"Accounts" => array("vtiger_seproductsrel"=>array("productid","crmid"),"vtiger_products"=>"productid"),
			"Contacts" => array("vtiger_seproductsrel"=>array("productid","crmid"),"vtiger_products"=>"productid"),
			"Potentials" => array("vtiger_seproductsrel"=>array("productid","crmid"),"vtiger_products"=>"productid"),
			"Products" => array("vtiger_products"=>array("productid","product_id"),"vtiger_products"=>"productid"),
			"PriceBooks" => array("vtiger_pricebookproductrel"=>array("productid","pricebookid"),"vtiger_products"=>"productid"),
			"Documents" => array("vtiger_senotesrel"=>array("crmid","notesid"),"vtiger_products"=>"productid"),
		);
		return $rel_tables[$secmodule];
	}

	function deleteProduct2ProductRelation($record,$return_id,$is_parent){
		global $adb;
		if($is_parent==0){
			$sql = "delete from vtiger_seproductsrel WHERE crmid = ? AND productid = ?";
			$adb->pquery($sql, array($record,$return_id));
		} else {
			$sql = "delete from vtiger_seproductsrel WHERE crmid = ? AND productid = ?";
			$adb->pquery($sql, array($return_id,$record));
		}
	}
	
	function insertIntoseProductsRel($record_id,$parentid,$return_module){
		global $adb;
		$query = $adb->pquery("SELECT * from vtiger_seproductsrel WHERE crmid=? and productid=?",array($record_id,$parentid));
		if($adb->num_rows($query)==0){
			$adb->pquery("insert into vtiger_seproductsrel values (?,?,?)",array($record_id,$parentid,$return_module));
		}
	}
	
	// Function to unlink all the dependent entities of the given Entity by Id
	function unlinkDependencies($module, $id) {
		global $log;
		//Backup Campaigns-Product Relation
		$cmp_q = 'SELECT campaignid FROM vtiger_campaign WHERE product_id = ?';
		$cmp_res = $this->db->pquery($cmp_q, array($id));
		if ($this->db->num_rows($cmp_res) > 0) {
			$cmp_ids_list = array();
			for($k=0;$k < $this->db->num_rows($cmp_res);$k++)
			{
				$cmp_ids_list[] = $this->db->query_result($cmp_res,$k,"campaignid");
			}
			$params = array($id, RB_RECORD_UPDATED, 'vtiger_campaign', 'product_id', 'campaignid', implode(",", $cmp_ids_list));
			$this->db->pquery('INSERT INTO vtiger_relatedlists_rb VALUES (?,?,?,?,?,?)', $params);
		}
		//we have to update the product_id as null for the campaigns which are related to this product
		$this->db->pquery('UPDATE vtiger_campaign SET product_id=0 WHERE product_id = ?', array($id));
		
		$this->db->pquery('DELETE from vtiger_seproductsrel WHERE productid=? or crmid=?',array($id,$id));
		
		parent::unlinkDependencies($module, $id);
	}
	
	// Function to unlink an entity with given Id from another entity
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		if(empty($return_module) || empty($return_id)) return;
		
		if($return_module == 'Calendar') {
			$sql = 'DELETE FROM vtiger_seactivityrel WHERE crmid = ? AND activityid = ?';
			$this->db->pquery($sql, array($id, $return_id));
		} elseif($return_module == 'Leads' || $return_module == 'Accounts' || $return_module == 'Contacts' || $return_module == 'Potentials') {
			$sql = 'DELETE FROM vtiger_seproductsrel WHERE productid = ? AND crmid = ?';
			$this->db->pquery($sql, array($id, $return_id));
		} elseif($return_module == 'Vendors') {
			$sql = 'UPDATE vtiger_products SET vendor_id = 0 WHERE productid = ?';
			$this->db->pquery($sql, array($id));
		} else {
			$sql = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
			$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
			$this->db->pquery($sql, $params);
		}
	}
	
}
?>