{*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Responsive Carousel Feed Instagram Images
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*}

{extends file=$layout}

{block name='content'}
    <section id="instagram-page">
        <h1 class="page-heading">
            {l s='Instagram' mod='boninstagramcarousel'}
        </h1>
        {if isset($instagram_param) && $instagram_param}
            <div class="instagram-carousel-container clearfix block">
                <div class="block_content">
                    <ul class="clearfix row">
                        {foreach from=$instagram_param item=media name=media}
                            {if $smarty.foreach.media.iteration <= $limit}
                                <li class="instagram-item col-xs-12 col-sm-4 col-md-3">
                                    <a href="https://www.instagram.com/p/{$media.shortcode|escape:'htmlall':'UTF-8'}/" target="_blank" rel="nofollow">
                                        <img src="{$media.thumbnail_src|escape:'htmlall':'UTF-8'}" alt="">
                                        <span class="instagram_cover"></span>
                                        <span class="instagram_likes">{$media.edge_liked_by.count|escape:'htmlall':'UTF-8'}</span>
                                        <span class="instagram_comment">{$media.edge_media_to_comment.count|escape:'htmlall':'UTF-8'}</span>
                                    </a>
                                </li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>
        {else}
            <p class="alert alert-warning">{l s='No instagram images.' mod='boninstagramcarousel'}</p>
        {/if}
    </section>
{/block}