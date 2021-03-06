<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

/*
 * File containing methods to proceed with the ui validation for all the forms
 *
 */
/** Function to get the details for fieldlabels for a given table array
  * @param $tablearray -- tablearray:: Type string array (table names in array)
  * @param $tabid -- tabid:: Type integer 
  * @returns $fieldName_array -- fieldName_array:: Type string array (field name details)
  *
 */


function getDBValidationData($tablearray,$tabid='')
{
  global $log;
  $log->debug("Entering getDBValidationData(".$tablearray.",".$tabid.") method ...");
  $sql = '';
  $params = array();
  $tab_con = "";
  $numValues = count($tablearray);
  global $adb,$mod_strings;

  if($tabid!='') $tab_con = ' and tabid='. mysql_real_escape_string($tabid);
	
  for($i=0;$i<$numValues;$i++)
  {

  	if(in_array("emails",$tablearray))
  	{
		if($numValues > 1 && $i != $numValues-1)
    	{
			$sql .= "select fieldlabel,fieldname,typeofdata from vtiger_field where tablename=? and tabid=10 and vtiger_field.presence in (0,2) and displaytype <> 2 union ";
			array_push($params, $tablearray[$i]);	
     	}
   		else
    	{
   			$sql  .= "select fieldlabel,fieldname,typeofdata from vtiger_field where tablename=? and tabid=10 and vtiger_field.presence in (0,2) and displaytype <> 2 ";
    		array_push($params, $tablearray[$i]);	
		}
  	}
  	else
  	{
    		if($numValues > 1 && $i != $numValues-1)
    		{
      			$sql .= "select fieldlabel,fieldname,typeofdata from vtiger_field where tablename=? $tab_con and displaytype in (1,3) and vtiger_field.presence in (0,2) union ";
    			array_push($params, $tablearray[$i]);	
			}
    		else
    		{
      			$sql  .= "select fieldlabel,fieldname,typeofdata from vtiger_field where tablename=? $tab_con and displaytype in (1,3) and vtiger_field.presence in (0,2)";
    			array_push($params, $tablearray[$i]);	
			}
  	}
  }
  $result = $adb->pquery($sql, $params);
  $noofrows = $adb->num_rows($result);
  $fieldName_array = Array();
  for($i=0;$i<$noofrows;$i++)
  {
    $fieldlabel = getTranslatedString($adb->query_result($result,$i,'fieldlabel'));
    $fieldname = $adb->query_result($result,$i,'fieldname');
    $typeofdata = $adb->query_result($result,$i,'typeofdata');
   //echo '<br> '.$fieldlabel.'....'.$fieldname.'....'.$typeofdata;
    $fldLabel_array = Array();
    $fldLabel_array[$fieldlabel] = $typeofdata;
    $fieldName_array[$fieldname] = $fldLabel_array;

  }

  
  $log->debug("Exiting getDBValidationData method ...");
  return $fieldName_array;
  


}
?>
