<?php

namespace wma\grid\data;

use Yii;
use wmc\models\user\UserLog;
use yii\helpers\Html;

class UserLogActionColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        UserLog::ACTION_LOGIN => 'txt-color-greenLight',
        UserLog::ACTION_LOGOUT => 'txt-color-blueDark'
    ];

    public $filterOptions = [
        'style' => 'white-space: nowrap;width:100px;'
    ];

    public function init() {
        $this->enableSorting = false;
        $this->filter = UserLog::getActionList();
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