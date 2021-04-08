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

require_once("include/php_writeexcel/class.writeexcel_workbook.inc.php");
require_once("include/php_writeexcel/class.writeexcel_worksheet.inc.php");

require_once("modules/SupervisionParCC/SupervisionParCC.php");

global $tmp_dir, $root_directory;

/*
if(isset($_POST["export"])  && $_POST["export"] ==true)
{
*/
$UserCodification = $_POST["codifvalues"];
$UserCodificationDet =$_POST["codifdetvalues"];
//$periode = "Du ",$_POST["date_start"]," ",$_POST["hour_start"],"  Au ",$_POST["date_end"]," ",$_POST["hour_end"];
$periode = "Du ".$_POST["date_start"]." ".$_POST["hour_start"]."  Au ".$_POST["date_end"]." ".$_POST["hour_end"];
$groupe = $_POST["groupe"];
$vue = $_POST["typevue"];
echo $periode,"  -   ",$groupe,"  -   ",$vue;

/*
	}
*/
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

$libelle =& $workbook->addformat();
$libelle->set_bold();
$libelle->set_size(10);
$libelle->set_align('right');


$info =& $workbook->addformat();
$info->set_size(10);
$info->set_align('center');
$info->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(10);
$total->set_align('center');
$total->set_border(1);

# Write out the data
$timesheetid = $_REQUEST["record"];

$focus = new Timesheets();
$listinterventions = $focus->getInterventions($timesheetid);
$timesheet = $focus->getInfoTimesheet($timesheetid);
$durationHours = $focus->getDurationHours($timesheetid);

$worksheet->write(1, 0, utf8_decode(decode_html($mod_strings['Timesheet Name'])),$libelle);
$worksheet->write(1, 1, $timesheet["timesheetname"]);
$worksheet->write(1, 2, utf8_decode(decode_html($mod_strings['Consultant Name'])),$libelle);
$worksheet->write(1, 3, $timesheet["nomconsultant"]);
$worksheet->write(2, 0, utf8_decode(decode_html($mod_strings['Period'])),$libelle);
$worksheet->write(2, 1, 'Du '.$timesheet["start_date"].'   Au '.$timesheet["due_date"]);
$worksheet->write(2, 2, utf8_decode(decode_html($mod_strings['Duration Hours'])),$libelle);
$worksheet->write(2, 3, $timesheet["duration_hours"]);

if(isset($listinterventions))
{
	 
	$worksheet->write(5, 0, utf8_decode(decode_html($mod_strings['LBL_INTERVENTION_DATE'])) , $header);
	$worksheet->write(5, 1, utf8_decode(decode_html($mod_strings['LBL_INTERVENTION_ACCOUNT'])) , $header);
	$worksheet->write(5, 2, utf8_decode(decode_html($mod_strings['LBL_INTERVENTION_PROJECT'])) , $header);
	$worksheet->write(5, 3, utf8_decode(decode_html($mod_strings['LBL_INTERVENTION_TASK'])) , $header);
	$worksheet->write(5, 4, utf8_decode(decode_html($mod_strings['LBL_INTERVENTION_DURATION'])) , $header);
	$i=6;	
	foreach($listinterventions as $key=>$interv)
	{
		$worksheet->write($i,0, utf8_decode($interv["date_interv"]),$info);
		$worksheet->write($i,1, utf8_decode($interv["accountname"]),$info);
		if($interv["projectname"]!="")
			$worksheet->write($i,2, utf8_decode($interv["projectname"]),$info);		
		else
			$worksheet->write($i,2, utf8_decode($interv["autreactivite"]),$info);		
		$worksheet->write($i,3, utf8_decode($interv["intervtask"]),$info);
		$worksheet->write($i,4, utf8_decode($interv["duration_interv"]),$info);
	
		$i++;
	}
	$worksheet->write($i, 3, utf8_decode(decode_html($mod_strings['Duration Hours'])),$total);
	$worksheet->write($i,4, utf8_decode($durationHours),$total);

}		

$workbook->close();

if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
{
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
header("Content-Type: application/x-msexcel");
header("Content-Length: ".@filesize($fname));
header("Content-disposition: attachment; filename="."test".".xls");
$fh=fopen($fname, "rb");
fpassthru($fh);
//unlink($fname);
?>
