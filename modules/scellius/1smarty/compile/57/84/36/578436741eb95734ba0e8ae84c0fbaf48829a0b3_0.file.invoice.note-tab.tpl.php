<?php
/* Smarty version 3.1.32, created on 2022-05-21 21:04:41
  from '/home/ukawearcvt/www/pdf/invoice.note-tab.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_628937c97aadc9_38692749',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '578436741eb95734ba0e8ae84c0fbaf48829a0b3' => 
    array (
      0 => '/home/ukawearcvt/www/pdf/invoice.note-tab.tpl',
      1 => 1575381450,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_628937c97aadc9_38692749 (Smarty_Internal_Template $_smarty_tpl) {
if (isset($_smarty_tpl->tpl_vars['order_invoice']->value->note) && $_smarty_tpl->tpl_vars['order_invoice']->value->note) {?>
	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="6" class="left">
			<table id="note-tab" style="width: 100%">
				<tr>
					<td class="grey"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Note','d'=>'Shop.Pdf','pdf'=>'true'),$_smarty_tpl ) );?>
</td>
				</tr>
				<tr>
					<td class="note"><?php echo nl2br($_smarty_tpl->tpl_vars['order_invoice']->value->note);?>
</td>
				</tr>
			</table>
		</td>
		<td colspan="1">&nbsp;</td>
	</tr>
<?php }
}
}
