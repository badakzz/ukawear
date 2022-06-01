{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}

<div class="leo-widget" id="{$widget_id}">
{if isset($subcategories)}
    <div class="widget-subcategories">
        {if isset($widget_heading)&&!empty($widget_heading)}
        <div class="widget-heading">
                {$widget_heading}
        </div>
        {/if}
        <div class="widget-inner">
            {if $cat->id_category != ''}
                <div class="menu-title">
                    <a href="{$link->getCategoryLink($cat->id_category, $cat->link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$cat->name|escape:'htmlall':'UTF-8'}" class="img">
                            {$cat->name|escape:'htmlall':'UTF-8'} 
                    </a>
                </div>
                <ul>
                {foreach from=$subcategories item=subcategory}
                    <li class="clearfix">
                        <a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}" class="img">
                                {$subcategory.name|escape:'htmlall':'UTF-8'} 
                        </a>
                    </li>
                {/foreach}
                </ul>
            {else}
                <div class="alert alert-warning">
                    {l s='The ID category does not exist' mod='leobootstrapmenu'}
                </div>
            {/if}
        </div>
    </div>
{/if} 
</div>