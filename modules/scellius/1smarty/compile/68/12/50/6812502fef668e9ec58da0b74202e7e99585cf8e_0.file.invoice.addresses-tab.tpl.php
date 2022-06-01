<?php
/* Smarty version 3.1.32, created on 2022-05-21 21:04:41
  from '/home/ukawearcvt/www/pdf/invoice.addresses-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_628937c960ad69_94497839',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6812502fef668e9ec58da0b74202e7e99585cf8e' => 
    array (
      0 => '/home/ukawearcvt/www/pdf/invoice.addresses-tab.tpl',
      1 => 1575381450,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_628937c960ad69_94497839 (Smarty_Internal_Template $_smarty_tpl) {
?><table id="addresses-tab" cellspacing="0" cellpadding="0">
	<tr>
		<td width="50%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Delivery Address','d'=>'Shop.Pdf','pdf'=>'true'),$_smarty_tpl ) );?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

			<?php }?>
		</td>
		<td width="50%"><span class="bold"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Billing Address','d'=>'Shop.Pdf','pdf'=>'true'),$_smarty_tpl ) );?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

		</td>
	</tr>
</table>
<?php }
}
