<?php /* Smarty version 2.6.18, created on 2019-07-02 09:41:16
         compiled from StatisticsMensuelsSM.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'StatisticsMensuelsSM.tpl', 3, false),array('modifier', 'count', 'StatisticsMensuelsSM.tpl', 40, false),)), $this); ?>
<table border=0 cellspacing=1 cellpadding=3  class="lvt small" align=center width=100%>
										<tr><td class="lvtCol" align=center ><?php echo $this->_tpl_vars['DESCSFICHE']; ?>
</td>
											<td class="lvtCol" width=10	valign=middle nowrap><img src="<?php echo vtiger_imageurl('actionGeneratePDF.gif', $this->_tpl_vars['THEME']); ?>
" width=30 height=30> &nbsp;&nbsp;
											<td class="lvtCol" width=10 valign=middle nowrap><img src="<?php echo vtiger_imageurl('exportxsl.jpg', $this->_tpl_vars['THEME']); ?>
" width=30 height=30>&nbsp;
											</td>
										</tr>
								</table>	
								<div id="conteneur">								
										<div id="table_gauche">
										    <table border=0 cellspacing=1 cellpadding=3  class="lvt small">
											<?php if (count ( $this->_tpl_vars['INDICATEURSDATAS']['datas'] ) != 0): ?>
												<tr>
													<td class="lvtCol">CODE</td><td class="lvtCol">INTITULE</td>
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<td>&nbsp;</td><td>&nbsp;</td>
												</tr>
												<!--tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<td>&nbsp;</td><td><b>INDICES PAR FONCTION</b></td>
												</tr-->
											<?php endif; ?>
												<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k1'] => $this->_tpl_vars['data']):
?>
													<?php if ($this->_tpl_vars['data']['niveau'] == 0): ?>
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															<td><b><?php echo $this->_tpl_vars['k1']; ?>
</b></td><td><b><?php echo $this->_tpl_vars['data']['intitule']; ?>
</b></td>
														</tr>
													<?php else: ?>
														<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
															<td><?php echo $this->_tpl_vars['k1']; ?>
</td><td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['data']['intitule']; ?>
</td>
														</tr>
													<?php endif; ?>
													<tr>
												<?php endforeach; endif; unset($_from); ?>
											</table>
										  </div>    
										  <div id="table_droite">
										     <table border=0 cellspacing=1 cellpadding=3   class="lvt small" align=left>
												<tr>
														<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['mois']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['annee'] => $this->_tpl_vars['data']):
?>
															<td align=center class="lvtCol" width=50 colspan=<?php echo count($this->_tpl_vars['data']); ?>
><b><?php echo $this->_tpl_vars['annee']; ?>
</b></td>
														<?php endforeach; endif; unset($_from); ?>
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['mois']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['annee'] => $this->_tpl_vars['data']):
?>
														<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mois'] => $this->_tpl_vars['data']):
?>
															<?php if ($this->_tpl_vars['mois'] != '0'): ?>
																<td align=center width=50><b><?php echo $this->_tpl_vars['MOISSTATS'][$this->_tpl_vars['mois']]; ?>
</b></td>
															<?php endif; ?>
														<?php endforeach; endif; unset($_from); ?>
													<?php endforeach; endif; unset($_from); ?>
												</tr>
												<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" >
													<?php $_from = $this->_tpl_vars['INDICATEURSDATAS']['mois']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['annee'] => $this->_tpl_vars['data']):
?>
														<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mois'] => $this->_tpl_vars['data']):
?>
															<?php if ($this->_tpl_vars['mois'] != '0'): ?>
																<td align=center width=50>&nbsp;</td>
															<?php endif; ?>
														<?php endforeach; endif; unset($_from); ?>
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
    foreach ($_from as $this->_tpl_vars['mois'] => $this->_tpl_vars['datamois']):
?>
																	<?php $_from = $this->_tpl_vars['datamois']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dataf']):
?>
																		<td align=center><?php echo $this->_tpl_vars['dataf']; ?>
</td>
																	<?php endforeach; endif; unset($_from); ?>
																<?php endforeach; endif; unset($_from); ?>
															<?php endforeach; endif; unset($_from); ?>
														</tr>
													
													<tr>
												<?php endforeach; endif; unset($_from); ?>
											</table>
										  </div>
										</div>
									
						</div>
				   </td>
                </tr>
                
         
            
        </table>