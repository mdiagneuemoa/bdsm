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

       <div id="divContainer">
 
					<div id="form-addcontact">
						<form id="candidatform">
					
						  <fieldset>
							<legend>INFORMATIONS PERSONNELLES</legend>

							<ol>
							 
							 <li>
								<label for=nom>Nom / Prénom</label>
								<select name="civilite">
									<option value="Mme" >Madame</option>
									<option value="Mlle" >Mademoiselle</option>
									<option value="M." selected>Monsieur</option>
								</select>
								<input id=nom name=nom type=text placeholder="nom" required>
								<input id=prenom name=prenom type=text placeholder="Prenom" required>
							
							  </li>
							  <li>
								  <label for=adressebur>Adresse</label>
								  <textarea id=adresse name=adresse rows=3 ></textarea>
								</li>
								
							   <li>
								<label for=ville>Ville / Pays</label>
								<input id=ville name=ville type=text placeholder="Ville">
								<input id=pays name=pays type=text placeholder="Pays">
							  </li>
							   <li>
								<label for=mobile>Mobile / Email</label>
								<input id=mobile name=mobile type=tel placeholder="par ex&nbsp;: +221772154878" required>
								<input id=email name=email type=email placeholder="exemple@domaine.com">
								</li>
								 <li>
								  <label for=specialite>Sp&eacute;cialit&eacute;</label>
								  <textarea id=specialite name=specialite rows=3 placeholder="par ex&nbsp;: Développement, Réseau & Système, Télécom"></textarea>
								</li>
								</ol>
								 </fieldset>
								 <fieldset>
							<legend>FORMATIONS ET DIPLOMES </legend>
							 * Saisir les 3 dernieres diplômes ou formations obtenus (année - établissement - diplôme préparé)
								<ol>
								<li>
								<label for=dernierdiplome>Dernier Diplome</label>
								<select name="anneedd" id="anneedd">
									<option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option>
									<option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
									<option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option>
									<option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option>
									<option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>

								</select>
								<input id=derniereecole name=derniereecole type=text placeholder="saisir le nom de l'établissement">
								<input id=derniereecole name=derniereecole type=text placeholder="saisir l'intitulé du diplôme">
							
							  </li>
							  <li>
								<label for=formation1>Formation / Séminaire</label>
								
								<select name="anneef1" id="anneef1">
									<option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option>
									<option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
									<option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option>
									<option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option>
									<option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>

								</select>
								<input id=formationecole1 name=formationecole1 type=text placeholder="saisir le nom de l'établissement">
								<input id=formationdiplome1 name=formationdiplome1 type=text placeholder="saisir l'intitulé du diplôme préparé">
								
							  </li>
							
							  <li>
								<label for=formation1>Formation / Séminaire</label>
								
								<select name="anneef1" id="anneef1">
									<option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option>
									<option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
									<option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option>
									<option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option>
									<option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>

								</select>
								<input id=formationecole1 name=formationecole1 type=text placeholder="saisir le nom de l'établissement">
								<input id=formationdiplome1 name=formationdiplome1 type=text placeholder="saisir l'intitulé du diplôme préparé">
								
							  </li>
							   <li>
								<label for=formation1>Formation / Séminaire</label>
								
								<select name="anneef1" id="anneef1">
									<option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option>
									<option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
									<option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option>
									<option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option>
									<option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option>

								</select>
								<input id=formationecole1 name=formationecole1 type=text placeholder="saisir le nom de l'établissement">
								<input id=formationdiplome1 name=formationdiplome1 type=text placeholder="saisir l'intitulé du diplôme préparé">
								
							  </li>
							  </ol>
							   </fieldset>
								 <fieldset>
							<legend>COMPETENCES TECHNIQUES</legend>
							* Saisir vos compétences Syst&egrave;me / SGBD, Technologies / Outils,Fonctionnelle / Processus ou Autres selon votre domaine de compétences 

							<ol>
							  <li>
								  <label for=competencesys>Syst&egrave;me / SGBD</label>
								  <textarea id=competencesys name=competencesys rows=2 placeholder="par ex&nbsp;: Windows, Linux, ..." ></textarea>
								  <textarea id=competencesgbd name=competencesgbd rows=2 placeholder="par ex&nbsp;: SQL Server, Mysql, ..." ></textarea>
								</li>
								<li>
								  <label for=competencestechno>Technologies / Outils</label>
								  <textarea id=competencestechno name=competencestechno rows=2 placeholder="par ex&nbsp;: Java/JEE, C#/.NET, ..."></textarea>
								  <textarea id=competencesoutils name=competencesoutils rows=2 placeholder="par ex&nbsp;: Eclipse, CVS, ..."></textarea>
								</li>
								<li>
								  <label for=competencefonc>Fonctionnelle / Processus</label>
								  <textarea id=competencefonc name=competencefonc rows=2 ></textarea>
								  <textarea id=competenceproc name=competenceproc rows=2 placeholder="par ex&nbsp;: ITIL, PGI, ..."></textarea>
								</li>
								<li>
								  <label for=competenceautre>Autre</label>
								  <textarea id=competenceautre name=competenceautre rows=3 ></textarea>
								</li>
								</ol>
								 </fieldset>
								 <fieldset>
							<legend>EXPERIENCES PROFESSIONNELLES & PROJETS</legend>
							* Saisir vos expériences professionnelles acquises lors de vos stages, emploi, projets scolaires ou Séminaires <br>
							en indiquant : la période, l'entreprise hôte (s'il existe), le sujet ou le poste occupé, le description de la mission

							<ol>
							
								<li>
								  <label for=competenceautre><select name="typeexperience1">
									<option value="Mme" >Stage</option>
									<option value="Mlle" >Emploi</option>
									<option value="M." selected>Projet</option>
									<option value="M." selected>Seminaire / Formation</option>

								</select></label>
								<input id=entexperience1 name=entexperience1 type=text placeholder="Entreprise hôte">
								  <input id=sujetexperience1 name=sujetexperience1 rows=3 placeholder="intitulé mission">

								<li>
										<label for=competenceautre>Periode</label>
										<input id=dbexperience1 name=dbexperience1 type=date size=10>
									 	<input id=dbexperience1 name=dbexperience1 type=date>
								<li>	
									<label for=competenceautre>Détail</label>

								  <textarea id=envtechexperience1 name=envtechexperience1 rows=3 placeholder="technologies utilisées"></textarea>
								  <textarea id=detailexperience1 name=detailexperience1 rows=3 placeholder="détail de la mission"></textarea>

							  </li>
							<li>
								  <label for=competenceautre><select name="typeexperience1">
									<option value="Mme" >Stage</option>
									<option value="Mlle" >Emploi</option>
									<option value="M." selected>Projet</option>
									<option value="M." selected>Seminaire / Formation</option>

								</select></label>
								<input id=entexperience1 name=entexperience1 type=text placeholder="Entreprise hôte">
								  <input id=sujetexperience1 name=sujetexperience1 rows=3 placeholder="intitulé mission">

								<li>
										<label for=competenceautre>Periode</label>
										<input id=dbexperience1 name=dbexperience1 type=date size=10>
									 	<input id=dbexperience1 name=dbexperience1 type=date>
								<li>	
									<label for=competenceautre>Détail</label>

								  <textarea id=envtechexperience1 name=envtechexperience1 rows=3 placeholder="technologies utilisées"></textarea>
								  <textarea id=detailexperience1 name=detailexperience1 rows=3 placeholder="détail de la mission"></textarea>

							  </li>
							  <li>
								  <label for=competenceautre><select name="typeexperience1">
									<option value="Mme" >Stage</option>
									<option value="Mlle" >Emploi</option>
									<option value="M." selected>Projet</option>
									<option value="M." selected>Seminaire / Formation</option>

								</select></label>
								<input id=entexperience1 name=entexperience1 type=text placeholder="Entreprise hôte">
								  <input id=sujetexperience1 name=sujetexperience1 rows=3 placeholder="intitulé mission">

								<li>
										<label for=competenceautre>Periode</label>
										<input id=dbexperience1 name=dbexperience1 type=date size=10>
									 	<input id=dbexperience1 name=dbexperience1 type=date>
								<li>	
									<label for=competenceautre>Détail</label>

								  <textarea id=envtechexperience1 name=envtechexperience1 rows=3 placeholder="technologies utilisées"></textarea>
								  <textarea id=detailexperience1 name=detailexperience1 rows=3 placeholder="détail de la mission"></textarea>

							  </li>
							  
							  </ol>
						  </fieldset>

						  <fieldset>
							<legend>CV & LETTRE MOTIVATION</legend>
							* Joindre votre CV et Lettre de motivation <br>
							Format accepté : .doc, .docx, .pdf (taille max : 2Mo)

							<ol>
								<li>
								  <label for=cv>votre Cv : </label>
								<input id=cv name=cv type=file accept='application/msword, application/pdf'>

								<li>
										  <label for=lettremotiv>votre Lettre de modivation : </label>
								<input id=lettremotiv name=lettremotiv type=file accept='application/msword, application/pdf'>
							  </ol>
						  </fieldset>	
						  <div>
							<button type=submit id="savecategorie">Enregistrer</button>&nbsp;&nbsp;

						  </div>
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
                    &#169; 	2014 2AS
                </p>
            </div>
        </footer>
  		<script src="scripts/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/pages/carrieres.js" type="text/javascript"></script>

    </body>
</html>
