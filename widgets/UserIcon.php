<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class UserIcon extends \yii\base\Widget
{
    public $htmlOptions = [];

    protected $_iconSource = 'gravatar';
    protected $_size = null;

    public function setSize($size) {
        if (is_int($size) && $size >= 1 && $size <= 2048 && $size != 80) {
            $this->_size = $size;
        }
    }

    public function run() {
        if ($this->_iconSource == 'gravatar') {
            $size = is_null($this->_size) ? 'd=mm' : '?d=mm&s=' . $this->_size;
            $src = 'https://www.gravatar.com/avatar/' . md5(strtolower(Yii::$app->user->identity->email)) . $size;
            return Html::img($src, $this->htmlOptions);
        }
    }
}