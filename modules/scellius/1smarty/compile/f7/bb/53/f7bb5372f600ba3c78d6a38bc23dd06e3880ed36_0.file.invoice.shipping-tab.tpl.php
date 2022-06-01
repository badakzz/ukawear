<?php
/* Smarty version 3.1.32, created on 2022-05-21 21:04:41
  from '/home/ukawearcvt/www/pdf/invoice.shipping-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_628937c97ee102_68770177',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f7bb5372f600ba3c78d6a38bc23dd06e3880ed36' => 
    array (
      0 => '/home/ukawearcvt/www/pdf/invoice.shipping-tab.tpl',
      1 => 1575381450,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_628937c97ee102_68770177 (Smarty_Internal_Template $_smarty_tpl) {
?><table id="shipping-tab" width="100%">
	<tr>
		<td class="shipping center small grey bold" width="44%"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Carrier','d'=>'Shop.Pdf','pdf'=>'true'),$_smarty_tpl ) );?>
</td>
		<td class="shipping center small white" width="56%"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
	</tr>
</table>
<?php }
}
