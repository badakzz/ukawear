{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2015 silbersaiten
* @version   1.1.13
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
<script type="text/javascript">
	var PS_ALLOW_ACCENTED_CHARS_URL = {if $PS_ALLOW_ACCENTED_CHARS_URL}1{else}0{/if};
	
	$(function(){
		$('input[id^=link_rewrite_]').blur(function(){
			updateLinkRewrite();
		});
	});
</script>
<div class="alert alert-info">
	<p>{l s='Note that you can use special tags to display a gallery virtually anywhere you want. Use [displayGallery id=x], "x" being the id of the gallery you want to display.' mod='gallerique'}</p>
</div>