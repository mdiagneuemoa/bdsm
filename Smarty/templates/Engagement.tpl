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
<script language="JavaScript" type="text/javascript" src="modules/PriceBooks/PriceBooks.js"></script>
{literal}
<script>
function editProductListPrice(id,pbid,price)
{
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'action=ProductsAjax&file=EditListPrice&return_action=CallRelatedList&return_module=PriceBooks&module=Products&record='+id+'&pricebook_id='+pbid+'&listprice='+price,
                        onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("editlistprice").innerHTML= response.responseText;
                        }
                }
        );
}

function gotoUpdateListPrice(id,pbid,proid)
{
        $("status").style.display="inline";
        $("roleLay").style.display = "none";
        var listprice=$("list_price").value;
                new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Products&action=ProductsAjax&file=UpdateListPrice&ajax=true&return_action=CallRelatedList&return_module=PriceBooks&record='+id+'&pricebook_id='+pbid+'&product_id='+proid+'&list_price='+listprice,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                );
}
{/literal}

function loadCvList(type,id)
{ldelim}
        if($("lead_cv_list").value != 'None' || $("cont_cv_list").value != 'None')
        {ldelim}
		$("status").style.display="inline";
        	if(type === 'Leads')
        	{ldelim}
                        new Ajax.Request(
                        'index.php',
                        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("lead_cv_list").value,
                                onComplete: function(response) {ldelim}
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                {rdelim}
                        {rdelim}
                	);
        	{rdelim}

        	if(type === 'Contacts')
        	{ldelim}
                        new Ajax.Request(
                        'index.php',
                        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("cont_cv_list").value,
                                onComplete: function(response) {ldelim}
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                {rdelim}
                        {rdelim}
                	);
		{rdelim}
        {rdelim}
{rdelim}
</script>
	{include file='Buttons_List1.tpl'}
<!-- Contents -->
<form name="manageengagement" id="manageengagement">

<div id="editlistprice" style="position:absolute;width:300px;"></div>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:20px">
 	        {* Module Record numbering, used MOD_SEQ_ID instead of ID *}	
			 <span class="lvtHeaderText"><font color="purple">[ {$MOD_SEQ_ID} ] </font>{$NAME} -  {$SINGLE_MOD} {$MOD.LBL_ENGAGEMENT_BUTTON_LABEL}</span> <br>
			 {$UPDATEINFO}
			 <hr noshade size=1>
			 <br> 
		
			<!-- Account details tabs -->
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			<tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						<tr>
							{if $OP_MODE eq 'edit_view'}
		                                                {assign var="action" value="EditView"}
                		                        {else}
                                		                {assign var="action" value="DetailView"}
		                                        {/if}
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
							<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action={$action}&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$SINGLE_MOD} {$APP.LBL_INFORMATION}</a></td>
                                		       	<td class="dvtTabCache" style="width:10px">&nbsp;</td>
							<td class="dvtSelectedCell" align=center nowrap>{$MOD.LBL_ENGAGEMENT_BUTTON_LABEL}</td>
							<td class="dvtTabCache" style="width:100%">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign=top align=center >
		                	
						<div id="createengagementdepenses">
						
							<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
								<tr>
									<td class="detailedViewHeader" align="right">&nbsp;
										<!--b>{$MOD.LBL_REUNION_DEPENSES}</b-->
										<input 
										title="{$MOD.LBL_GERER_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="return gererdepenses();"
										type="button" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_GERER_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL}&nbsp;">&nbsp;
										
									</td>
							
								</tr>
								<tr>
									<td valign=top>
										<table width=99% border=1>
										<caption><span style="color:green"><b>DEPENSES A ENGAGER PAR LA DIRECTION DU BUDGET (DB)</b></span></caption>
										<tr>
											<td class="detailedViewHeader"><b>LIBELLE</b></td>
											<td class="detailedViewHeader" align="center"><b>QTE</b></td>
											<td class="detailedViewHeader" align="center"><b>NBRE</b></td>
											<td class="detailedViewHeader" align="center"><b>P.U</b></td>
											<td class="detailedViewHeader" align="center"><b>TOTAL(FCFA)</b></td>
											
										</tr>
										{assign var='totaldepreunion' value=0}
										{assign var='totalmontantaengage' value=0}
										{assign var='totalmontantaengageumv' value=0}

										{foreach item=natdepense key=comptenat from=$NATDEPENSES}
										   {if $natdepense.totaldepense gt 0}
											<tr>
												<!--td width="2%"><input type="checkbox" NAME="selected_id" id="{$entity_id}" value= '{$entity_id}' onClick="check_object(this)"></td-->
												<!--td width="2%">&nbsp;</td-->
											<td colspan=6 class="detailedViewHeader">
													<b>{$natdepense.libnatdepense} ({$comptenat})</b>
												</td>
												
											</tr>
											{foreach item=lignedepense key=k from=$natdepense.depenses}
											{*if $lignedepense.totaldepense gt 0*}
												<tr style="{$lignedepense.style}">
													<td >{$lignedepense.libdepense}</td>
													<td align="center">{$lignedepense.qtedepense}</td>
													<td align="center">{$lignedepense.nbredepense}</td>
													<td align=right>{$lignedepense.pudepense|number_format:0:",":" "}</td>
													<td align=right>{$lignedepense.totaldepense|number_format:0:",":" "}</td>
												</tr>
											{*/if*}
											
											{/foreach}
												<tr>
													<td colspan=4 align="right">
														<b>TOTAL&nbsp;</b>
													</td>
													<td align=right>
														<b>{$natdepense.totaldepense|number_format:0:",":" "}</b>
													</td>
													
												</tr>
												{if $lignedepense.style eq 'background-color:white;'}
													{assign var='totalmontantaengage' value=$totalmontantaengage+$natdepense.totaldepense}
												{else}
													{assign var='totalmontantaengageumv' value=$totalmontantaengageumv+$natdepense.totaldepense}

												{/if}
												{assign var='totaldepreunion' value=$totaldepreunion+$natdepense.totaldepense}
										{/if}
										{/foreach}
										<tr><td colspan=6 class="detailedViewHeader">&nbsp;</td></tr>
										<tr><td colspan=4 align=right><b>BUDGET TOTAL DE L'ACTIVITE</b></td>
										<td align=right><b>{$totaldepreunion|number_format:0:",":" "}</b></td></tr>
										<tr><td colspan=4 align=right><span style="color:green"><b>TOTAL DES DEPENSES A ENGAGER PAR DB</b></span></td>
											<td align=right>
											<span style="color:green"><b>{$totalmontantaengage|number_format:0:",":" "}</b></span>
											</td>
											
										</tr>
										<tr><td colspan=4 align=right><span style="color:#808080"><b>TOTAL DES DEPENSES A ENGAGER PAR UMV</b></span></td>
											<td align=right>
											<span style="color:#808080"><b>{$totalmontantaengageumv|number_format:0:",":" "}</b></span>
											</td>
											
										</tr>
										{*if  $MODULE eq 'Reunion' && ( $IS_AGENTDB eq '1' || $CURRENT_USER_PROFIL eq '20') && $STATUT eq 'db_accepted' && $REGISSEURVAL neq ''*}
	
											{if $IS_REUNIONENGAGE eq '1'}
												<tr><td align=center colspan=6><input 
														title="{$MOD.LBL_EST_ENGAGE_OM_BUTTON_LABEL}" 
														class="crmbutton small edit" 
														disabled="disabled"
														onclick=""
														type="button" 
														name="Edit" 
														value="&nbsp;{$MOD.LBL_EST_ENGAGE_OM_BUTTON_LABEL}&nbsp;">&nbsp;
												</td></tr>
											{else}
												<tr>
													<td align=center colspan=6>
													<input 
												title="{$MOD.LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL}" disabled="true"
												class="crmbutton small edit" 
												onclick="return goengagementreunion('{$ID}');"
												type="button" 
												name="Edit" 
												value="&nbsp;{$MOD.LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL}&nbsp;">&nbsp;
													<!--input 
															title="{$MOD.LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL}" 
															class="crmbutton small edit" 
															onclick="this.form.return_module.value='Reunion'; 
																this.form.return_action.value='DetailView'; 
																this.form.module.value='Reunion';
																this.form.action.value='CreateEngagement';
																return creerEngagementReunion('Reunion');"   
																type="submit" 
															name="Edit" 
															value="&nbsp;{$MOD.LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL}&nbsp;"-->&nbsp;
												</td></tr>
											{/if}
										{*/if*}
										</table>
											
									</td>
																
								</tr>
							</table>
						</div>
				
						<div id="editengagementdepenses" style="display:none">
							<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
								<tr>
									<td valign=top>
										<table width=99% border=1>
										<caption><span style="color:green"><b>MODFIFICATION DEPENSES A ENGAGER PAR LA DIRECTION DU BUDGET (DB)</b></span></caption>
										<tr>
											<td class="detailedViewHeader" colspan=2><b>LIBELLE</b></td>
											<td class="detailedViewHeader" align="center"><b>QTE</b></td>
											<td class="detailedViewHeader" align="center"><b>NBRE</b></td>
											<td class="detailedViewHeader" align="center"><b>P.U</b></td>
											<td class="detailedViewHeader" align="center"><b>TOTAL(FCFA)</b></td>
											
										</tr>
										{assign var='totaldepreunion' value=0}
										{assign var='totalmontantaengage' value=0}

										{foreach item=natdepense key=comptenat from=$NATDEPENSES}
										   {if $natdepense.totaldepense gt 0}
											<tr>
											<td colspan=7 class="detailedViewHeader">
													<b>{$natdepense.libnatdepense} ({$comptenat})</b>
												</td>
												
											</tr>
											{foreach item=lignedepense key=k from=$natdepense.depenses}
												<tr id="row_cknaturesdepense_{$comptenat}_{$lignedepense.linenum}" style="{$lignedepense.style}">
													<td width="2%"><input type="checkbox" {$lignedepense.checked} NAME="cknaturesdepense_{$comptenat}_{$lignedepense.linenum}" id="cknaturesdepense_{$comptenat}_{$lignedepense.linenum}"  onClick="checkline_object('cknaturesdepense_{$comptenat}_{$lignedepense.linenum}','{$lignedepense.totaldepense}')"></td>
													<td >{$lignedepense.libdepense}</td>
													<td align="center">{$lignedepense.qtedepense}</td>
													<td align="center">{$lignedepense.nbredepense}</td>
													<td align=right>{$lignedepense.pudepense|number_format:0:",":" "}</td>
													<td align=right>{$lignedepense.totaldepense|number_format:0:",":" "}</td>
												</tr>
												{if $lignedepense.checked neq 'checked'}
													{assign var='totalmontantaengage' value=$totalmontantaengage+$lignedepense.totaldepense}
												{/if}
											{/foreach}
												<tr>
													<td colspan=5 align="right">
														<b>TOTAL&nbsp;</b>
													</td>
													<td align=right>
														<b>{$natdepense.totaldepense|number_format:0:",":" "}</b>
													</td>
													
												</tr>
												{assign var='totaldepreunion' value=$totaldepreunion+$natdepense.totaldepense}
											{/if}
										{/foreach}
										<tr><td colspan=5 align=right><b>BUDGET TOTAL DE L'ACTIVITE</b></td>
										<td align=right><b>{$totaldepreunion|number_format:0:",":" "}</b></td></tr>
										<tr><td colspan=5 align=right><span style="color:green"><b>TOTAL DES DEPENSES A ENGAGER (DB)</b></span></td>
											<td align=right>
											<span style="color:green"><b><input style="color:green;font-weight:bold;text-align: right;" type="text" size="5" name="tmontantaengage" id="tmontantaengage" value="{$totalmontantaengage}"></b></span>
											</td>
											
										</tr>
										</table>
											
									</td>
																
								</tr>
								<tr>
									<td align=center colspan=6>
										<input 
											title="{$MOD.LBL_SAVE_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											onclick="this.form.return_module.value='Reunion'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='Reunion';
											this.form.action.value='SaveDepenseAEngager';
											return saveDepenseaengager('Reunion');"   
											type="submit" 
											name="Edit" 
											value="&nbsp;{$MOD.LBL_SAVE_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL}&nbsp;">&nbsp;
									<input 
									title="{$MOD.LBL_CANCELMODIFDECISION_BUTTON_LABEL}" 
									class="crmbutton small edit" 
									onclick="return cancelgererdepenses();"
									type="button" 
									name="Edit" 
									value="&nbsp;{$MOD.LBL_CANCELMODIFDECISION_BUTTON_LABEL}&nbsp;">&nbsp;
									</td>
								</tr>
							</table>
						</div>
			
		</div>
	<!-- PUBLIC CONTENTS STOPS-->
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
</tr>

</table>
	{include file='EditViewHidden.tpl'}
<input type="hidden" id="reunionid" name="reunionid" value={$ID}></input>

</form>
{if $MODULE eq 'Leads' or $MODULE eq 'Contacts' or $MODULE eq 'Accounts' or $MODULE eq 'Campaigns' or $MODULE eq 'Vendors'}
<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;width:300px;"></div></form>
{/if}

<script>
function OpenWindow(url)
{ldelim}
	openPopUp('xAttachFile',this,url,'attachfileWin',380,375,'menubar=no,toolbar=no,location=no,status=no,resizable=no');	
{rdelim}
</script>
