<?php
/* Smarty version 3.1.32, created on 2019-11-19 16:25:57
  from '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_links.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5dd4098537bac1_99843801',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9edf1aa67f3288a16f8500c3df463e3c3e9a2689' => 
    array (
      0 => '/home/dev.polux.studio/ukawear/site/www/modules/leobootstrapmenu/views/templates/hook/widgets/widget_links.tpl',
      1 => 1553519958,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5dd4098537bac1_99843801 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="leo-widget" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_id']->value, ENT_QUOTES, 'UTF-8');?>
">
<?php if (isset($_smarty_tpl->tpl_vars['links']->value)) {?>
    <div class="widget-links">
	<?php if (isset($_smarty_tpl->tpl_vars['widget_heading']->value) && !empty($_smarty_tpl->tpl_vars['widget_heading']->value)) {?>
	<div class="menu-title">
		<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['widget_heading']->value, ENT_QUOTES, 'UTF-8');?>

	</div>
	<?php }?>
	<div class="widget-inner">	
		<div id="tabs<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" class="panel-group">
			<ul class="nav-links">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['links']->value, 'ac', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['ac']->value) {
?>  
					<li ><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ac']->value['link'], ENT_QUOTES, 'UTF-8');?>
" ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ac']->value['text'], ENT_QUOTES, 'UTF-8');?>
</a></li>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			</ul>
		</div>
	</div>
    </div>
<?php }?>
</div><?php }
}
