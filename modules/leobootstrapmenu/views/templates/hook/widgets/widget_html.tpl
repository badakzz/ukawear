{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}

<div class="leo-widget" id="{$widget_id}">
    {if isset($html)}
        <div class="widget-html">
            {if isset($widget_heading)&&!empty($widget_heading)}
            <div class="menu-title">
                    {$widget_heading}
            </div>
            {/if}
            <div class="widget-inner">
                    {$html nofilter}{* HTML form , no escape necessary *}
            </div>
        </div>
    {/if}
</div>