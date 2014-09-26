<?php

namespace wmadmin;

use yii\helpers\Html;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'wmadmin\controllers';

    private $_assetPath = null;
    private $_assetUrl = null;
    private $_templateOptions = [
        'theme' => 'default',
        'navStyle' => 'default',
        'fixed-layout' => 'none',
        'fixed-footer' => false,
        'fixed-width' => false

    ];

    public $tooltipIconDefaultColor = 'txt-color-teal';

    /**
     * Publish assets directory and handle module init
     * @return null
     */

    public function init()
    {
        parent::init();
        $asset = \Yii::$app->assetManager->publish('@wmadmin/assets/web',['forceCopy' => false]);
        $this->_assetPath = $asset[0];
        $this->_assetUrl = $asset[1];
    }

    /**
     * Returns file path of published wmadmin/assets/web directory
     * @return string admin assets file path
     */

    public function getAssetPath() {
        return $this->_assetPath;
    }

    /**
     * Returns URL of published wmadmin/assets/web directory
     * @return string admin assets URL
     */

    public function getAssetUrl() {
        return $this->_assetUrl;
    }

    /**
     * Set admin template options. Reference SmartAdmin documentation for behaviors.
     * The fixed-footer,and fixed-width booleans can be combined though the fixed-width toggle
     * does not work with the 'header+nav' or 'header+nav+ribbon' fixed-layout options.
     * options array[
     *  'theme' => (default|dark-elegance|ultra-white|google),
     *  'navStyle' => (default|minified|hidden|top),
     *  'fixed-layout' => (none|header|header+nav|header+nav+ribbon)
     *  'fixed-width' => bool (defaults to false),
     *  'fixed-footer' => bool (defaults to false),
     *
     * ]
     * @param $options array set template options via array config
     */

    public function setTemplateOptions($options) {
        if (is_array($options)) {
            foreach ($options as $key => $val){
                if (   ($key == 'theme' && in_array($val,['dark-elegance','ultra-white','google']))
                    || ($key == 'navStyle' && in_array($val,['minified','hidden','top']))
                    || ($key == 'fixed-layout' && in_array($val,['header','header+nav','header+nav+ribbon']))
                ) {
                    $this->_templateOptions[$key] = $val;
                } else if (($key == 'fixed-footer' || $key == 'fixed-width') && is_bool($val)) {
                    $this->_templateOptions[$key] = (bool) $val;
                }
            }
            // Ensure fixed-layout != header+nav or header+nav+ribbon if fixed-width is true
            if (    $this->_templateOptions['fixed-width'] === true
                && ($this->_templateOptions['fixed-layout'] == 'header+nav'
                || $this->_templateOptions['fixed-layout'] == 'header+nav')
            ) {
                $this->_templateOptions['fixed-layout'] = 'none';
            }
        }
    }

    /**
     * @return array template options
     */

    public function getTemplateOptions() {
        return $this->_templateOptions;
    }
}
