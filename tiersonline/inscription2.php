<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>BOURSE EXCELLENCE UEMOA</title>
        
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
	
	if (date("Y-m-d")=='2017-05-30')
		header("Location: inscriptionclose.php");
	
    ?>
       <header class="page-header">
             <div style=" background-color :#27AE60;">
               	<table width="80%" align=center>
					
							<tr>
					          <td width="40%" valign=middle><img src="images/logo_uemoa.png" height=50 border=0></td>
							<td align="left" valign=middle nowrap><span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
								<span style="font-size: 25px;text-decoration:none;color:#154360;vertical-align:middle;">Portail Soutien de l’UEMOA &agrave; la Formation et &agrave; la Recherche</span></td>
							</tr>
							<tr><td colspan=2><marquee direction="left" color="red"><font color="red">Dernier d&eacute;lai pour les inscriptions &agrave; l'&eacute;dition 2017-2018 le 30 Mai 2017 &agrave; 16h00.</font></MARQUEE>
							</td>
							<tr><td colspan=2 align=right>
									Si D&eacute;j&agrave; inscrit ? <a href="/portailweb/bourseonline.php">acc&eacute;der à votre dossier >></a>
								</td></tr>
				</table>
            </div>
        </header>
 <?php
 
require_once ("config/config_inc.php");

/*																						
require_once (PATH_BEANS."/tiers.php");
require_once (PATH_DAO_IMPL."/tiersDaoImpl.php");
$username=shell_exec("echo %username%" );

if (isset($_POST['windows_logon_user'])) {
 // $_SESSION['windows_logon_user'] = $_POST['windows_logon_user'];
  echo "windows_logon_user=".$_POST['windows_logon_user'];

}
$userlogin = substr($username, 4, -1);
$tiersdao = new TiersDao();
$email=substr($userlogin,0,-1).'@uemoa.int';
$tiers = $tiersdao->selectTiersByEmail($email);
//echo $tiers['identifiant'];
//print_r($tiers);
//echo "Bonjour ",$tiers['nom']," ",$tiers['prenom'];
*/
?> 		

       <div id="divContainer" >
      
 
					<div id="form-addcontact">
						<form id="candidatform" action="savetiers.php" method=post enctype="multipart/form-data">
						  <input id=tiersid name=tiersid type=hidden>
						  <div align=center class="rubrique">Formulaire de Candidature au soutien de l’UEMOA à la formation et à la recherche Edition 2017 - 2018											</td>
						</div><div>
						<fieldset>
							<legend><img src="images/securite.png"border=0>	PARAMETRE DE S&Eacute;CURITE</legend>
									* Choisissez votre identifiant et mot de passe de connexion.Ces informations nous permettrons d'accéder ultérieurement à votre dossier de candidature

							<ol>
							   <li>
								<label for=identifiantuemoa>N° Dossier / Identifiant <span style="color:red;">*</span></label>
								<input id=numdossier name=numdossier type=text value="20170125001" readonly="true">
								<input id=identifiant name=identifiant type=text placeholder="Choisir votre login de connexion" required>
							  </li>
							   <li>
								<label for=passworduemoa>Mot de Passe / Confirmer <span style="color:red;">*</span></label>
								<input id=password name=password type=password readonly=true placeholder="Saisir un mot de Passe" required>
								<input id=confpassword name=confpassword type=password placeholder="Resaisir mot de Passe" required>

							  </li>							   
								</ol>
								 </fieldset>
						
						  <fieldset>
							<legend><img src="images/personnes.png"border=0> IDENTIFICATION DU CANDIDAT</legend>
									* Bien vouloir compl&eacute;ter les informations sans abréviation

							<ol>
							   
							   <li>
								<label for=identifiantuemoa>Nom / Prénom<span style="color:red;">*</span></label>
								<input id=nom name=nom type=text placeholder="Saisir votre nom" required >
								<input id=prenom name=prenom type=text placeholder="Saisir vo(s) prénom(s)"  required>

							  </li>
							  <li>
								<label for=identifiantuemoa>Date de Naissance<span style="color:red;">*</span></label>
								<select id=journaissance name=journaissance style="width:80px">
									<option value="">jour...</option>
									<option value="01">01</option><option value="02">02</option><option value="03">03</option>
									<option value="04">04</option><option value="04">05</option><option value="06">06</option>
									<option value="07">07</option><option value="08">08</option><option value="09">09</option>
									<option value="10">10</option><option value="11">11</option><option value="12">12</option>
									<option value="13">13</option><option value="14">14</option><option value="15">15</option>
									<option value="16">16</option><option value="17">17</option><option value="18">18</option>
									<option value="18">18</option><option value="18">18</option><option value="18">18</option>
									<option value="19">19</option><option value="20">20</option><option value="21">21</option>
									<option value="22">22</option><option value="23">23</option><option value="24">24</option>
									<option value="25">25</option><option value="26">26</option><option value="27">27</option>
									<option value="28">28</option><option value="29">29</option><option value="30">30</option>
									<option value="31">31</option>
									</select>
									<select id=moisnaissance name=moisnaissance style="width:80px">
									<option value="">Mois...</option>
									<option value="01">01</option><option value="02">02</option><option value="03">03</option>
									<option value="04">04</option><option value="04">05</option><option value="06">06</option>
									<option value="07">07</option><option value="08">08</option><option value="09">09</option>
									<option value="10">10</option><option value="11">11</option><option value="12">12</option>
									</select>
									<select id=annaissance name=annaissance style="width:80px">
									<option value="">Année...</option>
									<option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option>
									<option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option>
									<option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option>
									<option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option>
									<option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option>
									<option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option>
									<option value="2000">2000</option>
								</select> &nbsp;&nbsp;&nbsp;&nbsp;<span class="infoimport">(Age limite 35 ans maximum)</span>
								 <li>
								<label for=identifiantuemoa>Lieu de Naissance<span style="color:red;">*</span></label>
								<input id=villenaissance name=villenaissance type=text placeholder="Ville de Naissance"  required>
								<input id=paysnaissance name=paysnaissance type=text placeholder="Pays de Naissance"  required>

							  </li>
							   <li>
								<label for=sexe>Sexe / Nationnalité</label>
								<select id=sexe name=sexe>
									<option value="">Choisir votre sexe...</option>
									<option value="Masculin">Masculin</option>
									<option value="Féminin">Féminin</option>
								</select>
								<select id=nationnalite name=nationnalite>
									<option value="">Choisir votre nationnalité...</option>
									<option value="Béninoise">Béninoise</option>
									<option value="Burkinabé">Burkinabé</option>
									<option value="Ivoirienne">Ivoirienne</option>
									<option value="Bissau Guinéenne">Bissau Guinéenne</option>
									<option value=">Malienne">Malienne</option>
									<option value=">Sénégalaise">Sénégalaise</option>
									<option value=">Togolaise">Togolaise</option>

									</select>
							  </li>
							  <li>
								  <label for=adressebur>Adresse / ville<span style="color:red;">*</span></label>
								  <input id=adresse name=adresse  placeholder="Adresse principale" required>
								<input id=ville name=ville type=text placeholder="Ville" required>
							</li>
							   <li>	
							   	<label for=telentreprise>Pays / Téléphone <span style="color:red;">*</span>/ Fixe</label>
								<input id=pays name=pays type=text placeholder="Pays" required>
								<input id=portable name=portable type=tel placeholder="par ex&nbsp;: +22665866370"  required>
							</li>
							   <li>
								<label for=telentreprise>Email / CNI ou Passeport<span style="color:red;">*</span></label>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>	
								<input id=cnifile name=cnifile type=file accept='application/msword, application/pdf' required>
								</li>
								</ol>
								 </fieldset>
								
							 <fieldset>
							<legend><img src="images/diplome.jpg"border=0> INFORMATIONS SUR LE DERNIER DIPLOME OBTENU</legend>
									
							<ol>
							   
							   <li>
								<label for=titrediplome>Titre / Discipline<span style="color:red;">*</span></label>
								<textarea id=titrederndiplome name=titrederndiplome type=text placeholder="Titre exact du diplome" required></textarea>
								<textarea id=disciplinederndiplome name=disciplinederndiplome type=text placeholder="par ex&nbsp;: Biologie" required></textarea>

							  </li>
							  <li>
								<label for=niveau>Niveau / Etablissement<span style="color:red;">*</span></label>
								<select id=niveaudiplome name=niveaudiplome>
									<option value="">Choisir le niveau du diplome...</option>
									<option value="BAC + 4">BAC + 4</option>
									<option value="BAC + 5">BAC + 5</option>
									<option value="Master 1">Master 1</option>
									<option value="Master 2">Master 2</option>
									<option value=">BAC + 5">>BAC + 5</option>
								</select>
								<input id=etablissementobtention name=etablissementobtention type=text placeholder="Etablissement d obtention"  required>

							  </li>
							   <li>
								<label for=annee>Annèe  / Moyenne </label>
								<select id=anneediplome name=anneediplome>
									<option value="">Choisir l'annèe d'obtention...</option>
									<option value="2000">2000</option>									
									<option value="2001">2001</option>
									<option value="2002">2002</option>
									<option value="2003">2003</option>
									<option value="2004">2004</option>									
									<option value="2005">2005</option>
									<option value="2006">2006</option>
									<option value="2007">2007</option>
									<option value="2008">2008</option>
									<option value="2009">2009</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>									
									<option value="2016">2015</option>									
									<option value="2017">2017</option>
									</select>
								<input id=moyennediplome name=moyennediplome type=text placeholder="par ex&nbsp;: 15.75 " >
							  </li>
							 <li>
								  <label for=diplomefile>Dernier diplome et relevé  <span style="color:red;">*</span></label>
								<input id=diplomefile name=diplomefile type=file accept='application/msword, application/pdf' required>
								<input id=relevenotefile name=relevenotefile type=file accept='application/msword, application/pdf' required>
								</li>					 
								
								</ol>
								 </fieldset>
							</div>
							<div id="form-etablissement1">							
								 <fieldset>
							<legend><img src="images/etablissement.jpg"border=0> CHOIX ETABLISSEMENT</legend>
							<span class="infoimport">* Vous pouvez choisir jusqu'à 3 établissements par ordre de priorité <br> NB : établissements d'enseignement supérieur public (nationnal ou communautaire) implanté sur le territoire de l'UEMOA															</span>
							<hr><br><span class="choixetab"> 1er Choix établissement</span>
							<ol>
							  <li>
								  <label for=etablissement>Etablissement Sollicité<span style="color:red;">*</span></label>
								  <textarea id=etablissement1 name=etablissement1 type=text placeholder="Nom Etablissement Sollicité"  required></textarea>
								  <textarea id=complementinfo1 name=complementinfo1 type=text placeholder="Autre établissement (si pas dans la liste)"   required></textarea>

							 </li>
							 
								 <li>
								<label for=villeetablissement1>Ville / Pays <span style="color:red;">*</span></label>
								<input id=villeetablissement1 name=villeetablissement1 type=text placeholder="Ville" required>
								<input id=paysetablissement1 name=paysetablissement1 type=text placeholder="Pays" required>
							  </li>
							   <li>
								<label for=teleetablissement>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=teletablissement1 name=teletablissement1 type=text placeholder="+22x xx xx xx xx" required>
								<input id=emailetablissement1 name=emailetablissement1 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
							  <span class="rubrique"> Information sur la formation demandée</span>
						
							  <li>
								  <label for=filiere>UFR ou faculté / Filière<span style="color:red;">*</span></label>
								  <input id=faculte1 name=faculte1 type=text placeholder="Nom de l'UFR ou Faculté ou Département"  required></textarea>
								  <input id=filiere1 name=filiere1 type=text placeholder="Filière"   required></input>

							 </li>
							  <li>
								<label for=diplomeprepare>Diplôme Préparé / Durée<span style="color:red;">*</span></label>
								<input id=diplomeprepare1 name=diplomeprepare1 type=text placeholder="Dénomination exacte du diplôme" required>
								<input id=dureediplome1 name=dureediplome1 type=text placeholder="Durée formation en nombre de mois" >

								</li>
								 <li>
								<label for=identifiantuemoa>Date Début / Date Fin <span style="color:red;">*</span></label>
								<input id=datedebut1 name=datedebut1 type=date placeholder="dd/mm/aaaa" required>
								<input id=datefin1 name=datefin1 type=date placeholder="dd/mm/aaaa"  required>

							  </li>
							  <li>
								<label for=montantscolarite>Montant Frais Scolarité <span style="color:red;">*</span></label>
								<input id=montantscolarite1 name=montantscolarite1 type=text placeholder="Montant Total Frais de scolarité (en CFA)" required>
								<select id=formationenligne1 name=formationenligne1>
									<option value="">S'agit-il d'une formation en ligne?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								</li>
								<span class="rubrique">Joindre une pr&eacute;inscription ou attestation d'inscription</span>
								<li>

								  <label for=cnifile>Préinscription <span style="color:red;"></span></label>
								<select id=preinscription1 name=preinscription1>
									<option value="">Avez-vous une préinscription?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								<input id=preinscriptionfile1 name=preinscriptionfile1 type=file accept='application/msword, application/pdf' required>
								</li>		 
							<span class="rubrique"> Personne à contacter dans l'établissement</span>
						
							  <li>
								  <label for=contact1>Nom Contact / Fonction<span style="color:red;">*</span></label>
								  <input id=contact1 name=contact1 type=text placeholder="Nom de la personne à contacter"  required></textarea>
								  <input id=fonction1 name=fonction1 type=text placeholder="par ex&nbsp;: Directeur, Secrétaire, etc."   required></input>

							 </li>
							 <li>
								<label for=telcontact>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=telcontact1 name=telcontact1 type=text placeholder="+22x xx xx xx xx" required>
								<input id=emailcontact1 name=emailcontact1 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
								
								</ol>
								
							</div>
							<div align=right><!--button type=button onclick="document.getElementById('form-etablissement2').style.display='block';document.getElementById('etablissement2').focus();" id="choix2" class="butchoix">Ajouter un deuxième établissement</button-->							
							<a href="#" onclick="document.getElementById('form-etablissement2').style.display='block';document.getElementById('etablissement2').focus();"><img src="images/etabadd.gif" border=0 title="Ajouter un deuxième établissement"></a></div>
							<hr>																			
							<div id="form-etablissement2" style="display:none;">	
							<div align=right><a href="#" onclick="document.getElementById('form-etablissement2').style.display='none';document.getElementById('etablissement2').focus();"><img src="images/etabcancel.gif" border=0 title="Annuler deuxième choix"></a></div>
														
								<br><span class="choixetab" align=left> 2ème Choix établissement</span>
							
							<ol>
							  <li>
								  <label for=etablissement>Etablissement Sollicité<span style="color:red;">*</span></label>
								  <textarea id=etablissement2 name=etablissement2 type=text placeholder="Nom Etablissement Sollicité"  required></textarea>
								  <textarea id=complementinfo2 name=complementinfo2 type=text placeholder="Autre établissement (si pas dans la liste)"   required></textarea>

							 </li>
							 
								 <li>
								<label for=villeetablissement2>Ville / Pays <span style="color:red;">*</span></label>
								<input id=villeetablissement2 name=villeetablissement2 type=text placeholder="Ville" required>
								<input id=paysetablissement2 name=paysetablissement2 type=text placeholder="Pays" required>
							  </li>
							   <li>
								<label for=teleetablissement>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=teletablissement2 name=teletablissement2 type=text placeholder="+22x xx xx xx xx" required>
								<input id=emailetablissement2 name=emailetablissement2 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
							  <span class="rubrique"> Information sur la formation demandée</span>
						
							  <li>
								  <label for=filiere>UFR ou faculté / Filière<span style="color:red;">*</span></label>
								  <input id=faculte2 name=faculte2 type=text placeholder="Nom de l'UFR ou Faculté ou Département"  required></textarea>
								  <input id=filiere2 name=filiere2 type=text placeholder="Filière"   required></input>

							 </li>
							  <li>
								<label for=diplomeprepare>Diplôme Préparé / Durée<span style="color:red;">*</span></label>
								<input id=diplomeprepare2 name=diplomeprepare2 type=text placeholder="Dénomination exacte du diplôme" required>
								<input id=dureediplome2 name=dureediplome2 type=text placeholder="Durée formation en nombre de mois" >

								</li>
								 <li>
								<label for=identifiantuemoa>Date Début / Date Fin <span style="color:red;">*</span></label>
								<input id=datedebut2 name=datedebut2 type=date placeholder="dd/mm/aaaa" required>
								<input id=datefin2 name=datefin2 type=date placeholder="dd/mm/aaaa"  required>

							  </li>
							  <li>
								<label for=montantscolarite>Montant Frais Scolarité <span style="color:red;">*</span></label>
								<input id=montantscolarite2 name=montantscolarite2 type=text placeholder="Montant Total des Frais de scolarité (en CFA)" required>
								<select id=formationenligne2 name=formationenligne2>
									<option value="">S'agit-il d'une formation en ligne?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								
								</li>
								<span class="rubrique">Joindre une pr&eacute;inscription ou attestation d'inscription</span>
								<li>
								
								  <label for=cnifile>Préinscription <span style="color:red;"></span></label>
								  <select id=preinscription2 name=preinscription2>
									<option value="">Avez-vous une préinscription?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								<input id=preinscriptionfile2 name=preinscriptionfile2 type=file accept='application/msword, application/pdf' required>
								</li>		 
							<span class="rubrique"> Personne à contacter dans l'établissement</span>
						
							  <li>
								  <label for=contact2>Nom Contact / Fonction<span style="color:red;">*</span></label>
								  <input id=contact2 name=contact2 type=text placeholder="Nom de la personne à contacter"  required></textarea>
								  <input id=fonction2 name=fonction2 type=text placeholder="par ex&nbsp;: Directeur, Secrétaire, etc."   required></input>

							 </li>
							 <li>
								<label for=telcontact>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=telcontact2 name=telcontact2 type=text placeholder="+22x xx xx xx xx" required>
								<input id=emailcontact2 name=emailcontact2 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
								
								</ol>
								<div align=right><button type=button onclick="document.getElementById('form-etablissement3').style.display='block';document.getElementById('etablissement3').focus();" id="choix2" class="butchoix">Ajouter un troisième établissement</button></div>							

																												
							<hr></div>
							
									<div id="form-etablissement3" style="display:none;">	
								 <div align=right><a href="#" onclick="document.getElementById('form-etablissement3').style.display='none';document.getElementById('etablissement2').focus();"><img src="images/etabcancel.gif" border=0 title="Annuler troisième choix"></a></div>
									
							<br><span class="choixetab">3&Egrave;me Choix établissement</span>
							
							<ol>
							  <li>
								  <label for=etablissement>Etablissement Sollicité<span style="color:red;">*</span></label>
								  <textarea id=etablissement3 name=etablissement3 type=text placeholder="Nom Etablissement Sollicité"  required></textarea>
								  <textarea id=complementinfo3 name=complementinfo3 type=text placeholder="Autre établissement (si pas dans la liste)"   required></textarea>

							 </li>
							 
								 <li>
								<label for=villeetablissement3>Ville / Pays <span style="color:red;">*</span></label>
								<input id=villeetablissement3 name=villeetablissement3 type=text placeholder="Ville" required>
								<input id=paysetablissement3 name=paysetablissement3 type=text placeholder="Pays" required>
							  </li>
							   <li>
								<label for=teleetablissement>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=teletablissement3 name=teletablissement3 type=text placeholder="+33x xx xx xx xx" required>
								<input id=emailetablissement3 name=emailetablissement3 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
							  <span class="rubrique"> Information sur la formation demandée</span>
						
							  <li>
								  <label for=filiere>UFR ou faculté / Filière<span style="color:red;">*</span></label>
								  <input id=faculte3 name=faculte3 type=text placeholder="Nom de l'UFR ou Faculté ou Département"  required></textarea>
								  <input id=filiere3 name=filiere3 type=text placeholder="Filière"   required></input>

							 </li>
							  <li>
								<label for=diplomeprepare>Diplôme Préparé / Durée<span style="color:red;">*</span></label>
								<input id=diplomeprepare3 name=diplomeprepare3 type=text placeholder="Dénomination exacte du diplôme" required>
								<input id=dureediplome3 name=dureediplome3 type=text placeholder="Durée formation en nombre de mois" >

								</li>
								 <li>
								<label for=identifiantuemoa>Date Début / Date Fin <span style="color:red;">*</span></label>
								<input id=datedebut3 name=datedebut3 type=date placeholder="dd/mm/aaaa" required>
								<input id=datefin3 name=datefin3 type=date placeholder="dd/mm/aaaa"  required>

							  </li>
							  <li>
								<label for=montantscolarite>Montant Frais Scolarité <span style="color:red;">*</span></label>
								<input id=montantscolarite3 name=montantscolarite3 type=text placeholder="Montant Total des Frais de scolarité (en CFA)" required>
								<select id=formationenligne3 name=formationenligne3>
									<option value="">S'agit-il d'une formation en ligne?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								
								</li>
								<span class="rubrique">Joindre une pr&eacute;inscription ou attestation d'inscription</span>
								<li>
								  <label for=cnifile>Préinscription <span style="color:red;"></span></label>
								  <select id=preinscription3 name=preinscription3>
									<option value="">Avez-vous une préinscription?...</option>
									<option value="OUI">OUI</option>									
									<option value="NON">NON</option>
								</select>
								<input id=preinscriptionfile3 name=preinscriptionfile3 type=file accept='application/msword, application/pdf' required>
								</li>		 
							<span class="rubrique"> Personne à contacter dans l'établissement</span>
						
							  <li>
								  <label for=contact3>Nom Contact / Fonction<span style="color:red;">*</span></label>
								  <input id=contact3 name=contact3 type=text placeholder="Nom de la personne à contacter"  required></textarea>
								  <input id=fonction3 name=fonction3 type=text placeholder="par ex&nbsp;: Directeur, Secrétaire, etc."   required></input>

							 </li>
							 <li>
								<label for=telcontact>Téléphone<span style="color:red;">*</span>/ Email</label>
								<input id=telcontact3 name=telcontact3 type=text placeholder="+22x xx xx xx xx" required>
								<input id=emailcontact2 name=emailcontact2 type=email placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
								
								</ol>
								 </fieldset>
							<hr></div>
							<div>
						  <!--fieldset>
							<legend>PIECES A JOINDRE OBLIGATOIREMENT (Format accepté : .doc, .docx, .pdf (taille max : 2Mo))</legend>
							
							<ol>
								<li>
								  <label for=cnifile>CNI ou Passeport <span style="color:red;">*</span></label>
								<input id=cnifile name=cnifile type=file accept='application/msword, application/pdf' required>
								</li>
								<li>
								  <label for=diplomefile>Dernier diplome <span style="color:red;">*</span></label>
								<input id=diplomefile name=diplomefile type=file accept='application/msword, application/pdf' required>
								</li>
								<li>
								  <label for=relevenotefile>Relevé de notes <span style="color:red;">*</span></label>
								<input id=relevenotefile name=relevenotefile type=file accept='application/msword, application/pdf' required>
								</li>						
							  </ol>
						  </fieldset-->	
						  <div align=center>
							<table><tr><td><button type=submit id="savetiersBut" class="butvalide">Enregistrer</button>&nbsp;&nbsp;</td>
							<td><button type=button id="canceltiersBut" onclick="history.back();" class="butcancel">Annuler</button>&nbsp;&nbsp;</td></tr></table>
						  </div>
						  </div>
						  
						   
						</form>
							
						</div>
					</td>
				</tr>
			</table>	
			</div>
				

        <footer class="page-footer">
            <div class="container">
                <p>
                    &#169; 	2016 DSI / Commission UEMOA
                </p>
            </div>
        </footer>
  		<script src="scripts/jquery.min.js" type="text/javascript"></script>
        <script src="scripts/pages/carrieres.js" type="text/javascript"></script>

    </body>
</html>
