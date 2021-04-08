<?php
/*
 * Created on 22 nov. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once('graphUtils/Pie.class.php');	

    
$colorBase = array( "LightBlue", "LightGreen", "LightRed","MidGray", "VeryLightPink",
					"VeryLightOrange","LightOrange","LightMagenta","LightCyan","LightYellow",
					"MidYellow","Yellow","MidCyan","Cyan","LightPink","LightPurple","DarkGray",
					"MidRed","Red","VeryDarkGray","MidBlue","Blue","Green", "DarkBlue","DarkRed",
					"VeryDarkRed", "White", "VeryLightGray","MidMagenta","Magenta","LightGray",
					"DarkPurple","Purple", "VeryDarkMagenta","DarkMagenta", "DarkPink","Pink",
					"DarkOrange","Orange","AlmostBlack","DarkGreen","MidGreen","VeryDarkGreen",
					"VeryDarkCyan","DarkCyan","DarkYellow","VeryDarkBlue", "VeryDarkYellow");

$graph = new Graph(800, 400);
$graph->setAntiAliasing(TRUE);
$graph->title->setFont(new Tuffy(10));
$graph->title->setBackgroundColor(new Color(255, 255, 255, 25));
$graph->title->border->show();
$graph->title->setPadding(3, 3, 3, 3);
$graph->title->move(-20, 0);

$graph->title->set("Incidents souffrants par campagne");

session_start();

$data			= $_SESSION['data_campagne'];
$data_legende 	= $data[0][1];
$data_values 	= $data[2];
$expl = array();
for($i=0; $i< count($data_values); $i++){
	$colors[$i] = new $colorBase[$i]();
	$expl[] = 10;
}

$plot = new Pie($data_values, $colors);
$plot->setCenter(0.35, 0.4);
$plot->setSize(0.4, 0.5);
$plot->set3D(0);
$plot->setLabelPrecision(1);
//$expl[0] = 20;
$plot->explode($expl);

$plot->setLegend($data_legende);

$plot->legend->setTextFont(new Tuffy(7)) ;
$plot->legend->setSpace(10);
$plot->legend->setAlign(Legend::CENTER);
if($i >=4)
$plot->legend->setColumns(4);
else
$plot->legend->setColumns($i);
$plot->legend->setPosition(null, 1.12);
$plot->set3D(5);
$graph->add($plot);
$graph->draw();


?>
