<?php
/* Smarty version 3.1.32, created on 2021-05-05 10:07:43
  from '/home/ukawearcvt/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_sub_categories.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6092524f936d09_11238354',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2d12b2067160d62f450c66b671dfd4695ac0dd83' => 
    array (
      0 => '/home/ukawearcvt/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_sub_categories.tpl',
      1 => 1575382586,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6092524f936d09_11238354 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="leo-widget" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_id']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php if (isset($_smarty_tpl->tpl_vars['subcategories']->value)) {?>
    <div class="widget-subcategories">
        <?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value) && !empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
        <div class="widget-heading">
                <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_heading']->value, ENT_QUOTES, 'UTF-8');?>

        </div>
        <?php }?>
        <div class="widget-inner">
            <?php if ($_smarty_tpl->tpl_vars['cat']->value->id_category != '') {?>
                <div class="menu-title">
                    <a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['cat']->value->id_category,$_smarty_tpl->tpl_vars['cat']->value->link_rewrite),'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['cat']->value->name,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" class="img">
                            <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['cat']->value->name,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 
                    </a>
                </div>
                <ul>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['subcategories']->value, 'subcategory');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->value) {
?>
                    <li class="clearfix">
                        <a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['subcategory']->value['id_category'],$_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite']),'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['subcategory']->value['name'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" class="img">
                                <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['subcategory']->value['name'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 
                        </a>
                    </li>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
            <?php } else { ?>
                <div class="alert alert-warning">
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The ID category does not exist','mod'=>'leobootstrapmenu'),$_smarty_tpl ) );?>

                </div>
            <?php }?>
        </div>
    </div>
<?php }?> 
</div><?php }
}
