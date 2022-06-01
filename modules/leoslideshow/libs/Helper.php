<?php
/**
 * 2007-2015 Leotheme
 *
 * NOTICE OF LICENSE
 *
 * Adds image, text or video to your homepage.
 *
 * DISCLAIMER
 *
 *  @author    leotheme <leotheme@gmail.com>
 *  @copyright 2007-2015 Leotheme
 *  @license   http://leotheme.com - prestashop template provider
 */

if (!class_exists('LeoSlideshowHelper')) {

    class LeoSlideshowHelper
    {
        const MODULE_NAME = 'leoslideshow';

        public static function l($string, $specific = false, $name = '')
        {
            if (empty($name)) {
                $name = self::MODULE_NAME;
            }
            return Translate::getModuleTranslation($name, $string, ($specific) ? $specific : $name);
        }

        /**
         * Copy js, css to theme folder
         */
        public static function copyToTheme()
        {
            include_once(_PS_MODULE_DIR_.'leoslideshow/libs/phpcopy.php');

            $theme_dir = _PS_ROOT_DIR_.'/themes/'._THEME_NAME_.'/';
            $module_dir = _PS_MODULE_DIR_.self::MODULE_NAME.'/';

            $theme_js_dir = $theme_dir.'js/modules/leoslideshow/views/js';
            $theme_css_dir = $theme_dir.'css/modules/leoslideshow/views/css';

            // Create js folder
            mkdir($theme_js_dir, 0755, true);
            PhpCopy::safeCopy($module_dir.'views/js/', $theme_js_dir);

            // Create css folder
            mkdir($theme_css_dir, 0755, true);
            PhpCopy::safeCopy($module_dir.'views/css/', $theme_css_dir);

            $url = 'index.php?controller=adminmodules&configure=leoslideshow&token='.Tools::getAdminTokenLite('AdminModules')
                    .'&tab_module=front_office_features&module_name=leoslideshow';
            Tools::redirectAdmin($url);
        }
        
        public static function getImgThemeUrl()
        {
            # LeoSlideshowHelper::getImgThemeUrl()
            static $img_theme_url;
            if (!$img_theme_url) {
                // Not exit image or icon
                $img_theme_url = _THEME_IMG_DIR_.'modules/leoslideshow/';
            }

            return $img_theme_url;
        }
    
        public static function getImgThemeDir()
        {
            static $img_theme_dir;
            if (!$img_theme_dir) {
                $img_theme_dir = _PS_ALL_THEMES_DIR_._THEME_NAME_.'/assets/img/modules/leoslideshow/';
            }
            return $img_theme_dir;
        }
        
        public static function genKey()
        {
            return md5(time().rand());
        }
    }
}
