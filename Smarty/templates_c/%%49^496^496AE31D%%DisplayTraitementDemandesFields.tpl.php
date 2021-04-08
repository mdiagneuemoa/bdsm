<?php /* Smarty version 2.6.18, created on 2011-02-25 14:59:52
         compiled from DisplayTraitementDemandesFields.tpl */ ?>

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

   <tr style="height:25px">
	<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewTraitementDemandesUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endforeach; endif; unset($_from); ?>
   </tr>
<?php endforeach; endif; unset($_from); ?>