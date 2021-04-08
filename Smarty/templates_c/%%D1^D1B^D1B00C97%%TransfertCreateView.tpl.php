<?php /* Smarty version 2.6.18, created on 2019-04-23 08:38:13
         compiled from TransfertCreateView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'TransfertCreateView.tpl', 58, false),array('modifier', 'cat', 'TransfertCreateView.tpl', 76, false),array('modifier', 'number_format', 'TransfertCreateView.tpl', 216, false),array('modifier', 'count', 'TransfertCreateView.tpl', 293, false),array('function', 'html_options', 'TransfertCreateView.tpl', 186, false),)), $this); ?>


<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>

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
</script>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<!--<td valign=top>
		<img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
">
	</td>-->

	<td class="showPanelBg" valign=top width=100%>
	     	     <div class="small" style="padding:20px">
		
				<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
		<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
				
		 <?php if ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?>   
			 <span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 -  <?php echo $this->_tpl_vars['APP']['LBL_EDITING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span> <br>
			<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
		 <?php endif; ?>

		 <?php if ($this->_tpl_vars['OP_MODE'] == 'create_view'): ?>
			<?php if ($this->_tpl_vars['DUPLICATE'] != 'true'): ?>
			<?php $this->assign('create_new', ((is_array($_tmp='LBL_CREATING_NEW_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['SINGLE_MOD']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['SINGLE_MOD']))); ?>
								<?php $this->assign('create_newlabel', $this->_tpl_vars['APP'][$this->_tpl_vars['create_new']]); ?>
				<?php if ($this->_tpl_vars['create_newlabel'] != ''): ?>
					<span class="lvtHeaderText"><?php echo $this->_tpl_vars['create_newlabel']; ?>
</span> <br>
				<?php else: ?>
					<!--<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_CREATING']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_NEW']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
</span> <br>-->
					<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_NEW']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
</span> <br>
				<?php endif; ?>
		        
			<?php else: ?>
			<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATING']; ?>
 "<?php echo $this->_tpl_vars['NAME']; ?>
" </span> <br>
			<?php endif; ?>
		 <?php endif; ?>

		 <hr noshade size=1>
		 <br> 
		
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		
		   <tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">

				   <tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>

					<?php if ($this->_tpl_vars['ADVBLOCKS'] != ''): ?>	
						<td width=75 style="width:15%" align="center" nowrap class="dvtSelectedCell" id="bi" onclick="fnLoadValues('bi','mi','basicTab','moreTab','normal','<?php echo $this->_tpl_vars['MODULE']; ?>
')"><b><?php echo $this->_tpl_vars['APP']['LBL_BASIC']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</b></td>
                    	<td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadValues('mi','bi','moreTab','basicTab','normal','<?php echo $this->_tpl_vars['MODULE']; ?>
')"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
 </b></td>
                   		<td class="dvtTabCache" style="width:65%" nowrap>&nbsp;</td>
					<?php else: ?>
						<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP']['LBL_BASIC']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
	                    <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					<?php endif; ?>
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
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';if(!isValideDemTransfert()) return false; if(!isFieldsFormValide(this.form)) return false; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px" >
										<?php endif; ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   <?php $_from = $this->_tpl_vars['BASBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
														
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRANSFERT_DEBITCREDIT'] && $this->_tpl_vars['MODULE'] == 'Transfert'): ?>
											<td colspan=5 class="detailedViewHeader">
													<b><?php echo $this->_tpl_vars['header']; ?>
</b>
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
																			<?php $this->assign('totaldebtransfert', 0); ?>
																	
																			<?php $_from = $this->_tpl_vars['INDEXES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind']):
?>
																				<?php if ($this->_tpl_vars['ind'] == 0): ?>
																					<tr>
																				<?php else: ?>
																					<?php $this->assign('styletr', 'style="display:none;"'); ?>
																					<table id="lignesdebit_<?php echo $this->_tpl_vars['ind']; ?>
" width=98% bgcolor=white class=lvtColDataHover border=1 <?php echo $this->_tpl_vars['styletr']; ?>
 width=100%>
																					<tr>
																				<?php endif; ?>
																				<td><select name="debit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" onChange="getSelectTypeBudget('debit','0');" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TYPEBUDGET']), $this);?>

																					</select>
																				</td>
																				<td><select name="debit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" onChange="getSelectSourceFin('debit','0');" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small"  style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SOURCESFINACEMENT'],'selected' => $this->_tpl_vars['fldvalue']), $this);?>

																					</select>
																				</td>
																				
																				<td><select name="debit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getSelectCompteNatByBudget('debit','0');" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['CODESBUDGETAIRES']), $this);?>

																					</select>
																				</td>
																				<td><select name="debit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small"  style="width:150px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['COMPTESNATURE'],'selected' => $this->_tpl_vars['fldvalue']), $this);?>

																					</select>
																				</td>
																				<td><div id="debit_mntdispo_<?php echo $this->_tpl_vars['ind']; ?>
"></div><input type="text" name="debit_montant_<?php echo $this->_tpl_vars['ind']; ?>
" id="debit_montant_<?php echo $this->_tpl_vars['ind']; ?>
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
																			<?php endforeach; endif; unset($_from); ?>
																			</table>
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL DEBIT (FCFA) : <span id="totaldeptransfert"><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldeptransfert'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
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
																	
																			<?php $_from = $this->_tpl_vars['INDEXES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind']):
?>
																				<?php if ($this->_tpl_vars['ind'] == 0): ?>
																					<tr>
																				<?php else: ?>
																					<?php $this->assign('styletr', 'style="display:none;"'); ?>
																					<table id="lignescredit_<?php echo $this->_tpl_vars['ind']; ?>
" bgcolor=white class=lvtColDataHover <?php echo $this->_tpl_vars['styletr']; ?>
 width=100% border=1>
																					<tr>
																				<?php endif; ?>
																				<td><select name="credit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_typebudget_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['TYPEBUDGET']), $this);?>

																					</select>
																				</td>
																				<td><select name="credit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_sourcefin_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" class="small"  style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SOURCESFINACEMENT'],'selected' => $this->_tpl_vars['fldvalue']), $this);?>

																					</select>
																				</td>
																				
																				<td><select name="credit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_codebudget_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
" onChange="getSelectCompteNatByBudget('credit','0');" class="small" style="width:250px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['CODESBUDGETAIRES']), $this);?>

																					</select>
																				</td>
																				<td><select name="credit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_comptenat_<?php echo $this->_tpl_vars['ind']; ?>
" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
"  class="small"  style="width:150px;">
																						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['COMPTESNATURE'],'selected' => $this->_tpl_vars['fldvalue']), $this);?>

																					</select>
																				</td>
																				<td><div id="credit_mntdispo_<?php echo $this->_tpl_vars['ind']; ?>
"></div><input type="text" name="credit_montant_<?php echo $this->_tpl_vars['ind']; ?>
" id="credit_montant_<?php echo $this->_tpl_vars['ind']; ?>
"  placeholder="montant" tabindex="<?php echo $this->_tpl_vars['vt_tab']; ?>
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
																			<?php endforeach; endif; unset($_from); ?>
																			
																			</table>
																			
																			
																			
																			<table  width=100% border=0 >
																			<tr><td colspan=1 align=right><b>TOTAL CREDIT (FCFA)</b> : <span id="totalcredtransfert"><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldeptransfert'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</span></b></td>
																			
																			</tr>
																			</table>
																	</table>
																</td>
																</tr>
																
														</table>
												</td>
												
											</tr>
											<input type="hidden" name="nbnatdepense" id="nbnatdepense" value="<?php echo count($this->_tpl_vars['NATDEPENSES']); ?>
">

																		
									<?php else: ?>
										<tr>
											<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										</tr>
									  <?php endif; ?>
								   <!-- Here we should include the uitype handlings-->
								   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "TransfertDisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>							
								   <tr style="height:10px"><td>&nbsp;</td></tr>
								 
								   <?php endforeach; endif; unset($_from); ?>
									<!--tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr-->
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
                                			<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
                                			<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
                                		<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>	
                                                                                       <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false;if(!isValideDemTransfert()) return false; if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px" >
										<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
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
					
			    </div>
			    <!-- Basic Information Tab Closed -->

			    <!-- More Information Tab Opened -->
			    <div id="moreTab">
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
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  "  >
										<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   <?php $_from = $this->_tpl_vars['ADVBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
								   <tr>
						         		<td colspan=4 class="detailedViewHeader">
                    	        		<b><?php echo $this->_tpl_vars['header']; ?>
</b>
                             		</td>
                             	   </tr>

								   <!-- Here we should include the uitype handlings-->
                                   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

							 	   <tr style="height:25px"><td>&nbsp;</td></tr>
								   <?php endforeach; endif; unset($_from); ?>

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
                                			<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
                                			<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
                                		<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate()" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php endif; ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
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
			    </div>

			</td>
		   </tr>
		</table>
	     </div>
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
<input type="hidden" name="nbnatdepense" id="nbnatdepense"/>
</form>

<?php if (( $this->_tpl_vars['MODULE'] == 'Emails' || 'Documents' || 'HReports' ) && ( $this->_tpl_vars['FCKEDITOR_DISPLAY'] == 'true' )): ?>
       <script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">

       var oFCKeditor = null;

       <?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
               oFCKeditor = new FCKeditor( "notecontent" ) ;
       <?php endif; ?>
       
						<?php if ($this->_tpl_vars['MODULE'] == 'Incidents'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
		<?php if ($this->_tpl_vars['MODULE'] == 'Conventions'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
	<?php if ($this->_tpl_vars['MODULE'] == 'ExecutionConventions'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
	   <?php if ($this->_tpl_vars['MODULE'] == 'HReports'): ?>
               oFCKeditor = new FCKeditor( "hreportcontent" ) ;
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