<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.11
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

class AdminCompanyMenu
{
    public function __construct()
    {
        $this->module = Module::getInstanceByName('gallerique');
        $this->context = Context::getContext();
    }

    public function displayCompanyMenu()
    {
        $menu_items = array();
        $def_pages = $this->getDefinitionConfigurePages();
        foreach ($def_pages['pages'] as $page_key => $page_item) {
            $menu_items[$page_key] = array(
                'name' => $page_item['name'],
                'icon' => isset($page_item['icon']) ? $page_item['icon'] : '',
                'url' => $this->getModuleUrl() . '&' . $def_pages['cparam'] . '=' . $page_key,
                'active' => ((!in_array(Tools::getValue($def_pages['cparam']), array_keys($def_pages['pages'])) && isset($page_item['default']) && $page_item['default'] == true) || Tools::getValue($def_pages['cparam']) == $page_key) ? true : false
            );
        }

        $this->context->smarty->assign(array(
            'menu_items' => $menu_items,
            'module_version' => $this->module->version,
            'module_name' => $this->module->displayName,
            'changelog' => file_exists(_PS_MODULE_DIR_ . $this->module->name . '/Readme.md'),
            '_path' => $this->module->getPathUri()
        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . '/views/templates/admin/menu.tpl');
    }

    private function getDefinitionConfigurePages()
    {
        return array(
            'cparam' => 'view_page',
            'pages' => array(
                'galleries' => array('name' => $this->l('Galleries'), 'icon' => 'icon-file', 'default' => true),
                'settings' => array('name' => $this->l('Settings'), 'icon' => 'icon-cogs'),
            )
        );
    }

    private function getModuleUrl()
    {
        return $this->context->link->getAdminLink(
            'AdminGalleryContent',
            true,
            array(),
            array('configure' => $this->module->name, 'tab_module' => $this->module->tab, 'module_name' => $this->module->name)
        );
    }

    private function l($string, $class = 'AdminTab', $addslashes = false, $htmlentities = true)
    {
        return Translate::getModuleTranslation('gallerique', $string, get_class($this));
    }
}
