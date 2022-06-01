/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.21
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

$(function () {
    if (typeof(cmsbuilder) !== 'undefined') {
        var formgallery = {
            init: function () {
                cmsbuilder.registerSaveProcessor('gallery', function (containerIndex, blockIndex, fancyboxContent) {
                    var formData = fancyboxContent.find('select[name^=gallery_id_]'),
                        bsizelg = parseInt(fancyboxContent.find('input[name=bsizelg]').val()),
                        bsizesm = parseInt(fancyboxContent.find('input[name=bsizesm]').val()),
                        bsizexs = parseInt(fancyboxContent.find('input[name=bsizexs]').val()),
                        margin_top = parseInt(fancyboxContent.find('input[name=margin_top]').val()),
                        margin_bottom = parseInt(fancyboxContent.find('input[name=margin_bottom]').val()),
                        title_tag = fancyboxContent.find('select[name=title_tag]').val();

                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings = {};
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['bsizelg'] = bsizelg;
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['bsizesm'] = bsizesm;
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['bsizexs'] = bsizexs;
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['margin_top'] = margin_top;
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['margin_bottom'] = margin_bottom;
                    cmsbuilder.blockData[containerIndex].items[blockIndex].settings['title_tag'] = title_tag;


                    if (formData.length) {
                        cmsbuilder.blockData[containerIndex].items[blockIndex].content = {};

                        formData.each(function () {
                            var n = cmsbuilder.getLanguageInfoFromInputName($(this).attr('name'));

                            if (n) {
                                cmsbuilder.blockData[containerIndex].items[blockIndex].content['lang_' + n.id_lang] = {
                                    'id_lang': n.id_lang,
                                    'value': $(this).val()
                                };
                            }
                        });
                    }
                });

                cmsbuilder.registerLoadProcessor('gallery', function (containerIndex, blockIndex, fancyboxContents, blockData) {
                    fancyboxContents.find('input[name=bsizelg]').val(blockData.settings.bsizelg ? blockData.settings.bsizelg : 4);
                    fancyboxContents.find('input[name=bsizesm]').val(blockData.settings.bsizesm ? blockData.settings.bsizesm : 6);
                    fancyboxContents.find('input[name=bsizexs]').val(blockData.settings.bsizexs ? blockData.settings.bsizexs : 12);
                    fancyboxContents.find('input[name=margin_top]').val(blockData.settings.margin_top ? blockData.settings.margin_top : 0);
                    fancyboxContents.find('input[name=margin_bottom]').val(blockData.settings.margin_bottom ? blockData.settings.margin_bottom : 0);
                    fancyboxContents.find('select[name=title_tag]').val(blockData.settings.title_tag ? blockData.settings.title_tag : 1);
                    for (var i in blockData.content)
                        fancyboxContents.find('select[name=gallery_id_' + blockData.content[i].id_lang + ']').val(blockData.content[i].value);
                });
            }
        };

        formgallery.init();
    }
});
