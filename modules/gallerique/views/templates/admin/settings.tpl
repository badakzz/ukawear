{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2018 silbersaiten
* @version   1.3.18
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
<form id="" class="form-horizontal" action="" method="post">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <div class="panel form-horizontal">
            <div class="panel-heading">
                <i class="icon-upload"></i> {l s='Settings' mod='gallerique'}
            </div>
            <div class="form-wrapper">
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Gallery link name' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        {foreach $languages as $language}
                            {if $languages|count > 1}
                                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                {if $language.id_lang != $defaultLang}style="display:none;"{/if}
                                >
                                <div class="col-lg-9">
                            {/if}
                            <input type="text"
                                   name="GALLERIQUE_GALLERY_LINK_NAME_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                   value="{$gallery_link_name[$language.id_lang]}"
                                   placeholder="-- GALLERY --"
                            >
                            {if $languages|count > 1}
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1"
                                            data-toggle="dropdown">
                                        {$language.iso_code|escape:'htmlall':'UTF-8'}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach from=$languages item=language}
                                            <li>
                                                <a href="javascript:hideOtherLanguage({$language.id_lang|escape:'htmlall':'UTF-8'});"
                                                   tabindex="-1">{$language.name|escape:'htmlall':'UTF-8'}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                    <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">{l s='A link to your gallery will look like this: ' mod='gallerique'}
                            "www.your-site.com/en/GALLERY/pictures"
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Galleries list link name' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        {foreach $languages as $language}
                            {if $languages|count > 1}
                                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                {if $language.id_lang != $defaultLang}style="display:none;"{/if}
                                >
                                <div class="col-lg-9">
                            {/if}
                            <input type="text"
                                   name="GALLERIQUE_GALLERIES_LINK_NAME_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                                   value="{$galleries_link_name[$language.id_lang]}"
                                   placeholder="-- IMAGINARIUM --"
                            >
                            {if $languages|count > 1}
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1"
                                            data-toggle="dropdown">
                                        {$language.iso_code|escape:'htmlall':'UTF-8'}
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        {foreach from=$languages item=language}
                                            <li>
                                                <a href="javascript:hideOtherLanguage({$language.id_lang|escape:'htmlall':'UTF-8'});"
                                                   tabindex="-1">{$language.name|escape:'htmlall':'UTF-8'}</a>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                    <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">{l s='A link to your galleries list will look like this: ' mod='gallerique'}
                            "www.your-site.com/en/IMAGINARIUM"
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Enable galleries list' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="GALLERIQUE_GALLERY_LIST" id="GALLERIQUE_GALLERY_LIST_on"
                                       value="1"
                                       {if $GALLERIQUE_GALLERY_LIST}checked="checked"{/if}>
                            <label for="GALLERIQUE_GALLERY_LIST_on">Yes</label>
                                <input type="radio" name="GALLERIQUE_GALLERY_LIST" id="GALLERIQUE_GALLERY_LIST_off"
                                       value="0"
                                       {if !$GALLERIQUE_GALLERY_LIST}checked="checked"{/if}>
                            <label for="GALLERIQUE_GALLERY_LIST_off">No</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Block view' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="GALLERIQUE_SHOW_COVERS" id="GALLERIQUE_SHOW_COVERS_on"
                                       value="1"
                                       {if $GALLERIQUE_SHOW_COVERS}checked="checked"{/if}>
                            <label for="GALLERIQUE_SHOW_COVERS_on">Yes</label>
                                <input type="radio" name="GALLERIQUE_SHOW_COVERS" id="GALLERIQUE_SHOW_COVERS_off"
                                       value="0"
                                       {if !$GALLERIQUE_SHOW_COVERS}checked="checked"{/if}>
                            <label for="GALLERIQUE_SHOW_COVERS_off">No</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        <span title="" data-toggle="tooltip" class="label-tooltip"
                              data-original-title="{l s='If you do not want the ID in the URL, disable this setting.' mod='gallerique'}"
                              data-html="true">
                            {l s='Use ID in URL' mod='gallerique'}
                        </span>
                    </label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="GALLERIQUE_WITH_ID" id="GALLERIQUE_WITH_ID_on" value="1"
                                       {if $GALLERIQUE_WITH_ID}checked="checked"{/if}>
                            <label for="GALLERIQUE_WITH_ID_on">Yes</label>
                                <input type="radio" name="GALLERIQUE_WITH_ID" id="GALLERIQUE_WITH_ID_off" value="0"
                                       {if !$GALLERIQUE_WITH_ID}checked="checked"{/if}>
                            <label for="GALLERIQUE_WITH_ID_off">No</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </div>
                    <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">{l s='Attention! If you turned this setting off, MUST use different "Friendly URL" for each gallery.' mod='gallerique'}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Items per row' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        <select name="GALLERIQUE_COVERS_PER_ROW" class=" fixed-width-xl" id="GALLERIQUE_COVERS_PER_ROW">
                            <option value="6" {if $GALLERIQUE_COVERS_PER_ROW == 6}selected="selected"{/if}>2</option>
                            <option value="4" {if $GALLERIQUE_COVERS_PER_ROW == 4}selected="selected"{/if}>3</option>
                            <option value="3" {if $GALLERIQUE_COVERS_PER_ROW == 3}selected="selected"{/if}>4</option>
                            <option value="2" {if $GALLERIQUE_COVERS_PER_ROW == 2}selected="selected"{/if}>6</option>
                            <option value="1" {if $GALLERIQUE_COVERS_PER_ROW == 1}selected="selected"{/if}>12</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Items per page' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        <input name="GALLERIQUE_COVERS_PER_PAGE" class="form-control fixed-width-xl"
                               id="GALLERIQUE_COVERS_PER_PAGE"
                               value="{if $GALLERIQUE_COVERS_PER_PAGE}{$GALLERIQUE_COVERS_PER_PAGE}{else}10{/if}"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">
                        {l s='Showing link without postfix' mod='gallerique'}
                    </label>
                    <div class="col-lg-9">
                        <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="GALLERIQUE_LINK_WITHOUT_POSTFIX"
                                       id="GALLERIQUE_LINK_WITHOUT_POSTFIX_on" value="1"
                                       {if $GALLERIQUE_LINK_WITHOUT_POSTFIX}checked="checked"{/if}>
                            <label for="GALLERIQUE_LINK_WITHOUT_POSTFIX_on">Yes</label>
                                <input type="radio" name="GALLERIQUE_LINK_WITHOUT_POSTFIX"
                                       id="GALLERIQUE_LINK_WITHOUT_POSTFIX_off" value="0"
                                       {if !$GALLERIQUE_LINK_WITHOUT_POSTFIX}checked="checked"{/if}>
                            <label for="GALLERIQUE_LINK_WITHOUT_POSTFIX_off">No</label>
                            <a class="slide-button btn"></a>
                        </span>
                    </div>
                    <div class="col-lg-9 col-lg-offset-3">
                        <div class="help-block">{l s='Your gallery link will looks like this: "www.example.com/gallery/1/company"' mod='gallerique'}</div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" value="1" id="gallery_image_content_form_submit_btn_1"
                        name="submitGallerySettings" class="btn btn-default pull-right">
                    <i class="process-icon-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</form>
