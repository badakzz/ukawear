<?php
/* Smarty version 3.1.32, created on 2022-02-06 02:38:01
  from '/home/ukawearcvt/www/mails/en/order_conf_cart_rules.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_61ff2679574d56_66661600',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ac78cf08b5b6471695db9a24f882b59ed84d173d' => 
    array (
      0 => '/home/ukawearcvt/www/mails/en/order_conf_cart_rules.tpl',
      1 => 1575381534,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61ff2679574d56_66661600 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'cart_rule');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart_rule']->value) {
?>
	<tr class="conf_body">
		<td bgcolor="#f8f8f8" colspan="4" style="border:1px solid #D6D4D4;color:#333;padding:7px 0">
			<table class="table" style="width:100%;border-collapse:collapse">
				<tr>
					<td width="10" style="color:#333;padding:0"></td>
					<td align="right" style="color:#333;padding:0">
						<font size="2" face="Open-sans, sans-serif" color="#555454">
							<strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_rule']->value['voucher_name'], ENT_QUOTES, 'UTF-8');?>
</strong>
						</font>
					</td>
					<td width="10" style="color:#333;padding:0"></td>
				</tr>
			</table>
		</td>
		<td bgcolor="#f8f8f8" colspan="4" style="border:1px solid #D6D4D4;color:#333;padding:7px 0">
			<table class="table" style="width:100%;border-collapse:collapse">
				<tr>
					<td width="10" style="color:#333;padding:0"></td>
					<td align="right" style="color:#333;padding:0">
						<font size="2" face="Open-sans, sans-serif" color="#555454">
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_rule']->value['voucher_reduction'], ENT_QUOTES, 'UTF-8');?>

						</font>
					</td>
					<td width="10" style="color:#333;padding:0"></td>
				</tr>
			</table>
		</td>
	</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
