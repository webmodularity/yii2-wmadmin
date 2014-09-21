<?php
namespace app\modules\wmadmin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/wmadmin/assets/web';
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/smartadmin-production.min.css',
        'css/smartadmin-skins.min.css',
        'css/wm_style.css',
        'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700',


    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
