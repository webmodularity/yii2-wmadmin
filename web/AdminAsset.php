<?php
namespace wma\web;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * Based on SmartAdmin v1.5.2
 * @package wma\web
 */

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@wma/assets';
    public $css = [
        'css/bootstrap.min.css',
        'css/smartadmin-production-plugins.min.css',
        'css/smartadmin-production.min.css',
        'css/smartadmin-skins.min.css',
        'css/your_style.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700'
    ];
    public $js = [
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
        'js/app.config.js',
        'js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        'js/bootstrap/bootstrap.min.js',
        'js/notification/SmartNotification.min.js',
        'js/smartwidgets/jarvis.widget.min.js',
        "js/plugin/bootstrap-slider/bootstrap-slider.min.js",
        'js/plugin/msie-fix/jquery.mb.browser.min.js',
        'js/plugin/fastclick/fastclick.min.js',
        'js/app.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
