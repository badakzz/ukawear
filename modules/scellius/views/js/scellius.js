/**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

/**
 * Misc JavaScript functions.
 */

function scelliusAddMultiOption(first) {
    if (first) {
        $('#scellius_multi_options_btn').hide();
        $('#scellius_multi_options_table').show();
    }

    var timestamp = new Date().getTime();

    var rowTpl = $('#scellius_multi_row_option').html();
    rowTpl = rowTpl.replace(/SCELLIUS_MULTI_KEY/g, '' + timestamp);

    $(rowTpl).insertBefore('#scellius_multi_option_add');
}

function scelliusDeleteMultiOption(key) {
    $('#scellius_multi_option_' + key).remove();

    if ($('#scellius_multi_options_table tbody tr').length === 1) {
        $('#scellius_multi_options_btn').show();
        $('#scellius_multi_options_table').hide();
        $('#scellius_multi_options_table').append("<input type=\"hidden\" id=\"SCELLIUS_MULTI_OPTIONS\" name=\"SCELLIUS_MULTI_OPTIONS\" value=\"\">");
    }
}

function scelliusAddOneyOption(first, suffix = '') {
    if (first) {
        $('#scellius_oney' + suffix + '_options_btn').hide();
        $('#scellius_oney' + suffix + '_options_table').show();
    }

    var timestamp = new Date().getTime();
    var key = suffix != '' ? /SCELLIUS_ONEY34_KEY/g : /SCELLIUS_ONEY_KEY/g;
    var rowTpl = $('#scellius_oney' + suffix + '_row_option').html();
    rowTpl = rowTpl.replace(key, '' + timestamp);

    $(rowTpl).insertBefore('#scellius_oney' + suffix + '_option_add');
}

function scelliusDeleteOneyOption(key, suffix = '') {
    $('#scellius_oney' + suffix + '_option_' + key).remove();

    if ($('#scellius_oney' + suffix + '_options_table tbody tr').length === 1) {
        $('#scellius_oney' + suffix + '_options_btn').show();
        $('#scellius_oney' + suffix + '_options_table').hide();
        $('#scellius_oney' + suffix + '_options_table').append("<input type=\"hidden\" id=\"SCELLIUS_ONEY" + suffix + "_OPTIONS\" name=\"SCELLIUS_ONEY" + suffix + "_OPTIONS\" value=\"\">");
    }
}

function scelliusAdditionalOptionsToggle(legend) {
    var fieldset = $(legend).parent();

    $(legend).children('span').toggleClass('ui-icon-triangle-1-e ui-icon-triangle-1-s');
    fieldset.find('section').slideToggle();
}

function scelliusCategoryTableVisibility() {
    var category = $('select#SCELLIUS_COMMON_CATEGORY option:selected').val();

    if (category === 'CUSTOM_MAPPING') {
        $('.scellius_category_mapping').show();
        $('.scellius_category_mapping select').removeAttr('disabled');
    } else {
        $('.scellius_category_mapping').hide();
        $('.scellius_category_mapping select').attr('disabled', 'disabled');
    }
}

function scelliusDeliveryTypeChanged(key) {
    var type = $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_type').val();

    if (type === 'RECLAIM_IN_SHOP') {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_address').show();
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_zip').show();
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_city').show();
    } else {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_address').val('');
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_zip').val('');
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_city').val('');

        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_address').hide();
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_zip').hide();
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_city').hide();
    }

    var speed = $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_speed').val();
    if (speed === 'PRIORITY') {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_delay').show();
    } else {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_delay').hide();
    }
}

function scelliusDeliverySpeedChanged(key) {
    var speed = $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_speed').val();
    var type = $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_type').val();

    if (speed === 'PRIORITY') {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_delay').show();
    } else {
        $('#SCELLIUS_ONEY_SHIP_OPTIONS_' + key + '_delay').hide();
    }
}

function scelliusRedirectChanged() {
    var redirect = $('select#SCELLIUS_REDIRECT_ENABLED option:selected').val();

    if (redirect === 'True') {
        $('#scellius_redirect_settings').show();
        $('#scellius_redirect_settings select, #scellius_redirect_settings input').removeAttr('disabled');
    } else {
        $('#scellius_redirect_settings').hide();
        $('#scellius_redirect_settings select, #scellius_redirect_settings input').attr('disabled', 'disabled');
    }
}

function scelliusOneyEnableOptionsChanged() {
    var enable = $('select#SCELLIUS_ONEY_ENABLE_OPTIONS option:selected').val();

    if (enable === 'True') {
        $('#scellius_oney_options_settings').show();
        $('#scellius_oney_options_settings select, #scellius_oney_options_settings input').removeAttr('disabled');
    } else {
        $('#scellius_oney_options_settings').hide();
        $('#scellius_oney_options_settings select, #scellius_oney_options_settings input').attr('disabled', 'disabled');
    }
}

function scelliusFullcbEnableOptionsChanged() {
    var enable = $('select#SCELLIUS_FULLCB_ENABLE_OPTS option:selected').val();

    if (enable === 'True') {
        $('#scellius_fullcb_options_settings').show();
        $('#scellius_fullcb_options_settings select, #scellius_fullcb_options_settings input').removeAttr('disabled');
    } else {
        $('#scellius_fullcb_options_settings').hide();
        $('#scellius_fullcb_options_settings select, #scellius_fullcb_options_settings input').attr('disabled', 'disabled');
    }
}

function scelliusHideOtherLanguage(id, name) {
    $('.translatable-field').hide();
    $('.lang-' + id).css('display', 'inline');

    $('.translation-btn button span').text(name);

    var id_old_language = id_language;
    id_language = id;

    if (id_old_language !== id) {
        changeEmployeeLanguage();
    }
}

function scelliusCardEntryChanged() {
    var cardDataMode = $('select#SCELLIUS_STD_CARD_DATA_MODE option:selected').val();

    switch (cardDataMode) {
        case '4':
            $('#SCELLIUS_REST_SETTINGS').hide();
            $('#SCELLIUS_STD_CANCEL_IFRAME_MENU').show();
            break;
        case '5':
            $('#SCELLIUS_REST_SETTINGS').show();
            $('#SCELLIUS_STD_CANCEL_IFRAME_MENU').hide();
            break;
        default:
            $('#SCELLIUS_REST_SETTINGS').hide();
            $('#SCELLIUS_STD_CANCEL_IFRAME_MENU').hide();
    }
}

function scelliusAddOtherPaymentMeansOption(first) {
    if (first) {
        $('#scellius_other_payment_means_options_btn').hide();
        $('#scellius_other_payment_means_options_table').show();
        $('#SCELLIUS_OTHER_PAYMENT_MEANS').remove();
    }

    var timestamp = new Date().getTime();

    var rowTpl = $('#scellius_other_payment_means_row_option').html();
    rowTpl = rowTpl.replace(/SCELLIUS_OTHER_PAYMENT_SCRIPT_MEANS_KEY/g, '' + timestamp);

    $(rowTpl).insertBefore('#scellius_other_payment_means_option_add');
}

function scelliusDeleteOtherPaymentMeansOption(key) {
    $('#scellius_other_payment_means_option_' + key).remove();

    if ($('#scellius_other_payment_means_options_table tbody tr').length === 1) {
        $('#scellius_other_payment_means_options_btn').show();
        $('#scellius_other_payment_means_options_table').hide();
        $('#scellius_other_payment_means_options_table').append("<input type=\"hidden\" id=\"SCELLIUS_OTHER_PAYMENT_MEANS\" name=\"SCELLIUS_OTHER_PAYMENT_MEANS\" value=\"\">");
    }
}

function scelliusCountriesRestrictMenuDisplay(retrictCountriesPaymentId) {
    var countryRestrict = $('#' + retrictCountriesPaymentId).val();
    if (countryRestrict === '2') {
        $('#' + retrictCountriesPaymentId + '_MENU').show();
    } else {
        $('#' + retrictCountriesPaymentId + '_MENU').hide();
    }
}

function scelliusOneClickMenuDisplay() {
    var oneClickPayment = $('#SCELLIUS_STD_1_CLICK_PAYMENT').val();
    if (oneClickPayment == 'True') {
        $('#SCELLIUS_STD_1_CLICK_MENU').show();
    } else {
        $('#SCELLIUS_STD_1_CLICK_MENU').hide();
    }
}

function scelliusDisplayMultiSelect(selectId) {
    $('#' + selectId).show();
    $('#' + selectId).focus();
    $('#LABEL_' + selectId).hide();
}

function scelliusDisplayLabel(selectId, clickMessage) {
    $('#' + selectId).hide();
    $('#LABEL_' + selectId).show();
    $('#LABEL_' + selectId).text(scelliusGetLabelText(selectId, clickMessage));
}

function scelliusGetLabelText(selectId, clickMessage) {
    var select = document.getElementById(selectId);
    var labelText = '', option;

    for (var i = 0, len = select.options.length; i < len; i++) {
        option = select.options[i];

        if (option.selected) {
            labelText += option.text + ', ';
        }
    }

    labelText = labelText.substring(0, labelText.length - 2);
    if (!labelText) {
        labelText = clickMessage;
    }

    return labelText;
}
