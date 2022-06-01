<?php
/**
 * gallerique
 *
 * @category  Module
 * @author    silbersaiten <info@silbersaiten.de>
 * @support   silbersaiten <support@silbersaiten.de>
 * @copyright 2018 silbersaiten
 * @version   1.3.14
 * @link      http://www.silbersaiten.de
 * @license   See joined file licence.txt
 */

require_once(dirname(__FILE__) . './../../classes/AdminCompanyMenu.php');

class AdminGalleryImagesController extends AdminController
{
    protected $gallery;
    public $id_gallery;
    protected $position_identifier = 'id_gallery_image';

    public function __construct()
    {
        $this->table = 'gallery_image';
        $this->className = 'GalleryImage';
        $this->lang = true;
        $this->bootstrap = true;
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->bulk_actions = array(
            'delete' => array('text' => $this->l('Delete selected'), 'icon' => 'icon-trash', 'confirm' => $this->l('Delete selected items?'))
        );

        $this->fieldImageSettings = array(
            'name' => 'image',
            'dir' => 'o'
        );

        $this->_select = 'a.`id_gallery_image` as `image_file`';

        $this->fields_list = array(
            'id_gallery_image' => array(
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 25
            ),
            'image_file' => array(
                'title' => $this->l('Photo'),
                'align' => 'center',
                'width' => 70,
                'orderby' => false,
                'filter' => false,
                'search' => false,
                'callback' => 'getGalleryPreviewImage',
            ),
            'label' => array(
                'title' => $this->l('Label'),
                'width' => 'auto'
            ),
            'image_link' => array(
                'title' => $this->l('Link'),
                'width' => 200
            ),
            'position' => array(
                'title' => $this->l('Position'),
                'width' => 40,
                'align' => 'center',
                'position' => 'position'
            ),
            'active' => array(
                'title' => $this->l('Displayed'),
                'width' => 25,
                'align' => 'center',
                'active' => 'status',
                'type' => 'bool',
                'orderby' => false
            )
        );

        $this->_orderBy = 'position';
        $this->_orderWay = 'ASC';

        if ($id_gallery = (int)Tools::getValue('id_gallery')) {
            $this->id_current_gallery = $id_gallery;

            $this->gallery = AdminGalleryContentController::getCurrentGallery();

            $this->_where = 'AND a.`id_gallery` = '.$this->id_current_gallery;
        }

        $this->display_company_menu = new AdminCompanyMenu();

        parent::__construct();

        $this->id = Tab::getIdFromClassName('AdminGallery');
        $this->token = Tools::getAdminToken('AdminGallery'.(int)$this->id.(int)$this->context->employee->id);
    }
    
    public function getGalleryPreviewImage()
    {
        return 'test';
    }

    public function renderList()
    {
        $gallery = new Gallery($this->id_gallery);
        
        $this->toolbar_title = $this->l('Images in gallery: ').$this->gallery->title[$this->context->language->id];
        $this->toolbar_btn['back'] = array(
            'href' => self::$currentIndex.'&token='.$this->token,
            'desc' => $this->l('Back to galleries')
        );
        $this->toolbar_btn['new'] = array(
            'href' => self::$currentIndex.'&add'.$this->table.'&id_gallery='.
                (int)$this->id_gallery.'&token='.$this->token,
            'desc' => $this->l('Add new')
        );
        $this->toolbar_btn['configure'] = array(
            'href' => self::$currentIndex.'&updategallery&id_gallery='.(int)$this->id_gallery.'&token='.$this->token,
            'desc' => $this->l('Settings gallery')
        );
        $this->toolbar_btn['preview'] = array(
            'href' => $this->context->link->getModuleLink(
                'gallerique',
                'gallery',
                array(
                    'id_gallery' => (int)$this->gallery->id,
                    'link_rewrite' => $this->gallery->link_rewrite[$this->context->language->id])
            ),
            'target' => true,
            'desc' => $this->l('Preview')
        );

        self::$currentIndex .= '&id_gallery='.(int)$this->id_gallery.'&viewgallery';

        $this->context->smarty->assign(array(
            'ajaxPath' => self::$currentIndex.'&token='.Tools::getAdminTokenLite('front_office_features').
                '&ajaxupl=true',
            'newimage' => self::$currentIndex.'&token='.$this->token.'&add'.$this->table,
            'refresh_link' => self::$currentIndex.'&token='.$this->token,
            'upl' => $this->l('has been uploaded'),
        ));
        $content = $this->context->smarty->fetch(_PS_MODULE_DIR_.'gallerique/views/templates/admin/filesUpload.tpl');

        $render = $this->display_company_menu->displayCompanyMenu();
        $render .= $content;
        $render .= parent::renderList();

        return $render;
    }

    public function renderForm()
    {
        if (!$this->loadObject(true)) {
            return;
        }

        if (Validate::isLoadedObject($this->object)) {
            $this->display = 'edit';

            $image = GalleryImage::getImageExists($this->object->id);

            $this->fields_value = array(
                'image' => $image ? '<img src="'.$image['rel'].'" />' : false,
                'size' => $image ? filesize($image['abs']) / 1000 : false
            );

            $gallery_id = $this->object->id_gallery;
        } else {
            $this->display = 'add';

            $gallery = AdminGalleryContentController::getCurrentGallery();

            $gallery_id = $gallery->id;
        }

        $this->initToolbar();

        $this->toolbar_btn['back'] = array(
            'href' => self::$currentIndex.'&amp;id_gallery='.$gallery_id.'&amp;viewgallery&amp;token='.$this->token,
            'desc' => $this->l('Back to list')
        );
        
        $paths = GalleryImage::getGalleryPaths();
        $id_gallery_image = Tools::getValue('id_gallery_image');
        
        $image = $paths[GalleryImage::THUMBNAIL]['abs'].(int)$id_gallery_image.'.jpg';
        $image_url = ImageManager::thumbnail(
            $image,
            $this->table.'_'.(int)$id_gallery_image.'.jpg',
            350,
            'jpg',
            true,
            true
        );
        $image_size = file_exists($image) ? filesize($image) / 1000 : false;

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Gallery Image'),
                'icon' => 'icon-picture'
            ),
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Gallery:'),
                    'name' => 'id_gallery',
                    'options' => array(
                    'query' => Gallery::getGalleries($this->context->language->id),
                    'id' => 'id',
                    'name' => 'name'
                    ),
                    'default_value' => $gallery_id,
                    'desc' => $this->l('Choose the gallery for this image'),
                    'required' => true
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l('Image:'),
                    'name' => 'image',
                    'display_image' => true,
                    'image' => $image_url ? $image_url : false,
                    'required' => true,
                    'desc' => $this->l('Upload an image from your computer.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Label:'),
                    'name' => 'label',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}',
                    'size' => 50
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Link:'),
                    'name' => 'image_link',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}',
                    'size' => 128
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Alt:'),
                    'name' => 'alt',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}',
                    'size' => 255
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Description'),
                    'name' => 'description',
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:').' <>;=#{}',
                    'rows' => 5,
                    'cols' => 40,
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
            ),
            'submit' => array(
            'title' => $this->l('Save'),
            'class' => 'btn btn-default pull-right'
            )
        );

        return $this->display_company_menu->displayCompanyMenu() . parent::renderForm();
    }

    protected function l($string, $class = 'AdminTab', $addslashes = false, $htmlentities = true)
    {
        return Translate::getModuleTranslation('gallerique', $string, get_class($this));
    }

    public function processSave()
    {
        $this->preuploadFileCheck(!$this->id_object);

        return parent::processSave();
    }

    public function uploadAjaxFile($id_gallery)
    {
        $result = array(
            'errors' => array(),
            'files' => array(),
        );
        $files = isset($_FILES[$this->fieldImageSettings['name']])
            ? $_FILES[$this->fieldImageSettings['name']]
            : false;
        if (!$files || !$id_gallery) {
            $result['errors'][] = $this->l('Upload failed. Try refreshing the page.');
        } else {
            $count_images = count($files['name']);
            for ($i=0; $i < $count_images; $i++) {
                if (is_uploaded_file($files['tmp_name'][$i])) {
                    
                    $gallery_image = new GalleryImage();
                    $gallery_image->id_gallery = (int)$id_gallery;
                    $gallery_image->active = 0;
            
                    if (!GalleryImage::checkFileUploadType($files['name'][$i], $files['type'][$i])) {
                        $result['errors'][] = $this->l('Invalid file type.');
                    } else {
                        $gallery_image->add();
                        $file = array();

                        foreach ($files as $field => $image) {
                            $file[$field] = $image[$i];
                        }

                        $filename = GalleryImage::uploadImage($gallery_image->id, $file);
                            $result['files'][] = array(
                            "name"=> $files['name'][$i],
                            "type"=> $files['type'][$i],
                            "size"=> $files['size'][$i]
                        );
                    }

                } else {
                    $result['errors'][] = $this->l('Upload failed. Try refreshing the page.');
                }
            }
        }

        return Tools::jsonEncode($result);
    }

    public function getFile()
    {
        $file = isset($_FILES[$this->fieldImageSettings['name']]) ? $_FILES[$this->fieldImageSettings['name']] : false;

        if (!$file || !is_uploaded_file($file['tmp_name'])) {
            $file = false;
        }

        return $file;
    }

    public function uploadFile($object_id, $require_file = true)
    {
        if ($file = $this->getFile()) {
            $filename = false;

            if (!$filename = GalleryImage::uploadImage($object_id, $file)) {
                $this->errors[] = Tools::displayError('Unable to upload image');
                return false;
            }

            return $filename;
        } elseif ($require_file) {
            $this->errors[] = Tools::displayError('Please provide an image');
            return false;
        }
    }

    public function preuploadFileCheck($require_file = true)
    {
        $errors = array();

        if ($file = $this->getFile()) {
            if (!GalleryImage::checkFileUploadType($file['name'], $file['type'])) {
                $errors[] = Tools::displayError('Invalid file type');
            }

        } elseif ($require_file) {
            $errors[] = Tools::displayError('Please provide an image');
        }

        if (count($errors)) {
            $this->errors = array_merge($this->errors, $errors);

            return false;
        }

        return true;
    }

    protected function postImage($id)
    {
        return ($this->preuploadFileCheck(false) && $this->uploadFile($id, false));
    }

    public function getAccess($action = 'edit', $class = 'AdminGalleryContent')
    {
        if (version_compare('1.7.0.0', _PS_VERSION_, '>')) {
            return false;
        }

        $slugs = array();
        $id = Tab::getIdFromClassName($class);
        foreach ((array) Access::getAuthorizationFromLegacy($action) as $roleSuffix) {
            $slugs[] = Access::findSlugByIdTab($id).$roleSuffix;
        }
        return Access::isGranted($slugs, $this->context->employee->id_profile);
    }

    public function postProcess()
    {
        if (Tools::isSubmit($this->table.'Orderby') || Tools::isSubmit($this->table.'Orderway')) {
            $this->filter = true;
        }

        $this->tabAccess = Profile::getProfileAccess(
            $this->context->employee->id_profile,
            Tab::getIdFromClassName('AdminGalleryContent')
        );

        if (!Configuration::get('GALLERIQUE_FOLDER_PERM_O')
            || !Configuration::get('GALLERIQUE_FOLDER_PERM_S')
            || !Configuration::get('GALLERIQUE_FOLDER_PERM_T')) {
            $this->errors[] = Tools::displayError(
                'Failed to save images. Please check permissions on folders "modules/gallerique/img" and subfolders'
            );
            return false;
        }

        if (Tools::isSubmit('submitAdd'.$this->table) || Tools::isSubmit('submitAdd'.$this->table.'AndPreview')) {
            parent::validateRules();

            if (count($this->errors)) {
                return false;
            }

            if (!$id_image = (int)Tools::getValue($this->identifier)) {
                $gallery_image = new GalleryImage();
                $this->copyFromPost($gallery_image, 'gallery_image');
                $this->preuploadFileCheck();

                if (!count($this->errors)) {
                    if (!$gallery_image->add()) {
                        $this->errors[] = Tools::displayError('An error occurred while
                            creating an object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
                    } else {
                        if (!$this->uploadFile($gallery_image->id)) {
                            $this->errors[] = Tools::displayError(
                                'We were unable to upload the picture you\'ve selected.'
                            ).Tools::displayError(
                                'The other information was saved, but the entry has been deactivated.'
                            );

                            $gallery_image->active = 0;
                            $gallery_image->update();

                        }
                    }
                }
            } else {
                $gallery_image = new GalleryImage($id_image);
                $this->copyFromPost($gallery_image, 'gallery_image');
                $this->preuploadFileCheck(false);

                if (!count($this->errors)) {
                    $this->uploadFile($gallery_image->id, false);

                    if (!$gallery_image->update()) {
                        $this->errors[] = Tools::displayError('An error occurred while updating an
                            object.').' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
                    }
                }
            }

            if (!count($this->errors)) {

                if (Tools::isSubmit('submitAdd'.$this->table.'AndStay')) {
                    Tools::redirectAdmin(
                        self::$currentIndex.'&'.$this->identifier.'='.$gallery_image->id.
                        '&viewgallery&conf=4&update'.$this->table.'&token='.
                        Tools::getAdminTokenLite('AdminGalleryContent')
                    );
                } else {
                    AdminGalleryContentController::setCurrentGallery($gallery_image->id_gallery);

                    Tools::redirectAdmin(
                        self::$currentIndex.'&id_gallery='.$gallery_image->id_gallery.
                        '&viewgallery&conf=4&token='.Tools::getAdminTokenLite('AdminGalleryContent')
                    );
                }
            }
        } elseif (Tools::isSubmit('delete'.$this->table)) {
            $gallery_image = new GalleryImage((int)Tools::getValue('id_gallery_image'));

            if (!$gallery_image->delete()) {
                $this->errors[] = Tools::displayError('An error occurred while deleting the object.').
                    ' <b>'.$this->table.' ('.Db::getInstance()->getMsgError().')</b>';
            } else {
                Tools::redirectAdmin(
                    self::$currentIndex.'&id_gallery='.Tools::getValue('id_gallery').
                    '&viewgallery&conf=1&token='.Tools::getAdminTokenLite('AdminGalleryContent')
                );
            }
        } elseif (Tools::getValue('submitDel'.$this->table) || Tools::getIsset('submitBulkdelete'.$this->table)) {
            if ($this->tabAccess['delete'] === '1' || $this->getAccess('delete') === true) {
                if (Tools::isSubmit($this->table.'Box')) {
                    $gallery_image = new GalleryImage();

                    if ($gallery_image->deleteSelection(Tools::getValue($this->table.'Box'))) {
                        $gallery_image->cleanPositions((int)Tools::getValue('id_gallery'));

                        Tools::redirectAdmin(
                            self::$currentIndex.'&id_gallery='.Tools::getValue('id_gallery').
                            '&viewgallery&conf=2&token='.Tools::getAdminTokenLite('AdminGalleryContent')
                        );
                    }

                    $this->errors[] = Tools::displayError('An error occurred while deleting this selection.');
                } else {
                    $this->errors[] = Tools::displayError('You must select at least one element to delete.');
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to delete this.');
            }
        } elseif (Tools::isSubmit('status'.$this->table) && Tools::isSubmit($this->identifier)) {
            if ($this->tabAccess['edit'] === '1' || $this->getAccess('edit') === true) {
                if (Validate::isLoadedObject($object = $this->loadObject())) {
                    if ($object->toggleStatus()) {
                        Tools::redirectAdmin(
                            self::$currentIndex.'&conf=5&id_gallery='.(int)$object->id_gallery.
                            '&viewgallery&token='.Tools::getValue('token')
                        );
                    } else {
                        $this->errors[] = Tools::displayError('An error occurred while updating the status.');
                    }
                } else {
                    $this->errors[] = Tools::displayError(
                        'An error occurred while updating the status for an object.'
                    ).' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
                }
            } else {
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            }
        } elseif (Tools::isSubmit('submitReset'.$this->table)) {
            $this->processResetFilters();
        } elseif (Tools::isSubmit('way') && Tools::isSubmit('id_gallery_image') && (Tools::isSubmit('position'))) {
            if ($this->tabAccess['edit'] !== '1' || $this->getAccess('edit') === true) {
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            } elseif (!Validate::isLoadedObject($object = $this->loadObject())) {
                $this->errors[] = Tools::displayError('An error occurred while updating the status for an object.').
                    ' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
            } elseif (!$object->updatePosition((int)Tools::getValue('way'), (int)Tools::getValue('position'))) {
                $this->errors[] = Tools::displayError('Failed to update the position.');
            } else {
                Tools::redirectAdmin(
                    self::$currentIndex.'&'.$this->table.'Orderby=position&'.$this->table.
                    'Orderway=asc&conf=4&viewgallery&id_gallery='.(int)$object->id_gallery.'&token='.
                    Tools::getAdminTokenLite('AdminGalleryContent')
                );
            }
        } elseif (Tools::isSubmit('submitBulkenableSelection'.$this->table)) {
            $selections = Tools::getValue($this->table.'Box');
            foreach ($selections as $image) {
                $gallery_image = new GalleryImage($image);
                $gallery_image->active = 1;
                $gallery_image->save();
            }
            Tools::redirectAdmin(
                self::$currentIndex.'&conf=5&id_gallery='.Tools::getValue('id_gallery').
                '&viewgallery&token='.Tools::getValue('token')
            );
        } elseif (Tools::isSubmit('submitBulkdisableSelection'.$this->table)) {
            $selections = Tools::getValue($this->table.'Box');
            foreach ($selections as $image) {
                $gallery_image = new GalleryImage($image);
                $gallery_image->active = 0;
                $gallery_image->save();
            }
            Tools::redirectAdmin(
                self::$currentIndex.'&conf=5&id_gallery='.Tools::getValue('id_gallery').
                '&viewgallery&token='.Tools::getValue('token')
            );
        }

        parent::postProcess();
    }

    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        if ($order_by && $this->context->cookie->__get($this->table.'Orderby')) {
            $order_by = $this->context->cookie->__get($this->table.'Orderby');
        } else {
            $order_by = 'position';
        }

        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
    }
}
