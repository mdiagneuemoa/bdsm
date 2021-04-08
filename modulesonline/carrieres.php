<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Carrière 2AS</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/pages/carrieres.css" rel="stylesheet" type="text/css" />
        <link href="styles/modal.css" rel="stylesheet" type="text/css" />

        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>

     
 <?php
 
require_once ("config/config_inc.php");
/*
require_once (PATH_BEANS."/Contact.php");
require_once (PATH_DAO_IMPL."/contactDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$contactdao = new ContactDao();
$contacts = $contactdao->selectContactByAbonne($numeroclient);
$categories = $contactdao->selectCategorieByAbonne($numeroclient);
*/
//print_r($messages);
?> 		
<center>
       <div id="divContainer">
 
					<div id="form-addcontact">
						<form id="candidatform" action="candidature.php" method=post>
						<fieldset>
						<legend>LES OFFRES DE STAGE</legend>

							 <div>
							 
								<a href='#' id='moreconts2'>STAGE Développeur - Recherche et Développement H/F</a>
								<div >
								<table>
								<tr><td>
STAGE Développeur - Recherche et Développement H/F
<tr><td>
Ref : 193923
<tr><td>
Sacré cœur 3
<tr><td>
Pirotechnique N° 32
<tr><td>
DAKAR – SENEGAL
<tr><td>
Stage - Informatique - Développement
<tr><td>
Début : Entre Octobre et Novembre 2014 
<tr><td>
Durée : 3 mois 
<tr><td>
Région : Dakar
<tr><td>
2AS  est une société technologique dédiée à la conception de solutions informatiques et télécom à valeur ajoutée. 
Reconnue Jeune Entreprise Innovante, 2AS consacre aujourd’hui 30% de son chiffre d’affaires à la R&D.
La société, basée à DAKR, est structurée sur un socle technologique fort, une parfaite maîtrise des nouvelles technologies permettant de concevoir des solutions à valeur ajoutée pour les PME et PMI. L’innovation est au cœur de ses préoccupations. 2AS commercialise ses propres logiciels en mode SaaS.
STAGE Développeur - Recherche et Développement H/F
<tr><td>
Mission
<tr><td>
Concenvoir la nouvelle génération des logiciels exploités par l'entreprise.
<tr><td>
Exemples de projets réalisés
<tr><td>
<ul>
<li>        Refonte du système d'intégration des données
<li>         Moteur de dérive relationnelle
</ul>
<tr><td>
Profil :
<tr><td>
Idéalement de formation BAC+5 (ingénieur ou universitaire), doté (au moins) d'une petite expérience pratique en programmation web/système.
<tr><td>
Compétences recherchées
<tr><td>
Indispensables :
<tr><td>
<ul>
<li>         Algorythmes complexes
<li>         Architecture système
<li>       Traitements parallélisés
<li>        Système à haute concurence
<li>        Base de données
<li>        UNIX
<tr><td>Appréciées :
<tr><td>
<ul>
<li>         Golang
<li>          Bash
<li>         API SOAP/REST
<li>         Formats d'échanges de données (JSON/XML)
<li>         Optimisation MySQL
<li>         Architecture des SI
<li>        MySQL
</ul>
<tr><td>Nous recherchons un candidat :
<tr><td>
<ul>
<li>        Rigoureux
<li>         Consciencieux
<li>        Réactif
<li>         Qui aime apprendre
</ul>
<tr><td>Modalités : 
<tr><td>
<ul>
<li>         Durée : 6 mois, début au plus tôt
<li>        Rémunération : 900€ - bruts/mois minimum
<li>         Remboursement de 50% des titres de transport
</ul>
</td></tr>
<tr><td>							<button type=submit id="savecategorie">Postuler</button>
</td></tr>
</table>
								</div>
							
							  </div>
							  <div>
								  <a href='#' id='moreconts2'>Stage développement d'une application Android</a>
								  <div style="display:none">
								  <textarea id=adresse name=adresse rows=8 ></textarea>
								  </div>
								</div>
								
							   <div>
								 <a href='#' id='moreconts2'>Stage mise en place d'une ALM sous Linux</a>
								 <div style="display:none">
								  <textarea id=adresse name=adresse rows=8 ></textarea>
								  </div>
								</div>
								 </fieldset>
											</div>

      
  		<script src="scripts/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/pages/carrieres.js" type="text/javascript"></script>

    </body>
</html>
