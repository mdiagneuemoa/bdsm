<?php /* Smarty version 2.6.18, created on 2010-04-19 19:01:20
         compiled from EditViewUsersGID.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'EditViewUsersGID.tpl', 53, false),array('modifier', 'cat', 'EditViewUsersGID.tpl', 73, false),)), $this); ?>


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


<br/><br/>

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>
	<td valign=top>
		<img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
">
	</td>

	<td class="showPanelBg" valign=top width=100%>
	     	     <div class="small" style="padding:20px">
		
				<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
		<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
				
		 <?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>   
			 <span class="lvtHeaderText"><?php echo $this->_tpl_vars['MOD']['LBL_MODIFICATION_PROFIL']; ?>
</span> <br>
			<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
		<?php else: ?>
			 <span class="lvtHeaderText"><?php echo $this->_tpl_vars['MOD']['LBL_DESACTIVATION_USER']; ?>
</span> <br>
		 <?php endif; ?>

		 <?php if ($this->_tpl_vars['OP_MODE'] == 'create_view'): ?>
			<?php if ($this->_tpl_vars['DUPLICATE'] != 'true'): ?>
			<?php $this->assign('create_new', ((is_array($_tmp='LBL_CREATING_NEW_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['SINGLE_MOD']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['SINGLE_MOD']))); ?>
								<?php $this->assign('create_newlabel', $this->_tpl_vars['APP'][$this->_tpl_vars['create_new']]); ?>
				<?php if ($this->_tpl_vars['create_newlabel'] != ''): ?>
					<span class="lvtHeaderText"><?php echo $this->_tpl_vars['create_newlabel']; ?>
</span> <br>
				<?php else: ?>
					<!--<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_CREATING']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_NEW']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
</span> <br>-->
					<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_NEW']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
</span> <br>
				<?php endif; ?>
		        
			<?php else: ?>
			<span class="lvtHeaderText"><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATING']; ?>
 "<?php echo $this->_tpl_vars['NAME']; ?>
" </span> <br>
			<?php endif; ?>
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

					<?php if ($this->_tpl_vars['ADVBLOCKS'] != ''): ?>	
						<td width=75 style="width:15%" align="center" nowrap class="dvtSelectedCell" id="bi" onclick="fnLoadValues('bi','mi','basicTab','moreTab','normal','<?php echo $this->_tpl_vars['MODULE']; ?>
')"><b><?php echo $this->_tpl_vars['APP']['LBL_BASIC']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</b></td>
                    	<td class="dvtUnSelectedCell" style="width: 100px;" align="center" nowrap id="mi" onclick="fnLoadValues('mi','bi','moreTab','basicTab','normal','<?php echo $this->_tpl_vars['MODULE']; ?>
')"><b><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
 </b></td>
                   		<td class="dvtTabCache" style="width:65%" nowrap>&nbsp;</td>
					<?php else: ?>
						<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP']['LBL_BASIC']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>
	                    <td class="dvtTabCache" style="width:65%">&nbsp;</td>
					<?php endif; ?>
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
								<table border=0 cellspacing=0 cellpadding=5 width="100%" class="small">

									<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
									<input type="hidden" id="mode" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
									<input type="hidden" id="profilId" name="profilId" value="<?php echo $this->_tpl_vars['IDPROFILE']; ?>
">
									
									<tr class="small">
									    <td width="15%" class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['Matricule']; ?>
</strong></td>
									    <td width="85%" class="cellText" ><?php echo $this->_tpl_vars['MATRICULE']; ?>
</td>
									</tr>
									<tr class="small">
									    <td width="15%" class="small cellLabel" ><strong><?php echo $this->_tpl_vars['MOD']['Lastname']; ?>
</strong></td>
									    <td width="85%" class="cellText" ><?php echo $this->_tpl_vars['NOM']; ?>
</td>
									</tr>
									<tr class="small">
									    <td class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['Firstname']; ?>
</strong></td>
									    <td class="cellText"><?php echo $this->_tpl_vars['PRENOM']; ?>
 </td>
									</tr>
						
									<?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>			
									<tr class="small">
									    <td class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['Profil']; ?>
</strong></td>
									    <td class="cellText">
									    <?php echo $this->_tpl_vars['PROFILESLIST']; ?>

									    </td>
									</tr>
									<?php else: ?>
									    <td class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['Profil']; ?>
</strong></td>
									    <td class="cellText"> <?php echo $this->_tpl_vars['PROFILENAME']; ?>
</td>
									<?php endif; ?>
									
									<?php if ($this->_tpl_vars['MODE'] == 'delete' || $this->_tpl_vars['MODE'] == 'enable'): ?>
									<tr class="small">
										<td class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['Raison']; ?>
</strong></td>
										<td class="cellText"><textarea name="raison" class="detailedViewTextBox" rows=2 cols=30> </textarea></td>
									</tr>
									<?php endif; ?>
	
									<tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr>
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
 										<?php if ($this->_tpl_vars['MODE'] == 'edit'): ?>			
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" class="crmbutton small save" onclick="getProfileSelected(<?php echo $this->_tpl_vars['ID']; ?>
); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_MODIFIER_BUTTON_LABEL']; ?>
" style="width:70px">
                                        <?php elseif ($this->_tpl_vars['MODE'] == 'enable'): ?>
                                        	<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" class="crmbutton small save" onclick="getProfileSelected(<?php echo $this->_tpl_vars['ID']; ?>
); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ACTIVER_BUTTON_LABEL']; ?>
" style="width:70px">
                                         <?php else: ?>
                                        	<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" class="crmbutton small save" onclick="getProfileSelected(<?php echo $this->_tpl_vars['ID']; ?>
); this.form.action.value='Save';  return formValidate()" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_DESACTIVER_BUTTON_LABEL']; ?>
" style="width:70px">
                                        <?php endif; ?>
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
			    <!-- Basic Information Tab Closed -->

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

<script type='text/javascript'>
function getProfileSelected(userId) 
{
	var element = document.getElementById('profil'+userId);
	if(element != null) 
	{
		var profil = element.value;
		var mode = document.getElementById('mode').value;
		if(mode == 'edit') 
		{
			document.getElementById('profilId').value = profil;
		}
	}
}
</script>