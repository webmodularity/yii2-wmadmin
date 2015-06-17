<?php

namespace wma\widgets;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $tooltipIconColorClass = 'txt-color-teal';
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