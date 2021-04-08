<?php /* Smarty version 2.6.18, created on 2018-01-26 09:19:35
         compiled from Buttons_List_ReportingRegie.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Buttons_List_ReportingRegie.tpl', 45, false),)), $this); ?>
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
	<?php if ($this->_tpl_vars['RIGHT_LABEL'] == 'TraitementConventions'): ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=index&module=TraitementConventions&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['TraitementConventions']; ?>
</a></td>
	<?php elseif ($this->_tpl_vars['RIGHT_LABEL'] == 'SuiviConventions'): ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=index&module=SuiviConventions&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['SuiviConventions']; ?>
</a></td>
	<?php elseif ($this->_tpl_vars['RIGHT_LABEL'] == 'ExecutionConventions'): ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=index&module=ExecutionConventions&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['ExecutionConventions']; ?>
</a></td>
	<?php elseif ($this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 24 || $this->_tpl_vars['CURRENT_USER_PROFIL_ID'] == 23): ?>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['MODULELABEL']; ?>
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
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
						<td style="padding-right:0px;padding-left:10px;"><img src="<?php echo vtiger_imageurl('btnL3Add-Faded.gif', $this->_tpl_vars['THEME']); ?>
" border=0></td>	
						<td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch');mergehide('mergeDup')" ><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Search.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_ALT']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_TITLE']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." border=0></a></a></td>
						<td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('filterAcc2');searchshowhide('filterAcc2','advSearch');mergehide('mergeDup')" ><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnFilter.jpg" alt="<?php echo $this->_tpl_vars['APP']['LBL_FILTER_ALT']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_FILTER_TITLE']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." border=0></a></a></td>
						</table>
			</td>
			</tr>
			</table>
		</td>
	
		</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>