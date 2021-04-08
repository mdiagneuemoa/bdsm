<?php /* Smarty version 2.6.18, created on 2016-01-25 10:43:40
         compiled from ListViewEntriesReportingConventions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ListViewEntriesReportingConventions.tpl', 240, false),array('function', 'html_options', 'ListViewEntriesReportingConventions.tpl', 361, false),)), $this); ?>
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
     <input name="where_export" type="hidden" value="<?php  echo to_html($_SESSION['export_where']); ?>">
     <input name="step" type="hidden">
     <input name="allids" type="hidden" id="allids" value="<?php echo $this->_tpl_vars['ALLIDS']; ?>
">
     <input name="selectedboxes" id="selectedboxes" type="hidden" value="<?php echo $this->_tpl_vars['SELECTEDIDS']; ?>
">
     <input name="allselectedboxes" id="allselectedboxes" type="hidden" value="<?php echo $this->_tpl_vars['ALLSELECTEDIDS']; ?>
">
     <input name="current_page_boxes" id="current_page_boxes" type="hidden" value="<?php echo $this->_tpl_vars['CURRENT_PAGE_BOXES']; ?>
">
				<!-- List View Master Holder starts -->
				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
				<tr>
				<td>
				<!-- List View's Buttons and Filters starts -->
		        <table border=0 cellspacing=0 cellpadding=2 width=100% >
			    <tr>
				<!-- Buttons -->
				<!--
				<td style="padding-right:20px" nowrap>

                 <?php $_from = $this->_tpl_vars['BUTTONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['button_check'] => $this->_tpl_vars['button_label']):
?>
                    <?php if ($this->_tpl_vars['button_check'] == 'del'): ?>
                         <input class="crmbutton small delete" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return massDelete('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                    <?php elseif ($this->_tpl_vars['button_check'] == 'mass_edit'): ?>
                         <input class="crmbutton small edit" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return mass_edit(this, 'massedit', '<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                    <?php elseif ($this->_tpl_vars['button_check'] == 's_mail'): ?>
                         <input class="crmbutton small edit" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return eMail('<?php echo $this->_tpl_vars['MODULE']; ?>
',this);"/>
					<?php elseif ($this->_tpl_vars['button_check'] == 's_cmail'): ?>
                         <input class="crmbutton small edit" type="submit" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return massMail('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                    <?php elseif ($this->_tpl_vars['button_check'] == 'mailer_exp'): ?>
                         <input class="crmbutton small edit" type="submit" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return mailer_export()"/>
					<?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </td>
				-->
				<!-- Record Counts -->
			<?php if ($this->_tpl_vars['MODULE'] != 'Satellite'): ?>
				<td style="padding-right:20px"  nowrap><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
</td>
			<?php endif; ?>	
				<!-- Page Navigation -->
			 <?php if ($this->_tpl_vars['MODULE'] != 'Satellite'): ?>
		        	<td nowrap align="center" width=50%>
					<table border=0 cellspacing=0 cellpadding=0 >
					     <tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
					</table>
                		</td>
                	<?php endif; ?>
                <?php if ($this->_tpl_vars['MODULE'] == 'Satellite'): ?>
	                <td nowrap>
	                	<input type="hidden" name="recordmp3" id="recordmp3">
                		<div id="player">
							
						</div> 
	                </td>
	             <?php endif; ?>
				 
				   <!-- Filters -->
				   
				   <?php if ($this->_tpl_vars['HIDE_CUSTOM_LINKS'] != '1'): ?>
					
						<?php if ($this->_tpl_vars['CATEGORY'] == 'Analytics' && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
						<td width=100% align="right">
							<table border=0 cellspacing=0 cellpadding=0 >
								<tr>						
									<td align=left>
										<input name="submit" type="button" class="crmbutton small create" onClick="ExportExcell();" value="Export XSL">&nbsp;
									</td>
								</tr>
							</table> 
						</td>	
						<?php elseif ($this->_tpl_vars['CATEGORY'] == 'Reporting' && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
						<td width=100% align="right">
							<table border=0 cellspacing=0 cellpadding=0 >
								<tr>						
									<td align=left>
										<input name="submit" type="button" class="crmbutton small create" onClick="ExportExcell();" value="Export XSL">&nbsp;
									</td>
								</tr>
							</table> 
						</td>	
						<?php endif; ?>
					<?php endif; ?>
       		    </tr>
			<tr>

					<?php if ($this->_tpl_vars['MODULE'] == 'Satellite'): ?>
						<td nowrap>
							<p> <b><?php echo $this->_tpl_vars['RECORDS_PERIODE']; ?>
 </b> </p>
						</td>
						<td style="padding-right:20px"  nowrap><p> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
 </p></td>
					<?php endif; ?>	
			</tr>	
					
			</table>
			<!-- List View's Buttons and Filters ends -->
			
			<!-- Table Headers -->
			<!--<div style="width:100%;overflow:auto;">
			<table border="1" style="width:100%;overflow:hidden;">-->
		
			
			<div class="wrap">
				<div class="inner">
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
			
			<tr>
	          
				<?php $_from = $this->_tpl_vars['LISTHEADER']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['listviewforeach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['listviewforeach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['header']):
        $this->_foreach['listviewforeach']['iteration']++;
?>
				<?php if ($this->_tpl_vars['header'] == 'Action' && ( $this->_tpl_vars['MODULE'] == 'ReportingConventions' || $this->_tpl_vars['MODULE'] == 'SBConventions' )): ?>
				<?php else: ?>
 					<td class="lvtCol" align=center><?php echo $this->_tpl_vars['header']; ?>
</td>
 				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</tr>
			
			
			<?php $_from = $this->_tpl_vars['LISTENTITYGLOBAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cle'] => $this->_tpl_vars['entityg']):
?>
			<?php if ($this->_tpl_vars['cle'] != 'SEUIL'): ?>
				<tr>
					<?php if ($this->_tpl_vars['cle'] == 'CUMUL' && $this->_tpl_vars['MODULE'] != 'Agent'): ?>
						<td  align="left" colspan="4"><b>SEUIL <span style="color:green;">OK</span> : <?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['seuilOK']; ?>
 / <?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['nbccx']; ?>
 <span style="color:green;">(<?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['pseuilOK']; ?>
%)</span>
						- SEUIL <span style="color:red;">K0</span> : <?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['seuilKO']; ?>
 / <?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['nbccx']; ?>
 <span style="color:red;">(<?php echo $this->_tpl_vars['LISTENTITYGLOBAL']['SEUIL']['pseuilKO']; ?>
%)</span></b></td>
						<td align="right" colspan="1"><b><?php echo $this->_tpl_vars['cle']; ?>
</b></td>
					<?php elseif ($this->_tpl_vars['cle'] == 'MOYENNE' || $this->_tpl_vars['MODULE'] == 'Agent'): ?>	
						<td align="right" colspan="5"><b><?php echo $this->_tpl_vars['cle']; ?>
</b></td>
					<?php endif; ?>
					
			
					<?php $_from = $this->_tpl_vars['entityg']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cols'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cols']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['cols']['iteration']++;
?>			
						<td><?php echo $this->_tpl_vars['data']; ?>
</td>

					<?php endforeach; endif; unset($_from); ?>
				</tr>
			<?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
			<!--</table>-->
			<!-- Table Contents -->
			
		
			
			 <?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
				<?php $this->assign('totalCallsEntered', 0); ?>
				<?php $this->assign('totalCallsDistributed', 0); ?>
				<?php $this->assign('totalCallsAnswered', 0); ?>
				<?php $this->assign('totalCallsAbandoned', 0); ?>
				<?php $this->assign('totalCallsShotAnswered', 0); ?>
				<?php $this->assign('totalCallsShotAbandoned', 0); ?>
			<?php endif; ?>
			
			 <?php if ($this->_tpl_vars['MODULE'] == 'ReportingConventions' && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
				<?php $this->assign('totalMontant', 0); ?>
		<?php endif; ?>	
			
			<?php $_from = $this->_tpl_vars['LISTENTITY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_id'] => $this->_tpl_vars['entity']):
?>
			<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
			
			<?php $_from = $this->_tpl_vars['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cols'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cols']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['cols']['iteration']++;
?>	
			
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 2): ?>
				<?php $this->assign('totalCallsEntered', $this->_tpl_vars['totalCallsEntered']+$this->_tpl_vars['data']); ?>		
			<?php endif; ?>
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 3): ?>
				<?php $this->assign('totalCallsDistributed', $this->_tpl_vars['totalCallsDistributed']+$this->_tpl_vars['data']); ?>			
			<?php endif; ?>
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 4): ?>
				<?php $this->assign('totalCallsAnswered', $this->_tpl_vars['totalCallsAnswered']+$this->_tpl_vars['data']); ?>			
			<?php endif; ?>
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 5): ?>
				<?php $this->assign('totalCallsAbandoned', $this->_tpl_vars['totalCallsAbandoned']+$this->_tpl_vars['data']); ?>		
			<?php endif; ?>
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 6): ?>
				<?php $this->assign('totalCallsShotAnswered', $this->_tpl_vars['totalCallsShotAnswered']+$this->_tpl_vars['data']); ?>		
			<?php endif; ?>
			<?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && ($this->_foreach['cols']['iteration']-1) == 7): ?>
				<?php $this->assign('totalCallsShotAbandoned', $this->_tpl_vars['totalCallsShotAbandoned']+$this->_tpl_vars['data']); ?>			
			<?php endif; ?>
			<?php if ($this->_tpl_vars['MODULE'] == 'ReportingConventions' && ($this->_foreach['cols']['iteration']-1) == 2): ?>
				<?php $this->assign('totalMontant', $this->_tpl_vars['totalMontant']+$this->_tpl_vars['data']); ?>			
			<?php endif; ?>
			

			<?php if ($this->_tpl_vars['MODULE'] == 'ReportingConventions' && ($this->_foreach['cols']['iteration']-1) == 2): ?>
				<td nowrap align="right">
				<?php  
					$mnt = $this->get_template_vars('data'); 
					$mnt2 = number_format($mnt, 0, ',', ' ');
					echo $mnt2;
				 ?>
			<?php elseif ($this->_tpl_vars['MODULE'] == 'SBConventions' && ( ($this->_foreach['cols']['iteration']-1) == 3 || ($this->_foreach['cols']['iteration']-1) == 4 || ($this->_foreach['cols']['iteration']-1) == 5 || ($this->_foreach['cols']['iteration']-1) == 6 || ($this->_foreach['cols']['iteration']-1) == 7 || ($this->_foreach['cols']['iteration']-1) == 8 || ($this->_foreach['cols']['iteration']-1) == 9 || ($this->_foreach['cols']['iteration']-1) == 10 )): ?>
				<td nowrap align="right">
					<?php  
					$mnt = $this->get_template_vars('data'); 
					$mnt2 = number_format($mnt, 0, ',', ' ');
					echo $mnt2;
				 ?>			
			<?php else: ?>
			<td nowrap>
				<?php echo $this->_tpl_vars['data']; ?>

			<?php endif; ?>
			</td>
	        <?php endforeach; endif; unset($_from); ?>
			</tr>
			<?php endforeach; else: ?>
			<tr><td style="background-color:#efefef;height:340px" align="center" colspan="<?php echo $this->_foreach['listviewforeach']['iteration']+1; ?>
">
			<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 50%; position: relative; z-index: 10000000;">
				<?php $this->assign('vowel_conf', 'LBL_A'); ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Invoice'): ?>
				<?php $this->assign('vowel_conf', 'LBL_AN'); ?>
				<?php endif; ?>
				<?php $this->assign('MODULE_CREATE', $this->_tpl_vars['SINGLE_MOD']); ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'HelpDesk'): ?>
				<?php $this->assign('MODULE_CREATE', 'Ticket'); ?>
				<?php endif; ?>
				
				<?php if ($this->_tpl_vars['CHECK']['EditView'] == 'yes' && $this->_tpl_vars['MODULE'] != 'Emails' && $this->_tpl_vars['MODULE'] != 'Webmails'): ?>
							
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
					<td rowspan="2" width="25%"><img src="<?php echo vtiger_imageurl('empty.jpg', $this->_tpl_vars['THEME']); ?>
" height="60" width="60"></td>
					<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
					<?php if ($this->_tpl_vars['MODULE_CREATE'] == 'SalesOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'Invoice' || $this->_tpl_vars['MODULE_CREATE'] == 'Quotes'): ?>
						<?php echo $this->_tpl_vars['APP']['LBL_NO']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>
 !
					<?php elseif ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
						<?php echo $this->_tpl_vars['APP']['LBL_NO']; ?>
 <?php echo $this->_tpl_vars['APP']['ACTIVITIES']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>
 !
					<?php else: ?>
																		
						<?php echo $this->_tpl_vars['APP']['NO_DATA_AVAILABLE_WITH_SPECIFIED_PERIOD']; ?>
 !

					<?php endif; ?>
					</span></td>
				</tr>
				
				</table> 
			<?php else: ?>
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
				<td rowspan="2" width="25%"><img src="<?php echo vtiger_imageurl('denied.gif', $this->_tpl_vars['THEME']); ?>
"></td>
				<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
				<?php if ($this->_tpl_vars['MODULE_CREATE'] == 'SalesOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'Invoice' || $this->_tpl_vars['MODULE_CREATE'] == 'Quotes'): ?>
					<?php echo $this->_tpl_vars['APP']['LBL_NO']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>
 !</span></td>
				<?php else: ?>
										<?php echo $this->_tpl_vars['APP']['LBL_NO']; ?>
 <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]): ?><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]; ?>
s<?php else: ?><?php echo $this->_tpl_vars['MODULE_CREATE']; ?>
<?php endif; ?> <?php echo $this->_tpl_vars['APP']['LBL_FOUND']; ?>
 !</span></td>
				<?php endif; ?>
				</tr>
				<tr>
				<td  align="left" nowrap="nowrap"><?php echo $this->_tpl_vars['APP']['LBL_YOU_ARE_NOT_ALLOWED_TO_CREATE']; ?>
 <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['vowel_conf']]; ?>

				<?php if ($this->_tpl_vars['MODULE_CREATE'] == 'SalesOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE_CREATE'] == 'Invoice' || $this->_tpl_vars['MODULE_CREATE'] == 'Quotes'): ?>
					 <?php echo $this->_tpl_vars['MOD'][$this->_tpl_vars['MODULE_CREATE']]; ?>

				<?php else: ?>
					 					 <?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]): ?><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_CREATE']]; ?>
<?php else: ?><?php echo $this->_tpl_vars['MODULE_CREATE']; ?>
<?php endif; ?>
				<?php endif; ?>
				<br>
				</td>
				</tr>
				</table>
				<?php endif; ?>
				</div>					
				</td></tr>	
			     <?php endif; unset($_from); ?>

				 <?php if (( $this->_tpl_vars['MODULE'] == 'RoutingPoint' || $this->_tpl_vars['MODULE'] == 'Campagne' ) && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
					<tr bgcolor=white class=lvtColDataHover  id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
						<td colspan="2" align="right"><b>Total</b></td>
						<td><b><?php echo $this->_tpl_vars['totalCallsEntered']; ?>
</td>
						<td><b><?php echo $this->_tpl_vars['totalCallsDistributed']; ?>
</td>
						<td><b><?php echo $this->_tpl_vars['totalCallsAnswered']; ?>
</td>
						<td><b><?php echo $this->_tpl_vars['totalCallsAbandoned']; ?>
</td>
						<td><b><?php echo $this->_tpl_vars['totalCallsShotAnswered']; ?>
</td>
						<td><b><?php echo $this->_tpl_vars['totalCallsShotAbandoned']; ?>
</td>
						<td colspan=20><b>&nbsp;</td>
						
					</tr>
				<?php endif; ?>	
				
				<?php if (( $this->_tpl_vars['MODULE'] == 'ReportingConventions' ) && $this->_tpl_vars['NB_RECORDS'] != 0): ?>
					<tr bgcolor=white class=lvtColDataHover  id="row_<?php echo $this->_tpl_vars['entity_id']; ?>
">
						<td colspan="2" align="right"><b>Total</b></td>
						<td nowrap><b><?php  
									$mnt = $this->get_template_vars('totalMontant'); 
									$mnt2 = number_format($mnt, 0, ',', ' ');
									echo $mnt2;
								 ?></td>
						<td colspan=20><b>&nbsp;</td>
						
					</tr>
				<?php endif; ?>
			  </tbody>
		 </table>
		 <!--/div-->
			 
			 <table border=0 cellspacing=0 cellpadding=2 width=100%>
			      <tr>
				  <!--
				 <td style="padding-right:20px" nowrap>
                                 <?php $_from = $this->_tpl_vars['BUTTONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['button_check'] => $this->_tpl_vars['button_label']):
?>
                                        <?php if ($this->_tpl_vars['button_check'] == 'del'): ?>
                                            <input class="crmbutton small delete" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return massDelete('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
					                    <?php elseif ($this->_tpl_vars['button_check'] == 'mass_edit'): ?>
					                         <input class="crmbutton small edit" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return mass_edit(this, 'massedit', '<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                                        <?php elseif ($this->_tpl_vars['button_check'] == 's_mail'): ?>
                                             <input class="crmbutton small edit" type="button" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return eMail('<?php echo $this->_tpl_vars['MODULE']; ?>
',this)"/>
                                        <?php elseif ($this->_tpl_vars['button_check'] == 's_cmail'): ?>
                                             <input class="crmbutton small edit" type="submit" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return massMail('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
                                        <?php elseif ($this->_tpl_vars['button_check'] == 'mailer_exp'): ?>
                                             <input class="crmbutton small edit" type="submit" value="<?php echo $this->_tpl_vars['button_label']; ?>
" onclick="return mailer_export()"/>
										<?php endif; ?>

                                 <?php endforeach; endif; unset($_from); ?>
                    </td>
					-->
				 <td style="padding-right:20px"  nowrap width=40%><?php echo $this->_tpl_vars['RECORD_COUNTS']; ?>
</td>
				 <td nowrap align="left" width=60%>
				    <table border=0 cellspacing=0 cellpadding=0 >
				         <tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
				     </table>
				 </td>
				 <!--
				 <td align="right" width=100%>
				   <table border=0 cellspacing=0 cellpadding=0 >
					<tr>
                                           <?php echo $this->_tpl_vars['WORDTEMPLATEOPTIONS']; ?>
<?php echo $this->_tpl_vars['MERGEBUTTON']; ?>

					</tr>
				   </table>
				 </td>
				 -->
			      </tr>
       		    </table>
		       </td>
		   </tr>
	    </table>

   </form>	
<?php echo $this->_tpl_vars['SELECT_SCRIPT']; ?>

<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['SEARCHLISTHEADER']), $this);?>
</select></div>