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
{extends file='page.tpl'}

{block name='page_content'}

    {capture name=path}{l s='Galleries' mod='gallerique'}{/capture}
    <div id="gallery_list" class="block">
        <h2 class="page-heading">{l s='Our Galleries' mod='gallerique'}</h2>

        {if $galleries}
            {if $covers}
                {assign var="i" value=0}
                {assign var="gallery_count" value=count($galleries)}
                {foreach from=$galleries item=gallery}
                    {if $i == 0}
                        <div class="row">
                    {/if}
                    <div class="col-md-{$perrow|escape:'htmlall':'UTF-8'} gallerique-gallery">
                        <div class="gallerique-gallery-cover">
                            <a href="{$link->getModuleLink('gallerique', 'gallery', ['id_gallery' => $gallery.id, 'link_rewrite' => $gallery.link_rewrite])}">
                                <img src="{$gallery.cover}">
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
                            <a href="{$link->getModuleLink('gallerique', 'gallery', ['id_gallery' => $gallery.id, 'link_rewrite' => $gallery.link_rewrite])}">{$gallery.name}</a>
                        </li>
                    {/foreach}
                </ul>
            {/if}
        {else}
            <p class="alert alert-warning">{l s='There are no galleries at this time. Try again later.' mod='gallerique'}</p>
        {/if}
    </div>
    <nav class="pagination">
        <div class="col-md-4">
            {block name='pagination_summary'}
                {l s='Showing %1$d - %2$d of %3$d items' sprintf=[$pagination.items_shown_from, $pagination.items_shown_to, $pagination.total_items] mod='gallerique'}
            {/block}
        </div>
        <div class="col-md-6 offset-md-2 pr-0">
            <ul class="page-list clearfix text-sm-center">
                <li>
                    <a href="{$previous_link}"
                       class="previous {if !$previous_link}disabled{/if}"
                       {if !$previous_link}onclick="return false"{/if}
                    >
                        <i class="material-icons">&#xE314;</i>{l s='Previous' mod='gallerique'}
                    </a>
                </li>
                {foreach $all_links as $key => $all_link}
                    <li {if $all_link.current}class="current"{/if}>
                        <a class=""
                           href="{$all_link.link}">
                            {$key + 1}
                        </a>
                    </li>
                {/foreach}
                <li>
                    <a href="{$next_link}"
                       class="next {if !$next_link}disabled{/if}"
                       {if !$next_link}onclick="return false"{/if}
                    >
                        {l s='Next' mod='gallerique'}<i class="material-icons">&#xE315;</i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
{/block}
