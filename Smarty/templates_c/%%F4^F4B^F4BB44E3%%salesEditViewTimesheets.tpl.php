<?php /* Smarty version 2.6.18, created on 2009-09-03 17:21:52
         compiled from salesEditViewTimesheets.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'salesEditViewTimesheets.tpl', 59, false),)), $this); ?>


<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-<?php echo $this->_tpl_vars['CALENDAR_LANG']; ?>
.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="include/js/timesheets.js"></script>
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
function AddressSync(Addform,id)
{
        if(formValidate() == true)
        {  
	      checkAddress(Addform,id);
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
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

	<td class="showPanelBg" valign=top width=100%>
				<div class="small" style="padding:20px">
						<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
			<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
				
			<?php if ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?>  				
				<span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 - <?php echo $this->_tpl_vars['APP']['LBL_EDITING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span> <br>
				<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
			<?php endif; ?>
			<?php if ($this->_tpl_vars['OP_MODE'] == 'create_view'): ?>
				<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_CREATING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
</span> <br>
			<?php endif; ?>

			<hr noshade size=1>
			<br> 
		
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

						<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			   <tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
					   <tr>
						<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
						<td class="dvtTabCache" style="width:10px">&nbsp;</td>
						<td class="dvtTabCache" style="width:100%">&nbsp;</td>
					   </tr>
					</table>
				</td>
			   </tr>
			   <tr>
				<td valign=top align=left >
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
" class="crmButton small save" onclick="this.form.action.value='Save'; return formValidateTimesheet(); " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
												<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>

									   <!-- included to handle the edit fields based on ui types -->
									   <?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
											<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_INTERVENTION_INFORMATION']): ?>
												   <tr>
												   <td  colspan=4>
												   
												   <table id='interv' class='closeinterv' cellspacing=0 cellpadding=0 width="100%">
												    <tr>
														<td colspan=4 class="detailedViewHeader">
				                                            <b><?php echo $this->_tpl_vars['header']; ?>
</b>
											 		</td>
						                            </tr>

												   <!-- Here we should include the uitype handlings-->
												  
												   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
												   
												   <tr>
													<td  colspan=4 style="padding:5px">
													   <div align="center">
														<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
"  onclick="if(formValidateIntervention()) addToListIntervs(this.form);" type="button" name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SAVE_INTERVENTION']; ?>
  " style="width:200px" >
														<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
"  onclick="document.getElementById('interv').style.display='none';" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
													   </div>
													</td>
												   </tr>
												   </table>
												   </td>
												   </tr>
											<?php else: ?>
												<tr>
													<td colspan=4 class="detailedViewHeader">
														<b><?php echo $this->_tpl_vars['header']; ?>
</b>
													</td>
												</tr>

												<!-- Here we should include the uitype handlings-->
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
								   		   <?php endif; ?>
								   
									   <?php endforeach; endif; unset($_from); ?>

									   <tr>
									   <td colspan=4>
											<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
												<tr>
													<td class="detailedViewHeader">
														<b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTIONS']; ?>
</b>
													</td>
													<td class="detailedViewHeader" align=right>	
														
														<input title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_INTERVENTION']; ?>
" onclick="addIntervForm(this.form);" type="button" name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_ADD_INTERVENTION']; ?>
  " style="width:200px" >
													</td>
												</tr>
												<tr>
													<td colspan=2>
													
														<table id='tabIntervs' border=1 align=center cellspacing=1 cellpadding=1 width=100%>
															<tr  class="lvt small">
																<td width='10'><img src="<?php echo vtiger_imageurl('select.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_INTERVENTION']; ?>
" LANGUAGE=javascript onclick="document.getElementById('interv').style.display='block';" align="absmiddle" style='cursor:hand;cursor:pointer'>
				</td>

																<td align='center'><b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTION_DATE']; ?>
</b></td>
																<td align='center'><b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTION_ACCOUNT']; ?>
</b></td>
																<td align='center'><b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTION_POTENTIAL']; ?>
</b></td>
																<td align='center'><b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTION_TASK']; ?>
</b></td>
																<td align='center' width="100"><b><?php echo $this->_tpl_vars['MOD']['LBL_INTERVENTION_DURATION']; ?>
</b></td>
															</tr>
														
															 <?php $_from = $this->_tpl_vars['LISTINTERVENTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['interv']):
?>
																<tbody class="lvt small" id="tr_<?php echo $this->_tpl_vars['interv']['tshtintervid']; ?>
">
																	<tr class="lvt small">
																	<td width='10' align="center">
																	<img src="<?php echo vtiger_imageurl('remove.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_INTERVENTION']; ?>
" LANGUAGE=javascript onclick="delToListIntervs('<?php echo $this->_tpl_vars['interv']['tshtintervid']; ?>
','<?php echo $this->_tpl_vars['interv']['duration_interv']; ?>
','edit');" align="absmiddle" style='cursor:hand;cursor:pointer'>
																	<td align='center'><?php echo $this->_tpl_vars['interv']['date_interv']; ?>
</td>
																	<td align='center'><?php echo $this->_tpl_vars['interv']['accountname']; ?>
</td>
																	<td align='center'><?php echo $this->_tpl_vars['interv']['potentialname']; ?>
</td>
																	<td align='center'><?php echo $this->_tpl_vars['interv']['intervtask']; ?>
</td>
																	<td align='center' width="100" id="duration_<?php echo $this->_tpl_vars['interv']['tshtintervid']; ?>
"><?php echo $this->_tpl_vars['interv']['duration_interv']; ?>
</td>
																	</tr>
																</tbody>																
															<?php endforeach; endif; unset($_from); ?>	
															</table>
															<table border=1 align=center cellspacing=1 cellpadding=1 width=100%>
															<input type=hidden name=dureeTotale value=<?php echo $this->_tpl_vars['DURATIONHOURS']; ?>
>
															<tr class="lvt small">
																<td colspan='5' align=right><b><?php echo $this->_tpl_vars['MOD']['LBL_TIMESHEET_TOTAL_DURATION']; ?>
</b></td>
																<td align='center' width="100" id='dureeT'><b><?php echo $this->_tpl_vars['DURATIONHOURS']; ?>
</b></td>
															</tr>
														</table>
													</td>
												</tr>
										</table>
										</td>
                                    </tr>

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">
										           	<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save" onclick="this.form.action.value='Save'; return formValidateTimesheet(); " type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
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
				</td>
			   </tr>
			</table>
		<div>
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
<!--added to fix 4600-->
<input name='search_url' id="search_url" type='hidden' value='<?php echo $this->_tpl_vars['SEARCH']; ?>
'>
</form>


<?php if (( $this->_tpl_vars['MODULE'] == 'Emails' || 'Documents' ) && ( $this->_tpl_vars['FCKEDITOR_DISPLAY'] == 'true' )): ?>
	<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
	<script type="text/javascript" defer="1">
		var oFCKeditor = null;
		<?php if ($this->_tpl_vars['MODULE'] == 'Documents'): ?>
			oFCKeditor = new FCKeditor( "notecontent" ) ;
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

	var ProductImages=new Array();
	var count=0;

	function delRowEmt(imagename)
	{
		ProductImages[count++]=imagename;
	}

	function displaydeleted()
	{
		var imagelists='';
		for(var x = 0; x < ProductImages.length; x++)
		{
			imagelists+=ProductImages[x]+'###';
		}

		if(imagelists != '')
			document.EditView.imagelist.value=imagelists
	}

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