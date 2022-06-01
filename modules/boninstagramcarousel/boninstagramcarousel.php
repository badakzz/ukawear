<?php
/**
 * 2015-2017 Bonpresta
 *
 * Bonpresta Responsive Carousel Feed Instagram Images
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Boninstagramcarousel extends Module
{
    public function __construct()
    {
        $this->name = 'boninstagramcarousel';
        $this->tab = 'front_office_features';
        $this->version = '1.0.5';
        $this->bootstrap = true;
        $this->author = 'Bonpresta';
        $this->module_key = 'f64b0da8f61d880055728934d4c92909';
        $this->author_address = '0xf66a8C20b52eD708FB78F0D347C9e0Bc7c6b3073';
        parent::__construct();
        $this->displayName = $this->l('Responsive Carousel Feed Instagram Images');
        $this->description = $this->l('Display responsive carousel feed Instagram images');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->controllers = array(
            'instagram'
        );
    }

    protected function getModuleSettings()
    {
        $res = array(
            'BONINSTAGRAMCAROUSEL_DISPLAY' => true,
            'BONINSTAGRAMCAROUSEL_USERID' => '',
            'BONINSTAGRAMCAROUSEL_TYPE' => 'tagged',
            'BONINSTAGRAMCAROUSEL_TAG' => 'clothes',
            'BONINSTAGRAMCAROUSEL_LIMIT' => 16,
            'BONINSTAGRAMCAROUSEL_PAGE_LIMIT' => 16,
            'BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL' => false,
            'BONINSTAGRAMCAROUSEL_NB' => 4,
            'BONINSTAGRAMCAROUSEL_MARGIN' => 30,
            'BONINSTAGRAMCAROUSEL_LOOP' => true,
            'BONINSTAGRAMCAROUSEL_NAV' => true,
            'BONINSTAGRAMCAROUSEL_DOTS' => false,
        );

        return $res;
    }

    public function install()
    {
        $settings = $this->getModuleSettings();

        foreach ($settings as $name => $value) {
            Configuration::updateValue($name, $value);
        }

        return parent::install() &&
        $this->registerHook('displayHeader') &&
        $this->registerHook('displayBackOfficeHeader') &&
        $this->registerHook('moduleRoutes') &&
        $this->registerHook('displayHome');
    }

    public function hookModuleRoutes()
    {
        return array(
            'module-boninstagramcarousel-instagram' => array(
                'controller' => 'instagram',
                'rule'       => 'instagram',
                'keywords'   => array(),
                'params'     => array(
                    'fc'     => 'module',
                    'module' => 'boninstagramcarousel',
                ),
            ),
        );
    }

    public function uninstall()
    {
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            Configuration::deleteByName($name);
        }

        return parent::uninstall();
    }

    public function getContent()
    {
        $output = '';

        if ((bool)Tools::isSubmit('submitSettings')) {
            if (!$errors = $this->checkItemFields()) {
                $this->postProcess();
                $output .= $this->displayConfirmation($this->l('Save all settings.'));
            } else {
                $output .= $errors;
            }
        }

        return $output.$this->renderForm();
    }

    protected function postProcess()
    {
        $form_values = $this->getConfigFieldsValues();
        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    protected function checkItemFields()
    {
        $errors = array();

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAMCAROUSEL_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAMCAROUSEL_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAMCAROUSEL_PAGE_LIMIT'))) {
            $errors[] = $this->l('Limit is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAMCAROUSEL_PAGE_LIMIT'))) {
                $errors[] = $this->l('Bad limit format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAMCAROUSEL_NB'))) {
            $errors[] = $this->l('Item is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAMCAROUSEL_NB'))) {
                $errors[] = $this->l('Bad item format');
            }
        }

        if (Tools::isEmpty(Tools::getValue('BONINSTAGRAMCAROUSEL_MARGIN'))) {
            $errors[] = $this->l('Margin is required.');
        } else {
            if (!Validate::isUnsignedInt(Tools::getValue('BONINSTAGRAMCAROUSEL_MARGIN'))) {
                $errors[] = $this->l('Bad margin format');
            }
        }

        if (count($errors)) {
            return $this->displayError(implode('<br />', $errors));
        }

        return false;
    }

    protected function getConfigInstagram()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings Instagram'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Instagram Feed'),
                        'name' => 'BONINSTAGRAMCAROUSEL_DISPLAY',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'enable',
                                'value' => 1,
                                'label' => $this->l('Yes')),
                            array(
                                'id' => 'disable',
                                'value' => 0,
                                'label' => $this->l('No')),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display item'),
                        'name' => 'BONINSTAGRAMCAROUSEL_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Get Feeds by'),
                        'name' => 'BONINSTAGRAMCAROUSEL_TYPE',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id' => 'tagged',
                                    'name' => $this->l('tagged')),
                                array(
                                    'id' => 'user',
                                    'name' => $this->l('user')),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram Tag'),
                        'name' => 'BONINSTAGRAMCAROUSEL_TAG',
                        'col' => 2,
                        'required' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Instagram User'),
                        'name' => 'BONINSTAGRAMCAROUSEL_USERID',
                        'col' => 2,
                        'required' => false,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Display item on page instagram'),
                        'name' => 'BONINSTAGRAMCAROUSEL_PAGE_LIMIT',
                        'col' => 2,
                        'required' => true,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Carousel:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL',
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'required' => true,
                        'label' => $this->l('Items:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_NB',
                        'col' => 2,
                        'desc' => $this->l('The number of items you want to see on the screen.'),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'text',
                        'label' => $this->l('Margin:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_MARGIN',
                        'col' => 2,
                        'suffix' => 'pixels',
                        'desc' => $this->l('margin-right on item.'),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Loop:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_LOOP',
                        'desc' => $this->l('Infinity loop. Duplicate last and first items to get loop illusion.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Navigation:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_NAV',
                        'desc' => $this->l('Show next/prev buttons.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'form_group_class' => 'display-block',
                        'type' => 'switch',
                        'label' => $this->l('Pagination:'),
                        'name' => 'BONINSTAGRAMCAROUSEL_DOTS',
                        'desc' => $this->l('Show pagination controls.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );
    }

    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitSettings';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).
            '&configure='.$this->name.
            '&tab_module='.$this->tab.
            '&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($this->getConfigInstagram()));
    }


    protected function getConfigFieldsValues()
    {
        $filled_settings = array();
        $settings = $this->getModuleSettings();

        foreach (array_keys($settings) as $name) {
            $filled_settings[$name] = Configuration::get($name);
        }

        return $filled_settings;
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') != $this->name) {
            return;
        }

        $this->context->controller->addJquery();
        $this->context->controller->addJS($this->_path.'views/js/boninstagramcarousel_admin.js');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/owl.carousel.js');
        $this->context->controller->addCSS($this->_path.'views/css/owl.carousel.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/owl.theme.default.css', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/boninstagramcarousel.css', 'all');
        $this->context->controller->addJS($this->_path.'/views/js/boninstagramcarousel.js');

        if (Configuration::get('BONINSTAGRAMCAROUSEL_DISPLAY')) {
            $this->context->smarty->assign('settings', $this->getBlankSettings());
            return $this->display($this->_path, '/views/templates/hook/boninstagramcarousel-header.tpl', $this->getCacheId());
        }
    }


    protected function getStringValueType($data)
    {
        if (Validate::isInt($data)) {
            return 'int';
        } elseif (Validate::isFloat($data)) {
            return 'float';
        } elseif (Validate::isBool($data)) {
            return 'bool';
        } else {
            return 'string';
        }
    }

    protected function getBlankSettings()
    {
        $settings = $this->getModuleSettings();
        $get_settings = array();

        foreach (array_keys($settings) as $name) {
            $data = Configuration::get($name);
            $get_settings[$name] = array('value' => $data, 'type' => $this->getStringValueType($data));
        }

        return $get_settings;
    }

    public function getInstagramContent()
    {
        if (Configuration::get('BONINSTAGRAMCAROUSEL_TYPE') == 'tagged' && Configuration::get('BONINSTAGRAMCAROUSEL_TAG') != '') {
            $insta_params = Tools::jsonDecode(Tools::file_get_contents('https://www.instagram.com/explore/tags/' . Configuration::get('BONINSTAGRAMCAROUSEL_TAG') . '/?__a=1'), true);
            $insta_array = $insta_params['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            $res = array();
            foreach ($insta_array as $name) {
                $res[] = $name["node"];
            }
            return $res;
        } else if (Configuration::get('BONINSTAGRAMCAROUSEL_TYPE') == 'user' && Configuration::get('BONINSTAGRAMCAROUSEL_USERID') != '') {
            $insta_params = Tools::file_get_contents('https://www.instagram.com/' . Configuration::get('BONINSTAGRAMCAROUSEL_USERID') . '/');
            $shards = explode('window._sharedData = ', $insta_params);
            $insta_json = explode(';</script>', $shards[1]);
            $insta_arra = json_decode($insta_json[0], TRUE);
            $insta_array = $insta_arra['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']["edges"];
            $res = array();
            foreach ($insta_array as $name) {
                $res[] = $name["node"];
            }
            return $res;
        }

        return '';
    }

    public function hookDisplayHome()
    {
        if (Configuration::get('BONINSTAGRAMCAROUSEL_DISPLAY')) {
            $this->context->smarty->assign('instagram_type', Configuration::get('BONINSTAGRAMCAROUSEL_TYPE'));
            $this->context->smarty->assign('limit', Configuration::get('BONINSTAGRAMCAROUSEL_LIMIT'));
            $this->context->smarty->assign('instagram_param', $this->getInstagramContent());
            $this->context->smarty->assign(
                array(
                    'display_caroucel' => Configuration::get('BONINSTAGRAMCAROUSEL_DISPLAY_CAROUSEL')
                )
            );

            return $this->display(__FILE__, 'boninstagramcarousel.tpl');
        }
    }
}
