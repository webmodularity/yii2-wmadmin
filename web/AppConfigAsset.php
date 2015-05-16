<?php
namespace wma\web;

use yii\web\AssetBundle;

/**
 * Class AppConfigAsset
 * Used to place app.config.js before bootstrap JS
 * Based on SmartAdmin v1.5.2
 * @package wma\web
 */

class AppConfigAsset extends AssetBundle
{
    public $sourcePath = '@wma/assets';

    public $js = [

    ];
}