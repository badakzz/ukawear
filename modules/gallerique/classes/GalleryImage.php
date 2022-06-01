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

class GalleryImage extends ObjectModel
{
    public $id;
    public $id_gallery;
    public $date_add;
    public $date_upd;
    public $position;
    public $label;
    public $image_link;
    public $description;
    public $alt;
    public $active = 1;
    private static $resize_data = false;

    const THUMBNAIL = 't';
    const SCALED = 's';
    const ORIGINAL = 'o';

    public static $definition = array(
        'table' => 'gallery_image',
        'primary' => 'id_gallery_image',
        'multilang' => true,
        'fields' => array(
            'id_gallery' => array('type' => self::TYPE_INT, 'required' => true),
            'date_add' => array('type' => self::TYPE_DATE),
            'date_upd' => array('type' => self::TYPE_DATE),
            'position' => array('type' => self::TYPE_INT),
            'label' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName',
                'size' => 128
            ),
            'image_link' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isUrl',
                'required' => false,
                'size' => 255
            ),
            'description' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
            'alt' => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
            'active' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true)
        )
    );

    private static $allowed_types = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif'
    );

    public static function getExistingOriginalImagesData($id_gallery)
    {
        $images = Db::getInstance()->ExecuteS(
            'SELECT `id_gallery_image` FROM `' . _DB_PREFIX_ . 'gallery_image` WHERE `id_gallery` = ' . (int)$id_gallery
        );
        $paths = self::getGalleryPaths();

        if ($images && count($images)) {
            foreach ($images as &$image) {
                $image['path'] = false;

                if (file_exists($paths[GalleryImage::ORIGINAL]['abs'] . $image['id_gallery_image'] . '.jpg')) {
                    $image['path'] = $paths[GalleryImage::ORIGINAL]['abs'] . $image['id_gallery_image'] . '.jpg';
                }
                if (file_exists($paths[GalleryImage::ORIGINAL]['abs'] . $image['id_gallery_image'] . '.png')) {
                    $image['path'] = $paths[GalleryImage::ORIGINAL]['abs'] . $image['id_gallery_image'] . '.png';
                }
            }

            return $images;
        }

        return false;
    }

    private static function getResizeData()
    {
        if (!self::$resize_data) {
            $resize_data = self::fullResizeWay();

            if (count($resize_data)) {
                foreach ($resize_data as &$data) {
                    if (!in_array($data['method'], array('auto', 'crop', 'exact', 'portrait', 'landscape'))) {
                        $data['method'] = 'auto';
                    }
                }
            }
            self::$resize_data = count($resize_data) ? $resize_data : false;
        }
        return self::$resize_data;
    }

    private static function fullResizeWay()
    {
        $id_gal = Tools::getValue('id_gallery');
        $paths = self::getGalleryPaths(true);
        $first_gallery_shop_id = self::getFirstGalleryShop($id_gal);
        $current_context_shop_id = Shop::getContextShopID();
        $current_context_group_shop_id = Shop::getContextShopGroupID();

        if ($first_gallery_shop_id && isset(Shop::getShop($first_gallery_shop_id)['id_shop_group'])) {
            $first_gallery_group_shop_id = Shop::getShop($first_gallery_shop_id)['id_shop_group'];
        } else {
            $first_gallery_group_shop_id = null;
        }

        $resize_data = array();
        foreach ($paths as $folder => $path) {
            $resize_data[$folder] = array(
                'method' => Configuration::get(
                    'GALLERIQUE_' . Tools::strtoupper(pSQL($folder)) . '_RESIZE_METHOD_' . $id_gal,
                    null,
                    $current_context_shop_id ? $current_context_shop_id : $first_gallery_shop_id,
                    $current_context_group_shop_id ? $current_context_group_shop_id : $first_gallery_group_shop_id
                ),
                'width' => (int)Configuration::get(
                    'GALLERIQUE_' . Tools::strtoupper(pSQL($folder)) . '_WIDTH_' . $id_gal,
                    null,
                    $current_context_shop_id ? $current_context_shop_id : $first_gallery_shop_id,
                    $current_context_group_shop_id ? $current_context_group_shop_id : $first_gallery_group_shop_id
                ),
                'height' => (int)Configuration::get(
                    'GALLERIQUE_' . Tools::strtoupper(pSQL($folder)) . '_HEIGHT_' . $id_gal,
                    null,
                    $current_context_shop_id ? $current_context_shop_id : $first_gallery_shop_id,
                    $current_context_group_shop_id ? $current_context_group_shop_id : $first_gallery_group_shop_id
                ),
                'abs' => $path['abs'],
                'rel' => $path['rel']
            );
        }
        return $resize_data;
    }

    private static function getFirstGalleryShop($id_gallery)
    {
        $query = new DbQuery();
        $query->select('id_shop');
        $query->from('gallery_shop', 'gs');
        $query->where('gs.id_gallery=' . $id_gallery);
        return Db::getInstance()->getValue($query->build());
    }

    public function add($autodate = true, $null_values = false)
    {
        $this->correctLink();
        $this->position = self::getLastPosition((int)$this->id_gallery) + 1;
        return parent::add($autodate, $null_values);
    }

    public function update($null_values = false)
    {
        $this->correctLink();
        if (parent::update($null_values)) {
            return $this->cleanPositions($this->id_gallery);
        }
        return false;
    }

    private function correctLink()
    {
        $pattern = '/^((https|http):\/\/)/';
        foreach ($this->image_link as &$link) {
            if ($link && !preg_match($pattern, $link)) {
                $link = 'http://' . $link;
            }
        }
    }

    public function delete()
    {
        $picture = $this->id;

        if (parent::delete()) {
            $this->deletePicture($picture);

            return $this->cleanPositions($this->id_gallery);
        }
        return false;
    }

    private function deletePicture($picture)
    {
        $paths = self::getGalleryPaths();

        foreach ($paths as $path) {
            foreach (self::$allowed_types as $extension => $type) {
                if (file_exists($path['abs'] . $picture . '.' . $extension)) {
                    @unlink($path['abs'] . $picture . '.' . $extension);
                }
            }
        }
    }

    public static function uploadImage($id, $file)
    {
        require_once(dirname(__FILE__) . '/ImageResizeGall.php');

        $paths = self::getGalleryPaths();
        $tmp_arr = explode('.', $file['name']);
        $filename = $id . '.' . mb_strtolower(end($tmp_arr));

        if (!Tools::copy($file['tmp_name'], $paths[self::ORIGINAL]['abs'] . $filename)) {
            return false;
        } else {
            self::generateScaledImages($id, $paths[self::ORIGINAL]['abs'] . $filename);
            @unlink($file['tmp_name']);
            return $filename;
        }

        return false;
    }

    public static function generateScaledImages($id, $path)
    {
        if ($path) {
            $resize_data = self::getResizeData();

            foreach ($resize_data as $data) {
                if ($data['width'] && $data['height']) {
                    $ext = explode('.', $path);
                    $file_type = mb_strtolower(end($ext));
                    $resize = new ImageResizeGall($path);
                    $resize->resizeImage($data['width'], $data['height'], $file_type, $data['method']);
                    $resize->saveImage($data['abs'] . $id . '.' . $file_type);
                }
            }
        }
    }

    public static function checkFileUploadType($filename, $filetype)
    {
        foreach (self::$allowed_types as $extension => $type) {
            if (self::getExtension($filename) == $extension && $filetype == $type) {
                return true;
            }
        }

        return false;
    }

    public static function getExtension($filename)
    {
        return Tools::strtolower(Tools::substr(strrchr($filename, '.'), 1));
    }

    public static function getGalleryPaths($exclude_original = false)
    {
        $folders = array(GalleryImage::SCALED, GalleryImage::THUMBNAIL);

        if (!$exclude_original) {
            array_push($folders, GalleryImage::ORIGINAL);
        }

        $result = array();

        foreach ($folders as $folder) {
            $result[$folder] = array(
                'abs' => _PS_MODULE_DIR_ . 'gallerique/img/' . $folder . '/',
                'rel' => _MODULE_DIR_ . 'gallerique/img/' . $folder . '/'
            );
        }

        return $result;
    }

    public function updatePosition($way, $position)
    {
        if (!$res = Db::getInstance()->executeS(
            'SELECT
            gi.`id_gallery_image`,
            gi.`position`,
            gi.`id_gallery`
            FROM
            `' . _DB_PREFIX_ . 'gallery_image` gi
            WHERE
            gi.`id_gallery` = ' . (int)$this->id_gallery . '
            ORDER BY
            gi.`position` ASC'
        )) {
            return false;
        }

        foreach ($res as $image) {
            if ((int)$image['id_gallery_image'] == (int)$this->id) {
                $moved_image = $image;
            }
        }

        if (!isset($moved_image) || !isset($position)) {
            return false;
        }

        return (Db::getInstance()->execute(
                'UPDATE
            `' . _DB_PREFIX_ . 'gallery_image`
            SET
            `position`= `position` ' . ($way ? '- 1' : '+ 1') . '
            WHERE `position`
            ' .
                (
                $way
                    ? '> ' . (int)$moved_image['position'] . ' AND `position` <= ' . (int)$position
                    : '< ' . (int)$moved_image['position'] . ' AND `position` >= ' . (int)$position
                ) . '
            AND
            `id_gallery`=' . (int)$moved_image['id_gallery']
            ) && Db::getInstance()->execute(
                'UPDATE
            `' . _DB_PREFIX_ . 'gallery_image`
            SET
            `position` = ' . (int)$position . '
            WHERE
            `id_gallery_image` = ' . (int)$moved_image['id_gallery_image'] . '
            AND
            `id_gallery`=' . (int)$moved_image['id_gallery']
            )
        );
    }

    public static function getLastPosition()
    {
        return (int)Db::getInstance()->getValue('SELECT MAX(`position`) FROM `' . _DB_PREFIX_ . 'gallery_image`');
    }

    public static function cleanPositions($id_gallery)
    {
        $sql = 'SELECT
            `id_gallery_image`
        FROM
            `' . _DB_PREFIX_ . 'gallery_image`
        WHERE
            `id_gallery` = ' . (int)$id_gallery . '
        ORDER BY
            `position`';

        $result = Db::getInstance()->executeS($sql);

        for ($i = 0, $total = count($result); $i < $total; ++$i) {
            $sql = 'UPDATE
            `' . _DB_PREFIX_ . 'gallery_image`
            SET
            `position` = ' . (int)$i . '
            WHERE
            `id_gallery` = ' . (int)$id_gallery . '
            AND
            `id_gallery_image` = ' . (int)$result[$i]['id_gallery_image'];

            Db::getInstance()->execute($sql);
        }

        return true;
    }

    public static function getImageExists($id, $type = GalleryImage::SCALED)
    {
        $paths = self::getGalleryPaths();

        if (isset($paths[$type]) && file_exists($paths[$type]['abs'] . $id . '.jpg')) {
            return array(
                'abs' => $paths[$type]['abs'] . $id . '.jpg',
                'rel' => $paths[$type]['rel'] . $id . '.jpg'
            );
        }

        return false;
    }
}
