/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Responsive Carousel Feed Instagram Images
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

$(document).ready(function(){
    $('.form-group.display-block').addClass('hidden');
    $(document).on('click', '#BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL_off', function(){
        $('.form-group.display-block').addClass('hidden');
    });
    $(document).on('click', '#BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL_on', function(){
        $('.form-group.display-block').removeClass('hidden');
    });
    if ($('input[name="BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL"]:checked').val() == 1) {
        $('.form-group.display-block').removeClass('hidden');
    }
});