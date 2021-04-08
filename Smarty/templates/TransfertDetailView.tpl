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
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>

<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>

<!--
<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
   <a class="link"  align="right" href="javascript:;">{$APP.LBL_EDIT_BUTTON}</a>
</span>
-->
<div id="convertleaddiv" style="display:block;position:absolute;left:225px;top:150px;"></div>
<script>
{literal}
var gVTModule = '{$smarty.request.module}';
function callConvertLeadDiv(id)
{
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Leads&action=LeadsAjax&file=ConvertLead&record='+id,
                        onComplete: function(response) {
                                $("convertleaddiv").innerHTML=response.responseText;
				eval($("conv_leadcal").innerHTML);
                        }
                }
        );
}
function showHideStatus(sId,anchorImgId,sImagePath)
{
	oObj = eval(document.getElementById(sId));
	if(oObj.style.display == 'block')
	{
		oObj.style.display = 'none';
		eval(document.getElementById(anchorImgId)).src =  'themes/images/inactivate.gif';
		eval(document.getElementById(anchorImgId)).alt = 'Display';
		eval(document.getElementById(anchorImgId)).title = 'Display';
	}
	else
	{
		oObj.style.display = 'block';
		eval(document.getElementById(anchorImgId)).src = 'themes/images/activate.gif';
		eval(document.getElementById(anchorImgId)).alt = 'Hide';
		eval(document.getElementById(anchorImgId)).title = 'Hide';
	}
}
<!-- End Of Code modified by SAKTI on 10th Apr, 2008 -->

<!-- Start of code added by SAKTI on 16th Jun, 2008 -->
function setCoOrdinate(elemId){
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById('lstRecordLayout');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do{					  
	  leftpos  += aTag.offsetLeft;
	  toppos += aTag.offsetTop;
	} while(aTag = aTag.offsetParent);
	
	tagName.style.top= toppos + 20 + 'px';
	tagName.style.left= leftpos - 276 + 'px';
}

function getListOfRecords(obj, sModule, iId,sParentTab)
{
		new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Users&action=getListOfRecords&ajax=true&CurModule='+sModule+'&CurRecordId='+iId+'&CurParentTab='+sParentTab,
			onComplete: function(response) {
				sResponse = response.responseText;
				$("lstRecordLayout").innerHTML = sResponse;
				Lay = 'lstRecordLayout';	
				var tagName = document.getElementById(Lay);
				var leftSide = findPosX(obj);
				var topSide = findPosY(obj);
				var maxW = tagName.style.width;
				var widthM = maxW.substring(0,maxW.length-2);
				var getVal = parseInt(leftSide) + parseInt(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = parseInt(leftSide) - parseInt(widthM);
					tagName.style.left = leftSide + 230 + 'px';
					tagName.style.top = topSide + 20 + 'px';
				}else{
					tagName.style.left = leftSide + 230 + 'px';
				}
				setCoOrdinate(obj.id);
				
				tagName.style.display = 'block';
				tagName.style.visibility = "visible";
			}
		}
	);
}
<!-- End of code added by SAKTI on 16th Jun, 2008 -->
{/literal}
function BackupDocument(form,id,folderid)
{ldelim}
	if(confirm("{$MOD.LBL_MSG_BACKUP}"))
	{ldelim}
		
		form.return_module.value='Documents'; 
		form.return_action.value='DetailView';
		form.module.value='Documents';
		form.action.value='ListView';
		form.idToBackup.value=id;
		form.folderid.value=folderid;
		form.submit();
		
	{rdelim}
{rdelim}

function BackupRapport(form,id,folderid)
{ldelim}
	if(confirm("Attention!! vous etes sur le point d'archiver ce rapport.\n Une fois fait, il ne sera disponible qu'en consultation."))
	{ldelim}
	
		form.return_module.value='HReports'; 
		form.return_action.value='DetailView';
		form.module.value='HReports';
		form.action.value='ListView';
		form.folderid.value=folderid;
		form.idToBackup.value=id;
		form.submit();
		
	{rdelim}
{rdelim}


function tagvalidate()
{ldelim}
	if(trim(document.getElementById('txtbox_tagfields').value) != '')
		SaveTag('txtbox_tagfields','{$ID}','{$MODULE}');	
	else
	{ldelim}
		alert("{$APP.PLEASE_ENTER_TAG}");
		return false;
	{rdelim}
{rdelim}
function DeleteTag(id,recordid)
{ldelim}
	$("vtbusy_info").style.display="inline";
	Effect.Fade('tag_'+id);
	new Ajax.Request(
		'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                        method: 'post',
                        postBody: "file=TagCloud&module={$MODULE}&action={$MODULE}Ajax&ajxaction=DELETETAG&recordid="+recordid+"&tagid=" +id,
                        onComplete: function(response) {ldelim}
						getTagCloud();
						$("vtbusy_info").style.display="none";
                        {rdelim}
                {rdelim}
        );
{rdelim}




//Added to send a file, in Documents module, as an attachment in an email
function sendfile_email()
{ldelim}
	filename = $('dldfilename').value;
	document.DetailView.submit();
	OpenCompose(filename,'Documents');
{rdelim}

</script>

<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>



<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
	<td>
		{if $MODULE eq 'Candidats'}
			{include file='Candidats_Buttons_List.tpl'}
		{else}
			{include file='Buttons_List.tpl'}
		{/if}
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<!--<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>-->
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div id="pos" class="small" style="padding:10px" >
		
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
			<tr><td>		
		  		{* Module Record numbering, used MOD_SEQ_ID instead of ID *}
		 		<span class="dvHeaderText">
				{if $MODULE eq 'Documents' || $MODULE eq 'HReports'}
					<!-- Pour retourner au dossier du document Hodar CRM -->
					<a href="index.php?action=ListView&module={$MODULE}&parenttab={$CATEGORY}&folderid={$FOLDERID}">
					<img src="{'dossier-ouvert.gif'|@vtiger_imageurl:$THEME}" border=0>&nbsp;{$FOLDERNAME}</a> >
				{/if}
				{*if $MODULE eq 'OrdresMission'}
					[<img src="{'arrow_left.png'|@vtiger_imageurl:$THEME}" border=0> <a href="index.php?module=Demandes&action=DetailView&record={$MOD_SEQ_ID}">Retour à la demande</a> ]
		 		{/if*}
		 	</td></tr>
		 </table>			 
		<br>
		
		<!-- Account details tabs -->
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		
		<tr>
			<td>
				<form action="index.php" method="post" name="DetailView" id="form1">
				{include file='DetailViewHidden.tpl'}	  
				<input type="hidden" name="validation">
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCell" align=center nowrap>{$APP[$SINGLE_MOD]} {$APP.LBL_INFORMATION}</td>	
					<td class="dvtTabCache" style="width:10px"></td>
					{if $IS_AGENTDB eq '1'  || $CURRENT_USER_PROFIL eq '20'}
					<!--td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=Engagement&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$MOD.LBL_ENGAGEMENT_BUTTON_LABEL}</a></td-->
					{/if}
				
					<td class="dvtTabCache" align="right" style="width:100%">
                    				

					
					{if ($IS_POSTEURDEMANDE eq '1' || $CURRENT_USER_PROFIL eq '20') && ($STATUT neq 'mt_cancelled' || $STATUT neq 'cancelled') }
						
						
						<input 
										title="{$MOD.LBL_CANCELTRANSFERT_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementTransfert';
												this.form.action.value='EditView';
												this.form.statut.value='mt_cancelled';
												return AnnulerTransfert('Transfert');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_CANCELTRANSFERT_BUTTON_LABEL}&nbsp;">&nbsp;
						
						{if $STATUT neq 'db_accepted'}				
							<input title="{$MOD.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$MOD.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
						{/if}
						
						{if $IS_DEMANDEVALIDE.bool eq '1'}
						
							{if $STATUT eq 'open'}
								<input 
									title="{$MOD.LBL_SOUMETTRE_BUTTON_LABEL}" 
									class="crmbutton small edit" 
									onclick="this.form.return_module.value='Transfert'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementTransfert';
										this.form.action.value='Save';
										this.form.statut.value='dc_submitted';
										return soumettreTransfert('Transfert');"   
								type="submit"  
								name="Edit" 
									value="&nbsp;{$MOD.LBL_SOUMETTRE_BUTTON_LABEL}&nbsp;">&nbsp;
												
							{else}
								<input 
									title="{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}" 
									class="crmbutton small edit" 
									
									onclick="this.form.return_module.value='Transfert'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementTransfert';
										this.form.action.value='Save';
										this.form.statut.value='open';
										return remettreTransfertEnPrepa('Transfert');"   
								type="submit"  
								name="Edit"
									value="&nbsp;{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}&nbsp;">&nbsp;
						{/if}	
						
					{/if}	
					{/if}			

					{if  ($CURRENT_USER_PROFIL eq '22'  || $CURRENT_USER_PROFIL eq '20' || $IS_INTERIMDIRCAB eq '1') && $STATUT eq 'dc_submitted'} {*    PROFIL DIRCAB *}
							<input 
										title="{$MOD.LBL_REJET_DC_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementTransfert';
												this.form.action.value='EditView';
												this.form.statut.value='dc_denied';
												return RejeterTransfert('Transfert');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_DC_BUTTON_LABEL}&nbsp;">&nbsp;
																		
						<input 
										title="{$MOD.LBL_VISER_DC_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementTransfert';
											this.form.action.value='Save';
											this.form.statut.value='dc_authorized';
											return ViserTransfert('Transfert');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_DC_BUTTON_LABEL}&nbsp;">&nbsp;

					{/if}
						
					{if  ($IS_AGENTDB eq '1'  || $CURRENT_USER_PROFIL eq '20')} {*    PROFIL AGENT DB *}
							
															
								{if $STATUT eq 'dc_authorized'}						
										<input 
										title="{$MOD.LBL_REJET_DB_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementTransfert';
												this.form.action.value='EditView';
												this.form.statut.value='db_denied';
												return RejeterTransfert('Transfert');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_DB_BUTTON_LABEL}&nbsp;">&nbsp;
							
										
									<input 
										title="{$MOD.LBL_VISER_DB_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementTransfert';
											this.form.action.value='Save';
											this.form.statut.value='db_accepted';
											return ViserTransfert('Transfert');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_DB_BUTTON_LABEL}&nbsp;">&nbsp;
						{/if}	
									
					{/if}
						
					{*if  ($CURRENT_USER_PROFIL eq '29'  || $CURRENT_USER_PROFIL eq '20') && $STATUT eq 'db_accepted'} 
							<input 
										title="{$MOD.LBL_REJET_DCF_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementTransfert';
												this.form.action.value='EditView';
												this.form.statut.value='dcf_denied';
												return RejeterTransfert('Transfert');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_DCF_BUTTON_LABEL}&nbsp;">&nbsp;
																		
							<input 
										title="{$MOD.LBL_VISER_DCF_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Transfert'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementTransfert';
											this.form.action.value='Save';
											this.form.statut.value='dcf_accepted';
											return ViserTransfert('Transfert');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_DCF_BUTTON_LABEL}&nbsp;">&nbsp;
					{/if*}
						
												

					
					{*********************************** FIN NOMADE ***************************************************}					
				  					
														
					
						
					
				</tr>
				</table>
			</td>
		</tr>
	
		<tr>
			<td valign=top align=left >                
				 <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" style="border-bottom:0;">
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
				
			</form>
			<form action="index.php" method="post" name="DetailView" id="form3">
			
		{if $MODULE == 'Transfert' }
			{if $STATUT eq 'open'}
				<tr><td align="left" ><img src="{'open_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
				
			{if $STATUT eq 'submitted'}
				<tr><td align="left" ><img src="{'submitted_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>				
			{/if}	
			{if $STATUT eq 'dc_accepted'}
				<tr><td align="left" ><img src="{'dc_accepted_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			{if $STATUT eq 'dc_cancelled' || $STATUT eq 'dc_denied'}
				<tr><td align="left" ><img src="{'dc_denied_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			{if $STATUT eq 'db_accepted'}
				<tr><td align="left" ><img src="{'db_accepted_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
			{if $STATUT eq 'db_denied'}
				<tr><td align="left" ><img src="{'db_denied_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
						
			{if $STATUT eq 'com_cancelled' || $STATUT eq 'com_denied'}
				<tr><td align="left" ><img src="{'com_denied_transfert.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
			{if $STATUT eq 'mtgenered' }
				<tr><td align="left" ><img src="{'prgenered.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}

			
		{/if}
		
		{if $IS_DEMANDEVALIDE.bool eq '0'}
			<!-- Demande de transfert nécessaire sur certains comptes natures -->
			<tr><td align=center><font color='red'><b>{$IS_DEMANDEVALIDE.msg}</b></font></td></tr>
		{/if}
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				  	<table border=0 cellspacing=0 cellpadding=0 width=100%>
							 
							  <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->
							 {include_php file="./include/DetailViewBlockStatus.php"}
							 <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->

							{foreach key=header item=detail from=$BLOCKS}

							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
							<!--tr>
				                            <td>&nbsp;</td>
				                            <td>&nbsp;</td>
				                            <td>&nbsp;</td>
							
							</tr-->
					<!--div id="savetraitbut" style="display:none" align=center >
						<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="traitementbut" onclick="this.form.action.value='SaveTraitement';" type="submit" " name="button" value="Enregistrer Livraison" >
					</div-->
							{if $header== $MOD.LBL_TRANSFERT_DEBITCREDIT && $MODULE == 'Transfert'}
											<td colspan=5 class="detailedViewHeader">
													<b>{$header}</b>
												</td>
										 </tr><tr><td  colspan=5>&nbsp;</td></tr>
											<tr><td colspan=5 >
												<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small" id="lignedebcred">
															
															<tr>
																<td valign=top>
																
																	<table bgcolor=white width=99% class=lvtColDataHover id="lignesdebit"  border=1>
																		<th colspan=5>A D&Eacute;BITER</th>
																			<tr>
																				<td class="lvtCol" nowrap><b>Type de Budget</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Source de financement</b></td>
																				<td class="lvtCol" nowrap><b>Imputation Budg&eacute;taire</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Compte Nature</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Montant (FCFA)</b></td>
																				
																				
																			</tr>
																			{assign var='totaldebtransfert' value=0}
																				{foreach item=linedeb key=index from=$LIGNESDEBIT}

																				<tr bgcolor=white class=lvtColDataHover>
																					<td align=center>{$linedeb.typebudget}</td>
																					<td nowrap align=center>{$linedeb.sourcefinlib}</td>
																					<td width=400>{$linedeb.codebudget} : <br>{$linedeb.libactivite}</td>
																					<td align=center>{$linedeb.comptenat}</td>
																					<td align=right>
																					{if $linedeb.montant gt $linedeb.mntdispo}
																						<font color='red'><b>{$linedeb.montant|number_format:0:",":" "}</b></font>
																					{else}
																						<b>{$linedeb.montant|number_format:0:",":" "}</b>
																					{/if}
																					<br><span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;font-size: 11px;color:gray;">
																						Dispo :{$linedeb.mntdispo|number_format:0:",":" "}</span>
																					</td>
																				</tr>
																				{assign var='totaldeptransfert' value=$totaldeptransfert+$linedeb.montant}
																			{/foreach}
																			
																			<tr>
																				<td colspan=4 align=right><b>TOTAL D&Eacute;BIT :</b></td>
																				<td align=right><b>{$totaldeptransfert|number_format:0:",":" "}</b></td>
																			</tr>
																			</table>
																
																</td>
																</tr>
																<tr>
																<td valign=top>
																
																	<table bgcolor=white width=99% class=lvtColDataHover id="lignescredit" border=1>
																		<th colspan=5>A CR&Eacute;DITER</th>
																				<tr>
																				<td class="lvtCol" nowrap><b>Type de Budget</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Source de financement</b></td>
																				<td class="lvtCol" nowrap><b>Imputation Budg&eacute;taire</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Compte Nature</b></td>
																				<td class="lvtCol" nowrap align="center"><b>Montant (FCFA)</b></td>
																				
																			</tr>
																			{assign var='totalcredtransfert' value=0}
																	
																			{foreach item=linecred key=index from=$LIGNESCREDIT}
																				<tr bgcolor=white class=lvtColDataHover>
																					<td align=center>{$linecred.typebudget}</td>
																					<td nowrap align=center>{$linecred.sourcefinlib}</td>
																					<td width=400>{$linecred.codebudget} : <br>{$linecred.libactivite}</td>
																					<td align=center>{$linecred.comptenat}</td>
																					<td align=right>
																						<b>{$linecred.montant|number_format:0:",":" "}</b>
																						<br><span style="font-family: Arial, Helvetica, sans-serif;font-weight:bold;font-size: 10px;color:gray;">Dispo :{$linedeb.mntdispo|number_format:0:",":" "}</span>
																						</td>
																				</tr>
																				{assign var='totalcredtransfert' value=$totalcredtransfert+$linecred.montant}
																			{/foreach}
																			
																			<tr>
																				<td colspan=4 align=right><b>TOTAL CR&Eacute;DIT : </b></td>
																				<td align=right><b>{$totalcredtransfert|number_format:0:",":" "}</b></td>
																			</tr>
																			</table>
																	</table>
																</td>
																</tr>
																
														</table>
												</td>
												
											</tr>
							
							{elseif $header neq 'Comments'}
 
							<tr>
							{strip}
							     <td colspan=2 class="dvInnerHeader">
								
								<div style="float:left;font-weight:bold;">
									<div style="float:left;">
										<a href="javascript:showHideStatus('tbl{$header|replace:' ':''}','aid{$header|replace:' ':''}','{$IMAGE_PATH}');">
											{if $BLOCKINITIALSTATUS[$header] eq 1}
												<img id="aid{$header|replace:' ':''}" src="{'activate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>
											{else}
												<img id="aid{$header|replace:' ':''}" src="{'inactivate.gif'|@vtiger_imageurl:$THEME}" style="border: 0px solid #000000;" alt="Display" title="Display"/>
											{/if}
										</a>
									</div>
									<b>&nbsp;{$header}</b>
								</div>
							     </td>
								
								
							{/strip}
					             </tr>
						{/if}
					</table>
						{if $header neq 'Comments'}
							{if $BLOCKINITIALSTATUS[$header] eq 1}
								<div style="width:auto;display:block;" id="tbl{$header|replace:' ':''}" >
							{else}
								<div style="width:auto;display:none;" id="tbl{$header|replace:' ':''}" >
							{/if}
							<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
							    {foreach item=detail from=$detail}
								{if $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES2 && $MODULE == 'Agentuemoa'}
									<tr id="banqueAgent2fields_{$label}" style="{$DISPLAY_COORDBANK2} height:25px">	
										
								{elseif $header== $MOD.LBL_TRANSFERT_DEBITCREDIT && $MODULE == 'Transfert'}
									<tr  style="display:none; height:25px">	
											
								{else}
									<tr style="height:25px">
								{/if}	
									{foreach key=label item=data from=$detail}
									   {assign var=keyid value=$data.ui}
									   {assign var=keyval value=$data.value}
									   {assign var=keytblname value=$data.tablename}
									   {assign var=keyfldname value=$data.fldname}
									   {assign var=keyfldid value=$data.fldid}
									   {assign var=keyoptions value=$data.options}
									   {assign var=keysecid value=$data.secid}
									   {assign var=keyseclink value=$data.link}
									   {assign var=keycursymb value=$data.cursymb}
									   {assign var=keysalut value=$data.salut}
									   {assign var=keyaccess value=$data.notaccess}
									   {assign var=keycntimage value=$data.cntimage}
									   {assign var=keyadmin value=$data.isadmin}
									   
									   
									   
										{if $label ne ''}
										{if $keycntimage ne ''}
											<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value={$keyadmin}></input>{$keycntimage}</td>
										{elseif $keyid eq '71' || $keyid eq '72'}<!-- Currency symbol -->
											<td class="dvtCellLabel" align=right width=25%>{$label}<input type="hidden" id="hdtxt_IsAdmin" value={$keyadmin}></input> ({$keycursymb})</td>
					
										{elseif $keyid neq '53'} <!-- Hodar crm && $keyid neq '27' pour ne pas afficher filelocationtype -->
											{if ($MODULE eq 'Demandes' || $MODULE eq 'Incidents') && $keyfldname eq 'description'}
												<input type="hidden" id="hdtxt_IsAdmin" value={$keyadmin}>
											{else}
												<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value={$keyadmin}></input>{$label}</td>
										{/if}
											<!--<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value={$keyadmin}></input>{$label}</td> -->
										{/if}
										{if ($MODULE eq 'Documents' || $MODULE eq 'HReports') && $EDIT_PERMISSION eq 'yes' && $header eq 'File Information'}
											{if $keyfldname eq 'filestatus' && $ADMIN eq 'yes'}
												{include file="DetailViewUI.tpl"}
											{else}
												{include file="DetailViewFields.tpl"}
										{/if}
										{else}
										{if $EDIT_PERMISSION eq 'yes'}
											{include file="DetailViewUI.tpl"}
										{else}
											{include file="DetailViewFields.tpl"}
										{/if}
										{/if}
										{/if}
										
									{/foreach}
								</tr>
														
							    {/foreach}	
								

								
							</table>
						</div>
						{/if}
                     	                      </td>
					   </tr>
			                                                                                                    
		<td style="padding:10px">
			{/foreach}
                    {*-- End of Blocks--*} 
			</td>
                </tr>
		<tr><td>
		<div id='divsignataire'  style='display:none;'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					
						<tr><th colspan=3 align=center>MODIFICATION TIMBRES ET SIGNATAIRES</th><tr>
						
					
				<tr align=center>
						<td class="detailedViewHeader2" ><b>&nbsp;</b></td>
						<td class="detailedViewHeader2" ><b>Timbre</b></td>
						<td class="detailedViewHeader2" ><b>Signataire</b></td>

					</tr>
					<tr align=center>
						<td class="detailedViewHeader2" ><b>Directeur de Cabinet</b></td>
						<td class="dvtCellInfo">
							<select name="timbredc"  class="small" id="timbredc" style="width:230px;">
								{html_options  options=$TIMBRESDC selected=$TIMBRESDCSELECT}
							</select>
						</td>
						<td class="dvtCellInfo">
							<select name="signatairedc"  class="small" id="signatairedc" style="width:230px;">
								{html_options  options=$SIGNATAIRES selected=$SIGNATAIREDCSELECT}
							</select>
						</td>
								
					</tr>	
					<tr align=center>
						<td class="detailedViewHeader2" ><b>Commissaire</b></td>
						<td class="dvtCellInfo">
							<select name="timbrecom"  class="small" id="timbrecom" style="width:230px;">
								{html_options  options=$TIMBRESCOM selected=$TIMBRESCOMSELECT}
							</select>
						</td>
						<td class="dvtCellInfo">
							<select name="signatairecom"  class="small" id="signatairecom" style="width:230px;">
								{html_options  options=$SIGNATAIRES selected=$SIGNATAIRECOMSELECT}
							</select>
						</td>
								
					</tr>	
					<tr><td colspan=3 align=right>
							<input title="{$MOD.LBL_SAVE_BUTTON_LABEL}" class="crmbutton small edit" 
								onclick="saveSignataire('{$ID}');"   
								type="button"  
								name="Edit" 
								value="&nbsp;{$MOD.LBL_SAVE_BUTTON_LABEL}&nbsp;">&nbsp;
							<input title="{$MOD.LBL_BACK_BUTTON_LABEL}" class="crmbutton small edit" 
								onclick="AnnulerSignataire();"   
								type="button"  
								name="Edit" 
								value="&nbsp;{$MOD.LBL_BACK_BUTTON_LABEL}&nbsp;">&nbsp;							
						</td></tr>
				</table>
		</div>
		</td>
                </tr>
		<tr><td>
		<div id='divdecision'  style='display:none;'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					
						<tr><th colspan=3 align=center>CAISSE AVANCE (AU BESOIN) ET R&Eacute;GISSEUR</th><tr>
						
					
				<tr align=center>		
						<td class="detailedViewHeader2" ><b>R&eacute;gisseur</b></td>

					</tr>
					<tr align=center>
						<td class="dvtCellInfo" colspan=2>
							<select name="regisseur"  class="small" id="regisseur" style="width:230px;">
								{html_options  options=$LISTREGISSEURS selected=$REGISSEURSELECT}
							</select>
						</td>
								
					</tr>	
					<tr><td  align=right>
							<input title="{$MOD.LBL_SAVEMODIFDECISION_BUTTON_LABEL}" class="crmbutton small edit" 
								onclick="saveDecision('{$ID}');"   
								type="button"  
								name="Edit" 
								value="&nbsp;{$MOD.LBL_SAVEMODIFDECISION_BUTTON_LABEL}&nbsp;">&nbsp;
							<input title="{$MOD.LBL_CANCELMODIFDECISION_BUTTON_LABEL}" class="crmbutton small edit" 
								onclick="AnnulerDecision();"   
								type="button"  
								name="Edit" 
								value="&nbsp;{$MOD.LBL_CANCELMODIFDECISION_BUTTON_LABEL}&nbsp;">&nbsp;							
						</td></tr>
				</table>
		</div>
		</td>
                </tr>
		
				{if $MODULE eq 'Demandes' || $MODULE eq 'OrdresMission'}
					<tr><td class="small"><b><u>Initiateur demande</u> : {$POSTEURDEMANDE}<b></td></tr>	
				{/if}	
				
				<!--tr><td>
				<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> INFORMATION DISPONIBITE DES CREDITS</caption>
					
				<tr align=center>		
						<td class="detailedViewHeader2"><b>Code Budgétaire</b></td>
						<td class="detailedViewHeader2"><b>Nature Dépense</b></td>
						<td class="detailedViewHeader2"><b>Autorisation d'engagement</b></td>
						<td class="detailedViewHeader2"><b>Montant Engagé</b></td>
						<td class="detailedViewHeader2"><b>Montant Disponible</b></td>
				</tr>
				{assign var='totalbudget' value=0}
				{foreach from=$BUDGETDISP item=budget key=codebudg}
					<tr align=center>
						<td class="detailedViewHeader2" rowspan=20><b>{$codebudg}</b></td>
					{foreach from=$budget item=ligne}
						<tr>					
						<td class="detailedViewHeader2">{$ligne.comptenatlib} ({$ligne.comptenat})</td>
						<td class="detailedViewHeader2"  align="right">{$ligne.fonddisp|number_format:0:",":" "}</td>
						<td class="detailedViewHeader2"  align="right">{$ligne.fondengage|number_format:0:",":" "}</td>
						<td class="detailedViewHeader2"  align="right">{$ligne.mntdispo|number_format:0:",":" "}</td>
						</tr>
						{assign var='totalbudget' value=$totalbudget+$ligne.mntdispo}

					{/foreach}
					</tr>	
				{/foreach}
				<tr align=center>
						<td class="detailedViewHeader2" colspan=3 align=right><b>TOTAL BUDGET DISPONIBLE</b></td>
						<td class="detailedViewHeader2"  align="right"><b>{$totalbudget|number_format:0:",":" "}</b></td>
				</table>
			</div>
			
			</td></tr-->	
			{if $MODULE eq 'Transfert'}
					<tr><td>&nbsp;</td></tr>
					<tr><td class="small"><b><u>Inititeur Transfert</u> : {$POSTEURDEMANDE}<b></td></tr>	
				{/if}										
		<tr>           
				{* ************************************* NOMADE ************************************ *}
				
					
		<!-- Inventory - Product Details informations -->
		   <tr>
			{$ASSOCIATED_PRODUCTS}
		   </tr>			
			<!--
			{if $SinglePane_View eq 'true' && $IS_REL_LIST eq 'true'}
				{include file= 'RelatedListNew.tpl'}
			{/if}
			-->
			
 				{include file='ListViewTraitementTransfert.tpl'}
 			
		</table>
		
		
			
		
		 <input type="hidden" id="demandeid" name="demandeid" value={$ID}></input>
		<input type="hidden" id="demandeticket" name="demandeticket" value={$TICKET}></input>
			
		</td>
		
</tr>
</form>
	<tr>
		<td>			
			<form action="index.php" method="post" name="DetailView2" id="form2">
			{include file='DetailViewHidden.tpl'}
			<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCacheBottom" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCellBottom" align=center nowrap>{$APP[$SINGLE_MOD]} {$APP.LBL_INFORMATION}</td>	
					<td class="dvtTabCacheBottom" style="width:10px">&nbsp;</td>
					<!--
					{if $SinglePane_View eq 'false'}
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$APP.LBL_MORE} {$APP.LBL_INFORMATION}</a></td>
					{/if}
					-->
					<td class="dvtTabCacheBottom" align="right" style="width:100%">
						&nbsp;
						{if $CURRENT_USER_DO_ACTION eq 'YES' }
							{*if $EDIT_DUPLICATE eq 'permitted'*}
							{if ($CURRENT_USER_IS_POSTEUR_DEMANDE neq '0' || $CURRENT_USER_IS_POSTEUR_INCIDENT neq '0' || $CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 ) && ( $STATUT eq 'open' ) }
								<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit"  name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
							{/if}
							{*if $EDIT_DUPLICATE eq 'permitted' && $MODULE neq 'Documents'}
									<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="crmbutton small create" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='{$MODULE}'; this.form.action.value='EditView'" type="submit"  name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}">&nbsp;
							{/if*}
							{*if $DELETE eq 'permitted'*}
							{if ($CURRENT_USER_IS_POSTEUR_DEMANDE neq '0' || $CURRENT_USER_IS_POSTEUR_INCIDENT neq '0' || $CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 ) && $STATUT eq 'open' }
									<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="crmbutton small delete" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='index'; this.form.action.value='Delete'; {if $MODULE eq 'Accounts'} return confirm('{$APP.NTC_ACCOUNT_DELETE_CONFIRMATION}') {else} return confirm('{$APP.NTC_DELETE_CONFIRMATION}') {/if}" type="submit"  name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}">&nbsp;
							{/if}
						{/if}
						{if $privrecord neq ''}
						<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" accessKey="{$APP.LNK_LIST_PREVIOUS}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$privrecord}&parenttab={$CATEGORY}'" name="privrecord" value="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev.gif'|@vtiger_imageurl:$THEME}">&nbsp;
						{else}
						<img align="absmiddle" title="{$APP.LNK_LIST_PREVIOUS}" src="{'rec_prev_disabled.gif'|@vtiger_imageurl:$THEME}">
						{/if}							
						{if $privrecord neq '' || $nextrecord neq ''}
						<img align="absmiddle" title="{$APP.LBL_JUMP_BTN}" accessKey="{$APP.LBL_JUMP_BTN}" onclick="var obj = this;var lhref = getListOfRecords(obj, '{$MODULE}',{$ID},'{$CATEGORY}');" name="jumpBtnIdBottom" id="jumpBtnIdBottom" src="{'rec_jump.gif'|@vtiger_imageurl:$THEME}">&nbsp;
						{/if}
						{if $nextrecord neq ''}
						<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" accessKey="{$APP.LNK_LIST_NEXT}" onclick="location.href='index.php?module={$MODULE}&viewtype={$VIEWTYPE}&action=DetailView&record={$nextrecord}&parenttab={$CATEGORY}'" name="nextrecord" src="{'rec_next.gif'|@vtiger_imageurl:$THEME}">&nbsp;
						{else}
						<img align="absmiddle" title="{$APP.LNK_LIST_NEXT}" src="{'rec_next_disabled.gif'|@vtiger_imageurl:$THEME}">&nbsp;
						{/if}
					</td>
				</tr>
				
			</table>
			</form>
		</td>
	</tr>
	
</table>

{if $MODULE eq 'Products'}
<script language="JavaScript" type="text/javascript" src="modules/Products/Productsslide.js"></script>
<script language="JavaScript" type="text/javascript">Carousel();</script>
{/if}

<script>

function getTagCloud()
{ldelim}
new Ajax.Request(
        'index.php',
        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
        method: 'post',
        postBody: 'module={$MODULE}&action={$MODULE}Ajax&file=TagCloud&ajxaction=GETTAGCLOUD&recordid={$ID}',
        onComplete: function(response) {ldelim}
                                $("tagfields").innerHTML=response.responseText;
                                $("txtbox_tagfields").value ='';
                        {rdelim}
        {rdelim}
);
{rdelim}
getTagCloud();
</script>
<!-- added for validation -->
<script language="javascript">
  var fieldname = new Array({$VALIDATION_DATA_FIELDNAME});
  var fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL});
  var fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE});
</script>
</td>

	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
</tr></table>

{if $MODULE eq 'Leads' or $MODULE eq 'Contacts' or $MODULE eq 'Accounts' or $MODULE eq 'Campaigns' or $MODULE eq 'Vendors'}
	<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;"></div></form>
{/if}

<!-- Add new Folder UI for Documents module starts -->
<script language="JavaScript" type="text/javascript" src="modules/Documents/Documents.js"></script>
<div id="orgLay" style="display:none;width:350px;" class="layerPopup" >
        <table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
	        <tr>
				<td class="genHeaderSmall" nowrap align="left" width="30%" id="editfolder_info">{$MOD.LBL_ADD_NEW_FOLDER}
				</td>
				<td align="right"><a href="javascript:;" onClick="closeFolderCreate();"><img src="{'close.gif'|@vtiger_imageurl:$THEME}" align="absmiddle" border="0"></a>
				</td>
	        </tr>
        </table>
        <table border=0 cellspacing=0 cellpadding=5 width=95% align=center>
        <tr>
			<td class="small">
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
				<tr>
					<td align="right" nowrap class="cellLabel small"><font color='red'>*</font>&nbsp;<b>{$MOD.LBL_FOLDER_NAME}
</b></td>
					<td align="left" class="cellText small">
					<input id="folder_id" name="folderId" type="hidden" value=''>
					<input id="fldrsave_mode" name="folderId" type="hidden" value='save'>
					<input id="folder_name" name="folderName" class="txtBox" type="text"> &nbsp;&nbsp;Maximum 20
					</td>
				</tr>
				<tr>
					<td class="cellLabel small" align="right" nowrap><b>{$MOD.LBL_FOLDER_DESC}</b>
					</td>
 					<td class="cellText small" align="left"><input id="folder_desc" name="folderDesc" class="txtBox" type="text"> &nbsp;&nbsp;Maximum 50
					</td>
				 </tr>
				 <tr>
					<td class="cellLabel small" align="right" nowrap><b>{$MOD.LBL_FOLDER_FATHER}</b>
					</td>
 					<td class="cellText small" align="left">
					<select name="folderFather" tabindex="folder_father" class="small">
						<!--{foreach item=v key=k from=$fldvalue}-->	 
						<option value="1">default</option> 
						<!--{/foreach}-->
					</select>
					</td>
				 </tr>
				</table>
			</td>
        </tr>
 	</table>
 	
	<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
        <tr>
			<td class="small" align="center">
                <input name="save" value=" &nbsp;{$APP.LBL_SAVE_BUTTON_LABEL}&nbsp; " class="crmbutton small save" onClick="AddFolder();" type="button">&nbsp;&nbsp;
                <input name="cancel" value=" {$APP.LBL_CANCEL_BUTTON_LABEL} " class="crmbutton small cancel" onclick="closeFolderCreate();" type="button">
			</td>
        </tr>
	</table>
</div>

<!-- Add new folder UI for Documents module ends -->








