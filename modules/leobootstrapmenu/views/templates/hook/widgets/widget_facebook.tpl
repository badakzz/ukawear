{* 
* @Module Name: Leo Bootstrap Menu
* @Website: leotheme.com.com - prestashop template provider
* @author Leotheme <leotheme@gmail.com>
* @copyright  Leotheme
*}
<div class="leo-widget" id="{$widget_id}">
		<div class="facebook-wrapper" style="width:{$width}" >
		{if isset($application_id)&&$application_id}
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/{$displaylanguage}/all.js#xfbml=1&appId={$application_id}";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		{else}
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/{$displaylanguage}/sdk.js#xfbml=1&version=v2.8";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
		{/if}
		<div class="fb-page" data-href="{$page_url}" data-tabs="{$tabdisplay}" data-height="{$height}" data-width="{$width}" data-show-facepile="{$show_faces}" data-hide-cover="{$hide_cover}" data-small-header="{$small_header}"></div>
	</div>
 </div>