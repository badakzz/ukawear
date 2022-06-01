{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2015 silbersaiten
* @version   1.1.5
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
{extends file='page.tpl'}

{block name='page_content'}

{if !empty($gallery)}
{capture name=path}
	{if Configuration::get('GALLERIQUE_GALLERY_LIST')}
	<a href="{$link->getModuleLink('gallerique', 'gallerylist')}">{l s='Galleries' mod='gallerique'}</a>
	<span class="navigation-pipe">/</span>
	{/if}
	{$gallery->title}
{/capture}
	{include file='module:gallerique/views/templates/front/t17/gallery_content.tpl'}
{else}
<p class="alert alert-warning">{l s='Selected gallery does not exist' mod='gallerique'}</p>
{/if}

{/block}