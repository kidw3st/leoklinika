<?php

namespace app\components\base;

use app\helpers\base\BImages;
use Yii;

class Image {
    private $_image;
    
    public function __construct($image)
    {
        $this->_image = $image;
    }

    public function __toString()
    {
        return $this->_image;
    }

    public function doCrop($width, $height, $quality = 95) {
        return BImages::doCrop($this->_image, $width, $height, $quality);
    }

    public function doProp($width, $height, $quality = 95) {
        return BImages::doProp($this->_image, $width, $height, $quality);
    }

    public function doPropWhite($width, $height, $quality = 95) {
        return BImages::doPropW($this->_image, $width, $height, $quality);
    }

    public function getImage() {
        if (file_exists(Yii::getAlias('@app/web') . $this->_image) && !empty($this->_image)) {
            return $this->_image;
        }
        return '/up/no-image.png';
    }

    public function getIs_empty() {
        if (empty($this->_image)) return true;

        return false;
    }
}