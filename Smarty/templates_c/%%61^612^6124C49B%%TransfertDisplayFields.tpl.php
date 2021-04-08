<?php /* Smarty version 2.6.18, created on 2019-02-18 08:27:15
         compiled from TransfertDisplayFields.tpl */ ?>

<?php $this->assign('fromlink', ""); ?>
<script language="JavaScript" type="text/javascript" src="include/js/Inventory.js"></script>
<script language="javascript">
	function fnshowHide(currObj,txtObj)
	{
			if(currObj.checked == true)
				document.getElementById(txtObj).style.visibility = 'visible';
			else
				document.getElementById(txtObj).style.visibility = 'hidden';
	}
	
	function fntaxValidation(txtObj)
	{
			if (!numValidate(txtObj,"Tax","any"))
				document.getElementById(txtObj).value = 0;
	}	
	
	function fnpriceValidation(txtObj)
	{
		if (!numValidate(txtObj,"Price","any"))
			document.getElementById(txtObj).value = 0;
	}	

function delimage(id)
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Contacts&action=ContactsAjax&file=DelImage&recordid='+id,
			onComplete: function(response)
				    {
					if(response.responseText.indexOf("SUCCESS")>-1)
						$("replaceimage").innerHTML='<?php echo $this->_tpl_vars['APP']['LBL_IMAGE_DELETED']; ?>
';
					else
						alert("<?php echo $this->_tpl_vars['APP']['ERROR_WHILE_EDITING']; ?>
")
				    }
		}
	);

}

// Function to enable/disable related elements based on whether the current object is checked or not
function fnenableDisable(currObj,enableId)
{
	var disable_flag = true;
	if(currObj.checked == true)
		disable_flag = false;
	
	document.getElementById('curname'+enableId).disabled = disable_flag;
	document.getElementById('cur_reset'+enableId).disabled = disable_flag;
	document.getElementById('base_currency'+enableId).disabled = disable_flag;	
}

// Update current value with current value of base currency and the conversion rate
function updateCurrencyValue(currObj,txtObj,base_curid,conv_rate)
{
	var unit_price = $(base_curid).value;
	//if(currObj.checked == true)
	//{
		document.getElementById(txtObj).value = unit_price * conv_rate;
	//}
}

// Synchronize between Unit price and Base currency value.
function updateUnitPrice(from_cur_id, to_cur_id)
{
    var from_ele = document.getElementById(from_cur_id);
    if (from_ele == null) return;
    
    var to_ele = document.getElementById(to_cur_id);
    if (to_ele == null) return;

    to_ele.value = from_ele.value;
}

// Update hidden base currency value, everytime the base currency value is changed in multi-currency UI
function updateBaseCurrencyValue()
{
    var cur_list = document.getElementsByName('base_currency_input');
    if (cur_list == null) return;
    
    var base_currency_ele = document.getElementById('base_currency');
    if (base_currency_ele == null) return;
    
    for(var i=0; i<cur_list.length; i++) 
    {	
		var cur_ele = cur_list[i];
		if (cur_ele != null && cur_ele.checked == true)
    		base_currency_ele.value = cur_ele.value;
	}
}

</script>

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['subdata']):
?>
	<?php if ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TIERS_BANQUE2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Tiers'): ?>
	
		<tr id="banque2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="display: none;height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TIERS_BANQUE3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'Tiers'): ?>
		<tr id="banque3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="display: none;height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="banqueAgent2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="banqueAgent3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="banqueAgent4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK4']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_COORDONNEES_BANQUAIRES5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="banqueAgent5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_COORDBANK5']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_CONJOINT'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="conjointAgentfields_<?php echo $this->_tpl_vars['label']; ?>
" style=" <?php echo $this->_tpl_vars['DISPLAY_CONJOINT']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT1'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent1fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT1']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT2'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT3'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT4'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT4']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT5'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT5']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_AGENTS_DONNEES_FAMILLE_ENFANT6'] && $this->_tpl_vars['MODULE'] == 'Agentuemoa'): ?>
		<tr id="enfantAgent6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ENFANT6']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>	

	
<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_2'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
		<tr id="etab2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_CHOIX_ETABLISSEMENT_3'] && $this->_tpl_vars['MODULE'] == 'Candidats'): ?>
		<tr id="etab3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_ETABLISSEMENT3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>		
		
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="demande2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="demande3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="demande4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE4']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_DEMANDE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="demande5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_DEMANDE5']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	
		
		
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="lignebudget2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_3'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="lignebudget3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_4'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="lignebudget4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET4']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_LIGNE_BUDGETAIRE_5'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="lignebudget5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_LIGNEBUDGET5']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_FILE_JUSTIFICATIF_2'] && $this->_tpl_vars['MODULE'] == 'Demandes'): ?>
		<tr id="justif2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_JUSTIFS2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
		
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET2_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet2fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET2']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET3_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet3fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET3']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET4_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet4fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET4']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET5_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet5fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET5']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET6_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet6fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET6']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET7_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet7fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET7']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_TRAJET8_INFORMATION'] && $this->_tpl_vars['MODULE'] == 'OrdresMission'): ?>
		<tr id="trajet8fields_<?php echo $this->_tpl_vars['label']; ?>
" style="<?php echo $this->_tpl_vars['DISPLAY_TRAJET8']; ?>
 height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>		
	<?php elseif ($this->_tpl_vars['header'] == $this->_tpl_vars['MOD']['LBL_REUNION_DEPENSES'] && $this->_tpl_vars['MODULE'] == 'Reunion'): ?>
		<tr  style="display:none; height:25px">	
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
		</tr>	
		
	<?php elseif ($this->_tpl_vars['header'] == 'Product Details'): ?>
		<tr>
			<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'TransfertEditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endforeach; endif; unset($_from); ?>
	</tr>
	<?php else: ?>
		<tr style="height:25px">
		<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'TransfertEditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endforeach; endif; unset($_from); ?>
   </tr>
	<?php endif; ?>
	
<?php endforeach; endif; unset($_from); ?>