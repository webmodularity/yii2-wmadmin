<?php

namespace wma\widgets;

use rmrevin\yii\fontawesome\FA;
use Yii;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public function init() {
        if ($this->homeLink === null) {
            $this->homeLink = [
                'label' => FA::icon('home')  . 'Home',
                'url' => Yii::$app->homeUrl,
                'encode' => false
            ];
        }
        parent::init();
    }
}