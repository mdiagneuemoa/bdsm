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
											<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save';if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px" >
										{/if}
										<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   {foreach key=header item=data from=$BASBLOCKS}
														
									{if $header== $MOD.LBL_TRANSFERT_DEBITCREDIT && $MODULE == 'Transfert'}
											<td colspan=5 class="detailedViewHeader">
													<b>{$header}</b>
												</td>
										 </tr>
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
																	
																			{foreach item=ind from=$INDEXES}
																				{if $ind eq 0 }
																					<tr>
																				{else}
																					{assign var='styletr' value='style="display:none;"'}
																					<table id="lignesdebit_{$ind}" width=98% bgcolor=white class=lvtColDataHover border=1 {$styletr} width=100%>
																					<tr>
																				{/if}
																				<td><select name="debit_typebudget_{$ind}" id="debit_typebudget_{$ind}" onChange="getSelectTypeBudget('debit','0');" tabindex="{$vt_tab}" class="small" style="width:250px;">
																						{html_options  options=$TYPEBUDGET}
																					</select>
																				</td>
																				<td><select name="debit_sourcefin_{$ind}" id="debit_sourcefin_{$ind}" onChange="getSelectSourceFin('debit','0');" tabindex="{$vt_tab}" class="small"  style="width:250px;">
																						{html_options  options=$SOURCESFINACEMENT selected=$fldvalue}
																					</select>
																				</td>
																				
																				<td><select name="debit_codebudget_{$ind}" id="debit_codebudget_{$ind}" tabindex="{$vt_tab}" onChange="getSelectCompteNatByBudget('debit','0');" class="small" style="width:250px;">
																						{html_options  options=$CODESBUDGETAIRES}
																					</select>
																				</td>
																				<td><select name="debit_comptenat_{$ind}" id="debit_comptenat_{$ind}" tabindex="{$vt_tab}" class="small"  style="width:150px;">
																						{html_options  options=$COMPTESNATURE selected=$fldvalue}
																					</select>
																				</td>
																				<td><div id="debit_mntdispo_{$ind}"></div><input type="text" name="debit_montant_{$ind}" id="debit_montant_{$ind}"  placeholder="montant" tabindex="{$vt_tab}" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneDebit('{$ind+1}');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					{if $ind gt '0'}
																						<a href="javascript:;" onClick="supLigneDebit('{$ind}');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					{/if}
																					</td>

																					</tr>
																			{/foreach}
																			</table>
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL DEBIT (FCFA) : <span id="totaldeptransfert">{$totaldeptransfert|number_format:0:",":" "}</span></b></td>
																			
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
																	
																			{foreach item=ind from=$INDEXES}
																				{if $ind eq 0 }
																					<tr>
																				{else}
																					{assign var='styletr' value='style="display:none;"'}
																					<table id="lignescredit_{$ind}" bgcolor=white class=lvtColDataHover {$styletr} width=100% border=1>
																					<tr>
																				{/if}
																				<td><select name="credit_typebudget_{$ind}" id="credit_typebudget_{$ind}" tabindex="{$vt_tab}" class="small" style="width:250px;">
																						{html_options  options=$TYPEBUDGET}
																					</select>
																				</td>
																				<td><select name="credit_sourcefin_{$ind}" id="credit_sourcefin_{$ind}" tabindex="{$vt_tab}" class="small"  style="width:250px;">
																						{html_options  options=$SOURCESFINACEMENT selected=$fldvalue}
																					</select>
																				</td>
																				
																				<td><select name="credit_codebudget_{$ind}" id="credit_codebudget_{$ind}" tabindex="{$vt_tab}" onChange="getSelectCompteNatByBudget('credit','0');" class="small" style="width:250px;">
																						{html_options  options=$CODESBUDGETAIRES}
																					</select>
																				</td>
																				<td><select name="credit_comptenat_{$ind}" id="credit_comptenat_{$ind}" tabindex="{$vt_tab}"  class="small"  style="width:150px;">
																						{html_options  options=$COMPTESNATURE selected=$fldvalue}
																					</select>
																				</td>
																				<td><div id="credit_mntdispo_{$ind}"></div><input type="text" name="credit_montant_{$ind}" id="credit_montant_{$ind}"  placeholder="montant" tabindex="{$vt_tab}" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneCredit('{$ind+1}');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					{if $ind gt '0'}
																						<a href="javascript:;" onClick="supLigneCredit('{$ind}');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					{/if}
																					</td>

																					</tr>
																			{/foreach}
																			
																			</table>
																			
																			
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL CREDIT (FCFA)</b> : <span id="totalcredtransfert">{$totaldeptransfert|number_format:0:",":" "}</span></b></td>
																			
																			</tr>
																			</table>
																	</table>
																</td>
																</tr>
																
														</table>
												</td>
												
											</tr>
											<input type="hidden" name="nbnatdepense" id="nbnatdepense" value="{$NATDEPENSES|@count}">

																		
									{else}
										<tr>
											<td colspan=4 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
										</tr>
									  {/if}
								   <!-- Here we should include the uitype handlings-->
								   {include file="TransfertDisplayFields.tpl"}							
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
                                            <input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false;if(!isValideDemTransfert()) return false; if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  " style="width:95px" >
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
<input type="hidden" name="nbnatdepense" id="nbnatdepense"/>
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
