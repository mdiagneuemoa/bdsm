<?php /* Smarty version 2.6.18, created on 2009-09-27 12:25:07
         compiled from RelatedListContents.tpl */ ?>

<script type='text/javascript' src='include/js/Mail.js'></script>
<?php if ($this->_tpl_vars['SinglePane_View'] == 'true'): ?>
	<?php $this->assign('return_modname', 'DetailView'); ?>
<?php else: ?>
	<?php $this->assign('return_modname', 'CallRelatedList'); ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['ACCOUNTID'] != ''): ?>
	<?php $this->assign('search_string', "&fromPotential=true&acc_id=".($this->_tpl_vars['ACCOUNTID'])); ?>
<?php endif; ?>
<?php $_from = $this->_tpl_vars['RELATEDLISTS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>

<?php $this->assign('rel_mod', $this->_tpl_vars['header']); ?>
<?php $this->assign('HEADERLABEL', $this->_tpl_vars['header']); ?>
<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['header']] != ''): ?>
	<?php $this->assign('HEADERLABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['header']]); ?>
<?php endif; ?>
<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="border-bottom:1px solid #999999;padding:5px;">
        <tr>
                <td  valign=bottom><b><?php echo $this->_tpl_vars['HEADERLABEL']; ?>
</b> <?php if ($this->_tpl_vars['MODULE'] == 'Campaigns' && ( $this->_tpl_vars['rel_mod'] == 'Contacts' || $this->_tpl_vars['rel_mod'] == 'Leads' )): ?><br><br><?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
: <a href="javascript:;" onclick="clear_checked_all('<?php echo $this->_tpl_vars['rel_mod']; ?>
');"><?php echo $this->_tpl_vars['APP']['LBL_NONE_NO_LINE']; ?>
</a><?php endif; ?> </td>
                <?php if ($this->_tpl_vars['detail'] != ''): ?>
                <td align=center><?php echo $this->_tpl_vars['detail']['navigation']['0']; ?>
</td>
                <?php echo $this->_tpl_vars['detail']['navigation']['1']; ?>

                <?php endif; ?>
                <td align=right>
			
			<?php echo $this->_tpl_vars['detail']['CUSTOM_BUTTON']; ?>


			<?php if ($this->_tpl_vars['header'] == 'Potentials'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Potentials&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">	
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
                                        <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Potentials';this.form.return_action.value='updateRelations'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
">
				<?php elseif ($this->_tpl_vars['MODULE'] != 'Services'): ?>
	                                <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Potentials'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Potential']; ?>
">
				<?php endif; ?>
                </td>
            <?php elseif ($this->_tpl_vars['header'] == 'Products'): ?>
                <?php if ($this->_tpl_vars['MODULE'] == 'PriceBooks'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_PRODUCT_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_PRODUCT_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_PRODUCT_BUTTON_LABEL']; ?>
" LANGUAGE=javascript onclick="this.form.action.value='AddProductsToPriceBook';this.form.module.value='Products';this.form.return_module.value='Products';this.form.return_action.value='PriceBookDetailView'"  type="submit" name="button"></td>
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Contacts'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Potentials'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessKey="" class="crmbutton small save" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">&nbsp;
					<!-- input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" accessyKey="F" class="crmbutton small save" onclick="this.form.action.value='EditView';this.form.module.value='Products';this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
"></td -->

				<?php elseif ($this->_tpl_vars['MODULE'] == 'Vendors'): ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessyKey="F" class="crmbutton small create" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=Vendors&action=Popup&return_action=<?php echo $this->_tpl_vars['return_modname']; ?>
&popuptype=detailview&select=enable&form=DetailView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
">
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Products';this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.parent_id.value='';" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
"></td>
                                <?php else: ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Products';this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
';this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
"></td>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Leads'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_SEND_MAIL_BUTTON']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SEND_MAIL_BUTTON']; ?>
" type="button"  name="button" onclick="rel_eMail('<?php echo $this->_tpl_vars['MODULE']; ?>
',this,'<?php echo $this->_tpl_vars['rel_mod']; ?>
')">
				<?php echo $this->_tpl_vars['LEADCVCOMBO']; ?>
<input title="<?php echo $this->_tpl_vars['MOD']['LBL_LOAD_LIST']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['MOD']['LBL_LOAD_LIST']; ?>
" type="button"  name="button" onclick="loadCvList('Leads','<?php echo $this->_tpl_vars['ID']; ?>
')">
				<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_LEAD_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_LEAD_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Leads']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Leads&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php endif; ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_LEAD_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_LEAD_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Leads']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Leads&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php elseif ($this->_tpl_vars['MODULE'] != 'Services'): ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Lead']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Leads'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Lead']; ?>
"></td>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Accounts'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Products'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Account']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Account']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Account']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Contacts'): ?>
				<?php if (( $this->_tpl_vars['MODULE'] == 'Calendar' || $this->_tpl_vars['MODULE'] == 'Potentials' || $this->_tpl_vars['MODULE'] == 'Vendors' )): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Contacts']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Contacts&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
<?php echo $this->_tpl_vars['search_string']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button"></td>
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_BULK_MAILS']; ?>
" accessykey="F" class="crmbutton small create" onclick="this.form.action.value='sendmail';this.form.return_action.value='DetailView';this.form.module.value='Emails';this.form.return_module.value='Emails';" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_BULK_MAILS']; ?>
" type="submit">&nbsp;
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small create" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Contacts&return_module=Emails&action=Popup&popuptype=detailview&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button"></td>
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_SEND_MAIL_BUTTON']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SEND_MAIL_BUTTON']; ?>
" type="button"  name="button" onclick="rel_eMail('<?php echo $this->_tpl_vars['MODULE']; ?>
',this,'<?php echo $this->_tpl_vars['rel_mod']; ?>
')">
					<?php echo $this->_tpl_vars['CONTCVCOMBO']; ?>
<input title="<?php echo $this->_tpl_vars['MOD']['LBL_LOAD_LIST']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['MOD']['LBL_LOAD_LIST']; ?>
" type="button"  name="button" onclick="loadCvList('Contacts','<?php echo $this->_tpl_vars['ID']; ?>
')">
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Contacts']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Contacts&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
"></td>
				<?php elseif ($this->_tpl_vars['MODULE'] == 'Products'): ?>
					<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_CONTACT_BUTTON_LABEL']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Contacts']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Contacts&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
				<?php elseif ($this->_tpl_vars['MODULE'] != 'Services'): ?>
					<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Contact']; ?>
"></td>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Activities'): ?>
				&nbsp;
				<input type="hidden" name="activity_mode">
				<?php if ($this->_tpl_vars['MODULE'] == 'PurchaseOrder' || $this->_tpl_vars['MODULE'] == 'Invoice' || $this->_tpl_vars['MODULE'] == 'SalesOrder' || $this->_tpl_vars['MODULE'] == 'Quotes' || $this->_tpl_vars['MODULE'] == 'Campaigns'): ?>
					<?php if ($this->_tpl_vars['TODO_PERMISSION'] == 'true'): ?>
					  	<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Calendar'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.activity_mode.value='Task'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
">
					<?php endif; ?>
				<?php else: ?>
					<?php if ($this->_tpl_vars['TODO_PERMISSION'] == 'true' && $this->_tpl_vars['MODULE'] != 'Contacts'): ?>
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Calendar'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.activity_mode.value='Task'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
">&nbsp;
					<?php else: ?>

						<?php if ($this->_tpl_vars['MODULE'] == 'Contacts' && $this->_tpl_vars['CONTACT_PERMISSION'] == 'true'): ?>
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Calendar'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.activity_mode.value='Task'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Todo']; ?>
">&nbsp;
						<?php endif; ?>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['EVENT_PERMISSION'] == 'true' || $this->_tpl_vars['MODULE'] == 'Contacts'): ?>
						<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Event']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Calendar'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.activity_mode.value='Events'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Event']; ?>
">
					<?php endif; ?>
				<?php endif; ?>
				</td>
			<?php elseif ($this->_tpl_vars['header'] == 'Campaigns'): ?>
                                <input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Campaigns']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Campaigns']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Campaigns']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Campaigns&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button"></td>
			<?php elseif ($this->_tpl_vars['header'] == 'Quotes'): ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Quote']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Quotes'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Quote']; ?>
"></td>
			<?php elseif ($this->_tpl_vars['header'] == 'Invoice'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'SalesOrder'): ?>
				<input type="hidden">
				<?php else: ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_Invoice']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Invoice'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_Invoice']; ?>
"></td>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Sales Order'): ?>
				<?php if ($this->_tpl_vars['MODULE'] == 'Quotes'): ?>
				<input type="hidden">
				<?php else: ?>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_SalesOrder']; ?>
" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_SalesOrder']; ?>
"></td>
				<?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Purchase Order'): ?>
                    <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_PurchaseOrder']; ?>
" accessyKey="O" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.module.value='PurchaseOrder'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['SINGLE_PurchaseOrder']; ?>
"></td>
            <?php elseif ($this->_tpl_vars['header'] == 'Emails'): ?>
                    <input type="hidden" name="email_directing_module">
                    <input type="hidden" name="record">
					<?php if ($this->_tpl_vars['PERMIT'] == '0'): ?>
                            <?php if ($this->_tpl_vars['MAIL_CHECK'] == 'true'): ?>
                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
" accessyKey="F" class="crmbutton small create" onclick="fnvshobj(this,'sendmail_cont');sendmail('<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
);" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
"></td>
							<?php else: ?>
                            <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
" accessyKey="F" class="crmbutton small create" onclick="OpenCompose('','create');" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
"></td>
                            <?php endif; ?>
                	<?php else: ?>
                        <input title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
" accessyKey="F" class="crmbutton small create" onclick="fnvshobj(this,'sendmail_cont');sendmail('<?php echo $this->_tpl_vars['MODULE']; ?>
',<?php echo $this->_tpl_vars['ID']; ?>
);" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Email']; ?>
"></td>
                    <?php endif; ?>
			<?php elseif ($this->_tpl_vars['header'] == 'Users'): ?>
                    <?php if ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
						<input title="Change" accessKey="" tabindex="2" type="button" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_USER_BUTTON_LABEL']; ?>
" name="button" LANGUAGE=javascript onclick='return window.open("index.php?module=Users&return_module=Calendar&return_action=<?php echo $this->_tpl_vars['return_modname']; ?>
&activity_mode=Events&action=Popup&popuptype=detailview&form=EditView&form_submit=true&select=enable&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&recordid=<?php echo $this->_tpl_vars['ID']; ?>
","test","width=640,height=525,resizable=0,scrollbars=0")';>
                    <?php elseif ($this->_tpl_vars['MODULE'] == 'Emails'): ?>
                        <input title="<?php echo $this->_tpl_vars['APP']['LBL_BULK_MAILS']; ?>
" accessykey="F" class="crmbutton small create" onclick="this.form.action.value='sendmail';this.form.return_action.value='DetailView';this.form.module.value='Emails';this.form.return_module.value='Emails';" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_BULK_MAILS']; ?>
" type="submit">&nbsp;
                        <input title="Change" accesskey="" tabindex="2" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_USER_BUTTON_LABEL']; ?>
" name="Button" language="javascript" onclick='return window.open("index.php?module=Users&return_module=Emails&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=true&return_id=<?php echo $this->_tpl_vars['ID']; ?>
&recordid=<?php echo $this->_tpl_vars['ID']; ?>
","test","width=640,height=520,resizable=0,scrollbars=0");' type="button">&nbsp;</td>
                    <?php endif; ?>
            <?php elseif ($this->_tpl_vars['header'] == 'Activity History'): ?>
                    &nbsp;</td>
			<?php elseif ($this->_tpl_vars['header'] == 'Product Bundles'): ?>
					<?php if ($this->_tpl_vars['MODULE'] == 'Products' && $this->_tpl_vars['IS_MEMBER'] == 0): ?>
						<input alt="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" accessKey="" class="crmbutton small create" value="<?php echo $this->_tpl_vars['APP']['LBL_ADD_NEW']; ?>
 <?php echo $this->_tpl_vars['APP']['Product']; ?>
" onClick="this.form.action.value='EditView'; this.form.return_action.value='<?php echo $this->_tpl_vars['return_modname']; ?>
'; this.form.module.value='Products'; this.form.return_module.value='<?php echo $this->_tpl_vars['MODULE']; ?>
'; this.form.return_viewname.value='<?php echo $this->_tpl_vars['NAME']; ?>
'; this.form.return_id.value='<?php echo $this->_tpl_vars['ID']; ?>
';" type="submit"  name="button">
						<input alt="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" title="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" accessKey="" class="crmbutton small edit" value="<?php echo $this->_tpl_vars['APP']['LBL_SELECT_BUTTON_LABEL']; ?>
 <?php echo $this->_tpl_vars['APP']['Products']; ?>
" LANGUAGE=javascript onclick='return window.open("index.php?module=Products&return_module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=<?php echo $this->_tpl_vars['ID']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
","test","width=640,height=602,resizable=0,scrollbars=0");' type="button"  name="button">
					<?php endif; ?>
            <?php endif; ?>
        </tr>
</table>
<?php $this->assign('check_status', $this->_tpl_vars['detail']); ?>
<?php if ($this->_tpl_vars['detail'] != '' && $this->_tpl_vars['detail']['header'] != ''): ?>
	<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
		<?php if ($this->_tpl_vars['header'] == 'header'): ?>
			<table border=0 cellspacing=1 cellpadding=3 width=100% style="background-color:#eaeaea;" class="small">
				<tr style="height:25px" bgcolor=white>
                                <?php if ($this->_tpl_vars['MODULE'] == 'Campaigns' && ( $this->_tpl_vars['rel_mod'] == 'Contacts' || $this->_tpl_vars['rel_mod'] == 'Leads' )): ?>
                                        <td class="lvtCol"><input name ="<?php echo $this->_tpl_vars['rel_mod']; ?>
_selectall" onclick="rel_toggleSelect(this.checked,'<?php echo $this->_tpl_vars['rel_mod']; ?>
_selected_id','<?php echo $this->_tpl_vars['rel_mod']; ?>
');"  type="checkbox"></td>
                                <?php endif; ?>
				<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['headerfields']):
?>
					<td class="lvtCol"><?php echo $this->_tpl_vars['headerfields']; ?>
</td>
				<?php endforeach; endif; unset($_from); ?>
                                </tr>
		<?php elseif ($this->_tpl_vars['header'] == 'entries'): ?>
			<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
				<tr bgcolor=white>
                                <?php if ($this->_tpl_vars['MODULE'] == 'Campaigns' && ( $this->_tpl_vars['rel_mod'] == 'Contacts' || $this->_tpl_vars['rel_mod'] == 'Leads' )): ?>
                                        <td><input name="<?php echo $this->_tpl_vars['rel_mod']; ?>
_selected_id" id="<?php echo $this->_tpl_vars['header']; ?>
" value="<?php echo $this->_tpl_vars['header']; ?>
" onclick="rel_check_object(this,'<?php echo $this->_tpl_vars['rel_mod']; ?>
');" toggleselectall(this.name,="" selectall="" )="" type="checkbox"  <?php echo $this->_tpl_vars['check_status']['checked'][$this->_tpl_vars['header']]; ?>
></td>
                                <?php endif; ?>
				<?php $_from = $this->_tpl_vars['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['listfields']):
?>
	                                 <td><?php echo $this->_tpl_vars['listfields']; ?>
</td>
				<?php endforeach; endif; unset($_from); ?>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<table style="background-color:#eaeaea;color:#000000" border="0" cellpadding="3" cellspacing="1" width="100%" class="small">
		<tr style="height: 25px;" bgcolor="white">
			<td><i><?php echo $this->_tpl_vars['APP']['LBL_NONE_INCLUDED']; ?>
</i></td>
		</tr>
	</table>
<?php endif; ?>
<br><br>
<?php if ($this->_tpl_vars['MODULE'] == 'Campaigns' && ( $this->_tpl_vars['rel_mod'] == 'Contacts' || $this->_tpl_vars['rel_mod'] == 'Leads' )): ?>
<script>
rel_default_togglestate('<?php echo $this->_tpl_vars['rel_mod']; ?>
');
</script>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>