<?php /* Smarty version 2.6.18, created on 2009-08-05 19:00:08
         compiled from DetailViewEmailTemplate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'DetailViewEmailTemplate.tpl', 16, false),)), $this); ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
<br>
	<div align=center>
	
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'SetMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
		    		<form method="post" action="index.php" name="etemplatedetailview">  
				<input type="hidden" name="action" value="editemailtemplate">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="templatename" value="<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
">
				<input type="hidden" name="templateid" value="<?php echo $this->_tpl_vars['TEMPLATEID']; ?>
">
				<input type="hidden" name="foldername" value="<?php echo $this->_tpl_vars['FOLDERNAME']; ?>
">
				<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['PARENTTAB']; ?>
">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="<?php echo vtiger_imageurl('ViewTemplate.gif', $this->_tpl_vars['THEME']); ?>
" width="45" height="60" border=0 ></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a> > <a href="index.php?module=Settings&action=listemailtemplates&parenttab=Settings"><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATES']; ?>
</a> &gt; <?php echo $this->_tpl_vars['MOD']['LBL_VIEWING']; ?>
 &quot;<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
&quot; </b></td>
				</tr>
				<tr>
					<td valign=top class="small"><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATE_DESC']; ?>
</td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_PROPERTIES']; ?>
 &quot;<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
&quot; </strong></td>
						<td class="small" align=right>						  &nbsp;&nbsp;
						  <input class="crmButton edit small" type="submit" name="Button" value="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
" onclick="this.form.action.value='editemailtemplate'; this.form.parenttab.value='Settings'">&nbsp;&nbsp;
						</td>
					</tr>
					</table>
					
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
						<td width=20% class="small cellLabel"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_NAME']; ?>
</strong></td>
						<td width=80% class="small cellText"><strong><?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
</strong></td>
					  </tr>
					<tr>
						<td valign=top class="small cellLabel"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_DESCRIPTION']; ?>
</strong></td>
						<td class="cellText small" valign=top>&nbsp;<?php echo $this->_tpl_vars['DESCRIPTION']; ?>
</td>
					  </tr>
					<tr>
						<td valign=top class="small cellLabel"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_FOLDER']; ?>
</strong></td>
						<td class="cellText small" valign=top><?php echo $this->_tpl_vars['FOLDERNAME']; ?>
</td>
					  </tr>
					
					
					<tr>
					  <td colspan="2" valign=top class="cellText small"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="thickBorder">
                        <tr>
                          <td valign=top><table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td colspan="2" valign="top" class="small" style="background-color:#cccccc"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATE']; ?>
</strong></td>
                                </tr>
                              <tr>
                                <td width="15%" valign="top" class="cellLabel small"><?php echo $this->_tpl_vars['UMOD']['LBL_SUBJECT']; ?>
</td>
                                <td width="85%" class="cellText small"><?php echo $this->_tpl_vars['SUBJECT']; ?>
</td>
                              </tr>
                              <tr>
                                <td valign="top" class="cellLabel small"><?php echo $this->_tpl_vars['UMOD']['LBL_MESSAGE']; ?>
</td>
                                <td class="cellText small"><?php echo $this->_tpl_vars['BODY']; ?>
</td>
                              </tr>
                          </table></td>
                          
                        </tr>
                      </table></td>
					  </tr>
					</table>
					<br>
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td class="small" nowrap align=right><a href="#top"><?php echo $this->_tpl_vars['MOD']['LBL_SCROLL']; ?>
</a></td>
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
	</form>
	</table>
		
	</div>

</td>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</tbody>
</table>