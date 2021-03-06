<?php
class VtigerCRMActorMeta extends EntityMeta {
	private $pearDB;
	private static $fieldTypeMapping = array();
	
	function VtigerCRMActorMeta($tableName,$webserviceObject,$adb,$user){
		parent::__construct($webserviceObject,$user);
		$this->baseTable = $tableName;
		$this->idColumn = null;
		$this->pearDB = $adb;
		
		$fieldList = $this->getTableFieldList($tableName);
		$this->moduleFields = array();
		foreach ($fieldList as $field) {
			$this->moduleFields[$field->getFieldName()] = $field;
		}
		
		$this->pearDB = $adb;
	}
	
	private function getTableFieldList($tableName){
		$tableFieldList = array();
		
		$factory = WebserviceField::fromArray($this->pearDB,array('tablename'=>$tableName));
		$dbTableFields = $factory->getTableFields();
		foreach ($dbTableFields as $dbField) {
			if($dbField->primary_key){
				if($this->idColumn === null){
					$this->idColumn = $dbField->name;
				}else{
					throw new WebServiceException(WebServiceErrorCode::$UNKOWNENTITY,
						"Entity table with multi column primary key is not supported");
				}
			}
			$field = $this->getFieldArrayFromDBField($dbField,$tableName);
			$webserviceField = WebserviceField::fromArray($this->pearDB,$field);
			$fieldDataType = $this->getFieldType($dbField,$tableName);
			if($fieldDataType === null){
				$fieldDataType = $this->getFieldDataTypeFromDBType($dbField->type);
			}
			$webserviceField->setFieldDataType($fieldDataType);
			if(strcasecmp($fieldDataType,'reference') === 0){
				$webserviceField->setReferenceList($this->getReferenceList($dbField));
			}
			array_push($tableFieldList,$webserviceField);
		}
		return $tableFieldList;
	}
	
	private function getFieldArrayFromDBField($dbField,$tableName){
		$field = array();
		$field['fieldname'] = $dbField->name;
		$field['columnname'] = $dbField->name;
		$field['tablename'] = $tableName;
		$field['fieldlabel'] = str_replace('_', ' ',$dbField->name);
		$field['displaytype'] = 1;
		$field['uitype'] = 1;
		$fieldDataType = $this->getFieldType($dbField,$tableName);
		if($fieldDataType !== null){
			$fieldType = $this->getTypeOfDataForType($fieldDataType);
		}else{
			$fieldType = $this->getTypeOfDataForType($dbField->type);
		}
		$typeOfData = null;
		if($dbField->not_null && !$dbField->primary_key){
			$typeOfData = $fieldType.'~M';
		}else{
			$typeOfData = $fieldType.'~O';
		}
		$field['typeofdata'] = $typeOfData;
		$field['tabid'] = null;
		$field['fieldid'] = null;
		$field['masseditable'] = 0;
		return $field;
	}
	
	private function getReferenceList($dbField){
		static $referenceList = array();
		if(isset($referenceList[$dbField->name])){
			return $referenceList[$dbField->name];
		}
		if(!isset(VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name])){
			$this->getFieldType();
		}
		$fieldTypeData = VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name];
		$referenceTypes = array();
		$sql = "select * from vtiger_ws_entity_referencetype where fieldtypeid=?";
		$result = $this->pearDB->pquery($sql,array($fieldTypeData['fieldtypeid']));
		$numRows = $this->pearDB->num_rows($result);
		for($i=0;$i<$numRows;++$i){
			array_push($referenceTypes,$this->pearDB->query_result($result,$i,"type"));
		}
		$referenceList[$dbField->name] = $referenceTypes;
		return $referenceTypes;
	}
	
	private function getFieldType($dbField,$tableName){
		
		if(isset(VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name])){
			if(VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name] === 'null'){
				return null;
			}
			$row = VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name];
			return $row['fieldtype'];
		}
		$sql = "select * from vtiger_ws_entity_fieldtype where table_name=? and field_name=?;";
		$result = $this->pearDB->pquery($sql,array($tableName,$dbField->name));
		$rowCount = $this->pearDB->num_rows($result);
		if($rowCount > 0){
			$row = $this->pearDB->query_result_rowdata($result,0);
			VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name] = $row;
			return $row['fieldtype'];
		}else{
			VtigerCRMActorMeta::$fieldTypeMapping[$dbField->name] = 'null';
			return null;
		}
	}
	
	private function getTypeOfDataForType($type){
		switch($type){
			case 'email': return 'E';
			case 'password': return 'P';
			case 'date': return 'D';
			case 'datetime': return 'DT';
			case 'timestamp': return 'T';
			case 'int':
			case 'integer': return 'I';
			case 'numeric': return 'N';
			case 'varchar':
			case 'text':
			default: return 'V';
		}
	}
	
	private function getFieldDataTypeFromDBType($type){
		switch($type){
			case 'date': return 'date';
			case 'datetime': return 'datetime';
			case 'timestamp': return 'time';
			case 'int':
			case 'integer': return 'integer';
			case 'numeric': return 'double';
			case 'text': return 'text';
			case 'varchar': return 'string';
			default: return $type;
		}
	}
	
	function hasMandatoryFields($row){
		
		$mandatoryFields = $this->getMandatoryFields();
		$hasMandatory = true;
		foreach($mandatoryFields as $ind=>$field){
			if( !isset($row[$field])){
				$hasMandatory = false;
				break;
			}
		}
		return $hasMandatory;
		
	}
	
	public function hasPermission($operation,$webserviceId){
		if($this->user->is_admin){
			return true;
		}else{
			if(strcmp($operation,EntityMeta::$RETRIEVE)===0){
				return true;
			}
			return false;
		}
	}
	
	public function hasAssignPrivilege($ownerWebserviceId){
		if($this->user->is_admin){
			return true;
		}else{
			$idComponents = vtws_getIdComponents($webserviceId);
			$userId=$idComponents[1];
			if($this->user->id === $userId){
				return true;
			}
			return false;
		}
	}
	
	public function hasDeleteAccess(){
		if($this->user->is_admin){
			return true;
		}else{
			return false;
		}
	}
	
	public function hasAccess(){
		return true;
	}
	
	public function hasReadAccess(){
		return true;
	}
	
	public function hasWriteAccess(){
		if($this->user->is_admin){
			return true;
		}else{
			return false;
		}
	}
	
	public function getEntityName(){
		return $this->webserviceObject->getEntityName();
	}
	public function getEntityId(){
		return $this->webserviceObject->getEntityId();
	}
	
	function getObjectEntityName($webserviceId){
		
		$idComponents = vtws_getIdComponents($webserviceId);
		$id=$idComponents[1];
		
		if($this->exists($id)){
			return $this->webserviceObject->getEntityName();
		}
		return null;
	}
	
	function exists($recordId){
		$exists = false;
		$sql = 'select * from '.$this->baseTable.' where '.$this->getObectIndexColumn().'=?';
		$result = $this->pearDB->pquery($sql , array($recordId));
		if($result != null && isset($result)){
			if($this->pearDB->num_rows($result)>0){
				$exists = true;
			}
		}
		return $exists;
	}
}
?>