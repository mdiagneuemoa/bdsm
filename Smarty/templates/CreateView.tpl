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
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>

{*if $CATEGORY eq 'Demandes'}
	<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
{else}
	<script type="text/javascript" src="jscalendar/lang/calendar-{$CALENDAR_LANG}.js"></script>
{/if*}
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
</script>

		{include file='Buttons_List1.tpl'}

{*<!-- Contents -->*}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<!--<td valign=top>
		<img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}">
	</td>-->

	<td class="showPanelBg" valign=top width=100%>
	     {*<!-- PUBLIC CONTENTS STARTS-->*}
	     <div class="small" style="padding:20px">
		
		{* vtlib customization: use translation only if present *}
		{assign var="SINGLE_MOD_LABEL" value=$SINGLE_MOD}
		{if $APP.$SINGLE_MOD} {assign var="SINGLE_MOD_LABEL" value=$APP.SINGLE_MOD} {/if}
				
		 {if $OP_MODE eq 'edit_view'}   
			 <span class="lvtHeaderText"><font color="purple">[ {$ID} ] </font>{$NAME} -  {$APP.LBL_EDITING} {$SINGLE_MOD_LABEL} {$APP.LBL_INFORMATION}</span> <br>
			{$UPDATEINFO}	 
		 {/if}

		 {if $OP_MODE eq 'create_view'}
			{if $DUPLICATE neq 'true'}
			{assign var=create_new value="LBL_CREATING_NEW_"|cat:$SINGLE_MOD}
				{* vtlib customization: use translation only if present *}
				{assign var="create_newlabel" value=$APP.$create_new}
				{if $create_newlabel neq ''}
					<span class="lvtHeaderText">{$create_newlabel}</span> <br>
				{else}
					<!--<span class="lvtHeaderText">{$APP.LBL_CREATING} {$APP.LBL_NEW} {$SINGLE_MOD}</span> <br>-->
					<span class="lvtHeaderText">{$APP.LBL_NEW} {$SINGLE_MOD}</span> <br>
				{/if}
		        
			{else}
			<span class="lvtHeaderText">{$APP.LBL_DUPLICATING} "{$NAME}" </span> <br>
			{/if}
		 {/if}

		 <hr noshade size=1>
		 <br> 
		
		{include file='EditViewHidden.tpl'}

		{*<!-- Account details tabs -->*}
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		
		   <tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">

				   <tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>

					{if $ADVBLOCKS neq ''}	
						<td width=75 style="width:15%" align="center" nowrap class="dvtSelectedCell" id="bi" onclick="fnLoadValues('bi','mi','basicTab','moreTab','normal','{$MODULE}')"><b>{$APP.LBL_BASIC} {$APP.LBL_INFORMATION}</b></td>
                    	<td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadValues('mi','bi','moreTab','basicTab','normal','{$MODULE}')"><b>{$APP.LBL_MORE} {$APP.LBL_INFORMATION} </b></td>
                   		<td class="dvtTabCache" style="width:65%" nowrap>&nbsp;</td>
					{else}
						<td class="dvtSelectedCell" align=center nowrap>{$APP.LBL_BASIC} {$APP.LBL_INFORMATION}</td>
	                    <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					{/if}
				   <tr>
				</table>
			</td>
		   </tr>
		   <tr>
			<td valign=top align=left >

			    <!-- Basic Information Tab Opened -->
			    <div id="basicTab">

				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<td align=left>
					<!-- content cache -->
					
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						   <tr>
							<td id ="autocom"></td>
						   </tr>
						   <tr>
							<td style="padding:10px">
							<!-- General details -->
								<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										{if $MODULE eq 'Accounts'}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{else}
                                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false;  if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px" >
										{/if}
										<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   {foreach key=header item=data from=$BASBLOCKS}
								  
								   
									{if $header== $MOD.LBL_ADDRESS_INFORMATION && ($MODULE == 'Accounts' || $MODULE == 'Quotes' || $MODULE == 'PurchaseOrder' || $MODULE == 'SalesOrder'|| $MODULE == 'Invoice')}
										<tr>											
																	   <td colspan=2 class="detailedViewHeader">
                                                                        <b>{$header}</b></td>
                                                                        <td class="detailedViewHeader">
                                                                        <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b>{$APP.LBL_RCPY_ADDRESS}</b></td>
                                                                        <td class="detailedViewHeader">
                                                                        <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b>{$APP.LBL_LCPY_ADDRESS}</b></td>

									{elseif $header== $MOD.LBL_ADDRESS_INFORMATION && $MODULE == 'Contacts'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader">
												<input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b>{$APP.LBL_CPY_OTHER_ADDRESS}</b></td>
											<td class="detailedViewHeader">
												<input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b>{$APP.LBL_CPY_MAILING_ADDRESS}</b>
											</td>
									
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
												<a href="javascript:;" onClick="banqueAgent2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE2}"></a>
											</td>
								
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES2 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE3}"></a>
												<a href="javascript:;" onClick="banqueAgent2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES3 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE4}"></a>
												<a href="javascript:;" onClick="banqueAgent3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES4 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
												<a href="javascript:;" onClick="banqueAgent4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES5 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_COMPTE}"></a></td>
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
									<tr id="donnesconjointheader" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="ConjointAgentcancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_CONJOINT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT1 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant1header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf2" onClick="EnfantAgent2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT2}"></a>
												<a href="javascript:;" onClick="EnfantAgent1cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT2 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf3" onClick="EnfantAgent3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT3}"></a>
												<a href="javascript:;" onClick="EnfantAgent2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT3 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf4" onClick="EnfantAgent4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT4}"></a>
												<a href="javascript:;" onClick="EnfantAgent3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT4 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf5" onClick="EnfantAgent5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT5}"></a>
												<a href="javascript:;" onClick="EnfantAgent4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT5 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf6" onClick="EnfantAgent6display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_ENFANT6}"></a>
												<a href="javascript:;" onClick="EnfantAgent5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_AGENTS_DONNEES_FAMILLE_ENFANT6 && $MODULE == 'Agentuemoa'}
									<tr id="donneesenfant6header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="EnfantAgent6cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_ENFANT}"></a></td>
									 </tr>
									 
	{************************************************  MODULE DEMANDE INFORMATIQUE **********************************************}
								
								{elseif $header== $MOD.LBL_DEMANDE_INFORMATION && ($MODULE == 'Demandes' || $MODULE eq 'DemandesFournituresService')}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
											</td>
								
								{elseif $header== $MOD.LBL_DEMANDE_2 && ($MODULE == 'Demandes' || $MODULE eq 'DemandesFournituresService')}
									<tr id="demande2header" style="display: none;">
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE3}"></a>
												<a href="javascript:;" onClick="demande2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
											</td>
								
								{elseif $header== $MOD.LBL_DEMANDE_3 && ($MODULE == 'Demandes' || $MODULE eq 'DemandesFournituresService')}
									<tr id="demande3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE3}"></a>
												<a href="javascript:;" onClick="demande3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_DEMANDE_4 && ($MODULE == 'Demandes' || $MODULE eq 'DemandesFournituresService')}
									<tr id="demande4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE4}"></a>
												<a href="javascript:;" onClick="demande4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_DEMANDE_5 && ($MODULE == 'Demandes' || $MODULE eq 'DemandesFournituresService')}
									<tr id="demande5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								
								
	{************************************************ FIN MODULE DEMANDE INFORMATIQUE **********************************************}
	{************************************************  MODULE NOMADE **********************************************}	
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE && ($MODULE == 'Demandes')}
									<tr id="lignebudgetheader">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
											</td-->
									</tr>
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_2 && ($MODULE == 'Demandes')}
									<tr id="lignebudget2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
												<a href="javascript:;" onClick="lignebudget2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_3 && ($MODULE == 'Demandes')}
									<tr id="lignebudget3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
												<a href="javascript:;" onClick="lignebudget3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_4 && ($MODULE == 'Demandes')}
									<tr id="lignebudget4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_COMPTE5}"></a>
												<a href="javascript:;" onClick="lignebudget4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_5 && ($MODULE == 'Demandes')}
									<tr id="lignebudget5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_CANCEL_ADD_DEMANDE}"></a></td>
									 </tr>
	
								{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_1 && ($MODULE == 'Demandes')}
									<tr id="justif1header">		
									<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="justif2display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_JUSTIFS}"></a>
											</td-->
									 </tr>
								{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_2 && ($MODULE == 'Demandes')}
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
									<tr id="trajet2header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right >
												<a href="javascript:;" onClick="trajet3display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet2cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET3_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet3header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet4display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet3cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET4_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet4header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet5display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet4cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET5_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet5header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet6display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet5cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET6_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet6header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet7display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ADD_TRAJET}"></a>
												<a href="javascript:;" onClick="trajet6cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET7_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet7header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8display();"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_AGENTS_ADD_DEMANDE2}"></a>
												<a href="javascript:;" onClick="trajet7cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
							{elseif $header== $MOD.LBL_TRAJET8_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet8header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8cancel()"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" title="{$MOD.LBL_ANCEL_ADD_TRAJET}"></a></td>
											</td>
	{************************************************  FIN MODULE NOMADE **********************************************}									
									{else}
										<tr>
						         		<td colspan=4 class="detailedViewHeader">
                                                	        		<b>{$header}</b>
							 		</td>
		                            </tr>
									  {/if}
								   <!-- Here we should include the uitype handlings-->
								   {include file="DisplayFields.tpl"}							
								   <tr style="height:10px"><td>&nbsp;</td></tr>
								 
								   {/foreach}
									<!--tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr-->
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										{if $MODULE eq 'Emails'}
                                			<input title="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE}" accessKey="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_KEY}" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid={$ENTITY_ID}&entity={$ENTITY_TYPE}','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL}">
                                			<input title="{$MOD.LBL_SEND}" accessKey="{$MOD.LBL_SEND}" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate();" type="submit" " name="button" value="  {$MOD.LBL_SEND}  " >
                                		{/if}
										{if $MODULE eq 'Accounts'}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{else}	
                                           {* <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isPopImpacteeValide(this.form.popimpactee)) return false; if(!isTimeValide(this.form.time_start)) return false; return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px" > *}
                                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false; if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px" >
										{/if}
                                            <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
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
					
			    </div>
			    <!-- Basic Information Tab Closed -->

			    <!-- More Information Tab Opened -->
			    <div id="moreTab">
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
										{if $MODULE eq 'Accounts'}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{else}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  "  >
										{/if}
                                            <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   {foreach key=header item=data from=$ADVBLOCKS}
								   <tr>
						         		<td colspan=4 class="detailedViewHeader">
                    	        		<b>{$header}</b>
                             		</td>
                             	   </tr>

								   <!-- Here we should include the uitype handlings-->
                                   {include file="DisplayFields.tpl"}

							 	   <tr style="height:25px"><td>&nbsp;</td></tr>
								   {/foreach}

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										{if $MODULE eq 'Emails'}
                                			<input title="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE}" accessKey="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_KEY}" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid={$ENTITY_ID}&entity={$ENTITY_TYPE}','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="{$APP.LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL}">
                                			<input title="{$MOD.LBL_SEND}" accessKey="{$MOD.LBL_SEND}" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" " name="button" value="  {$MOD.LBL_SEND}  " >
                                		{/if}
										{if $MODULE eq 'Accounts'}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{else}
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate()" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:70px" >
										{/if}
										<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
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
			    </div>

			</td>
		   </tr>
		</table>
	     </div>
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
   </tr>
</table>
</form>

{if ($MODULE eq 'Emails' || 'Documents' || 'HReports') and ($FCKEDITOR_DISPLAY eq 'true')}
       <script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">

       var oFCKeditor = null;

       {if $MODULE eq 'Documents'}
               oFCKeditor = new FCKeditor( "notecontent" ) ;
       {/if}
       
		{*if $MODULE eq 'Demandes'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if*}
		{*if $MODULE eq 'Demandes'}
               oFCKeditor = new FCKeditor( "objet" ) ;
       {/if}
	   {if $MODULE eq 'Demandes'}
               oFCKeditor = new FCKeditor( "commentbillet" ) ;
       {/if*}
		{if $MODULE eq 'Incidents'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if}
		{if $MODULE eq 'Conventions'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if}
	{if $MODULE eq 'ExecutionConventions'}
               oFCKeditor = new FCKeditor( "description" ) ;
       {/if}
	   {if $MODULE eq 'HReports'}
               oFCKeditor = new FCKeditor( "hreportcontent" ) ;
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
