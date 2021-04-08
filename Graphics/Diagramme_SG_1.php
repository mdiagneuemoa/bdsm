<?php
/*
 * Created on 22 nov. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once('graphUtils/Pie.class.php');	

$graph = new Graph(933, 350);
$graph->setAntiAliasing(TRUE);

$graph->title->set("Répartition des évaluations par ADP");
$graph->title->setFont(new Tuffy(10));
$graph->title->setBackgroundColor(new Color(255, 255, 255, 25));
$graph->title->border->show();
$graph->title->setPadding(3, 3, 3, 3);
$graph->title->move(-20, 0);
session_start();
$values = $_SESSION['data_graf2'];
$y = $_SESSION['data_graf4'];

$plot = new Pie($values, Pie::AQUA);
$plot->setCenter(0.30, 0.5);
$plot->setSize(0.5, 0.8);
$plot->set3D(10);
$plot->setStartAngle(0);

//$plot->explode(array(4 => 10, 0 => 10));


$plot->setLegend($y);

$plot->legend->setPosition(1.7,0.5);
$plot->legend->setTextFont(new Tuffy(8));
$plot->legend->setBackgroundColor(new VeryLightGray(30));
$plot->explode(array(0 => 10));

$graph->add($plot);
$graph->draw();

?>
