<?php

namespace wma\grid\data;

use Yii;
use wmc\models\user\UserGroup;
use yii\helpers\Html;

class UserGroupColumn extends \wma\grid\DataColumnStyled
{
    public $format = 'raw';

    public static $colorMap = [
        UserGroup::USER => 'text-primary',
        UserGroup::AUTHOR => 'text-warning',
        UserGroup::ADMIN => 'txt-color-teal',
        UserGroup::SU => 'txt-color-pink'
    ];

    public function init() {
        $this->filter = UserGroup::getAccessibleGroupList(null, [UserGroup::GUEST]);
        $this->value = function ($model, $key, $index, $column) {
            if (isset(static::$colorMap[$model->{$this->attribute}])) {
                return Html::tag('span', $model->group->name, ['class' => static::$colorMap[$model->{$this->attribute}]]);
            } else {
                return $model->group->name;
            }
        };
        $this->filterInputOptions['options'] = static::getDropdownOptions();;
    }
}