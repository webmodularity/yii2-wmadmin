<?php

namespace wmadmin\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class LogoImage extends Widget
{
    public function init() {
        parent::init();
        // Build functionality to detect/change logo
        // Currently returns assets/web/img/logo.png
    }

    public function run() {
        return Html::tag('span',' ' . Html::img(\Yii::$app->getModule('wmadmin')->assetUrl.'/img/logo.png',['alt' => 'Web Modularity']) . ' ',['id' => 'logo']);
    }
}