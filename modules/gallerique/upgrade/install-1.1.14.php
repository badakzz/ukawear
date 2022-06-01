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

function upgrade_module_1_1_14($object)
{
    return ($object->registerHook('displayBackOfficeHeader')
        && $object->registerHook('displayAdminAdCmsMenu')
        && $object->registerHook('displayAdminAdCmsBlockContents')
        && $object->registerHook('actionBlockDataPrefilter'));
}
