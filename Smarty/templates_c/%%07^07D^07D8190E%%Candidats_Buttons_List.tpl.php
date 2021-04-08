<?php /* Smarty version 2.6.18, created on 2017-02-06 17:12:15
         compiled from Candidats_Buttons_List.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Candidats_Buttons_List.tpl', 43, false),)), $this); ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
<tr><td style="height:2px"></td></tr>
<tr>
	<?php $this->assign('action', 'ListView'); ?>
	<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
	<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]): ?>
		<?php $this->assign('MODULELABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]); ?>
	<?php endif; ?>	
	<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == '50'): ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 ><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</td>
	<?php else: ?>
			<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=<?php echo $this->_tpl_vars['action']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</a></td>

	<?php endif; ?>	
	<td width=100% nowrap>
	
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="sep1" style="width:1px;"></td>
		<td class=small >
			<!-- Add and Search -->
			<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL_ID'] != '50'): ?>
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<?php if ($this->_tpl_vars['CHECK']['EditView'] == 'yes'): ?>
			        	
						<td style="padding-right:0px;padding-left:10px;"><img src="<?php echo vtiger_imageurl('btnL3Add-Faded.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>	
					<?php endif; ?>

							 <td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch');mergehide('mergeDup')" ><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Search.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_ALT']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_TITLE']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." border=0></a></a></td>
								<td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('filterAcc');searchshowhide('filterAcc','advSearch');mergehide('mergeDup')" ><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnFilter.jpg" alt="<?php echo $this->_tpl_vars['APP']['LBL_FILTER_ALT']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_FILTER_TITLE']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." border=0></a></a></td>
								
						
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
			<?php endif; ?>
		</td>
			
		
		<td style="width:20px;">&nbsp;</td>
		
		</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>