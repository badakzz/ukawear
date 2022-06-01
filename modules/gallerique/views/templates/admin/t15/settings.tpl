{**
* Gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2016 silbersaiten
* @version   1.2.0
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}
<form id="" class="form-horizontal" action="" method="post">
<fieldset>
		<legend>
			{l s='Settings' mod='gallerique'}
		</legend>

		<div style="clear: both; padding-top:15px;" id="conf_id_GALLERIQUE_GALLERY_LIST">
			<label class="conf_title">{l s='Enable galleries list' mod='gallerique'}</label>
			<div class="margin-form">
				<label class="t" for="GALLERIQUE_GALLERY_LIST_on"><img src="../img/admin/enabled.gif" alt="Yes" title="Yes"></label>
				<input type="radio" name="GALLERIQUE_GALLERY_LIST" id="GALLERIQUE_GALLERY_LIST_on" value="1" {if $GALLERIQUE_GALLERY_LIST}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_GALLERY_LIST_on"> Yes</label>
				<label class="t" for="GALLERIQUE_GALLERY_LIST_off"><img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;"></label>
				<input type="radio" name="GALLERIQUE_GALLERY_LIST" id="GALLERIQUE_GALLERY_LIST_off" value="0" {if !$GALLERIQUE_GALLERY_LIST}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_GALLERY_LIST_off"> No</label>
			</div>
		</div>
		<div class="clear"></div>

		<div style="clear: both; padding-top:15px;" id="conf_id_GALLERIQUE_SHOW_COVERS">
			<label class="conf_title">{l s='Block view' mod='gallerique'}</label>
			<div class="margin-form">
				<label class="t" for="GALLERIQUE_SHOW_COVERS_on"><img src="../img/admin/enabled.gif" alt="Yes" title="Yes"></label>
				<input type="radio" name="GALLERIQUE_SHOW_COVERS" id="GALLERIQUE_SHOW_COVERS_on" value="1" {if $GALLERIQUE_SHOW_COVERS}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_SHOW_COVERS_on"> Yes</label>
				<label class="t" for="GALLERIQUE_SHOW_COVERS_off"><img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;"></label>
				<input type="radio" name="GALLERIQUE_SHOW_COVERS" id="GALLERIQUE_SHOW_COVERS_off" value="0" {if !$GALLERIQUE_SHOW_COVERS}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_SHOW_COVERS_off"> No</label>
			</div>
		</div>
		<div class="clear"></div>

		<div style="clear: both; padding-top:15px;" id="conf_id_GALLERIQUE_WITH_ID">
			<label class="conf_title">{l s='Block view' mod='gallerique'}</label>
			<div class="margin-form">
				<label class="t" for="GALLERIQUE_WITH_ID_on"><img src="../img/admin/enabled.gif" alt="Yes" title="Yes"></label>
				<input type="radio" name="GALLERIQUE_WITH_ID" id="GALLERIQUE_WITH_ID_on" value="1" {if $GALLERIQUE_WITH_ID}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_WITH_ID_on"> Yes</label>
				<label class="t" for="GALLERIQUE_WITH_ID_off"><img src="../img/admin/disabled.gif" alt="No" title="No" style="margin-left: 10px;"></label>
				<input type="radio" name="GALLERIQUE_WITH_ID" id="GALLERIQUE_WITH_ID_off" value="0" {if !$GALLERIQUE_WITH_ID}checked="checked"{/if}>
				<label class="t" for="GALLERIQUE_WITH_ID_off"> No</label>
			</div>
		</div>
		<div class="clear"></div>

		<div style="clear: both; padding-top:15px;" id="conf_id_GALLERIQUE_COVERS_PER_ROW">
			<label class="conf_title">{l s='Items per row' mod='gallerique'}</label>
			<div class="margin-form">
				<select name="GALLERIQUE_COVERS_PER_ROW" class=" fixed-width-xl" id="GALLERIQUE_COVERS_PER_ROW">
					<option value="6" {if $GALLERIQUE_COVERS_PER_ROW == 6}selected="selected"{/if}>2</option>
					<option value="4" {if $GALLERIQUE_COVERS_PER_ROW == 4}selected="selected"{/if}>3</option>
					<option value="3" {if $GALLERIQUE_COVERS_PER_ROW == 3}selected="selected"{/if}>4</option>
					<option value="2" {if $GALLERIQUE_COVERS_PER_ROW == 2}selected="selected"{/if}>6</option>
					<option value="1" {if $GALLERIQUE_COVERS_PER_ROW == 1}selected="selected"{/if}>12</option>
				</select>
			</div>
		</div>
		<div class="clear"></div>
		<div class="panel-footer">
			<button type="submit" value="1" id="gallery_image_content_form_submit_btn_1" name="submitGallerySettings" class="btn btn-default pull-right">
				<i class="process-icon-save"></i> Save
			</button>
		</div>
</fieldset>
</form>