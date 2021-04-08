182
a:4:{s:8:"template";a:3:{s:16:"listeCollabs.tpl";b:1;s:10:"header.tpl";b:1;s:10:"footer.tpl";b:1;}s:9:"timestamp";i:1211905797;s:7:"expires";i:1211909397;s:13:"cache_serials";a:0:{}}<center><table border='1' width='60%' bgcolor='#c0c0c0'>
<tr><td align="center">
<h2>Poste Collaborateurs PCCI</h2>
</td></tr>
</table></center>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />

    <title>Poste Collaborateurs PCCI</title>

    <link rel="StyleSheet" type="text/css" href="css/style.css"/>
    <script type="text/javascript" src="js/modifCollab.js"></script>
     <script type="text/javascript" src="js/util.js"></script>
</head>

<body>
<center>

<form name="form" action="" method="post" >
    
    			<div id="recherche" STYLE="display:none">
					<table class="tableform" cellSpacing="1" cellPadding="2" align="center">
					<caption><h5>Ajout / Recherche Collaborateur</h5></caption>
					<tr>
						<th>Nom</th>
	            		<th>Prénom</th>
	            		<th>Poste</th>
	            		<th>Tél mobile</th>
					</tr>
					<tr>
						<td><input type="text" name="nom" size="15"/></td>
						<td><input type="text" name="prenom" size="15"/></td>
						<td><input type="text" name="poste" size="15"/></td>
						<td><input type="text" name="mobile" size="15"/></td>
					</tr>
					</table>
				</div>	
						<div id="butRech" STYLE="display:none">
							<table>
								<tr>
									<td><input type="submit" name="submit" value="rechercher">&nbsp;&nbsp;&nbsp;
									<input type="button" name="annuler" value="Annuler" onclick="annuler()"></td>
								</tr>
							</table>		
								
						</div>
						<div id="butSave" STYLE="display:none">
							<table>
								<tr>
									<td><input type="submit" name="submit" value="sauvegarder">&nbsp;&nbsp;&nbsp;
										<input type="button" name="annuler" value="Annuler"></td>
								</tr>
							</table>			
						</div>	
						
					
	</form>				

	    	
    <table class="tableform" id="table-utilisateurs">
	
        <tr>
        	<th><img src="images/add.gif" onclick="ajouter()" title="Ajouter un collaborateur"/>&nbsp;
        		<img src="images/loupe.jpg" width="20" height="20" onclick="rechercher();" title="Rechercher collaborateur"/></th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Poste</th>
            <th>Tél mobile</th>
        
        </tr>
		        
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIAGNE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Meissa
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3272
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    774430230
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIONGUE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Seynabou
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3208
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    GUEYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Mor Codou
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3271
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    KIBANGOU
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Mpela
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3090
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    MENDY
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Benoit
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3092
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    GUEYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Malick
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3229
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    NDIONE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Babacar
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3066
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    NIASSE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Baye
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3094
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIACK
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Daouda
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3065
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIAGNE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Mamadou
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3269
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIONGUE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Magib
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    MBAYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Magatte
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3273
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    NDIAYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Assane
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3270
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    NDOYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Abdoulaye
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    GUEYE N°2
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Babacar
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    GUEYE N°3
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Babacar
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    SECK
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Bamba
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3722
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    WANE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Mamadou
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIEYE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Ndeye Khady
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIOP
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Mame Diarra
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3719
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    KEBE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Makébe
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3715
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIA
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Alioune
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3713
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    MBOUP
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Ibrahima
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    0000
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    SENE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Ibrahima
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIAKHATE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Khady
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    DIOUF
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Bamba
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3016
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    BASSOUM
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Malick
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    -
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    WONE
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Abdourahmane
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3260
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    AGNE ADMIN RESEAU
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Al ousseynou
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3043
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#d0d0d0">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    Aminata & sarah compta
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Aminata & sarah
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3015
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
             
            <tr bgcolor="#eeeeee">
            	<td><img src="images/remove.gif" onclick="supprimer()" title="Supprimer collaborateur"/>&nbsp;
            		<img src="images/edit.gif" onclick="modifier()" title="Modifier collaborateur"/></td>
                <td class="cellule" ondblclick="inlineMod(, this, 'nom', 'texte')">
                    GNING
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'prenom', 'texte')">
                    Serigne
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'poste', 'texte')">
                    3067
                </td>

                <td class="cellule" ondblclick="inlineMod(, this, 'mobile', 'texte')">
                    -
                </td>
                
            </tr>
     		<tr><td colspan="5" align="left"><font size="2" color="blue">Il y eu 31 collaborateurs d'affichés.</font></td></tr>
    </table>
</center>
</body>
</html>






<center><table border='0' width='60%'>
<tr><td align="center">
<h5>@Meissa DIAGNE Mai 2008</h5>
</td></tr>
</table></center>