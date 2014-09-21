<?php

namespace wmadmin;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'wmadmin\controllers';

    private $_assetPath = null;
    private $_assetUrl = null;

    public function init()
    {
        parent::init();
        $asset = \Yii::$app->assetManager->publish('@wmadmin/assets/web',['forceCopy' => false]);
        $this->_assetPath = $asset[0];
        $this->_assetUrl = $asset[1];
    }

    public function getAssetPath() {
        return $this->_assetPath;
    }

    public function getAssetUrl() {
        return $this->_assetUrl;
    }
}
