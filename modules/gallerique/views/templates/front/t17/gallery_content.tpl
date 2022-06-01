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
        <h2 class="page-heading">{$gallery->title}</h2>
    {/if}
    {if $gallery->description_top}
        <div class="rte gallery-description gallery-top-description">
            {$gallery->description_top nofilter}
        </div>
    {/if}
    {if isset($gallery_images) && $gallery_images}
        <ul id="gallery_container" class="gallery gallery_{$gallery->id}">
            {foreach from=$gallery_images item=image}
                <li>
                    <a rel="gallery_image_{$gallery->id}" href="{$image.large}"
                       title="{if $image.label}{$image.label}{/if}"
                       {if $image.image_link}data-image-link="{$image.image_link}"{/if}>
                        <img src="{$smarty.const._PS_IMG_|escape:'quotes':'UTF-8'}loader.gif"
                             alt="{$image.alt|escape:'htmlall':'UTF-8'}"
                             title="{$image.alt|escape:'htmlall':'UTF-8'}"
                             data-src="{$image.thumb}"
                             width="{$sizes.thumbnail.width}" height="{$sizes.thumbnail.height}"
                             data-o="{$image.original}" data-buttons="{$sett.buttons}"/>
                        {if $image.label}
                            <p class="{if !$sett.show_label}hidden{/if} label-image"
                               style="max-width:{$sizes.thumbnail.width}px;">{$image.label|truncate:$sett.max_label}</p>
                        {/if}
                        {if $image.description}
                            <p class="{if !$sett.show_desc}hidden{/if} description"
                               style="max-width:{$sizes.thumbnail.width}px;">{$image.description|truncate:$sett.max_desc}</p>
                            <p class="hidden full-description">{$image.description}</p>
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
            {$gallery->description_bottom nofilter}
        </div>
    {/if}
</div>
