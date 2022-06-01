{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2018 silbersaiten
* @version   1.3.22
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
{capture name=path}{l s='Galleries' mod='gallerique'}{/capture}

<div id="gallery_list" class="block">
    <h2 class="page-heading">{l s='Our Galleries' mod='gallerique'}</h2>
    {if $galleries}
        {if $covers}
            {assign var="i" value=0}
            {assign var="gallery_count" value=count($galleries)}
            {foreach from=$galleries key=key item=gallery}
                {if $i == 0}
                    <div class="row">
                {/if}
                <div class="col-md-{$perrow|escape:'htmlall':'UTF-8'} gallerique-gallery">
                    <div class="gallerique-gallery-cover">
                        <a href="{$link->getModuleLink('gallerique', 'gallery', ['id_gallery' => $gallery.id, 'link_rewrite' => $gallery.link_rewrite])|escape:'htmlall':'UTF-8'}">
                            <img src="{$gallery.cover|escape:'quotes':'UTF-8'}">
                        </a>
                    </div>
                    <div class="gallerique-gallery-desc">
                        {$gallery.name|escape:'htmlall':'UTF-8'}
                    </div>
                </div>
                {$i = $i + 1}
                {if ($i - $inrow) == 0 || $gallery_count == $key + 1}
                    {$i = 0}
                    </div>
                {/if}
            {/foreach}
        {else}
            <ul id="gallery_list" class="list-block">
                {foreach from=$galleries item=gallery}
                    <li>
                        <a href="{$link->getModuleLink('gallerique', 'gallery', ['id_gallery' => $gallery.id, 'link_rewrite' => $gallery.link_rewrite])|escape:'htmlall':'UTF-8'}">
                            {$gallery.name|escape:'htmlall':'UTF-8'}
                        </a>
                    </li>
                {/foreach}
            </ul>
        {/if}
    {else}
        <p class="alert alert-warning">{l s='There are no galleries at this time. Try again later.' mod='gallerique'}</p>
    {/if}
    <div class="bottom-pagination-content clearfix">
        <nav>
            <div class="col-xs-4">
                {l s='Showing %1$d - %2$d of %3$d items' sprintf=[$pagination.items_shown_from, $pagination.items_shown_to, $pagination.total_items] mod='gallerique'}
            </div>
            <div class="col-xs-8">
                <ul class="pagination">
                    <li class="pagination_previous {if !$previous_link}disabled{/if}">
                        <a href="{$previous_link}"
                           class="previous"
                           {if !$previous_link}onclick="return false"{/if}
                        >
                            <span><i class="icon-chevron-left"></i> <b>{l s='Previous' mod='gallerique'}</b></span>
                        </a>
                    </li>
                    {foreach $all_links as $key => $all_link}
                        <li {if $all_link.current}class="current"{/if}>
                            <a class=""
                               href="{$all_link.link}">
                                <span>{$key + 1}</span>
                            </a>
                        </li>
                    {/foreach}
                    <li class="pagination_next {if !$next_link}disabled{/if}">
                        <a href="{$next_link}"
                           class="next"
                           {if !$next_link}onclick="return false"{/if}
                        >
                            <span><b>{l s='Next' mod='gallerique'}</b> <i class="icon-chevron-right"></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
