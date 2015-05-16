<?php

namespace wma\widgets;

use Yii;
use rmrevin\yii\fontawesome\FA;

class UserIcon extends \yii\base\Widget
{
    protected $_iconSource = 'gravatar';
    protected $_size = null;

    public function setSize($size) {
        if (is_int($size) && $size >= 1 && $size <= 2048 && $size != 80) {
            $this->_size = $size;
        }
    }

    public function run() {
        if ($this->_iconSource == 'gravatar') {
            $gravatarHash = md5(strtolower(Yii::$app->user->identity->person->email));
            $source = 'https://www.gravatar.com/avatar/' . $gravatarHash;
            return is_null($this->_size) ? $source : $source . '?s=' . $this->_size;
        }
    }
}