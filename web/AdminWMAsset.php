<?php

namespace wma\web;

use Yii;
use yii\web\AssetBundle;

class AdminWMAsset extends AssetBundle
{
    public $sourcePath = '@wma/web/asset';
    public $css = ['css/wm-style.css'];
    //public $js = ['js/app.min.js'];
    public $depends = [
        'wma\web\AdminAsset'
    ];
}
