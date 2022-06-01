{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}

<div class="leo-widget" id="{$widget_id}">
{if isset($username)}
    <div class="widget-twitter">
        {if isset($widget_heading)&&!empty($widget_heading)}
        <div class="menu-title">
            {$widget_heading}
        </div>
        {/if}
        <div class="widget-inner">
            <a class="twitter-timeline" data-dnt="true" data-theme="{$theme}" data-link-color="#FFFFFF" width="{$width}" height="{$height}" data-chrome="{$chrome}" data-border-color="#{$border_color}" lang="EN" data-tweet-limit="{$count}" data-show-replies="{$show_replies}" href="https://twitter.com/{$username}"  data-widget-id="{$twidget_id}">Tweets by @{$username}</a>
        </div>
    </div>
{literal}
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if (!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
{/literal}
{/if}
</div>