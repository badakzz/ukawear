{* 
* @Module Name: Leo Slideshow
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  2007-2018 Leotheme
*}

{extends file=$layout}
{block name='content'}
	{if $leoslideshow_tpl == 1}
		{include file='./leoslideshow.tpl'}
	{else}
		{include file='module:leoslideshow/views/templates/front/leoslideshow.tpl'}
	{/if}
{/block}
