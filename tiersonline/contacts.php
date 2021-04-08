<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Mon Assistant en ligne</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/pages/contacts.css" rel="stylesheet" type="text/css" />
        <link href="styles/modal.css" rel="stylesheet" type="text/css" />

        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
        
        
        <header class="page-header">
             <div class="container">
               	<table width="99%">
					<tbody>
							<tr>
					          <td width="10%" nowrap>
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
require_once (PATH_BEANS."/Contact.php");
require_once (PATH_DAO_IMPL."/contactDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$contactdao = new ContactDao();
$contacts = $contactdao->selectContactByAbonne($numeroclient);
$categories = $contactdao->selectCategorieByAbonne($numeroclient);

//print_r($messages);
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
								<a href="contacts.php">Contacts<span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="messages.php">Boite de R&eacute;ception</a></li>
										<li><a href="agenda.html">Agenda</a></li>
										<li><a href="parametres.php">Param&egrave;tres</a></li>

									</ul>
								</div>
							</li>
							<li>
								<a href="#"><img src="images/addcontact.jpg"><span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="#" id="addcontlink">Nouveau Contact</a></li>
										
									</ul>
								</div>
							</li>
							<li>
								<a href="products.html"><img src="images/checkbox.gif"><span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="#" id="checkAll">Tous</a></li>
										<li><a href="#" id="UncheckAll">Aucun</a></li>
									</ul>
								</div>
							</li>
							<li><a href="about.html">plus<span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="#" class="dellink">supprimer les contacts</a></li>
										<li><a href="#" class="importlink">importer...</a></li>
										<li><a href="#" class="exportlink">exporter...</a></li>
										<li><a href="#join_form" id="join_pop">Nouvelle Cat&eacute;gorie</a></li>
									</ul>
								</div>
							</li>


						</ul>
					</nav>
</td>
<td width=20% align=right><label class="assist"><img src="images/assistante.jpg" height="30">0173023298</label></td>
</tr></table>
				
<hr>
                <div id="divContainer">
 
 
        <!-- HTML5 TABLE FORMATTED VIA CSS3-->
			<table width="98%"  >
				<tr>
					<td valign=top width="180">
						<nav id="menu-side">
						<p><input type="button" id="addcontactbut" class="addcontact"  value="Nouveau Contact" /></p>
						<p class="titre"><a href='#' id="mescontacts">Mes Contacts ( <?php echo count($contacts);?> )</a></p>
							<ul>
								<?php
									foreach ($categories as $cat) 
									{
										echo '<li><a href="#" onclick="showContacts(\''.$cat['id'].'\');">'.$cat['libelle'].'('.$cat['nb'].')</a></li>';
									}
								?>	
								
							</ul>
						<p class="titre"><a href="#join_form" id="join_pop">Nouvelle Cat&eacute;gorie</a><p>
						<p class="titre"><a href='#' id="importcontlink">Importer des contacts</a><p>
						<!--p class="titre">Exporter des contacts<p-->
						</nav>
					</td>	
					<td valign=top>	
					<form id="listcontacts">
						<div id="contacts"><progress id="prog" max=100></div>
					</form>
					<div id="form-addcontact" style="display:none">
						<form id="contactform">
						  <fieldset>
							<legend>Ajout d'un nouveau contact</legend>

							<ol>
							  <li>
								<label for=nom>Pr&eacute;nom Nom</label>
								<input id=nom name=nom type=text placeholder="Prenom et nom" required autofocus>
							  </li>
							   <li>
								<label for=nom>Soci&eacute;t&eacute;</label>
								<input id=nom name=nom type=text placeholder="Nom entreprise">
							  </li>
							   <li>
								<label for=nom>Cat&eacute;gorie</label>
								<select name="categoriecont" id="categoriecont">
								<?php
									foreach ($categories as $cat) 
									{
										echo '<option value="'.$cat['id'].'">'.$cat['libelle'].'</option></li>';
									}
								?>	
								</select><a href="#join_form" id="join_pop" title='Ajouter une cat&eacute;gorie'><img src="images/add.gif"></a>
							  </li>
							   <div id=addemailperso style='display:none;'>
							   <li>
								<label for=emailperso>Email Personnel</label>
								<input id=emailperso name=emailperso type=email placeholder="exemple@domaine.com">
								<a href="#" id="delemailperso"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>							 
							  </div>
							  <div id=addemailpro style='display:none;'>
							   <li>
								<label for=emailpro>Email Professionel</label>
								<input id=emailpro name=emailpro type=email placeholder="exemple@domaine.com">
								<a href="#" id="delemailpro"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>
							  </div>
							    <div id=addemailtype>
							  <li>
								<label for=email><select name="typeemail" id="typeemail">
									<option value="personnel" >Email Personnel</option>
									<option value="professionel" >Email Professionel</option>
								</select></label>
								<input id=emailtype name=emailtype type=email placeholder="exemple@domaine.com">
							  </li>
							  </div>
							   <div id=idemaillink style='display:none;'>
									<a href="#" id="addemaillink"><img src="images/addemail.gif" title="Ajouter un autre email"></a>
							  </div>
							   <div id=addtelephonedom style='display:none;'>
							   <li>
								<label for=telephonedom>T&eacute;l&eacute;phone Domicile</label>
								<input id=telephonedom name=telephonedom type=tel placeholder="par ex&nbsp;: +33(0)6102564" required>
								<a href="#" id="deltelephonedom"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>
							  </div>
							   <div id=addtelephonebureau style='display:none;'>
							   <li>
								<label for=telephonebureau>T&eacute;l&eacute;phone bureau</label>
								<input id=telephonebureau name=telephonebureau type=tel placeholder="par ex&nbsp;: +33(0)6102564">
								<a href="#" id="deltelephonebureau"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>
							  </div>
							   <div id=addtelephoneperso style='display:none;'>
							   <li>
								<label for=telephoneperso>T&eacute;l&eacute;phone mobile personnel</label>
								<input id=telephoneperso name=telephoneperso type=tel placeholder="par ex&nbsp;: +33(0)6102564">
								<a href="#" id="deltelephoneperso"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>
							  </div>
							   <div id=addtelephonepro style='display:none;'>
							   <li>
								<label for=telephonepro>T&eacute;l&eacute;phone mobile profesionnel</label>
								<input id=telephonepro name=telephonepro type=tel placeholder="par ex&nbsp;: +33(0)6102564">
								<a href="#" id="deltelephonepro"><img src="images/delete.gif" title="Supprimer"></a>
							  </li>
							  </div>
							   <div id=addtelephonetype>
							  <li>
								<label for=telephonetype>
								<select name="typetel" id="typetel">
									<option value="domicile" >T&eacute;l&eacute;phone Domicile</option>
									<option value="bureau" >T&eacute;l&eacute;phone bureau</option>
									<option value="mobileperso" >T&eacute;l&eacute;phone mobile personnel</option>
									<option value="mobilepro" >T&eacute;l&eacute;phone mobile profesionnel</option>

								</select></label>
								<input id=telephonetype name=telephonetype type=tel placeholder="par ex&nbsp;: +33(0)6102564">
							  </li>
							  </div>
							   <div id=idtellink style='display:none;'>
									<a href="#" id="addtellink"><img src="images/Calls.gif" title="Ajouter un autre t&eacute;l&eacute;phone"></a>
							  </div>
								<li>
								  <label for=adressebur>Adresse Bureau</label>
								  <textarea id=adressebur name=adressebur rows=3 ></textarea>
								</li>
								<li>
								  <label for=boitepostalbur>Boite Postale Bureau</label>
								  <input id=boitepostalbur name=boitepostalbur type=text >
								</li>
						  </ol>
							</fieldset>
						  						  
						  <div align=right><a href='#' id='moreconts'><img src="images/down.gif"> Ajouter plus de champs</a></div>
						   <div align=right><a href='#' id='moreconts2' style="display:none"><img src="images/up.gif"> Ajouter plus de champs</a></div>

						  <div id="more-infoscontact" style="display:none">
						  
						   <fieldset>
							<legend>Informations compl&eacute;mentaires</legend>

							<ol>
							  <li>
								<label for=fonction>Fonction</label>
								<input id=fonction name=fonction type=text>
							  </li>
							   <li>
								<label for=datenais>Date Naissance</label>
								<input id=datenais name=datenais type=date>
							  </li>
								<li>
								  <label for=adressedom>Adresse Domicile</label>
								  <textarea id=adressedom name=adressedom rows=3 ></textarea>
								</li>
								<li>
								  <label for=boitepostaldom>Boite Postale Domicile</label>
								  <input id=boitepostaldom name=boitepostaldom type=text >
								</li>
								  <li>
								  <label for=pays>Pays</label>
								  <input id=pays name=pays type=text>
								</li>							 
								<li>
								<label for=departement>D&eacute;partement</label>
								<input id=departement name=departement type=text>
							  </li>
							  <li>
								<label for=assistant>Assistant</label>
								<input id=assistant name=assistant type=text>
							  </li>
							  <li>
								<label for=surnom>Surnom</label>
								<input id=surnom name=surnom type=text>
							  </li>
								<li>
								  <label for=sitewebpro>Site Web Professionnel</label>
								  <input id=sitewebpro name=sitewebpro type=text placeholder="http://" >
								</li>
								<li>
								  <label for=sitewebperso>Site Web Personnel</label>
								  <input id=sitewebperso name=sitewebperso type=text placeholder="http://" >
								</li>
								  <li>
								  <label for=commentaire>Commentaire</label>
								  <textarea id=adresse name=adresse rows=3 ></textarea>
								</li>
							  </ol>
							</fieldset>
						  </div>
						  <fieldset>
							<button type=submit id="savecategorie">Enregistrer</button>
						  </fieldset>
						  </div>
						  
						   
						</form>
							
						</div>
					</td>
				</tr>
			</table>	
			</div>
				<a href="#x" class="overlay" id="join_form"></a>
					<div class="popup">
					<h2>Ajout Cat&eacute;gorie</h2>
					<div>
						<label for="newcategorie">Entrez une nouvelle cat&eacute;gorie :</label><br>
						<input type="text" id="newcategorie" value="" />
					</div>
					<!--div>
						<input type="checkbox" name="checkbox1" value="checkbox">
						<label for="pass">Imbriquer la cat&eacute;gorie sous :</label><br>
						<select name="catparent" >
							<option>Famille</option>
							<option>Collegues</option>
							<option>Amies</option>
						</select>
					</div-->
					
					<input type="button" value="Cr&eacute;er" id="submitCatBut"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Annuler" />

					<a class="close" href="#close"></a>	
			
					</div>

        <footer class="page-footer">
            <div class="container">
                <p>
                    &#169; 	2014 PCCI - BU SSII 
                </p>
            </div>
        </footer>
  		<script src="scripts/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/pages/contacts.js" type="text/javascript"></script>

    </body>
</html>
