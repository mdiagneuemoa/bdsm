<?php

require_once('graphUtils/Pie.class.php');															



class Diagramme{
	
	function getGraph( $valuesTraitement,$colors ){
				
		$graph = new Graph(400, 215);
		$graph->setAntiAliasing(TRUE);
		$graph->title->border->show();
		$graph->title->setBackgroundColor(new LightRed(60));
		$graph->title->setPadding(3, 3, 3, 3);
		
		$graph->shadow->setSize(1);
		$graph->shadow->smooth(TRUE);
		$graph->shadow->setPosition(Shadow::LEFT_BOTTOM);
		$graph->shadow->setColor(new DarkGray);
		
		$plot = $this->createPie(array_values($valuesTraitement), array_values($colors), "", 0.3, 0.53);
		$plot->setLegend(array_keys($valuesTraitement));
		
		$graph->add($plot);
		$graph->draw() ;
	}
	
	
	
	function createPie($values,$colors, $title, $x, $y) {
		
		$plot = new Pie($values, $colors);
		$plot->setSize(0.68, 0.68);
		$plot->set3D(5);
		$plot->setCenter($x, $y);
		$plot->setAbsSize(200, 200);
		$plot->setStartAngle(234);
		
		$plot->title->set($title);
		$plot->title->setFont(new TuffyBold(8));
		$plot->title->move(NULL, -12);
		
		$plot->label->setFont(new Tuffy(8));
		$plot->setLabelPosition(5);
		$plot->label->setPadding(2, 2, 2, 2);
		$plot->label->setBackgroundColor(new White(60));
		$plot->setLabelPrecision(1);
		
		$plot->legend->hide(FALSE);
		$plot->legend->shadow->setSize(2);
		$plot->legend->setBackgroundColor(new VeryLightGray(30));
		$plot->legend->setPosition(1.85, 0.7);
		
		return $plot;
	}
	
}

session_start();
$valuesTraitement = $_SESSION['valuesTraitementDemande'] ;

$colorsList = array_keys($valuesTraitement);
$colorsListFinal = null ;
$listFinal = null ;
for($i=0 ; $i < count($colorsList) ; $i++ ){

	if ( $colorsList[$i] == "Non souffrant" && $valuesTraitement["Non souffrant"]>0 ){
		$listFinal["Non souffrant"]  =  $valuesTraitement["Non souffrant"] ;
		$colorsListFinal[$i]  =  new Blue ;
	}	
	elseif ( $colorsList[$i] == "Souffrance" && $valuesTraitement["Souffrance"]>0){
		$listFinal["Souffrance"]  =  $valuesTraitement["Souffrance"] ;
		$colorsListFinal[$i]  = new Red ;
	}	
	elseif ( $colorsList[$i] == "Traitées dans les delais" && $valuesTraitement["Traitées dans les delais"]>0 ){
		$listFinal["Traitées dans les delais"]  =  $valuesTraitement["Traitées dans les delais"] ;
		$colorsListFinal[$i]  = new Orange ;
	}
	elseif ( $colorsList[$i] == "Traitées hors delais" && $valuesTraitement["Traitées hors delais"] >0){
		$listFinal["Traitées hors delais"]  =  $valuesTraitement["Traitées hors delais"] ;
		$colorsListFinal[$i]  = new Purple ;
	}
}

if ($listFinal != null && $colorsListFinal != null)
{
	$cl= new Diagramme();
	$cl->getGraph($listFinal,$colorsListFinal) ;
}
session_unregister('valuesTraitementDemande');	
?>


