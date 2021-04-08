<?php

abstract class WebserviceEntityOperation{
	protected $user;
	protected $log;
	protected $webserviceObject;
	protected $meta;
	
	protected function WebserviceEntityOperation($webserviceObject,$user,$adb,$log){
		$this->user = $user;
		$this->log = $log;
		$this->webserviceObject = $webserviceObject;
		$this->pearDB = $adb;
	}
	
	public function create($elementType,$element){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation Create is not supported for this entity");
	}
	
	public function retrieve($id){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation Retrieve is not supported for this entity");
	}
	
	public function update($element){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation Update is not supported for this entity");
	}
	
	public function delete($id){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation delete is not supported for this entity");
	}
	
	public function query($q){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation query is not supported for this entity");
	}
	
	public function describe($elementType){
		throw new WebServiceException(WebServiceErrorCode::$OPERATIONNOTSUPPORTED,
		"Operation describe is not supported for this entity");
	}
	
	function getFieldTypeDetails($webserviceField){
		global $upload_maxsize;
		$typeDetails = array();
		switch($webserviceField->getFieldDataType()){
			case 'reference': $typeDetails['refersTo'] = $webserviceField->getReferenceList();
				if(strtolower($this->meta->getEntityName())=="products" && $webserviceField->getUIType()==51){
					$typeDetails['refersTo'] = Array($this->meta->getEntityName());
				}
				break;
			case 'picklist': $typeDetails["picklistValues"] = $this->getPicklistDetails($webserviceField);
				$typeDetails['defaultValue'] = $typeDetails["picklistValues"][0]['value'];
				break;
			case 'file': $maxUploadSize = 0;
				$maxUploadSize = ini_get('upload_max_filesize');
				$maxUploadSize = strtolower($maxUploadSize);
				$maxUploadSize = explode('m',$maxUploadSize);
				$maxUploadSize = $maxUploadSize[0];
				if(!is_numeric($maxUploadSize)){
					$maxUploadSize = 0;
				}
				$maxUploadSize = $maxUploadSize * 1000000;
				if($upload_maxsize > $maxUploadSize){
					$maxUploadSize = $upload_maxsize;
				}
				$typeDetails['maxUploadFileSize'] = $maxUploadSize;
				break;
			case 'date': $typeDetails['format'] = $this->user->date_format;
		}
		return $typeDetails;
	}
	
	function isEditable($webserviceField){
		if(((int)$webserviceField->getDisplayType()) === 2 || strcasecmp($webserviceField->getFieldDataType(),"autogenerated")
			===0 || strcasecmp($webserviceField->getFieldDataType(),"id")===0){
			return false;
		}
		//uitype 70 is vtiger generated fields, such as (of vtiger_crmentity table) createdtime and modified time fields.
		if($webserviceField->getUIType() ==  70){
			return false;
		}
		return true;
	}
	
	function getPicklistDetails($webserviceField){
		$hardCodedPickListNames = array("hdntaxtype");
		$hardCodedPickListValues = array("hdntaxtype"=>array(array("label"=>"Individual","value"=>"individual"),
														array("label"=>"Group","value"=>"group")));
		if(in_array(strtolower($webserviceField->getFieldName()),$hardCodedPickListNames)){
			return $hardCodedPickListValues[strtolower($webserviceField->getFieldName())];
		}
		return $this->getPickListOptions($webserviceField->getFieldName());
	}
	
	function getPickListOptions($fieldName){
		
		$options = array();
		$sql = "select * from vtiger_picklist where name=?";
		$result = $this->pearDB->pquery($sql,array($fieldName));
		$numRows = $this->pearDB->num_rows($result);
		if($numRows == 0){
			$sql = "select * from vtiger_$fieldName";
			$result = $this->pearDB->pquery($sql,array());
			$numRows = $this->pearDB->num_rows($result);
			for($i=0;$i<$numRows;++$i){
				$elem = array();
				$elem["label"] = $this->pearDB->query_result($result,$i,$fieldName);
				$elem["value"] = $this->pearDB->query_result($result,$i,$fieldName);
				array_push($options,$elem);
			}
		}else{
			$details = getPickListValues($fieldName,$this->user->roleid);
			for($i=0;$i<sizeof($details);++$i){
				$elem = array();
				$elem["label"] = $details[$i];
				$elem["value"] = $details[$i];
				array_push($options,$elem);
			}
		}
		return $options;
	}
	
	function getIdField($label){
		return array('name'=>'id','label'=>$label,'mandatory'=>false,'type'=>'id','editable'=>false,'type'=>
						array('name'=>'autogenerated'),'nullable'=>false,'default'=>"");
	}
	
	/**
	 * @return Intance of EntityMeta class.
	 *
	 */
	abstract public function getMeta();
	
}

?>