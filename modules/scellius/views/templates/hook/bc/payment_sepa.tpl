{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

{if version_compare($smarty.const._PS_VERSION_, '1.6', '>=')}
  <div class="row"><div class="col-xs-12{if version_compare($smarty.const._PS_VERSION_, '1.6.0.11', '<')} col-md-6{/if}">
{/if}

<div class="payment_module scellius {$scellius_tag|escape:'html':'UTF-8'}">
  <a href="javascript: $('#scellius_sepa').submit();" title="{l s='Click here to pay with SEPA' mod='scellius'}">
    <img class="logo" src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" />{$scellius_title|escape:'html':'UTF-8'}

    <form action="{$link->getModuleLink('scellius', 'redirect', array(), true)|escape:'html':'UTF-8'}" method="post" id="scellius_sepa">
      <input type="hidden" name="scellius_payment_type" value="sepa" />
    </form>
  </a>
</div>

{if version_compare($smarty.const._PS_VERSION_, '1.6', '>=')}
  </div></div>
{/if}