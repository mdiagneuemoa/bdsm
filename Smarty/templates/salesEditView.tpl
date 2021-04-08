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


{*<!-- module header -->*}

<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
{if $CATEGORY eq 'Demandes'}
	<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
{else}
	<script type="text/javascript" src="jscalendar/lang/calendar-{$CALENDAR_LANG}.js"></script>
{/if}
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript">
var gVTModule = '{$smarty.request.module}';
function sensex_info()
{ldelim}
        var Ticker = $('tickersymbol').value;
        if(Ticker!='')
        {ldelim}
                $("vtbusy_info").style.display="inline";
                new Ajax.Request(
                      'index.php',
                      {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module={$MODULE}&action=Tickerdetail&tickersymbol='+Ticker,
                                onComplete: function(response) {ldelim}
                                        $('autocom').innerHTML = response.responseText;
                                        $('autocom').style.display="block";
                                        $("vtbusy_info").style.display="none";
                                {rdelim}
                        {rdelim}
                );
        {rdelim}
{rdelim}
function AddressSync(Addform,id)
{ldelim}
        if(formValidate() == true)
        {ldelim}  
	      checkAddress(Addform,id);
        {rdelim}
{rdelim}

</script>

		{if $MODULE eq 'Candidats' && $CURRENT_USER_PROFIL_ID eq '50'}
			{include file='Candidats_Buttons_List.tpl'}
		{else}
			{include file='Buttons_List.tpl'}
		{/if}

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>

	<td class="showPanelBg" valign=top width=100%>
		{*<!-- PUBLIC CONTENTS STARTS-->*}
		<div class="small" style="padding:20px">
			{* vtlib customization: use translated label if available *}
			{assign var="SINGLE_MOD_LABEL" value=$SINGLE_MOD}
			{if $APP.$SINGLE_MOD} {assign var="SINGLE_MOD_LABEL" value=$APP.SINGLE_MOD} {/if}
			
			{if $MSGVALIDATION neq ''}  				
				<span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} - {$MOD.LBL_VALIDATION}</span> <br>
				{$UPDATEINFO}	 
			
			{elseif $OP_MODE eq 'edit_view'}  				
				<span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} - {$APP.LBL_EDITING} {$SINGLE_MOD_LABEL} {$APP.LBL_INFORMATION}</span> <br>
				{$UPDATEINFO}	 
			
			{elseif $OP_MODE eq 'create_view'}
				<span class="lvtHeaderText">{$APP.LBL_CREATING} {$SINGLE_MOD_LABEL}</span> <br>
			{/if}

			<hr noshade size=1>
			<br> 
		
			{include file='EditViewHidden.tpl'}

			{*<!-- Account details tabs -->*}
			
			
			
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			<!--tr><td class="big4" valign=middle>N&deg; Convention : {$TICKET}</td-->	
			   <tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
					   <tr>
						<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						 {if $MODULE eq 'OrdresMission'}
							<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]}</td>
						{else}
							<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]} {$APP.LBL_INFORMATION}</td>
						{/if}	
						<td class="dvtTabCache" style="width:10px">&nbsp;</td>
						<td class="dvtTabCache" style="width:100%">&nbsp;</td>
					   </tr>
					</table>
				</td>
			   </tr>
			   {if $MODULE eq 'Agentuemoa'}
					<tr><td class="info" >Les informations grisées sont non modifiables via ce formulaire. Si certaines vous semblent erron&eacute;es, veillez vous rapprocher de la DRH.<br>Les agents de la DRH se chargeront de les v&eacute;rifier et les mettre &agrave; jour au besoin.</td></tr>
				{/if}
			   <tr>
				<td valign=top align=left >
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
					   <tr>

						<td align=left>
							{*<!-- content cache -->*}
					
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding:10px">
									<!-- General details -->
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
												{if $MODULE eq 'Webmails'}
													<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='{$ID}'" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
											{elseif $MODULE eq 'Accounts'}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  AddressSync(this.form,{$ID});"  type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
											{elseif $MODULE eq 'OrdresMission'}	
												<input title="G&eacute;n&eacute;rer l'Ordre de Mission" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  G&eacute;n&eacute;rer l'Ordre de Mission  " style="width:200px">
											{elseif $MSGVALIDATION neq ''}
											<input class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); return formValidate() " type="submit" name="button" value="  {$APP.LBL_VALIDATE_BUTTON_LABEL}  " style="width:70px" >
											 	
												{else}
													<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px">
              				                        <!--input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';return formValidate()" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px" -->
												{/if}
													<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
										
										
										
									   <!-- included to handle the edit fields based on ui types -->
									   {foreach key=header item=data from=$BLOCKS}



							<!-- This is added to display the existing comments -->
							{if $header eq $MOD.LBL_COMMENTS || $header eq $MOD.LBL_COMMENT_INFORMATION}
							   <tr><td>&nbsp;</td></tr>
							   <tr>
								<td colspan=4 class="dvInnerHeader">
							        	<b>{$MOD.LBL_COMMENT_INFORMATION}</b>
								</td>
							   </tr>
							   <tr>
								<td colspan=4 class="dvtCellInfo">{$COMMENT_BLOCK}</td>
							   </tr>
							   <tr><td>&nbsp;</td></tr>
							{/if}



									      <tr>
										{if $header== $MOD.LBL_ADDRESS_INFORMATION && ($MODULE == 'Accounts' || $MODULE == 'Quotes' || $MODULE == 'PurchaseOrder' || $MODULE == 'SalesOrder'|| $MODULE == 'Invoice')}
                                                                                <td colspan=2 class="detailedViewHeader">
                                                                                <b>{$header}</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b>{$APP.LBL_RCPY_ADDRESS}</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b>{$APP.LBL_LCPY_ADDRESS}</b></td>
										{elseif $header== $MOD.LBL_ADDRESS_INFORMATION && $MODULE == 'Contacts'}
										<td colspan=2 class="detailedViewHeader">
                                                                                <b>{$header}</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b>{$APP.LBL_CPY_OTHER_ADDRESS}</b></td>
                                                                                <td class="detailedViewHeader">
                                                                                <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b>{$APP.LBL_CPY_MAILING_ADDRESS}</b></td>
                                                                               

									{elseif $header== $MOD.LBL_TIERS_BANQUE1_INFORMATION && $MODULE == 'Tiers'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_TIERS_ADD_COMPTE2}"></a>
											</td>
											
									 {elseif $header== $MOD.LBL_TIERS_BANQUE2_INFORMATION && $MODULE == 'Tiers'}
									<tr id="banque2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
									<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque3display()"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_TIERS_ADD_COMPTE3}"></a>&nbsp;&nbsp;
												<a href="javascript:;" onClick="banque2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_TIERS_CANCEL_ADD_COMPTE}" ></a></td>
									
								   {elseif $header== $MOD.LBL_TIERS_BANQUE3_INFORMATION && $MODULE == 'Tiers'}
									<tr id="banque3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_TIERS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES && $MODULE == 'Agentuemoa'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnbanqueAgent2display" onClick="banqueAgent2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE2}"></a>
											</td>
								
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES2 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent2header" style="{$DISPLAY_COORDBANK2}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnbanqueAgent3display"  onClick="banqueAgent3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE3}"></a>
												<a href="javascript:;" id="btnbanqueAgent2cancel"  onClick="banqueAgent2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES3 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnbanqueAgent4display" onClick="banqueAgent4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE4}"></a>
												<a href="javascript:;" id="btnbanqueAgent3cancel" onClick="banqueAgent3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES4 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnbanqueAgent5display" onClick="banqueAgent5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
												<a href="javascript:;" id="btnbanqueAgent4cancel" onClick="banqueAgent4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES5 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnbanqueAgent5cancel" onClick="banqueAgent5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_MERE && $MODULE == 'Agentuemoa'}
									<tr id="donneesmereheader" >		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddconjoint" style="display:none" onClick="ConjointAgentdisplay();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_CONJOINT}"></a>
												<a href="javascript:;" id="linkaddenf1" style="display:none" onClick="EnfantAgent1display();"><img src="{'addenfant.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT1}"></a>
									 </tr>
								
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_CONJOINT && $MODULE == 'Agentuemoa'}
									<tr id="donnesconjointheader" style="{$DISPLAY_CONJOINT}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="ConjointAgentcancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_CONJOINT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT1 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant1header" style="{$DISPLAY_ENFANT1}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf2" onClick="EnfantAgent2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT2}"></a>
												<a href="javascript:;" onClick="EnfantAgent1cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT2 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant2header" style="{$DISPLAY_ENFANT2}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf3" onClick="EnfantAgent3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT3}"></a>
												<a href="javascript:;" onClick="EnfantAgent2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT3 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant3header" style="{$DISPLAY_ENFANT3}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf4" onClick="EnfantAgent4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT4}"></a>
												<a href="javascript:;" onClick="EnfantAgent3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT4 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant4header" style="{$DISPLAY_ENFANT4}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf5" onClick="EnfantAgent5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT5}"></a>
												<a href="javascript:;" onClick="EnfantAgent4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT5 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant5header" style="{$DISPLAY_ENFANT5}">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf6" onClick="EnfantAgent6display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT6}"></a>
												<a href="javascript:;" onClick="EnfantAgent5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td-->
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT6 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant6header" style="{$DISPLAY_ENFANT6}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="EnfantAgent6cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>

	{************************************************ MODULE CANDIDAT BOURSE ONLINE 07/02/2017**********************************************}
									 
								{elseif $header== $MOD.LBL_CHOIX_ETABLISSEMENT_1 && $MODULE == 'Candidats'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="btnetab2display" onClick="etab2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_CANDIDAT_ADD_ETAB}"></a>
											</td>	
									
								{elseif $header== $MOD.LBL_CHOIX_ETABLISSEMENT_2 && $MODULE == 'Candidats'}
									<tr id="etab2header" style="{$DISPLAY_ETABLISSEMENT2}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<!--a href="javascript:;" onClick="etab3display()"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_CANDIDAT_ADD_ETAB}"></a-->&nbsp;&nbsp;
												<a href="javascript:;" onClick="etab2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_CANDIDAT_CANCEL_ADD_ETAB}"></a></td>
									 </tr>
									
								{elseif $header== $MOD.LBL_CHOIX_ETABLISSEMENT_3 && $MODULE == 'Candidats'}
									<tr id="etab3header" style="{$DISPLAY_ETABLISSEMENT3}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="etab3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_CANDIDAT_CANCEL_ADD_ETAB}"></a></td>
									 </tr>	
									 {************************************************  MODULE DEMANDE INFORMATIQUE **********************************************}
								
								{elseif $header== $MOD.LBL_DEMANDE_INFORMATION && $MODULE == 'Demandes'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
											</td>
								
								{elseif $header== $MOD.LBL_DEMANDE_2 && $MODULE == 'Demandes'}
									<tr id="demande2header" style="display: none;">
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE3}"></a>
												<a href="javascript:;" onClick="demande2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
											</td>
								
								{elseif $header== $MOD.LBL_DEMANDE_3 && $MODULE == 'Demandes'}
									<tr id="demande3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE3}"></a>
												<a href="javascript:;" onClick="demande3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_DEMANDE_4 && $MODULE == 'Demandes'}
									<tr id="demande4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE4}"></a>
												<a href="javascript:;" onClick="demande4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_DEMANDE_5 && $MODULE == 'Demandes'}
									<tr id="demande5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								
								
	{************************************************ FIN MODULE DEMANDE INFORMATIQUE **********************************************}
	{************************************************ MODULE NOMADE *********************************************}
							{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE && $MODULE == 'Demandes'}
									<tr>
											<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
											</td-->
							{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_2 && $MODULE == 'Demandes'}
									
									<tr id="lignebudget2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE4}"></a>
												<a href="javascript:;" onClick="lignebudget2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
							
							{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_3 && $MODULE == 'Demandes'}
									<tr id="lignebudget3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE4}"></a>
												<a href="javascript:;" onClick="lignebudget3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
							{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_4 && $MODULE == 'Demandes'}
									<tr id="lignebudget4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE4}"></a>
												<a href="javascript:;" onClick="lignebudget4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>	
							{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_5 && $MODULE == 'Demandes'}
									<tr id="lignebudget5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
							{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_1 && $MODULE == 'Demandes'}
									<tr>
											<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="justif2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
											</td-->
							{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_2 && $MODULE == 'Demandes'}
									<tr id="justif2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="justif2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>	


												
							{elseif $header== $MOD.LBL_TRAJET1_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet1header">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
											</td>
							{elseif $header== $MOD.LBL_TRAJET2_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet2header" style="{$DISPLAY_TRAJET2}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right >
												<a href="javascript:;" onClick="trajet3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET3_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet3header" style="{$DISPLAY_TRAJET3}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET4_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet4header" style="{$DISPLAY_TRAJET4}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET5_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet5header" style="{$DISPLAY_TRAJET5}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet6display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET6_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet6header" style="{$DISPLAY_TRAJET6}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet7display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet6cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET7_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet7header" style="{$DISPLAY_TRAJET7}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
												<a href="javascript:;" onClick="trajet7cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET8_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet8header" style="{$DISPLAY_TRAJET8}">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
	{************************************************ FIN MODULE NOMADE *********************************************}
	
								{else}
										<td colspan=4 class="detailedViewHeader">
											<b>{$header}</b>
										{/if}
										</td>
									      </tr>

										<!-- Handle the ui types display -->
										{include file="DisplayFields.tpl"}

									   {/foreach}


									   <!-- Added to display the Product Details in Inventory-->
									   {if $MODULE eq 'PurchaseOrder' || $MODULE eq 'SalesOrder' || $MODULE eq 'Quotes' || $MODULE eq 'Invoice'}
							   		   <tr>
										<td colspan=4>
											{include file="ProductDetailsEditView.tpl"}
										</td>
							   		   </tr>
									   {/if}

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
										{if $MODULE eq 'Emails'}
										<input title="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE}" accessKey="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_KEY}" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid={$ENTITY_ID}&entity={$ENTITY_TYPE}','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button" name="button" value="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL}">
										<input title="{$MOD.LBL_SEND}" accessKey="{$MOD.LBL_SEND}" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" name="button" value="  {$MOD.LBL_SEND}  " >
										{/if}
										{if $MODULE eq 'Webmails'}
										<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='{$ID}'" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{elseif $MODULE eq 'Accounts'}
                                		                     <input type='hidden'  name='address_change' value='no'>
                                                                             <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  AddressSync(this.form,{$ID}) " type="button" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >		
										{elseif $MODULE eq 'OrdresMission'}	
												<input title="G&eacute;n&eacute;rer l'Ordre de Mission" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  G&eacute;n&eacute;rer l'Ordre de Mission  " style="width:200px">
										
										{elseif $MSGVALIDATION neq ''}
											<input class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); return formValidate() " type="submit" name="button" value="  {$APP.LBL_VALIDATE_BUTTON_LABEL}  " style="width:70px" >
											
										{else}
													<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px">
              				                                	<!--input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';return formValidate()" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px" -->
										{/if}
                                               					<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table>
								</td>
							   </tr>
							</table>
						</td>
					   </tr>
					</table>
				</td>
			   </tr>
			</table>
		<div>
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
   </tr>
</table>
<!--added to fix 4600-->
<input name='search_url' id="search_url" type='hidden' value='{$SEARCH}'>
</form>


{if ($MODULE eq 'Emails' || 'Documents') and ($FCKEDITOR_DISPLAY eq 'true')}
	<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
	<script type="text/javascript" defer="1">
		var oFCKeditor = null;
		{if $MODULE eq 'Documents'}
			oFCKeditor = new FCKeditor( "notecontent" ) ;
		{/if}
		
		{*if $MODULE eq 'Demandes'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if*}

		{if $MODULE eq 'Incidents'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if}
       
		oFCKeditor.BasePath   = "include/fckeditor/" ;
		oFCKeditor.ReplaceTextarea() ;
	</script>
{/if}

{if $MODULE eq 'Accounts'}
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
{/if}
<script>	

        var fieldname = new Array({$VALIDATION_DATA_FIELDNAME})

        var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL})

        var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE})

	var ProductImages=new Array();
	var count=0;

	function delRowEmt(imagename)
	{ldelim}
		ProductImages[count++]=imagename;
	{rdelim}

	function displaydeleted()
	{ldelim}
		var imagelists='';
		for(var x = 0; x < ProductImages.length; x++)
		{ldelim}
			imagelists+=ProductImages[x]+'###';
		{rdelim}

		if(imagelists != '')
			document.EditView.imagelist.value=imagelists
	{rdelim}

</script>

<!-- vtlib customization: Help information assocaited with the fields -->
{if $FIELDHELPINFO}
<script type='text/javascript'>
{literal}var fieldhelpinfo = {}; {/literal}
{foreach item=FIELDHELPVAL key=FIELDHELPKEY from=$FIELDHELPINFO}
	fieldhelpinfo["{$FIELDHELPKEY}"] = "{$FIELDHELPVAL}";
{/foreach}
</script>
{/if}
<!-- END -->
