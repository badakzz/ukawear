<?php
/* Smarty version 3.1.32, created on 2020-04-21 10:22:49
  from '/home/ukawearcvt/www/themes/at_movic/templates/layouts/layout-error.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5e9ead59240be6_50651173',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84c5bebb630c70c25ad64cef081e67fc5c3b981e' => 
    array (
      0 => '/home/ukawearcvt/www/themes/at_movic/templates/layouts/layout-error.tpl',
      1 => 1575381984,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:_partials/stylesheets.tpl' => 1,
  ),
),false)) {
function content_5e9ead59240be6_50651173 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!doctype html>
<html lang="">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_11528599975e9ead5923a788_60523199', 'head_seo');
?>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4532926795e9ead5923c870_67326975', 'stylesheets');
?>


  </head>

  <body>

    <div id="layout-error">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12453199345e9ead59240515_56814103', 'content');
?>

    </div>

  </body>

</html>
<?php }
/* {block 'head_seo_title'} */
class Block_14306034215e9ead5923ad86_42281423 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head_seo_title'} */
/* {block 'head_seo_description'} */
class Block_19528885205e9ead5923b5f6_36251278 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head_seo_description'} */
/* {block 'head_seo_keywords'} */
class Block_19740810855e9ead5923bd59_45774957 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'head_seo_keywords'} */
/* {block 'head_seo'} */
class Block_11528599975e9ead5923a788_60523199 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head_seo' => 
  array (
    0 => 'Block_11528599975e9ead5923a788_60523199',
  ),
  'head_seo_title' => 
  array (
    0 => 'Block_14306034215e9ead5923ad86_42281423',
  ),
  'head_seo_description' => 
  array (
    0 => 'Block_19528885205e9ead5923b5f6_36251278',
  ),
  'head_seo_keywords' => 
  array (
    0 => 'Block_19740810855e9ead5923bd59_45774957',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14306034215e9ead5923ad86_42281423', 'head_seo_title', $this->tplIndex);
?>
</title>
      <meta name="description" content="<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19528885205e9ead5923b5f6_36251278', 'head_seo_description', $this->tplIndex);
?>
">
      <meta name="keywords" content="<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19740810855e9ead5923bd59_45774957', 'head_seo_keywords', $this->tplIndex);
?>
">
    <?php
}
}
/* {/block 'head_seo'} */
/* {block 'stylesheets'} */
class Block_4532926795e9ead5923c870_67326975 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'stylesheets' => 
  array (
    0 => 'Block_4532926795e9ead5923c870_67326975',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php $_smarty_tpl->_subTemplateRender("file:_partials/stylesheets.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('stylesheets'=>$_smarty_tpl->tpl_vars['stylesheets']->value), 0, false);
?>
    <?php
}
}
/* {/block 'stylesheets'} */
/* {block 'content'} */
class Block_12453199345e9ead59240515_56814103 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_12453199345e9ead59240515_56814103',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <p>Hello world! This is HTML5 Boilerplate.</p>
      <?php
}
}
/* {/block 'content'} */
}
