/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
import $ from 'jquery';

$(document).ready(function () {
	/**DONGND:: check if display arrow*/
  createProductSpin();
  createInputFile();
  coverImage();
  imageScrollBox(false, false);

  prestashop.on('updatedProduct', function (event) {
    createInputFile();
    coverImage();
    if (event && event.product_minimal_quantity) {
      const minimalProductQuantity = parseInt(event.product_minimal_quantity, 10);
      const quantityInputSelector = '#quantity_wanted';
      let quantityInput = $(quantityInputSelector);

      // @see http://www.virtuosoft.eu/code/bootstrap-touchspin/ about Bootstrap TouchSpin
      quantityInput.trigger('touchspin.updatesettings', {min: minimalProductQuantity});
    }
    /**LEO_THEME : FIX PRODUCT PAGE NOT SCROLL IMAGE*/
	$('.js-product-images-modal').replaceWith(event.product_images_modal);
	imageScrollBox(false, true);
	$($('.tabs .nav-link.active').attr('href')).addClass('active').removeClass('fade');
  });
  
  /**DONGND:: fix scroll product image when resize*/
	$(window).resize(function () {
		if (style_scroll_quickview_attr == 'vertical')
		{		
			var check_li_item_first_load = $('.quickview .js-qv-product-images li').height();			
		}
		else
		{		
			var check_li_item_first_load = $('.quickview .js-qv-product-images li').width();
		};
		if (check_li_item_first_load > 0)
		{
			imageScrollBox(true, true);
		}
		else
		{
			imageScrollBox(true, false);
		}	
	});

  function coverImage() {
    $('.js-thumb').on(
      'click',
      (event) => {
        $('.js-modal-product-cover').attr('src',$(event.target).data('image-large-src'));
        $('.selected').removeClass('selected');
        $(event.target).addClass('selected');
        $('.js-qv-product-cover').prop('src', $(event.currentTarget).data('image-large-src'));
      }
    );
  }

  function imageScrollBox(checkupdate, checkupdatequickview)
  {
    /**DONGND:: fix scroll product image - product page*/
	
	var number_thumb_page = $('#main .js-qv-product-images li').length;
	
	if (style_scroll_page == 'vertical')
	{
		var mask_size_page = $('#main .js-qv-mask').height();
		if (checkupdate == true)
		{
			size_item_page = $('#main .js-qv-product-images li').height();
		};
	}
	else
	{
		var mask_size_page = $('#main .js-qv-mask').width();
		if (checkupdate == true)
		{
			size_item_page = $('#main .js-qv-product-images li').width();
		};
	};
	var size_scroll_page = size_item_page*number_thumb_page;
	var check_arrow_page_exists = size_scroll_page - mask_size_page;
	if (check_arrow_page_exists >= size_item_page)
	{	
		$('#main .js-qv-mask').addClass('scroll');
		$('#main .scroll-box-arrows').addClass('scroll');
		
		$('#main .js-qv-mask').unbind('backward');
		$('#main .js-qv-mask').unbind('forward');
		$('#main .js-qv-mask').scrollbox({
			 direction: style_scroll_page,
			distance: size_item_page,
			autoPlay: false,
			step: 1,
		});
		
		$('#main .scroll-box-arrows .left').click(function () {
			$('#main .js-qv-mask').trigger('backward');
		});
		$('#main .scroll-box-arrows .right').click(function () {
			$('#main .js-qv-mask').trigger('forward');
		});
	} else {
		$('#main .js-qv-mask').removeClass('scroll');
		$('#main .scroll-box-arrows').removeClass('scroll');
	};
	
	/**DONGND:: fix scroll product image - quickview when change attribute*/
	if (checkupdatequickview == true)
	{		
		var number_thumb_quickview = $('.quickview .js-qv-product-images li').length;
		
		if (style_scroll_quickview_attr == 'vertical')
		{
			var mask_size_quickview = $('.quickview .js-qv-mask').height();
			if (checkupdate == true || checkupdate == false)
			{
				size_item_quickview_attr = $('.quickview .js-qv-product-images li').height();
			}
		}
		else
		{
			var mask_size_quickview = $('.quickview .js-qv-mask').width();
			if (checkupdate == true || checkupdate == false)
			{
				size_item_quickview_attr = $('.quickview .js-qv-product-images li').width();
			}
		};
		
		var size_scroll_quickview = size_item_quickview_attr*number_thumb_quickview;
		var check_arrow_quickview_exists = size_scroll_quickview - mask_size_quickview;
		
		// console.log(checkupdate);
		// console.log(size_item_quickview_attr);
		// console.log(number_thumb_quickview);
		// console.log(size_scroll_quickview);
		// console.log(mask_size_quickview);
		// console.log(check_arrow_quickview_exists);
		if (check_arrow_quickview_exists >= size_item_quickview_attr)
		{	
			$('.quickview .js-qv-mask').addClass('scroll');
			$('.quickview .js-arrows').addClass('scroll');
			$('.quickview .js-arrows').show();
			$('.quickview .js-qv-mask').unbind('backward');
			$('.quickview .js-qv-mask').unbind('forward');
			$('.quickview .js-qv-mask').scrollbox({
				 direction: style_scroll_quickview_attr,
				distance: size_item_quickview_attr,
				autoPlay: false,
				step: 1,
			});
			$('.quickview .arrow-up').click(function () {
				$('.quickview .js-qv-mask').trigger('backward');
			});
			$('.quickview .arrow-down').click(function () {
				$('.quickview .js-qv-mask').trigger('forward');
			});
				
		} else {
			$('.quickview .js-qv-mask').removeClass('scroll');
			$('.quickview .js-arrows').removeClass('scroll');
			$('.quickview .js-arrows').hide();
		};
	}
	/**DONGND:: fix scroll product image at popup - product page*/
	
	var number_thumb_popup = $('.js-product-images-modal .js-modal-product-images li').length;
	
	if (style_scroll_popup == 'vertical')
	{
		var mask_size_popup = $('.js-product-images-modal .js-modal-mask').height();
		if (checkupdate == true && $('.js-product-images-modal .js-modal-product-images li').height() != 0)
		{
			size_item_popup = $('.js-product-images-modal .js-modal-product-images li').height();
		};
	}
	else
	{
		var mask_size_popup = $('.js-product-images-modal .js-modal-mask').width();
		if (checkupdate == true && $('.js-product-images-modal .js-modal-product-images li').width() != 0)
		{
			size_item_popup = $('.js-product-images-modal .js-modal-product-images li').width();
		};
	};
	var size_scroll_popup = size_item_popup*number_thumb_popup;
	var check_arrow_popup_exists = size_scroll_popup - mask_size_popup;
	if (check_arrow_popup_exists >= size_item_popup)
	{
		$('.js-product-images-modal .js-modal-mask').addClass('scroll');
		$('.js-modal-arrows').addClass('scroll');
		$('.js-product-images-modal .js-modal-mask').unbind('backward');
		$('.js-product-images-modal .js-modal-mask').unbind('forward');
		$('.js-product-images-modal .js-modal-mask').scrollbox({
			direction: style_scroll_popup,
			distance: size_item_popup,
			autoPlay: false,
			step: 1,
		});
		$('.arrow-up').click(function () {
			$('.js-product-images-modal .js-modal-mask').trigger('backward');
		});
		$('.arrow-down').click(function () {
			$('.js-product-images-modal .js-modal-mask').trigger('forward');
		});
	} else {
		$('.js-modal-arrows').hide();
	};
  }

  function createInputFile()
  {
    $('.js-file-input').on('change', (event) => {
      let target, file;

      if ((target = $(event.currentTarget)[0]) && (file = target.files[0])) {
        $(target).prev().text(file.name);
      }
    });
  }

  function createProductSpin()
  {
    let quantityInput = $('#quantity_wanted');
    quantityInput.TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'material-icons touchspin-up',
      verticaldownclass: 'material-icons touchspin-down',
      buttondown_class: 'btn btn-touchspin js-touchspin',
      buttonup_class: 'btn btn-touchspin js-touchspin',
      min: parseInt(quantityInput.attr('min'), 10),
      max: 1000000
    });

    var quantity = quantityInput.val();
    quantityInput.on('keyup change', function (event) {
      const newQuantity = $(this).val();
      if (newQuantity !== quantity) {
        quantity = newQuantity;
        let $productRefresh = $('.product-refresh');
        $(event.currentTarget).trigger('touchspin.stopspin');
        $productRefresh.trigger('click', {eventType: 'updatedProductQuantity'});
      }
      event.preventDefault();

      return false;
    });
  }
});
