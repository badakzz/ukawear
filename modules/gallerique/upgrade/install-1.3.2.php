<?php
/**
 * Gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2017 silbersaiten
 * @version   1.3.2
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_3_2($object)
{
    return (Configuration::updateValue('GALLERIQUE_SHOW_COVERS', 0)
    	&& Configuration::updateValue('GALLERIQUE_COVERS_PER_ROW', 2)
    	&& Configuration::updateValue('GALLERIQUE_GALLERY_LIST', 1));
}
