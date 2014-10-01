<?php

namespace wma\components;

use yii\helpers\ArrayHelper;

class Application extends \yii\web\Application
{

    private $_wmadminModuleId;

    public function preInit(&$config)
    {
        $wmadmin = ArrayHelper::remove($config, 'wmadmin');
        if (is_null($wmadmin)) {
            throw new InvalidConfigException('The "wmadmin" configuration for the Application is required.');
        }
        $this->_wmadminModuleId = isset($wmadmin['module_id']) ? ArrayHelper::remove($wmadmin, 'module_id') : 'admin';
        $modulesMerge = [
            $this->_wmadminModuleId => ArrayHelper::merge(['class' => 'wma\Module'], $wmadmin)
        ];
        $config['modules'] = isset($config['modules']) ? ArrayHelper::merge($modulesMerge, $config['modules']) : $modulesMerge;
        $adminConfig = [
            'defaultRoute' => '/admin/dashboard/go',
        ];
        $config = ArrayHelper::merge($adminConfig, $config);
        parent::preInit($config);
    }

}