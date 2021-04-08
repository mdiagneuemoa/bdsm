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
<div id="editlistprice" style="position:absolute;width:300px;"></div>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="{'showPanelTopLeft.gif'|@vtiger_imageurl:$THEME}"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:20px">
 	        {* Module Record numbering, used MOD_SEQ_ID instead of ID *}	
			<table border=0 cellspacing=1 cellpadding=3 width=100%>
			<tr><td>
			 <span class="lvtHeaderText"><font color="purple"><a href="index.php?module=Conventions&action=DetailView&record={$MOD_SEQ_ID}" title="Retour au d&eacute;tail de la Convention">[ {$MOD_SEQ_ID} ]</a> </font>{$SINGLE_MOD} {$APP.LBL_MORE} {$APP.LBL_INFORMATION}</span>
			 </td>
			 <td class="big4">N&deg; Convention : {$NAME}</td></tr>
			{* {$UPDATEINFO} *}
			 <hr noshade size=1>
			 <br> 
			 <!--div id="addprodfin" style="display:none;">
				 <table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
					<tr>
		 				<td class="big3" colspan=5>Ajout d'un produit financier</td>
						
				   </tr>
					<tr>
						<td class="lvtCol">Libell&eacute;</td>
		 				<td class="lvtCol">montant</td>
		 				<td class="lvtCol">Date Effet</td>
		 				<td class="lvtCol">Date Saisie</td>
		 				<td class="lvtCol">&nbsp;</td>
					</tr>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
					<td><input name="libelleprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="montantprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="dateeffetprodfin" id="jscal_field_dateeffetprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
						<img src="{'btnL3Calendar.gif'|@vtiger_imageurl:$THEME}" id="jscal_trigger_{$fldname}">
					</td>
					<td><input name="dateprodfin" id="jscal_field_dateprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="{$date_val}">
						<img src="{'btnL3Calendar.gif'|@vtiger_imageurl:$THEME}" id="jscal_trigger_{$fldname}">
					</td>
					
						<td><input type="submit" name="submit" value="Enregister"></td>
					</tr>
				</table>
			</div-->
			<br>
			<form action="index.php" method="post" name="form2" id="form2">

			<!--table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
				<tr>
	 				<td class="big3" colspan=5>Pr&eacuteparation de la Convention : Historiques des &eacute;tapes effectu&eacute;es</td>
					<td class="big3" align=right><input title="{$APP.LBL_PREPARATIONDET_BUTTON_LABEL}" 
											class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
												this.form2.return_action.value='DetailView'; 
												this.form2.module.value='TraitementConventions';
												this.form2.action.value='EditView';
												this.form2.statut.value='';
												this.form2.dmd.value='{$ID}'; 
												this.form2.cloturer.value='true'" 
											type="submit" name="Edit" 
											value="&nbsp;{$APP.LBL_PREPARATION_BUTTON_LABEL}&nbsp;">&nbsp;
					</td>						
			   </tr>
				<tr>
	 				<td class="lvtCol" nowrap>ID Traitement</td>
	 				<td class="lvtCol" nowrap>Statut</td>
	 				<td class="lvtCol" nowrap>Date Action</td>
	 				<td class="lvtCol" nowrap>Utilisateur</td>
	 				<td class="lvtCol">Organe</td>
	 				<td class="lvtCol" width="500px">Observation</td>
					
			    </tr>
				
					
					 
				{foreach item=data from=$TRAITEMENTS}
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
					
								<td>{$data.traitementid}</td> 
								<td nowrap>{$data.statut}</td> 
								<td nowrap>{$data.datemodification}</td> 
								<td nowrap>{$data.nom}</td> 
								<td>{$data.organe}</td> 
								<td>{$data.description}</td> 
				   
					</tr>
					
				 {/foreach}
				 	
				 	
			 	
			 	
			 </table>
			 <br><br-->
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
				<tr>
	 				<td class="big3" colspan=8>Ex&eacute;cution de la convention : Liste des d&eacute;caissements</td>
									
			   </tr>
				<tr>
	 				<td class="lvtCol" nowrap>N&deg; Engagement</td>
	 				<td class="lvtCol" nowrap>Dare Engagement</td>
	 				<td class="lvtCol" nowrap>Montant Engag&eacute;</td>
	 				<td class="lvtCol" nowrap>Montant Liquid&eacute;</td>
	 				<td class="lvtCol" nowrap>Montant Ordonnanc&eacute;</td>
	 				<td class="lvtCol" nowrap>Date Ordonnancement</td>
	 				<td class="lvtCol" nowrap>Montant Pay&eacute;</td>
	 				<td class="lvtCol" width=400>Date Paiement</td>
					
			    </tr>
				
					
					 
				{foreach item=data from=$DECAISSEMENTS}
				
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
					
								<td>{$data.numengagement}</td> 
								<td>{$data.dateengagement}</td> 
								<td>{$data.montantengage}</td> 
								<td>{$data.montantliquide}</td> 
								<td>{$data.montantordonnance}</td> 
								<td>{$data.dateordonnancement}</td> 
								<td>{$data.montantpaye}</td> 
								<td>{$data.datepaiement}</td>

					</tr>
					
				 {/foreach}
				 	
				 	
			 	
			 	
			 </table>
			<br><br>
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
				<tr>
	 				<td class="big3" colspan=9>Ex&eacute;cution de la convention : Liste des Comptes Rendus du Maitre d'Ouvrage</td>
					<!--td class="big3" align=right><input title="{$APP.LBL_EXECUTION_SAVE_BUTTON_LABEL}" 
										class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
													this.form2.return_action.value='DetailView'; 
													this.form2.module.value='ExecutionConventions';
													this.form2.action.value='EditView';
													this.form2.dmd.value='{$ID}';" 
											type="submit" 
											name="Edit"
										value="&nbsp;{$APP.LBL_EXECUTION_SAVE_BUTTON_LABEL}&nbsp;">&nbsp; 
					</td-->					
			   </tr>
				<tr>
	 				<td class="lvtCol">R&eacute;f&eacute;rence Fournisseur</td>
	 				<td class="lvtCol">Mode Paiement</td>
	 				<td class="lvtCol" nowrap>Montant</td>
	 				<td class="lvtCol" nowrap>Date Paiement</td>
	 				<td class="lvtCol" nowrap>Date Saisie</td>
	 				<td class="lvtCol">R&eacute;f&eacute;rence Paiement</td>
	 				<td class="lvtCol" width=400>Activit&eacute;s</td>
	 				<td class="lvtCol">Pi&egrave;ces Justificatives</td>
	 				<td class="lvtCol">Action</td>
					
			    </tr>
				
					
					 
				{foreach item=data from=$CREXECUTIONS}
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
					
								<td>{$data.reffournisseur}</td> 
								<td nowrap>{$data.modepaiement}</td> 
								<td nowrap>{$data.montant}</td> 
								<td nowrap>{$data.datepaiement}</td> 
								<td nowrap>{$data.datesaisie}</td> 
								<td>{$data.refpaiement}</td> 
								<td>{$data.description}</td>
								<td><a href = 'index.php?module=uploads&action=downloadfile&return_module=Conventions&fileid={$data.pjustifid}&entityid={$data.idexecution} ' 
											onclick='javascript:dldCntIncrease("{$data.idexecution}")'>{$data.filename}</a>
								</td>
</td>
								<td align=center>
									{if ($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 22 ) }
										<a href='index.php?action=EditView&module=ExecutionConventions&record={$data.idexecution}&parenttab=Conventions'>
										<img src='{'edit.png'|@vtiger_imageurl:$THEME}' title="editer"  border=0>
										</a>&nbsp;
										<a href='javascript:;' onclick='deleteCRExecution("{$data.idexecution}")'>
											<img src='{'delete.png'|@vtiger_imageurl:$THEME}' title="supprimer"  border=0>
										</a>
									{/if}	
								</td>
					</tr>
					
				 {/foreach}
				 	
				 	
			 	
			 	
			 </table>
			 
			 <br><br>
			 <table border=0 cellspacing=1 cellpadding=3 width=80% class="lvt small">
				<tr>
	 				<td class="big3" colspan=5>Produits financiers : Liste g&eacute;n&eacute;r&eacute;e par la Convention </td>
					<!--td  class="big3" align=right><input title="{$APP.LBL_PRODFINANCIER_SAVE_BUTTON_LABEL}" 
										class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
													this.form2.return_action.value='DetailView'; 
													this.form2.module.value='ExecutionConventions';
													this.form2.action.value='EditView';
													this.form2.statut.value='transfered';
													this.form2.dmd.value='{$ID}'; 
													this.form2.action.value='EditView'" 
											type="submit" 
											name="Edit"
										value="&nbsp;{$APP.LBL_PRODFINANCIER_SAVE_BUTTON_LABEL}&nbsp;">&nbsp; 
					</td-->
			   </tr>
				<tr>
					<td class="lvtCol" width="600px">Libell&eacute;</td>
	 				<td class="lvtCol">montant</td>
	 				<td class="lvtCol">Date Effet</td>
	 				<td class="lvtCol">Date Saisie</td>
	 				<td class="lvtCol">Action</td>
					
			    </tr>
				
					
					 
				{foreach item=data from=$PRODUITSFIN}
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
								<td>{$data.libelle}</td> 
								<td>{$data.montant}</td> 
								<td>{$data.dateeffet}</td> 
								<td>{$data.datesaisie}</td> 
								<td align=center>
									{if ($CURRENT_USER_IS_ADMIN eq 'on' || $CURRENT_USER_PROFIL_ID eq 22 ) }
										<a href='javascript:;' onclick='deleteprofin("{$data.idprodfin}")'>
											<img src='{'delete.png'|@vtiger_imageurl:$THEME}' title="supprimer"  border=0>
										</a>
									{/if}	
								</td>
				   
					</tr>
					
				 {/foreach}
				 	
				 	
			 	
			 	
			 </table>
		</div>
	<!-- PUBLIC CONTENTS STOPS-->
	</td>
	<td align=right valign=top><img src="{'showPanelTopRight.gif'|@vtiger_imageurl:$THEME}"></td>
</tr>

</table>
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
