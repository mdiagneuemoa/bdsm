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
													<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted();if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px">
              				                        <!--input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';return formValidate()" type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:75px" -->
												{/if}
													<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
											</div>
										</td>
									   </tr>
										
										
										
									   <!-- included to handle the edit fields based on ui types -->
									   {foreach key=header item=data from=$BLOCKS}
										
										
										<!-- This is added to display the existing comments -->
										
										{if $header== $MOD.LBL_TRANSFERT_DEBITCREDIT && $MODULE == 'Transfert'}
											<td colspan=5 class="detailedViewHeader">
													<b>{$header}</b>
												</td>
										 </tr><tr><td>&nbsp;</td></tr>
											<tr><td colspan=5 >
												<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small" id="lignedebcred">
															
															<tr>
																<td valign=top>
																
																	<table bgcolor=white  class=lvtColDataHover id="lignesdebit"  border=1>
																		<th colspan=6>A D&Eacute;BITER</th>
																			<tr>
																				<td class="lvtCol" nowrap><b>Type de Budget</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Source de financement</b></td>
																				<!--td class="lvtCol" nowrap align="center"><b>Programme / Dotation</b></td-->
																				<td class="lvtCol" nowrap><b>Imputation Budg&eacute;taire</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Compte Nature</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Montant (FCFA)</b></td>
																				<td>&nbsp;</td>
																				
																			</tr>
																			{assign var='totaldebtransfert' value=0}
																	
																				{foreach item=linedeb key=ind from=$LIGNESDEBIT}
																				{if $linedeb.montant eq '' || $linedeb.montant eq 0}
																					{assign var='styletr' value='style="display:none;"'}
																				{else}
																					{assign var='styletr' value=''}
																				{/if}
																				{if $ind eq 0 }
																					{assign var='styleselect' value=''}
																					<tr>
																				{else}
																					{assign var='styleselect' value='disabled'}
																					<table id="lignesdebit_{$ind}" {$styletr} width=98% bgcolor=white class=lvtColDataHover border=1  width=100%>
																					<tr>
																				{/if}
																				<td><select name="debit_typebudget_{$ind}" id="debit_typebudget_{$ind}" {$styleselect} onChange="getSelectTypeBudget('debit','0');" tabindex="{$vt_tab}" class="small" style="width:250px;">
																						{html_options  options=$TYPEBUDGET selected=$linedeb.typebudget}
																					</select>
																				</td>
																				<td><select name="debit_sourcefin_{$ind}" id="debit_sourcefin_{$ind}" {$styleselect} onChange="getSelectSourceFin('debit','0');" tabindex="{$vt_tab}" class="small"  style="width:250px;">
																						{html_options  options=$SOURCESFINACEMENT selected=$linedeb.sourcefin}
																					</select>
																				</td>
																				
																				<td><select name="debit_codebudget_{$ind}" id="debit_codebudget_{$ind}" tabindex="{$vt_tab}" onChange="getSelectCompteNatByBudget('debit','0');" class="small" style="width:250px;">
																						{html_options  options=$CODESBUDGETAIRES selected=$linedeb.codebudget}
																					</select>
																				</td>
																				<td><select name="debit_comptenat_{$ind}" id="debit_comptenat_{$ind}" tabindex="{$vt_tab}" onChange="getDispoByCompteNat('debit','0');" class="small"  style="width:150px;">
																						{html_options  options=$COMPTESNATURE selected=$linedeb.comptenat}
																					</select>
																				</td>
																				<td><div id="debit_mntdispo_{$ind}"></div><input type="text" name="debit_montant_{$ind}" id="debit_montant_{$ind}" value="{$linedeb.montant}"  placeholder="montant" tabindex="{$vt_tab}" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneDebit('{$ind+1}');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					{if $ind gt '0'}
																						<a href="javascript:;" onClick="supLigneDebit('{$ind}');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					{/if}
																					</td>

																					</tr>
																				{assign var='totaldebtransfert' value=$totaldebtransfert+$linedeb.montant}
																					
																			{/foreach}
																			</table>
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL DEBIT (FCFA) : <span id="totaldeptransfert">{$totaldebtransfert|number_format:0:",":" "}</span></b></td>
																			
																			</tr>
																			</table>
																
																</td>
																</tr>
																<tr>
																<td valign=top>
																
																	<table bgcolor=white class=lvtColDataHover id="lignescredit" border=1>
																		<th colspan=6>A CR&Eacute;DITER</th>
																				<tr>
																				<td class="lvtCol" nowrap><b>Type de Budget</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Source de financement</b></td>
																				<!--td class="lvtCol" nowrap align="center"><b>Programme / Dotation</b></td-->
																				<td class="lvtCol" nowrap><b>Imputation Budg&eacute;taire</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Compte Nature</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Montant (FCFA)</b></td>
																				<td>&nbsp;</td>
																			</tr>
																			{assign var='totalcredtransfert' value=0}
																			{assign var='styleselect' value='disabled'}
																	
																			{foreach item=linecred key=ind from=$LIGNESCREDIT}
																				
																				{if $linecred.montant eq '' || $linecred.montant eq 0}
																					{assign var='styletr' value='style="display:none;"'}
																				{else}
																					{assign var='styletr' value=''}
																				{/if}
																				{if $ind eq 0 }
									
																					<tr>
																				{else}
																					<table id="lignescredit_{$ind}" {$styletr} bgcolor=white class=lvtColDataHover  width=100% border=1>
																					<tr>
																				{/if}
																				<td><select name="credit_typebudget_{$ind}" id="credit_typebudget_{$ind}" {$styleselect} tabindex="{$vt_tab}" class="small" style="width:250px;">
																						{html_options  options=$TYPEBUDGET selected=$linecred.typebudget}
																					</select>
																				</td>
																				<td><select name="credit_sourcefin_{$ind}" id="credit_sourcefin_{$ind}" {$styleselect} tabindex="{$vt_tab}" class="small"  style="width:250px;">
																						{html_options  options=$SOURCESFINACEMENT selected=$linecred.sourcefin}
																					</select>
																				</td>
																				
																				<td><select name="credit_codebudget_{$ind}" id="credit_codebudget_{$ind}" tabindex="{$vt_tab}" onChange="getSelectCompteNatByBudget('credit','0');" class="small" style="width:250px;">
																						{html_options  options=$CODESBUDGETAIRES selected=$linecred.codebudget}
																					</select>
																				</td>
																				<td><select name="credit_comptenat_{$ind}" id="credit_comptenat_{$ind}" tabindex="{$vt_tab}" onChange="getDispoByCompteNat('credit','0');" class="small"  style="width:150px;">
																						{html_options  options=$COMPTESNATURE selected=$linecred.comptenat}
																					</select>
																				</td>
																				<td><div id="credit_mntdispo_{$ind}"></div><input type="text" name="credit_montant_{$ind}" id="credit_montant_{$ind}"  value="{$linecred.montant}" tabindex="{$vt_tab}" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneCredit('{$ind+1}');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					{if $ind gt '0'}
																						<a href="javascript:;" onClick="supLigneCredit('{$ind}');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					{/if}
																					</td>

																					</tr>
																				{assign var='totalcredtransfert' value=$totalcredtransfert+$linecred.montant}
																					
																			{/foreach}
																			
																			</table>
																			
																			
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL CREDIT (FCFA) : <span id="totalcredtransfert">{$totalcredtransfert|number_format:0:",":" "}</span></b></td>
																			
																			</tr>
																			</table>
																	</table>
																</td>
																</tr>
																
														</table>
												</td>
												
											</tr>
											
										{else}
										
										<tr>
											<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										</tr>

										{/if}
										<!-- Handle the ui types display -->
										{include file="TransfertDisplayFields.tpl"}

									   {/foreach}

									  

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
													<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted();if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px">
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
