<?php /* Smarty version 2.6.18, created on 2009-07-09 12:45:03
         compiled from Settings/CustomModEntityNoInfo.tpl */ ?>

<table width="100%"  border="0" cellspacing="0" cellpadding="5">

<tr>
	<td colspan=2 nowrap class="small cellLabel">
		<strong><?php echo $this->_tpl_vars['SELMODULE']; ?>
 Module Numbering</strong> <?php echo $this->_tpl_vars['STATUSMSG']; ?>

	</td>
</tr>

<tr>
	<td width="20%" nowrap class="small cellLabel"><strong>Use Prefix</strong></td>
    <td width="80%" class="small cellText">
	<input type="text" name="recprefix" class="small" style="width:30%" value="<?php echo $this->_tpl_vars['MODNUM_PREFIX']; ?>
"  />
	</td>
</tr>
<tr>
	<td width="20%" nowrap class="small cellLabel"><strong>Start Sequence <font color='red'>*</font></strong></td>
	<td width="80%" class="small cellText">
	<input type="text" name="recnumber" class="small" style="width:30%" value="<?php echo $this->_tpl_vars['MODNUM']; ?>
"  />
	</td>
</tr>

<tr>
	<td width="20%" nowrap colspan="2" align ="center">
		<input type="button" name="Button" class="crmbutton small save" value="Apply" onclick="updateModEntityNoSetting(this, this.form);" />
		<input type="button" name="Button" class="crmbutton small cancel" value="Cancel" onclick="history.back(-1);" /></td>
	</td>
</tr>
</table>
