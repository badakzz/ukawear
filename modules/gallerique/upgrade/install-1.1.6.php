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

function upgrade_module_1_1_6($object)
{
    unset($object);
    return (Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'gallery_shop` (
        `id_gallery`       int(10)         unsigned NOT NULL,
        `id_shop`          int(10)         unsigned NOT NULL,
        PRIMARY KEY (`id_gallery`,`id_shop`),
        KEY `id_shop` (`id_shop`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'));
}
