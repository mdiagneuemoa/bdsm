<?php

require_once('graphUtils/Pie.class.php');															



class Diagramme{
	
	function getGraph( $valuesOrigine ){
		
		$graph = new Graph(400, 175);
		$graph->setAntiAliasing(TRUE);
		$graph->title->border->show();
		$graph->title->setBackgroundColor(new LightRed(60));
		$graph->title->setPadding(3, 3, 3, 3);
		
		$graph->shadow->setSize(1);
		$graph->shadow->smooth(TRUE);
		$graph->shadow->setPosition(Shadow::LEFT_BOTTOM);
		$graph->shadow->setColor(new DarkGray);
		
		$colors = array(
			new LightOrange, 
			new LightBlue
		);
		$plot = $this->createPie($valuesOrigine,$colors, "Origine", 0.68, 0.25);
		$plot->setLegend(array('Externe', 'Interne'));
		$graph->add($plot);
		
		$graph->draw() ;
	}
	
	
	
	function createPie($values,$colors, $title, $x, $y) {
		
		$plot = new Pie($values, $colors);
		$plot->setSize(0.70, 0.60);
		$plot->setCenter(0.40, 0.55);
		$plot->set3D(5);
		
		$plot->setCenter(0.3, 0.53);
		$plot->setAbsSize(200, 200);
		$plot->setBorderColor(new White);
		//$plot->setStartAngle(234);
		
		$plot->title->set($title);
		$plot->title->setFont(new TuffyBold(8));
		$plot->title->move(NULL, -12);
		
		$plot->label->setFont(new Tuffy(7));
		$plot->legend->hide(FALSE);
		
		$plot->setLabelPosition(5);
		$plot->label->setPadding(2, 2, 2, 2);
		$plot->label->setFont(new Tuffy(7));
		$plot->label->setBackgroundColor(new White(60));
		
		$plot->legend->setPosition(1.50);
		
		return $plot;
	}
	
}
session_start();
$valuesOrigine = $_SESSION['valuesOrigine'] ;
$cl= new Diagramme();
if( $valuesOrigine != null )
	$cl->getGraph($valuesOrigine) ;
?>


