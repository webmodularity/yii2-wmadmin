<?php

namespace wma\grid\data;

use Yii;
use wmu\models\User;
use yii\helpers\Html;

class UserStatusColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        User::STATUS_ACTIVE => 'text-success',
        User::STATUS_DELETED => 'text-danger',
        User::STATUS_NEW => 'txt-color-blueLight'
    ];

    public function init() {
        $this->filter = User::getUserStatusList();
        $this->value = function ($model, $key, $index, $column) {
            if (isset(static::$colorMap[$model->{$this->attribute}])) {
                $options = ['class' => static::$colorMap[$model->{$this->attribute}]];
                if ($model->{$this->attribute} == User::STATUS_NEW) {
                    $options['style'] = 'font-style: italic;';
                }
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
            if ($key == User::STATUS_NEW) {
                $options['style'] = 'font-style: italic;';
            }
            $allOptions[$key] = $options;
        }
        return $allOptions;
    }
}