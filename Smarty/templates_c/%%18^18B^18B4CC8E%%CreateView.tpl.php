<?php /* Smarty version 2.6.18, created on 2018-10-12 15:52:57
         compiled from CreateView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'CreateView.tpl', 58, false),array('modifier', 'cat', 'CreateView.tpl', 76, false),)), $this); ?>


<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>

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
	<!--<td valign=top>
		<img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
">
	</td>-->

	<td class="showPanelBg" valign=top width=100%>
	     	     <div class="small" style="padding:20px">
		
				<?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['SINGLE_MOD']); ?>
		<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]): ?> <?php $this->assign('SINGLE_MOD_LABEL', $this->_tpl_vars['APP']['SINGLE_MOD']); ?> <?php endif; ?>
				
		 <?php if ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?>   
			 <span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 -  <?php echo $this->_tpl_vars['APP']['LBL_EDITING']; ?>
 <?php echo $this->_tpl_vars['SINGLE_MOD_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span> <br>
			<?php echo $this->_tpl_vars['UPDATEINFO']; ?>
	 
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
								<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false;  if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px" >
										<?php endif; ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
									   </div>
									</td>
								   </tr>

								   <?php $_from = $this->_tpl_vars['BASBLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
								  
								   
									<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_ADDRESS_INFORMATION'] && ( $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Quotes' || $this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Invoice' )): ?>
										<tr>											
																	   <td colspan=2 class="detailedViewHeader">
                                                                        <b><?php echo $this->_tpl_vars['header']; ?>
</b></td>
                                                                        <td class="detailedViewHeader">
                                                                        <input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_RCPY_ADDRESS']; ?>
</b></td>
                                                                        <td class="detailedViewHeader">
                                                                        <input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_LCPY_ADDRESS']; ?>
</b></td>

									<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_ADDRESS_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Contacts'): ?>
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader">
												<input name="cpy" onclick="return copyAddressLeft(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_CPY_OTHER_ADDRESS']; ?>
</b></td>
											<td class="detailedViewHeader">
												<input name="cpy" onclick="return copyAddressRight(EditView)" type="radio"><b><?php echo $this->_tpl_vars['APP']['LBL_CPY_MAILING_ADDRESS']; ?>
</b>
											</td>
									
									<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TIERS_BANQUE1_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Tiers'): ?>
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_TIERS_ADD_COMPTE2']; ?>
"></a>
											</td>
											
									 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TIERS_BANQUE2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Tiers'): ?>
									<tr id="banque2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
									<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque3display()"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_TIERS_ADD_COMPTE3']; ?>
"></a>&nbsp;&nbsp;
												<a href="javascript:;" onClick="banque2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_TIERS_CANCEL_ADD_COMPTE']; ?>
" ></a></td>
									
								   <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TIERS_BANQUE3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Tiers'): ?>
									<tr id="banque3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banque3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_TIERS_CANCEL_ADD_COMPTE']; ?>
"></a></td>
									 </tr>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE2']; ?>
"></a>
											</td>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent3display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE3']; ?>
"></a>
												<a href="javascript:;" onClick="banqueAgent2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_COMPTE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent4display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE4']; ?>
"></a>
												<a href="javascript:;" onClick="banqueAgent3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_COMPTE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent5display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE5']; ?>
"></a>
												<a href="javascript:;" onClick="banqueAgent4cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_COMPTE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="banqueAgent5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="banqueAgent5cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_COMPTE']; ?>
"></a></td>
									 </tr>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_MERE'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesmereheader" >		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddconjoint" style="display:none" onClick="ConjointAgentdisplay();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_CONJOINT']; ?>
"></a>
												<a href="javascript:;" id="linkaddenf1" style="display:none" onClick="EnfantAgent1display();"><img src="<?php echo vtiger_imageurl('addenfant.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT1']; ?>
"></a>
									 </tr>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_CONJOINT'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donnesconjointheader" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="ConjointAgentcancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_CONJOINT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT1'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant1header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf2" onClick="EnfantAgent2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT2']; ?>
"></a>
												<a href="javascript:;" onClick="EnfantAgent1cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf3" onClick="EnfantAgent3display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT3']; ?>
"></a>
												<a href="javascript:;" onClick="EnfantAgent2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf4" onClick="EnfantAgent4display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT4']; ?>
"></a>
												<a href="javascript:;" onClick="EnfantAgent3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf5" onClick="EnfantAgent5display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT5']; ?>
"></a>
												<a href="javascript:;" onClick="EnfantAgent4cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" id="linkaddenf6" onClick="EnfantAgent6display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_ENFANT6']; ?>
"></a>
												<a href="javascript:;" onClick="EnfantAgent5cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT6'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
									<tr id="donneesenfant6header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="EnfantAgent6cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_ENFANT']; ?>
"></a></td>
									 </tr>
									 
									
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_INFORMATION'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'DemandesFournituresService' )): ?>
									<tr>
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_DEMANDE2']; ?>
"></a>
											</td>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'DemandesFournituresService' )): ?>
									<tr id="demande2header" style="display: none;">
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande3display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_DEMANDE3']; ?>
"></a>
												<a href="javascript:;" onClick="demande2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
											</td>
								
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'DemandesFournituresService' )): ?>
									<tr id="demande3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande4display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_DEMANDE3']; ?>
"></a>
												<a href="javascript:;" onClick="demande3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'DemandesFournituresService' )): ?>
									<tr id="demande4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_DEMANDE4']; ?>
"></a>
												<a href="javascript:;" onClick="demande4cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' || $this->_tpl_vars['MODULE'] == 'DemandesFournituresService' )): ?>
									<tr id="demande5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="demande5cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								
								
			
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="lignebudgetheader">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE5']; ?>
"></a>
											</td-->
									</tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_2'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="lignebudget2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget3display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE5']; ?>
"></a>
												<a href="javascript:;" onClick="lignebudget2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_3'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="lignebudget3header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget4display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE5']; ?>
"></a>
												<a href="javascript:;" onClick="lignebudget3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_4'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="lignebudget4header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_COMPTE5']; ?>
"></a>
												<a href="javascript:;" onClick="lignebudget4cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_5'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="lignebudget5header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="lignebudget5cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
	
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_FILE_JUSTIFICATIF_1'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="justif1header">		
									<td colspan=4 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<!--td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="justif2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_JUSTIFS']; ?>
"></a>
											</td-->
									 </tr>
								<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_FILE_JUSTIFICATIF_2'] && ( $this->_tpl_vars['MODULE'] == 'Demandes' )): ?>
									<tr id="justif2header" style="display: none;">		
									<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="justif2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_CANCEL_ADD_DEMANDE']; ?>
"></a></td>
									 </tr>
									 
									 <?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET1_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet1header">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet2display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet2header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right >
												<a href="javascript:;" onClick="trajet3display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
												<a href="javascript:;" onClick="trajet2cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet3header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet4display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
												<a href="javascript:;" onClick="trajet3cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET4_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet4header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet5display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
												<a href="javascript:;" onClick="trajet4cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET5_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet5header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet6display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
												<a href="javascript:;" onClick="trajet5cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET6_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet6header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet7display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_TRAJET']; ?>
"></a>
												<a href="javascript:;" onClick="trajet6cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET7_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet7header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8display();"><img src="<?php echo vtiger_imageurl('reportsCreate.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_AGENTS_ADD_DEMANDE2']; ?>
"></a>
												<a href="javascript:;" onClick="trajet7cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
							<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET8_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
									<tr id="trajet8header" style="display: none;">		
											<td colspan=2 class="detailedViewHeader">
												<b><?php echo $this->_tpl_vars['header']; ?>
</b>
											</td>
										
											<td class="detailedViewHeader" colspan=2 align=right>
												<a href="javascript:;" onClick="trajet8cancel()"><img src="<?php echo vtiger_imageurl('reportsDelete.gif', $this->_tpl_vars['THEME']); ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_ANCEL_ADD_TRAJET']; ?>
"></a></td>
											</td>
										
									<?php else: ?>
										<tr>
						         		<td colspan=4 class="detailedViewHeader">
                                                	        		<b><?php echo $this->_tpl_vars['header']; ?>
</b>
							 		</td>
		                            </tr>
									  <?php endif; ?>
								   <!-- Here we should include the uitype handlings-->
								   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>							
								   <tr style="height:10px"><td>&nbsp;</td></tr>
								 
								   <?php endforeach; endif; unset($_from); ?>
									<!--tr><td><div><font color="red">(f) : champs facultatifs</font></div></td></tr-->
								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
                                			<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
                                			<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
                                		<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>	
                                                                                       <input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save'; if(!isFieldsFormValide(this.form)) return false; if(!isDateTimeCorrect(this.form.heuredebut_relle, this.form.time_start, '')) return false; return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:95px" >
										<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
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
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate();" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  "  >
										<?php endif; ?>
                                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

							 	   <tr style="height:25px"><td>&nbsp;</td></tr>
								   <?php endforeach; endif; unset($_from); ?>

								   <tr>
									<td  colspan=4 style="padding:5px">
									   <div align="center">
										<?php if ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
                                			<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="window.open('index.php?module=Users&action=lookupemailtemplates&entityid=<?php echo $this->_tpl_vars['ENTITY_ID']; ?>
&entity=<?php echo $this->_tpl_vars['ENTITY_TYPE']; ?>
','emailtemplate','top=100,left=200,height=400,width=300,menubar=no,addressbar=no,status=yes')" type="button"  " name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECTEMAILTEMPLATE_BUTTON_LABEL']; ?>
">
                                			<input title="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" accessKey="<?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';this.form.send_mail.value='true'; return formValidate()" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['MOD']['LBL_SEND']; ?>
  " >
                                		<?php endif; ?>
										<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  if(formValidate())AjaxDuplicateValidate('Accounts','accountname',this.form);" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php else: ?>
											<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';  return formValidate()" type="submit" " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >
										<?php endif; ?>
										<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button"  " name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
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
       
						<?php if ($this->_tpl_vars['MODULE'] == 'Incidents'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
		<?php if ($this->_tpl_vars['MODULE'] == 'Conventions'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
       <?php endif; ?>
	<?php if ($this->_tpl_vars['MODULE'] == 'ExecutionConventions'): ?>
               oFCKeditor = new FCKeditor( "description" ) ;
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