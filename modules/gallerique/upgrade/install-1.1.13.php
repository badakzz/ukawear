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

function upgrade_module_1_1_13($object)
{
    return ($object->registerHook('displayHeader')
        && $object->registerHook('moduleRoutes')
        && Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'gallery_lang` ADD `link_rewrite` varchar(128) NOT NULL AFTER `title`'));
}
