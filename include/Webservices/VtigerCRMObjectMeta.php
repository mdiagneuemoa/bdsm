<?php

class VtigerCRMObjectMeta extends EntityMeta {
	
	private $tabId;
	
	private $meta;
	private $assign;
	private $hasAccess;
	private $hasReadAccess;
	private $hasWriteAccess;
	private $hasDeleteAccess;
	private $assignUsers;
	
	function VtigerCRMObjectMeta($webserviceObject,$user){
		
		parent::__construct($webserviceObject,$user);
		
		$this->columnTableMapping = null;
		$this->fieldColumnMapping = null;
		$this->userAccessibleColumns = null;
		$this->mandatoryFields = null;
		$this->emailFields = null;
		$this->referenceFieldDetails = null;
		$this->ownerFields = null;
		$this->moduleFields = array();
		$this->hasAccess = false;
		$this->hasReadAccess = false;
		$this->hasWriteAccess = false;
		$this->hasDeleteAccess = false;
		$instance = vtws_getModuleInstance($this->webserviceObject);
		$this->idColumn = $instance->tab_name_index[$instance->table_name];
		$this->baseTable = $instance->table_name;
		
		$this->tabId = null;
	}
	
	public function getTabId(){
		if($this->tabId == null){
			$this->tabId = getTabid($this->objectName);
		}
		return $this->tabId;
	}
	
	public function getTabName(){
		if($this->objectName == 'Events'){
			return 'Calendar';
		}
		return $this->objectName;
	}
	
	private function computeAccess(){
		
		global $adb;
		
		$active = vtlib_isModuleActive($this->getTabName());
		if($active == false){
			$this->hasAccess = false;
			$this->hasReadAccess = false;
			$this->hasWriteAccess = false;
			$this->hasDeleteAccess = false;
		}
		
		require('user_privileges/user_privileges_'.$this->user->id.'.php');
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] == 0){
			$this->hasAccess = true;
			$this->hasReadAccess = true;
			$this->hasWriteAccess = true;
			$this->hasDeleteAccess = true;
		}else{
			
			//TODO get oer sort out the preference among profile2tab and profile2globalpermissions.
			//TODO check whether create/edit seperate controls required for web sevices?
			$profileList = getCurrentUserProfileList();
			
			$sql = "select * from vtiger_profile2globalpermissions where profileid in (".generateQuestionMarks($profileList).");";
			$result = $adb->pquery($sql,array($profileList));
			
			$noofrows = $adb->num_rows($result);
			//globalactionid=1 is view all action.
			//globalactionid=2 is edit all action.
			for($i=0; $i<$noofrows; $i++){
				$permission = $adb->query_result($result,$i,"globalactionpermission");
				$globalactionid = $adb->query_result($result,$i,"globalactionid");
				if($permission != 1 || $permission != "1"){
					$this->hasAccess = true;
					if($globalactionid == 2 || $globalactionid == "2"){
						$this->hasWriteAccess = true;
						$this->hasDeleteAccess = true;
					}else{
						$this->hasReadAccess = true;
					}
				}
			}
			
			$sql = 'select * from vtiger_profile2tab where profileid in ('.generateQuestionMarks($profileList).') and tabid = ?;';
			$result = $adb->pquery($sql,array($profileList,$this->getTabId()));
			$standardDefined = false;
			$permission = $adb->query_result($result,1,"permissions");
			if($permission == 1 || $permission == "1"){
				$this->hasAccess = false;
				return;
			}else{
				$this->hasAccess = true;
			}
			
			//operation=2 is delete operation.
			//operation=0 or 1 is create/edit operation. precise 0 create and 1 edit.
			//operation=3 index or popup. //ignored for websevices.
			//operation=4 is view operation.
			$sql = "select * from vtiger_profile2standardpermissions where profileid in (".generateQuestionMarks($profileList).") and tabid=?";
			$result = $adb->pquery($sql,array($profileList,$this->getTabId()));
			
			$noofrows = $adb->num_rows($result);
			for($i=0; $i<$noofrows; $i++){
				$standardDefined = true;
				$permission = $adb->query_result($result,$i,"permissions");
				$operation = $adb->query_result($result,$i,"Operation");
				if(!$operation){
					$operation = $adb->query_result($result,$i,"operation");
				}
				
				if($permission != 1 || $permission != "1"){
					$this->hasAccess = true;
					if($operation == 0 || $operation == "0"){
						$this->hasWriteAccess = true;
					}else if($operation == 1 || $operation == "1"){
						$this->hasWriteAccess = true;
					}else if($operation == 2 || $operation == "2"){
						$this->hasDeleteAccess = true;
					}else if($operation == 4 || $operation == "4"){
						$this->hasReadAccess = true;
					}
				}
			}
			if(!$standardDefined){
				$this->hasReadAccess = true;
				$this->hasWriteAccess = true;
				$this->hasDeleteAccess = true;
			}
			
		}
	}
	
	function hasAccess(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return $this->hasAccess;
	}
	
	function hasWriteAccess(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return $this->hasWriteAccess;
	}
	
	function hasReadAccess(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return $this->hasReadAccess;
	}
	
	function hasDeleteAccess(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return $this->hasDeleteAccess;
	}
	
	function hasPermission($operation,$id){
		
		$idComponents = vtws_getIdComponents($webserviceId);
		$id=$idComponents[1];
		
		$permitted = isPermitted($this->getTabName(),$operation,$id);
		if(strcmp($permitted,"yes")===0){
			return true;
		}
		return false;
	}
	
	function hasAssignPrivilege($webserviceId){
		global $adb;
		
		$idComponents = vtws_getIdComponents($webserviceId);
		$userId=$idComponents[1];
		$ownerTypeId = $idComponents[0];
		
		if($userId == null || $userId =='' || $ownerTypeId == null || $ownerTypeId ==''){
			return false;
		}
		$webserviceObject = VtigerWebserviceObject::fromId($adb,$ownerTypeId);
		if(strcasecmp($webserviceObject->getEntityName(),"Users")===0){
			if($userId == $this->user->id){
				return true;
			}
			if(!$this->assign){
				$this->retrieveUserHierarchy();
			}
			if(in_array($userId,array_keys($this->assignUsers))){
				return true;
			}else{
				return false;
			}
		}elseif(strcasecmp($webserviceObject->getEntityName(),"Groups") === 0){
			$tabId = $this->getTabId();
			$groups = vtws_getUserAccessibleGroups($tabId, $this->user);
			foreach ($groups as $group) {
				if($group['id'] == $userId){
					return true;
				}
			}
			return false;
		}
		
	}
	
	function getUserAccessibleColumns(){
		
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return parent::getUserAccessibleColumns();
	}
	
	function getColumnTableMapping(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return parent::getColumnTableMapping();
	}
	
	function getFieldColumnMapping(){
		
		if(!$this->meta){
			$this->retrieveMeta();
		}
		if($this->fieldColumnMapping === null){
			$this->fieldColumnMapping =  array();
			foreach ($this->moduleFields as $fieldName=>$webserviceField) {
				if(strcasecmp($webserviceField->getFieldDataType(),'file') !== 0){
					$this->fieldColumnMapping[$fieldName] = $webserviceField->getColumnName();
				}
			}
			$this->fieldColumnMapping['id'] = $this->idColumn;
		}
		return $this->fieldColumnMapping;
	}
	
	function getMandatoryFields(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return parent::getMandatoryFields();
	}
	
	function getReferenceFieldDetails(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return parent::getReferenceFieldDetails();
	}
	
	function getOwnerFields(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		return parent::getOwnerFields();
	}
	
	function getEntityName(){
		return $this->objectName;
	}
	
	function getEntityId(){
		return $this->objectId;
	}
	
	function getEmailFields(){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		parent::getEmailFields();
	}
	
	function getFieldIdFromFieldName($fieldName){
		if(!$this->meta){
			$this->retrieveMeta();
		}
		
		if(isset($this->moduleFields[$fieldName])){
			$webserviceField = $this->moduleFields[$fieldName];
			return $webserviceField->getFieldId();
		}
		return null;
	}
	
	function retrieveMeta(){
		
		global $current_language,$theme,$current_user,$default_language;
		
		$current_user = $this->user;
		$theme = $this->user->theme;
		$current_language = $default_language;
		//requie should happen here as it depends on state os of global vars to work
		require_once('modules/CustomView/CustomView.php');
		
		//$this->objectId = getObjectId($this->objectName);
		$this->computeAccess();
		
		$cv = new CustomView();
		$module_info = $cv->getCustomViewModuleInfo($this->getTabName());
		$blockArray = array();
		foreach($cv->module_list[$this->getTabName()] as $label=>$blockList){
			$blockArray = array_merge($blockArray,explode(',',$blockList));
		}
		$this->retrieveMetaForBlock($blockArray);
		
		$this->meta = true;
		
	}
	
	private function retrieveUserHierarchy(){
		
		$heirarchyUsers = get_user_array(false,"ACTIVE",$this->user->id);
		$groupUsers = vtws_getUsersInTheSameGroup($this->user->id);
		$this->assignUsers = $heirarchyUsers+$groupUsers;
		$this->assign = true;
	}
	
	private function retrieveMetaForBlock($block){
		
		global $adb;
		
		$tabid = $this->getTabId();
		require('user_privileges/user_privileges_'.$this->user->id.'.php');
		if($is_admin == true || $profileGlobalPermission[1] == 0 || $profileGlobalPermission[2] ==0){
				 	$sql = "select * from vtiger_field where tabid =? and block in (".generateQuestionMarks($block).") and displaytype in (1,2,3,4) and vtiger_field.presence in (0,2) group by columnname"; 
				$params = array($tabid, $block);	
		}else{
			$profileList = getCurrentUserProfileList();
			
			if (count($profileList) > 0) {
				$sql = "SELECT *
						FROM vtiger_field
						INNER JOIN vtiger_profile2field
						ON vtiger_profile2field.fieldid = vtiger_field.fieldid
						INNER JOIN vtiger_def_org_field
						ON vtiger_def_org_field.fieldid = vtiger_field.fieldid
						WHERE vtiger_field.tabid =? AND vtiger_profile2field.visible = 0 
						AND vtiger_profile2field.profileid IN (". generateQuestionMarks($profileList) .")
						AND vtiger_def_org_field.visible = 0 and vtiger_field.block in (".generateQuestionMarks($block).") and vtiger_field.displaytype in (1,2,3,4) and vtiger_field.presence in (0,2) group by columnname";
				$params = array($tabid, $profileList, $block);
			} else {
				$sql = "SELECT *
						FROM vtiger_field
						INNER JOIN vtiger_profile2field
						ON vtiger_profile2field.fieldid = vtiger_field.fieldid
						INNER JOIN vtiger_def_org_field
						ON vtiger_def_org_field.fieldid = vtiger_field.fieldid
						WHERE vtiger_field.tabid=? 
						AND vtiger_profile2field.visible = 0 
						AND vtiger_def_org_field.visible = 0 and vtiger_field.block in (".generateQuestionMarks($block).") and vtiger_field.displaytype in (1,2,3,4) and vtiger_field.presence in (0,2) group by columnname";
				$params = array($tabid, $block);
			}
		}
		
		$result = $adb->pquery($sql,$params);
		
		$noofrows = $adb->num_rows($result);
		$referenceArray = array();
		$knownFieldArray = array();
		for($i=0; $i<$noofrows; $i++){
			$fieldname = $adb->query_result($result,$i,"fieldname");
			if(strcasecmp($fieldname,'imagename')===0){
				continue;
			}
			$webserviceField = WebserviceField::fromQueryResult($adb,$result,$i);
			$this->moduleFields[$webserviceField->getFieldName()] = $webserviceField;
		}
	}
	
	function getObjectEntityName($webserviceId){
		global $adb;
		
		$idComponents = vtws_getIdComponents($webserviceId);
		$id=$idComponents[1];
		
		$seType = null;
		$sql = "select * from vtiger_crmentity where crmid=? and deleted=0";
		$result = $adb->pquery($sql , array($id));
		if($result != null && isset($result)){
			if($adb->num_rows($result)>0){
				$seType = $adb->query_result($result,0,"setype");
			}
		}
		
		if($seType === null){
			$sql = "select user_name from vtiger_users where id=? and deleted=0";
			$result = $adb->pquery($sql , array($id));
			if($result != null && isset($result)){
				if($adb->num_rows($result)>0){
					$seType = 'Users';
				}
			}
		}elseif($seType == "Calendar"){
			$seType = vtws_getCalendarEntityType($id);
		}
		return $seType;
	}
	
	function exists($recordId){
		global $adb;
		
		$exists = false;
		$sql = "select * from vtiger_crmentity where crmid=? and deleted=0";
		$result = $adb->pquery($sql , array($recordId));
		if($result != null && isset($result)){
			if($adb->num_rows($result)>0){
				$exists = true;
			}
		}
		return $exists;
	}
	
}

?>