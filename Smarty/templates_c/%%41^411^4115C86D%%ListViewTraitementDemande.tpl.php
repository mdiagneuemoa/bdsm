<?php /* Smarty version 2.6.18, created on 2018-05-04 10:28:14
         compiled from ListViewTraitementDemande.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewTraitementDemande.tpl', 80, false),)), $this); ?>

 <tr>
	<td colspan=4 class="dvInnerHeader">
    	<b><?php echo $this->_tpl_vars['APP']['LBL_DETAIL_DEMANDE_TRAITEMENT']; ?>
</b>
	</td>
 </tr>
 <tr><td>&nbsp;</td></tr>	
 
 <tr>
 <td>		
		<table border=0   align=center valign=bottom align=center>
		   <tr align=center>
		   <?php $_from = $this->_tpl_vars['LISTTRAITEMENT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['traitement']):
?>
			 		<?php $this->assign('k', $this->_tpl_vars['i']+1); ?>
			 		<?php if ($this->_tpl_vars['i']%4 == 0): ?>
						</tr> <tr>
					<?php endif; ?>
			 		<?php $_from = $this->_tpl_vars['traitement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['libelle'] => $this->_tpl_vars['value']):
?>
					
					   <?php if ($this->_tpl_vars['libelle'] == 'statut'): ?>
							
						    <?php if ($this->_tpl_vars['value'] == 'open'): ?>
								<td  class="submitted" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'submitted' || $this->_tpl_vars['value'] == 'submitted_grcj' || $this->_tpl_vars['value'] == 'sup_submitted'): ?>
								<td  class="submitted" width=180 height=30 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'dir_accepted' || $this->_tpl_vars['value'] == 'dc_submitted' || $this->_tpl_vars['value'] == 'dcpc_submitted'): ?>
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'reopen'): ?>
								<td  class="reopen" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'dc_accepted' || $this->_tpl_vars['value'] == 'grcj_accepted' || $this->_tpl_vars['value'] == 'dc_authorized' || $this->_tpl_vars['value'] == 'signed'): ?>
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'com_accepted' || $this->_tpl_vars['value'] == 'prcj_accepted'): ?>
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'umv_accepted' || $this->_tpl_vars['value'] == 'rumv_accepted'): ?>
								<td  class="accepted" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'authorized' || $this->_tpl_vars['value'] == 'pr_authorized'): ?>
								<td  class="authorized" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'ch_cancelled' || $this->_tpl_vars['value'] == 'grcj_cancelled' || $this->_tpl_vars['value'] == 'prcj_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'dir_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'dc_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'dcpc_omcancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'om_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'com_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == 'ag_cancelled'): ?>
								<td  class="cancelled" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'dir_denied'): ?>
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'dc_denied' || $this->_tpl_vars['value'] == 'grcj_denied' || $this->_tpl_vars['value'] == 'prcj_denied'): ?>
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'dcpc_denied'): ?>
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'com_denied'): ?>
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'umv_denied'): ?>
								<td  class="denied" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php elseif ($this->_tpl_vars['value'] == 'umv_tobecorrected'): ?>
								<td  class="tobecorrected" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">	
							<?php endif; ?>
					<?php endif; ?>	
					<?php endforeach; endif; unset($_from); ?>
					
					
				     <?php $_from = $this->_tpl_vars['traitement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['libelle'] => $this->_tpl_vars['value']):
?>
					 <?php if ($this->_tpl_vars['libelle'] == 'statut' && $this->_tpl_vars['value'] != ''): ?>
								<b><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['value']]; ?>
</b> 
					    <?php endif; ?><br>
						<?php if ($this->_tpl_vars['libelle'] == 'datemodification' && $this->_tpl_vars['value'] != ''): ?>
								 <?php echo $this->_tpl_vars['value']; ?>

					    <?php endif; ?>
				     <?php endforeach; endif; unset($_from); ?>
				     </td>
				
			 	 <?php if ($this->_tpl_vars['i'] != $this->_tpl_vars['NBTRAITEMENT']): ?>
				 	 	 <td><img src="<?php echo vtiger_imageurl('fleche-droite.jpg', $this->_tpl_vars['THEME']); ?>
" hspace="5" align="absmiddle" border="0"/></td>
				  <?php endif; ?>
			 <?php endforeach; endif; unset($_from); ?>
			 </tr>
		</table>	 
	</td>
</tr>			 
 <tr>
	<td>		
		<table class=tabs border=0 cellspacing=4 cellpadding=4 width=100% align=center valign=bottom>
			
			<tr><td>
			<?php $_from = $this->_tpl_vars['LISTTRAITEMENT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i'] => $this->_tpl_vars['traitement']):
?>
				
				<?php $this->assign('k', $this->_tpl_vars['i']+1); ?>
				<?php $this->assign('j', $this->_tpl_vars['k']%2); ?>
				<?php if ($this->_tpl_vars['j'] == 1): ?>
					</tr><tr><td>
				<?php endif; ?>
				
				 	<table class=small cellspacing="0" cellpadding="0" border="0" id=tab_<?php echo $this->_tpl_vars['i']; ?>
 style="display: none;" width=400 height=200 align=center valign=bottom bordercolor="eee">
						 	
					 	
						<?php $_from = $this->_tpl_vars['traitement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['libelle'] => $this->_tpl_vars['value']):
?>
						
							<?php if ($this->_tpl_vars['libelle'] == 'statut'): ?>
							
							 	    <tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['value']]; ?>
 </td>
								 	</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'description' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td class=dvtCellInfo colspan='2'>Description : <br><?php echo $this->_tpl_vars['value']; ?>
</td>
								</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'datemodification' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel>Date :</td>
									<td width=300 class=dvtCellInfo><?php echo $this->_tpl_vars['value']; ?>
</td>
								</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'nom' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel>Nom :</td>
									<td width=300 class=dvtCellInfo><?php echo $this->_tpl_vars['value']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['value']]; ?>
</td>
								</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'groupname' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel>Groupe :</td>
									<td width=300 class=dvtCellInfo><?php echo $this->_tpl_vars['value']; ?>
</td>
								</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'groupe' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel><?php echo $this->_tpl_vars['APP']['transfered']; ?>
 au :</td>
									<td width=300 class=dvtCellInfo> <?php echo $this->_tpl_vars['value']; ?>
 </td>
								</tr>
							
							<?php elseif ($this->_tpl_vars['libelle'] == 'motif' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel><?php echo $this->_tpl_vars['libelle']; ?>
 :</td>
									<td width=300 class=dvtCellInfo><?php echo $this->_tpl_vars['value']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['value']]; ?>
</td>
								</tr>
							<?php elseif ($this->_tpl_vars['libelle'] == 'autremotif' && $this->_tpl_vars['value'] != ''): ?>
								<tr>
									<td width=100 class=dvtCellLabel><?php echo $this->_tpl_vars['libelle']; ?>
 :</td>
									<td width=300 class=dvtCellInfo><?php echo $this->_tpl_vars['value']; ?>
</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
							
				 	</table>
				
			 <?php endforeach; endif; unset($_from); ?>
			 </td>
		     </tr>
		     
		</table>
	</td>
 </tr>


