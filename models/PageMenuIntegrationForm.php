<?php

namespace wma\models;

use Yii;
use yii\base\Model;

class PageMenuIntegrationForm extends Model
{
    public $active;
    public $iconName;

    public function rules()
    {
        return [
            [['active'], 'required'],
            [['active'], 'boolean'],
            [['iconName'], 'string']
        ];
    }
}