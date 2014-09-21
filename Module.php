<?php

namespace app\modules\wmadmin;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\wmadmin\controllers';

    private $_assetPath = null;
    private $_assetUrl = null;

    public function init()
    {
        parent::init();
        \Yii::setAlias('wmadmin','@app/modules/wmadmin');
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
