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

class ScelliusTools
{
    private static $GATEWAY_CODE = 'Scellius';
    private static $GATEWAY_NAME = 'Scellius';
    private static $BACKOFFICE_NAME = 'Scellius';
    private static $GATEWAY_URL = 'https://scelliuspaiement.labanquepostale.fr/vads-payment/';
    private static $REST_URL = 'https://api.scelliuspaiement.labanquepostale.fr/api-payment/';
    private static $STATIC_URL = 'https://api.scelliuspaiement.labanquepostale.fr/static/';
    private static $SITE_ID = '12345678';
    private static $KEY_TEST = '1111111111111111';
    private static $KEY_PROD = '2222222222222222';
    private static $CTX_MODE = 'TEST';
    private static $SIGN_ALGO = 'SHA-256';
    private static $LANGUAGE = 'fr';

    private static $CMS_IDENTIFIER = 'PrestaShop_1.5-1.7';
    private static $SUPPORT_EMAIL = 'commercant.cnm@labanquepostale.fr';
    private static $PLUGIN_VERSION = '1.13.2';
    private static $GATEWAY_VERSION = 'V2';

    const ORDER_ID_REGEX = '#^[a-zA-Z0-9]{1,9}$#';
    const CUST_ID_REGEX = '#^[a-zA-Z0-9]{1,8}$#';
    const PRODUCT_REF_REGEX = '#^[a-zA-Z0-9]{1,64}$#';

    const ON_FAILURE_RETRY = 'retry';
    const ON_FAILURE_SAVE = 'save';

    const EMPTY_CART = 'empty';
    const KEEP_CART = 'keep';

    /* Fields lists. */
    public static $multi_lang_fields = array(
        'SCELLIUS_REDIRECT_SUCCESS_M', 'SCELLIUS_REDIRECT_ERROR_M',
        'SCELLIUS_STD_TITLE', 'SCELLIUS_MULTI_TITLE', 'SCELLIUS_ONEY_TITLE', 'SCELLIUS_ONEY34_TITLE', 'SCELLIUS_ANCV_TITLE',
        'SCELLIUS_SEPA_TITLE', 'SCELLIUS_SOFORT_TITLE', 'SCELLIUS_PAYPAL_TITLE', 'SCELLIUS_CHOOZEO_TITLE', 'SCELLIUS_THEME_CONFIG',
        'SCELLIUS_FULLCB_TITLE', 'SCELLIUS_OTHER_TITLE'
    );

    public static $amount_fields = array();

    public static $group_amount_fields = array(
        'SCELLIUS_STD_AMOUNTS', 'SCELLIUS_MULTI_AMOUNTS', 'SCELLIUS_ANCV_AMOUNTS',
        'SCELLIUS_ONEY_AMOUNTS', 'SCELLIUS_ONEY34_AMOUNTS', 'SCELLIUS_SEPA_AMOUNTS',
        'SCELLIUS_SOFORT_AMOUNTS', 'SCELLIUS_PAYPAL_AMOUNTS', 'SCELLIUS_CHOOZEO_AMOUNTS',
        'SCELLIUS_CHOOZEO_OPTIONS', 'SCELLIUS_FULLCB_AMOUNTS', 'SCELLIUS_3DS_MIN_AMOUNT', 'SCELLIUS_OTHER_AMOUNTS'
    );

    public static $address_regex = array(
        'oney' => array(
            'name' => "#^[A-ZÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜÇ/ '-]{1,63}$#ui",
            'street' => "#^[A-Z0-9ÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜÇ/ '.,-]{1,127}$#ui",
            'zip' => '#^[0-9]{5}$#',
            'city' => "#^[A-Z0-9ÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜÇ/ '-]{1,127}$#ui",
            'country' => '#^FR|GP|MQ|GF|RE|YT$#i',
            'phone' => '#^[0-9]{10}$#'
        ),
        'fullcb' => array(
            'name' => "#^[A-Za-z0-9àâçèéêîôùû]+([ \-']?[A-Za-z0-9àâçèéêîôùû]+)*$#",
            'street' => '#^[^;]*$#',
            'zip' => '#^[0-9]{5}$#',
            'city' => '#^[^;]*$#',
            'country' => '#^FR$#',
            'phone' => '#^(0|33)[0-9]{9}$#'
        )
    );

    public static $plugin_features = array(
        'qualif' => false,
        'prodfaq' => true,
        'restrictmulti' => false,
        'shatwo' => true,
        'embedded' => true,

        'multi' => true,
        'choozeo' => false,
        'oney' => true,
        'ancv' => true,
        'sepa' => true,
        'sofort' => true,
        'paypal' => true,
        'fullcb' => true,
        'conecs' => true
    );

    public static $submodules = array(
        'STD' => 'Standard',
        'MULTI' => 'Multi',
        'CHOOZEO' => 'Choozeo',
        'ONEY' => 'Oney',
        'ONEY34' => 'Oney34',
        'FULLCB' => 'Fullcb',
        'ANCV' => 'Ancv',
        'SEPA'=> 'Sepa',
        'PAYPAL' => 'Paypal',
        'SOFORT' => 'Sofort',
        'OTHER' => 'Other'
    );

    public static function getDefault($name)
    {
        if (! is_string($name)) {
            return '';
        }

        if (! isset(self::$$name)) {
            return '';
        }

        return self::$$name;
    }

    public static function getDocPattern()
    {
        $version = self::getDefault('PLUGIN_VERSION');
        $minor = Tools::substr($version, 0, strrpos($version, '.'));

        return self::getDefault('GATEWAY_CODE') . '_' . self::getDefault('CMS_IDENTIFIER') . '_v' . $minor . '*.pdf';
    }

    public static function checkAddress($address, $type, $payment)
    {
        /* @var Scellius */
        $scellius = Module::getInstanceByName('scellius');

        $regex = self::$address_regex[$payment];
        $invalid_msg = $scellius->l('The field %1$s of your %2$s is invalid.', 'scelliustools');
        $empty_msg = $scellius->l('The field %1$s of your %2$s is mandatory.', 'scelliustools');

        $address_type = $type === 'billing' ? $scellius->l('billing address', 'scelliustools') :
            $scellius->l('delivery address', 'scelliustools');

        $errors = array();

        if (empty($address->lastname)) {
            $errors[] = sprintf($empty_msg, $scellius->l('Last name', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['name'], $address->lastname)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Last name', 'scelliustools'), $address_type);
        }

        if (empty($address->firstname)) {
            $errors[] = sprintf($empty_msg, $scellius->l('First name', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['name'], $address->firstname)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('First name', 'scelliustools'), $address_type);
        }

        if (! empty($address->phone) && ! preg_match($regex['phone'], $address->phone)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Phone', 'scelliustools'), $address_type);
        }

        if (! empty($address->phone_mobile) && ! preg_match($regex['phone'], $address->phone_mobile)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Phone mobile', 'scelliustools'), $address_type);
        }

        if (empty($address->address1)) {
            $errors[] = sprintf($empty_msg, $scellius->l('Address', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['street'], $address->address1)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Address', 'scelliustools'), $address_type);
        }

        if (! empty($address->address2) && ! preg_match($regex['street'], $address->address2)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Address2', 'scelliustools'), $address_type);
        }

        if (empty($address->postcode)) {
            $errors[] = sprintf($empty_msg, $scellius->l('Zip code', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['zip'], $address->postcode)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Zip code', 'scelliustools'), $address_type);
        }

        if (empty($address->city)) {
            $errors[] = sprintf($empty_msg, $scellius->l('City', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['city'], $address->city)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('City', 'scelliustools'), $address_type);
        }

        $country = new Country((int) $address->id_country);
        if (empty($country->iso_code)) {
            $errors[] = sprintf($empty_msg, $scellius->l('Country', 'scelliustools'), $address_type);
        } elseif (! preg_match($regex['country'], $country->iso_code)) {
            $errors[] = sprintf($invalid_msg, $scellius->l('Country', 'scelliustools'), $address_type);
        }

        return $errors;
    }

    /**
     * Return the list of configuration parameters with their scellius names and default values.
     *
     * @return array
     */
    public static function getAdminParameters()
    {
        // NB : keys are 32 chars max.
        $params = array(
            array('key' => 'SCELLIUS_ENABLE_LOGS', 'default' => 'True', 'label' => 'Logs'),

            array('key' => 'SCELLIUS_SITE_ID', 'name' => 'site_id', 'default' => self::getDefault('SITE_ID'), 'label' => 'Site ID'),
            array('key' => 'SCELLIUS_KEY_TEST', 'name' => 'key_test', 'default' => self::getDefault('KEY_TEST'),
                'label' => 'Certificate in test mode'),
            array('key' => 'SCELLIUS_KEY_PROD', 'name' => 'key_prod', 'default' => self::getDefault('KEY_PROD'),
                'label' => 'Certificate in production mode'),
            array('key' => 'SCELLIUS_MODE', 'name' => 'ctx_mode', 'default' => self::getDefault('CTX_MODE'), 'label' => 'Mode'),
            array('key' => 'SCELLIUS_SIGN_ALGO', 'name' => 'sign_algo', 'default' => self::getDefault('SIGN_ALGO'),
                'label' => 'Signature algorithm'),
            array('key' => 'SCELLIUS_PLATFORM_URL', 'name' => 'platform_url',
                'default' => self::getDefault('GATEWAY_URL'), 'label' => 'Payment page URL'),

            array('key' => 'SCELLIUS_PRIVKEY_TEST', 'default' => '', 'label' => 'Test password'),
            array('key' => 'SCELLIUS_PRIVKEY_PROD', 'default' => '', 'label' => 'Production password'),
            array('key' => 'SCELLIUS_PUBKEY_TEST', 'default' => '', 'label' => 'Public test key'),
            array('key' => 'SCELLIUS_PUBKEY_PROD', 'default' => '', 'label' => 'Public production key'),
            array('key' => 'SCELLIUS_RETKEY_TEST', 'default' => '', 'label' => 'SHA256 test key'),
            array('key' => 'SCELLIUS_RETKEY_PROD', 'default' => '', 'label' => 'SHA256 production key'),

            array('key' => 'SCELLIUS_DEFAULT_LANGUAGE', 'default' => self::getDefault('LANGUAGE'), 'label' => 'Default language'),
            array('key' => 'SCELLIUS_AVAILABLE_LANGUAGES', 'name' => 'available_languages', 'default' => '',
                'label' => 'Available languages'),
            array('key' => 'SCELLIUS_DELAY', 'name' => 'capture_delay', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_VALIDATION_MODE', 'name' => 'validation_mode', 'default' => '',
                'label' => 'Payment validation'),

            array('key' => 'SCELLIUS_THEME_CONFIG', 'name' => 'theme_config',
                'default' => array(
                    'en' => 'RESPONSIVE_MODEL=',
                    'fr' => 'RESPONSIVE_MODEL=',
                    'de' => 'RESPONSIVE_MODEL=',
                    'es' => 'RESPONSIVE_MODEL='
                ),
                'label' => 'Theme configuration'),
            array('key' => 'SCELLIUS_SHOP_NAME', 'name' => 'shop_name', 'default' => '', 'label' => 'Shop name'),
            array('key' => 'SCELLIUS_SHOP_URL', 'name' => 'shop_url', 'default' => '', 'label' => 'Shop URL'),

            array('key' => 'SCELLIUS_3DS_MIN_AMOUNT', 'default' => '', 'label' => 'Disable 3DS by customer group'),

            array('key' => 'SCELLIUS_REDIRECT_ENABLED', 'name' => 'redirect_enabled', 'default' => 'False',
                'label' => 'Automatic redirection'),
            array('key' => 'SCELLIUS_REDIRECT_SUCCESS_T', 'name' => 'redirect_success_timeout', 'default' => '5',
                'label' => 'Redirection timeout on success'),
            array('key' => 'SCELLIUS_REDIRECT_SUCCESS_M', 'name' => 'redirect_success_message',
                'default' => array(
                    'en' => 'Redirection to shop in few seconds...',
                    'fr' => 'Redirection vers la boutique dans quelques instants...',
                    'de' => 'Weiterleitung zum Shop in Kürze...',
                    'es' => 'Redirección a la tienda en unos momentos...'
                ),
                'label' => 'Redirection message on success'),
            array('key' => 'SCELLIUS_REDIRECT_ERROR_T', 'name' => 'redirect_error_timeout', 'default' => '5',
                'label' => 'Redirection timeout on failure'),
            array('key' => 'SCELLIUS_REDIRECT_ERROR_M', 'name' => 'redirect_error_message',
                'default' => array(
                    'en' => 'Redirection to shop in few seconds...',
                    'fr' => 'Redirection vers la boutique dans quelques instants...',
                    'de' => 'Weiterleitung zum Shop in Kürze...',
                    'es' => 'Redirección a la tienda en unos momentos...'
                ),
                'label' => 'Redirection message on failure'),
            array('key' => 'SCELLIUS_RETURN_MODE', 'name' => 'return_mode', 'default' => 'GET',
                'label' => 'Return mode'),
            array('key' => 'SCELLIUS_FAILURE_MANAGEMENT', 'default' => self::ON_FAILURE_RETRY,
                'label' => 'Payment failed management'),
            array('key' => 'SCELLIUS_CART_MANAGEMENT', 'default' => self::EMPTY_CART, 'label' => 'Cart management'),

            array('key' => 'SCELLIUS_SEND_CART_DETAIL', 'default' => 'True', 'label' => 'Send shopping cart details'),
            array('key' => 'SCELLIUS_COMMON_CATEGORY', 'default' => 'FOOD_AND_GROCERY',
                'label' => 'Category mapping'),
            array('key' => 'SCELLIUS_CATEGORY_MAPPING', 'default' => array(), 'label' => 'Category mapping'),
            array('key' => 'SCELLIUS_SEND_SHIP_DATA', 'default' => 'False',
                'label' => 'Always send advanced shipping data'),
            array('key' => 'SCELLIUS_ONEY_SHIP_OPTIONS', 'default' => array(), 'label' => 'Shipping options'),

            array('key' => 'SCELLIUS_STD_TITLE',
                'default' => array(
                    'en' => 'Payment by credit card',
                    'fr' => 'Paiement par carte bancaire',
                    'de' => 'Zahlung mit EC-/Kreditkarte',
                    'es' => 'Pago con tarjeta de crédito'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_STD_ENABLED', 'default' => 'True', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_STD_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_STD_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_STD_PAYMENT_CARDS', 'default' => '', 'label' => 'Card Types'),
            array('key' => 'SCELLIUS_STD_PROPOSE_ONEY', 'default' => 'False', 'label' => 'Propose FacilyPay Oney'),
            array('key' => 'SCELLIUS_STD_AMOUNTS', 'default' => array(), 'label' => 'Standard payment - Customer group amount restriction'),
            array('key' => 'SCELLIUS_STD_CARD_DATA_MODE', 'default' => '1', 'label' => 'Card data entry mode'),
            array('key' => 'SCELLIUS_STD_REST_DISPLAY_MODE', 'default' => 'embedded', 'label' => 'Display mode'),
            array('key' => 'SCELLIUS_STD_REST_THEME', 'default' => 'material', 'label' => 'Custom theme'),
            array('key' => 'SCELLIUS_STD_REST_PLACEHLDR', 'default' => array(), 'label' => 'Custom field placeholders'),
            array('key' => 'SCELLIUS_STD_REST_ATTEMPTS', 'default' => '', 'label' => 'Payment attempts number'),
            array('key' => 'SCELLIUS_STD_1_CLICK_PAYMENT', 'default' => 'False', 'label' => 'Payment by token'),
            array('key' => 'SCELLIUS_STD_CANCEL_IFRAME', 'default' => 'False', 'label' => 'Cancel payment in iframe mode'),

            array('key' => 'SCELLIUS_MULTI_TITLE',
                'default' => array(
                    'en' => 'Payment by credit card in installments',
                    'fr' => 'Paiement par carte bancaire en plusieurs fois',
                    'de' => 'Ratenzahlung mit EC-/Kreditkarte',
                    'es' => 'Pago con tarjeta de crédito en cuotas'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_MULTI_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_MULTI_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_MULTI_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_MULTI_PAYMENT_CARDS', 'default' => '', 'label' => 'Card Types'),
            array('key' => 'SCELLIUS_MULTI_CARD_MODE', 'default' => '1', 'label' => 'Card selection mode'),
            array('key' => 'SCELLIUS_MULTI_AMOUNTS', 'default' => array(), 'label' => 'Payment in installments - Customer group amount restriction'),
            array('key' => 'SCELLIUS_MULTI_OPTIONS', 'default' => array(), 'label' => 'Payment in installments - Payment options'),

            array('key' => 'SCELLIUS_ONEY_TITLE',
                'default' => array(
                    'en' => 'Payment with FacilyPay Oney (Deprecated)',
                    'fr' => 'Paiement avec FacilyPay Oney (Déprécié)',
                    'de' => 'Zahlung via FacilyPay Oney (Überholt)',
                    'es' => 'Pago con FacilyPay Oney (Obsoleto)'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_ONEY_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_ONEY_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_ONEY_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_ONEY_AMOUNTS', 'default' => array(), 'label' => 'FacilyPay Oney payment - Customer group amount restriction'),
            array('key' => 'SCELLIUS_ONEY_ENABLE_OPTIONS', 'default' => 'False',
                'label' => 'Enable options selection'),
            array('key' => 'SCELLIUS_ONEY_OPTIONS', 'default' => array(), 'label' => 'FacilyPay Oney payment - Payment options'),

            array('key' => 'SCELLIUS_ONEY34_TITLE',
                'default' => array(
                    'en' => 'Payment in 3 or 4 times Oney',
                    'fr' => 'Paiement en 3 ou 4 fois Oney',
                    'de' => 'Zahlung im 3 oder 4 mal Oney',
                    'es' => 'Pago en 3 o 4 veces Oney'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_ONEY34_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_ONEY34_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_ONEY34_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_ONEY34_AMOUNTS', 'default' => array(), 'label' => 'Payment in 3 or 4 times Oney - Customer group amount restriction'),
            array('key' => 'SCELLIUS_ONEY34_ENABLE_OPTIONS', 'default' => 'False',
                'label' => 'Enable options selection'),
            array('key' => 'SCELLIUS_ONEY34_OPTIONS', 'default' => array(), 'label' => 'Payment in 3 or 4 times Oney - Payment options'),

            array('key' => 'SCELLIUS_FULLCB_TITLE',
                'default' => array(
                    'en' => 'Payment with Full CB',
                    'fr' => 'Paiement avec Full CB',
                    'de' => 'Zahlung via Full CB',
                    'es' => 'Pago con Full CB'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_FULLCB_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_FULLCB_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_FULLCB_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_FULLCB_AMOUNTS',
                'default' => array(
                    array('min_amount' => '100', 'max_amount' => '1500')
                ),
                'label' => 'Full CB payment - Customer group amount restriction'),
            array('key' => 'SCELLIUS_FULLCB_ENABLE_OPTS', 'default' => 'False',
                'label' => 'Enable options selection'),
            array('key' => 'SCELLIUS_FULLCB_OPTIONS',
                'default' => array(
                    'FULLCB3X' => array(
                        'enabled' => 'True',
                        'label' => self::convertIsoArrayToIdArray(
                            array('en' => 'Payment in 3 times', 'fr' => 'Paiement en 3 fois', 'de' => 'Zahlung in 3 mal', 'es' => 'Pago en 3 veces')
                        ),
                        'min_amount' => '',
                        'max_amount' => '',
                        'rate' => '1.4',
                        'cap' => '9',
                        'count' => '3'
                    ),
                    'FULLCB4X' => array(
                        'enabled' => 'True',
                        'label' => self::convertIsoArrayToIdArray(
                            array('en' => 'Payment in 4 times', 'fr' => 'Paiement en 4 fois', 'de' => 'Zahlung in 4 mal', 'es' => 'Pago en 4 veces')
                        ),
                        'min_amount' => '',
                        'max_amount' => '',
                        'rate' => '2.1',
                        'cap' => '12',
                        'count' => '4'
                    )
                ),
                'label' => 'Full CB payment - Payment options'),

            array('key' => 'SCELLIUS_ANCV_TITLE',
                'default' => array(
                    'en' => 'Payment with ANCV',
                    'fr' => 'Paiement avec ANCV',
                    'de' => 'Zahlung via ANCV',
                    'es' => 'Pago con ANCV'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_ANCV_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_ANCV_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_ANCV_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_ANCV_AMOUNTS', 'default' => array(), 'label' => 'ANCV payment - Customer group amount restriction'),

            array('key' => 'SCELLIUS_SEPA_TITLE',
                'default' => array(
                    'en' => 'Payment with SEPA',
                    'fr' => 'Paiement avec SEPA',
                    'de' => 'Zahlung via SEPA',
                    'es' => 'Pago con SEPA'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_SEPA_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_SEPA_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_SEPA_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_SEPA_AMOUNTS', 'default' => array(), 'label' => 'SEPA payment - Customer group amount restriction'),
            array('key' => 'SCELLIUS_SEPA_MANDATE_MODE', 'default' => 'PAYMENT', 'label' => 'SEPA direct debit mode'),

            array('key' => 'SCELLIUS_SOFORT_TITLE',
                'default' => array(
                    'en' => 'Payment with SOFORT Banking',
                    'fr' => 'Paiement avec SOFORT Banking',
                    'de' => 'Zahlung via SOFORT Banking',
                    'es' => 'Pago con SOFORT Banking'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_SOFORT_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_SOFORT_AMOUNTS', 'default' => array(), 'label' => 'SOFORT Banking payment - Customer group amount restriction'),

            array('key' => 'SCELLIUS_PAYPAL_TITLE',
                'default' => array(
                    'en' => 'Payment with PayPal',
                    'fr' => 'Paiement avec PayPal',
                    'de' => 'Zahlung via  PayPal',
                    'es' => 'Pago con PayPal'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_PAYPAL_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_PAYPAL_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_PAYPAL_VALIDATION', 'default' => '-1', 'label' => 'Payment validation'),
            array('key' => 'SCELLIUS_PAYPAL_AMOUNTS', 'default' => array(), 'label' => 'PayPal payment - Customer group amount restriction'),

            array('key' => 'SCELLIUS_CHOOZEO_TITLE',
                'default' => array(
                    'en' => 'Payment with Choozeo without fees',
                    'fr' => 'Paiement avec Choozeo sans frais',
                    'de' => 'Zahlung mit Choozeo ohne zusätzliche',
                    'es' => 'Pago con Choozeo sin gastos'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_CHOOZEO_ENABLED', 'default' => 'False', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_CHOOZEO_DELAY', 'default' => '', 'label' => 'Capture delay'),
            array('key' => 'SCELLIUS_CHOOZEO_AMOUNTS',
                'default' => array(
                    array('min_amount' => '135', 'max_amount' => '2000')
                ),
                'label' => 'Choozeo payment - Customer group amount restriction'),
            array('key' => 'SCELLIUS_CHOOZEO_OPTIONS', 'default' => array(
                'EPNF_3X' => array(
                    'enabled' => 'True',
                    'min_amount' => '',
                    'max_amount' => ''
                ),
                'EPNF_4X' => array(
                    'enabled' => 'True',
                    'min_amount' => '',
                    'max_amount' => ''
                )
            ), 'label' => 'Choozeo payment - Payment options'),

            array('key' => 'SCELLIUS_OTHER_GROUPED_VIEW', 'default' => 'False', 'label' => 'Regroup payment means'),
            array('key' => 'SCELLIUS_OTHER_ENABLED', 'default' => 'True', 'label' => 'Activation'),
            array('key' => 'SCELLIUS_OTHER_TITLE',
                'default' => array(
                    'en' => 'Other payment means',
                    'fr' => 'Autres moyens de paiement',
                    'de' => 'Anderen Zahlungsmittel',
                    'es' => 'Otros medios de pago'
                ),
                'label' => 'Method title'),
            array('key' => 'SCELLIUS_OTHER_AMOUNTS', 'default' => array(), 'label' => 'Other payment means - Customer group amount restriction'),
            array('key' => 'SCELLIUS_OTHER_PAYMENT_MEANS', 'default' => array(), 'label' => 'Other payment means - Payment means')
        );

        foreach (array_keys(self::$submodules) as $key) {
            array_push($params, array('key' => 'SCELLIUS_' . $key . '_COUNTRY', 'default' => '1', 'label' => 'Restrict to some countries'));
            array_push($params, array('key' => 'SCELLIUS_' . $key . '_COUNTRY_LST', 'default' => '', 'label' => 'Authorized countries'));
        }

        return $params;
    }

    public static function convertIsoArrayToIdArray($array)
    {
        if (! is_array($array) || empty($array)) {
            return array();
        }

        $converted = array();

        foreach (Language::getLanguages(false) as $language) {
            $key = key_exists($language['iso_code'], $array) ? $language['iso_code'] : 'en';

            $converted[$language['id_lang']] = $array[$key];
        }

        return $converted;
    }

    public static function checkOneyRequirements($cart, $name = '')
    {
        // Check order_id param.
        if (! preg_match(self::ORDER_ID_REGEX, $cart->id)) {
            $msg = 'Order ID « % s» does not match ' . $name . ' specifications.';
            $msg .= ' The regular expression for this field is « %s ». Module is not displayed.';
            self::getLogger()->logWarning(sprintf($msg, $cart->id, self::ORDER_ID_REGEX));
            return false;
        }

        // Check customer ID param.
        if (! preg_match(self::CUST_ID_REGEX, $cart->id_customer)) {
            $msg = 'Customer ID « %s » does not match ' . $name . ' specifications.';
            $msg .= ' The regular expression for this field is « %s ». Module is not displayed.';
            self::getLogger()->logWarning(sprintf($msg, $cart->id_customer, self::CUST_ID_REGEX));
            return false;
        }

        // Check products.
        foreach ($cart->getProducts(true) as $product) {
            if (! preg_match(self::PRODUCT_REF_REGEX, $product['id_product'])) {
                // Product id doesn't match Oney rules.

                $msg = 'Product reference « %s » does not match ' . $name . ' specifications.';
                $msg .= ' The regular expression for this field is « %s ». Module is not displayed.';
                self::getLogger()->logWarning(sprintf($msg, $product['id_product'], self::PRODUCT_REF_REGEX));
                return false;
            }
        }

        return true;
    }

    public static function getSupportedCardTypes()
    {
        $cards = ScelliusApi::getSupportedCardTypes();

        if (isset($cards['ONEY'])) {
            unset($cards['ONEY']);
        }

        if (isset($cards['ONEY_SANDBOX'])) {
            unset($cards['ONEY_SANDBOX']);
        }

        if (isset($cards['ONEY_3X_4X'])) {
            unset($cards['ONEY_3X_4X']);
        }

        return $cards;
    }

    public static function getSupportedMultiCardTypes()
    {
        $multi_cards = array(
            'AMEX', 'CB', 'DINERS', 'DISCOVER', 'E-CARTEBLEUE', 'JCB', 'MASTERCARD',
            'PRV_BDP', 'PRV_BDT', 'PRV_OPT', 'PRV_SOC', 'VISA', 'VISA_ELECTRON', 'VPAY'
        );

        $cards = array();
        foreach (ScelliusApi::getSupportedCardTypes() as $code => $label) {
            if (in_array($code, $multi_cards)) {
                $cards[$code] = $label;
            }
        }

        return $cards;
    }

    /**
     * SoColissimo does not set delivery address ID into cart object.
     * So we get address data from SoColissimo database table.
     *
     * @param Cart $cart
     * @return Address|null
     */
    public static function getColissimoDeliveryAddress($cart)
    {
        // SoColissimo not available.
        if (! Configuration::get('SOCOLISSIMO_CARRIER_ID')) {
            return null;
        }

        // SoColissimo is not selected as shipping method.
        if ($cart->id_carrier != Configuration::get('SOCOLISSIMO_CARRIER_ID')) {
            return null;
        }

        // Get address saved by SoColissimo.
        $row = Db::getInstance()->getRow(
            'SELECT * FROM ' . _DB_PREFIX_ . 'socolissimo_delivery_info WHERE id_cart = \'' .
            (int) $cart->id . '\' AND id_customer = \'' . (int) $cart->id_customer . '\''
        );

        if (! $row) {
            return null;
        }

        $not_allowed_chars = array(' ', '.', '-', ',', ';', '+', '/', '\\', '+', '(', ')');
        $so_address = new Address();

        $ps_address = new Address((int) $cart->id_address_delivery);
        $id_country = Country::getByIso(pSQL($row['cecountry']));

        if (Tools::strtoupper($ps_address->lastname) != Tools::strtoupper($row['prname'])
            || $ps_address->id_country != $id_country
            || Tools::strtoupper($ps_address->firstname) != Tools::strtoupper($row['prfirstname'])
            || Tools::strtoupper($ps_address->address1) != Tools::strtoupper($row['pradress3'])
            || Tools::strtoupper($ps_address->address2) != Tools::strtoupper($row['pradress2'])
            || Tools::strtoupper($ps_address->postcode) != Tools::strtoupper($row['przipcode'])
            || Tools::strtoupper($ps_address->city) != Tools::strtoupper($row['prtown'])
            || str_replace($not_allowed_chars, '', $ps_address->phone_mobile) != $row['cephonenumber']) {
            $so_address->lastname = Tools::substr($row['cename'], 0, 32);
            $so_address->firstname = Tools::substr($row['cefirstname'], 0, 32);
            $so_address->postcode = $row['przipcode'];
            $so_address->city = $row['prtown'];
            $so_address->id_country = $id_country;
            $so_address->phone_mobile = $row['cephonenumber'];

            if (! in_array($row['delivery_mode'], array('DOM', 'RDV'))) {
                $so_address->company = Tools::substr($row['prfirstname'], 0, 31) . ' ' . Tools::substr($row['prname'], 0, 32);
                $so_address->address1 = $row['pradress1'];
                $so_address->address2 = $row['pradress2'];
            } else {
                $so_address->address1 = $row['pradress3'];
                $so_address->address2 = isset($row['pradress2']) ? $row['pradress2'] : '';
                $so_address->other = '';
                $so_address->other .= isset($row['pradress1']) ? $row['pradress1'] : '';
                $so_address->other .= isset($row['pradress4']) ? ' ' . $row['pradress4'] : '';
            }

            // Return the SoColissimo updated address.
            return $so_address;
        }

        // Use initial customer address.
        return null;
    }

    private static $logger;

    public static function getLogger()
    {
        if (! self::$logger) {
            self::$logger = new ScelliusFileLogger(Configuration::get('SCELLIUS_ENABLE_LOGS') !== 'False');

            $logs_dir = _PS_ROOT_DIR_ . '/var/logs/';
            if (! file_exists($logs_dir)) {
                $logs_dir = _PS_ROOT_DIR_ . '/app/logs/';
                if (! file_exists($logs_dir)) {
                    $logs_dir = _PS_ROOT_DIR_ . '/log/';
                }
            }

            self::$logger->setFilename($logs_dir.date('Y_m') . '_scellius.log');
        }

        return self::$logger;
    }

    public static function getTemplatePath($tpl)
    {
        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            return 'module:scellius/views/templates/front/' . $tpl;
        }

        return $tpl;
    }

    public static function getPageLink($relative_url)
    {
        $url = $relative_url;

        if (strpos($url, 'index.php?controller=') !== false && strpos($url, 'index.php') === 0) {
            $url = Tools::substr($url, Tools::strlen('index.php?controller='));
            if (Configuration::get('PS_REWRITING_SETTINGS')) {
                $url = Tools::strReplaceFirst('&', '?', $url);
            }
        }

        $explode = explode('?', $url);

        // Don't use ssl if url is home page.
        // Used when logout for example.
        $use_ssl = ! empty($url);
        $url = Context::getContext()->link->getPageLink($explode[0], $use_ssl);
        if (isset($explode[1])) {
            $url .= '?' . $explode[1];
        }

        return $url;
    }

    public static function convertRestResult($answer, $isTransaction = false)
    {
        if (! is_array($answer) || empty($answer)) {
            return array();
        }

        if ($isTransaction) {
            $transaction = $answer;
        } else {
            $transactions = self::getProperty($answer, 'transactions');

            if (! is_array($transactions) || empty($transactions)) {
                return array();
            }

            $transaction = $transactions[0];
        }

        $response = array();

        $response['vads_result'] = self::getProperty($transaction, 'errorCode') ? self::getProperty($transaction, 'errorCode') : '00';
        $response['vads_extra_result'] = self::getProperty($transaction, 'detailedErrorCode');

        $response['vads_trans_status'] = self::getProperty($transaction, 'detailedStatus');
        $response['vads_trans_uuid'] = self::getProperty($transaction, 'uuid');
        $response['vads_operation_type'] = self::getProperty($transaction, 'operationType');
        $response['vads_effective_creation_date'] = self::getProperty($transaction, 'creationDate');
        $response['vads_payment_config'] = 'SINGLE'; // Only single payments are possible via REST API at this time.

        if (($customer = self::getProperty($answer, 'customer')) && ($billingDetails = self::getProperty($customer, 'billingDetails'))) {
            $response['vads_language'] = self::getProperty($billingDetails, 'language');
        }

        $response['vads_amount'] = self::getProperty($transaction, 'amount');
        $response['vads_currency'] = ScelliusApi::getCurrencyNumCode(self::getProperty($transaction, 'currency'));

        if (self::getProperty($transaction, 'paymentMethodToken')) {
            $response['vads_identifier'] = self::getProperty($transaction, 'paymentMethodToken');
            $response['vads_identifier_status'] = 'CREATED';
        }

        if ($orderDetails = self::getProperty($answer, 'orderDetails')) {
            $response['vads_order_id'] = self::getProperty($orderDetails, 'orderId');
        }

        if ($metadata = self::getProperty($transaction, 'metadata')) {
            $orderInfo = key_exists('orderInfo', $metadata) ? self::getProperty($metadata, 'orderInfo') :
                self::getProperty($metadata, 'info');
            $response['vads_order_info'] = $orderInfo;
        }

        if ($transactionDetails = self::getProperty($transaction, 'transactionDetails')) {
            $response['vads_sequence_number'] = self::getProperty($transactionDetails, 'sequenceNumber');

            // Workarround to adapt to REST API behavior.
            $effectiveAmount = self::getProperty($transactionDetails, 'effectiveAmount');
            $effectiveCurrency = ScelliusApi::getCurrencyNumCode(self::getProperty($transactionDetails, 'effectiveCurrency'));

            if ($effectiveAmount && $effectiveCurrency) {
                $response['vads_effective_amount'] = $response['vads_amount'];
                $response['vads_effective_currency'] = $response['vads_currency'];
                $response['vads_amount'] = $effectiveAmount;
                $response['vads_currency'] = $effectiveCurrency;
            }

            $response['vads_warranty_result'] = self::getProperty($transactionDetails, 'liabilityShift');

            if ($cardDetails = self::getProperty($transactionDetails, 'cardDetails')) {
                $response['vads_trans_id'] = self::getProperty($cardDetails, 'legacyTransId'); // Deprecated.
                $response['vads_presentation_date'] = self::getProperty($cardDetails, 'expectedCaptureDate');

                $response['vads_card_brand'] = self::getProperty($cardDetails, 'effectiveBrand');
                $response['vads_card_number'] = self::getProperty($cardDetails, 'pan');
                $response['vads_expiry_month'] = self::getProperty($cardDetails, 'expiryMonth');
                $response['vads_expiry_year'] = self::getProperty($cardDetails, 'expiryYear');

                if ($authorizationResponse = self::getProperty($cardDetails, 'authorizationResponse')) {
                    $response['vads_auth_result'] = self::getProperty($authorizationResponse, 'authorizationResult');
                }

                if (($threeDSResponse = self::getProperty($cardDetails, 'threeDSResponse'))
                    && ($authenticationResultData = self::getProperty($threeDSResponse, 'authenticationResultData'))) {
                    $response['vads_threeds_cavv'] = self::getProperty($authenticationResultData, 'cavv');
                    $response['vads_threeds_status'] = self::getProperty($authenticationResultData, 'status');
                }
            }

            if ($fraudManagement = self::getProperty($transactionDetails, 'fraudManagement')) {
                if ($riskControl = self::getProperty($fraudManagement, 'riskControl')) {
                    $response['vads_risk_control'] = '';

                    foreach ($riskControl as $key => $value) {
                        $response['vads_risk_control'] .= "$key=$value;";
                    }
                }

                if ($riskAssessments = self::getProperty($fraudManagement, 'riskAssessments')) {
                    $response['vads_risk_assessment_result'] = self::getProperty($riskAssessments, 'results');
                }
            }
        }

        return $response;
    }

    // Check REST WS response.
    public static function checkRestResult($response, $expectedStatuses = array())
    {
        $answer = $response['answer'];

        if ($response['status'] !== 'SUCCESS') {
            if (isset($answer['detailedErrorMessage']) && ! empty($answer['detailedErrorMessage'])) {
                $errorMessage = $answer['detailedErrorMessage'];
            } else {
                $errorMessage = 'Unknown refund error';
            }

            throw new ScelliusWsException($errorMessage, $answer['errorCode']);
        } elseif (! empty($expectedStatuses) && ! in_array($answer['detailedStatus'], $expectedStatuses)) {
            throw new Exception("Unexpected transaction status returned: {$answer['detailedStatus']}.");
        }
    }

    private static function getProperty($array, $key)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        return null;
    }

    public static function checkRestIpnValidity()
    {
        return Tools::getIsset('kr-hash') && Tools::getIsset('kr-hash-algorithm') && Tools::getIsset('kr-answer');
    }

    public static function checkFormIpnValidity()
    {
        return Tools::getIsset('vads_order_id') && Tools::getIsset('vads_hash');
    }

    public static function checkHash($data, $key)
    {
        $supported_sign_algos = array('sha256_hmac');

        // Check if the hash algorithm is supported.
        if (! in_array($data['kr-hash-algorithm'], $supported_sign_algos)) {
            self::getLogger()->logError('Hash algorithm is not supported: ' . Tools::getValue('kr-hash-algorithm'));
            return false;
        }

        // On some servers, / can be escaped.
        $kr_answer = str_replace('\/', '/', $data['kr-answer']);

        $hash = hash_hmac('sha256', $kr_answer, $key);

        // Return true if calculated hash and sent hash are the same.
        return ($hash == $data['kr-hash']);
    }

    public static function ucClassName($name)
    {
        $parts = explode('_', $name);
        return implode('', array_map('Tools::ucfirst', $parts));
    }
}
