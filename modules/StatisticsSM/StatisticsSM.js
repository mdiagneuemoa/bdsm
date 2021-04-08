/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
var listcomptenat = Array[50]; 

function showfaq(resp)
{
	document.getElementById('REP'+resp).style.display='table-row';
	//alert('resp='+resp);
}

function PasteDatasFromExcel(flux) {
    //document.getElementById('excel_data').value="";
    navigator.clipboard.readText().then(clipText =>
  document.getElementById("excel_data").innerText = clipText);
/*  var data = document.getElementById('excel_data').value;

 //   var data = $('textarea[name=excel_data]').val();
    //console.log(data);
	var rows = data.split("\n");
	var codeflux = flux.split("||");
	//alert('f='+flux);
//var table = $('<table />');
var i=0;
for(var y in rows) {
    var cells = rows[y].split("\t");
    
   // var row = $('<tr />');
    for(var x in cells) {
       // row.append('<td>'+cells[x]+'</td>');
	var codeflux1=codeflux[i];
	//if (!isNaN(cells[x]))
	//{
		document.getElementById(codeflux1).value=cells[x];
	//}
	//alert(cells[x]);
	an=an+1;
	i=i+1;
    }
  //  table.append(row);
  
}

// Insert into DOM
//$('#excel_table').html(table);
*/
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
function getFichesByCat()
{
	var cfiche=document.getElementById("cfiche").options[document.getElementById("cfiche").selectedIndex].value;

	//alert("codeprog="+codeprog);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=StatisticsSM&action=StatisticsSMAjax&mode=ajax&file=StatisticsSMUtils&requete=getFichesByCat&cfiche='+cfiche,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				actions= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("fiche");
				while (selectdep.firstChild) 
				{
						selectdep.removeChild(selectdep.firstChild);
				}
				document.getElementById("fiche").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir...","");

				for(var i=0;i<actions.length;i++)
				{	
					var action = actions[i].split(":");
					selectdep.options[selectdep.options.length]= new Option(action[1],action[0]);
				}
				selectdep.disabled = false;
				document.getElementById("sousfiche").value="";
			}
			}	
	);
}
function getSousFichesByFiche()
{
	var fiche=document.getElementById("fiche").options[document.getElementById("fiche").selectedIndex].value;

	//alert("codeprog="+codeprog);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=StatisticsSM&action=StatisticsSMAjax&mode=ajax&file=StatisticsSMUtils&requete=getSousFichesByFiche&fiche='+fiche,
				onComplete: function(response) {
				//resp = response.responseText;
				//alert("resp="+resp);
				actions= JSON.parse(response.responseText);
				//alert("dep="+departements);
				var html = '';
				var selectdep = document.getElementById("sousfiche");
				while (selectdep.firstChild) 
				{
						selectdep.removeChild(selectdep.firstChild);
				}
				document.getElementById("sousfiche").options.length = 0;
				selectdep.options[selectdep.options.length]= new Option("Choisir...","");

				for(var i=0;i<actions.length;i++)
				{	
					var action = actions[i].split(":");
					selectdep.options[selectdep.options.length]= new Option(action[1],action[0]);
				}
				selectdep.disabled = false;
				//document.getElementById("sousfiche").value="";
			}
			}	
	);
}
function callFilter()
{
	var moisdeb=document.getElementById("moisdeb").options[document.getElementById("moisdeb").selectedIndex].value;
	var anneedeb=document.getElementById("anneedeb").options[document.getElementById("anneedeb").selectedIndex].value;
	var moisfin=document.getElementById("moisfin").options[document.getElementById("moisfin").selectedIndex].value;
	var anneefin=document.getElementById("anneefin").options[document.getElementById("anneefin").selectedIndex].value;
	var sfiche = document.getElementById('sfiche').value;
	var sficheid = document.getElementById('sficheid').value;
	//var sfiche='FICHE TEST';
	//pays = document.getElementById('pays').value;
	var pays = document.querySelector('input[name="pays"]:checked').value;
	//frequence = document.getElementById('frequence').value;
	var frequence = document.querySelector('input[name="frequence"]:checked').value;
	
	
	if (frequence=='')
	{
		alert("Vous devez indiquer la frequence des donnees souhaitee!!!!");
		return false;
	}
	else
	{
		if (frequence=='A')
		{
			if (anneedeb=='' || anneefin=='')
			{
				alert("Vous devez indiquer la periode (annee debut et annee fin) des donnees souhaitee!!!!");
				return false;
			}
		}
		else if (frequence=='M'  || frequence=='S' || frequence=='T')
		{
			if (moisdeb=='' || moisdeb=='0' || moisfin=='' || moisfin=='0')
			{
				alert("Vous devez indiquer la periode (annee et mois debut et annee et mois fin) des donnees souhaitee!!!!");
				return false;
			}
		
		}
	}
	if (pays=='')
	{
		alert("Vous devez indiquer le pays concerne!!!!");
		return false;
	}
	if (sfiche=='')
	{
		alert("Vous devez indiquer la fiche concernee!!!!");
		return false;
	}
	
	document.getElementById('conteneur').innerHTML="";
	if(confirm('Etes-vous sur de vouloir afficher les donnees de : \r '+sfiche+' \r Avec les parametres suivants: \r - PAYS : '+pays+' \r - FREQUENCE : '+frequence+'\r - DEBUT : '+moisdeb+' '+anneedeb+'\r - FIN : '+moisfin+' '+anneefin))
	{
		document.getElementById('conteneur').innerHTML="";
		getStatistiques(sficheid,pays,frequence,moisdeb,anneedeb,moisfin,anneefin);
	}
 	else {
		return false;
 	}
}
function getStatistiques(sficheidval,paysval,frequenceval,moisdebval,anneedebval,moisfinval,anneefinval)
{
	//alert("missionduree="+missionduree);
	var paramstats = JSON.stringify({ sficheid: sficheidval, pays: paysval, frequence: frequenceval, moisdeb: moisdebval, anneedeb: anneedebval, moisfin: moisfinval, anneefin: anneefinval })
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=StatisticsSM&action=StatisticsSMAjax&mode=ajax&file=StatisticsSMUtils&requete=getStatistiques&paramstats='+paramstats,
				onComplete: function(response) {
				resp = response.responseText;
				//alert("resp="+resp);
				
				document.getElementById('conteneur').innerHTML=resp;
				
			}
			}	
	);
}
function callSaisie()
{
	var moisdeb=document.getElementById("moisdeb").options[document.getElementById("moisdeb").selectedIndex].value;
	var anneedeb=document.getElementById("anneedeb").options[document.getElementById("anneedeb").selectedIndex].value;
	var moisfin=document.getElementById("moisfin").options[document.getElementById("moisfin").selectedIndex].value;
	var anneefin=document.getElementById("anneefin").options[document.getElementById("anneefin").selectedIndex].value;
	var sousfiche = document.getElementById("sousfiche").options[document.getElementById("sousfiche").selectedIndex].value;
	//var sfiche = document.getElementById('sfiche').value;
	//var sficheid = document.getElementById('sficheid').value;
	//var sfiche='FICHE TEST';
	//pays = document.getElementById('pays').value;
	var pays = document.getElementById("pays").value;
	//frequence = document.getElementById('frequence').value;
	var frequence = document.querySelector('input[name="frequence"]:checked').value;
	var typesaisie = document.querySelector('input[name="typesaisie"]:checked').value;
	
	
	if (frequence=='')
	{
		alert("Vous devez indiquer la frequence des donnees souhaitee!!!!");
		return false;
	}
	else
	{
		if (frequence=='A')
		{
			if (anneedeb=='' || anneefin=='')
			{
				alert("Vous devez indiquer la periode (annee debut et annee fin) des donnees souhaitee!!!!");
				return false;
			}
		}
		else if (frequence=='M'  || frequence=='S' || frequence=='T')
		{
			if (moisdeb=='' || moisdeb=='0' || moisfin=='' || moisfin=='0')
			{
				alert("Vous devez indiquer la periode (annee et mois debut et annee et mois fin) des donnees souhaitee!!!!");
				return false;
			}
		
		}
	}
	if (pays=='' || pays=='UEMOA')
	{
		alert("Vous devez indiquer le pays concerne!!!!");
		return false;
	}
	if (sousfiche=='')
	{
		alert("Vous devez indiquer la fiche concernee par la saisie!!!!");
		return false;
	}
	
	document.getElementById('conteneur').innerHTML="";
	if(confirm('Etes-vous sur de vouloir afficher les donnees de : \r '+sfiche+' \r Avec les parametres suivants: \r - PAYS : '+pays+' \r - FREQUENCE : '+frequence+'\r - DEBUT : '+moisdeb+' '+anneedeb+'\r - FIN : '+moisfin+' '+anneefin))
	{
		document.getElementById('conteneur').innerHTML="";
		getFormSaisie(sousfiche,pays,frequence,moisdeb,anneedeb,moisfin,anneefin,typesaisie);
	}
 	else {
		return false;
 	}
}
function getFormSaisie(sficheidval,paysval,frequenceval,moisdebval,anneedebval,moisfinval,anneefinval,typesaisieval)
{
	//alert("anneedebval="+anneedebval+"   anneefinval="+anneefinval);
	var paramstats = JSON.stringify({ sficheid: sficheidval, pays: paysval, frequence: frequenceval, moisdeb: moisdebval, anneedeb: anneedebval, moisfin: moisfinval, anneefin: anneefinval, typesaisie: typesaisieval })
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=StatisticsSM&action=StatisticsSMAjax&mode=ajax&file=StatisticsSMUtils&requete=getFormSaisie&paramstats='+paramstats,
				onComplete: function(response) {
				resp = response.responseText;
				//alert("resp="+resp);
				
				document.getElementById('conteneur').innerHTML=resp;
				
			}
			}	
	);
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

function ExportExcell(params)
{

	document.location.href="index.php?module=StatisticsSM&action=CreateXL&parenttab={$CATEGORY}&param="+params;
}
function DownloadTemplateExcell(params)
{

	document.location.href="index.php?module=StatisticsSM&action=CreateModeleFicheXL&parenttab={$CATEGORY}&param="+params;
}