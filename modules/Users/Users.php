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

/*********************************************
 * With modifications by
 * Daniel Jabbour
 * iWebPress Incorporated, www.iwebpress.com
 * djabbour - a t - iwebpress - d o t - com
 ********************************************/

/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/Users/Users.php,v 1.10 2010/05/21 18:42:00 isene Exp $
 * Description: TODO:  To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/Calendar/Activity.php');
require_once('modules/Contacts/Contacts.php');
require_once('data/Tracker.php');
require_once 'include/utils/CommonUtils.php';
require_once 'include/Webservices/Utils.php';

// User is used to store customer information.
 /** Main class for the user module
   *
  */
class Users {
	var $log;
	var $db;
	// Stored fields
	var $id;
	var $authenticated = false;
	var $error_string;
	var $is_admin;
	var $deleted;
/*
	var $tab_name = Array('users','attachments','user2role','asteriskextensions');	
	var $tab_name_index = Array('users'=>'id','attachments'=>'attachmentsid','user2role'=>'userid','asteriskextensions'=>'userid');
	var $column_fields = Array('user_name'=>'','is_admin' =>'','user_password'=>'','confirm_password'=>'',
	'first_name' =>'',
	'last_name' =>'',
	'roleid' =>'',
	'email1' =>'',
	'status' =>'',
	'activity_view' =>'',
	'lead_view' =>'',
	'currency_id' =>'',
	'currency_name' =>'',
	'currency_code' =>'',
	'currency_symbol' =>'',
	'conv_rate' =>'',
	'hour_format' =>'',
	'end_hour' =>'',
	'start_hour' =>'',
	'title' =>'',
	'phone_work' =>'',
	'department' =>'',
	'phone_mobile' =>'',
	'reports_to_id' =>'',
	'phone_other' =>'',
	'email2' =>'',
	'phone_fax' =>'',
	'yahoo_id' =>'',
	'phone_home' =>'',
	'imagename' =>'',
	'date_format' =>'',
	'signature' =>'',
	'description' =>'',
	'reminder_interval' =>'',
	'internal_mailer'=>'',
	'address_street' =>'',
	'address_city' =>'',
	'address_state' =>'',
	'address_postalcode' =>'',
	'address_country' =>'',
	
);
*/
	var $tab_name = Array('users','siprod_users');	
	var $tab_name_index = Array('users'=>'user_id','siprod_users'=>'userid');
	var $column_fields = Array(
	'user_id' =>'',
	'user_login' =>'',
	'user_matricule' =>'',
	'user_numerologin' =>'',
	'user_pwd' =>'',
	'user_name' =>'',
	'user_firstname' =>'',
	'is_admin' =>'',
	
//	'userid' =>'',
	'profilid' =>'',
	'profilename' =>'',
	'statut' =>'',
	'raison' =>'',

	'is_posteur_demande'=>'',
	'is_posteur_incident'=>'',
	'is_traiteur_demande'=>'',
	'is_traiteur_incident'=>'',
	'is_superieur'=>'',
	
);	
//	var $table_name = "users";
//	var $table_index= 'id';
		
	var $table_name = "users";
	var $table_index= 'user_id';
	
	// This is the list of fields that are in the lists.
	var $list_link_field= 'user_name';

	var $list_mode;
	var $popup_type;

	var $search_fields = Array(
		'User Name'=>Array('users'=>'user_name'),
		'Name'=>Array('users'=>'last_name'),
		'First Name'=>Array('users'=>'first_name'),
		'Role'=>Array('user2role'=>'roleid'),
		//'Email'=>Array('users'=>'email1')
	);
	var $search_fields_name = Array(
		'User Name'=>'user_name',
		'Name'=>'last_name',
		'First Name'=>'first_name',
		'Role'=>'roleid', 
		//'Email'=>'email1'
	);

	var $module_name = "Users";

	var $object_name = "User";
	var $user_preferences;
	var $homeorder_array = array('HDB','ALVT','PLVT','QLTQ','CVLVT','HLT','OLV','GRT','OLTSO','ILTI','MNL','OLTPO','LTFAQ', 'UA', 'PA');

	var $encodeFields = Array("first_name", "last_name", "description");

	// This is used to retrieve related fields from form posts.
	var $additional_column_fields = Array('reports_to_name');		

	var $sortby_fields = Array('status','email1','phone_work','is_admin','user_name','last_name');	  

	// This is the list of fields that are in the lists.
	var $list_fields = Array(
		'First Name'=>Array('users'=>'first_name'),
		'Last Name'=>Array('users'=>'last_name'),
		'Role Name'=>Array('user2role'=>'roleid'),
		'User Name'=>Array('users'=>'user_name'),
		'Status'=>Array('users'=>'status'), 
		'Email'=>Array('users'=>'email1'),
		'Admin'=>Array('users'=>'is_admin'),
		'Phone'=>Array('users'=>'phone_work')
	);
	var $list_fields_name = Array(
		'Last Name'=>'last_name',
		'First Name'=>'first_name',
		'Role Name'=>'roleid', 
		'User Name'=>'user_name',
		 'Status'=>'status',
		'Email'=>'email1',
		'Admin'=>'is_admin',	
		'Phone'=>'phone_work'	
	);

	//Default Fields for Email Templates -- Pavani
	var $emailTemplate_defaultFields = array('first_name','last_name','title','department','phone_home','phone_mobile','signature','email1','address_street','address_city','address_state','address_country','address_postalcode');
	
	// This is the list of fields that are in the lists.
	var $default_order_by = "user_name";
	var $default_sort_order = 'ASC';

	var $record_id;
	var $new_schema = true;

	var $DEFAULT_PASSWORD_CRYPT_TYPE = 'MD5';

	/** constructor function for the main user class
            instantiates the Logger class and PearDatabase Class	
  	  *
 	*/
	
	function Users() {
		$this->log = LoggerManager::getLogger('user');
		$this->log->debug("Entering Users() method ...");
		$this->db = new PearDatabase();
		$this->log->debug("Exiting Users() method ...");
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
			$sorder = (($_SESSION['USERS_SORT_ORDER'] != '')?($_SESSION['USERS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder method ...");
		return $sorder;
	}
	
	/**
	 * Function to get order by
	 * return string  $order_by    - fieldname(eg: 'subject')
	 */
	function getOrderBy()
	{
		global $log;
                 $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['USERS_ORDER_BY'] != '')?($_SESSION['USERS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}	
	// Mike Crowe Mod --------------------------------------------------------

	/** Function to set the user preferences in the session
  	  * @param $name -- name:: Type varchar
  	  * @param $value -- value:: Type varchar
  	  *
 	*/
	function setPreference($name, $value){
		if(!isset($this->user_preferences)){
			if(isset($_SESSION["USER_PREFERENCES"]))
				$this->user_preferences = $_SESSION["USER_PREFERENCES"];
			else 
				$this->user_preferences = array();	
		}
		if(!array_key_exists($name,$this->user_preferences )|| $this->user_preferences[$name] != $value){
			$this->log->debug("Saving To Preferences:". $name."=".$value);
			$this->user_preferences[$name] = $value;
			$this->savePreferecesToDB();	

		}
		$_SESSION[$name] = $value;


	}


	/** Function to save the user preferences to db
  	  *
 	*/
	
	function savePreferecesToDB(){
		$data = base64_encode(serialize($this->user_preferences));
		$query = "UPDATE $this->table_name SET user_preferences=? where id=?";
		$result =& $this->db->pquery($query, array($data, $this->id));
		$this->log->debug("SAVING: PREFERENCES SIZE ". strlen($data)."ROWS AFFECTED WHILE UPDATING USER PREFERENCES:".$this->db->getAffectedRowCount($result));
		$_SESSION["USER_PREFERENCES"] = $this->user_preferences;
	}

	/** Function to load the user preferences from db
  	  *
 	*/
	function loadPreferencesFromDB($value){

		if(isset($value) && !empty($value)){
			$this->log->debug("LOADING :PREFERENCES SIZE ". strlen($value));
			$this->user_preferences = unserialize(base64_decode($value));
			$_SESSION = array_merge($this->user_preferences, $_SESSION);
			$this->log->debug("Finished Loading");
			$_SESSION["USER_PREFERENCES"] = $this->user_preferences;


		}

	}


	/**
	 * @return string encrypted password for storage in DB and comparison against DB password.
	 * @param string $user_name - Must be non null and at least 2 characters
	 * @param string $user_password - Must be non null and at least 1 character.
	 * @desc Take an unencrypted username and password and return the encrypted password
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function encrypt_password($user_password, $crypt_type='')
	{
		// encrypt the password.
		$salt = substr($this->column_fields["user_name"], 0, 2);

		// Fix for: http://trac.vtiger.com/cgi-bin/trac.cgi/ticket/4923
		if($crypt_type == '') {
			// Try to get the crypt_type which is in database for the user
			$crypt_type = $this->get_user_crypt_type();
		}

		// For more details on salt format look at: http://in.php.net/crypt
		if($crypt_type == 'MD5') {
			$salt = '$1$' . $salt . '$';
		} else if($crypt_type == 'BLOWFISH') {
			$salt = '$2$' . $salt . '$';
		}

		$encrypted_password = crypt($user_password, $salt);	

		return $encrypted_password;

	}

	
	/** Function to authenticate the current user with the given password
  	  * @param $password -- password::Type varchar
	  * @returns true if authenticated or false if not authenticated
 	*/
	function authenticate_user($password){
		$usr_name = $this->column_fields["user_name"];

		$query = "SELECT * from $this->table_name where user_name='$usr_name' AND user_hash='$password'";
		$result = $this->db->requireSingleResult($query, false);

		if(empty($result)){
			$this->log->fatal("SECURITY: failed login by $usr_name");
			return false;
		}

		return true;
	}
	// fonction de désactivation d'un user pou hodar CRM
	function desable_user(){
		$usr_name = $this->column_fields["user_name"];

		$query = "SELECT * from $this->table_name where user_name='$usr_name'";
		$result = $this->db->requireSingleResult($query, false);
		if(!empty($result))
		{
			$row = $this->db->fetchByAssoc($result);
			$this->id = $row['id'];	
			$query = "UPDATE $this->table_name SET status=? where id=?";
			$this->db->pquery($query, array("Inactive", $row['id']), true, "Error setting status for {$row['user_name']}: ");	
			return true;
		}
		return false;
	}
	
	function user_desabled(){
		$usr_name = $this->column_fields["user_name"];

		$query = "SELECT * from $this->table_name where user_name='$usr_name'";
		$result = $this->db->requireSingleResult($query, false);
		if(!empty($result))
		{
			$row = $this->db->fetchByAssoc($result);
			$statut = $row['status'];
		}	
			if($statut=="Inactive")	return true;
			else return false;
		
	}
	// fonction de test première connexion pour changement de mot de passe pour hodar CRM
	function is_firstconnexion($usrname){
		$query = "SELECT * from loginhistory where user_name='".$usrname."'";
		$result=$this->db->pquery($query,array());
		$nbconnexions=$this->db->num_rows($result);
		if($nbconnexions==0 && $this->is_authenticated()) return true;
		else return false;
	}
	
	/** Function for validation check 
  	  *
 	*/
	function validation_check($validate, $md5, $alt=''){
		$validate = base64_decode($validate);
		if(file_exists($validate) && $handle = fopen($validate, 'rb', true)){
			$buffer = fread($handle, filesize($validate));
			if(md5($buffer) == $md5 || (!empty($alt) && md5($buffer) == $alt)){
				return 1;
			}
			return -1;

		}else{
			return -1;
		}

	}

	/** Function for authorization check 
  	  *
 	*/	
	function authorization_check($validate, $authkey, $i){
		$validate = base64_decode($validate);
		$authkey = base64_decode($authkey);
		if(file_exists($validate) && $handle = fopen($validate, 'rb', true)){
			$buffer = fread($handle, filesize($validate));
			if(substr_count($buffer, $authkey) < $i)
				return -1;
		}else{
			return -1;
		}

	}
	/**
	 * Checks the config.php AUTHCFG value for login type and forks off to the proper module
	 *
	 * @param string $user_password - The password of the user to authenticate
	 * @return true if the user is authenticated, false otherwise
	 */
	function doLogin($user_password) {
		global $AUTHCFG;
		$usr_name = $this->column_fields["user_name"];

		switch (strtoupper($AUTHCFG['authType'])) {
			case 'LDAP':
				$this->log->debug("Using LDAP authentication");
				require_once('modules/Users/authTypes/LDAP.php');
				$result = ldapAuthenticate($this->column_fields["user_name"], $user_password);
				if ($result == NULL) {
					return false;
				} else {
					return true;
				}
				break;

			case 'AD':
				$this->log->debug("Using Active Directory authentication");
				require_once('modules/Users/authTypes/adLDAP.php');
				$adldap = new adLDAP();
				if ($adldap->authenticate($this->column_fields["user_name"],$user_password)) {
					return true;
				} else {
					return false;
				}
				break;

			default:
				$this->log->debug("Using integrated/SQL authentication");
				$encrypted_password = $this->encrypt_password($user_password);
				$query = "SELECT * from $this->table_name where user_name=? AND user_password=?";
				$result = $this->db->requirePsSingleResult($query, array($usr_name, $encrypted_password), false);
				if (empty($result)) {
					return false;
				} else {
					return true;
				}
				break;
		}
		return false;
	}


	/** 
	 * Load a user based on the user_name in $this
	 * @return -- this if load was successul and null if load failed.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function load_user($user_password)
	{
		$usr_name = $this->column_fields["user_name"];
		if(isset($_SESSION['loginattempts']) && ($_SESSION['login_user_name']==$usr_name)){
			$_SESSION['loginattempts'] += 1;
		}else{
			$_SESSION['loginattempts'] = 1;	
		}
		$this->log->debug("Starting user load for $usr_name");
		$validation = 0;
		unset($_SESSION['validation']);
		if( !isset($this->column_fields["user_name"]) || $this->column_fields["user_name"] == "" || !isset($user_password) || $user_password == "")
			return null;

		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f', '866bba5ae0a15180e8613d33b0acc6bd') == -1)$validation = -1;
		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvcG93ZXJlZF9ieV9zdWdhcmNybS5naWY=' , '3d49c9768de467925daabf242fe93cce') == -1)$validation = -1;
		if($this->authorization_check('aW5kZXgucGhw' , 'PEEgaHJlZj0naHR0cDovL3d3dy5zdWdhcmNybS5jb20nIHRhcmdldD0nX2JsYW5rJz48aW1nIGJvcmRlcj0nMCcgc3JjPSdpbmNsdWRlL2ltYWdlcy9wb3dlcmVkX2J5X3N1Z2FyY3JtLmdpZicgYWx0PSdQb3dlcmVkIEJ5IFN1Z2FyQ1JNJz48L2E+', 1) == -1)$validation = -1;

		$authCheck = false;
		$authCheck = $this->doLogin($user_password);

		if(!$authCheck)
		{
			$this->log->warn("User authentication for $usr_name failed");
			return null;
		}

		// Get the fields for the user
		$query = "SELECT * from $this->table_name where user_name='$usr_name'";
		$result = $this->db->requireSingleResult($query, false);

		$row = $this->db->fetchByAssoc($result);
		$this->id = $row['id'];	

		$user_hash = strtolower(md5($user_password));


		// If there is no user_hash is not present or is out of date, then create a new one.
		if(!isset($row['user_hash']) || $row['user_hash'] != $user_hash)
		{
			$query = "UPDATE $this->table_name SET user_hash=? where id=?";
			$this->db->pquery($query, array($user_hash, $row['id']), true, "Error setting new hash for {$row['user_name']}: ");	
		}
		$this->loadPreferencesFromDB($row['user_preferences']);


		if ($row['status'] != "Inactive") $this->authenticated = true;
		/*else
		{
			$_SESSION['compteBloque'] = $mod_strings['LBL_UNACTIVE_USER'];
		}*/

		unset($_SESSION['loginattempts']);
		return $this;
	}

	
	function load_userGID($usr_name, $user_password)
	{
		//$usr_name = $this->column_fields["user_name"];
		$this->column_fields["user_pwd"] = $user_password;
		if(isset($_SESSION['loginattempts']) && ($_SESSION['login_user_name']==$usr_name)){
			$_SESSION['loginattempts'] += 1;
		}else{
			$_SESSION['loginattempts'] = 1;	
		}
		$this->log->debug("Starting user load for $usr_name");
		$validation = 0;
		//echo "profilid = ",$this->column_fields["profilid"];break;
		unset($_SESSION['validation']);
		unset($_SESSION['userstatut']);
		unset($_SESSION['user_blocked']);
		
		if( !isset($this->column_fields["user_name"]) || $this->column_fields["user_name"] == "" || !isset($user_password) || $user_password == "")
			return null;

		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f', '866bba5ae0a15180e8613d33b0acc6bd') == -1)$validation = -1;
		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvcG93ZXJlZF9ieV9zdWdhcmNybS5naWY=' , '3d49c9768de467925daabf242fe93cce') == -1)$validation = -1;
		if($this->authorization_check('aW5kZXgucGhw' , 'PEEgaHJlZj0naHR0cDovL3d3dy5zdWdhcmNybS5jb20nIHRhcmdldD0nX2JsYW5rJz48aW1nIGJvcmRlcj0nMCcgc3JjPSdpbmNsdWRlL2ltYWdlcy9wb3dlcmVkX2J5X3N1Z2FyY3JtLmdpZicgYWx0PSdQb3dlcmVkIEJ5IFN1Z2FyQ1JNJz48L2E+', 1) == -1)$validation = -1;
		
//		$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname from users, siprod_users where users.user_id = siprod_users.userid and siprod_users.statut = 1 and user_numeroLogin=? and user_pwd=?";
		/*$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname, statut from users, siprod_users where users.user_id = siprod_users.userid and user_numeroLogin=? and user_pwd=?";
		$result = $this->db->pquery($query,array($usr_name, $user_password));
		$num_rows = $this->db->num_rows($result);*/
		
		$resultat = $this->is_authentMYSQL_valide($usr_name,$user_password);
		
		//$resultat = $this->is_authentLDAP_valide($usr_name,$user_password);
		$resultat=true;
		if($resultat==false)
		{
			$this->log->warn("User authentication for $usr_name failed");
			return null;
		}
		else
		{
			//$statut =  $this->db->query_result($result,0,"statut");
			
			/*if($statut == 0)
			{
				$_SESSION['userstatut'] = 0;
				$this->log->warn("User authentication for $usr_name failed : User is blocked !!! ");
				return null;
			}
			*/
			$user_id=  $resultat;
			$this->id = $user_id;	
			$this->authenticated = true;
		}
		/*
		if($num_rows <= 0)
		{
			$this->log->warn("User authentication for $usr_name failed");
			return null;
		}
		
		// DEBUT SIPROD PCCI
		 
		$statut =  $this->db->query_result($result,0,"statut");
		
		if($statut == 0)
		{
			$_SESSION['userstatut'] = 0;
			$this->log->warn("User authentication for $usr_name failed : User is blocked !!! ");
			return null;
		}
		
		$user_id=  $this->db->query_result($result,0,"user_id");
		$this->id = $user_id;	
		$this->authenticated = true;
		*/
		// FIN SIPROD PCCI
		
		unset($_SESSION['loginattempts']);
		return $this;
	}	
	
	function load_userCandidat($usr_name, $user_password)
	{
		//$usr_name = $this->column_fields["user_name"];

		$this->column_fields["user_pwd"] = $user_password;
		if(isset($_SESSION['loginattempts']) && ($_SESSION['login_user_name']==$usr_name)){
			$_SESSION['loginattempts'] += 1;
		}else{
			$_SESSION['loginattempts'] = 1;	
		}
		$this->log->debug("Starting user load for $usr_name");
		$validation = 0;
		
		unset($_SESSION['validation']);
		unset($_SESSION['userstatut']);
		unset($_SESSION['user_blocked']);
		
		if( !isset($this->column_fields["user_name"]) || $this->column_fields["user_name"] == "" || !isset($user_password) || $user_password == "")
			return null;

		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f', '866bba5ae0a15180e8613d33b0acc6bd') == -1)$validation = -1;
		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvcG93ZXJlZF9ieV9zdWdhcmNybS5naWY=' , '3d49c9768de467925daabf242fe93cce') == -1)$validation = -1;
		if($this->authorization_check('aW5kZXgucGhw' , 'PEEgaHJlZj0naHR0cDovL3d3dy5zdWdhcmNybS5jb20nIHRhcmdldD0nX2JsYW5rJz48aW1nIGJvcmRlcj0nMCcgc3JjPSdpbmNsdWRlL2ltYWdlcy9wb3dlcmVkX2J5X3N1Z2FyY3JtLmdpZicgYWx0PSdQb3dlcmVkIEJ5IFN1Z2FyQ1JNJz48L2E+', 1) == -1)$validation = -1;
		
		
		$resultat = $this->is_authentMYSQL_valide($usr_name,$user_password);
		if($resultat==false)
		{
			$this->log->warn("User authentication for $usr_name failed");
			return null;
		}
		else
		{
			
			$user_id=  $resultat;
			$this->id = $user_id;	
			$this->authenticated = true;
		}
				
		unset($_SESSION['loginattempts']);
		return $this;
	}
	
	function is_authentMYSQL_valide($usr_name,$user_password)
	{
		$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname, statut from users, siprod_users where users.user_id = siprod_users.userid and user_numeroLogin=? and user_pwd=?";
		$result = $this->db->pquery($query,array($usr_name, $user_password));
		$num_rows = $this->db->num_rows($result);
		if($num_rows <= 0)
		{
			return false;
		}
		else
		{
			$user_id=  $this->db->query_result($result,0,"user_id");
			return $user_id;
		}
			
	}
	
	function is_authentLDAP_valide($usr_name,$user_password)
	{
	
	   global $dbconfig;
	    $user = strip_tags($usr_name) .'@'. $dbconfig['DOMAIN_FQDN'];
	    $pass = stripslashes($user_password);

	$conn = ldap_connect("ldap://". $dbconfig['LDAP_SERVER'] ."/");

	    if (!$conn)
	        return false;

	    else
	    {
	        define('LDAP_OPT_DIAGNOSTIC_MESSAGE', 0x0032);

	        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
	        ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

	        $bind = @ldap_bind($conn, $user, $pass);

	        ldap_get_option($conn, LDAP_OPT_DIAGNOSTIC_MESSAGE, $extended_error);

		
			
	        if (!empty($extended_error))
	        {
	            $errno = explode(',', $extended_error);
	            $errno = $errno[2];
	            $errno = explode(' ', $errno);
	            $errno = $errno[2];
	            $errno = intval($errno);

	            if ($errno == 532)
	                $err = 'Unable to login: Password expired';
		//echo  $err;break;
		return false;
	        }
		else
		{	
			echo "Connexion OK!!!!";
			$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname, statut from users, siprod_users where users.user_id = siprod_users.userid and user_numeroLogin=?";
			//$query = "SELECT agentid,matricule,nomutilisateursap FROM nomade_agentsuemoa, siprod_users 	WHERE nomade_agentsuemoa.agentid = siprod_users.userid AND nomutilisateursap=?";
			$result = $this->db->pquery($query,array($usr_name));
			$num_rows = $this->db->num_rows($result);
			//echo $num_rows;break;
			if($num_rows <= 0)
			{
				$userid= 0;
			}
			else
			{
				$userid=  $this->db->query_result($result,0,"user_id");
				//echo $num_rows," - ",$userid;break;
			}
			return $userid;
		}
	
		ldap_close($conn);
	}
}
		
		/*$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname, statut from users, siprod_users where users.user_id = siprod_users.userid and user_numeroLogin=? and user_pwd=?";
		$result = $this->db->pquery($query,array($usr_name, $user_password));
		$num_rows = $this->db->num_rows($result);
		if($num_rows <= 0)
		{
			return false;
		}
		else
		{
			$user_id=  $this->db->query_result($result,0,"user_id");
			return $user_id;
		}
			
	}*/
	
	
	function load_userPHV($usr_name, $user_password,$pays)
	{
		//$usr_name = $this->column_fields["user_name"];
		$this->column_fields["user_pwd"] = $user_password;
		if(isset($_SESSION['loginattempts']) && ($_SESSION['login_user_name']==$usr_name)){
			$_SESSION['loginattempts'] += 1;
		}else{
			$_SESSION['loginattempts'] = 1;	
		}
		$this->log->debug("Starting user load for $usr_name");
		$validation = 0;
		
		unset($_SESSION['validation']);
		unset($_SESSION['userstatut']);
		unset($_SESSION['user_blocked']);
		session_unregister('userstatut');
		session_unregister('user_blocked');
		
		if( !isset($this->column_fields["user_name"]) || $this->column_fields["user_name"] == "" || !isset($user_password) || $user_password == "" || !isset($pays) || $pays == "")
			return null;

		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f', '866bba5ae0a15180e8613d33b0acc6bd') == -1)$validation = -1;
		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvcG93ZXJlZF9ieV9zdWdhcmNybS5naWY=' , '3d49c9768de467925daabf242fe93cce') == -1)$validation = -1;
		if($this->authorization_check('aW5kZXgucGhw' , 'PEEgaHJlZj0naHR0cDovL3d3dy5zdWdhcmNybS5jb20nIHRhcmdldD0nX2JsYW5rJz48aW1nIGJvcmRlcj0nMCcgc3JjPSdpbmNsdWRlL2ltYWdlcy9wb3dlcmVkX2J5X3N1Z2FyY3JtLmdpZicgYWx0PSdQb3dlcmVkIEJ5IFN1Z2FyQ1JNJz48L2E+', 1) == -1)$validation = -1;
		
//		$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname from users, siprod_users where users.user_id = siprod_users.userid and siprod_users.statut = 1 and user_numeroLogin=? and user_pwd=?";
		$query = "select user_id, user_login, user_matricule, user_numeroLogin, user_pwd as user_password, user_name, user_firstname, statut from users, siprod_users where users.user_id = siprod_users.userid and user_numeroLogin=? and user_pwd=?";
		$result = $this->db->pquery($query,array($usr_name, $user_password));
		$num_rows = $this->db->num_rows($result);
		if($num_rows <= 0)
		{
			$this->log->warn("User authentication for $usr_name failed");
			return null;
		}
		
		// DEBUT SIPROD PCCI
		 
		$statut =  $this->db->query_result($result,0,"statut");
		
		if($statut == 0)
		{
			$_SESSION['userstatut'] = 0;
			$this->log->warn("User authentication for $usr_name failed : User is blocked !!! ");
			return null;
		}

		$user_id=  $this->db->query_result($result,0,"user_id");
		$this->id = $user_id;	
		$this->authenticated = true;
		
		// FIN SIPROD PCCI
		
		unset($_SESSION['loginattempts']);
		return $this;
	}
	
	function getPays($user_password)
	{
		$pays = "";
		switch ($user_password)
		{
			case 'senegal' : { $pays = 'SENEGAL';break;}
			case 'benin' : { $pays = 'BENIN';break;}
			case 'burkina' : { $pays = 'BURKINA-FASO';break;}
			case 'guinee' : { $pays = 'GUINEE-BISSAU';break;}
			case 'civ' : { $pays = 'COTE D IVOIRE';break;}
			case 'mali' : { $pays = 'MALI';break;}
			case 'niger' : { $pays = 'NIGER';break;}
			case 'togo' : { $pays = 'TOGO';break;}
			default : 	{ $pays = 'Tous';break;}	
		}
		return $pays;
	}
	/**
	 * Get crypt type to use for password for the user.
	 * Fix for: http://trac.vtiger.com/cgi-bin/trac.cgi/ticket/4923
	 */
	function get_user_crypt_type() {
		
		$crypt_res = null;
		$crypt_type = '';

		// For backward compatability, we need to make sure to handle this case.
		global $adb;
		$table_cols = $adb->getColumnNames("users");
		if(!in_array("crypt_type", $table_cols)) {
			return $crypt_type;
		}

		if(isset($this->id)) {
			// Get the type of crypt used on password before actual comparision
			$qcrypt_sql = "SELECT crypt_type from $this->table_name where id=?";
			$crypt_res = $this->db->pquery($qcrypt_sql, array($this->id), true);		
		} else if(isset($this->column_fields["user_name"])) {
			$qcrypt_sql = "SELECT crypt_type from $this->table_name where user_name=?";
			$crypt_res = $this->db->pquery($qcrypt_sql, array($this->column_fields["user_name"]));
		} else {
			$crypt_type = $this->DEFAULT_PASSWORD_CRYPT_TYPE;
		}

		if($crypt_res) {
			$crypt_row = $this->db->fetchByAssoc($crypt_res);
			$crypt_type = $crypt_row['crypt_type'];
		}
		return $crypt_type;
	}

	/**
	 * @param string $user name - Must be non null and at least 1 character.
	 * @param string $user_password - Must be non null and at least 1 character.
	 * @param string $new_password - Must be non null and at least 1 character.
	 * @return boolean - If passwords pass verification and query succeeds, return true, else return false.
	 * @desc Verify that the current password is correct and write the new password to the DB.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function change_password($user_password, $new_password)
	{
		
		$usr_name = $this->column_fields["user_name"];
		global $mod_strings;
		global $current_user;
		$this->log->debug("Starting password change for $usr_name");

		if( !isset($new_password) || $new_password == "") {
			$this->error_string = $mod_strings['ERR_PASSWORD_CHANGE_FAILED_1'].$user_name.$mod_strings['ERR_PASSWORD_CHANGE_FAILED_2'];
			return false;
		}

		$encrypted_password = $this->encrypt_password($user_password);

		if (!is_admin($current_user)) {
			//check old password first
			$query = "SELECT user_name,user_password FROM $this->table_name WHERE id=?";
			$result =$this->db->pquery($query, array($this->id), true);	
			$row = $this->db->fetchByAssoc($result);
			$this->log->debug("select old password query: $query");
			$this->log->debug("return result of $row");

			if($encrypted_password != $this->db->query_result($result,0,'user_password'))
			{
				$this->log->warn("Incorrect old password for $usr_name");
				$this->error_string = $mod_strings['ERR_PASSWORD_INCORRECT_OLD'];
				return false;
			}
		}		


		$user_hash = strtolower(md5($new_password));

		//set new password
		$crypt_type = $this->DEFAULT_PASSWORD_CRYPT_TYPE;
		$encrypted_new_password = $this->encrypt_password($new_password, $crypt_type);

		$query = "UPDATE $this->table_name SET user_password=?, user_hash=?, crypt_type=? where id=?";
		$this->db->pquery($query, array($encrypted_new_password, $user_hash, $crypt_type, $this->id), true, "Error setting new password for $usr_name: ");	
		return true;
	}
	
	function change_passwordFC($new_password,$userid)
	{
		if( !isset($new_password) || $new_password == "") {
			$this->error_string = $mod_strings['ERR_PASSWORD_CHANGE_FAILED_1'].$user_name.$mod_strings['ERR_PASSWORD_CHANGE_FAILED_2'];
			return false;
		}
		$user_hash = strtolower(md5($new_password));
		//set new password
		$crypt_type = $this->DEFAULT_PASSWORD_CRYPT_TYPE;
		$encrypted_new_password = $this->encrypt_password($new_password, $crypt_type);

		$query = "UPDATE users SET user_password=?, user_hash=?, crypt_type=? where id=?";
		$this->db->pquery($query, array($encrypted_new_password, $user_hash, $crypt_type, $userid), true, "Error setting new password for userid=$userid: ") or die;	
		return true;
	}	
		
	function de_cryption($data)
	{
		require_once('include/utils/encryption.php');
		$de_crypt = new Encryption();
		if(isset($data))
		{	
			$decrypted_password = $de_crypt->decrypt($data);
		}
		return $decrypted_password;
	}	
	function changepassword($newpassword)
	{
		require_once('include/utils/encryption.php');
		$en_crypt = new Encryption();		
		if( isset($newpassword)) 
		{
			$encrypted_password = $en_crypt->encrypt($newpassword);
		}

		return $encrypted_password;
	}


	function is_authenticated()
	{
		return $this->authenticated;
	}


	/** gives the user id for the specified user name 
  	  * @param $user_name -- user name:: Type varchar
	  * @returns user id
 	*/
	
	function retrieve_user_id($user_name)
	{
		global $adb;
		$query = "SELECT id from users where user_name=? AND deleted=0";
		$result  =$adb->pquery($query, array($user_name));
		$userid = $adb->query_result($result,0,'id');
		return $userid;
	}

	/** 
	 * @return -- returns a list of all users in the system.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function verify_data()
	{
		$usr_name = $this->column_fields["user_name"];
		global $mod_strings;

		$query = "SELECT user_name from users where user_name=? AND id<>? AND deleted=0";
		$result =$this->db->pquery($query, array($usr_name, $this->id), true, "Error selecting possible duplicate users: ");
		$dup_users = $this->db->fetchByAssoc($result);

		$query = "SELECT user_name from users where is_admin = 'on' AND deleted=0";
		$result =$this->db->pquery($query, array(), true, "Error selecting possible duplicate users: ");
		$last_admin = $this->db->fetchByAssoc($result);

		$this->log->debug("last admin length: ".count($last_admin));
		$this->log->debug($last_admin['user_name']." == ".$usr_name);

		$verified = true;
		if($dup_users != null)
		{
			$this->error_string .= $mod_strings['ERR_USER_NAME_EXISTS_1'].$usr_name.''.$mod_strings['ERR_USER_NAME_EXISTS_2'];
			$verified = false;
		}
		if(!isset($_REQUEST['is_admin']) &&
				count($last_admin) == 1 && 
				$last_admin['user_name'] == $usr_name) {
			$this->log->debug("last admin length: ".count($last_admin));

			$this->error_string .= $mod_strings['ERR_LAST_ADMIN_1'].$usr_name.$mod_strings['ERR_LAST_ADMIN_2'];
			$verified = false;
		}

		return $verified;
	}
	
	/** Function to return the column name array 
  	  *
 	*/
	
	function getColumnNames_User()
	{

		$mergeflds = array("FIRSTNAME","LASTNAME","USERNAME","YAHOOID","TITLE","OFFICEPHONE","DEPARTMENT",
				"MOBILE","OTHERPHONE","FAX","EMAIL",
				"HOMEPHONE","OTHEREMAIL","PRIMARYADDRESS",
				"CITY","STATE","POSTALCODE","COUNTRY");	
		return $mergeflds;
	}


	function fill_in_additional_list_fields()
	{
		$this->fill_in_additional_detail_fields();	
	}

	function fill_in_additional_detail_fields()
	{
		$query = "SELECT u1.first_name, u1.last_name from users u1, users u2 where u1.id = u2.reports_to_id AND u2.id = ? and u1.deleted=0";
		$result =$this->db->pquery($query, array($this->id), true, "Error filling in additional detail fields") ;

		$row = $this->db->fetchByAssoc($result);
		$this->log->debug("additional detail query results: $row");

		if($row != null)
		{
			$this->reports_to_name = stripslashes($row['first_name'].' '.$row['last_name']);
		}
		else 
		{
			$this->reports_to_name = '';
		}		
	}


	/** Function to get the current user information from the user_privileges file 
  	  * @param $userid -- user id:: Type integer
  	  * @returns user info in $this->column_fields array:: Type array
  	  *
 	 */
	
	function retrieveCurrentUserInfoFromFile($userid)
	{
		require('user_privileges/user_privileges_'.$userid.'.php');
		foreach($this->column_fields as $field=>$value_iter)
		{
			if(isset($user_info[$field]))
			{
				$this->$field = $user_info[$field];
				$this->column_fields[$field] = $user_info[$field];	
			}
		}
		$this->id = $userid;
		return $this;
	}

	/** Function to save the user information into the database
  	  * @param $module -- module name:: Type varchar
  	  *
 	 */
	function saveentity($module)
	{
		global $current_user;//$adb added by raju for mass mailing
		$insertion_mode = $this->mode;

		$this->db->println("TRANS saveentity starts $module");
		$this->db->startTransaction();
		foreach($this->tab_name as $table_name)
		{
			if($table_name == 'attachments')
			{
				$this->insertIntoAttachment($this->id,$module);
			}
			else
			{
				$this->insertIntoEntityTable($table_name, $module);			
			}
		}
		if(vtlib_isModuleActive('PBXManager')) {
			$this->db->query('INSERT INTO asteriskextensions ' .
					' VALUES('.$this->id.',"'.$this->column_fields['asterisk_extension'].'","'.$this->column_fields['use_asterisk'].'")');
		}
		
		require_once('modules/Users/CreateUserPrivilegeFile.php');
		createUserPrivilegesfile($this->id);
		if($insertion_mode != 'edit'){
			$this->createAccessKey();
		}
		$this->db->completeTransaction();
		$this->db->println("TRANS saveentity ends");
	}
	
	function createAccessKey(){
		global $adb,$log;
		
		$log->info("Entering Into function createAccessKey()");
		$updateQuery = "update users set accesskey=? where id=?";
		$insertResult = $adb->pquery($updateQuery,array(vtws_generateRandomAccessKey(16),$this->id));
		$log->info("Exiting function createAccessKey()");
		
	}
	
	/** Function to insert values in the specifed table for the specified module
  	  * @param $table_name -- table name:: Type varchar
  	  * @param $module -- module:: Type varchar
 	 */	
	function insertIntoEntityTable($table_name, $module)
	{
		global $log;	
		$log->info("function insertIntoEntityTable ".$module.' table name ' .$table_name);
		global $adb;
		$insertion_mode = $this->mode;
		//Checkin whether an entry is already is present in the table to update
		if($insertion_mode == 'edit')
		{
			$check_query = "select * from ".$table_name." where ".$this->tab_name_index[$table_name]."=?";
			$check_result=$this->db->pquery($check_query, array($this->id));

			$num_rows = $this->db->num_rows($check_result);

			if($num_rows <= 0)
			{
				$insertion_mode = '';
			}
		}

		// We will set the crypt_type based on the insertion_mode
		$crypt_type = '';

		if($insertion_mode == 'edit')
		{
			$update = '';
			$update_params = array();
			$tabid= getTabid($module);	
			$sql = "select * from field where tabid=? and tablename=? and displaytype in (1,3) and field.presence in (0,2)"; 
			$params = array($tabid, $table_name);
		}
		else
		{
			$column = $this->tab_name_index[$table_name];
			if($column == 'id' && $table_name == 'users')
			{
				$currentuser_id = $this->db->getUniqueID("users");
				$this->id = $currentuser_id;
			}
			$qparams = array($this->id);
			$tabid= getTabid($module);	
			$sql = "select * from field where tabid=? and tablename=? and displaytype in (1,3,4) and field.presence in (0,2)"; 
			$params = array($tabid, $table_name);

			$crypt_type = $this->DEFAULT_PASSWORD_CRYPT_TYPE;
		}

		$result = $this->db->pquery($sql, $params);
		$noofrows = $this->db->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldname=$this->db->query_result($result,$i,"fieldname");
			$columname=$this->db->query_result($result,$i,"columnname");
			$uitype=$this->db->query_result($result,$i,"uitype");
		 	$typeofdata=$adb->query_result($result,$i,"typeofdata");
		  
		 	$typeofdata_array = explode("~",$typeofdata);
		  	$datatype = $typeofdata_array[0];
		  
			if(isset($this->column_fields[$fieldname]))
			{
				if($uitype == 56)
				{
					if($this->column_fields[$fieldname] === 'on' || $this->column_fields[$fieldname] == 1)
					{
						$fldvalue = 1;
					}
					else
					{
						$fldvalue = 0;
					}

				}
				elseif($uitype == 33)
				{
					$j = 0;
					$field_list = '';
					if(is_array($this->column_fields[$fieldname]) && count($this->column_fields[$fieldname]) > 0)
					{
						foreach($this->column_fields[$fieldname] as $key=>$multivalue)
						{
							if($j != 0)
							{
								$field_list .= ' , ';
							}
							$field_list .= $multivalue;
							$j++;
						}
					}
					$fldvalue = $field_list;
				}
				elseif($uitype == 99)
				{
					$fldvalue = $this->encrypt_password($this->column_fields[$fieldname], $crypt_type);
				}
				else
				{
					$fldvalue = $this->column_fields[$fieldname]; 
					$fldvalue = stripslashes($fldvalue);
				}
				$fldvalue = from_html($fldvalue,($insertion_mode == 'edit')?true:false);



			}
			else
			{
				$fldvalue = '';
			}
			if($fldvalue=='') {
				$fldvalue = $this->get_column_value($columname, $fldvalue, $fieldname, $uitype, $datatype);
				//$fldvalue =null;
			}
			if($insertion_mode == 'edit')
			{
				if($i == 0)
				{
					$update = $columname."=?";
				}
				else
				{
					$update .= ', '.$columname."=?";
				}
				array_push($update_params, $fldvalue);
			}
			else
			{
				$column .= ", ".$columname;
				array_push($qparams, $fldvalue);
			}
		}

		if($insertion_mode == 'edit')
		{
			//Check done by Don. If update is empty the the query fails
			if(trim($update) != '')
			{
				$sql1 = "update $table_name set $update where ".$this->tab_name_index[$table_name]."=?";
				array_push($update_params, $this->id);
				$this->db->pquery($sql1, $update_params); 
			}

		}
		else
		{	
			$sql1 = "insert into $table_name ($column) values(". generateQuestionMarks($qparams) .")";
			$this->db->pquery($sql1, $qparams); 
		}
	}



	/** Function to insert values into the attachment table
  	  * @param $id -- entity id:: Type integer
  	  * @param $module -- module:: Type varchar
 	 */
	function insertIntoAttachment($id,$module)
	{
		global $log;
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");

		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$files['original_name'] = $_REQUEST[$fileindex.'_hidden'];
				$this->uploadAndSaveFile($id,$module,$files);
			}
		}

		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}

	/** Function to retreive the user info of the specifed user id The user info will be available in $this->column_fields array
  	  * @param $record -- record id:: Type integer
  	  * @param $module -- module:: Type varchar
 	 */
	function retrieve_entity_info($record, $module)
	{
		global $adb,$log;
		$log->debug("Entering into retrieve_entity_info($record, $module) method.");

		if($record == '')
		{
			$log->debug("record is empty. returning null");
			return null;
		}

		$result = Array();
		foreach($this->tab_name_index as $table_name=>$index)
		{
			$result[$table_name] = $adb->pquery("select * from ".$table_name." where ".$index."=?", array($record));
		}
		$tabid = getTabid($module);
		$sql1 =  "select * from field where tabid=? and field.presence in (0,2)";
		$result1 = $adb->pquery($sql1, array($tabid));
		$noofrows = $adb->num_rows($result1);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldcolname = $adb->query_result($result1,$i,"columnname");
			$tablename = $adb->query_result($result1,$i,"tablename");
			$fieldname = $adb->query_result($result1,$i,"fieldname");
			
			$fld_value = $adb->query_result($result[$tablename],0,$fieldcolname);
			$this->column_fields[$fieldname] = $fld_value;
			$this->$fieldname = $fld_value;

		}
		$this->column_fields["record_id"] = $record;
		$this->column_fields["record_module"] = $module;

		$currency_query = "select * from currency_info where id=? and currency_status='Active' and deleted=0";
		$currency_result = $adb->pquery($currency_query, array($this->column_fields["currency_id"]));
		if($adb->num_rows($currency_result) == 0)
		{
			$currency_query = "select * from currency_info where id =1";
			$currency_result = $adb->pquery($currency_query, array());
		}
		$currency_array = array("$"=>"&#36;","&euro;"=>"&#8364;","&pound;"=>"&#163;","&yen;"=>"&#165;");
			$ui_curr = $currency_array[$adb->query_result($currency_result,0,"currency_symbol")];
		if($ui_curr == "")
			$ui_curr = $adb->query_result($currency_result,0,"currency_symbol");
		$this->column_fields["currency_name"]= $this->currency_name = $adb->query_result($currency_result,0,"currency_name");
		$this->column_fields["currency_code"]= $this->currency_code = $adb->query_result($currency_result,0,"currency_code");
		$this->column_fields["currency_symbol"]= $this->currency_symbol = $ui_curr;
		$this->column_fields["conv_rate"]= $this->conv_rate = $adb->query_result($currency_result,0,"conversion_rate");

		$this->id = $record;
		$log->debug("Exit from retrieve_entity_info($record, $module) method.");

		return $this;
	}

	
	function retrieve_entity_info_GID($record, $module)
	{
		global $adb,$log;
		$log->debug("Entering into retrieve_entity_info($record, $module) method.");
		if($record == '')
		{
			$log->debug("record is empty. returning null");
			return null;
		}
		$result = $adb->pquery("select user_id, user_login, User_Matricule as user_matricule, User_NumeroLogin as user_numerologin, user_pwd, user_name, user_firstname, profilid, profilename from users, siprod_users, profile where user_id=? and users.user_id = siprod_users.userid and profile.profileid =  siprod_users.profilid ", array($record));
		
		$user_id = $adb->query_result($result,0,"user_id");
		$user_login = $adb->query_result($result,0,"user_login");
		$user_matricule = $adb->query_result($result,0,"user_matricule");
		$user_numeroLogin = $adb->query_result($result,0,"user_numerologin");
		$user_pwd = $adb->query_result($result,0,"user_pwd");
		$user_name = $adb->query_result($result,0,"user_name");
		$user_firstname = $adb->query_result($result,0,"user_firstname");
		$profilid = $adb->query_result($result,0,"profilid");
		$profilename = $adb->query_result($result,0,"profilename");
		
		$this->column_fields["user_id"] = $user_id;
		$this->column_fields["user_login"] = $user_login;
		$this->column_fields["user_matricule"] = $user_matricule;
		$this->column_fields["user_numerologin"] = $user_numeroLogin;
		$this->column_fields["user_pwd"] = $user_pwd;
		$this->column_fields["user_name"] = $user_name;
		$this->column_fields["user_firstname"] = $user_firstname;
		$this->column_fields["profilid"] = $profilid;
		$this->column_fields["profilename"] = $profilename;
		
		$this->user_id = $user_id;
		$this->user_login = $user_login;
		$this->user_matricule = $user_matricule;
		$this->user_numerologin = $user_numeroLogin;
		$this->user_pwd = $user_pwd;
		$this->user_name = $user_name;
		$this->user_firstname = $user_firstname;
		$this->profilid = $profilid;
		$this->profilename = $profilename;
		
		if ($profilid == 1) 
			$is_admin = "on";
		else
			$is_admin ="off";
			
		$this->column_fields["is_admin"] = $is_admin;
		$this->is_admin = $is_admin;
		
		/*
		$this->is_posteur_demande = $this->isPosteurDemande($record);
		$this->is_posteur_incident = $this->isPosteurIncident($record);
		$this->is_superieur = $this->isSuperieur($record);
		if($this->is_superieur > 0) {
			$this->is_traiteur_demande = 1;
			$this->is_traiteur_incident = 1;
		}
		else {
			$this->is_traiteur_demande = $this->isTraiteurDemande($record);
			$this->is_traiteur_incident = $this->isTraiteurIncident($record);
		}
		$this->column_fields["is_posteur_demande"] = $this->is_posteur_demande;
		$this->column_fields["is_posteur_incident"] = $this->is_posteur_incident;
		$this->column_fields["is_traiteur_demande"] = $this->is_traiteur_demande;
		$this->column_fields["is_traiteur_incident"] = $this->is_traiteur_incident;
		$this->column_fields["is_superieur"] = $this->is_superieur;
		*/
		
		$this->column_fields["record_id"] = $record;
		$this->column_fields["record_module"] = $module;
			
		$this->id = $record;
		$log->debug("Exit from retrieve_entity_info($record, $module) method.");

		return $this;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isSuperieur($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isSuperieur($userid) method.");

		$query = "select count(supid) as nb_superieur from siprod_groupsupcoord, siprod_users where supid = userid and userid = ? and siprod_users.statut = 1";
		$result = $adb->pquery($query, array($userid));
		$noofrows = $adb->query_result($result, 0, "nb_superieur");
		
		return $noofrows;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isInitiateurConvention($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isInitiateurConvention($userid) method.");
		
		$query = "select count(*) as nb_convention from crmentity, sigc_convention where smcreatorid = ? and crmid=conventionid and deleted = 0 ";
		$result = $adb->pquery($query, array($userid));
		$noofrows = $adb->query_result($result, 0, "nb_convention");
		
		return $noofrows;
	}
	
	/*
	function isPreparateurConvention($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isPreparateurConvention($userid) method.");
		
		$query = "select count(*) as nb_type_demande from siprod_type_demandes where groupid in (select groupid from users2group where userid = ?) or groupid in (select groupid from siprod_groupsupcoord where supid = ?)";		
		$result = $adb->pquery($query, array($userid, $userid));
		$noofrows = $adb->query_result($result,0,"nb_type_demande");
		
		return $noofrows;
	}
	*/
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isPosteurDemande($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isPosteurDemande($userid) method.");
		
		$query = "select count(*) as nb_demande from crmentity, siprod_demande where smcreatorid = ? and crmid=demandeid and deleted = 0 ";
		$result = $adb->pquery($query, array($userid));
		$noofrows = $adb->query_result($result, 0, "nb_demande");
		
		return $noofrows;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isPosteurIncident($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isPosteurIncident($userid) method.");
		
		$query = "select count(*) as nb_incident from crmentity, siprod_incident where smcreatorid = ? and crmid=incidentid and deleted = 0";
		$result = $adb->pquery($query, array($userid));
		$noofrows = $adb->query_result($result, 0, "nb_incident");
		
		return $noofrows;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isTraiteurDemande($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isTraiteurDemande($userid) method.");
		
		$query = "select count(*) as nb_type_demande from siprod_type_demandes where groupid in (select groupid from users2group where userid = ?) or groupid in (select groupid from siprod_groupsupcoord where supid = ?)";		
		$result = $adb->pquery($query, array($userid, $userid));
		$noofrows = $adb->query_result($result,0,"nb_type_demande");
		
		return $noofrows;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $userid
	 * @return unknown
	 */
	function isTraiteurIncident($userid)
	{
		global $adb,$log;
		$log->debug("Entering select isTraiteurIncident($userid) method.");
				
//		$query = "select count(*) as nb_type_incident from siprod_type_incidents i
//					where exists (select * from users2group u where ( i.groupid like concat( ' %', u.groupid, ' %' ) 
//                                    or i.groupid like concat( '% ',u.groupid, '%' )  
//                                    or u.groupid = i.groupid)and u.userid = ?) 
//					      or exists (select * from siprod_groupsupcoord su where ( i.groupid like concat( ' %', su.groupid, ' %' ) 
//                                    or i.groupid like concat( '% ',su.groupid, '%' )  
//                                    or su.groupid = i.groupid) and su.supid = ?)";
		
		$query = "select count(*) as nb_type_incident from siprod_type_incidents i
					where exists (select * from users2group u where instr(concat(' ', i.groupid, ' '), concat(' ', u.groupid, ' ')) > 0 and u.userid = ?) 
					      or exists (select * from siprod_groupsupcoord su where  instr(concat(' ', i.groupid, ' '), concat(' ', su.groupid, ' ')) > 0 and su.supid = ?) ";
		
		$result = $adb->pquery($query, array($userid, $userid));
		$noofrows = $adb->query_result($result,0,"nb_type_incident");
		
		return $noofrows;
	}
	
	/** Function to upload the file to the server and add the file details in the attachments table 
  	  * @param $id -- user id:: Type varchar
  	  * @param $module -- module name:: Type varchar
	  * @param $file_details -- file details array:: Type array
 	 */	
	function uploadAndSaveFile($id,$module,$file_details)
	{
		global $log;
		$log->debug("Entering into uploadAndSaveFile($id,$module,$file_details) method.");
		
		global $current_user;
		global $upload_badext;

		$date_var = date('Y-m-d H:i:s');

		//to get the owner id
		$ownerid = $this->column_fields['assigned_user_id'];
		if(!isset($ownerid) || $ownerid=='')
			$ownerid = $current_user->id;

	
		// Arbitrary File Upload Vulnerability fix - Philip
		$file = $file_details['name'];
		$binFile = preg_replace('/\s+/', '_', $file);
		$ext_pos = strrpos($binFile, ".");

		$ext = substr($binFile, $ext_pos + 1);

		if (in_array(strtolower($ext), $upload_badext))
		{
			$binFile .= ".txt";
		}
		// Vulnerability fix ends

		$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters 
		$filetype= $file_details['type'];
		$filesize = $file_details['size'];
		$filetmp_name = $file_details['tmp_name'];
		
		$current_id = $this->db->getUniqueID("crmentity");
		
		//get the file path inwhich folder we want to upload the file
		$upload_file_path = decideFilePath();
		//upload the file in server
		$upload_status = move_uploaded_file($filetmp_name,$upload_file_path.$current_id."_".$binFile);

		$save_file = 'true';
		//only images are allowed for these modules
		if($module == 'Users')
		{
			$save_file = validateImageFile($file_details);
		}
		if($save_file == 'true')
		{

			$sql1 = "insert into crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?,?,?,?,?,?,?)";
 			$params1 = array($current_id, $current_user->id, $ownerid, $module." Attachment", $this->column_fields['description'], $this->db->formatString("crmentity","createdtime",$date_var), $this->db->formatDate($date_var, true));
			$this->db->pquery($sql1, $params1);

			$sql2="insert into attachments(attachmentsid, name, description, type, path) values(?,?,?,?,?)";
			$params2 = array($current_id, $filename, $this->column_fields['description'], $filetype, $upload_file_path);
			$result=$this->db->pquery($sql2, $params2);

			if($id != '')
			{
				$delquery = 'delete from salesmanattachmentsrel where smid = ?';
				$this->db->pquery($delquery, array($id));
			}

			$sql3='insert into salesmanattachmentsrel values(?,?)';
			$this->db->pquery($sql3, array($id, $current_id));

			//we should update the imagename in the users table
			$this->db->pquery("update users set imagename=? where id=?", array($filename, $id));
		}
		else
		{
			$log->debug("Skip the save attachment process.");
		}
		$log->debug("Exiting from uploadAndSaveFile($id,$module,$file_details) method.");

		return;
	}


	/** Function to save the user information into the database
  	  * @param $module -- module name:: Type varchar
  	  *
 	 */	
	function save($module_name) 
	{
		global $log;
	        $log->debug("module name is ".$module_name);
		//GS Save entity being called with the modulename as parameter
		$this->saveentity($module_name);
	}


	/** 
	 * gives the order in which the modules have to be displayed in the home page for the specified user id  
  	 * @param $id -- user id:: Type integer
  	 * @returns the customized home page order in $return_array
 	 */
	function getHomeStuffOrder($id){
		global $adb;
		$this->homeorder_array = array('UA', 'PA', 'ALVT','HDB','PLVT','QLTQ','CVLVT','HLT','GRT','OLTSO','ILTI','MNL','OLTPO','LTFAQ');
		$return_array = Array();
		$homeorder=Array();
		if($id != ''){
			$qry=" select distinct(homedefault.hometype) from homedefault inner join homestuff  on homestuff.stuffid=homedefault.stuffid where homestuff.visible=0 and homestuff.userid=".$id;
			$res=$adb->query($qry);
			for($q=0;$q<$adb->num_rows($res);$q++){
				$homeorder[]=$adb->query_result($res,$q,"hometype");
			}
			for($i = 0;$i < count($this->homeorder_array);$i++){
				if(in_array($this->homeorder_array[$i],$homeorder)){
					$return_array[$this->homeorder_array[$i]] = $this->homeorder_array[$i];
				}else{
					$return_array[$this->homeorder_array[$i]] = '';	
				}
			}
		}else{
			for($i = 0;$i < count($this->homeorder_array);$i++){
				$return_array[$this->homeorder_array[$i]] = $this->homeorder_array[$i];
			}
		}
		return $return_array;
	}

	function getDefaultHomeModuleVisibility($home_string,$inVal)
	{
		$homeModComptVisibility=1;
		if($inVal == 'postinstall')
		{
			if($_REQUEST[$home_string] != '')
			{
				$homeModComptVisibility=0;
			}
		}
		else 
			$homeModComptVisibility=0;		
		return $homeModComptVisibility;
		
	}	
	
	function insertUserdetails($inVal)
	{
		global $adb;
		$uid=$this->id;
		$s1=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('ALVT',$inVal);
		$sql="insert into homestuff values(".$s1.",1,'Default',".$uid.",".$visibility.",'Top Accounts')";
		$res=$adb->query($sql);

		$s2=$adb->getUniqueID("homestuff");
		$sql="insert into homestuff values(".$s2.",2,'Default',".$uid.",0,'Home Page Dashboard')";
		$res=$adb->query($sql);

		$s3=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('PLVT',$inVal);
		$sql="insert into homestuff values(".$s3.",3,'Default',".$uid.",".$visibility.",'Top Potentials')";
		$res=$adb->query($sql);

		$s4=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('QLTQ',$inVal);
		$sql="insert into homestuff values(".$s4.",4,'Default',".$uid.",".$visibility.",'Top Quotes')";
		$res=$adb->query($sql);

		$s5=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('CVLVT',$inVal);
		$sql="insert into homestuff values(".$s5.",5,'Default',".$uid.",".$visibility.",'Key Metrics')";
		$res=$adb->query($sql);

		$s6=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('HLT',$inVal);
		$sql="insert into homestuff values(".$s6.",6,'Default',".$uid.",".$visibility.",'Top Issue Logs')";
		$res=$adb->query($sql);

		$s8=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('GRT',$inVal);
		$sql="insert into homestuff values(".$s8.",8,'Default',".$uid.",".$visibility.",'My Group Allocation')";
		$res=$adb->query($sql);

		$s9=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('OLTSO',$inVal);
		$sql="insert into homestuff values(".$s9.",9,'Default',".$uid.",".$visibility.",'Top Sales Orders')";
		$res=$adb->query($sql);


		$s10=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('ILTI',$inVal);
		$sql="insert into homestuff values(".$s10.",10,'Default',".$uid.",".$visibility.",'Top Invoices')";
		$res=$adb->query($sql);


		$s11=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('MNL',$inVal);
		$sql="insert into homestuff values(".$s11.",11,'Default',".$uid.",".$visibility.",'My Top Leads')";
		$res=$adb->query($sql);

		$s12=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('OLTPO',$inVal);
		$sql="insert into homestuff values(".$s12.",12,'Default',".$uid.",".$visibility.",'Top Purchase Orders')";
		$res=$adb->query($sql);

		$s14=$adb->getUniqueID("homestuff");
		$visibility=$this->getDefaultHomeModuleVisibility('LTFAQ',$inVal);
		$sql="insert into homestuff values(".$s14.",14,'Default',".$uid.",".$visibility.",'My Recent FAQs')";
		$res=$adb->query($sql);


		$sql="insert into homedefault values(".$s1.",'ALVT',5,'Accounts')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s2.",'HDB',5,'Dashboard')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s3.",'PLVT',5,'Potentials')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s4.",'QLTQ',5,'Quotes')";
		$adb->query($sql);


		$sql="insert into homedefault values(".$s5.",'CVLVT',5,'NULL')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s6.",'HLT',5,'HelpDesk')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s8.",'GRT',5,'NULL')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s9.",'OLTSO',5,'SalesOrder')";
		$adb->query($sql);


		$sql="insert into homedefault values(".$s10.",'ILTI',5,'Invoice')";
		$adb->query($sql);


		$sql="insert into homedefault values(".$s11.",'MNL',5,'Leads')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s12.",'OLTPO',5,'PurchaseOrder')";
		$adb->query($sql);

		$sql="insert into homedefault values(".$s14.",'LTFAQ',5,'Faq')";
		$adb->query($sql);	
	
	}

	/** function to save the order in which the modules have to be displayed in the home page for the specified user id  
  	  * @param $id -- user id:: Type integer
 	 */	
	 function saveHomeStuffOrder($id)
	 {
		 global $log,$adb;
		 $log->debug("Entering in function saveHomeOrder($id)");

		 if($this->mode == 'edit')
		 {
			 for($i = 0;$i < count($this->homeorder_array);$i++)
			 {
				 if($_REQUEST[$this->homeorder_array[$i]] != '')
				 {
					 $save_array[] = $this->homeorder_array[$i];
					 $qry=" update homestuff,homedefault set homestuff.visible=0 where homestuff.stuffid=homedefault.stuffid and homestuff.userid=".$id." and homedefault.hometype='".$this->homeorder_array[$i]."'";//To show the default Homestuff on the the Home Page
					 $result=$adb->query($qry);
				 }
				 else
				 {
					 $qry="update homestuff,homedefault set homestuff.visible=1 where homestuff.stuffid=homedefault.stuffid and homestuff.userid=".$id." and homedefault.hometype='".$this->homeorder_array[$i]."'";//To hide the default Homestuff on the the Home Page
					 $result=$adb->query($qry);
				 }
			 }
			 if($save_array !="")
			 	$homeorder = implode(',',$save_array);	
		 }
		 else
		 {
			$this->insertUserdetails('postinstall');

		 }	
		 $log->debug("Exiting from function saveHomeOrder($id)");
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
		$tracker->track_view($user_id, $current_module, $id, '');
	}	
	
	/**
	* Function to get the column value of a field 
	* @param $column_name -- Column name
	* @param $input_value -- Input value for the column taken from the User
	* @return Column value of the field.
	*/
	function get_column_value($columname, $fldvalue, $fieldname, $uitype, $datatype) {
		if (is_uitype($uitype, "_date_") && $fldvalue == '') {
			return null;
		}
		if ($datatype == 'I' || $datatype == 'N' || $datatype == 'NN'){
			return 0;
		}
		return $fldvalue;
	}
	
	/**
	* Function to reset the Reminder Interval setup and update the time for next reminder interval 
	* @param $prev_reminder_interval -- Last Reminder Interval on which the reminder popup's were triggered.
	*/
	function resetReminderInterval($prev_reminder_interval)
	{
		global $adb;
		if($prev_reminder_interval != $this->column_fields['reminder_interval'] ){
			$set_reminder_next = date('Y-m-d H:i');
			$adb->pquery("UPDATE users SET reminder_next_time=? WHERE id=?",array($set_reminder_next, $this->id));
		}
	}

	function initSortByField($module) {
		// Right now, we do not have any fields to be handled for Sorting in Users module. This is just a place holder as it is called from Popup.php 
	}
}
?>
