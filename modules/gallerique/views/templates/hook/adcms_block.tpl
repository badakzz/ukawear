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

<div class="form-group clearfix">
    <label class="control-label col-lg-3">{l s='Gallery' mod='gallerique'}</label>
    <div class="col-lg-9">
		{if !$gallery_list || !$gallery_list|@count}
			<div class="alert alert-warning">{l s='You have to add galleries first' mod='gallerique'}</div>
		{else}
			{foreach $languages as $language}
				{if $languages|count > 1}
				<div class="form-group translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}"{if $language.id_lang != $defaultFormLanguage} style="display:none;"{/if}>
					<div class="col-lg-9">
				{/if}
					<select name="gallery_id_{$language.id_lang|escape:'htmlall':'UTF-8'}">
						{foreach from=$gallery_list item=gallery}
						<option value="{$gallery.id|escape:'htmlall':'UTF-8'}">{$gallery.name|escape:'htmlall':'UTF-8'}</option>
						{/foreach}
					</select>
				{if $languages|count > 1}
					</div>
					<div class="col-lg-2">
						<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
							{$language.iso_code|escape:'htmlall':'UTF-8'}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							{foreach from=$languages item=language}
							<li>
								<a href="javascript:hideOtherLanguage({$language.id_lang|escape:'htmlall':'UTF-8'});" tabindex="-1">{$language.name|escape:'htmlall':'UTF-8'}</a>
							</li>
							{/foreach}
						</ul>
					</div>
				</div>
				{/if}
			{/foreach}
		{/if}
    </div>
</div>
