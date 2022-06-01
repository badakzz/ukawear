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
  <a class="unclickable"
    {if $scellius_saved_identifier}
        title="{l s='Choose pay with registred means of payment or enter payment information and click « Pay » button' mod='scellius'}"
    {else}
        title="{l s='Enter payment information and click « Pay » button' mod='scellius'}"
    {/if}
  >
    <img class="logo" src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" />{$scellius_title|escape:'html':'UTF-8'}

    <div id="scellius_standard_rest_wrapper" style="padding-top: 10px; padding-left: 40px;">
      <div class="kr-embedded"{if $scellius_rest_popin} kr-popin{/if} kr-form-token="{$scellius_rest_identifier_token|escape:'html':'UTF-8'}">
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
                      margin: 0 auto; display: block; height: 35px; background-position: center;
                      background-repeat: no-repeat; background-size: 35px;">
          </div>
        </div>

        <div class="kr-form-error"></div>
      </div>
    </div>

    {if $scellius_saved_identifier}
      {include file="./payment_std_oneclick.tpl"}
      <input id="scellius_payment_by_identifier" type="hidden" name="scellius_payment_by_identifier" value="1" />
    {else}
        {if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
          <input id="scellius_standard_link" value="{l s='Pay' mod='scellius'}" class="button" />
        {else}
          <button id="scellius_standard_link" class="button btn btn-default standard-checkout button-medium" >
            <span>{l s='Pay' mod='scellius'}</span>
          </button>
        {/if}
    {/if}

    <script type="text/javascript">
        $('#scellius_standard_link').click(function() {
          var isPopin = document.getElementsByClassName('kr-popin-button');

          if (isPopin.length > 0) {
            $('.kr-popin-button').click();
          } else {
            $('#scellius_oneclick_payment_description').hide();
            $('.scellius .processing').css('display', 'block');
            $('#scellius_hidden_button').click();
          }
        });
   </script>
  </a>
</div>

{if version_compare($smarty.const._PS_VERSION_, '1.6', '>=')}
  </div></div>
{/if}