<?php
namespace wma\web;

use Yii;
use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * Based on Admin-LTE v2.x.x
 * @package wma\web
 */

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $css = ['css/AdminLTE.min.css'];
    public $js = ['js/app.min.js'];
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    public function init() {
        $skin = Yii::$app->adminSettings->getOption('template.skin')
            ? 'skin-' . Yii::$app->adminSettings->getOption('template.skin')
            : '_all-skins';
        if ($skin) {
            $this->css[] = sprintf('css/skins/%s.min.css', $skin);
        }
        parent::init();
    }
}
