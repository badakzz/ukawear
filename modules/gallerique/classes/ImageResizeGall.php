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

class ImageResizeGall
{
    private $image;
    private $width;
    private $height;
    private $imageResized;

    public function __construct($fileName, $extension = false)
    {
        $this->image = $this->openImage($fileName, $extension);

        if (!$this->image) {
            die(Tools::displayError('Unable to open this image'));
        }

        $this->width  = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function openImage($file, $forced_extension = false)
    {
        $extension = $forced_extension ? $forced_extension : Tools::strtolower(Tools::substr(strrchr($file, '.'), 1));

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $img = @imagecreatefromjpeg($file);
                break;
            case 'gif':
                $img = @imagecreatefromgif($file);
                break;
            case 'png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }

        return $img;
    }

    public function resizeImage($new_width, $new_height, $file_type, $option = 'auto')
    {
        $option_array = $this->getDimensions($new_width, $new_height, $option);

        $optimal_width  = $option_array['optimalWidth'];
        $optimal_height = $option_array['optimalHeight'];

        $this->imageResized = imagecreatetruecolor($optimal_width, $optimal_height);

        if ($file_type == 'png') {
            $this->forPng($optimal_width, $optimal_height);
        }

        imagecopyresampled(
            $this->imageResized,
            $this->image,
            0,
            0,
            0,
            0,
            $optimal_width,
            $optimal_height,
            $this->width,
            $this->height
        );

        if ($option == 'crop') {
            $this->crop($optimal_width, $optimal_height, $new_width, $new_height, $file_type);
        }

    }

    private function getDimensions($new_width, $new_height, $option)
    {
        switch ($option) {
            case 'exact':
                $optimal_width = $new_width;
                $optimal_height = $new_height;
                break;
            case 'portrait':
                $optimal_width = $this->getSizeByFixedHeight($new_height);
                $optimal_height = $new_height;
                break;
            case 'landscape':
                $optimal_width = $new_width;
                $optimal_height = $this->getSizeByFixedWidth($new_width);
                break;
            case 'auto':
                $option_array = $this->getSizeByAuto($new_width, $new_height);
                $optimal_width = $option_array['optimalWidth'];
                $optimal_height = $option_array['optimalHeight'];
                break;
            case 'crop':
                $option_array = $this->getOptimalCrop($new_width, $new_height);
                $optimal_width = $option_array['optimalWidth'];
                $optimal_height = $option_array['optimalHeight'];
                break;
        }

        return array('optimalWidth' => $optimal_width, 'optimalHeight' => $optimal_height);
    }

    private function getSizeByFixedHeight($new_height)
    {
        $ratio = $this->width / $this->height;
        $new_width = $new_height * $ratio;

        return $new_width;
    }

    private function getSizeByFixedWidth($new_width)
    {
        $ratio = $this->height / $this->width;
        $new_height = $new_width * $ratio;

        return $new_height;
    }

    private function getSizeByAuto($new_width, $new_height)
    {
        if ($this->height < $this->width) {
            $optimal_width = $new_width;
            $optimal_height = $this->getSizeByFixedWidth($new_width);
        } elseif ($this->height > $this->width) {
            $optimal_width = $this->getSizeByFixedHeight($new_height);
            $optimal_height = $new_height;
        } else {
            if ($new_height < $new_width) {
                $optimal_width = $new_width;
                $optimal_height = $this->getSizeByFixedWidth($new_width);
            } elseif ($new_height > $new_width) {
                $optimal_width = $this->getSizeByFixedHeight($new_height);
                $optimal_height = $new_height;
            } else {
                $optimal_width = $new_width;
                $optimal_height = $new_height;
            }
        }

        return array('optimalWidth' => $optimal_width, 'optimalHeight' => $optimal_height);
    }

    private function getOptimalCrop($new_width, $new_height)
    {
        $height_ratio = $this->height / $new_height;
        $width_ratio  = $this->width / $new_width;

        if ($height_ratio < $width_ratio) {
            $optimal_ratio = $height_ratio;
        } else {
            $optimal_ratio = $width_ratio;
        }

        $optimal_height = $this->height / $optimal_ratio;
        $optimal_width  = $this->width / $optimal_ratio;

        return array('optimalWidth' => $optimal_width, 'optimalHeight' => $optimal_height);
    }

    private function crop($optimal_width, $optimal_height, $new_width, $new_height, $file_type)
    {
        $crop_start_x = ($optimal_width / 2) - ($new_width / 2);
        $crop_start_y = ($optimal_height / 2) - ($new_height / 2);

        $crop = $this->imageResized;

        $this->imageResized = imagecreatetruecolor($new_width, $new_height);
        if ($file_type == 'png') {
            $this->forPng($new_width, $new_height);
        }

        imagecopyresampled(
            $this->imageResized,
            $crop,
            0,
            0,
            $crop_start_x,
            $crop_start_y,
            $new_width,
            $new_height,
            $new_width,
            $new_height
        );
    }

    public function saveImage($save_path, $image_quality = '100')
    {
            $extension = strrchr($save_path, '.');
            $extension = Tools::strtolower($extension);

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $save_path, $image_quality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $save_path);
                }
                break;

            case '.png':
                $save_path = str_replace('.png', '.jpg', $save_path);
                $scale_quality = round(($image_quality / 100) * 9);

                $invert_scale_quality = 9 - $scale_quality;

                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $save_path, $invert_scale_quality);
                }
                break;

            default:
                break;
        }

        imagedestroy($this->imageResized);
    }

    private function forPng($width, $height)
    {
        imagealphablending($this->imageResized, false);
        imagesavealpha($this->imageResized, true);
        $transparent = imagecolorallocatealpha($this->imageResized, 255, 255, 255, 127);
        imagefilledrectangle($this->imageResized, 0, 0, $width, $height, $transparent);
    }
}
