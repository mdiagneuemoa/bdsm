<?php

require_once('graphUtils/Pie.class.php');															



class Diagramme2{
	
	function getGraph( $valuesStatut , $colors ){
		
		$graph = new Graph(400, 215);
		$graph->setAntiAliasing(TRUE);
		$graph->title->border->show();
		$graph->title->setBackgroundColor(new LightRed(60));
		$graph->title->setPadding(3, 3, 3, 3);
		
		$graph->shadow->setSize(1);
		$graph->shadow->smooth(TRUE);
		$graph->shadow->setPosition(Shadow::LEFT_BOTTOM);
		$graph->shadow->setColor(new DarkGray);
			 	  
		$plot = $this->createPie(array_values($valuesStatut),array_values($colors), " ", 0.3, 0.53);
		$plot->setLegend(array_keys($valuesStatut));
		$graph->add($plot);
		
		$graph->draw() ;
	}
	
	
	
	function createPie($values,$colors, $title, $x, $y) {
		
		$plot = new Pie($values, $colors);
		$plot->setSize(0.68, 0.68);
		$plot->set3D(5);
		$plot->setCenter(0.3, 0.53);
		$plot->setAbsSize(200, 200);
		$plot->setStartAngle(234);
		
		$plot->title->set($title);
		$plot->title->setFont(new TuffyBold(8));
		$plot->title->move(NULL, -12);
		
		$plot->label->setFont(new Tuffy(8));
		$plot->setLabelPosition(3);
		$plot->label->setPadding(2, 2, 2, 2);
		$plot->label->setBackgroundColor(new White(60));
		$plot->setLabelPrecision(1);
		
		$plot->legend->hide(FALSE);
		$plot->legend->shadow->setSize(0);
		$plot->legend->setBackgroundColor(new VeryLightGray(30));
		$plot->legend->setPosition(1.87, 0.78);
		
		return $plot;
	}
	
}
session_start();
$valuesStatut = $_SESSION['valuesStatut'];
$colorsList = array_keys($valuesStatut);
$colorsListFinal ;
for($i=0 ; $i < count($colorsList) ; $i++ ){
		
	if ( $colorsList[$i] == "A traiter" ){
		$colorsListFinal[$i]  =  new Blue ;
	}
	if ( $colorsList[$i] == "En cours de traitement" ){
		$colorsListFinal[$i]  = new LightBlue ;
	}
	if ( $colorsList[$i] == "En attente de clôture" ){
		$colorsListFinal[$i]  = new LightGreen ;
	}
	if ( $colorsList[$i] == "Clôturés" ){
		$colorsListFinal[$i]  = new Green ;
	}
}

$cl= new Diagramme2();
if ($valuesStatut != null && $colorsListFinal != null)
	$cl->getGraph( $valuesStatut , $colorsListFinal ) ;
session_unregister('valuesStatut');	
?>


