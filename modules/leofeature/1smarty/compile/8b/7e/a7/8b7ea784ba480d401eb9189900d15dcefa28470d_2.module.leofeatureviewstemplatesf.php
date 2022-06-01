<?php
/* Smarty version 3.1.32, created on 2022-05-30 18:37:58
  from 'module:leofeatureviewstemplatesf' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_6294f2e6b1d3a1_52301790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8b7ea784ba480d401eb9189900d15dcefa28470d' => 
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
function content_6294f2e6b1d3a1_52301790 (Smarty_Internal_Template $_smarty_tpl) {
?>	<?php if ($_smarty_tpl->tpl_vars['only_total']->value != 1) {?>
		<div class="leo-dropdown-cart-content clearfix">
			<div class="leo-dropdown-list-item-warpper">
				<ul class="leo-dropdown-list-item"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart']->value['products'], 'product', false, NULL, 'cart_product', array (
  'first' => true,
  'last' => true,
  'index' => true,
  'iteration' => true,
  'total' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['total'];
?><li style="width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['width_cart_item']->value, ENT_QUOTES, 'UTF-8');?>
px; height: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['height_cart_item']->value, ENT_QUOTES, 'UTF-8');?>
px" class="leo-dropdown-cart-item clearfix<?php if ((count($_smarty_tpl->tpl_vars['product']->value['attributes']) && $_smarty_tpl->tpl_vars['show_combination']->value) || (count($_smarty_tpl->tpl_vars['product']->value['customizations']) && $_smarty_tpl->tpl_vars['show_customization']->value)) {?> has-view-additional<?php }
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['first'] : null)) {?> first<?php }
if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_cart_product']->value['last'] : null)) {?> last<?php }?>">						
							<div class="leo-cart-item-img">
								<?php if ($_smarty_tpl->tpl_vars['product']->value['images']) {?>
									<a class="label" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"><img class="img-fluid" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['images'][0]['bySize']['small_default']['url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"/></a>
								<?php }?>	
							</div>						
							<div class="leo-cart-item-info">					
								<div class="product-name"><a class="label" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['name'],18,'...' )), ENT_QUOTES, 'UTF-8');?>
</a></div>
								<div class="product-price">
									<?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
										<div class="product-discount">
										  <span class="regular-price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['regular_price'], ENT_QUOTES, 'UTF-8');?>
</span>
										  
										  <?php if ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'percentage') {?>
											<span class="discount discount-percentage">
												-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['discount_percentage_absolute'], ENT_QUOTES, 'UTF-8');?>

											  </span>
										  <?php } else { ?>
											<span class="discount discount-amount">
												-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['discount_to_display'], ENT_QUOTES, 'UTF-8');?>

											  </span>
										  <?php }?>
										  
										</div>
									  <?php }?>
									  <div class="current-price">
										<span class="price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');?>
</span>
									  </div>
										<?php if ($_smarty_tpl->tpl_vars['product']->value['unit_price_full']) {?>
										  <div class="unit-price-cart"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['unit_price_full'], ENT_QUOTES, 'UTF-8');?>
</div>
										<?php }?>
								</div>
								
								<?php if ($_smarty_tpl->tpl_vars['enable_update_quantity']->value) {?>
									<div class="product-quantity">												
										<?php if ($_smarty_tpl->tpl_vars['enable_button_quantity']->value) {?>
											<a href="javascript:void(0)" class="leo-bt-product-quantity leo-bt-product-quantity-down"><i class="material-icons">&#xE15B;</i></a>
										<?php }?>
										<input
											class="leo-input-product-quantity input-group"
											data-down-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['down_quantity_url'], ENT_QUOTES, 'UTF-8');?>
"
											data-up-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['up_quantity_url'], ENT_QUOTES, 'UTF-8');?>
"
											data-update-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['update_quantity_url'], ENT_QUOTES, 'UTF-8');?>
"
											data-id-product = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_product'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
											data-id-product-attribute = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
											data-id-customization = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_customization'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
											data-min-quantity="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');?>
"
											data-product-quantity="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity'], ENT_QUOTES, 'UTF-8');?>
"
											data-quantity-available="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity_available'], ENT_QUOTES, 'UTF-8');?>
"									
											type="text"
											value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity'], ENT_QUOTES, 'UTF-8');?>
"								
											min="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['minimal_quantity'], ENT_QUOTES, 'UTF-8');?>
"
										  />
										<?php if ($_smarty_tpl->tpl_vars['enable_button_quantity']->value) {?>	
											<a href="javascript:void(0)" class="leo-bt-product-quantity leo-bt-product-quantity-up"><i class="material-icons">&#xE145;</i></a>
										<?php }?>
									</div>
								<?php } else { ?>
									<div class="product-quantity"><span class="lablel"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Quantity','mod'=>'leofeature'),$_smarty_tpl ) );?>
</span>: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['quantity'], ENT_QUOTES, 'UTF-8');?>
</div>
								<?php }?>
							</div>
							<a class="leo-remove-from-cart"					
								href="javascript:void(0)"					
								title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remove from cart','mod'=>'leofeature'),$_smarty_tpl ) );?>
" 
								data-link-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['remove_from_cart_url'], ENT_QUOTES, 'UTF-8');?>
"
								data-id-product = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_product'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
								data-id-product-attribute = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
								data-id-customization = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['id_customization'],'javascript' )), ENT_QUOTES, 'UTF-8');?>
"
							>
								<i class="material-icons">&#xE872;</i>
							</a>
							<?php if ((count($_smarty_tpl->tpl_vars['product']->value['attributes']) && $_smarty_tpl->tpl_vars['show_combination']->value) || (count($_smarty_tpl->tpl_vars['product']->value['customizations']) && $_smarty_tpl->tpl_vars['show_customization']->value)) {?>
								<div class="view-additional">								
									<div class="view-leo-dropdown-additional"></div>
								</div>
							<?php }?>
							<div class="leo-dropdown-overlay">
								<div class="leo-dropdown-cssload-speeding-wheel"></div>
							</div>
							<div class="leo-dropdown-additional">
								<?php if (count($_smarty_tpl->tpl_vars['product']->value['attributes']) && $_smarty_tpl->tpl_vars['show_combination']->value) {?>							
									<div class="view-combination label">
										
									</div>
									<div class="combinations">
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product']->value['attributes'], 'value', false, 'attribute');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->value => $_smarty_tpl->tpl_vars['value']->value) {
?>
											  <div class="product-line-info">
												<span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attribute']->value, ENT_QUOTES, 'UTF-8');?>
:</span>
												<span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8');?>
</span>
											  </div>
										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
									</div>
								<?php }?>
								<?php if (count($_smarty_tpl->tpl_vars['product']->value['customizations']) && $_smarty_tpl->tpl_vars['show_customization']->value) {?>
									<div class="view-customization label">
										
									</div>
									<div class="customizations">								
										<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product']->value['customizations'], 'customization');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->value) {
?>			
											
											<ul>
												<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['customization']->value['fields'], 'field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['field']->value) {
?>
													<li>
														<span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['label'], ENT_QUOTES, 'UTF-8');?>
</span>
														<?php if ($_smarty_tpl->tpl_vars['field']->value['type'] == 'text') {?>
															: <span class="value"><?php echo $_smarty_tpl->tpl_vars['field']->value['text'];?>
</span>
														<?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type'] == 'image') {?>
															<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['image']['small']['url'], ENT_QUOTES, 'UTF-8');?>
">
														<?php }?>
													</li>
												<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
											</ul>								
										<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>								
									</div>
								<?php }?>
							</div>
						</li><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?></ul>
			</div>
			<div class="leo-dropdown-bottom">
			<?php }?>
				<div class="leo-dropdown-total" data-cart-total="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['products_count'], ENT_QUOTES, 'UTF-8');?>
">
					<div class="leo-dropdown-cart-subtotals">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart']->value['subtotals'], 'subtotal');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['subtotal']->value) {
?>
							<?php if ($_smarty_tpl->tpl_vars['subtotal']->value) {?>
								<div class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['type'], ENT_QUOTES, 'UTF-8');?>
 clearfix">
									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
											<span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['label'], ENT_QUOTES, 'UTF-8');?>
</span>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
											<span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['value'], ENT_QUOTES, 'UTF-8');?>
</span>
										</div>
									</div>
								</div>
							<?php }?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
					</div>
					<div class="leo-dropdown-cart-total clearfix">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
								<span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['label'], ENT_QUOTES, 'UTF-8');?>
</span>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
								<span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
							</div>
						</div>
					</div>
				</div>
			<?php if ($_smarty_tpl->tpl_vars['only_total']->value != 1) {?>
				<div class="leo-cart-dropdown-action clearfix">
					<a class="cart-dropdow-button cart-dropdow-viewcart btn btn-primary btn-outline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_url']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View Cart','mod'=>'leofeature'),$_smarty_tpl ) );?>
</a>
					<a class="cart-dropdow-button cart-dropdow-checkout btn btn-primary btn-outline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['order_url']->value, ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check Out','mod'=>'leofeature'),$_smarty_tpl ) );?>
</a>
				</div>
			</div>
		</div>
	<?php }
}
}
