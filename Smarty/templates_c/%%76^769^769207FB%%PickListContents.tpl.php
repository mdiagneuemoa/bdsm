<?php /* Smarty version 2.6.18, created on 2011-12-16 18:03:01
         compiled from modules/PickList/PickListContents.tpl */ ?>
<div id="pickListContents">
<table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td class="big" width="20%" nowrap>
		<strong><?php echo $this->_tpl_vars['MOD']['LBL_SELECT_PICKLIST']; ?>
</strong>&nbsp;&nbsp;
	</td>
	<td class="cellText" width="40%">
		<select name="avail_picklists" id="allpick" class="small detailedViewTextBox" style="font-weight: normal;">
			<?php $_from = $this->_tpl_vars['ALL_LISTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fld_nam'] => $this->_tpl_vars['fld_lbl']):
?>
				<option value="<?php echo $this->_tpl_vars['fld_nam']; ?>
"><?php echo $this->_tpl_vars['fld_lbl']; ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
	<td nowrap align="right">
		<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_BUTTON']; ?>
" name="add" class="crmButton small create" onclick="showAddDiv();">
 		<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON']; ?>
" name="del" class="crmButton small edit" onclick="showEditDiv();">
 		<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON']; ?>
" name="del" class="crmButton small delete" onclick="showDeleteDiv();">
 	</td>
</tr>
</table>
<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]): ?>
	<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
<?php endif; ?>
<table class="tableHeading" border="0" cellpadding="7" cellspacing="0" width="100%">
<tr>
	<td  width="40%">
		<strong>
			<?php echo $this->_tpl_vars['MOD']['LBL_PICKLIST_AVAIL']; ?>
 <?php echo $this->_tpl_vars['MODULELABEL']; ?>
 for &nbsp;
		</strong>
		<select name="pickrole" id="pickid" class="detailedViewTextBox" onChange="showPicklistEntries('<?php echo $this->_tpl_vars['MODULE']; ?>
' );" style="width : auto;">
			<?php $_from = $this->_tpl_vars['ROLE_LISTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['roleid'] => $this->_tpl_vars['role']):
?>
				<?php if ($this->_tpl_vars['SEL_ROLEID'] == $this->_tpl_vars['roleid']): ?>
					<option value="<?php echo $this->_tpl_vars['roleid']; ?>
" selected><?php echo $this->_tpl_vars['role']; ?>
</option>
				<?php else: ?>
					<option value="<?php echo $this->_tpl_vars['roleid']; ?>
"><?php echo $this->_tpl_vars['role']; ?>
</option>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</select>
	</td>
</tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=100% class="listTable">
<tr>
<td valign=top width="50%">
	<table width="100%" class="listTable" cellpadding="5" cellspacing="0">
	<?php $_from = $this->_tpl_vars['PICKLIST_VALUES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['picklists']):
?>
	<tr>
		<?php $_from = $this->_tpl_vars['picklists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['picklistfields']):
?>
			<?php if ($this->_tpl_vars['picklistfields'] != ''): ?>
				<td class="listTableTopButtons small" style="padding-left:20px" valign="top" align="left">
					<?php if ($this->_tpl_vars['TEMP_MOD'][$this->_tpl_vars['picklistfields']['fieldlabel']] != ''): ?>	
						<b><?php echo $this->_tpl_vars['TEMP_MOD'][$this->_tpl_vars['picklistfields']['fieldlabel']]; ?>
</b>
					<?php else: ?>
						<b><?php echo $this->_tpl_vars['picklistfields']['fieldlabel']; ?>
</b>
					<?php endif; ?>
				</td>
				<td class="listTableTopButtons" valign="top">
					<input type="button" value="<?php echo $this->_tpl_vars['MOD_PICKLIST']['LBL_ASSIGN_BUTTON']; ?>
" class="crmButton small edit" onclick="assignPicklistValues('<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['picklistfields']['fieldname']; ?>
','<?php echo $this->_tpl_vars['picklistfields']['fieldlabel']; ?>
');" > 
				</td>
			<?php else: ?>
				<td class="listTableTopButtons small" colspan="2">&nbsp;</td>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
	<tr>
		<?php $_from = $this->_tpl_vars['picklists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['picklistelements']):
?>
			<?php if ($this->_tpl_vars['picklistelements'] != ''): ?>
				<td colspan="2" valign="top">
				<ul style="list-style-type: none;">
					<?php $_from = $this->_tpl_vars['picklistelements']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['elements']):
?>
						<?php if ($this->_tpl_vars['TEMP_MOD'][$this->_tpl_vars['elements']] != ''): ?>
							<li><?php echo $this->_tpl_vars['TEMP_MOD'][$this->_tpl_vars['elements']]; ?>
</li>
						<?php elseif ($this->_tpl_vars['MOD_PICKLIST'][$this->_tpl_vars['elements']] != ''): ?>
							<li><?php echo $this->_tpl_vars['MOD_PICKLIST'][$this->_tpl_vars['elements']]; ?>
</li>
						<?php else: ?>
							<li><?php echo $this->_tpl_vars['elements']; ?>
</li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
				</td>
			<?php else: ?>
				<td colspan="2">&nbsp;</td>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	</table> 
</td>
</tr>
</table>
</div>