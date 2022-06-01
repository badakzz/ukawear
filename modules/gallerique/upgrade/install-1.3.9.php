<?php
/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.9
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_9($object)
{
    return (Db::getInstance()->execute(
        'ALTER TABLE `'._DB_PREFIX_.'gallery_lang` ADD `meta_title` varchar(255);
             ALTER TABLE `'._DB_PREFIX_.'gallery_lang` ADD `meta_description` text;'
    ));
}
