<?php
	
	function vtws_update($element,$user){
		
		global $log,$adb;
		$idList = vtws_getIdComponents($element['id']);
		$webserviceObject = VtigerWebserviceObject::fromId($adb,$idList[0]);
		$handlerPath = $webserviceObject->getHandlerPath();
		$handlerClass = $webserviceObject->getHandlerClass();
		
		require_once $handlerPath;
		
		$handler = new $handlerClass($webserviceObject,$user,$adb,$log);
		$meta = $handler->getMeta();
		$entityName = $meta->getObjectEntityName($element['id']);
		
		$types = vtws_listtypes($user);
		if(!in_array($entityName,$types['types'])){
			throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED,"Permission to perform the operation is denied");
		}
		
		if($entityName !== $webserviceObject->getEntityName()){
			throw new WebServiceException(WebServiceErrorCode::$INVALIDID,"Id specified is incorrect");
		}
		
		if(!$meta->hasPermission(EntityMeta::$UPDATE,$element['id'])){
			throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED,"Permission to read given object is denied");
		}
		
		if(!$meta->exists($idList[1])){
			throw new WebServiceException(WebServiceErrorCode::$RECORDNOTFOUND,"Record you are trying to access is not found");
		}
		
		if($meta->hasWriteAccess()!==true){
			throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED,"Permission to write is denied");
		}
		
		$referenceFields = $meta->getReferenceFieldDetails();
		foreach($referenceFields as $fieldName=>$details){
			if(isset($element[$fieldName]) && strlen($element[$fieldName]) > 0){
				$ids = vtws_getIdComponents($element[$fieldName]);
				$elemTypeId = $ids[0];
				$elemId = $ids[1];
				$referenceObject = VtigerWebserviceObject::fromId($adb,$elemTypeId);
				if(!in_array($referenceObject->getEntityName(),$details)){
					throw new WebServiceException(WebServiceErrorCode::$REFERENCEINVALID,
						"Invalid reference specified for $fieldName");
				}
				if(!in_array($referenceObject->getEntityName(),$types['types'])){
					throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED,
						"Permission to access reference type is denied ".$referenceObject->getEntityName());
				}
			}else if($element[$fieldName] !== NULL){
				unset($element[$fieldName]);
			}
		}
		
		if(!$meta->hasMandatoryFields($element)){
			throw new WebServiceException(WebServiceErrorCode::$MANDFIELDSMISSING,"Mandatory fields not specified");
		}
		$ownerFields = $meta->getOwnerFields();
		if(is_array($ownerFields) && sizeof($ownerFields) >0){
			foreach($ownerFields as $ownerField){
				if(isset($element[$ownerField]) && $element[$ownerField]!==null && 
					!$meta->hasAssignPrivilege($element[$ownerField])){
					throw new WebServiceException(WebServiceErrorCode::$ACCESSDENIED, "Cannot assign record to the given user");
				}
			}
		}
		
		return $handler->update($element);
	}
	
?>