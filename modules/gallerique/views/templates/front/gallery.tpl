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
{if !empty($gallery)}
{capture name=path}
	{if Configuration::get('GALLERIQUE_GALLERY_LIST')}
	<a href="{$link->getModuleLink('gallerique', 'gallerylist')|escape:'htmlall':'UTF-8'}">{l s='Galleries' mod='gallerique'}</a>
	<span class="navigation-pipe">{$navigationPipe|escape:'htmlall':'UTF-8'}</span>
	{/if}
	{$gallery->title|escape:'htmlall':'UTF-8'}
{/capture}
	{include file=$gallery_template gallery=$gallery}
{else}
<p class="alert alert-warning">{l s='Selected gallery does not exist' mod='gallerique'}</p>
{/if}