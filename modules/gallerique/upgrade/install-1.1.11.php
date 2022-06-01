<?php
/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2016 silbersaiten
 * @version   1.2.3
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_1_11($object)
{
    unset($object);
    return Db::getInstance()->execute(
        'ALTER TABLE `'._DB_PREFIX_.'gallery_lang` ADD `id_shop` int(10) unsigned NOT NULL AFTER `id_lang`,
        ADD PRIMARY KEY `PRIMARY_NEW` (`id_gallery`, `id_lang`, `id_shop`),
        DROP INDEX `PRIMARY`'
    );
}
