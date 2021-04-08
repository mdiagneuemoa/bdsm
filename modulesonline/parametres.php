<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Mon Assistant en ligne</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/pages/parametres.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
         
        
        <header class="page-header">
             <div class="container">
                <table width="99%">
					<tbody>
							<tr>
					          <td nowrap>
									<img src="images/accueilpapcci.png" alt="SI PREMIUM ACCUEIL " title="SI PREMIUM ACCUEIL" border=0>
								</td>
							<td align="right">			
								Pauline POISONNIER <a href="index.php?module=Users&action=Logout"><img src="images/deconnexion.jpg" alt="deconnexion" title="deconnexion" border=0></a>
							</td>
							</tr>
				</table>
            </div>
        </header>
 <?php
 
require_once ("config/config_inc.php");
require_once (PATH_BEANS."/Abonne.php");
require_once (PATH_DAO_IMPL."/abonneDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$abonnedao = new AbonneDao();
$abonne = $abonnedao->selectAbonneById($numeroclient);
?> 	
	<nav class="page-nav">
            <div class="container">
                <a href="accueil.php" class="active">Accueil</a>
                <a href="messages.php">Message</a>
                <a href="contacts.php">Contacts</a>
                <a href="agenda.html">Agenda</a>
                <a href="parametres.php">Parametres</a>
                <!--a href="live.htm">Live</a>
                <a href="feedback.htm">Feedback</a-->
            </div>
        </nav>
		<table width=98%>
		<tr><td width=80% >
					<nav id="menu-onglet">
						<ul>
							
							<li>
								<a href="parametres.html">Param&egrave;tres<span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="messages.php">Boite de R&eacute;ception</a></li>
										<li><a href="parametres.php">Contacts</a></li>
										<li><a href="agenda.html">Agenda</a></li>

									</ul>
								</div>
							</li>
							<li><a href="#" id="moncomptelink">Mon Compte</span></a></li>
							<li><a href="#" id="monagendalink">Mon Agenda</span></a></li>
							<li><a href="#" id="mesconsigneslink">Mes Consignes</span></a></li>
							
						</ul>
					</nav>
				
	</td>
<td width=20% align=right><label class="assist"><img src="images/assistante.jpg" height="30">0173023298</label></td>
</tr></table>			
<hr>
                <div id="divContainer">
 
					 <div id="moncompte">
						<form id="moncompte">
						  <fieldset>
							<legend>Information Compte</legend>

							<ol>
							  <li>
								<label for=nom>Nom</label>
								<input id=nom name=nom type=text  value="<?php echo $abonne['prenom'],' ',$abonne['nom'];?>">
							  </li>
							  <li>
								<label for=email>Email</label>
								<input id=email name=email type=email value="<?php echo $abonne['email'];?>">
							  </li>
							  <li>
								<label for=telephone>T&eacute;l&eacute;phone</label>
								<input id=telephone name=telephone type=tel  value="<?php echo $abonne['mobile'];?>">
							  </li>
							  <li>
								<label for=numeroassistant>T&eacute;l&eacute;phone Assistante</label>
								<input id=numeroassistant name=numeroassistant type=tel  value="<?php echo $abonne['numerortc'];?>">
							  </li>
							</ol>
						  </fieldset>

						<fieldset>
							<button type=submit>Enregistrer</button>
						  </fieldset>
					</form>					
				</div>
				 <div id="mesconsignes" style="display:none">
						<form id="mesconsignes">
						
						
						  <fieldset>
							<legend >Personnaliser vos consignes</legend>

							<ol>
							  <li>
								<label for=consigneaccueil>Consigne d'accueil</label>
								<textarea id=consigneaccueil name=consigneaccueil readonly=readonly><?php echo $abonne['consignes'];?></textarea>
								<a href="#" id="editconsigneaccueil"><img src="images/edit.png" title="editer"></a>
							  </li>
							  <li>
								<label for=consignereponse>Consigne de r&eacute;ponse</label>
								<textarea id=consignereponse name=consignereponse readonly=readonly><?php echo $abonne['reponses'];?></textarea>
								<a href="#" id="editconsignereponse"><img src="images/edit.png" title="editer"></a>
							  </li>
							  <li>
								<label for=consigneautre>Autre Consigne</label>
								<textarea id=consigneautre name=consigneautre readonly=readonly><?php echo $abonne['autresconsignes'];?></textarea>
								<a href="#" id="editconsigneautre"><img src="images/edit.png" title="editer"></a>
							  </li>
							  <li>
								<label for=planacces>Plan d'acc&egrave;s</label>
								  <input type="file" id="planacces" name="planacces"  />
							  </li>
							  <li>
								<label for=doccommercial>Document Commercial</label>
								  <input type="file" id="doccommercial" name="doccommercial" />
							  </li>
							  <li>
								<label for=autredoc>Autre Document</label>
								  <input type="file" id="autresdoc" name="autresdoc[]" multiple="multiple"/>
							  </li>
							</ol>
						  </fieldset> 

						<fieldset>
							<button type=submit>Enregistrer</button>
						  </fieldset>
					</form>					
				</div>
					<div id="monagenda" style="display:none" >
						<form id="monagenda">
						  <fieldset>
							<legend>Personnaliser votre Agenda</legend>

							<ol>
							  <li>
								<label for=dureeminrv>Dur&eacute;e min Rendez-vous</label>
								<select name="dureerv">
									<option value="15" >15 minutes</option>
									<option value="30" >30 minutes</option>
									<option value="45" >45 minutes</option>
									<option value="60" >1 heure</option>
									<option value="90" >1 heure 30 minutes</option>
									<option value="120" >2 heures</option>
								</select>
							  </li>
							  <li>
  								<label for=pasrappel>Pas de Rappel</label>
								<input id=pasrappel name=pasrappel type=radio>
							  </li>
							  <li>
							  	<label for=rappel>Rappel</label>
								<input id=rappel name=rappel type=radio>
								<select name="dureerappel">
									<option value="5" >15</option>
									<option value="15" >15</option>
									<option value="30" >30</option>
									<option value="45" >45</option>
								</select>
								<select name="uniterappel">
									<option value="minutes" >minutes</option>
									<option value="heures" >heures</option>
									<option value="jours" >jours</option>
								</select>
							  </li>
							  <li>
								<label for=rappel>Copie par mail</label>
								<input type="checkbox" name="copiemail" value="checkbox">
							 </li>
							  <li>
							  <label for=rappel>R&eacute;capitulatif par mail des re</label>
								<input type="checkbox" name="recapmail" value="checkbox">
							 </li>
							</ol>
						  </fieldset>

						<fieldset>
							<button type=submit>Enregistrer</button>
						  </fieldset>
					</form>					
				</div>
				
</form>
            </div>

        <footer class="page-footer">
            <div class="container">
                <p>
                    &#169; 	2014 PCCI - BU SSII 
                </p>
            </div>
        </footer>
   		<script src="scripts/jquery.min.js" type="text/javascript"></script>
       <script src="scripts/pages/parametres.js" type="text/javascript"></script>
    </body>
</html>
