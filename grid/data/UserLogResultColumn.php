<?php

namespace wma\grid\data;

use Yii;
use wmu\models\UserLog;
use wma\helpers\Html;

class UserLogResultColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        UserLog::RESULT_SUCCESS => 'text-success',
        UserLog::RESULT_FAIL => 'text-danger'
    ];

    public $filterOptions = [
        'style' => 'white-space: nowrap;width:80px;'
    ];

    public function init() {
        $this->enableSorting = false;
        $this->filter = UserLog::getResultList();
        $this->value = function ($model, $key, $index, $column) {
            if (isset(static::$colorMap[$model->{$this->attribute}])) {
                $options = ['class' => static::$colorMap[$model->{$this->attribute}]];
                return Html::tag('span', $this->filter[$model->{$this->attribute}], $options);
            } else {
                return $this->filter[$model->{$this->attribute}];
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