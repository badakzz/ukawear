<?php
/* Smarty version 3.1.32, created on 2022-02-06 02:38:01
  from '/home/ukawearcvt/www/mails/en/order_conf_cart_rules.txt' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_61ff26794f2f07_43551418',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48f91134eee569737ac93284f27f27aa17be311e' => 
    array (
      0 => '/home/ukawearcvt/www/mails/en/order_conf_cart_rules.txt',
      1 => 1575381534,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61ff26794f2f07_43551418 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'cart_rule');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cart_rule']->value) {
?>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_rule']->value['voucher_name'], ENT_QUOTES, 'UTF-8');?>
  <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_rule']->value['voucher_reduction'], ENT_QUOTES, 'UTF-8');?>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
