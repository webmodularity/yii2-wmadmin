<?php

namespace wma\widgets;

use Yii;

class FavIcon extends \yii\base\Widget
{
    protected $_favicon = null;

    public function init() {
        parent::init();
        // Build functionality to detect/change favicon.ico
        // Currently returns {adminAssetUrl}/img/favicon.ico
        $this->_favicon = Yii::$app->adminAssetUrl.'/img/favicon.ico';

        // Register FavIcon meta tags
        $this->view->registerLinkTag([
            'rel' => 'shortcut icon',
            'href' => $this->_favicon,
            'type' => 'image/x-icon'
        ]);
        $this->view->registerLinkTag([
            'rel' => 'icon',
            'href' => $this->_favicon,
            'type' => 'image/x-icon'
        ]);
    }
}