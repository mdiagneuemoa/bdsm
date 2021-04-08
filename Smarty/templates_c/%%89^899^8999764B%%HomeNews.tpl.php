<?php /* Smarty version 2.6.18, created on 2009-03-31 18:10:39
         compiled from HomeNews.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'HomeNews.tpl', 7, false),)), $this); ?>
<div style='overflow: hidden;'>
<table border='0' cellpadding='2' cellspacing='0' width="100%">
	<tr valign=top>
		<td align='left'><b><?php echo $this->_tpl_vars['APP']['LBL_VTIGER_NEWS']; ?>
</b></td>
		<td align='right'>&nbsp;</td>
		<td align='right'>
			<a style='padding-left: 10px;' href="javascript:;" onclick="fninvsh('vtigerNewsPopupLay');"><img src='<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
' align='absmiddle' border='0'></a></td>
	</tr>

	<tr>
		<td colspan='3'><hr></td>
	</tr>

	<?php $_from = $this->_tpl_vars['NEWSLIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['NEWS']):
?>
	<tr>
		<td colspan='3' align='left'><a class='small' href='<?php echo $this->_tpl_vars['NEWS']->get_link(); ?>
' target='_blank' style='color: #0070BA;'><?php echo $this->_tpl_vars['NEWS']->get_title(); ?>
</a></td>
	</tr>
	<?php endforeach; else: ?>
	<tr>
		<td colspan='3'><?php echo $this->_tpl_vars['MOD']['LBL_NEWS_NO']; ?>
</td>
	</tr>
	<?php endif; unset($_from); ?>
</table>
</div>