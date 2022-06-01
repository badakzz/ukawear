<?php
/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2019 silbersaiten
 * @version   1.3.25
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_25($object)
{
    unset($object);
    return Db::getInstance()->execute( 'ALTER TABLE `'._DB_PREFIX_.'gallery_image_lang` MODIFY `image_link` VARCHAR(255) NULL;');
}
