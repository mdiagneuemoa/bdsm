<?php /* Smarty version 2.6.18, created on 2010-03-02 15:54:32
         compiled from ReportRunContents.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'ReportRunContents.tpl', 27, false),)), $this); ?>


<br>
<!--
<table align="center" border="0" cellpadding="5" cellspacing="0" width="100%" class="mailSubHeader">
	<tbody><tr>
	<td align="left" nowrap ><input class="crmbutton small create" id="btnExport" name="btnExport" value="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTPDF_BUTTON']; ?>
" type="button" onClick="goToURL(CrearEnlace('CreatePDF',<?php echo $this->_tpl_vars['REPORTID']; ?>
));" title="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTPDF_BUTTON']; ?>
"></td>
	<td align="left" nowrap ><input class="crmbutton small create" id="btnExport" name="btnExport" value="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTXL_BUTTON']; ?>
" type="button" onClick="goToURL(CrearEnlace('CreateXL',<?php echo $this->_tpl_vars['REPORTID']; ?>
));" title="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTXL_BUTTON']; ?>
" ></td>
	<td align="left" width="100%"><input name="PrintReport" value="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_REPORT']; ?>
" onClick="goToPrintReport(<?php echo $this->_tpl_vars['REPORTID']; ?>
);" class="crmbutton small create" type="button"></td>
	</tr>
	</tbody>
</table>
-->
<table style="border: 1px solid rgb(0, 0, 0);"  align="center" cellpadding="0" cellspacing="0" width="95%">
	<tbody><tr>
	<td style="background-repeat: repeat-y;" background="<?php echo vtiger_imageurl('report_btn.gif', $this->_tpl_vars['THEME']); ?>
" width="16"></td>

	<td style="padding: 5px;" valign="top">
	<table cellpadding="0" cellspacing="0" width="100%" >
		<tbody><tr>
		<td align="left" width="75%">
		<span class="genHeaderGray">
		<?php if ($this->_tpl_vars['MOD'][$this->_tpl_vars['REPORTNAME']] != ''): ?>
			<?php echo $this->_tpl_vars['MOD'][$this->_tpl_vars['REPORTNAME']]; ?>

		<?php else: ?>
			<?php echo $this->_tpl_vars['REPORTNAME']; ?>

		<?php endif; ?>
		</span><br>
		</td>
		<td align="right" width="25%">
		<span class="genHeaderGray"><?php echo $this->_tpl_vars['APP']['LBL_TOTAL']; ?>
 : <?php echo $this->_tpl_vars['REPORTHTML']['1']; ?>
  <?php echo $this->_tpl_vars['APP']['LBL_RECORDS']; ?>
</span>
		</td>
		</tr>
		<tr><td id="report_info" align="left" colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<td colspan="2">
		<?php if ($this->_tpl_vars['ERROR_MSG'] == ''): ?>
		<?php echo $this->_tpl_vars['REPORTHTML']['0']; ?>

		<?php else: ?>
		<?php echo $this->_tpl_vars['ERROR_MSG']; ?>

		<?php endif; ?>
		</td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2" ><?php echo $this->_tpl_vars['REPORTTOTHTML']; ?>
</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</tbody>
	</table>
	</td>
	<td style="background-repeat: repeat-y;" background="<?php echo vtiger_imageurl('report_btn.gif', $this->_tpl_vars['THEME']); ?>
" width="16"></td>
	</tr>

	</tbody>
</table>
<!--
<table align="center" border="0" cellpadding="5" cellspacing="0" width="100%" class="mailSubHeader">
	<tbody><tr>
	<td align="left" nowrap ><input class="crmbutton small create" id="btnExport" name="btnExport" value="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTPDF_BUTTON']; ?>
" type="button" onClick="goToURL(CrearEnlace('CreatePDF',<?php echo $this->_tpl_vars['REPORTID']; ?>
));" title="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTPDF_BUTTON']; ?>
"></td>
	<td align="left" nowrap ><input class="crmbutton small create" id="btnExport" name="btnExport" value="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTXL_BUTTON']; ?>
" type="button" onClick="goToURL(CrearEnlace('CreateXL',<?php echo $this->_tpl_vars['REPORTID']; ?>
));" title="<?php echo $this->_tpl_vars['MOD']['LBL_EXPORTXL_BUTTON']; ?>
" ></td>
	<td align="left" width=100% nowrap><input name="PrintReport" value="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_REPORT']; ?>
" class="crmbutton small create" onClick="goToPrintReport(<?php echo $this->_tpl_vars['REPORTID']; ?>
);" type="button"></td>
	</tr>
	</tbody>
</table>
-->