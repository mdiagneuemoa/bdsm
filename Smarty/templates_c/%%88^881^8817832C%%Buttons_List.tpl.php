<?php /* Smarty version 2.6.18, created on 2020-10-06 10:27:59
         compiled from Buttons_List.tpl */ ?>
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
	
		<table border="0" cellspacing="3" cellpadding="3" width=90%>
			<tr>
				<td  align="left"><a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=EditView&return_action=DetailView&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><input type="button" value="Saisie de donn&eacute;es"></a> &nbsp; <a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=ListView&return_action=DetailView&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><input type="button" value="Consultation de donn&eacute;es"></a></td>				
				<td  align="right" ><a href="http://localhost/bdsm/index.php" target="_blank"><input type="button" value="Consulter les donn&eacute;es publi&eacute;es"></a></td>				
			</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>