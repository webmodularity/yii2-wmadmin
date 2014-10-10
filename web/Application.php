<?php

namespace wma\web;

use Yii;
use wmc\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class Application extends \yii\web\Application
{
    private $_adminAssetPath;
    private $_adminAssetUrl;

    public function preInit(&$config) {
        $adminSettings = ArrayHelper::remove($config, 'adminSettings');
        if (is_null($adminSettings)) {
            throw new InvalidConfigException('The WMAdmin Application requires a configuration key
             named adminSettings.');
        }

        // Components
<<<<<<< HEAD
        $config['components'] = !isset($config['components']) ? $config['components'] : [];
=======
        $config['componets'] = !isset($config['components']) ? $config['components'] : [];
>>>>>>> 979b5798df257154b1b3fede1abc781cbabc9294
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

        // user
        $config['components']['user'] = [
            'identityClass' => 'wmc\models\User',
            'loginUrl' => ['/user/login'],
            'enableAutoLogin' => $enableAutoLogin,
        ];

        // session
        if ($enableAutoLogin === false) {
            $config['components']['session'] = isset($config['components']['session'])
                ? $config['components']['session']
                : [];
            $config['components']['session']['timeout'] = $sessionDuration;
        }

        // AlertManager
        $config['components']['alertManager'] = [
            'class' => 'wmc\web\AlertManager',
            'alertClass' => 'wma\widgets\Alert'
        ];

        // AdminSettings
        $config['components']['adminSettings'] = [
            'class' => 'wma\components\AdminSettings',
            'adminSettings' => $adminSettings
        ];

        // Formatter
        $config['components']['formatter'] = [
            'class' => 'wmc\components\Formatter'
        ];

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
        $asset = Yii::$app->assetManager->publish('@wma/assets',['forceCopy' => false]);
        $this->_adminAssetPath = $asset[0];
        $this->_adminAssetUrl = $asset[1];

        // DI
        Yii::$container->set('yii\behaviors\TimestampBehavior', ['value' => new \yii\db\Expression('NOW()')]);

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