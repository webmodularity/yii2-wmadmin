<?php

namespace wma\components;

use Yii;
use yii\helpers\ArrayHelper;

class Application extends \yii\web\Application
{

    private $_adminModuleId;

    public function preInit(&$config)
    {
        $wmadmin = ArrayHelper::remove($config, 'wmadmin');
        if (is_null($wmadmin)) {
            throw new InvalidConfigException('The "wmadmin" configuration for the Application is required.');
        }
        $this->_adminModuleId = isset($wmadmin['moduleOptions']['id'])
            ? ArrayHelper::remove($wmadmin['moduleOptions'], 'id')
            : 'admin';

        // Components
        if (!isset($config['components'])) {
            $config['components'] = [];
        }
        // Normalize allowCookies
        $enableAutoLogin = isset($wmadmin['userOptions']['allowCookies']) && is_bool($wmadmin['userOptions']['allowCookies'])
            ? $wmadmin['userOptions']['allowCookies']
            : false;
        // Normalize sessionDuration
        if ($enableAutoLogin === true) {
            $sessionDuration = isset($wmadmin['userOptions']['sessionDuration']) && is_int($wmadmin['userOptions']['sessionDuration'])
                ? $wmadmin['userOptions']['sessionDuration']
                : 60 * 60 * 24 * 30; // 1 month
        } else {
            $sessionDuration = isset($wmadmin['userOptions']['sessionDuration']) && is_int($wmadmin['userOptions']['sessionDuration'])
                ? $wmadmin['userOptions']['sessionDuration']
                : 60 * 60; // 1 hour
        }
        $wmadmin['userOptions']['sessionDuration'] = $sessionDuration;

        // user
        $config['components']['user'] = [
            'identityClass' => 'wma\models\User',
            'loginUrl' => ['/'  . $this->_adminModuleId . '/user/login'],
            'enableAutoLogin' => $enableAutoLogin,
        ];

        // session
        if ($enableAutoLogin === false) {
            $config['components']['session'] = isset($config['components']['session'])
                ? $config['components']['session']
                : [];
            $config['components']['session']['timeout'] = $sessionDuration;
        }

        // errorHandler
        $config['components']['errorHandler'] = isset($config['components']['errorHandler'])
            ? $config['components']['errorHandler']
            : [];
        $config['components']['errorHandler']['errorAction'] = '/' . $this->_adminModuleId . '/user/error';

        // configure module
        $moduleOptions = (isset($wmadmin['moduleOptions']))
            ? ArrayHelper::remove($wmadmin, 'moduleOptions')
            : [];
        $modulesMerge = [
            $this->_adminModuleId => ArrayHelper::merge(['class' => 'wma\Module'], $wmadmin)
        ];
        $config['modules'] = isset($config['modules'])
            ? ArrayHelper::merge($modulesMerge, $config['modules'])
            : $modulesMerge;

        $adminConfig = [
            'defaultRoute' => '/admin/dashboard/go',
        ];
        $config = ArrayHelper::merge($adminConfig, $config);
        parent::preInit($config);
    }

    public function getAdminModuleId() {
        return $this->_adminModuleId;
    }

    public function getAdminModule() {
        return Yii::$app->getModule($this->_adminModuleId);
    }
}