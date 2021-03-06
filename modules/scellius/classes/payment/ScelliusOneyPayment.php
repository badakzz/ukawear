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

class ScelliusOneyPayment extends AbstractScelliusPayment
{
    const ONEY_THREE_TIMES_MAX_FEES = 10;
    const ONEY_FOUR_TIMES_MAX_FEES = 20;

    protected $prefix = 'SCELLIUS_ONEY_';
    protected $tpl_name = 'payment_oney.tpl';
    protected $logo = 'oney.png';
    protected $name = 'oney';

    protected $label = "FacilyPay Oney";

    protected $currencies = array('EUR');
    protected $countries = array('FR', 'GP', 'MQ', 'GF', 'RE', 'YT');
    protected $needs_cart_data = true;

    public function getCountries()
    {
        return $this->countries;
    }

    public function isAvailable($cart)
    {
        if (! parent::isAvailable($cart)) {
            return false;
        }

        if (Configuration::get($this->prefix . 'ENABLE_OPTIONS') === 'True') {
            $options = self::getAvailableOptions($cart);

            if (empty($options)) {
                return false;
            }
        }

        if (! ScelliusTools::checkOneyRequirements($cart, $this->label)) {
            return false;
        }

        return true;
    }

    protected function proposeOney($data = array())
    {
        return true;
    }

    public function validate($cart, $data = array())
    {
        $errors = parent::validate($cart, $data);
        if (! empty($errors)) {
            return $errors;
        }

        $billing_address = new Address((int) $cart->id_address_invoice);

        // Check address validity according to FacilyPay Oney payment specifications.
        $errors = ScelliusTools::checkAddress($billing_address, 'billing', $this->name);

        if (empty($errors)) {
            // Billing address is valid, check delivery address.
            $delivery_address = new Address((int) $cart->id_address_delivery);

            $errors = ScelliusTools::checkAddress($delivery_address, 'delivery', $this->name);
        }

        return $errors;
    }

    /**
     * {@inheritDoc}
     * @see AbstractScelliusPayment::prepareRequest()
     */
    public function prepareRequest($cart, $data = array())
    {
        $request = parent::prepareRequest($cart, $data);

        // Override with FacilyPay Oney payment cards.
        $test_mode = $request->get('ctx_mode') === 'TEST';
        $request->set('payment_cards', $test_mode ? 'ONEY_SANDBOX' : 'ONEY');

        if (isset($data['opt']) && $data['opt']) {
            // Override option code parameter.
            $oney_options = self::getAvailableOptions($cart);
            $option = $oney_options[$data['opt']];

            $request->set('payment_option_code', $option['code']);
        }

        return $request;
    }

    public static function getAvailableOptions($cart)
    {
        // FacilyPay Oney payment options.
        $options = @unserialize(Configuration::get('SCELLIUS_ONEY_OPTIONS'));
        if (! is_array($options) || empty($options)) {
            return array();
        }

        $amount = $cart->getOrderTotal();

        $enabled_options = array();
        foreach ($options as $key => $option) {
            $min = $option['min_amount'];
            $max = $option['max_amount'];

            if ((empty($min) || $amount >= $min) && (empty($max) || $amount <= $max)) {
                $default = is_string($option['label']) ? $option['label'] : $option['count'] . ' x';
                $option_label = is_array($option['label']) && isset($option['label'][$cart->id_lang]) ?
                    $option['label'][$cart->id_lang] : $default;

                $option['localized_label'] = $option_label;

                // Compute some fields.
                $count = (int) $option['count'];
                $rate = (float) $option['rate'];

                $max_fees = null;
                switch ($count) {
                    case 3:
                        $max_fees = self::ONEY_THREE_TIMES_MAX_FEES;
                        break;
                    case 4:
                        $max_fees = self::ONEY_FOUR_TIMES_MAX_FEES;
                        break;
                    default:
                        $max_fees = null;
                        break;
                }

                $payment = round($amount / $count, 2);

                $fees = round($amount * $rate / 100, 2);
                if ($max_fees) {
                    $fees = min($fees, $max_fees);
                }

                $first = $amount - ($payment * ($count - 1)) + $fees;

                $option['order_total'] = Tools::displayPrice($amount);
                $option['first_payment'] = Tools::displayPrice($first);
                $option['funding_count'] = $count - 1; // Real number of payments concerned by funding.
                $option['monthly_payment'] = Tools::displayPrice($payment);
                $option['funding_total'] = Tools::displayPrice(($count - 1) * $payment - $fees);
                $option['funding_fees'] = Tools::displayPrice($fees);
                $option['taeg'] = ''; // TODO calculate TAEG.

                $enabled_options[$key] = $option;
            }
        }

        return $enabled_options;
    }

    public function getTplVars($cart)
    {
        $vars = parent::getTplVars($cart);

        $options = array();
        if (Configuration::get($this->prefix . 'ENABLE_OPTIONS') === 'True') {
            $options = self::getAvailableOptions($cart);
        }

        $vars['scellius_oney_options'] = $options;
        $vars['title'] = sprintf($this->l('Click here to pay with %s', 'payment_other'), $this->label);
        $vars['suffix'] = '';

        return $vars;
    }

    public function hasForm()
    {
        return Configuration::get($this->prefix . 'ENABLE_OPTIONS') === 'True';
    }

    protected function getDefaultTitle()
    {
        return $this->l('Payment with FacilyPay Oney');
    }
}
