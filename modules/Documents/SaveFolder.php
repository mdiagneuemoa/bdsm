<?php
/*********************************************************************************
* * The contents of this file are subject to the vtiger CRM Public License Version 1.0
* * ("License"); You may not use this file except in compliance with the License
* * The Original Code is:  vtiger CRM Open Source
* * The Initial Developer of the Original Code is vtiger.
* * Portions created by vtiger are Copyright (C) vtiger.
* * All Rights Reserved.
* *
* ********************************************************************************/
require_once('modules/Documents/Documents.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');

global $adb,$tablename;



	$local_log =& LoggerManager::getLogger('index');
	$folderid = $_REQUEST['record'];
	$foldername = utf8RawUrlDecode($_REQUEST["foldername"]);
	$folderdesc = utf8RawUrlDecode($_REQUEST["folderdesc"]);
	$folderFatherId = $_REQUEST["folderFatherId"];
	$folderpotentialId = intval($_REQUEST["potentialId"]);
	$folderType = $_REQUEST["folderType"];
	$tablename = "";
	if($folderType=="Rapport") 
	{
		$tablename= "vtiger_rapportsfolder";
		$prefix='R';
	}	
	else if($folderType=="Document") 
	{
		$tablename= "vtiger_attachmentsfolder";
		$prefix='D';
	}	
	
	//echo $foldername,"-",$folderdesc,"-",$folderFatherId;	
	
	if(isset($_REQUEST['savemode']) && $_REQUEST['savemode'] == 'Save')
	{
		if($folderid == "")
		{
			$parentFolderDetails=getFolderInformation($folderFatherId);
			$parentFolderInfo=$parentFolderDetails[$folderFatherId];
			$folderdepth = $parentFolderInfo[2]+1;
			if(!folderNameExist($foldername,$folderFatherId,$folderdepth))
			{
				$Folderid_no=$adb->getUniqueId($tablename);
				$FolderId=$prefix.$Folderid_no;
				$parentFolderHr=$parentFolderInfo[1];
				$parentFolderDepth=intval($parentFolderInfo[2]);
				$nowParentFolderHr=$parentFolderHr.'::'.$FolderId;
				$nowFolderDepth=$parentFolderDepth + 1;
				
				if($folderType=="Rapport") 
				{
					$query="insert into ".$tablename." values(?,?,?,?,?,?)";
					$qparams = array($FolderId,$foldername,$folderdesc,$nowParentFolderHr,$folderpotentialId,$nowFolderDepth);
							
				}	
				else if($folderType=="Document") 
				{
					$query="insert into ".$tablename." values(?,?,?,?,?)";
					$qparams = array($FolderId,$foldername,$folderdesc,$nowParentFolderHr,$nowFolderDepth);
							
				}	
				//Inserting vtiger_rapportfolder into db
				//$query="insert into ".$tablename." values(?,?,?,?,?,?)";
				//$qparams = array($FolderId,$foldername,$folderdesc,$nowParentFolderHr,$folderpotentialId,$nowFolderDepth);
				//echo $FolderId,":",$foldername,";",$folderdesc,":",$nowParentFolderHr,":",$folderpotentialId,":",$nowFolderDepth;
				$result = $adb->pquery($query,$qparams);
				
				if(!$result)
				{
					echo "FAILURE";
				}
				else
				{
					//header("Location: index.php?action=DocumentsAjax&file=ListView&mode=ajax&module=Documents");
					echo "SUCCES";
				}				
			}
			else
				echo "DUPLICATE_FOLDERNAME";
			
		}	
			
	}

function getFolderInformation($folderid)
{
	global $log,$tablename;
	$log->debug("Entering getFolderInformation(".$folderid.") method ...");
	global $adb;
	$query = "select * from ".$tablename." where folderid=?";
	$result = $adb->pquery($query, array($folderid));
	$foldernameSQL=$adb->query_result($result,0,'foldername');
	$parentfolderSQL=$adb->query_result($result,0,'parentfolder');
	$folderdepth=$adb->query_result($result,0,'depth');
	$parentfolderArr=explode('::',$parentfolder);
	$immediateParent=$parentfolderArr[sizeof($parentfolderArr)-2];
	$folderDet=Array();
	$folderDet[]=$foldernameSQL;
	$folderDet[]=$parentfolderSQL;
	$folderDet[]=$folderdepth;
	$folderDet[]=$immediateParent;
	$folderInfo=Array();
	$folderInfo[$folderid]=$folderDet;
	$log->debug("Exiting getfolderInformation method ...");
	return $folderInfo;	
}	

function folderNameExist($foldername,$folderFatherId,$folderdepth)
{
	global $log;
	$log->debug("Entering folderNameExist(".$foldername.") method ...");
	global $adb,$tablename;
	$query = "select foldername,parentfolder,depth from ".$tablename." where foldername= ? and depth=?";
	$result = $adb->pquery($query, array($foldername,$folderdepth));
	$log->debug("Exiting getfolderInformation method ...");
	$chn = $foldername."-".$folderdepth.":";
	if($adb->num_rows($result)==0)
	{
		return false;
	}
	else
	{
		$fldfather = $adb->query_result($result,0,'parentfolder');
		$fldfatherArr=explode('::',$fldfather);
		$immediateParent2=$fldfatherArr[sizeof($fldfatherArr)-2];
		if($folderFatherId==$immediateParent2)
		return true;
	}	
	
 
	 	 
}	
	
?>
