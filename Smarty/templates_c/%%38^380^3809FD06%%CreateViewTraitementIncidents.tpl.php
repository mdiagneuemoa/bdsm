<?php /* Smarty version 2.6.18, created on 2011-02-28 16:44:29
         compiled from CreateViewTraitementIncidents.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'CreateViewTraitementIncidents.tpl', 53, false),)), $this); ?>


<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-<?php echo $this->_tpl_vars['CALENDAR_LANG']; ?>
.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>

<script type="text/javascript">
var gVTModule = '<?php echo $_REQUEST['module']; ?>
';
function sensex_info()
{
        var Ticker = $('tickersymbol').value;
        if(Ticker!='')
        {
                $("vtbusy_info").style.display="inline";
                new Ajax.Request(
                      'index.php',
                      {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Tickerdetail&tickersymbol='+Ticker,
                                onComplete: function(response) {
                                        $('autocom').innerHTML = response.responseText;
                                        $('autocom').style.display="block";
                                        $("vtbusy_info").style.display="none";
                                }
                        }
                );
        }
}
</script>

				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top>
		<img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
">
	</td>

	<td class="showPanelBg" valign=top width=100%>
	     	     <div class="small" style="padding:20px">
		
		

		 <hr noshade size=1>
		
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['RESERVER'] == 'true'): ?>
			<input type="hidden" name="reserver" value="<?php echo $this->_tpl_vars['RESERVER']; ?>
">
		<?php endif; ?>
				<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		   <tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				   <tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>

					
						<td class="dvtSelectedCell" align=center nowrap>TRAITEMENT</td>
	                    <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					
				   <tr>
				</table>
			</td>
		   </tr>
		   <tr>
			<td valign=top align=left >

			    <!-- Basic Information Tab Opened -->
			    <div id="basicTab">

				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<td align=left>
					<!-- content cache -->
					
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						   <tr>
							<td id ="autocom"></td>
						   </tr>
						   <tr>
							<td style="padding:10px">
							<!-- General details -->
								<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFormTraitementValide(this.form)) return false; return formValidate();" type="submit"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:75px" >
                                            <?php if ($this->_tpl_vars['STATUT'] != 'closed'): ?>
												<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_TITLE_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; this.form.mode.value='traited&transfered'; if(!isFormTraitementValide(this.form)) return false; return formValidate()" type="submit"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_LABEL']; ?>
  " style="width:150px" >
											<?php endif; ?>
										    <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" readonly="true" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   <?php $_from = $this->_tpl_vars['BASBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
								   <tr>
									<td colspan=4 class="detailedViewHeader">
										<?php if ($this->_tpl_vars['STATUT'] == 'closed'): ?>
											<?php if ($this->_tpl_vars['header'] == 'TRAITEMENT INCIDENT'): ?>
												<b><?php echo $this->_tpl_vars['MOD']['LBL_BLOCK_CLOTURE_INCIDENT']; ?>
</b>
											<?php elseif ($this->_tpl_vars['header'] == 'DESCRIPTION'): ?>
												<b><?php echo $this->_tpl_vars['MOD']['LBL_BLOCK_COMMENTAIRE']; ?>
</b>
											<?php endif; ?>	
										<?php else: ?>
											<b><?php echo $this->_tpl_vars['header']; ?>
</b></td>
										<?php endif; ?>
									
                                            		                            </tr>

								   <!-- Here we should include the uitype handlings-->
								   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayTraitementIncidentsFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>							
								  <!-- <tr style="height:25px"><td>&nbsp;</td></tr> -->
								   <?php endforeach; endif; unset($_from); ?>
									<tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr>
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFormTraitementValide(this.form)) return false; return formValidate(); " type="submit"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:75px" >
                                            <?php if ($this->_tpl_vars['STATUT'] != 'closed'): ?>
												<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_TITLE_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; this.form.mode.value='traited&transfered'; if(!isFormTraitementValide(this.form)) return false; return formValidate()" type="submit"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_TRANSFERT_BUTTON_LABEL']; ?>
  " style="width:150px" >
											<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>
								</table>
							</td>
						   </tr>
						</table>
					</td>
				   </tr>
				</table>
					
			    </div>
			    <!-- Basic Information Tab Closed -->

			    <!-- More Information Tab Opened -->
			    <div id="moreTab">
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
				   <tr>
					<td align=left>
										
						<table border=0 cellspacing=0 cellpadding=0 width=100%>
						   <tr>
							<td id ="autocom"></td>
						   </tr>
						   <tr>
							<td style="padding:10px">
							<!-- General details -->
								<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate();" type="submit"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   <?php $_from = $this->_tpl_vars['ADVBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
								   <tr>
						         		<td colspan=4 class="detailedViewHeader">
                    	        			<b><?php echo $this->_tpl_vars['header']; ?>
</b>
                             			</td>
                             	   </tr>

								   <!-- Here we should include the uitype handlings-->
                                   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayTraitementIncidentsFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									
							 	   <tr style="height:25px"><td>&nbsp;</td></tr>
								   <?php endforeach; endif; unset($_from); ?>

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<input 
											title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" 
											accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" 
											class="crmbutton small save" 
											onclick="this.form.action.value='Save';  return formValidate();" 
											type="submit"  
											name="button" 
											value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " 
											style="width:70px" >
										
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>
								</table>
							</td>
						   </tr>
						</table>
					</td>
				   </tr>
				</table>
			    </div>

			</td>
		   </tr>
		</table>
	     </div>
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
</form>

<?php if (( $this->_tpl_vars['MODULE'] == 'Emails' || 'Documents' || 'HReports' ) && ( $this->_tpl_vars['FCKEDITOR_DISPLAY'] == 'true' )): ?>
       <script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">

       var oFCKeditor = null;

       <?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
               oFCKeditor = new FCKeditor( "notecontent" ) ;
       <?php endif; ?>
	   <?php if ($this->_tpl_vars['MODULE'] == 'HReports'): ?>
               oFCKeditor = new FCKeditor( "hreportcontent" ) ;
       <?php endif; ?>
		<?php if ($this->_tpl_vars['MODULE'] == 'TraitementIncidents'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
       oFCKeditor.BasePath   = "include/fckeditor/" ;
       oFCKeditor.ReplaceTextarea() ;

       </script>
<?php endif; ?>
<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
<?php endif; ?>
<script>
        var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
)
        var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
)
        var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
)
</script>

<!-- vtlib customization: Help information assocaited with the fields -->
<?php if ($this->_tpl_vars['FIELDHELPINFO']): ?>
<script type='text/javascript'>
<?php echo 'var fieldhelpinfo = {}; '; ?>

<?php $_from = $this->_tpl_vars['FIELDHELPINFO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FIELDHELPKEY'] => $this->_tpl_vars['FIELDHELPVAL']):
?>
	fieldhelpinfo["<?php echo $this->_tpl_vars['FIELDHELPKEY']; ?>
"] = "<?php echo $this->_tpl_vars['FIELDHELPVAL']; ?>
";
<?php endforeach; endif; unset($_from); ?>
</script>
<?php endif; ?>
<!-- END -->