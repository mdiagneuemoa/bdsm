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
/*********************************************************************************
 * $Header: /cvs/repository/siprodPCCI/modules/Rss/Delete.php,v 1.1 2010/01/15 18:44:31 isene Exp $
 * Description:  Deletes an Account record and then redirects the browser to the 
 * defined return URL.
 ********************************************************************************/


if(!isset($_REQUEST['record']))
	die($mod_strings['ERR_DELETE_RECORD']);

DeleteEntity($_REQUEST['module'],$_REQUEST['return_module'],'',$_REQUEST['record'],'');

 //code added for returning back to the current view after delete from list view
header("Location: index.php?module=".$_REQUEST['return_module']."&action=RssAjax&file=ListView&directmode=ajax");
?>
