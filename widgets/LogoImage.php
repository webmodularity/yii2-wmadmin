<?php

namespace wma\widgets;

use Yii;
use yii\helpers\Html;

class LogoImage extends \yii\base\Widget
{
    public function init() {
        parent::init();
        // Build functionality to detect/change logo
        // Currently returns assets/web/img/logo.png
    }

    public function run() {
        return Html::tag('span',' ' . Html::img(Yii::$app->adminAssetUrl.'/img/logo.png',['alt' => 'Web Modularity']) . ' ',['id' => 'logo']);
    }
}