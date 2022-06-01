<?php
/**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

class ScelliusIframeModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        if (Configuration::get('SCELLIUS_CART_MANAGEMENT') !== ScelliusTools::KEEP_CART) {
            if ($this->context->cart->id) {
                $this->context->cookie->scelliusCartId = (int) $this->context->cart->id;
            }

            if (isset($this->context->cookie->scelliusCartId)) {
                $this->context->cookie->id_cart = $this->context->cookie->scelliusCartId;
            }
        }

        $this->setTemplate(ScelliusTools::getTemplatePath('iframe/loader.tpl'));
    }
}
