<?php /* Smarty version 2.6.18, created on 2018-03-23 10:59:36
         compiled from Buttons_List_UsersNomade.tpl */ ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
<tr><td style="height:2px"></td></tr>
<tr>
	<?php $this->assign('action', 'ListView'); ?>
	<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
	<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]): ?>
		<?php $this->assign('MODULELABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]); ?>
	<?php endif; ?>	
	
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['CATEGORY']]; ?>
 > <a class="hdrLink" href="index.php?action=<?php echo $this->_tpl_vars['action']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</a></td>
	
	<td width=100% nowrap>
	
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="sep1" style="width:1px;"></td>
		<td class=small >
			<!-- Add and Search -->
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
						<?php if ($this->_tpl_vars['CURRENT_USER_PROFIL'] == '20' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '26' || $this->_tpl_vars['CURRENT_USER_PROFIL'] == '27'): ?>
							<td style="padding-right:0px;padding-left:10px;"><a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=EditView&return_action=DetailView&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Add.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_CREATE_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_CREATE_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
..." border=0></a></td>				
						<?php endif; ?>
							<td style="padding-right:10px"><a href="javascript:;" onClick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch');mergehide('mergeDup')" ><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Search.gif" alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_ALT']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." title="<?php echo $this->_tpl_vars['APP']['LBL_SEARCH_TITLE']; ?>
<?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]; ?>
..." border=0></a></a></td>
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
					
		</tr>
		</table>
	</td>
</tr>
<tr><td style="height:2px"></td></tr>
</TABLE>