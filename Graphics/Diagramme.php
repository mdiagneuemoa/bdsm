<?php
/*
 * Created on 22 nov. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once('graphUtils/Pie.class.php');	

$graph = new Graph(500, 300);
$graph->setAntiAliasing(TRUE);

$graph->title->set("Répartition globale des évaluations");

session_start();
//$values = $_SESSION['data_graf1'];
$values= array(1,8,2,7,10);

$plot = new Pie($values, Pie::AQUA);
$plot->setCenter(0.28, 0.37);
$plot->setSize(0.5, 0.4);
$plot->set3D(15);
//$plot->explode(array(4 => 10, 0 => 10));

//$plot->setLegend($_SESSION['data_graf0']);
$plot->setLegend(array(a,b,c,d,e));

$plot->legend->setPosition(1.93,1);
$plot->legend->setBackgroundColor(new VeryLightGray(30));

$graph->add($plot);
$graph->draw();

?>
