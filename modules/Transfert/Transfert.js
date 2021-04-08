/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
var listcomptenat = Array[50]; 
 
function clearselect(idnumrow)
{
	var select = document.getElementById(idnumrow);
	var length = select.options.length;
	for (i = 1; i < length; i++) {
	  select.options[i] = null;
}
}
function getSelectCompteNatByBudget(sens,numrow)
{
	var codebudget=document.getElementById(sens+'_codebudget_'+numrow).options[document.getElementById(sens+'_codebudget_'+numrow).selectedIndex].value;
	//alert("rep="+codebudget);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=TransfertUtils&requete=getCompteNatByBudget&codebudget='+codebudget,
				onComplete: function(response) 
				{
					comptnats= JSON.parse(response.responseText);
					//alert("rep="+response.responseText);
					var html = '';
					var comptnat = Array[2];
					var nbcn = 0;
					clearselect(sens+'_comptenat_'+numrow);
					for(var i=0;i<comptnats.length;i++)
					{
						var comptnat = comptnats[i].split('::');
						var ctn = comptnat[1];
						document.getElementById(sens+'_comptenat_'+numrow).options[i+1] = new Option(comptnat[1]+' ('+comptnat[0] +')',comptnat[1]);
					
					}
			
				}
			}	
	);
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


function getDispoByCompteNat(sens,nbrows)
{
		//alert("rep="+codebudget);
		codebudget = document.getElementById(sens+'_codebudget_'+nbrows).options[document.getElementById(sens+'_codebudget_'+nbrows).selectedIndex].value;
		comptenat = document.getElementById(sens+'_comptenat_'+nbrows).options[document.getElementById(sens+'_comptenat_'+nbrows).selectedIndex].value;
		//alert("codebudget="+codebudget+ '   comptenat='+comptenat);
	
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=TransfertUtils&requete=getDispoByCompteNat&codebudget='+codebudget+'&comptenat='+comptenat,
				onComplete: function(response) 
				{
					mntdispo= response.responseText;
					//alert("rep="+mntdispo);
					document.getElementById(sens+'_mntdispo_'+nbrows).innerHTML = mntdispo;
					
				}
			}	
	);
}
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
				postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=TransfertUtils&requete=getCompteNatByBudget&codebudget='+codebudget+'&sourcefin='+sourcefin,
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
function calculSommeDebit()
{
	//alert("testtt");
	var curmontant=0;
	var totaldeptransfert=0;
	for(var i=0;i<10;i++)
	{
		curmontant = document.getElementById('debit_montant_'+i).value;
		if (curmontant!=0 && curmontant!='')
			totaldeptransfert = totaldeptransfert + curmontant;
	}
	document.getElementById('totaldeptransfert').innerHTML = totaldeptransfert;
}
function calculSommeCredit()
{
	//alert("testtt");
	var curmontant=0;
	var totalcredtransfert=0;
	for(var i=0;i<16;i++)
	{
		curmontant = document.getElementById('credit_montant_'+i).value;
		if (curmontant!=0 && curmontant!='')
			totalcredtransfert = totalcredtransfert + curmontant;
	}
	document.getElementById('totalcredtransfert').innerHTML = totalcredtransfert;
}
function ajouterLigneDebit(numrow)
{
	//alert("testtt");
	var ligne = document.getElementById('lignesdebit_'+numrow);
	ligne.style.display="block";
}
function supLigneDebit(nbrows)
{
	var ligne = document.getElementById('lignesdebit_'+nbrows);
	document.getElementById('debit_codebudget_'+nbrows).selectedIndex=0;
	document.getElementById('debit_comptenat_'+nbrows).selectedIndex=0;
	document.getElementById('debit_montant_'+nbrows).value="";
	ligne.style.display="none";
}
function ajouterLigneCredit(numrow)
{
	//alert("testtt : "+document.getElementById('credit_typebudget_0').selectedIndex);
	var ligne = document.getElementById('lignescredit_'+numrow);
	document.getElementById('credit_typebudget_'+numrow).selectedIndex=document.getElementById('credit_typebudget_0').selectedIndex;
	document.getElementById('credit_sourcefin_'+numrow).selectedIndex=document.getElementById('credit_sourcefin_0').selectedIndex;
	
	ligne.style.display="block";
}
function supLigneCredit(nbrows)
{
	var ligne = document.getElementById('lignescredit_'+nbrows);
	document.getElementById('credit_codebudget_'+nbrows).selectedIndex=0;
	document.getElementById('credit_comptenat_'+nbrows).selectedIndex=0;
	document.getElementById('credit_montant_'+nbrows).value="";
	ligne.style.display="none";
}
function getSelectTypeBudget(sens,nbrow)
{
	var typebudgetdeb = document.getElementById('debit_typebudget_'+nbrow);
	var typebudgetcred = document.getElementById('credit_typebudget_'+nbrow);
	for (i = 0; i <= 20; i++)
	{
		document.getElementById('debit_typebudget_'+(i+1)).selectedIndex = typebudgetdeb.selectedIndex;
		document.getElementById('debit_typebudget_'+(i+1)).disabled = true;
		document.getElementById('credit_typebudget_'+i).selectedIndex = typebudgetdeb.selectedIndex;
		document.getElementById('credit_typebudget_'+i).disabled = true;
	}
}
function getSelectSourceFin(sens,nbrow)
{
	var sourcefindeb = document.getElementById('debit_sourcefin_'+nbrow);
	var sourcefincred = document.getElementById('credit_sourcefin_'+nbrow);
	for (i = 0; i <= 20; i++)
	{
		document.getElementById('debit_sourcefin_'+(i+1)).selectedIndex = sourcefindeb.selectedIndex;
		document.getElementById('debit_sourcefin_'+(i+1)).disabled = true;
		document.getElementById('credit_sourcefin_'+i).selectedIndex = sourcefindeb.selectedIndex;
		document.getElementById('credit_sourcefin_'+i).disabled = true;
	}
}
function getObj(n,d) {

	var p,i,x; 

	if(!d)

		d=document;


	if(n != undefined)
	{
		if((p=n.indexOf("?"))>0&&parent.frames.length) {

			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);

		}
	}



	if(!(x=d[n])&&d.all)

		x=d.all[n];

	if(typeof x == 'string'){
		x=null;
	}

	for(i=0;!x&&i<d.forms.length;i++)

		x=d.forms[i][n];



	for(i=0;!x&&d.layers&&i<d.layers.length;i++)

		x=getObj(n,d.layers[i].document);



	if(!x && d.getElementById)

		x=d.getElementById(n);



	return x;

}
function isValideDemTransfert()
{

		if(getObj('debit_typebudget_0'))
		{
			if(getObj('debit_typebudget_0').value =="")
			{
				alert("Sur les informations DEBIT, veuillez saisir le Type de Budget!!!");
					return false;
			}
		}
		if(getObj('debit_sourcefin_0'))
		{
			if(getObj('debit_sourcefin_0').value =="")
			{
				alert("Sur les informations DEBIT, veuillez saisir la Source de financement!!!");
					return false;
			}
		}
		if(getObj('debit_codebudget_0'))
		{
			if(getObj('debit_codebudget_0').value =="")
			{
				alert("Sur les informations DEBIT, veuillez saisir le code Budgetaire!!!");
					return false;
			}
		}
		if(getObj('debit_comptenat_0'))
		{
			if(getObj('debit_comptenat_0').value =="")
			{
				alert("Sur les informations DEBIT, veuillez saisir le Compte Nature!!!");
					return false;
			}
		}
		if(getObj('debit_mntdispo_0'))
		{
			if(getObj('debit_mntdispo_0').value =="")
			{
				alert("Sur les informations DEBIT, veuillez saisir le Montant!!!");
					return false;
			}
		}
		
		if(getObj('credit_typebudget_0'))
		{
			if(getObj('credit_typebudget_0').value =="")
			{
				alert("Sur les informations CREDIT, veuillez saisir le Type de Budget!!!");
					return false;
			}
		}
		if(getObj('credit_sourcefin_0'))
		{
			if(getObj('credit_sourcefin_0').value =="")
			{
				alert("Sur les informations CREDIT, veuillez saisir la Source de financement!!!");
					return false;
			}
		}
		if(getObj('credit_codebudget_0'))
		{
			if(getObj('credit_codebudget_0').value =="")
			{
				alert("Sur les informations CREDIT, veuillez saisir le code Budgetaire!!!");
					return false;
			}
		}
		if(getObj('credit_comptenat_0'))
		{
			if(getObj('credit_comptenat_0').value =="")
			{
				alert("Sur les informations CREDIT, veuillez saisir le Compte Nature!!!");
					return false;
			}
		}
		if(getObj('credit_mntdispo_0'))
		{
			if(getObj('credit_mntdispo_0').value =="")
			{
				alert("Sur les informations CREDIT, veuillez saisir le Montant!!!");
					return false;
			}
		}
		return true;
		
}
function soumettreTransfert(module) {
	var msg;
	//alert("RRRRRRR");	
	
	if (module == 'Transfert')
		msg = "Voulez-vous soumettre cette demande \340 votre DC?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function remettreTransfertEnPrepa(module) {
	var msg;
	if (module == 'Transfert')
		msg = "Voulez-vous remettre cette demande de r\351union en pr\351paration?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function RejeterTransfert(module) {
	var msg;
		
	if (module == 'Transfert')
		msg = "Voulez-vous rejeter cette demande de r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}
function AnnulerTransfert(module) {
	var msg;
		
	if (module == 'Transfert')
		msg = "Voulez-vous annuler cette r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function ViserTransfert(module) {
	var msg;
	
	if (module == 'Transfert')
		msg = "Voulez-vous accepter cette r\351union?";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
}

function goengagement(transfertid)
{
	if(confirm("Etes-vous sur de vouloir cr\351er l'engagement?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=CreateEngagement&record='+transfertid,
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
function saveDecision(transfertid) {
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
					postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=TransfertUtils&requete=saveDecision&parenttab=Activites&transfertid='+transfertid+'&regisseur='+regisseur,
					onComplete: function(response) {
					resp= response.responseText;
					//alert("transfertid = "+resp);
					location.reload();
					
					}
				}	
		);
	
	
	}
 	else {
		return false;
 	}
}
function saveSignataire(transfertid) {
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
					postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=TransfertUtils&requete=savemodifSignataire&parenttab=Demandes&transfertid='+transfertid+'&jsoninfossignataires='+jsoninfossignataires,
					onComplete: function(response) {
					resp= response.responseText;
					//alert("transfertid = "+resp);
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
	
	if (module == 'Transfert')
		msg = "Voulez-vous enregistrer les d\351penses a engager";
	
	if(confirm(msg)) {
	}
 	else {
		return false;
 	}
	
}
function creerEngagementTransfert()
{
	
	if (module == 'Transfert')
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

function goengagementtransfert(transfertid)
{
	if(confirm("Etes-vous sur de vouloir cr\351er l'engagement pour cette r\351union"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Transfert&action=TransfertAjax&mode=ajax&file=CreateEngagement&record='+transfertid,
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