<?php

namespace wma\components;

use wmc\models\user\UserLog;
use yii\helpers\ArrayHelper;

class Formatter extends \wmc\components\Formatter
{

    public function asUserLogAction($actionId) {
        return ArrayHelper::getValue(UserLog::getActionList(), $actionId, "Unknown");
    }

    public function asUserLogApp($appId) {
        return ArrayHelper::getValue(UserLog::getAppList(), $appId, "Unknown");
    }

    public function asUserLogResult($resultId) {
        return ArrayHelper::getValue(UserLog::getResultList(), $resultId, "Unknown");
    }
}