<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>FICHE D'INSCRIPTION DES TIERS DES ORGANES DE L'UEMOA</title>
        
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

      <header class="page-header">
             <div class="container">
               	<table width="80%">
					<tbody>
							<tr>
					          <td width="20%" nowrap>
									<img src="images/logo_uemoa.png" height=50 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0>
								</td>
							<td align="center" class="titrehead">			
								COLLECTE  DE DONNEES TIERS (RH)
							</td>
							
							 <td width="20%" align=right>
									<img src="images/cauri.png" height=65 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0>
							</td>
							</tr>
							<tr>
								<td nowrap colspan=3 align=right>
									<div id="accueilid" class="hello"></div>
								</td>
							</tr>
				</table>
            </div>
        </header>
 <?php
 
require_once ("config/config_inc.php");

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
?> 		

       <div id="divContainer" >
      
 
					<div id="form-addcontact">
						<form id="candidatform" action="savetiers.php" method=post enctype="multipart/form-data">
						  <input id=tiersid name=tiersid type=hidden>

						  <fieldset>
							<legend>IDENTIFICATION (INFORMATIONS PERSONNELLES)</legend>
									* Bien vouloir compl&eacute;ter la fiche sans abréviation

							<ol>
							   <li>
								<label for=identifiantuemoa>Identification UEMOA <span style="color:red;">*</span></label>
								<input id=matricule name=matricule type=text placeholder="N° Matricule UEMOA" required>
								<input id=identifiant name=identifiant type=text readonly=true placeholder="N° Identifiant Tiers" required>

							  </li>
							   <li>
								<label for=identifiantuemoa>Nom / Prénom<span style="color:red;">*</span></label>
								<input id=nom name=nom type=text  required>
								<input id=prenom name=prenom type=text  required>

							  </li>
							  <li>
								<label for=identifiantuemoa>CIN / Date Naissance <span style="color:red;">*</span></label>
								<input id=identificationfiscale name=identificationfiscale type=text placeholder="N° CIN / Passeport"  required>
								<input id=datenaissance name=datenaissance type=date placeholder="dd/mm/aaaa" required>

							  </li>
							  <li>
								  <label for=adressebur>Adresse <span style="color:red;">*</span></label>
								  <textarea id=adresse name=adresse rows=3 placeholder="Adresse principale" required></textarea>
								  <textarea id=complementadresse name=complementadresse rows=3 placeholder="complément d'adresse" ></textarea>

								</li>
							   <li>
								<label for=codepostal>Code Postale / BP</label>
								<input id=codepostal name=codepostal type=text placeholder="Code Postal" >
								<input id=boitepostale name=boitepostale type=text placeholder="Boite Postale" >
							  </li>
							   <li>
								<label for=ville>Ville / Pays<span style="color:red;">*</span></label>
								<input id=ville name=ville type=text placeholder="Ville" required>
								<input id=pays name=pays type=text placeholder="Pays" required>
							  </li>
							   <li>
								<label for=telentreprise>Téléphone Portable<span style="color:red;">*</span>/ Fixe</label>
								<input id=portable name=portable type=tel placeholder="par ex&nbsp;: +22665866370"  required>
								<input id=telephonefixe name=telephonefixe type=tel placeholder="par ex&nbsp;: +22625866370"  >
							</li>
							   <li>
								<label for=telentreprise>Email<span style="color:red;">*</span>/ Email2</label>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>
								<input id=email2 name=email2 type=text placeholder="par ex&nbsp;: exemple@exemple.com" >

								</li>
							 
								
								</ol>
								 </fieldset>
														  
								 <fieldset>
							<legend>COMPTE BANCAIRE N°1</legend>
							<ol>
							  <li>
								  <label for=banque>Banque / Pays<span style="color:red;">*</span></label>
								  <input id=nombanque1 name=nombanque1 type=text placeholder="Nom Banque"  required>
								  <input id=paysbanque1 name=paysbanque1 type=text placeholder="Code Banque"   required>

							 </li>
								<li>
								  <label for=banque>Code Banque / Agence<span style="color:red;">*</span></label>
								 	<input id=codebanque1 name=codebanque1 type=text placeholder="Code Banque"  required>
								 	<input id=nomagence1 name=nomagence1 type=text placeholder="Nom Agence"  required>

								</li>
								<li>
								  <label for=guichet>Code Guichet / Libellé Compte<span style="color:red;">*</span></label>
								 	<input id=codeguichet1 name=codeguichet1 type=text placeholder="Code Guichet"  required>
								 	<input id=libellecompte1 name=libellecompte1 type=text placeholder="Libellé Compte"  required>

								</li>
								<li>
								  <label for=compte>Numéro Compte / Clé RIB<span style="color:red;">*</span></label>
								 	<input id=numerocompte1 name=numerocompte1 type=text placeholder="Numéro Compte"  required>
								 	<input id=clerib1 name=clerib1 type=text placeholder="Clé RIB"  required>

								</li>
								<li>
								  <label for=devise>Devise / Code SWIFT/IBAN<span style="color:red;">*</span></label>
								 	<input id=devisecompte1 name=devisecompte1 type=text placeholder="Devise"  required>
								 	<input id=codeswift1 name=codeswift1 type=text placeholder="Code SWIFT/IBAN"  required>
								</li>
								<li>
								  <label for=rib>RIB 1 ou copie chéque 1 <span style="color:red;">*</span></label>
								<input id=ribfile name=ribfile type=file accept='application/msword, application/pdf' required	>
								</li>		
								</ol>
								 </fieldset>
								 
								  <fieldset>
							<legend>COMPTE BANCAIRE N°2</legend>
							<ol>
							  <li>
								  <label for=banque>Banque</label>
								  <input id=nombanque2 name=nombanque2 type=text placeholder="Nom Banque"  >
								  <input id=paysbanque2 name=paysbanque2 type=text placeholder="Code Banque"   >

							 </li>
								<li>
								  <label for=banque>Code Banque / Agence</label>
								 	<input id=codebanque2 name=codebanque2 type=text placeholder="Code Banque"   >
								 	<input id=nomagence2 name=nomagence2 type=text placeholder="Nom Agence"  >

								</li>
								<li>
								  <label for=guichet>Code Guichet / Libellé Compte</label>
								 	<input id=codeguichet2 name=codeguichet2 type=text placeholder="Code Guichet"  >
								 	<input id=libellecompte2 name=libellecompte2 type=text placeholder="Libellé Compte"  >

								</li>
								<li>
								  <label for=compte>Numéro Compte / Clé RIB</label>
								 	<input id=numerocompte2 name=numerocompte2 type=text placeholder="Numéro Compte"  >
								 	<input id=clerib2 name=clerib2 type=text placeholder="Clé RIB"  >

								</li>
								<li>
								  <label for=devise>Devise / Code SWIFT/IBAN</label>
								 	<input id=devisecompte2 name=devisecompte2 type=text placeholder="Devise"  >
								 	<input id=codeswift2 name=codeswift2 type=text placeholder="Code SWIFT/IBAN"  >
								</li>
								<li>
								  <label for=rib>RIB 2 ou copie chéque 2 </label>
								<input id=ribfile2 name=ribfile2 type=file accept='application/msword, application/pdf'>
								</li>		
								</ol>
								 </fieldset>
						  <fieldset>
							<legend>PIECES A JOINDRE OBLIGATOIREMENT (Format accepté : .doc, .docx, .pdf (taille max : 2Mo))</legend>
							
							<ol>
								<li>
								  <label for=matriculefile>Copie CNI ou Passeport <span style="color:red;">*</span></label>
								<input id=matriculefile name=matriculefile type=file accept='application/msword, application/pdf' required>
								</li>
								
														
							  </ol>
						  </fieldset>	
						  <div align=center>
							<table><tr><td><button type=submit id="savetiersBut">Enregistrer</button>&nbsp;&nbsp;</td>
							<td><button type=button id="canceltiersBut">Annuler</button>&nbsp;&nbsp;</td></tr></table>
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
