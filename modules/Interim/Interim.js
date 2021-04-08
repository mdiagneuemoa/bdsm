/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
function getdirectioninterim()
{
	var matricule = document.getElementById('matinterimaire').value;
	alert(matricule);
	
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Interim&action=InterimAjax&mode=ajax&file=InterimUtils&requete=getdirectioninterim&parenttab=Demandes&matricule='+matricule,
				onComplete: function(response) {
				//resp= response.responseText;
				
				/*var direction = resp.split("##");
				document.getElementById('libdirection').value=direction[0];
				document.getElementById('codedirection').value=direction[1];*/
				
			}
				
	);
}
function getfonctioninterim()
{
	var matricule = document.getElementById('matinterimaire').value;
	//alert(matricule);
	new Ajax.Request(
			'index.php',
			{	queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Demandes&action=DemandesAjax&mode=ajax&file=DemandeUtils&requete=getfoncinterim&parenttab=Demandes&matricule='+matricule,
				onComplete: function(response) {
				resp= response.responseText;
				document.getElementById('fonctioninterimaire').value=resp;
				
			}
			}	
	);
}