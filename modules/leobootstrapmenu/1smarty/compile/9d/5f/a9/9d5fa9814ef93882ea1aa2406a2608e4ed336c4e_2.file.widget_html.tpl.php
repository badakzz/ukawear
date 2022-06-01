<?php
/* Smarty version 3.1.32, created on 2021-05-05 10:07:43
  from '/home/ukawearcvt/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_html.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6092524fc50829_20116874',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d5fa9814ef93882ea1aa2406a2608e4ed336c4e' => 
    array (
      0 => '/home/ukawearcvt/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_html.tpl',
      1 => 1575382586,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6092524fc50829_20116874 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="leo-widget" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_id']->value, ENT_QUOTES, 'UTF-8');?>
">
    <?php if (isset($_smarty_tpl->tpl_vars['html']->value)) {?>
        <div class="widget-html">
            <?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value) && !empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
            <div class="menu-title">
                    <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_heading']->value, ENT_QUOTES, 'UTF-8');?>

            </div>
            <?php }?>
            <div class="widget-inner">
                    <?php echo $_smarty_tpl->tpl_vars['html']->value;?>
            </div>
        </div>
    <?php }?>
</div><?php }
}
