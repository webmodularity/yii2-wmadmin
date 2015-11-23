<?php

namespace wma\components;

use wmc\models\user\User;
use wmc\models\user\UserGroup;
use yii\base\InvalidConfigException;

class AdminSettings extends \yii\base\Component
{
    static $skinColors = [
        'blue', 'blue-light',
        'yellow', 'yellow-light',
        'green', 'green-light',
        'purple', 'purple-light',
        'red', 'red-light',
        'black', 'black-light'
    ];
    static $templateSections = [
        'layout', 'sidebar', 'header', 'footer'
    ];

    private $_template = [
        'skin' => null,
        'layout' => [
            'fixed' => false,
            'boxed' => false
        ],
        'header' => [
            'nav' => false,
            'messages' => false,
            'notifications' => false,
            'tasks' => false,
            'user' => true
        ],
        'sidebar' => [
            'collapsed' => false,
            'mini' => true,
            'user' => false,
            'search' => false
        ],
        'footer' => [
            'version' => true,
            'copyright' => [
                'name' => 'WebModularity',
                'link' => 'http://www.webmodularity.com',
                'date' => true
            ]
        ]
    ];
    private $_user = [
        'sessionDuration' => 14400,
        'register' => [
            'webRegistration' => false,
            'newUserStatus' => User::STATUS_NEW,
            'newUserRole' => UserGroup::USER,
            'confirmEmail' => true
        ]
    ];

    public function setAdminSettings($settings) {
        foreach ($settings as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * Set admin template options. Refer to $this->_template for options
     * @param $options array set template options via array config
     */

    public function setTemplate($options) {
        if (is_array($options)) {
            foreach ($options as $key => $val){
                if ($key == 'skin' && in_array($val, static::$skinColors)) {
                    $this->_template['skin'] = $val;
                } else if (in_array($key, static::$templateSections) && is_array($val)) {
                    foreach ($val as $altKey => $altVal) {
                        $this->_template[$key][$altKey] = $altVal;
                    }
                }
            }
        }
    }

    /**
     * Set admin user options. Refer to $this->_user for options.
     * @param $options array set template options via array config
     */

    public function setUser($options) {
        if (is_array($options)) {
            if (isset($options['register'])) {
                //register
                foreach ($options['register'] as $key => $val) {
                    if (
                        ($key == 'newUserStatus' && is_int($val)
                            && $val >=  User::STATUS_DELETED && $val <= User::STATUS_ACTIVE)
                        ||
                        ($key == 'newUserRole' && is_int($val)
                            && $val >= UserGroup::USER && $val <= UserGroup::SU)
                    ) {
                        $this->_user['register'][$key] = $val;
                    } else {
                        if (
                            ($key == 'webRegistration' || $key == 'confirmEmail')
                            && is_bool($val)
                        ) {
                            $this->_user['register'][$key] = $val;
                        }
                    }
                }
            }
        }
    }

    public function getOption($index) {
        $parts = explode('.', $index);
        $type = '_' . array_shift($parts);
        if (isset($this->$type)) {
            if (count($parts) > 0) {
                $property = $this->$type;
                while (count($parts) > 0) {
                    $val = array_shift($parts);
                    $property = $property[$val];
                }
                return $property;
            }
        }
        throw new InvalidConfigException('No property found at ' . $index . '.');
    }

}