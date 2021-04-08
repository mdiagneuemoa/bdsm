<?php


require_once ("graphUtils/LinePlot.class.php");

$graph = new Graph(933, 350);

//$values = array(2, 6, 3, 2, 4);
session_start();
$x = $_SESSION['data_graf6'];
$y = $_SESSION['data_graf5'];



$plot = new LinePlot($x);

$plot->grid->setNoBackground();

$plot->title->set("Evolution de la note moyenne des CC (en %)");
$plot->title->setFont(new Tuffy(10));
$plot->title->setBackgroundColor(new Color(255, 255, 255, 25));
$plot->title->border->show();
$plot->title->setPadding(3, 3, 3, 3);
$plot->title->move(-20, 25);

$plot->setSpace(4, 4, 10, 0);
$plot->setPadding(30, 15, 10, 32);

$plot->setBackgroundGradient(
	new LinearGradient(
		new Color(153, 204, 255),
		new Color(255, 255, 255),
		0
	)
);

$plot->setColor(new Color(0, 0, 150, 20));

$plot->setFillGradient(
	new LinearGradient(
		new Color(31, 143, 255),
		new Color(245, 245, 245),
		0
	)
);

$plot->mark->setType(Mark::CIRCLE);
$plot->mark->border->show();

$plot->xAxis->setLabelText($y);
$plot->xAxis->title->set("Jours");
$plot->yAxis->title->set("Note moyenne");
$plot->xAxis->label->setFont(new Tuffy(7));

$graph->add($plot);
$graph->draw();
?>


