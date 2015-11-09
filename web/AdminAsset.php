<?php
namespace wma\web;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * Based on Admin-LTE v2.x.x
 * @package wma\web
 */

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@wma/assets';
    public $css = [
        'css/smartadmin-production-plugins.min.css',
        'css/smartadmin-production.min.css',
        'css/smartadmin-skins.min.css',
        'css/your_style.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700'
    ];
    public $js = [
        'js/wm/jquery.redirect.js',
        'js/wm/wma.delete-confirm.js',
        'js/app.config.js',
        'js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        'js/notification/SmartNotification.min.js',
        'js/smartwidgets/jarvis.widget.min.js',
        "js/plugin/bootstrap-slider/bootstrap-slider.min.js",
        'js/plugin/msie-fix/jquery.mb.browser.min.js',
        'js/plugin/fastclick/fastclick.min.js',
        'js/app.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
