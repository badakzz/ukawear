<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.18
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

require_once(dirname(__FILE__) . './../../classes/AdminCompanyMenu.php');

class AdminGalleryController extends AdminController
{
    protected $gallery;
    protected $position_identifier = 'id_gallery_to_move';
    public $module;

    public function __construct()
    {
        $this->table = 'gallery';
        $this->className = 'Gallery';
        $this->lang = true;
        $this->bootstrap = true;

        $this->actions = array();
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->addRowAction('view');
        $this->addRowAction('preview');
        $this->actions_available = array('add', 'edit', 'delete', 'view', 'preview');
        $this->module = Module::getInstanceByName('gallerique');

        $this->context = Context::getContext();
        $this->display_company_menu = new AdminCompanyMenu();

        $this->toolbar_title = $this->l('Galleries');

        $this->bulk_actions = array(
            'delete' => array('text' => $this->l('Delete selected'), 'icon' => 'icon-trash', 'confirm' => $this->l('Delete selected items?'))
        );
        $this->explicitSelect = true;

        $this->fieldImageSettings = array(
            'name' => 'image',
            'dir' => 'o'
        );

        $this->_select = 'a.`id_gallery` as `gallery_link`';

        $this->fields_list = array(
            'id_gallery' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 25
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'width' => 'auto'
            ),
            'gallery_link' => array(
                'title' => $this->l('URL'),
                'width' => 'auto',
                'remove_onclick' => true,
                'callback' => 'getURLGallery'
            ),
            'active' => array(
                'title' => $this->l('Displayed'),
                'width' => 25,
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false
            ),
        );

        if (!AdminGalleryContentController::getCurrentGallery()) {
            $this->redirect_after = '?controller=AdminGalleryContent&token=' .
                Tools::getAdminTokenLite('AdminGalleryContent');
            $this->redirect();
        }

        $this->gallery = AdminGalleryContentController::getCurrentGallery();

        parent::__construct();
    }

    public function renderList()
    {
        $this->initToolbar();

        $render = $this->display_company_menu->displayCompanyMenu();

        if (Tools::getValue('view_page', false) == 'settings') {
            $render .= $this->getSetting();
        } else {
            $render .= parent::renderList();
        }

        return $render;
    }


    public function getSetting()
    {
        $languages = Language::getLanguages();
        $link_name = array();
        foreach ($languages as $lang) {
            $link_name['galleries'][$lang['id_lang']] = Configuration::get('GALLERIQUE_GALLERIES_LINK_NAME', $lang['id_lang']);
            $link_name['gallery'][$lang['id_lang']] = Configuration::get('GALLERIQUE_GALLERY_LINK_NAME', $lang['id_lang']);
        }

        $this->context->smarty->assign(array(
            'GALLERIQUE_GALLERY_LIST' => Configuration::get('GALLERIQUE_GALLERY_LIST'),
            'GALLERIQUE_SHOW_COVERS' => Configuration::get('GALLERIQUE_SHOW_COVERS'),
            'GALLERIQUE_COVERS_PER_ROW' => Configuration::get('GALLERIQUE_COVERS_PER_ROW'),
            'GALLERIQUE_COVERS_PER_PAGE' => Configuration::get('GALLERIQUE_COVERS_PER_PAGE'),
            'GALLERIQUE_WITH_ID' => Configuration::get('GALLERIQUE_WITH_ID'),
            'GALLERIQUE_LINK_WITHOUT_POSTFIX' => Configuration::get('GALLERIQUE_LINK_WITHOUT_POSTFIX'),
            'galleries_link_name' => $link_name['galleries'],
            'gallery_link_name' => $link_name['gallery'],
            'defaultLang' => $this->context->language->id,
            'languages' => $languages,
        ));
        $content = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'gallerique/views/templates/admin/' . (version_compare('1.6.0.0', _PS_VERSION_, '>') ? 't15/' : '') . 'settings.tpl');
        return $content;
    }

    public function renderForm()
    {
        if (!$this->loadObject(true)) {
            return;
        }

        if (Validate::isLoadedObject($this->object)) {
            $this->display = 'edit';
        } else {
            $this->display = 'add';
        }

        $image_url = ImageManager::thumbnail(
            _PS_MODULE_DIR_ . 'gallerique/img/covers/cover_' . $this->object->id . '.jpg',
            $this->table . '_cover_' . $this->object->id . '.jpg',
            350,
            'jpg',
            true,
            true
        );

        $this->initToolbar();

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Gallery'),
                'icon' => 'icon-folder-close-alt'
            ),
            'input' => array(
                array(
                    'type' => 'free',
                    'label' => false,
                    'name' => 'help_block'
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Title:'),
                    'name' => 'title',
                    'lang' => true,
                    'required' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'size' => 50
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Friendly URL:'),
                    'name' => 'link_rewrite',
                    'size' => 33,
                    'required' => true,
                    'lang' => true,
                    'hint' => $this->l('Only letters, numbers, underscore and the minus character are allowed.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Meta title:'),
                    'name' => 'meta_title',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'size' => 200
                ),
                array(
                    'type' => 'textarea',
                    'rows' => 10,
                    'cols' => 100,
                    'label' => $this->l('Meta description:'),
                    'name' => 'meta_description',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'autoload_rte' => true
                ),
                array(
                    'type' => 'textarea',
                    'rows' => 10,
                    'cols' => 100,
                    'label' => $this->l('Description:'),
                    'name' => 'description_top',
                    'lang' => true,
                    'required' => false,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'desc' => $this->l('Top text, appears before the images.'),
                    'autoload_rte' => true
                ),
                array(
                    'type' => 'textarea',
                    'rows' => 10,
                    'cols' => 100,
                    'label' => $this->l('Description:'),
                    'name' => 'description_bottom',
                    'lang' => true,
                    'required' => false,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}',
                    'desc' => $this->l('Bottom text, appears after the images.'),
                    'autoload_rte' => true
                ),
                array(
                    'type' => version_compare('1.6.0.0', _PS_VERSION_, '>') ? 'radio' : 'switch',
                    'label' => $this->l('Active:'),
                    'name' => 'active',
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
                    'type' => 'file',
                    'label' => $this->l('Cover:'),
                    'name' => 'cover_image',
                    'display_image' => true,
                    'image' => $image_url ? $image_url : false,
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ),
            'buttons' => array(
                array(
                    'title' => $this->l('Save and Add Images'),
                    'class' => 'pull-right',
                    'type' => 'submit',
                    'name' => 'submitGalleryAndAddImages',
                    'icon' => 'process-icon-save'
                )
            )
        );

        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association:'),
                'name' => 'checkBoxShopAsso',
            );
        }

        $this->context->smarty->assign(
            'PS_ALLOW_ACCENTED_CHARS_URL',
            Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')
        );

        $this->fields_value['help_block'] = $this->module->display($this->module->getLocalPath(), 'help_block.tpl');

        return $this->display_company_menu->displayCompanyMenu() . parent::renderForm();
    }

    protected function postImage($id)
    {
        $file = isset($_FILES['cover_image']) ? $_FILES['cover_image'] : false;

        if ($file && is_uploaded_file($file['tmp_name'])) {
            if (!GalleryImage::checkFileUploadType($file['name'], $file['type'])) {
                $errors[] = Tools::displayError('Invalid file type');
            } else {
                $path = _PS_MODULE_DIR_ . 'gallerique/img/covers/';
                $tmp_arr = explode('.', $file['name']);
                $filename = 'cover_' . $id . '.' . mb_strtolower(end($tmp_arr));

                if (!Tools::copy($file['tmp_name'], $path . 'o/' . $filename)) {
                    $errors[] = Tools::displayError('Failed to load image');
                } else {
                    require_once(_PS_MODULE_DIR_ . 'gallerique/classes/ImageResizeGall.php');
                    $patho = $path . 'o/' . $filename;

                    $ext = explode('.', $patho);
                    $file_type = mb_strtolower(end($ext));
                    $resize = new ImageResizeGall($patho);
                    $resize->resizeImage('500', '500', $file_type, 'crop');
                    $resize->saveImage($path . 'cover_' . $id . '.' . $file_type);

                    return true;
                }
            }
        }

        $this->errors = array_merge($this->errors, $errors);
        return false;
    }

    protected function updateAssoShop($id_object)
    {
        $assos_shop = array();

        if (Shop::isFeatureActive()) {
            $assos_shop = Tools::getValue('checkBoxShopAsso_' . $this->table);
        }

        if (!Shop::isFeatureActive() || $assos_shop === false) {
            $assos_shop[$this->context->shop->id] = $this->context->shop->id;
        }

        if (empty($assos_shop)) {
            $this->errors[] = Tools::displayError('Select at least one Shop association!');
            return false;
        }

        Db::getInstance()->delete($this->table . '_shop', '`' . $this->identifier . '` = ' . (int)$id_object);

        foreach (array_keys($assos_shop) as $id_shop) {
            Db::getInstance()->insert('gallery_shop', array(
                'id_gallery' => (int)$id_object,
                'id_shop' => (int)$id_shop,
            ));
        }

        return true;
    }

    protected function l($string, $class = 'AdminTab', $addslashes = false, $htmlentities = true)
    {
        return Translate::getModuleTranslation('gallerique', $string, get_class($this));
    }

    /**
     * @return mixed
     */
    public function postProcess()
    {
        if (Tools::isSubmit($this->table . 'Orderby') || Tools::isSubmit($this->table . 'Orderway')) {
            $this->filter = true;
        }

        $this->tabAccess = Profile::getProfileAccess(
            $this->context->employee->id_profile,
            Tab::getIdFromClassName('AdminGalleryContent')
        );

        if (Tools::isSubmit('submitAdd' . $this->table) || Tools::isSubmit('submitGalleryAndAddImages')) {
            if (!(int)Tools::getValue($this->identifier)) {
                $this->action = 'add';
            } else {
                $this->action = 'update';
            }

            $object = parent::postProcess();

            if ($object !== false) {
                if ($this->action == 'add') {
                    if (!$this->updOptions((int)$object->id)) {
                        $this->errors[] = ($this->l('The configuration could not be updated.'));
                    } else {
                        $object->associateTo($this->context->shop->id);
                    }
                }

                if (Tools::isSubmit('submitGalleryAndAddImages')) {
                    Tools::redirectAdmin(
                        self::$currentIndex . '&conf=' . ($this->action == 'add' ? 3 : 4) .
                        '&viewgallery&id_gallery=' . (int)$object->id . '&token=' . Tools::getValue('token')
                    );
                } else {
                    Tools::redirectAdmin(
                        self::$currentIndex . '&conf=' . ($this->action == 'add' ? 3 : 4) .
                        '&id_gallery=' . (int)$object->id . '&token=' . Tools::getValue('token')
                    );
                }
            }

            return $object;
        } elseif (Tools::isSubmit('delete' . $this->table)) {
            if ($this->tabAccess['delete'] === '1') {
                if (Validate::isLoadedObject($object = $this->loadObject()) && isset($this->fieldImageSettings)) {
                    // check if request at least one object with noZeroObject
                    if (isset($object->noZeroObject)
                        && count(call_user_func(array($this->className, $object->noZeroObject))) <= 1) {
                        $this->errors[] = Tools::displayError('You need at least one object.') .
                            ' <b>' . $this->table . '</b><br />' .
                            Tools::displayError('You cannot delete all of the items.');
                    } else {
                        if ($this->deleted) {
                            $object->deleted = 1;

                            if ($object->update()) {
                                Tools::redirectAdmin(self::$currentIndex . '&conf=1&token=' . Tools::getValue('token'));
                            }
                        } elseif ($object->delete()) {
                            $gal = $object->id;
                            Configuration::deleteByName('GALLERIQUE_S_HEIGHT_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_S_WIDTH_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_T_HEIGHT_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_T_WIDTH_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_T_RESIZE_METHOD_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_S_RESIZE_METHOD_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_SORTING_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_SHOW_IMAGE_LABELS_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_SHOW_IMAGE_DESC_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_MAX_IMAGE_LABELS_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_MAX_IMAGE_DESC_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_SB_ON_IMAGE_' . $gal);
                            Configuration::deleteByName('GALLERIQUE_IMG_CACHE_' . $gal);
                            Tools::redirectAdmin(self::$currentIndex . '&conf=1&token=' . Tools::getValue('token'));
                        }

                        $this->errors[] = Tools::displayError('An error occurred during deletion.');
                    }
                } else {
                    $this->errors[] = Tools::displayError('An error occurred while deleting the object.')
                        . '<b>' . $this->table . '</b> ' .
                        Tools::displayError('(cannot load object)');
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
        } elseif (Tools::getValue('submitDel' . $this->table) || Tools::getIsset('submitBulkdelete' . $this->table)) {
            if ($this->tabAccess['delete'] === '1') {
                if (Tools::isSubmit($this->table . 'Box')) {
                    $gallery = new Gallery();

                    if ($gallery->deleteSelection(Tools::getValue($this->table . 'Box'))) {
                        $token = Tools::getAdminTokenLite('AdminGalleryContent');

                        Tools::redirectAdmin(self::$currentIndex . '&conf=2&token=' . $token);
                    }

                    $this->errors[] = Tools::displayError('An error occurred while deleting this selection.');

                } else {
                    $this->errors[] = Tools::displayError('You must select at least one element to delete.');
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
        } elseif (Tools::isSubmit('status' . $this->table) && Tools::isSubmit($this->identifier)) {
            if ($this->tabAccess['edit'] === '1') {
                if (Validate::isLoadedObject($object = $this->loadObject())) {
                    if ($object->toggleStatus()) {
                        Tools::redirectAdmin(self::$currentIndex . '&conf=5&token=' . Tools::getValue('token'));
                    } else {
                        $this->errors[] = Tools::displayError('An error occurred while updating the status.');
                    }
                } else {
                    $this->errors[] = Tools::displayError(
                            'An error occurred while updating the status for an object.'
                        ) . ' <b>' . $this->table . '</b> ' .
                        Tools::displayError('(cannot load object)');
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            }
        } elseif (Tools::isSubmit('submitGallery')) {
            if (!$this->updOptions(Tools::getValue('id_gallery'))) {
                $this->errors[] = ($this->l('The configuration could not be updated.'));
            } else {
                Tools::redirectAdmin(
                    self::$currentIndex . '&conf=6&updategallery&id_gallery=' .
                    Tools::getValue('id_gallery') . '&token=' . Tools::getValue('token')
                );
            }
        } elseif (Tools::isSubmit('submitBulkenableSelection' . $this->table)) {
            $selections = Tools::getValue($this->table . 'Box');
            foreach ($selections as $gal) {
                $gallery = new Gallery($gal);
                $gallery->active = 1;
                $gallery->save();
            }
            Tools::redirectAdmin(
                self::$currentIndex . '&conf=5&id_gallery=' . Tools::getValue('id_gallery') .
                '&token=' . Tools::getValue('token')
            );
        } elseif (Tools::isSubmit('submitBulkdisableSelection' . $this->table)) {
            $selections = Tools::getValue($this->table . 'Box');
            foreach ($selections as $gal) {
                $gallery = new Gallery($gal);
                $gallery->active = 0;
                $gallery->save();
            }
            Tools::redirectAdmin(
                self::$currentIndex . '&conf=5&id_gallery=' . Tools::getValue('id_gallery') .
                '&token=' . Tools::getValue('token')
            );
        }
        parent::postProcess();
    }

    private function updOptions($id_g)
    {
        $list = (array(
            'GALLERIQUE_S_WIDTH_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_S_WIDTH', 600),
                'default' => 600
            ),
            'GALLERIQUE_S_HEIGHT_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_S_HEIGHT', 600),
                'default' => 600
            ),
            'GALLERIQUE_T_WIDTH_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_T_WIDTH', 90),
                'default' => 90
            ),
            'GALLERIQUE_T_HEIGHT_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_T_HEIGHT', 90),
                'default' => 90
            ),
            'GALLERIQUE_T_RESIZE_METHOD_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_T_RESIZE_METHOD', 'crop'),
                'default' => 'crop'
            ),
            'GALLERIQUE_S_RESIZE_METHOD_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_S_RESIZE_METHOD', 'auto'),
                'default' => 'auto'
            ),
            'GALLERIQUE_SORTING_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_SORTING', 1),
                'default' => 1
            ),
            'GALLERIQUE_SHOW_IMAGE_LABELS_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_SHOW_IMAGE_LABELS', 0),
                'default' => 0
            ),
            'GALLERIQUE_SHOW_IMAGE_DESC_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_SHOW_IMAGE_DESC', 0),
                'default' => 0
            ),
            'GALLERIQUE_MAX_IMAGE_LABELS_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_MAX_IMAGE_LABELS', 30),
                'default' => 30
            ),
            'GALLERIQUE_MAX_IMAGE_DESC_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_MAX_IMAGE_DESC', 30),
                'default' => 30
            ),
            'GALLERIQUE_SB_ON_IMAGE_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_SB_ON_IMAGE', 0),
                'default' => 0
            ),
            'GALLERIQUE_IMG_CACHE_' . $id_g => array(
                'value' => Tools::getValue('GALLERIQUE_IMG_CACHE', 1),
                'default' => 1
            ),
        ));

        $res = true;

        foreach ($list as $k => $v) {
            $value = $v['value'];

            if (Tools::isEmpty($v['value'])) {
                $value = $v['default'];
            }

            if (Shop::isFeatureActive()) {
                foreach (Shop::getShops() as $shop) {
                    $res &= Configuration::updateValue($k, $value, false, $shop['id_shop_group'], $shop['id_shop']);
                }
            } else {
                $res &= Configuration::updateValue($k, $value);
            }
        }

        if ($res) {
            AdminGalleryContentController::regenerateImages($id_g);
        }
        return $res;
    }
}
