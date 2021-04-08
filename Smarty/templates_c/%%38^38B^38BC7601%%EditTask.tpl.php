<?php /* Smarty version 2.6.18, created on 2009-06-04 16:31:35
         compiled from com_vtiger_workflow/EditTask.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'com_vtiger_workflow/Header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/jquery-1.2.6.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/functional.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/json2.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/edittaskscript.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	jQuery.noConflict();
	fn.addStylesheet('modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/style.css');
	edittaskscript(jQuery);
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'SetMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="view">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'com_vtiger_workflow/ModuleTitle.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<table class="tableHeading" width="75%" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td class="big" nowrap="">
				<strong><?php echo $this->_tpl_vars['MOD']['LBL_SUMMARY']; ?>
</strong>
			</td>
		</tr>
	</table>
	<form name="new_task">
		<table border="0" cellpadding="5" cellspacing="0" width="75%">
			<tr>
				<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['MOD']['LBL_TASK_TITLE']; ?>
</td>
				<td class="dvtCellInfo" align="left" colspan="3"><input type="text" name="summary" value="<?php echo $this->_tpl_vars['task']->summary; ?>
" id="save_summary"></td>
			</tr>
			<tr>
				<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['MOD']['LBL_PARENT_WORKFLOW']; ?>
</td>
				<td class="dvtCellInfo" align="left" colspan="3">
					<?php echo $this->_tpl_vars['workflow']->id; ?>
 <?php echo $this->_tpl_vars['workflow']->description; ?>

					<input type="hidden" name="workflow_id" value="<?php echo $this->_tpl_vars['workflow']->id; ?>
" id="save_workflow_id">
				</td>
			</tr>
			<tr>
				<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['MOD']['LBL_STATUS']; ?>
</td>
				<td class="dvtCellInfo" align="left" colspan="3">
					<select name="active">
						<option value="true"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
						<option value="false" <?php if (! $this->_tpl_vars['task']->active): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
					</select> 
				</td>
			</tr>
		</table>
		<h4><input type="checkbox" name="check_select_date" value="" id="check_select_date" <?php if ($this->_tpl_vars['trigger'] != null): ?>checked<?php endif; ?>> 
			<?php echo $this->_tpl_vars['MOD']['MSG_EXECUTE_TASK_DELAY']; ?>
.</h4>
		<div id="select_date" style="display:none;">
			<input type="text" name="select_date_days" value="<?php echo $this->_tpl_vars['trigger']['days']; ?>
" id="select_date_days" cols="3"> days 
			<select name="select_date_direction">
				<option <?php if ($this->_tpl_vars['trigger']['direction'] == 'after'): ?>selected<?php endif; ?> value='after'><?php echo $this->_tpl_vars['MOD']['LBL_AFTER']; ?>
</option>
				<option <?php if ($this->_tpl_vars['trigger']['direction'] == 'after'): ?>selected<?php endif; ?> value='before'><?php echo $this->_tpl_vars['MOD']['LBL_BEFORE']; ?>
</option>
			</select> 
			<select name="select_date_field">
<?php $_from = $this->_tpl_vars['dateFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['label']):
?>
				<option value='<?php echo $this->_tpl_vars['name']; ?>
' <?php if ($this->_tpl_vars['trigger']->name == $this->_tpl_vars['name']): ?>selected<?php endif; ?>>
					<?php echo $this->_tpl_vars['label']; ?>

				</option>
<?php endforeach; endif; unset($_from); ?>
			</select> 
		</div>
		<br>
		<table class="tableHeading" border="0"  width="100%" cellspacing="0" cellpadding="5">
			<tr>
				<td class="big" nowrap="">
					<strong><?php echo $this->_tpl_vars['MOD']['LBL_TASK_OPERATIONS']; ?>
</strong>
				</td>
			</tr>
		</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['taskTemplate']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<input type="hidden" name="save_type" value="<?php echo $this->_tpl_vars['saveType']; ?>
" id="save_save_type">
<?php if ($this->_tpl_vars['edit']): ?>
		<input type="hidden" name="task_id" value="<?php echo $this->_tpl_vars['task']->id; ?>
" id="save_task_id">
<?php endif; ?>
		<input type="hidden" name="task_type" value="<?php echo $this->_tpl_vars['taskType']; ?>
" id="save_task_type">
		<input type="hidden" name="action" value="savetask" id="save_action">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']->name; ?>
" id="save_module">
		<input type="hidden" name="return_url" value="<?php echo $this->_tpl_vars['returnUrl']; ?>
" id="save_return_url">
		<p><input type="submit" name="save" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" id="save"></p>
	</form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'com_vtiger_workflow/Footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>