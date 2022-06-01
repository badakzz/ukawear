<?php
/* Smarty version 3.1.32, created on 2022-06-01 19:22:02
  from 'module:leofeatureviewstemplatesf' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6297a03ab77401_06362486',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b2b08f3e7cd22b2aad86e184d6bdfdc8b3802cf' => 
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
function content_6297a03ab77401_06362486 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal leo-modal leo-modal-cart fade" tabindex="-1" role="dialog" aria-hidden="true">
	<!--
	<div class="vertical-alignment-helper">
	-->
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title h6 text-xs-center leo-warning leo-alert">
				<i class="material-icons">info_outline</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must enter a quantity','mod'=>'leofeature'),$_smarty_tpl ) );?>
		
			</h4>
			
			<h4 class="modal-title h6 text-xs-center leo-info leo-alert">
				<i class="material-icons">info_outline</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The minimum purchase order quantity for the product is ','mod'=>'leofeature'),$_smarty_tpl ) );?>
<strong class="alert-min-qty"></strong>		
			</h4>	
			
			<h4 class="modal-title h6 text-xs-center leo-block leo-alert">				
				<i class="material-icons">block</i>				
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There are not enough products in stock','mod'=>'leofeature'),$_smarty_tpl ) );?>

			</h4>
		  </div>
		  <!--
		  <div class="modal-body">
			...
		  </div>
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
			
		  </div>
		  -->
		</div>
	  </div>
	<!--
	</div>
	-->
</div><?php }
}
