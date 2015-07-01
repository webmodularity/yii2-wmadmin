<?php

namespace wma\web;

use Yii;
use wmc\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class Application extends \yii\web\Application
{
    private $_adminAssetPath;
    private $_adminAssetUrl;
    private $_requiredParams = [
        'siteName',
        'adminEmail',
        'noReplyEmail'
    ];

    public function preInit(&$config) {
        $adminSettings = ArrayHelper::remove($config, 'adminSettings');
        if (is_null($adminSettings)) {
            throw new InvalidConfigException('The WMAdmin Application requires a configuration key
             named adminSettings.');
        }
        // Require params
        foreach ($this->_requiredParams as $requiredParam) {
            if (!isset($config['params'][$requiredParam])) {
                throw new InvalidConfigException('The ' . $requiredParam . ' parameter is required for WMAdmin.');
            }
        }
        // Controller Map
        $adminControllerMap = [
            'user' => 'wma\controllers\UserController',
            'user-admin' => 'wma\controllers\UserAdminController',
            'dashboard' => 'wma\controllers\DashboardController',
            'menu' => 'wma\controllers\MenuController',
            'log' => 'wma\controllers\LogController'
        ];
        $config['controllerMap'] = isset($config['controllerMap']) ? ArrayHelper::merge($adminControllerMap, $config['controllerMap']) : $adminControllerMap;


        // Components
        $config['components'] = isset($config['components']) ? $config['components'] : [];
        // Normalize enableAutoLogin
        $enableAutoLogin = isset($adminSettings['user']['enableAutoLogin'])
        && $adminSettings['user']['enableAutoLogin'] === true
            ? true
            : false;
        // Normalize sessionDuration
        if ($enableAutoLogin === true) {
            $sessionDuration = isset($adminSettings['user']['sessionDuration'])
            && is_int($adminSettings['user']['sessionDuration'])
                ? $adminSettings['user']['sessionDuration']
                : 60 * 60 * 24 * 30; // 1 month
        } else {
            $sessionDuration = isset($adminSettings['user']['sessionDuration'])
            && is_int($adminSettings['user']['sessionDuration'])
                ? $adminSettings['user']['sessionDuration']
                : 60 * 60 * 4; // 4 hours
        }
        $adminSettings['user']['sessionDuration'] = $sessionDuration;

        // bootstrap
        $bootstrap = ['log'];
        $config['bootstrap'] = isset($config['bootstrap'])
            ? ArrayHelper::merge($bootstrap, $config['bootstrap'])
            : $bootstrap;

        // user
        $config['components']['user'] = [
            'identityClass' => 'wmu\models\User',
            'loginUrl' => ['/user/login'],
            'enableAutoLogin' => $enableAutoLogin,
        ];

        // rbac
        $config['components']['authManager'] = [
            'class' => 'wmu\rbac\DbManager',
            'defaultRoles' => ['su', 'admin', 'author', 'user'],
        ];

        // session
        $config['components']['session'] = isset($config['components']['session'])
            ? $config['components']['session']
            : [];
        $config['components']['session']['class'] = 'yii\web\DbSession';
        if ($enableAutoLogin === false) {
            $config['components']['session']['timeout'] = $sessionDuration;
        }

        // AlertManager
        $config['components']['alertManager'] = [
            'class' => 'wmc\web\AlertManager'
        ];

        // AdminSettings
        $config['components']['adminSettings'] = [
            'class' => 'wma\components\AdminSettings',
            'adminSettings' => $adminSettings
        ];

        // Formatter
        $config['components']['formatter'] = [
            'class' => 'wma\components\Formatter',
            'nullDisplay' => '<em>NULL</em>'
        ];

        // urlManager
        $config['components']['urlManager'] = isset($config['components']['urlManager'])
            ? $config['components']['urlManager']
            : [];
        $config['components']['urlManager']['class'] = 'wma\web\UrlManager';

        // Log
        $config['components']['log'] = isset($config['components']['log'])
            ? $config['components']['log']
            : [];
        $config['components']['log']['traceLevel'] = YII_DEBUG ? 3 : 0;
        $logTargets = isset($config['components']['log']['targets']) ? $config['components']['log']['targets'] : [];
        $logTargets[] = [
            'class' => 'yii\log\DbTarget',
            'levels' => ['error', 'warning'],
        ];
        $config['components']['log']['targets'] = $logTargets;

        // Asset Manager - Link Assets
        $config['components']['assetManager']['linkAssets'] = isset($config['components']['assetManager']['linkAssets'])
            ? $config['components']['assetManager']['linkAssets']
            : true;

        // errorHandler
        $config['components']['errorHandler'] = isset($config['components']['errorHandler'])
            ? $config['components']['errorHandler']
            : [];
        $config['components']['errorHandler']['errorAction'] = '/user/error';

        $adminConfig = [
            'defaultRoute' => '/dashboard/go',
        ];
        $config = ArrayHelper::merge($adminConfig, $config);
        parent::preInit($config);
    }

    public function init() {
        parent::init();
        $asset = Yii::$app->assetManager->publish('@wma/assets',['forceCopy' => false]);
        $this->_adminAssetPath = $asset[0];
        $this->_adminAssetUrl = $asset[1];

        // DI
        Yii::$container->set('yii\behaviors\TimestampBehavior', ['value' => new \yii\db\Expression('NOW()')]);
        Yii::$container->set('wmu\models\LoginForm', ['sessionDuration' => Yii::$app->adminSettings->getOption('user.sessionDuration')]);
        Yii::$container->set('wmc\swiftmailer\Mailer', ['htmlLayout' => '@wma/mail/layouts/html']);
        Yii::$container->set('yii\bootstrap\BootstrapAsset', ['css' => ['css/bootstrap.min.css'], 'sourcePath' => '@wma/assets']);
    }

    /**
     * Returns file path of published admin/assets/web directory
     * @return string admin assets file path
     */

    public function getAdminAssetPath() {
        return $this->_adminAssetPath;
    }

    /**
     * Returns URL of published admin/assets/web directory
     * @return string admin assets URL
     */

    public function getAdminAssetUrl() {
        return $this->_adminAssetUrl;
    }
}