<?php /* Smarty version 2.6.18, created on 2009-09-08 19:17:19
         compiled from AddMailAccount.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'AddMailAccount.tpl', 17, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">

<tr>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
        <td class="showPanelBg" valign="top" width="100%">
                <div class="small" style="padding: 10px;">
                        <span class="lvtHeaderText"><?php echo $this->_tpl_vars['MOD']['LBL_MY_MAIL_SERVER_DET']; ?>
</span> <br>
                        <hr noshade="noshade" size="1"><br>

  		<form action="index.php" method="post" name="EditView" id="form">
			<input type="hidden" name="module" value="Users">
		  	<input type="hidden" name="action">
  			<input type="hidden" name="server_type" value="email">
			<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
		        <input type="hidden" name="edit" value="<?php echo $this->_tpl_vars['EDIT']; ?>
">
			<input type="hidden" name="return_module" value="Settings">
			<input type="hidden" name="return_action" value="index">
			<input type="hidden" name="changepassword" value="">
</tr>	
		
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
                  <tr>

                        <td>
                            <table class="small" border="0" cellpadding="3" cellspacing="0" width="100%">
                                <tr>
                                    <td class="dvtTabCache" style="width: 10px;" nowrap="nowrap">&nbsp;</td>
                                    <td class="dvtSelectedCell" style="width: 100px;" align="center" nowrap="nowrap"><b><?php echo $this->_tpl_vars['MOD']['LBL_MY_MAIL_SERVER_DET']; ?>
 </b></td>
		                    <td class="dvtTabCache" nowrap="nowrap">&nbsp;</td>
                                </tr>

                            </table>
                        </td>
                </tr>
                <tr>
                        <td align="left" valign="top">

<!-- General Contents for Mail Server Starts Here -->

<table class="dvtContentSpace" border="0" cellpadding="3" cellspacing="0" width="100%">
<tr>
   <td align="left">
     <table border="0" cellpadding="0" cellspacing="0" width="100%">
       <tr>
          <td style="padding: 10px;"><table width="100%"  border="0" cellspacing="0" cellpadding="5">
       <tr>
           <td colspan="3" class="detailedViewHeader"><b><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_ID']; ?>
</b></td>
       </tr>
       <tr>
          <td class="dvtCellLabel" align="right" width="33%"><?php echo $this->_tpl_vars['MOD']['LBL_DISPLAY_NAME']; ?>
</td>
          <td class="dvtCellInfo" width="33%"><input type="text" name="displayname" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['DISPLAYNAME']; ?>
"/></td>
          <td class="dvtCellInfo" width="34%"><?php echo $this->_tpl_vars['MOD']['LBL_NAME_EXAMPLE']; ?>
</td>
       </tr>
       <tr>
          <td class="dvtCellLabel" align="right"><FONT class="required" color="red"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</FONT> <?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_ADDRESS']; ?>
 </td>
          <td class="dvtCellInfo"><input type="text" name="email" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" value="<?php echo $this->_tpl_vars['EMAIL']; ?>
"/></td>
          <td class="dvtCellInfo"><?php echo $this->_tpl_vars['MOD']['LBL_EMAIL_EXAMPLE']; ?>
</td>
       </tr>
       <tr><td colspan="3" >&nbsp;</td></tr>
       <tr>
          <td colspan="3"  class="detailedViewHeader"><b><?php echo $this->_tpl_vars['MOD']['LBL_INCOME_SERVER_SETTINGS']; ?>
</b></td>
       </tr>
       <tr>
          <td class="dvtCellLabel" align="right"><FONT class="required" color="red"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</FONT><?php echo $this->_tpl_vars['MOD']['LBL_MAIL_SERVER_NAME']; ?>
</td>
          <td class="dvtCellInfo"><input type="text" name="mail_servername" value="<?php echo $this->_tpl_vars['SERVERNAME']; ?>
"  class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'"/></td>
          <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td class="dvtCellLabel" align="right"><FONT class="required" color="red"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</FONT><?php echo $this->_tpl_vars['APP']['LBL_LIST_USER_NAME']; ?>
</td>
           <td class="dvtCellInfo"><input type="text" name="server_username" value="<?php echo $this->_tpl_vars['SERVERUSERNAME']; ?>
"  class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'"/></td>
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td class="dvtCellLabel" align="right"><FONT class="required" color="red"><?php echo $this->_tpl_vars['APP']['LBL_REQUIRED_SYMBOL']; ?>
</FONT><?php echo $this->_tpl_vars['MOD']['LBL_LIST_PASSWORD']; ?>
</td>
           <td class="dvtCellInfo"> <?php echo $this->_tpl_vars['CHANGE_PW_BUTTON']; ?>
</td>
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td colspan="3" class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_MAIL_PROTOCOL']; ?>
</td>
           <td class="dvtCellInfo">
		<!-- <input type="radio" name="mailprotocol" value="pop3" <?php echo $this->_tpl_vars['POP3']; ?>
/>&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_POP']; ?>
 <font color="red">* *</font>&nbsp;
		<input type="radio" name="mailprotocol" value="imap" <?php echo $this->_tpl_vars['IMAP']; ?>
/>&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_IMAP']; ?>
 <font color="red">* *</font>&nbsp; -->
		<input type="radio" name="mailprotocol" value="imap2" <?php echo $this->_tpl_vars['IMAP2']; ?>
/>&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_IMAP2']; ?>

		<input type="radio" name="mailprotocol" value="IMAP4" <?php echo $this->_tpl_vars['IMAP4']; ?>
/>&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_IMAP4']; ?>

	   </td>	
           <td class="dvtCellInfo">&nbsp;</td>
        </tr>
        <tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_SSL_OPTIONS']; ?>
</td>
           <td class="dvtCellInfo">
		<input type="radio" name="ssltype" value="notls" <?php echo $this->_tpl_vars['NOTLS']; ?>
 />&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_NO_TLS']; ?>

		<input type="radio" name="ssltype" value="tls" <?php echo $this->_tpl_vars['TLS']; ?>
 />&nbsp; <?php echo $this->_tpl_vars['MOD']['LBL_TLS']; ?>

		<input type="radio" name="ssltype" value="ssl" <?php echo $this->_tpl_vars['SSL']; ?>
 />&nbsp; <?php echo $this->_tpl_vars['MOD']['LBL_SSL']; ?>
 </td>
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_CERT_VAL']; ?>
</td>
           <td class="dvtCellInfo">
		<input type="radio" name="sslmeth" value="validate-cert" <?php echo $this->_tpl_vars['VALIDATECERT']; ?>
 />&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_VAL_SSL_CERT']; ?>

		<input type="radio" name="sslmeth" value="novalidate-cert" <?php echo $this->_tpl_vars['NOVALIDATECERT']; ?>
 />&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_DONOT_VAL_SSL_CERT']; ?>

	   </td>	
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <!--<tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_INT_MAILER']; ?>
</td>
           <td class="dvtCellInfo">
		<input type="radio" name="int_mailer" value="1" <?php echo $this->_tpl_vars['INT_MAILER_USE']; ?>
 />&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_INT_MAILER_USE']; ?>

		<input type="radio" name="int_mailer" value="0" <?php echo $this->_tpl_vars['INT_MAILER_NOUSE']; ?>
 />&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_INT_MAILER_NOUSE']; ?>

	   </td>	
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>-->
       <tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_REFRESH_TIMEOUT']; ?>
</td>
           <td class="dvtCellInfo">
		<select value="<?php echo $this->_tpl_vars['BOX_REFRESH']; ?>
" name="box_refresh">
			<option value="60000" <?php echo $this->_tpl_vars['BOX_OPT1']; ?>
><?php echo $this->_tpl_vars['MOD']['LBL_1_MIN']; ?>
</option>
			<option value="120000" <?php echo $this->_tpl_vars['BOX_OPT2']; ?>
><?php echo $this->_tpl_vars['MOD']['LBL_2_MIN']; ?>
</option>
			<option value="180000" <?php echo $this->_tpl_vars['BOX_OPT3']; ?>
><?php echo $this->_tpl_vars['MOD']['LBL_3_MIN']; ?>
</option>
			<option value="240000" <?php echo $this->_tpl_vars['BOX_OPT4']; ?>
><?php echo $this->_tpl_vars['MOD']['LBL_4_MIN']; ?>
</option>
			<option value="300000" <?php echo $this->_tpl_vars['BOX_OPT5']; ?>
><?php echo $this->_tpl_vars['MOD']['LBL_5_MIN']; ?>
</option>
		</select>
	   </td>
           <td class="dvtCellInfo">&nbsp;</td>
       </tr>
       <tr>
           <td class="dvtCellLabel" align="right"><?php echo $this->_tpl_vars['MOD']['LBL_EMAILS_PER_PAGE']; ?>
</td>
           <td class="dvtCellInfo"><input type="text" name="mails_per_page" value="<?php echo $this->_tpl_vars['MAILS_PER_PAGE']; ?>
" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'"/></td>
           <td class="dvtCellInfo">&nbsp;</td>
	</tr><tr>
	<td colspan='3' align='center'><?php echo $this->_tpl_vars['MOD']['LBL_MAIL_DISCLAIM']; ?>
</td>
       </tr>
       <tr><td colspan="3" style="border-bottom:1px dashed #CCCCCC;">&nbsp;</td></tr>
       <tr>
           <td colspan="3" align="center">
		<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='SaveMailAccount'; return verify_data(EditView)" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " >
			&nbsp;&nbsp;
	        <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
>" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="window.history.back()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
"></td>
           </td>
       </tr>
       <tr><td colspan="3" style="border-top:1px dashed #CCCCCC;">&nbsp;</td></tr>
       </table>
	   </td>
            </tr>

     </table></td>
     </tr>
</table>
</td></tr>
</table>
</form>
</td></tr>
</table>

<?php echo $this->_tpl_vars['JAVASCRIPT']; ?>
