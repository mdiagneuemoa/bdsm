<?php /* Smarty version 2.6.18, created on 2009-03-26 16:33:58
         compiled from QuickCreateHidden.tpl */ ?>
<?php if ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
	<form name="QcEditView" onSubmit="return getFormValidate('qcform');" method="POST" action="index.php"  ENCTYPE="multipart/form-data">
<?php else: ?>
	<form name="QcEditView" onSubmit="return getFormValidate('qcform');" method="POST" action="index.php">
<?php endif; ?>

<?php if ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
	<input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Events'): ?>
        <input type="hidden" name="activity_mode" value="<?php echo $this->_tpl_vars['ACTIVITY_MODE']; ?>
">
<?php endif; ?>
	<input type="hidden" name="record" value="">
	<input type="hidden" name="action" value="Save">
	<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	<input type="hidden" name="assigned_user_id" value="<?php echo $this->_tpl_vars['USERID']; ?>
">