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

require_once('Smarty_setup.php');
require_once('modules/SalesOrder/SalesOrder.php');
//Redirecting Header for single page layout
require_once('user_privileges/default_module_view.php');
global $singlepane_view;
if($singlepane_view == 'true' && $_REQUEST['action'] == 'CallRelatedList' )
{
	header("Location:index.php?action=DetailView&module=".$_REQUEST['module']."&record=".$_REQUEST['record']."&parenttab=".$_REQUEST['parenttab']);
}
else
{
$focus = new SalesOrder();
$currentmodule = $_REQUEST['module'];
$RECORD = $_REQUEST['record'];
if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve_entity_info($_REQUEST['record'],"SalesOrder");
    $focus->id = $_REQUEST['record'];
    $focus->name=$focus->column_fields['subject'];
$log->debug("id is ".$focus->id);
$log->debug("name is ".$focus->name);
}

global $mod_strings;
global $app_strings,$currentModule;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;

if(isset($_REQUEST['mode']) && $_REQUEST['mode'] != ' ') {
        $smarty->assign("OP_MODE",$_REQUEST['mode']);
}
if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
$related_array=getRelatedLists($currentModule,$focus);
$smarty->assign("RELATEDLISTS", $related_array);
$category = getParentTab();
$smarty->assign("TODO_PERMISSION",CheckFieldPermission('parent_id','Calendar'));
$smarty->assign("EVENT_PERMISSION",CheckFieldPermission('parent_id','Events'));
$smarty->assign("CATEGORY",$category);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));
$smarty->assign("ID",$focus->id);

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$smarty->assign("MODULE",$currentmodule);
$smarty->assign("SINGLE_MOD",$mod_strings['SalesOrder']);
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->display("RelatedLists.tpl");
}
?>
