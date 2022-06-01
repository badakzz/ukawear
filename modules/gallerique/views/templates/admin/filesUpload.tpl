{**
* gallerique
*
* @category  Module
* @author    silbersaiten <info@silbersaiten.de>
* @support   silbersaiten <support@silbersaiten.de>
* @copyright 2015 silbersaiten
* @version   1.1.13
* @link      http://www.silbersaiten.de
* @license   See joined file licence.txt
*}

<script>
{literal}
$(function () {
    'use strict';
    var url = "{/literal}{$ajaxPath|escape:'quotes':'UTF-8'}{literal}";
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            if (data.result.files.length > 0) {
                $.each(data.result.files, function (index, file) {
                    if($("#files>.alert").is(".alert-success")) {
                        $('#files>.alert-success').append('<b>'+file.name+'</b>{/literal} {$upl|escape:'html':'UTF-8'}{literal}.<br>');
                    } else {
                        $('#files').append($(document.createElement('div')).addClass('alert alert-success').html('<button type="button" class="close" data-dismiss="alert">×</button><b>'+file.name+'</b>{/literal} {$upl|escape:'html':'UTF-8'}{literal}.<br>'));
                    }
                    
                    $("table#table-gallery_image").load("{/literal}{$refresh_link|escape:'quotes':'UTF-8'}{literal}" + " table#table-gallery_image");
                });
            }
            if (data.result.errors.length > 0) {
                $.each(data.result.errors, function (index, error) {
                    $('#files').append($(document.createElement('div')).addClass('alert alert-danger').html('<button type="button" class="close" data-dismiss="alert">×</button><b>'+error));
                });
            }
        },
        stop: function() {
            $('#files > .alert.alert-success').append("<br><h4>{/literal}{l s="Upload completed. Don't forget to activate your images." mod='gallerique'}{literal}</h4>");
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
{/literal}
</script>

<div class="panel form-horizontal">
    <div class="panel-heading">
        <i class="icon-upload"></i> {l s='Multiple upload' mod='gallerique'}
    </div>
    <div class="form-wrapper">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {l s='For a single image upload please use the button' mod='gallerique'} <a href="{$newimage|escape:'quotes':'UTF-8'}"><strong>{l s='add new' mod='gallerique'}</strong></a> {l s='in the top right control bar' mod='gallerique'}
        </div>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {l s='Available formats: ' mod='gallerique'}
            <ul>
                <li>JPG</li>
                <li>PNG</li>
            </ul>
            {l s='Please note: images uploaded with this function appear in your backend after reloading the page and they are deactivated. Please check uploaded images again and activate them manually' mod='gallerique'}
        </div>
        <form id="upload">
            <input id="fileupload" type="file" name="image[]" multiple data-sequential-uploads="false">
        </form>
        <br>
        <div id="progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
        <div id="files" class="files"></div>
    </div>
</div>
