<?php /* Smarty version 2.6.18, created on 2018-04-13 12:00:22
         compiled from ListViewCurrentMission.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewCurrentMission.tpl', 56, false),array('function', 'html_options', 'ListViewCurrentMission.tpl', 68, false),)), $this); ?>

			<div align=center>
			<table border=0 cellspacing=1 cellpadding=3 width=99% class="lvt small">
			<th colspan=6><h2> Liste du personnel en mission au <?php echo $this->_tpl_vars['DATEJOUR']; ?>
</h2></th>
			<!-- Table Headers -->
			<tr>
           				
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Numeroom']; ?>
</td>
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Nomcomplet']; ?>
</td>
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Objet']; ?>
</td>
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Lieu']; ?>
</td>
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Datedepart']; ?>
</td>
 					<td class="lvtCol" align=center nowrap><?php echo $this->_tpl_vars['MOD']['Datearrivee']; ?>
</td>
 		
			</tr>
			<!-- Table Contents -->
			<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['depart'] => $this->_tpl_vars['missiondeparts']):
?>
				<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'">
					<td colspan=6 class="lvtCol">
						<?php echo $this->_tpl_vars['missiondeparts']['libdepart']; ?>

					</td>
				</tr>
				<?php $_from = $this->_tpl_vars['missiondeparts']['missions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
					<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
						
						<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cols'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cols']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['cols']['iteration']++;
?>
							<?php if (($this->_foreach['cols']['iteration']-1) == 2): ?>
								<td width=40%>
									<?php echo $this->_tpl_vars['data']; ?>

								</td>
							<?php else: ?>
								<td nowrap>
									<?php echo $this->_tpl_vars['data']; ?>

								</td>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			<?php endforeach; else: ?>
			<tr><td style="background-color:#efefef;height:340px" align="center" colspan="<?php echo $this->_foreach['listviewforeach']['iteration']+1; ?>
">
			<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 45%; position: relative; z-index: 10000000;">
											
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
					<td rowspan="2" width="25%"><img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="61"></td>
					<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%">
					<span class="genHeaderSmall">Aucune Mission en cours !!!</span></td>
				</tr>
				
				</table> 
			
		       </td>
		   </tr>
	    </table>
 <?php endif; unset($_from); ?>
<?php echo $this->_tpl_vars['SELECT_SCRIPT']; ?>

<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>
</select></div>