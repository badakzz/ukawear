{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

{capture name=path}Scellius{/capture}
{if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
  {include file="$tpl_dir./breadcrumb.tpl"}
{/if}

<h1 style="margin-bottom: 20px;">{l s='Redirection to payment gateway' mod='scellius'}</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<div id="scellius_content">
  <h3>{$scellius_title|escape:'html':'UTF-8'}</h3>

  <form action="{$scellius_url|escape:'html':'UTF-8'}" method="post" id="scellius_form" name="scellius_form" onsubmit="scelliusDisablePayment();">
    {foreach from=$scellius_params key='key' item='value'}
      <input type="hidden" name="{$key|escape:'html':'UTF-8'}" value="{$value|escape:'html':'UTF-8'}" />
    {/foreach}

    <p>
      <img src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" style="margin-bottom: 5px" />
      <br />

      {l s='Please wait, you will be redirected to the payment gateway.' mod='scellius'}

      <br /> <br />
      {l s='If nothing happens in 10 seconds, please click the button below.' mod='scellius'}
      <br /><br />
    </p>

  {if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
    <p class="cart_navigation">
      <input type="submit" id="scellius_submit_payment" value="{l s='Pay' mod='scellius'}" class="exclusive" />
    </p>
  {else}
    <p class="cart_navigation clearfix">
      <button type="submit" id="scellius_submit_payment" class="button btn btn-default standard-checkout button-medium" >
        <span>{l s='Pay' mod='scellius'}</span>
      </button>
    </p>
  {/if}
  </form>
</div>

<script type="text/javascript">
  function scelliusDisablePayment() {
    document.getElementById('scellius_submit_payment').disabled = true;
  }

  function scelliusSubmitForm() {
    document.getElementById('scellius_submit_payment').click();
  }

  if (window.addEventListener) { // for most browsers
    window.addEventListener('load', scelliusSubmitForm, false);
  } else if (window.attachEvent) { // for IE 8 and earlier versions
    window.attachEvent('onload', scelliusSubmitForm);
  }
</script>
