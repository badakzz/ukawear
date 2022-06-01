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

class ScelliusGroupedOtherPayment extends AbstractScelliusPayment
{
    protected $prefix = 'SCELLIUS_OTHER_';
    protected $tpl_name = 'payment_grouped_other.tpl';
    protected $logo = 'other.png';
    protected $name = 'grouped_other';

    protected $other_payments;
    protected $needs_cart_data = false;
    protected $force_local_cart_data = true;

    public function setPaymentMeans($other_payments)
    {
        $this->other_payments = $other_payments;
    }

    public function isAvailable($cart)
    {
        if (! parent::isAvailable($cart)) {
            return false;
        }

        // Check available payment options.
        if (empty($this->other_payments)) {
            return false;
        }

        return true;
    }

    public function getTplVars($cart)
    {
        $vars = parent::getTplVars($cart);

        $options = array();
        foreach ($this->other_payments as $payment) {
            $title = is_array($payment['title']) ? $payment['title'][(int) $cart->id_lang] : $payment['title'];

            $options[$payment['code']] = $title;
        }

        $vars['scellius_other_options'] = $options;

        return $vars;
    }

    public function getPaymentOption($cart)
    {
        $option = parent::getPaymentOption($cart);

        $inputs = $option->getInputs();
        $inputs[] = array('type' => 'hidden', 'name' => 'scellius_payment_title', 'value' => $this->getTitle((int) $cart->id_lang));

        $option->setInputs($inputs);

        return $option;
    }

    /**
     * {@inheritDoc}
     * @see AbstractScelliusPayment::prepareRequest()
     */
    public function prepareRequest($cart, $data = array())
    {
        // Recover payment parameters.
        $available_payments = ScelliusOtherPayment::getAvailablePaymentMeans($cart);
        $validation_mode = '-1';
        $capture_delay = '';

        foreach ($available_payments as $option) {
            if ($option['code'] === $data['card_type']) {
                $validation_mode = $option['validation'];
                $capture_delay = $option['capture'];

                // Send cart data to payment gateway?
                $this->needs_cart_data = isset($option['cart']) && ($option['cart'] === 'True');

                break;
            }
        }

        $request = parent::prepareRequest($cart, $data);

        // Set payment card.
        $request->set('payment_cards', $data['card_type']);

        // Set validation mode.
        if ($validation_mode !== '-1') {
            $request->set('validation_mode', $validation_mode);
        }

        // Set capture delay.
        if (is_numeric($capture_delay)) {
            $request->set('capture_delay', $capture_delay);
        }

        return $request;
    }

    public function hasForm()
    {
        return true;
    }

    protected function getDefaultTitle()
    {
        return $this->l('Other payment means');
    }
}
