<?php /* Smarty version 2.6.18, created on 2009-03-31 15:27:03
         compiled from CurrencyListViewEntries.tpl */ ?>

<table width="100%" cellpadding="5" cellspacing="0" class="listTable" >
	<tr>
                <td class="colHeader small" width="3%">#</td>
                <td class="colHeader small" width="9%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_TOOL']; ?>
</td>
        	<td class="colHeader small" width="23%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_NAME']; ?>
</td>
                <td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_CODE']; ?>
</td>
                <td class="colHeader small" width="10%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_SYMBOL']; ?>
</td>
                <td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_CRATE']; ?>
</td>
                <td class="colHeader small" width="15%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_STATUS']; ?>
</td>
	</tr>
	<?php $_from = $this->_tpl_vars['CURRENCY_LIST']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['currlist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['currlist']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['currencyvalues']):
        $this->_foreach['currlist']['iteration']++;
?>
		<tr>
			<td nowrap class="listTableRow small" valign="top"><?php echo $this->_foreach['currlist']['iteration']; ?>
</td>
			<td nowrap class="listTableRow small" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['tool']; ?>
</td>
			<td nowrap class="listTableRow small" valign="top"><b><?php echo $this->_tpl_vars['currencyvalues']['name']; ?>
</b></td>
			<td nowrap class="listTableRow small" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['code']; ?>
</td>
			<td nowrap class="listTableRow small" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['symbol']; ?>
</td>
			<td nowrap class="listTableRow small" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['crate']; ?>
</td>
			<?php if ($this->_tpl_vars['currencyvalues']['status'] == 'Active'): ?>
			<td nowrap class="listTableRow small active" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['status']; ?>
</td>
			<?php else: ?>
			<td nowrap class="listTableRow small inactive" valign="top"><?php echo $this->_tpl_vars['currencyvalues']['status']; ?>
</td>
			<?php endif; ?>
                 </tr>
        <?php endforeach; endif; unset($_from); ?>
</table>
