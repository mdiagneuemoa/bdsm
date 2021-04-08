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
						  <div align=center class="rubrique">Inscription au soutien de l’UEMOA à la formation et à la recherche Edition 2017 - 2018											</td>
						</div><div>
						
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
								<label for=identifiantuemoa>Date /Lieu de Naissance<span style="color:red;">*</span></label>
								<input id=datenaissance name=datenaissance type=date required >
								<input id=villenaissance name=villenaissance type=text placeholder="Ville de Naissance"  required>
								 &nbsp;&nbsp;&nbsp;&nbsp;<span class="infoimport">(Age limite 35 ans maximum)</span>
							</li>	
							   <li>
								<label for=sexe>Sexe / Nationnalité</label>
								<select id=sexe name=sexe>
									<option value="">votre sexe...</option>
									<option value="Masculin">Masculin</option>
									<option value="Féminin">Féminin</option>
								</select>
								<select id=nationnalite name=nationnalite>
									<option value="">votre nationnalité...</option>
									<option value="Béninoise">Béninoise</option>
									<option value="Burkinabé">Burkinabé</option>
									<option value="Ivoirienne">Ivoirienne</option>
									<option value="Bissau Guinéenne">Bissau Guinéenne</option>
									<option value=">Malienne">Malienne</option>
									<option value=">Sénégalaise">Sénégalaise</option>
									<option value=">Togolaise">Togolaise</option>

									</select>
							  </li>
							  <!--li>
								  <label for=adressebur>Adresse / ville<span style="color:red;">*</span></label>
								  <input id=adresse name=adresse  placeholder="Adresse principale" required>
								<input id=ville name=ville type=text placeholder="Ville" required>
							</li-->
							   <li>	
							   	<label for=telentreprise>Téléphone <span style="color:red;">*</span>/ Email <span style="color:red;">*</span></label>
								<input id=portable name=portable type=tel placeholder="par ex&nbsp;: +22665866370"  required>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>	
								<input id=emailconfirm name=emailconfirm type=email placeholder="resaisir email...." required>	

							</li>
							   <!--li>
								<label for=telentreprise>Email / CNI ou Passeport<span style="color:red;">*</span></label>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>	
								<input id=cnifile name=cnifile type=file accept='application/msword, application/pdf' required>
								</li-->
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
									<option value="">Niveau du diplome...</option>
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
									<option value="">Annèe d'obtention...</option>
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
										 
								
								</ol>
								 </fieldset>
							</div>
							
						
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
