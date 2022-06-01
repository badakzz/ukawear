<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.23
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

require_once(dirname(__FILE__) . '/AdminGalleryController.php');
require_once(dirname(__FILE__) . '/AdminGalleryImagesController.php');
require_once(dirname(__FILE__) . '/../../classes/Gallery.php');
require_once(dirname(__FILE__) . '/../../classes/GalleryImage.php');

class AdminGalleryContentController extends AdminController
{
    protected $admin_galleries;
    protected $admin_gallery_image;
    protected static $gallery = null;

    protected $position_identifier = 'id_gallery_image';

    public function __construct()
    {
        self::setCurrentGallery();

        $this->table = 'gallery_image_content';
        $this->className = 'GalleryImage';
        $this->bootstrap = true;
        $this->bulk_actions = array(
            'delete' => array('text' => $this->l('Delete selected'), 'icon' => 'icon-trash', 'confirm' => $this->l('Delete selected items?'))
        );
        $this->context = Context::getContext();
        $this->admin_galleries = new AdminGalleryController();
        $this->admin_gallery_image = new AdminGalleryImagesController();

        if (!Configuration::get('GALLERIQUE_FOLDER_PERM_' . Tools::strtoupper(GalleryImage::ORIGINAL))) {
            $this->permission(GalleryImage::ORIGINAL);
        }
        if (!Configuration::get('GALLERIQUE_FOLDER_PERM_' . Tools::strtoupper(GalleryImage::SCALED))) {
            $this->permission(GalleryImage::SCALED);
        }
        if (!Configuration::get('GALLERIQUE_FOLDER_PERM_' . Tools::strtoupper(GalleryImage::THUMBNAIL))) {
            $this->permission(GalleryImage::THUMBNAIL);
        }

        if (Tools::getIsset('ajaxupl')) {
            echo $this->admin_gallery_image->uploadAjaxFile((int)Tools::getValue('id_gallery'));
            die();
        }

        parent::__construct();
    }


    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Gallery options'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'label' => $this->l('Big picture width'),
                        'name' => 'GALLERIQUE_S_WIDTH',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'suffix' => 'pixels'
                    ),
                    array(
                        'label' => $this->l('Big picture height'),
                        'name' => 'GALLERIQUE_S_HEIGHT',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'suffix' => 'pixels'
                    ),
                    array(
                        'label' => $this->l('Thumbnail picture width'),
                        'name' => 'GALLERIQUE_T_WIDTH',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'suffix' => 'pixels'
                    ),
                    array(
                        'label' => $this->l('Thumbnail picture height'),
                        'name' => 'GALLERIQUE_T_HEIGHT',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                        'suffix' => 'pixels'
                    ),
                    array(
                        'label' => $this->l('Thumbnail resize type'),
                        'name' => 'GALLERIQUE_T_RESIZE_METHOD',
                        'validation' => 'isString',
                        'type' => 'select',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'auto',
                                    'name' => $this->l('Automatic')
                                ),
                                array(
                                    'id_option' => 'exact',
                                    'name' => $this->l('Exact')
                                ),
                                array(
                                    'id_option' => 'crop',
                                    'name' => $this->l('Crop')
                                ),
                                array(
                                    'id_option' => 'portrait',
                                    'name' => $this->l('Fixed Height')
                                ),
                                array(
                                    'id_option' => 'landscape',
                                    'name' => $this->l('Fixed Width')
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'label' => $this->l('Big picture resize type'),
                        'name' => 'GALLERIQUE_S_RESIZE_METHOD',
                        'validation' => 'isString',
                        'type' => 'select',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'auto',
                                    'name' => $this->l('Automatic')
                                ),
                                array(
                                    'id_option' => 'exact',
                                    'name' => $this->l('Exact')
                                ),
                                array(
                                    'id_option' => 'crop',
                                    'name' => $this->l('Crop')
                                ),
                                array(
                                    'id_option' => 'portrait',
                                    'name' => $this->l('Fixed Height')
                                ),
                                array(
                                    'id_option' => 'landscape',
                                    'name' => $this->l('Fixed Width')
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'label' => $this->l('Sorting images'),
                        'name' => 'GALLERIQUE_SORTING',
                        'validation' => 'isInt',
                        'type' => 'select',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->l('Sort by ID')
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->l('Sort by ID (desc)')
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->l('Sort by date of addition')
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => $this->l('Sort by date of addition (desc)')
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => $this->l('Sort by editing date')
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => $this->l('Sort by editing date (desc)')
                                ),
                                array(
                                    'id_option' => 7,
                                    'name' => $this->l('Sort by position')
                                ),
                                array(
                                    'id_option' => 8,
                                    'name' => $this->l('Sort by position (desc)')
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'radio' : 'switch',
                        'label' => $this->l('Show image label'),
                        'name' => 'GALLERIQUE_SHOW_IMAGE_LABELS',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
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
                        'label' => $this->l('Max symbols in image label'),
                        'name' => 'GALLERIQUE_MAX_IMAGE_LABELS',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                    ),
                    array(
                        'type' => version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'radio' : 'switch',
                        'label' => $this->l('Show image description'),
                        'name' => 'GALLERIQUE_SHOW_IMAGE_DESC',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
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
                        'type' => version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'radio' : 'switch',
                        'label' => $this->l('Show buttons on image'),
                        'name' => 'GALLERIQUE_SB_ON_IMAGE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
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
                        'label' => $this->l('Max symbols in image description'),
                        'name' => 'GALLERIQUE_MAX_IMAGE_DESC',
                        'validation' => 'isInt',
                        'cast' => 'intval',
                        'type' => 'text',
                    ),
                    array(
                        'type' => version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'radio' : 'switch',
                        'label' => $this->l('Add timestamp to load new images'),
                        'name' => 'GALLERIQUE_IMG_CACHE',
                        'required' => false,
                        'class' => 't',
                        'is_bool' => true,
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
                        'desc' => $this->l('While you configure your gallery, we recommended to activate this to quickly see all changes. After the gallery is complete it is recommended to deactivate this function to enable cache and a faster loading')
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            )
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')
            : 0;
        $this->fields_form = array();

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitGallery';
        $helper->currentIndex = AdminController::$currentIndex . '&id_gallery=' .
            Tools::getValue('id_gallery') . '&updategallery';
        $helper->token = Tools::getAdminTokenLite('AdminGalleryContent');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues((int)Tools::getValue('id_gallery')),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    /**
     * @deprecated
     * Move to the main module file.
     * Because when PS1.7 and php7 this function needs parameter $newTheme = false
     */
//    public function setMedia()
//    {
//        parent::setMedia();
//        $this->addJS(_MODULE_DIR_ . '/gallerique/views/js/jquery.fileupload.js');
//    }

    protected function l($string, $class = 'AdminTab', $addslashes = false, $htmlentities = true)
    {
        return Translate::getModuleTranslation('gallerique', $string, get_class($this));
    }

    public function getURLGallery($value, $gallery)
    {
        $obj = new Gallery((int)$value, $this->context->language->id);
        $link = $this->context->link->getModuleLink(
            'gallerique',
            'gallery',
            array('id_gallery' => $obj->id, 'link_rewrite' => $obj->link_rewrite)
        );
        return '<a href="' . $link . '" target="_blank">' . $link . '</a>';
    }

    protected function processUpdateOptions()
    {
        parent::processUpdateOptions();

        if (!count($this->errors) && Validate::isLoadedObject(self::$gallery)) {
            self::regenerateImages(self::$gallery->id);
        }
    }

    public function getConfigFieldsValues($id_gallery)
    {
        return array(
            'GALLERIQUE_S_WIDTH' => Tools::getValue(
                'GALLERIQUE_S_WIDTH',
                Configuration::get('GALLERIQUE_S_WIDTH_' . $id_gallery)
            ),
            'GALLERIQUE_S_HEIGHT' => Tools::getValue(
                'GALLERIQUE_S_HEIGHT',
                Configuration::get('GALLERIQUE_S_HEIGHT_' . $id_gallery)
            ),
            'GALLERIQUE_T_WIDTH' => Tools::getValue(
                'GALLERIQUE_T_WIDTH',
                Configuration::get('GALLERIQUE_T_WIDTH_' . $id_gallery)
            ),
            'GALLERIQUE_T_HEIGHT' => Tools::getValue(
                'GALLERIQUE_T_HEIGHT',
                Configuration::get('GALLERIQUE_T_HEIGHT_' . $id_gallery)
            ),
            'GALLERIQUE_T_RESIZE_METHOD' => Tools::getValue(
                'GALLERIQUE_T_RESIZE_METHOD',
                Configuration::get('GALLERIQUE_T_RESIZE_METHOD_' . $id_gallery)
            ),
            'GALLERIQUE_S_RESIZE_METHOD' => Tools::getValue(
                'GALLERIQUE_S_RESIZE_METHOD',
                Configuration::get('GALLERIQUE_S_RESIZE_METHOD_' . $id_gallery)
            ),
            'GALLERIQUE_SORTING' => Tools::getValue(
                'GALLERIQUE_SORTING',
                Configuration::get('GALLERIQUE_SORTING_' . $id_gallery)
            ),
            'GALLERIQUE_SHOW_IMAGE_LABELS' => Tools::getValue(
                'GALLERIQUE_SHOW_IMAGE_LABELS',
                Configuration::get('GALLERIQUE_SHOW_IMAGE_LABELS_' . $id_gallery)
            ),
            'GALLERIQUE_SHOW_IMAGE_DESC' => Tools::getValue(
                'GALLERIQUE_SHOW_IMAGE_DESC',
                Configuration::get('GALLERIQUE_SHOW_IMAGE_DESC_' . $id_gallery)
            ),
            'GALLERIQUE_MAX_IMAGE_LABELS' => Tools::getValue(
                'GALLERIQUE_MAX_IMAGE_LABELS',
                Configuration::get('GALLERIQUE_MAX_IMAGE_LABELS_' . $id_gallery)
            ),
            'GALLERIQUE_MAX_IMAGE_DESC' => Tools::getValue(
                'GALLERIQUE_MAX_IMAGE_DESC',
                Configuration::get('GALLERIQUE_MAX_IMAGE_DESC_' . $id_gallery)
            ),
            'GALLERIQUE_SB_ON_IMAGE' => Tools::getValue(
                'GALLERIQUE_SB_ON_IMAGE',
                Configuration::get('GALLERIQUE_SB_ON_IMAGE_' . $id_gallery)
            ),
            'GALLERIQUE_IMG_CACHE' => Tools::getValue(
                'GALLERIQUE_IMG_CACHE',
                Configuration::get('GALLERIQUE_IMG_CACHE_' . $id_gallery)
            ),
        );
    }

    public static function regenerateImages($id_gallery)
    {
        require_once(dirname(__FILE__) . '/../../classes/ImageResizeGall.php');

        $images = GalleryImage::getExistingOriginalImagesData($id_gallery);

        if ($images && count($images)) {
            foreach ($images as $image) {
                GalleryImage::generateScaledImages($image['id_gallery_image'], $image['path']);
            }
        }
    }

    public static function getCurrentGallery()
    {
        return self::$gallery;
    }

    public static function setCurrentGallery($id_gallery = false)
    {
        $id_gallery = $id_gallery ? $id_gallery : (int)Tools::getValue('id_gallery');

        self::$gallery = new Gallery((int)$id_gallery);
    }

    public function viewAccess($disable = false)
    {
        $result = parent::viewAccess($disable);
        $this->admin_galleries->tabAccess = $this->tabAccess;
        $this->admin_gallery_image->tabAccess = $this->tabAccess;

        return $result;
    }

    public function getGalleryPreviewImage($id_gallery_image, $tr)
    {
        $paths = GalleryImage::getGalleryPaths();
        $image = false;
        $not_cached_prefix = '?' . time();

        if (file_exists($paths[GalleryImage::THUMBNAIL]['abs'] . $id_gallery_image . '.jpg')) {
            $image = $paths[GalleryImage::THUMBNAIL]['rel'] . $id_gallery_image . '.jpg' . $not_cached_prefix;
        }

        return $image ? '<img src="' . $image . '" width="70px" />' : '';
    }

    public function getGalleryLink($gallery_name, $tr)
    {
        return '<a href="' . $this->context->link->getModuleLink(
                'gallerique',
                'gallery',
                array('id_gallery' => $tr['id_gallery'])
            ) . '">' . $tr['title'] . '</a>';
    }

    public function displayPreviewLink($token, $id)
    {
        unset($token);
        if (!array_key_exists('preview', self::$cache_lang)) {
            self::$cache_lang['preview'] = $this->l('Preview');
        }

        $gallery = new Gallery((int)$id, $this->context->language->id);

        $this->context->smarty->assign(array(
            'href' => $this->context->link->getModuleLink(
                'gallerique',
                'gallery',
                array('id_gallery' => $gallery->id, 'link_rewrite' => $gallery->link_rewrite)
            ),
            'action' => self::$cache_lang['preview'],
        ));

        return $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'gallerique/views/templates/admin/list_action_preview.tpl'
        );
    }

    public function initContent()
    {
        $this->admin_galleries->token = $this->token;
        $this->admin_gallery_image->token = $this->token;

        if ($this->display == 'add_gallery') {
            $this->content .= $this->admin_galleries->renderForm();
        } elseif ($this->display == 'edit_gallery') {
            $this->content .= $this->admin_galleries->renderForm();
            $this->content .= $this->renderForm();
        } elseif ($this->display == 'edit_gallery_image') {
            $this->content .= $this->admin_gallery_image->renderForm();
        } else {
            $id_gallery = (int)Tools::getValue('id_gallery');

            $tabs = array('gallery', 'gallery_image');
            $cat_bar_index = self::$currentIndex;
            foreach ($tabs as $tab) {
                if (Tools::getValue($tab . 'Orderby') && Tools::getValue($tab . 'Orderway')) {
                    $cat_bar_index = preg_replace(
                        '/&' . $tab . 'Orderby=([a-z _]*)&' . $tab . 'Orderway=([a-z]*)/i',
                        '',
                        self::$currentIndex
                    );
                }
            }

            if (!Tools::getIsset('viewgallery')) {
                // show list of galleries
                $this->content .= $this->admin_galleries->renderList();
            } else {
                //show gallery
                $this->admin_gallery_image->id_gallery = $id_gallery;

                if ($id_gallery) {
                    $this->content .= $this->admin_gallery_image->renderList();
                }

                // $this->context->smarty->assign(array(
                //     'gallery_breadcrumb' => getPath($cat_bar_index, $id_gallery, '', '', 'gallery'),
                // ));
            }

        }
        parent::initContent();
        $this->content .= '<div class="col-xs-12 col-sm-12 col-lg-12"><div class="panel">
        <iframe src="http://silbersaiten.de/page/getmoreinfo16.html" frameborder="0" width="100%" height="190">
        </iframe></div></div>';

        $this->context->smarty->assign(array(
            'show_page_header_toolbar' => true,
            'content' => $this->content
        ));
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitGallerySettings')) {
            Configuration::updateValue('GALLERIQUE_WITH_ID', Tools::getValue('GALLERIQUE_WITH_ID'));
            Configuration::updateValue('GALLERIQUE_SHOW_COVERS', Tools::getValue('GALLERIQUE_SHOW_COVERS'));
            Configuration::updateValue('GALLERIQUE_COVERS_PER_ROW', Tools::getValue('GALLERIQUE_COVERS_PER_ROW'));
            Configuration::updateValue('GALLERIQUE_COVERS_PER_PAGE', Tools::getValue('GALLERIQUE_COVERS_PER_PAGE'));
            Configuration::updateValue('GALLERIQUE_GALLERY_LIST', Tools::getValue('GALLERIQUE_GALLERY_LIST'));
            Configuration::updateValue('GALLERIQUE_LINK_WITHOUT_POSTFIX', Tools::getValue('GALLERIQUE_LINK_WITHOUT_POSTFIX'));

            $languages = Language::getLanguages();
            $values = array();
            foreach ($languages as $lang) {
                $galleries_link_name = Tools::getValue('GALLERIQUE_GALLERIES_LINK_NAME_' . $lang['id_lang']);
                $gallery_link_name = Tools::getValue('GALLERIQUE_GALLERY_LINK_NAME_' . $lang['id_lang']);

                if (Validate::isString($galleries_link_name) && $galleries_link_name) {
                    $values['galleries'][$lang['id_lang']] = $galleries_link_name;
                } else {
                    $this->errors[] = $this->l('Invalid value in the field "Galleries list link name"');
                }

                if (Validate::isString($gallery_link_name) && $gallery_link_name) {
                    $values['gallery'][$lang['id_lang']] = $gallery_link_name;
                } else {
                    $this->errors[] = $this->l('Invalid value in the field "Gallery link name"');
                }
            }

            Configuration::updateValue('GALLERIQUE_GALLERIES_LINK_NAME', $values['galleries']);
            Configuration::updateValue('GALLERIQUE_GALLERY_LINK_NAME', $values['gallery']);

            Tools::redirectAdmin(
                self::$currentIndex . '&conf=4&token=' . $this->token
            );
        }

        if (Tools::isSubmit('submitDelgallery_image')
            || Tools::isSubmit('previewSubmitAddgallery_imageAndPreview')
            || Tools::isSubmit('submitAddgallery_image')
            || Tools::isSubmit('submitBulkenableSelectiongallery_image')
            || Tools::isSubmit('submitBulkdisableSelectiongallery_image')
            || Tools::isSubmit('submitBulkdeletegallery_image')
            || Tools::isSubmit('deletegallery_image')
            || Tools::isSubmit('viewgallery_image')
            || Tools::isSubmit('submitFilterButtongallery_image')
            || (Tools::isSubmit('gallery_imageOrderby') || Tools::isSubmit('gallery_imageOrderway'))
            || Tools::isSubmit('submitResetgallery_image')
            || (Tools::isSubmit('statusgallery_image') && Tools::isSubmit('id_gallery_image'))
            || (Tools::isSubmit('way') && Tools::isSubmit('id_gallery_image')) && (Tools::isSubmit('position'))) {
            $this->admin_gallery_image->postProcess();
        } elseif (Tools::isSubmit('submitDelgallery')
            || Tools::isSubmit('submitAddgalleryAndBackToParent')
            || Tools::isSubmit('submitBulkdeletegallery')
            || Tools::isSubmit('submitBulkdisableSelectiongallery')
            || Tools::isSubmit('submitBulkenableSelectiongallery')
            || Tools::isSubmit('submitAddgallery')
            || Tools::isSubmit('submitGalleryAndAddImages')
            || Tools::isSubmit('submitFilterButtongallery')
            || (Tools::isSubmit('galleryOrderby') || Tools::isSubmit('galleryOrderway'))
            || Tools::isSubmit('submitResetgallery')
            || Tools::isSubmit('deletegallery')
            || (Tools::isSubmit('statusgallery') && Tools::isSubmit('id_gallery'))
            || (Tools::isSubmit('position') && Tools::isSubmit('id_gallery_to_move'))
            || Tools::isSubmit('submitGallery')) {
            $this->id_gallery = (int)Tools::getValue('id_gallery');
            $this->admin_galleries->postProcess();

            self::regenerateImages($this->id_gallery);
        } else {
            parent::postProcess();
        }

        if (((Tools::isSubmit('submitAddgallery')
                    || Tools::isSubmit('submitGalleryAndAddImages')
                    || Tools::isSubmit('submitAddgalleryAndStay'))
                && count($this->admin_galleries->errors))
            || Tools::isSubmit('addgallery')) {
            $this->display = 'add_gallery';
        } elseif (Tools::isSubmit('updategallery')) {
            $this->display = 'edit_gallery';
        } elseif (((Tools::isSubmit('submitAddgallery_image')
                    || Tools::isSubmit('submitAddgallery_imageAndStay'))
                && count($this->admin_gallery_image->errors))
            || Tools::isSubmit('updategallery_image')
            || Tools::isSubmit('addgallery_image')) {
            $this->display = 'edit_gallery_image';
        } else {
            $this->display = 'list';
            $this->id_gallery = (int)Tools::getValue('id_gallery');
        }

        if (isset($this->admin_gallery_image->errors)) {
            $this->errors = array_merge($this->errors, $this->admin_gallery_image->errors);
        }

        if (isset($this->admin_galleries->errors)) {
            $this->errors = array_merge($this->errors, $this->admin_galleries->errors);
        }
    }


    public function ajaxProcessUpdatePositions()
    {
        if ($this->tabAccess['edit'] === '1' || $this->access('edit') === true) {
            $table = 'gallery_image';
            $way = (int)Tools::getValue('way');
            $id = (int)Tools::getValue('id');
            $positions = Tools::getValue($table);

            if ($positions && is_array($positions)) {
                foreach ($positions as $position => $value) {
                    list($prefix, $q, $id, $old_position) = explode('_', $value);
                    Db::getInstance()->Execute(
                        'UPDATE `' . _DB_PREFIX_ . $table . '` SET `position`=' .
                        (int)$position . ' WHERE `' . $this->position_identifier . '`=' . (int)$id
                    );
                }
            }
        }
    }

    private function permission($folder)
    {
        $allpath = GalleryImage::getGalleryPaths();
        $path = $allpath[$folder]['abs'];
        $file = $path . 'gallerique.txt';
        if (file_put_contents($file, 'gallerique') === false) {
            $this->errors[] = sprintf(
                Tools::displayError('Failed to save images. Please check permissions on folders %s.'),
                $path
            );
        } else {
            unlink($file);
            Configuration::updateValue('GALLERIQUE_FOLDER_PERM_' . Tools::strtoupper($folder), 1);
        }
    }
}
