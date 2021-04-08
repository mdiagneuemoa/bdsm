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
	if($folderType=="Rapport") $tablename= "vtiger_rapportsfolder";
	else if($folderType=="Document") $tablename= "vtiger_attachmentsfolder";
	
	//echo $foldername,"-",$folderdesc,"-",$folderFatherId;	
	
	if(isset($_REQUEST['savemode']) && $_REQUEST['savemode'] == 'Save')
	{
		if($folderid == "")
		{
			if(!folderNameExist($foldername))
			{
			
				$parentFolderDetails=getFolderInformation($folderFatherId);
				$parentFolderInfo=$parentFolderDetails[$folderFatherId];
				$Folderid_no=$adb->getUniqueId($tablename);
				$FolderId='R'.$Folderid_no;
				$parentFolderHr=$parentFolderInfo[1];
				$parentFolderDepth=intval($parentFolderInfo[2]);
				$nowParentFolderHr=$parentFolderHr.'::'.$FolderId;
				$nowFolderDepth=$parentFolderDepth + 1;
				//Inserting vtiger_rapportfolder into db
				$query="insert into ".$tablename." values(?,?,?,?,?,?)";
				$qparams = array($FolderId,$foldername,$folderdesc,$nowParentFolderHr,$folderpotentialId,$nowFolderDepth);
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
			/*
			$params=array();
			$sqlfid="select max(folderid) from vtiger_attachmentsfolder";
			$fid=$adb->query_result($adb->pquery($sqlfid,$params),0,'max(folderid)')+1;
			$params=array();
			$sqlseq="select max(sequence) from vtiger_attachmentsfolder";
			$sequence=$adb->query_result($adb->pquery($sqlseq,$params),0,'max(sequence)')+1;
			$params=array();
			$dbQuery="select * from vtiger_attachmentsfolder";
			$result1=$adb->pquery($dbQuery,array());
			$flag=0;
			for($i=0;$i<$adb->num_rows($result1);$i++)
			{
				$dbfldrname=$adb->query_result($result1,$i,'foldername');
				if($dbfldrname == $foldername)
					$flag = 1;
			}
			if($flag == 0)
			{
				$sql="insert into vtiger_attachmentsfolder (folderid,foldername,description,createdby,sequence)values ($fid,'".$foldername."','".$folderdesc."',".$current_user->id.",$sequence)";
				$result=$adb->pquery($sql,$params);
				if(!$result)
				{
					echo "Failure";
				}
				else
					header("Location: index.php?action=DocumentsAjax&file=ListView&mode=ajax&module=Documents");
			}
			elseif($flag == 1)
				echo "DUPLICATE_FOLDERNAME";
			*/	
	
		/*
		elseif($folderid != "")
		{			
			$dbQuery="select * from vtiger_attachmentsfolder";
			$result1=$adb->pquery($dbQuery,array());
			$flag=0;
			for($i=0;$i<$adb->num_rows($result1);$i++)
			{
				$dbfldrname=$adb->query_result($result1,$i,'foldername');
				if($dbfldrname == $foldername)
					$flag = 1;
			}			
			if($flag == 0)
			{
				$sql="update vtiger_attachmentsfolder set foldername= ? where folderid= ? ";
				$result=$adb->pquery($sql,array($foldername,$folderid));
				if(!$result)
				{
					echo "Failure";
				}
				else
					echo 'Success';
			}
			elseif($flag == 1)
				echo "DUPLICATE_FOLDERNAME";
		}*/
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

function folderNameExist($foldername)
{
	global $log;
	$log->debug("Entering folderNameExist(".$foldername.") method ...");
	global $adb,$tablename;
	$query = "select * from ".$tablename." where foldername=?";
	$result = $adb->pquery($query, array($foldername));
	$log->debug("Exiting getfolderInformation method ...");
	if($adb->num_rows($result)==0) return false;
	else return true; 	 
}	
	
?>
