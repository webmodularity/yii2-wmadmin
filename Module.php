<?php

namespace wma;

use wmc\helpers\Html;
use wma\models\User;
use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'wma\controllers';

    private $_assetPath = null;
    private $_assetUrl = null;
    private $_templateOptions = [
        'theme' => 'default',
        'navStyle' => 'default',
        'fixedLayout' => 'none',
        'fixedFooter' => false,
        'fixedWidth' => false
    ];
    private $_userOptions = [
        'allowCookies' => null, // default defined in wma\components\Application
        'sessionDuration' => null, // default defined in wma\components\Application
        'register' => [
            'webRegistration' => false,
            'newUserStatus' => User::STATUS_NEW,
            'newUserRole' => User::ROLE_USER,
            'confirmationEmail' => false
        ]
    ];

    /**
     * Publish assets directory and handle module init
     * @return null
     */

    public function init()
    {
        $asset = \Yii::$app->assetManager->publish('@wma/assets/web',['forceCopy' => false]);
        $this->_assetPath = $asset[0];
        $this->_assetUrl = $asset[1];
        parent::init();
    }

    /**
     * Returns file path of published admin/assets/web directory
     * @return string admin assets file path
     */

    public function getAssetPath() {
        return $this->_assetPath;
    }

    /**
     * Returns URL of published admin/assets/web directory
     * @return string admin assets URL
     */

    public function getAssetUrl() {
        return $this->_assetUrl;
    }

    /**
     * Set admin template options. Reference SmartAdmin documentation for behaviors.
     * The fixedFooter,and fixedWidth booleans can be combined though the fixedWidth toggle
     * does not work with the 'header+nav' or 'header+nav+ribbon' fixedLayout options.
     * options array[
     *  'theme' => (default|dark-elegance|ultra-white|google),
     *  'navStyle' => (default|minified|hidden|top),
     *  'fixedLayout' => (none|header|header+nav|header+nav+ribbon)
     *  'fixedWidth' => bool (defaults to false),
     *  'fixedFooter' => bool (defaults to false),
     *
     * ]
     * @param $options array set template options via array config
     */

    public function setTemplateOptions($options) {
        if (is_array($options)) {
            foreach ($options as $key => $val){
                if (   ($key == 'theme' && in_array($val,['dark-elegance','ultra-white','google']))
                    || ($key == 'navStyle' && in_array($val,['minified','hidden','top']))
                    || ($key == 'fixedLayout' && in_array($val,['header','header+nav','header+nav+ribbon']))
                ) {
                    $this->_templateOptions[$key] = $val;
                } else if (($key == 'fixedFooter' || $key == 'fixedWidth') && is_bool($val)) {
                    $this->_templateOptions[$key] = $val;
                }
            }
            // Ensure fixed-layout != header+nav or header+nav+ribbon if fixed-width is true
            if (    $this->_templateOptions['fixedWidth'] === true
                && ($this->_templateOptions['fixedLayout'] == 'header+nav'
                || $this->_templateOptions['fixedLayout'] == 'header+nav')
            ) {
                $this->_templateOptions['fixedLayout'] = 'none';
            }
        }
    }

    /**
     * Set admin user options.
     * options [
     *  'allowCookies' => bool (default set in wma\components\Application),
     *  'sessionDuration' => int (seconds) (default *varies based on allowCookies* set in wma\components\Application),
     *  'register' => [
     *      'webRegistration' -> bool (allow new admin users via web registration form),
     *      'confirmationEmail' => bool (send account confirmation email to change status from new to active)
     *                             Only applies when webRegistration is set to true,
     *      'newUserStatus' => int (-1:Deleted|0:New|1:Active),
     *      'newUserRole' => int (1:User->255:SuperAdmin),
     *   ]
     * ]
     * @param $options array set template options via array config
     */

    public function setUserOptions($options) {
        if (is_array($options)) {
            if (isset($options['register'])) {
                //register
                foreach ($options['register'] as $key => $val) {
                    if (($key == 'newUserStatus'
                            && filter_var(
                                $val,
                                FILTER_VALIDATE_INT,
                                ["min_range" => User::STATUS_DELETED, "max_range" => User::STATUS_ACTIVE]
                            )
                        )
                        || ($key == 'newUserRole'
                            && filter_var(
                                $val,
                                FILTER_VALIDATE_INT,
                                ["min_range" => User::ROLE_USER, "max_range" => User::ROLE_SUPERADMIN]
                            )
                        )

                    ) {
                        $this->_userOptions['register'][$key] = $val;
                    } else {
                        if (
                            ($key == 'webRegistration' || $key == 'confirmationEmail')
                            && is_bool($val)
                        ) {
                            $this->_userOptions['register'][$key] = $val;
                        }
                    }
                }
            }
        }
    }

    public function getOption($type, $key) {
        if ($type == 'userRegister') {
            $option = $this->_userOptions['register'][$key];
        } else {
            $var = '_' . $type . 'Options';
            $option = isset($this->{$var}[$key]) ? $this->{$var}[$key] : null;
        }
        return $option;
    }
}
