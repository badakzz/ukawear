<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (! defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class that renders payment module administration interface.
 */
class ScelliusHelperForm
{
    private function __construct()
    {
        // Do not instantiate this class.
    }

    public static function getAdminFormContext()
    {
        $context = Context::getContext();

        /* @var Scellius */
        $scellius = Module::getInstanceByName('scellius');

        $languages = array();
        foreach (ScelliusApi::getSupportedLanguages() as $code => $label) {
            $languages[$code] = $scellius->l($label, 'scelliushelperform');
        }
        asort($languages);

        $category_options = array(
            'FOOD_AND_GROCERY' => $scellius->l('Food and grocery', 'scelliushelperform'),
            'AUTOMOTIVE' => $scellius->l('Automotive', 'scelliushelperform'),
            'ENTERTAINMENT' => $scellius->l('Entertainment', 'scelliushelperform'),
            'HOME_AND_GARDEN' => $scellius->l('Home and garden', 'scelliushelperform'),
            'HOME_APPLIANCE' => $scellius->l('Home appliance', 'scelliushelperform'),
            'AUCTION_AND_GROUP_BUYING' => $scellius->l('Auction and group buying', 'scelliushelperform'),
            'FLOWERS_AND_GIFTS' => $scellius->l('Flowers and gifts', 'scelliushelperform'),
            'COMPUTER_AND_SOFTWARE' => $scellius->l('Computer and software', 'scelliushelperform'),
            'HEALTH_AND_BEAUTY' => $scellius->l('Health and beauty', 'scelliushelperform'),
            'SERVICE_FOR_INDIVIDUAL' => $scellius->l('Service for individual', 'scelliushelperform'),
            'SERVICE_FOR_BUSINESS' => $scellius->l('Service for business', 'scelliushelperform'),
            'SPORTS' => $scellius->l('Sports', 'scelliushelperform'),
            'CLOTHING_AND_ACCESSORIES' => $scellius->l('Clothing and accessories', 'scelliushelperform'),
            'TRAVEL' => $scellius->l('Travel', 'scelliushelperform'),
            'HOME_AUDIO_PHOTO_VIDEO' => $scellius->l('Home audio, photo, video', 'scelliushelperform'),
            'TELEPHONY' => $scellius->l('Telephony', 'scelliushelperform')
        );

        // Get documentation links.
        $doc_files = array();
        $filenames = glob(_PS_MODULE_DIR_ . 'scellius/installation_doc/' . ScelliusTools::getDocPattern());

        $doc_languages = array(
            'fr' => 'Français',
            'en' => 'English',
            'es' => 'Español',
            'de' => 'Deutsch'
            // Complete when other languages are managed.
        );

        foreach ($filenames as $filename) {
            $base_filename = basename($filename, '.pdf');
            $lang = Tools::substr($base_filename, -2); // Extract language code.

            $doc_files[$base_filename . '.pdf'] = $doc_languages[$lang];
        }

        $placeholders = self::getArrayConfig('SCELLIUS_STD_REST_PLACEHLDR');
        if (empty($placeholders)) {
            $placeholders = array('pan' => '', 'expiry' => '', 'cvv' => '');
        }

        $enabledCountries = Country::getCountries((int) $context->language->id, true);
        $all_countries =    Country::getCountries((int) $context->language->id, false);
        $countryList = array();
        foreach ($enabledCountries as $value) {
            $countryList['ps_countries'][$value['iso_code']] = $value['name'];
        }

        foreach (ScelliusTools::$submodules as $key => $module) {
            $module_class_name = 'Scellius' . $module.'Payment';
            $instance_module = new $module_class_name();
            if (method_exists($instance_module, 'getCountries') && $instance_module->getCountries()) {
                $submodule_specific_countries = $instance_module->getCountries();
                foreach ($submodule_specific_countries as $country) {
                    if (isset($countryList['ps_countries'][$country])) {
                        $countryList[$key][$country] = $countryList['ps_countries'][$country];
                    }
                }
            }
        }

        foreach ($all_countries as $value) {
            if ($value['iso_code'] === 'FR') {
                $countryList['FULLCB']['FR'] = $value['name'];
                break;
            }
        }

        $tpl_vars = array(
            'scellius_support_email' => ScelliusTools::getDefault('SUPPORT_EMAIL'),
            'scellius_plugin_version' => ScelliusTools::getDefault('PLUGIN_VERSION'),
            'scellius_gateway_version' => ScelliusTools::getDefault('GATEWAY_VERSION'),

            'scellius_plugin_features' => ScelliusTools::$plugin_features,
            'scellius_request_uri' => $_SERVER['REQUEST_URI'],

            'scellius_doc_files' => $doc_files,
            'scellius_enable_disable_options' => array(
                'False' => $scellius->l('Disabled', 'scelliushelperform'),
                'True' => $scellius->l('Enabled', 'scelliushelperform')
            ),
            'scellius_mode_options' => array(
                'TEST' => $scellius->l('TEST', 'scelliushelperform'),
                'PRODUCTION' => $scellius->l('PRODUCTION', 'scelliushelperform')
            ),
            'scellius_language_options' => $languages,
            'scellius_validation_mode_options' => array(
                '' => $scellius->l('Bank Back Office configuration', 'scelliushelperform'),
                '0' => $scellius->l('Automatic', 'scelliushelperform'),
                '1' => $scellius->l('Manual', 'scelliushelperform')
            ),
            'scellius_payment_cards_options' => array('' => $scellius->l('ALL', 'scelliushelperform')) + ScelliusTools::getSupportedCardTypes(),
            'scellius_multi_payment_cards_options' => array('' => $scellius->l('ALL', 'scelliushelperform')) + ScelliusTools::getSupportedMultiCardTypes(),
            'scellius_category_options' => $category_options,
            'scellius_yes_no_options' => array(
                'False' => $scellius->l('No', 'scelliushelperform'),
                'True' => $scellius->l('Yes', 'scelliushelperform')
            ),
            'scellius_delivery_type_options' => array(
                'PACKAGE_DELIVERY_COMPANY' => $scellius->l('Delivery company', 'scelliushelperform'),
                'RECLAIM_IN_SHOP' => $scellius->l('Reclaim in shop', 'scelliushelperform'),
                'RELAY_POINT' => $scellius->l('Relay point', 'scelliushelperform'),
                'RECLAIM_IN_STATION' => $scellius->l('Reclaim in station', 'scelliushelperform')
            ),
            'scellius_delivery_speed_options' => array(
                'STANDARD' => $scellius->l('Standard', 'scelliushelperform'),
                'EXPRESS' => $scellius->l('Express', 'scelliushelperform'),
                'PRIORITY' => $scellius->l('Priority', 'scelliushelperform')
            ),
            'scellius_delivery_delay_options' => array(
                'INFERIOR_EQUALS' => $scellius->l('<= 1 hour', 'scelliushelperform'),
                'SUPERIOR' => $scellius->l('> 1 hour', 'scelliushelperform'),
                'IMMEDIATE' => $scellius->l('Immediate', 'scelliushelperform'),
                'ALWAYS' => $scellius->l('24/7', 'scelliushelperform')
            ),
            'scellius_failure_management_options' => array(
                ScelliusTools::ON_FAILURE_RETRY => $scellius->l('Go back to checkout', 'scelliushelperform'),
                ScelliusTools::ON_FAILURE_SAVE => $scellius->l('Save order and go back to order history', 'scelliushelperform')
            ),
            'scellius_cart_management_options' => array(
                ScelliusTools::EMPTY_CART => $scellius->l('Empty cart to avoid amount errors', 'scelliushelperform'),
                ScelliusTools::KEEP_CART => $scellius->l('Keep cart (PrestaShop default behavior)', 'scelliushelperform')
            ),
            'scellius_card_data_mode_options' => array(
                '1' => $scellius->l('Bank data acquisition on payment gateway', 'scelliushelperform'),
                '2' => $scellius->l('Card type selection on merchant site', 'scelliushelperform'),
                '4' => $scellius->l('Payment page integrated to checkout process (iframe mode)', 'scelliushelperform'),
                '5' => $scellius->l('Embedded payment fields (REST API)', 'scelliushelperform')
            ),
            'scellius_countries_options' => array(
                '1' => $scellius->l('All Allowed Countries', 'scelliushelperform'),
                '2' => $scellius->l('Specific Countries', 'scelliushelperform')
            ),
            'scellius_countries_list' => $countryList,
            'scellius_card_selection_mode_options' => array(
                '1' => $scellius->l('On payment gateway', 'scelliushelperform'),
                '2' => $scellius->l('On merchant site', 'scelliushelperform')
            ),
            'scellius_default_multi_option' => array(
                'label' => '',
                'min_amount' => '',
                'max_amount' => '',
                'contract' => '',
                'count' => '',
                'period' => '',
                'first' => ''
            ),
            'scellius_default_oney_option' => array(
                'label' => '',
                'code' => '',
                'min_amount' => '',
                'max_amount' => '',
                'count' => '',
                'rate' => ''
            ),
            'scellius_default_other_payment_means_option' => array(
                'title' => '',
                'code' => '',
                'min_amount' => '',
                'max_amount' => '',
                'validation' => '-1',
                'capture' => '',
                'cart' => 'False'
            ),
            'scellius_rest_display_mode_options' => array(
                'embedded' => $scellius->l('Directly on merchant site', 'scelliushelperform'),
                'popin' => $scellius->l('In a pop-in', 'scelliushelperform')
            ),
            'scellius_std_rest_theme_options' => array(
                'classic' =>  'Classic',
                'material' => 'Material'
            ),

            'prestashop_categories' => Category::getCategories((int) $context->language->id, true, false),
            'prestashop_languages' => Language::getLanguages(false),
            'prestashop_lang' => Language::getLanguage((int) $context->language->id),
            'prestashop_carriers' => Carrier::getCarriers(
                (int) $context->language->id,
                true,
                false,
                false,
                null,
                Carrier::ALL_CARRIERS
            ),
            'prestashop_groups' => self::getAuthorizedGroups(),
            'scellius_sepa_mandate_mode_options' => array(
                'PAYMENT' => $scellius->l('One-off SEPA direct debit', 'scelliushelperform'),
                'REGISTER_PAY' => $scellius->l('Register a recurrent SEPA mandate with direct debit', 'scelliushelperform'),
                'REGISTER' => $scellius->l('Register a recurrent SEPA mandate without direct debit', 'scelliushelperform')
            ),

            'SCELLIUS_ENABLE_LOGS' => Configuration::get('SCELLIUS_ENABLE_LOGS'),

            'SCELLIUS_SITE_ID' => Configuration::get('SCELLIUS_SITE_ID'),
            'SCELLIUS_KEY_TEST' => Configuration::get('SCELLIUS_KEY_TEST'),
            'SCELLIUS_KEY_PROD' => Configuration::get('SCELLIUS_KEY_PROD'),
            'SCELLIUS_MODE' => Configuration::get('SCELLIUS_MODE'),
            'SCELLIUS_SIGN_ALGO' => Configuration::get('SCELLIUS_SIGN_ALGO'),
            'SCELLIUS_PLATFORM_URL' => Configuration::get('SCELLIUS_PLATFORM_URL'),
            'SCELLIUS_NOTIFY_URL' => self::getIpnUrl(),

            'SCELLIUS_PUBKEY_TEST' => Configuration::get('SCELLIUS_PUBKEY_TEST'),
            'SCELLIUS_PRIVKEY_TEST' => Configuration::get('SCELLIUS_PRIVKEY_TEST'),
            'SCELLIUS_PUBKEY_PROD' => Configuration::get('SCELLIUS_PUBKEY_PROD'),
            'SCELLIUS_PRIVKEY_PROD' => Configuration::get('SCELLIUS_PRIVKEY_PROD'),
            'SCELLIUS_RETKEY_TEST' => Configuration::get('SCELLIUS_RETKEY_TEST'),
            'SCELLIUS_RETKEY_PROD' => Configuration::get('SCELLIUS_RETKEY_PROD'),
            'SCELLIUS_REST_NOTIFY_URL' => self::getIpnUrl(),

            'SCELLIUS_DEFAULT_LANGUAGE' => Configuration::get('SCELLIUS_DEFAULT_LANGUAGE'),
            'SCELLIUS_AVAILABLE_LANGUAGES' => ! Configuration::get('SCELLIUS_AVAILABLE_LANGUAGES') ?
                                            array('') :
                                            explode(';', Configuration::get('SCELLIUS_AVAILABLE_LANGUAGES')),
            'SCELLIUS_DELAY' => Configuration::get('SCELLIUS_DELAY'),
            'SCELLIUS_VALIDATION_MODE' => Configuration::get('SCELLIUS_VALIDATION_MODE'),

            'SCELLIUS_THEME_CONFIG' => self::getLangConfig('SCELLIUS_THEME_CONFIG'),
            'SCELLIUS_SHOP_NAME' => Configuration::get('SCELLIUS_SHOP_NAME'),
            'SCELLIUS_SHOP_URL' => Configuration::get('SCELLIUS_SHOP_URL'),

            'SCELLIUS_3DS_MIN_AMOUNT' => self::getArrayConfig('SCELLIUS_3DS_MIN_AMOUNT'),

            'SCELLIUS_REDIRECT_ENABLED' => Configuration::get('SCELLIUS_REDIRECT_ENABLED'),
            'SCELLIUS_REDIRECT_SUCCESS_T' => Configuration::get('SCELLIUS_REDIRECT_SUCCESS_T'),
            'SCELLIUS_REDIRECT_SUCCESS_M' => self::getLangConfig('SCELLIUS_REDIRECT_SUCCESS_M'),
            'SCELLIUS_REDIRECT_ERROR_T' => Configuration::get('SCELLIUS_REDIRECT_ERROR_T'),
            'SCELLIUS_REDIRECT_ERROR_M' => self::getLangConfig('SCELLIUS_REDIRECT_ERROR_M'),
            'SCELLIUS_RETURN_MODE' => Configuration::get('SCELLIUS_RETURN_MODE'),
            'SCELLIUS_FAILURE_MANAGEMENT' => Configuration::get('SCELLIUS_FAILURE_MANAGEMENT'),
            'SCELLIUS_CART_MANAGEMENT' => Configuration::get('SCELLIUS_CART_MANAGEMENT'),

            'SCELLIUS_SEND_CART_DETAIL' => Configuration::get('SCELLIUS_SEND_CART_DETAIL'),
            'SCELLIUS_COMMON_CATEGORY' => Configuration::get('SCELLIUS_COMMON_CATEGORY'),
            'SCELLIUS_CATEGORY_MAPPING' => self::getArrayConfig('SCELLIUS_CATEGORY_MAPPING'),
            'SCELLIUS_SEND_SHIP_DATA' => Configuration::get('SCELLIUS_SEND_SHIP_DATA'),
            'SCELLIUS_ONEY_SHIP_OPTIONS' => self::getArrayConfig('SCELLIUS_ONEY_SHIP_OPTIONS'),

            'SCELLIUS_STD_TITLE' => self::getLangConfig('SCELLIUS_STD_TITLE'),
            'SCELLIUS_STD_ENABLED' => Configuration::get('SCELLIUS_STD_ENABLED'),
            'SCELLIUS_STD_AMOUNTS' => self::getArrayConfig('SCELLIUS_STD_AMOUNTS'),
            'SCELLIUS_STD_DELAY' => Configuration::get('SCELLIUS_STD_DELAY'),
            'SCELLIUS_STD_VALIDATION' => Configuration::get('SCELLIUS_STD_VALIDATION'),
            'SCELLIUS_STD_PAYMENT_CARDS' => ! Configuration::get('SCELLIUS_STD_PAYMENT_CARDS') ?
                                            array('') :
                                            explode(';', Configuration::get('SCELLIUS_STD_PAYMENT_CARDS')),
            'SCELLIUS_STD_PROPOSE_ONEY' => Configuration::get('SCELLIUS_STD_PROPOSE_ONEY'),
            'SCELLIUS_STD_CARD_DATA_MODE' => Configuration::get('SCELLIUS_STD_CARD_DATA_MODE'),
            'SCELLIUS_STD_REST_DISPLAY_MODE' => Configuration::get('SCELLIUS_STD_REST_DISPLAY_MODE'),
            'SCELLIUS_STD_REST_THEME' => Configuration::get('SCELLIUS_STD_REST_THEME'),
            'SCELLIUS_STD_REST_PLACEHLDR' => $placeholders,
            'SCELLIUS_STD_REST_ATTEMPTS' => Configuration::get('SCELLIUS_STD_REST_ATTEMPTS'),
            'SCELLIUS_STD_1_CLICK_PAYMENT' => Configuration::get('SCELLIUS_STD_1_CLICK_PAYMENT'),
            'SCELLIUS_STD_CANCEL_IFRAME' => Configuration::get('SCELLIUS_STD_CANCEL_IFRAME'),

            'SCELLIUS_MULTI_TITLE' => self::getLangConfig('SCELLIUS_MULTI_TITLE'),
            'SCELLIUS_MULTI_ENABLED' => Configuration::get('SCELLIUS_MULTI_ENABLED'),
            'SCELLIUS_MULTI_AMOUNTS' => self::getArrayConfig('SCELLIUS_MULTI_AMOUNTS'),
            'SCELLIUS_MULTI_DELAY' => Configuration::get('SCELLIUS_MULTI_DELAY'),
            'SCELLIUS_MULTI_VALIDATION' => Configuration::get('SCELLIUS_MULTI_VALIDATION'),
            'SCELLIUS_MULTI_CARD_MODE' => Configuration::get('SCELLIUS_MULTI_CARD_MODE'),
            'SCELLIUS_MULTI_PAYMENT_CARDS' => ! Configuration::get('SCELLIUS_MULTI_PAYMENT_CARDS') ?
                                            array('') :
                                            explode(';', Configuration::get('SCELLIUS_MULTI_PAYMENT_CARDS')),
            'SCELLIUS_MULTI_OPTIONS' => self::getArrayConfig('SCELLIUS_MULTI_OPTIONS'),

            'SCELLIUS_ANCV_TITLE' => self::getLangConfig('SCELLIUS_ANCV_TITLE'),
            'SCELLIUS_ANCV_ENABLED' => Configuration::get('SCELLIUS_ANCV_ENABLED'),
            'SCELLIUS_ANCV_AMOUNTS' => self::getArrayConfig('SCELLIUS_ANCV_AMOUNTS'),
            'SCELLIUS_ANCV_DELAY' => Configuration::get('SCELLIUS_ANCV_DELAY'),
            'SCELLIUS_ANCV_VALIDATION' => Configuration::get('SCELLIUS_ANCV_VALIDATION'),

            'SCELLIUS_ONEY_TITLE' => self::getLangConfig('SCELLIUS_ONEY_TITLE'),
            'SCELLIUS_ONEY_ENABLED' => Configuration::get('SCELLIUS_ONEY_ENABLED'),
            'SCELLIUS_ONEY_AMOUNTS' => self::getArrayConfig('SCELLIUS_ONEY_AMOUNTS'),
            'SCELLIUS_ONEY_DELAY' => Configuration::get('SCELLIUS_ONEY_DELAY'),
            'SCELLIUS_ONEY_VALIDATION' => Configuration::get('SCELLIUS_ONEY_VALIDATION'),
            'SCELLIUS_ONEY_ENABLE_OPTIONS' => Configuration::get('SCELLIUS_ONEY_ENABLE_OPTIONS'),
            'SCELLIUS_ONEY_OPTIONS' => self::getArrayConfig('SCELLIUS_ONEY_OPTIONS'),

            'SCELLIUS_ONEY34_TITLE' => self::getLangConfig('SCELLIUS_ONEY34_TITLE'),
            'SCELLIUS_ONEY34_ENABLED' => Configuration::get('SCELLIUS_ONEY34_ENABLED'),
            'SCELLIUS_ONEY34_AMOUNTS' => self::getArrayConfig('SCELLIUS_ONEY34_AMOUNTS'),
            'SCELLIUS_ONEY34_DELAY' => Configuration::get('SCELLIUS_ONEY34_DELAY'),
            'SCELLIUS_ONEY34_VALIDATION' => Configuration::get('SCELLIUS_ONEY34_VALIDATION'),
            'SCELLIUS_ONEY34_ENABLE_OPTIONS' => Configuration::get('SCELLIUS_ONEY34_ENABLE_OPTIONS'),
            'SCELLIUS_ONEY34_OPTIONS' => self::getArrayConfig('SCELLIUS_ONEY34_OPTIONS'),

            'SCELLIUS_FULLCB_TITLE' => self::getLangConfig('SCELLIUS_FULLCB_TITLE'),
            'SCELLIUS_FULLCB_ENABLED' => Configuration::get('SCELLIUS_FULLCB_ENABLED'),
            'SCELLIUS_FULLCB_AMOUNTS' => self::getArrayConfig('SCELLIUS_FULLCB_AMOUNTS'),
            'SCELLIUS_FULLCB_ENABLE_OPTS' => Configuration::get('SCELLIUS_FULLCB_ENABLE_OPTS'),
            'SCELLIUS_FULLCB_OPTIONS' => self::getArrayConfig('SCELLIUS_FULLCB_OPTIONS'),

            'SCELLIUS_SEPA_TITLE' => self::getLangConfig('SCELLIUS_SEPA_TITLE'),
            'SCELLIUS_SEPA_ENABLED' => Configuration::get('SCELLIUS_SEPA_ENABLED'),
            'SCELLIUS_SEPA_AMOUNTS' => self::getArrayConfig('SCELLIUS_SEPA_AMOUNTS'),
            'SCELLIUS_SEPA_DELAY' => Configuration::get('SCELLIUS_SEPA_DELAY'),
            'SCELLIUS_SEPA_VALIDATION' => Configuration::get('SCELLIUS_SEPA_VALIDATION'),
            'SCELLIUS_SEPA_MANDATE_MODE' => Configuration::get('SCELLIUS_SEPA_MANDATE_MODE'),

            'SCELLIUS_SOFORT_TITLE' => self::getLangConfig('SCELLIUS_SOFORT_TITLE'),
            'SCELLIUS_SOFORT_ENABLED' => Configuration::get('SCELLIUS_SOFORT_ENABLED'),
            'SCELLIUS_SOFORT_AMOUNTS' => self::getArrayConfig('SCELLIUS_SOFORT_AMOUNTS'),

            'SCELLIUS_PAYPAL_TITLE' => self::getLangConfig('SCELLIUS_PAYPAL_TITLE'),
            'SCELLIUS_PAYPAL_ENABLED' => Configuration::get('SCELLIUS_PAYPAL_ENABLED'),
            'SCELLIUS_PAYPAL_AMOUNTS' => self::getArrayConfig('SCELLIUS_PAYPAL_AMOUNTS'),
            'SCELLIUS_PAYPAL_DELAY' => Configuration::get('SCELLIUS_PAYPAL_DELAY'),
            'SCELLIUS_PAYPAL_VALIDATION' => Configuration::get('SCELLIUS_PAYPAL_VALIDATION'),

            'SCELLIUS_CHOOZEO_TITLE' => self::getLangConfig('SCELLIUS_CHOOZEO_TITLE'),
            'SCELLIUS_CHOOZEO_ENABLED' => Configuration::get('SCELLIUS_CHOOZEO_ENABLED'),
            'SCELLIUS_CHOOZEO_AMOUNTS' => self::getArrayConfig('SCELLIUS_CHOOZEO_AMOUNTS'),
            'SCELLIUS_CHOOZEO_DELAY' => Configuration::get('SCELLIUS_CHOOZEO_DELAY'),
            'SCELLIUS_CHOOZEO_OPTIONS' => self::getArrayConfig('SCELLIUS_CHOOZEO_OPTIONS'),

            'SCELLIUS_OTHER_GROUPED_VIEW' => Configuration::get('SCELLIUS_OTHER_GROUPED_VIEW'),
            'SCELLIUS_OTHER_ENABLED' => Configuration::get('SCELLIUS_OTHER_ENABLED'),
            'SCELLIUS_OTHER_TITLE' => self::getLangConfig('SCELLIUS_OTHER_TITLE'),
            'SCELLIUS_OTHER_AMOUNTS' => self::getArrayConfig('SCELLIUS_OTHER_AMOUNTS'),
            'SCELLIUS_OTHER_PAYMENT_MEANS' => self::getArrayConfig('SCELLIUS_OTHER_PAYMENT_MEANS')
        );

        foreach (ScelliusTools::$submodules as $key => $module) {
            $tpl_vars['SCELLIUS_' . $key . '_COUNTRY'] = Configuration::get('SCELLIUS_' . $key . '_COUNTRY');
            $tpl_vars['SCELLIUS_' . $key . '_COUNTRY_LST'] = ! Configuration::get('SCELLIUS_' . $key . '_COUNTRY_LST') ?
                array() : explode(';', Configuration::get('SCELLIUS_' . $key . '_COUNTRY_LST'));
        }

        if (! ScelliusTools::$plugin_features['embedded']) {
            unset($tpl_vars['scellius_card_data_mode_options']['5']);
        }

        return $tpl_vars;
    }

    private static function getIpnUrl()
    {
        $shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));

        // SSL enabled on default shop?
        $id_shop_group = isset($shop->id_shop_group) ? $shop->id_shop_group : $shop->id_group_shop;
        $ssl = Configuration::get('PS_SSL_ENABLED', null, $id_shop_group, $shop->id);

        $ipn = ($ssl ? 'https://' . $shop->domain_ssl : 'http://' . $shop->domain)
            . $shop->getBaseURI() . 'modules/scellius/validation.php';

        return $ipn;
    }

    private static function getArrayConfig($name)
    {
        $value = @unserialize(Configuration::get($name));

        if (! is_array($value)) {
            $value = array();
        }

        return $value;
    }

    private static function getLangConfig($name)
    {
        $languages = Language::getLanguages(false);

        $result = array();
        foreach ($languages as $language) {
            $result[$language['id_lang']] = Configuration::get($name, $language['id_lang']);
        }

        return $result;
    }

    private static function getAuthorizedGroups()
    {
        $context = Context::getContext();

        /* @var Scellius */
        $scellius = Module::getInstanceByName('scellius');

        $sql = 'SELECT DISTINCT gl.`id_group`, gl.`name` FROM `' . _DB_PREFIX_ . 'group_lang` AS gl
            INNER JOIN `' . _DB_PREFIX_ . 'module_group` AS mg
            ON (
                gl.`id_group` = mg.`id_group`
                AND mg.`id_module` = ' . (int) $scellius->id . '
                AND mg.`id_shop` = ' . (int) $context->shop->id . '
            )
            WHERE gl.`id_lang` = ' . (int) $context->language->id;

        return Db::getInstance()->executeS($sql);
    }
}
