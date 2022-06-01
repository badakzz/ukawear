<?php
/* Smarty version 3.1.32, created on 2019-10-31 17:15:04
  from '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_tabhtml.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dbb0888ce57c0_08170501',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd93f3a2624b7199a4caa93f5110baf832004cb0a' => 
    array (
      0 => '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_tabhtml.tpl',
      1 => 1553519958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dbb0888ce57c0_08170501 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="leo-widget" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_id']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php if (isset($_smarty_tpl->tpl_vars['tabhtmls']->value)) {?>
    <div id="tabhtml<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" class="widget-tab block">
        <?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value) && !empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
        <h4 class="title_block">
            <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['widget_heading']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

        </h4>
        <?php }?>
        <div class="block_content"> 
            <div id="tabhtmls<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" class="panel-group">
                <ul class="nav nav-tabs">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabhtmls']->value, 'ac', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['ac']->value) {
?>  
                    <li class="nav-item<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?> active<?php }?>"><a href="#tabhtml<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['key']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" class="nav-link tab-link" ><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ac']->value['title'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</a></li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>

                <div class="tab-content">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tabhtmls']->value, 'ac', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['ac']->value) {
?>
                        <div class="tab-pane<?php if ($_smarty_tpl->tpl_vars['key']->value == 0) {?> active<?php }?> " id="tabhtml<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['id']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');
echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['key']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['ac']->value['content'];?>
</div>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </div>
            </div>
        </div>
    </div>
<?php echo '<script'; ?>
 type="text/javascript">
    
    if ( typeof live_editor !== 'undefined' && live_editor)
    {
        // var tabhtml_id = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
;
        list_tab_live_editor.push(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
);
    }
    else
    {		
        // list_menu_tmp.list_tab.push({$id});
        list_tab.push(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
)	;
    }
    
<?php echo '</script'; ?>
>
<?php }?>
</div><?php }
}
