{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra-network.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<form action="{$scellius_url|escape:'html':'UTF-8'}" method="post" id="scellius_form" name="scellius_form">
  {foreach from=$scellius_params key='key' item='value'}
    <input type="hidden" name="{$key|escape:'html':'UTF-8'}" value="{$value|escape:'html':'UTF-8'}" />
  {/foreach}

  <p>
    {if version_compare($smarty.const._PS_VERSION_, '1.7', '>=')}
      {include file="module:scellius/views/templates/front/iframe/loader.tpl"}
    {else}
      {include file="./loader.tpl"}
    {/if}
  </p>
</form>

<script type="text/javascript">
      function scelliusSubmitForm() {
        document.getElementById('scellius_form').submit();
      }

      if (window.addEventListener) { // for most browsers
        window.addEventListener('load', scelliusSubmitForm, false);
      } else if (window.attachEvent) { // for IE 8 and earlier versions
        window.attachEvent('onload', scelliusSubmitForm);
      }
</script>
