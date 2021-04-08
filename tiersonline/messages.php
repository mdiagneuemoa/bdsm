<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Mon Assistant en ligne</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
        
        <link href="styles/pages/messages.css" rel="stylesheet" type="text/css" />
		<link href="styles/modal.css" rel="stylesheet" type="text/css" />

        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>
        
         
        
        <header class="page-header">
            <div class="container">
               	<table width="100%">
					<tbody>
							<tr>
					          <td nowrap>
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
require_once (PATH_BEANS."/Message.php");
require_once (PATH_DAO_IMPL."/messageDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
$messagedao = new MessageDao();
$messages = $messagedao->selectMessageDAyByAbonne($numeroclient);
$categories = $messagedao->selectFolderByAbonne($numeroclient,$messages);

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
								<a href="messages.html">Messages<span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="messages.php">Contacts</a></li>
										<li><a href="agenda.html">Agenda</a></li>
										<li><a href="parametres.php">Param&egrave;tres</a></li>

									</ul>
								</div>
							</li>
	
							<li>
								<a href="products.html"><img src="images/checkbox.gif"><span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="#" id="checkAll">Tous</a></li>
										<li><a href="#" id="UncheckAll">Aucun</a></li>
										<li><a href="#" id="checkNews">Non Lus</a></li>
										<li><a href="#" id="checkUrgents">Urgents</a></li>
									</ul>
								</div>
							</li>
							<li><a href="about.html"><img src="images/delete.gif"></a></li>
							<li><a href="about.html"><img src="images/dossier-ferme.gif"><span class="caret"></span></a>
							<div>
									<ul>
										<?php
												foreach ($categories as $key => $cat ) 
												{
													if ($key!=0 and $key!=1 and $key!=2 )
													echo "<li><a href='#nogo'>".changeAccented($cat['foldername'])."</a></li>";
												}
										?>
								</ul>
								</div>
							</li>
							<li><a href="about.html">plus<span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="#join_form" id="join_pop">Nouveau Dossier</a></li>
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
 
				<table width="98%">
				<tr>
					<td valign=top width="180">
						<nav id="menu-side">
							<a href='#' id="mesmessages">Boite de r&eacute;ception (<?php echo count($messages);?>)</a>
							<p class="titre"><?php echo '<a href="#" onclick="showMessages(\''.$categories[0]['folderid'].'\');">'.$categories[0]['foldername'].'('.$categories[0]['nb'].')';?></p>
							<p class="titre"><?php echo '<a href="#" onclick="showMessages(\''.$categories[1]['folderid'].'\');">'.$categories[1]['foldername'].'('.$categories[1]['nb'].')';?></p>
							<p class="titre"><?php echo '<a href="#" onclick="showMessages(\''.$categories[2]['ifolderidd'].'\');">'.$categories[2]['foldername'].'('.$categories[2]['nb'].')';?></p>
							<p class="titre">Cercles(2)</p>
								<ul>
									<?php
									foreach ($categories as $key => $cat ) 
									{
										if ($key!=0 and $key!=1 and $key!=2 )
										echo '<li><a href="#" onclick="showMessages(\''.$cat['folderid'].'\');">'.changeAccented($cat['foldername']).'('.$cat['nb'].')</a></li>';

									}
									?>
								</ul>
								<p class="titre"><a href="#join_form" id="join_pop">Nouveau Dossier</a><p>
							</nav>
					</td>	
					<td valign=top>	
					<div id="messagesdiv">
						<form id="listmessages">
							<div id="messages"><progress id="prog" max=100></div>
						</form>
					</div>
				</td>
				</tr>
			</table>
	
    </div>
	 </div>
	 <!-- popup form #2 -->
        <a href="#x" class="overlay" id="join_form"></a>
        <div class="popup">
            <h2>Ajout dossier</h2>
            <div>
                <label for="email">Entrez un nouveau dossier :</label><br>
                <input type="text" id="email" value="" />
            </div>
            <div>
                <input type="checkbox" name="checkbox1" value="checkbox">
				<label for="pass">Imbriquer le dossier sous :</label><br>
                <select name="catparent" >
					<option>Famille</option>
					<option>Collegues</option>
					<option>Amies</option>
				</select>
            </div>
            
            <input type="button" value="Cr&eacute;er" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Annuler" />

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
        <script src="scripts/pages/message.js" type="text/javascript"></script>
    </body>
</html>
