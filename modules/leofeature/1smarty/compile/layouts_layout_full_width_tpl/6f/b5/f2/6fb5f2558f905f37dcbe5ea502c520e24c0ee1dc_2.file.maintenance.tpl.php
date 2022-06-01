<?php
/* Smarty version 3.1.32, created on 2020-04-21 10:22:49
  from '/home/ukawearcvt/www/themes/at_movic/templates/errors/maintenance.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5e9ead5922ce50_90037638',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6fb5f2558f905f37dcbe5ea502c520e24c0ee1dc' => 
    array (
      0 => '/home/ukawearcvt/www/themes/at_movic/templates/errors/maintenance.tpl',
      1 => 1575381984,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e9ead5922ce50_90037638 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5516434345e9ead59224766_94510248', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layouts/layout-error.tpl');
}
/* {block 'page_header_logo'} */
class Block_1086047065e9ead59225381_05345351 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <div class="logo"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo'], ENT_QUOTES, 'UTF-8');?>
" alt="logo"></div>
        <?php
}
}
/* {/block 'page_header_logo'} */
/* {block 'hook_maintenance'} */
class Block_11074107625e9ead59227b49_46515265 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php echo $_smarty_tpl->tpl_vars['HOOK_MAINTENANCE']->value;?>

        <?php
}
}
/* {/block 'hook_maintenance'} */
/* {block 'page_title'} */
class Block_3364412365e9ead59228ec6_07264506 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'We\'ll be back soon.','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );
}
}
/* {/block 'page_title'} */
/* {block 'page_header'} */
class Block_10841962635e9ead59228992_52470981 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <h1><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3364412365e9ead59228ec6_07264506', 'page_title', $this->tplIndex);
?>
</h1>
        <?php
}
}
/* {/block 'page_header'} */
/* {block 'page_header_container'} */
class Block_50197185e9ead59224e19_62856021 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <header class="page-header">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1086047065e9ead59225381_05345351', 'page_header_logo', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11074107625e9ead59227b49_46515265', 'hook_maintenance', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10841962635e9ead59228992_52470981', 'page_header', $this->tplIndex);
?>

      </header>
    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content'} */
class Block_17122127855e9ead5922b399_46298901 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php echo $_smarty_tpl->tpl_vars['maintenance_text']->value;?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_14298955465e9ead5922ae58_63987913 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-content page-maintenance">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17122127855e9ead5922b399_46298901', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer_container'} */
class Block_20835791205e9ead5922c3b5_54552957 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_5516434345e9ead59224766_94510248 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_5516434345e9ead59224766_94510248',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_50197185e9ead59224e19_62856021',
  ),
  'page_header_logo' => 
  array (
    0 => 'Block_1086047065e9ead59225381_05345351',
  ),
  'hook_maintenance' => 
  array (
    0 => 'Block_11074107625e9ead59227b49_46515265',
  ),
  'page_header' => 
  array (
    0 => 'Block_10841962635e9ead59228992_52470981',
  ),
  'page_title' => 
  array (
    0 => 'Block_3364412365e9ead59228ec6_07264506',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_14298955465e9ead5922ae58_63987913',
  ),
  'page_content' => 
  array (
    0 => 'Block_17122127855e9ead5922b399_46298901',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_20835791205e9ead5922c3b5_54552957',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_50197185e9ead59224e19_62856021', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14298955465e9ead5922ae58_63987913', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20835791205e9ead5922c3b5_54552957', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
