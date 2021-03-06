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
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/UserInfoUtil.php');
global $calpath;
global $app_strings,$mod_strings;
global $app_list_strings;
global $modules;
global $blocks;
global $adv_filter_options;
global $log;

global $report_modules;
global $related_modules;

$adv_filter_options = array("e"=>"equals",
		            "n"=>"not equal to",
			    "s"=>"starts with",
			    "ew"=>"ends with",
			    "c"=>"contains",
			    "k"=>"does not contain",
			    "l"=>"less than",
			    "g"=>"greater than",
			    "m"=>"less or equal",
			    "h"=>"greater or equal"
			   );

//$report_modules = Array('Faq','Rss','Portal','Recyclebin','Emails','Reports','Dashboard','Home','Activities'
	//	       );

/*$related_modules = Array('Leads'=>Array(),
			 'Accounts'=>Array('Potentials','Contacts','Products','Quotes','Invoice'),
			 'Contacts'=>Array('Accounts','Potentials','Quotes','PurchaseOrder'),
			 'Potentials'=>Array('Accounts','Contacts','Quotes'),
			 'Calendar'=>Array('Leads','Accounts','Contacts','Potentials'),
			 'Products'=>Array('Accounts','Contacts'),
			 'HelpDesk'=>Array('Products'),
			 'Quotes'=>Array('Accounts','Contacts','Potentials'),
			 'PurchaseOrder'=>Array('Contacts'),
			 'SalesOrder'=>Array(),
			 'Invoice'=>Array('Accounts'),
			 'Campaigns'=>Array('Products')
			);
*/
$related_modules =Array();

class Reports extends CRMEntity{



	/**
	 * This class has the informations for Reports and inherits class CRMEntity and
	 * has the variables required to generate,save,restore vtiger_reports
	 * and also the required functions for the same
	 * Contributor(s): ______________________________________..
	 */


	var $srptfldridjs;

	var $column_fields = Array();

	var $sort_fields = Array();
	var $sort_values = Array();

	var $id;
	var $mode;
	var $mcount;

	var $startdate;
	var $enddate;

	var $ascdescorder;

	var $stdselectedfilter;
	var $stdselectedcolumn;

	var $primodule;
	var $secmodule;
	var $columnssummary;
	var $is_editable;
	var $reporttype;
	var $reportname;
	var $reportdescription;
	var $folderid;
	var $module_blocks;

	var $pri_module_columnslist;
	var $sec_module_columnslist;

	var $advft_column;
	var $advft_option;
	var $advft_value;
	var $adv_rel_fields = Array();
	
	var $module_list = Array();/*
				"Leads"=>Array("Information"=>13,"Address"=>15,"Description"=>16,"Custom Information"=>14),
				"Contacts"=>Array("Information"=>4,"Portal Information"=>6,"Address"=>7,"Description"=>8,"Custom Information"=>5),
				"Accounts"=>Array("Information"=>9,"Address"=>11,"Description"=>12,"Custom Information"=>10),
				"Potentials"=>Array("Information"=>1,"Description"=>3,"Custom Information"=>2),
				"Calendar"=>Array("Information"=>19,"Description"=>20),
 		                "Campaigns"=>Array("Information"=>76,"Expectations"=>78,"Description"=>82,"Custom Information"=>77),
				"Products"=>Array("Information"=>31,"Description"=>36,"Pricing Information"=>32,"Stock Information"=>33,"Custom Information"=>34),
				"Documents"=>Array("Information"=>17,"Description"=>18),
				"Emails"=>Array("Information"=>21,"Description"=>24),
				"HelpDesk"=>Array("Information"=>'25,26',"Custom Information"=>27,"Description"=>28,"Solution"=>29),//patch2
				"Quotes"=>Array("Information"=>51,"Address"=>53,"Description"=>56,"Terms and Conditions"=>55,"Custom Information"=>52),
				"PurchaseOrder"=>Array("Information"=>57,"Address"=>59,"Description"=>62,"Terms and Conditions"=>61,"Custom Information"=>58),
				"SalesOrder"=>Array("Information"=>63,"Address"=>65,"Description"=>68,"Terms and Conditions"=>67,"Custom Information"=>64),
				"Invoice"=>Array("Information"=>69,"Address"=>71,"Description"=>74,"Terms and Conditions"=>73,"Custom Information"=>70)
				);*/

	/** Function to set primodule,secmodule,reporttype,reportname,reportdescription,folderid for given vtiger_reportid
	 *  This function accepts the vtiger_reportid as argument
	 *  It sets primodule,secmodule,reporttype,reportname,reportdescription,folderid for the given vtiger_reportid
	 */

	function Reports($reportid="")
	{
		global $adb,$current_user,$theme,$mod_strings;
		$this->initListOfModules();
		if($reportid != "")
		{
			$ssql = "select vtiger_reportmodules.*,vtiger_report.* from vtiger_report inner join vtiger_reportmodules on vtiger_report.reportid = vtiger_reportmodules.reportmodulesid";
			$ssql .= " where vtiger_report.reportid = ?";
			$params = array($reportid);
			
			require_once('include/utils/GetUserGroups.php');
			require('user_privileges/user_privileges_'.$current_user->id.'.php');
			$userGroups = new GetUserGroups();
			$userGroups->getAllUserGroups($current_user->id);
			$user_groups = $userGroups->user_groups;
			/*
			$non_admin_query = " vtiger_report.reportid IN (SELECT reportid from vtiger_reportsharing WHERE (shareid IN (".generateQuestionMarks($user_groups).") AND setype='groups') OR (shareid=? AND setype='users'))";
			if($is_admin==false){
				$ssql .= " and ( (".$non_admin_query.") or vtiger_report.sharingtype='Public' or vtiger_report.owner = ? or vtiger_report.owner in(select vtiger_user2role.userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%'))";			
				array_push($params, $user_groups);
				array_push($params, $current_user->id);
				array_push($params, $current_user->id);
			}*/
					
			$query = $adb->pquery("select userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%'",array());
			$subordinate_users = Array();
			for($i=0;$i<$adb->num_rows($query);$i++){
				$subordinate_users[] = $adb->query_result($query,$i,'userid');
			}
			$result = $adb->pquery($ssql, $params);
			$reportmodulesrow = $adb->fetch_array($result);
			if($reportmodulesrow)
			{
				$this->primodule = $reportmodulesrow["primarymodule"];
				$this->secmodule = $reportmodulesrow["secondarymodules"];
				$this->reporttype = $reportmodulesrow["reporttype"];
				$this->reportname = decode_html($reportmodulesrow["reportname"]);
				$this->reportdescription = decode_html($reportmodulesrow["description"]);
				$this->folderid = $reportmodulesrow["folderid"];
				if($is_admin==true || in_array($reportmodulesrow["owner"],$subordinate_users) || $reportmodulesrow["owner"]==$current_user->id)
					$this->is_editable = 'true';
				else
					$this->is_editable = 'false';
			} else {
				if($_REQUEST['mode'] != 'ajax')
				{
					include('themes/'.$theme.'/header.php');
				}	
				echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
				echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 80%; position: relative; z-index: 10000000;'>
		
				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='themes/$theme/images/denied.gif' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>You are not allowed to View this Report </span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>			   	
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   		     </td>
				</tr>
				</tbody></table> 
				</div>";
				echo "</td></tr></table>";
				break;
				
			}
		}
	}

	// Update the module list for listing columns for report creation.
	function updateModuleList($module) {
		global $adb;
		if (!isset($module)) return;
		require_once('include/utils/utils.php');
		$tabid = getTabid($module); 
		if ($module == 'Calendar') {
			$tabid = array(9, 16);
		} 
		$sql = "SELECT blockid, blocklabel FROM vtiger_blocks WHERE tabid IN (". generateQuestionMarks($tabid) .")";
		$res = $adb->pquery($sql, array($tabid));
		$noOfRows = $adb->num_rows($res);
		if ($noOfRows <= 0) return;
		for($index = 0; $index < $noOfRows; ++$index) {
			$blockid = $adb->query_result($res,$index,'blockid');
			if(in_array($blockid, $this->module_list[$module])) continue;
			$blockid_list[] = $blockid;
			$blocklabel = $adb->query_result($res,$index,'blocklabel');
			$this->module_list[$module][$blocklabel] = $blockid;
		}
	}

	// Initializes the module list for listing columns for report creation.
	function initListOfModules() {
		global $adb,$current_user;
		$restricted_modules = array('Emails','Events','Webmails');
		$restricted_blocks = array('LBL_IMAGE_INFORMATION','LBL_COMMENTS','LBL_COMMENT_INFORMATION');
		$this->related_lists[$module]=Array();
		$result = $adb->pquery("select name from vtiger_tab WHERE vtiger_tab.presence != 1 AND vtiger_tab.isentitytype=1 and vtiger_tab.name NOT IN(".generateQuestionMarks($restricted_modules).") order by vtiger_tab.tabsequence ", array($restricted_modules));
		if($adb->num_rows($result)>0){
			for($i=0;$i <$adb->num_rows($result);$i++){
				$module = $adb->query_result($result,$i,'name');
				require_once('include/utils/utils.php');
				$tabid = getTabid($module); 
				if ($module == 'Calendar') {
					$tabid = array(9, 16);
				}
				$sql = "SELECT blockid, blocklabel FROM vtiger_blocks WHERE tabid IN (". generateQuestionMarks($tabid) .")";
				$res = $adb->pquery($sql, array($tabid));
				$noOfRows = $adb->num_rows($res);
				$this->module_list[$module]=Array();
				if ($noOfRows > 0) { 
					for($index = 0; $index < $noOfRows; ++$index) {
						$blockid = $adb->query_result($res,$index,'blockid');
						$blocklabel = $adb->query_result($res,$index,'blocklabel');
						if((in_array($blocklabel,$restricted_blocks) || (isset($this->module_list[$module]) &&in_array($blockid, $this->module_list[$module])) || isset($this->module_list[$module][getTranslatedString($blocklabel,$module)]))&& $module !='Calendar') continue;
						else{
							$blockid_list[] = $blockid;
							if($module == 'Calendar' && $blocklabel == 'LBL_CUSTOM_INFORMATION')
								$this->module_list[$module][getTranslatedString($blocklabel,$module)][] = $blockid;
							else
								$this->module_list[$module][getTranslatedString($blocklabel,$module)] = $blockid;
						}
					}
				}
				$rel_mod_query = $adb->pquery("SELECT vtiger_tab.name FROM vtiger_tab INNER JOIN vtiger_relatedlists on vtiger_tab.tabid=vtiger_relatedlists.related_tabid WHERE vtiger_relatedlists.tabid IN (". generateQuestionMarks($tabid) .") AND vtiger_tab.isentitytype=1 and vtiger_tab.name NOT IN(".generateQuestionMarks($restricted_modules).") AND vtiger_tab.presence=0 AND vtiger_relatedlists.label!='Activity History'",array($tabid,$restricted_modules));
				$noOfRows = $adb->num_rows($rel_mod_query);
				$this->related_modules[$module]=Array();
				if($noOfRows > 0){
					for($index = 0; $index < $noOfRows; $index++) {
						$mod_name = $adb->query_result($rel_mod_query,$index,'name');
						if($mod_name!=$module){
							$this->related_modules[$module][] = $mod_name;
						}
					}
				}
			}
		}
	}
 	
	/** Function to get the Listview of Reports
	 *  This function accepts no argument
	 *  This generate the Reports view page and returns a string
	 *  contains HTML 
	 */

	function sgetRptFldr($mode='')
	{

		global $adb,$log,$mod_strings;
		$returndata = Array();
		$sql = "select * from vtiger_reportfolder where foldername = 'Demandes Reports' or  foldername = 'Incidents Reports'order by folderid";
		$result = $adb->pquery($sql, array());
		$reportfldrow = $adb->fetch_array($result);
		if($mode != '')
		{
			do
			{
				if($reportfldrow["state"] == $mode)
				{
					$details = Array();	
					$details['state'] = $reportfldrow["state"]; 
					$details['id'] = $reportfldrow["folderid"]; 
					$details['name'] = ($mod_strings[$reportfldrow["foldername"]] == '' ) ? $reportfldrow["foldername"]:$mod_strings[$reportfldrow["foldername"]]; 
					$details['description'] = $reportfldrow["description"]; 
					$details['fname'] = popup_decode_html($details['name']);
					$details['fdescription'] = popup_decode_html($reportfldrow["description"]);
					$details['details'] = $this->sgetRptsforFldr($reportfldrow["folderid"]);
					$returndata[] = $details;
				}
			}while($reportfldrow = $adb->fetch_array($result));
		}else
		{
			do
			{
				$details = Array();	
				$details['state'] = $reportfldrow["state"]; 
				$details['id'] = $reportfldrow["folderid"]; 
				$details['name'] = ($mod_strings[$reportfldrow["foldername"]] == '' ) ? $reportfldrow["foldername"]:$mod_strings[$reportfldrow["foldername"]]; 
				$details['description'] = $reportfldrow["description"]; 
				$details['fname'] = popup_decode_html($details['name']);
				$details['fdescription'] = popup_decode_html($reportfldrow["description"]);
				$returndata[] = $details;
			}while($reportfldrow = $adb->fetch_array($result));
		}

		$log->info("Reports :: ListView->Successfully returned vtiger_report folder HTML");
		return $returndata;
	}

	/** Function to get the Reports inside each modules
	 *  This function accepts the folderid
	 *  This Generates the Reports under each Reports module 
	 *  This Returns a HTML sring
	 */

	function sgetRptsforFldr($rpt_fldr_id)
	{
		$srptdetails="";
		global $adb;
		global $log;
		global $mod_strings,$current_user;
		$returndata = Array();

		require_once('include/utils/UserInfoUtil.php');

		$sql = "select vtiger_report.*, vtiger_reportmodules.* from vtiger_report inner join vtiger_reportfolder on vtiger_reportfolder.folderid = vtiger_report.folderid";
		$sql .= " inner join vtiger_reportmodules on vtiger_reportmodules.reportmodulesid = vtiger_report.reportid where vtiger_reportfolder.folderid=?";
		
		$params = array($rpt_fldr_id);
		
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		require_once('include/utils/GetUserGroups.php');
		$userGroups = new GetUserGroups();
		$userGroups->getAllUserGroups($current_user->id);
		$user_groups = $userGroups->user_groups;
		
		//$non_admin_query = " vtiger_report.reportid IN (SELECT reportid from vtiger_reportsharing WHERE (shareid IN (".generateQuestionMarks($user_groups).") AND setype='groups') OR (shareid=? AND setype='users'))";
		/*if($is_admin==false){
			$sql .= " and ( (".$non_admin_query.") or vtiger_report.sharingtype='Public' or vtiger_report.owner = ? or vtiger_report.owner in(select vtiger_user2role.userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%'))";			
			array_push($params, $user_groups);
			array_push($params, $current_user->id);
			array_push($params, $current_user->id);
		}*/
		$query = $adb->pquery("select userid from vtiger_user2role inner join vtiger_users on vtiger_users.id=vtiger_user2role.userid inner join vtiger_role on vtiger_role.roleid=vtiger_user2role.roleid where vtiger_role.parentrole like '".$current_user_parent_role_seq."::%'",array());
		$subordinate_users = Array();
		for($i=0;$i<$adb->num_rows($query);$i++){
			$subordinate_users[] = $adb->query_result($query,$i,'userid');
		}
		$result = $adb->pquery($sql, $params);
		
		$report = $adb->fetch_array($result);
		
		if(count($report)>0)
		{
			do
			{
				$report_details = Array();
				$report_details ['customizable'] = $report["customizable"];
				$report_details ['reportid'] = $report["reportid"];
				$report_details ['primarymodule'] = $report["primarymodule"];
				$report_details ['secondarymodules'] = $report["secondarymodules"];
				$report_details ['state'] = $report["state"];
				$report_details ['description'] = $report["description"];
				$report_details ['reportname'] = $report["reportname"];
				$report_details ['sharingtype'] = $report["sharingtype"];
				//if($is_admin==true || in_array($report["owner"],$subordinate_users) || $report["owner"]==$current_user->id)
					$report_details ['editable'] = 'true';
				//else
				//	$report_details['editable'] = 'false';
				
				//if(isPermitted($report["primarymodule"],'index') == "yes")
					$returndata []=$report_details; 
			}while($report = $adb->fetch_array($result));
		}

		$log->info("Reports :: ListView->Successfully returned vtiger_report details HTML");
		return $returndata;
	}

	/** Function to get the array of ids
	 *  This function forms the array for the ExpandCollapse
	 *  Javascript
	 *  It returns the array of ids
	 *  Array('1RptFldr','2RptFldr',........,'9RptFldr','10RptFldr')
	 */

	function sgetJsRptFldr()
	{
		$srptfldr_js = "var ReportListArray=new Array(".$this->srptfldridjs.")
			setExpandCollapse()";
		return $srptfldr_js;
	}

	/** Function to set the Primary module vtiger_fields for the given Report 
	 *  This function sets the primary module columns for the given Report 
	 *  It accepts the Primary module as the argument and set the vtiger_fields of the module
	 *  to the varialbe pri_module_columnslist and returns true if sucess
	 */

	function getPriModuleColumnsList($module)
	{
		//$this->updateModuleList($module);
		foreach($this->module_list[$module] as $key=>$value)
		{
			$ret_module_list[$module][$key] = $this->getColumnsListbyBlock($module,$value);
		}
		$this->pri_module_columnslist = $ret_module_list;
		return true;
	}

	/** Function to set the Secondary module fileds for the given Report
	 *  This function sets the secondary module columns for the given module
	 *  It accepts the module as the argument and set the vtiger_fields of the module
	 *  to the varialbe sec_module_columnslist and returns true if sucess
	 */

	function getSecModuleColumnsList($module)
	{
		if($module != "")
		{
			$secmodule = explode(":",$module);
			for($i=0;$i < count($secmodule) ;$i++)
			{
				//$this->updateModuleList($secmodule[$i]);
				if($this->module_list[$secmodule[$i]]){
					foreach($this->module_list[$secmodule[$i]] as $key=>$value)
					{
						$ret_module_list[$secmodule[$i]][$key] = $this->getColumnsListbyBlock($secmodule[$i],$value);
					}
					$this->sec_module_columnslist[$secmodule[$i]] = $ret_module_list[$secmodule[$i]];
				}
			}
		}
		return true;
	}

	/** Function to get vtiger_fields for the given module and block
	 *  This function gets the vtiger_fields for the given module
	 *  It accepts the module and the block as arguments and 
	 *  returns the array column lists
	 *  Array module_columnlist[ vtiger_fieldtablename:fieldcolname:module_fieldlabel1:fieldname:fieldtypeofdata]=fieldlabel
	 */

	function getColumnsListbyBlock($module,$block)
	{
		global $adb;
		global $log;
		global $current_user;

		if(is_string($block)) $block = explode(",", $block);

		$tabid = getTabid($module);
		if ($module == 'Calendar') {
			$tabid = array('9','16');
		}
		$params = array($tabid, $block);
		
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		//Security Check 
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] ==0)
		{
			$sql = "select * from vtiger_field where vtiger_field.tabid in (". generateQuestionMarks($tabid) .") and vtiger_field.block in (". generateQuestionMarks($block) .") and vtiger_field.displaytype in (1,2,3) and vtiger_field.presence in (0,2) ";

			//fix for Ticket #4016
			if($module == "Calendar")
				$sql.=" group by vtiger_field.fieldlabel order by sequence";
			else
				$sql.=" order by sequence";
		}
		else
		{
			
			$profileList = getCurrentUserProfileList();
			$sql = "select * from vtiger_field inner join vtiger_profile2field on vtiger_profile2field.fieldid=vtiger_field.fieldid inner join vtiger_def_org_field on vtiger_def_org_field.fieldid=vtiger_field.fieldid where vtiger_field.tabid in (". generateQuestionMarks($tabid) .")  and vtiger_field.block in (". generateQuestionMarks($block) .") and vtiger_field.displaytype in (1,2,3) and vtiger_profile2field.visible=0 and vtiger_def_org_field.visible=0 and vtiger_field.presence in (0,2)";
			if (count($profileList) > 0) {
				$sql .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")";	
				array_push($params, $profileList);
			}

			//fix for Ticket #4016
			if($module == "Calendar")
				$sql.=" group by vtiger_field.fieldid,vtiger_field.fieldlabel order by sequence";
			else
				$sql.=" group by vtiger_field.fieldid order by sequence";			
		}
		
		if($module == 'HelpDesk' && $block == 25)
        {
        		$module_columnlist['vtiger_crmentity:crmid:HelpDesk_Ticket_ID:ticketid:I'] = 'Ticket ID';
        }
		
		$result = $adb->pquery($sql, $params);
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$fieldtype = $adb->query_result($result,$i,"typeofdata");
			$uitype = $adb->query_result($result,$i,"uitype");
			$fieldtype = explode("~",$fieldtype);
			$fieldtypeofdata = $fieldtype[0];

			//Here we Changing the displaytype of the field. So that its criteria will be displayed correctly in Reports Advance Filter.
			$fieldtypeofdata=ChangeTypeOfData_Filter($fieldtablename,$fieldcolname,$fieldtypeofdata);
			
			if($uitype == 68 || $uitype == 59)
			{
				$fieldtypeofdata = 'V';
			}
			if($fieldtablename == "vtiger_crmentity")
			{
				$fieldtablename = $fieldtablename.$module;
			}
			if($fieldname == "assigned_user_id")
			{
				$fieldtablename = "vtiger_users".$module;
				$fieldcolname = "user_name";
			}
			if($fieldname == "account_id")
			{
				$fieldtablename = "vtiger_account".$module;
				$fieldcolname = "accountname";
			}
			if($fieldname == "contact_id")
			{
				$fieldtablename = "vtiger_contactdetails".$module;
				$fieldcolname = "lastname";
			}
			if($fieldname == "parent_id")
			{
				$fieldtablename = "vtiger_crmentityRel".$module;
				$fieldcolname = "setype";
			}
			if($fieldname == "vendor_id")
			{
				$fieldtablename = "vtiger_vendorRel".$module;
				$fieldcolname = "vendorname";
			}
			if($fieldname == "potential_id")
			{
				$fieldtablename = "vtiger_potentialRel".$module;
				$fieldcolname = "potentialname";
			}
			if($fieldname == "assigned_user_id1")
			{
				$fieldtablename = "vtiger_usersRel1";
				$fieldcolname = "user_name";
			}
			if($fieldname == 'quote_id')
			{
				$fieldtablename = "vtiger_quotes".$module;
				$fieldcolname = "subject";
			}
			
			$product_id_tables = array(
				"vtiger_troubletickets"=>"vtiger_productsRel",
				"vtiger_campaign"=>"vtiger_productsCampaigns",
				"vtiger_faq"=>"vtiger_productsFaq",
				);
			if($fieldname == 'product_id' && isset($product_id_tables[$fieldtablename]))
			{
				$fieldtablename = $product_id_tables[$fieldtablename];
				$fieldcolname = "productname";
			}
			if($fieldname == 'campaignid' && $module=='Potentials')
			{
				$fieldtablename = "vtiger_campaign".$module;
				$fieldcolname = "campaignname";
			}
			if($fieldname == 'currency_id' && $fieldtablename=='vtiger_pricebook')
			{
				$fieldtablename = "vtiger_currency_info".$module;
				$fieldcolname = "currency_name";
			}

			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			$fieldlabel1 = str_replace(" ","_",$fieldlabel);
			$optionvalue = $fieldtablename.":".$fieldcolname.":".$module."_".$fieldlabel1.":".$fieldname.":".$fieldtypeofdata;
			$this->adv_rel_fields[$fieldtypeofdata][] = '$'.$module.'#'.$fieldname.'$'."::".$module." ".$fieldlabel;
			//added to escape attachments fields in Reports as we have multiple attachments
                        if($module != 'HelpDesk' || $fieldname !='filename')
				$module_columnlist[$optionvalue] = $fieldlabel;
		}
		$log->info("Reports :: FieldColumns->Successfully returned ColumnslistbyBlock".$module.$block);
		return $module_columnlist;
	}

	/** Function to set the standard filter vtiger_fields for the given vtiger_report
	 *  This function gets the standard filter vtiger_fields for the given vtiger_report
	 *  and set the values to the corresponding variables
	 *  It accepts the repordid as argument 
	 */

	function getSelectedStandardCriteria($reportid)
	{
		global $adb;
		$sSQL = "select vtiger_reportdatefilter.* from vtiger_reportdatefilter inner join vtiger_report on vtiger_report.reportid = vtiger_reportdatefilter.datefilterid where vtiger_report.reportid=?";
		//$sSQL = "select siprod_type_demandes.* from siprod_type_demandes;
		$result = $adb->pquery($sSQL, array());
		$result = $adb->pquery($sSQL, array($reportid));
		$selectedstdfilter = $adb->fetch_array($result);

		 $this->stdselectedcolumn = $selectedstdfilter["datecolumnname"];
		//$this->stdselectedcolumn = $selectedstdfilter["nom"];		
		$this->stdselectedfilter = $selectedstdfilter["datefilter"];

		if($selectedstdfilter["datefilter"] == "custom")
		{
			if($selectedstdfilter["startdate"] != "0000-00-00")
			{
				$this->startdate = $selectedstdfilter["startdate"]; 
			}
			if($selectedstdfilter["enddate"] != "0000-00-00")
			{
				$this->enddate = $selectedstdfilter["enddate"]; 
			}
		}
	}

	/** Function to get the combo values for the standard filter
	 *  This function get the combo values for the standard filter for the given vtiger_report
	 *  and return a HTML string 
	 */

	function getSelectedStdFilterCriteria($selecteddatefilter = "")
	{
		global $mod_strings;

		$datefiltervalue = Array("custom","prevfy","thisfy","nextfy","prevfq","thisfq","nextfq",
				"yesterday","today","tomorrow","lastweek","thisweek","nextweek","lastmonth","thismonth",
				"nextmonth","last7days","last30days", "last60days","last90days","last120days",
				"next30days","next60days","next90days","next120days"
				);

		$datefilterdisplay = Array("Custom","Previous FY", "Current FY","Next FY","Previous FQ","Current FQ","Next FQ","Yesterday",
				"Today","Tomorrow","Last Week","Current Week","Next Week","Last Month","Current Month",
				"Next Month","Last 7 Days","Last 30 Days","Last 60 Days","Last 90 Days","Last 120 Days",
				"Next 7 Days","Next 30 Days","Next 60 Days","Next 90 Days","Next 120 Days"
				);

		for($i=0;$i<count($datefiltervalue);$i++)
		{
			if($selecteddatefilter == $datefiltervalue[$i])
			{
				$sshtml .= "<option selected value='".$datefiltervalue[$i]."'>".$mod_strings[$datefilterdisplay[$i]]."</option>";
			}else
			{
				$sshtml .= "<option value='".$datefiltervalue[$i]."'>".$mod_strings[$datefilterdisplay[$i]]."</option>";
			}
		}

		return $sshtml;
	}

	/** Function to get the selected standard filter columns 
	 *  This function returns the selected standard filter criteria 
	 *  which is selected for vtiger_reports as an array
	 *  Array stdcriteria_list[fieldtablename:fieldcolname:module_fieldlabel1]=fieldlabel
	 */

	function getStdCriteriaByModule($module)
	{	
		global $adb;
		global $log;
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');		

		$tabid = getTabid($module);
		foreach($this->module_list[$module] as $key=>$blockid)
		{
			$blockids[] = $blockid;
		}	
		$blockids = implode(",",$blockids);	

		$params = array($tabid, $blockids);
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0)
		{
			//uitype 6 and 23 added for start_date,EndDate,Expected Close Date
			$sql = "select * from vtiger_field where vtiger_field.tabid=? and (vtiger_field.uitype =5 or vtiger_field.uitype = 6 or vtiger_field.uitype = 23 or vtiger_field.displaytype=2) and vtiger_field.block in (". generateQuestionMarks($block) .") and vtiger_field.presence in (0,2) order by vtiger_field.sequence";
		}
		else
		{
			$profileList = getCurrentUserProfileList();
			$sql = "select * from vtiger_field inner join vtiger_tab on vtiger_tab.tabid = vtiger_field.tabid inner join vtiger_profile2field on vtiger_profile2field.fieldid=vtiger_field.fieldid inner join vtiger_def_org_field on vtiger_def_org_field.fieldid=vtiger_field.fieldid  where vtiger_field.tabid=? and (vtiger_field.uitype =5 or vtiger_field.displaytype=2) and vtiger_profile2field.visible=0 and vtiger_def_org_field.visible=0 and vtiger_field.block in (". generateQuestionMarks($block) .") and vtiger_field.presence in (0,2)";
			if (count($profileList) > 0) {
				$sql .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")";
				array_push($params, $profileList);
			}
			$sql .= " order by vtiger_field.sequence";
		}

		$result = $adb->pquery($sql, $params);

		while($criteriatyperow = $adb->fetch_array($result))
		{
			$fieldtablename = $criteriatyperow["tablename"];
			$fieldcolname = $criteriatyperow["columnname"];
			$fieldlabel = $criteriatyperow["fieldlabel"];

			if($fieldtablename == "vtiger_crmentity")
			{
				$fieldtablename = $fieldtablename.$module;
			}
			$fieldlabel1 = str_replace(" ","_",$fieldlabel);
			$optionvalue = $fieldtablename.":".$fieldcolname.":".$module."_".$fieldlabel1;
			$stdcriteria_list[$optionvalue] = $fieldlabel;
		}

		$log->info("Reports :: StdfilterColumns->Successfully returned Stdfilter for".$module);
		return $stdcriteria_list;

	}

	/** Function to form a javascript to determine the start date and end date for a standard filter 
	 *  This function is to form a javascript to determine
	 *  the start date and End date from the value selected in the combo lists
	 */

	function getCriteriaJS()
	{
		$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
		$tomorrow  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
		$yesterday  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));

		$currentmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));
		$currentmonth1 = date("Y-m-t");
		$lastmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
		$lastmonth1 = date("Y-m-t", strtotime("-1 Month"));
		$nextmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")+1, "01",   date("Y")));
		$nextmonth1 = date("Y-m-t", strtotime("+1 Month"));

		$lastweek0 = date("Y-m-d",strtotime("-2 week Monday"));
		$lastweek1 = date("Y-m-d",strtotime("-1 week Sunday"));

		$thisweek0 = date("Y-m-d",strtotime("-1 week Monday"));
		$thisweek1 = date("Y-m-d",strtotime("this Sunday"));

		$nextweek0 = date("Y-m-d",strtotime("this Monday"));
		$nextweek1 = date("Y-m-d",strtotime("+1 week Sunday"));

		$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
		$next30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));
		$next60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
		$next90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+89, date("Y")));
		$next120days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+119, date("Y")));

		$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-6, date("Y")));
		$last30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-29, date("Y")));
		$last60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-59, date("Y")));
		$last90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-89, date("Y")));
		$last120days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-119, date("Y")));

		$currentFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")));
		$currentFY1 = date("Y-m-t",mktime(0, 0, 0, "12", date("d"),   date("Y")));
		$lastFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")-1));
		$lastFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")-1));
		$nextFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")+1));
		$nextFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")+1));

		if(date("m") <= 3)
		{
			$cFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
			$cFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
			$nFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
			$nFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
			$pFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")-1));
			$pFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")-1));
		}else if(date("m") > 3 and date("m") <= 6)
		{
			$pFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
			$pFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
			$cFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
			$cFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
			$nFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
			$nFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));

		}else if(date("m") > 6 and date("m") <= 9)
		{
			$nFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
			$nFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));
			$pFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
			$pFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
			$cFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
			$cFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));
		}
		else if(date("m") > 9 and date("m") <= 12)
		{
			$nFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")+1));
			$nFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")+1));
			$pFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
			$pFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));
			$cFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
			$cFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));

		}

		$sjsStr = '<script language="JavaScript" type="text/javaScript">
			function showDateRange( type )
			{
				if (type!="custom")
				{
					document.NewReport.startdate.readOnly=true
					document.NewReport.enddate.readOnly=true
					getObj("jscal_trigger_date_start").style.visibility="hidden"
					getObj("jscal_trigger_date_end").style.visibility="hidden"
				}
				else
				{
					document.NewReport.startdate.readOnly=false
					document.NewReport.enddate.readOnly=false
					getObj("jscal_trigger_date_start").style.visibility="visible"
					getObj("jscal_trigger_date_end").style.visibility="visible"
				}
				if( type == "today" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($today).'";
				}
				else if( type == "yesterday" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($yesterday).'";
					document.NewReport.enddate.value = "'.getDisplayDate($yesterday).'";
				}
				else if( type == "tomorrow" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($tomorrow).'";
					document.NewReport.enddate.value = "'.getDisplayDate($tomorrow).'";
				}        
				else if( type == "thisweek" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($thisweek0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($thisweek1).'";
				}                
				else if( type == "lastweek" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($lastweek0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($lastweek1).'";
				}                
				else if( type == "nextweek" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($nextweek0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($nextweek1).'";
				}                

				else if( type == "thismonth" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($currentmonth0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($currentmonth1).'";
				}                

				else if( type == "lastmonth" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($lastmonth0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($lastmonth1).'";
				}             
				else if( type == "nextmonth" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($nextmonth0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($nextmonth1).'";
				}           
				else if( type == "next7days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($next7days).'";
				}                
				else if( type == "next30days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($next30days).'";
				}                
				else if( type == "next60days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($next60days).'";
				}                
				else if( type == "next90days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($next90days).'";
				}        
				else if( type == "next120days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($today).'";
					document.NewReport.enddate.value = "'.getDisplayDate($next120days).'";
				}        
				else if( type == "last7days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($last7days).'";
					document.NewReport.enddate.value =  "'.getDisplayDate($today).'";
				}                        
				else if( type == "last30days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($last30days).'";
					document.NewReport.enddate.value = "'.getDisplayDate($today).'";
				}                
				else if( type == "last60days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($last60days).'";
					document.NewReport.enddate.value = "'.getDisplayDate($today).'";
				}        
				else if( type == "last90days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($last90days).'";
					document.NewReport.enddate.value = "'.getDisplayDate($today).'";
				}        
				else if( type == "last120days" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($last120days).'";
					document.NewReport.enddate.value = "'.getDisplayDate($today).'";
				}        
				else if( type == "thisfy" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($currentFY0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($currentFY1).'";
				}                
				else if( type == "prevfy" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($lastFY0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($lastFY1).'";
				}                
				else if( type == "nextfy" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($nextFY0).'";
					document.NewReport.enddate.value = "'.getDisplayDate($nextFY1).'";
				}                
				else if( type == "nextfq" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($nFq).'";
					document.NewReport.enddate.value = "'.getDisplayDate($nFq1).'";
				}                        
				else if( type == "prevfq" )
				{

					document.NewReport.startdate.value = "'.getDisplayDate($pFq).'";
					document.NewReport.enddate.value = "'.getDisplayDate($pFq1).'";
				}                
				else if( type == "thisfq" )
				{
					document.NewReport.startdate.value = "'.getDisplayDate($cFq).'";
					document.NewReport.enddate.value = "'.getDisplayDate($cFq1).'";
				}                
				else
				{
					document.NewReport.startdate.value = "";
					document.NewReport.enddate.value = "";
				}        
			}        
		</script>';

		return $sjsStr;
	}
function getEscapedColumns($selectedfields)
	{
		$fieldname = $selectedfields[3];
		if($fieldname == "parent_id")
		{
			if($this->primarymodule == "HelpDesk" && $selectedfields[0] == "vtiger_crmentityRelHelpDesk")
			{
				$querycolumn = "case vtiger_crmentityRelHelpDesk.setype when 'Accounts' then vtiger_accountRelHelpDesk.accountname when 'Contacts' then vtiger_contactdetailsRelHelpDesk.lastname End"." '".$selectedfields[2]."', vtiger_crmentityRelHelpDesk.setype 'Entity_type'";
				return $querycolumn;
			}
			if($this->primarymodule == "Products" || $this->secondarymodule == "Products")
			{
				$querycolumn = "case vtiger_crmentityRelProducts.setype when 'Accounts' then vtiger_accountRelProducts.accountname when 'Leads' then vtiger_leaddetailsRelProducts.lastname when 'Potentials' then vtiger_potentialRelProducts.potentialname End"." '".$selectedfields[2]."', vtiger_crmentityRelProducts.setype 'Entity_type'";
			}
			if($this->primarymodule == "Calendar" || $this->secondarymodule == "Calendar")
			{
				$querycolumn = "case vtiger_crmentityRelCalendar.setype when 'Accounts' then vtiger_accountRelCalendar.accountname when 'Leads' then vtiger_leaddetailsRelCalendar.lastname when 'Potentials' then vtiger_potentialRelCalendar.potentialname when 'Quotes' then vtiger_quotesRelCalendar.subject when 'PurchaseOrder' then vtiger_purchaseorderRelCalendar.subject when 'Invoice' then vtiger_invoiceRelCalendar.subject End"." '".$selectedfields[2]."', vtiger_crmentityRelCalendar.setype 'Entity_type'";
			}
		}
		return $querycolumn;
	}
	function getaccesfield($module)
	{
		global $current_user;
		global $adb;
		$access_fields = Array();
		
		$profileList = getCurrentUserProfileList();
		$query = "select vtiger_field.fieldname from vtiger_field inner join vtiger_profile2field on vtiger_profile2field.fieldid=vtiger_field.fieldid inner join vtiger_def_org_field on vtiger_def_org_field.fieldid=vtiger_field.fieldid where";
		$params = array();
		if($module == "Calendar")
		{
			$query .= " vtiger_field.tabid in (9,16) and vtiger_field.displaytype in (1,2,3) and vtiger_profile2field.visible=0 and vtiger_def_org_field.visible=0 and vtiger_field.presence in (0,2)";
			if (count($profileList) > 0) {				
				$query .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")";
				array_push($params, $profileList);
			}
			$query .= " group by vtiger_field.fieldid order by block,sequence";
		}
		else
		{
			array_push($params, $this->primodule, $this->secmodule);
			$query .= " vtiger_field.tabid in (select tabid from vtiger_tab where vtiger_tab.name in (?,?)) and vtiger_field.displaytype in (1,2,3) and vtiger_profile2field.visible=0 and vtiger_def_org_field.visible=0 and vtiger_field.presence in (0,2)";
			if (count($profileList) > 0) {				
				$query .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")";
				array_push($params, $profileList);
			}
			$query .= " group by vtiger_field.fieldid order by block,sequence";
		}
		$result = $adb->pquery($query, $params);

		
		while($collistrow = $adb->fetch_array($result))
		{
			$access_fields[] = $collistrow["fieldname"];
		}
		return $access_fields;
	}

	/** Function to set the order of grouping and to find the columns responsible
	 *  to the grouping
	 *  This function accepts the vtiger_reportid as variable,sets the variable ascdescorder[] to the sort order and
	 *  returns the array array_list which has the column responsible for the grouping
	 *  Array array_list[0]=columnname
	 */


	function getSelctedSortingColumns($reportid)
	{

		global $adb;
		global $log;

		$sreportsortsql = "select vtiger_reportsortcol.* from vtiger_report";
		$sreportsortsql .= " inner join vtiger_reportsortcol on vtiger_report.reportid = vtiger_reportsortcol.reportid";
		$sreportsortsql .= " where vtiger_report.reportid =? order by vtiger_reportsortcol.sortcolid";

		$result = $adb->pquery($sreportsortsql, array($reportid));
		$noofrows = $adb->num_rows($result);

		for($i=0; $i<$noofrows; $i++)
		{
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$sort_values = $adb->query_result($result,$i,"sortorder");
			$this->ascdescorder[] = $sort_values;
			$array_list[] = $fieldcolname;
		}

		$log->info("Reports :: Successfully returned getSelctedSortingColumns");
		return $array_list;
	}

	/** Function to get the selected columns list for a selected vtiger_report
	 *  This function accepts the vtiger_reportid as the argument and get the selected columns
	 *  for the given vtiger_reportid and it forms a combo lists and returns
	 *  HTML of the combo values
	 */

	function getSelectedColumnsList($reportid)
	{
		global $adb;
		global $modules;
		global $log,$current_user;

		$ssql = "select vtiger_selectcolumn.* from vtiger_report inner join vtiger_selectquery on vtiger_selectquery.queryid = vtiger_report.queryid";
		$ssql .= " left join vtiger_selectcolumn on vtiger_selectcolumn.queryid = vtiger_selectquery.queryid";
		$ssql .= " where vtiger_report.reportid = ?";
		$ssql .= " order by vtiger_selectcolumn.columnindex";
		$result = $adb->pquery($ssql, array($reportid));
		$permitted_fields = Array();
	
		$selected_mod = split(":",$this->secmodule);
		array_push($selected_mod,$this->primodule);
		
		while($columnslistrow = $adb->fetch_array($result))
		{
			$fieldname ="";
			$fieldcolname = $columnslistrow["columnname"];

			$selmod_field_disabled = true;
			foreach($selected_mod as $smod){
				if((stripos($fieldcolname,":".$smod."_")>-1) && vtlib_isModuleActive($smod)){
					$selmod_field_disabled = false;
					break;
				}
			}
			if($selmod_field_disabled==false){
				list($tablename,$colname,$module_field,$fieldname,$single) = split(":",$fieldcolname);
				require('user_privileges/user_privileges_'.$current_user->id.'.php');
				list($module,$field) = split("_",$module_field);
				if(sizeof($permitted_fields) == 0 && $is_admin == false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1)
				{
					$permitted_fields = $this->getaccesfield($module);	
				}
				$querycolumns = $this->getEscapedColumns($selectedfields);
				$fieldlabel = trim(str_replace($module," ",$module_field));
				$mod_arr=explode('_',$fieldlabel);
	                        $mod = ($mod_arr[0] == '')?$module:$mod_arr[0];
				$fieldlabel = trim(str_replace("_"," ",$fieldlabel));
				//modified code to support i18n issue 
				$mod_lbl = getTranslatedString($mod,$module); //module
				$fld_lbl = getTranslatedString($fieldlabel,$module); //fieldlabel
				$fieldlabel = $mod_lbl." ".$fld_lbl;
				if(CheckFieldPermission($fieldname,$mod) != 'true')
				{
						$shtml .= "<option permission='no' value=\"".$fieldcolname."\" disabled = 'true'>".$fieldlabel."</option>";
				}
				else
				{
						$shtml .= "<option permission='yes' value=\"".$fieldcolname."\">".$fieldlabel."</option>";
				}
			}
			//end
		}
		$log->info("ReportRun :: Successfully returned getQueryColumnsList".$reportid);
		return $shtml;		
	}
	function getAdvancedFilterList($reportid)
	{
		global $adb;
		global $modules;
		global $log;
		$ssql = 'select vtiger_relcriteria.* from vtiger_report inner join vtiger_relcriteria on vtiger_relcriteria.queryid = vtiger_report.queryid left join vtiger_selectquery on vtiger_relcriteria.queryid = vtiger_selectquery.queryid';
		$ssql.= " where vtiger_report.reportid = ? order by vtiger_relcriteria.columnindex";

		$result = $adb->pquery($ssql, array($reportid));

		while($relcriteriarow = $adb->fetch_array($result))
		{
			$this->advft_column[] = $relcriteriarow["columnname"];
			$this->advft_option[] = $relcriteriarow["comparator"];
			$advfilterval = $relcriteriarow["value"];
			$col = explode(":",$relcriteriarow["columnname"]);
			$temp_val = explode(",",$relcriteriarow["value"]);
			if($col[4] == 'D' || ($col[4] == 'T' && $col[1] != 'time_start' && $col[1] != 'time_end') || ($col[4] == 'DT')) 
			{
					$val = Array();
					for($x=0;$x<count($temp_val);$x++)
					{
						list($temp_date,$temp_time) = explode(" ",$temp_val[$x]);
						$temp_date = getDisplayDate(trim($temp_date));
						if(trim($temp_time) != '')
							$temp_date .= ' '.$temp_time;
						$val[$x]=$temp_date;
						if($x == 0)
							$advfilterval = $val[$x];
						else
							$advfilterval = ','.$val[$x];
					}

			}

			$this->advft_value[] = $advfilterval;
		}
		$log->info("Reports :: Successfully returned getAdvancedFilterList");
		return true;
	}
	//<<<<<<<<advanced filter>>>>>>>>>>>>>>

	/** Function to get the list of vtiger_report folders when Save and run  the vtiger_report
	 *  This function gets the vtiger_report folders from database and form
	 *  a combo values of the folders and return 
	 *  HTML of the combo values
	 */

	function sgetRptFldrSaveReport()
	{
		global $adb;
		global $log;

		$sql = "select * from vtiger_reportfolder order by folderid";
		$result = $adb->pquery($sql, array());
		$reportfldrow = $adb->fetch_array($result);
		$x = 0;
		do
		{
			$shtml .= "<option value='".$reportfldrow['folderid']."'>".$reportfldrow['foldername']."</option>";
		}while($reportfldrow = $adb->fetch_array($result));

		$log->info("Reports :: Successfully returned sgetRptFldrSaveReport");
		return $shtml;
	}

	/** Function to get the column to total vtiger_fields in Reports 
	 *  This function gets columns to total vtiger_field 
	 *  and generated the html for that vtiger_fields
	 *  It returns the HTML of the vtiger_fields along with the check boxes
	 */

	function sgetColumntoTotal($primarymodule,$secondarymodule)
	{
		$options = Array();
		$options []= $this->sgetColumnstoTotalHTML($primarymodule,0);
		if(!empty($secondarymodule))
		{
			//$secondarymodule = explode(":",$secondarymodule);
			for($i=0;$i < count($secondarymodule) ;$i++)
			{
				$options []= $this->sgetColumnstoTotalHTML($secondarymodule[$i],($i+1));
			}
		}
		return $options;
	}

	/** Function to get the selected columns of total vtiger_fields in Reports
	 *  This function gets selected columns of total vtiger_field
	 *  and generated the html for that vtiger_fields
	 *  It returns the HTML of the vtiger_fields along with the check boxes
	 */


	function sgetColumntoTotalSelected($primarymodule,$secondarymodule,$reportid)
	{
		global $adb;
		global $log;
		$options = Array();
		if($reportid != "")
		{
			$ssql = "select vtiger_reportsummary.* from vtiger_reportsummary inner join vtiger_report on vtiger_report.reportid = vtiger_reportsummary.reportsummaryid where vtiger_report.reportid=?";
			$result = $adb->pquery($ssql, array($reportid));
			if($result)
			{
				$reportsummaryrow = $adb->fetch_array($result);

				do
				{
					$this->columnssummary[] = $reportsummaryrow["columnname"];

				}while($reportsummaryrow = $adb->fetch_array($result));
			}
		}	
		$options []= $this->sgetColumnstoTotalHTML($primarymodule,0);
		if($secondarymodule != "")
		{
			$secondarymodule = explode(":",$secondarymodule);
			for($i=0;$i < count($secondarymodule) ;$i++)
			{
				$options []= $this->sgetColumnstoTotalHTML($secondarymodule[$i],($i+1));
			}
		}

		$log->info("Reports :: Successfully returned sgetColumntoTotalSelected");
		return $options;
	
	}

	/** Function to form the HTML for columns to total	
	 *  This function formulates the HTML format of the
	 *  vtiger_fields along with four checkboxes
	 *  It returns the HTML of the vtiger_fields along with the check boxes
	 */


	function sgetColumnstoTotalHTML($module)
	{
		//retreive the vtiger_tabid	
		global $adb;
		global $log;
		global $current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
		$tabid = getTabid($module);
		$escapedchars = Array('_SUM','_AVG','_MIN','_MAX');
		$sparams = array($tabid);
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] ==0)
		{
			$ssql = "select * from vtiger_field inner join vtiger_tab on vtiger_tab.tabid = vtiger_field.tabid where vtiger_field.uitype != 50 and vtiger_field.tabid=? and vtiger_field.displaytype in (1,2,3) and vtiger_field.presence in (0,2) ";		
		}
		else
		{
			$profileList = getCurrentUserProfileList();
			$ssql = "select * from vtiger_field inner join vtiger_tab on vtiger_tab.tabid = vtiger_field.tabid inner join vtiger_def_org_field on vtiger_def_org_field.fieldid=vtiger_field.fieldid inner join vtiger_profile2field on vtiger_profile2field.fieldid=vtiger_field.fieldid  where vtiger_field.uitype != 50 and vtiger_field.tabid=? and vtiger_field.displaytype in (1,2,3) and vtiger_def_org_field.visible=0 and vtiger_profile2field.visible=0 and vtiger_field.presence in (0,2)";
			if (count($profileList) > 0) {
				$ssql .= " and vtiger_profile2field.profileid in (". generateQuestionMarks($profileList) .")";
				array_push($sparams, $profileList);
			}
		}

		//Added to avoid display the Related fields (Account name,Vandor name,product name, etc) in Report Calculations(SUM,AVG..)			
		switch($tabid)
		{
			case 2://Potentials
				//ie. Campaign name will not displayed in Potential's report calcullation
				$ssql.= " and vtiger_field.fieldname not in ('campaignid')";
				break;
			case 4://Contacts
				$ssql.= " and vtiger_field.fieldname not in ('account_id')";
				break;
			case 6://Accounts
				$ssql.= " and vtiger_field.fieldname not in ('account_id')";
				break;
			case 9://Calandar
				$ssql.= " and vtiger_field.fieldname not in ('parent_id','contact_id')";
				break;
			case 13://Trouble tickets(HelpDesk)
				$ssql.= " and vtiger_field.fieldname not in ('parent_id','product_id')";
				break;
			case 14://Products
				$ssql.= " and vtiger_field.fieldname not in ('vendor_id','product_id')";
				break;
			case 20://Quotes
				$ssql.= " and vtiger_field.fieldname not in ('potential_id','assigned_user_id1','account_id')";
				break;
			case 21://Purchase Order
				$ssql.= " and vtiger_field.fieldname not in ('contact_id','vendor_id')";
				break;
			case 22://SalesOrder
				$ssql.= " and vtiger_field.fieldname not in ('potential_id','account_id','contact_id','quote_id')";
				break;
			case 23://Invoice
				$ssql.= " and vtiger_field.fieldname not in ('salesorder_id','contact_id','account_id')";
				break;
			case 26://Campaings
				$ssql.= " and vtiger_field.fieldname not in ('product_id')";
				break;

		}

		$ssql.= " order by sequence";

		$result = $adb->pquery($ssql, $sparams);
		$columntototalrow = $adb->fetch_array($result);
		$options_list = Array();	
		do
		{
			$typeofdata = explode("~",$columntototalrow["typeofdata"]);

			if($typeofdata[0] == "N" || $typeofdata[0] == "I")
			{
				$options = Array();
				if(isset($this->columnssummary))
				{
					$selectedcolumn = "";
					$selectedcolumn1 = "";

					for($i=0;$i < count($this->columnssummary) ;$i++)
					{
						$selectedcolumnarray = explode(":",$this->columnssummary[$i]);
						$selectedcolumn = $selectedcolumnarray[1].":".$selectedcolumnarray[2].":".
							str_replace($escapedchars,"",$selectedcolumnarray[3]);

						if ($selectedcolumn != $columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.str_replace(" ","_",$columntototalrow['fieldlabel']))
						{
							$selectedcolumn = "";
						}else
						{
							$selectedcolumn1[$selectedcolumnarray[4]] = $this->columnssummary[$i];
						}

					}
					if(isset($_REQUEST["record"]) && $_REQUEST["record"] != '')
					{
						$options['label'][] = getTranslatedString($columntototalrow['tablabel']).' -'.getTranslatedString($columntototalrow['fieldlabel']);
					}	

					$columntototalrow['fieldlabel'] = str_replace(" ","_",$columntototalrow['fieldlabel']);
					$options []= getTranslatedString($columntototalrow['tablabel']).' - '.getTranslatedString($columntototalrow['fieldlabel']);
					if($selectedcolumn1[2] == "cb:".$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel']."_SUM:2")
					{
						$options []=  '<input checked name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_SUM:2" type="checkbox" value="">';					    
					}else
					{
						$options []=  '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_SUM:2" type="checkbox" value="">';
					}
					if($selectedcolumn1[3] == "cb:".$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel']."_AVG:3")
					{
						$options []=  '<input checked name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_AVG:3" type="checkbox" value="">';
					}else
					{
						$options []=  '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_AVG:3" type="checkbox" value="">';
					}

					if($selectedcolumn1[4] == "cb:".$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel']."_MIN:4")
					{
						$options []=  '<input checked name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MIN:4" type="checkbox" value="">';
					}else
					{
						$options []=  '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MIN:4" type="checkbox" value="">';
					}

					if($selectedcolumn1[5] == "cb:".$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel']."_MAX:5")
					{
						$options []=  '<input checked name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MAX:5" type="checkbox" value="">';
					}else
					{
						$options []=  '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MAX:5" type="checkbox" value="">';
					}
				}else
				{
					$options []= getTranslatedString($columntototalrow['tablabel']).' - '.getTranslatedString($columntototalrow['fieldlabel']);
					$options []= '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_SUM:2" type="checkbox" value="">';
					$options []= '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_AVG:3" type="checkbox" value="" >';
					$options []= '<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MIN:4"type="checkbox" value="" >';
					$options [] ='<input name="cb:'.$columntototalrow['tablename'].':'.$columntototalrow['columnname'].':'.$columntototalrow['fieldlabel'].'_MAX:5" type="checkbox" value="" >';	
				}
				$options_list [] = $options;
			}
		}while($columntototalrow = $adb->fetch_array($result));

		$log->info("Reports :: Successfully returned sgetColumnstoTotalHTML");
		return $options_list;
	}
}

/** Function to get the primary module list in vtiger_reports
 *  This function generates the list of primary modules in vtiger_reports
 *  and returns an array of permitted modules 
 */

function getReportsModuleList($focus)
{
	global $adb;
	global $app_list_strings;
	//global $report_modules;	
	global $mod_strings;
	$modules = Array();
	foreach($focus->module_list as $key=>$value)
	{
			if(isPermitted($key,'index') == "yes")
			{
				$count_flag = 1;
				$modules [$key] = getTranslatedString($key,$key);
			}
			
	}
	return $modules;
}
/** Function to get the Related module list in vtiger_reports
 *  This function generates the list of secondary modules in vtiger_reports
 *  and returns the related module as an Array 
 */

function getReportRelatedModules($module,$focus)
{
	global $app_list_strings;
	global $related_modules;
	global $mod_strings;
	$optionhtml = Array();
	if(vtlib_isModuleActive($module)){
		foreach($focus->related_modules[$module] as $rel_modules)
		{
			if(isPermitted($rel_modules,'index') == "yes")
			{
				$optionhtml []= $rel_modules;		
			}
		}
	}


	return $optionhtml;
}


?>
