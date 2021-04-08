<?php /* Smarty version 2.6.18, created on 2009-09-09 09:20:50
         compiled from EmailContents.tpl */ ?>
<div id="rssScroll">
	<table cellspacing="0" cellpadding="0" width=100%>
        <tr>
			<th width="5%" class='tableHeadBg'><input type="checkbox"  name="selectall" onClick=toggleSelect(this.checked,"selected_id")></th>
            <th width="65%" class='tableHeadBg'><?php echo $this->_tpl_vars['LISTHEADER']['0']; ?>
</th>
            <th width="15%" class='tableHeadBg'><?php echo $this->_tpl_vars['LISTHEADER']['1']; ?>
</th>
            <th width="15%" class='tableHeadBg'><?php echo $this->_tpl_vars['LISTHEADER']['2']; ?>
</th>
        </tr>
		<?php if ($this->_tpl_vars['LISTENTITY'] != NULL): ?>
			<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['row']):
?>
			    <tr id="row_<?php echo $this->_tpl_vars['id']; ?>
">
				<td>
				<span><input type="checkbox" name="selected_id" value= '<?php echo $this->_tpl_vars['id']; ?>
' onClick=toggleSelectAll(this.name,"selectall")>
				</span></td>
				<td onClick="getEmailContents('<?php echo $this->_tpl_vars['id']; ?>
');" style="cursor:pointer;"><b><?php echo $this->_tpl_vars['row']['0']; ?>
</b></td>
				<td onClick="getEmailContents('<?php echo $this->_tpl_vars['id']; ?>
');" style="cursor:pointer;"><?php echo $this->_tpl_vars['row']['1']; ?>
</td>
				<?php if ($this->_tpl_vars['EMAILFALG'][$this->_tpl_vars['id']] == 'SAVED'): ?>
					<td onClick="getEmailContents('<?php echo $this->_tpl_vars['id']; ?>
');" style="cursor:pointer;"></td>
				<?php else: ?>
					<td onClick="getEmailContents('<?php echo $this->_tpl_vars['id']; ?>
');" style="cursor:pointer;"><?php echo $this->_tpl_vars['row']['2']; ?>
</td>
				<?php endif; ?>
			        </tr>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
			<tr><td>&nbsp;</td><td align="center" nowrap><b><?php echo $this->_tpl_vars['MOD']['LBL_NO_RECORDS']; ?>
</b></td></tr>
		<?php endif; ?>
    </table>
</div>
<SCRIPT>
	if(gselectedrowid != 0)
	{
		var rowid = 'row_'+gselectedrowid;
	    getObj(rowid).className = 'emailSelected';
	}
</SCRIPT>