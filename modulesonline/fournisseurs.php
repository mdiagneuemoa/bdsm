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
        <link href="styles/jquery.autocomplete.css" media="print" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="scripts/jquery.autocomplete.js"></script> 
	<script type="text/javascript" src="scripts/jquery.autocomplete.min.js"></script> 
	<script type="text/javascript" src="scripts/jquery.autocomplete.pack.js"></script> 

    </head>
    <body>

      <header class="page-header">
             <div class="container">
               	<table width="100%" border=0>
					<tbody>
							<tr>
					          <td width="8%" width=20 valign=top >
									<img src="images/logo_uemoa.png" height=50 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0>
								</td>
							<td align="left" class="titrehead" width="84%">			
								FICHE D'INSCRIPTION DES TIERS (FOURNISSEURS)
							</td>
							
							 
							</tr>
				</table>
            </div>
        </header>
 <?php
 
require_once ("config/config_inc.php");

require_once (PATH_BEANS."/tiers.php");
require_once (PATH_DAO_IMPL."/tiersDaoImpl.php");


?> 		
	<div id="accueilid" class="hello" align=left></div>
       <div id="divContainer">
      
 
					<div id="form-addcontact">
						<form id="candidatform" action="savefournisseurs.php" method=post enctype="multipart/form-data">
						  <input id=tiersid name=tiersid type=hidden>

						  <fieldset>
							<legend>IDENTIFICATION (INFORMATIONS PERSONNELLES)</legend>
									* Bien vouloir compl&eacute;ter la fiche sans abr??viation

							<ol>
							 <li>
								<label for=identifiantuemoa>N?? Identification(IFU,NINEA,...) <span style="color:red;">*</span></label>
								<input id=identificationfiscale name=identificationfiscale type=text placeholder="N?? IFU,NINEA,..." required>
								<input id=identifiant name=identifiant type=text readonly=true placeholder="N?? Identifiant UEMOA" required>

							  </li>
							 <li>
								<label for=identifiantuemoa>Nom Pr??nom(s)/Raison Sociale<span style="color:red;">*</span></label>
								<input id=raisonsociale name=raisonsociale type=text  required>
								<input id=initiales name=initiales type=text placeholder="Initiales (Sigle)">

							  </li>
							  
							  
							  <li>
								<label for=identifiantuemoa>N?? Matricule/Date Cr??ation<span style="color:red;">*</span></label>
								<input id=nummatricule name=nummatricule type=text placeholder="N?? RC / N?? Matricule / N?? Pi??ce d'Identit??"  required>
								<input id=datenaissance name=datenaissance type=date  required>

							  </li>
							  <li>
								  <label for=adressebur>Adresse <span style="color:red;">*</span></label>
								  <textarea id=adresse name=adresse rows=3 placeholder="Adresse principale" required></textarea>
								  <textarea id=complementadresse name=complementadresse rows=3 placeholder="compl??ment d'adresse" ></textarea>

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
								<label for=telentreprise>T??l??phone Portable<span style="color:red;">*</span>/ Fixe</label>
								<input id=portable name=portable type=tel placeholder="par ex&nbsp;: +22665866370"  required>
								<input id=telephonefixe name=telephonefixe type=tel placeholder="par ex&nbsp;: +22625866370"  >
							</li>
							<li>
								<label for=faxentreprise>Fax  / Site Internet</label>
								<input id=fax name=fax type=fax placeholder="par ex&nbsp;: +22625866371" >
								<input id=siteinternet name=siteinternet type=tel placeholder="par ex&nbsp;: www.uemoa.int">
							</li>
							   <li>
								<label for=emailentreprise>Email<span style="color:red;">*</span>/ Email2</label>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>
								<input id=email2 name=email2 type=text placeholder="par ex&nbsp;: exemple@exemple.com" >
							</li>
							 <li>
								<label for=persjuridique>Personnalit??/Forme (Juridique)<span style="color:red;">*</span></label>
								<select name="personnalitejuridique" id="personnalitejuridique">
									<option value="">Choisissez une Personnalit?? Juridique...</option>
									<option value="PERSONNE PHYSIQUE">Personne Physique</option>
									<option value="PERSONNE MORALE">Personne Morale</option>

								</select>
								<select name="formejuridique" id="formejuridique">
									<option value="">Choisissez une Forme Juridique...</option>
									<option value="ENTIND">Entreprise individuelle</option>
									<option value="GIE">Groupement d Int&eacute;r&ecirc;t Economique (GIE)</option>
									<option value="SA">Soci&eacute;t&eacute; anonyme (SA)</option>
									<option value="SARL">Soci&eacute;t&eacute; &agrave; Responsabilit&eacute; Limit&eacute;e (SARL)</option>
									<option value="SCS">Soci&eacute;t&eacute; en Commandite Simple (SCS)</option>
									<option value="SNC">Soci&eacute;t&eacute; en Nom Collectif (SNC)</option>
									<option value="SURL">Soci&eacute;t&eacute; Unipersonnelle &agrave; responsabilit&eacute; limit&eacute;e (SURL)</option>

								</select>
							</li> 
								
						</ol>
					 </fieldset>
					<fieldset>
						<legend>REPRESENTANT / PERSONNE A CONTACTER</legend>
						<ol>
						  <li>
							  <label for=representant>Nom / Titre<span style="color:red;">*</span></label>
							  <input id=repnom name=repnom type=text placeholder="par ex&nbsp;: M. Alex NDA "  required>
							  <input id=reptitre name=reptitre type=text placeholder="par ex&nbsp;: Directeur"   required>

						 </li>
						 <li>
						  <label for=banque>Portable<span style="color:red;">*</span> / Ligne Directe (Fixe)</label>
							<input id=repportable name=repportable type=text placeholder="par ex&nbsp;: +22665866370"  required>
							<input id=replignedirect name=replignedirect type=text placeholder="par ex&nbsp;: +22625866371" >

						 </li>	
						 </ol>
						 </fieldset>			
						<fieldset>
						<legend>TYPES D'ACTIVITE (3 Maximum)</legend>
						<ol>
						  <li>
						  
							<table cellpadding=5 cellspacing=5 style="width:100%;height:200px;overflow:auto;display:inline-block;">
							   <tr>
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.1">&nbsp;&nbsp;A.1 : Eau - Electricit??
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.2">&nbsp;&nbsp;A.2 : Carburant, lubrifiant, gaz
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.3">&nbsp;&nbsp;A.3 : T??l??phonie
							   </tr>
							    <tr>
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.4">&nbsp;&nbsp;A.4 : Fournitures de bureau
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.5">&nbsp;&nbsp;A.5 : Consommables informatiques
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.6">&nbsp;&nbsp;A.6 : Mat??riel et mobilier de bureau
							   </tr>
							    <tr>
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.7">&nbsp;&nbsp;A.7 : Mat??riel et logiciels informatiques
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.8">&nbsp;&nbsp;A.8 : Mat??riel et outillage divers
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.9">&nbsp;&nbsp;A.9 : Produits pharmaceutiques
							    </tr>
							    <tr>
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.10">&nbsp;&nbsp;A.10 : Transport ??? Transit - Logistique
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.11">&nbsp;&nbsp;A.11 : Courrier et affranchissements
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.12">&nbsp;&nbsp;A.12 : Imprimerie 
							   </tr>
							   <tr>
								<td  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.17">&nbsp;&nbsp;A.17 : Location de v??hicules
								<td  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.18">&nbsp;&nbsp;A.18 : Assurances
								<td  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.27">&nbsp;&nbsp;A.27 : Gardiennage et s??curit??
							   </tr>
							   <tr>
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.19">&nbsp;&nbsp;A.19 : Etudes et recherches (cabinet, consultant)
								<td nowrap valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.20">&nbsp;&nbsp;A.20 : Textile, habillement, d??coration
								<td  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.21">&nbsp;&nbsp;A.21 : Restauration, h??bergement
							   </tr>

							   <tr>
								<td valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.22">&nbsp;&nbsp;A.22 : Activit??s r??cr??atives (loisir, culture, sport)
								<td valign=top colspan=3><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.25">&nbsp;&nbsp;A.25 : Entretien et r??paration automobiles
						   </tr>
							   <tr>
								<td  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.23">&nbsp;&nbsp;A.23 : Maintenance mat??riel informatique
								<td colspan=3 valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.24">&nbsp;&nbsp;A.24 : Entretien et maintenance d???onduleurs, groupes ??lectrog??nes, etc.
							   </tr>
							   <tr>
								<td  valign=top><INPUT TYPE=checkbox NAME="activite26" value="A.26">&nbsp;&nbsp;A.26 : Entretien et nettoyage des locaux
								<td colspan=3  valign=top><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.13">&nbsp;&nbsp;A.13 : Documentation g??n??rale (librairie, abonnement t??l??, etc.)
							   </tr>
							   <tr>
								<td valign=top><INPUT TYPE=checkbox NAME="activite15" value="A.15">&nbsp;&nbsp;A.15 : Activit??s immobili??res (location, etc.)
								<td valign=top colspan=3 ><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.16">&nbsp;&nbsp;A.16 : Am??nagement et construction de b??timents ??? G??nie civil
							   </tr>							   
							   <tr>
								<td valign=top colspan=4><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.14">&nbsp;&nbsp;A.14 : Publications (Annonces, insertions et publicit??s, banderoles, couvertures m??diatiques)
							   </tr>							   
								<td valign=top colspan=4><INPUT TYPE=checkbox NAME="typeactivite[]" value="A.28">&nbsp;&nbsp;A.28 : Travaux divers (petits travaux d?????lectricit??, de plomberie, de r??paration chaises/tables/serrures
							   </tr>						
						</table>

						 </li>	
						 </ol>
						 </fieldset>			
						 <fieldset>
							<legend>COMPTE BANCAIRE N??1</legend>
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
								  <label for=guichet>Code Guichet / Libell?? Compte<span style="color:red;">*</span></label>
								 	<input id=codeguichet1 name=codeguichet1 type=text placeholder="Code Guichet"  required>
								 	<input id=libellecompte1 name=libellecompte1 type=text placeholder="Libell?? Compte"  required>

								</li>
								<li>
								  <label for=compte>Num??ro Compte / Cl?? RIB<span style="color:red;">*</span></label>
								 	<input id=numerocompte1 name=numerocompte1 type=text placeholder="Num??ro Compte"  required>
								 	<input id=clerib1 name=clerib1 type=text placeholder="Cl?? RIB"  required>

								</li>
								<li>
								  <label for=devise>Devise / Code SWIFT/IBAN<span style="color:red;">*</span></label>
								 	<input id=devisecompte1 name=devisecompte1 type=text placeholder="Devise"  required>
								 	<input id=codeswift1 name=codeswift1 type=text placeholder="Code SWIFT/IBAN"  required>
								</li>
								<li>
								  <label for=rib>RIB 1 ou copie ch??que 1 <span style="color:red;">*</span></label>
								<input id=ribfile name=ribfile type=file accept='application/msword, application/pdf' required	>
								</li>		
								</ol>
								 </fieldset>
								 
								  <fieldset>
							<legend>COMPTE BANCAIRE N??2 (Facultatif)</legend>
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
								  <label for=guichet>Code Guichet / Libell?? Compte</label>
								 	<input id=codeguichet2 name=codeguichet2 type=text placeholder="Code Guichet"  >
								 	<input id=libellecompte2 name=libellecompte2 type=text placeholder="Libell?? Compte"  >

								</li>
								<li>
								  <label for=compte>Num??ro Compte / Cl?? RIB</label>
								 	<input id=numerocompte2 name=numerocompte2 type=text placeholder="Num??ro Compte"  >
								 	<input id=clerib2 name=clerib2 type=text placeholder="Cl?? RIB"  >

								</li>
								<li>
								  <label for=devise>Devise / Code SWIFT/IBAN</label>
								 	<input id=devisecompte2 name=devisecompte2 type=text placeholder="Devise"  >
								 	<input id=codeswift2 name=codeswift2 type=text placeholder="Code SWIFT/IBAN"  >
								</li>
								<li>
								  <label for=rib2>RIB 2 ou copie ch??que 2 </label>
								<input id=ribfile2 name=ribfile2 type=file accept='application/msword, application/pdf'>
								</li>		
								</ol>
								 </fieldset>
						 <fieldset>
							<legend>COMPTE BANCAIRE N??3 (Facultatif)</legend>
							<ol>
							  <li>
								  <label for=banque3>Banque / Pays</label>
								  <input id=nombanque3 name=nombanque3 type=text placeholder="Nom Banque">
								  <input id=paysbanque3 name=paysbanque3 type=text placeholder="Code Banque">

							 </li>
								<li>
								  <label for=banque>Code Banque / Agence</label>
								 	<input id=codebanque3 name=codebanque3 type=text placeholder="Code Banque">
								 	<input id=nomagence3 name=nomagence3 type=text placeholder="Nom Agence">

								</li>
								<li>
								  <label for=guichet>Code Guichet / Libell?? Compte</label>
								 	<input id=codeguichet3 name=codeguichet3 type=text placeholder="Code Guichet">
								 	<input id=libellecompte3 name=libellecompte3 type=text placeholder="Libell?? Compte">

								</li>
								<li>
								  <label for=compte>Num??ro Compte / Cl?? RIB</label>
								 	<input id=numerocompte3 name=numerocompte3 type=text placeholder="Num??ro Compte">
								 	<input id=clerib3 name=clerib3 type=text placeholder="Cl?? RIB">

								</li>
								<li>
								  <label for=devise>Devise / Code SWIFT/IBAN</label>
								 	<input id=devisecompte3 name=devisecompte3 type=text placeholder="Devise">
								 	<input id=codeswift3 name=codeswift3 type=text placeholder="Code SWIFT/IBAN">
								</li>
								<li>
								  <label for=rib3>RIB 3 ou copie ch??que 3</label>
								<input id=ribfile3 name=ribfile3 type=file accept='application/msword, application/pdf'>
								</li>		
								</ol>
								 </fieldset>		 
								 
						  <fieldset>
							<legend>PIECES A JOINDRE OBLIGATOIREMENT (Format accept?? : .doc, .docx, .pdf (taille max : 2Mo))</legend>
								              * 1. Photocopie du registre de commerce ou du R??c??piss??/d??cision de cr??ation ou Pi??ce d???Identit?? (CNI ou Passeport)<br>
								              * 2. Photocopie attestation fiscale (pour les soci??t??s)
							<ol>
								<li>
								  <label for=matriculefile>RC / CNI ou Passeport <span style="color:red;">*</span></label>
									<input id=matriculefile name=matriculefile type=file accept='application/msword, application/pdf' required>
								</li>
								<li>
								  <label for=attestationfiscalefile>Attestation Fiscale</label>
									<input id=attestationfiscalefile name=attestationfiscalefile type=file accept='application/msword, application/pdf'>
								</li>
																						
							  </ol>
						  </fieldset>	
						  <div>
							<table align=center><tr><td><button type=submit id="savetiersBut">Enregistrer</button>&nbsp;&nbsp;</td>
							<td><button type=button id="canceltiersBut">Annuler</button>&nbsp;&nbsp;</td></tr></table>
						  </div>
						  </div>
						  
						   
						</form>
							
				
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
