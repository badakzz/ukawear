{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2018 silbersaiten
* @version   1.3.20
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
<div id="galleryWrapper">
    {if isset($g_title) && $g_title == true}
        <h2 class="page-heading">{$gallery->title|escape:'htmlall':'UTF-8'}</h2>
    {/if}
    {if $gallery->description_top}
        <div class="rte gallery-description gallery-top-description">
            {$gallery->description_top|escape:'quotes':'UTF-8'}
        </div>
    {/if}
    {if isset($gallery_images) && $gallery_images}
        <ul id="gallery_container" class="gallery gallery_{$gallery->id|escape:'htmlall':'UTF-8'}">
            {foreach from=$gallery_images item=image}
                <li>
                    <a rel="gallery_image_{$gallery->id|escape:'htmlall':'UTF-8'}"
                       href="{$image.large|escape:'htmlall':'UTF-8'}"
                       title="{if $image.label}{$image.label|escape:'htmlall':'UTF-8'}{/if}"
                       {if $image.image_link}data-image-link="{$image.image_link|escape:'htmlall':'UTF-8'}"{/if}>
                        <img src="{$smarty.const._PS_IMG_|escape:'quotes':'UTF-8'}loader.gif"
                             alt="{$image.alt|escape:'htmlall':'UTF-8'}"
                             title="{$image.alt|escape:'htmlall':'UTF-8'}"
                             data-src="{$image.thumb|escape:'htmlall':'UTF-8'}"
                             width="{$sizes.thumbnail.width|escape:'htmlall':'UTF-8'}"
                             height="{$sizes.thumbnail.height|escape:'htmlall':'UTF-8'}"
                             data-o="{$image.original|escape:'htmlall':'UTF-8'}"
                             data-buttons="{$sett.buttons|escape:'htmlall':'UTF-8'}"/>
                        {if $image.label}
                            <p class="{if !$sett.show_label}hidden{/if} label-image"
                               style="max-width:{$sizes.thumbnail.width|escape:'htmlall':'UTF-8'}px;">{$image.label|truncate:$sett.max_label|escape:'htmlall':'UTF-8'}</p>
                        {/if}
                        {if $image.description}
                            <p class="{if !$sett.show_desc}hidden{/if} description"
                               style="max-width:{$sizes.thumbnail.width|escape:'htmlall':'UTF-8'}px;">{$image.description|truncate:$sett.max_desc|escape:'htmlall':'UTF-8'}</p>
                            <p class="hidden full-description">{$image.description|escape:'htmlall':'UTF-8'}</p>
                        {/if}
                    </a>
                </li>
            {/foreach}
        </ul>
    {else}
        <p class="alert alert-warning">
            {l s='This gallery contains no images so far. Try again later.' mod='gallerique'}
        </p>
    {/if}
    {if $gallery->description_bottom}
        <div class="rte gallery-description gallery-top-description">
            {$gallery->description_bottom|escape:'quotes':'UTF-8'}
        </div>
    {/if}
</div>
