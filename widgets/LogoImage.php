<?php

namespace wma\widgets;

use yii\base\Widget;
use wmc\helpers\Html;

class LogoImage extends Widget
{
    public function init() {
        parent::init();
        // Build functionality to detect/change logo
        // Currently returns assets/web/img/logo.png
    }

    public function run() {
        return Html::tag('span',' ' . Html::img(\wma\Module::getInstance()->assetUrl.'/img/logo.png',['alt' => 'Web Modularity']) . ' ',['id' => 'logo']);
    }
}