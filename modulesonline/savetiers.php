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
               	<table width="99%">
					<tbody>
							<tr>
					          <td width="20%" nowrap>
									<a href="tiers.php"><img src="images/logo_uemoa.png" height=50 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0></a>
								</td>
							<td align="center" class="titrehead">			
								COLLECTE  DE DONNEES TIERS (RH)
							</td>
							
							 <td width="20%" align=right>
									<img src="images/cauri.png" height=65 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0>
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

$tiersdao = new TiersDao();
if($tiersdao->verifExistMatricule($_REQUEST['matricule'])==1)
{
	$tiers = $tiersdao->updateTiers($_REQUEST);
}
else
{
	$tiers = $tiersdao->saveTiers($_REQUEST);
}
	
//echo $tiers;
//echo "Bonjour ",$tiers['nom']," ",$tiers['prenom'];
?> 		

       <div id="divContainer" align=center>
      
 
					<div id="form-addcontact">
						<form id="candidatform" action="savetiers.php" method=post>
						  <fieldset>
									* Vos informations ont été enregistrées avec succès!!!!

						  </fieldset>	
						 
							
					
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
