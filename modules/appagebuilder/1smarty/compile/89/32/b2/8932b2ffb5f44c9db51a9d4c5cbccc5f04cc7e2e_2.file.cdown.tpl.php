<?php
/* Smarty version 3.1.32, created on 2022-06-01 17:15:51
  from '/home/ukawearcvt/www/modules/appagebuilder/views/templates/hook/cdown.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_629782a77f4fc5_53695965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8932b2ffb5f44c9db51a9d4c5cbccc5f04cc7e2e' => 
    array (
      0 => '/home/ukawearcvt/www/modules/appagebuilder/views/templates/hook/cdown.tpl',
      1 => 1575382225,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_629782a77f4fc5_53695965 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['product']->value) {?>
<ul class="deal-clock lof-clock-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['product']->value['id_product']), ENT_QUOTES, 'UTF-8');?>
-detail list-inline">
	<?php if (isset($_smarty_tpl->tpl_vars['product']->value['js']) && $_smarty_tpl->tpl_vars['product']->value['js'] == 'unlimited') {?><div class="lof-labelexpired"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Unlimited','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
</div><?php }?>
</ul>
<?php if (isset($_smarty_tpl->tpl_vars['product']->value['js']) && $_smarty_tpl->tpl_vars['product']->value['js'] != 'unlimited') {?>
	<?php echo '<script'; ?>
 type="text/javascript">
		
		jQuery(document).ready(function($){
			var text_d = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'days','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
';
			var text_h = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'hours','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
';
			var text_m = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'min','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
';
			var text_s = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'sec','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
';
			$(".lof-clock-<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['product']->value['id_product']), ENT_QUOTES, 'UTF-8');?>
-detail").lofCountDown({
				TargetDate:"<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['month'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['day'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['year'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['hour'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
:<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['minute'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
:<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['js']['seconds'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
",
				DisplayFormat:'<li class="z-depth-1">%%D%%<span>'+text_d+'</span></li><li class="z-depth-1">%%H%%<span>'+text_h+'</span></li><li class="z-depth-1">%%M%%<span>'+text_m+'</span></li><li class="z-depth-1">%%S%%<span>'+text_s+'</span></li>',
				FinishMessage: "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['finish'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"
			
			});
		});
		
	<?php echo '</script'; ?>
>
<?php }
}
}
}
