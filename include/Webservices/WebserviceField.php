<?php

class WebserviceField{
	private $fieldId;
	private $uitype;
	private $blockId;
	private $nullable;
	private $default;
	private $tableName;
	private $columnName;
	private $fieldName;
	private $fieldLabel;
	private $editable;
	private $fieldType;
	private $displayType;
	private $mandatory;
	private $massEditable;
	private $tabid;
	private $pearDB;
	private $typeOfData;
	private $fieldDataType;
	private $dataFromMeta;
	private static $tableMeta = array();
	private static $fieldTypeMapping = array();
	private $referenceList;
	private $defaultValuePresent;
	
	private function WebserviceField($adb,$row){
		$this->uitype = $row['uitype'];
		$this->blockId = $row['block'];
		$this->tableName = $row['tablename'];
		$this->columnName = $row['columnname'];
		$this->fieldName = $row['fieldname'];
		$this->fieldLabel = $row['fieldlabel'];
		$this->displayType = $row['displaytype'];
		$this->massEditable = ($row['masseditable'] === 1)? true: false;
		$typeOfData = $row['typeofdata'];
		$this->typeOfData = $typeOfData;
		$typeOfData = explode("~",$typeOfData);
		$this->mandatory = ($typeOfData[1] == 'M')? true: false;
		if($this->uitype == 4){
			$this->mandatory = false;
		}
		$this->fieldType = $typeOfData[0];
		$this->tabid = $row['tabid'];
		$this->fieldId = $row['fieldid'];
		$this->pearDB = $adb;
		$this->fieldDataType = null;
		$this->dataFromMeta = false;
		$this->defaultValuePresent = false;
		$this->referenceList = null;
	}
	
	public static function fromQueryResult($adb,$result,$rowNumber){
		 return new WebserviceField($adb,$adb->query_result_rowdata($result,$rowNumber));
	}
	
	public static function fromArray($adb,$row){
		return new WebserviceField($adb,$row);
	}
	
	public function getTableName(){
		return $this->tableName;
	}
	
	public function getFieldName(){
		return $this->fieldName;
	}
	
	public function getFieldLabelKey(){
		return $this->fieldLabel;
	}
	
	public function getFieldType(){
		return $this->fieldType;
	}
	
	public function isMandatory(){
		return $this->mandatory;
	}
	
	public function getTypeOfData(){
		return $this->typeOfData;
	}
	
	public function getDisplayType(){
		return $this->displayType;
	}
	
	public function getMassEditable(){
		return $this->massEditable;
	}
	
	public function getFieldId(){
		return $this->fieldId;
	}
	
	public function getDefault(){
		if($this->dataFromMeta !== true){
			$this->fillColumnMeta();
		}
		return $this->default;
	}
	
	public function getColumnName(){
		return $this->columnName;
	}
	
	public function isNullable(){
		if($this->dataFromMeta !== true){
			$this->fillColumnMeta();
		}
		return $this->nullable;
	}
	
	public function hasDefault(){
		if($this->dataFromMeta !== true){
			$this->fillColumnMeta();
		}
		return $this->defaultValuePresent;
	}
	
	public function getUIType(){
		return $this->uitype;
	}
	
	private function setNullable($nullable){
		$this->nullable = $nullable;
	}
	
	private function setDefault($value){
		$this->default = $value;
	}
	
	public function setFieldDataType($dataType){
		$this->fieldDataType = $dataType;
	}
	
	public function setReferenceList($referenceList){
		$this->referenceList = $referenceList;
	}
	
	public function getTableFields(){
		$tableFields = null;
		if(isset(WebserviceField::$tableMeta[$this->getTableName()])){
			$tableFields = WebserviceField::$tableMeta[$this->getTableName()];
		}else{
			$dbMetaColumns = $this->pearDB->database->MetaColumns($this->getTableName());
			$tableFields = array();
			foreach ($dbMetaColumns as $key => $dbField) {
				$tableFields[$dbField->name] = $dbField;
			}
			WebserviceField::$tableMeta[$this->getTableName()] = $tableFields;
		}
		return $tableFields;
	}
	public function fillColumnMeta(){
		$tableFields = $this->getTableFields();
		foreach ($tableFields as $fieldName => $dbField) {
			if(strcmp($fieldName,$this->getColumnName())===0){
				$this->setNullable(!$dbField->not_null);
				if($dbField->has_default === true){
					$this->defaultValuePresent = $dbField->has_default;
					$this->setDefault($dbField->default_value);
				}
			}
		}
		$this->dataFromMeta = true;
	}
	
	public function getFieldDataType(){
		if($this->fieldDataType === null){
			$fieldDataType = $this->getFieldTypeFromUIType();
			if($fieldDataType === null){
				$fieldDataType = $this->getFieldTypeFromTypeOfData();
			}
			$tableFieldDataType = $this->getFieldTypeFromTable();
			if($tableFieldDataType == 'datetime'){
				$fieldDataType = $tableFieldDataType;
			}
			$this->fieldDataType = $fieldDataType;
		}
		return $this->fieldDataType;
	}
	
	public function getReferenceList(){
		static $referenceList = array();
		if($this->referenceList === null){
			if(isset($referenceList[$this->getUIType()])){
				$this->referenceList = $referenceList[$this->getUIType()];
				return $referenceList[$this->getUIType()];
			}
			if(!isset(WebserviceField::$fieldTypeMapping[$this->getUIType()])){
				$this->getFieldTypeFromUIType();
			}
			$fieldTypeData = WebserviceField::$fieldTypeMapping[$this->getUIType()];
			$referenceTypes = array();
			$sql = "select * from vtiger_ws_referencetype where fieldtypeid=?";
			$result = $this->pearDB->pquery($sql,array($fieldTypeData['fieldtypeid']));
			$numRows = $this->pearDB->num_rows($result);
			for($i=0;$i<$numRows;++$i){
				array_push($referenceTypes,$this->pearDB->query_result($result,$i,"type"));
			}
			$referenceList[$this->getUIType()] = $referenceTypes;
			$this->referenceList = $referenceTypes;
			return $referenceTypes;
		}
		return $this->referenceList;
	}
	
	private function getFieldTypeFromTable(){
		$tableFields = $this->getTableFields();
		foreach ($tableFields as $fieldName => $dbField) {
			if(strcmp($fieldName,$this->getColumnName())===0){
				return $dbField->type;
			}
		}
		//This should not be returned if entries in DB are correct.
		return null;
	}
	
	private function getFieldTypeFromTypeOfData(){
		switch($this->fieldType){
			case 'T': return "time";
			case 'D':
			case 'DT': return "date";
			case 'E': return "email";
			case 'N':
			case 'NN': return "double";
			case 'P': return "password";
			case 'I': return "integer";
			case 'V':
			default: return "string";
		}
	}
	
	private function getFieldTypeFromUIType(){
		
		if(isset(WebserviceField::$fieldTypeMapping[$this->getUIType()])){
			if(WebserviceField::$fieldTypeMapping[$this->getUIType()] === null){
				return null;
			}
			$row = WebserviceField::$fieldTypeMapping[$this->getUIType()];
			return $row['fieldtype'];
		}
		$sql = "select * from vtiger_ws_fieldtype where uitype=?;";
		$result = $this->pearDB->pquery($sql,array($this->getUIType()));
		$rowCount = $this->pearDB->num_rows($result);
		if($rowCount > 0){
			$row = $this->pearDB->query_result_rowdata($result,0);
			WebserviceField::$fieldTypeMapping[$this->getUIType()] = $row;
			return $row['fieldtype'];
		}else{
			WebserviceField::$fieldTypeMapping[$this->getUIType()] = null;
			return null;
		}
	}
}

?>