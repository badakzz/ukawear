{**
 * Copyright © Lyra Network.
 * This file is part of Scellius plugin for PrestaShop. See COPYING.md for license details.
 *
 * @author    Lyra Network (https://www.lyra.com/)
 * @copyright Lyra Network
 * @license   https://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *}

<script type="text/javascript">
  $(function() {
    $('#accordion').accordion({
      active: false,
      collapsible: true,
      autoHeight: false,
      heightStyle: 'content',
      header: 'h4',
      animated: false
    });
  });
</script>

<form method="POST" action="{$scellius_request_uri|escape:'html':'UTF-8'}" class="defaultForm form-horizontal">
  <div style="width: 100%;">
    <fieldset>
      <legend>
        <img style="width: 20px; vertical-align: middle;" src="../modules/scellius/logo.png" alt="Scellius">Scellius
      </legend>

      {l s='Developed by' mod='scellius'} : <b><a href="http://www.lyra-network.com/" target="_blank">Lyra Network</a></b><br />
      {l s='Contact us' mod='scellius'} : <b><a href="mailto:{$scellius_support_email|escape:'html':'UTF-8'}">{$scellius_support_email|escape:'html':'UTF-8'}</a></b><br />
      {l s='Module version' mod='scellius'} : <b>{if $smarty.const._PS_HOST_MODE_|defined}Cloud{/if}{$scellius_plugin_version|escape:'html':'UTF-8'}</b><br />
      {l s='Gateway version' mod='scellius'} : <b>{$scellius_gateway_version|escape:'html':'UTF-8'}</b><br />

      {if !empty($scellius_doc_files)}
        <span style="color: red; font-weight: bold; text-transform: uppercase;">{l s='Click to view the module configuration documentation :' mod='scellius'}</span>
        {foreach from=$scellius_doc_files key="file" item="lang"}
          <a style="margin-left: 10px; font-weight: bold; text-transform: uppercase;" href="../modules/scellius/installation_doc/{$file|escape:'html':'UTF-8'}" target="_blank">{$lang|escape:'html':'UTF-8'}</a>
        {/foreach}
      {/if}
    </fieldset>
  </div>

  <br /><br />

  <div id="accordion" style="width: 100%; float: none;">
    <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
      <a href="#">{l s='GENERAL CONFIGURATION' mod='scellius'}</a>
    </h4>
    <div>
      <fieldset>
        <legend>{l s='BASE SETTINGS' mod='scellius'}</legend>

        <label for="SCELLIUS_ENABLE_LOGS">{l s='Logs' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_ENABLE_LOGS" name="SCELLIUS_ENABLE_LOGS">
            {foreach from=$scellius_enable_disable_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ENABLE_LOGS === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Enable / disbale module logs' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='PAYMENT GATEWAY ACCESS' mod='scellius'}</legend>

        <label for="SCELLIUS_SITE_ID">{l s='Site ID' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_SITE_ID" name="SCELLIUS_SITE_ID" value="{$SCELLIUS_SITE_ID|escape:'html':'UTF-8'}" autocomplete="off">
          <p>{l s='The identifier provided by your bank.' mod='scellius'}</p>
        </div>

        {if !$scellius_plugin_features['qualif']}
          <label for="SCELLIUS_KEY_TEST">{l s='Key in test mode' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_KEY_TEST" name="SCELLIUS_KEY_TEST" value="{$SCELLIUS_KEY_TEST|escape:'html':'UTF-8'}" autocomplete="off">
            <p>{l s='Key provided by your bank for test mode (available in your store Back Office).' mod='scellius'}</p>
          </div>
        {/if}

        <label for="SCELLIUS_KEY_PROD">{l s='Key in production mode' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_KEY_PROD" name="SCELLIUS_KEY_PROD" value="{$SCELLIUS_KEY_PROD|escape:'html':'UTF-8'}" autocomplete="off">
          <p>{l s='Key provided by your bank (available in your store Back Office after enabling production mode).' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_MODE">{l s='Mode' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_MODE" name="SCELLIUS_MODE" {if $scellius_plugin_features['qualif']} disabled="disabled"{/if}>
            {foreach from=$scellius_mode_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_MODE === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='The context mode of this module.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_SIGN_ALGO">{l s='Signature algorithm' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_SIGN_ALGO" name="SCELLIUS_SIGN_ALGO">
            <option value="SHA-1"{if $SCELLIUS_SIGN_ALGO === 'SHA-1'} selected="selected"{/if}>SHA-1</option>
            <option value="SHA-256"{if $SCELLIUS_SIGN_ALGO === 'SHA-256'} selected="selected"{/if}>HMAC-SHA-256</option>
          </select>
          <p>
            {l s='Algorithm used to compute the payment form signature. Selected algorithm must be the same as one configured in your store Back Office.' mod='scellius'}<br />
            {if !$scellius_plugin_features['shatwo']}
              <b>{l s='The HMAC-SHA-256 algorithm should not be activated if it is not yet available in your store Back Office, the feature will be available soon.' mod='scellius'}</b>
            {/if}
          </p>
        </div>

        <label>{l s='Instant Payment Notification URL' mod='scellius'}</label>
        <div class="margin-form">
          <span style="font-weight: bold;">{$SCELLIUS_NOTIFY_URL|escape:'html':'UTF-8'}</span><br />
          <p>
            <img src="{$smarty.const._MODULE_DIR_|escape:'html':'UTF-8'}scellius/views/img/warn.png">
            <span style="color: red; display: inline-block;">
              {l s='URL to copy into your bank Back Office > Settings > Notification rules.' mod='scellius'}<br />
              {l s='In multistore mode, notification URL is the same for all the stores.' mod='scellius'}
            </span>
          </p>
        </div>

        <label for="SCELLIUS_PLATFORM_URL">{l s='Payment page URL' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_PLATFORM_URL" name="SCELLIUS_PLATFORM_URL" value="{$SCELLIUS_PLATFORM_URL|escape:'html':'UTF-8'}" style="width: 470px;">
          <p>{l s='Link to the payment page.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend onclick="javascript: scelliusAdditionalOptionsToggle(this);" style="cursor: pointer;">
          <span class="ui-icon ui-icon-triangle-1-e" style="display: inline-block; vertical-align: middle;"></span>
          {l s='REST API KEYS' mod='scellius'}
        </legend>

        <p style="font-size: .85em; color: #7F7F7F;">
         {l s='Configure this section if you are using order operations from Prestashop backend or if you are using « Embedded payment fields » mode.' mod='scellius'}
        <br />
         {l s='REST API keys are available in your store Back Office (menu: Settings > Shops > REST API keys).' mod='scellius'}
        </p>

        <section style="display: none; padding-top: 15px;">
          <label for="SCELLIUS_PRIVKEY_TEST">{l s='Test password' mod='scellius'}</label>
          <div class="margin-form">
            <input type="password" id="SCELLIUS_PRIVKEY_TEST" name="SCELLIUS_PRIVKEY_TEST" value="{$SCELLIUS_PRIVKEY_TEST|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off" />
          </div>
          <p></p>

          <label for="SCELLIUS_PRIVKEY_PROD">{l s='Production password' mod='scellius'}</label>
          <div class="margin-form">
            <input type="password" id="SCELLIUS_PRIVKEY_PROD" name="SCELLIUS_PRIVKEY_PROD" value="{$SCELLIUS_PRIVKEY_PROD|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off">
          </div>
          <p></p>

          <label for="SCELLIUS_PUBKEY_TEST">{l s='Public test key' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_PUBKEY_TEST" name="SCELLIUS_PUBKEY_TEST" value="{$SCELLIUS_PUBKEY_TEST|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off">
          </div>
          <p></p>

          <label for="SCELLIUS_PUBKEY_PROD">{l s='Public production key' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_PUBKEY_PROD" name="SCELLIUS_PUBKEY_PROD" value="{$SCELLIUS_PUBKEY_PROD|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off">
          </div>
          <p></p>

          <label for="SCELLIUS_RETKEY_TEST">{l s='HMAC-SHA-256 test key' mod='scellius'}</label>
          <div class="margin-form">
            <input type="password" id="SCELLIUS_RETKEY_TEST" name="SCELLIUS_RETKEY_TEST" value="{$SCELLIUS_RETKEY_TEST|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off">
          </div>
          <p></p>

          <label for="SCELLIUS_RETKEY_PROD">{l s='HMAC-SHA-256 production key' mod='scellius'}</label>
          <div class="margin-form">
            <input type="password" id="SCELLIUS_RETKEY_PROD" name="SCELLIUS_RETKEY_PROD" value="{$SCELLIUS_RETKEY_PROD|escape:'html':'UTF-8'}" style="width: 470px;" autocomplete="off">
          </div>
          <p></p>

          <label>{l s='API REST Notification URL' mod='scellius'}</label>
          <div class="margin-form">
            {$SCELLIUS_REST_NOTIFY_URL|escape:'html':'UTF-8'}<br />
            <p>
              <img src="{$smarty.const._MODULE_DIR_|escape:'html':'UTF-8'}scellius/views/img/warn.png">
              <span style="color: red; display: inline-block;">
                {l s='URL to copy into your bank Back Office > Settings > Notification rules.' mod='scellius'}<br />
                {l s='In multistore mode, notification URL is the same for all the stores.' mod='scellius'}
              </span>
            </p>
          </div>
        </section>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

        <label for="SCELLIUS_DEFAULT_LANGUAGE">{l s='Default language' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_DEFAULT_LANGUAGE" name="SCELLIUS_DEFAULT_LANGUAGE">
            {foreach from=$scellius_language_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_DEFAULT_LANGUAGE === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Default language on the payment page.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_AVAILABLE_LANGUAGES">{l s='Available languages' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_AVAILABLE_LANGUAGES" name="SCELLIUS_AVAILABLE_LANGUAGES[]" multiple="multiple" size="8">
            {foreach from=$scellius_language_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_AVAILABLE_LANGUAGES)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Languages available on the payment page. If you do not select any, all the supported languages will be available.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_DELAY">{l s='Capture delay' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_DELAY" name="SCELLIUS_DELAY" value="{$SCELLIUS_DELAY|escape:'html':'UTF-8'}">
          <p>{l s='The number of days before the bank capture (adjustable in your store Back Office).' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_VALIDATION_MODE">{l s='Validation mode' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_VALIDATION_MODE" name="SCELLIUS_VALIDATION_MODE">
            {foreach from=$scellius_validation_mode_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_VALIDATION_MODE === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='PAYMENT PAGE CUSTOMIZE' mod='scellius'}</legend>

        <label>{l s='Theme configuration' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_THEME_CONFIG"
              input_value=$SCELLIUS_THEME_CONFIG
              style="width: 470px;"
           }
          <p>{l s='The theme configuration to customize the payment page.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_SHOP_NAME">{l s='Shop name' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_SHOP_NAME" name="SCELLIUS_SHOP_NAME" value="{$SCELLIUS_SHOP_NAME|escape:'html':'UTF-8'}">
          <p>{l s='Shop name to display on the payment page. Leave blank to use gateway configuration.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_SHOP_URL">{l s='Shop URL' mod='scellius'}</label>
        <div class="margin-form">
          <input type="text" id="SCELLIUS_SHOP_URL" name="SCELLIUS_SHOP_URL" value="{$SCELLIUS_SHOP_URL|escape:'html':'UTF-8'}" style="width: 470px;">
          <p>{l s='Shop URL to display on the payment page. Leave blank to use gateway configuration.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='SELECTIVE 3DS' mod='scellius'}</legend>

        <label for="SCELLIUS_3DS_MIN_AMOUNT">{l s='Disable 3DS by customer group' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./table_amount_group.tpl"
            groups=$prestashop_groups
            input_name="SCELLIUS_3DS_MIN_AMOUNT"
            input_value=$SCELLIUS_3DS_MIN_AMOUNT
            min_only=true
          }
          <p>{l s='Amount below which 3DS will be disabled for each customer group. Needs subscription to selective 3DS option. For more information, refer to the module documentation.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='RETURN TO SHOP' mod='scellius'}</legend>

        <label for="SCELLIUS_REDIRECT_ENABLED">{l s='Automatic redirection' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_REDIRECT_ENABLED" name="SCELLIUS_REDIRECT_ENABLED" onchange="javascript: scelliusRedirectChanged();">
            {foreach from=$scellius_enable_disable_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_REDIRECT_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='If enabled, the buyer is automatically redirected to your site at the end of the payment.' mod='scellius'}</p>
        </div>

        <section id="scellius_redirect_settings">
          <label for="SCELLIUS_REDIRECT_SUCCESS_T">{l s='Redirection timeout on success' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_REDIRECT_SUCCESS_T" name="SCELLIUS_REDIRECT_SUCCESS_T" value="{$SCELLIUS_REDIRECT_SUCCESS_T|escape:'html':'UTF-8'}">
            <p>{l s='Time in seconds (0-300) before the buyer is automatically redirected to your website after a successful payment.' mod='scellius'}</p>
          </div>

          <label>{l s='Redirection message on success' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_REDIRECT_SUCCESS_M"
              input_value=$SCELLIUS_REDIRECT_SUCCESS_M
              style="width: 470px;"
            }
            <p>{l s='Message displayed on the payment page prior to redirection after a successful payment.' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_REDIRECT_ERROR_T">{l s='Redirection timeout on failure' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_REDIRECT_ERROR_T" name="SCELLIUS_REDIRECT_ERROR_T" value="{$SCELLIUS_REDIRECT_ERROR_T|escape:'html':'UTF-8'}">
            <p>{l s='Time in seconds (0-300) before the buyer is automatically redirected to your website after a declined payment.' mod='scellius'}</p>
          </div>

          <label>{l s='Redirection message on failure' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_REDIRECT_ERROR_M"
              input_value=$SCELLIUS_REDIRECT_ERROR_M
              style="width: 470px;"
            }
            <p>{l s='Message displayed on the payment page prior to redirection after a declined payment.' mod='scellius'}</p>
          </div>
        </section>

        <script type="text/javascript">
          scelliusRedirectChanged();
        </script>

        <label for="SCELLIUS_RETURN_MODE">{l s='Return mode' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_RETURN_MODE" name="SCELLIUS_RETURN_MODE">
            <option value="GET"{if $SCELLIUS_RETURN_MODE === 'GET'} selected="selected"{/if}>GET</option>
            <option value="POST"{if $SCELLIUS_RETURN_MODE === 'POST'} selected="selected"{/if}>POST</option>
          </select>
          <p>{l s='Method that will be used for transmitting the payment result from the payment page to your shop.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_FAILURE_MANAGEMENT">{l s='Payment failed management' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_FAILURE_MANAGEMENT" name="SCELLIUS_FAILURE_MANAGEMENT">
            {foreach from=$scellius_failure_management_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_FAILURE_MANAGEMENT === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='How to manage the buyer return to shop when the payment is failed.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_CART_MANAGEMENT">{l s='Cart management' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_CART_MANAGEMENT" name="SCELLIUS_CART_MANAGEMENT">
            {foreach from=$scellius_cart_management_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_CART_MANAGEMENT === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='We recommend to choose the option « Empty cart » in order to avoid amount inconsistencies. In case of return back from the browser button the cart will be emptied. However in case of cancelled or refused payment, the cart will be recovered. If you do not want to have this behavior but the default PrestaShop one which is to keep the cart, choose the second option.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend onclick="javascript: scelliusAdditionalOptionsToggle(this);" style="cursor: pointer;">
          <span class="ui-icon ui-icon-triangle-1-e" style="display: inline-block; vertical-align: middle;"></span>
          {l s='ADDITIONAL OPTIONS' mod='scellius'}
        </legend>
        <p style="font-size: .85em; color: #7F7F7F;">{l s='Configure this section if you use advanced risk assessment module or if you have a FacilyPay Oney contract.' mod='scellius'}</p>

        <section style="display: none; padding-top: 15px;">
          <label for="SCELLIUS_SEND_CART_DETAIL">{l s='Send shopping cart details' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SEND_CART_DETAIL" name="SCELLIUS_SEND_CART_DETAIL">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEND_CART_DETAIL === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If you disable this option, the shopping cart details will not be sent to the gateway. Attention, in some cases, this option has to be enabled. For more information, refer to the module documentation.' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_COMMON_CATEGORY">{l s='Category mapping' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_COMMON_CATEGORY" name="SCELLIUS_COMMON_CATEGORY" style="width: 220px;" onchange="javascript: scelliusCategoryTableVisibility();">
              <option value="CUSTOM_MAPPING"{if $SCELLIUS_COMMON_CATEGORY === 'CUSTOM_MAPPING'} selected="selected"{/if}>{l s='(Use category mapping below)' mod='scellius'}</option>
              {foreach from=$scellius_category_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_COMMON_CATEGORY === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Use the same category for all products.' mod='scellius'}</p>

            <table cellpadding="10" cellspacing="0" class="table scellius_category_mapping" style="margin-top: 15px;{if $SCELLIUS_COMMON_CATEGORY != 'CUSTOM_MAPPING'} display: none;{/if}">
            <thead>
              <tr>
                <th>{l s='Product category' mod='scellius'}</th>
                <th>{l s='Bank product category' mod='scellius'}</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$prestashop_categories item="category"}
                {if $category.id_parent === 0}
                  {continue}
                {/if}

                {assign var="category_id" value=$category.id_category}

                {if isset($SCELLIUS_CATEGORY_MAPPING[$category_id])}
                  {assign var="exists" value=true}
                {else}
                  {assign var="exists" value=false}
                {/if}

                {if $exists}
                  {assign var="scellius_category" value=$SCELLIUS_CATEGORY_MAPPING[$category_id]}
                {else}
                  {assign var="scellius_category" value="FOOD_AND_GROCERY"}
                {/if}

                <tr id="scellius_category_mapping_{$category_id|escape:'html':'UTF-8'}">
                  <td>{$category.name|escape:'html':'UTF-8'}{if $exists === false}<span style="color: red;">*</span>{/if}</td>
                  <td>
                    <select id="SCELLIUS_CATEGORY_MAPPING_{$category_id|escape:'html':'UTF-8'}" name="SCELLIUS_CATEGORY_MAPPING[{$category_id|escape:'html':'UTF-8'}]"
                        style="width: 220px;"{if $SCELLIUS_COMMON_CATEGORY != 'CUSTOM_MAPPING'} disabled="disabled"{/if}>
                      {foreach from=$scellius_category_options key="key" item="option"}
                        <option value="{$key|escape:'html':'UTF-8'}"{if $scellius_category === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                    </select>
                  </td>
                </tr>
              {/foreach}
            </tbody>
            </table>
            <p class="scellius_category_mapping"{if $SCELLIUS_COMMON_CATEGORY != 'CUSTOM_MAPPING'} style="display: none;"{/if}>{l s='Match each product category with a bank product category.' mod='scellius'} <b>{l s='Entries marked with * are newly added and must be configured.' mod='scellius'}</b></p>
          </div>

          <label for="SCELLIUS_SEND_SHIP_DATA">{l s='Always send advanced shipping data' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SEND_SHIP_DATA" name="SCELLIUS_SEND_SHIP_DATA">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEND_SHIP_DATA === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select « Yes » to send advanced shipping data for all payments (carrier name, delivery type and delivery rapidity).' mod='scellius'}</p>
          </div>

          <label>{l s='Shipping options' mod='scellius'}</label>
          <div class="margin-form">
            <table class="table" cellpadding="10" cellspacing="0">
            <thead>
              <tr>
                <th>{l s='Method title' mod='scellius'}</th>
                <th>{l s='Name' mod='scellius'}</th>
                <th>{l s='Type' mod='scellius'}</th>
                <th>{l s='Rapidity' mod='scellius'}</th>
                <th>{l s='Delay' mod='scellius'}</th>
                <th style="width: 270px;" colspan="3">{l s='Address' mod='scellius'}</th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$prestashop_carriers item="carrier"}
                {assign var="carrier_id" value=$carrier.id_carrier}

                {if isset($SCELLIUS_ONEY_SHIP_OPTIONS[$carrier_id])}
                  {assign var="exists" value=true}
                {else}
                  {assign var="exists" value=false}
                {/if}

                {if $exists}
                  {assign var="ship_option" value=$SCELLIUS_ONEY_SHIP_OPTIONS[$carrier_id]}
                {/if}

                <tr>
                  <td>{$carrier.name|escape:'html':'UTF-8'}{if $exists === false}<span style="color: red;">*</span>{/if}</td>
                  <td>
                    <input id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_label"
                        name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][label]"
                        value="{if isset($ship_option)}{$ship_option.label|escape:'html':'UTF-8'}{else}{$carrier.name|regex_replace:"#[^A-Z0-9ÁÀÂÄÉÈÊËÍÌÎÏÓÒÔÖÚÙÛÜÇ /'-]#ui":" "|substr:0:55}{/if}"
                        type="text">
                  </td>
                  <td>
                    <select id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_type" name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][type]" onchange="javascript: scelliusDeliveryTypeChanged({$carrier_id|escape:'html':'UTF-8'});" style="width: 150px;">
                      {foreach from=$scellius_delivery_type_options key="key" item="option"}
                        <option value="{$key|escape:'html':'UTF-8'}"{if (isset($ship_option) && $ship_option.type === $key) || ('PACKAGE_DELIVERY_COMPANY' === $key)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                    </select>
                  </td>
                  <td>
                    <select id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_speed" name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][speed]" onchange="javascript: scelliusDeliverySpeedChanged({$carrier_id|escape:'html':'UTF-8'});">
                      {foreach from=$scellius_delivery_speed_options key="key" item="option"}
                        <option value="{$key|escape:'html':'UTF-8'}"{if (isset($ship_option) && $ship_option.speed === $key) || ('STANDARD' === $key)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                    </select>
                  </td>
                  <td>
                    <select
                        id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_delay"
                        name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][delay]"
                        style="{if !isset($ship_option) || ($ship_option.type != 'RECLAIM_IN_SHOP') || ($ship_option.speed != 'PRIORITY')} display: none;{/if}">
                      {foreach from=$scellius_delivery_delay_options key="key" item="option"}
                        <option value="{$key|escape:'html':'UTF-8'}"{if (isset($ship_option) && isset($ship_option.delay) && ($ship_option.delay === $key)) || 'INFERIOR_EQUALS' === $key} selected="selected"{/if}>{$option|escape:'quotes':'UTF-8'}</option>
                      {/foreach}
                    </select>
                  </td>
                  <td>
                    <input
                        id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_address"
                        name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][address]"
                        placeholder="{l s='Address' mod='scellius'}"
                        value="{if isset($ship_option)}{$ship_option.address|escape:'html':'UTF-8'}{/if}"
                        style="width: 160px;{if !isset($ship_option) || $ship_option.type != 'RECLAIM_IN_SHOP'} display: none;{/if}"
                        type="text">
                  </td>
                  <td>
                    <input
                        id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_zip"
                        name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][zip]"
                        placeholder="{l s='Zip code' mod='scellius'}"
                        value="{if isset($ship_option)}{$ship_option.zip|escape:'html':'UTF-8'}{/if}"
                        style="width: 50px;{if !isset($ship_option) || $ship_option.type != 'RECLAIM_IN_SHOP'} display: none;{/if}"
                        type="text">
                  </td>
                  <td>
                    <input
                        id="SCELLIUS_ONEY_SHIP_OPTIONS_{$carrier_id|escape:'html':'UTF-8'}_city"
                        name="SCELLIUS_ONEY_SHIP_OPTIONS[{$carrier_id|escape:'html':'UTF-8'}][city]"
                        placeholder="{l s='City' mod='scellius'}"
                        value="{if isset($ship_option)}{$ship_option.city|escape:'html':'UTF-8'}{/if}"
                        style="width: 160px;{if !isset($ship_option) || $ship_option.type != 'RECLAIM_IN_SHOP'} display: none;{/if}"
                        type="text">
                  </td>
                </tr>
              {/foreach}
            </tbody>
            </table>
            <p>
              {l s='Define the information about all shipping methods.' mod='scellius'}<br />
              <b>{l s='Name' mod='scellius'} : </b>{l s='The label of the shipping method (use 55 alphanumeric characters, accentuated characters and these special characters: space, slash, hyphen, apostrophe).' mod='scellius'}<br />
              <b>{l s='Type' mod='scellius'} : </b>{l s='The delivery type of shipping method.' mod='scellius'}<br />
              <b>{l s='Rapidity' mod='scellius'} : </b>{l s='Select the delivery rapidity.' mod='scellius'}<br />
              <b>{l s='Delay' mod='scellius'} : </b>{l s='Select the delivery delay if speed is « Priority ».' mod='scellius'}<br />
              <b>{l s='Address' mod='scellius'} : </b>{l s='Enter address if it is a reclaim in shop.' mod='scellius'}<br />
              <b>{l s='Entries marked with * are newly added and must be configured.' mod='scellius'}</b>
            </p>
          </div>
        </section>
      </fieldset>
      <div class="clear">&nbsp;</div>
    </div>

    <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
      <a href="#">{l s='STANDARD PAYMENT' mod='scellius'}</a>
    </h4>
    <div>
      <fieldset>
        <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

       <label for="SCELLIUS_STD_ENABLED">{l s='Activation' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_STD_ENABLED" name="SCELLIUS_STD_ENABLED">
            {foreach from=$scellius_enable_disable_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
        </div>

        <label>{l s='Payment method title' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./input_text_lang.tpl"
            languages=$prestashop_languages
            current_lang=$prestashop_lang
            input_name="SCELLIUS_STD_TITLE"
            input_value=$SCELLIUS_STD_TITLE
            style="width: 330px;"
          }
          <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

        <label for="SCELLIUS_STD_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_STD_COUNTRY" name="SCELLIUS_STD_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_STD_COUNTRY')">
            {foreach from=$scellius_countries_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
        </div>

        <div id="SCELLIUS_STD_COUNTRY_MENU" {if $SCELLIUS_STD_COUNTRY === '1'} style="display: none;"{/if}>
          <label for="SCELLIUS_STD_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_COUNTRY_LST" name="SCELLIUS_STD_COUNTRY_LST[]" multiple="multiple" size="7">
              {foreach from=$scellius_countries_list['ps_countries'] key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_STD_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
          </div>
        </div>

        <label>{l s='Customer group amount restriction' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./table_amount_group.tpl"
            groups=$prestashop_groups
            input_name="SCELLIUS_STD_AMOUNTS"
            input_value=$SCELLIUS_STD_AMOUNTS
          }
          <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

        <label for="SCELLIUS_STD_DELAY">{l s='Capture delay' mod='scellius'}</label>
        <div class="margin-form">
          <input id="SCELLIUS_STD_DELAY" name="SCELLIUS_STD_DELAY" value="{$SCELLIUS_STD_DELAY|escape:'html':'UTF-8'}" type="text">
          <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_STD_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_STD_VALIDATION" name="SCELLIUS_STD_VALIDATION">
            <option value="-1"{if $SCELLIUS_STD_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
            {foreach from=$scellius_validation_mode_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
        </div>

        <label for="SCELLIUS_STD_PAYMENT_CARDS">{l s='Card Types' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_STD_PAYMENT_CARDS" name="SCELLIUS_STD_PAYMENT_CARDS[]" multiple="multiple" size="7">
            {foreach from=$scellius_payment_cards_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_STD_PAYMENT_CARDS)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='The card type(s) that can be used for the payment. Select none to use gateway configuration.' mod='scellius'}</p>
        </div>

        {if $scellius_plugin_features['oney']}
          <label for="SCELLIUS_STD_PROPOSE_ONEY">{l s='Propose FacilyPay Oney' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_PROPOSE_ONEY" name="SCELLIUS_STD_PROPOSE_ONEY">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_PROPOSE_ONEY === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select « Yes » if you want to propose FacilyPay Oney in standard payment. Attention, you must ensure that you have a FacilyPay Oney contract.' mod='scellius'}</p>
          </div>
        {/if}
        </fieldset>
        <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='ADVANCED OPTIONS' mod='scellius'}</legend>

        <label for="SCELLIUS_STD_CARD_DATA_MODE">{l s='Card data entry mode' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_STD_CARD_DATA_MODE" name="SCELLIUS_STD_CARD_DATA_MODE" onchange="javascript: scelliusCardEntryChanged();">
            {foreach from=$scellius_card_data_mode_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_CARD_DATA_MODE === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Select how the card data will be entered. Attention, to use bank data acquisition on the merchant site, you must ensure that you have subscribed to this option with your bank.' mod='scellius'}</p>
        </div>

        <div id="SCELLIUS_STD_CANCEL_IFRAME_MENU" {if $SCELLIUS_STD_CARD_DATA_MODE !== '4'} style="display: none;"{/if}>
          <label for="SCELLIUS_STD_CANCEL_IFRAME">{l s='Cancel payment in iframe mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_CANCEL_IFRAME" name="SCELLIUS_STD_CANCEL_IFRAME">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_CANCEL_IFRAME === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select « Yes » if you want to propose payment cancellation in iframe mode.' sprintf='Scellius' mod='scellius'}</p>
          </div>
        </div>

        <div id="SCELLIUS_REST_SETTINGS" {if $SCELLIUS_STD_CARD_DATA_MODE != '5'} style="display: none;"{/if}>
          <label for="SCELLIUS_STD_REST_DISPLAY_MODE">{l s='Display mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_REST_DISPLAY_MODE" name="SCELLIUS_STD_REST_DISPLAY_MODE">
              {foreach from=$scellius_rest_display_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_REST_DISPLAY_MODE === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select the mode to use to display embedded payment fields.' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_STD_REST_THEME">{l s='Theme' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_REST_THEME" name="SCELLIUS_STD_REST_THEME">
              {foreach from=$scellius_std_rest_theme_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_REST_THEME === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select a theme to use to display embedded payment fields. For more customization, you can edit module template manually.' mod='scellius'}</p>
          </div>
          <p></p>

          <label for="SCELLIUS_STD_REST_PLACEHLDR">{l s='Custom fields placeholders' mod='scellius'}</label>
          <div class="margin-form">
            <table class="table" cellspacing="0" cellpadding="10">
              <tbody>
                <tr>
                  <td>{l s='Card number' mod='scellius'}</td>
                  <td>
                    {include file="./input_text_lang.tpl"
                      languages=$prestashop_languages
                      current_lang=$prestashop_lang
                      input_name="SCELLIUS_STD_REST_PLACEHLDR[pan]"
                      field_id="SCELLIUS_STD_REST_PLACEHLDR_pan"
                      input_value=$SCELLIUS_STD_REST_PLACEHLDR.pan
                      style="width: 150px;"
                    }
                  </td>
                </tr>

                <tr>
                  <td>{l s='Expiry date' mod='scellius'}</td>
                  <td>
                    {include file="./input_text_lang.tpl"
                      languages=$prestashop_languages
                      current_lang=$prestashop_lang
                      input_name="SCELLIUS_STD_REST_PLACEHLDR[expiry]"
                      field_id="SCELLIUS_STD_REST_PLACEHLDR_expiry"
                      input_value=$SCELLIUS_STD_REST_PLACEHLDR.expiry
                      style="width: 150px;"
                    }
                  </td>
                </tr>

                <tr>
                  <td>{l s='CVV' mod='scellius'}</td>
                  <td>
                    {include file="./input_text_lang.tpl"
                      languages=$prestashop_languages
                      current_lang=$prestashop_lang
                      input_name="SCELLIUS_STD_REST_PLACEHLDR[cvv]"
                      field_id="SCELLIUS_STD_REST_PLACEHLDR_cvv"
                      input_value=$SCELLIUS_STD_REST_PLACEHLDR.cvv
                      style="width: 150px;"
                    }
                  </td>
                </tr>

              </tbody>
            </table>
            <p>{l s='Texts to use as placeholders for embedded payment fields.' mod='scellius'}</p>
          </div>
          <p></p>

          <label for="SCELLIUS_STD_REST_ATTEMPTS">{l s='Payment attempts number' mod='scellius'}</label>
          <div class="margin-form">
            <input type="text" id="SCELLIUS_STD_REST_ATTEMPTS" name="SCELLIUS_STD_REST_ATTEMPTS" value="{$SCELLIUS_STD_REST_ATTEMPTS|escape:'html':'UTF-8'}" style="width: 150px;" />
            <p>{l s='Maximum number of payment retries after a failed payment (between 0 and 9). If blank, the gateway default value is 3.' mod='scellius'}</p>
          </div>
          <p></p>

        </div>

        <div id="SCELLIUS_STD_1_CLICK_PAYMENT_MENU">
          <label for="SCELLIUS_STD_1_CLICK_PAYMENT">{l s='Payment by token' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_STD_1_CLICK_PAYMENT" name="SCELLIUS_STD_1_CLICK_PAYMENT">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_STD_1_CLICK_PAYMENT === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='The payment by token allows to pay orders without re-entering bank data at each payment. The "payment by token" option should be enabled on your %s store to use this feature.' sprintf='Scellius' mod='scellius'}</p>
          </div>

        </div>

      </fieldset>
      <div class="clear">&nbsp;</div>
    </div>

    {if $scellius_plugin_features['multi']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='PAYMENT IN INSTALLMENTS' mod='scellius'}</a>
      </h4>
      <div>
        {if $scellius_plugin_features['restrictmulti']}
          <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
            {l s='ATTENTION: The payment in installments feature activation is subject to the prior agreement of Société Générale.' mod='scellius'}<br />
            {l s='If you enable this feature while you have not the associated option, an error 10000 – INSTALLMENTS_NOT_ALLOWED or 07 - PAYMENT_CONFIG will occur and the buyer will not be able to pay.' mod='scellius'}
          </p>
        {/if}

        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_MULTI_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_MULTI_ENABLED" name="SCELLIUS_MULTI_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_MULTI_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_MULTI_TITLE"
              input_value=$SCELLIUS_MULTI_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_MULTI_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_MULTI_COUNTRY" name="SCELLIUS_MULTI_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_MULTI_COUNTRY')">
              {foreach from=$scellius_countries_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_MULTI_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
          </div>

          <div id="SCELLIUS_MULTI_COUNTRY_MENU" {if $SCELLIUS_MULTI_COUNTRY === '1'} style="display: none;"{/if}>
            <label for="SCELLIUS_MULTI_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_MULTI_COUNTRY_LST" name="SCELLIUS_MULTI_COUNTRY_LST[]" multiple="multiple" size="7">
                {foreach from=$scellius_countries_list['ps_countries'] key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_MULTI_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
            </div>
          </div>

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_MULTI_AMOUNTS"
              input_value=$SCELLIUS_MULTI_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_MULTI_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_MULTI_DELAY" name="SCELLIUS_MULTI_DELAY" value="{$SCELLIUS_MULTI_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_MULTI_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_MULTI_VALIDATION" name="SCELLIUS_MULTI_VALIDATION">
              <option value="-1"{if $SCELLIUS_MULTI_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_MULTI_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_MULTI_PAYMENT_CARDS">{l s='Card Types' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_MULTI_PAYMENT_CARDS" name="SCELLIUS_MULTI_PAYMENT_CARDS[]" multiple="multiple" size="7">
              {foreach from=$scellius_multi_payment_cards_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_MULTI_PAYMENT_CARDS)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='The card type(s) that can be used for the payment. Select none to use gateway configuration.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='ADVANCED OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_MULTI_CARD_MODE">{l s='Card type selection' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_MULTI_CARD_MODE" name="SCELLIUS_MULTI_CARD_MODE">
              {foreach from=$scellius_card_selection_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_MULTI_CARD_MODE === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select where the card type will be selected by the buyer.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label>{l s='Payment options' mod='scellius'}</label>
          <div class="margin-form">
            <script type="text/html" id="scellius_multi_row_option">
              {include file="./row_multi_option.tpl"
                languages=$prestashop_languages
                current_lang=$prestashop_lang
                key="SCELLIUS_MULTI_KEY"
                option=$scellius_default_multi_option
              }
            </script>

            <button type="button" id="scellius_multi_options_btn"{if !empty($SCELLIUS_MULTI_OPTIONS)} style="display: none;"{/if} onclick="javascript: scelliusAddMultiOption(true, '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>

            <table id="scellius_multi_options_table"{if empty($SCELLIUS_MULTI_OPTIONS)} style="display: none;"{/if} class="table" cellpadding="10" cellspacing="0">
              <thead>
                <tr>
                  <th style="font-size: 10px;">{l s='Label' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Min amount' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Max amount' mod='scellius'}</th>
                  {if in_array('CB', $scellius_multi_payment_cards_options)}
                    <th style="font-size: 10px;">{l s='Contract' mod='scellius'}</th>
                  {/if}
                  <th style="font-size: 10px;">{l s='Count' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Period' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='1st payment' mod='scellius'}</th>
                  <th style="font-size: 10px;"></th>
                </tr>
              </thead>

              <tbody>
                {foreach from=$SCELLIUS_MULTI_OPTIONS key="key" item="option"}
                  {include file="./row_multi_option.tpl"
                    languages=$prestashop_languages
                    current_lang=$prestashop_lang
                    key=$key
                    option=$option
                  }
                {/foreach}

                <tr id="scellius_multi_option_add">
                  <td colspan="{if in_array('CB', $scellius_multi_payment_cards_options)}7{else}6{/if}"></td>
                  <td>
                    <button type="button" onclick="javascript: scelliusAddMultiOption(false, '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <p>
              {l s='Click on « Add » button to configure one or more payment options.' mod='scellius'}<br />
              <b>{l s='Label' mod='scellius'} : </b>{l s='The option label to display on the frontend.' mod='scellius'}<br />
              <b>{l s='Min amount' mod='scellius'} : </b>{l s='Minimum amount to enable the payment option.' mod='scellius'}<br />
              <b>{l s='Max amount' mod='scellius'} : </b>{l s='Maximum amount to enable the payment option.' mod='scellius'}<br />
              {if in_array('CB', $scellius_multi_payment_cards_options)}
                <b>{l s='Contract' mod='scellius'} : </b>{l s='ID of the contract to use with the option (Leave blank preferably).' mod='scellius'}<br />
              {/if}
              <b>{l s='Count' mod='scellius'} : </b>{l s='Total number of payments.' mod='scellius'}<br />
              <b>{l s='Period' mod='scellius'} : </b>{l s='Delay (in days) between payments.' mod='scellius'}<br />
              <b>{l s='1st payment' mod='scellius'} : </b>{l s='Amount of first payment, in percentage of total amount. If empty, all payments will have the same amount.' mod='scellius'}<br />
              <b>{l s='Do not forget to click on « Save » button to save your modifications.' mod='scellius'}</b>
            </p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['choozeo']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='CHOOZEO PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_CHOOZEO_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_CHOOZEO_ENABLED" name="SCELLIUS_CHOOZEO_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_CHOOZEO_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_CHOOZEO_TITLE"
              input_value=$SCELLIUS_CHOOZEO_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          {if isset ($scellius_countries_list['CHOOZEO'])}
            <label for="SCELLIUS_CHOOZEO_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_CHOOZEO_COUNTRY" name="SCELLIUS_CHOOZEO_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_CHOOZEO_COUNTRY')">
                {foreach from=$scellius_countries_options key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_CHOOZEO_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
              <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
            </div>

            <div id="SCELLIUS_CHOOZEO_COUNTRY_MENU" {if $SCELLIUS_CHOOZEO_COUNTRY === '1'} style="display: none;"{/if}>
              <label for="SCELLIUS_CHOOZEO_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
              <div class="margin-form">
                <select id="SCELLIUS_CHOOZEO_COUNTRY_LST" name="SCELLIUS_CHOOZEO_COUNTRY_LST[]" multiple="multiple" size="7">
                  {if isset ($scellius_countries_list['CHOOZEO'])}
                      {foreach from=$scellius_countries_list['CHOOZEO'] key="key" item="option"}
                          <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_CHOOZEO_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                  {/if}
                </select>
              </div>
            </div>
          {else}
            <input type="hidden" name ="SCELLIUS_CHOOZEO_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_CHOOZEO_COUNTRY_LST[]" value ="">
            <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
                {l s='Payment method unavailable for the list of countries defined on your PrestaShop store.' mod='scellius'}
            </p>
          {/if}

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_CHOOZEO_AMOUNTS"
              input_value=$SCELLIUS_CHOOZEO_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_CHOOZEO_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_CHOOZEO_DELAY" name="SCELLIUS_CHOOZEO_DELAY" value="{$SCELLIUS_CHOOZEO_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label>{l s='Payment options' mod='scellius'}</label>
          <div class="margin-form">
            <table class="table" cellpadding="10" cellspacing="0">
              <thead>
                <tr>
                  <th>{l s='Activation' mod='scellius'}</th>
                  <th>{l s='Label' mod='scellius'}</th>
                  <th>{l s='Min amount' mod='scellius'}</th>
                  <th>{l s='Max amount' mod='scellius'}</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_3X][enabled]"
                      style="width: 100%;"
                      type="checkbox"
                      value="True"
                      {if !isset($SCELLIUS_CHOOZEO_OPTIONS.EPNF_3X.enabled) || ($SCELLIUS_CHOOZEO_OPTIONS.EPNF_3X.enabled ==='True')}checked{/if}>
                  </td>
                  <td>Choozeo 3X CB</td>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_3X][min_amount]"
                      value="{if isset($SCELLIUS_CHOOZEO_OPTIONS['EPNF_3X'])}{$SCELLIUS_CHOOZEO_OPTIONS['EPNF_3X']['min_amount']|escape:'html':'UTF-8'}{/if}"
                      style="width: 200px;"
                      type="text">
                  </td>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_3X][max_amount]"
                      value="{if isset($SCELLIUS_CHOOZEO_OPTIONS['EPNF_3X'])}{$SCELLIUS_CHOOZEO_OPTIONS['EPNF_3X']['max_amount']|escape:'html':'UTF-8'}{/if}"
                      style="width: 200px;"
                      type="text">
                  </td>
                </tr>

                <tr>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_4X][enabled]"
                      style="width: 100%;"
                      type="checkbox"
                      value="True"
                      {if !isset($SCELLIUS_CHOOZEO_OPTIONS.EPNF_4X.enabled) || ($SCELLIUS_CHOOZEO_OPTIONS.EPNF_4X.enabled ==='True')}checked{/if}>
                  </td>
                  <td>Choozeo 4X CB</td>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_4X][min_amount]"
                      value="{if isset($SCELLIUS_CHOOZEO_OPTIONS['EPNF_4X'])}{$SCELLIUS_CHOOZEO_OPTIONS['EPNF_4X']['min_amount']|escape:'html':'UTF-8'}{/if}"
                      style="width: 200px;"
                      type="text">
                  </td>
                  <td>
                    <input name="SCELLIUS_CHOOZEO_OPTIONS[EPNF_4X][max_amount]"
                      value="{if isset($SCELLIUS_CHOOZEO_OPTIONS['EPNF_4X'])}{$SCELLIUS_CHOOZEO_OPTIONS['EPNF_4X']['max_amount']|escape:'html':'UTF-8'}{/if}"
                      style="width: 200px;"
                      type="text">
                  </td>
                </tr>
              </tbody>
            </table>
            <p>{l s='Define amount restriction for each card.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['oney']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='PAYMENT IN 3 OR 4 TIMES ONEY' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_ONEY34_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ONEY34_ENABLED" name="SCELLIUS_ONEY34_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY34_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_ONEY34_TITLE"
              input_value=$SCELLIUS_ONEY34_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          {if isset ($scellius_countries_list['ONEY'])}
            <label for="SCELLIUS_ONEY34_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_ONEY34_COUNTRY" name="SCELLIUS_ONEY34_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_ONEY34_COUNTRY')">
                {foreach from=$scellius_countries_options key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY34_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
              <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
            </div>

            <div id="SCELLIUS_ONEY34_COUNTRY_MENU" {if $SCELLIUS_ONEY34_COUNTRY === '1'} style="display: none;"{/if}>
              <label for="SCELLIUS_ONEY34_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
              <div class="margin-form">
                <select id="SCELLIUS_ONEY34_COUNTRY_LST" name="SCELLIUS_ONEY34_COUNTRY_LST[]" multiple="multiple" size="7">
                  {if isset ($scellius_countries_list['ONEY'])}
                      {foreach from=$scellius_countries_list['ONEY'] key="key" item="option"}
                          <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_ONEY34_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                  {/if}
                </select>
              </div>
            </div>
          {else}
            <input type="hidden" name ="SCELLIUS_ONEY34_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_ONEY34_COUNTRY_LST[]" value ="">
            <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
                {l s='Payment method unavailable for the list of countries defined on your PrestaShop store.' mod='scellius'}
            </p>
          {/if}

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_ONEY34_AMOUNTS"
              input_value=$SCELLIUS_ONEY34_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_ONEY34_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_ONEY34_DELAY" name="SCELLIUS_ONEY34_DELAY" value="{$SCELLIUS_ONEY34_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_ONEY34_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ONEY34_VALIDATION" name="SCELLIUS_ONEY34_VALIDATION">
              <option value="-1"{if $SCELLIUS_ONEY34_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY34_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label>{l s='Payment options' mod='scellius'}</label>
          <div class="margin-form">
            <script type="text/html" id="scellius_oney34_row_option">
              {include file="./row_oney_option.tpl"
                languages=$prestashop_languages
                current_lang=$prestashop_lang
                key="SCELLIUS_ONEY34_KEY"
                option=$scellius_default_oney_option
                suffix='34'
              }
            </script>

            <button type="button" id="scellius_oney34_options_btn"{if !empty($SCELLIUS_ONEY34_OPTIONS)} style="display: none;"{/if} onclick="javascript: scelliusAddOneyOption(true, '34', '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>

            <table id="scellius_oney34_options_table"{if empty($SCELLIUS_ONEY34_OPTIONS)} style="display: none;"{/if} class="table" cellpadding="10" cellspacing="0">
              <thead>
                <tr>
                  <th style="font-size: 10px;">{l s='Label' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Code' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Min amount' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Max amount' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Count' mod='scellius'}</th>
                  <th style="font-size: 10px;">{l s='Rate' mod='scellius'}</th>
                  <th style="font-size: 10px;"></th>
                </tr>
              </thead>

              <tbody>
                {foreach from=$SCELLIUS_ONEY34_OPTIONS key="key" item="option"}
                  {include file="./row_oney_option.tpl"
                    languages=$prestashop_languages
                    current_lang=$prestashop_lang
                    key=$key
                    option=$option
                    suffix='34'
                  }
                {/foreach}

                <tr id="scellius_oney34_option_add">
                  <td colspan="6"></td>
                  <td>
                    <button type="button" onclick="javascript: scelliusAddOneyOption(false, '34', '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <p>
              {l s='Click on « Add » button to configure one or more payment options.' mod='scellius'}<br />
              <b>{l s='Label' mod='scellius'} : </b>{l s='The option label to display on the frontend.' mod='scellius'}<br />
              <b>{l s='Code' mod='scellius'} : </b>{l s='The option code as defined in your FacilyPay Oney contract.' mod='scellius'}<br />
              <b>{l s='Min amount' mod='scellius'} : </b>{l s='Minimum amount to enable the payment option.' mod='scellius'}<br />
              <b>{l s='Max amount' mod='scellius'} : </b>{l s='Maximum amount to enable the payment option.' mod='scellius'}<br />
              <b>{l s='Count' mod='scellius'} : </b>{l s='Total number of payments.' mod='scellius'}<br />
              <b>{l s='Rate' mod='scellius'} : </b>{l s='The interest rate in percentage.' mod='scellius'}<br />
              <b>{l s='Do not forget to click on « Save » button to save your modifications.' mod='scellius'}</b>
            </p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['oney']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='FACILYPAY ONEY PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_ONEY_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ONEY_ENABLED" name="SCELLIUS_ONEY_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_ONEY_TITLE"
              input_value=$SCELLIUS_ONEY_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          {if isset ($scellius_countries_list['ONEY'])}
            <label for="SCELLIUS_ONEY_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_ONEY_COUNTRY" name="SCELLIUS_ONEY_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_ONEY_COUNTRY')">
                {foreach from=$scellius_countries_options key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
              <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
            </div>

            <div id="SCELLIUS_ONEY_COUNTRY_MENU" {if $SCELLIUS_ONEY_COUNTRY === '1'} style="display: none;"{/if}>
              <label for="SCELLIUS_ONEY_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
              <div class="margin-form">
                <select id="SCELLIUS_ONEY_COUNTRY_LST" name="SCELLIUS_ONEY_COUNTRY_LST[]" multiple="multiple" size="7">
                  {if isset ($scellius_countries_list['ONEY'])}
                      {foreach from=$scellius_countries_list['ONEY'] key="key" item="option"}
                          <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_ONEY_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                  {/if}
                </select>
              </div>
            </div>
          {else}
            <input type="hidden" name ="SCELLIUS_ONEY_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_ONEY_COUNTRY_LST[]" value ="">
            <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
                {l s='Payment method unavailable for the list of countries defined on your PrestaShop store.' mod='scellius'}
            </p>
          {/if}

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_ONEY_AMOUNTS"
              input_value=$SCELLIUS_ONEY_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_ONEY_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_ONEY_DELAY" name="SCELLIUS_ONEY_DELAY" value="{$SCELLIUS_ONEY_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_ONEY_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ONEY_VALIDATION" name="SCELLIUS_ONEY_VALIDATION">
              <option value="-1"{if $SCELLIUS_ONEY_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_ONEY_ENABLE_OPTIONS">{l s='Enable options selection' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ONEY_ENABLE_OPTIONS" name="SCELLIUS_ONEY_ENABLE_OPTIONS" onchange="javascript: scelliusOneyEnableOptionsChanged();">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ONEY_ENABLE_OPTIONS === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enable payment options selection on merchant site.' mod='scellius'}</p>
          </div>

          <section id="scellius_oney_options_settings">
            <label>{l s='Payment options' mod='scellius'}</label>
            <div class="margin-form">
              <script type="text/html" id="scellius_oney_row_option">
                {include file="./row_oney_option.tpl"
                  languages=$prestashop_languages
                  current_lang=$prestashop_lang
                  key="SCELLIUS_ONEY_KEY"
                  option=$scellius_default_oney_option
                  suffix=''
                }
              </script>

              <button type="button" id="scellius_oney_options_btn"{if !empty($SCELLIUS_ONEY_OPTIONS)} style="display: none;"{/if} onclick="javascript: scelliusAddOneyOption(true, '', '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>

              <table id="scellius_oney_options_table"{if empty($SCELLIUS_ONEY_OPTIONS)} style="display: none;"{/if} class="table" cellpadding="10" cellspacing="0">
                <thead>
                  <tr>
                    <th style="font-size: 10px;">{l s='Label' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Code' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Min amount' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Max amount' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Count' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Rate' mod='scellius'}</th>
                    <th style="font-size: 10px;"></th>
                  </tr>
                </thead>

                <tbody>
                  {foreach from=$SCELLIUS_ONEY_OPTIONS key="key" item="option"}
                    {include file="./row_oney_option.tpl"
                      languages=$prestashop_languages
                      current_lang=$prestashop_lang
                      key=$key
                      option=$option
                      suffix=''
                    }
                  {/foreach}

                  <tr id="scellius_oney_option_add">
                    <td colspan="6"></td>
                    <td>
                      <button type="button" onclick="javascript: scelliusAddOneyOption(false, '', '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <p>
                {l s='Click on « Add » button to configure one or more payment options.' mod='scellius'}<br />
                <b>{l s='Label' mod='scellius'} : </b>{l s='The option label to display on the frontend.' mod='scellius'}<br />
                <b>{l s='Code' mod='scellius'} : </b>{l s='The option code as defined in your FacilyPay Oney contract.' mod='scellius'}<br />
                <b>{l s='Min amount' mod='scellius'} : </b>{l s='Minimum amount to enable the payment option.' mod='scellius'}<br />
                <b>{l s='Max amount' mod='scellius'} : </b>{l s='Maximum amount to enable the payment option.' mod='scellius'}<br />
                <b>{l s='Count' mod='scellius'} : </b>{l s='Total number of payments.' mod='scellius'}<br />
                <b>{l s='Rate' mod='scellius'} : </b>{l s='The interest rate in percentage.' mod='scellius'}<br />
                <b>{l s='Do not forget to click on « Save » button to save your modifications.' mod='scellius'}</b>
              </p>
            </div>
          </section>

          <script type="text/javascript">
            scelliusOneyEnableOptionsChanged();
          </script>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['fullcb']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='FULLCB PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_FULLCB_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_FULLCB_ENABLED" name="SCELLIUS_FULLCB_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_FULLCB_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_FULLCB_TITLE"
              input_value=$SCELLIUS_FULLCB_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          <div id="SCELLIUS_FULLCB_COUNTRY_MENU">
            <input type="hidden" name ="SCELLIUS_FULLCB_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_FULLCB_COUNTRY_LST[]" value ="FR">
            <label for="SCELLIUS_FULLCB_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
            <div class="margin-form">
              <span style="font-size: 13px; padding-top: 5px; vertical-align: middle;"><b>{$scellius_countries_list['ps_countries']['FR']|escape:'html':'UTF-8'}</b></span>
            </div>
          </div>

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_FULLCB_AMOUNTS"
              input_value=$SCELLIUS_FULLCB_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_FULLCB_ENABLE_OPTS">{l s='Enable options selection' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_FULLCB_ENABLE_OPTS" name="SCELLIUS_FULLCB_ENABLE_OPTS" onchange="javascript: scelliusFullcbEnableOptionsChanged();">
              {foreach from=$scellius_yes_no_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_FULLCB_ENABLE_OPTS === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enable payment options selection on merchant site.' mod='scellius'}</p>
          </div>

          <section id="scellius_fullcb_options_settings">
            <label>{l s='Payment options' mod='scellius'}</label>
            <div class="margin-form">
              <table class="table" cellpadding="10" cellspacing="0">
                <thead>
                  <tr>
                    <th style="font-size: 10px;">{l s='Activation' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Label' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Min amount' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Max amount' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Rate' mod='scellius'}</th>
                    <th style="font-size: 10px;">{l s='Cap' mod='scellius'}</th>
                  </tr>
                </thead>

                <tbody>
                  {foreach from=$SCELLIUS_FULLCB_OPTIONS key="key" item="option"}
                  <tr>
                    <td>
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][enabled]"
                        style="width: 100%;"
                        type="checkbox"
                        value="True"
                        {if !isset($option.enabled) || ($option.enabled === 'True')}checked{/if}>
                    </td>
                    <td>
                      {include file="./input_text_lang.tpl"
                        languages=$prestashop_languages
                        current_lang=$prestashop_lang
                        input_name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][label]"
                        field_id="SCELLIUS_FULLCB_OPTIONS_{$key|escape:'html':'UTF-8'}_label"
                        input_value=$option['label']
                        style="width: 140px;"
                      }
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][count]" value="{$option['count']|escape:'html':'UTF-8'}" type="text" style="display: none; width: 0px;">
                    </td>
                    <td>
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][min_amount]"
                        value="{if isset($option)}{$option['min_amount']|escape:'html':'UTF-8'}{/if}"
                        style="width: 75px;"
                        type="text">
                    </td>
                    <td>
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][max_amount]"
                        value="{if isset($option)}{$option['max_amount']|escape:'html':'UTF-8'}{/if}"
                        style="width: 75px;"
                        type="text">
                    </td>
                    <td>
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][rate]"
                        value="{if isset($option)}{$option['rate']|escape:'html':'UTF-8'}{/if}"
                        style="width: 70px;"
                        type="text">
                    </td>
                    <td>
                      <input name="SCELLIUS_FULLCB_OPTIONS[{$key|escape:'html':'UTF-8'}][cap]"
                        value="{if isset($option)}{$option['cap']|escape:'html':'UTF-8'}{/if}"
                        style="width: 70px;"
                        type="text">
                    </td>
                  </tr>
                  {/foreach}
                </tbody>
              </table>
              <p>
                {l s='Configure FullCB payment options.' mod='scellius'}<br />
                <b>{l s='Activation' mod='scellius'} : </b>{l s='Enable / disable the payment option.' mod='scellius'}<br />
                <b>{l s='Min amount' mod='scellius'} : </b>{l s='Minimum amount to enable the payment option.' mod='scellius'}<br />
                <b>{l s='Max amount' mod='scellius'} : </b>{l s='Maximum amount to enable the payment option.' mod='scellius'}<br />
                <b>{l s='Rate' mod='scellius'} : </b>{l s='The interest rate in percentage.' mod='scellius'}<br />
                <b>{l s='Cap' mod='scellius'} : </b>{l s='Maximum fees amount of payment option.' mod='scellius'}<br />
                <b>{l s='Do not forget to click on « Save » button to save your modifications.' mod='scellius'}</b>
              </p>
            </div>
          </section>

          <script type="text/javascript">
            scelliusFullcbEnableOptionsChanged();
          </script>
         </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['ancv']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='ANCV PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_ANCV_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ANCV_ENABLED" name="SCELLIUS_ANCV_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ANCV_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_ANCV_TITLE"
              input_value=$SCELLIUS_ANCV_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_ANCV_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ANCV_COUNTRY" name="SCELLIUS_ANCV_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_ANCV_COUNTRY')">
              {foreach from=$scellius_countries_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ANCV_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
          </div>

          <div id="SCELLIUS_ANCV_COUNTRY_MENU" {if $SCELLIUS_ANCV_COUNTRY === '1'} style="display: none;"{/if}>
            <label for="SCELLIUS_ANCV_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_ANCV_COUNTRY_LST" name="SCELLIUS_ANCV_COUNTRY_LST[]" multiple="multiple" size="7">
                {foreach from=$scellius_countries_list['ps_countries'] key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_ANCV_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
            </div>
          </div>

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_ANCV_AMOUNTS"
              input_value=$SCELLIUS_ANCV_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_ANCV_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_ANCV_DELAY" name="SCELLIUS_ANCV_DELAY" value="{$SCELLIUS_ANCV_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_ANCV_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_ANCV_VALIDATION" name="SCELLIUS_ANCV_VALIDATION">
              <option value="-1"{if $SCELLIUS_ANCV_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_ANCV_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['sepa']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='SEPA PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_SEPA_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SEPA_ENABLED" name="SCELLIUS_SEPA_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEPA_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_SEPA_TITLE"
              input_value=$SCELLIUS_SEPA_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          {if isset ($scellius_countries_list['SEPA'])}
            <label for="SCELLIUS_SEPA_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_SEPA_COUNTRY" name="SCELLIUS_SEPA_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_SEPA_COUNTRY')">
                {foreach from=$scellius_countries_options key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEPA_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
              <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
            </div>

            <div id="SCELLIUS_SEPA_COUNTRY_MENU" {if $SCELLIUS_SEPA_COUNTRY === '1'} style="display: none;"{/if}>
              <label for="SCELLIUS_SEPA_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
              <div class="margin-form">
                <select id="SCELLIUS_SEPA_COUNTRY_LST" name="SCELLIUS_SEPA_COUNTRY_LST[]" multiple="multiple" size="7">
                  {if isset ($scellius_countries_list['SEPA'])}
                      {foreach from=$scellius_countries_list['SEPA'] key="key" item="option"}
                          <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_SEPA_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                  {/if}
                </select>
              </div>
            </div>
          {else}
            <input type="hidden" name ="SCELLIUS_SEPA_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_SEPA_COUNTRY_LST[]" value ="">
            <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
                {l s='Payment method unavailable for the list of countries defined on your PrestaShop store.' mod='scellius'}
            </p>
          {/if}

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_SEPA_AMOUNTS"
              input_value=$SCELLIUS_SEPA_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
         </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_SEPA_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_SEPA_DELAY" name="SCELLIUS_SEPA_DELAY" value="{$SCELLIUS_SEPA_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_SEPA_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SEPA_VALIDATION" name="SCELLIUS_SEPA_VALIDATION">
              <option value="-1"{if $SCELLIUS_SEPA_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEPA_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_SEPA_MANDATE_MODE">{l s='SEPA direct debit mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SEPA_MANDATE_MODE" name="SCELLIUS_SEPA_MANDATE_MODE">
              {foreach from=$scellius_sepa_mandate_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SEPA_MANDATE_MODE === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Select SEPA direct debit mode. Attention, the two last choices require the payment by token option on %s.' sprintf='Scellius' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['paypal']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='PAYPAL PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_PAYPAL_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_PAYPAL_ENABLED" name="SCELLIUS_PAYPAL_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_PAYPAL_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_PAYPAL_TITLE"
              input_value=$SCELLIUS_PAYPAL_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_PAYPAL_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_PAYPAL_COUNTRY" name="SCELLIUS_PAYPAL_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_PAYPAL_COUNTRY')">
              {foreach from=$scellius_countries_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_PAYPAL_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
          </div>

          <div id="SCELLIUS_PAYPAL_COUNTRY_MENU" {if $SCELLIUS_PAYPAL_COUNTRY === '1'} style="display: none;"{/if}>
            <label for="SCELLIUS_PAYPAL_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_PAYPAL_COUNTRY_LST" name="SCELLIUS_PAYPAL_COUNTRY_LST[]" multiple="multiple" size="7">
                {foreach from=$scellius_countries_list['ps_countries'] key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_PAYPAL_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
            </div>
          </div>

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_PAYPAL_AMOUNTS"
              input_value=$SCELLIUS_PAYPAL_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='PAYMENT PAGE' mod='scellius'}</legend>

          <label for="SCELLIUS_PAYPAL_DELAY">{l s='Capture delay' mod='scellius'}</label>
          <div class="margin-form">
            <input id="SCELLIUS_PAYPAL_DELAY" name="SCELLIUS_PAYPAL_DELAY" value="{$SCELLIUS_PAYPAL_DELAY|escape:'html':'UTF-8'}" type="text">
            <p>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}</p>
          </div>

          <label for="SCELLIUS_PAYPAL_VALIDATION">{l s='Validation mode' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_PAYPAL_VALIDATION" name="SCELLIUS_PAYPAL_VALIDATION">
              <option value="-1"{if $SCELLIUS_PAYPAL_VALIDATION === '-1'} selected="selected"{/if}>{l s='Base settings configuration' mod='scellius'}</option>
              {foreach from=$scellius_validation_mode_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_PAYPAL_VALIDATION === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    {if $scellius_plugin_features['sofort']}
      <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
        <a href="#">{l s='SOFORT BANKING PAYMENT' mod='scellius'}</a>
      </h4>
      <div>
        <fieldset>
          <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

          <label for="SCELLIUS_SOFORT_ENABLED">{l s='Activation' mod='scellius'}</label>
          <div class="margin-form">
            <select id="SCELLIUS_SOFORT_ENABLED" name="SCELLIUS_SOFORT_ENABLED">
              {foreach from=$scellius_enable_disable_options key="key" item="option"}
                <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SOFORT_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
              {/foreach}
            </select>
            <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
          </div>

          <label>{l s='Payment method title' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./input_text_lang.tpl"
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              input_name="SCELLIUS_SOFORT_TITLE"
              input_value=$SCELLIUS_SOFORT_TITLE
              style="width: 330px;"
            }
            <p>{l s='Method title to display on payment means page.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>

        <fieldset>
          <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

          {if isset ($scellius_countries_list['SOFORT'])}
            <label for="SCELLIUS_SOFORT_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
            <div class="margin-form">
              <select id="SCELLIUS_SOFORT_COUNTRY" name="SCELLIUS_SOFORT_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_SOFORT_COUNTRY')">
                {foreach from=$scellius_countries_options key="key" item="option"}
                  <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_SOFORT_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                {/foreach}
              </select>
              <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
            </div>

            <div id="SCELLIUS_SOFORT_COUNTRY_MENU" {if $SCELLIUS_SOFORT_COUNTRY === '1'} style="display: none;"{/if}>
              <label for="SCELLIUS_SOFORT_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
              <div class="margin-form">
                <select id="SCELLIUS_SOFORT_COUNTRY_LST" name="SCELLIUS_SOFORT_COUNTRY_LST[]" multiple="multiple" size="7">
                  {if isset ($scellius_countries_list['SOFORT'])}
                      {foreach from=$scellius_countries_list['SOFORT'] key="key" item="option"}
                          <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_SOFORT_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
                      {/foreach}
                  {/if}
                </select>
              </div>
            </div>
          {else}
            <input type="hidden" name ="SCELLIUS_SOFORT_COUNTRY" value="1" ></input>
            <input type="hidden" name ="SCELLIUS_SOFORT_COUNTRY_LST[]" value ="">
            <p style="background: none repeat scroll 0 0 #FFFFE0; border: 1px solid #E6DB55; font-size: 13px; margin: 0 0 20px; padding: 10px;">
                {l s='Payment method unavailable for the list of countries defined on your PrestaShop store.' mod='scellius'}
            </p>
          {/if}

          <label>{l s='Customer group amount restriction' mod='scellius'}</label>
          <div class="margin-form">
            {include file="./table_amount_group.tpl"
              groups=$prestashop_groups
              input_name="SCELLIUS_SOFORT_AMOUNTS"
              input_value=$SCELLIUS_SOFORT_AMOUNTS
            }
            <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
          </div>
        </fieldset>
        <div class="clear">&nbsp;</div>
      </div>
    {/if}

    <h4 style="font-weight: bold; margin-bottom: 0; overflow: hidden; line-height: unset !important;">
      <a href="#">{l s='OTHER PAYMENT MEANS' mod='scellius'}</a>
    </h4>
    <div>
      <fieldset>
        <legend>{l s='MODULE OPTIONS' mod='scellius'}</legend>

        <label for="SCELLIUS_OTHER_ENABLED">{l s='Activation' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_OTHER_ENABLED" name="SCELLIUS_OTHER_ENABLED">
            {foreach from=$scellius_enable_disable_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_OTHER_ENABLED === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Enables / disables this payment method.' mod='scellius'}</p>
        </div>

        <label>{l s='Payment method title' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./input_text_lang.tpl"
            languages=$prestashop_languages
            current_lang=$prestashop_lang
            input_name="SCELLIUS_OTHER_TITLE"
            input_value=$SCELLIUS_OTHER_TITLE
            style="width: 330px;"
          }
          <p>{l s='Method title to display on payment means page. Used only if « Regroup payment means » option is enabled.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>

      <fieldset>
        <legend>{l s='RESTRICTIONS' mod='scellius'}</legend>

        <label for="SCELLIUS_OTHER_COUNTRY">{l s='Restrict to some countries' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_OTHER_COUNTRY" name="SCELLIUS_OTHER_COUNTRY" onchange="javascript: scelliusCountriesRestrictMenuDisplay('SCELLIUS_OTHER_COUNTRY')">
            {foreach from=$scellius_countries_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_OTHER_COUNTRY === (string)$key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='Buyer\'s billing countries in which this payment method is available.' mod='scellius'}</p>
        </div>

        <div id="SCELLIUS_OTHER_COUNTRY_MENU" {if $SCELLIUS_OTHER_COUNTRY === '1'} style="display: none;"{/if}>
        <label for="SCELLIUS_OTHER_COUNTRY_LST">{l s='Authorized countries' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_OTHER_COUNTRY_LST" name="SCELLIUS_OTHER_COUNTRY_LST[]" multiple="multiple" size="7">
            {foreach from=$scellius_countries_list['ps_countries'] key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if in_array($key, $SCELLIUS_OTHER_COUNTRY_LST)} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
        </div>
        </div>

        <label>{l s='Customer group amount restriction' mod='scellius'}</label>
        <div class="margin-form">
          {include file="./table_amount_group.tpl"
            groups=$prestashop_groups
            input_name="SCELLIUS_OTHER_AMOUNTS"
            input_value=$SCELLIUS_OTHER_AMOUNTS
          }
          <p>{l s='Define amount restriction for each customer group.' mod='scellius'}</p>
        </div>
      </fieldset>
      <div class="clear scellius-grouped">&nbsp;</div>

      <fieldset>
        <legend>{l s='PAYMENT OPTIONS' mod='scellius'}</legend>

        <label for="SCELLIUS_OTHER_GROUPED_VIEW">{l s='Regroup payment means ' mod='scellius'}</label>
        <div class="margin-form">
          <select id="SCELLIUS_OTHER_GROUPED_VIEW" name="SCELLIUS_OTHER_GROUPED_VIEW" onchange="javascript: scelliusGroupedViewChanged();">
            {foreach from=$scellius_enable_disable_options key="key" item="option"}
              <option value="{$key|escape:'html':'UTF-8'}"{if $SCELLIUS_OTHER_GROUPED_VIEW === $key} selected="selected"{/if}>{$option|escape:'html':'UTF-8'}</option>
            {/foreach}
          </select>
          <p>{l s='If this option is enabled, all the payment means added in this section will be displayed within the same payment submodule.' mod='scellius'}</p>
        </div>

        <label>{l s='Payment means' mod='scellius'}</label>
        <div class="margin-form">
          <script type="text/html" id="scellius_other_payment_means_row_option">
            {include file="./row_other_payment_means_option.tpl"
              payment_means_cards=$scellius_payment_cards_options
              countries_list=$scellius_countries_list['ps_countries']
              validation_mode_options=$scellius_validation_mode_options
              enable_disable_options=$scellius_enable_disable_options
              languages=$prestashop_languages
              current_lang=$prestashop_lang
              key="SCELLIUS_OTHER_PAYMENT_SCRIPT_MEANS_KEY"
              option=$scellius_default_other_payment_means_option
            }
          </script>

          <button type="button" id="scellius_other_payment_means_options_btn"{if !empty($SCELLIUS_OTHER_PAYMENT_MEANS)} style="display: none;"{/if} onclick="javascript: scelliusAddOtherPaymentMeansOption(true, '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>

          <table id="scellius_other_payment_means_options_table"{if empty($SCELLIUS_OTHER_PAYMENT_MEANS)} style="display: none;"{/if} class="table" cellpadding="10" cellspacing="0">
          <thead>
            <tr>
              <th style="font-size: 10px;">{l s='Label' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Means of payment' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Countries' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Min amount' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Max amount' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Capture' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Validation mode' mod='scellius'}</th>
              <th style="font-size: 10px;">{l s='Cart data' mod='scellius'}</th>
              <th style="font-size: 10px;"></th>
            </tr>
          </thead>

          <tbody>
            {foreach from=$SCELLIUS_OTHER_PAYMENT_MEANS key="key" item="option"}
              {include file="./row_other_payment_means_option.tpl"
                payment_means_cards=$scellius_payment_cards_options
                countries_list=$scellius_countries_list['ps_countries']
                validation_mode_options=$scellius_validation_mode_options
                enable_disable_options=$scellius_enable_disable_options
                languages=$prestashop_languages
                current_lang=$prestashop_lang
                key=$key
                option=$option
              }
            {/foreach}

            <tr id="scellius_other_payment_means_option_add">
              <td colspan="8"></td>
              <td>
                <button type="button" onclick="javascript: scelliusAddOtherPaymentMeansOption(false, '{l s='Delete' mod='scellius'}');">{l s='Add' mod='scellius'}</button>
              </td>
            </tr>
          </tbody>
          </table>

          {if empty($SCELLIUS_OTHER_PAYMENT_MEANS)}
            <input type="hidden" id="SCELLIUS_OTHER_PAYMENT_MEANS" name="SCELLIUS_OTHER_PAYMENT_MEANS" value="">
          {/if}

          <p>
            {l s='Click on « Add » button to configure one or more payment means.' mod='scellius'}<br />
            <b>{l s='Label' mod='scellius'} : </b>{l s='The label of the means of payment to display on your site.' mod='scellius'}<br />
            <b>{l s='Means of payment' mod='scellius'} : </b>{l s='Choose the means of payment you want to propose.' mod='scellius'}<br />
            <b>{l s='Countries' mod='scellius'} : </b>{l s='Countries where the means of payment will be available. Keep blank to authorize all countries.' mod='scellius'}<br />
            <b>{l s='Min amount' mod='scellius'} : </b>{l s='Minimum amount to enable the means of payment.' mod='scellius'}<br />
            <b>{l s='Max amount' mod='scellius'} : </b>{l s='Maximum amount to enable the means of payment.' mod='scellius'}<br />
            <b>{l s='Capture' mod='scellius'} : </b>{l s='The number of days before the bank capture. Enter value only if different from « Base settings ».' mod='scellius'}<br />
            <b>{l s='Validation mode' mod='scellius'} : </b>{l s='If manual is selected, you will have to confirm payments manually in your bank Back Office.' mod='scellius'}<br />
            <b>{l s='Cart data' mod='scellius'} : </b>{l s='If you disable this option, the shopping cart details will not be sent to the gateway. Attention, in some cases, this option has to be enabled. For more information, refer to the module documentation.' mod='scellius'}<br />
            <b>{l s='Do not forget to click on « Save » button to save your modifications.' mod='scellius'}</b>
          </p>
        </div>
      </fieldset>
      <div class="clear">&nbsp;</div>
    </div>

   </div>

  {if version_compare($smarty.const._PS_VERSION_, '1.6', '<')}
    <div class="clear" style="width: 100%;">
      <input type="submit" class="button" name="scellius_submit_admin_form" value="{l s='Save' mod='scellius'}" style="float: right;">
    </div>
  {else}
    <div class="panel-footer" style="width: 100%;">
      <button type="submit" value="1" name="scellius_submit_admin_form" class="btn btn-default pull-right" style="float: right !important;">
        <i class="process-icon-save"></i>
        {l s='Save' mod='scellius'}
      </button>
    </div>
  {/if}
</form>

<br />
<br />