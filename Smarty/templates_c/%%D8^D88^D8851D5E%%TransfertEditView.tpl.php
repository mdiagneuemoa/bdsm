<?php /* Smarty version 2.6.18, created on 2019-04-21 23:16:58
         compiled from TransfertEditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'TransfertEditView.tpl', 67, false),array('modifier', 'number_format', 'TransfertEditView.tpl', 233, false),array('function', 'html_options', 'TransfertEditView.tpl', 201, false),)), $this); ?>



<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<?php if ($this->_tpl_vars['CATEGORY'] == 'Demandes'): ?>
	<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<?php else: ?>
	<script type="text/javascript" src="jscalendar/lang/calendar-<?php echo $this->_tpl_vars['CALENDAR_LANG']; ?>
.js"></script>
<?php endif; ?>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript">
var gVTModule = '<?php echo $_REQUEST['module']; ?>
';
function sensex_info()
{
        var Ticker = $('tickersymbol').value;
        if(Ticker!='')
        {
                $("vtbusy_info").style.display="inline";
                new Ajax.Request(
                      'index.php',
                      {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Tickerdetail&tickersymbol='+Ticker,
                                onComplete: function(response) {
                                        $('autocom').innerHTML = response.responseText;
                                        $('autocom').style.display="block";
                                        $("vtbusy_info").style.display="none";
                                }
                        }
                );
        }
}
function AddressSync(Addform,id)
{
        if(formValidate() == true)
        {  
	      checkAddress(Addform,id);
        }
}

</script>

		<?php if ($this->_tpl_vars['MODULE'] == 'Candidats' && $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == '50'): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Candidats_Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php else: ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

	<td class="showPanelBg" valign=top width=100%>
				<div class="small" style="padding:20px">
						<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
			<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
			
			<?php if ($this->_tpl_vars['MSGVALIDATION'] != ''): ?>  				
				<span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 - <?php echo $this->_tpl_vars['MOD']['LBL_VALIDATION']; ?>
</span> <br>
				<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
			
			<?php elseif ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?>  				
				<span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 - <?php echo $this->_tpl_vars['APP']['LBL_EDITING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span> <br>
				<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
			
			<?php elseif ($this->_tpl_vars['OP_MODE'] == 'create_view'): ?>
				<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_CREATING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
</span> <br>
			<?php endif; ?>

			<hr noshade size=1>
			<br> 
		
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

						
			
			
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			<!--tr><td class="big4" valign=middle>N&deg; Convention : <?php echo $this->_tpl_vars['TICKET']; ?>
</td-->	
			   <tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
					   <tr>
						<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						 <?php if ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
							<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
</td>
						<?php else: ?>
							<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
						<?php endif; ?>	
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
												<?php if ($this->_tpl_vars['MODULE'] == 'Webmails'): ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='<?php echo $this->_tpl_vars['ID']; ?>
'" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  AddressSync(this.form,<?php echo $this->_tpl_vars['ID']; ?>
);"  type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											<?php elseif ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>	
												<input title="G&eacute;n&eacute;rer l'Ordre de Mission" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  G&eacute;n&eacute;rer l'Ordre de Mission  " style="width:200px">
											<?php elseif ($this->_tpl_vars['MSGVALIDATION'] != ''): ?>
											<input class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_VALIDATE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											 	
												<?php else: ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted();if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px">
              				                        <!--input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';return formValidate()" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:75px" -->
												<?php endif; ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>
										
										
										
									   <!-- included to handle the edit fields based on ui types -->
									   <?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
										
										
										<!-- This is added to display the existing comments -->
										
										<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRANSFERT_DEBITCREDIT'] && $this->_tpl_vars['MODULE'] == 'Transfert'): ?>
											<td colspan=5 class="detailedViewHeader">
													<b><?php echo $this->_tpl_vars['header']; ?>
</b>
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
																			<?php $this->assign('totaldebtransfert', 0); ?>
																	
																				<?php $_from = $this->_tpl_vars['LIGNESDEBIT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind'] => $this->_tpl_vars['linedeb']):
?>
																				<?php if ($this->_tpl_vars['linedeb']['montant'] == '' || $this->_tpl_vars['linedeb']['montant'] == 0): ?>
																					<?php $this->assign('styletr', 'style="display:none;"'); ?>
																				<?php else: ?>
																					<?php $this->assign('styletr', ''); ?>
																				<?php endif; ?>
																				<?php if ($this->_tpl_vars['ind'] == 0): ?>
																					<?php $this->assign('styleselect', ''); ?>
																					<tr>
																				<?php else: ?>
																					<?php $this->assign('styleselect', 'disabled'); ?>
																					<table id="lignesdebit_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styletr']; ?>
 width=98% bgcolor=white class=lvtColDataHover border=1  width=100%>
																					<tr>
																				<?php endif; ?>
																				<td><select name="debit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styleselect']; ?>
 onChange="getSelectTypeBudget('debit','0');" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TYPEBUDGET'],'selected' => $this->_tpl_vars['linedeb']['typebudget']), $this);?>

																					</select>
																				</td>
																				<td><select name="debit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styleselect']; ?>
 onChange="getSelectSourceFin('debit','0');" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small"  style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SOURCESFINACEMENT'],'selected' => $this->_tpl_vars['linedeb']['sourcefin']), $this);?>

																					</select>
																				</td>
																				
																				<td><select name="debit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getSelectCompteNatByBudget('debit','0');" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['CODESBUDGETAIRES'],'selected' => $this->_tpl_vars['linedeb']['codebudget']), $this);?>

																					</select>
																				</td>
																				<td><select name="debit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getDispoByCompteNat('debit','0');" class="small"  style="width:150px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['COMPTESNATURE'],'selected' => $this->_tpl_vars['linedeb']['comptenat']), $this);?>

																					</select>
																				</td>
																				<td><div id="debit_mntdispo_<?php echo $this->_tpl_vars['ind']; ?>
"></div><input type="text" name="debit_montant_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_montant_<?php echo $this->_tpl_vars['ind']; ?>
" value="<?php echo $this->_tpl_vars['linedeb']['montant']; ?>
"  placeholder="montant" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneDebit('<?php echo $this->_tpl_vars['ind']+1; ?>
');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					<?php if ($this->_tpl_vars['ind'] > '0'): ?>
																						<a href="javascript:;" onClick="supLigneDebit('<?php echo $this->_tpl_vars['ind']; ?>
');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					<?php endif; ?>
																					</td>

																					</tr>
																				<?php $this->assign('totaldebtransfert', $this->_tpl_vars['totaldebtransfert']+$this->_tpl_vars['linedeb']['montant']); ?>
																					
																			<?php endforeach; endif; unset($_from); ?>
																			</table>
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL DEBIT (FCFA) : <span id="totaldeptransfert"><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldebtransfert'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</span></b></td>
																			
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
																			<?php $this->assign('totalcredtransfert', 0); ?>
																			<?php $this->assign('styleselect', 'disabled'); ?>
																	
																			<?php $_from = $this->_tpl_vars['LIGNESCREDIT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind'] => $this->_tpl_vars['linecred']):
?>
																				
																				<?php if ($this->_tpl_vars['linecred']['montant'] == '' || $this->_tpl_vars['linecred']['montant'] == 0): ?>
																					<?php $this->assign('styletr', 'style="display:none;"'); ?>
																				<?php else: ?>
																					<?php $this->assign('styletr', ''); ?>
																				<?php endif; ?>
																				<?php if ($this->_tpl_vars['ind'] == 0): ?>
									
																					<tr>
																				<?php else: ?>
																					<table id="lignescredit_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styletr']; ?>
 bgcolor=white class=lvtColDataHover  width=100% border=1>
																					<tr>
																				<?php endif; ?>
																				<td><select name="credit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styleselect']; ?>
 tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TYPEBUDGET'],'selected' => $this->_tpl_vars['linecred']['typebudget']), $this);?>

																					</select>
																				</td>
																				<td><select name="credit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" <?php echo $this->_tpl_vars['styleselect']; ?>
 tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small"  style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SOURCESFINACEMENT'],'selected' => $this->_tpl_vars['linecred']['sourcefin']), $this);?>

																					</select>
																				</td>
																				
																				<td><select name="credit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getSelectCompteNatByBudget('credit','0');" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['CODESBUDGETAIRES'],'selected' => $this->_tpl_vars['linecred']['codebudget']), $this);?>

																					</select>
																				</td>
																				<td><select name="credit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getDispoByCompteNat('credit','0');" class="small"  style="width:150px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['COMPTESNATURE'],'selected' => $this->_tpl_vars['linecred']['comptenat']), $this);?>

																					</select>
																				</td>
																				<td><div id="credit_mntdispo_<?php echo $this->_tpl_vars['ind']; ?>
"></div><input type="text" name="credit_montant_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_montant_<?php echo $this->_tpl_vars['ind']; ?>
"  value="<?php echo $this->_tpl_vars['linecred']['montant']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" size=10></td>

																				<td nowrap width=45 align=left>&nbsp;
																					<a href="javascript:;" onClick="ajouterLigneCredit('<?php echo $this->_tpl_vars['ind']+1; ?>
');"><img src="modules/Transfert/rowadd.gif" titre="Ajouter une ligne de poste"></a>
																					<?php if ($this->_tpl_vars['ind'] > '0'): ?>
																						<a href="javascript:;" onClick="supLigneCredit('<?php echo $this->_tpl_vars['ind']; ?>
');"><img src="modules/Transfert/rowdelete.gif" titre="Suprimer cette ligne de poste"></a>
																					<?php endif; ?>
																					</td>

																					</tr>
																				<?php $this->assign('totalcredtransfert', $this->_tpl_vars['totalcredtransfert']+$this->_tpl_vars['linecred']['montant']); ?>
																					
																			<?php endforeach; endif; unset($_from); ?>
																			
																			</table>
																			
																			
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL CREDIT (FCFA) : <span id="totalcredtransfert"><?php echo ((is_array($_tmp=$this->_tpl_vars['totalcredtransfert'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</span></b></td>
																			
																			</tr>
																			</table>
																	</table>
																</td>
																</tr>
																
														</table>
												</td>
												
											</tr>
											
										<?php else: ?>
										
										<tr>
											<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										</tr>

										<?php endif; ?>
										<!-- Handle the ui types display -->
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "TransfertDisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

									   <?php endforeach; endif; unset($_from); ?>

									  

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
										<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
										<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Webmails'): ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.module.value='Webmails';this.form.send_mail.value='true';this.form.record.value='<?php echo $this->_tpl_vars['ID']; ?>
'" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
                                		                     <input type='hidden'  name='address_change' value='no'>
                                                                             <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; displaydeleted();  AddressSync(this.form,<?php echo $this->_tpl_vars['ID']; ?>
) " type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >		
										<?php elseif ($this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>	
												<input title="G&eacute;n&eacute;rer l'Ordre de Mission" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  G&eacute;n&eacute;rer l'Ordre de Mission  " style="width:200px">
										
										<?php elseif ($this->_tpl_vars['MSGVALIDATION'] != ''): ?>
											<input class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_VALIDATE_BUTTON_LABEL']; ?>
  " style="width:70px" >
											
										<?php else: ?>
													<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted();if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px">
              				                                	<!--input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';return formValidate()" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:75px" -->
										<?php endif; ?>
                                               					<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
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
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
<!--added to fix 4600-->
<input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH']; ?>
'>
</form>


<?php if (( $this->_tpl_vars['MODULE'] == 'Emails' || 'Documents' ) && ( $this->_tpl_vars['FCKEDITOR_DISPLAY'] == 'true' )): ?>
	<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
	<script type="text/javascript" defer="1">
		var oFCKeditor = null;
		<?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
			oFCKeditor = new FCKeditor( "notecontent" ) ;
		<?php endif; ?>
		
		
		<?php if ($this->_tpl_vars['MODULE'] == 'Incidents'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
       
		oFCKeditor.BasePath   = "include/fckeditor/" ;
		oFCKeditor.ReplaceTextarea() ;
	</script>
<?php endif; ?>

<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
<?php endif; ?>
<script>	

        var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
)

        var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
)

        var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
)

	var ProductImages=new Array();
	var count=0;

	function delRowEmt(imagename)
	{
		ProductImages[count++]=imagename;
	}

	function displaydeleted()
	{
		var imagelists='';
		for(var x = 0; x < ProductImages.length; x++)
		{
			imagelists+=ProductImages[x]+'###';
		}

		if(imagelists != '')
			document.EditView.imagelist.value=imagelists
	}

</script>

<!-- vtlib customization: Help information assocaited with the fields -->
<?php if ($this->_tpl_vars['FIELDHELPINFO']): ?>
<script type='text/javascript'>
<?php echo 'var fieldhelpinfo = {}; '; ?>

<?php $_from = $this->_tpl_vars['FIELDHELPINFO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FIELDHELPKEY'] => $this->_tpl_vars['FIELDHELPVAL']):
?>
	fieldhelpinfo["<?php echo $this->_tpl_vars['FIELDHELPKEY']; ?>
"] = "<?php echo $this->_tpl_vars['FIELDHELPVAL']; ?>
";
<?php endforeach; endif; unset($_from); ?>
</script>
<?php endif; ?>
<!-- END -->