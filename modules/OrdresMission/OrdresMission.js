/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

 function corrigerengagement(iddemande)
{
	if(confirm("Cette action change le num\351ro de l'OM et supprime le num\351ro de l'engagegement de nomade. Elle est irreversible. \r Assurez vous d'abord que l'engagegement a \351t\351 rejet\351e dans SAP. \r Une fois cette action effectu\351e, vous devez  r\351engager. \r  Etes-vous sur de vouloir corriger l'engagement?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=OrdresMission&action=OrdresMissionAjax&mode=ajax&file=CorrectEngagement&record='+iddemande,
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

function savePeriodeReelle(iddemande)
{
	if(confirm("Etes-vous sur de vouloir corriger la periode de la mission?"))
	{

		new Ajax.Request(
				'index.php',
				{	queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=OrdresMission&action=OrdresMissionAjax&mode=ajax&file=ChangePeriodeMission&record='+iddemande,
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

function cancelPeriodeReelle()
{
	var changeperiode = document.getElementById('changeperiode');
	
	changeperiode.style.display="none";

}

function changePeriodeMission()
{
	var changeperiode = document.getElementById('changeperiode');
	var datedebutreel = document.getElementById('datedebutreel');
	
	changeperiode.style.display="block";
	datedebutreel.focus();
	

}