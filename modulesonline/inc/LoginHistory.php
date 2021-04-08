<?php

require_once ("config/config_inc.php");
require_once (PATH_INC."/db_mysql.inc");
require_once (PATH_DAO."/Mysql.php");
require_once (PATH_DAO."/fonctions_inc.php");

class LoginHistory {
	var $log;
	var $db;

	// Stored vtiger_fields
	var $login_id;
	var $user_name;
	var $user_ip;
	var $login_time;
	var $logout_time;
	var $status;
	
	
	function LoginHistory() {
		//$this->log = LoggerManager::getLogger('loginhistory');
		
	}
	
	function getHistoryListViewHeader()
	{
		global $log;
		$log->debug("Entering getHistoryListViewHeader method ...");
		global $app_strings;
		
		//$header_array = array($app_strings['LBL_LIST_USER_NAME'], $app_strings['LBL_LIST_USERIP'], $app_strings['LBL_LIST_SIGNIN'], $app_strings['LBL_LIST_SIGNOUT'], $app_strings['LBL_LIST_STATUS']);

		$log->debug("Exiting getHistoryListViewHeader method ...");
		return $header_array;
		
	}

/**
  * Function to get the Login History values of the User.
  * @param $navigation_array - Array values to navigate through the number of entries.
  * @param $sortorder - DESC
  * @param $orderby - login_time
  * Returns the login history entries in an array format.
**/
	function getHistoryListViewEntries($username, $navigation_array, $sorder='', $orderby='')
	{
		global $log;
		$log->debug("Entering getHistoryListViewEntries() method ...");
		global $adb, $current_user;	
		
		if($sorder != '' && $order_by != '')
	       		$list_query = "Select * from interf_loginhistory where user_name=? order by ".$order_by." ".$sorder;
		else
				$list_query = "Select * from interf_loginhistory where user_name=? order by ".$this->default_order_by." ".$this->default_sort_order;

		$result = $adb->pquery($list_query, array($username));
		$entries_list = array();
		
	if($navigation_array['end_val'] != 0)
	{
		for($i = $navigation_array['start']; $i <= $navigation_array['end_val']; $i++)
		{
			$entries = array();
			$loginid = $adb->query_result($result, $i-1, 'login_id');

			$entries[] = $adb->query_result($result, $i-1, 'user_name');
			$entries[] = $adb->query_result($result, $i-1, 'user_ip');
			$entries[] = $adb->query_result($result, $i-1, 'login_time');
			$entries[] = $adb->query_result($result, $i-1, 'logout_time');
			$entries[] = $adb->query_result($result, $i-1, 'status');

			$entries_list[] = $entries;
		}	
		$log->debug("Exiting getHistoryListViewEntries() method ...");
		return $entries_list;
	}	
	}
	
	/** Function that Records the Login info of the User 
	 *  @param ref variable $usname :: Type varchar
	 *  @param ref variable $usip :: Type varchar
	 *  @param ref variable $intime :: Type timestamp
	 *  Returns the query result which contains the details of User Login Info
	*/
	function user_login(&$usname,&$usip,&$intime)
	{
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();
		
		//Kiran: Setting logout time to '0000-00-00 00:00:00' instead of null
		$query .= "Insert into interf_loginhistory (user_name, user_ip, logout_time, login_time, status) ";
		$query .= "values ('".$usname."','".$usip."','0000-00-00 00:00:00','".$intime."','Signed in')";
		//echo $query; 
		$result = $db->Query($query);
		return $result;
	}
	
	/** Function that Records the Logout info of the User 
	 *  @param ref variable $usname :: Type varchar
	 *  @param ref variable $usip :: Type varchar
	 *  @param ref variable $outime :: Type timestamp
	 *  Returns the query result which contains the details of User Logout Info
	*/
	function user_logout(&$usname,&$usip,&$outtime)
	{
		$db = Mysql::getInstance(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);
		$db->Open();		
		$logid_qry = "SELECT max(login_id) AS login_id from interf_loginhistory where user_name='".$usname."' and user_ip='".$usip."'";
		$result = $db->Query($logid_qry);
		$loghist = $db->FetchAllArrays($result);

		if ($loghist['login_id'] == '')
                {
                        return;
                }
		// update the user login info.
		$query = "Update interf_loginhistory set logout_time ='".$outtime."', status='Signed off' where login_id = '".$loginid."'";
		$result = $db->Query($logid_qry);
    }

	/** Function to create list query 
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Query.
	*/
  	function create_list_query(&$order_by, &$where)
  	{
		// Determine if the vtiger_account name is present in the where clause.
		global $current_user;
		$query = "SELECT user_name,user_ip, status,
				".$this->db->getDBDateString("login_time")." AS login_time,
				".$this->db->getDBDateString("logout_time")." AS logout_time
			FROM ".$this->table_name;
		if($where != "")
		{
			if(!is_admin($current_user))
			$where .=" AND user_name = '". mysql_real_escape_string($current_user->user_name) ."'";
			$query .= " WHERE ($where)";
		}
		else
		{
			if(!is_admin($current_user))
			$query .= " WHERE user_name = '". mysql_real_escape_string($current_user->user_name) ."'";
		}
		
		if(!empty($order_by))
			$query .= " ORDER BY ". mysql_real_escape_string($order_by);
        
		return $query;
	}

}



?>
