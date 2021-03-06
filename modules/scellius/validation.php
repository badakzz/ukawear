<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

/**
 * Instant payment notification file. Wait for payment gateway confirmation, then validate order.
 */

require_once dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
require_once dirname(__FILE__) . '/scellius.php';

// Module logger object.
$logger = ScelliusTools::getLogger();

$save_on_failure = true;

if (ScelliusTools::checkRestIpnValidity()) {
    $test_mode = Configuration::get('SCELLIUS_MODE') === 'TEST';
    $sha_key = $test_mode ? Configuration::get('SCELLIUS_PRIVKEY_TEST') : Configuration::get('SCELLIUS_PRIVKEY_PROD');

    // Use direct post content to avoid stipslashes from json data.
    $data = $_POST;

    if (! ScelliusTools::checkHash($data, $sha_key)) {
        $ip = Tools::getRemoteAddr();
        $logger->logError("{$ip} tries to access validation.php page without valid signature with data: " . print_r($data, true));
        die('<span style="display:none">KO-An error occurred while computing the signature.' . "\n" . '</span>');
    }

    $answer = json_decode($data['kr-answer'], true);
    if (! is_array($answer)) {
        $logger->logError('Invalid REST IPN request received. Content of kr-answer: ' . $data['kr-answer']);
        die('<span style="display:none">KO-Invalid IPN request received.' . "\n" . '</span>');
    }

    $save_on_failure &= isset($answer['orderCycle']) && ($answer['orderCycle'] === 'CLOSED');

    // Wrap payment result to use traditional order creation tunnel.
    $data = ScelliusTools::convertRestResult($answer);

    $cart_id = (int) $data['vads_order_id'];

    // Shopping cart object.
    $cart = new Cart($cart_id);

    require_once _PS_MODULE_DIR_ . 'scellius/classes/ScelliusResponse.php';

    /** @var ScelliusResponse $response */
    $response = new ScelliusResponse($data, null, null, null);
} elseif (ScelliusTools::checkFormIpnValidity()) {
    $cart_id = (int) Tools::getValue('vads_order_id');

    // Shopping cart object.
    $cart = new Cart($cart_id);

    require_once _PS_MODULE_DIR_ . 'scellius/classes/ScelliusResponse.php';

    /** @var ScelliusResponse $response */
    $response = new ScelliusResponse(
        $_POST,
        Configuration::get('SCELLIUS_MODE'),
        Configuration::get('SCELLIUS_KEY_TEST'),
        Configuration::get('SCELLIUS_KEY_PROD'),
        Configuration::get('SCELLIUS_SIGN_ALGO')
    );

    // Check the authenticity of the request.
    if (! $response->isAuthentified()) {
        $ip = Tools::getRemoteAddr();
        $logger->logError("{$ip} tries to access validation.php page without valid signature with data: " . print_r($_POST, true));
        $logger->logError('Signature algorithm selected in module settings must be the same as one selected in gateway Back Office.');

        die($response->getOutputForGateway('auth_fail'));
    }
} else {
    $logger->logError('Invalid IPN request received. Content: ' . print_r($_POST, true));
    die('<span style="display:none">KO-Invalid IPN request received.' . "\n" . '</span>');
}

$logger->logInfo("Server call process starts for cart #$cart_id.");

// Cart errors.
if (! Validate::isLoadedObject($cart)) {
    $logger->logError("Cart #$cart_id not found in database.");
    die('<span style="display:none">KO-Order not found.' . "\n" . '</span>');
} elseif ($cart->nbProducts() <= 0) {
    $logger->logError("Cart #$cart_id was emptied before redirection.");
    die('<span style="display:none">KO-Empty cart detected before order processing.' . "\n" . '</span>');
}

// Rebuild context.
$controller = new FrontController();
$controller->init();

Context::getContext()->controller = $controller;

if (isset($cart->id_shop)) {
    $_GET['id_shop'] = $cart->id_shop;
    Context::getContext()->shop = Shop::initialize();
}

Context::getContext()->customer = new Customer((int) $cart->id_customer);
Context::getContext()->customer->logged = 1;

Context::getContext()->cart = $cart = new Cart((int) $cart_id); // Reload cart to take into nto account customer group.

$address = new Address((int) $cart->id_address_invoice);
Context::getContext()->country = new Country((int) $address->id_country);
Context::getContext()->language = new Language((int) $cart->id_lang);
Context::getContext()->currency = new Currency((int) $cart->id_currency);
Context::getContext()->link = new Link();

// Module main object.
$scellius = new Scellius();

// Search order in db.
$order_id = Order::getOrderByCartId($cart_id);

if ($order_id === false) {
    // Order has not been processed yet.

    $new_state = (int) Scellius::nextOrderState($response);

    if ($response->isAcceptedPayment()) {
        $logger->logInfo("Payment accepted for cart #$cart_id. New order state is $new_state.");

        $order = $scellius->saveOrder($cart, $new_state, $response);

        if (Scellius::hasAmountError($order)) {
            // Amount paid not equals initial amount.
            $msg = "Error: amount paid {$order->total_paid_real} is not equal to initial amount {$order->total_paid}.";
            $msg .= " Order is in a failed state, cart #$cart_id.";
            $logger->logWarning($msg);

            die($response->getOutputForGateway('ko', 'Total paid is different from order amount.'));
        } else {
            // Response to server.
            die($response->getOutputForGateway('payment_ok'));
        }
    } else {
        // Payment KO.
        $logger->logInfo("Payment failed for cart #$cart_id.");

        $save_on_failure &= (Configuration::get('SCELLIUS_FAILURE_MANAGEMENT') === ScelliusTools::ON_FAILURE_SAVE);
        if ($save_on_failure || Scellius::isOney($response)) {
            // Save on failure option is selected or Oney payment.
            $msg = Scellius::isOney($response) ? 'Oney payment' : 'Save on failure option is selected';
            $logger->logInfo("$msg: save failed order for cart #$cart_id. New order state is $new_state.");
            $order = $scellius->saveOrder($cart, $new_state, $response);

            die($response->getOutputForGateway('payment_ko'));
        } else {
            die($response->getOutputForGateway('payment_ko_bis'));
        }
    }
} else {
    // Order already registered.
    $logger->logInfo("Order #$order_id already registered for cart #$cart_id.");

    $order = new Order((int) $order_id);
    $old_state = (int) $order->getCurrentState();

    $logger->logInfo("The current state for order corresponding to cart #$cart_id is ($old_state).");

    // Check if  a total refund of order was made.
    $total_refund = false;

    if ($response->get('operation_type') === 'CREDIT') {
        $currency = ScelliusApi::findCurrency($response->get('currency'));
        $decimals = $currency->getDecimals();
        $paid_total = $currency->convertAmountToFloat($response->get('amount'));

        if (number_format($order->total_paid_real, $decimals) === number_format($paid_total, $decimals)) {
            $total_refund = true;
        }
    }

    $outofstock = Scellius::isOutOfStock($order);
    $new_state = (int) Scellius::nextOrderState($response, $total_refund, $outofstock);

    // Final states.
    $consistent_states = array(
        'PS_OS_OUTOFSTOCK_PAID', // Override paid state since PrestaShop 1.6.1.
        'SCELLIUS_OS_PAYMENT_OUTOFSTOCK', // Paid state for PrestaShop < 1.6.1.
        'PS_OS_PAYMENT',
        'SCELLIUS_OS_TRANS_PENDING',
        'PS_OS_REFUND',
        'PS_OS_CANCELED'
    );

    // If the payment is not the first in sequence, do not update order state.
    $first_payment = ($response->get('sequence_number') === '1') || ! $response->get('sequence_number');

    if (($old_state === $new_state) || ! $first_payment) {
        // No changes, just display a confirmation message.
        $logger->logInfo("No state change for order associated with cart #$cart_id, order remains in state ({$old_state}).");

        $scellius->savePayment($order, $response);
        $scellius->createMessage($order, $response);

        if ($response->isAcceptedPayment()) {
            $msg = 'payment_ok_already_done';
        } else {
            $msg = 'payment_ko_already_done';
        }

        die($response->getOutputForGateway($msg));
    } elseif (Scellius::isPaidOrder($order) &&
        (! Scellius::isStateInArray($new_state, $consistent_states) || ($response->get('url_check_src') === 'PAY'))) {
        // Order cannot move from final paid state to not completed states.
        $logger->logInfo("Order is successfully registered for cart #$cart_id but platform returns a payment error, transaction status is {$response->getTransStatus()}.");
        die($response->getOutputForGateway('payment_ko_on_order_ok'));
    } elseif (! $old_state || Scellius::isStateInArray($old_state, Scellius::getManagedStates())) {
        if (($old_state === Configuration::get('PS_OS_ERROR')) && $response->isAcceptedPayment() &&
            Scellius::hasAmountError($order)) {
            // Amount paid not equals amount.
            $msg = "Error: amount paid {$order->total_paid_real} is not equal to initial amount {$order->total_paid}.";
            $msg .= " Order is in a failed state, cart #$cart_id.";
            $logger->logWarning($msg);
            die($response->getOutputForGateway('ko', 'Total paid is different from order amount.'));
        }

        if (! $old_state) {
            $logger->logWarning("Current order state for cart #$cart_id is empty! Something went wrong. Try to set it anyway.");
        }

        $scellius->setOrderState($order, $new_state, $response);

        $logger->logInfo("Order is successfully updated for cart #$cart_id.");
        die($response->getOutputForGateway($response->isAcceptedPayment() ? 'payment_ok' : 'payment_ko'));
    } else {
        $logger->logWarning("Unknown order state ID ($old_state) for cart #$cart_id. Managed by merchant.");
        die($response->getOutputForGateway('ok', 'Unknown order status.'));
    }
}
