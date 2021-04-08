{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

{assign var="fromlink" value=""}
<script language="JavaScript" type="text/javascript" src="include/js/Inventory.js"></script>
<script language="javascript">
	function fnshowHide(currObj,txtObj)
	{ldelim}
			if(currObj.checked == true)
				document.getElementById(txtObj).style.visibility = 'visible';
			else
				document.getElementById(txtObj).style.visibility = 'hidden';
	{rdelim}
	
	function fntaxValidation(txtObj)
	{ldelim}
			if (!numValidate(txtObj,"Tax","any"))
				document.getElementById(txtObj).value = 0;
	{rdelim}	
	
	function fnpriceValidation(txtObj)
	{ldelim}
		if (!numValidate(txtObj,"Price","any"))
			document.getElementById(txtObj).value = 0;
	{rdelim}	

function delimage(id)
{ldelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Contacts&action=ContactsAjax&file=DelImage&recordid='+id,
			onComplete: function(response)
				    {ldelim}
					if(response.responseText.indexOf("SUCCESS")>-1)
						$("replaceimage").innerHTML='{$APP.LBL_IMAGE_DELETED}';
					else
						alert("{$APP.ERROR_WHILE_EDITING}")
				    {rdelim}
		{rdelim}
	);

{rdelim}

// Function to enable/disable related elements based on whether the current object is checked or not
function fnenableDisable(currObj,enableId)
{ldelim}
	var disable_flag = true;
	if(currObj.checked == true)
		disable_flag = false;
	
	document.getElementById('curname'+enableId).disabled = disable_flag;
	document.getElementById('cur_reset'+enableId).disabled = disable_flag;
	document.getElementById('base_currency'+enableId).disabled = disable_flag;	
{rdelim}

// Update current value with current value of base currency and the conversion rate
function updateCurrencyValue(currObj,txtObj,base_curid,conv_rate)
{ldelim}
	var unit_price = $(base_curid).value;
	//if(currObj.checked == true)
	//{ldelim}
		document.getElementById(txtObj).value = unit_price * conv_rate;
	//{rdelim}
{rdelim}

// Synchronize between Unit price and Base currency value.
function updateUnitPrice(from_cur_id, to_cur_id)
{ldelim}
    var from_ele = document.getElementById(from_cur_id);
    if (from_ele == null) return;
    
    var to_ele = document.getElementById(to_cur_id);
    if (to_ele == null) return;

    to_ele.value = from_ele.value;
{rdelim}

// Update hidden base currency value, everytime the base currency value is changed in multi-currency UI
function updateBaseCurrencyValue()
{ldelim}
    var cur_list = document.getElementsByName('base_currency_input');
    if (cur_list == null) return;
    
    var base_currency_ele = document.getElementById('base_currency');
    if (base_currency_ele == null) return;
    
    for(var i=0; i<cur_list.length; i++) 
    {ldelim}	
		var cur_ele = cur_list[i];
		if (cur_ele != null && cur_ele.checked == true)
    		base_currency_ele.value = cur_ele.value;
	{rdelim}
{rdelim}

</script>

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
{foreach key=label item=subdata from=$data}
	{if $header== $MOD.LBL_TIERS_BANQUE2_INFORMATION && $MODULE == 'Tiers'}
	
		<tr id="banque2fields_{$label}" style="display: none;height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TIERS_BANQUE3_INFORMATION && $MODULE == 'Tiers'}
		<tr id="banque3fields_{$label}" style="display: none;height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES2 && $MODULE == 'Agentuemoa'}
		<tr id="banqueAgent2fields_{$label}" style="{$DISPLAY_COORDBANK2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES3 && $MODULE == 'Agentuemoa'}
		<tr id="banqueAgent3fields_{$label}" style="{$DISPLAY_COORDBANK3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES4 && $MODULE == 'Agentuemoa'}
		<tr id="banqueAgent4fields_{$label}" style="{$DISPLAY_COORDBANK4} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES5 && $MODULE == 'Agentuemoa'}
		<tr id="banqueAgent5fields_{$label}" style="{$DISPLAY_COORDBANK5} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_CONJOINT && $MODULE == 'Agentuemoa'}
		<tr id="conjointAgentfields_{$label}" style=" {$DISPLAY_CONJOINT} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT1 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent1fields_{$label}" style="{$DISPLAY_ENFANT1} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT2 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent2fields_{$label}" style="{$DISPLAY_ENFANT2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT3 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent3fields_{$label}" style="{$DISPLAY_ENFANT3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT4 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent4fields_{$label}" style="{$DISPLAY_ENFANT4} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT5 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent5fields_{$label}" style="{$DISPLAY_ENFANT5} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT6 && $MODULE == 'Agentuemoa'}
		<tr id="enfantAgent6fields_{$label}" style="{$DISPLAY_ENFANT6} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>	

	{************************************************ MODULE CANDIDAT BOURSE ONLINE 07/02/2017**********************************************}

{elseif $header== $MOD.LBL_CHOIX_ETABLISSEMENT_2 && $MODULE == 'Candidats'}
		<tr id="etab2fields_{$label}" style="{$DISPLAY_ETABLISSEMENT2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
{elseif $header== $MOD.LBL_CHOIX_ETABLISSEMENT_3 && $MODULE == 'Candidats'}
		<tr id="etab3fields_{$label}" style="{$DISPLAY_ETABLISSEMENT3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>		
	{************************************************ MODULE DEMANDE INFORMATIQUE **********************************************}
	
	{elseif $header== $MOD.LBL_DEMANDE_2 && $MODULE == 'Demandes'}
		<tr id="demande2fields_{$label}" style="{$DISPLAY_DEMANDE2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_DEMANDE_3 && $MODULE == 'Demandes'}
		<tr id="demande3fields_{$label}" style="{$DISPLAY_DEMANDE3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_DEMANDE_4 && $MODULE == 'Demandes'}
		<tr id="demande4fields_{$label}" style="{$DISPLAY_DEMANDE4} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_DEMANDE_5 && $MODULE == 'Demandes'}
		<tr id="demande5fields_{$label}" style="{$DISPLAY_DEMANDE5} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	
	{************************************************ FIN MODULE DEMANDE INFORMATIQUE **********************************************}
	
	{************************************************ MODULE NOMADE **********************************************}
	
	{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_2 && $MODULE == 'Demandes'}
		<tr id="lignebudget2fields_{$label}" style="{$DISPLAY_LIGNEBUDGET2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_3 && $MODULE == 'Demandes'}
		<tr id="lignebudget3fields_{$label}" style="{$DISPLAY_LIGNEBUDGET3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_4 && $MODULE == 'Demandes'}
		<tr id="lignebudget4fields_{$label}" style="{$DISPLAY_LIGNEBUDGET4} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_5 && $MODULE == 'Demandes'}
		<tr id="lignebudget5fields_{$label}" style="{$DISPLAY_LIGNEBUDGET5} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_2 && $MODULE == 'Demandes'}
		<tr id="justif2fields_{$label}" style="{$DISPLAY_JUSTIFS2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
		
	{elseif $header== $MOD.LBL_TRAJET2_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet2fields_{$label}" style="{$DISPLAY_TRAJET2} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET3_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet3fields_{$label}" style="{$DISPLAY_TRAJET3} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET4_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet4fields_{$label}" style="{$DISPLAY_TRAJET4} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET5_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet5fields_{$label}" style="{$DISPLAY_TRAJET5} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET6_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet6fields_{$label}" style="{$DISPLAY_TRAJET6} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET7_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet7fields_{$label}" style="{$DISPLAY_TRAJET7} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>
	{elseif $header== $MOD.LBL_TRAJET8_INFORMATION && $MODULE == 'OrdresMission'}
		<tr id="trajet8fields_{$label}" style="{$DISPLAY_TRAJET8} height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>		
	{elseif $header== $MOD.LBL_REUNION_DEPENSES && $MODULE == 'Reunion'}
		<tr  style="display:none; height:25px">	
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
		</tr>	
	{************************************************ FIN MODULE NOMADE **********************************************}
	
	{elseif $header eq 'Product Details'}
		<tr>
			{foreach key=mainlabel item=maindata from=$subdata}
				{include file='EditViewUI.tpl'}
			{/foreach}
	</tr>
	{else}
		<tr style="height:25px">
		{foreach key=mainlabel item=maindata from=$subdata}
		{include file='EditViewUI.tpl'}
	{/foreach}
   </tr>
	{/if}
	
{/foreach}
