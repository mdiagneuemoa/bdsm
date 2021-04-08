<?php /* Smarty version 2.6.18, created on 2018-06-27 09:34:29
         compiled from ReunionEditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ReunionEditView.tpl', 67, false),array('modifier', 'number_format', 'ReunionEditView.tpl', 226, false),array('modifier', 'count', 'ReunionEditView.tpl', 252, false),)), $this); ?>



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
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
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
										<tr>
											<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										</tr>
										<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_REUNION_DEPENSES'] && $this->_tpl_vars['MODULE'] == 'Reunion'): ?>
									
											<tr><td colspan=5 >
											<table width=99% border=1 id="naturesdepense">
											<tr>
												<td class="detailedViewHeader" width=120><b>LIBELLE</b></td>
												<td class="detailedViewHeader" width=20 align="center"><b>QUANTITE</b></td>
												<td class="detailedViewHeader" width=20 align="center"><b>NOMBRE</b></td>
												<td class="detailedViewHeader" width=30 align="center"><b>PRIX UNITAIRE</b></td>
												<td class="detailedViewHeader" width=30 align="center"><b>TOTAL (FCFA)</b></td>
												<td class="detailedViewHeader" width=2	 align="center">&nbsp;</td>
											</tr>
											<?php $this->assign('totaldepreunion', 0); ?>
											<?php $_from = $this->_tpl_vars['NATDEPENSES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comptenat'] => $this->_tpl_vars['natdepense']):
?>
												
												<tr>
													<!--td colspan=6 class="detailedViewHeader">
														<b><?php echo $this->_tpl_vars['natdepense']['libnatdepense']; ?>
 (<?php echo $this->_tpl_vars['comptenat']; ?>
)</b>
													</td-->
													<td colspan=6 class="detailedViewHeader">
														<table width=99% border=0>
															<tr>
																<td colspan=5>
																	<b><?php echo $this->_tpl_vars['natdepense']['libnatdepense']; ?>
 (<?php echo $this->_tpl_vars['comptenat']; ?>
)</b>
																</td>
																<td align=right>
																	<?php if ($this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo'] != ''): ?>
																		<b>Montant disponible : <?php echo $this->_tpl_vars['BUDGETDISP'][$this->_tpl_vars['CODEBUDGET']][$this->_tpl_vars['comptenat']]['mntdispo']; ?>
 FCFA</b>
																	<?php else: ?>
																		<b>Montant disponible : 0 FCFA</b>
																	<?php endif; ?>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td colspan=6>
														<table width=95% border=1 id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
">
															<?php $_from = $this->_tpl_vars['natdepense']['depenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['linedep'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['linedep']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['lignedepense']):
        $this->_foreach['linedep']['iteration']++;
?>
																<tr>
																	<td ><input type="text" name="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_lib_<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
" id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_lib_<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['lignedepense']['libdepense']; ?>
" size=70></td>
																	<td align="center"><input type="text" name="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_qte_<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
" id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_qte_<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
" onmouseout="calculTotalDepense('<?php echo $this->_tpl_vars['comptenat']; ?>
','<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
')" value="<?php echo $this->_tpl_vars['lignedepense']['qtedepense']; ?>
" size=10></td>
																	<td align="center"><input type="text" name="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_nb_<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
" id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_nb_<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
" onmouseout="calculTotalDepense('<?php echo $this->_tpl_vars['comptenat']; ?>
','<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
')" value="<?php echo $this->_tpl_vars['lignedepense']['nbredepense']; ?>
" size=10></td>
																	<td align=right><input type="text" name="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_pu_<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
" id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_pu_<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
" onmouseout="calculTotalDepense('<?php echo $this->_tpl_vars['comptenat']; ?>
','<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
')" value="<?php echo $this->_tpl_vars['lignedepense']['pudepense']; ?>
"  size=20></td>
																	<td align=right><input type="text" name="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_pt_<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
" id="naturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_pt_<?php echo ($this->_foreach['linedep']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['lignedepense']['totaldepense']; ?>
"  size=20></td>
																	<td nowrap>
																	<?php if (($this->_foreach['linedep']['iteration']-1) == 0): ?>
																		<a href="javascript:;" onClick="ajouterLigneDepenseElt('<?php echo $this->_tpl_vars['comptenat']; ?>
');"><img src="modules/Reunion/rowadd.gif" titre="Ajouter une ligne de dépense"></a>&nbsp;
																	<?php else: ?>
																		<a href="javascript:;" onClick="supLigneDepenseElt('<?php echo $this->_tpl_vars['comptenat']; ?>
','<?php echo ($this->_foreach['linedep']['iteration']-1)+1; ?>
');"><img src="modules/Reunion/rowdelete.gif" titre="Suprimer cette ligne de dépense"></a>
																	<?php endif; ?>
																	</td>
																</tr>
															
															<?php endforeach; endif; unset($_from); ?>
															<!--tr>
																<td colspan=4 align="right">
																	<b>TOTAL&nbsp;</b>
																</td>
																<td align=right>
																	<b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b>
																</td>
																<td align="center">&nbsp;</td>
															</tr-->
																<?php $this->assign('totaldepreunion', $this->_tpl_vars['totaldepreunion']+$this->_tpl_vars['natdepense']['totaldepense']); ?>
														</table>
													</td>
												</tr>
												<!--tr>
																<td colspan=4 align="right">
																	<b>TOTAL&nbsp;</b>
																</td>
																<td align=right>
																	<b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b>
																</td>
																<td align="center">&nbsp;</td>
															</tr-->
											<?php endforeach; endif; unset($_from); ?>
											<tr><td colspan=4 align=right><b>BUDGET TOTAL DE L'ACTIVITE</b></td>
											<td align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldepreunion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td>
											<td align="center">&nbsp;</td>
											</tr>
											</table>
												</td>
												
											</tr>
											<input type="hidden" name="nbnatdepense" id="nbnatdepense" value="<?php echo count($this->_tpl_vars['NATDEPENSES']); ?>
">

										<?php endif; ?>
										<!-- Handle the ui types display -->
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
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
" class="crmButton small save" onclick="this.form.action.value='Save'; displaydeleted(); if(!isFieldsFormValide(this.form)) return false; return formValidate() " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
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