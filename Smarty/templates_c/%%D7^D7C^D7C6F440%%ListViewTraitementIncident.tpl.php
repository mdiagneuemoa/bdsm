<?php /* Smarty version 2.6.18, created on 2011-02-23 18:56:04
         compiled from ListViewTraitementIncident.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewTraitementIncident.tpl', 52, false),)), $this); ?>

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
		   <tr>
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
								
						    <?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['pending']): ?>
								<td  class="reservation" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['traited']): ?>
								<td  class="traitement" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['transfered']): ?>
								<td  class="transfert" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['reopen']): ?>
								<td  class="retraitement" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['closed']): ?>
								<td  class="cloture" width=180 height=80 onClick="javascript:displayTraitementById('tab_<?php echo $this->_tpl_vars['i']; ?>
' , <?php echo $this->_tpl_vars['NBTRAITEMENT']; ?>
);">
							<?php endif; ?>
							
						<?php endif; ?>
						
					<?php endforeach; endif; unset($_from); ?>
					
					<?php $_from = $this->_tpl_vars['traitement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['libelle'] => $this->_tpl_vars['value']):
?>
						<?php if ($this->_tpl_vars['libelle'] == 'groupe' && $this->_tpl_vars['value'] != ''): ?>
								<br><b>Destination : </b> <?php echo $this->_tpl_vars['value']; ?>
 <br>
					    <?php endif; ?>
				     <?php endforeach; endif; unset($_from); ?>
				     
				     <?php $_from = $this->_tpl_vars['traitement']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['libelle'] => $this->_tpl_vars['value']):
?>
						<?php if ($this->_tpl_vars['libelle'] == 'datemodification' && $this->_tpl_vars['value'] != ''): ?>
								<b>Date : </b> <?php echo $this->_tpl_vars['value']; ?>

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
	<td  height='50'>		
		<table border=0 cellspacing=4 cellpadding=4 width=100% align=center valign=bottom>
			
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
							
							 	 <?php if ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['pending'] && $this->_tpl_vars['value'] != ''): ?>
							 		<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> En cours de traitement</td>
								 	</tr>
								 <?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['closed'] && $this->_tpl_vars['value'] != ''): ?>
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Clotur&eacute;</td>
								 	</tr>
								 <?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['traited'] && $this->_tpl_vars['value'] != ''): ?>
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Trait&eacute;(e)</td>
								 	</tr>
								 <?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['transfered'] && $this->_tpl_vars['value'] != ''): ?>
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> Transf&eacute;r&eacute;(e)</td>
								 	</tr>
								 <?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['traited'] && $this->_tpl_vars['value'] != ''): ?>
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> A Traiter</td>
								 	</tr>
								 <?php elseif ($this->_tpl_vars['value'] == $this->_tpl_vars['APP']['reopen'] && $this->_tpl_vars['value'] != ''): ?>
									<tr>
								 		<td colspan='2' align="center" class=dvInnerHeader><b>Statut:</b> A Retraiter</td>
								 	</tr>
								 <?php endif; ?>
						        
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


