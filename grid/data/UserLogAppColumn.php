<?php

namespace wma\grid\data;

use Yii;
use wmc\models\user\UserLog;
use yii\helpers\Html;

class UserLogAppColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        UserLog::APP_CONSOLE => 'txt-color-blueLight',
        UserLog::APP_FRONTEND => 'text-primary',
        UserLog::APP_BACKEND => 'text-success'
    ];

    public $filterOptions = [
        'style' => 'white-space: nowrap;width:65px;'
    ];

    public function init() {
        $this->enableSorting = false;
        $this->filter = UserLog::getAppList();
        $this->value = function ($model, $key, $index, $column) {
            if (isset(static::$colorMap[$model->{$this->attribute}])) {
                $options = ['class' => static::$colorMap[$model->{$this->attribute}]];
                return Html::tag('span', $this->filter[$model->{$this->attribute}], $options);
            } else {
                return $model->{$this->attribute};
            }
        };
        $this->filterInputOptions['options'] = static::getDropdownOptions();
    }

    public static function getDropdownOptions() {
        $allOptions = [];
        foreach (static::$colorMap as $key => $color) {
            $options = ['class' => $color];
            $allOptions[$key] = $options;
        }
        return $allOptions;
    }
}