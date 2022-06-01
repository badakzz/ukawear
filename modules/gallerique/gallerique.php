<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2019 silbersaiten
 * @version   1.3.25
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

require_once(_PS_MODULE_DIR_ . 'gallerique/classes/Gallery.php');

class Gallerique extends Module
{
    private $_html;
    private static $tbl_cache = array();
    private static $tables = array(
        'gallery_image' => 'CREATE TABLE IF NOT EXISTS `%PREFIX%gallery_image` (
      `id_gallery_image` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `id_gallery` INT(10) UNSIGNED NOT NULL,
      `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
      `date_add` DATETIME NOT NULL,
      `date_upd` DATETIME NOT NULL,
      `position` INT(10) UNSIGNED NOT NULL DEFAULT \'0\',
      PRIMARY KEY (`id_gallery_image`)
    ) ENGINE=%ENGINE%  DEFAULT CHARSET=utf8',

        'gallery_image_lang' => 'CREATE TABLE IF NOT EXISTS `%PREFIX%gallery_image_lang` (
      `id_gallery_image` INT(10) UNSIGNED NOT NULL,
      `id_lang` INT(10) UNSIGNED NOT NULL,
      `label` VARCHAR(128) NOT NULL,
      `image_link` VARCHAR(128) DEFAULT NULL,
      `alt` VARCHAR(255) DEFAULT NULL,
      `description` TEXT,
      PRIMARY KEY (`id_gallery_image`,`id_lang`)
    ) ENGINE=%ENGINE% DEFAULT CHARSET=utf8',

        'gallery' => 'CREATE TABLE IF NOT EXISTS `%PREFIX%gallery` (
      `id_gallery` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'0\',
      `date_add` DATETIME NOT NULL,
      `date_upd` DATETIME NOT NULL,
      PRIMARY KEY (`id_gallery`)
    ) ENGINE=%ENGINE%  DEFAULT CHARSET=utf8',

        'gallery_lang' => 'CREATE TABLE IF NOT EXISTS `%PREFIX%gallery_lang` (
      `id_gallery` INT(10) UNSIGNED NOT NULL,
      `id_lang` INT(10) UNSIGNED NOT NULL,
      `id_shop` INT(10) UNSIGNED NOT NULL,
      `title` VARCHAR(128) NOT NULL,
      `link_rewrite` VARCHAR(128) NOT NULL,
      `description_top` TEXT,
      `description_bottom` TEXT,
      `meta_title` VARCHAR(255),
      `meta_description` TEXT,
      PRIMARY KEY (`id_gallery`,`id_lang`,`id_shop`)
    ) ENGINE=%ENGINE% DEFAULT CHARSET=utf8',

        'gallery_shop' => 'CREATE TABLE IF NOT EXISTS `%PREFIX%gallery_shop` (
    `id_gallery` INT(10) UNSIGNED NOT NULL,
    `id_shop` INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`id_gallery`,`id_shop`),
    KEY `id_shop` (`id_shop`)
    ) ENGINE=%ENGINE% DEFAULT CHARSET=utf8'
    );

    private static $_langauges;
    public $vt = 't17';
    public $display_list_name;

    public function __construct()
    {
        $this->name = 'gallerique';
        $this->version = '1.3.25';
        $this->author = 'Silbersaiten';
        $this->tab = 'front_office_features';
        $this->bootstrap = true;
        $this->module_key = 'bf62c087a40e37bb5b76819a5e55e8a0';
        $this->controllers = array('gallery', 'gallerylist');

        if (version_compare('1.7.0.0', _PS_VERSION_, '>')) {
            $this->vt = 't16';
        }

        parent::__construct();

        $this->displayName = $this->l('Gallerique');
        $this->description = $this->l('Creates galleries that can be viewed via fancybox for Prestashop 1.6.* - 1.7.* v.');

        $this->display_list_name = $this->l('Galleries');

        if (!isset($this->context->smarty->registered_plugins['function']['displayGallery'])) {
            smartyRegisterFunction(
                $this->context->smarty,
                'function',
                'displayGallery',
                array('Gallerique', 'displayGallery')
            );
        }
    }

    public function install($delete_params = true)
    {
        if (parent::install()
            && $this->registerHook('displayBackOfficeHeader')
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayAdminAdCmsMenu')
            && $this->registerHook('displayAdminAdCmsBlockContents')
            && $this->registerHook('actionBlockDataPrefilter')
            && $this->registerHook('moduleRoutes')) {
            if ($delete_params) {
                if (!self::createDbTables()) {
                    $this->uninstall();
                    return false;
                }
            }
            Configuration::updateValue('GALLERIQUE_WITH_ID', 1);
            $this->installTab('AdminGalleryContent', 'Gallery');

            return true;
        }

        return false;
    }

    public function uninstall($delete_params = true)
    {
        parent::uninstall();

        if ($delete_params) {
            self::deleteOptions();
            self::deleteDbTables();
            $this->clearImages(dirname(__FILE__) . '/img/');
        }

        $this->uninstallTab('AdminGalleryContent');

        Configuration::deleteByName('GALLERIQUE_S_HEIGHT');
        Configuration::deleteByName('GALLERIQUE_S_WIDTH');
        Configuration::deleteByName('GALLERIQUE_T_HEIGHT');
        Configuration::deleteByName('GALLERIQUE_T_WIDTH');
        Configuration::deleteByName('GALLERIQUE_T_RESIZE_METHOD');
        Configuration::deleteByName('GALLERIQUE_S_RESIZE_METHOD');
        Configuration::deleteByName('GALLERIQUE_SORTING');
        Configuration::deleteByName('GALLERIQUE_WITH_ID');
        Configuration::deleteByName('GALLERIQUE_LINK_WITHOUT_POSTFIX');
        Configuration::deleteByName('GALLERIQUE_GALLERIES_LINK_NAME');
        Configuration::deleteByName('GALLERIQUE_GALLERY_LINK_NAME');

        return true;
    }

    public function reset()
    {
        if (!$this->uninstall(false)) {
            return false;
        }
        if (!$this->install(false)) {
            return false;
        }

        return true;
    }

    public function searchIdByRewrite($rewrite, $lang_id)
    {
        return Db::getInstance()->getValue(
            'SELECT `id_gallery`
            FROM `' . _DB_PREFIX_ . 'gallery_lang`
            WHERE `link_rewrite` = \'' . pSQL($rewrite) . '\' AND `id_lang` = ' . (int)$lang_id
        );
    }

    public function hookModuleRoutes($params)
    {
        unset($params);
        $id_lang = $this->context->language->id;
        $gallery_link = Configuration::get('GALLERIQUE_GALLERY_LINK_NAME', $id_lang);
        $result = array(
            'module-gallerique-gallery' => array(
                'controller' => 'gallery',
                'rule' => ($gallery_link ? $gallery_link : 'gallery')
                    . (Configuration::get('GALLERIQUE_WITH_ID') ? '/{id_gallery}' : '')
                    . '/{link_rewrite}'
                    . ((int)Configuration::get('GALLERIQUE_LINK_WITHOUT_POSTFIX') ? '' : '.html'),
                'keywords' => array(
                    'id_gallery' => array('regexp' => '[0-9]+', 'param' => 'id_gallery'),
                    'link_rewrite' => array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'link_rewrite'),
                    'module' => array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'module'),
                    'controller' => array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'controller'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'gallerique',
                    'controller' => 'gallery',
                )
            )
        );

        if (Configuration::get('GALLERIQUE_GALLERY_LIST')) {
            $galleries_link_name = Configuration::get('GALLERIQUE_GALLERIES_LINK_NAME', $id_lang);
            $result['module-gallerique-gallerylist'] = array(
                'controller' => 'gallerylist',
                'rule' => ($galleries_link_name ? $galleries_link_name : 'galleries') .
                    ((int)Configuration::get('GALLERIQUE_LINK_WITHOUT_POSTFIX') ? '' : '.html'),
                'keywords' => array(
                    'module' => array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'module'),
                    'controller' => array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'controller'),
                ),
                'params' => array(
                    'fc' => 'module',
                    'module' => 'gallerique',
                    'controller' => 'gallerylist',
                )
            );
        }

        return $result;
    }

    private function clearImages($dir)
    {
        if (!$dh = @opendir($dir)) {
            return false;
        }

        while (false !== ($obj = readdir($dh))) {
            if (in_array($obj, array('.', '..'))) {
                continue;
            }

            if (!is_dir($dir . '/' . $obj)) {
                @unlink($dir . '/' . $obj);
            } else {
                $this->clearImages($dir . '/' . $obj);
            }
        }

        closedir($dh);
    }

    public static function getLanguages()
    {
        if (!is_array(self::$_langauges)) {
            self::$_langauges = Language::getLanguages();
        }

        return self::$_langauges;
    }

    public function installTab($tab_class, $tab_name, $parent = 'AdminParentPreferences')
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = $tab_class;
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tab_name;
        }
        $tab->id_parent = (int)Tab::getIdFromClassName($parent);
        $tab->module = $this->name;
        return $tab->add();
    }

    public function uninstallTab($tab_class)
    {
        $id_tab = (int)Tab::getIdFromClassName($tab_class);
        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        }
        return false;
    }

    public function getMultilangField($string)
    {
        $languages = self::getLanguages();
        $prepared = array();

        foreach ($languages as $language) {
            $prepared[$language['id_lang']] = $string;
        }

        return $prepared;
    }

    private static function tableExists($table, $use_cache = true)
    {
        if (!count(self::$tbl_cache) || !$use_cache) {
            $tmp = Db::getInstance()->ExecuteS('SHOW TABLES');

            foreach ($tmp as $entry) {
                reset($entry);

                $table_tmp = Tools::strtolower($entry[key($entry)]);

                if (!array_search($table_tmp, self::$tbl_cache)) {
                    self::$tbl_cache[] = $table_tmp;
                }
            }
        }

        return array_search(Tools::strtolower($table), self::$tbl_cache) ? true : false;
    }

    private static function createDbTables()
    {
        if (count(self::$tables)) {
            foreach (self::$tables as $query) {
                $query = strtr($query, array('%PREFIX%' => _DB_PREFIX_, '%ENGINE%' => _MYSQL_ENGINE_));

                if (!Db::getInstance()->Execute($query)) {
                    self::uninstall();

                    return false;
                }
            }
        }

        return true;
    }

    private static function deleteDbTables()
    {
        if (count(self::$tables)) {
            foreach (array_keys(self::$tables) as $tbl_name) {
                if (self::tableExists(_DB_PREFIX_ . $tbl_name)) {
                    Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . $tbl_name . '`');
                }
            }
        }

        return true;
    }

    private static function deleteOptions()
    {
        $result = Db::getInstance()->ExecuteS(
            'SELECT
            g.`id_gallery`
            FROM
            `' . _DB_PREFIX_ . 'gallery` g
            WHERE 1'
        );

        if ($result && count($result)) {
            foreach ($result as $gallery) {
                Configuration::deleteByName('GALLERIQUE_S_HEIGHT_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_S_WIDTH_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_T_HEIGHT_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_T_WIDTH_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_T_RESIZE_METHOD_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_S_RESIZE_METHOD_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_SORTING_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_SHOW_IMAGE_LABELS_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_SHOW_IMAGE_DESC_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_MAX_IMAGE_LABELS_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_MAX_IMAGE_DESC_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_SB_ON_IMAGE_' . $gallery['id_gallery']);
                Configuration::deleteByName('GALLERIQUE_IMG_CACHE_' . $gallery['id_gallery']);
            }
        }

        return true;
    }

    public function getContent()
    {
        Tools::redirectAdmin('index.php?controller=AdminGalleryContent&token=' . Tools::getAdminTokenLite('AdminGalleryContent', $this->context));
    }

    /**
     * TODO: Without checking the load of the module because it is necessary for built-in context method displayGallery()
     */

    public function hookDisplayHeader($params)
    {

        $this->context->smarty->registerFilter('output', array($this, 'parseGalleriqueTags'));
        $this->context->controller->addJqueryPlugin('fancybox');
        $this->setMetaData();

        if ($this->vt == 't16') {
            $this->context->controller->addCSS(_MODULE_DIR_ . $this->name . '/views/css/gallery.css', 'all');
            $this->context->controller->addJs(_MODULE_DIR_ . $this->name . '/views/js/lazy.js');
            $this->context->controller->addJs(_MODULE_DIR_ . $this->name . '/views/js/gallery.js');


        } else {
            $this->context->controller->registerJavascript(
                'modules-gallerique-lazy',
                'modules/' . $this->name . '/views/js/lazy.js',
                array('position' => 'bottom', 'priority' => 150)
            );
            $this->context->controller->registerJavascript(
                'modules-gallerique',
                'modules/' . $this->name . '/views/js/gallery.js',
                array('position' => 'bottom', 'priority' => 150)
            );
            $this->context->controller->registerStylesheet(
                'modules-gallerique-front',
                'modules/' . $this->name . '/views/css/gallery.css',
                array('media' => 'all', 'priority' => 150)
            );
        }
        return $this->display(__FILE__, 'meta_content.tpl');
    }

    private function setMetaData()
    {
        if (Tools::getValue('module') === $this->name) {
            $gallery = $this->getGalleryData();

            //these variable override default PS variable for header.tpl
            if ($this->vt === 't16') {
                $gallery->meta_title
                    ? $this->context->smarty->assign('meta_title', html_entity_decode($gallery->meta_title))
                    : false;
                $gallery->meta_description
                    ? $this->context->smarty->assign('meta_description', html_entity_decode($gallery->meta_description))
                    : false;
            } elseif ($this->vt === 't17') {
                $gallery->meta_title
                    ? $this->context->smarty->tpl_vars['page']->value['meta']['title'] = html_entity_decode($gallery->meta_title)
                    : false;
                $gallery->meta_description
                    ? $this->context->smarty->tpl_vars['page']->value['meta']['description'] = html_entity_decode($gallery->meta_description)
                    : false;
            }
        }


    }

    private function getGalleryData()
    {
        if (Configuration::get('GALLERIQUE_WITH_ID')) {
            $id_gallery = (int)Tools::getValue('id_gallery');
        } else {
            $id_gallery = $this->searchIdByRewrite(Tools::getValue('link_rewrite'), $this->context->language->id);
        }

        $context = Context::getContext();
        return new Gallery((int)$id_gallery, $context->language->id);
    }

    public function parseGalleriqueTags($tpl_output, Smarty_Internal_Template $template)
    {
        preg_match_all('/\<p\>\[\s?displayGallery\sid\s?=\s?([0-9]*)\s?\]\<\/p\>/', $tpl_output, $m, PREG_SET_ORDER);

        if (count($m)) {
            foreach ($m as $gallery_call) {
                $id_gallery = (int)$gallery_call[1];

                $gallery_tpl = self::displayGallery(array('id' => $id_gallery));
                $tpl_output = str_replace($gallery_call[0], $gallery_tpl, $tpl_output);
            }
        }

        return $tpl_output;
    }

    public static function displayGallery($params)
    {
        require_once(_PS_MODULE_DIR_ . 'gallerique/classes/GalleryImage.php');

        $context = Context::getContext();
        $gallery = new Gallery((int)$params['id'], $context->language->id);

        if (Validate::isLoadedObject($gallery) && $gallery->isAssociatedToShop($context->shop->id)) {
            $context->smarty->assign(array(
                'gallery' => $gallery,
                'gallery_images' => $gallery->getImages($context->language->id, true),
                'sizes' => $gallery->getSizes(),
                'sett' => $gallery->getSett(),
                'g_title' => false
            ));

            return $context->smarty->fetch(
                dirname(__FILE__) . '/views/templates/front/' . (version_compare('1.7.0.0', _PS_VERSION_, '>')
                    ? ''
                    : 't17/') . 'gallery_content.tpl'
            );
        }

        return false;
    }

    public function hookDisplayAdminAdCmsMenu($params)
    {
        unset($params);
        return $this->display(__FILE__, 'adcms_menu.tpl');
    }

    public function hookDisplayAdminAdCmsBlockContents($params)
    {
        if ($params['type'] == 'gallery') {

            $gallery_list = Gallery::getGalleries($this->context->language->id, true);
            $this->context->smarty->assign(array(
                'gallery_list' => $gallery_list
            ));

            return $this->display(__FILE__, 'adcms_block.tpl');
        }
    }

    public function hookActionBlockDataPrefilter($params)
    {
        if ($params['type'] == 'gallery') {
            $gallery_id = $params['contents'];

            if (Validate::isUnsignedId($gallery_id)
                && $gallery_content = self::displayGallery(array('id' => $gallery_id))) {
                $params['contents'] = $gallery_content;
            } else {
                $params['contents'] = null;
            }
        }
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $this->context->controller->addJquery();
        $this->context->controller->addJqueryUI('ui.widget');
        $this->context->controller->addCSS($this->_path . '/views/css/admin_gallery.css', 'all');
        if ($this->context->controller instanceof AdminAdvancedCMSSettingsController) {
            $this->context->controller->addJS($this->_path . 'views/js/adcms.js');
        }

        if ($this->context->controller instanceof AdminGalleryContentController) {
            $this->context->controller->addJS($this->_path . 'views/js/jquery.fileupload.js');
        }
    }

    public function deleteOldFiles()
    {
        $files = array(
            'AdminGallery.php',
            'AdminGalleryContent.php',
            'AdminGalleryImages.php',
        );

        foreach ($files as $file) {
            if (file_exists(_PS_MODULE_DIR_ . $this->name . '/' . $file)) {
                unlink(_PS_MODULE_DIR_ . $this->name . '/' . $file);
            }
        }
    }
}
