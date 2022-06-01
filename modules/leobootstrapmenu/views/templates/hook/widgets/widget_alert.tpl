{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}

<div class="leo-widget" id="{$widget_id}">
    {if isset($html)&& !empty($html)}
        <div class="alert {$alert_type}">
            {$html nofilter}{* HTML form , no escape necessary *}
        </div>
    {/if}
</div>