<?php /* Smarty version 2.6.18, created on 2009-06-04 16:31:09
         compiled from com_vtiger_workflow/EditWorkflow.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'com_vtiger_workflow/EditWorkflow.tpl', 28, false),)), $this); ?>
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
/resources/vtigerwebservices.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/parallelexecuter.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/editworkflowscript.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	jQuery.noConflict();
	fn.addStylesheet('modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/style.css');
	var moduleName = '<?php echo $this->_tpl_vars['workflow']->moduleName; ?>
';
<?php if ($this->_tpl_vars['workflow']->test): ?>
	var conditions = JSON.parse('<?php echo $this->_tpl_vars['workflow']->test; ?>
');
<?php else: ?>
	var conditions = null;
<?php endif; ?>
	editworkflowscript(jQuery, conditions);
</script>

<div id="new_task_popup" class='layerPopup' style="display:none;">
	<table width="100%" cellspacing="0" cellpadding="5" border="0" class="layerHeadingULine">
		<tr>
			<td width="60%" align="left" class="layerPopupHeading">
				<?php echo $this->_tpl_vars['MOD']['LBL_CREATE_TASK']; ?>

				</td>
			<td width="40%" align="right">
				<a href="javascript:void(0);" id="new_task_popup_close">
					<img border="0" align="absmiddle" src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
"/>
				</a>
			</td>
		</tr>
	</table>

	<form action="index.php" method="get" accept-charset="utf-8">
	<div class="popup_content">
		<?php echo $this->_tpl_vars['MOD']['LBL_CREATE_TASK_OF_TYPE']; ?>
 
		<select name="task_type">
	<?php $_from = $this->_tpl_vars['taskTypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['taskType']):
?>
			<option value='<?php echo $this->_tpl_vars['taskType']; ?>
'>
				<?php echo $this->_tpl_vars['MOD'][$this->_tpl_vars['taskType']]; ?>

			</option>
	<?php endforeach; endif; unset($_from); ?>
		</select>
		<input type="hidden" name="module_name" value="<?php echo $this->_tpl_vars['workflow']->moduleName; ?>
">
		<input type="hidden" name="save_type" value="new" id="save_type_new">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']->name; ?>
" id="save_module">
		<input type="hidden" name="action" value="edittask" id="save_action">
		<input type="hidden" name="return_url" value="<?php echo $this->_tpl_vars['newTaskReturnUrl']; ?>
" id="save_return_url">
		<input type="hidden" name="workflow_id" value="<?php echo $this->_tpl_vars['workflow']->id; ?>
">
	</div>
	<table width="100%" cellspacing="0" cellpadding="5" border="0" class="layerPopupTransport">
		<tr><td align="center">
			<input type="submit" class="crmButton small save" value="<?php echo $this->_tpl_vars['APP']['LBL_CREATE_BUTTON_LABEL']; ?>
" name="save" id='new_task_popup_save'/> 
			<input type="button" class="crmButton small cancel" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " name="cancel" id='new_task_popup_cancel'/>
		</td></tr>
	</table>
	</form>
</div>
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
	<br>
	<form name="new_workflow" action="index.php">
		<table class="tableHeading" width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td class="big" nowrap="">
					<strong><?php echo $this->_tpl_vars['MOD']['LBL_SUMMARY']; ?>
</strong>
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
				<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['MOD']['LBL_SUMMARY']; ?>
</td>
				<td class="dvtCellInfo" align="left" colspan="3"><input type="text" name="description" id="save_description" value="<?php echo $this->_tpl_vars['workflow']->description; ?>
"></td>
			</tr>
			<tr>
				<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['APP']['LBL_MODULE']; ?>
</td>
				<td class="dvtCellInfo" align="left" colspan="3"><?php echo $this->_tpl_vars['workflow']->moduleName; ?>
</td>
			</tr>
		</table>
		<br>
		<table class="tableHeading" width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td class="big" nowrap="">
					<strong><?php echo $this->_tpl_vars['MOD']['LBL_WHEN_TO_RUN_WORKFLOW']; ?>
</strong>
				</td>
			</tr>
		</table>
		<table border="0" >
			<tr><td><input type="radio" name="execution_condition" value="ON_FIRST_SAVE" 
				<?php if ($this->_tpl_vars['workflow']->executionConditionAsLabel() == 'ON_FIRST_SAVE'): ?>checked<?php endif; ?>/></td> 
				<td><?php echo $this->_tpl_vars['MOD']['LBL_ONLY_ON_FIRST_SAVE']; ?>
.</td></tr>
			<tr><td><input type="radio" name="execution_condition" value="ONCE" 
							<?php if ($this->_tpl_vars['workflow']->executionConditionAsLabel() == 'ONCE'): ?>checked<?php endif; ?> /></td>
							<td><?php echo $this->_tpl_vars['MOD']['LBL_UNTIL_FIRST_TIME_CONDITION_TRUE']; ?>
.</td></tr>
						<tr><td><input type="radio" name="execution_condition" value="ON_EVERY_SAVE" 
				<?php if ($this->_tpl_vars['workflow']->executionConditionAsLabel() == 'ON_EVERY_SAVE'): ?>checked<?php endif; ?>/></td>
				<td><?php echo $this->_tpl_vars['MOD']['LBL_EVERYTIME_RECORD_SAVED']; ?>
.</td></tr>
		</table>
		<br>
		<table class="tableHeading" width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td class="big" nowrap="">
					<strong><?php echo $this->_tpl_vars['MOD']['LBL_CONDITIONS']; ?>
</strong>
				</td>
			</tr>
		</table>
		<div id="workflow_loading" style="display:none">
		  <h4><red>Loading </red><img src="themes/images/vtbusy.gif"</h4>
		</div>

		<table class="listTableTopButtons" width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td class="small"> <span id="status_message"></span> </td>
				<td class="small" align="right">
					<input type="button" class="crmButton create small" 
						value="<?php echo $this->_tpl_vars['MOD']['LBL_NEW_CONDITION_BUTTON_LABEL']; ?>
" id="save_conditions_add"/>
				</td>
			</tr>
		</table>
		<div id="save_conditions"></div>
		
		<p><input type="submit" id="save_submit" value="Save" class="crmButton small save"></p>
		<input type="hidden" name="module_name" value="<?php echo $this->_tpl_vars['workflow']->moduleName; ?>
" id="save_modulename">
		<input type="hidden" name="save_type" value="<?php echo $this->_tpl_vars['saveType']; ?>
" id="save_savetype">
<?php if ($this->_tpl_vars['saveType'] == 'edit'): ?>
		<input type="hidden" name="workflow_id" value="<?php echo $this->_tpl_vars['workflow']->id; ?>
">
<?php endif; ?>
		<input type="hidden" name="conditions" value="" id="save_conditions_json"/>
		<input type="hidden" name="action" value="saveworkflow" id="some_name">
		<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['module']->name; ?>
" id="some_name">
	</form>
<?php if ($this->_tpl_vars['saveType'] == 'edit'): ?>
	<table class="tableHeading" width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td class="big" nowrap="">
				<strong><?php echo $this->_tpl_vars['MOD']['LBL_TASKS']; ?>
</strong>
			</td>
		</tr>
	</table>
	<table class="listTableTopButtons" width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td class="small"> <span id="status_message"></span> </td>
			<td class="small" align="right">
				<input type="button" class="crmButton create small" 
					value="<?php echo $this->_tpl_vars['MOD']['LBL_NEW_TASK_BUTTON_LABEL']; ?>
" id='new_task'/>
			</td>
		</tr>
	</table>
	<table class="listTable" width="100%" border="0" cellspacing="0" cellpadding="5" id='expressionlist'>
		<tr>
			<td class="colHeader small" width="70%">
				<?php echo $this->_tpl_vars['MOD']['LBL_TASK']; ?>

			</td>
			<td class="colHeader small" width="15%">
				<?php echo $this->_tpl_vars['MOD']['LBL_STATUS']; ?>

			</td>
			<td class="colHeader small" width="15%">
				<?php echo $this->_tpl_vars['MOD']['LBL_LIST_TOOLS']; ?>

			</td>
		</tr>
<?php $_from = $this->_tpl_vars['tasks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['task']):
?>
		<tr>
			<td><?php echo $this->_tpl_vars['task']->summary; ?>
</td>
			<td><?php if ($this->_tpl_vars['task']->active): ?>Active<?php else: ?>Inactive<?php endif; ?></td>
			<td>
				<a href="<?php echo $this->_tpl_vars['module']->editTaskUrl($this->_tpl_vars['task']->id); ?>
">
					<img border="0" title="Edit" alt="Edit" \
						style="cursor: pointer;" id="expressionlist_editlink_<?php echo $this->_tpl_vars['task']->id; ?>
" \
						src="<?php echo vtiger_imageurl('editfield.gif', $this->_tpl_vars['THEME']); ?>
"/>
				</a>
				<a href="<?php echo $this->_tpl_vars['module']->deleteTaskUrl($this->_tpl_vars['task']->id); ?>
">
					<img border="0" title="Delete" alt="Delete"\
			 			src="<?php echo vtiger_imageurl('delete.gif', $this->_tpl_vars['THEME']); ?>
" \
						style="cursor: pointer;" id="expressionlist_deletelink_<?php echo $this->_tpl_vars['task']->id; ?>
"/>
				</a>
			</td>
		</tr>
<?php endforeach; endif; unset($_from); ?>
	</table>
<?php endif; ?>
</div>
<div id="dump" style="display:None;"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'com_vtiger_workflow/Footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>