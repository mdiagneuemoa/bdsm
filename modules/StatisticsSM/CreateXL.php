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
global $mod_strings, $app_strings, $currentModule, $current_user, $theme, $singlepane_view,$CODEPAYSUEMOA;

global $adb;

require_once("include/php_writeexcel/class.writeexcel_workbook.inc.php");
require_once("include/php_writeexcel/class.writeexcel_worksheet.inc.php");
require_once('include/DatabaseUtil.php');

require_once('include/utils/utils.php');
require_once('modules/StatisticsSM/StatisticsSM.php');

	session_start();

	$focus = new StatisticsSM();
	$paramstats = explode('||',$_REQUEST['param']);	

	$frequence = $paramstats[0];
	$pays = $paramstats[2];
	$sficheid = $paramstats[1];
	$moisdeb = $paramstats[3]; $anneedeb = $paramstats[4];
	$moisfin = $paramstats[5]; $anneefin = $paramstats[6];
	$mode = $paramstats[7];
	
	if ($frequence=='A')
	{
		$serie = 'ANNUELLE';
		if ($sficheid=='SFCO71-01')
			$statistics = $focus->getDonneesIndicateursCoherence1($sficheid,$pays,$anneedeb,$anneefin);
		else	
			$statistics = $focus->getDonneesIndicateursAnnuels($sficheid,$pays,$anneedeb,$anneefin);
	}
	elseif ($frequence=='M')
	{
		$serie = 'MENSUELLE';
		//$sficheid='SFPR22-01';
		//echo $sficheid,' - ',$frequence,' - ',$pays,' - ',$moisdeb,' - ',$moisfin,' - ',$anneedeb,' - ',$anneefin; 
		$statistics = $focus->getDonneesIndicateursMensuels($sficheid,$pays,$moisdeb,$moisfin,$anneedeb,$anneefin);
		
	}
	elseif ($frequence=='T')
	{
		$serie = 'TRIMESTRIELLE';
		$statistics = $focus->getDonneesIndicateursTrimestriels($sficheid,$pays,$anneedeb,$anneefin);
		//$showstatistics = $focus->showStatistics($statistics);
	}
$focus->downloadDonneesAnnuelles($statistics,$paramstats);
		
/*	

global $tmp_dir, $root_directory;

$fname = tempnam($root_directory.$tmp_dir, "merge2.xls");
$workbook = &new writeexcel_workbook($fname);
$worksheet =& $workbook->addworksheet();


# Set the column width for columns 1, 2, 3 and 4
$worksheet->set_column(0, 0,20);
$worksheet->set_column(1, 1,50);
# Create a format for the column headings
$header =& $workbook->addformat();
$header->set_bold();
$header->set_size(10);
$header->set_align('left');
$header->set_color('blue');
$header->set_border(0);

$libelle =& $workbook->addformat();
$libelle->set_bold();
$libelle->set_size(10);
$libelle->set_align('left');
$libelle->set_border(1);

$intitule =& $workbook->addformat();
$intitule->set_bold();
$intitule->set_size(10);
$intitule->set_align('left');
$intitule->set_border(1);

$libelle2 =& $workbook->addformat();
$libelle2->set_bold();
$libelle2->set_size(10);
$libelle2->set_align('center');
$libelle2->set_border(1);

$info =& $workbook->addformat();
$info->set_size(10);
$info->set_align('left');
$info->set_border(1);

$total =& $workbook->addformat();
$total->set_bold();
$total->set_size(10);
$total->set_align('center');
$total->set_border(1);

$info2 =& $workbook->addformat();
$info2->set_size(10);
$info2->set_align('left');
$info2->set_border(0);

$info3 =& $workbook->addformat();
$info3->set_size(10);
$info3->set_align('center');
$info3->set_border(1);

$infoh =& $workbook->addformat();
$infoh->set_size(10);
$infoh->set_align('left');
$infoh->set_border(0);
$infoh->set_bold();

$merged_cells = &$workbook->addformat();
$merged_cells->set_bold();
$merged_cells->set_color('blue');
//$merged_cells->set_fg_color('51');
$merged_cells->set_align('center');
$merged_cells->set_size('2');
$merged_cells->set_align('vcenter');
$merged_cells->set_border(1);
// indique qu'une cellule de ce format servira à la fusion
$merged_cells->set_merge();

$merged_cells2 = &$workbook->addformat();
$merged_cells2->set_bold();
$merged_cells2->set_color('white');
$merged_cells2->set_fg_color('green');
$merged_cells2->set_align('center');
$merged_cells2->set_size('14');
$merged_cells2->set_align('vcenter');
$merged_cells2->set_border(0);
// indique qu'une cellule de ce format servira à la fusion
$merged_cells2->set_merge();

$merged_cells3 = &$workbook->addformat();
$merged_cells3->set_bold();
$merged_cells3->set_color('blue');
$merged_cells3->set_fg_color('green');
$merged_cells3->set_align('center');
$merged_cells3->set_size('14');
$merged_cells3->set_align('vcenter');
$merged_cells3->set_border(0);
// indique qu'une cellule de ce format servira à la fusion
$merged_cells3->set_merge();

$intitule =& $workbook->addformat();
$intitule->set_bold();
$intitule->set_size(10);
$intitule->set_align('left');
$intitule->set_border(1);

$worksheet->write(1,0,'Union Economique et Monétaire Ouest Africaine',$merged_cells2);
$worksheet->write_blank(1,1, $merged_cells2);
$worksheet->write_blank(1,2, $merged_cells2);
$worksheet->write_blank(1,3, $merged_cells2);
$worksheet->write_blank(1,4, $merged_cells2);
$worksheet->write_blank(1,5, $merged_cells2);

$worksheet->write(2,0, 'Statistiques Surveillance Multimatérale',$merged_cells3);
$worksheet->write_blank(2,1, $merged_cells3);
$worksheet->write_blank(2,2, $merged_cells3);
$worksheet->write_blank(2,3, $merged_cells3);
$worksheet->write_blank(2,4, $merged_cells3);
$worksheet->write_blank(2,5, $merged_cells3);

$worksheet->write(4,0, 'Etat Membre',$infoh);
$worksheet->write(4,1,$CODEPAYSUEMOA[$pays],$header);

$worksheet->write(5,0,'Fiche',$infoh);
$worksheet->write(5,1,$statistics['fiche']['flibelle'].' : '.$statistics['fiche']['fslibelle'],$header);

$worksheet->write(6,0,'Série',$infoh);
$worksheet->write(6,1,$serie,$header);

if ($statistics['fiche']['unite']!='')
{
	$worksheet->write(7,0,'Devise/Unité',$infoh);
	$worksheet->write(7,1,$statistics['fiche']['unite'],$header);
}

$worksheet->write_blank(10,0, $header);

$worksheet->write(10,0,'CODE',$libelle);
$worksheet->write(10,1,'INTITULE',$libelle);
$focus->downloadDonneesAnnuelles($statistics,$paramstats,$worksheet,$workbook);

$ln=11;$ln2=11;
$cl=2;$cl2=2;

if ($mode=='DOWNLOADDATAS')
{
	$filename = str_replace(" ","_",$statistics['fiche']['flibelle']).'_'.$serie.'-'.$pays.'_'.$anneedeb.'-'.$anneefin;
	$AnneArrayObject = new ArrayObject($statistics['annee']);
	$AnneArrayObject->asort();
	foreach ($AnneArrayObject as $annee => $data)
	{
		$worksheet->write(10,$cl++,$data['annee'],$libelle2);
	}
	
}
else
{
	$filename = 'TEMPLATE_'.str_replace(" ","_",$statistics['fiche']['flibelle']).'_'.$serie.'-'.$pays.'_'.$anneedeb.'-'.$anneefin;
	$j=intval($anneedeb);
	$k=$j+(intval($anneefin)-intval($anneedeb))+1;
	for($i=$j; $i<$k; $i++)
	{
		$INDICATEURSAN[$i]=$i;
	}
	$AnneArrayObject = new ArrayObject($INDICATEURSAN);
	$AnneArrayObject->asort();
	foreach ($AnneArrayObject as $annee => $data)
	{
		$worksheet->write(10,$cl++,$data,$libelle2);
	}
}

$infocodeflux =& $workbook->addformat();
$infocodeflux->set_align('left');
$infocodeflux->set_border(1);

foreach($statistics['datas'] as $codeflux => $data)
{
	$dataflux=$decal.htmlspecialchars(html_entity_decode($data['intitule']));
	$worksheet->write($ln,0,$codeflux,$infocodeflux);
	$worksheet->write($ln,1,$dataflux,$infocodeflux);
	$cp=2;
	if ($mode=='DOWNLOADDATAS')
	{
		foreach ($AnneArrayObject as $annee => $data2)
		{
			if ($data['data'][$annee]!='' && $data['data'][$annee]!=0)
					$worksheet->write($ln,$cp,$data['data'][$annee],$info3);
			else
					$worksheet->write($ln,$cp,'-',$info3);

			$cp++;
		}
	}	
	$ln++;
}


$workbook->close();

if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
{
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
header("Content-Type: application/x-msexcel");
header("Content-Length: ".@filesize($fname));
//header("Content-disposition: attachment; filename=".$timesheet['timesheetname'.".xls");
header("Content-disposition: attachment; filename=$filename.xls");
$fh=fopen($fname, "rb");
fpassthru($fh);
//unlink($fname);
*/
?>
