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
{if $scellius_saved_identifier}
  <a class="unclickable scellius-standard-link" title="{l s='Choose pay with registred means of payment or enter payment information and click « Pay » button' mod='scellius'}">
    <img class="logo" src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" />{$scellius_title|escape:'html':'UTF-8'}
{else}
  <a href="javascript: void(0);" title="{l s='Click here to pay by credit card' mod='scellius'}" id="scellius_standard_link" class="scellius-standard-link">
    <img class="logo" src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" />{$scellius_title|escape:'html':'UTF-8'}
    <br />
{/if}

    {if $scellius_saved_identifier}
      <br /><br />
      {include file="./payment_std_oneclick.tpl"}
      <input id="scellius_payment_by_identifier" type="hidden" name="scellius_payment_by_identifier" value="1" />
    {/if}

    <iframe class="scellius-iframe" id="scellius_iframe" src="{$link->getModuleLink('scellius', 'iframe', ['content_only' => 1], true)|escape:'html':'UTF-8'}" style="display: none;">
    </iframe>

    {if $scellius_can_cancel_iframe}
        <button class="scellius-iframe" id="scellius_cancel_iframe" style="display: none;">{l s='< Cancel and return to payment choice' mod='scellius'}</button>
    {/if}
  </a>

  <script type="text/javascript">
    var done = false;
    function scelliusShowIframe() {
      if (done) {
        return;
      }

      done = true;

      {if !$scellius_saved_identifier}
        $('#scellius_iframe').parent().addClass('unclickable');
      {/if}

      $('.scellius-iframe').show();
      $('#scellius_oneclick_payment_description').hide();

      var url = "{$link->getModuleLink('scellius', 'redirect', ['content_only' => 1], true)|escape:'url':'UTF-8'}";
      {if $scellius_saved_identifier}
            url = url + '&scellius_payment_by_identifier=' + $('#scellius_payment_by_identifier').val();
      {/if}

      $('#scellius_iframe').attr('src', decodeURIComponent(url) + '&' + Date.now());
    }

    function scelliusHideIframe() {
      if (!done) {
        return;
      }

      done = false;

      {if !$scellius_saved_identifier}
        $('#scellius_iframe').parent().removeClass('unclickable');
      {/if}

      $('.scellius-iframe').hide();
      $('#scellius_oneclick_payment_description').show();

      var url = "{$link->getModuleLink('scellius', 'iframe', ['content_only' => 1], true)|escape:'url':'UTF-8'}";
      $('#scellius_iframe').attr('src', decodeURIComponent(url) + '&' + Date.now());
    }

    $(function() {
      $('#scellius_standard_link').click(scelliusShowIframe);
      $('#scellius_cancel_iframe').click(function() {
        scelliusHideIframe();
        return false;
      });

      $('.payment_module a:not(.scellius-standard-link)').click(scelliusHideIframe);
    });
  </script>
</div>

{if version_compare($smarty.const._PS_VERSION_, '1.6', '>=')}
</div></div>
{/if}