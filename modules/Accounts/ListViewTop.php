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
 * $Header: /cvs/repository/siprodPCCI/modules/Accounts/ListViewTop.php,v 1.1 2010/01/15 18:42:50 isene Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

/**Function to get the top 5 Accounts order by Amount in Descending Order
 *return array $values - array with the title, header and entries like  Array('Title'=>$title,'Header'=>$listview_header,'Entries'=>$listview_entries) where as listview_header and listview_entries are arrays of header and entity values which are returned from function getListViewHeader and getListViewEntries
*/
function getTopAccounts($maxval,$calCnt)
{
	$log = LoggerManager::getLogger('top accounts_list');
	$log->debug("Entering getTopAccounts() method ...");
	require_once("data/Tracker.php");
	require_once('modules/Potentials/Potentials.php');
	require_once('include/logging.php');
	require_once('include/ListView/ListView.php');
	global $app_strings;
	global $adb;
	global $current_language;
	global $current_user;
	$current_module_strings = return_module_language($current_language, "Accounts");

        require('user_privileges/user_privileges_'.$current_user->id.'.php');
        require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

	$list_query = "select vtiger_account.accountid, vtiger_account.accountname, vtiger_account.tickersymbol, sum(vtiger_potential.amount) as amount from vtiger_potential inner join vtiger_crmentity on (vtiger_potential.potentialid=vtiger_crmentity.crmid) inner join vtiger_account on (vtiger_potential.accountid=vtiger_account.accountid) left join vtiger_groups on (vtiger_groups.groupid = vtiger_crmentity.smownerid) where vtiger_crmentity.deleted=0 AND vtiger_crmentity.smownerid='".$current_user->id."' and vtiger_potential.sales_stage not in ('Closed Won', 'Closed Lost','".$app_strings['LBL_CLOSE_WON']."','".$app_strings['LBL_CLOSE_LOST']."')";
	if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1 && $defaultOrgSharingPermission[6] == 3)
	{
		$sec_parameter=getListViewSecurityParameter('Accounts');
		$list_query .= $sec_parameter;

	}
	$list_query .= " group by vtiger_account.accountid, vtiger_account.accountname, vtiger_account.tickersymbol order by amount desc";
	$list_result=$adb->query($list_query);
	$open_accounts_list = array();
	$noofrows = min($adb->num_rows($list_result),$maxval);
	if($calCnt == 'calculateCnt')
	      return $noofrows;

	if (count($list_result)>0)
		for($i=0;$i<$noofrows;$i++) 
		{
			$open_accounts_list[] = Array('accountid' => $adb->query_result($list_result,$i,'accountid'),
					'accountname' => $adb->query_result($list_result,$i,'accountname'),
					'amount' => $adb->query_result($list_result,$i,'amount'),
					'tickersymbol' => $adb->query_result($list_result,$i,'tickersymbol'),
					);								 
		}

	$title=array();
	$title[]='myTopAccounts.gif';
	$title[]=$current_module_strings['LBL_TOP_ACCOUNTS'];
	$title[]='home_myaccount';
	
	$header=array();
	$header[]=$current_module_strings['LBL_LIST_ACCOUNT_NAME'];
	$currencyid=fetchCurrency($current_user->id);
	$rate_symbol = getCurrencySymbolandCRate($currencyid);
	$rate = $rate_symbol['rate'];
	$curr_symbol = $rate_symbol['symbol'];
        $header[]=$current_module_strings['LBL_LIST_AMOUNT'].'('.$curr_symbol.')';
	
	$entries=array();
	foreach($open_accounts_list as $account)
	{
		$value=array();
		$account_fields = array(
				'ACCOUNT_ID' => $account['accountid'],
				'ACCOUNT_NAME' => $account['accountname'],
				'AMOUNT' => ($account['amount']),
				);

		$Top_Accounts = (strlen($account['accountname']) > 20) ? (substr($account['accountname'],0,20).'...') : $account['accountname'];
		$value[]='<a href="index.php?action=DetailView&module=Accounts&record='.$account['accountid'].'">'.$Top_Accounts.'</a>';
		$value[]=convertFromDollar($account['amount'],$rate);
		$entries[$account['accountid']]=$value;	
	}
	$values=Array('ModuleName'=>'Accounts','Title'=>$title,'Header'=>$header,'Entries'=>$entries);
	$log->debug("Exiting getTopAccounts method ...");
	if (($display_empty_home_blocks && count($entries) == 0 ) || (count($entries)>0))
		return $values;
}
?>
