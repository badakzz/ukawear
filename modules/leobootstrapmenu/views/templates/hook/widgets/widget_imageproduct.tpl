{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}

<div class="leo-widget" id="{$widget_id}">
{if isset($images)}
    <div class="widget-images block">
            {if isset($widget_heading)&&!empty($widget_heading)}
            <h4 class="title_block">
                    {$widget_heading}
            </h4>
            {/if}
            <div class="block_content clearfix">
                            <div class="images-list clearfix">	
                            <div class="row">
                                    {foreach from=$images item=image name=images}
                                            <div class="image-item {if $columns == 5} col-md-2-4 {else} col-md-{12/$columns}{/if} col-xs-12">
                                                    <a class="fancybox" rel="leogallery{$id_btmegamenu_widgets}" href= "{$link->getImageLink($image.link_rewrite, $image.id_image, $thickimage)}">
                                                            <img class="replace-2x img-fluid" src="{$link->getImageLink($image.link_rewrite, $image.id_image, $smallimage)}" alt=""/>
                                                    </a>
                                            </div>
                                    {/foreach}
                            </div>
                    </div>
            </div>
    </div>
{/if}
</div>