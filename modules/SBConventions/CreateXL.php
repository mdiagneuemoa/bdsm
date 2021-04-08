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
//error_reporting(E_ALL ^ E_NOTICE); 
global $php_max_execution_time;
set_time_limit($php_max_execution_time);
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view;

global $adb;

require_once("include/php_writeexcel/class.writeexcel_workbook.inc.php");
require_once("include/php_writeexcel/class.writeexcel_worksheet.inc.php");
require_once('include/DatabaseUtil.php');


global $tmp_dir, $root_directory;

$fname = tempnam($root_directory.$tmp_dir, "merge2.xls");
$workbook = &new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet();


# Set the column width for columns 1, 2, 3 and 4
$worksheet->set_column(0, 5, 28);

# Create a format for the column headings
$header =& $workbook->addformat();
$header->set_bold();
$header->set_size(10);
$header->set_align('center');
$header->set_color('blue');
$header->set_border(1);

$info =& $workbook->addformat();
$info->set_size(10);
$info->set_align('center');
$info->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(10);
$total->set_align('center');
$total->set_border(1);


$merged_cells = &$workbook->addformat();
$merged_cells->set_bold();
$merged_cells->set_color('blue');
//$merged_cells->set_fg_color('51');
$merged_cells->set_align('center');
$merged_cells->set_size('10');
$merged_cells->set_align('vcenter');
$merged_cells->set_border(1);
// indique qu'une cellule de ce format servira à la fusion
$merged_cells->set_merge();


$export_query = $_SESSION[$currentModule.'_listquery'];

$list_result = $adb->pquery($export_query, array());
$noofrows = $adb->num_rows($list_result);



$worksheet->write_blank(4,0, $merged_cells);
$worksheet->write_blank(4,1, $merged_cells);
$worksheet->write_blank(4,2, $merged_cells);
$worksheet->write_blank(4,3, $merged_cells);
$worksheet->write_blank(4,4, $merged_cells);

$worksheet->write(4,5, utf8_decode($app_strings['LBL_JOKCALL_TOTAL_TIME']),$merged_cells);
$worksheet->write_blank(4,6, $merged_cells);
$worksheet->write_blank(4,7, $merged_cells);
$worksheet->write_blank(4,8, $merged_cells);
$worksheet->write_blank(4,9, $merged_cells);	
$worksheet->write_blank(4,10, $merged_cells);	
$worksheet->write_blank(4,11, $merged_cells);	

$worksheet->write(4,12, utf8_decode($app_strings['LBL_JOKCALL_TOTAL_CALLS']),$merged_cells);
$worksheet->write_blank(4,13, $merged_cells);

$worksheet->write(4,14, utf8_decode($app_strings['LBL_JOKCALL_TOTAL_NUMBER']),$merged_cells);
$worksheet->write_blank(4,15, $merged_cells);
$worksheet->write_blank(4,16, $merged_cells);
$worksheet->write_blank(4,17, $merged_cells);	


$worksheet->write(5,0, $mod_strings['Jour Prod'],$header);
$worksheet->write(5,1, $mod_strings['Tranche Horaire'],$header);
$worksheet->write(5,2, $mod_strings['USER ID'],$header);
$worksheet->write(5,3, $mod_strings['Nom'],$header);
$worksheet->write(5,4, $mod_strings['Operation'],$header);
$worksheet->write(5,5, $mod_strings['Total Time Login'],$header);
$worksheet->write(5,6, $mod_strings['Total Time Not Ready'],$header);
$worksheet->write(5,7, $mod_strings['Total Time Wait'],$header);
$worksheet->write(5,8, $mod_strings['Total Time Talk'],$header);
$worksheet->write(5,9, $mod_strings['Total Time After Call Work'],$header);
$worksheet->write(5,10, $mod_strings['Total Time In Bound Talk'],$header);
$worksheet->write(5,11, $mod_strings['Total Time Internal Talk'],$header);
$worksheet->write(5,12, $mod_strings['Total Calls'],$header);
$worksheet->write(5,13, $mod_strings['Total In Bound Calls'],$header);
$worksheet->write(5,14, $mod_strings['Total Internal Calls'],$header);
$worksheet->write(5,15, $mod_strings['Total Wait Number'],$header);
$worksheet->write(5,16, $mod_strings['Total Not Ready Number'],$header);
$worksheet->write(5,17, $mod_strings['Total Number On Hold'],$header);
	
	
$line=6;	

for ($i=1; $i<=$noofrows; $i++)
{
	$ag_jour_prod = $adb->query_result($list_result,$i-1,"ag_jour_prod");
	$ag_heure = $adb->query_result($list_result,$i-1,"ag_heure");
	$ag_user_id = $adb->query_result($list_result,$i-1,"ag_user_id");
	$ag_nom = $adb->query_result($list_result,$i-1,"ag_nom");
	$ag_op_lib = $adb->query_result($list_result,$i-1,"ag_op_lib");
	$ag_total_time_login = $adb->query_result($list_result,$i-1,"ag_total_time_login");
	$ag_total_time_not_ready = $adb->query_result($list_result,$i-1,"ag_total_time_not_ready");
	$ag_total_time_wait = $adb->query_result($list_result,$i-1,"ag_total_time_wait");
	$ag_total_time_talk = $adb->query_result($list_result,$i-1,"ag_total_time_talk");
	$ag_total_time_after_call_work = $adb->query_result($list_result,$i-1,"ag_total_time_after_call_work");
	$ag_total_time_in_bound_talk = $adb->query_result($list_result,$i-1,"ag_total_time_in_bound_talk");
	$ag_total_time_internal_talk = $adb->query_result($list_result,$i-1,"ag_total_time_internal_talk");
	$ag_total_calls = $adb->query_result($list_result,$i-1,"ag_total_calls");
	$ag_total_in_bound_calls = $adb->query_result($list_result,$i-1,"ag_total_in_bound_calls");
	$ag_total_internal_calls = $adb->query_result($list_result,$i-1,"ag_total_internal_calls");
	$ag_total_wait_number = $adb->query_result($list_result,$i-1,"ag_total_wait_number");
	$ag_total_not_ready_number = $adb->query_result($list_result,$i-1,"ag_total_not_ready_number");
	$ag_total_number_on_hold = $adb->query_result($list_result,$i-1,"ag_total_number_on_hold");
	

	$ag_tranche_h = $adb->query_result($list_result,$i-1,"ag_tranche_h");
	$val = $ag_heure;
	switch ($ag_tranche_h) {
		case 1 : 
			$ag_heure = sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_1']."-".sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_2']; 
			break;
		case 2 : 
			$ag_heure = sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_2']."-".sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_3']; 
			break;
		case 3 : 
			$ag_heure = sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_3']."-".sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_4']; 
			break;
		case 4 : 
			$ag_heure = sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_4']."-".sprintf("%02d", (($val+1)==24?0:($val+1))).$app_strings['LBL_JOKCALL_TRANCHE_QUATER_1']; 
			break;
		default :
			if($val == '') {
				$ag_heure = "00".$app_strings['LBL_JOKCALL_TRANCHE_HOUR']."-"."23".$app_strings['LBL_JOKCALL_TRANCHE_HOUR'];
			}
			else {
				$ag_heure = sprintf("%02d", ($val)).$app_strings['LBL_JOKCALL_TRANCHE_HOUR']."-".sprintf("%02d", (($val+1)==24?0:($val+1))).$app_strings['LBL_JOKCALL_TRANCHE_HOUR'];
			} 
			break;
	}

	
	$worksheet->write($line,0, utf8_decode($ag_jour_prod),$info);
	$worksheet->write($line,1, utf8_decode($ag_heure),$info);
	$worksheet->write($line,2, utf8_decode($ag_user_id),$info);
	$worksheet->write($line,3, utf8_decode($ag_nom),$info);
	$worksheet->write($line,4, utf8_decode($ag_op_lib),$info);
	$worksheet->write($line,5, utf8_decode($ag_total_time_login),$info);
	$worksheet->write($line,6, utf8_decode($ag_total_time_not_ready),$info);
	$worksheet->write($line,7, utf8_decode($ag_total_time_wait),$info);
	$worksheet->write($line,8, utf8_decode($ag_total_time_talk),$info);
	$worksheet->write($line,9, utf8_decode($ag_total_time_after_call_work),$info);
	$worksheet->write($line,10, utf8_decode($ag_total_time_in_bound_talk),$info);
	$worksheet->write($line,11, utf8_decode($ag_total_time_internal_talk),$info);
	$worksheet->write($line,12, utf8_decode($ag_total_calls),$info);
	$worksheet->write($line,13, utf8_decode($ag_total_in_bound_calls),$info);
	$worksheet->write($line,14, utf8_decode($ag_total_internal_calls),$info);
	$worksheet->write($line,15, utf8_decode($ag_total_wait_number),$info);
	$worksheet->write($line,16, utf8_decode($ag_total_not_ready_number),$info);
	$worksheet->write($line,17, utf8_decode($ag_total_number_on_hold),$info);
	
	$line++;
}

$workbook->close();

if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
{
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
header("Content-Type: application/x-msexcel");
header("Content-Length: ".@filesize($fname));
//header("Content-disposition: attachment; filename=".$timesheet['timesheetname'].".xls");
header("Content-disposition: attachment; filename=$currentModule.xls");
$fh=fopen($fname, "rb");
fpassthru($fh);
//unlink($fname);
?>
