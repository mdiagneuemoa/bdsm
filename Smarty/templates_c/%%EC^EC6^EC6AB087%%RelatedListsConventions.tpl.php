<?php /* Smarty version 2.6.18, created on 2016-01-26 10:37:23
         compiled from RelatedListsConventions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'RelatedListsConventions.tpl', 94, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/PriceBooks/PriceBooks.js"></script>
<?php echo '
<script>
function editProductListPrice(id,pbid,price)
{
        $("status").style.display="inline";
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'action=ProductsAjax&file=EditListPrice&return_action=CallRelatedList&return_module=PriceBooks&module=Products&record=\'+id+\'&pricebook_id=\'+pbid+\'&listprice=\'+price,
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
                        \'index.php\',
                        {queue: {position: \'end\', scope: \'command\'},
                                method: \'post\',
                                postBody: \'module=Products&action=ProductsAjax&file=UpdateListPrice&ajax=true&return_action=CallRelatedList&return_module=PriceBooks&record=\'+id+\'&pricebook_id=\'+pbid+\'&product_id=\'+proid+\'&list_price=\'+listprice,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                );
}
'; ?>


function loadCvList(type,id)
{
        if($("lead_cv_list").value != 'None' || $("cont_cv_list").value != 'None')
        {
		$("status").style.display="inline";
        	if(type === 'Leads')
        	{
                        new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("lead_cv_list").value,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                	);
        	}

        	if(type === 'Contacts')
        	{
                        new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("cont_cv_list").value,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                	);
		}
        }
}
</script>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Contents -->
<div id="editlistprice" style="position:absolute;width:300px;"></div>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:20px">
 	        	
			<table border=0 cellspacing=1 cellpadding=3 width=100%>
			<tr><td>
			 <span class="lvtHeaderText"><font color="purple"><a href="index.php?module=Conventions&action=DetailView&record=<?php echo $this->_tpl_vars['MOD_SEQ_ID']; ?>
" title="Retour au d&eacute;tail de la Convention">[ <?php echo $this->_tpl_vars['MOD_SEQ_ID']; ?>
 ]</a> </font><?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span>
			 </td>
			 <td class="big4">N&deg; Convention : <?php echo $this->_tpl_vars['NAME']; ?>
</td></tr>
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
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
					<td><input name="libelleprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="montantprodfin"  class="detailedViewTextBox"  type="text" value=""/></td>
					<td><input name="dateeffetprodfin" id="jscal_field_dateeffetprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['date_val']; ?>
">
						<img src="<?php echo vtiger_imageurl('btnL3Calendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_<?php echo $this->_tpl_vars['fldname']; ?>
">
					</td>
					<td><input name="dateprodfin" id="jscal_field_dateprodfin" type="text" style="border:1px solid #bababa;" size="11" maxlength="10" value="<?php echo $this->_tpl_vars['date_val']; ?>
">
						<img src="<?php echo vtiger_imageurl('btnL3Calendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_<?php echo $this->_tpl_vars['fldname']; ?>
">
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
					<td class="big3" align=right><input title="<?php echo $this->_tpl_vars['APP']['LBL_PREPARATIONDET_BUTTON_LABEL']; ?>
" 
											class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
												this.form2.return_action.value='DetailView'; 
												this.form2.module.value='TraitementConventions';
												this.form2.action.value='EditView';
												this.form2.statut.value='';
												this.form2.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
												this.form2.cloturer.value='true'" 
											type="submit" name="Edit" 
											value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_PREPARATION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
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
				
					
					 
				<?php $_from = $this->_tpl_vars['TRAITEMENTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
					
								<td><?php echo $this->_tpl_vars['data']['traitementid']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['statut']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['datemodification']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['nom']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['organe']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['description']; ?>
</td> 
				   
					</tr>
					
				 <?php endforeach; endif; unset($_from); ?>
				 	
				 	
			 	
			 	
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
				
					
					 
				<?php $_from = $this->_tpl_vars['DECAISSEMENTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
				
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
					
								<td><?php echo $this->_tpl_vars['data']['numengagement']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['dateengagement']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['montantengage']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['montantliquide']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['montantordonnance']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['dateordonnancement']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['montantpaye']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['datepaiement']; ?>
</td>

					</tr>
					
				 <?php endforeach; endif; unset($_from); ?>
				 	
				 	
			 	
			 	
			 </table>
			<br><br>
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
				<tr>
	 				<td class="big3" colspan=9>Ex&eacute;cution de la convention : Liste des Comptes Rendus du Maitre d'Ouvrage</td>
					<!--td class="big3" align=right><input title="<?php echo $this->_tpl_vars['APP']['LBL_EXECUTION_SAVE_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
													this.form2.return_action.value='DetailView'; 
													this.form2.module.value='ExecutionConventions';
													this.form2.action.value='EditView';
													this.form2.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
';" 
											type="submit" 
											name="Edit"
										value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EXECUTION_SAVE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp; 
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
				
					
					 
				<?php $_from = $this->_tpl_vars['CREXECUTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
					
								<td><?php echo $this->_tpl_vars['data']['reffournisseur']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['modepaiement']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['montant']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['datepaiement']; ?>
</td> 
								<td nowrap><?php echo $this->_tpl_vars['data']['datesaisie']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['refpaiement']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['description']; ?>
</td>
								<td><a href = 'index.php?module=uploads&action=downloadfile&return_module=Conventions&fileid=<?php echo $this->_tpl_vars['data']['pjustifid']; ?>
&entityid=<?php echo $this->_tpl_vars['data']['idexecution']; ?>
 ' 
											onclick='javascript:dldCntIncrease("<?php echo $this->_tpl_vars['data']['idexecution']; ?>
")'><?php echo $this->_tpl_vars['data']['filename']; ?>
</a>
								</td>
</td>
								<td align=center>
									<?php if (( $this->_tpl_vars['CURRENT_USER_IS_ADMIN'] == 'on' || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 22 )): ?>
										<a href='index.php?action=EditView&module=ExecutionConventions&record=<?php echo $this->_tpl_vars['data']['idexecution']; ?>
&parenttab=Conventions'>
										<img src='<?php echo vtiger_imageurl('edit.png', $this->_tpl_vars['THEME']); ?>
' title="editer"  border=0>
										</a>&nbsp;
										<a href='javascript:;' onclick='deleteCRExecution("<?php echo $this->_tpl_vars['data']['idexecution']; ?>
")'>
											<img src='<?php echo vtiger_imageurl('delete.png', $this->_tpl_vars['THEME']); ?>
' title="supprimer"  border=0>
										</a>
									<?php endif; ?>	
								</td>
					</tr>
					
				 <?php endforeach; endif; unset($_from); ?>
				 	
				 	
			 	
			 	
			 </table>
			 
			 <br><br>
			 <table border=0 cellspacing=1 cellpadding=3 width=80% class="lvt small">
				<tr>
	 				<td class="big3" colspan=5>Produits financiers : Liste g&eacute;n&eacute;r&eacute;e par la Convention </td>
					<!--td  class="big3" align=right><input title="<?php echo $this->_tpl_vars['APP']['LBL_PRODFINANCIER_SAVE_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
											onclick="this.form2.return_module.value='Conventions'; 
													this.form2.return_action.value='DetailView'; 
													this.form2.module.value='ExecutionConventions';
													this.form2.action.value='EditView';
													this.form2.statut.value='transfered';
													this.form2.dmd.value='<?php echo $this->_tpl_vars['ID']; ?>
'; 
													this.form2.action.value='EditView'" 
											type="submit" 
											name="Edit"
										value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_PRODFINANCIER_SAVE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp; 
					</td-->
			   </tr>
				<tr>
					<td class="lvtCol" width="600px">Libell&eacute;</td>
	 				<td class="lvtCol">montant</td>
	 				<td class="lvtCol">Date Effet</td>
	 				<td class="lvtCol">Date Saisie</td>
	 				<td class="lvtCol">Action</td>
					
			    </tr>
				
					
					 
				<?php $_from = $this->_tpl_vars['PRODUITSFIN']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
					
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
								<td><?php echo $this->_tpl_vars['data']['libelle']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['montant']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['dateeffet']; ?>
</td> 
								<td><?php echo $this->_tpl_vars['data']['datesaisie']; ?>
</td> 
								<td align=center>
									<?php if (( $this->_tpl_vars['CURRENT_USER_IS_ADMIN'] == 'on' || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 22 )): ?>
										<a href='javascript:;' onclick='deleteprofin("<?php echo $this->_tpl_vars['data']['idprodfin']; ?>
")'>
											<img src='<?php echo vtiger_imageurl('delete.png', $this->_tpl_vars['THEME']); ?>
' title="supprimer"  border=0>
										</a>
									<?php endif; ?>	
								</td>
				   
					</tr>
					
				 <?php endforeach; endif; unset($_from); ?>
				 	
				 	
			 	
			 	
			 </table>
		</div>
	<!-- PUBLIC CONTENTS STOPS-->
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
</tr>

</table>
</form>
<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Campaigns' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;width:300px;"></div></form>
<?php endif; ?>

<script>
function OpenWindow(url)
{
	openPopUp('xAttachFile',this,url,'attachfileWin',380,375,'menubar=no,toolbar=no,location=no,status=no,resizable=no');	
}
</script>