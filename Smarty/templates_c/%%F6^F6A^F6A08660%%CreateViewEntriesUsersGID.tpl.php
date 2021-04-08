<?php /* Smarty version 2.6.18, created on 2011-02-24 17:42:47
         compiled from CreateViewEntriesUsersGID.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'CreateViewEntriesUsersGID.tpl', 118, false),)), $this); ?>

<?php if ($_REQUEST['ajax'] != ''): ?>
&#&#&#<?php echo $this->_tpl_vars['ERROR']; ?>
&#&#&#
<?php endif; ?>

<form name="massdelete" method="POST" id="massdelete">
     <input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH_URL']; ?>
'>
     <input name="idlist" id="idlist" type="hidden">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <input name="action" type="hidden">
     
    <input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
	<input type="hidden" name="mode" value="add">
     
     <input name="where_export" type="hidden" value="<?php  echo to_html($_SESSION['export_where']); ?>">
     <input name="step" type="hidden">
     <input name="allids" type="hidden" id="allids" value="<?php echo $this->_tpl_vars['ALLIDS']; ?>
">
     <input name="selectedboxes" id="selectedboxes" type="hidden" value="<?php echo $this->_tpl_vars['SELECTEDIDS']; ?>
">
     <input name="allselectedboxes" id="allselectedboxes" type="hidden" value="<?php echo $this->_tpl_vars['ALLSELECTEDIDS']; ?>
">
     <input name="allProfileSelectedBoxes" id="allProfileSelectedBoxes" type="hidden" value="<?php echo $this->_tpl_vars['ALLPROFILESELECTEDIDS']; ?>
">
     <input name="current_page_boxes" id="current_page_boxes" type="hidden" value="<?php echo $this->_tpl_vars['CURRENT_PAGE_BOXES']; ?>
">

				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
				<tr>
				<td>

		        <table border=0 cellspacing=0 cellpadding=2 width=100% class="small">
			    <tr>

				<td style="padding-right:20px" class="small" nowrap><span class="lvtHeaderText"><?php echo $this->_tpl_vars['MOD']['LBL_CREATION_USERS']; ?>
</span></td>
				<td style="padding-right:20px" class="small" nowrap><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
</td>

		        <td nowrap >
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					     <tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
					</table>
                </td>
				<td width=100% align="right">

				   
				   <?php if ($this->_tpl_vars['HIDE_CUSTOM_LINKS'] != '1'): ?>
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					<tr>
						<td><?php echo $this->_tpl_vars['APP']['LBL_VIEW']; ?>
</td>
						<td style="padding-left:5px;padding-right:5px">
                            <SELECT NAME="viewname" disabled id="viewname" class="small" onchange="showDefaultCustomView(this,'<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
')"><?php echo $this->_tpl_vars['CUSTOMVIEW_OPTION']; ?>
</SELECT></td>

					</tr>
					</table> 

				   <?php endif; ?>

				</td>	
       		    </tr>
			</table>
			<div>
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">

			<tr>
           
		   <td class="lvtCol"><input type="checkbox"  name="selectall" onClick=toggleSelect_ListView(this.checked,"selected_id")></td>
			
			<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
 			<td class="lvtCol"><?php echo $this->_tpl_vars['header']; ?>
</td>
				<?php endforeach; endif; unset($_from); ?>
			</tr>

			<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
			<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
			
			<td width="2%"><input type="checkbox" NAME="selected_id" id="<?php echo $this->_tpl_vars['entity_id']; ?>
" value= '<?php echo $this->_tpl_vars['entity_id']; ?>
' onClick="check_object(this)"></td>
		
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
			 
			 <table border=0 cellspacing=0 cellpadding=2 width=100%>

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
		       </td>
		   </tr>
	    </table>

			 <table border=0 cellspacing=0 cellpadding=2 width=100%>
			      <tr>
					 <td style="padding-right:20px" nowrap align=center>
				      	<input class="crmbutton small save" type="submit" value="<?php echo $this->_tpl_vars['MOD']['LBL_AJOUTER_UTILISATEURS']; ?>
"  onclick="this.form.action.value='Save';return getUserChecked();"/>
				     </td>
				  </tr>
			</table>

			<br/>
		
   </form>	
<?php echo $this->_tpl_vars['SELECT_SCRIPT']; ?>

<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>
</select></div>