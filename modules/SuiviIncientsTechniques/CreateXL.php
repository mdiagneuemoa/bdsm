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
//$worksheet->set_column(0, 10, 15);

# Create a format for the column headings
$header =& $workbook->addformat();
$header->set_bold();
$header->set_size(8);
$header->set_text_wrap(2);
$header->set_align('center');
$header->set_color('black');
$header->set_border(1);
$header->set_bg_color('49');


$info =& $workbook->addformat();
$info->set_size(8);
$info->set_align('center');
$info->set_border(1);

$info2 =& $workbook->addformat();
$info2->set_align('left');
$info2->set_size(8);
$info2->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(8);
$total->set_align('center');
$total->set_border(1);


$merged_cells = &$workbook->addformat();
$merged_cells->set_bold();
$merged_cells->set_color('blue');
$merged_cells->set_fg_color('51');
$merged_cells->set_align('center');
$merged_cells->set_size(10);
$merged_cells->set_align('vcenter');
$merged_cells->set_border(1);
// indique qu'une cellule de ce format servira à la fusion
$merged_cells->set_merge();


$export_query = $_SESSION[$currentModule.'_listquery'];
//$export_query = $_REQUEST["sql"];

//echo "Dans Export : $export_query <br/>";
//print_r($EXPORT_RESULT);
//break;

$list_result = $adb->pquery($export_query, array());
$noofrows = $adb->num_rows($list_result);



$worksheet->write(1,0, utf8_decode($mod_strings['LBL_SUIVI_INCIDENTS_TECHNIQUES']),$merged_cells);
$worksheet->write_blank(1,1, $merged_cells);
$worksheet->write_blank(1,2, $merged_cells);
$worksheet->write_blank(1,3, $merged_cells);
$worksheet->write_blank(1,4, $merged_cells);
$worksheet->write_blank(1,5, $merged_cells);
$worksheet->write_blank(1,6, $merged_cells);
$worksheet->write_blank(1,7, $merged_cells);
$worksheet->write_blank(1,8, $merged_cells);
$worksheet->write_blank(1,9, $merged_cells);
$worksheet->write_blank(1,10, $merged_cells);
$worksheet->write_blank(1,11, $merged_cells);
$worksheet->write_blank(1,12, $merged_cells);


$worksheet->write(2,0, utf8_decode(decode_html($mod_strings['Date postage'])),$header);
$worksheet->write(2,1, utf8_decode(decode_html($mod_strings['Campagne'])),$header);
$worksheet->write(2,2, utf8_decode(decode_html($mod_strings['Nombre Incients Declares'])),$header);
$worksheet->write(2,3, utf8_decode(decode_html($mod_strings['Origine Interne'])),$header);
$worksheet->write(2,4, utf8_decode(decode_html($mod_strings['Origine Interne Pop Impactee'])),$header);
$worksheet->write(2,5, utf8_decode(decode_html($mod_strings['Origine Externe'])),$header);
$worksheet->write(2,6, utf8_decode(decode_html($mod_strings['Origine Externe Pop Impactee'])),$header);
$worksheet->write(2,7, utf8_decode(decode_html($mod_strings['Incidents Traites Dans Delais'])),$header);
$worksheet->write(2,8, utf8_decode(decode_html($mod_strings['Traites Dans Delais Pop Impactee'])),$header);
$worksheet->write(2,9, utf8_decode(decode_html($mod_strings['Incidents Traites Hors Delais'])),$header);
$worksheet->write(2,10, utf8_decode(decode_html($mod_strings['Traites Hors Delais Pop Impactee'])),$header);
$worksheet->write(2,11, utf8_decode(decode_html($mod_strings['Total Incidents Traites'])),$header);
$worksheet->write(2,12, utf8_decode(decode_html($mod_strings['Total Incidents Non Traites'])),$header);
	
	
	
$line=3;	

for ($i=1; $i<=$noofrows; $i++)
{
	$date_postage = $adb->query_result($list_result,$i-1,"date_postage");
	$campagne = $adb->query_result($list_result,$i-1,"campagne");
	$nb_incidents_all = $adb->query_result($list_result,$i-1,"nb_incidents_all");
	$origine_interne = $adb->query_result($list_result,$i-1,"origine_interne");
	$origine_interne_pop_impactee = $adb->query_result($list_result,$i-1,"origine_interne_pop_impactee");
	$origine_externe = $adb->query_result($list_result,$i-1,"origine_externe");
	$origine_externe_pop_impactee = $adb->query_result($list_result,$i-1,"origine_externe_pop_impactee");
	$nb_incident_traites_dans_delai = $adb->query_result($list_result,$i-1,"nb_incident_traites_dans_delai");
	$traites_dans_delai_pop_impactee = $adb->query_result($list_result,$i-1,"traites_dans_delai_pop_impactee");
	$nb_incident_traites_au_dela_delai = $adb->query_result($list_result,$i-1,"nb_incident_traites_au_dela_delai");
	$traites_au_dela_delai_pop_impactee = $adb->query_result($list_result,$i-1,"traites_au_dela_delai_pop_impactee");
	$nb_incident_traites = $adb->query_result($list_result,$i-1,"nb_incident_traites");
	$nb_incident_non_traites = $adb->query_result($list_result,$i-1,"nb_incident_non_traites");

	
	$worksheet->write($line,0, utf8_decode($date_postage),$info);
	$worksheet->write($line,1, utf8_decode($campagne),$info2);
	$worksheet->write($line,2, utf8_decode($nb_incidents_all),$info);
	$worksheet->write($line,3, utf8_decode($origine_interne),$info);
	$worksheet->write($line,4, utf8_decode($origine_interne_pop_impactee),$info);
	$worksheet->write($line,5, utf8_decode($origine_externe),$info);
	$worksheet->write($line,6, utf8_decode($origine_externe_pop_impactee),$info);
	$worksheet->write($line,7, utf8_decode($nb_incident_traites_dans_delai),$info);
	$worksheet->write($line,8, utf8_decode($traites_dans_delai_pop_impactee),$info);
	$worksheet->write($line,9, utf8_decode($nb_incident_traites_au_dela_delai),$info);
	$worksheet->write($line,10, utf8_decode($traites_au_dela_delai_pop_impactee),$info);
	$worksheet->write($line,11, utf8_decode($nb_incident_traites),$info);
	$worksheet->write($line,12, utf8_decode($nb_incident_non_traites),$info);
	
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
