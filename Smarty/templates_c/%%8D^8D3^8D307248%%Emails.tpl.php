<?php /* Smarty version 2.6.18, created on 2009-09-09 09:20:50
         compiled from Emails.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'Emails.tpl', 76, false),)), $this); ?>
<!--  USER  SETTINGS PAGE STARTS HERE -->
<script language="javascript">
function ShowFolders(folderid)
{
	gselectedrowid = 0;
	$("status").style.display="inline";
	gFolderid = folderid;
//	getObj('search_text').value = '';
	switch(folderid)
	{
		case 1:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_ALLMAILS']; ?>
</b>';
			break;
		case 2:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_TO_CONTACTS']; ?>
</b>';
			break;
		case 3:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_TO_ACCOUNTS']; ?>
</b>';
			break;
		case 4:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_TO_LEADS']; ?>
</b>';
			break;
		case 5:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_TO_USERS']; ?>
</b>';
			break;
		case 6:
			getObj('mail_fldrname').innerHTML = '<b><?php echo $this->_tpl_vars['MOD']['LBL_QUAL_CONTACT']; ?>
</b>';
	}
	
	new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                method: 'post',
                postBody: 'module=Emails&ajax=true&action=EmailsAjax&file=ListView&folderid='+folderid,
                onComplete: function(response) {
                                        $("status").style.display="none";
                                        if(gFolderid == folderid)
                                        {
                                                gselectedrowid = 0;
                                                $("email_con").innerHTML=response.responseText;
						$('EmailDetails').innerHTML = '<table valign="top" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td class="forwardBg"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td colspan="2">&nbsp;</td></tr></tbody></table></td></tr><tr><td style="padding-top:10px;" bgcolor="#ffffff" height="300" valign="top"></td></tr></tbody></table>';
						$("subjectsetter").innerHTML='';
                                                execJS($('email_con'));
                                        }
                                        else
                                        {
                                                $('EmailDetails').innerHTML = '<table valign="top" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td class="forwardBg"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td colspan="2">&nbsp;</td></tr></tbody></table></td></tr><tr><td style="padding-top:10px;" bgcolor="#ffffff" height="300" valign="top"></td></tr></tbody></table>';
                                                $("subjectsetter").innerHTML='';
                                                $("email_con").innerHTML=response.responseText;
                                                execJS($('email_con'));
                                        }
                                }
                        }
	);

}
</script>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="JavaScript" type="text/javascript" src="modules/Emails/Emails.js"></script>
<link rel="stylesheet" type="text/css" href="themes/<?php echo $this->_tpl_vars['theme']; ?>
/webmail.css">
<div id="mailconfchk" class="small" style="position:absolute;display:none;left:350px;top:160px;height:27px;white-space:nowrap;z-index:10000007px;"><font color='red'><b><?php echo $this->_tpl_vars['MOD']['LBL_CONFIGURE_MAIL_SETTINGS']; ?>
.<br> <?php echo $this->_tpl_vars['APP']['LBL_PLEASE_CLICK']; ?>
 <a href="index.php?module=Users&action=AddMailAccount&record=<?php echo $this->_tpl_vars['USERID']; ?>
"><?php echo $this->_tpl_vars['APP']['LBL_HERE']; ?>
</a> <?php echo $this->_tpl_vars['APP']['LBL_TO_CONFIGURE']; ?>
</b></font></div>
<!-- Shadow starts here -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" height="100%">
	<tr>
		<td valign=top align=right><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

		<td class="showPanelBg" valign="top" width="95%" align=center >
		<!-- Email Client starts here -->
			<br>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="mailClient">
				<tr>
					<td class="mailClientBg" width="7">&nbsp;</td>
					<td class="mailClientBg">
					<form name="massdelete" method="POST">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<!-- Compose, Settings and Name image -->
							<tr>
								<td colspan="3" style="vertical-align:middle;">
									<table border=0 cellspacing=0 cellpadding=0 width=100%>
									<tr>
									<td align=left>
									
										<table cellpadding="5" cellspacing="0" border="0">
											<tr>
												<td nowrap style="padding-left:20px;padding-right:20px" class=small>
												<img src="<?php echo vtiger_imageurl('compose.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />
							&nbsp;<a href="javascript:;" onClick="OpenCompose('','create');" ><?php echo $this->_tpl_vars['MOD']['LBL_COMPOSE']; ?>
</a>
												</td>
												<td nowrap style="padding-left:20px;padding-right:20px" class=small>
												<img src="<?php echo vtiger_imageurl('webmail_settings.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />
							&nbsp;<a href="index.php?module=Users&action=AddMailAccount&record=<?php echo $this->_tpl_vars['USERID']; ?>
" ><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a>
												</td>
											</tr>
											</table>
										</td>
										<td align=right>
											<table >
											<tr>
												<td class="componentName" align=right><?php echo $this->_tpl_vars['MOD']['LBL_VTIGER_EMAIL_CLIENT']; ?>
<!-- <img src="<?php echo vtiger_imageurl('titleMailClient.gif', $this->_tpl_vars['THEME']); ?>
" align="right"/> --></td>
											</tr>
											</table>
									</td>
									</tr>
									</table>
									
								</td>
							</tr>
							<!-- Columns -->
							<tr>
							<td width="18%" class="big mailSubHeader" ><b><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_FOLDERS']; ?>
</b></td>
							<td>&nbsp;</td>
							<td width="82%" class="big mailSubHeader" align="left"><span id="mail_fldrname"><b><?php echo $this->_tpl_vars['MOD']['LBL_ALLMAILS']; ?>
</b></span></td>
							</tr>
							
							<tr>
								<td rowspan="6" class="MatrixLayer1" valign="top" bgcolor="#FFFFFF" style="padding:5px; " align="left" >
								<!-- Mailbox Tree -->
								<!-- Inbox -->
								<img src="<?php echo vtiger_imageurl('folder_.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;<b class="txtGreen"><?php echo $this->_tpl_vars['MOD']['LBL_INBOX']; ?>
</b>
								<ul style="list-style-type:none;margin-left:10px;margin-top:5px;padding:2px">
									<li><img src="<?php echo vtiger_imageurl('folder.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
										<a href="javascript:;" onClick="ShowFolders(6)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_QUAL_CONTACT']; ?>
</a>&nbsp;<b></b>
									</li>
									<li><img src="<?php echo vtiger_imageurl('mymail.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="gotoWebmail();" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_MY_MAILS']; ?>
</a>&nbsp;<b></b>
									</li>
								</ul>
								<!-- Sent mail -->
								<img src="<?php echo vtiger_imageurl('sentmail.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;<b class="txtGreen"><?php echo $this->_tpl_vars['MOD']['LBL_SENT_MAILS']; ?>
</b>
								<ul style="list-style-type:none;margin-left:10px;margin-top:5px;padding:2px">
									<li><img src="<?php echo vtiger_imageurl('folder1.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="ShowFolders(1)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_ALLMAILS']; ?>
</a>&nbsp;<b></b>
									<li><img src="<?php echo vtiger_imageurl('folder1.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="ShowFolders(2)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_TO_CONTACTS']; ?>
</a>&nbsp;<b></b>
									</li>
									<li><img src="<?php echo vtiger_imageurl('folder1.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="ShowFolders(3)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_TO_ACCOUNTS']; ?>
</a>&nbsp;<b></b>
									</li>
									<li><img src="<?php echo vtiger_imageurl('folder1.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="ShowFolders(4)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_TO_LEADS']; ?>
</a>&nbsp;
									</li>
									<li><img src="<?php echo vtiger_imageurl('folder1.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" />&nbsp;&nbsp;
									<a href="javascript:;" onClick="ShowFolders(5)" class="webMnu"><?php echo $this->_tpl_vars['MOD']['LBL_TO_USERS']; ?>
</a>&nbsp;
									</li>
								</ul>
								</td>
								<!-- All mails pane -->
								<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td class="hdrNameBg">
									<!-- Command Buttons and Search Email -->
									<table width="100%"  border="0" cellspacing="0" cellpadding="2">
									<input name="idlist" type="hidden">
										<tr>
											<td width="30%" align="left"><input type="button" name="Button2" value=" <?php echo $this->_tpl_vars['APP']['LBL_DELETE_BUTTON']; ?>
"  class="crmbutton small delete" onClick="return massDelete();"/> &nbsp;</td>
											<td width="40%" align="right" class="small">
												<font color="#000000"><?php echo $this->_tpl_vars['APP']['LBL_SEARCH']; ?>
</font>&nbsp;<input type="text" name="search_text" id="search_text" class="importBox" >&nbsp;
											</td>
											<td width="20%" align=left class="small">
												<select name="search_field" id="search_field" onChange="Searchfn();" class="importBox">
												<option value='subject'><?php echo $this->_tpl_vars['MOD']['LBL_IN_SUBJECT']; ?>
</option>
												<option value='user_name'><?php echo $this->_tpl_vars['MOD']['LBL_IN_SENDER']; ?>
</option>
												<option value='join'><?php echo $this->_tpl_vars['MOD']['LBL_IN_SUBJECT_OR_SENDER']; ?>
</option>
												</select>&nbsp;
											</td>
											<td width="10%">
					<input name="find" value=" Find " class="crmbutton small create" onclick="Searchfn();" type="button">
				</td>
										</tr>
									</table>
									
								</td>
							</tr>
							<!-- Mail Subject Headers list -->
							<tr>
								<td>&nbsp;</td>
								<td align="left">
									<div id="email_con">
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "EmailContents.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
								</td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
								<td valign="top">
									<div id="EmailDetails"> 
									<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "EmailDetails.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
									</div>
								</td>
							</tr>
						</table>
						</form>
						<br>
					</td>
					<td class="mailClientBg" width="7">&nbsp;</td>
				</tr>
				<!-- <tr>
					<td width="7" height="8" style="font-size:1px;font-family:Arial, Helvetica, sans-serif;"><img src="<?php echo vtiger_imageurl('bottom_left.jpg', $this->_tpl_vars['THEME']); ?>
" align="bottom"  /></td>
					<td bgcolor="#ECECEC" height="8" style="font-size:1px;" ></td>
					<td width="8" height="8" style="font-size:1px;font-family:Arial, Helvetica, sans-serif;"><img src="<?php echo vtiger_imageurl('bottom_right.jpg', $this->_tpl_vars['THEME']); ?>
" align="bottom" /></td>
				</tr>-->
			</table><br/>
		</td>
		<td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
		
		
	</tr>
</table>
<!-- END -->
