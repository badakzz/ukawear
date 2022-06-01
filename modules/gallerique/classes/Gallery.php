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

class Gallery extends ObjectModel
{
    public $id;
    public $date_add;
    public $date_upd;
    public $title;
    public $meta_title;
    public $meta_description;
    public $link_rewrite;
    public $description_top;
    public $description_bottom;
    public $active = 1;

    public static $definition = array(
        'table' => 'gallery',
        'primary' => 'id_gallery',
        'multilang' => true,
        'multilang_shop' => false,
        'fields' => array(
            'date_add'           => array('type' => self::TYPE_DATE),
            'date_upd'           => array('type' => self::TYPE_DATE),
            'title'              => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName',
                'required' => true,
                'size' => 128
            ),
            'link_rewrite'       => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isLinkRewrite',
                'required' => true,
                'size' => 128
            ),
            'meta_title' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isString',
                'size' => 256
            ),
            'meta_description'    => array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString'),
            'description_top'    => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
            'description_bottom' => array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString'),
            'active'             => array('type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true)
        )
    );

    public function delete()
    {
        $pictures = Db::getInstance()->ExecuteS(
            'SELECT
            `id_gallery_image`
            FROM
            `'._DB_PREFIX_.'gallery_image`
            WHERE
            `id_gallery` = '.(int)$this->id
        );

        if ($pictures && count($pictures)) {
            foreach ($pictures as $picture) {
                if (Validate::isLoadedObject($gallery_image = new GalleryImage((int)$picture['id_gallery_image']))) {
                    $gallery_image->delete();
                }
            }
        }

        return parent::delete();
    }

    /**
     * @param $id_lang
     * @param bool $active
     * @param bool $shop
     * @param bool $limit
     * @param bool $page
     * @return array|false|mysqli_result|null|PDOStatement|resource
     * @throws PrestaShopDatabaseException
     */
    public static function getGalleries($id_lang, $active = false, $shop = false, $limit = false, $page = false)
    {
        $sql = new DbQuery();
        $sql->select(
            'g.`id_gallery`,
            gl.`link_rewrite`,
            gl.`title`,
            gl.`description_top`'
        );

        $sql->from('gallery', 'g');
        $sql->leftJoin('gallery_lang', 'gl', 'g.`id_gallery` = gl.`id_gallery` AND gl.`id_lang` = ' . (int)$id_lang);

        if ($shop) {
            $sql->leftJoin('gallery_shop', 'gs', 'g.`id_gallery` = gs.`id_gallery` AND gs.`id_shop` = ' . (int)$shop);
            $sql->where('gs.`id_shop` = ' . (int)$shop);
        }

        if ($active) {
            $sql->where('g.`active` = 1');
        }

        if($limit){
            $sql->limit($limit, $page);
            }

        $sql->orderBy('g.`id_gallery` ASC');
        $result = Db::getInstance()->executeS($sql);


        foreach ($result as &$gallery) {
            $gallery['id'] = $gallery['id_gallery'];
            $gallery['name'] = $gallery['title'];
            $gallery['description'] = $gallery['description_top'];
            $gallery['cover'] = _MODULE_DIR_ . 'gallerique/img/covers/cover_' . $gallery['id_gallery'] . '.jpg';
        }

        unset($gallery);
        return $result;
    }

    public function getImages($id_lang, $active = true, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        if (!Validate::isBool($active)) {
            die (Tools::displayError());
        }

        if ($active && ! $this->active) {
            die (Tools::displayError());
        }

        switch (Configuration::get('GALLERIQUE_SORTING_'.(int)$this->id)) {
            case '1':
                $sort = 'gi.`id_gallery_image`';
                break;
            case '2':
                $sort = 'gi.`id_gallery_image` DESC';
                break;
            case '3':
                $sort = 'gi.`date_add`';
                break;
            case '4':
                $sort = 'gi.`date_add` DESC';
                break;
            case '5':
                $sort = 'gi.`date_upd`';
                break;
            case '6':
                $sort = 'gi.`date_upd` DESC';
                break;
            case '8':
                $sort = 'gi.`position` DESC';
                break;
            case '7':            
            default:
                $sort = 'gi.`position`';
                break;
        }

        $sql = '
        SELECT
            gi.*,
            gil.`label`,
            gil.`description`,
            gil.`image_link`,
            gil.`alt`
        FROM
            `'._DB_PREFIX_.'gallery_image` gi
        LEFT JOIN
            `'._DB_PREFIX_.'gallery_image_lang` gil
        ON (
            gil.`id_gallery_image` = gi.`id_gallery_image`
            AND
            gil.`id_lang` = '.(int)$id_lang.'
        )
        WHERE
            gi.`id_gallery` = '.(int)$this->id.'
            '.($active ? ' AND gi.`active` = 1' : '').'
        ORDER BY
            '.$sort;

        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        if (!$result) {
            return false;
        }

        $prepared_result = array();

        $paths = GalleryImage::getGalleryPaths();

        foreach ($result as &$image) {
            $image_checked = true;

            foreach ($paths as $key => $data) {
                $img_name = false;

                switch ($key) {
                    case GalleryImage::SCALED:
                        $img_name = 'large';
                        break;
                    case GalleryImage::THUMBNAIL:
                        $img_name = 'thumb';
                        break;
                    case GalleryImage::ORIGINAL:
                        $img_name = 'original';
                        break;
                }

                if ($img_name) {
                    $not_cached_prefix = Configuration::get('GALLERIQUE_IMG_CACHE_'.$this->id) ? '?'.time() : '';
                    if (file_exists($data['abs'].$image['id_gallery_image'].'.jpg')) {
                        $image[$img_name] = $data['rel'].$image['id_gallery_image'].'.jpg' . $not_cached_prefix;
                    } elseif (file_exists($data['abs'].$image['id_gallery_image'].'.png')) {
                        $image[$img_name] = $data['rel'].$image['id_gallery_image'].'.png' . $not_cached_prefix;
                    } else {
                        $image_checked = false;
                    }
                }
            }

            if ($image_checked) {
                array_push($prepared_result, $image);
            }
        }

        return count($prepared_result) ? $prepared_result : false;
    }
    
    public function getSizes()
    {
        return array(
            'thumbnail' => array(
                'width' => Configuration::get('GALLERIQUE_T_WIDTH_'.$this->id),
                'height' => Configuration::get('GALLERIQUE_T_HEIGHT_'.$this->id)
            ),
            'large' => array(
                'width' => Configuration::get('GALLERIQUE_S_WIDTH_'.$this->id),
                'height' => Configuration::get('GALLERIQUE_S_HEIGHT_'.$this->id)
            )
        );
    }

    public function getSett()
    {
        return array(
            'show_label' => Configuration::get('GALLERIQUE_SHOW_IMAGE_LABELS_'.$this->id),
            'show_desc' => Configuration::get('GALLERIQUE_SHOW_IMAGE_DESC_'.$this->id),
            'max_label' => Configuration::get('GALLERIQUE_MAX_IMAGE_LABELS_'.$this->id),
            'max_desc' => Configuration::get('GALLERIQUE_MAX_IMAGE_DESC_'.$this->id),
            'buttons' => Configuration::get('GALLERIQUE_SB_ON_IMAGE_'.$this->id),
        );
    }
}
