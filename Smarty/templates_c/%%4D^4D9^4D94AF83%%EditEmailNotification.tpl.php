<?php /* Smarty version 2.6.18, created on 2009-07-24 01:36:17
         compiled from Settings/EditEmailNotification.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Settings/EditEmailNotification.tpl', 18, false),)), $this); ?>

<?php if ($this->_tpl_vars['NOTIFY_DETAILS']['type'] == 'select'): ?>
<div id="orgLay" class="layerPopup">
<table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
<tr>
	<td class="layerPopupHeading" align="left"><?php echo $this->_tpl_vars['NOTIFY_DETAILS']['name']; ?>
</td>
	<td align="right" class="small"><a href="javascript:hide('editdiv');"><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="middle" border="0"></a></td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
<tr>
	<td class="small">
	<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
	<tr>
	<td align="right"  class="cellLabel small" width="40%"><b><?php echo $this->_tpl_vars['MOD']['LBL_STATUS']; ?>
 :</b></td>
	<td align="left"  class="cellText small" width="60%">
		<select class="small" id="notify_status" disabled>
	<?php if ($this->_tpl_vars['NOTIFY_DETAILS']['active'] == 1): ?>
		<option value="1" "selected"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0"><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php else: ?>
		<option value="1"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0" "selected"><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php endif; ?>
	</select>
</td>
</tr>
<tr><td colspan="2" class="dvInnerHeader"><b><?php echo $this->_tpl_vars['MOD']['LBL_SELECT_EMAIL_TEMPLATE_FOR']; ?>
  <?php echo $this->_tpl_vars['NOTIFY_DETAILS']['name']; ?>
</b></td></tr>
<tr>
<td align="right" class="cellLabel small"><b><?php echo $this->_tpl_vars['MOD']['LBL_TEMPLATE']; ?>
 : </b></td>
<td align="left"  class="cellText small">
<input type="hidden" id="notifysubject" value="aaaa">
	<select class="small" id="notifybody">

	<?php $_from = $this->_tpl_vars['VALUES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
		<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['SEL_ID']): ?>
		<option value="<?php echo $this->_tpl_vars['k']; ?>
" "selected"><?php echo $this->_tpl_vars['v']; ?>
</option>
		<?php else: ?>
		<option value="<?php echo $this->_tpl_vars['k']; ?>
"><?php echo $this->_tpl_vars['v']; ?>
</option>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>

	</select>

</td>
</tr>
</table>
</td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
<tr>
<td class="small" align="center">
	<input name="save" value=" <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
 " class="crmButton small save" type="button" onClick="fetchSaveNotify('<?php echo $this->_tpl_vars['NOTIFY_DETAILS']['id']; ?>
')">
	<input name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " class="crmButton small cancel" type="button" onClick="hide('editdiv');">
</td>
</tr>
</table>
</div>


	<?php else: ?>



<div id="orgLay" class="layerPopup">
<table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
<tr>
	<td class="layerPopupHeading" align="left"><?php echo $this->_tpl_vars['NOTIFY_DETAILS']['name']; ?>
</td>
	<td align="right" class="small"><a href="javascript:hide('editdiv');"><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="middle" border="0"></a></td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
<tr>
	<td class="small">
	<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
	<tr>
	<td align="right"  class="cellLabel small" width="40%"><b><?php echo $this->_tpl_vars['MOD']['LBL_STATUS']; ?>
 :</b></td>
	<td align="left"  class="cellText small" width="60%">
	<?php if ($this->_tpl_vars['NOTIFY_DETAILS']['id'] != 7): ?>
		<select class="small" id="notify_status">
	<?php else: ?>	
		<select class="small" disabled id="notify_status">
	<?php endif; ?>
	<?php if ($this->_tpl_vars['NOTIFY_DETAILS']['active'] == 1): ?>
		<option value="1" "selected"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0"><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php else: ?>
		<option value="1"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0" "selected"><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php endif; ?>
	</select>
</td>
</tr>
<tr><td colspan="2" class="dvInnerHeader"><b><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_CONTENTS']; ?>
</b></td></tr>
<tr>
<td align="right" class="cellLabel small"><b><?php echo $this->_tpl_vars['MOD']['LBL_SUBJECT']; ?>
 : </b></td>
<td align="left"  class="cellText small"><input class="txtBox" id="notifysubject" name="notifysubject" value="<?php echo $this->_tpl_vars['NOTIFY_DETAILS']['subject']; ?>
" size="40" type="text"></td>
</tr>
<tr>
<td align="right"  class="cellLabel small" valign="top"><b><?php echo $this->_tpl_vars['MOD']['LBL_MESSAGE']; ?>
 : </b></td>
<td align="left"  class="cellText small"><textarea id="notifybody" name="notifybody" class="txtBox" rows="5" cols="40"><?php echo $this->_tpl_vars['NOTIFY_DETAILS']['body']; ?>
</textarea></td>
</tr>
</table>
</td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
<tr>
<td class="small" align="center">
	<input name="save" value=" <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
 " class="crmButton small save" type="button" onClick="fetchSaveNotify('<?php echo $this->_tpl_vars['NOTIFY_DETAILS']['id']; ?>
')">
	<input name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " class="crmButton small cancel" type="button" onClick="hide('editdiv');">
</td>
</tr>
</table>
</div>

<?php endif; ?>