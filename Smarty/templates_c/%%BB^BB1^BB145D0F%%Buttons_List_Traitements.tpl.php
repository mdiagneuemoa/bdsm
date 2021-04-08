<?php /* Smarty version 2.6.18, created on 2010-03-03 08:53:53
         compiled from Buttons_List_Traitements.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Buttons_List_Traitements.tpl', 39, false),)), $this); ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
<tr><td style="height:2px"></td></tr>
<tr>
	<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
	<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]): ?>
		<?php $this->assign('MODULELABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]); ?>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['CATEGORY'] == 'Settings'): ?>
	<!-- No List View in Settings - Action is index -->
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><a class="hdrLink" href="index.php?action=index&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</a></td>
	<?php else: ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=ListView&module=<?php echo $this->_tpl_vars['MODULE']; ?>
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
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
						<td style="padding-right:0px;padding-left:10px;"><img src="<?php echo vtiger_imageurl('btnL3Add-Faded.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>	
									
						<td style="padding-right:10px"><img src="<?php echo vtiger_imageurl('btnL3Search-Faded.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		
		<td style="width:20px;">&nbsp;</td>
		<td class="small">
				<!-- All Menu -->
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-left:10px;"><a href="javascript:;" onmouseout="fninvsh('allMenu');" onClick="fnvshobj(this,'allMenu')"><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3AllMenu.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_ALL_MENU_ALT']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_ALL_MENU_TITLE']; ?>
" border="0"></a></td>
				</tr>
				</table>
		</td>			
		</tr>
		</table>
	</td>
</tr>
</TABLE>