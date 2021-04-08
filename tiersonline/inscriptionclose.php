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

      <header class="page-header">
             <div class="container">
               	<table width="95%">
					<tbody>
							<tr>
					          <td width="10%" nowrap>
									<img src="images/logo_uemoa.png" height=50 alt="COLLECTE DE DONNEES RH " title="COLLECTE DE DONNEES RH" border=0>
								</td>
							<td align="center" class="titrehead">			
								CANDIDATURE POUR LA PRESELECTION AU SOUTIEN A LA FORMATION <br>ET A LA RECHERCHE DE L'EXCELLENCE EDITION  2017-2018
							<marquee direction="left" color="red"><font color="red">Dernier délai pour les inscriptions le 30 Mai 2017 à 18h00.</font></MARQUEE>
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
      
 
					<div id="form-addcontact" align=center>
						<form id="candidatform" action="savetiers.php" method=post enctype="multipart/form-data">
						  <input id=tiersid name=tiersid type=hidden>
						
						<div align=right>
						 <a href="http://localhost/portailweb/bourseonline.php"><img src="images/accesdossier.jpg"border=0 title="Si D&eacute;j&agrave; inscrit ? acc&eacute;der à votre dossier"></a>

						</div><br><br>
						<div class="inscriptionclose">Les inscriptions à la demande de bourse l'excellence UEMOA Session 2017 - 2018 sont closes.
						<br>La date limite de dépot des candidatures était fixée au 30 Mai 2017 à 18h00.<br> Si vous êtiez déjà inscrit vous pouvez suivre votre dossier via lien "accéder à votre compte" ci-dessus. </div>
				

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
