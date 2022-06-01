{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<form action="{$link->getModuleLink('scellius', 'redirect', array(), true)|escape:'html':'UTF-8'}" method="post">
  <input type="hidden" name="scellius_payment_type" value="standard" />
</form>