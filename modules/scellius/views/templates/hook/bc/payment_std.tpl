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
  {if $scellius_std_card_data_mode == 1 && !$scellius_saved_identifier}
    <a href="javascript: $('#scellius_standard').submit();" title="{l s='Click here to pay by credit card' mod='scellius'}">
  {else}
    <a class="unclickable"
      {if $scellius_saved_identifier}
        title="{l s='Choose pay with registred means of payment or enter payment information and click « Pay » button' mod='scellius'}"
      {else}
        title="{l s='Enter payment information and click « Pay » button' mod='scellius'}"
      {/if}
    >
  {/if}
    <img class="logo" src="{$scellius_logo|escape:'html':'UTF-8'}" alt="Scellius" />{$scellius_title|escape:'html':'UTF-8'}
    {if $scellius_saved_identifier}
      <br /><br />
      {include file="./payment_std_oneclick.tpl"}
    {/if}

    <form action="{$link->getModuleLink('scellius', 'redirect', array(), true)|escape:'html':'UTF-8'}"
          method="post" id="scellius_standard"
          {if $scellius_saved_identifier} style="display: none;"{/if}
    >

      <input type="hidden" name="scellius_payment_type" value="standard" />

      {if $scellius_saved_identifier}
        <input id="scellius_payment_by_identifier" type="hidden" name="scellius_payment_by_identifier" value="1" />
      {/if}

      {if ($scellius_std_card_data_mode == 2)}
        <br />

        {assign var=first value=true}
        {foreach from=$scellius_avail_cards key="key" item="label"}
          <div style="display: inline-block;">
            {if $scellius_avail_cards|@count == 1}
              <input type="hidden" id="scellius_card_type_{$key|escape:'html':'UTF-8'}" name="scellius_card_type" value="{$key|escape:'html':'UTF-8'}" >
            {else}
              <input type="radio" id="scellius_card_type_{$key|escape:'html':'UTF-8'}" name="scellius_card_type" value="{$key|escape:'html':'UTF-8'}" style="vertical-align: middle;"{if $first == true} checked="checked"{/if} >
            {/if}

            <label for="scellius_card_type_{$key|escape:'html':'UTF-8'}" class="scellius_card">
              {assign var=img_file value=$smarty.const._PS_MODULE_DIR_|cat:'scellius/views/img/':{$key|lower|escape:'html':'UTF-8'}:'.png'}

              {if file_exists($img_file)}
                <img src="{$base_dir_ssl|escape:'html':'UTF-8'}modules/scellius/views/img/{$key|lower}.png" alt="{$label|escape:'html':'UTF-8'}" title="{$label|escape:'html':'UTF-8'}" >
              {else}
                <span>{$label|escape:'html':'UTF-8'}</span>
              {/if}
            </label>

            {assign var=first value=false}
          </div>
        {/foreach}
        <br />
        <div style="margin-bottom: 12px;"></div>

        {if $scellius_saved_identifier}
            <div>
                <ul>
                    {if $scellius_std_card_data_mode == 2}
                        <li>
                            <span class="scellius_span">{l s='You will enter payment data after order confirmation.' mod='scellius'}</span>
                        </li>
                    {/if}
                    <li style="margin: 8px 0px 8px;">
                        <span class="scellius_span">{l s='OR' mod='scellius'}</span>
                    </li>
                    <li>
                        <p class="scellius_link" onclick="scelliusOneclickPaymentSelect(1)">{l s='Click here to pay with your registered means of payment.' mod='scellius'}</p>
                    </li>
                </ul>
            </div>
        {/if}

        {if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
          <input id="scellius_submit_form" type="submit" name="submit" value="{l s='Pay' mod='scellius'}" class="button"/>
        {else}
          <button id="scellius_submit_form" type="submit" name="submit" class="button btn btn-default standard-checkout button-medium">
            <span>{l s='Pay' mod='scellius'}</span>
          </button>
        {/if}
      {/if}
    </form>

    {if $scellius_saved_identifier}
      <script type="text/javascript">
        $('#scellius_standard_link').click(function(){
          {if ($scellius_std_card_data_mode == 2)}
            $('#scellius_submit_form').click();
          {else}
            $('#scellius_standard').submit();
          {/if}
        });
      </script>
    {/if}
  </a>
</div>

{if version_compare($smarty.const._PS_VERSION_, '1.6', '>=')}
  </div></div>
{/if}