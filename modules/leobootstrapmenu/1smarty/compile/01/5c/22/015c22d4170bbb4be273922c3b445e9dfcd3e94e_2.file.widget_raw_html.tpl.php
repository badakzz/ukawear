<?php
/* Smarty version 3.1.32, created on 2019-03-26 11:45:20
  from '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_raw_html.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5c9a02c050f761_98889044',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '015c22d4170bbb4be273922c3b445e9dfcd3e94e' => 
    array (
      0 => '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_raw_html.tpl',
      1 => 1553519958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c9a02c050f761_98889044 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="leo-widget" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_id']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php if (isset($_smarty_tpl->tpl_vars['raw_html']->value)) {?>
    <div class="widget-raw-html">
        <?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value) && !empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
        <div class="menu-title">
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_heading']->value, ENT_QUOTES, 'UTF-8');?>

        </div>
        <?php }?>
        <div class="widget-inner">
            <?php echo $_smarty_tpl->tpl_vars['raw_html']->value;?>
        </div>
    </div>
<?php }?>
</div><?php }
}
