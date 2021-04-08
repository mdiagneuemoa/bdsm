<?php /* Smarty version 2.6.18, created on 2009-07-28 13:28:32
         compiled from AccountHierarchy.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'AccountHierarchy.tpl', 26, false),)), $this); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['THEME_PATH']; ?>
style.css">
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/<?php  echo $_SESSION['authenticated_user_language']; ?>.lang.js?<?php  echo $_SESSION['vtiger_version']; ?>"></script>
<script language="JavaScript" type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
</table>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
     <tr>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

	<td class="showPanelBg" valign="top" width=100% style="padding:10px;">
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td class="moduleName" style="padding-left:10px;"><?php echo $this->_tpl_vars['APP']['LBL_ACCOUNT_HIERARCHY']; ?>
</td>
					<td align="right"><input type="button" class="crmbutton small cancel" onclick="window.history.back();" value="<?php echo $this->_tpl_vars['APP']['LBL_BACK']; ?>
" /></td>
				</tr>
			</table>
			
			<div id="ListViewContents">				
			<?php $_from = $this->_tpl_vars['ACCOUNT_HIERARCHY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
				<?php if ($this->_tpl_vars['header'] == 'header'): ?>
				<table border=0 cellspacing=1 cellpadding=3 width=100% style="background-color:#eaeaea;" class="small">
					<tr style="height:25px" bgcolor=white>
					<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['headerfields']):
?>
						<td class="lvtCol"><?php echo $this->_tpl_vars['headerfields']; ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
					</tr>
				<?php elseif ($this->_tpl_vars['header'] == 'entries'): ?>
					<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
					<tr bgcolor=white>
						<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['listfields']):
?>
						<td><?php echo $this->_tpl_vars['listfields']; ?>
</td>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</table>
				<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			</div>

     </td>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>