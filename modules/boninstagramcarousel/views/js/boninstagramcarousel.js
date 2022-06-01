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
    if(typeof(BONINSTAGRAMCAROUSEL_DISPLAY) != 'undefined' && BONINSTAGRAMCAROUSEL_DISPLAY) {
        $('.owl-carousel-instagram').owlCarousel({
            items: BONINSTAGRAMCAROUSEL_NB,
            loop: BONINSTAGRAMCAROUSEL_LOOP,
            margin: BONINSTAGRAMCAROUSEL_MARGIN,
            responsiveClass:true,
            nav: BONINSTAGRAMCAROUSEL_NAV,
            dots: BONINSTAGRAMCAROUSEL_DOTS,
            mouseDrag: true,
            autoplay: true,
            lazyLoad: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: [
                "❮",
                "❯"
            ],
            responsive:{
                0:{
                    items:1,
                },
                600:{
                    items:3,
                },
                1000:{
                    items: BONINSTAGRAMCAROUSEL_NB,
                }
            }
        })
    }
});