<?php /* Smarty version 2.6.18, created on 2009-09-08 19:23:46
         compiled from ListViewAjax.tpl */ ?>
			
<!-- Table to display the mails list -  Starts -->
				<div id="navTemp" style="display:none">
					<span style="float:left"><?php echo $this->_tpl_vars['ACCOUNT']; ?>
 &gt; <?php echo $this->_tpl_vars['MAILBOX']; ?>

					<?php if ($this->_tpl_vars['NUM_EMAILS'] != 0): ?>
                                                 <?php if ($this->_tpl_vars['NUM_EMAILS'] != 1): ?>
                                                        (<?php echo $this->_tpl_vars['NUM_EMAILS']; ?>
 Messages)
                                                 <?php else: ?>
                                                        (<?php echo $this->_tpl_vars['NUM_EMAILS']; ?>
 Message)
                                                 <?php endif; ?>
                                         <?php endif; ?>
					</span> <span style="float:right"><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</span>	
				</div>
				<span id="<?php echo $this->_tpl_vars['MAILBOX']; ?>
_tempcount" style="display:none" ><?php echo $this->_tpl_vars['UNREAD_COUNT']; ?>
</span>
				<div id="temp_boxlist" style="display:none">
					<ul style="list-style-type:none;">
					<?php $_from = $this->_tpl_vars['BOXLIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
						<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row_values']):
?>                                                                                                 <?php echo $this->_tpl_vars['row_values']; ?>
                                                                                                       <?php endforeach; endif; unset($_from); ?>                                                                                                          <?php endforeach; endif; unset($_from); ?>
					</ul>
				</div>
				<div id="temp_movepane" style="display:none">
					<input type="button" name="mass_del" value=" <?php echo $this->_tpl_vars['MOD']['LBL_DELETE']; ?>
 "  class="crmbutton small delete" onclick="mass_delete();"/>
                                        <?php echo $this->_tpl_vars['FOLDER_SELECT']; ?>

				</div>
			<div id="show_msg" class="layerPopup" align="center" style="padding: 5px;font-weight:bold;width: 400px;display:none;z-index:10000"></div>	
                                <form name="massdelete" method="post">
                                <table cellspacing="1" cellpadding="3" border="0" width="100%" id="message_table">
                                   <tr>
                                <th class="tableHeadBg"><input type="checkbox" name="select_all" value="checkbox"  onclick="toggleSelect(this.checked,'selected_id');"/></th>
                                        <?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
                                                <?php echo $this->_tpl_vars['element']; ?>

                                        <?php endforeach; endif; unset($_from); ?>
                                   </tr>
                                        <?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                                <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row_values']):
?>
                                                        <?php echo $this->_tpl_vars['row_values']; ?>

                                                <?php endforeach; endif; unset($_from); ?>
                                        <?php endforeach; endif; unset($_from); ?>
				</table>
                                </form>
                                <!-- Table to display the mails list - Ends -->