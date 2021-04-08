<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>PORTAIL FOURNISSEUR UEMOA</title>
        
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
             <div style=" background-color :#27AE60;">
               	<table width="80%" align=center>
					
							<tr>
					          <td width="20%" valign=middle><img src="images/logo_uemoa.png" height=50 border=0></td>
							<td align="left" valign=middle nowrap><span style="font-size: 22px;text-decoration:none;color:white;vertical-align:middle;">Union Economique et Mon&eacute;taire Ouest Africaine</span><br>
								<span style="font-size: 25px;text-decoration:none;color:#154360;vertical-align:middle;">Portail Tiers & Fournisseurs de l’UEMOA</span></td>
							</tr>
							
							<tr><td colspan=2 align=right>
									Si D&eacute;j&agrave; inscrit ? <a href="/portailweb/tiersonline.php">acc&eacute;der à votre dossier >></a>
								</td></tr>
				</table>
            </div>
        </header>
 <?php
 
require_once ("config/config_inc.php");
require_once (PATH_BEANS."/tiers.php");
require_once (PATH_DAO_IMPL."/tiersDaoImpl.php");


?> 	<br>	
	<div id="accueilid" class="hello" align=left></div>
       <div id="divContainer">
      
 
					<div id="form-addcontact">
						<form id="candidatform" action="savefournisseurs.php" method=post enctype="multipart/form-data">
						  <input id=tiersid name=tiersid type=hidden>
							  <div align=center style="font-size: 20px; color :#27AE60;">Inscription à la base des fournisseurs de  la Commission de l’UEMOA</div>
							  <div><br>
						  <fieldset>
							<legend>IDENTIFICATION (INFORMATIONS FOURNISSEUR)</legend>
									<span style=" color :red;"> ATTENTION !!! : Cette inscription est une première étape de votre processus d'enregistrement comme fournisseur.
									Une fois inscrit, vous recevrez vos identifiants de connexion au portail. Vous devrez alors obligatoirement vous connecter au portail pour accéder à votre dossier, compléter vos informations et 
									valider votre enregistrement sur le régistre des fournisseurs.</span>

							<ol>
							 <li>
								<label for=identifiantuemoa>N°Identification(IFU,NINEA,...) <span style="color:red;">*</span></label>
								<input id=identificationfiscale name=identificationfiscale type=text placeholder="N° IFU,NINEA,..." required>
								<input id=identifiant name=identifiant type=text readonly=true placeholder="N° Identifiant UEMOA" required>

							  </li>
							 <li>
								<label for=identifiantuemoa>Nom Prénom(s)/Raison Sociale<span style="color:red;">*</span></label>
								<input id=raisonsociale name=raisonsociale type=text  required>
								<input id=initiales name=initiales type=text placeholder="Initiales (Sigle)">

							  </li>
							  
							  
							  <li>
								<label for=identifiantuemoa>N° Matricule/Date Création<span style="color:red;">*</span></label>
								<input id=nummatricule name=nummatricule type=text placeholder="N° RC / N° Matricule / N° Pièce d'Identité"  required>
								<input id=datenaissance name=datenaissance type=date  required>

							  </li>
							  <li>
								  <label for=adressebur>Adresse <span style="color:red;">*</span></label>
								  <textarea id=adresse name=adresse rows=3 placeholder="Adresse principale" required></textarea>
								  <textarea id=complementadresse name=complementadresse rows=3 placeholder="complément d'adresse" ></textarea>

								</li>
							  
							   <li>
								<label for=telentreprise>Téléphone Portable<span style="color:red;">*</span>/ Fixe</label>
								<input id=portable name=portable type=tel placeholder="par ex&nbsp;: +22665866370"  required>
								<input id=telephonefixe name=telephonefixe type=tel placeholder="par ex&nbsp;: +22625866370"  >
							</li>
							
							   <li>
								<label for=emailentreprise>Email<span style="color:red;">*</span></label>
								<input id=email name=email type=email placeholder="exemple@uemoa.int" required>
								<input id=email2 name=email2 type=text placeholder="resaisir votre email" >
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
