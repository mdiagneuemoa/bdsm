<?php /* Smarty version 2.6.18, created on 2010-10-13 13:18:29
         compiled from modules/PickList/AddPickList.tpl */ ?>
<div style="position:relative;display: block;" id="orgLay" class="layerPopup">
	<table border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
		<tr>
			<td class="layerPopupHeading" align="left" width="40%" nowrap><?php echo $this->_tpl_vars['MOD']['ADD_PICKLIST_VALUES']; ?>
 - <?php echo $this->_tpl_vars['FIELDLABEL']; ?>
</td>
		</tr>
	</table>

	<table border=0 cellspacing=0 cellpadding=5 width=100%>
		<tr>	
			<td rowspan=3 valign=top align=left width=250px;>	
				<b><?php echo $this->_tpl_vars['MOD']['LBL_EXISTING_PICKLIST_VALUES']; ?>
</b>
				<div id="add_availPickList" name="availList" style="overflow:auto; height: 150px;width:200px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;"> 				
					<table style="padding-left:5px" cellpadding="0" cellspacing="3" width="100%">
						<?php $_from = $this->_tpl_vars['PICKVAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pick_val']):
?>
							<tr style="background-color: #ffffff;">
								<td>
									<span class="picklist_existing_options"><?php echo $this->_tpl_vars['pick_val']; ?>
</span>
								</td>
							</tr>
						<?php endforeach; endif; unset($_from); ?>
					</table>
				</div>
				<br>
				<?php if (is_array ( $this->_tpl_vars['NONEDITPICKLIST'] )): ?>				
					<b><?php echo $this->_tpl_vars['MOD']['LBL_NON_EDITABLE_PICKLIST_ENTRIES']; ?>
 :</b>
					<div id="nonedit_pl_values" name="availList" style="overflow:auto; height: 150px;width:200px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
						<table style="padding-left:5px" cellspacing="3" cellpadding="0" width="100%">
							<?php $_from = $this->_tpl_vars['NONEDITPICKLIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nonedit']):
?>
								<tr style="background-color: #ffffff;">
									<td>
									<span class="picklist_noneditable_options">
										<?php echo $this->_tpl_vars['nonedit']; ?>
		
									</span>							
									</td>
								</tr>	
							<?php endforeach; endif; unset($_from); ?>
						</table>
					</div>
				<?php endif; ?>
			</td>
			
			<td valign=top align=left width=300px;>
				<b><?php echo $this->_tpl_vars['MOD']['LBL_PICKLIST_ADDINFO']; ?>
</b>
				<textarea id="add_picklist_values" class="detailedViewTextBox" align="left" rows="10"></textarea>
			</td>
		</tr>
		<tr>
			<td valign=top align=left width=300px;>
				<b><?php echo $this->_tpl_vars['MOD']['LBL_SELECT_ROLES']; ?>
 </b><br />
				<select id="add_availRoles" multiple="multiple" wrap size="5" name="add_availRoles" style="width:250px;border:1px solid #666666;font-family:Arial, Helvetica, sans-serif;font-size:11px;">
					<?php $_from = $this->_tpl_vars['ROLEDETAILS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['role_id'] => $this->_tpl_vars['role_details']):
?>
						<option value="<?php echo $this->_tpl_vars['role_id']; ?>
"><?php echo $this->_tpl_vars['role_details']['0']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign=top align=right>
				<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" id="saveAddButton" name="save" class="crmButton small edit" onclick="validateAdd('<?php echo $this->_tpl_vars['FIELDNAME']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
');">
				<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" name="cancel" class="crmButton small cancel" onclick="fnhide('actiondiv');">
			</td>			
		</tr>
	</table>
</div>