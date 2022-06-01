<?php
/* Smarty version 3.1.32, created on 2019-03-26 11:36:19
  from 'module:leofeatureviewstemplatesf' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5c9a00a32aa4e4_64684656',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c97d14dae98843460109eb96ea181e11eba6e1d9' => 
    array (
      0 => 'module:leofeatureviewstemplatesf',
      1 => 1553519958,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c9a00a32aa4e4_64684656 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="modal leo-modal leo-modal-review fade" tabindex="-1" role="dialog" aria-hidden="true">
	<!--
	<div class="vertical-alignment-helper">
	-->
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title h2 text-xs-center">
							
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Write a review','mod'=>'leofeature'),$_smarty_tpl ) );?>
		
			</h4>
				
		  </div>
		  
		  <div class="modal-body">
			<div class="row">
				<?php if (isset($_smarty_tpl->tpl_vars['product_modal_review']->value) && $_smarty_tpl->tpl_vars['product_modal_review']->value) {?>
					<div class="product-info clearfix  col-xs-12 col-sm-6">
						<img class="img-fluid" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productcomment_cover_image']->value, ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product_modal_review']->value->name,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" />
						<div class="product_desc">
							<p class="product_name">
								<strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product_modal_review']->value->name, ENT_QUOTES, 'UTF-8');?>
</strong>
							</p>
							<?php echo $_smarty_tpl->tpl_vars['product_modal_review']->value->description_short;?>

						</div>
					</div>
				<?php }?>
				<div class="new_review_form_content col-xs-12 col-sm-6">					
					<?php if (count($_smarty_tpl->tpl_vars['criterions']->value) > 0) {?>
						<ul id="criterions_list">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['criterions']->value, 'criterion');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['criterion']->value) {
?>
							<li>
								<?php if (isset($_smarty_tpl->tpl_vars['criterion']->value['name']) && $_smarty_tpl->tpl_vars['criterion']->value['name'] != '') {?><label><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['criterion']->value['name'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
:</label><?php }?>
								<div class="star_content">
									<input class="star not_uniform" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_review_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="1" />
									<input class="star not_uniform" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_review_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="2" />
									<input class="star not_uniform" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_review_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="3" />
									<input class="star not_uniform" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_review_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="4" checked="checked" />
									<input class="star not_uniform" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_review_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="5" />
								</div>
								<div class="clearfix"></div>
							</li>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					<?php }?>				
					<form class="form-new-review" action="#" method="post">
						<div class="form-group">
						  <label class="form-control-label" for="new_review_title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Title','mod'=>'leofeature'),$_smarty_tpl ) );?>
 <sup class="required">*</sup></label>
						  <input type="text" class="form-control" id="new_review_title" required="" name="new_review_title">					  
						</div>
						<div class="form-group">
						  <label class="form-control-label" for="new_review_content"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Comment','mod'=>'leofeature'),$_smarty_tpl ) );?>
 <sup class="required">*</sup></label>
						  <textarea type="text" class="form-control" id="new_review_content" required="" name="new_review_content"></textarea>				  
						</div>
						<?php if ($_smarty_tpl->tpl_vars['allow_guests']->value == true && !$_smarty_tpl->tpl_vars['is_logged']->value) {?>
							<div class="form-group">
							  <label class="form-control-label" for="new_review_customer_name"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your name','mod'=>'leofeature'),$_smarty_tpl ) );?>
 <sup class="required">*</sup></label>
							  <input type="text" class="form-control" id="new_review_customer_name" required="" name="new_review_customer_name">					  
							</div>
						<?php }?>
						<div class="form-group">
							<label class="form-control-label"><sup>*</sup> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Required fields','mod'=>'leofeature'),$_smarty_tpl ) );?>
</label>
						<input id="id_product_review" name="id_product_review" type="hidden" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product_modal_review']->value->id, ENT_QUOTES, 'UTF-8');?>
' />
						</div>
						<button class="btn btn-primary form-control-submit leo-fake-button pull-xs-right" type="submit">
						  
						</button>
					</form>
				</div>
			</div>
		  </div>
		  <div class="modal-footer">
			
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Close','mod'=>'leofeature'),$_smarty_tpl ) );?>
</button>
			<button type="button" class="leo-modal-review-bt btn btn-primary">
				
				<span class="leo-modal-review-loading cssload-speeding-wheel"></span>
				<span class="leo-modal-review-bt-text">
					<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Submit','mod'=>'leofeature'),$_smarty_tpl ) );?>

				</span>
			</button>
			
		  </div>
		  
		</div>
	  </div>
	<!--
	</div>
	-->
</div><?php }
}
