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
require_once('config.inc.php');
//require('cron/send_mail.php');
require_once('config.php');
require_once('include/utils/utils.php');
require_once('include/language/fr_fr.lang.php');
global $app_strings;

require_once("include/php_writeexcel/class.writeexcel_workbook.inc.php");
require_once("include/php_writeexcel/class.writeexcel_worksheet.inc.php");


global $tmp_dir, $root_directory;


//$fname_hebdo = "Rapport_hebdomadaire_".getDisplayDate(date('y-m-d')).".xls";
$fname_hebdo = "Reportgidpcci_w".(date('W')-1).date('Y').".xls";
$fname = $root_directory."report_hedomadaire\\".$fname_hebdo;


$workbook = &new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet("Par campagne");

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
$libelle->set_align('center');
$libelle->set_border(1);

$info =& $workbook->addformat();
$info->set_size(10);
$info->set_align('center');
$info->set_border(1);

$info1 =& $workbook->addformat();
$info1->set_size(10);
$info1->set_align('left');
$info1->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(10);
$total->set_align('center');
$total->set_border(1);

# Write out the data
$timesheetid = $_REQUEST["record"];



// tableau data par campagne
$query = "SELECT YEARWEEK(date_postage),
	campagne ,
	op_lib,
	SUM(nb_incidents_declares) as nb_incidents_declares,
	SUM(nb_Incidents_traites) as nb_incidents_traites,
	SUM(duree_t_traitement) as duree_t_traitement,
	SUM(nb_incidents_en_souffrance)as   nb_incidents_en_souffrance,
	SUM(nb_Incidents_dslesdelais) as  nb_incidents_dslesdelais,
	SUM(nb_incident_audela_dslesdelais) as nb_incident_audela_dslesdelais ,
	SUM(incidents_internes) as incidents_internes ,
	SUM(incidents_Externes) incidents_externes ,
	SUM(incidents_closed) as incidents_closed ,
	SUM(incidents_dclosed) as incidents_dclosed ,
	SUM(Incidents_nonsouffrants) as incidents_nonsouffrants
	FROM
	siprod_rapport_quotidien_campagne
	where YEARWEEK(date_postage,1) = '201102'
	group by YEARWEEK(date_postage),campagne";

$result = $adb->pquery($query, array());
// tableau data par type
$query_type = "SELECT YEARWEEK(date_postage),
	campagne ,
	typeincidents, 
	op_lib,
	SUM(nb_incidents_declares) as nb_incidents_declares,
	SUM(nb_Incidents_traites) as nb_incidents_traites,
	SUM(duree_t_traitement) as duree_t_traitement,
	SUM(nb_incidents_en_souffrance)as   nb_incidents_en_souffrance,
	SUM(nb_Incidents_dslesdelais) as  nb_incidents_dslesdelais,
	SUM(nb_incident_audela_dslesdelais) as nb_incident_audela_dslesdelais ,
	SUM(incidents_internes) as incidents_internes ,
	SUM(incidents_externes)as incidents_externes ,
	SUM(incidents_closed) as incidents_closed ,
	SUM(incidents_dclosed) as incidents_dclosed ,
	SUM(incidents_nonsouffrants) as incidents_nonsouffrants
	FROM
	siprod_rapport_quotidien_type
	where YEARWEEK(date_postage,1) = '201102'
	group by YEARWEEK(date_postage),typeincidents";

$result_type = $adb->pquery($query_type, array());
// tableau data par groupe
$query_groupe = "SELECT YEARWEEK(date_postage),
	campagne ,
	groupeincidents,
	op_lib,
	SUM(nb_incidents_declares) as nb_incidents_declares,
	SUM(nb_Incidents_traites) as nb_incidents_traites,
	SUM(duree_t_traitement) as duree_t_traitement,
	SUM(nb_incidents_en_souffrance)as   nb_incidents_en_souffrance,
	SUM(nb_incidents_dslesdelais) as  nb_incidents_dslesdelais,
	SUM(nb_incident_audela_dslesdelais) as nb_incident_audela_dslesdelai ,
	SUM(incidents_internes) as incidents_internes , 
	SUM(incidents_externes)as incidents_externes ,
	SUM(Incidents_closed) as incidents_closed ,
	SUM(Incidents_dclosed) as incidents_dclosed ,
	SUM(incidents_nonsouffrants) as incidents_nonsouffrants
	FROM
	siprod_rapport_quotidien_groupe
	where YEARWEEK(date_postage,1) = YEARWEEK(SUBDATE(now(), INTERVAL 24 HOUR),1)
	group by YEARWEEK(date_postage),groupeincidents";

$result_groupe = $adb->pquery($query_groupe, array());

$j = 0;
$result_groupe_c = null;
while ($myrow = $adb->fetch_array($result_groupe))
{
	$id_g = $myrow["groupeincidents"] ;
	$tab_g = split('\|##\|',$id_g);
	$g_name = "";
	$g_id ="";
	for($i=0; $i < count($tab_g); $i++ ){
		$query_groupename  = "select groupname from vtiger_groups where groupid = $tab_g[$i]";
		$result_groupename = $adb->pquery($query_groupename, array());
		$grouprow = $adb->fetch_array($result_groupename);
		$g_name = $g_name.'- '.$grouprow[0].' ';
		$g_id = $g_id.','.$tab_g[$i];
	}
	$myrow["groupeid"] = $g_id ;
	$myrow["groupeincidents"] = $g_name ;
	$result_groupe_c[$j] = $myrow ;
	$j++;
}


// Preparing data and mail body
setlocale (LC_ALL, 'fr_FR','fr');

$i=0;
$i++;
$i++;
$worksheet->write($i, 0,"Par campagne",$libelle);
$i++;

$worksheet->write($i, 0,html_entity_decode($app_strings["DAILY_NOTIFICATION_CAMPAGNE"]),$libelle);
$worksheet->write($i, 1,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]),$libelle);
$worksheet->write($i, 2,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ATTENTE"]),$libelle);
$worksheet->write($i, 3,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_CLOTURES"] ),$libelle);
$worksheet->write($i, 4,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]),$libelle);
$worksheet->write($i, 5,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]),$libelle);
$worksheet->write($i, 6,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURE_AVANT_TR"]),$libelle);	
$worksheet->write($i, 7,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_INTERNES"]) ,$libelle);
$worksheet->write($i, 8,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_EXTERNES"]) ,$libelle);
$worksheet->write($i, 9,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]),$libelle);


$isContainStatistic = false;
$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

while ($myrow = $adb->fetch_array($result)) 
{
	$i++;
	
	$worksheet->write($i, 0,html_entity_decode($myrow["op_lib"]),$info1);
	$worksheet->write($i, 1,$myrow["nb_incidents_declares"],$info);
	$worksheet->write($i, 2,$myrow["nb_incidents_traites"],$info);
	$worksheet->write($i, 3,$myrow["incidents_closed"],$info);
	$worksheet->write($i, 4,$myrow["nb_incidents_en_souffrance"],$info);
	$worksheet->write($i, 5,$myrow["incidents_nonsouffrants"],$info);
	$worksheet->write($i, 6,$myrow["incidents_dclosed"],$info);
	$worksheet->write($i, 7,$myrow["incidents_internes"],$info);
	$worksheet->write($i, 8,$myrow["incidents_externes"],$info);
	
	$duree = $myrow["duree_t_traitement"] ;
	$duree = sec_To_Time($duree);
	$worksheet->write($i, 9,$duree,$info);																				
	
	$total_nb_incidents_declares 		+= $myrow["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $myrow["nb_incidents_traites"];
	$total_incidents_closed 			+= $myrow["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $myrow["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $myrow["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $myrow["incidents_dclosed"];
	$total_incidents_internes 			+= $myrow["incidents_internes"];
	$total_incidents_externes 			+= $myrow["incidents_externes"] ; 
	$dureeTotal 						+= $myrow["duree_t_traitement"] ;
	
	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$i++;
	$worksheet->write($i++, 3,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]),$libelle);
	$i++;																				
}else{
	$i++; 
	$worksheet->write($i, 0, "Total ",$libelle);
	$worksheet->write($i, 1,$total_nb_incidents_declares,$libelle);
	$worksheet->write($i, 2,$total_nb_incidents_traites,$libelle);
	$worksheet->write($i, 3,$total_incidents_closed,$libelle);
	$worksheet->write($i, 4,$total_nb_incidents_en_souffrance,$libelle);
	$worksheet->write($i, 5,$total_incidents_nonsouffrants,$libelle);
	$worksheet->write($i, 6,$total_incidents_dclosed,$libelle);
	$worksheet->write($i, 7,$total_incidents_internes,$libelle);
	$worksheet->write($i, 8,$total_incidents_externes,$libelle);
	$worksheet->write($i, 9,sec_To_Time($dureeTotal),$libelle);
	
}

$worksheet1 =& $workbook->addworksheet('Par type incident');
# Set the column width for columns 1, 2, 3 and 4
$worksheet1->set_column(0, 5, 28);
$i=0;
$i++;
$i++;

// tableau data par type start

$worksheet1->write($i, 0,html_entity_decode($app_strings["DAILY_NOTIFICATION_CAMPAGNE"]),$libelle);
$worksheet1->write($i, 1,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]),$libelle);
$worksheet1->write($i, 2,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ATTENTE"]),$libelle);
$worksheet1->write($i, 3,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_CLOTURES"] ),$libelle);
$worksheet1->write($i, 4,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]),$libelle);
$worksheet1->write($i, 5,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]),$libelle);
$worksheet1->write($i, 6,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURE_AVANT_TR"]),$libelle);	
$worksheet1->write($i, 7,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_INTERNES"]) ,$libelle);
$worksheet1->write($i, 8,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_EXTERNES"]) ,$libelle);
$worksheet1->write($i, 9,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]),$libelle);

$isContainStatistic = false;

$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

while ($myrow = $adb->fetch_array($result_type)) 
{
	$i++;
	$worksheet1->write($i, 0,str_replace('&#039;','\'', html_entity_decode(utf8_decode($myrow["typeincidents"]))),$info1);
	$worksheet1->write($i, 1,$myrow["nb_incidents_declares"],$info);
	$worksheet1->write($i, 2,$myrow["nb_incidents_traites"],$info);
	$worksheet1->write($i, 3,$myrow["incidents_closed"],$info);
	$worksheet1->write($i, 4,$myrow["nb_incidents_en_souffrance"],$info);
	$worksheet1->write($i, 5,$myrow["incidents_nonsouffrants"],$info);
	$worksheet1->write($i, 6,$myrow["incidents_dclosed"],$info);
	$worksheet1->write($i, 7,$myrow["incidents_internes"],$info);
	$worksheet1->write($i, 8,$myrow["incidents_externes"],$info);
	
	$duree = $myrow["duree_t_traitement"] ;
	$duree = sec_To_Time($duree);
	$worksheet1->write($i, 9,$duree,$info);																				
	
	$total_nb_incidents_declares 		+= $myrow["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $myrow["nb_incidents_traites"];
	$total_incidents_closed 			+= $myrow["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $myrow["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $myrow["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $myrow["incidents_dclosed"];
	$total_incidents_internes 			+= $myrow["incidents_internes"];
	$total_incidents_externes 			+= $myrow["incidents_externes"] ; 
	$dureeTotal 						+= $myrow["duree_t_traitement"] ;
	
	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$i++;
	$worksheet1->write($i++, 3,utf8_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]),$libelle);
	$i++;																				
}else{
	$i++;
	$worksheet1->write($i, 0, "Total",$libelle);
	$worksheet1->write($i, 1,$total_nb_incidents_declares,$libelle);
	$worksheet1->write($i, 2,$total_nb_incidents_traites,$libelle);
	$worksheet1->write($i, 3,$total_incidents_closed,$libelle);
	$worksheet1->write($i, 4,$total_nb_incidents_en_souffrance,$libelle);
	$worksheet1->write($i, 5,$total_incidents_nonsouffrants,$libelle);
	$worksheet1->write($i, 6,$total_incidents_dclosed,$libelle);
	$worksheet1->write($i, 7,$total_incidents_internes,$libelle);
	$worksheet1->write($i, 8,$total_incidents_externes,$libelle);
	$worksheet1->write($i, 9,sec_To_Time($dureeTotal),$libelle);
	
}

// tableau data par type end
$i=0;
$i++;
$i++;  

//tableau data par groupe start
$worksheet2 =& $workbook->addworksheet("Par groupe de traitement");

$worksheet2->write($i, 0,html_entity_decode($app_strings["DAILY_NOTIFICATION_CAMPAGNE"]),$libelle);
$worksheet2->write($i, 1,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DECLARES"]),$libelle);
$worksheet2->write($i, 2,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ATTENTE"]),$libelle);
$worksheet2->write($i, 3,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_CLOTURES"] ),$libelle);
$worksheet2->write($i, 4,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_SOUFFRANCE"]),$libelle);
$worksheet2->write($i, 5,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_NON_TRAITES"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_NON_SOUFFRANT"]),$libelle);
$worksheet2->write($i, 6,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_CLOTURE_AVANT_TR"]),$libelle);	
$worksheet2->write($i, 7,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_INTERNES"]) ,$libelle);
$worksheet2->write($i, 8,html_entity_decode($app_strings["WEEKLY_NOTIFICATION_INCIDENTS_ORIGINE"]." ".$app_strings["WEEKLY_NOTIFICATION_INCIDENTS_EXTERNES"]) ,$libelle);
$worksheet2->write($i, 9,html_entity_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_DUREE_TRAITEMENT"]),$libelle);

$isContainStatistic = false;
$total_nb_incidents_declares 		= 0;
$total_nb_incidents_traites 		= 0;
$total_incidents_closed 			= 0;
$total_nb_incidents_en_souffrance 	= 0;
$total_incidents_nonsouffrants 		= 0;
$total_incidents_dclosed 			= 0;
$total_incidents_internes 			= 0;
$total_incidents_externes 			= 0; 
$dureeTotal							= 0;

for($j=0; $j < count($result_groupe_c); $j++ ){
	
	$i++;
	$worksheet2->write($i, 0,html_entity_decode(utf8_decode($result_groupe_c[$j]["groupeincidents"])),$info1);
	$worksheet2->write($i, 1,$result_groupe_c[$j]["nb_incidents_declares"],$info);
	$worksheet2->write($i, 2,$result_groupe_c[$j]["nb_incidents_traites"],$info);
	$worksheet2->write($i, 3,$result_groupe_c[$j]["incidents_closed"],$info);
	$worksheet2->write($i, 4,$result_groupe_c[$j]["nb_incidents_en_souffrance"],$info);
	$worksheet2->write($i, 5,$result_groupe_c[$j]["incidents_nonsouffrants"],$info);
	$worksheet2->write($i, 6,$result_groupe_c[$j]["incidents_dclosed"],$info);
	$worksheet2->write($i, 7,$result_groupe_c[$j]["incidents_internes"],$info);
	$worksheet2->write($i, 8,$result_groupe_c[$j]["incidents_externes"],$info);
	
	$duree = $result_groupe_c[$j]["duree_t_traitement"] ;
	$duree = sec_To_Time($duree);
	$worksheet2->write($i, 9,$duree,$info);																				
	
	$total_nb_incidents_declares 		+= $result_groupe_c[$j]["nb_incidents_declares"];
	$total_nb_incidents_traites 		+= $result_groupe_c[$j]["nb_incidents_traites"];
	$total_incidents_closed 			+= $result_groupe_c[$j]["incidents_closed"];
	$total_nb_incidents_en_souffrance 	+= $result_groupe_c[$j]["nb_incidents_en_souffrance"];
	$total_incidents_nonsouffrants 		+= $result_groupe_c[$j]["incidents_nonsouffrants"];
	$total_incidents_dclosed 			+= $result_groupe_c[$j]["incidents_dclosed"];
	$total_incidents_internes 			+= $result_groupe_c[$j]["incidents_internes"];
	$total_incidents_externes 			+= $result_groupe_c[$j]["incidents_externes"] ; 
	$dureeTotal 						+= $result_groupe_c[$j]["duree_t_traitement"] ;
	
	
	$isContainStatistic = true;
}

if ($isContainStatistic == false) {
	$i++;
	$worksheet2->write($i++, 3,utf8_decode($app_strings["DAILY_NOTIFICATION_INCIDENTS_STATISTIQUE_EMPTY"]),$libelle);
	$i++;																				
}else{
	$i++; 
	$worksheet2->write($i, 0, "Total ",$libelle);
	$worksheet2->write($i, 1,$total_nb_incidents_declares,$libelle);
	$worksheet2->write($i, 2,$total_nb_incidents_traites,$libelle);
	$worksheet2->write($i, 3,$total_incidents_closed,$libelle);
	$worksheet2->write($i, 4,$total_nb_incidents_en_souffrance,$libelle);
	$worksheet2->write($i, 5,$total_incidents_nonsouffrants,$libelle);
	$worksheet2->write($i, 6,$total_incidents_dclosed,$libelle);
	$worksheet2->write($i, 7,$total_incidents_internes,$libelle);
	$worksheet2->write($i, 8,$total_incidents_externes,$libelle);
	$worksheet2->write($i, 9,sec_To_Time($dureeTotal),$libelle);
	
}


//---------------------------------------------------------------------


$workbook->close();
//$name ="Rapport_hebdomadaire_".getDisplayDate(date('y-m-d h:i:s'))."xls";
//$workbook->save("C:/wamp/www/gidPCCI/".$name);


header("Pragma: no-cache");
//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/x-msexcel");
header("Content-Length: ".@filesize($fname));
header("Content-disposition: attachment; filename=".$file_name);

fwrite($fh);
fclose($fh);

function debutsem1($year,$month,$day) {
 $num_day      = date('w', mktime(0,0,0,$month,$day,$year));
 $premier_jour = mktime(0,0,0, $month,$day-(!$num_day?7:$num_day)+1,$year);
 $datedeb      = date('d-m-Y', $premier_jour);
    return $datedeb;
}

function finsem1($year,$month,$day) {
 $num_day      = date('w', mktime(0,0,0,$month,$day,$year));
 $dernier_jour = mktime(0,0,0, $month,7-(!$num_day?7:$num_day)+$day,$year);
 $datedeb      = date('d-m-Y', $dernier_jour);
    return $datedeb;
}


?>