<?php
/*
 * Created on 22 nov. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once('graphUtils/BarPlot.class.php');	

$graph = new Graph(933, 400);
$graph->setAntiAliasing(TRUE);

//$graph->title->set("Répartition globale des évaluations");
$graph->title->setFont(new Tuffy(10));
$graph->setAntiAliasing(TRUE);

session_start();
$x = $_SESSION['data_graf3'];
$y = $_SESSION['data_graf4'];

$plot = new BarPlot($x);

$plot->setSpace(4, 4, 10, 0);
$plot->setPadding(40, 15, 10, 180);

$plot->title->set("Répartition des évaluations par ADP");
$plot->title->setFont(new Tuffy(10));
$plot->title->setBackgroundColor(new Color(255, 255, 255, 25));
$plot->title->border->show();
$plot->title->setPadding(3, 3, 3, 3);
$plot->title->move(-20, 25);

$plot->yAxis->title->set("Nombre évaluations");
$plot->yAxis->title->setFont(new Tuffy(10));
$plot->yAxis->title->move(-4, 0);
$plot->yAxis->setTitleAlignment(Label::TOP);

/*
$plot->xAxis->title->set("Axe des X");
$plot->xAxis->title->setFont(new TuffyBold(10));
$plot->xAxis->setTitleAlignment(Label::RIGHT);
*/
$plot->setBackgroundGradient(
	new LinearGradient(
		new Color(153, 204, 255),
		new Color(255, 255, 255),
		0
	)
);

$plot->barBorder->setColor(new Color(0, 0, 150, 20));

$plot->setBarGradient(
	new LinearGradient(
		new Color(31, 143, 255),
		new Color(245, 245, 245),
		0
	)
);


$plot->xAxis->setLabelText($y);
$plot->xAxis->label->setFont(new TuffyBold(8));
$plot->xAxis->label->setAngle(70);

$graph->shadow->setSize(4);
$graph->shadow->setPosition(Shadow::LEFT_TOP);
$graph->shadow->smooth(TRUE);
$graph->shadow->setColor(new Color(160, 160, 160));

$graph->add($plot);
$graph->draw();
?>