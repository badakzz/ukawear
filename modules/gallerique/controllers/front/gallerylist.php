<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2015 silbersaiten
 * @version   1.1.12
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

class GalleriqueGalleryListModuleFrontController extends ModuleFrontController
{
    /**
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function initContent()
    {
        $this->php_self = 'module-gallerique-gallerylist';
        parent::initContent();

        if (!Configuration::get('GALLERIQUE_GALLERY_LIST')) {
            Tools::redirect('index.php');
        }

        require_once(_PS_MODULE_DIR_.'gallerique/classes/GalleryImage.php');
        require_once(_PS_MODULE_DIR_.'gallerique/classes/Gallery.php');

        $per_page = (int)Configuration::get('GALLERIQUE_COVERS_PER_PAGE');
        $current_page = Tools::getValue('page') ? (int)Tools::getValue('page') : 1;
        $count_elements = count(Gallery::getGalleries($this->context->language->id, true, $this->context->shop->id));
        $count_pages = $count_elements / $per_page;

        $galleries = Gallery::getGalleries(
            $this->context->language->id,
            true,
            $this->context->shop->id,
            $per_page,
            ($current_page - 1) * $per_page // Because LIMIT start since 0, and showed the number page since 1
        );

        if (!$galleries || !count($galleries)) {
            $galleries = false;
        }

        switch (Configuration::get('GALLERIQUE_COVERS_PER_ROW')) {
            case 6:
                $inrow = 2;
                break;
            case 4:
                $inrow = 3;
                break;
            case 3:
                $inrow = 4;
                break;
            case 1:
                $inrow = 12;
                break;
            case 2:
            default:
                $inrow = 6;
                break;
        }

        if($current_page > 1){
            $previous_link = $this->context->link->getModuleLink('gallerique', 'gallerylist', array('page' => $current_page - 1));
        } else {
            $previous_link = false;
        }

        if($count_pages > $current_page){
            $next_link = $this->context->link->getModuleLink('gallerique', 'gallerylist', array('page' => $current_page + 1));
        } else {
            $next_link = false;
        }
        
        $all_links = array();
        $num_link = 0;
        while ((int)ceil($count_pages) !== $num_link){
            $num_link++;
            $all_links[] = array(
                'link' => $this->context->link->getModuleLink('gallerique', 'gallerylist', array('page' => $num_link)),
                'current' => $num_link === $current_page
            );
        }

        $this->context->smarty->assign(array(
            'galleries' => $galleries,
            'covers' => Configuration::get('GALLERIQUE_SHOW_COVERS'),
            'perrow' => Configuration::get('GALLERIQUE_COVERS_PER_ROW'),
            'inrow' => (int)$inrow,

            'previous_link' => $previous_link,
            'next_link' => $next_link,
            'all_links' => $all_links,

            'pagination' => array(
                'total_items' => $count_elements,
                'items_shown_from' => $per_page * ($current_page - 1) + 1,
                'items_shown_to' => $per_page * $current_page
            )
        ));

        if (version_compare('1.7.0.0', _PS_VERSION_, '>')) {
            $this->setTemplate('gallery_list.tpl');
        } else {
            $this->setTemplate('module:gallerique/views/templates/front/t17/gallery_list.tpl');
        }
    }

    public function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();
     
        $breadcrumb['links'][] = array(
            'title' => $this->module->display_list_name,
            'url' => $this->context->link->getModuleLink('gallerique', 'gallerylist')
        );
     
        return $breadcrumb;
    }
}
