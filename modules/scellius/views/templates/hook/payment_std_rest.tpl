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

<section id="scellius_standard_rest_wrapper" style="margin-bottom: 2rem;">
  <div class="scellius kr-embedded"{if $scellius_rest_popin} kr-popin{/if} kr-form-token="{$scellius_rest_identifier_token|escape:'html':'UTF-8'}">
     <div class="kr-pan"></div>
     <div class="kr-expiry"></div>
     <div class="kr-security-code"></div>

     {if !$scellius_rest_popin}
       <div style="display: none;">
     {/if}
     <button type="button" id="scellius_hidden_button" class="kr-payment-button"></button>
     {if !$scellius_rest_popin}
       </div>
     {/if}

     <div class="kr-field processing" style="display: none; border: none !important;">
       <div style="background-image: url('{$smarty.const._MODULE_DIR_|escape:'html':'UTF-8'}scellius/views/img/loading_big.gif');
                  margin: 0 auto; display: block; height: 35px; background-color: #ffffff; background-position: center;
                  background-repeat: no-repeat; background-size: 35px;">
       </div>
     </div>

     <div class="kr-form-error"></div>
  </div>
</section>

<script type="text/javascript">
  var scelliusSubmit = function(e) {
    e.preventDefault();

    if (!$('#scellius_standard').data('submitted')) {
      var isPopin = document.getElementsByClassName('kr-popin-button');

      {if $scellius_saved_identifier}
        if (isPopin.length === 0) {
          $('#scellius_oneclick_payment_description').hide();
        }
      {/if}

      if (isPopin.length > 0) {
        $('.kr-popin-button').click();
      } else {
        $('#scellius_standard').data('submitted', true);
        $('.scellius .processing').css('display', 'block');
        $('#payment-confirmation button').attr('disabled', 'disabled');
        $('#scellius_hidden_button').click();
      }
    }

    return false;
  };
</script>