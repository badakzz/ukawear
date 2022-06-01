/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.20
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

var gallerique = {
    currentItem: false,
    currentLink: false,
    currentDescription: false,
    init: function () {
        $('a[rel^=gallery_image_] img').unveil();
        this.initFancybox();
        this.errorHandler();
    },
    setLink: function () {
        gallerique.currentLink = false;
        if (gallerique.currentItem && typeof(gallerique.currentItem.find('a[rel^=gallery_image_]').data('imageLink'))) {
            gallerique.currentLink = gallerique.currentItem.find('a[rel^=gallery_image_]').data('imageLink');
        }
    },
    setDescription: function () {
        gallerique.currentDescription = false;
        if (gallerique.currentItem && gallerique.currentItem.find('.full-description').length) {
            gallerique.currentDescription = gallerique.currentItem.find('.full-description').html();
        }
    },
    errorHandler: function () {
        if (typeof this.getURLParameter() !== 'undefined' && gq_message_error) {
            if ($('body .growl_status_all').length === 0) {
                $('body').append($('<div class="growl_status_all" />'));
            }

            $(".growl_status_all").append(
                $('<div class="growl_status_gallerique" />')
                    .append('<div class="close_status_gallerique" />')
                    .append($('<span class="text_growl_status_gallerique" />').html(gq_message_error))
                    .stop().fadeIn().delay(3000).fadeOut()
            );
        }
        $(document).on('click', '.close_status_gallerique', function (e) {
            $(this).parent('.growl_status_gallerique').hide();
        });
    },
    getURLParameter: function () {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === 'not_active_page') {
                return true;
            }
        }
    },
    initFancybox: function () {
        $("a[rel^=gallery_image_]").fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'titlePosition': 'over',
            'padding': 0,
            'cyclic': true,
            helpers: {
                title: {
                    type: 'inside'
                }
            },
            beforeShow: function () {
                var imgAlt = $(this.element).find("img").attr("alt");
                $('.fancybox-image').attr('alt', imgAlt);
                $('.fancybox-image').attr('title', imgAlt);
            },
            beforeLoad: function () {
                gallerique.currentItem = $(this.element).parent('li');

                if (!gallerique.currentItem.length) {
                    gallerique.currentItem = false;
                }

                var title = '';

                gallerique.setLink();
                gallerique.setDescription();

                if (typeof($(this.element).attr('title')) !== 'undefined' && $(this.element).attr('title').length) {
                    title = '<h4>' + $(this.element).attr('title') + '</h4>';
                }

                if (gallerique.currentDescription) {
                    if (gallerique.currentLink) {
                        title += '<a href="' + gallerique.currentLink + '">' + gallerique.currentDescription + '</a>';
                    } else {
                        title += gallerique.currentDescription;
                    }
                } else if (gallerique.currentLink) {
                    title += '<a href="' + gallerique.currentLink + '">' + gallerique.currentLink + '</a>';
                }

                if (parseInt(gallerique.currentItem.find('img').attr('data-buttons')) === 1) {
                    var buttons = '<div class="gallerique-buttons">' +
                        '<a href="' + gallerique.currentItem.find('img').attr('data-o') + '" target="_blank" title="' + gq_button_o_original + '">' +
                        '<i class="icon-link-ext"></i>' +
                        '</a>' +
                        '</div>';
                }

                if (title.length) {
                    this.title = '<div class="gallerique_title_block">' + title + '</div>';
                }

                if (typeof(buttons) !== 'undefined') {
                    this.title += buttons;
                }
            }
        });
    }
};

(function () {
    $(document).ready(function(){
        gallerique.init();
    });
}());
