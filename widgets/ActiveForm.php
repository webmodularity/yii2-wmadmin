<?php

namespace wma\widgets;

use Yii;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $options = [
        'role' => 'form',
        'class' => 'smart-form'
    ];
    public $requiredCssClass = '';
    public $errorCssClass = 'state-error';
    public $successCssClass = 'state-success';
    public $fieldClass = 'wma\widgets\ActiveField';
    public $validateOnBlur = false;
    public $validateOnChange = false;

}