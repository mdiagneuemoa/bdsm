<?php /* Smarty version 2.6.18, created on 2019-01-30 08:56:02
         compiled from Engagement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Engagement.tpl', 96, false),array('modifier', 'number_format', 'Engagement.tpl', 178, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/PriceBooks/PriceBooks.js"></script>
<?php echo '
<script>
function editProductListPrice(id,pbid,price)
{
        $("status").style.display="inline";
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'action=ProductsAjax&file=EditListPrice&return_action=CallRelatedList&return_module=PriceBooks&module=Products&record=\'+id+\'&pricebook_id=\'+pbid+\'&listprice=\'+price,
                        onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("editlistprice").innerHTML= response.responseText;
                        }
                }
        );
}

function gotoUpdateListPrice(id,pbid,proid)
{
        $("status").style.display="inline";
        $("roleLay").style.display = "none";
        var listprice=$("list_price").value;
                new Ajax.Request(
                        \'index.php\',
                        {queue: {position: \'end\', scope: \'command\'},
                                method: \'post\',
                                postBody: \'module=Products&action=ProductsAjax&file=UpdateListPrice&ajax=true&return_action=CallRelatedList&return_module=PriceBooks&record=\'+id+\'&pricebook_id=\'+pbid+\'&product_id=\'+proid+\'&list_price=\'+listprice,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                );
}
'; ?>


function loadCvList(type,id)
{
        if($("lead_cv_list").value != 'None' || $("cont_cv_list").value != 'None')
        {
		$("status").style.display="inline";
        	if(type === 'Leads')
        	{
                        new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("lead_cv_list").value,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                	);
        	}

        	if(type === 'Contacts')
        	{
                        new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'module=Campaigns&action=CampaignsAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+$("cont_cv_list").value,
                                onComplete: function(response) {
                                        $("status").style.display="none";
                                        $("RLContents").innerHTML= response.responseText;
                                }
                        }
                	);
		}
        }
}
</script>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Contents -->
<form name="manageengagement" id="manageengagement">

<div id="editlistprice" style="position:absolute;width:300px;"></div>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:20px">
 	        	
			 <span class="lvtHeaderText"><font color="purple">[ <?php echo $this->_tpl_vars['MOD_SEQ_ID']; ?>
 ] </font><?php echo $this->_tpl_vars['NAME']; ?>
 -  <?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
 <?php echo $this->_tpl_vars['MOD']['LBL_ENGAGEMENT_BUTTON_LABEL']; ?>
</span> <br>
			 <?php echo $this->_tpl_vars['UPDATEINFO']; ?>

			 <hr noshade size=1>
			 <br> 
		
			<!-- Account details tabs -->
			<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
			<tr>
				<td>
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						<tr>
							<?php if ($this->_tpl_vars['OP_MODE'] == 'edit_view'): ?>
		                                                <?php $this->assign('action', 'EditView'); ?>
                		                        <?php else: ?>
                                		                <?php $this->assign('action', 'DetailView'); ?>
		                                        <?php endif; ?>
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
							<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=<?php echo $this->_tpl_vars['action']; ?>
&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a></td>
                                		       	<td class="dvtTabCache" style="width:10px">&nbsp;</td>
							<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['MOD']['LBL_ENGAGEMENT_BUTTON_LABEL']; ?>
</td>
							<td class="dvtTabCache" style="width:100%">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign=top align=center >
		                	
						<div id="createengagementdepenses">
						
							<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
								<tr>
									<td class="detailedViewHeader" align="right">&nbsp;
										<!--b><?php echo $this->_tpl_vars['MOD']['LBL_REUNION_DEPENSES']; ?>
</b-->
										<input 
										title="<?php echo $this->_tpl_vars['MOD']['LBL_GERER_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL']; ?>
" 
										class="crmbutton small edit" 
										onclick="return gererdepenses();"
										type="button" 
										name="Edit" 
										value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_GERER_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
										
									</td>
							
								</tr>
								<tr>
									<td valign=top>
										<table width=99% border=1>
										<caption><span style="color:green"><b>DEPENSES A ENGAGER PAR LA DIRECTION DU BUDGET (DB)</b></span></caption>
										<tr>
											<td class="detailedViewHeader"><b>LIBELLE</b></td>
											<td class="detailedViewHeader" align="center"><b>QTE</b></td>
											<td class="detailedViewHeader" align="center"><b>NBRE</b></td>
											<td class="detailedViewHeader" align="center"><b>P.U</b></td>
											<td class="detailedViewHeader" align="center"><b>TOTAL(FCFA)</b></td>
											
										</tr>
										<?php $this->assign('totaldepreunion', 0); ?>
										<?php $this->assign('totalmontantaengage', 0); ?>
										<?php $this->assign('totalmontantaengageumv', 0); ?>

										<?php $_from = $this->_tpl_vars['NATDEPENSES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comptenat'] => $this->_tpl_vars['natdepense']):
?>
										   <?php if ($this->_tpl_vars['natdepense']['totaldepense'] > 0): ?>
											<tr>
												<!--td width="2%"><input type="checkbox" NAME="selected_id" id="<?php echo $this->_tpl_vars['entity_id']; ?>
" value= '<?php echo $this->_tpl_vars['entity_id']; ?>
' onClick="check_object(this)"></td-->
												<!--td width="2%">&nbsp;</td-->
											<td colspan=6 class="detailedViewHeader">
													<b><?php echo $this->_tpl_vars['natdepense']['libnatdepense']; ?>
 (<?php echo $this->_tpl_vars['comptenat']; ?>
)</b>
												</td>
												
											</tr>
											<?php $_from = $this->_tpl_vars['natdepense']['depenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['lignedepense']):
?>
																							<tr style="<?php echo $this->_tpl_vars['lignedepense']['style']; ?>
">
													<td ><?php echo $this->_tpl_vars['lignedepense']['libdepense']; ?>
</td>
													<td align="center"><?php echo $this->_tpl_vars['lignedepense']['qtedepense']; ?>
</td>
													<td align="center"><?php echo $this->_tpl_vars['lignedepense']['nbredepense']; ?>
</td>
													<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['pudepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
													<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
												</tr>
																						
											<?php endforeach; endif; unset($_from); ?>
												<tr>
													<td colspan=4 align="right">
														<b>TOTAL&nbsp;</b>
													</td>
													<td align=right>
														<b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b>
													</td>
													
												</tr>
												<?php if ($this->_tpl_vars['lignedepense']['style'] == 'background-color:white;'): ?>
													<?php $this->assign('totalmontantaengage', $this->_tpl_vars['totalmontantaengage']+$this->_tpl_vars['natdepense']['totaldepense']); ?>
												<?php else: ?>
													<?php $this->assign('totalmontantaengageumv', $this->_tpl_vars['totalmontantaengageumv']+$this->_tpl_vars['natdepense']['totaldepense']); ?>

												<?php endif; ?>
												<?php $this->assign('totaldepreunion', $this->_tpl_vars['totaldepreunion']+$this->_tpl_vars['natdepense']['totaldepense']); ?>
										<?php endif; ?>
										<?php endforeach; endif; unset($_from); ?>
										<tr><td colspan=6 class="detailedViewHeader">&nbsp;</td></tr>
										<tr><td colspan=4 align=right><b>BUDGET TOTAL DE L'ACTIVITE</b></td>
										<td align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldepreunion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td></tr>
										<tr><td colspan=4 align=right><span style="color:green"><b>TOTAL DES DEPENSES A ENGAGER PAR DB</b></span></td>
											<td align=right>
											<span style="color:green"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totalmontantaengage'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></span>
											</td>
											
										</tr>
										<tr><td colspan=4 align=right><span style="color:#808080"><b>TOTAL DES DEPENSES A ENGAGER PAR UMV</b></span></td>
											<td align=right>
											<span style="color:#808080"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totalmontantaengageumv'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></span>
											</td>
											
										</tr>
											
											<?php if ($this->_tpl_vars['IS_REUNIONENGAGE'] == '1'): ?>
												<tr><td align=center colspan=6><input 
														title="<?php echo $this->_tpl_vars['MOD']['LBL_EST_ENGAGE_OM_BUTTON_LABEL']; ?>
" 
														class="crmbutton small edit" 
														disabled="disabled"
														onclick=""
														type="button" 
														name="Edit" 
														value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_EST_ENGAGE_OM_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
												</td></tr>
											<?php else: ?>
												<tr>
													<td align=center colspan=6>
													<input 
												title="<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL']; ?>
" disabled="true"
												class="crmbutton small edit" 
												onclick="return goengagementreunion('<?php echo $this->_tpl_vars['ID']; ?>
');"
												type="button" 
												name="Edit" 
												value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
													<!--input 
															title="<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL']; ?>
" 
															class="crmbutton small edit" 
															onclick="this.form.return_module.value='Reunion'; 
																this.form.return_action.value='DetailView'; 
																this.form.module.value='Reunion';
																this.form.action.value='CreateEngagement';
																return creerEngagementReunion('Reunion');"   
																type="submit" 
															name="Edit" 
															value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CREER_ENGAGEMENT_DB_BUTTON_LABEL']; ?>
&nbsp;"-->&nbsp;
												</td></tr>
											<?php endif; ?>
																				</table>
											
									</td>
																
								</tr>
							</table>
						</div>
				
						<div id="editengagementdepenses" style="display:none">
							<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
								<tr>
									<td valign=top>
										<table width=99% border=1>
										<caption><span style="color:green"><b>MODFIFICATION DEPENSES A ENGAGER PAR LA DIRECTION DU BUDGET (DB)</b></span></caption>
										<tr>
											<td class="detailedViewHeader" colspan=2><b>LIBELLE</b></td>
											<td class="detailedViewHeader" align="center"><b>QTE</b></td>
											<td class="detailedViewHeader" align="center"><b>NBRE</b></td>
											<td class="detailedViewHeader" align="center"><b>P.U</b></td>
											<td class="detailedViewHeader" align="center"><b>TOTAL(FCFA)</b></td>
											
										</tr>
										<?php $this->assign('totaldepreunion', 0); ?>
										<?php $this->assign('totalmontantaengage', 0); ?>

										<?php $_from = $this->_tpl_vars['NATDEPENSES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comptenat'] => $this->_tpl_vars['natdepense']):
?>
										   <?php if ($this->_tpl_vars['natdepense']['totaldepense'] > 0): ?>
											<tr>
											<td colspan=7 class="detailedViewHeader">
													<b><?php echo $this->_tpl_vars['natdepense']['libnatdepense']; ?>
 (<?php echo $this->_tpl_vars['comptenat']; ?>
)</b>
												</td>
												
											</tr>
											<?php $_from = $this->_tpl_vars['natdepense']['depenses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['lignedepense']):
?>
												<tr id="row_cknaturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_<?php echo $this->_tpl_vars['lignedepense']['linenum']; ?>
" style="<?php echo $this->_tpl_vars['lignedepense']['style']; ?>
">
													<td width="2%"><input type="checkbox" <?php echo $this->_tpl_vars['lignedepense']['checked']; ?>
 NAME="cknaturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_<?php echo $this->_tpl_vars['lignedepense']['linenum']; ?>
" id="cknaturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_<?php echo $this->_tpl_vars['lignedepense']['linenum']; ?>
"  onClick="checkline_object('cknaturesdepense_<?php echo $this->_tpl_vars['comptenat']; ?>
_<?php echo $this->_tpl_vars['lignedepense']['linenum']; ?>
','<?php echo $this->_tpl_vars['lignedepense']['totaldepense']; ?>
')"></td>
													<td ><?php echo $this->_tpl_vars['lignedepense']['libdepense']; ?>
</td>
													<td align="center"><?php echo $this->_tpl_vars['lignedepense']['qtedepense']; ?>
</td>
													<td align="center"><?php echo $this->_tpl_vars['lignedepense']['nbredepense']; ?>
</td>
													<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['pudepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
													<td align=right><?php echo ((is_array($_tmp=$this->_tpl_vars['lignedepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</td>
												</tr>
												<?php if ($this->_tpl_vars['lignedepense']['checked'] != 'checked'): ?>
													<?php $this->assign('totalmontantaengage', $this->_tpl_vars['totalmontantaengage']+$this->_tpl_vars['lignedepense']['totaldepense']); ?>
												<?php endif; ?>
											<?php endforeach; endif; unset($_from); ?>
												<tr>
													<td colspan=5 align="right">
														<b>TOTAL&nbsp;</b>
													</td>
													<td align=right>
														<b><?php echo ((is_array($_tmp=$this->_tpl_vars['natdepense']['totaldepense'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b>
													</td>
													
												</tr>
												<?php $this->assign('totaldepreunion', $this->_tpl_vars['totaldepreunion']+$this->_tpl_vars['natdepense']['totaldepense']); ?>
											<?php endif; ?>
										<?php endforeach; endif; unset($_from); ?>
										<tr><td colspan=5 align=right><b>BUDGET TOTAL DE L'ACTIVITE</b></td>
										<td align=right><b><?php echo ((is_array($_tmp=$this->_tpl_vars['totaldepreunion'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ",", ' ') : number_format($_tmp, 0, ",", ' ')); ?>
</b></td></tr>
										<tr><td colspan=5 align=right><span style="color:green"><b>TOTAL DES DEPENSES A ENGAGER (DB)</b></span></td>
											<td align=right>
											<span style="color:green"><b><input style="color:green;font-weight:bold;text-align: right;" type="text" size="5" name="tmontantaengage" id="tmontantaengage" value="<?php echo $this->_tpl_vars['totalmontantaengage']; ?>
"></b></span>
											</td>
											
										</tr>
										</table>
											
									</td>
																
								</tr>
								<tr>
									<td align=center colspan=6>
										<input 
											title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL']; ?>
" 
											class="crmbutton small edit" 
											onclick="this.form.return_module.value='Reunion'; 
											this.form.return_action.value='DetailView'; 
											this.form.module.value='Reunion';
											this.form.action.value='SaveDepenseAEngager';
											return saveDepenseaengager('Reunion');"   
											type="submit" 
											name="Edit" 
											value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_DEPENSEAENGAGEMENT_DB_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
									<input 
									title="<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECISION_BUTTON_LABEL']; ?>
" 
									class="crmbutton small edit" 
									onclick="return cancelgererdepenses();"
									type="button" 
									name="Edit" 
									value="&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_CANCELMODIFDECISION_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
									</td>
								</tr>
							</table>
						</div>
			
		</div>
	<!-- PUBLIC CONTENTS STOPS-->
	</td>
	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
</tr>

</table>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<input type="hidden" id="reunionid" name="reunionid" value=<?php echo $this->_tpl_vars['ID']; ?>
></input>

</form>
<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Campaigns' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;width:300px;"></div></form>
<?php endif; ?>

<script>
function OpenWindow(url)
{
	openPopUp('xAttachFile',this,url,'attachfileWin',380,375,'menubar=no,toolbar=no,location=no,status=no,resizable=no');	
}
</script>