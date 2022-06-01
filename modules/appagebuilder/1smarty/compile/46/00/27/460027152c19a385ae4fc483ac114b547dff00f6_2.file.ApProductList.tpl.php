<?php
/* Smarty version 3.1.32, created on 2022-05-15 00:05:37
  from '/home/ukawearcvt/www/modules/appagebuilder/views/templates/hook/ApProductList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_628027b1af1dc7_94224240',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '460027152c19a385ae4fc483ac114b547dff00f6' => 
    array (
      0 => '/home/ukawearcvt/www/modules/appagebuilder/views/templates/hook/ApProductList.tpl',
      1 => 1575382224,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_628027b1af1dc7_94224240 (Smarty_Internal_Template $_smarty_tpl) {
?><!-- @file modules\appagebuilder\views\templates\hook\ApProductList -->
<?php if (!isset($_smarty_tpl->tpl_vars['apAjax']->value)) {?>
    <div class="block <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['formAtts']->value['class'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
		<?php echo $_smarty_tpl->tpl_vars['apLiveEdit']->value ? $_smarty_tpl->tpl_vars['apLiveEdit']->value : '';?>
		<input type="hidden" class="apconfig" value='<?php echo $_smarty_tpl->tpl_vars['apPConfig']->value;?>
'/>
		<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['title']) && !empty($_smarty_tpl->tpl_vars['formAtts']->value['title'])) {?>
		<h4 class="title_block">
			<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['formAtts']->value['title'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

		</h4>
		<?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['sub_title']) && $_smarty_tpl->tpl_vars['formAtts']->value['sub_title']) {?>
            <div class="sub-title-widget"><?php echo $_smarty_tpl->tpl_vars['formAtts']->value['sub_title'];?>
</div>
        <?php }
}
if (isset($_smarty_tpl->tpl_vars['products']->value) && $_smarty_tpl->tpl_vars['products']->value) {?>
    <?php if (!isset($_smarty_tpl->tpl_vars['apAjax']->value)) {?>
    <!-- Products list -->
    <ul<?php if (isset($_smarty_tpl->tpl_vars['id']->value) && $_smarty_tpl->tpl_vars['id']->value) {?> id="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['id']->value), ENT_QUOTES, 'UTF-8');?>
"<?php }?> class="product_list grid row<?php if (isset($_smarty_tpl->tpl_vars['class']->value) && $_smarty_tpl->tpl_vars['class']->value) {?> <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['class']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?> <?php if (isset($_smarty_tpl->tpl_vars['productClassWidget']->value)) {
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['productClassWidget']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
}?>">
    <?php }?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product', false, NULL, 'products', array (
  'first' => true,
  'last' => true,
  'iteration' => true,
  'index' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['total'];
?>
            <li class="ajax_block_product<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) && $_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) {?> has-animation<?php }?> product_block 
                <?php if ($_smarty_tpl->tpl_vars['scolumn']->value == 5) {?> col-lg-2-4 <?php } else { ?> col-lg-<?php echo htmlspecialchars(12/intval($_smarty_tpl->tpl_vars['scolumn']->value), ENT_QUOTES, 'UTF-8');
}?> 
                col-sm-6 col-xs-6 col-sp-12 <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['first'] : null)) {?>first_item<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['last'] : null)) {?>last_item<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) && $_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) {?> data-animation="fadeInUp" data-animation-delay="<?php echo htmlspecialchars((isset($_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration'] : null)*100, ENT_QUOTES, 'UTF-8');?>
ms" data-animation-duration="2s" data-animation-iteration-count="1"<?php }?>>
                    <?php if (isset($_smarty_tpl->tpl_vars['product_item_path']->value)) {?>
                        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['product_item_path']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                    <?php }?>
            </li>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    <?php if (!isset($_smarty_tpl->tpl_vars['apAjax']->value)) {?>
    </ul>
    <!-- End Products list -->
    <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['use_showmore']) && $_smarty_tpl->tpl_vars['formAtts']->value['use_showmore'] && count($_smarty_tpl->tpl_vars['products']->value) >= $_smarty_tpl->tpl_vars['formAtts']->value['nb_products']) {?>
    <div class="box-show-more open">
        <a href="javascript:void(0)" class="btn btn-default btn-show-more" data-use-animation="<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) && $_smarty_tpl->tpl_vars['formAtts']->value['use_animation']) {?>1<?php } else { ?>0<?php }?>" data-page="<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['p']->value), ENT_QUOTES, 'UTF-8');?>
" data-loading-text="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Loading...','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
">
            <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Show more','mod'=>'appagebuilder'),$_smarty_tpl ) );?>
</span></a>
    </div>
    <?php }?>

    </div>
	<?php echo $_smarty_tpl->tpl_vars['apLiveEditEnd']->value ? $_smarty_tpl->tpl_vars['apLiveEditEnd']->value : '';?>
    <?php }?>
	<?php } else { ?>
</div>
<?php }
}
}
