<?php /* Smarty version 2.6.18, created on 2009-09-30 19:23:59
         compiled from DetailViewTimesheets.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'DetailViewTimesheets.tpl', 191, false),array('modifier', 'replace', 'DetailViewTimesheets.tpl', 302, false),)), $this); ?>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>

<script type="text/javascript" src="include/js/reflection.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>
<!--
<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
   <a class="link"  align="right" href="javascript:;"><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON']; ?>
</a>
</span>
-->
<div id="convertleaddiv" style="display:block;position:absolute;left:225px;top:150px;"></div>
<script>
<?php echo '
var gVTModule = \'{$smarty.request.module}\';
function callConvertLeadDiv(id)
{
        new Ajax.Request(
                \'index.php\',
                {queue: {position: \'end\', scope: \'command\'},
                        method: \'post\',
                        postBody: \'module=Leads&action=LeadsAjax&file=ConvertLead&record=\'+id,
                        onComplete: function(response) {
                                $("convertleaddiv").innerHTML=response.responseText;
				eval($("conv_leadcal").innerHTML);
                        }
                }
        );
}
function showHideStatus(sId,anchorImgId,sImagePath)
{
	oObj = eval(document.getElementById(sId));
	if(oObj.style.display == \'block\')
	{
		oObj.style.display = \'none\';
		eval(document.getElementById(anchorImgId)).src =  \'themes/images/inactivate.gif\';
		eval(document.getElementById(anchorImgId)).alt = \'Display\';
		eval(document.getElementById(anchorImgId)).title = \'Display\';
	}
	else
	{
		oObj.style.display = \'block\';
		eval(document.getElementById(anchorImgId)).src = \'themes/images/activate.gif\';
		eval(document.getElementById(anchorImgId)).alt = \'Hide\';
		eval(document.getElementById(anchorImgId)).title = \'Hide\';
	}
}
<!-- End Of Code modified by SAKTI on 10th Apr, 2008 -->

<!-- Start of code added by SAKTI on 16th Jun, 2008 -->
function setCoOrdinate(elemId){
	oBtnObj = document.getElementById(elemId);
	var tagName = document.getElementById(\'lstRecordLayout\');
	leftpos  = 0;
	toppos = 0;
	aTag = oBtnObj;
	do{					  
	  leftpos  += aTag.offsetLeft;
	  toppos += aTag.offsetTop;
	} while(aTag = aTag.offsetParent);
	
	tagName.style.top= toppos + 20 + \'px\';
	tagName.style.left= leftpos - 276 + \'px\';
}

function getListOfRecords(obj, sModule, iId,sParentTab)
{
		new Ajax.Request(
		\'index.php\',
		{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody: \'module=Users&action=getListOfRecords&ajax=true&CurModule=\'+sModule+\'&CurRecordId=\'+iId+\'&CurParentTab=\'+sParentTab,
			onComplete: function(response) {
				sResponse = response.responseText;
				$("lstRecordLayout").innerHTML = sResponse;
				Lay = \'lstRecordLayout\';	
				var tagName = document.getElementById(Lay);
				var leftSide = findPosX(obj);
				var topSide = findPosY(obj);
				var maxW = tagName.style.width;
				var widthM = maxW.substring(0,maxW.length-2);
				var getVal = parseInt(leftSide) + parseInt(widthM);
				if(getVal  > document.body.clientWidth ){
					leftSide = parseInt(leftSide) - parseInt(widthM);
					tagName.style.left = leftSide + 230 + \'px\';
					tagName.style.top = topSide + 20 + \'px\';
				}else{
					tagName.style.left = leftSide + 230 + \'px\';
				}
				setCoOrdinate(obj.id);
				
				tagName.style.display = \'block\';
				tagName.style.visibility = "visible";
			}
		}
	);
}
<!-- End of code added by SAKTI on 16th Jun, 2008 -->
'; ?>

function tagvalidate()
{
	if(trim(document.getElementById('txtbox_tagfields').value) != '')
		SaveTag('txtbox_tagfields','<?php echo $this->_tpl_vars['ID']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
');	
	else
	{
		alert("<?php echo $this->_tpl_vars['APP']['PLEASE_ENTER_TAG']; ?>
");
		return false;
	}
}
function DeleteTag(id,recordid)
{
	$("vtbusy_info").style.display="inline";
	Effect.Fade('tag_'+id);
	new Ajax.Request(
		'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "file=TagCloud&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&ajxaction=DELETETAG&recordid="+recordid+"&tagid=" +id,
                        onComplete: function(response) {
						getTagCloud();
						$("vtbusy_info").style.display="none";
                        }
                }
        );
}

//Added to send a file, in Documents module, as an attachment in an email
function sendfile_email()
{
	filename = $('dldfilename').value;
	document.DetailView.submit();
	OpenCompose(filename,'Documents');
}

</script>

<div id="lstRecordLayout" class="layerPopup" style="display:none;width:325px;height:300px;"></div>

<?php if ($this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Leads'): ?>
        <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
                <?php $this->assign('address1', '$MOD.LBL_BILLING_ADDRESS'); ?>
                <?php $this->assign('address2', '$MOD.LBL_SHIPPING_ADDRESS'); ?>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
                <?php $this->assign('address1', '$MOD.LBL_PRIMARY_ADDRESS'); ?>
                <?php $this->assign('address2', '$MOD.LBL_ALTERNATE_ADDRESS'); ?>
        <?php endif; ?>
        <div id="locateMap" onMouseOut="fninvsh('locateMap')" onMouseOver="fnvshNrm('locateMap')">
                <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
							<td>
                                <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
                                        <a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Main' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_BILLING_ADDRESS']; ?>
</a>
                                        <a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Other' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_SHIPPING_ADDRESS']; ?>
</a>
                               <?php endif; ?>
                               <?php if ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
									<a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Main' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_PRIMARY_ADDRESS']; ?>
</a>
                                    <a href="javascript:;" onClick="fninvsh('locateMap'); searchMapLocation( 'Other' );" class="calMnu"><?php echo $this->_tpl_vars['MOD']['LBL_ALTERNATE_ADDRESS']; ?>
</a>
                               <?php endif; ?>
						   </td>
                        </tr>
                </table>
        </div>
<?php endif; ?>


<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
	<td>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List1.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
<!-- Contents -->
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
<tr>
	<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
	<td class="showPanelBg" valign=top width=100%>
		<!-- PUBLIC CONTENTS STARTS-->
		<div class="small" style="padding:10px" >
		
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
			<tr><td>		
		  				 		<span class="dvHeaderText">
				<?php if ($this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports'): ?>
					<!-- Pour retourner au dossier du document Hodar CRM -->
					<a href="index.php?action=ListView&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
&folderid=<?php echo $this->_tpl_vars['FOLDERID']; ?>
">
					<img src="<?php echo vtiger_imageurl('dossier-ouvert.gif', $this->_tpl_vars['THEME']); ?>
" border=0>&nbsp;<?php echo $this->_tpl_vars['FOLDERNAME']; ?>
</a> >
				<?php endif; ?>
				[ <?php echo $this->_tpl_vars['MOD_SEQ_ID']; ?>
 ] <?php echo $this->_tpl_vars['NAME']; ?>
 -  <?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</span>&nbsp;&nbsp;&nbsp;<span class="small"><?php echo $this->_tpl_vars['UPDATEINFO']; ?>
</span>&nbsp;<span id="vtbusy_info" style="display:none;" valign="bottom"><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span><span id="vtbusy_info" style="visibility:hidden;" valign="bottom"><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
		 	</td></tr>
		 </table>			 
		<br>
		
		<!-- Account details tabs -->
		<table border=0 cellspacing=0 cellpadding=0 width=95% align=center>
		<tr>
			<td>
				<form action="index.php" method="post" name="DetailView" id="form1">
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	  
				<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCell" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>	
					<td class="dvtTabCache" style="width:10px">&nbsp;</td>
					<!--<?php if ($this->_tpl_vars['SinglePane_View'] == 'false'): ?>
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a></td>
					<?php endif; ?>-->
					<td class="dvtTabCache" align="right" style="width:100%">
					
						<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted'): ?>
					
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.return_action.value='DetailView'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView';" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['DELETE'] == 'permitted'): ?>
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='index'; this.form.action.value='Delete'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
') <?php else: ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
') <?php endif; ?>" type="submit" name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
						<?php endif; ?>
										
						<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
						<?php endif; ?>							
						<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdTop" id="jumpBtnIdTop" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
					</td>
				</tr>
				</table>
				</form>
			</td>
		</tr>
		<tr>
			<td valign=top align=left >                
				 <table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace" style="border-bottom:0;">
				<tr>

					<td align=left>
					<!-- content cache -->
					
				<table border=0 cellspacing=0 cellpadding=0 width=100%>
                <tr>
					<td style="padding:5px">
					<!-- Command Buttons -->
				  	<table border=0 cellspacing=0 cellpadding=0 width=100%>
							 
							  <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->
							 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "./include/DetailViewBlockStatus.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

							 <!-- Start of File Include by SAKTI on 10th Apr, 2008 -->

							<?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>

							<!-- Detailed View Code starts here-->
							<table border=0 cellspacing=0 cellpadding=0 width=100% class="small">
							<tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          
                             </tr>

							<!-- This is added to display the existing comments -->
							<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENTS'] || $this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']): ?>
							   <tr>
								<td colspan=4 class="dvInnerHeader">
						        	<b><?php echo $this->_tpl_vars['MOD']['LBL_COMMENT_INFORMATION']; ?>
</b>
								</td>
							   </tr>
							   <tr>
							   			<td colspan=4 class="dvtCellInfo"><?php echo $this->_tpl_vars['COMMENT_BLOCK']; ?>
</td>
							   </tr>
							   <tr><td>&nbsp;</td></tr>
							<?php endif; ?>


	<?php if ($this->_tpl_vars['header'] != $this->_tpl_vars['MOD']['LBL_INTERVENTION_INFORMATION']): ?>
 
						     <tr><?php echo '<td colspan=4 class="dvInnerHeader"><div style="float:left;font-weight:bold;"><div style="float:left;"><a href="javascript:showHideStatus(\'tbl'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\'aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '\',\''; ?><?php echo $this->_tpl_vars['IMAGE_PATH']; ?><?php echo '\');">'; ?><?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('activate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Hide" title="Hide"/>'; ?><?php else: ?><?php echo '<img id="aid'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?><?php echo '" src="'; ?><?php echo vtiger_imageurl('inactivate.gif', $this->_tpl_vars['THEME']); ?><?php echo '" style="border: 0px solid #000000;" alt="Display" title="Display"/>'; ?><?php endif; ?><?php echo '</a></div><b>&nbsp;'; ?><?php echo $this->_tpl_vars['header']; ?><?php echo '</b></div></td>'; ?>

					             </tr>
<?php endif; ?>
							</table>
<?php if ($this->_tpl_vars['header'] != $this->_tpl_vars['MOD']['LBL_INTERVENTION_INFORMATION']): ?>
							<?php if ($this->_tpl_vars['BLOCKINITIALSTATUS'][$this->_tpl_vars['header']] == 1): ?>
							<div style="width:auto;display:block;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
							<?php else: ?>
							<div style="width:auto;display:none;" id="tbl<?php echo ((is_array($_tmp=$this->_tpl_vars['header'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '') : smarty_modifier_replace($_tmp, ' ', '')); ?>
" >
							<?php endif; ?>
							<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
						   <?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['detail']):
?>
								<tr style="height:25px">
									<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['data']):
?>
									   <?php $this->assign('keyid', $this->_tpl_vars['data']['ui']); ?>
									   <?php $this->assign('keyval', $this->_tpl_vars['data']['value']); ?>
									   <?php $this->assign('keytblname', $this->_tpl_vars['data']['tablename']); ?>
									   <?php $this->assign('keyfldname', $this->_tpl_vars['data']['fldname']); ?>
									   <?php $this->assign('keyfldid', $this->_tpl_vars['data']['fldid']); ?>
									   <?php $this->assign('keyoptions', $this->_tpl_vars['data']['options']); ?>
									   <?php $this->assign('keysecid', $this->_tpl_vars['data']['secid']); ?>
									   <?php $this->assign('keyseclink', $this->_tpl_vars['data']['link']); ?>
									   <?php $this->assign('keycursymb', $this->_tpl_vars['data']['cursymb']); ?>
									   <?php $this->assign('keysalut', $this->_tpl_vars['data']['salut']); ?>
									   <?php $this->assign('keyaccess', $this->_tpl_vars['data']['notaccess']); ?>
									   <?php $this->assign('keycntimage', $this->_tpl_vars['data']['cntimage']); ?>
									   <?php $this->assign('keyadmin', $this->_tpl_vars['data']['isadmin']); ?>
									   
									   
									   
			                           <?php if ($this->_tpl_vars['label'] != ''): ?>
					                        <?php if ($this->_tpl_vars['keycntimage'] != ''): ?>
													<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['keycntimage']; ?>
</td>
											<?php elseif ($this->_tpl_vars['keyid'] == '71' || $this->_tpl_vars['keyid'] == '72'): ?><!-- Currency symbol -->
													<td class="dvtCellLabel" align=right width=25%><?php echo $this->_tpl_vars['label']; ?>
<input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input> (<?php echo $this->_tpl_vars['keycursymb']; ?>
)</td>
								
											<?php elseif ($this->_tpl_vars['keyid'] != '53'): ?> <!-- Hodar crm && $keyid neq '27' pour ne pas afficher filelocationtype -->
							
											<td class="dvtCellLabel" align=right width=25%><input type="hidden" id="hdtxt_IsAdmin" value=<?php echo $this->_tpl_vars['keyadmin']; ?>
></input><?php echo $this->_tpl_vars['label']; ?>
</td>
										<?php endif; ?>
										<?php if (( $this->_tpl_vars['MODULE'] == 'Documents' || $this->_tpl_vars['MODULE'] == 'HReports' ) && $this->_tpl_vars['EDIT_PERMISSION'] == 'yes' && $this->_tpl_vars['header'] == 'File Information'): ?>
											<?php if ($this->_tpl_vars['keyfldname'] == 'filestatus' && $this->_tpl_vars['ADMIN'] == 'yes'): ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewUI.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											<?php else: ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											<?php endif; ?>
										<?php else: ?>
											<?php if ($this->_tpl_vars['EDIT_PERMISSION'] == 'yes'): ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewUI.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											<?php else: ?>
												<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DetailViewFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
											<?php endif; ?>
										<?php endif; ?>
									   <?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>
							</tr>	
						<?php endforeach; endif; unset($_from); ?>	
				</table>
							 </div>
			<?php endif; ?>
             </td>
	 </tr>
  <tr>  <td style="padding:10px">
<?php endforeach; endif; unset($_from); ?>
  
			</td>
                </tr>
				
			<tr>
									   <td colspan=4>
											<table border=0 cellspacing=0 cellpadding=0 width="100%" class="small">
												<tr>
													<td colspan="2" class="detailedViewHeader">
														<b><?php echo $this->_tpl_vars['MOD']['LBL_LIST_INTERVENTIONS']; ?>
</b>
													</td>
													
												</tr>
												<tr>
													<td colspan=2>
													
														<table id='tabIntervs' border=1 align=center cellspacing=1 cellpadding=1 width=100%>
															<tr  class="lvt small">
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
																<tr class="lvt small">
													
																<td align='center'><?php echo $this->_tpl_vars['interv']['date_interv']; ?>
</td>
																<td align='center'><?php echo $this->_tpl_vars['interv']['accountname']; ?>
</td>
																<td align='center'><?php echo $this->_tpl_vars['interv']['potentialname']; ?>
</td>
																<td align='center'><?php echo $this->_tpl_vars['interv']['intervtask']; ?>
</td>
																<td align='center' width="100"><?php echo $this->_tpl_vars['interv']['duration_interv']; ?>
</td>
																</tr>	
															<?php endforeach; endif; unset($_from); ?>	
															<tr class="lvt small">
																<td colspan='4' align=right><b><?php echo $this->_tpl_vars['MOD']['LBL_TIMESHEET_TOTAL_DURATION']; ?>
</b></td>
																<td align='center' width="100"><b><?php echo $this->_tpl_vars['DURATIONHOURS']; ?>
</b></td>
															</tr>
														</table>
													</td>
												</tr>
										</table>
										</td>
                                    </tr>	
		<!-- Inventory - Product Details informations -->
		   <tr>
			<?php echo $this->_tpl_vars['ASSOCIATED_PRODUCTS']; ?>

		   </tr>			
			<!--<?php if ($this->_tpl_vars['SinglePane_View'] == 'true' && $this->_tpl_vars['IS_REL_LIST'] == 'true'): ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'RelatedListNew.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>-->
		</table>
		</td>
		
</tr>
	<tr>
		<td>			
			<form action="index.php" method="post" name="DetailView2" id="form2">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'DetailViewHidden.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
				<tr>
					<td class="dvtTabCacheBottom" style="width:10px" nowrap>&nbsp;</td>
					
					<td class="dvtSelectedCellBottom" align=center nowrap><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['SINGLE_MOD']]; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</td>	
					<td class="dvtTabCacheBottom" style="width:10px">&nbsp;</td>
					<!--<?php if ($this->_tpl_vars['SinglePane_View'] == 'false'): ?>
					<td class="dvtUnSelectedCell" align=center nowrap><a href="index.php?action=CallRelatedList&module=<?php echo $this->_tpl_vars['MODULE']; ?>
&record=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_MORE']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_INFORMATION']; ?>
</a></td>
					<?php endif; ?>-->
					<td class="dvtTabCacheBottom" align="right" style="width:100%">
						&nbsp;
						<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted'): ?>
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" class="crmbutton small edit" onclick="this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.action.value='EditView';this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView';" type="submit" name="Edit" value="&nbsp;<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
&nbsp;">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted' && $this->_tpl_vars['MODULE'] != 'Documents' && $this->_tpl_vars['MODULE'] != 'HReports' && $this->_tpl_vars['MODULE'] != 'Timesheets'): ?>
								<input title="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_KEY']; ?>
" class="crmbutton small create" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='DetailView'; this.form.isDuplicate.value='true';this.form.module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.action.value='EditView'" type="submit" name="Duplicate" value="<?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_BUTTON_LABEL']; ?>
">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['DELETE'] == 'permitted'): ?>
								<input title="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_KEY']; ?>
" class="crmbutton small delete" onclick="this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='index'; this.form.action.value='Delete'; <?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_ACCOUNT_DELETE_CONFIRMATION']; ?>
') <?php else: ?> return confirm('<?php echo $this->_tpl_vars['APP']['NTC_DELETE_CONFIRMATION']; ?>
') <?php endif; ?>" type="submit" name="Delete" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON_LABEL']; ?>
">&nbsp;
						<?php endif; ?>
					
						<?php if ($this->_tpl_vars['privrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['privrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="privrecord" value="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_PREVIOUS']; ?>
" src="<?php echo vtiger_imageurl('rec_prev_disabled.gif', $this->_tpl_vars['THEME']); ?>
">
						<?php endif; ?>							
						<?php if ($this->_tpl_vars['privrecord'] != '' || $this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_JUMP_BTN']; ?>
" onclick="var obj = this;var lhref = getListOfRecords(obj, '<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
,'<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" name="jumpBtnIdBottom" id="jumpBtnIdBottom" src="<?php echo vtiger_imageurl('rec_jump.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
						<?php if ($this->_tpl_vars['nextrecord'] != ''): ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&viewtype=<?php echo $this->_tpl_vars['VIEWTYPE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['nextrecord']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
'" name="nextrecord" src="<?php echo vtiger_imageurl('rec_next.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php else: ?>
						<img align="absmiddle" title="<?php echo $this->_tpl_vars['APP']['LNK_LIST_NEXT']; ?>
" src="<?php echo vtiger_imageurl('rec_next_disabled.gif', $this->_tpl_vars['THEME']); ?>
">&nbsp;
						<?php endif; ?>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
<script language="JavaScript" type="text/javascript" src="modules/Products/Productsslide.js"></script>
<script language="JavaScript" type="text/javascript">Carousel();</script>
<?php endif; ?>

<script>

function getTagCloud()
{
new Ajax.Request(
        'index.php',
        {queue: {position: 'end', scope: 'command'},
        method: 'post',
        postBody: 'module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=<?php echo $this->_tpl_vars['MODULE']; ?>
Ajax&file=TagCloud&ajxaction=GETTAGCLOUD&recordid=<?php echo $this->_tpl_vars['ID']; ?>
',
        onComplete: function(response) {
                                $("tagfields").innerHTML=response.responseText;
                                $("txtbox_tagfields").value ='';
                        }
        }
);
}
getTagCloud();
</script>
<!-- added for validation -->
<script language="javascript">
  var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
);
  var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
);
  var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
);
</script>
</td>

	<td align=right valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
</tr></table>

<?php if ($this->_tpl_vars['MODULE'] == 'Leads' || $this->_tpl_vars['MODULE'] == 'Contacts' || $this->_tpl_vars['MODULE'] == 'Accounts' || $this->_tpl_vars['MODULE'] == 'Campaigns' || $this->_tpl_vars['MODULE'] == 'Vendors'): ?>
	<form name="SendMail"><div id="sendmail_cont" style="z-index:100001;position:absolute;"></div></form>
<?php endif; ?>








