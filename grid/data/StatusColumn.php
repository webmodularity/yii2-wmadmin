<?php

namespace wma\grid\data;

use Yii;
use yii\helpers\Html;

class StatusColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        1 => 'text-success',
        0 => 'text-danger'
    ];

    protected $_statusList = [
        0 => 'Disabled',
        1 => 'Active'
    ];

    public function init() {
        $this->filter = $this->_statusList;
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
}