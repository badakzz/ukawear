<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.20
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

class GalleriqueGalleryModuleFrontController extends ModuleFrontController
{
    public function setMedia()
    {
        parent::setMedia();

        $this->addJqueryPlugin('fancybox');
        $this->addCSS(_MODULE_DIR_.'gallerique/views/css/gallery.css', 'all');
        $this->addCSS(_MODULE_DIR_.'gallerique/views/css/fontello.css', 'all');
        $this->addJs(_MODULE_DIR_.'gallerique/views/js/gallery.js');
    }

    public function initContent()
    {
        $this->php_self = 'module-gallerique-gallery';
        parent::initContent();

        if (Configuration::get('GALLERIQUE_WITH_ID')) {
            $id_gallery = (int)Tools::getValue('id_gallery');
        } else {
            $id_gallery = $this->module->searchIdByRewrite(Tools::getValue('link_rewrite'), $this->context->language->id);
        }

        require_once(_PS_MODULE_DIR_.'gallerique/classes/GalleryImage.php');
        require_once(_PS_MODULE_DIR_.'gallerique/classes/Gallery.php');

        if (version_compare('1.7.0.0', _PS_VERSION_, '>')) {
            $this->setTemplate('gallery.tpl');
        } else {
            $this->setTemplate('module:gallerique/views/templates/front/t17/gallery.tpl');
        }
        $gallery = new Gallery((int)$id_gallery, $this->context->language->id);

        if (!Validate::isLoadedObject($gallery)) {
            Tools::redirect('index.php');
        }

        if (!$gallery->link_rewrite == Tools::getValue('link_rewrite')) {
            Tools::redirect('index.php');
        }

        if (Shop::isFeatureActive() && !$gallery->isAssociatedToShop($this->context->shop->id)) {
            Tools::redirect('index.php');
        }

        if (!(bool)$gallery->active) {
            $this->errors[] = 'error';
            Tools::redirect('index.php?not_active_page');
        }

        $this->context->smarty->assign(array(
            'gallery_template'  => $this->getTemplatePath('gallery_content.tpl')
                .(version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'gallery_content.tpl' : ''),
            'gallery'           => $gallery,
            'gallery_images'    => $gallery->getImages($this->context->language->id, true),
            'sizes'             => $gallery->getSizes(),
            'sett'              => $gallery->getSett(),
            'g_title'           => true
        ));
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        if (Configuration::get('GALLERIQUE_WITH_ID')) {
            $id_gallery = (int)Tools::getValue('id_gallery');
        } else {
            $id_gallery = $this->module->searchIdByRewrite(Tools::getValue('link_rewrite'), $this->context->language->id);
        }
        require_once(_PS_MODULE_DIR_.'gallerique/classes/Gallery.php');
        $gallery = new Gallery((int)$id_gallery, $this->context->language->id);

        if (Configuration::get('GALLERIQUE_GALLERY_LIST')) {
            $breadcrumb['links'][] = array(
                'title' => $this->module->display_list_name,
                'url' => $this->context->link->getModuleLink('gallerique', 'gallerylist')
            );
        }
     
        $breadcrumb['links'][] = array(
            'title' => $gallery->title,
            'url' => ''
        );
     
        return $breadcrumb;
    }
}
