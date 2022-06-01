{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<div style="padding-left: 40px;" id="scellius_oneclick_payment_description">
  <ul id="scellius_oneclick_payment_description_1">
    <li>
      <span class="scellius_span">{l s='You will pay with your registered means of payment' mod='scellius'}<b> {$scellius_saved_payment_mean|escape:'html':'UTF-8'}. </b>{l s='No data entry is needed.' mod='scellius'}</span>
    </li>

    <li style="margin: 8px 0px 8px;">
      <span class="scellius_span">{l s='OR' mod='scellius'}</span>
    </li>

    <li>
      <p class="scellius_link" onclick="scelliusOneclickPaymentSelect(0)">{l s='Click here to pay with another means of payment.' mod='scellius'}</p>
    </li>
  </ul>
{if ($scellius_std_card_data_mode == '2')}
  <script type="text/javascript">
    function scelliusOneclickPaymentSelect(paymentByIdentifier) {
      if (paymentByIdentifier) {
        $('#scellius_oneclick_payment_description').show();
        $('#scellius_standard').hide();
        $('#scellius_payment_by_identifier').val('1');
      } else {
        $('#scellius_oneclick_payment_description').hide();
        $('#scellius_standard').show();
        $('#scellius_payment_by_identifier').val('0');
      }
    }
  </script>
{else}
  <ul id="scellius_oneclick_payment_description_2" style="display: none;">
    {if ($scellius_std_card_data_mode != '5') || $scellius_rest_popin}
      <li>{l s='You will enter payment data after order confirmation.' mod='scellius'}</li>
    {/if}

      <li style="margin: 8px 0px 8px;">
        <span class="scellius_span">{l s='OR' mod='scellius'}</span>
      </li>
      <li>
        <p class="scellius_link" onclick="scelliusOneclickPaymentSelect(1)">{l s='Click here to pay with your registered means of payment.' mod='scellius'}</p>
      </li>
  </ul>

  <script type="text/javascript">
    function scelliusOneclickPaymentSelect(paymentByIdentifier) {
      if (paymentByIdentifier) {
        $('#scellius_oneclick_payment_description_1').show();
        $('#scellius_oneclick_payment_description_2').hide()
        $('#scellius_payment_by_identifier').val('1');
      } else {
        $('#scellius_oneclick_payment_description_1').hide();
        $('#scellius_oneclick_payment_description_2').show();
        $('#scellius_payment_by_identifier').val('0');
      }

      {if ($scellius_std_card_data_mode == '5')}
        $('.scellius .kr-form-error').html('');

        if ($('#scellius_payment_by_identifier').val() == '1') {
          var token = "{$scellius_rest_identifier_token|escape:'html':'UTF-8'}";
        } else {
          var token = "{$scellius_rest_form_token|escape:'html':'UTF-8'}";
        }

        KR.setFormConfig({ formToken: token });
      {/if}
    }
    </script>
{/if}

{if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
  <input id="scellius_standard_link" value="{l s='Pay' mod='scellius'}" class="button" />
{else}
  <button id="scellius_standard_link" class="button btn btn-default standard-checkout button-medium" >
    <span>{l s='Pay' mod='scellius'}</span>
  </button>
{/if}

</div>