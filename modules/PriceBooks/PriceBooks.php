<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/SugarBean.php');
require_once('data/CRMEntity.php');
require_once('include/utils/utils.php');
require_once('user_privileges/default_module_view.php');

class PriceBooks extends CRMEntity {
	var $log;
	var $db;
	var $table_name = "vtiger_pricebook";
	var $table_index= 'pricebookid';
	var $tab_name = Array('vtiger_crmentity','vtiger_pricebook','vtiger_pricebookcf');
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_pricebook'=>'pricebookid','vtiger_pricebookcf'=>'pricebookid');
	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_pricebookcf', 'pricebookid');
	var $column_fields = Array();

	var $sortby_fields = Array('bookname');		  

        // This is the list of fields that are in the lists.
	var $list_fields = Array(
                                'Price Book Name'=>Array('pricebook'=>'bookname'),
                                'Active'=>Array('pricebook'=>'active')
                                );
                                
	var $list_fields_name = Array(
                                        'Price Book Name'=>'bookname',
                                        'Active'=>'active'
                                     );
	var $list_link_field= 'bookname';

	var $search_fields = Array(
                                'Price Book Name'=>Array('pricebook'=>'bookname')
                                );
	var $search_fields_name = Array(
                                        'Price Book Name'=>'bookname',
                                     );

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'bookname';
	var $default_sort_order = 'ASC';

	var $mandatory_fields = Array('bookname','currency_id','pricebook_no','createdtime' ,'modifiedtime');
	
	/**	Constructor which will set the column_fields in this object
	 */
	function PriceBooks() {
		$this->log =LoggerManager::getLogger('pricebook');
		$this->log->debug("Entering PriceBooks() method ...");
		$this->db = new PearDatabase();
		$this->column_fields = getColumnFields('PriceBooks');
		$this->log->debug("Exiting PriceBook method ...");
	}

	function save_module($module)
	{
		// Update the list prices in the price book with the unit price, if the Currency has been changed
		$this->updateListPrices();
	}	
	
	/* Function to Update the List prices for all the products of a current price book 
	   with its Unit price, if the Currency for Price book has changed. */
	function updateListPrices() {
		global $log, $adb;
		$log->debug("Entering function updateListPrices...");
		$pricebook_currency = $this->column_fields['currency_id'];
		$prod_res = $adb->pquery("select productid from vtiger_pricebookproductrel where pricebookid=? and usedcurrency != ?", 
							array($this->id,$pricebook_currency));
		$numRows = $adb->num_rows($prod_res);
		$prod_ids = array();
		for($i=0;$i<$numRows;$i++) {
			$prod_ids[] = $adb->query_result($prod_res,$i,'productid');
		}
		if(count($prod_ids) > 0) {
			$prod_price_list = getPricesForProducts($pricebook_currency,$prod_ids);
		
			for($i=0;$i<count($prod_ids);$i++) {
				$product_id = $prod_ids[$i];
				$unit_price = $prod_price_list[$product_id];
				$query = "update vtiger_pricebookproductrel set listprice=?, usedcurrency=? where pricebookid=? and productid=?";
				$params = array($unit_price, $pricebook_currency, $this->id, $product_id);
				$adb->pquery($query, $params);
			}	
		}
		$log->debug("Exiting function updateListPrices...");
	}

	/**	Function used to get the sort order for PriceBook listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['PRICEBOOK_SORT_ORDER'] if this session value is empty then default sort order will be returned. 
	 */
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");	
		if(isset($_REQUEST['sorder'])) 
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['PRICEBOOK_SORT_ORDER'] != '')?($_SESSION['PRICEBOOK_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for PriceBook listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['PRICEBOOK_ORDER_BY'] if this session value is empty then default order by will be returned. 
	 */
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['PRICEBOOK_ORDER_BY'] != '')?($_SESSION['PRICEBOOK_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}	

	/**	function used to get the products which are related to the pricebook
	 *	@param int $id - pricebook id
         *      @return array - return an array which will be returned from the function getPriceBookRelatedProducts
        **/
	function get_pricebook_products($id, $cur_tab_id, $rel_tab_id, $actions=false)
	{
		global $log,$singlepane_view;
		$log->debug("Entering get_pricebook_products(".$id.") method ...");
		global $app_strings;
		
		$related_module = vtlib_getModuleNameById($rel_tab_id);
		checkFileAccess("modules/$related_module/$related_module.php");
		require_once("modules/$related_module/$related_module.php");
		$focus = new $related_module();

		$button = '';

		if($singlepane_view == 'true')
			$returnset = '&return_module=PriceBooks&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=PriceBooks&return_action=CallRelatedList&return_id='.$id;

		$query = 'select vtiger_products.productid, vtiger_products.productname, vtiger_products.productcode, vtiger_products.commissionrate, vtiger_products.qty_per_unit, vtiger_products.unit_price, vtiger_crmentity.crmid, vtiger_crmentity.smownerid,vtiger_pricebookproductrel.listprice from vtiger_products inner join vtiger_pricebookproductrel on vtiger_products.productid = vtiger_pricebookproductrel.productid inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_products.productid inner join vtiger_pricebook on vtiger_pricebook.pricebookid = vtiger_pricebookproductrel.pricebookid  where vtiger_pricebook.pricebookid = '.$id.' and vtiger_crmentity.deleted = 0'; 
		$log->debug("Exiting get_pricebook_products method ...");
		return getPriceBookRelatedProducts($query,$this,$returnset);
	}	

	/**	function used to get the services which are related to the pricebook
	 *	@param int $id - pricebook id
         *      @return array - return an array which will be returned from the function getPriceBookRelatedServices
        **/
	function get_pricebook_services($id, $cur_tab_id, $rel_tab_id, $actions=false)
	{
		global $log,$singlepane_view,$currentModule;
		$log->debug("Entering get_pricebook_services(".$id.") method ...");
		
		$related_module = vtlib_getModuleNameById($rel_tab_id);
		checkFileAccess("modules/$related_module/$related_module.php");
		require_once("modules/$related_module/$related_module.php");
		$focus = new $related_module();
		
		$button = '';
		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='submit' name='button' onclick=\"this.form.action.value='AddServicesToPriceBook';this.form.module.value='$related_module';this.form.return_module.value='$currentModule';this.form.return_action.value='PriceBookDetailView'\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($related_module) ."'>&nbsp;";
			}
		}
				
		$button .= '</td>';
		
		if($singlepane_view == 'true')
			$returnset = '&return_module=PriceBooks&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=PriceBooks&return_action=CallRelatedList&return_id='.$id;

		$query = 'select vtiger_service.serviceid, vtiger_service.servicename, vtiger_service.commissionrate,  
			vtiger_service.qty_per_unit, vtiger_service.unit_price, vtiger_crmentity.crmid, vtiger_crmentity.smownerid,  
			vtiger_pricebookproductrel.listprice from vtiger_service 
			inner join vtiger_pricebookproductrel on vtiger_service.serviceid = vtiger_pricebookproductrel.productid  
			inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_service.serviceid
			inner join vtiger_pricebook on vtiger_pricebook.pricebookid = vtiger_pricebookproductrel.pricebookid
			where vtiger_pricebook.pricebookid = '.$id.' and vtiger_crmentity.deleted = 0';
		
		$return_value = $focus->getPriceBookRelatedServices($query,$this,$returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;
		
		$log->debug("Exiting get_pricebook_products method ...");
		return $return_value; 
	}

	/**	function used to get whether the pricebook has related with a product or not
	 *	@param int $id - product id
	 *	@return true or false - if there are no pricebooks available or associated pricebooks for the product is equal to total number of pricebooks then return false, else return true
	 */
	function get_pricebook_noproduct($id)
	{
		global $log;
		$log->debug("Entering get_pricebook_noproduct(".$id.") method ...");
		 
		$query = "select vtiger_crmentity.crmid, vtiger_pricebook.* from vtiger_pricebook inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_pricebook.pricebookid where vtiger_crmentity.deleted=0";
		$result = $this->db->pquery($query, array());
		$no_count = $this->db->num_rows($result);
		if($no_count !=0)
		{
       	 	$pb_query = 'select vtiger_crmentity.crmid, vtiger_pricebook.pricebookid,vtiger_pricebookproductrel.productid from vtiger_pricebook inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_pricebook.pricebookid inner join vtiger_pricebookproductrel on vtiger_pricebookproductrel.pricebookid=vtiger_pricebook.pricebookid where vtiger_crmentity.deleted=0 and vtiger_pricebookproductrel.productid=?';
			$result_pb = $this->db->pquery($pb_query, array($id));
			if($no_count == $this->db->num_rows($result_pb))
			{
				$log->debug("Exiting get_pricebook_noproduct method ...");
				return false;
			}
			elseif($this->db->num_rows($result_pb) == 0)
			{
				$log->debug("Exiting get_pricebook_noproduct method ...");
				return true;
			}
			elseif($this->db->num_rows($result_pb) < $no_count)
			{
				$log->debug("Exiting get_pricebook_noproduct method ...");
				return true;
			}
		}
		else
		{
			$log->debug("Exiting get_pricebook_noproduct method ...");
			return false;
		}
	}
	
	/*
	 * Function to get the primary query part of a report 
	 * @param - $module Primary module name
	 * returns the query string formed on fetching the related data for report for primary module
	 */
	function generateReportsQuery($module){
	 			$moduletable = $this->table_name;
	 			$moduleindex = $this->table_index;
	 			
	 			$query = "from $moduletable
					inner join vtiger_crmentity on vtiger_crmentity.crmid=$moduletable.$moduleindex
					left join vtiger_currency_info as vtiger_currency_info$module on vtiger_currency_info$module.id = $moduletable.currency_id 
					left join vtiger_groups as vtiger_groups$module on vtiger_groups$module.groupid = vtiger_crmentity.smownerid 
					left join vtiger_users as vtiger_users$module on vtiger_users$module.id = vtiger_crmentity.smownerid 
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
	
		$query = " left join $tabname as $tmpname on $tmpname.$prifieldname = $condvalue and $tmpname.$secfieldname IN (SELECT pricebookid from vtiger_pricebook)";
		$query .=" left join vtiger_pricebook as vtiger_pricebookPriceBooks on vtiger_pricebookPriceBooks.pricebookid=$tmpname.$secfieldname  
				left join vtiger_crmentity as vtiger_crmentityPriceBooks on vtiger_crmentityPriceBooks.crmid=vtiger_pricebookPriceBooks.pricebookid and vtiger_crmentityPriceBooks.deleted=0 
				left join vtiger_pricebook on vtiger_pricebook.pricebookid = vtiger_crmentityPriceBooks.crmid 
				left join vtiger_currency_info as vtiger_currency_infoPriceBooks on vtiger_currency_infoPriceBooks.id = vtiger_pricebook.currency_id 
				left join vtiger_users as vtiger_usersPriceBooks on vtiger_usersPriceBooks.id = vtiger_crmentityPriceBooks.smownerid
				left join vtiger_groups as vtiger_groupsPriceBooks on vtiger_groupsPriceBooks.groupid = vtiger_crmentityPriceBooks.smownerid"; 

		return $query;
	}

	/*
	 * Function to get the relation tables for related modules 
	 * @param - $secmodule secondary module name
	 * returns the array with table names and fieldnames storing relations between module and this module
	 */
	function setRelationTables($secmodule){
		$rel_tables = array (
			"Products" => array("vtiger_pricebookproductrel"=>array("pricebookid","productid"),"vtiger_pricebook"=>"pricebookid"),
		);
		return $rel_tables[$secmodule];
	}

}
?>
