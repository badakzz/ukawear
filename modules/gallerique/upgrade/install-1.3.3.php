<?php
/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2017 silbersaiten
 * @version   1.3.3
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_3($object)
{
	$object->deleteOldFiles();

    return (Db::getInstance()->execute(
    	'ALTER TABLE `'._DB_PREFIX_.'gallery_image_lang` ADD `alt` varchar(255) NOT NULL AFTER `image_link`'
    ));
}
