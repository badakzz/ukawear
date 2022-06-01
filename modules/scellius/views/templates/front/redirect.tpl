{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

{extends file='checkout/checkout.tpl'}
{block name='content'}
  <section id="content">
    <div class="row">
      <div class="col-xs-12 col-lg-8">
        <section id="scellius_content" class="checkout-step -current" style="text-align: center;">
          <h1 class="step-title h3" style="margin-bottom: 20px;">
            {l s='Redirection to payment gateway' mod='scellius'}
          </h1>

          <div class="content">
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

              <p class="cart_navigation clearfix">
                <button type="submit" id="scellius_submit_payment" class="button btn btn-default standard-checkout button-medium" >
                  <span>{l s='Pay' mod='scellius'}</span>
                </button>
              </p>
            </form>
          </div>
        </section>
      </div>

       <div class="col-md-4">
      </div>
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
  </section>
{/block}