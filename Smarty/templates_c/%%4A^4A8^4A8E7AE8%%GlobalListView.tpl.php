<?php /* Smarty version 2.6.18, created on 2009-03-30 12:35:32
         compiled from GlobalListView.tpl */ ?>

<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
<?php echo $this->_tpl_vars['IMAGELISTS']; ?>

<script language="JavaScript" type="text/javascript" src="include/js/thumbnail.js"></script>
<div id="dynloadarea" style=float:left;position:absolute;left:350px;top:150px;></div>
<?php endif; ?>


<?php if ($this->_tpl_vars['MODULE'] == $this->_tpl_vars['SEARCH_MODULE'] && $this->_tpl_vars['SEARCH_MODULE'] != ''): ?>
	<div id="global_list_<?php echo $this->_tpl_vars['SEARCH_MODULE']; ?>
" style="display:block">
<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts' && $this->_tpl_vars['SEARCH_MODULE'] == ''): ?>
	<div id="global_list_<?php echo $this->_tpl_vars['MODULE']; ?>
" style="display:block">
<?php elseif ($this->_tpl_vars['SEARCH_MODULE'] != ''): ?>
	<div id="global_list_<?php echo $this->_tpl_vars['MODULE']; ?>
" style="display:none">
<?php else: ?>
	<div id="global_list_<?php echo $this->_tpl_vars['MODULE']; ?>
" style="display:block">
<?php endif; ?>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
     <form name="massdelete" method="POST">
     <input name="idlist" type="hidden">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <tr>
		<td>
	   <!-- PUBLIC CONTENTS STARTS-->
	   <br>
	   <div class="small" style="padding:2px">
        	<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
	           <tr >
			<td>
				<table border=0 cellspacing=0 cellpadding=2 width=100% class="small">
				   <tr>
					<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULE']); ?>
					<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']] != ''): ?>
						<?php $this->assign('MODULELABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE']]); ?>
					<?php endif; ?>
					<td style="padding-right:20px" nowrap ><b class=big><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</b><?php echo $this->_tpl_vars['SEARCH_CRITERIA']; ?>
</td>
					<!-- Not used, may be used in future when we do the pagination and customeviews
						<td style="padding-right:20px" class="small" nowrap><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
</td>
						<td nowrap >
							<table border=0 cellspacing=0 cellpadding=0 class="small">
							   <tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
							</table>
                                 		</td>
					 	<td width=100% align="right">
					   		<table border=0 cellspacing=0 cellpadding=0 class="small">
								<tr><?php echo $this->_tpl_vars['CUSTOMVIEW']; ?>
</tr>
					   		</table>
					 	</td>	
					-->
				   </tr>
				</table>
                 <div  class="searchResults">
			 	<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				   <tr>
					<?php if ($this->_tpl_vars['DISPLAYHEADER'] == 1): ?>
						<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header']):
?>
							<td class="mailSubHeader"><?php echo $this->_tpl_vars['header']; ?>
</td>
			         		<?php endforeach; endif; unset($_from); ?>
					<?php else: ?>
						<td class="searchResultsRow" colspan=$HEADERCOUNT> <?php echo $this->_tpl_vars['APP']['LBL_NO_DATA']; ?>
 </td>
					<?php endif; ?>
				   </tr>
				   <?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
				   <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'"  >
					<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>	
						<td><?php echo $this->_tpl_vars['data']; ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
				   </tr>
				   <?php endforeach; endif; unset($_from); ?>
				</table>
			 	</div>

				<!-- not used, may be used in future for navigation
			 		<table border=0 cellspacing=0 cellpadding=2 width=100%>
					   <tr>
					 	<td style="padding-right:20px" class="small" nowrap><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
</td>
						<td nowrap >
							<table border=0 cellspacing=0 cellpadding=0 class="small">
							   <tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
							</table>
						</td>
					   </tr>
					</table>
				-->
			</td>
		   </tr>
		</table>
	   </div>
	   
	</td>
	</form>	
   </tr>
</table>

</div>
<?php if ($this->_tpl_vars['SEARCH_MODULE'] == 'All'): ?>
<script>
displayModuleList(document.getElementById('global_search_module'));
</script>
<?php endif; ?>

<?php echo $this->_tpl_vars['SELECT_SCRIPT']; ?>

