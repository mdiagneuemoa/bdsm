<!DOCTYPE html>
<html lang="fr" manifest="/appcache.manifest">
    <head>
        <meta charset="utf-8"/>
        <title>Mon Assistant en ligne</title>
        
        <link href="styles/site.css" rel="stylesheet" type="text/css" />
        <link href="styles/nav.css" rel="stylesheet" type="text/css" />
        <link href="styles/header.css" rel="stylesheet" type="text/css" />
        <link href="styles/footer.css" rel="stylesheet" type="text/css" />
		<link href="styles/pages/messages.css" rel="stylesheet" type="text/css" />

		<link href="styles/pages/agenda.css" rel="stylesheet" type="text/css" />
        <link href="styles/mobile.css" rel="stylesheet" type="text/css" />
        <link href="styles/print.css" media="print" rel="stylesheet" type="text/css" />
    </head>
    <body>
	        
 <?php
 
require_once ("config/config_inc.php");
require_once (PATH_BEANS."/Message.php");
require_once (PATH_DAO_IMPL."/messageDaoImpl.php");
$numeroclient = $_SESSION['numeroclient'];
$numeroclient = '20120702033';
//$messagedao = new MessageDao();
//$messages = $messagedao->selectMessageDAyByAbonne($numeroclient);
//print_r($messages);
?> 
 <header class="page-header">
             <div class="container">
               	<table width="99%" class="headtab">
					<tbody>
							<tr>
					          <td width="10%" nowrap>
									<img src="images/accueilpapcci.png" alt="SI PREMIUM ACCUEIL " title="SI PREMIUM ACCUEIL" border=0>
								</td>
							<td align="right">			
								Pauline POISONNIER <a href="index.php?module=Users&action=Logout"><img src="images/deconnexion.jpg" alt="deconnexion" title="deconnexion" border=0></a>
							</td>
							</tr>
				</table>
            </div>
        </header>
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
<nav id="menu-onglet">
						<ul>
							<li class="assist"><label class="assist"><img src="images/assistante.jpg" height="30">
								0173023298</label>
							</li>
							<li>
								<a href="agenda.html"><span color="red">Agenda</span><span class="caret"></span></a>
								<div>
									<ul>
										<li><a href="messages.html">Boite de R&eacute;ception</a></li>
										<li><a href="contacts.html">Contacts</a></li>
										<li><a href="parametres.html">Param&egrave;tres</a></li>

									</ul>
								</div>
							</li>
							
						</ul>
					</nav>
				
				
<hr>

<div id="messages">
						<form id="listmessages">
							<div id="messages"><progress id="prog" max=100></div>
						</form>
					</div>


<div id="calendar-wrap" class="box">
	<div id="calendar">
		<h1 id="calendar-title"> </h1>
		<ul id="controls">
			<li class="sep"><a href="#" id="btn-theme">light</a></li>
			<li><a href="#" id="btn-ical">iCal</a></li>
			<li class="sep"><a href="#" id="btn-csv">CSV</a></li>
			<li><a href="#" id="btn-previous">&laquo;</a></li>
			<li><a href="#" id="btn-today">today</a></li>
			<li><a href="#" id="btn-next">&raquo;</a></li>
		</ul>
		<div class="clear"> </div>
		<h3 id="time"> </h3>
		<table id="table">
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
		<div class="clear"> </div>
		<h2 id="stats"></h2>
		<p class="info">
			Click on a date to view events. Use arrow keys to browser the calendar.
		</p>
		<div class="clear"> </div>
	</div>
	<div class="clear"> </div>
</div>

<div id="diary-wrap" class="box">
	<div class="content">
		<a href="#" id="diary-close" class="round">&laquo;</a>
		<h2 id="diary-title">&nbsp;</h2>
		<div class="clear"> </div>
		
		<ul id="diary"></ul>
		<p class="info">Click on a time to add an event</p>
	</div>
</div>

<div id="dialog">
	<a href="#" id="dialog-close" class="round">&times;</a>
	<form id="add" class="target">
		<h2 id="event-date"></h2>
		<p class="time">
			<select id="event-hour"></select>
			<select id="event-minute"></select>
		</p>
		<p>
			<label>Description Rendez-vous</label>
			<input type="text" id="event-description" maxlength="100" />
		</p>
		<div id="event-label">
		</div>
		<p class="buttons">
			<input type="submit" id="event-create" value="ok" class="button" />
			<input type="button" id="event-close" value="cancel" class="button" />
			<input type="button" id="event-delete" value="delete" class="button" />
			<input type="button" id="event-tweet" value="tweet" class="button" />
		</p>
	</form>
	
	<div id="popup-export" class="target">
		<p>Export your calendar to use with Google Calendar, iCal etc.</p>
		<p><em class="mozilla">Rename the file to <span class="filename"></span> after saving</em></p>
		
		<a href="#" class="download">Download <span class="filename"></span></a>
	</div>

</div>
<div class="clear"> </div>
  
 <footer class="page-footer">
            <div class="container">
                <p>
                    &#169; 	2014 PCCI - BU SSII 
                </p>
            </div>
        </footer>
        
	<script src="scripts/pages/jquery.js"></script>
	        <script src="scripts/pages/message.js" type="text/javascript"></script>

	<script src="scripts/pages/agenda.js"></script>    </body>
</html>
