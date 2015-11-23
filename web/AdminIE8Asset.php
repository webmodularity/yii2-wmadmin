<?php
namespace wma\web;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * Based on Admin-LTE v2.x.x
 * @package wma\web
 */

class AdminIE8Asset extends AssetBundle
{
    public $sourcePath = null;
    public $jsOptions = ['condition' => 'lt IE 9'];
    public $js = ['https://cdn.jsdelivr.net/g/html5shiv@3.7.3,respond@1.4.2'];
    public $depends = ['yii\web\JqueryAsset'];
}