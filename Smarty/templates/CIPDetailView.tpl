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
					{*if $SinglePane_View eq 'false'}
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module={$MODULE}&record={$ID}&parenttab={$CATEGORY}">{$APP.LBL_MORE} {$APP.LBL_INFORMATION}</a></td>
					{/if*}
				
					<td class="dvtTabCache" align="right" style="width:100%">
                    
					{*********************************** NOMADE ***************************************************}
				
					{if  $MODULE eq 'Demandes'}
					
						{if ($IS_CHARGEMISSIONDEMANDE eq '1') && ($STATUT eq 'submitted' && ($STATUT neq 'om_cancelled' || $STATUT neq 'ag_cancelled'))}
						
									<input 
											title="{$MOD.LBL_ANNULER_CHARGEMISSION_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											onclick="this.form.return_module.value='Demandes'; 
													this.form.return_action.value='DetailView'; 
													this.form.module.value='TraitementDemandes';
													this.form.action.value='EditView';
													this.form.statut.value='ch_cancelled';
													this.form.dmd.value='{$ID}'; 
													return AnnulerDemande('Demandes');"
											type="submit" 
											name="Edit" 
											value="&nbsp;{$MOD.LBL_ANNULER_CHARGEMISSION_BUTTON_LABEL}&nbsp;">&nbsp;
						{/if}
						{if ($IS_POSTEURDEMANDE eq '1' || $CURRENT_USER_PROFIL eq '20') && ($STATUT neq 'om_cancelled' || $STATUT neq 'ag_cancelled' || $STATUT neq 'ch_cancelled' || $STATUT neq 'ch_cancelled') }
							<input 
											title="{$MOD.LBL_ANNULER_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											onclick="this.form.return_module.value='Demandes'; 
													this.form.return_action.value='DetailView'; 
													this.form.module.value='TraitementDemandes';
													this.form.action.value='EditView';
													this.form.statut.value='ag_cancelled';
													this.form.dmd.value='{$ID}'; 
													return AnnulerDemande('Demandes');"
											type="submit" 
											name="Edit" 
											value="&nbsp;{$MOD.LBL_ANNULER_BUTTON_LABEL}&nbsp;">&nbsp;
							
							<input 
										title="{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='open';
												this.form.dmd.value='{$ID}'; 
												return remettreDemande('Demandes');" 
									type="submit"  
									name="Edit"
									value="&nbsp;{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}&nbsp;">&nbsp;
							{if $STATUT eq 'open'}
								<input 
									title="{$MOD.LBL_SOUMETTRECC_BUTTON_LABEL}" 
									class="crmbutton small edit" 
									onclick="this.form.return_module.value='Demandes'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementDemandes';
										this.form.action.value='Save';
										this.form.statut.value='sup_submitted';
										this.form.dmd.value='{$ID}'; 
										return soumettreDemandeDC('Demandes');"   
								type="submit"  
								name="Edit" 
								value="&nbsp;{$MOD.LBL_SOUMETTRECC_BUTTON_LABEL}&nbsp;">&nbsp;
											
									
									<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
									<input 
										title="{$MOD.LBL_DUPPLIQUER_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='Demandes';
												this.form.dmd.value='{$ID}'; 
												this.form.statut.value='open';
												this.form.isDuplicate.value='true';
												this.form.action.value='EditView';" 
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_DUPPLIQUER_BUTTON_LABEL}&nbsp;">&nbsp;
						
							{/if}	
								
						{/if}	
						{*if $CURRENT_USER_PROFIL neq '20' && $STATUT neq 'ag_cancelled' && $STATUT neq 'ch_cancelled' && $STATUT neq 'open' }
								<input 
									title="{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}" 
									class="crmbutton small edit" 
									
									onclick="this.form.return_module.value='Demandes'; 
										this.form.return_action.value='DetailView'; 
										this.form.module.value='TraitementDemandes';
										this.form.action.value='Save';
										this.form.statut.value='open';
										this.form.dmd.value='{$ID}'; 
										return remettreDemande('Demandes');"   
								type="submit"  
								name="Edit"
									value="&nbsp;{$MOD.LBL_REMETTREENPREPA_BUTTON_LABEL}&nbsp;">&nbsp;
									
						{/if*}
					{if  ($CURRENT_USER_PROFIL eq '22' || $CURRENT_USER_PROFIL eq '20' || $IS_INTERIMDIRCAB eq '1') && $STATUT eq 'sup_submitted'} {*    PROFIL DIRCAB *}
						<input 
										title="{$MOD.LBL_REJET_SUP_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='dc_denied';
												this.form.dmd.value='{$ID}'; 
												return RejeterDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_SUP_BUTTON_LABEL}&nbsp;">&nbsp;
																		
						<input 
										title="{$MOD.LBL_VISER_SUP_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='dcpc_submitted';
											this.form.dmd.value='{$ID}'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_SUP_BUTTON_LABEL}&nbsp;">&nbsp;
						<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;

					{/if}
						
					
					
					{if  ($IS_DIRCABPCOM eq '1' || $IS_INTERIMDIRCABPCOM eq '1' ) && ($STATUT eq 'dcpc_submitted')} 
						<input 
										title="{$MOD.LBL_REJET_DCPC_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='dcpc_denied';
												this.form.dmd.value='{$ID}'; 
												this.form.reserver.value='true';
												return RejeterDemande('Demandes');" 
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_DCPC_BUTTON_LABEL}&nbsp;">&nbsp;
																		
						<input 
										title="{$MOD.LBL_VISER_DCPC_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='dc_authorized';
											this.form.dmd.value='{$ID}'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_DCPC_BUTTON_LABEL}&nbsp;">&nbsp;
										
						
						{/if}					
					
					
					{if  ($CURRENT_USER_PROFIL eq '26'  || $CURRENT_USER_PROFIL eq '20' || $IS_INTERIMRUMV eq '1') && $STATUT neq 'om_cancelled'} 
								
							{if  $STATUT eq 'dc_authorized'}
								<input 
										title="{$MOD.LBL_REJET_UMV_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='open';
												this.form.dmd.value='{$ID}'; 
												return RejeterDemande('Demandes');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REJET_UMV_BUTTON_LABEL}&nbsp;">&nbsp;
																		
								<input 
										title="{$MOD.LBL_VISER_UMV_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='rumv_accepted';
											this.form.dmd.value='{$ID}'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_VISER_UMV_BUTTON_LABEL}&nbsp;">&nbsp;
							{/if}
							
										
							{if  $STATUT neq 'open'}
								<input 
										title="{$MOD.LBL_REMETTREENPREPA_UMV_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='open';
												this.form.dmd.value='{$ID}'; 
												return remettreDemande('Demandes');" 
									type="submit"  
									name="Edit"
									value="&nbsp;{$MOD.LBL_REMETTREENPREPA_UMV_BUTTON_LABEL}&nbsp;">&nbsp;
							{/if}
							<!--input 
										title="{$MOD.LBL_REMISESIGNE_UMV_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='dcpc_submitted';
											this.form.dmd.value='{$ID}'; 
											return ViserDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REMISESIGNE_UMV_BUTTON_LABEL}&nbsp;"-->&nbsp;
							<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;

					{/if}
					
					{if  ($CURRENT_USER_PROFIL eq '27'  || $CURRENT_USER_PROFIL eq '20' || $IS_INTERIMRUMV eq '1') && ($STATUT eq 'rumv_accepted')}	{*    PROFIL AGENT UMV *}
							<input 
										title="{$MOD.LBL_GENEREROM_BUTTON_LABEL}" 
										class="crmbutton small edit" 

										onclick="this.form.return_module.value='OrdresMission'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='OrdresMission';
												this.form.dmd.value='{$ID}'; 
												this.form.statut.value='omgenered';
												this.form.opt.value='omgenered';
												this.form.action.value='EditView';
												this.form.mode.value='create_view';" 
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_GENEREROM_BUTTON_LABEL}&nbsp;">&nbsp;
										
							<input 
										title="{$MOD.LBL_REMETTREOMGENERE_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='TraitementDemandes';
											this.form.action.value='Save';
											this.form.statut.value='omgenered';
											this.form.dmd.value='{$ID}'; 
											return MettreOMgenereDemande('Demandes');"   
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_REMETTREOMGENERE_BUTTON_LABEL}&nbsp;">&nbsp;

					{/if}
					{if  ($CURRENT_USER_PROFIL eq '27'  || $CURRENT_USER_PROFIL eq '20') && $STATUT eq 'omgenered'}	{*    PROFIL AGENT UMV *}
								<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_EDIT_BUTTON_LABEL}&nbsp;">&nbsp;
					{/if}							
					{if $MODULE eq 'OrdresMission' && $STATUTOM neq 'om_cancelled'}
							<input 
										title="{$MOD.LBL_CANCELMISSION_BUTTON_LABEL}" 
										class="crmbutton small edit" 
										onclick="this.form.return_module.value='Demandes'; 
												this.form.return_action.value='DetailView'; 
												this.form.module.value='TraitementDemandes';
												this.form.action.value='EditView';
												this.form.statut.value='om_cancelled';
												this.form.dmd.value='{$ID}'; 
												return AnnulerMission('OrdresMission');"
										type="submit" 
										name="Edit" 
										value="&nbsp;{$MOD.LBL_CANCELMISSION_BUTTON_LABEL}&nbsp;">&nbsp;
							
							
							<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="crmbutton small edit" onclick="this.form.return_module.value='{$MODULE}'; this.form.return_action.value='DetailView'; this.form.return_id.value='{$ID}';this.form.module.value='{$MODULE}';this.form.action.value='EditView';this.form.mode.value='edit_view'" type="submit" name="Edit" value="&nbsp;{$APP.LBL_MODIF_OM_BUTTON_LABEL}&nbsp;">&nbsp;

							<input title="{$MOD.LBL_OMVERSO_BUTTON_LABEL}" class="crmbutton small edit" 
										onclick="window.open('http://ouavlibre01/portailnomade/ordremission/ordremission.php?demandeid={$ID}','','');return false;"   
										type="submit"  
										name="Edit" 
										value="&nbsp;{$MOD.LBL_OMRECTOVERSO_BUTTON_LABEL}&nbsp;">&nbsp;
										
							<input title="{$MOD.LBL_OMDECOMPTE_BUTTON_LABEL}" class="crmbutton small edit" 
										onclick="window.open('http://ouavlibre01/portailnomade/ordremission/decompte.php?demandeid={$ID}','','');return false;"   
										type="submit"  
										name="Edit" 
										value="&nbsp;{$MOD.LBL_OMDECOMPTE_BUTTON_LABEL}&nbsp;">&nbsp;
										
							
							
																
					{/if}

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
				<tr><td> 
			 <div id="divaddprodfin" style="display:none;">
			 <input type="hidden" id="numconvention" value={$TICKET}></input>
				 <table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
					<tr>
		 				<td class="big3" colspan=5>Ajout d'un produit financier</td>
					</tr>
					<tr>
						<td class="lvtCol">Libell&eacute;</td>
		 				<td class="lvtCol">montant</td>
		 				<td class="lvtCol">Date Effet</td>
		 				<td class="lvtCol">Date Saisie</td>
					</tr>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
					<td><input name="libelleprodfin"  id="libelleprodfin" class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="montantprodfin" id="montantprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="dateeffetprodfin" id="jscal_field_dateeffetprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
						<img src="{'btnL3Calendar.gif'|@vtiger_imageurl:$THEME}" id="jscal_trigger_dateeffetprodfin">
					</td>
					<td><input name="dateprodfin" id="jscal_field_dateprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
						<img src="{'btnL3Calendar.gif'|@vtiger_imageurl:$THEME}" id="jscal_trigger_dateprodfin">
					</td>
					</tr>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
						<td colspan="4" align="center">
							<input type="button" name="submit1" value="Enregister" onclick="saveaddprofin()" >
							<input type="button" name="cancel" value="Annuler" onclick="canceladdprofin()">

						</td>
					</tr>
				</table>
					<script type="text/javascript" id='massedit_calendar_dateeffetprodfin'>
					Calendar.setup ({ldelim}
						inputField : "jscal_field_dateeffetprodfin", ifFormat : "%d-%m-%Y", showsTime : false, button : "jscal_trigger_dateeffetprodfin", singleClick : true, step : 1
					{rdelim})
				</script>
				<script type="text/javascript" id='massedit_calendar_dateprodfin'>
					Calendar.setup ({ldelim}
						inputField : "jscal_field_dateprodfin", ifFormat : "%d-%m-%Y", showsTime : false, button : "jscal_trigger_dateprodfin", singleClick : true, step : 1
					{rdelim})
				</script>
			</div>
			</td>
			</tr>	
			</form>
			<form action="index.php" method="post" name="DetailView" id="form3">
				<tr>
					{if $MODULE eq 'OrdresMission'}
					<td class="dvtTabCache" style="width:10px" nowrap>
					[<img src="{'arrow_left.png'|@vtiger_imageurl:$THEME}" border=0> <a href="index.php?module=Demandes&action=DetailView&record={$MOD_SEQ_ID}">Retour à la demande</a> ]
					</td>
					{/if}</tr>
			{if $MODULE eq 'OrdresMission' && ($STATUTOM eq 'om_cancelled' ||  $STATUTOM eq 'dcpc_omcancelled')}
					<tr><td  class="omcancelled" width=180 height=40 >{$APP.$STATUTOM}</td></tr>
			{/if}	
		{if $MODULE == 'Demandes' }
			{if $STATUT eq 'open'}
				<tr><td align="left" ><img src="{'open_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}	
			{if $STATUT eq 'ag_cancelled' || $STATUT eq 'ch_cancelled'}
				<tr><td align="left" ><img src="{'ag_cancelled_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			{if $STATUT eq 'sup_submitted'}
				<tr><td align="left" ><img src="{'submitted_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			{if $STATUT eq 'signed'}
				<tr><td align="left" ><img src="{'signed_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}	
			{if $STATUT eq 'authorized'}
				<tr><td align="left" ><img src="{'authorized_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
			
			{if $STATUT eq 'umv_denied' }
				<tr><td align="left" ><img src="{'umv_denied_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
			{if $STATUT eq 'umv_accepted'}
				<tr><td align="left" ><img src="{'umv_accepted_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			{/if}
			{if $STATUT eq 'omgenered' }
				<tr><td align="left" ><img src="{'omgenered_cip.png'|@vtiger_imageurl:$THEME}"></td></tr>
			{/if}
			
			<tr><td align="right" ><a href="index.php?action=ListView&module=OrdresMission&matricule_field={$AGENTMATRICULE}&filterMissionAgent=true">Voir les missions ant&eacute;rieures de l'agent</a><td></tr>

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
							{if $header== $MOD.LBL_AGENTS_COORDONNEES_BANQUAIRES && $MODULE == 'Agentuemoa'}
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
																	 
								 
								 {***************************************** NOMADE **********************************************************}
								 
								  {elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_2 && $MODULE == 'Demandes'}
									<tr id="lignebudget2header" style="{$DISPLAY_LIGNEBUDGET2}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 {elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_3 && $MODULE == 'Demandes'}
									<tr id="lignebudget3header" style="{$DISPLAY_LIGNEBUDGET3}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 {elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_4 && $MODULE == 'Demandes'}
									<tr id="lignebudget4header" style="{$DISPLAY_LIGNEBUDGET4}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 {elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_5 && $MODULE == 'Demandes'}
									<tr id="lignebudget5header" style="{$DISPLAY_LIGNEBUDGET5}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								  {elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_2 && $MODULE == 'Demandes'}
									<tr id="justif2header" style="{$DISPLAY_JUSTIFS2}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>

								 
								{elseif $header== $MOD.LBL_TRAJET2_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet2header" style="{$DISPLAY_TRAJET2}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 
								 {elseif $header== $MOD.LBL_TRAJET3_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet3header" style="{$DISPLAY_TRAJET3}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 
								 {elseif $header== $MOD.LBL_TRAJET4_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet4header" style="{$DISPLAY_TRAJET4}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 
								 {elseif $header== $MOD.LBL_TRAJET5_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet5header" style="{$DISPLAY_TRAJET5}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>

								 
								 {elseif $header== $MOD.LBL_TRAJET6_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet6header" style="{$DISPLAY_TRAJET6}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 
								 {elseif $header== $MOD.LBL_TRAJET7_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet7header" style="{$DISPLAY_TRAJET7}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								 
								 {elseif $header== $MOD.LBL_TRAJET8_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet8header" style="{$DISPLAY_TRAJET8}">		
									<td colspan=2 class="detailedViewHeader">
												<b>{$header}</b>
											</td>
								 </tr>
								  {***************************************** FIN NOMADE **********************************************************}
								 
							<!-- This is added to display the existing comments -->
							{elseif $header eq $MOD.LBL_COMMENTS || $header eq $MOD.LBL_COMMENT_INFORMATION}
							   <tr>
								<td colspan=4 class="dvInnerHeader">
						        	<b>{$MOD.LBL_COMMENT_INFORMATION}</b>
								</td>
							   </tr>
							   <tr>
							   			<td colspan=4 class="dvtCellInfo">{$COMMENT_BLOCK}</td>
							   </tr>
							   <!--tr><td>&nbsp;</td></tr-->


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
								 {if $header== $MOD.LBL_DEMANDE_INFORMATION && $MODULE == 'Demandes'}

									<td id="statutdem" class="detailedViewHeader" align="right" style="display:none" >
										<select name="statutdemande" id="statutdemande"  tabindex="{$vt_tab}" class="small" onchange="showformtraintement1();">
											<option value="1">Livr&eacute;</option>
											<option selected value="0">Non Livr&eacute;</option>
										</select>
								</td>
								{/if}
								{if $header== $MOD.LBL_DEMANDE_INFORMATION && $DISPLAY_LIVRAISON1.statut== '1' && $MODULE == 'Demandes' && $CURRENT_USER_PROFIL_ID eq 20}
									<td align="right" ><img src="{'delivered.png'|@vtiger_imageurl:$THEME}"></td>
								{/if}
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
									
								{************************************* NOMADE *******************************************}
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_2 && $MODULE == 'Demandes'}
									<tr id="lignebudget2fields_{$label}" style="{$DISPLAY_LIGNEBUDGET2} height:25px">		
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_3 && $MODULE == 'Demandes'}
									<tr id="lignebudget3fields_{$label}" style="{$DISPLAY_LIGNEBUDGET3} height:25px">
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_4 && $MODULE == 'Demandes'}
									<tr id="lignebudget4fields_{$label}" style="{$DISPLAY_LIGNEBUDGET4} height:25px">
								{elseif $header== $MOD.LBL_LIGNE_BUDGETAIRE_5 && $MODULE == 'Demandes'}
									<tr id="lignebudget5fields_{$label}" style="{$DISPLAY_LIGNEBUDGET5} height:25px">
								{elseif $header== $MOD.LBL_FILE_JUSTIFICATIF_2 && $MODULE == 'Demandes'}
									<tr id="justif2fields_{$label}" style="{$DISPLAY_JUSTIFS2} height:25px">	

								{elseif $header== $MOD.LBL_TRAJET2_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet2fields_{$label}" style="{$DISPLAY_TRAJET2} height:25px">
								{elseif $header== $MOD.LBL_TRAJET3_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet3fields_{$label}" style="{$DISPLAY_TRAJET3} height:25px">
								{elseif $header== $MOD.LBL_TRAJET4_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet4fields_{$label}" style="{$DISPLAY_TRAJET4} height:25px">
								{elseif $header== $MOD.LBL_TRAJET5_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet5fields_{$label}" style="{$DISPLAY_TRAJET5} height:25px">
								{elseif $header== $MOD.LBL_TRAJET6_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet6fields_{$label}" style="{$DISPLAY_TRAJET6} height:25px">
								{elseif $header== $MOD.LBL_TRAJET7_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet7fields_{$label}" style="{$DISPLAY_TRAJET7} height:25px">
								{elseif $header== $MOD.LBL_TRAJET8_INFORMATION && $MODULE == 'OrdresMission'}
									<tr id="trajet8fields_{$label}" style="{$DISPLAY_TRAJET8} height:25px">									
								{************************************* FIN NOMADE *******************************************}	
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
								

								{if ( $CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 20 ) }
								{if  $header== $MOD.LBL_DEMANDE_INFORMATION && $MODULE == 'Demandes'}
									<tr id="headtraitement1" style="display:none">		
										<td colspan=4 class="detailedViewHeader2">
													<b>D&eacute;tail de la livraison</b>
												</td>
									</tr>
									<tr height="25" id="info1traitement1" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Description Article</td>
									<td width=25% class="dvtCellInfo" align="left">	
										<input type="text" name="descarticle1" id="descarticle1" tabindex="{$vt_tab}"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									<td class="dvtCellLabel" align=right width=25%>N° de s&eacute;rie </td>
									<td width=25% class="dvtCellInfo" align="left">
										<input type="text" name="numserie1" id="numserie1" tabindex="{$vt_tab}"  class=detailedViewTextBox onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'">
									</td>
									</tr>
									<tr height="25" id="info2traitement1" style="display:none">
									<td class="dvtCellLabel" align=right width=25%>Commentaire</td>
									<td width=25% class="dvtCellInfo" align="left" colspan=3>
										<textarea class="detailedViewTextBox" name="comment1" id="comment1" tabindex="{$vt_tab}" onFocus="this.className='detailedViewTextBoxOn'"   onBlur="this.className='detailedViewTextBox'" cols="110" rows="12"></textarea>
									</td>
									
									</tr>
							{/if}
							
					{/if}	
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
				{if $MODULE eq 'Demandes' || $MODULE eq 'OrdresMission'}
					<tr><td class="small"><b><u>Initiateur demande</u> : {$POSTEURDEMANDE}<b></td></tr>	
				{/if}	
				{if $MODULE eq 'OrdresMission' || $MODULE eq 'Demandes'}
					
				<tr><td>
			<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> INFORMATION DISPONIBITE DES CREDITS</caption>
					
				{if $BUDGETDISP.msgErreurSap eq ''}	
					<tr align=center>		
							<td class="detailedViewHeader2"><b>Code Budgétaire</b></td>
							<td class="detailedViewHeader2"><b>Source de Financement</b></td>
							<td class="detailedViewHeader2"><b>Compte Nature</b></td>
							<td class="detailedViewHeader2"><b>Autorisation d'engagement</b></td>
							<td class="detailedViewHeader2"><b>Montant Engagé</b></td>
							<td class="detailedViewHeader2"><b>Montant Disponible</b></td>
					</tr>
					{foreach from=$BUDGETDISP item=budget key=codebudget}
						{if $codebudget neq 'msgErreurSap'}
							{foreach from=$budget item=line key=cmptnat}
								<tr align=center>
									<td class="detailedViewHeader2">{$line.codebudget}</td>
									<td class="detailedViewHeader2">{$line.sourcefin}</td>
									<td class="detailedViewHeader2">{$line.comptenat}</td>
									<td class="detailedViewHeader2">{$line.fonddisp|number_format:0:",":" "}</td>
									<td class="detailedViewHeader2">{$line.fondengage|number_format:0:",":" "}</td>
									<td class="detailedViewHeader2">{$line.mntdispo|number_format:0:",":" "}</td>
								</tr>	
							{/foreach}
						{/if}
					{/foreach}
				{else}
					<tr>
						<td colspan=6 class="detailedViewHeader2" align=center>
							<font color='red'><b>{$BUDGETDISP.msgErreurSap}</b></font>
						</td>
						
					</tr>
				{/if}
				</table>
		</div>
			
			</td></tr>	
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
			{if $MODULE eq 'Demandes' && $NBTRAITEMENT gte 0}
 				{include file='ListViewTraitementDemande.tpl'}
 			{elseif $MODULE eq 'Incidents' && $NBTRAITEMENT gte 0}
 				{include file='ListViewTraitementIncident.tpl'}
			{elseif $MODULE eq 'Conventions' && $NBTRAITEMENT gte 0}
 				{include file='ListViewTraitementConvention.tpl'}	
 			{/if}
		</table>
		
		{if $MODULE eq 'OrdresMission'}
		<div id='divdecompteview'>
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
				<caption class="big2" align=center> RECAPITULATIF DE LA DECOMPTE</caption>
					{if  ( $CURRENT_USER_PROFIL eq '27' || $CURRENT_USER_PROFIL eq '26'  || $CURRENT_USER_PROFIL eq '20') && $STATUTOM neq 'om_cancelled'}
					<tr><td colspan=9 align=right>
							<input title="{$MOD.LBL_MODIFDECOMPTE_BUTTON_LABEL}" class="crmbutton small edit" 
												onclick="return modifierDecompte({$ID});"   
												type="button"  
												name="Edit" 
												value="&nbsp;{$MOD.LBL_MODIFDECOMPTE_BUTTON_LABEL}&nbsp;">&nbsp;
												
					</td></tr>
				{/if}
				<tr align=center>		
						<td class="detailedViewHeader2" rowspan=2><b>Lieu</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Indemnit&eacute;</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Hébergement</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Transport</b></td>

						<td class="detailedViewHeader2" rowspan=2><b>Total</b></td>
					</tr>
					<tr align=center>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						{assign var='totaldecomte' value=0}
						{foreach from=$DECOMPTES item=decompte}

							<tr align=center>		
								<td class="dvtCellInfo"><b>{$decompte.zone}</b></td>
								<td class="dvtCellInfo">{$decompte.nbjindemn}</td>
								<td class="dvtCellInfo">{$decompte.indemnite|number_format:0:",":" "}</td>
								<td class="dvtCellInfo">{$decompte.nbjheberg}</td>
								<td class="dvtCellInfo">{$decompte.herbergement|number_format:0:",":" "}</td>
								<td class="dvtCellInfo">{$decompte.nbjtransp}</td>
								<td class="dvtCellInfo">{$decompte.transport|number_format:0:",":" "}</td>
								<td class="dvtCellInfo"><b>{$decompte.mnttotal|number_format:0:",":" "}</b></td>
							</tr>	
							 {assign var='totaldecomte' value=$totaldecomte+$decompte.mnttotal}
						{/foreach}	
					<tr align=center>		
								<td class="dvtCellInfo" colspan=7 align=right><b>TOTAL DECOMPTE</b></td>
								<td class="dvtCellInfo" ><b>{$totaldecomte|number_format:0:",":" "}</b></td>
							</tr>	
				</table>
		</div>	
		<br>
		<div id='divdecompteedit' style="display:none" >
				<table width="90%" align=center border=1 cellspacing=1 cellpadding=3 width=100% class="lvt small" valign=top>
					{if   ($CURRENT_USER_PROFIL eq '27' || $CURRENT_USER_PROFIL eq '26'  || $CURRENT_USER_PROFIL eq '20') && $STATUTOM neq 'om_cancelled'}
				<tr><td colspan=9 align=right>
						<input title="{$MOD.LBL_SAVEMODIFDECOMPTE_BUTTON_LABEL}" class="crmbutton small edit" 
											onclick="this.form.return_module.value='OrdresMission'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='OrdresMission';
											this.form.action.value='SaveDecompte';
											this.form.dmd.value='{$ID}'; 
											return saveModifDecompte('OrdresMission');"   
									type="submit"  
									name="Edit" 
											value="&nbsp;{$MOD.LBL_SAVEMODIFDECOMPTE_BUTTON_LABEL}&nbsp;">&nbsp;
				<input title="{$MOD.LBL_CANCELMODIFDECOMPTE_BUTTON_LABEL}" class="crmbutton small edit" 
											onclick="return AnnulermodifierDecompte({$ID});"   
											type="button"  
											name="Edit" 
											value="&nbsp;{$MOD.LBL_CANCELMODIFDECOMPTE_BUTTON_LABEL}&nbsp;">&nbsp;							
				</td></tr>
				{/if}
				<tr align=center>		
						<td class="detailedViewHeader2" rowspan=2><b>Lieu</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Indemnit&eacute;</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Hébergement</b></td>
						<td class="detailedViewHeader2" colspan=2><b>Transport</b></td>

					</tr>
					<tr align=center>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						<td class="detailedViewHeader2">Nbjours</td>
						<td class="detailedViewHeader2">Taux</td>
						{assign var='totaldecomte' value=0}
						{foreach from=$DECOMPTES item=decompte key=k}

							<tr align=center>		
								<td class="dvtCellInfo" nowrap><b>{$decompte.zone}</b></td>
								<td class="dvtCellInfo"><input type="text" name="nbjindemn_{$k}" id="nbjindemn_{$k}" value="{$decompte.nbjindemn}" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="indemnite_{$k}" id="indemnite_{$k}" value="{$decompte.indemnite}" class=detailedViewTextBox size=30/></td>
								<td class="dvtCellInfo"><input type="text" name="nbjheberg_{$k}" id="nbjheberg_{$k}" value="{$decompte.nbjheberg}" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="herbergement_{$k}" id="herbergement_{$k}" value="{$decompte.herbergement}" class=detailedViewTextBox size=30/></td>
								<td class="dvtCellInfo"><input type="text" name="nbjtransp_{$k}" id="nbjtransp_{$k}" value="{$decompte.nbjtransp}" class=detailedViewTextBox size=10/></td>
								<td class="dvtCellInfo"><input type="text" name="transport_{$k}" id="transport_{$k}" value="{$decompte.transport}" class=detailedViewTextBox size=30/></td>
					 
								<input type="hidden" id="zonetrajet_{$k}" name="zonetrajet_{$k}" value="{$decompte.zone}"></input>
							
							</tr>	
						{/foreach}	
					
				</table>
		</div>
		
				 <input type="hidden" id="nbzonetrajet" name="nbzonetrajet" value={$DECOMPTES|@count}></input>

		{/if}
		
		 <input type="hidden" id="demandeid" name="demandeid" value={$ID}></input>
		<input type="hidden" id="demandeticket" name="demandeticket" value={$TICKET}></input>
			<div id="savetraitbut" style="display:none" align=center >
						<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="traitementbut" onclick="if(!verifSaveTraitement()) return false; this.form.action.value='SaveTraitement'" type="submit" name="button" value="Enregistrer Livraison" >
            </div>
		</td>
		<!--
		<td width=22% valign=top style="border-left:1px dashed #cccccc;padding:13px">
				  
			
			{if $MODULE eq 'Potentials' || $MODULE eq 'HelpDesk' || $MODULE eq 'Contacts' || $MODULE eq 'Accounts' || $MODULE eq 'Leads' || (($MODULE eq 'Documents' || $MODULE eq 'HReports')  && ($ADMIN eq 'yes' || $FILE_STATUS eq '1'))}
  			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr><td>&nbsp;</td></tr>				
								
				{if $MODULE eq 'HelpDesk'}
					{if $CONVERTASFAQ eq 'permitted'}
				<tr><td align="left" class="genHeaderSmall">{$APP.LBL_ACTIONS}</td></tr>				
				<tr>
					<td align="left" style="padding-left:10px;"> 
						<a class="webMnu" href="index.php?return_module={$MODULE}&return_action=DetailView&record={$ID}&return_id={$ID}&module={$MODULE}&action=ConvertAsFAQ"><img src="{'convert.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle"  border="0"/></a>
						<a class="webMnu" href="index.php?return_module={$MODULE}&return_action=DetailView&record={$ID}&return_id={$ID}&module={$MODULE}&action=ConvertAsFAQ">{$MOD.LBL_CONVERT_AS_FAQ_BUTTON_LABEL}</a>
					</td>
				</tr>
					{/if}		
				{elseif $MODULE eq 'Potentials'}
						{if $CONVERTINVOICE eq 'permitted'}
				<tr><td align="left" class="genHeaderSmall">{$APP.LBL_ACTIONS}</td></tr>				
				<tr>
					<td align="left" style="padding-left:10px;"> 
						<a class="webMnu" href="index.php?return_module={$MODULE}&return_action=DetailView&return_id={$ID}&convertmode={$CONVERTMODE}&module=Invoice&action=EditView&account_id={$ACCOUNTID}"><img src="{'actionGenerateInvoice.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle"  border="0"/></a>
						<a class="webMnu" href="index.php?return_module={$MODULE}&return_action=DetailView&return_id={$ID}&convertmode={$CONVERTMODE}&module=Invoice&action=EditView&account_id={$ACCOUNTID}">{$APP.LBL_CREATE} {$APP.Invoice}</a>
					</td>
				</tr>
						{/if}
				{elseif $TODO_PERMISSION eq 'true' || $EVENT_PERMISSION eq 'true' || $CONTACT_PERMISSION eq 'true'|| $MODULE eq 'Contacts' || ($MODULE eq 'Documents')}                              
				<tr><td align="left" class="genHeaderSmall">{$APP.LBL_ACTIONS}</td></tr>
						
					{if $MODULE eq 'Contacts'}
						{assign var=subst value="contact_id"}
						{assign var=acc value="&account_id=$accountid"}
					{else}
						{assign var=subst value="parent_id"}
						{assign var=acc value=""}
					{/if}			
				
					{if $MODULE eq 'Leads' || $MODULE eq 'Contacts' || $MODULE eq 'Accounts'}
						{if $SENDMAILBUTTON eq 'permitted'}						
					<tr>
						<td align="left" style="padding-left:10px;"> 
							<input type="hidden" name="pri_email" value="{$EMAIL1}"/>
							<input type="hidden" name="sec_email" value="{$EMAIL2}"/>
							<a href="javascript:void(0);" class="webMnu" onclick="if(LTrim('{$EMAIL1}') !='' || LTrim('{$EMAIL2}') !=''){ldelim}fnvshobj(this,'sendmail_cont');sendmail('{$MODULE}',{$ID}){rdelim}else{ldelim}OpenCompose('','create'){rdelim}"><img src="{'sendmail.png'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle"  border="0"/></a>&nbsp;
							<a href="javascript:void(0);" class="webMnu" onclick="if(LTrim('{$EMAIL1}') !='' || LTrim('{$EMAIL2}') !=''){ldelim}fnvshobj(this,'sendmail_cont');sendmail('{$MODULE}',{$ID}){rdelim}else{ldelim}OpenCompose('','create'){rdelim}">{$APP.LBL_SENDMAIL_BUTTON_LABEL}</a>
						</td>
					</tr>
						{/if}
					{/if}
					
					{if $MODULE eq 'Contacts' || $EVENT_PERMISSION eq 'true'}	
					<tr>
						<td align="left" style="padding-left:10px;"> 
				        	<a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Events&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu"><img src="{'AddEvent.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle"  border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Events&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu">{$APP.LBL_ADD_NEW} {$APP.Event}</a>
						</td>
					</tr>
					{/if}
		
					{if $TODO_PERMISSION eq 'true' && ($MODULE eq 'Accounts' || $MODULE eq 'Leads')}
					<tr>
						<td align="left" style="padding-left:10px;">
					        <a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Task&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu"><img src="{'AddToDo.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle" border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Task&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu">{$APP.LBL_ADD_NEW} {$APP.Todo}</a>
						</td>
					</tr>
					{/if}
		
					{if $MODULE eq 'Contacts' && $CONTACT_PERMISSION eq 'true'}
					<tr>
						<td align="left" style="padding-left:10px;">
					        <a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Task&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu"><img src="{'AddToDo.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle" border="0"/></a>
							<a href="index.php?module=Calendar&action=EditView&return_module={$MODULE}&return_action=DetailView&activity_mode=Task&return_id={$ID}&{$subst}={$ID}{$acc}&parenttab={$CATEGORY}" class="webMnu">{$APP.LBL_ADD_NEW} {$APP.Todo}</a>
						</td>
					</tr>
					{/if}							
					
					{if $MODULE eq 'Leads'}
						{if $CONVERTLEAD eq 'permitted'}
					<tr>
						<td align="left" style="padding-left:10px;">
							<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('{$ID}');"><img src="{'convert.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle"  border="0"/></a>
							<a href="javascript:void(0);" class="webMnu" onclick="callConvertLeadDiv('{$ID}');">{$APP.LBL_CONVERT_BUTTON_LABEL}</a>
						</td>
					</tr>
						{/if}
					{/if}
					
				
					{if $MODULE eq 'Documents' || $MODULE eq 'HReports'  }
		                                <tr><td align="left" style="padding-left:10px;">			        
						{if $FILE_STATUS eq '1'}	
							<br><a href="index.php?module=uploads&action=downloadfile&fileid={$FILEID}&entityid={$NOTESID}"  onclick="javascript:dldCntIncrease({$NOTESID});" class="webMnu"><img src="{'fbDownload.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle" title="{$APP.LNK_DOWNLOAD}" border="0"/></a>
		                    <a href="index.php?module=uploads&action=downloadfile&fileid={$FILEID}&entityid={$NOTESID}" onclick="javascript:dldCntIncrease({$NOTESID});">{$MOD.LBL_DOWNLOAD_FILE}</a>
						{elseif $DLD_TYPE eq 'E' && $FILE_STATUS eq '1'}
							<br><a target="_blank" href="{$DLD_PATH}" onclick="javascript:dldCntIncrease({$NOTESID});"><img src="{'fbDownload.gif'|@vtiger_imageurl:$THEME}"" align="absmiddle" title="{$APP.LNK_DOWNLOAD}" border="0"></a>
							<a target="_blank" href="{$DLD_PATH}" onclick="javascript:dldCntIncrease({$NOTESID});">{$MOD.LBL_DOWNLOAD_FILE}</a>
						
						{/if}
						</td></tr>
						{if $CHECK_INTEGRITY_PERMISSION eq 'yes'}
							<tr><td align="left" style="padding-left:10px;">	
							<br><a href="javascript:;" onClick="checkFileIntegrityDetailView({$NOTESID});"><img id="CheckIntegrity_img_id" src="{'yes.gif'|@vtiger_imageurl:$THEME}" alt="Check integrity of this file" title="Check integrity of this file" hspace="5" align="absmiddle" border="0"/></a>
		                    <a href="javascript:;" onClick="checkFileIntegrityDetailView({$NOTESID});">{$MOD.LBL_CHECK_INTEGRITY}</a>&nbsp;
		                    <input type="hidden" id="dldfilename" name="dldfilename" value="{$FILENAME}">
		                    <span id="vtbusy_integrity_info" style="display:none;">
								<img src="{'vtbusy.gif'|@vtiger_imageurl:$THEME}" border="0"></span>
							<span id="integrity_result" style="display:none"></span>						
							</td></tr>
						{/if}
						<tr><td align="left" style="padding-left:10px;">			        
						{if $DLD_TYPE eq 'I'}	
							<input type="hidden" id="dldfilename" name="dldfilename" value="{$FILENAME}">
							<br><a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value={$NOTESID}; document.DetailView.return_id.value={$NOTESID}; sendfile_email();" class="webMnu"><img src="{'attachment.gif'|@vtiger_imageurl:$THEME}" hspace="5" align="absmiddle" border="0"/></a>
		                    <a href="javascript: document.DetailView.return_module.value='Documents'; document.DetailView.return_action.value='DetailView'; document.DetailView.module.value='Documents'; document.DetailView.action.value='EmailFile'; document.DetailView.record.value={$NOTESID}; document.DetailView.return_id.value={$NOTESID}; sendfile_email();">{$MOD.LBL_EMAIL_FILE}</a>                                      
						{/if}
						</td></tr>
						<tr><td>&nbsp;</td></tr>
					
						{/if}
					{/if}
					
			
                  </table>
                <br>
			{/if}
		
			{* vtlib customization: Custom links on the Detail view *}
			{if $CUSTOM_LINKS}
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr><td align="left" class="dvtUnSelectedCell dvtCellLabel">
					<a href="javascript:;" onmouseover="fnvshobj(this,'vtlib_customLinksLay');" onclick="fnvshobj(this,'vtlib_customLinksLay');"><b>{$APP.LBL_MORE} {$APP.LBL_ACTIONS} &#187;</b></a>
				</td></tr>
			</table>
			<br>
			<div style="display: none; left: 193px; top: 106px;width:155px; position:absolute;" id="vtlib_customLinksLay" 
				onmouseout="fninvsh('vtlib_customLinksLay')" onmouseover="fnvshNrm('vtlib_customLinksLay')">
				<table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr><td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b>{$APP.LBL_MORE} {$APP.LBL_ACTIONS} &#187;</b></td></tr>
				<tr>
					<td>
						{foreach item=CUSTOMLINK from=$CUSTOM_LINKS}
							{assign var="customlink_href" value=$CUSTOMLINK->linkurl}
							{assign var="customlink_label" value=$CUSTOMLINK->linklabel}
							{if $customlink_label eq ''}
								{assign var="customlink_label" value=$customlink_href}
							{else}
								{* Pickup the translated label provided by the module *}
								{assign var="customlink_label" value=$customlink_label|@getTranslatedString:$customlink_module}
							{/if}
							<a href="{$customlink_href}" class="drop_down">{$customlink_label}</a>
						{/foreach}
					</td>
				</tr>
				</table>
			</div>
			{/if}
		{* END *}
         			</form>
       

		{if $TAG_CLOUD_DISPLAY eq 'true'}
		
		<table border=0 cellspacing=0 cellpadding=0 width=100% class="tagCloud">
		<tr>
			<td class="tagCloudTopBg"><img src="{$IMAGE_PATH}tagCloudName.gif" border=0></td>
		</tr>
		<tr>
              		<td><div id="tagdiv" style="display:visible;"><form method="POST" action="javascript:void(0);" onsubmit="return tagvalidate();"><input class="textbox"  type="text" id="txtbox_tagfields" name="textbox_First Name" value="" style="width:100px;margin-left:5px;"></input>&nbsp;&nbsp;<input name="button_tagfileds" type="submit"  class="crmbutton small save" value="{$APP.LBL_TAG_IT}" /></form></div></td>
                </tr>
		<tr>
			<td class="tagCloudDisplay" valign=top> <span id="tagfields">{$ALL_TAG}</span></td>
		</tr>
		</table>
		
		{/if}
				<br>
				{if $MERGEBUTTON eq 'permitted'}
				<form action="index.php" method="post" name="TemplateMerge" id="form">
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="parenttab" value="{$CATEGORY}">
				<input type="hidden" name="record" value="{$ID}">
				<input type="hidden" name="action">
  				<table border=0 cellspacing=0 cellpadding=0 width=100% class="rightMailMerge">
      				<tr>
      					   <td class="rightMailMergeHeader"><b>{$WORDTEMPLATEOPTIONS}</b></td>
      				</tr>
      				<tr style="height:25px">
					<td class="rightMailMergeContent">
						{if $TEMPLATECOUNT neq 0}
						<select name="mergefile">{foreach key=templid item=tempflname from=$TOPTIONS}<option value="{$templid}">{$tempflname}</option>{/foreach}</select>
                                                   <input class="crmbutton small create" value="{$APP.LBL_MERGE_BUTTON_LABEL}" onclick="this.form.action.value='Merge';" type="submit" ></input> 
						{else}
						<a href=index.php?module=Settings&action=upload&tempModule={$MODULE}&parenttab=Settings>{$APP.LBL_CREATE_MERGE_TEMPLATE}</a>
						{/if}
					</td>
      				</tr>
  				</table>
				</form>
				{/if}
			</td>
		</tr>
		</table>
		
			
			
		
		</div>
		
	</td>
	-->
</tr>
{if  $MODULE eq 'OrdresMission' && ( $CURRENT_USER_PROFIL eq '27' || $CURRENT_USER_PROFIL eq '26'  || $CURRENT_USER_PROFIL eq '20')}
	
							{*<tr><td align=right><input 
											title="{$MOD.LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											onclick="this.form.return_module.value='OrdresMission'; 
													this.form.return_action.value='DetailView'; 
													this.form.module.value='OrdresMission';
													this.form.action.value='CreateEngagement';
													this.form.dmd.value='{$ID}'; 
													this.form.demandeid.value='{$ID}'; 
													return CreerEngagement('OrdresMission');"
											type="submit" 
											name="Edit" 
											value="&nbsp;{$MOD.LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL}&nbsp;">&nbsp;
						</td></tr>*}
						{if $IS_MISSIONENGAGE eq '1'}
							<tr><td align=right><input 
											title="{$MOD.LBL_EST_ENGAGE_OM_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											disabled="disabled"
											onclick=""
											type="button" 
											name="Edit" 
											value="&nbsp;{$MOD.LBL_EST_ENGAGE_OM_BUTTON_LABEL}&nbsp;">&nbsp;
						</td></tr>
						{else}
							<tr><td align=right><input 
												title="{$MOD.LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL}" 
												class="crmbutton small edit" 
												onclick="return goengagement('{$ID}');"
												type="button" 
												name="Edit" 
												value="&nbsp;{$MOD.LBL_CREER_ENGAGEMENT_OM_BUTTON_LABEL}&nbsp;">&nbsp;
							</td></tr>
						{/if}
					{/if}
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








