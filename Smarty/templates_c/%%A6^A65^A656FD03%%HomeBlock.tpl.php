<?php /* Smarty version 2.6.18, created on 2011-09-22 22:20:45
         compiled from Home/HomeBlock.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Home/HomeBlock.tpl', 58, false),array('modifier', 'truncate', 'Home/HomeBlock.tpl', 125, false),)), $this); ?>

<div class='hide_tab' id="editRowmodrss_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
" style="position:absolute; top:0px;left:0px;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="small" valign="top" >
	<tr>
<?php if ($this->_tpl_vars['HOME_STUFFTYPE'] == 'Module' || $this->_tpl_vars['HOME_STUFFTYPE'] == 'RSS' || $this->_tpl_vars['HOME_STUFFTYPE'] == 'Default'): ?>	
		<td align="left" class="homePageMatrixHdr" style="height:28px;" nowrap width="40%">
			<?php echo $this->_tpl_vars['MOD']['LBL_HOME_SHOW']; ?>
&nbsp;
			<select id="maxentries_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
" name="maxid" class="small" style="width:40px;">
	<?php unset($this->_sections['iter']);
$this->_sections['iter']['name'] = 'iter';
$this->_sections['iter']['start'] = (int)1;
$this->_sections['iter']['loop'] = is_array($_loop=13) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['iter']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['iter']['show'] = true;
$this->_sections['iter']['max'] = $this->_sections['iter']['loop'];
if ($this->_sections['iter']['start'] < 0)
    $this->_sections['iter']['start'] = max($this->_sections['iter']['step'] > 0 ? 0 : -1, $this->_sections['iter']['loop'] + $this->_sections['iter']['start']);
else
    $this->_sections['iter']['start'] = min($this->_sections['iter']['start'], $this->_sections['iter']['step'] > 0 ? $this->_sections['iter']['loop'] : $this->_sections['iter']['loop']-1);
if ($this->_sections['iter']['show']) {
    $this->_sections['iter']['total'] = min(ceil(($this->_sections['iter']['step'] > 0 ? $this->_sections['iter']['loop'] - $this->_sections['iter']['start'] : $this->_sections['iter']['start']+1)/abs($this->_sections['iter']['step'])), $this->_sections['iter']['max']);
    if ($this->_sections['iter']['total'] == 0)
        $this->_sections['iter']['show'] = false;
} else
    $this->_sections['iter']['total'] = 0;
if ($this->_sections['iter']['show']):

            for ($this->_sections['iter']['index'] = $this->_sections['iter']['start'], $this->_sections['iter']['iteration'] = 1;
                 $this->_sections['iter']['iteration'] <= $this->_sections['iter']['total'];
                 $this->_sections['iter']['index'] += $this->_sections['iter']['step'], $this->_sections['iter']['iteration']++):
$this->_sections['iter']['rownum'] = $this->_sections['iter']['iteration'];
$this->_sections['iter']['index_prev'] = $this->_sections['iter']['index'] - $this->_sections['iter']['step'];
$this->_sections['iter']['index_next'] = $this->_sections['iter']['index'] + $this->_sections['iter']['step'];
$this->_sections['iter']['first']      = ($this->_sections['iter']['iteration'] == 1);
$this->_sections['iter']['last']       = ($this->_sections['iter']['iteration'] == $this->_sections['iter']['total']);
?>
				<option value="<?php echo $this->_sections['iter']['index']; ?>
" <?php if ($this->_tpl_vars['HOME_STUFF']['Maxentries'] == $this->_sections['iter']['index']): ?> selected <?php endif; ?>>
					<?php echo $this->_sections['iter']['index']; ?>

				</option>
	<?php endfor; endif; ?>
			</select>&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_HOME_ITEMS']; ?>

		</td>
		<td align="right" class="homePageMatrixHdr" nowrap style="height:28px;" width=60%>
			<input type="button" name="save" value="Save" class="crmbutton small save" onclick="saveEntries('maxentries_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
')">
			<input type="button" name="cancel" value="Cancel" class="crmbutton small cancel" onclick="cancelEntries('editRowmodrss_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
')">
		</td>		
<?php elseif ($this->_tpl_vars['HOME_STUFFTYPE'] == 'DashBoard'): ?>
		<td  valign="top" align='center' class="homePageMatrixHdr" style="height:28px;" width=60%>
			<input type="radio" id="dashradio_0" name="dashradio_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
" value="horizontalbarchart" <?php if ($this->_tpl_vars['DASHDETAILS'][$this->_tpl_vars['HOME_STUFFID']]['Chart'] == 'horizontalbarchart'): ?>checked<?php endif; ?>>Horizontal
			<input type="radio" id="dashradio_1" name="dashradio_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
" value="verticalbarchart"<?php if ($this->_tpl_vars['DASHDETAILS'][$this->_tpl_vars['HOME_STUFFID']]['Chart'] == 'verticalbarchart'): ?>checked<?php endif; ?>>Vertical
			<input type="radio" id="dashradio_2" name="dashradio_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
" value="piechart" <?php if ($this->_tpl_vars['DASHDETAILS'][$this->_tpl_vars['HOME_STUFFID']]['Chart'] == 'piechart'): ?>checked<?php endif; ?>>Pie
		</td>
		</tr>
		<tr>
			<td  valign="top" align="center" class="homePageMatrixHdr" nowrap style="height:28px;" width="40%">
			<input type="button" name="save" value="Save" class="crmbutton small save" onclick="saveEditDash(<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
)">
			<input type="button" name="cancel" value="Cancel" class="crmbutton small cancel" onclick="cancelEntries('editRowmodrss_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
')">
			</td>
		</tr>		
<?php endif; ?>
	</tr>
	</table>
</div>

<?php if ($this->_tpl_vars['HOME_STUFFTYPE'] == 'Module'): ?>
	<input type=hidden id=more_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
 value="<?php echo $this->_tpl_vars['HOME_STUFF']['ModuleName']; ?>
"/>
	<input type=hidden id=cvid_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
 value="<?php echo $this->_tpl_vars['HOME_STUFF']['cvid']; ?>
">
	<table border=0 cellspacing=0 cellpadding=5 width="100%">
	<?php $this->assign('cvid', $this->_tpl_vars['HOME_STUFF']['cvid']); ?>
	<?php $this->assign('modulename', $this->_tpl_vars['HOME_STUFF']['ModuleName']); ?>
	<tr>	   
		<td width=5%>
			&nbsp;
		</td>
		<?php $_from = $this->_tpl_vars['HOME_STUFF']['Header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
		<td align="left" nowrap>
			<b><?php echo $this->_tpl_vars['header']; ?>
</b>
		</td>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
		<?php $_from = $this->_tpl_vars['HOME_STUFF']['Entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['crmid'] => $this->_tpl_vars['row']):
?>
 	<tr>
		<td>
			<a href="index.php?module=<?php echo $this->_tpl_vars['HOME_STUFF']['ModuleName']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['crmid']; ?>
">
				<img src="<?php echo vtiger_imageurl('bookMark.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0" alt="Details" title="Details"/>
			</a>
		</td>
			<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
		<td align="left"/>
			<?php echo $this->_tpl_vars['element']; ?>

		</td>
			<?php endforeach; endif; unset($_from); ?>
	</tr>
		<?php endforeach; endif; unset($_from); ?>
		
	</table>

<?php elseif ($this->_tpl_vars['HOME_STUFFTYPE'] == 'Default'): ?>
	<input type=hidden id=more_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
 value="<?php echo $this->_tpl_vars['HOME_STUFF']['Details']['ModuleName']; ?>
"/>
	<table border=0 cellspacing=1 cellpadding=3 width="100%" class="lvt small">
	<tr>	   
		<!--<td width=5%>&nbsp;</td>-->
	<?php $_from = $this->_tpl_vars['HOME_STUFF']['Details']['Header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
		<td class="lvtCol" align="left"><b><?php echo $this->_tpl_vars['header']; ?>
</b></td>
	<?php endforeach; endif; unset($_from); ?>
	</tr>	
	<?php $_from = $this->_tpl_vars['HOME_STUFF']['Details']['Entries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['crmid'] => $this->_tpl_vars['row']):
?>
	<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'">
		<!--
		<td>
		<?php if ($this->_tpl_vars['HOME_STUFF']['Details']['Title']['1'] == 'My Sites'): ?>
			<img src="<?php echo vtiger_imageurl('bookMark.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0" alt="Details" title="Details"/>
		<?php elseif ($this->_tpl_vars['HOME_STUFF']['Details']['Title']['1'] != 'Key Metrics' && $this->_tpl_vars['HOME_STUFF']['Details']['Title']['1'] != 'My Group Allocation'): ?>
			<img src="<?php echo vtiger_imageurl('bookMark.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0" alt="Details" title="Details"/>
		<?php elseif ($this->_tpl_vars['HOME_STUFF']['Details']['Title']['1'] == 'Key Metrics'): ?>
			<img src="<?php echo vtiger_imageurl('bookMark.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0" alt="Details" title="Details"/>
		<?php elseif ($this->_tpl_vars['HOME_STUFF']['Details']['Title']['1'] == 'My Group Allocation'): ?>
			<img src="<?php echo vtiger_imageurl('bookMark.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0" alt="Details" title="Details"/>
		<?php endif; ?>
		</td>
		
		-->
		<?php if ($this->_tpl_vars['HOME_STUFF']['Details']['noofactivities'] != 0): ?>
			<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
			
			<td align="left" nowrap> 

				<?php if ($this->_tpl_vars['element'] == 1000): ?>
					<?php echo $this->_tpl_vars['APP']['ALL_POPULATION']; ?>

				<?php else: ?>
					<?php echo $this->_tpl_vars['element']; ?>

				<?php endif; ?>
				
			</td>
			<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
		<?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['element']):
?>
			<td align="center" colspan="5" style="color:red;"> <?php echo $this->_tpl_vars['element']; ?>
</td>
		<?php endforeach; endif; unset($_from); ?>	
		<?php endif; ?>	
	</tr>
	<?php endforeach; endif; unset($_from); ?>	
	</table>
	
<?php elseif ($this->_tpl_vars['HOME_STUFFTYPE'] == 'RSS'): ?>
	<input type=hidden id=more_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
 value="<?php echo $this->_tpl_vars['HOME_STUFF']['Entries']['More']; ?>
"/>
	<table border=0 cellspacing=0 cellpadding=2 width=100%>
		<?php $_from = $this->_tpl_vars['HOME_STUFF']['Entries']['Details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['details']):
?>
			<tr>
				<td align="left">
					<a href="<?php echo $this->_tpl_vars['details']['1']; ?>
" target="_blank">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['details']['0'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>
...
					</a>
				</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	
<?php elseif ($this->_tpl_vars['HOME_STUFFTYPE'] == 'DashBoard'): ?>
	<input type=hidden id=more_<?php echo $this->_tpl_vars['HOME_STUFFID']; ?>
 value="<?php echo $this->_tpl_vars['DASHDETAILS'][$this->_tpl_vars['HOME_STUFFID']]['DashType']; ?>
"/>
	<table border=0 cellspacing=0 cellpadding=5 width=100%>
		<tr>
			<td align="left"><?php echo $this->_tpl_vars['HOME_STUFF']; ?>
</td>
		</tr>
	</table>		

<?php endif; ?>


<b>
	<?php if ($this->_tpl_vars['TOTAL_RECORD_COUNT_INCIDENT'] != ''): ?>
		<br/><?php echo $this->_tpl_vars['RECORD_COUNT_INCIDENT']; ?>
 &nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SUR']; ?>
 &nbsp; <?php echo $this->_tpl_vars['TOTAL_RECORD_COUNT_INCIDENT']; ?>
<br/>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['TOTAL_RECORD_COUNT_DEMANDE'] != ''): ?>
		<br/><?php echo $this->_tpl_vars['RECORD_COUNT_DEMANDE']; ?>
 &nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SUR']; ?>
 &nbsp; <?php echo $this->_tpl_vars['TOTAL_RECORD_COUNT_DEMANDE']; ?>
<br/>
	<?php endif; ?>				
</b>	
		