<?php
class VtigerModuleOperation extends WebserviceEntityOperation {
	private $tabId;
	
	public function VtigerModuleOperation($webserviceObject,$user,$adb,$log){
		parent::__construct($webserviceObject,$user,$adb,$log);
		$this->meta = new VtigerCRMObjectMeta($this->webserviceObject,$this->user);
		$this->tabId = $this->meta->getTabId();
	}
	
	public function create($elementType,$element){
		$crmObject = new VtigerCRMObject($elementType, false);
		
		$element = DataTransform::sanitizeForInsert($element,$this->meta);
		
		$error = $crmObject->create($element);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		$id = $crmObject->getObjectId();
		
		$error = $crmObject->read($id);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		return DataTransform::filterAndSanitize($crmObject->getFields(),$this->meta);
	}
	
	public function retrieve($id){
		
		$ids = vtws_getIdComponents($id);
		$elemid = $ids[1];
		
		$crmObject = new VtigerCRMObject($this->tabId, true);
		$error = $crmObject->read($elemid);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		return DataTransform::filterAndSanitize($crmObject->getFields(),$this->meta);
	}
	
	public function update($element){
		$ids = vtws_getIdComponents($element["id"]);
		$element = DataTransform::sanitizeForInsert($element,$this->meta);
		
		$crmObject = new VtigerCRMObject($this->tabId, true);
		$crmObject->setObjectId($ids[1]);
		$error = $crmObject->update($element);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		$id = $crmObject->getObjectId();
		
		$error = $crmObject->read($id);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		return DataTransform::filterAndSanitize($crmObject->getFields(),$this->meta);
	}
	
	public function delete($id){
		$ids = vtws_getIdComponents($id);
		$elemid = $ids[1];
		
		$crmObject = new VtigerCRMObject($this->tabId, true);
		
		$error = $crmObject->delete($elemid);
		if(!$error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		return array("status"=>"successful");
	}
	
	public function query($q){
		
		$parser = new Parser($this->user, $q);
		$error = $parser->parse();
		
		if($error){
			return $parser->getError();
		}
		
		$mysql_query = $parser->getSql();
		$meta = $parser->getObjectMetaData();
		$this->pearDB->startTransaction();
		$result = $this->pearDB->pquery($mysql_query, array());
		$error = $this->pearDB->hasFailedTransaction();
		$this->pearDB->completeTransaction();
		
		if($error){
			throw new WebServiceException(WebServiceErrorCode::$DATABASEQUERYERROR,"Database error while performing required operation");
		}
		
		$noofrows = $this->pearDB->num_rows($result);
		$output = array();
		for($i=0; $i<$noofrows; $i++){
			$row = $this->pearDB->fetchByAssoc($result,$i);
			if(!$meta->hasPermission(EntityMeta::$RETRIEVE,$row["crmid"])){
				continue;
			}
			$output[] = DataTransform::sanitizeDataWithColumn($row,$meta);
		}
		
		return $output;
	}
	
	public function describe($elementType){
		global $app_strings,$current_user;
		
		$current_user = $this->user;
		$label = (isset($app_strings[$elementType]))? $app_strings[$elementType]:$elementType;
		$createable = (strcasecmp(isPermitted($elementType,EntityMeta::$CREATE),'yes')===0)? true:false;
		$updateable = (strcasecmp(isPermitted($elementType,EntityMeta::$UPDATE),'yes')===0)? true:false;
		$deleteable = $this->meta->hasDeleteAccess();
		$retrieveable = $this->meta->hasReadAccess();
		$fields = $this->getModuleFields();
		return array("label"=>$label,"name"=>$elementType,"createable"=>$createable,"updateable"=>$updateable,
				"deleteable"=>$deleteable,"retrieveable"=>$retrieveable,"fields"=>$fields,
				"idPrefix"=>$this->meta->getEntityId());
	}
	
	function getModuleFields(){
		
		$fields = array();
		$moduleFields = $this->meta->getModuleFields();
		foreach ($moduleFields as $fieldName=>$webserviceField) {
			array_push($fields,$this->getDescribeFieldArray($webserviceField));
		}
		array_push($fields,$this->getIdField($this->meta->getObectIndexColumn()));
		
		return $fields;
	}
	
	function getDescribeFieldArray($webserviceField){
		global $default_language;
		
		require 'modules/'.$this->meta->getTabName()."/language/$default_language.lang.php";
		$fieldLabel = $webserviceField->getFieldLabelKey();
		if(isset($mod_strings[$fieldLabel])){
			$fieldLabel = $mod_strings[$fieldLabel];
		}
		$typeDetails = $this->getFieldTypeDetails($webserviceField);
		
		//set type name, in the type details array.
		$typeDetails['name'] = $webserviceField->getFieldDataType();
		$editable = $this->isEditable($webserviceField);
		
		$describeArray = array('name'=>$webserviceField->getFieldName(),'label'=>$fieldLabel,'mandatory'=>
			$webserviceField->isMandatory(),'type'=>$typeDetails,'nullable'=>$webserviceField->isNullable(),
			"editable"=>$editable);
		if($webserviceField->hasDefault()){
			$describeArray['default'] = $webserviceField->getDefault();
		}
		return $describeArray;
	}
	
	function getMeta(){
		return $this->meta;
	}
	
	function getField($fieldName){
		$moduleFields = $this->meta->getModuleFields();
		return $this->getDescribeFieldArray($moduleFields[$fieldName]);
	}
	
}
?>