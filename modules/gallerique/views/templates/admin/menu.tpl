{**
* Gallerique
*
* @author    silbersaiten <info@silbersaiten.de>
* @copyright 2018 Silbersaiten
* @license   See joined file licence.txt
* @version   1.3.10
* @category  Module
* @support   silbersaiten <support@silbersaiten.de>
* @link      http://www.silbersaiten.de
*}
<nav class="menu-gallerique navbar">
    <ul class="nav nav-pills navbar-left menu">
        {foreach $menu_items as $menu_item_key => $menu_item}
            <li{if $menu_item.active == true} class="active"{/if}>
                <a href="{$menu_item.url|escape:'html':'UTF-8'}">
                    {if $menu_item.icon != ''}
                        <i class="{$menu_item.icon|escape:'htmlall':'UTF-8'}"></i>
                    {/if}
                    {$menu_item.name|escape:'htmlall':'UTF-8'}
                </a></li>
        {/foreach}
    </ul>
    <ul class="nav nav-pills navbar-right info">
        <li><a href="#" rel="nofollow"><i class="icon-info"></i>
                {$module_name|escape:'htmlall':'UTF-8'}
                {l s='Version' mod='gallerique'}
                : {$module_version|escape:'htmlall':'UTF-8'}
            </a>
        </li>
        {if $changelog == true}
            <li>
                <a href="{$_path|escape:'quotes':'UTF-8'}Readme.md" class="fancybox">
                    <i class="icon-list"></i>
                    {l s='Changelog' mod='gallerique'}
                </a>
            </li>
        {/if}
        <li>
            <a href="https://addons.prestashop.com/de/contact-us?id_product=8367" target="_blank">
                <i class="icon-envelope-o"></i>
                {l s='Contact us' mod='gallerique'}
            </a>
        </li>
        <li><a href="https://addons.prestashop.com/de/20_silbersaiten" target="_blank">
                <i class="icon-th-list"></i>
                {l s='Our modules' mod='gallerique'}
            </a>
        </li>
    </ul>
</nav>
<script type="text/javascript">
    $(document).ready(function () {
        $('.fancybox').fancybox({
            'type': 'iframe',
            autoDimensions: false,
            autoSize: false,
            width: 600,
            height: 'auto',
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });
</script>
