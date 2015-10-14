<?php

namespace wma\web;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;

class Application extends \yii\web\Application
{
    private $_adminAssetPath;
    private $_adminAssetUrl;
    private $_requiredParams = [
        'siteName',
        'adminEmail',
        'noReplyEmail'
    ];

    protected $_urlRules = [
        'user/confirm/<key:.{32}>' => 'user/confirm',
        'file/<filename>' => 'site/file',
        'file/<pathAlias:[a-zA-Z0-9\-\_]+>/<filename>' => 'site/file'
    ];

    public function preInit(&$config) {
        Yii::$classMap['yii\helpers\Html'] = '@wma/helpers/Html.php';
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
            'log-backend' => 'wma\controllers\LogBackendController',
            'log-frontend' => 'wma\controllers\LogFrontendController',
            'site' => 'wma\controllers\SiteController',
            'page' => 'wma\controllers\PageController'
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
            'identityClass' => 'wmc\models\user\User',
            'loginUrl' => ['/user/login'],
            'enableAutoLogin' => $enableAutoLogin,
        ];

        // rbac
        $config['components']['authManager'] = [
            'class' => 'wmc\rbac\DbManager',
            'defaultRoles' => ['su', 'admin', 'author', 'user', 'guest'],
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
        $config['components']['urlManager'] = isset($config['components']['urlManager']) ? $config['components']['urlManager'] : [];
        $urlRules = isset($config['components']['urlManager']['rules']) ? $config['components']['urlManager']['rules'] : [];
        $config['components']['urlManager']['rules'] = ArrayHelper::merge($this->_urlRules, $urlRules);
        $config['components']['urlManager'] = ArrayHelper::merge($config['components']['urlManager'],
            ['enablePrettyUrl' => true, 'showScriptName' => false]);

        // urlManagerFrontend
        $config['components']['urlManagerFrontend'] = isset($config['components']['urlManagerFrontend'])
            ? $config['components']['urlManagerFrontend']
            : [];
        if (empty($config['components']['urlManagerFrontend'])) {
            $frontendUrlConfig = [
                'class' => 'yii\web\urlManager',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'rules' => [
                    'file/<filename>' => 'site/file',
                    'file/<pathAlias:[a-zA-Z0-9\-\_]+>/<filename>' => 'site/file',
                    'page/<name:.+>' => 'site/page',
                ],
            ];
            $serverName = $_SERVER['SERVER_NAME'];
            if (preg_match('/^admin\.(.+)$/', $serverName, $hostMatch)) {
                $prefix = YII_ENV_DEV ? 'http://' : 'http://www.';
                $frontendUrlConfig['baseUrl'] = $prefix . $hostMatch[1];
            }
            $config['components']['urlManagerFrontend'] = $frontendUrlConfig;
        }


        // Log
        $config['components']['log'] = isset($config['components']['log'])
            ? $config['components']['log']
            : [];
        $config['components']['log']['traceLevel'] = YII_DEBUG ? 3 : 0;
        $logTargets = isset($config['components']['log']['targets']) ? $config['components']['log']['targets'] : [];
        $logTargets[] = [
            'class' => 'yii\log\DbTarget',
            'levels' => ['error', 'warning'],
            'logTable' => 'log_backend'
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
        Yii::$container->set('wmc\models\user\LoginForm', ['sessionDuration' => Yii::$app->adminSettings->getOption('user.sessionDuration')]);
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