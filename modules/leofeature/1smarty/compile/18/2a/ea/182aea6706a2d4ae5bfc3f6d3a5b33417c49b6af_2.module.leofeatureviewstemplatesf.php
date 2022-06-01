<?php
/* Smarty version 3.1.32, created on 2022-06-01 19:22:02
  from 'module:leofeatureviewstemplatesf' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6297a03ab936e3_65166559',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '182aea6706a2d4ae5bfc3f6d3a5b33417c49b6af' => 
    array (
      0 => 'module:leofeatureviewstemplatesf',
      1 => 1575382257,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6297a03ab936e3_65166559 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="leo-notification" style="width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['width_notification']->value, ENT_QUOTES, 'UTF-8');?>
; <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['vertical_position']->value, ENT_QUOTES, 'UTF-8');?>
; <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['horizontal_position']->value, ENT_QUOTES, 'UTF-8');?>
">
</div>
<div class="leo-temp leo-temp-success">
	<div class="notification-wrapper">
		<div class="notification notification-success">
						<strong class="noti product-name"></strong>
			<span class="noti noti-update"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The product has been updated in your shopping cart','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-delete"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The product has been removed from your shopping cart','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-add"><strong class="noti-special"></strong> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Product successfully added to your shopping cart','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="leo-temp leo-temp-error">
	<div class="notification-wrapper">
		<div class="notification notification-error">
						
			<span class="noti noti-update"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error updating','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-delete"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error deleting','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			<span class="noti noti-add"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error adding. Please go to product detail page and try again','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="leo-temp leo-temp-warning">
	<div class="notification-wrapper">
		<div class="notification notification-warning">
						<span class="noti noti-min"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The minimum purchase order quantity for the product is','mod'=>'leofeature'),$_smarty_tpl ) );?>
 <strong class="noti-special"></strong></span>
			<span class="noti noti-max"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There are not enough products in stock','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<div class="leo-temp leo-temp-normal">
	<div class="notification-wrapper">
		<div class="notification notification-normal">
						<span class="noti noti-check"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must enter a quantity','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>
			
			<span class="notification-close">X</span>
			
		</div>
	</div>
</div>
<?php }
}
