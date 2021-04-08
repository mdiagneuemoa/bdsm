/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
var listcomptenat = Array[50]; 
function getCompteNatByBudget()
{
	var codebudget=document.getElementById("codebudget").options[document.getElementById("codebudget").selectedIndex].value;
	var sourcefin=document.getElementById("sourcefin").options[document.getElementById("sourcefin").selectedIndex].value;
	
	InitLigneDepense();
	//alert("codebudget="+codebudget);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Reunion&action=ReunionAjax&mode=ajax&file=ReunionUtils&requete=getCompteNatByBudget&codebudget='+codebudget+'&sourcefin='+sourcefin,
				onComplete: function(response) {
				comptnats= JSON.parse(response.responseText);
				//alert("rep="+response.responseText);
				var html = '';
				var comptnat = Array[2];
				var nbcn = 0;
				for(var i=0;i<comptnats.length;i++)
				{
					var comptnat = comptnats[i].split('::');
					var ctn = comptnat[1];
					//ajouterLigneDepense(comptnat[0]+' ('+comptnat[1]+')');
					ajouterLigneDepense(comptnats[i]);
					ajouterLigneDepenseHeader(ctn);	
					ajouterLigneDepenseElt(ctn);
					nbcn = nbcn +1;
				}
				document.getElementById("nbnatdepense").value=nbcn;
				tableau = document.getElementById("naturesdepense");
				var codebudg =document.getElementById("codebudget").options[document.getElementById("codebudget").selectedIndex].text;
				var textcodebudg=codebudg.split("(");
				document.getElementById("objet").value=textcodebudg[1];
				//ajouterLigneTotal(tableau);
			}
			}	
	);
	
	
}

function InitLigneDepense()
{
		
	var element = document.getElementById("naturesdepense");
	while (element.firstChild) {
	  element.removeChild(element.firstChild);
	}
						
}

function ajouterLigneDepense(natdepense)
{
	//alert("testtt");
	var tableau = document.getElementById("naturesdepense");
	var nbrows = tableau.rows.length;
	comptnat = natdepense.split('::');
	TRANSPORT="- Cout transport a\351rien estim\351 par l'UMV \r - Cout transport par la route (location v\351hicule) : 150.000FCFA pour trajet Cotonou-Lom\351, aller/retour \r - Cout transport par la route des Experts : Forfait 25.000FCFA \r - Cout transport de l'Aéroport international Blaise Diagne de Diass à Dakar, Aller/retour : Forfait 25.000FCFA";
	PERDIUM_HEBERGEMENT=" * Indemnit\351 de session des Ministres : \r   - R\351unions de Ministres Sectorielles : 600.000FCFA par Ministre \r   - R\351unions du Conseil des Ministres Statutaires : 1.500.000FCFA par Ministre \r * Perdium et H\351bergement des Experts : \r   - 50.000FCFA/J pour les Experts sectoriels \r   - 500.000FCFA a titre d'indemnit\351 de session pour les Experts Statutaires \r   - 75.000FCFA pour la période de la réunion pour chacun des deux (02) rapporteurs \r - Président Sous-comité chargé de l’examen du rapport semestriel de la surveillance multilatérale, Comité des Experts Statutaire : Forfait 80.000FCFA \r - Rapport(s) Sous-comité chargé de l’examen du rapport semestriel de la surveillance multilatérale, Comité des Experts Statutaire : Forfait 60.000FCFA \r - 70.000FCFA par nuit\351e pour les Experts non-r\351sidents \r   - 40.000FCFA par nuit\351e pour les Experts en transit Routing \351tabli par UMV) \r * Cas des ateliers ou des s\351minaires nationaux :\r   - 25.000FCFA par jour pour les experts \r   - 70.000FCFA par nuit\351e pour les Experts non-r\351sidents \r   - 25.000FCFA pour les experts vant de l'int\351rieur du pays";
	PAUSE_CAFE = " * Pause-caf\351 : \r   - r\351unions minist\351rielles : 6.000FCFA par personne \r   - autres r\351unions : 3.000FCFA par personne \r * Bouteille d'eau : 500FCFA par personne (1.000FCFA matin/soir) \r * Cocktail : \r   - r\351unions de Ministres sectorielles : 12.500FCFA l'unit\351 \r   - r\351unions d'Experts sectorielles (pr\351c\351dents imm\351diatement les r\351unions de Ministres sectorielles) : 7.500FCFA l'unit\351 \r * Cout d\351jeuner : \r - r\351unions des Ministres : 25.000FCFA par repas \r   - r\351unions des Experts Statutaires : 12.000FCFA par repas";
	LOCATION_VEHICULE = " - Pour le Pr\351sident de la Commission : 110.000FCFA par jour \r - Membres d'Organes : 66.000FCFA par jour \r - Ministres (un v\351hicule par Etat) : 66.000FCFA par jour \r - V\351hicules de liaison : 55.000FCFA par jour \r - V\351hicules Président du Comité des Experts Statutaire (Hors Burkina Faso) : 55.000FCFA par jour \r - Bus pour les r\351unions au Complexe administratid de Ouaga 2000 : 100.000FCFA par jour";
	LOCATION_SALLE = " -  350.000FCFA salles de r\351unions sonoris\351es (pour r\351union minist\351rielle) \r - 300.000FCFA pour salles de r\351unions sonoris\351es de plus 50 places \r - 200.000FCFA pour salles de r\351unions sonoris\351es de moins de 50 places \r - 50.000FCFA pour salle de secr\351tariat (r\351unions d'Experts sectorielles et r\351unions des Ministres)  ";
	LOCATION_MATERIELS = " -  100.000FCFA pour l'ensemble des mat\351riels (copieur+encre, micro-ordinateur, imprimante+encre, vid\351oprojecteur, etc.)  ",
	FOURNITURES_BUREAU = " -  150.000FCFA pour l'ensemble des fournitures de bureau  ",
	CHARGE_PUB = " -  75.000FCFA pour les banderoles, badges, macarons et autres publicit\351es ";
	PUB_COUVERTURE_MEDIA = " - 700.000FCFA max pour couverture m\351diatique (Presse \351crite, t\351l\351vision(pour r\351unions minist\351rielles) et radio) (R\351unions de rang minist\351riel uniquement) ";
	CARBURANT = " -  20 litres/jour pour v\351hicules des Ministres et des Membres d'Organes \r - 15 litres/jour pour les v\351hicules de liaison";
	GRATIFICATION = " -  50.000FCFA pour personnel d'appui (r\351unions des Ministres) \r - 5.000FCFA par jour et par chauffeur de v\351hicule lou\351. \r - 20.000 FCFA pour les bagagistes (R\351unions de rang minist\351riel uniquement) ";
	DELEGATION_COMMISSION = " * r\351unions du Conseil des Ministres Statutaires, hors sessions budgr\351taires : 13 particpants \r   - le Pr\351sident de la Commission et 03 membres d'Organes, \r   - 09 agents, dont un agent du protocole, \r   - 01 agent de liaison et la secr\351taire du Conseil \r pour les r\351unions de Ministres Sectorielles : 04 participants \r   - 01 membre d'Organe \r - 02 cadres et 01 secr\351taire ";
	FRETE_ADMIN = " ";
		
	//ajouterLigneEntete(tableau);
	var ligne = tableau.insertRow(-1);//on a ajouté une ligne
	ligne.bgColor='#ddddcc';
	var colonne1 = ligne.insertCell(0);//on a une ajouté une cellule
	colonne1.colSpan =5;
	var textinfo = '';
	//colone1.style='detailedViewHeader';
	if (comptnat[1]=='605510')
		textinfo=FOURNITURES_BUREAU;	// Fournitures de bureau
	if (comptnat[1]=='618100')
			textinfo=TRANSPORT;	// Transport pour missions et réunions
	if (comptnat[1]=='622230')
			textinfo=LOCATION_SALLE;	// Locations de salles
	if (comptnat[1]=='622320')
			textinfo=LOCATION_VEHICULE;	// Locations de véhicules

	if (comptnat[1]=='627810')
			textinfo=PUB_COUVERTURE_MEDIA;	// Couvertures médiatiques
	if (comptnat[1]=='627820')
			textinfo=CHARGE_PUB;	// Autres charges de publicité (Banderoles, Badges, macarons, )
	if (comptnat[1]=='638320')
			textinfo=PAUSE_CAFE;	// Pause café
	if (comptnat[1]=='638400')
			textinfo=PERDIUM_HEBERGEMENT;	// Frais de mission (Perdiem et hébergement)

	if (comptnat[1]=='658100')
			textinfo=GRATIFICATION; 	// Gratifications
	if (comptnat[1]=='605310')
			textinfo=CARBURANT;	// Carburant et lubrifiants

	if (comptnat[1]=='622310')
			textinfo=LOCATION_MATERIELS;	// Locations de matériels	
	
	if (comptnat[1]=='616200')
			textinfo=FRETE_ADMIN;	// Frete Administratif
			
	colonne1.innerHTML += '<a href="#" alt="'+textinfo+'" title="'+textinfo+'"><img src="themes/images/iconeinfo.png" ></a>&nbsp;&nbsp;<b>'+comptnat[0]+' ('+comptnat[1]+')'+'</b>';
	
	//var colonne2 = ligne.insertCell(1);//on a une ajouté une cellule
	//colonne2.innerHTML += '<b>Montant Disponible</b>';
	
	var colonne3 = ligne.insertCell(1);//on a une ajouté une cellule
	colonne3.innerHTML += '<b>Montant Disponible : '+comptnat[2]+' FCFA</b>';
	
	tableau.innerHTML += '<input type="hidden" name="natdepense_'+nbrows+'" id="natdepense_'+nbrows+'" value="'+comptnat[1]+'">';
						
}
function ajouterLigneEntete(tableau)
{
	//alert("testtt");

	var ligne = tableau.insertRow(-1);//on a ajouté une ligne

	var colonne1 = ligne.insertCell(0);//on a une ajouté une cellule
	colonne1.innerHTML += '<b>LIBELLE</b>';
	colonne1.style.color='#ddddcc';


	var colonne2 = ligne.insertCell(1);//on ajoute la seconde cellule;
	colonne2.innerHTML += '<b>QUANTITE</b>';
	colonne2.style.color='#ddddcc';


	var date = new Date();
	var colonne3 = ligne.insertCell(2);
	colonne3.innerHTML += '<b>NOMBRE</b>';
	colonne3.style.color='#ddddcc';


	var colonne4 = ligne.insertCell(3);
	colonne4.innerHTML += '<b>PRIX UNITAIRE</b>';
	colonne4.style.color='#ddddcc';


	var colonne5 = ligne.insertCell(4);
	colonne5.innerHTML += '<b>TOTAL (FCFA)</b>';
	colonne5.style.color='#ddddcc';
	
	var colonne6 = ligne.insertCell(5);
	colonne6.innerHTML += '&nbsp;';
	colonne6.style.color='#ddddcc';
		
	
						
}
function ajouterLigneTotal(tableau)
{
	//alert("testtt");

	var ligne = tableau.insertRow(-1);//on a ajouté une ligne

	var colonne1 = ligne.insertCell(0);//on a une ajouté une cellule
	colonne1.innerHTML += '<b>BUDGET TOTAL DE L\'ACTIVITE</b>';
	ligne.bgColor='#ddddcc';	
	colonne1.colSpan =4;

	var colonne2 = ligne.insertCell(1);//on ajoute la seconde cellule;
	colonne2.innerHTML += '<input type="text" name="budgettotal" id="budgettotal"  value=0 size=20>';
	colonne2.style.color='#ddddcc';
						
}
function ajouterLigneDepenseHeader(i)
{
	var tableau = document.getElementById("naturesdepense");
	var ligne2 = tableau.insertRow(-1);//on a ajouté une ligne
	ligne2.bgColor='#fafafa';
	var colonne1 = ligne2.insertCell(0);//on a une ajouté une cellule
	colonne1.colSpan =6;
	colonne1.innerHTML += '<table width=95% border=1 id="naturesdepense_'+i+'">';
}
function ajouterLigneDepenseElt(i)
{
	//alert("testtt");
	var tabid='naturesdepense_'+i;
	var tableau = document.getElementById(tabid);
	var ligne = tableau.insertRow(-1);//on a ajouté une ligne
	var nbrows = tableau.rows.length;

	var colonne1 = ligne.insertCell(0);//on a une ajouté une cellule
	colonne1.innerHTML += '<input type="text" name="'+tabid+'_lib_'+nbrows+'" id="'+tabid+'_lib_'+nbrows+'" placeholder="libell&eacute;" tabindex="{$vt_tab}" size=70>';


	var colonne2 = ligne.insertCell(1);//on ajoute la seconde cellule;
	colonne2.innerHTML += '<input type="text" name="'+tabid+'_qte_'+nbrows+'" id="'+tabid+'_qte_'+nbrows+'" onmouseout="calculTotalDepense('+i+','+nbrows+')" placeholder="Quantit&eacute;" tabindex="{$vt_tab}"size=10>';


	var date = new Date();
	var colonne3 = ligne.insertCell(2);
	colonne3.innerHTML += '<input type="text" name="'+tabid+'_nb_'+nbrows+'" id="'+tabid+'_nb_'+nbrows+'" onmouseout="calculTotalDepense('+i+','+nbrows+')" placeholder="Nombre" tabindex="{$vt_tab}"size=10>';


	var colonne4 = ligne.insertCell(3);
	colonne4.innerHTML += '<input type="text" name="'+tabid+'_pu_'+nbrows+'" id="'+tabid+'_pu_'+nbrows+'" onmouseout="calculTotalDepense('+i+','+nbrows+')" placeholder="Prix Unitaire" tabindex="{$vt_tab}" size=20>';


	var colonne5 = ligne.insertCell(4);
	colonne5.innerHTML += '<input type="text" name="'+tabid+'_pt_'+nbrows+'" id="'+tabid+'_pt_'+nbrows+'" placeholder="Prix Total" tabindex="{$vt_tab}" style="text-align: right;"  size=20>';
	
	var colonne6 = ligne.insertCell(5);
	if (tableau.rows.length==1)
		colonne6.innerHTML += '<a href="javascript:;" onClick="ajouterLigneDepenseElt('+i+');"><img src="modules/Reunion/rowadd.gif" titre="Ajouter une ligne de dépense"></a>';
	else
		colonne6.innerHTML += '<a href="javascript:;" onClick="supLigneDepenseElt('+i+','+nbrows+');"><img src="modules/Reunion/rowdelete.gif" titre="Suprimer cette ligne de dépense"></a>';
									
}

function calculTotalDepense(i,l)
{
	//alert("testtt");
	var tabid='naturesdepense_'+i;
	var tableau = document.getElementById(tabid);
	//var som = document.getElementById('budgettotal').value;
	var qte = document.getElementById(tabid+'_qte_'+l).value;
	var nb = document.getElementById(tabid+'_nb_'+l).value;
	var pu = document.getElementById(tabid+'_pu_'+l).value;
	document.getElementById(tabid+'_pt_'+l).innerHTML = qte*nb*pu;
	document.getElementById(tabid+'_pt_'+l).value = qte*nb*pu;
	//som = som+(qte*nb*pu);
	//document.getElementById('budgettotal').value = som;
	//document.getElementById('budgettotal').innerHTML = som;
	//document.getElementById('budgettotal').innerHTML = "FFFFFF";
	
	//var tableau2 = document.getElementById("naturesdepense");	
	//var nbrows = tableau2.rows.length;
}

function supLigneDepenseElt(i,nbrows)
{
	//alert("testtt"+i+' - '+nbrows);
	var tabid='naturesdepense_'+i;
	var tableau = document.getElementById(tabid);
	/*document.getElementById(tabid+'_lib_'+nbrows).value="";
	document.getElementById(tabid+'_qte_'+nbrows).value="";
	document.getElementById(tabid+'_nb_'+nbrows).value="";
	document.getElementById(tabid+'_pu_'+nbrows).value="";
	document.getElementById(tabid+'_pt_'+nbrows).value="";*/
	var ligne = tableau.deleteRow(nbrows-1);//on a supprimé une ligne
}	

function soumettreReunion(module) {
	var msg;
	//alert("RRRRRRR");	
	
	if (module == 'Reunion')
		msg = "Voulez-vous soumettre cette demande \340 votre DC?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function remettreReunionEnPrepa(module) {
	var msg;
	if (module == 'Reunion')
		msg = "Voulez-vous remettre cette demande de r\351union en pr\351paration?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function RejeterReunion(module) {
	var msg;
		
	if (module == 'Reunion')
		msg = "Voulez-vous rejeter cette demande de r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function AnnulerReunion(module) {
	var msg;
		
	if (module == 'Reunion')
		msg = "Voulez-vous annuler cette r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function ViserReunion(module) {
	var msg;
	
	if (module == 'Reunion')
		msg = "Voulez-vous accepter cette r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function goengagement(reunionid)
{
	if(confirm("Etes-vous sur de vouloir cr\351er l'engagement?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Reunion&action=ReunionAjax&mode=ajax&file=CreateEngagement&record='+reunionid,
					onComplete: function(response) {
					resp= response.responseText;
					alert(resp);
					//location.reload();
					}
				}	
		);
	}
	else	
	{
		return false;
	}
}


function SaisirDecision() {
	var msg;
	document.getElementById('divdecision').style.display= 'block';
	document.getElementById('regisseur').focus();
	
}
/*
function JoindreDocuments() {
	var msg;
	document.getElementById('divdocuments').style.display= 'block';
	//document.getElementById('regisseur').focus();
	
}
*/
function AnnulerDecision() {
	var msg;
	document.getElementById('divdecision').style.display= 'none';

}

function AddSignataire() {
	var msg;
	document.getElementById('divsignataire').style.display= 'block';
	document.getElementById('timbredc').focus();

}
function AnnulerSignataire() {
	var msg;
	document.getElementById('divsignataire').style.display= 'none';

}
function ModifierSignataire() {
	var msg;
	document.getElementById('divsignataire').style.display= 'none';
	document.getElementById('modifdivsignataire').style.display= 'block';

}
function saveDecision(reunionid) {
	var msg;
	var regisseur = document.getElementById('regisseur').options[document.getElementById('regisseur').selectedIndex].value;
	
		if (regisseur=='' )
		{
			alert("Veillez choisir un r\351gisseur!!!");
			return false;
		}
		msg = "Voulez-vous enregistrer les informations saisies";
	
	if(confirm(msg)) {
	
		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Reunion&action=ReunionAjax&mode=ajax&file=ReunionUtils&requete=saveDecision&parenttab=Activites&reunionid='+reunionid+'&regisseur='+regisseur,
					onComplete: function(response) {
					resp= response.responseText;
					//alert("reunionid = "+resp);
					location.reload();
					
					}
				}	
		);
	
	
	}
 	else {
		return false;
 	}
}
function saveSignataire(reunionid) {
	var msg;
	var signatairedc = document.getElementById('signatairedc').options[document.getElementById('signatairedc').selectedIndex].value;
	var timbredc = document.getElementById('timbredc').options[document.getElementById('timbredc').selectedIndex].value;
	var signatairecom = document.getElementById('signatairecom').options[document.getElementById('signatairecom').selectedIndex].value;
	var timbrecom = document.getElementById('timbrecom').options[document.getElementById('timbrecom').selectedIndex].value;
	if (signatairedc=='' )
	{
		alert("Veillez choisir un signataire DC!!!");
		return false;
	}
	if (timbredc=='' )
	{
		alert("Veillez choisir un timbre DC!!!");
		return false;
	}
	if (signatairecom=='' )
	{
		alert("Veillez choisir un signataire Commissaire!!!");
		return false;
	}
	if (timbrecom=='' )
	{
		alert("Veillez choisir un timbre Commissaire!!!");
		return false;
	}	
	
		msg = "Voulez-vous enregistrer les informations saisies";
	
	if(confirm(msg)) {
	
		var infossignataires = {timbredc: timbredc, signatairedc: signatairedc, timbrecom: timbrecom, signatairecom: signatairecom};
		var jsoninfossignataires = JSON.stringify(infossignataires);
		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Reunion&action=ReunionAjax&mode=ajax&file=ReunionUtils&requete=savemodifSignataire&parenttab=Demandes&reunionid='+reunionid+'&jsoninfossignataires='+jsoninfossignataires,
					onComplete: function(response) {
					resp= response.responseText;
					//alert("reunionid = "+resp);
					location.reload();
					
					}
				}	
		);
	}
 	else {
		return false;
 	}
}

function gererdepenses()
{
	document.getElementById('createengagementdepenses').style.display= 'none';
	document.getElementById('editengagementdepenses').style.display= 'block';

	
}
function cancelgererdepenses()
{
	location.reload();
	
}
function saveDepenseaengager()
{
	
	if (module == 'Reunion')
		msg = "Voulez-vous enregistrer les d\351penses a engager";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
	
}
function creerEngagementReunion()
{
	
	if (module == 'Reunion')
		msg = "Etes-vous sur de vouloir cr\351er l'engagement pour cette r\351union";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
	
}
function checkline_object(obj,montant)
{
	//alert("test");
	var line = document.getElementById("row_"+obj);
	var butch = document.getElementById(obj);
	if (butch.checked == true)
	{
		line.style.backgroundColor  = "#808080";
		document.getElementById('tmontantaengage').value = parseInt(document.getElementById('tmontantaengage').value) - parseInt(montant);
	}
	else
	{
		line.style.backgroundColor  = "white";
		document.getElementById('tmontantaengage').value = parseInt(document.getElementById('tmontantaengage').value) + parseInt(montant);
	}
}

function goengagementreunion(reunionid)
{
	if(confirm("Etes-vous sur de vouloir cr\351er l'engagement pour cette r\351union"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Reunion&action=ReunionAjax&mode=ajax&file=CreateEngagement&record='+reunionid,
					onComplete: function(response) {
					resp= response.responseText;
					alert(resp);
					location.reload();
					}
				}	
		);
	}
	else	
	{
		return false;
	}
}