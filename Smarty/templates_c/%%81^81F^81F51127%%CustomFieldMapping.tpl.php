<?php /* Smarty version 2.6.18, created on 2009-07-13 11:11:49
         compiled from CustomFieldMapping.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'CustomFieldMapping.tpl', 15, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        <br>

		<div align=center>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'SetMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<!-- DISPLAY -->
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr align="left">
					<td rowspan="2" valign="top" width="50"><img src="<?php echo vtiger_imageurl('custom.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_USERS']; ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_USERS']; ?>
" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=ModuleManager&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['VTLIB_LBL_MODULE_MANAGER']; ?>
&gt;</a><a href="index.php?module=Settings&action=ModuleManager&module_settings=true&formodule=Leads&parenttab=Settings"><?php echo $this->_tpl_vars['MODULE']; ?>
</a> &gt; <?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_FIELD_SETTINGS']; ?>
</b></td>
				</tr>

				<tr align="left">
					<td class="small" valign="top"><?php echo $this->_tpl_vars['MOD']['LEADS_CUSTOM_FIELD_MAPPING']; ?>
</td>
				</tr>
				</table>
				
				<br>
				<form action="index.php?module=Settings&action=SaveConvertLead" method="post" name="index">
				<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td class="big" align="left"><strong><?php echo $this->_tpl_vars['MOD']['LBL_EDIT_FIELD_MAPPING']; ?>
</strong> </td>
					<td class="small">&nbsp;</td>
					<td class="small" align="right">&nbsp;&nbsp;
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" name="save" value=" &nbsp;<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
&nbsp; " class="crmButton small save" type="submit" onclick ="return validateCustomFieldAccounts();">
                     <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
>" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " onclick = "window.history.back()"  class="crmButton small cancel" type="button">
				</tr>
				</table>
				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td rowspan="2" class="colHeader small" width="2%">#</td>
					<td rowspan="2" class="colHeader small" width="15%"><?php echo $this->_tpl_vars['MOD']['FieldLabel']; ?>
</td>
					<td rowspan="2" class="colHeader small" width="15%"><?php echo $this->_tpl_vars['MOD']['FieldType']; ?>
</td>
					<td colspan="3" class="colHeader small" valign="top"><div align="center"><?php echo $this->_tpl_vars['MOD']['LBL_MAPPING_OTHER_MODULES']; ?>
</div></td>
				</tr>
				<tr>
					<td class="colHeader small" valign="top" width="23%"><?php echo $this->_tpl_vars['APP']['Accounts']; ?>
</td>
					<td class="colHeader small" valign="top" width="23%"><?php echo $this->_tpl_vars['APP']['Contacts']; ?>
</td>
					<td class="colHeader small" valign="top" width="24%"><?php echo $this->_tpl_vars['APP']['Potentials']; ?>
</td>
				</tr>
				<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cfarray'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cfarray']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['leadcf'] => $this->_tpl_vars['cfarray']):
        $this->_foreach['cfarray']['iteration']++;
?>
				<tr>
					<td class="listTableRow small"><?php echo $this->_tpl_vars['cfarray']['sno']; ?>
</td>
					<td class="listTableRow small"><?php echo $this->_tpl_vars['cfarray']['leadid']; ?>
</td>
					<td class="listTableRow small"><?php echo $this->_tpl_vars['cfarray']['fieldtype']; ?>
</td>
					<?php $_from = $this->_tpl_vars['cfarray']['account']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fldnameacc'] => $this->_tpl_vars['acc_cf']):
?>
					<td class="listTableRow small">
						<select name='<?php echo $this->_tpl_vars['fldnameacc']; ?>
' id='<?php echo $this->_tpl_vars['fldnameacc']; ?>
' onChange='return validateTypeforCFMapping("<?php echo $this->_tpl_vars['cfarray']['fieldtype']; ?>
","<?php echo $this->_tpl_vars['cfarray']['typeofdata']; ?>
","<?php echo $this->_tpl_vars['fldnameacc']; ?>
",this);' >
						<option value='None'><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</option>
						<?php $_from = $this->_tpl_vars['acc_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
							<option value="<?php echo $this->_tpl_vars['element']['fieldid']; ?>
" <?php echo $this->_tpl_vars['element']['selected']; ?>
><?php echo $this->_tpl_vars['element']['fieldlabel']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
						</select>
						<?php if (($this->_foreach['cfarray']['iteration']-1) == 0): ?>
							<?php $_from = $this->_tpl_vars['acc_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
								<input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' value='<?php echo $this->_tpl_vars['element']['fieldtype']; ?>
'>
								<input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' value='<?php echo $this->_tpl_vars['element']['typeofdata']; ?>
'>
							<?php endforeach; endif; unset($_from); ?>
						<?php endif; ?>
					</td>
					<?php endforeach; endif; unset($_from); ?>
					<?php $_from = $this->_tpl_vars['cfarray']['contact']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fldnamecon'] => $this->_tpl_vars['con_cf']):
?>
                    <td class="listTableRow small">
                        <select name='<?php echo $this->_tpl_vars['fldnamecon']; ?>
' id='<?php echo $this->_tpl_vars['fldnamecon']; ?>
' onChange='return validateTypeforCFMapping("<?php echo $this->_tpl_vars['cfarray']['fieldtype']; ?>
","<?php echo $this->_tpl_vars['cfarray']['typeofdata']; ?>
","<?php echo $this->_tpl_vars['fldnamecon']; ?>
",this);'>
						<option value='None'><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</option>
						<?php $_from = $this->_tpl_vars['con_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
							<option value="<?php echo $this->_tpl_vars['element']['fieldid']; ?>
" <?php echo $this->_tpl_vars['element']['selected']; ?>
><?php echo $this->_tpl_vars['element']['fieldlabel']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
                        </select>
					<?php if (($this->_foreach['cfarray']['iteration']-1) == 0): ?>
						<?php $_from = $this->_tpl_vars['con_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
                                                	<input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' value='<?php echo $this->_tpl_vars['element']['fieldtype']; ?>
' >
                                                	<input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' value='<?php echo $this->_tpl_vars['element']['typeofdata']; ?>
'>
						<?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
					</td>
				  	<?php endforeach; endif; unset($_from); ?>
					<?php $_from = $this->_tpl_vars['cfarray']['potential']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fldnamepot'] => $this->_tpl_vars['pot_cf']):
?>
					<td class="listTableRow small">
						<select name='<?php echo $this->_tpl_vars['fldnamepot']; ?>
' id='<?php echo $this->_tpl_vars['fldnamepot']; ?>
' onChange='return validateTypeforCFMapping("<?php echo $this->_tpl_vars['cfarray']['fieldtype']; ?>
","<?php echo $this->_tpl_vars['cfarray']['typeofdata']; ?>
","<?php echo $this->_tpl_vars['fldnamepot']; ?>
",this);'>
						<option value='None'><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</option>
						<?php $_from = $this->_tpl_vars['pot_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
							<option value="<?php echo $this->_tpl_vars['element']['fieldid']; ?>
" <?php echo $this->_tpl_vars['element']['selected']; ?>
><?php echo $this->_tpl_vars['element']['fieldlabel']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
                        </select>
					<?php if (($this->_foreach['cfarray']['iteration']-1) == 0): ?>
						<?php $_from = $this->_tpl_vars['pot_cf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
	                                        	<input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_type' value='<?php echo $this->_tpl_vars['element']['fieldtype']; ?>
'>
        	                                        <input type='hidden' name='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' id='<?php echo $this->_tpl_vars['element']['fieldid']; ?>
_typeofdata' value='<?php echo $this->_tpl_vars['element']['typeofdata']; ?>
'>
						<?php endforeach; endif; unset($_from); ?>
                                        <?php endif; ?>
					</td>
				    <?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
				</table>
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
					<td class="small">
		        	<strong><?php echo $this->_tpl_vars['APP']['LBL_NOTE']; ?>
: </strong> <?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_MAPP_INFO']; ?>

					</td>
				</tr>
				</table>
				<table border="0" cellpadding="5" cellspacing="0" width="100%">
				<tr>
		  			<td class="small" align="right" nowrap="nowrap"><a href="#top"><?php echo $this->_tpl_vars['MOD']['LBL_SCROLL']; ?>
</a></td>
				</tr>
				</table>
				</form>
				<br>
		</td>
		</tr>
		</table>
        </td>
        </tr>
        </table>
        </div>

        </td>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
        </tr>
</tbody>
</table>
<script>
	var alertmessage = new Array("<?php echo $this->_tpl_vars['MOD']['LBL_TYPEALERT_1']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_WITH']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_TYPEALERT_2']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_LENGTHALERT']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_DECIMALALERT']; ?>
");
</script>