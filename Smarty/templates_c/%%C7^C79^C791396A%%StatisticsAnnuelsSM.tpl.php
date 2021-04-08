<?php /* Smarty version 2.6.18, created on 2020-10-05 23:29:20
         compiled from StatisticsAnnuelsSM.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'StatisticsAnnuelsSM.tpl', 17, false),array('modifier', 'truncate', 'StatisticsAnnuelsSM.tpl', 32, false),)), $this); ?>
<table border=0 cellspacing=1 cellpadding=3  class="lvt small" align=center width=100%>
										
										
										<!--tr><td class="lvtCol" align=center ><?php echo $this->_tpl_vars['DESCSFICHE']; ?>
</td>
											<td  width=50 class="lvtCol"  height=10	valign=middle nowrap>
											<input 
												class="crmbutton small edit" 
												type="button" 
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SAISIE_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
											<td  width=50 class="lvtCol"	valign=middle nowrap>
											<input 
												class="crmbutton small edit" 
												type="button" 
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VALIDATION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
											<td class="lvtCol" width=10	valign=middle nowrap><img src="<?php echo vtiger_imageurl('exportpdf.jpg', $this->_tpl_vars['THEME']); ?>
" width=30> &nbsp;&nbsp;
											<td class="lvtCol" width=10 valign=middle nowrap><img src="<?php echo vtiger_imageurl('exportxsl.jpg', $this->_tpl_vars['THEME']); ?>
" width=30>&nbsp;
											</td-->
										</tr-->
								</table>	
								<div id="conteneur">								
										<!--div id="table_gauche" >
										    <table border=0 cellspacing=1 cellpadding=3  class="lvt small">
												<tr>
													<td class="lvtCol">CODE <br>&nbsp;</td>
													<td class="lvtCol">INTITULE<br>&nbsp;</td>
												</tr>
											
												<?php $this->assign('decal', ''); ?>
												<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k1'] => $this->_tpl_vars['data']):
?>
												<?php if (((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) == 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;'); ?>
													<?php $this->assign('niveaustyle', 'fichedont'); ?>
												<?php endif; ?>
												<?php if ($this->_tpl_vars['data']['niveau'] == 0 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', ''); ?>
													<?php $this->assign('niveaustyle', 'fichen1'); ?>
												<?php elseif ($this->_tpl_vars['data']['niveau'] == 1 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;'); ?>
													<?php $this->assign('niveaustyle', 'fichen2'); ?>
												<?php elseif ($this->_tpl_vars['data']['niveau'] == 2 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); ?>
													<?php $this->assign('niveaustyle', 'fichen3'); ?>
												<?php elseif ($this->_tpl_vars['data']['niveau'] == 3 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); ?>
													<?php $this->assign('niveaustyle', ''); ?>
												<?php elseif ($this->_tpl_vars['data']['niveau'] == 4 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); ?>	
													<?php $this->assign('niveaustyle', ''); ?>
												<?php elseif ($this->_tpl_vars['data']['niveau'] == 5 && ((is_array($_tmp=$this->_tpl_vars['data']['intitule'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, "") : smarty_modifier_truncate($_tmp, 4, "")) != 'Dont'): ?>
													<?php $this->assign('decal', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); ?>	
												<?php endif; ?>				
												
														<tr bgcolor=white class="<?php echo $this->_tpl_vars['niveaustyle']; ?>
" >
															<td><?php echo $this->_tpl_vars['k1']; ?>
</td><td><?php echo $this->_tpl_vars['decal']; ?>
<?php echo $this->_tpl_vars['data']['intitule']; ?>
</td>
														</tr>
													<tr>
												<?php endforeach; endif; unset($_from); ?>
											</table>
										  </div>    
										  <div id="table_droite">
										     <table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>
												
												<tr>
														<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['annee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['an'] => $this->_tpl_vars['data']):
?>
															<td align=center class="lvtCol" width=50><b><?php echo $this->_tpl_vars['data']['annee']; ?>
</b> <br><?php echo $this->_tpl_vars['data']['etat']; ?>
</td>
														<?php endforeach; endif; unset($_from); ?>
												</tr>
												
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
														<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['annee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['an'] => $this->_tpl_vars['data']):
?>
															<td align=center  width=50>&nbsp;</td>
														<?php endforeach; endif; unset($_from); ?>
												</tr>
																								
												<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dataflux']):
?>
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															<?php $_from = $this->_tpl_vars['dataflux']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['an'] => $this->_tpl_vars['dataan']):
?>
																	<?php $_from = $this->_tpl_vars['dataan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dataf']):
?>
																		<td align=center><?php echo $this->_tpl_vars['dataf']; ?>
</td>
																	<?php endforeach; endif; unset($_from); ?>
															<?php endforeach; endif; unset($_from); ?>
														</tr>
													
													<tr>
													
												<?php endforeach; endif; unset($_from); ?>
												
											</table>
										  </div>
										</div-->
									
						</div>
				   </td>
                </tr>
                
         
            
        </table>