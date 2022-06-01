{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<!-- This meta tag is mandatory to avoid encoding problems caused by \PrestaShop\PrestaShop\Core\Payment\PaymentOptionFormDecorator -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<section style="margin-top: -12px;">
  <iframe class="scellius-iframe" id="scellius_iframe" src="{$link->getModuleLink('scellius', 'iframe', array(), true)|escape:'html':'UTF-8'}" style="display: none;">
  </iframe>

   {if $scellius_can_cancel_iframe}
       <a id="scellius_cancel_iframe" class="scellius-iframe" style="margin-bottom: 8px; display: none;" href="javascript:scelliusInit();">
           {l s='< Cancel and return to payment choice' mod='scellius'}
       </a>
   {/if}
</section>
<br />

<script type="text/javascript">
  var scelliusSubmit = function(e) {
    e.preventDefault();

    if (!$('#scellius_standard').data('submitted')) {
      $('#scellius_standard').data('submitted', true);
      $('#payment-confirmation button').attr('disabled', 'disabled');
      $('.scellius-iframe').show();
      $('#scellius_oneclick_payment_description').hide();

      var url = decodeURIComponent("{$link->getModuleLink('scellius', 'redirect', ['content_only' => 1], true)|escape:'url':'UTF-8'}") + '&' + Date.now();
      {if $scellius_saved_identifier}
        url = url + '&scellius_payment_by_identifier=' + $('#scellius_payment_by_identifier').val();
      {/if}

      $('#scellius_iframe').attr('src', url);
    }

    return false;
  }

  setTimeout(function() {
    $('input[type="radio"][name="payment-option"]').change(function() {
      scelliusInit();
    });
  }, 0);

  function scelliusInit() {
    if (!$('#scellius_standard').data('submitted')) {
      return;
    }

    $('#scellius_standard').data('submitted', false);
    $('#payment-confirmation button').removeAttr('disabled');
    $('.scellius-iframe').hide();
    $('#scellius_oneclick_payment_description').show();

    var url = decodeURIComponent("{$link->getModuleLink('scellius', 'iframe', ['content_only' => 1], true)|escape:'url':'UTF-8'}") + '&' + Date.now();
    $('#scellius_iframe').attr('src', url);
  }
</script>